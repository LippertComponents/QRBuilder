## What does it do?
QRBuilder is a CMP for MODX Revolution. It allows users to easily build customer QR codes in the MODX Manager. 
These QR Codes have simple counter stats within the MODX Manager. It also allows builds into the URL parameters 
for Analytics, like Google, Piwik or similar. It will build a short URL like http://mysite.com/qr*123 that would 
redirect to the destination like http://mysite.com/folder/page.html?analytics_params=123&param2=abc&etc. This will allow the 
QR Codes to be less complex so they will have better compatibility with QR scanners on smaller prints. 

## Manual install:
 - download files
 - put files on your modx install
 - create namespace:
      - Name: qrbuilder
      - Core Path: {core_path}components/qrbuilder/
      - Assets Path: {assets_path}components/qrbuilder/
    
 - create menu item
      - Lex Key: qrbuilder
      - Description: qrbuilder.desc
      - Action: index
      - Namespace: qrbuilder
 - create plugin
      - Name: QRBuilder
      - Description: QRBuilder
      - Check Is Static
      - Select Filesystem Media Source
      - Select file: core/components/qrbuilder/elements/plugins/plugin.qrbuilder.php
      - Attach onPageNotFound
        If you are using Redirect you may need to set the priority column
 - create tables
      - Create install snippet and run in a web page code is found here: core\components\qrbuilder\elements\snippets\snippet.installqrbuilder.php
    
## Requirements
 - SEO/Friendly URLs working
 - Extra: http://modx.com/extras/package/ludwigqrcode ~ uses the qr code library to build the qr code image

## TODO before can be put into MODX Extras:
 - Build script
 - Work with multi context
 - more testing

Fork and do a pull request on the above TODO list would be appreciated.
