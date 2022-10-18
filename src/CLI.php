<?php

namespace Abel\CompressPics;

class CLI
{

	public function compress($args, $assoc_args) {
		if (isset($assoc_args['post']) || isset($assoc_args['image'])) {
			$image_id;

			if (isset($assoc_args['post'])) {
				$image_id = get_post_thumbnail_id($assoc_args['post']);

				if (!$image_id) {
					\WP_CLI::line('This post has no featured image');
					return false;
				}
			} else {
				$image_id = $assoc_args['image'];
			}

			if (!wp_attachment_is_image($image_id)) {
				\WP_CLI::warning($image_id . ' is not an image');

				return false;
			}

			Compressor::compressByID($image_id);
		} elseif (isset($assoc_args['product'])) {
			if (class_exists( 'WooCommerce')) {
				Compressor::compressByProductID($assoc_args['product']);
			} else {
				\WP_CLI::warning('WooCommerce is not active');

				return false;
			}
		} else {
			\WP_CLI::line('Please declare an image or post to compress');
		}
	}
}