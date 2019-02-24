#!/bin/sh
# print the directory and file.
#cd /var/www/html
ignores=( \
  'smart' \
)

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
    echo $(dirname ${file}) -- $(basename $(dirname ${file}));
    $(pwd)/vendor/bin/drush potx single --include=modules/contrib/potx --folder="$(dirname ${file})/" --api=8
  fi
  if [[ ! -d $(dirname ${file})/translations ]]; then
    mkdir $(dirname ${file})/translations;
    echo "mkdir $(dirname ${file})/translations";
  fi
  mv "$(pwd)/general.pot" "$(dirname ${file})/translations/$(basename $(dirname ${file})).pot"
done