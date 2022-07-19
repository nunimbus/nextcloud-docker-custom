<?php

$CONFIG = array();

/**
 * Comments
 *
 * Global settings for the Comments infrastructure
 */

/**
 * Replaces the default Comments Manager Factory. This can be utilized if an
 * own or 3rdParty CommentsManager should be used that – for instance – uses the
 * filesystem instead of the database to keep the comments.
 *
 * Defaults to ``\OC\Comments\ManagerFactory``
 */
$comments_managerFactory = getenv('NEXTCLOUD_COMMENTS_MANAGERFACTORY');
if ($comments_managerFactory !== false) {
  $CONFIG['comments.managerFactory'] = $comments_managerFactory;
}

/**
 * Replaces the default System Tags Manager Factory. This can be utilized if an
 * own or 3rdParty SystemTagsManager should be used that – for instance – uses the
 * filesystem instead of the database to keep the tags.
 *
 * Defaults to ``\OC\SystemTag\ManagerFactory``
 */
$systemtags_managerFactory = getenv('NEXTCLOUD_SYSTEMTAGS_MANAGERFACTORY');
if ($systemtags_managerFactory !== false) {
  $CONFIG['systemtags.managerFactory'] = $systemtags_managerFactory;
}
