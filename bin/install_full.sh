#!/usr/bin/env bash

#composer require kgaut/potx
#composer require drupal/drush_language
#composer require drupal/migrate_source_csv
#composer require drupal/migrate_tools
vendor/bin/drush si -y --account-pass=admin --db-url=mysql://root:root@localhost/isp
vendor/bin/drush en -y ds role_menu commerce_cart commerce_checkout commerce_payment_example commerce_recurring drush_language superfish
vendor/bin/drush en -y libraries commerce_autosku views_slideshow views_slideshow_cycle default_content
# Install views_slideshow jquery libraries
vendor/bin/drush views:slideshow:lib
vendor/bin/drush en -y config_update_ui migrate_source_csv block_class locale config_translation potx
vendor/bin/drupal thi coloradmin -y
#vendor/bin/drupal thi barrio -y
vendor/bin/drupal thi aro -y
vendor/bin/drush cset -y system.theme default aro
vendor/bin/drush cset -y system.theme admin coloradmin
vendor/bin/drush cset system.performance js.preprocess 0 -y
vendor/bin/drush cset system.performance css.preprocess 0 -y
vendor/bin/drush language-add zh-hans
vendor/bin/drush pmu -y toolbar
vendor/bin/drush en -y barrio_block isp_demodata
vendor/bin/drush cr

#Install modules
vendor/bin/drush en -y isp_core isp_server isp_ip isp_room

