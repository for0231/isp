#!/bin/bash

ignores=( \
  # cbos
  'account' \
)

sudo rm sites/simpletest/browser_output -rf
OUTPUT="simpletest-`date +%Y%m%d`.txt"
rm ${OUTPUT}

PROJECT="modules/isp"
for file in `find ${PROJECT} -name "*.info.yml"`; do
  module=$(basename $(dirname ${file}))
  FOUND=0
  for ignore in ${ignores[@]}; do
    if [[ ${module} == ${ignore} ]]; then
      FOUND=1
      break;
    fi
  done
  if [[ ${FOUND} == 1 ]]; then
    echo "Ignore $file"
  else
    echo "Testing $file"
    sudo -u $USER php \
      ./core/scripts/run-tests.sh --url http://localhost --verbose \
      $module >> $OUTPUT
  fi
done