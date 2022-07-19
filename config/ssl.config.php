<?php

$CONFIG = array();

/**
 * SSL
 */

/**
 * Extra SSL options to be used for configuration.
  *
 * Defaults to an empty array.
 */
foreach (getenv() as $key=>$val) {
  if (substr(trim($key), 0, 18) == 'NEXTCLOUD_OPENSSL_') {
    if (!(isset($CONFIG['openssl']) || array_key_exists('openssl', $CONFIG))) {
      $CONFIG['openssl'] = array();
    }
    $CONFIG['openssl'][strtolower(substr(trim($key), 18))] = $val;
  }
}
