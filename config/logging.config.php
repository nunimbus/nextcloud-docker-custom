<?php

$CONFIG = array();

/**
 * Logging
 */

/**
 * This parameter determines where the Nextcloud logs are sent.
 * ``file``: the logs are written to file ``nextcloud.log`` in the default
 * Nextcloud data directory. The log file can be changed with parameter
 * ``logfile``.
 * ``syslog``: the logs are sent to the system log. This requires a syslog daemon
 * to be active.
 * ``errorlog``: the logs are sent to the PHP ``error_log`` function.
 * ``systemd``: the logs are sent to the Systemd journal. This requires a system
 * that runs Systemd and the Systemd journal. The PHP extension ``systemd``
 * must be installed and active.
 *
 * Defaults to ``file``
 */
$log_type = getenv('NEXTCLOUD_LOG_TYPE');
if ($log_type !== false) {
  $CONFIG['log_type'] = $log_type;
}

/**
 * Name of the file to which the Nextcloud logs are written if parameter
 * ``log_type`` is set to ``file``.
 *
 * Defaults to ``[datadirectory]/nextcloud.log``
 */
$logfile = getenv('NEXTCLOUD_LOGFILE');
if ($logfile !== false) {
  $CONFIG['logfile'] = $logfile;
}

/**
 * Log file mode for the Nextcloud loggin type in octal notation.
 *
 * Defaults to 0640 (writeable by user, readable by group).
 */
$logfilemode = getenv('NEXTCLOUD_LOGFILEMODE');
if ($logfilemode !== false) {
  $CONFIG['logfilemode'] = $logfilemode;
}

/**
 * Loglevel to start logging at. Valid values are: 0 = Debug, 1 = Info, 2 =
 * Warning, 3 = Error, and 4 = Fatal. The default value is Warning.
 *
 * Defaults to ``2``
 */
$loglevel = getenv('NEXTCLOUD_LOGLEVEL');
if ($loglevel !== false) {
  $CONFIG['loglevel'] = $loglevel;
}

/**
 * If you maintain different instances and aggregate the logs, you may want
 * to distinguish between them. ``syslog_tag`` can be set per instance
 * with a unique id. Only available if ``log_type`` is set to ``syslog`` or
 * ``systemd``.
 *
 * The default value is ``Nextcloud``.
 */
$syslog_tag = getenv('NEXTCLOUD_SYSLOG_TAG');
if ($syslog_tag !== false) {
  $CONFIG['syslog_tag'] = $syslog_tag;
}

/**
 * Log condition for log level increase based on conditions. Once one of these
 * conditions is met, the required log level is set to debug. This allows to
 * debug specific requests, users or apps
 *
 * Supported conditions:
 *  - ``shared_secret``: if a request parameter with the name `log_secret` is set to
 *                this value the condition is met
 *  - ``users``:  if the current request is done by one of the specified users,
 *                this condition is met
 *  - ``apps``:   if the log message is invoked by one of the specified apps,
 *                this condition is met
 *
 * Defaults to an empty array.
 */
foreach (getenv() as $key=>$val) {
  if (substr(trim($key), 0, 24) == 'NEXTCLOUD_LOG_CONDITION_') {
    if (!(isset($CONFIG['log.condition']) || array_key_exists('log.condition', $CONFIG))) {
      $CONFIG['log.condition'] = array();
    }
    $CONFIG['log.condition'][strtolower(substr(trim($key), 24))] = $val;
  }
}

/**
 * This uses PHP.date formatting; see https://www.php.net/manual/en/function.date.php
 *
 * Defaults to ISO 8601 ``2005-08-15T15:52:01+00:00`` - see \DateTime::ATOM
 * (https://www.php.net/manual/en/class.datetime.php#datetime.constants.atom)
 */
$logdateformat = getenv('NEXTCLOUD_LOGDATEFORMAT');
if ($logdateformat !== false) {
  $CONFIG['logdateformat'] = $logdateformat;
}

/**
 * The timezone for logfiles. You may change this; see
 * https://www.php.net/manual/en/timezones.php
 *
 * Defaults to ``UTC``
 */
$logtimezone = getenv('NEXTCLOUD_LOGTIMEZONE');
if ($logtimezone !== false) {
  $CONFIG['logtimezone'] = $logtimezone;
}

/**
 * Append all database queries and parameters to the log file. Use this only for
 * debugging, as your logfile will become huge.
 */
$log_query = getenv('NEXTCLOUD_LOG_QUERY');
if ($log_query !== false) {
  $CONFIG['log_query'] = $log_query;
}

/**
 * Enables log rotation and limits the total size of logfiles. Set it to 0 for
 * no rotation. Specify a size in bytes, for example 104857600 (100 megabytes
 * = 100 * 1024 * 1024 bytes). A new logfile is created with a new name when the
 * old logfile reaches your limit. If a rotated log file is already present, it
 * will be overwritten.
 *
 * Defaults to 100 MB
 */
$log_rotate_size = getenv('NEXTCLOUD_LOG_ROTATE_SIZE');
if ($log_rotate_size !== false) {
  $CONFIG['log_rotate_size'] = $log_rotate_size;
}
