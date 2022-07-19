<?php

$CONFIG = array();

/**
 * Proxy Configurations
 */

/**
 * The URL of your proxy server, for example ``proxy.example.com:8081``.
 *
 * Note: Guzzle (the http library used by Nextcloud) is reading the environment
 * variables HTTP_PROXY (only for cli request), HTTPS_PROXY, and NO_PROXY by default.
 *
 * If you configure proxy with Nextcloud any default configuration by Guzzle
 * is overwritten. Make sure to set ``proxyexclude`` accordingly if necessary.
 *
 * Defaults to ``''`` (empty string)
 */
$proxy = getenv('NEXTCLOUD_PROXY');
if ($proxy !== false) {
  $CONFIG['proxy'] = $proxy;
}

/**
 * The optional authentication for the proxy to use to connect to the internet.
 * The format is: ``username:password``.
 *
 * Defaults to ``''`` (empty string)
 */
$proxyuserpwd = getenv('NEXTCLOUD_PROXYUSERPWD');
if ($proxyuserpwd !== false) {
  $CONFIG['proxyuserpwd'] = $proxyuserpwd;
}

/**
 * List of host names that should not be proxied to.
 * For example: ``['.mit.edu', 'foo.com']``.
 *
 * Hint: Use something like ``explode(',', getenv('NO_PROXY'))`` to sync this
 * value with the global NO_PROXY option.
 *
 * Defaults to empty array.
 */
$proxyexclude = getenv('NEXTCLOUD_PROXYEXCLUDE');
if ($proxyexclude !== false) {
  $CONFIG['proxyexclude'] = explode(',', $proxyexclude);
}

/**
 * Allow remote servers with local addresses e.g. in federated shares, webcal services and more
 *
 * Defaults to false
 */
$allow_local_remote_servers = getenv('NEXTCLOUD_ALLOW_LOCAL_REMOTE_SERVERS');
if ($allow_local_remote_servers !== false) {
  $CONFIG['allow_local_remote_servers'] = $allow_local_remote_servers;
}
