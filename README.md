# CompressPics

A Wordpress plugin to compress png-images.

## Requirements

An Ubuntu server with [pngquant](https://pngquant.org/) installed.

## Hooks

CompressPics hooks into `wp_generate_attachment_metadata` to compress the images once they're saved or updated. Once ResponsivePics resized the images and `responsive_pics_file_saved_local` fires, CompressPics will compress the newly generated images.

## CLI

It is possible to force a compression through the WP CLI through a set of commands.

To compress the featured image of a post you can insert the post id:
`wp cpics compress --post=<POST_ID>`

To specify which image to compress you can insert the image id:
`wp cpics compress --image=<IMAGE_ID>`

In order to compress all images asociated to a product and its variations insert the product id:
`wp cpics compress --product=<PRODUCT_ID>`