# Contao Additional Header Logging Bundle

[![Packagist Version](https://img.shields.io/packagist/v/cgoit/contao-additional-header-logging-bundle.svg)](https://packagist.org/packages/cgoit/contao-additional-header-logging-bundle)
![Dynamic JSON Badge](https://img.shields.io/badge/dynamic/json?url=https%3A%2F%2Fraw.githubusercontent.com%2FcgoIT%2Fcontao-additional-header-logging-bundle%2Fmain%2Fcomposer.json&query=%24.require%5B%22contao%2Fcore-bundle%22%5D&label=Contao%20Version)
[![Downloads](https://img.shields.io/packagist/dt/cgoit/contao-additional-header-logging-bundle.svg)](https://packagist.org/packages/cgoit/contao-additional-header-logging-bundle)
[![CI](https://github.com/cgoIT/contao-additional-header-logging-bundle/actions/workflows/ci.yml/badge.svg)](https://github.com/cgoIT/contao-additional-header-logging-bundle/actions/workflows/ci.yml)

Do you need more insight into incoming requests in your Contao application?
Are you missing specific HTTP headers in your logs for debugging, analytics or security purposes?

This bundle allows you to configure a list of HTTP headers that will be logged in addition to the default Contao log information.

Define the headers you are interested in, and they will automatically be included in your Contao log entries.

Typical use cases include:

- Debugging reverse proxy or CDN setups (e.g. `X-Forwarded-For`, `X-Real-IP`)
- Tracking custom application headers
- Inspecting authentication or API-related headers
- Security analysis and request tracing

## Install

```bash
composer require cgoit/contao-additional-header-logging-bundle
```

## Configuration

Configure the headers under Settings in your Contao Backend.

## Notes

* Header names are case-insensitive.
* Only headers present in the request will be logged.
* Be careful when logging sensitive headers (e.g. authentication tokens).
