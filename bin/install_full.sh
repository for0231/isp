#!/usr/bin/env bash

#composer require kgaut/potx
#composer require drupal/drush_language
vendor/bin/drush si -y --account-pass=admin --db-url=mysql://root:root@localhost/isp
vendor/bin/drush en -y role_menu commerce_cart commerce_checkout commerce_payment_example commerce_recurring drush_language superfish
vendor/bin/drush en -y config_update_ui
vendor/bin/drupal thi coloradmin -y
vendor/bin/drupal thi tplus -y
vendor/bin/drush cset -y system.theme default tplus
vendor/bin/drush cset -y system.theme admin coloradmin
vendor/bin/drush language-add zh-hans
vendor/bin/drush pmu -y toolbar

