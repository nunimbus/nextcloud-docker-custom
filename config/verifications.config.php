<?php

$CONFIG = array();

/**
 * Nextcloud Verifications
 *
 * Nextcloud performs several verification checks. There are two options,
 * ``true`` and ``false``.
 */

/**
 * Checks an app before install whether it uses private APIs instead of the
 * proper public APIs. If this is set to true it will only allow to install or
 * enable apps that pass this check.
 *
 * Defaults to ``false``
 */
$appcodechecker = getenv('NEXTCLOUD_APPCODECHECKER');
if ($appcodechecker !== false) {
  $CONFIG['appcodechecker'] = $appcodechecker;
}

/**
 * Check if Nextcloud is up-to-date and shows a notification if a new version is
 * available.
 *
 * Defaults to ``true``
 */
$updatechecker = getenv('NEXTCLOUD_UPDATECHECKER');
if ($updatechecker !== false) {
  $CONFIG['updatechecker'] = $updatechecker;
}

/**
 * URL that Nextcloud should use to look for updates
 *
 * Defaults to ``https://updates.nextcloud.com/updater_server/``
 */
$updater_server_url = getenv('NEXTCLOUD_UPDATER_SERVER_URL');
if ($updater_server_url !== false) {
  $CONFIG['updater.server.url'] = $updater_server_url;
}

/**
 * The channel that Nextcloud should use to look for updates
 *
 * Supported values:
 *   - ``daily``
 *   - ``beta``
 *   - ``stable``
 */
$updater_release_channel = getenv('NEXTCLOUD_UPDATER_RELEASE_CHANNEL');
if ($updater_release_channel !== false) {
  $CONFIG['updater.release.channel'] = $updater_release_channel;
}

/**
 * Is Nextcloud connected to the Internet or running in a closed network?
 *
 * Defaults to ``true``
 */
$has_internet_connection = getenv('NEXTCLOUD_HAS_INTERNET_CONNECTION');
if ($has_internet_connection !== false) {
  $CONFIG['has_internet_connection'] = $has_internet_connection;
}

/**
 * Which domains to request to determine the availability of an Internet
 * connection. If none of these hosts are reachable, the administration panel
 * will show a warning. Set to an empty list to not do any such checks (warning
 * will still be shown).
 *
 * Defaults to the following domains:
 *
 *  - www.nextcloud.com
 *  - www.startpage.com
 *  - www.eff.org
 *  - www.edri.org
 */
$connectivity_check_domains = getenv('NEXTCLOUD_CONNECTIVITY_CHECK_DOMAINS');
if ($connectivity_check_domains !== false) {
  $CONFIG['connectivity_check_domains'] = explode(',', $connectivity_check_domains);
}

/**
 * Allows Nextcloud to verify a working .well-known URL redirects. This is done
 * by attempting to make a request from JS to
 * https://your-domain.com/.well-known/caldav/
 *
 * Defaults to ``true``
 */
$check_for_working_wellknown_setup = getenv('NEXTCLOUD_CHECK_FOR_WORKING_WELLKNOWN_SETUP');
if ($check_for_working_wellknown_setup !== false) {
  $CONFIG['check_for_working_wellknown_setup'] = $check_for_working_wellknown_setup;
}

/**
 * This is a crucial security check on Apache servers that should always be set
 * to ``true``. This verifies that the ``.htaccess`` file is writable and works.
 * If it is not, then any options controlled by ``.htaccess``, such as large
 * file uploads, will not work. It also runs checks on the ``data/`` directory,
 * which verifies that it can't be accessed directly through the Web server.
 *
 * Defaults to ``true``
 */
$check_for_working_htaccess = getenv('NEXTCLOUD_CHECK_FOR_WORKING_HTACCESS');
if ($check_for_working_htaccess !== false) {
  $CONFIG['check_for_working_htaccess'] = $check_for_working_htaccess;
}

/**
 * In rare setups (e.g. on Openshift or docker on windows) the permissions check
 * might block the installation while the underlying system offers no means to
 * "correct" the permissions. In this case, set the value to false.
 *
 * In regular cases, if issues with permissions are encountered they should be
 * adjusted accordingly. Changing the flag is discouraged.
 *
 * Defaults to ``true``
 */
$check_data_directory_permissions = getenv('NEXTCLOUD_CHECK_DATA_DIRECTORY_PERMISSIONS');
if ($check_data_directory_permissions !== false) {
  $CONFIG['check_data_directory_permissions'] = $check_data_directory_permissions;
}

/**
 * In certain environments it is desired to have a read-only configuration file.
 * When this switch is set to ``true`` Nextcloud will not verify whether the
 * configuration is writable. However, it will not be possible to configure
 * all options via the Web interface. Furthermore, when updating Nextcloud
 * it is required to make the configuration file writable again for the update
 * process.
 *
 * Defaults to ``false``
 */
$config_is_read_only = getenv('NEXTCLOUD_CONFIG_IS_READ_ONLY');
if ($config_is_read_only !== false) {
  $CONFIG['config_is_read_only'] = $config_is_read_only;
}
