<?php

$CONFIG = array();

/**
 * Memory caching backend configuration
 *
 * Available cache backends:
 *
 * * ``\OC\Memcache\APCu``       APC user backend
 * * ``\OC\Memcache\ArrayCache`` In-memory array-based backend (not recommended)
 * * ``\OC\Memcache\Memcached``  Memcached backend
 * * ``\OC\Memcache\Redis``      Redis backend
 *
 * Advice on choosing between the various backends:
 *
 * * APCu should be easiest to install. Almost all distributions have packages.
 *   Use this for single user environment for all caches.
 * * Use Redis or Memcached for distributed environments.
 *   For the local cache (you can configure two) take APCu.
 */

/**
 * Memory caching backend for locally stored data
 *
 * * Used for host-specific data, e.g. file paths
 *
 * Defaults to ``none``
 */
$memcache_local = getenv('NEXTCLOUD_MEMCACHE_LOCAL');
if ($memcache_local !== false) {
  $CONFIG['memcache.local'] = $memcache_local;
}

/**
 * Memory caching backend for distributed data
 *
 * * Used for installation-specific data, e.g. database caching
 * * If unset, defaults to the value of memcache.local
 *
 * Defaults to ``none``
 */
$memcache_distributed = getenv('NEXTCLOUD_MEMCACHE_DISTRIBUTED');
if ($memcache_distributed !== false) {
  $CONFIG['memcache.distributed'] = $memcache_distributed;
}

/**
 * Server details for one or more memcached servers to use for memory caching.
 */
foreach (getenv() as $key=>$val) {
  if (substr(trim($key), 0, 28) == 'NEXTCLOUD_MEMCACHED_SERVERS_') {
    if (!(isset($CONFIG['memcached_servers']) || array_key_exists('memcached_servers', $CONFIG))) {
      $CONFIG['memcached_servers'] = array();
    }
    $CONFIG['memcached_servers'][strtolower(substr(trim($key), 28))] = $val;
  }
}

/**
 * Connection options for memcached
 */
foreach (getenv() as $key=>$val) {
  if (substr(trim($key), 0, 28) == 'NEXTCLOUD_MEMCACHED_OPTIONS_') {
    if (!(isset($CONFIG['memcached_options']) || array_key_exists('memcached_options', $CONFIG))) {
      $CONFIG['memcached_options'] = array();
    }
    $CONFIG['memcached_options'][strtolower(substr(trim($key), 28))] = $val;
  }
}

/**
 * Memory caching backend for file locking
 *
 * Because most memcache backends can clean values without warning using redis
 * is highly recommended to *avoid data loss*.
 *
 * Defaults to ``none``
 */
$memcache_locking = getenv('NEXTCLOUD_MEMCACHE_LOCKING');
if ($memcache_locking !== false) {
  $CONFIG['memcache.locking'] = $memcache_locking;
}

/**
 * Location of the cache folder, defaults to ``data/$user/cache`` where
 * ``$user`` is the current user. When specified, the format will change to
 * ``$cache_path/$user`` where ``$cache_path`` is the configured cache directory
 * and ``$user`` is the user.
 *
 * Defaults to ``''`` (empty string)
 */
$cache_path = getenv('NEXTCLOUD_CACHE_PATH');
if ($cache_path !== false) {
  $CONFIG['cache_path'] = $cache_path;
}

/**
 * TTL of chunks located in the cache folder before they're removed by
 * garbage collection (in seconds). Increase this value if users have
 * issues uploading very large files via the Nextcloud Client as upload isn't
 * completed within one day.
 *
 * Defaults to ``60*60*24`` (1 day)
 */
$cache_chunk_gc_ttl = getenv('NEXTCLOUD_CACHE_CHUNK_GC_TTL');
if ($cache_chunk_gc_ttl !== false) {
  $CONFIG['cache_chunk_gc_ttl'] = $cache_chunk_gc_ttl;
}

/**
 * Connection details for redis to use for memory caching in a single server configuration.
 *
 * For enhanced security it is recommended to configure Redis
 * to require a password. See http://redis.io/topics/security
 * for more information.
 */
if (getenv('REDIS_HOST')) {
  $CONFIG['memcache.distributed'] = '\OC\Memcache\Redis';
  $CONFIG['memcache.locking'] = '\OC\Memcache\Redis';
  $CONFIG['redis'] = array(
    'host' => getenv('REDIS_HOST'),
  );

  if (getenv('REDIS_PASSWORD') !== false) {
    $CONFIG['redis']['password'] = (string) getenv('REDIS_PASSWORD');
  }
  if (getenv('REDIS_DBINDEX') !== false) {
    $CONFIG['redis']['dbindex'] = (string) getenv('REDIS_DBINDEX');
  }
  if (getenv('REDIS_TIMEOUT') !== false) {
    $CONFIG['redis']['timeout'] = (string) getenv('REDIS_TIMEOUT');
  }

  if (getenv('REDIS_HOST_PORT') !== false) {
    $CONFIG['redis']['port'] = (int) getenv('REDIS_HOST_PORT');
  } elseif (getenv('REDIS_HOST')[0] != '/') {
    $CONFIG['redis']['port'] = 6379;
  }
}

/**
 * Connection details for a Redis Cluster
 *
 * Only for use with Redis Clustering, for Sentinel-based setups use the single
 * server configuration above, and perform HA on the hostname.
 *
 * Redis Cluster support requires the php module phpredis in version 3.0.0 or
 * higher.
 *
 * Available failover modes:
 *  - \RedisCluster::FAILOVER_NONE - only send commands to master nodes (default)
 *  - \RedisCluster::FAILOVER_ERROR - failover to slaves for read commands if master is unavailable (recommended)
 *  - \RedisCluster::FAILOVER_DISTRIBUTE - randomly distribute read commands across master and slaves
 *
 * WARNING: FAILOVER_DISTRIBUTE is a not recommended setting and we strongly
 * suggest to not use it if you use Redis for file locking. Due to the way Redis
 * is synchronized it could happen, that the read for an existing lock is
 * scheduled to a slave that is not fully synchronized with the connected master
 * which then causes a FileLocked exception.
 *
 * See https://redis.io/topics/cluster-spec for details about the Redis cluster
 *
 * Authentication works with phpredis version 4.2.1+. See
 * https://github.com/phpredis/phpredis/commit/c5994f2a42b8a348af92d3acb4edff1328ad8ce1
 */
 /*
'redis.cluster' => [
	'seeds' => [ // provide some/all of the cluster servers to bootstrap discovery, port required
		'localhost:7000',
		'localhost:7001',
	],
	'timeout' => 0.0,
	'read_timeout' => 0.0,
	'failover_mode' => \RedisCluster::FAILOVER_ERROR,
	'password' => '', // Optional, if not defined no password will be used.
],
*/
foreach (getenv() as $key=>$val) {
  if (substr(trim($key), 0, 24) == 'NEXTCLOUD_REDIS_CLUSTER_') {
    if (!(isset($CONFIG['redis.cluster']) || array_key_exists('redis.cluster', $CONFIG))) {
      $CONFIG['redis.cluster'] = array();
    }
    $CONFIG['redis.cluster'][strtolower(substr(trim($key), 24))] = $val;
  }
}
