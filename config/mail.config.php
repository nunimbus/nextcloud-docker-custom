<?php

if (getenv('SMTP_HOST') && getenv('MAIL_FROM_ADDRESS') && getenv('MAIL_DOMAIN')) {
  $CONFIG = array();

  /**
   * Mail Parameters
   *
   * These configure the email settings for Nextcloud notifications and password
   * resets.
   */

  /**
   * The return address that you want to appear on emails sent by the Nextcloud
   * server, for example ``nc-admin@example.com``, substituting your own domain,
   * of course.
   */
  $mail_domain = getenv('MAIL_DOMAIN');
  if ($mail_domain !== false) {
    $CONFIG['mail_domain'] = $mail_domain;
  }

  /**
   * FROM address that overrides the built-in ``sharing-noreply`` and
   * ``lostpassword-noreply`` FROM addresses.
   *
   * Defaults to different from addresses depending on the feature.
   */
  $mail_from_address = getenv('MAIL_FROM_ADDRESS');
  if ($mail_from_address !== false) {
    $CONFIG['mail_from_address'] = $mail_from_address;
  }

  /**
   * Enable SMTP class debugging.
   *
   * Defaults to ``false``
   */
  $mail_smtpdebug = getenv('SMTP_DEBUG');
  if ($mail_smtpdebug !== false) {
    $CONFIG['mail_smtpdebug'] = $mail_smtpdebug;
  }

  /**
   * Which mode to use for sending mail: ``sendmail``, ``smtp`` or ``qmail``.
   *
   * If you are using local or remote SMTP, set this to ``smtp``.
   *
   * For the ``sendmail`` option you need an installed and working email system on
   * the server, with ``/usr/sbin/sendmail`` installed on your Unix system.
   *
   * For ``qmail`` the binary is /var/qmail/bin/sendmail, and it must be installed
   * on your Unix system.
   *
   * Defaults to ``smtp``
   */
  $mail_smtpmode = getenv('SMTP_MODE');
  if ($mail_smtpmode !== false) {
    $CONFIG['mail_smtpmode'] = $mail_smtpmode;
  }

  /**
   * This depends on ``mail_smtpmode``. Specify the IP address of your mail
   * server host. This may contain multiple hosts separated by a semi-colon. If
   * you need to specify the port number append it to the IP address separated by
   * a colon, like this: ``127.0.0.1:24``.
   *
   * Defaults to ``127.0.0.1``
   */
  $mail_smtphost = getenv('SMTP_HOST');
  if ($mail_smtphost !== false) {
    $CONFIG['mail_smtphost'] = $mail_smtphost;
  }

  /**
   * This depends on ``mail_smtpmode``. Specify the port for sending mail.
   *
   * Defaults to ``25``
   */
  $mail_smtpport = getenv('SMTP_PORT');
  if ($mail_smtpport !== false) {
    $CONFIG['mail_smtpport'] = $mail_smtpport;
  }

  /**
   * This depends on ``mail_smtpmode``. This sets the SMTP server timeout, in
   * seconds. You may need to increase this if you are running an anti-malware or
   * spam scanner.
   *
   * Defaults to ``10`` seconds
   */
  $mail_smtptimeout = getenv('SMTP_TIMEOUT');
  if ($mail_smtptimeout !== false) {
    $CONFIG['mail_smtptimeout'] = $mail_smtptimeout;
  }

  /**
   * This depends on ``mail_smtpmode``. Specify when you are using ``ssl`` for SSL/TLS or
   * ``tls`` for STARTTLS, or leave empty for no encryption.
   *
   * Defaults to ``''`` (empty string)
   */
  $mail_smtpsecure = getenv('SMTP_SECURE');
  if ($mail_smtpsecure !== false) {
    $CONFIG['mail_smtpsecure'] = $mail_smtpsecure;
  }

  /**
   * This depends on ``mail_smtpmode``. If SMTP authentication is required, choose
   * the authentication type as ``LOGIN`` or ``PLAIN``.
   *
   * Defaults to ``LOGIN``
   */
  $mail_smtpauthtype = getenv('SMTP_AUTHTYPE');
  if ($mail_smtpauthtype !== false) {
    $CONFIG['mail_smtpauthtype'] = $mail_smtpauthtype;
  }

  /**
   * This depends on ``mail_smtpauth``. Specify the username for authenticating to
   * the SMTP server.
   *
   * Defaults to ``''`` (empty string)
   */
  $mail_smtpname = getenv('SMTP_NAME');
  if ($mail_smtpname !== false) {
    $CONFIG['mail_smtpname'] = $mail_smtpname;
  }

  /**
   * This depends on ``mail_smtpauth``. Specify the password for authenticating to
   * the SMTP server.
   *
   * Default to ``''`` (empty string)
   */
  $mail_smtppassword = getenv('SMTP_PASSWORD');
  if ($mail_smtppassword !== false) {
    $CONFIG['mail_smtppassword'] = $mail_smtppassword;
  }

  /**
   * This depends on ``mail_smtpmode``. Change this to ``true`` if your mail
   * server requires authentication.
   *
   * Defaults to ``false``
   */
  $mail_smtpauth = getenv('SMTP_AUTH');
  if ($mail_smtpauth !== false) {
    $CONFIG['mail_smtpauth'] = $mail_smtpauth;
  }
  else if ($mail_smtpname !== false && $mail_smtppassword !== false) {
    $CONFIG['mail_smtpauth'] = getenv('SMTP_NAME') && getenv('SMTP_PASSWORD');
  }

  /**
   * Replaces the default mail template layout. This can be utilized if the
   * options to modify the mail texts with the theming app is not enough.
   * The class must extend  ``\OC\Mail\EMailTemplate``
   */
  $mail_template_class = getenv('MAIL_TEMPLATE_CLASS');
  if ($mail_template_class !== false) {
    $CONFIG['mail_template_class'] = $mail_template_class;
  }

  /**
   * Email will be send by default with an HTML and a plain text body. This option
   * allows to only send plain text emails.
   */
  $mail_send_plaintext_only = getenv('MAIL_SEND_PLAINTEXT_ONLY');
  if ($mail_send_plaintext_only !== false) {
    $CONFIG['mail_send_plaintext_only'] = $mail_send_plaintext_only;
  }

  /**
   * This depends on ``mail_smtpmode``. Array of additional streams options that
   * will be passed to underlying Swift mailer implementation.
   * Defaults to an empty array.
   */
  $mail_smtpstreamoptions = getenv('SMTP_STREAMOPTIONS');
  if ($mail_smtpstreamoptions !== false) {
    $CONFIG['mail_smtpstreamoptions'] = $mail_smtpstreamoptions;
  }

  /**
   * Which mode is used for sendmail/qmail: ``smtp`` or ``pipe``.
   *
   * For ``smtp`` the sendmail binary is started with the parameter ``-bs``:
   *   - Use the SMTP protocol on standard input and output.
   *
   * For ``pipe`` the binary is started with the parameters ``-t``:
   *   - Read message from STDIN and extract recipients.
   *
   * Defaults to ``smtp``
   */
  $mail_sendmailmode = getenv('MAIL_SENDMAILMODE');
  if ($mail_sendmailmode !== false) {
    $CONFIG['mail_sendmailmode'] = $mail_sendmailmode;
  }
}
