api = 2
core = 7.x
projects[drupal][type] = core
projects[drupal][version] = 7.34


; Router rebuild lock_wait() condition can result in rebuild later in the request (race condition)
project[drupal][patch] = https://www.drupal.org/files/issues/356399_menu_rebuild-44.patch
