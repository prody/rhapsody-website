#!/bin/bash

# path to source files 
src_dir="../../../src"
# path to trained classifiers 
cls_dir="../../trained_classifiers-????-*-*-*"

jobdir=$(pwd)
jobdir=$(basename $jobdir)
jobid=${jobdir#job_}
if [ ${jobdir:0:4} != "job_" ]; then
  echo 'Fatal error. Wrong working directory.' > SNPs_webserver_error.tmp 
  exit 1
fi

uploaded_file=$1

if [ "$uploaded_file" == "pph2-full.txt" ]; then
  option="-pp2"
else
  option=""
fi

echo "running" > status.tmp

# map SNPs to PDBs
python -u ${src_dir}/main.py $option $uploaded_file &> main.log
# handle error
if [ "$?" -ne 0 ]; then
  echo 'aborted' > status.tmp 
  echo 'Error while processing input file.' > main.err
  exit 1
fi

# compute structural and dynamical features
python -u ${src_dir}/main-dssp.py     mapped_SNPs.out > dssp.out 2> main-dssp.log
python -u ${src_dir}/main-dynamics.py mapped_SNPs.out &> main-dynamics.log

# retrieve STR/DYN features used by classifier
cat dssp.out | \
  awk '{if(substr($0,0,1)=="#") print "?"; else print $5}' \
  > STR_features.tmp
cat GNM-sq_fluctuations.out | \
  awk '{if(substr($0,0,1)=="#") print "?"; else print $7}' \
  > sqf_features.tmp
cat ANM-effectors_sensors.out | \
  awk '{if(substr($0,0,1)=="#") print "?"; else print $7, $9}' \
  > prs_features.tmp
cat ANM-mech_bridging_score.out | \
  awk '{if(substr($0,0,1)=="#") print "?"; else print $7}' \
  > mbs_features.tmp
cat ANM-MechStiff.out | awk '{if(substr($0,0,1)=="#") print "?"; else print $7}' \
  > stf_features.tmp

if [ "$uploaded_file" == "pph2-full.txt" ]; then

  # retrieve SEQ features
  cat pp2_comparison_and_features.out | \
    awk '(substr($0,0,3)!="no/"){print $5, $6}' \
    > SEQ_features.tmp

  # compute predictions from SEQ-classifier
  python -u ${src_dir}/predict.py ${cls_dir}/trained_classifier-SEQ.pkl \
    SEQ_features.tmp ${cls_dir}/training_SNPs.dat mapped_SNPs.out \
    &> predict-SEQ.log
  mv predictions.out predictions-SEQ.out

  # prepare input file for SEQ-DYN classifier (8 features)
  paste SEQ_features.tmp STR_features.tmp sqf_features.tmp \
    prs_features.tmp mbs_features.tmp stf_features.tmp \
    > SEQ_DYN-features.out

  # compute predictions from SEQ_DYN-classifier
  python -u ${src_dir}/predict.py ${cls_dir}/trained_classifier-ALL.pkl \
    SEQ_DYN-features.out ${cls_dir}/training_SNPs.dat mapped_SNPs.out \
    &> predict.log

  cp SEQ_DYN-features.out features.txt
else

  # prepare input file for DYN classifier (6 features)
  paste STR_features.tmp sqf_features.tmp \
    prs_features.tmp mbs_features.tmp stf_features.tmp \
    > DYN-features.out

  python -u ${src_dir}/predict.py ${cls_dir}/trained_classifier-DYN.pkl \
    DYN-features.out ${cls_dir}/training_SNPs.dat mapped_SNPs.out \
    &> predict.log

  cp DYN-features.out features.txt
fi

rm *_features.tmp


# prepare zip file for download 
mkdir Unix
cd Unix
cp ../mapped_SNPs.out mapped_SNPs.txt
grep -v "#" mapped_SNPs.txt | \
  awk 'BEGIN{print "\t\t"}{print $1,$2,$3,$4,"\t"}' > SNP_list.tmp
paste SNP_list.tmp ../predictions.out > predictions.txt
mv ../features.txt .
cp ../../../objects/README.txt .
if [ "$uploaded_file" == "pph2-full.txt" ]; then
  cp ../pp2_comparison_and_features.out pp2_comparison_and_features.txt
  paste SNP_list.tmp ../predictions-SEQ.out > predictions-SEQ.txt
fi
rm -f SNP_list.tmp
cd ..

mkdir Windows
for f in $(ls Unix/*); do
  file=$(basename $f)
  sed $'s/$/\r/' Unix/$file > Windows/$file
done

mkdir predictions 
mv Unix Windows -t predictions
zip -r ${jobdir}.zip predictions/ &> /dev/null
# tar -zcvf ${jobdir}.tar.gz predictions/ &> /dev/null


# email user
read -r email < email.txt
if [ -n "$email" ]
then
  sendmail "$email" <<EOF
subject:RAPSODY: your list of variants has been successfully processed!
from:RAPSODY
Dear user, 

the job $jobid you submitted is now completed.
You can download the results at the following page:
http://rapsody.csb.pitt.edu/results_page.php?id=$jobid

Best regards.
EOF
fi

echo "completed" > status.tmp

# remove old jobs directories (older than 48 hours)
cd ../..
./remove_old_dirs.sh 2>&1 >> jobs_directory/remove_old_dirs.out

exit 0
