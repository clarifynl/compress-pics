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
			self::$instance = new Singleton();
		}

		return self::$instance;
	}
}