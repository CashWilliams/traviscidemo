<?php

/**
 * Travis CI Demo site settings
 */

// PHP settings
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 100);
ini_set('session.gc_maxlifetime', 200000);
ini_set('session.cookie_lifetime', 2000000);

// Access control for update.php script.
$update_free_access = FALSE;

// Load require file to ensure environment variables are available immediately.
if (file_exists('/var/www/site-php')) {
  require '/var/www/site-php/traviscidemo/traviscidemo-settings.inc';
}

// Site Info
$conf['site_name'] = 'Travis CI Demo';

/**
 * Acquia environment variables.
 */
if (isset($_ENV['AH_SITE_ENVIRONMENT'])) {
  switch ($_ENV['AH_SITE_ENVIRONMENT']) {
    // PRODUCTION
    case 'prod':
      $conf['site_env'] = 'PRODUCTION';
      break;
    case 'test':
      $conf['site_env'] = 'Stage';
      break;
    case 'dev':
      $conf['site_env'] = 'development';
      break;
  }
}

// Disable automated cron
$conf['cron_safe_threshold'] = 0;

// Include local settings for overrides
if (file_exists(dirname(__FILE__).'/local.settings.php')) {
  require dirname(__FILE__).'/local.settings.php';
}
