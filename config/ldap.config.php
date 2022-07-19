<?php

$CONFIG = array();

/**
 * LDAP
 *
 * Global settings used by LDAP User and Group Backend
 */

/**
 * defines the interval in minutes for the background job that checks user
 * existence and marks them as ready to be cleaned up. The number is always
 * minutes. Setting it to 0 disables the feature.
 * See command line (occ) methods ``ldap:show-remnants`` and ``user:delete``
 *
 * Defaults to ``51`` minutes
 */
$ldapUserCleanupInterval = getenv('NEXTCLOUD_LDAPUSERCLEANUPINTERVAL');
if ($ldapUserCleanupInterval !== false) {
  $CONFIG['ldapUserCleanupInterval'] = $ldapUserCleanupInterval;
}

/**
 * Sort groups in the user settings by name instead of the user count
 *
 * By enabling this the user count beside the group name is disabled as well.
 */
$sort_groups_by_name = getenv('NEXTCLOUD_SORT_GROUPS_BY_NAME');
if ($sort_groups_by_name !== false) {
  $CONFIG['sort_groups_by_name'] = $sort_groups_by_name;
}
