## What does it do?
QRBuilder is a CMP for MODX Revolution. It allows users to easily build customer QR codes in the MODX Manager. 
These QR Codes have simple counter stats within the MODX Manager. It also allows and builds into the URL parameters 
for Analytics, like Google, Matomo or similar. It will build a short URL like `http://mysite.com/qr*123` that would 
redirect to the destination like `http://mysite.com/folder/page.html?analytics_params=123&param2=abc&etc`. This will allow the 
QR Codes to be less complex so they will have better compatibility with QR scanners on smaller prints. 

## Install

Requires an installation of MODX

- Install [Orchestrator](https://github.com/LippertComponents/Orchestrator)
- Add to the composer.json file as below
- Add to your .env file parameters in the sample.env file and customize.
- Run ```composer update```
- If you did not set up Orchestrator as the LocalOrchestrator example or you want to manually call the install script.  
Run ```$ php vendor/bin/orchestrator orchestrator:package lci/modx-qrbuilder``` from where you have composer.json.


### Composer.json

Add the following to your local composer.json file

```json
{
  "require": {
    "lci/modx-qrbuilder": "dev-master"
  },
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/LippertComponents/QRBuilder"
    }
  ],
  "extra": {
    "auto-install": [
      "lci/modx-qrbuilder"
    ]
  },
  "minimum-stability": "dev"
}
```

## What is installed in MODX
 - Custom database tables: modx_mb_sequence
 - A [Plugin](https://rtfm.modx.com/revolution/2.x/developing-in-modx/basic-development/plugins): 
 [QRBuilder](/src/elements/plugins/QRBuilder.php) and attach System Events:
    - OnDocFormSave
    - OnResourceSort
    - OnCacheUpdate
 - MODX namespace: qrbuilder
 - QR Builder CMP to manager the QR codes in the MODX Manager
    
## Requirements
 - SEO/Friendly URLs working