<?php

namespace Abel\CompressPics;

class Hooks
{
	public function __construct() {
		echo 'hooks started';
		exit();
		// add_filter('wp_generate_attachment_metadata', function ($metadata, $id, $context) {
		// 	$path = get_attached_file($id);
		// 	$path_info = pathinfo($path);
		// 	$image_dir = $path_info['dirname'];

		// 	if ($path_info['extension'] == 'png') {
		// 		compress_image($path);

		// 		foreach ($metadata['sizes'] as $size => $value) {
		// 			$size_path = $image_dir . '/' . $value['file'];
		// 			compress_image($size_path);
		// 		}
		// 	}

		// 	return $metadata;
		// }, 10, 3);
	}
}