#!/bin/bash
set -e

# get correct path to website directory
BIN_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" >/dev/null 2>&1 && pwd )"
WWW_DIR="${BIN_DIR%/src/bin}"

# create config.py file
cat << EOF > ${WWW_DIR}/src/python/config.py
PICKLES_DIR  = '${WWW_DIR}/workspace/pickles'
PRODY_DIR    = '???'
RHAPSODY_DIR = '???'
MAIN_CLSF    = '???'
AUX_CLSF     = '???'
EOF

echo "An empty configuration file has been created."
echo "Please set the requested paths in ${WWW_DIR}/script/python/config.py"
