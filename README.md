# release plugin for Craft CMS 3.x

craft plugin for releases and statistics

![Screenshot](resources/img/icon.png)

## Requirements

This plugin requires Craft CMS 3.0.0-beta.23 or later.

## Installation

To install the plugin, follow these instructions.

1. Add this path to your composer "repositories" in your Craft project:

```
"repositories": [
    {
      "type": "path",
      "url": "../craft-release/",
      "options": {
        "symlink": true
      }
    }
  ],
```

2. Then tell Composer to require the plugin:

```
"require": {
    "craftcms/aws-s3": "1.3.0",
    "dilewe/release": "1.0.0",
    "craftcms/redactor": "2.8.8",
}
```

3. then update with composer
```
composer update
```

4. In the Control Panel, go to Settings → Plugins and click the “Install” button for release.


## Configuring release

You need to configure the Adress of the server in config/general.php, variable "lasubAdministration"

Brought to you by [Digitale-Lernwelten](https://dilewe.de)
