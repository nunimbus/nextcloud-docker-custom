<?php

$CONFIG = array();

/**
 * Reverse Proxy Configurations
 */

/**
 * The automatic hostname detection of Nextcloud can fail in certain reverse
 * proxy and CLI/cron situations. This option allows you to manually override
 * the automatic detection; for example ``www.example.com``, or specify the port
 * ``www.example.com:8080``.
 */
$overwritehost = getenv('OVERWRITEHOST');
if ($overwritehost !== false) {
  $CONFIG['overwritehost'] = $overwritehost;
}

/**
 * When generating URLs, Nextcloud attempts to detect whether the server is
 * accessed via ``https`` or ``http``. However, if Nextcloud is behind a proxy
 * and the proxy handles the ``https`` calls, Nextcloud would not know that
 * ``ssl`` is in use, which would result in incorrect URLs being generated.
 * Valid values are ``http`` and ``https``.
 */
$overwriteprotocol = getenv('OVERWRITEPROTOCOL');
if ($overwriteprotocol !== false) {
  $CONFIG['overwriteprotocol'] = $overwriteprotocol;
}

/**
 * Nextcloud attempts to detect the webroot for generating URLs automatically.
 * For example, if ``www.example.com/nextcloud`` is the URL pointing to the
 * Nextcloud instance, the webroot is ``/nextcloud``. When proxies are in use,
 * it may be difficult for Nextcloud to detect this parameter, resulting in
 * invalid URLs.
 */
$overwritewebroot = getenv('OVERWRITEWEBROOT');
if ($overwritewebroot !== false) {
  $CONFIG['overwritewebroot'] = $overwritewebroot;
}

/**
 * This option allows you to define a manual override condition as a regular
 * expression for the remote IP address. For example, defining a range of IP
 * addresses starting with ``10.0.0.`` and ending with 1 to 3:
 * ``^10\.0\.0\.[1-3]$``
 *
 * Defaults to ``''`` (empty string)
 */
$overwritecondaddr = getenv('OVERWRITECONDADDR');
if ($overwritecondaddr !== false) {
  $CONFIG['overwritecondaddr'] = $overwritecondaddr;
}

/**
 * Use this configuration parameter to specify the base URL for any URLs which
 * are generated within Nextcloud using any kind of command line tools (cron or
 * occ). The value should contain the full base URL:
 * ``https://www.example.com/nextcloud``
 *
 * Defaults to ``''`` (empty string)
 */
$overwrite_cli_url = getenv('OVERWRITE_CLI_URL');
if ($overwrite_cli_url !== false) {
  $CONFIG['overwrite.cli.url'] = $overwrite_cli_url;
}

/**
 * List of trusted proxy servers
 *
 * You may set this to an array containing a combination of
 * - IPv4 addresses, e.g. `192.168.2.123`
 * - IPv4 ranges in CIDR notation, e.g. `192.168.2.0/24`
 * - IPv6 addresses, e.g. `fd9e:21a7:a92c:2323::1`
 *
 * _(CIDR notation for IPv6 is currently work in progress and thus not
 * available as of yet)_
 *
 * When an incoming request's `REMOTE_ADDR` matches any of the IP addresses
 * specified here, it is assumed to be a proxy instead of a client. Thus, the
 * client IP will be read from the HTTP header specified in
 * `forwarded_for_headers` instead of from `REMOTE_ADDR`.
 *
 * So if you configure `trusted_proxies`, also consider setting
 * `forwarded_for_headers` which otherwise defaults to `HTTP_X_FORWARDED_FOR`
 * (the `X-Forwarded-For` header).
 *
 * Defaults to an empty array.
 */
$trusted_proxies = getenv('NEXTCLOUD_TRUSTED_PROXIES');
if ($trusted_proxies !== false) {
  $CONFIG['trusted_proxies'] = explode(',', $trusted_proxies);
}

/**
 * Headers that should be trusted as client IP address in combination with
 * `trusted_proxies`. If the HTTP header looks like 'X-Forwarded-For', then use
 * 'HTTP_X_FORWARDED_FOR' here.
 *
 * If set incorrectly, a client can spoof their IP address as visible to
 * Nextcloud, bypassing access controls and making logs useless!
 *
 * Defaults to ``'HTTP_X_FORWARDED_FOR'``
 */
$forwarded_for_headers = getenv('NEXTCLOUD_FORWARDED_FOR_HEADERS');
if ($forwarded_for_headers !== false) {
  $CONFIG['forwarded_for_headers'] = explode(',', $forwarded_for_headers);
}
