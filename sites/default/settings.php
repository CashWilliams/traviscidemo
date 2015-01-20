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

// jQuery Update
$conf['jquery_update_compression_type'] = 'min';
$conf['jquery_update_jquery_cdn'] = 'none';
$conf['jquery_update_jquery_version'] = '1.9';

// Bootstrap
$conf['theme_bootstrap_settings']['toggle_logo'] = 0;
$conf['theme_bootstrap_settings']['toggle_name'] = 1;
$conf['theme_bootstrap_settings']['toggle_slogan'] = 0;
$conf['theme_bootstrap_settings']['toggle_main_menu'] = 1;
$conf['theme_bootstrap_settings']['toggle_secondary_menu'] = 1;
$conf['theme_bootstrap_settings']['bootstrap_breadcrumb'] = '0';
$conf['theme_bootstrap_settings']['bootstrap_navbar_position'] = 'fixed-top';
$conf['theme_bootstrap_settings']['bootstrap_navbar_inverse'] = 1;
$conf['theme_bootstrap_settings']['bootstrap_anchors_fix'] = 1;
$conf['theme_bootstrap_settings']['bootstrap_anchors_smooth_scrolling'] = 1;
$conf['theme_bootstrap_settings']['bootstrap_popover_enabled'] = 0;
$conf['theme_bootstrap_settings']['bootstrap_popover_animation'] = 1;
$conf['theme_bootstrap_settings']['bootstrap_popover_html'] = 0;
$conf['theme_bootstrap_settings']['bootstrap_cdn'] = '3.0.2';
$conf['theme_bootstrap_settings']['bootstrap_bootswatch'] = 'spacelab';

// Include local settings for overrides
if (file_exists(dirname(__FILE__).'/local.settings.php')) {
  require dirname(__FILE__).'/local.settings.php';
}
