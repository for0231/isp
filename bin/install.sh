#!/bin/bash
# Install system

#sed -i 's/^include/#include/' sites/default/settings.php

vendor/bin/drush si -y --account-pass=admin --db-url=mysql://root:root@localhost/icp

vendor/bin/drupal moi memcache
#sed -i 's/^#include/include/' sites/default/settings.php

# Fix Plugin (language) instance class "\Drupal\language\DefaultLanguageItem" does not exist.
vendor/bin/drush cr

vendor/bin/drush pmu -y contextual dblog toolbar

vendor/bin/drupal moi block_class role_frontpage role_menu small_title user_plus

# enable it in prod.
#vendor/bin/drupal moi -y memcache memcache_admin
## Install for dev
vendor/bin/drupal moi -y devel kint webprofiler
vendor/bin/drush pmu -y toolbar

#vendor/bin/drush views:slideshow:lib
vendor/bin/drush cset system.performance js.preprocess 0 -y
vendor/bin/drush cset system.performance css.preprocess 0 -y
vendor/bin/drush cset user.settings password_strength false -y
vendor/bin/drush cset user.settings register visitors -y
vendor/bin/drush cset user.settings verify_mail false -y

vendor/bin/drupal thi tark -y
vendor/bin/drush cset -y system.theme default tark
vendor/bin/drush cset -y system.theme admin tark

#vendor/bin/drush language-add zh-hans

# isp modules
vendor/bin/drush en -y comp

