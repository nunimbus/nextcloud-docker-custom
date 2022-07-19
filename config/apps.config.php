<?php

$CONFIG = array();

/**
 * Apps
 *
 * Options for the Apps folder, Apps store, and App code checker.
 */

/**
 * When enabled, admins may install apps from the Nextcloud app store.
 *
 * Defaults to ``true``
 */
$appstoreenabled = getenv('NEXTCLOUD_APPSTOREENABLED');
if ($appstoreenabled !== false) {
  $CONFIG['appstoreenabled'] = $appstoreenabled;
}

/**
 * Enables the installation of apps from a self hosted apps store.
 * Requires that at least one of the configured apps directories is writeable.
 *
 * Defaults to ``https://apps.nextcloud.com/api/v1``
 */
$appstoreurl = getenv('NEXTCLOUD_APPSTOREURL');
if ($appstoreurl !== false) {
  $CONFIG['appstoreurl'] = $appstoreurl;
}

/**
 * Use the ``apps_paths`` parameter to set the location of the Apps directory,
 * which should be scanned for available apps, and where user-specific apps
 * should be installed from the Apps store. The ``path`` defines the absolute
 * file system path to the app folder. The key ``url`` defines the HTTP Web path
 * to that folder, starting from the Nextcloud webroot. The key ``writable``
 * indicates if a Web server can write files to that folder.
 */
foreach (getenv() as $key=>$val) {
  if (substr(trim($key), 0, 21) == 'NEXTCLOUD_APPS_PATHS_') {
    if (!(isset($CONFIG['apps_paths']) || array_key_exists('apps_paths', $CONFIG))) {
      $CONFIG['apps_paths'] = array();
    }
    $CONFIG['apps_paths'][strtolower(substr(trim($key), 21))] = $val;
  }
}

/**
 * @see appcodechecker
 */
