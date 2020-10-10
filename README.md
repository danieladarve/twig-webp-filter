# Twig Webp Filter plugin for Craft CMS 3.x

Returns an Object containing webp and img data

## Requirements

This plugin requires Craft CMS 3.5 or later.

## Installation

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:

        cd /path/to/project

2. Then tell Composer to load the plugin:

        composer require danieladarve/twig-webp-filter

3. In the Control Panel, go to Settings → Plugins and click the “Install” button for Twig Webp Filter.

## Twig Webp Filter Overview

Accepts an instance of craft\elements\Asset
``{% set imageObject = webp(image.one()) %}``

Brought to you by [Daniel G Adarve](https://github.com/danieladarve)
