<?php

$CONFIG = array();

/**
 * File versions
 *
 * These parameters control the Versions app.
 */

/**
 * If the versions app is enabled (default), this setting defines the policy
 * for when versions will be permanently deleted.
 * The app allows for two settings, a minimum time for version retention,
 * and a maximum time for version retention.
 * Minimum time is the number of days a version will be kept, after which it
 * may be deleted. Maximum time is the number of days at which it is guaranteed
 * to be deleted.
 * Both minimum and maximum times can be set together to explicitly define
 * version deletion. For migration purposes, this setting is installed
 * initially set to "auto", which is equivalent to the default setting in
 * Nextcloud.
 *
 * Available values:
 *
 * * ``auto``
 *     default setting. Automatically expire versions according to expire
 *     rules. Please refer to :doc:`../configuration_files/file_versioning` for
 *     more information.
 * * ``D, auto``
 *     keep versions at least for D days, apply expire rules to all versions
 *     that are older than D days
 * * ``auto, D``
 *     delete all versions that are older than D days automatically, delete
 *     other versions according to expire rules
 * * ``D1, D2``
 *     keep versions for at least D1 days and delete when exceeds D2 days
 * * ``disabled``
 *     versions auto clean disabled, versions will be kept forever
 *
 * Defaults to ``auto``
 */
$versions_retention_obligation = getenv('NEXTCLOUD_VERSIONS_RETENTION_OBLIGATION');
if ($versions_retention_obligation !== false) {
  $CONFIG['versions_retention_obligation'] = $versions_retention_obligation;
}
