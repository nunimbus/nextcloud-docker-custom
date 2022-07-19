<?php

$CONFIG = array();

/**
 * Sharing
 *
 * Global settings for Sharing
 */

/**
 * Replaces the default Share Provider Factory. This can be utilized if
 * own or 3rdParty Share Providers are used that – for instance – use the
 * filesystem instead of the database to keep the share information.
 *
 * Defaults to ``\OC\Share20\ProviderFactory``
 */
$sharing_managerFactory = getenv('NEXTCLOUD_SHARING_MANAGERFACTORY');
if ($sharing_managerFactory !== false) {
  $CONFIG['sharing.managerFactory'] = $sharing_managerFactory;
}

/**
 * Define max number of results returned by the search for auto-completion of
 * users, groups, etc. The value must not be lower than 0 (for unlimited).
 *
 * If more, different sources are requested (e.g. different user backends; or
 * both users and groups), the value is applied per source and might not be
 * truncated after collecting the results. I.e. more results can appear than
 * configured here.
 *
 * Default is 25.
 */
$sharing_maxAutocompleteResults = getenv('NEXTCLOUD_SHARING_MAXAUTOCOMPLETERESULTS');
if ($sharing_maxAutocompleteResults !== false) {
  $CONFIG['sharing.maxAutocompleteResults'] = $sharing_maxAutocompleteResults;
}

/**
 * Define the minimum length of the search string before we start auto-completion
 * Default is no limit (value set to 0)
 */
$sharing_minSearchStringLength = getenv('NEXTCLOUD_SHARING_MINSEARCHSTRINGLENGTH');
if ($sharing_minSearchStringLength !== false) {
  $CONFIG['sharing.minSearchStringLength'] = $sharing_minSearchStringLength;
}

/**
 * Set to true to enable that internal shares need to be accepted by the users by default.
 * Users can change this for their account in their personal sharing settings
 */
$sharing_enable_share_accept = getenv('NEXTCLOUD_SHARING_ENABLE_SHARE_ACCEPT');
if ($sharing_enable_share_accept !== false) {
  $CONFIG['sharing.enable_share_accept'] = $sharing_enable_share_accept;
}

/**
 * Set to true to enforce that internal shares need to be accepted
 */
$sharing_force_share_accept = getenv('NEXTCLOUD_SHARING_FORCE_SHARE_ACCEPT');
if ($sharing_force_share_accept !== false) {
  $CONFIG['sharing.force_share_accept'] = $sharing_force_share_accept;
}

/**
 * Set to false to stop sending a mail when users receive a share
 */
$sharing_enable_share_mail = getenv('NEXTCLOUD_SHARING_ENABLE_SHARE_MAIL');
if ($sharing_enable_share_mail !== false) {
  $CONFIG['sharing.enable_share_mail'] = $sharing_enable_share_mail;
}
