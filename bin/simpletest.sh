#!/bin/sh

echo $(pwd)

PROJECT="modules/isp"
OUTPUT="simpletest-`date +%Y%m%d`.txt"
NUMS=`find ${PROJECT} -name "*.info.yml" |wc -l`
echo ${NUMS}
rm $OUTPUT
for file in `find ${PROJECT} -name "*.info.yml"`; do
  echo $(dirname ${file}) -- $(basename $(dirname ${file}));
  sudo -u $USER php \
    ./core/scripts/run-tests.sh --url http://drupal.server.host --verbose \
    $(basename $(dirname ${file})) >> $OUTPUT
done

