<?php

$CONFIG = array();

/**
 * Using Object Store with Nextcloud
 */
if (getenv('OBJECTSTORE_S3_BUCKET')) {
  $use_ssl = getenv('OBJECTSTORE_S3_SSL');
  $use_path = getenv('OBJECTSTORE_S3_USEPATH_STYLE');
  $use_legacyauth = getenv('OBJECTSTORE_S3_LEGACYAUTH');
  $autocreate = getenv('OBJECTSTORE_S3_AUTOCREATE');
  $CONFIG = array(
    'objectstore' => array(
      'class' => '\OC\Files\ObjectStore\S3',
      'arguments' => array(
        'bucket' => getenv('OBJECTSTORE_S3_BUCKET'),
        'key' => getenv('OBJECTSTORE_S3_KEY') ?: '',
        'secret' => getenv('OBJECTSTORE_S3_SECRET') ?: '',
        'region' => getenv('OBJECTSTORE_S3_REGION') ?: '',
        'hostname' => getenv('OBJECTSTORE_S3_HOST') ?: '',
        'port' => getenv('OBJECTSTORE_S3_PORT') ?: '',
        'objectPrefix' => getenv("OBJECTSTORE_S3_OBJECT_PREFIX") ? getenv("OBJECTSTORE_S3_OBJECT_PREFIX") : "urn:oid:",
        'autocreate' => (strtolower($autocreate) === 'false' || $autocreate == false) ? false : true,
        'use_ssl' => (strtolower($use_ssl) === 'false' || $use_ssl == false) ? false : true,
        // required for some non Amazon S3 implementations
        'use_path_style' => $use_path == true && strtolower($use_path) !== 'false',
        // required for older protocol versions
        'legacy_auth' => $use_legacyauth == true && strtolower($use_legacyauth) !== 'false'
      )
    )
  );
} 

/**
 * This example shows how to configure Nextcloud to store all files in a
 * swift object storage.
 *
 * It is important to note that Nextcloud in object store mode will expect
 * exclusive access to the object store container because it only stores the
 * binary data for each file. The metadata is currently kept in the local
 * database for performance reasons.
 *
 * WARNING: The current implementation is incompatible with any app that uses
 * direct file IO and circumvents our virtual filesystem. That includes
 * Encryption and Gallery. Gallery will store thumbnails directly in the
 * filesystem and encryption will cause severe overhead because key files need
 * to be fetched in addition to any requested file.
 *
 * One way to test is applying for a trystack account at http://trystack.org/
 */
 /*
'objectstore' => [
	'class' => 'OC\\Files\\ObjectStore\\Swift',
	'arguments' => [
		// trystack will use your facebook id as the user name
		'username' => 'facebook100000123456789',
		// in the trystack dashboard go to user -> settings -> API Password to
		// generate a password
		'password' => 'Secr3tPaSSWoRdt7',
		// must already exist in the objectstore, name can be different
		'container' => 'nextcloud',
		// prefix to prepend to the fileid, default is 'oid:urn:'
		'objectPrefix' => 'oid:urn:',
		// create the container if it does not exist. default is false
		'autocreate' => true,
		// required, dev-/trystack defaults to 'RegionOne'
		'region' => 'RegionOne',
		// The Identity / Keystone endpoint
		'url' => 'http://8.21.28.222:5000/v2.0',
		// required on dev-/trystack
		'tenantName' => 'facebook100000123456789',
		// dev-/trystack uses swift by default, the lib defaults to 'cloudFiles'
		// if omitted
		'serviceName' => 'swift',
		// The Interface / url Type, optional
		'urlType' => 'internal'
	],
],
*/

/**
 * To use swift V3
 */
if (getenv('OBJECTSTORE_SWIFT_URL')) {
    $autocreate = getenv('OBJECTSTORE_SWIFT_AUTOCREATE');
  $CONFIG = array(
    'objectstore' => [
      'class' => 'OC\\Files\\ObjectStore\\Swift',
      'arguments' => [
        'autocreate' => $autocreate == true && strtolower($autocreate) !== 'false',
        'user' => [
          'name' => getenv('OBJECTSTORE_SWIFT_USER_NAME'),
          'password' => getenv('OBJECTSTORE_SWIFT_USER_PASSWORD'),
          'domain' => [
            'name' => (getenv('OBJECTSTORE_SWIFT_USER_DOMAIN')) ?: 'Default',
          ],
        ],
        'scope' => [
          'project' => [
            'name' => getenv('OBJECTSTORE_SWIFT_PROJECT_NAME'),
            'domain' => [
              'name' => (getenv('OBJECTSTORE_SWIFT_PROJECT_DOMAIN')) ?: 'Default',
            ],
          ],
        ],
        'serviceName' => (getenv('OBJECTSTORE_SWIFT_SERVICE_NAME')) ?: 'swift',
        'region' => getenv('OBJECTSTORE_SWIFT_REGION'),
        'url' => getenv('OBJECTSTORE_SWIFT_URL'),
        'bucket' => getenv('OBJECTSTORE_SWIFT_CONTAINER_NAME'),
      ]
    ]
  );
}

/**
 * If this is set to true and a multibucket object store is configured then
 * newly created previews are put into 256 dedicated buckets.
 *
 * Those buckets are named like the mulibucket version but with the postfix
 * ``-preview-NUMBER`` where NUMBER is between 0 and 255.
 *
 * Keep in mind that only previews of files are put in there that don't have
 * some already. Otherwise the old bucket will be used.
 *
 * To migrate existing previews to this new multibucket distribution of previews
 * use the occ command ``preview:repair``. For now this will only migrate
 * previews that were generated before Nextcloud 19 in the flat
 * ``appdata_INSTANCEID/previews/FILEID`` folder structure.
 */
$objectstore_multibucket_preview_distribution = getenv('NEXTCLOUD_OBJECTSTORE_MULTIBUCKET_PREVIEW_DISTRIBUTION');
if ($objectstore_multibucket_preview_distribution !== false) {
  $CONFIG['objectstore.multibucket.preview-distribution'] = $objectstore_multibucket_preview_distribution;
}

if (getenv('OBJECTSTORE_S3_MULTIBUCKET')) {
  $use_ssl = getenv('OBJECTSTORE_S3_SSL');
  $use_path = getenv('OBJECTSTORE_S3_USEPATH_STYLE');
  $use_legacyauth = getenv('OBJECTSTORE_S3_LEGACYAUTH');
  $autocreate = getenv('OBJECTSTORE_S3_AUTOCREATE');
  $CONFIG = array(
    'objectstore' => array(
      'class' => '\OC\Files\ObjectStore\S3',
      'arguments' => array(
        'bucket' => getenv('OBJECTSTORE_S3_BUCKET'),
        'key' => getenv('OBJECTSTORE_S3_KEY') ?: '',
        'secret' => getenv('OBJECTSTORE_S3_SECRET') ?: '',
        'region' => getenv('OBJECTSTORE_S3_REGION') ?: '',
        'hostname' => getenv('OBJECTSTORE_S3_HOST') ?: '',
        'port' => getenv('OBJECTSTORE_S3_PORT') ?: '',
        'objectPrefix' => getenv("OBJECTSTORE_S3_OBJECT_PREFIX") ? getenv("OBJECTSTORE_S3_OBJECT_PREFIX") : "urn:oid:",
        'autocreate' => (strtolower($autocreate) === 'false' || $autocreate == false) ? false : true,
        'use_ssl' => (strtolower($use_ssl) === 'false' || $use_ssl == false) ? false : true,
        // required for some non Amazon S3 implementations
        'use_path_style' => $use_path == true && strtolower($use_path) !== 'false',
        // required for older protocol versions
        'legacy_auth' => $use_legacyauth == true && strtolower($use_legacyauth) !== 'false'
      )
    )
  );
}

if (getenv('OBJECTSTORE_S3_MULTIBUCKET')) {
  $use_ssl = getenv('OBJECTSTORE_S3_SSL');
  $use_path = getenv('OBJECTSTORE_S3_USEPATH_STYLE');
  $use_legacyauth = getenv('OBJECTSTORE_S3_LEGACYAUTH');
  $autocreate = getenv('OBJECTSTORE_S3_AUTOCREATE');
  $CONFIG = array(
    'objectstore_multibucket' => array(
      'class' => '\OC\Files\ObjectStore\S3',
      'arguments' => array(
        'bucket' => getenv('OBJECTSTORE_S3_MULTIBUCKET'),
        'key' => getenv('OBJECTSTORE_S3_KEY') ?: '',
        'secret' => getenv('OBJECTSTORE_S3_SECRET') ?: '',
        'region' => getenv('OBJECTSTORE_S3_REGION') ?: '',
        'hostname' => getenv('OBJECTSTORE_S3_HOST') ?: '',
        'port' => getenv('OBJECTSTORE_S3_PORT') ?: '',
        'objectPrefix' => getenv("OBJECTSTORE_S3_OBJECT_PREFIX") ? getenv("OBJECTSTORE_S3_OBJECT_PREFIX") : "urn:oid:",
        'autocreate' => (strtolower($autocreate) === 'false' || $autocreate == false) ? false : true,
        'use_ssl' => (strtolower($use_ssl) === 'false' || $use_ssl == false) ? false : true,
        // required for some non Amazon S3 implementations
        'use_path_style' => $use_path == true && strtolower($use_path) !== 'false',
        // required for older protocol versions
        'legacy_auth' => $use_legacyauth == true && strtolower($use_legacyauth) !== 'false',
        'num_buckets' => getenv('OBJECTSTORE_S3_NUM_BUCKETS') ?: '1',
      )
    )
  );
}
