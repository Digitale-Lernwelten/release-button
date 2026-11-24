# Release button for Craft CMS 5

A control panel button that sends a signed release webhook.

## Requirements

- Craft CMS 5
- PHP 8.2 or newer

## Installation

Once version 3.0.0 is tagged, install the plugin with Composer and enable it in **Settings → Plugins**:

```sh
composer require dilewe/release:^3.0
php craft plugin/install release
```

For a local checkout, add it as a Composer path repository in the Craft project before running `composer require`:

```json
{
  "repositories": [
    { "type": "path", "url": "../release-button", "options": { "symlink": true, "versions": { "dilewe/release": "3.0.0" } } }
  ]
}
```

## Configuration

Set these environment variables in the Craft project (for example, in `.env`):

```dotenv
CRAFT_RELEASE_URL="https://example.com/release-webhook"
CRAFT_RELEASE_SECRET="replace-with-a-secret"
```

The URL must use HTTPS. The plugin sends `{"action":"released"}` as JSON with an `X-Hub-Signature` header containing the hex-encoded HMAC-SHA1 of that exact JSON payload, signed with `CRAFT_RELEASE_SECRET`. The secret remains on the server.

Grant users the **Access Release** (`accessPlugin-release`) and **Veröffentlichen** (`deployment`) permissions. The navigation item is visible only to users with both permissions. The page and action require both permissions.

The button reports whether the webhook accepted the request; it does not wait for an external deployment to finish.

## Upgrading from Craft 4

Upgrade the Craft project to Craft 5 and PHP 8.2 before installing version 3 of this plugin. Keep the plugin handle `release` so existing user permissions are retained. The webhook environment variables and signed payload are unchanged from version 2.

For Craft 4 projects, continue using `"dilewe/release": "^2.0"`. Install `"dilewe/release": "^3.0"` after upgrading the project and its other plugins to Craft 5. Do not use `dev-master` for deployed projects; it follows the current branch instead of a stable release.

## Upgrading from Craft 3

Version 2 requires Craft 4. Keep the plugin handle `release` when upgrading so existing user permissions can be retained. Move webhook settings to `CRAFT_RELEASE_URL` and `CRAFT_RELEASE_SECRET` if they were previously provided through Twig aliases or other configuration.

For Craft 3 projects, use the last Craft 3 release (`"dilewe/release": "^1.2.1"`). Upgrade the project and its other plugins to Craft 4 with version 2 of this plugin, then upgrade to Craft 5 with version 3.
