<?php

$CONFIG = array();

/**
 * Alternate Code Locations
 *
 * Some of the Nextcloud code may be stored in alternate locations.
 */

/**
 * This section is for configuring the download links for Nextcloud clients, as
 * seen in the first-run wizard and on Personal pages.
 *
 * Defaults to:
 *  - Desktop client: ``https://nextcloud.com/install/#install-clients``
 *  - Android client: ``https://play.google.com/store/apps/details?id=com.nextcloud.client``
 *  - iOS client: ``https://itunes.apple.com/us/app/nextcloud/id1125420102?mt=8``
 *  - iOS client app id: ``1125420102``
 */
$customclient_desktop = getenv('NEXTCLOUD_CUSTOMCLIENT_DESKTOP');
if ($customclient_desktop !== false) {
  $CONFIG['customclient_desktop'] = $customclient_desktop;
}

$customclient_android = getenv('NEXTCLOUD_CUSTOMCLIENT_ANDROID');
if ($customclient_android !== false) {
  $CONFIG['customclient_android'] = $customclient_android;
}

$customclient_ios = getenv('NEXTCLOUD_CUSTOMCLIENT_IOS');
if ($customclient_ios !== false) {
  $CONFIG['customclient_ios'] = $customclient_ios;
}

$customclient_ios_appid = getenv('NEXTCLOUD_CUSTOMCLIENT_IOS_APPID');
if ($customclient_ios_appid !== false) {
  $CONFIG['customclient_ios_appid'] = $customclient_ios_appid;
}
