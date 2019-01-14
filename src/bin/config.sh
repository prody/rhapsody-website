#!/bin/bash
set -e

# get correct path to website directory
BIN_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" >/dev/null 2>&1 && pwd )"
WWW_DIR="${BIN_DIR%/src/bin}"

# create config.txt file
cd ${WWW_DIR}

if [ -e config.txt ]
then
  cp -f config.txt{,.bak}
  echo "Original file config.txt backed up as config.txt.bak"
fi

cat << EOF > config.txt
#!/bin/bash
set -e

# At least Python 3.7 is required
PYTHON="python"
EOF


# create config.py file
cd ${WWW_DIR}/src/python

if [ -e config.py ] 
then 
  cp -f config.py{,.bak} 
  echo "Original file src/python/config.py backed up as src/python/config.py.bak"
fi
cat << EOF > ${WWW_DIR}/src/python/config.py
PICKLES_DIR  = '${WWW_DIR}/workspace/pickles'
PRODY_DIR    = '???'
RHAPSODY_DIR = '???'
MAIN_CLSF    = '???'
AUX_CLSF     = '???'
EOF

echo
echo "Clean configuration files have been created."
echo "Please set the requested paths in:"
echo ${WWW_DIR}/config.txt 
echo "and:" 
echo ${WWW_DIR}/src/python/config.py
echo
