<?php
namespace Abel\CompressPics;
use ourcodeworld\PNGQuant\PNGQuant;

class Loader
{
	public function __construct() {
		new Hooks();
	}
}