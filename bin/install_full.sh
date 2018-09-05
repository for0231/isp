#!/usr/bin/env bash

#composer require kgaut/potx
#composer require drupal/drush_language
#composer require drupal/migrate_source_csv
#composer require drupal/migrate_tools
vendor/bin/drush si -y --account-pass=admin --db-url=mysql://root:root@localhost/isp
vendor/bin/drush en -y role_menu commerce_cart commerce_checkout commerce_payment_example commerce_recurring drush_language superfish
vendor/bin/drush en -y config_update_ui migrate_source_csv block_class
vendor/bin/drupal thi coloradmin -y
vendor/bin/drupal thi barrio -y
vendor/bin/drush cset -y system.theme default barrio
vendor/bin/drush cset -y system.theme admin coloradmin
vendor/bin/drush language-add zh-hans
vendor/bin/drush pmu -y toolbar

