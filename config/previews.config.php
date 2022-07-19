<?php

$CONFIG = array();

/**
 * Previews
 *
 * Nextcloud supports previews of image files, the covers of MP3 files, and text
 * files. These options control enabling and disabling previews, and thumbnail
 * size.
 */

/**
 * By default, Nextcloud can generate previews for the following filetypes:
 *
 * - Image files
 * - Covers of MP3 files
 * - Text documents
 *
 * Valid values are ``true``, to enable previews, or
 * ``false``, to disable previews
 *
 * Defaults to ``true``
 */
$enable_previews = getenv('NEXTCLOUD_ENABLE_PREVIEWS');
if ($enable_previews !== false) {
  $CONFIG['enable_previews'] = $enable_previews;
}

/**
 * The maximum width, in pixels, of a preview. A value of ``null`` means there
 * is no limit.
 *
 * Defaults to ``4096``
 */
$preview_max_x = getenv('NEXTCLOUD_PREVIEW_MAX_X');
if ($preview_max_x !== false) {
  $CONFIG['preview_max_x'] = $preview_max_x;
}

/**
 * The maximum height, in pixels, of a preview. A value of ``null`` means there
 * is no limit.
 *
 * Defaults to ``4096``
 */
$preview_max_y = getenv('NEXTCLOUD_PREVIEW_MAX_Y');
if ($preview_max_y !== false) {
  $CONFIG['preview_max_y'] = $preview_max_y;
}

/**
 * max file size for generating image previews with imagegd (default behavior)
 * If the image is bigger, it'll try other preview generators, but will most
 * likely show the default mimetype icon. Set to -1 for no limit.
 *
 * Defaults to ``50`` megabytes
 */
$preview_max_filesize_image = getenv('NEXTCLOUD_PREVIEW_MAX_FILESIZE_IMAGE');
if ($preview_max_filesize_image !== false) {
  $CONFIG['preview_max_filesize_image'] = $preview_max_filesize_image;
}

/**
 * custom path for LibreOffice/OpenOffice binary
 *
 *
 * Defaults to ``''`` (empty string)
 */
$preview_libreoffice_path = getenv('NEXTCLOUD_PREVIEW_LIBREOFFICE_PATH');
if ($preview_libreoffice_path !== false) {
  $CONFIG['preview_libreoffice_path'] = $preview_libreoffice_path;
}
/**
 * Use this if LibreOffice/OpenOffice requires additional arguments.
 *
 * Defaults to ``''`` (empty string)
 */
$preview_office_cl_parameters = getenv('NEXTCLOUD_PREVIEW_OFFICE_CL_PARAMETERS');
if ($preview_office_cl_parameters !== false) {
  $CONFIG['preview_office_cl_parameters'] = $preview_office_cl_parameters;
}

/**
 * Only register providers that have been explicitly enabled
 *
 * The following providers are disabled by default due to performance or privacy
 * concerns:
 *
 *  - OC\Preview\Illustrator
 *  - OC\Preview\Movie
 *  - OC\Preview\MSOffice2003
 *  - OC\Preview\MSOffice2007
 *  - OC\Preview\MSOfficeDoc
 *  - OC\Preview\PDF
 *  - OC\Preview\Photoshop
 *  - OC\Preview\Postscript
 *  - OC\Preview\StarOffice
 *  - OC\Preview\SVG
 *  - OC\Preview\TIFF
 *  - OC\Preview\Font
 *
 *
 * Defaults to the following providers:
 *
 *  - OC\Preview\BMP
 *  - OC\Preview\GIF
 *  - OC\Preview\HEIC
 *  - OC\Preview\JPEG
 *  - OC\Preview\MarkDown
 *  - OC\Preview\MP3
 *  - OC\Preview\PNG
 *  - OC\Preview\TXT
 *  - OC\Preview\XBitmap
 *  - OC\Preview\OpenDocument
 *  - OC\Preview\Krita
 */
$enabledPreviewProviders = getenv('NEXTCLOUD_ENABLEDPREVIEWPROVIDERS');
if ($enabledPreviewProviders !== false) {
  $CONFIG['enabledPreviewProviders'] = explode(',', $enabledPreviewProviders);
}
