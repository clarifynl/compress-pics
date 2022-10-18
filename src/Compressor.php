<?php

namespace Abel\CompressPics;
use ourcodeworld\PNGQuant\PNGQuant;

class Compressor
{
	private static $instance = null;

	public static function getInstance()
	{
		if (self::$instance == null)
		{
			self::$instance = new Compressor();
		}

		return self::$instance;
	}

	public static function compressByProductID($product_id) {
		if ( defined( 'WP_CLI' ) && WP_CLI ) {
			\WP_CLI::line('compress product id: ' . $product_id);
		}

		$post_type = get_post_type($product_id);

		if ($post_type != 'product') {
			if ( defined( 'WP_CLI' ) && WP_CLI ) {
				\WP_CLI::warning($product_id . ' is not a product');
			}

			return false;
		}

		global $product;

		$product = wc_get_product($product_id);
		$is_variable = $product->is_type('variable');
		if ($is_variable) {
			$variations = $product->get_available_variations();

			$images_ids = [];
			foreach ($variations as $variation) {
				$product_variation = new \WC_Product_Variation($variation['variation_id']);

				$images_ids []= $product_variation->get_image_id();
			}

			$unique_images = array_unique($images_ids);

			foreach ($unique_images as $image) {
				self::compressByID($image);
			}
		}

		return true;
	}

	public static function compressByID($image_id) {
		$sizes = get_intermediate_image_sizes();
		$path = get_attached_file($image_id, true);

		$path_info = pathinfo($path);
		$dir = $path_info['dirname'];

		foreach ($sizes as $size) {
			$src = wp_get_attachment_image_src($image_id, $size)[0];
			$filename = pathinfo($src)['basename'];
			$path = $dir . '/' . $filename;

			$is_compressed = self::compressImage($path);

			if ( defined( 'WP_CLI' ) && WP_CLI ) {
				if ($is_compressed) {
					\WP_CLI::success('Compressed image: ' . $path);
				} else {
					\WP_CLI::warning('Compress failed for file:  ' . $path);
				}
			}
		}
	}

	public static function compressImage($path) {
		if (!file_exists($path)) {
			if ( defined( 'WP_CLI' ) && WP_CLI ) {
				\WP_CLI::warning($path . ' is not a path.');
			}

			return false;
		}
		syslog(LOG_DEBUG, 'compression triggered for image: ' . $path);

		$instance = new PNGQuant();
		$path_info = pathinfo($path);
		$dir = $path_info['dirname'];
		$filename = $path_info['filename'];

		if ($path_info['extension'] != 'png') {
			return false;
		}

		$exit_code = $instance->setImage($path)
		->skipIfLarger()
		->setOutputImage($path)
		->overwriteExistingFile()
		->setQuality(50,80)
		->execute();


		if ($exit_code != 0){
			error_log("Something went wrong (status code $exit_code)  with description: ". $instance->getErrorTable()[(string) $exit_code]);

			return false;
		} else {
			syslog(LOG_DEBUG, 'pngquant compressed image: ' . $path);

			return true;
		}
	}

	public static function onSaveImage($metadata, $id, $context) {
		$path = get_attached_file($id);
		$path_info = pathinfo($path);
		$image_dir = $path_info['dirname'];

		if ($path_info['extension'] == 'png') {
			self::compressImage($path);

			foreach ($metadata['sizes'] as $size => $value) {
				$size_path = $image_dir . '/' . $value['file'];
				self::compressImage($size_path);
			}
		}

		return $metadata;
	}

	public static function onRPSaved ($post_id, $file) {
		if ($file['mime-type'] == 'image/png') {
			self::compressImage($file['path']);
		}
	}
}