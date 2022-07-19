<?php

$CONFIG = array();

/**
 * Maintenance
 *
 * These options are for halting user activity when you are performing server
 * maintenance.
 */

/**
 * Enable maintenance mode to disable Nextcloud
 *
 * If you want to prevent users from logging in to Nextcloud before you start
 * doing some maintenance work, you need to set the value of the maintenance
 * parameter to true. Please keep in mind that users who are already logged-in
 * are kicked out of Nextcloud instantly.
 *
 * Defaults to ``false``
 */
$maintenance = getenv('NEXTCLOUD_MAINTENANCE');
if ($maintenance !== false) {
  $CONFIG['maintenance'] = $maintenance;
}
