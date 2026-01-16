# Sole Dev

A WordPress plugin designed to sanitize and enhance local development environments. Prevents accidental email sends, proxies media files from production, and provides visual indicators to ensure you're always aware you're working in a development environment.

## Features

### 🚫 Email Disabler
Prevents all outgoing emails from being sent in your local development environment. This ensures you never accidentally send test emails to real users or customers.

### 📦 Media Proxy
Automatically replaces local media URLs with production URLs, allowing you to work without maintaining a local copy of `wp-content/uploads/`. This saves disk space and ensures you're always viewing production-quality media.

### ⚠️ Dev Environment Warning
Displays a prominent red warning banner at the bottom of both the WordPress admin and frontend, clearly indicating you're in a development environment.

### 🔗 Link Confirmation
Shows a confirmation dialog when clicking links that point to your production site, preventing accidental navigation away from your development environment. Other external links work normally without confirmation.

## Requirements

- WordPress 5.0 or higher
- PHP 7.4 or higher

## Installation

1. Download or clone this repository into your `wp-content/plugins/` directory
2. Activate the plugin through the WordPress admin 'Plugins' menu

## Configuration

### Automatic Detection

The plugin automatically activates when:
- Your site's hostname contains `.test` (e.g., `mysite.test`)

### Manual Activation

To enable the plugin on non-`.test` domains, add the following to your `wp-config.php`:

```php
define('SOLE_DEV_ENVIRONMENT', true);
```

### Media Proxy Configuration

To enable media proxying, define your production URL and enable the proxy in `wp-config.php`:

```php
define('SOLE_DEV_PROXY_URL', 'https://your-production-site.com');
define('SOLE_DEV_PROXY_ENABLED', true);
```

**Note:** The Media Proxy and Link Confirmation features require both constants to be defined and truthy. If either is missing or false, those features will be disabled.

## Constants

### `SOLE_DEV_ENVIRONMENT`
- **Type:** Boolean
- **Default:** Not defined
- **Description:** Manually enables the plugin on non-`.test` domains. Set to `true` to activate.
- **Location:** `wp-config.php`

### `SOLE_DEV_PROXY_URL`
- **Type:** String (URL)
- **Default:** Not defined
- **Description:** The production site URL used for media proxying and link confirmation. Must be a full URL including protocol (e.g., `https://example.com`).
- **Location:** `wp-config.php`
- **Required for:** Media Proxy and Link Confirmation features

### `SOLE_DEV_PROXY_ENABLED`
- **Type:** Boolean
- **Default:** Not defined
- **Description:** Enables the media proxy and link confirmation features. Must be set to `true` along with `SOLE_DEV_PROXY_URL` for these features to work.
- **Location:** `wp-config.php`
- **Required for:** Media Proxy and Link Confirmation features

## How It Works

### Email Disabler
- Intercepts all `wp_mail()` calls and prevents them from sending
- Clears all recipients from PHPMailer as a secondary safety measure

### Media Proxy
- Filters WordPress attachment URLs, image sources, content URLs, and responsive image srcsets
- Replaces local site URLs with production URLs for all media references

### Dev Environment Warning
- Adds a fixed-position banner at the bottom of all pages
- Automatically adds bottom margin to the body to prevent content from being hidden

### Link Confirmation
- Uses JavaScript to detect clicks on links pointing to the production domain
- Shows a browser confirmation dialog before allowing navigation
- Only affects links to the production site; other external links work normally

## File Structure

```
sole-dev/
├── sole-dev.php              # Main plugin file
├── class-email-disabler.php  # Email disabler module
├── class-media-proxy.php     # Media proxy module
├── class-dev-warning.php     # Dev warning banner module
├── class-link-confirmation.php # Link confirmation module
└── README.md                 # This file
```

## Development

The plugin follows WordPress coding standards and uses a modular class-based architecture for easy maintenance and extensibility.

## License

This plugin is provided as-is for development use.

## Contributing

Contributions are welcome! Please ensure your code follows WordPress coding standards and includes appropriate documentation.

## Changelog

### 1.0.0
- Initial release
- Email disabler functionality
- Media proxy functionality
- Dev environment warning banner
- Link confirmation for production URLs

