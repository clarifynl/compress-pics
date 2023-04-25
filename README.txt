# CompressPics

A Wordpress plugin to compress png-images.

## Requirements

An Ubuntu server with [pngquant](https://pngquant.org/) installed.

## Hooks

CompressPics hooks into `wp_generate_attachment_metadata` to compress the images once they're saved or updated. Once ResponsivePics resized the images, CompressPics will compress the newly generated images.
