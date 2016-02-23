<?php
class Slider
{
	public static function getStatusSliderOption($input)
	{
		if ($input == DISABLED) {
			return 'Ẩn';
		}
		if ($input == ENABLED) {
			return 'Hiển thị';
		}

	}
}