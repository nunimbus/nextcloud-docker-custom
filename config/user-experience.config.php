<?php

$CONFIG = array();

/**
 * User Experience
 *
 * These optional parameters control some aspects of the user interface. Default
 * values, where present, are shown.
 */

/**
 * This sets the default language on your Nextcloud server, using ISO_639-1
 * language codes such as ``en`` for English, ``de`` for German, and ``fr`` for
 * French. It overrides automatic language detection on public pages like login
 * or shared items. User's language preferences configured under "personal ->
 * language" override this setting after they have logged in. Nextcloud has two
 * distinguished language codes for German, 'de' and 'de_DE'. 'de' is used for
 * informal German and 'de_DE' for formal German. By setting this value to 'de_DE'
 * you can enforce the formal version of German unless the user has chosen
 * something different explicitly.
 *
 * Defaults to ``en``
 */
$default_language = getenv('NEXTCLOUD_DEFAULT_LANGUAGE');
if ($default_language !== false) {
  $CONFIG['default_language'] = $default_language;
}

/**
 * With this setting a language can be forced for all users. If a language is
 * forced, the users are also unable to change their language in the personal
 * settings. If users shall be unable to change their language, but users have
 * different languages, this value can be set to ``true`` instead of a language
 * code.
 *
 * Defaults to ``false``
 */
$force_language = getenv('NEXTCLOUD_FORCE_LANGUAGE');
if ($force_language !== false) {
  $CONFIG['force_language'] = $force_language;
}

/**
 * This sets the default locale on your Nextcloud server, using ISO_639
 * language codes such as ``en`` for English, ``de`` for German, and ``fr`` for
 * French, and ISO-3166 country codes such as ``GB``, ``US``, ``CA``, as defined
 * in RFC 5646. It overrides automatic locale detection on public pages like
 * login or shared items. User's locale preferences configured under "personal
 * -> locale" override this setting after they have logged in.
 *
 * Defaults to ``en``
 */
$default_locale = getenv('NEXTCLOUD_DEFAULT_LOCALE');
if ($default_locale !== false) {
  $CONFIG['default_locale'] = $default_locale;
}

/**
 * This sets the default region for phone numbers on your Nextcloud server,
 * using ISO 3166-1 country codes such as ``DE`` for Germany, ``FR`` for France, …
 * It is required to allow inserting phone numbers in the user profiles starting
 * without the country code (e.g. +49 for Germany).
 *
 * No default value!
 */
$default_phone_region = getenv('NEXTCLOUD_DEFAULT_PHONE_REGION');
if ($default_phone_region !== false) {
  $CONFIG['default_phone_region'] = $default_phone_region;
}

/**
 * With this setting a locale can be forced for all users. If a locale is
 * forced, the users are also unable to change their locale in the personal
 * settings. If users shall be unable to change their locale, but users have
 * different languages, this value can be set to ``true`` instead of a locale
 * code.
 *
 * Defaults to ``false``
 */
$force_locale = getenv('NEXTCLOUD_FORCE_LOCALE');
if ($force_locale !== false) {
  $CONFIG['force_locale'] = $force_locale;
}

/**
 * Set the default app to open on login. Use the app names as they appear in the
 * URL after clicking them in the Apps menu, such as documents, calendar, and
 * gallery. You can use a comma-separated list of app names, so if the first
 * app is not enabled for a user then Nextcloud will try the second one, and so
 * on. If no enabled apps are found it defaults to the dashboard app.
 *
 * Defaults to ``dashboard,files``
 */
$defaultapp = getenv('NEXTCLOUD_DEFAULTAPP');
if ($defaultapp !== false) {
  $CONFIG['defaultapp'] = $defaultapp;
}

/**
 * ``true`` enables the Help menu item in the user menu (top right of the
 * Nextcloud Web interface). ``false`` removes the Help item.
 */
$knowledgebaseenabled = getenv('NEXTCLOUD_KNOWLEDGEBASEENABLED');
if ($knowledgebaseenabled !== false) {
  $CONFIG['knowledgebaseenabled'] = $knowledgebaseenabled;
}

/**
 * ``true`` allows users to change their display names (on their Personal
 * pages), and ``false`` prevents them from changing their display names.
 */
$allow_user_to_change_display_name = getenv('NEXTCLOUD_ALLOW_USER_TO_CHANGE_DISPLAY_NAME');
if ($allow_user_to_change_display_name !== false) {
  $CONFIG['allow_user_to_change_display_name'] = $allow_user_to_change_display_name;
}

/**
 * Lifetime of the remember login cookie. This should be larger than the
 * session_lifetime. If it is set to 0 remember me is disabled.
 *
 * Defaults to ``60*60*24*15`` seconds (15 days)
 */
$remember_login_cookie_lifetime = getenv('NEXTCLOUD_REMEMBER_LOGIN_COOKIE_LIFETIME');
if ($remember_login_cookie_lifetime !== false) {
  $CONFIG['remember_login_cookie_lifetime'] = $remember_login_cookie_lifetime;
}

/**
 * The lifetime of a session after inactivity.
 *
 * Defaults to ``60*60*24`` seconds (24 hours)
 */
$session_lifetime = getenv('NEXTCLOUD_SESSION_LIFETIME');
if ($session_lifetime !== false) {
  $CONFIG['session_lifetime'] = $session_lifetime;
}

/**
 * Enable or disable session keep-alive when a user is logged in to the Web UI.
 * Enabling this sends a "heartbeat" to the server to keep it from timing out.
 *
 * Defaults to ``true``
 */
$session_keepalive = getenv('NEXTCLOUD_SESSION_KEEPALIVE');
if ($session_keepalive !== false) {
  $CONFIG['session_keepalive'] = $session_keepalive;
}

/**
 * Enable or disable the automatic logout after session_lifetime, even if session
 * keepalive is enabled. This will make sure that an inactive browser will be logged out
 * even if requests to the server might extend the session lifetime.
 *
 * Defaults to ``false``
 */
$auto_logout = getenv('NEXTCLOUD_AUTO_LOGOUT');
if ($auto_logout !== false) {
  $CONFIG['auto_logout'] = $auto_logout;
}

/**
 * Enforce token authentication for clients, which blocks requests using the user
 * password for enhanced security. Users need to generate tokens in personal settings
 * which can be used as passwords on their clients.
 *
 * Defaults to ``false``
 */
$token_auth_enforced = getenv('NEXTCLOUD_TOKEN_AUTH_ENFORCED');
if ($token_auth_enforced !== false) {
  $CONFIG['token_auth_enforced'] = $token_auth_enforced;
}

/**
 * The interval at which token activity should be updated.
 * Increasing this value means that the last activty on the security page gets
 * more outdated.
 *
 * Tokens are still checked every 5 minutes for validity
 * max value: 300
 *
 * Defaults to ``300``
 */
$token_auth_activity_update = getenv('NEXTCLOUD_TOKEN_AUTH_ACTIVITY_UPDATE');
if ($token_auth_activity_update !== false) {
  $CONFIG['token_auth_activity_update'] = $token_auth_activity_update;
}

/**
 * Whether the bruteforce protection shipped with Nextcloud should be enabled or not.
 *
 * Disabling this is discouraged for security reasons.
 *
 * Defaults to ``true``
 */
$auth_bruteforce_protection_enabled = getenv('NEXTCLOUD_AUTH_BRUTEFORCE_PROTECTION_ENABLED');
if ($auth_bruteforce_protection_enabled !== false) {
  $CONFIG['auth.bruteforce.protection.enabled'] = $auth_bruteforce_protection_enabled;
}

/**
 * By default WebAuthn is available but it can be explicitly disabled by admins
 */
$auth_webauthn_enabled = getenv('NEXTCLOUD_AUTH_WEBAUTHN_ENABLED');
if ($auth_webauthn_enabled !== false) {
  $CONFIG['auth.webauthn.enabled'] = $auth_webauthn_enabled;
}

/**
 * The directory where the skeleton files are located. These files will be
 * copied to the data directory of new users. Leave empty to not copy any
 * skeleton files.
 * ``{lang}`` can be used as a placeholder for the language of the user.
 * If the directory does not exist, it falls back to non dialect (from ``de_DE``
 * to ``de``). If that does not exist either, it falls back to ``default``
 *
 * Defaults to ``core/skeleton`` in the Nextcloud directory.
 */
$skeletondirectory = getenv('NEXTCLOUD_SKELETONDIRECTORY');
if ($skeletondirectory !== false) {
  $CONFIG['skeletondirectory'] = $skeletondirectory;
}

/**
 * The directory where the template files are located. These files will be
 * copied to the template directory of new users. Leave empty to not copy any
 * template files.
 * ``{lang}`` can be used as a placeholder for the language of the user.
 * If the directory does not exist, it falls back to non dialect (from ``de_DE``
 * to ``de``). If that does not exist either, it falls back to ``default``
 *
 * If this is not set creating a template directory will only happen if no custom
 * ``skeletondirectory`` is defined, otherwise the shipped templates will be used
 * to create a template directory for the user.
 */
$templatedirectory = getenv('NEXTCLOUD_TEMPLATEDIRECTORY');
if ($templatedirectory !== false) {
  $CONFIG['templatedirectory'] = $templatedirectory;
}

/**
 * If your user backend does not allow password resets (e.g. when it's a
 * read-only user backend like LDAP), you can specify a custom link, where the
 * user is redirected to, when clicking the "reset password" link after a failed
 * login-attempt.
 * In case you do not want to provide any link, replace the url with 'disabled'
 */
$lost_password_link = getenv('NEXTCLOUD_LOST_PASSWORD_LINK');
if ($lost_password_link !== false) {
  $CONFIG['lost_password_link'] = $lost_password_link;
}

/**
 * By default autocompletion is enabled for the login form on Nextcloud's login page.
 * While this is enabled, browsers are allowed to "remember" login names and such.
 * Some companies require it to be disabled to comply with their security policy.
 *
 * Simply set this property to "false", if you want to turn this feature off.
 */
$login_form_autocomplete = getenv('NEXTCLOUD_LOGIN_FORM_AUTOCOMPLETE');
if ($login_form_autocomplete !== false) {
  $CONFIG['login_form_autocomplete'] = $login_form_autocomplete;
}

/**
 * If you are applying a theme to Nextcloud, enter the name of the theme here.
 * The default location for themes is ``nextcloud/themes/``.
 *
 * Defaults to the theming app which is shipped since Nextcloud 9
 */
$theme = getenv('NEXTCLOUD_THEME');
if ($theme !== false) {
  $CONFIG['theme'] = $theme;
}
