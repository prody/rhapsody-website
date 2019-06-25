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

if $(python -c 'import prody, rhapsody'); then
  PYTHON=$(which python)
  echo 'Done.'
else
  PYTHON=''
  echo "Seems like the current Python version doesn't have" \
       "Prody/Rhapsody packages installed."
  echo "Please set up an appropriate path to another Python version" \
       "in your local .profile file"
fi

cat << EOF > .profile
# At least Python 3.6 is required
export PYTHON='$PYTHON'
EOF
