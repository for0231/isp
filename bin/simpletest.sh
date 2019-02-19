#!/bin/bash

ignores=( \
  'eabax_seven' \
)

PROJECTS=(
  "modules/eabax" \
  "modules/isp" \
)
OUTPUT="simpletest-`date +%Y%m%d`.txt"
#NUMS=`find ${PROJECT} -name "*.info.yml" |wc -l`
#echo ${NUMS}
rm -f ${OUTPUT}
for PROJECT in ${PROJECTS[@]}; do
  for file in `find ${PROJECT} -name "*.info.yml"`; do
    FOUND=0
    for module in ${ignores[@]}; do
      if [[ $(basename $(dirname ${file})) == ${module} ]]; then
        FOUND=1
        break;
      fi
    done
    if [[ ${FOUND} == 1 ]]; then
      echo 'ignore' - $(basename $(dirname ${file}))
    else
      sudo -u $USER php \
        ./core/scripts/run-tests.sh --url http://localhost --verbose \
      $(basename $(dirname ${file}))# >> $OUTPUT
    fi
  done
done