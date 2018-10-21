#!/bin/bash

modules=( \
  'isp_room,isp_server' \
  'isp_ip' \
)

#sudo rm sites/simpletest/browser_output -rf
OUTPUT="simpletest-`date +%Y%m%d`.txt"
for module in ${modules[@]}; do
  echo "Testing $module"
  sudo -u $USER php \
    ./core/scripts/run-tests.sh --url http://localhost --verbose \
    $module >> $OUTPUT
done
