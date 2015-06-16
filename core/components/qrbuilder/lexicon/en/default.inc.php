<?php
/**
 * Default English Lexicon Entries for Qrbuilder
 *
 * @package qrbuilder
 * @subpackage lexicon
 */
// for permissions:
$_lang['perm.view_qrbuilder'] = 'View QR Builder';

$_lang['qrcode'] = 'QR Code';
$_lang['qrbuilder'] = 'QR Builder';
$_lang['qrbuilder.desc'] = 'Manage your QR Codes.';
$_lang['qrbuilder.description'] = 'Description';
// errors via the processor:
$_lang['qrbuilder.qrcode_err_ae'] = 'A QR Code with that name already exists.';
$_lang['qrbuilder.qrcode_err_nf'] = 'QR code record not found.';
$_lang['qrbuilder.qrcode_err_ns'] = 'QR code not specified.';
$_lang['qrbuilder.qrcode_err_ns_name'] = 'Please specify a name for the QR code.';
$_lang['qrbuilder.qrcode_err_remove'] = 'An error occurred while trying to remove the QR code.';
$_lang['qrbuilder.qrcode_err_save'] = 'An error occurred while trying to save the QR code.';
$_lang['qrbuilder.qrcode_err_end_date'] = 'The end date must be greater then the start date.';
$_lang['qrbuilder.qrcode_err_data'] = 'Invalid data.';
$_lang['qrbuilder.qrcode_err_empty_short_link'] = 'Field must not be empty or uncheck Use short link.';
$_lang['qrbuilder.qrcode_err_short_link_exists'] = 'The URL already exists, please use another one.';
$_lang['qrbuilder.qrcode_err_invalid_json'] = 'Invalid JSON';

$_lang['qrbuilder.qrcode_create'] = 'Create New QR code';
$_lang['qrbuilder.qrcode_remove'] = 'Remove QR code';
$_lang['qrbuilder.qrcode_remove_confirm'] = 'Are you sure you want to remove this QR code?';
$_lang['qrbuilder.qrcode_update'] = 'Update QR code';
$_lang['qrbuilder.downloads'] = 'Downloads';
$_lang['qrbuilder.location'] = 'Location';
$_lang['qrbuilder.management'] = 'QR-Builder Management';
$_lang['qrbuilder.management_desc'] = 'Manage your qrbuilder here. You can edit them by either double-clicking on the grid or right-clicking on the respective row.';
$_lang['qrbuilder.name'] = 'Name';
$_lang['qrbuilder.search...'] = 'Search...';
$_lang['qrbuilder.top_downloaded'] = 'Top Downloaded Qrbuilder';

// Web-ads
$_lang['qrbuilder.web_ads'] = 'Readable URL Ads';
$_lang['qrbuilder.web_ads_desc'] = 'Create unique readable ad URLs that can be attached to analytics.';

// grid column names:
$_lang['qrbuilder.grid.name'] = 'Name';
$_lang['qrbuilder.grid.context_key'] = 'Context';
$_lang['qrbuilder.grid.description'] = 'Description';
$_lang['qrbuilder.grid.destination_url'] = 'Destination URL';
$_lang['qrbuilder.grid.hits'] = 'Hits';
$_lang['qrbuilder.grid.override_url_input'] = 'Override URL';
$_lang['qrbuilder.grid.build_url_params'] = 'URL Params';
$_lang['qrbuilder.grid.qr_link'] = 'QR Link';
$_lang['qrbuilder.grid.short_link'] = 'Ad Link';
$_lang['qrbuilder.grid.use_ad_link'] = 'Use readable link';
$_lang['qrbuilder.grid.redirect_type'] = 'Redirect Type';
$_lang['qrbuilder.grid.qr_png_path'] = 'PNG QR';
$_lang['qrbuilder.grid.qr_svg_path'] = 'SVG QR';
$_lang['qrbuilder.grid.download'] = 'Download';
$_lang['qrbuilder.grid.download_png'] = 'PNG';
$_lang['qrbuilder.grid.download_svg'] = 'SVG';
$_lang['qrbuilder.grid.active'] = 'Active';
$_lang['qrbuilder.grid.start_date'] = 'Start Date';
$_lang['qrbuilder.grid.end_date'] = 'End Date';
$_lang['qrbuilder.grid.use_end_date'] = 'Use end date';
$_lang['qrbuilder.grid.create_date'] = 'Date Created';
$_lang['qrbuilder.grid.edit_date'] = 'Last date updated';

// qrcode Table columns for create/update forms: 
$_lang['qrbuilder.qrcode.name'] = 'Name of QR Code/Link';
$_lang['qrbuilder.qrcode.context_key'] = 'Select Context/Site';
$_lang['qrbuilder.qrcode.description'] = 'Brief description of what and why the QR Code/Link are needed.';
$_lang['qrbuilder.qrcode.destination_url'] = 'Destination URL (URL the QR code will redirect to)';
$_lang['qrbuilder.qrcode.override_url_input'] = 'Override Analytics paramaters';
$_lang['qrbuilder.qrcode.override_url_input_check'] = 'Check to override Analytics tab paramaters input then fill in below.';
$_lang['qrbuilder.qrcode.build_url_params'] = 'URL Paramaters, must be valid JSON';
$_lang['qrbuilder.qrcode.qr_link'] = 'Generated link used for QR Code';
$_lang['qrbuilder.qrcode.short_link'] = 'Readable Ad link, only put folder paths, exclude your domain name.';
$_lang['qrbuilder.qrcode.use_ad_link'] = 'Use Readable Ad link';
$_lang['qrbuilder.qrcode.use_ad_link_check'] = 'Check to override the generated QR Link';
$_lang['qrbuilder.qrcode.redirect_type'] = 'Redirect Type';
$_lang['qrbuilder.qrcode.qr_png_path'] = 'QR Code PNG, click to Download';// the path to the image
$_lang['qrbuilder.qrcode.qr_svg_path'] = 'QR Code SVG, click to Download';// the path to the image
$_lang['qrbuilder.qrcode.active'] = 'Active';
$_lang['qrbuilder.qrcode.start_date'] = 'Start Date';
$_lang['qrbuilder.qrcode.end_date'] = 'End Date (only used if above is set to 1)';
$_lang['qrbuilder.qrcode.use_end_date'] = 'Use end date';
$_lang['qrbuilder.qrcode.use_end_date_check'] = 'Check to use end date, once end date is reached QR Code will be invalid';
$_lang['qrbuilder.qrcode.create_date'] = 'Date Created';
$_lang['qrbuilder.qrcode.edit_date'] = 'Last date updated';

// user URL Params:
$_lang['qrbuilder.qrcode.campaign_source'] = 'Campaign Source * (referrer: ads, show, google, newsletter4, ect.)';
$_lang['qrbuilder.qrcode.campaign_medium'] = 'Campaign Medium * (marketing medium: magazine, show, cpc, banner, email, ect.)';
$_lang['qrbuilder.qrcode.campaign_term'] = 'Campaign Term (identify the paid keywords)';
$_lang['qrbuilder.qrcode.campaign_content'] = 'Campaign Content (use to differentiate ads)';
$_lang['qrbuilder.qrcode.campaign_name'] = 'Campaign Name * (product, trailer-life, promo code, ect.)';

//$_lang['qrbuilder.qrcode.'] = '';


// qrcode form tabs:
$_lang['qrbuilder.qrcode.tab_basic'] = 'Basic Details';
$_lang['qrbuilder.qrcode.tab_params'] = 'Analytics';
$_lang['qrbuilder.qrcode.tab_image'] = 'QR Code Image';
$_lang['qrbuilder.qrcode.tab_advanced'] = 'Advanced';


$_lang['qrbuilder.qrcode.tab_basic_desc'] = 'Fill in all fields';
$_lang['qrbuilder.qrcode.tab_params_desc'] = 'Fill in all fields. These feilds relate to Google Analytics tracking.';
$_lang['qrbuilder.qrcode.tab_image_desc'] = 'Copy the URL to make a QR Code. Or right click and download the QR Code Image.';
$_lang['qrbuilder.qrcode.tab_advanced_desc'] = 'If set to 1 then the params will override the analytics input fields.';
