#!/bin/bash
set -e

# get correct path to website directory
BIN_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" >/dev/null 2>&1 && pwd )"
WWW_DIR="${BIN_DIR%/src/bin}"

# create config.txt file
cd ${WWW_DIR}

if [ -e .profile ]
then
  cp -f .profile{,.bak}
  echo "Original configuration file backed up as .profile.bak"
fi

cat << EOF > .profile
# At least Python 3.6 is required
export PYTHON="python"

# path to ProDy package folder
# (leave blank to use version installed by pip)
export PRODY_DIR=""

# path to Rhapsody package folder
export RHAPSODY_DIR="???"

# path to folders where precomputed pickles and downloaded PDBs will be stored
export PICKLES_DIR="${WWW_DIR}/workspace/pickles"
export PDB_DIR="${WWW_DIR}/workspace/pickles"

# path to classifiers used by Rhapsody for predictions
export MAIN_CLSF="???.pkl"
export AUX_CLSF="???.pkl"

# path to EVmutation folder
export EVMUT_DIR="???/mutation_effects"

# EVmutation optimal cutoff computed on training dataset
export EVMUT_CUTOFF="-4.551"

EOF


echo "Please set the requested paths in " ${WWW_DIR}/.profile
