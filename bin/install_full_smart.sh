#!/usr/bin/env bash

vendor/bin/drush si -y --account-pass=admin --db-url=mysql://root:root@mariadb/idcp
vendor/bin/drush en -y config_rewrite ds role_menu role_frontpage commerce_cart commerce_checkout commerce_payment_example commerce_recurring drush_language superfish
vendor/bin/drush en -y libraries commerce_autosku views_slideshow views_slideshow_cycle default_content
# Contribute Modules for Experience
#vendor/bin/drush en -y better_messages
# Install views_slideshow jquery libraries
vendor/bin/drush views:slideshow:lib
vendor/bin/drush en -y config_update_ui migrate_source_csv block_class locale config_translation potx
#vendor/bin/drupal thi smart -y

#vendor/bin/drush cset user.settings user_password_strength 0
#vendor/bin/drush language-add zh-hans
vendor/bin/drush pmu -y toolbar
#Install idcp modules
vendor/bin/drush en -y isp_core commerce_plus isp_server isp_ip isp_room idcp
vendor/bin/drush en -y message_plus
#Install demo data
vendor/bin/drush en -y isp_data
#vendor/bin/drush cset -y system.theme default smart
#vendor/bin/drush cset -y system.theme admin smart
vendor/bin/drush cset system.performance js.preprocess 0 -y
vendor/bin/drush cset system.performance css.preprocess 0 -y
vendor/bin/drush cset user.settings password_strength false -y
vendor/bin/drush cset user.settings register visitors -y
vendor/bin/drush cset user.settings verify_mail false -y
vendor/bin/drush cr
