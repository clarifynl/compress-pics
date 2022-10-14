<?php

namespace Abel\CompressPics;

class Hooks
{
	public function __construct() {
		add_filter('wp_generate_attachment_metadata', ['Abel\CompressPics\Compressor', 'onSaveImage'], 10, 3);

		if (class_exists('ResponsivePics')) {
			add_action('responsive_pics_file_saved_local', ['Abel\CompressPics\Compressor', 'onRPicsSaved'], 10, 3);
		}
	}
}