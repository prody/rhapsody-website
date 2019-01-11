#!/bin/bash
set -e

# find stuff older than 2 days
OLD_DIRS=$(find ./jobs_directory -maxdepth 1 -type d -name "job_*" -mtime +2)
for d in $OLD_DIRS
do
  dd=$(basename $d)
  if [ "${dd:0:4}" == "job_" ]; then
    if [ -e ${d}/date.txt ]; then
      # number of submitted SNPs
      n=$(cat ${d}/mapped_SNPs.out | wc -l)
      # status
      s=$(cat ${d}/status.tmp)
      # date
      date=$(cat ${d}/date.txt)
      echo $date $dd $s "- SNPs:" $n 
      rm -rf $d
    elif [ -z "$(ls -A ${d})" ]; then
      # date
      date=$(date -r $d "+%d %b %Y %R")
      # remove empty dirs
      echo $date $dd "not started" 
      rm -rf $d
    fi
  fi
done
