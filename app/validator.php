<?php
Validator::extend('unique_delete', function($attribute, $value, $parameters)
{
	if (Admin::where('username', $value)->first()) {
		return false;
	}
	return true;
});

Validator::extend('check_slug', function($attribute, $value, $parameters)
{
	$inputSlug = convert_string_vi_to_en($value);
	$inputSlug = strtolower( preg_replace('/[^a-zA-Z0-9]+/i', '-', $inputSlug) );
	if (Type::findBySlug($inputSlug) || TypeNew::findBySlug($inputSlug)) {
		return false;
	}
	return true;
});
