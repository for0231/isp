#!/usr/bin/env bash

vendor/bin/drush si -y --account-pass=admin --db-url=mysql://root:root@localhost/icp
## Install for prod
vendor/bin/drupal moi -y config_rewrite \
 block_class \
 coffee \
 config_translation \
 config_update_ui \
 commerce_autosku \
 commerce_cart \
 commerce_checkout \
 commerce_payment_example \
 commerce_recurring \
 default_content \
 drush_language \
 field_group \
 layout_builder \
 libraries \
 locale \
 migrate_source_csv \
 migrate_source_xls \
 potx \
 pinyin \
 role_menu \
 role_frontpage \
 superfish \
 translation \
 views_slideshow \
 views_slideshow_cycle

# enable it in prod.
#vendor/bin/drupal moi -y memcache memcache_admin
## Install for dev
vendor/bin/drupal moi -y devel kint webprofiler
vendor/bin/drush pmu -y toolbar

vendor/bin/drush views:slideshow:lib
vendor/bin/drush cset system.performance js.preprocess 0 -y
vendor/bin/drush cset system.performance css.preprocess 0 -y
vendor/bin/drush cset user.settings password_strength false -y
vendor/bin/drush cset user.settings register visitors -y
vendor/bin/drush cset user.settings verify_mail false -y


vendor/bin/drupal thi colors -y
vendor/bin/drush cset -y system.theme default colors
vendor/bin/drush cset -y system.theme admin colors

# core modules
vendor/bin/drush en -y \
  eabax_core \
  eabax_workflow \
  import \
  role_frontpage \
  role_menu \
  small_title \
  translation \
  user_plus

#vendor/bin/drush language-add zh-hans

# isp modules
#vendor/bin/drush en -y isp_core commerce_plus isp_server isp_ip isp_room \
#                       message_plus

