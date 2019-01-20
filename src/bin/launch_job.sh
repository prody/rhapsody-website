#!/bin/bash
set -e

# import variables
jobdir=$(realpath $1)
pyscript=$(realpath $2)

# set environmental variables
source .profile

cd $jobdir

# run rhapsody
$PYTHON $pyscript > rhapsody-log.txt 2>&1 & echo -n $! > PID.tmp

exit 0