<?php

namespace Abel\CompressPics;

class Compressor
{
	private static $instance = null;

	public static function CompressImage($path) {
		if (!file_exists($path)) {
			error_log($path, ' is not a path.');

			return null;
		}
	}

	public static function getInstance()
	{
		if (self::$instance == null)
		{
			self::$instance = new Compressor();
		}

		return self::$instance;
	}

	public static function compressImage($path) {
		if (!file_exists($path)) {
			error_log($path, ' is not a path.');

			return null;
		}

		$instance = new PNGQuant();
		$path_info = pathinfo($path);
		$dir = $path_info['dirname'];
		$filename = $path_info['filename'];


		$exit_code = $instance->setImage($path)
			->setOutputImage($path)
			->overwriteExistingFile()
			->setQuality(50,80)
			->execute();

		if ($exit_code != 0){
			error_log("Something went wrong (status code $exit_code)  with description: ". $instance->getErrorTable()[(string) $exit_code]);
		}
	}

	public static function onSaveImage($metadata) {
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