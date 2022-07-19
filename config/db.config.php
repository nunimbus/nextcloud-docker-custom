<?php

$CONFIG = array();

/**
 * Identifies the database used with this installation. See also config option
 * ``supportedDatabases``
 *
 * Available:
 * 	- sqlite3 (SQLite3)
 * 	- mysql (MySQL/MariaDB)
 * 	- pgsql (PostgreSQL)
 *
 * Defaults to ``sqlite3``
 */
$dbtype = getenv('NEXTCLOUD_DBTYPE');
if ($dbtype !== false) {
  $CONFIG['dbtype'] = $dbtype;
}

/**
 * Your host server name, for example ``localhost``, ``hostname``,
 * ``hostname.example.com``, or the IP address. To specify a port use
 * ``hostname:####``; to specify a Unix socket use
 * ``localhost:/path/to/socket``.
 */
$dbhost = getenv('NEXTCLOUD_DBHOST');
if ($dbhost !== false) {
  $CONFIG['dbhost'] = $dbhost;
}

/**
 * The name of the Nextcloud database, which is set during installation. You
 * should not need to change this.
 */
$dbname = getenv('NEXTCLOUD_DBNAME');
if ($dbname !== false) {
  $CONFIG['dbname'] = $dbname;
}

/**
 * The user that Nextcloud uses to write to the database. This must be unique
 * across Nextcloud instances using the same SQL database. This is set up during
 * installation, so you shouldn't need to change it.
 */
$dbuser = getenv('NEXTCLOUD_DBUSER');
if ($dbuser !== false) {
  $CONFIG['dbuser'] = $dbuser;
}

/**
 * The password for the database user. This is set up during installation, so
 * you shouldn't need to change it.
 */
$dbpassword = getenv('NEXTCLOUD_DBPASSWORD');
if ($dbpassword !== false) {
  $CONFIG['dbpassword'] = $dbpassword;
}

/**
 * Prefix for the Nextcloud tables in the database.
 *
 * Default to ``oc_``
 */
$dbtableprefix = getenv('NEXTCLOUD_DBTABLEPREFIX');
if ($dbtableprefix !== false) {
  $CONFIG['dbtableprefix'] = $dbtableprefix;
}

/**
 * Additional driver options for the database connection, eg. to enable SSL
 * encryption in MySQL or specify a custom wait timeout on a cheap hoster.
 */
foreach (getenv() as $key=>$val) {
  if (substr(trim($key), 0, 26) == 'NEXTCLOUD_DBDRIVEROPTIONS_') {
    if (!(isset($CONFIG['dbdriveroptions']) || array_key_exists('dbdriveroptions', $CONFIG))) {
      $CONFIG['dbdriveroptions'] = array();
    }
    $CONFIG['dbdriveroptions'][strtolower(substr(trim($key), 26))] = $val;
  }
}

/**
 * sqlite3 journal mode can be specified using this configuration parameter -
 * can be 'WAL' or 'DELETE' see for more details https://www.sqlite.org/wal.html
 */
$sqlite_journal_mode = getenv('NEXTCLOUD_SQLITE_JOURNAL_MODE');
if ($sqlite_journal_mode !== false) {
  $CONFIG['sqlite.journal_mode'] = $sqlite_journal_mode;
}

/**
 * During setup, if requirements are met (see below), this setting is set to true
 * and MySQL can handle 4 byte characters instead of 3 byte characters.
 *
 * If you want to convert an existing 3-byte setup into a 4-byte setup please
 * set the parameters in MySQL as mentioned below and run the migration command:
 * ./occ db:convert-mysql-charset
 * The config setting will be set automatically after a successful run.
 *
 * Consult the documentation for more details.
 *
 * MySQL requires a special setup for longer indexes (> 767 bytes) which are
 * needed:
 *
 * [mysqld]
 * innodb_large_prefix=ON
 * innodb_file_format=Barracuda
 * innodb_file_per_table=ON
 *
 * Tables will be created with
 *  * character set: utf8mb4
 *  * collation:     utf8mb4_bin
 *  * row_format:    compressed
 *
 * See:
 * https://dev.mysql.com/doc/refman/5.7/en/charset-unicode-utf8mb4.html
 * https://dev.mysql.com/doc/refman/5.7/en/innodb-parameters.html#sysvar_innodb_large_prefix
 * https://mariadb.com/kb/en/mariadb/xtradbinnodb-server-system-variables/#innodb_large_prefix
 * http://www.tocker.ca/2013/10/31/benchmarking-innodb-page-compression-performance.html
 * http://mechanics.flite.com/blog/2014/07/29/using-innodb-large-prefix-to-avoid-error-1071/
 */
$mysql_utf8mb4 = getenv('NEXTCLOUD_MYSQL_UTF8MB4');
if ($mysql_utf8mb4 !== false) {
  $CONFIG['mysql.utf8mb4'] = $mysql_utf8mb4;
}


/**
 * Database types that are supported for installation.
 *
 * Available:
 * 	- sqlite (SQLite3)
 * 	- mysql (MySQL)
 * 	- pgsql (PostgreSQL)
 * 	- oci (Oracle)
 *
 * Defaults to the following databases:
 *  - sqlite (SQLite3)
 *  - mysql (MySQL)
 *  - pgsql (PostgreSQL)
 */
$supportedDatabases = getenv('NEXTCLOUD_SUPPORTEDDATABASES');
if ($supportedDatabases !== false) {
  $CONFIG['supportedDatabases'] = explode(',', $supportedDatabases);
}
