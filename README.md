# Guardian Plugin

This plugin protects the admin section by requiring a key when first accessing
the URL.

## Installation

- Download and extract as `APP/Plugin/Guardian`.
- Activate plugin by running: `Console/cake ext activate plugin Guardian` or
  via the Extensions page
- Optional: Change the generated key

Make sure to record the URL in the plugin activation message as the admin area
will not be accessible without the key is missing from the URL.
