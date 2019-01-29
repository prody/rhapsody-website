#!/bin/bash
set -e

scratch_dir=$(realpath $1)

# find stuff older than 2 days
OLD_DIRS=$(find $scratch_dir -maxdepth 1 -type d -name "job_*" -mtime +2)

# sort by date
OLD_DIRS=$(ls -dtr $OLD_DIRS)

for d in $OLD_DIRS
do
  jobdir=$(basename $d)
  date=$(date -r $d "+%d %b %Y %R")
  status="?"
  numSAVs="?"
  if [ "${jobdir:0:4}" == "job_" -a  "${jobdir:4:8}" != "example-" ]; then
    if [ -e ${d}/rhapsody-results.zip ]; then
      status="completed  "
      # number of submitted SAVs
      if [ -e ${d}/rhapsody-Uniprot2PDB.txt ]; then
        numSAVs=$(cat ${d}/rhapsody-Uniprot2PDB.txt | wc -l)
      fi
    elif [ -z "$(ls -A ${d})" ]; then
      # empty dir
      status="not started"
    else
      # something went wrong
      status="aborted    "
    fi
    # store info
    echo "$date  $jobdir  $status  -  num.SAVs: $numSAVs"
    # remove dir
    rm -rf $d
  fi
done
