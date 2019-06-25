#!/bin/bash
set -e

# get correct path to website directory
BIN_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" >/dev/null 2>&1 && pwd )"
WWW_DIR="${BIN_DIR%/src/bin}"

cd $WWW_DIR

php -S localhost:8999 &
firefox --new-window http://localhost:8999/ &
