<?php defined('SYSPATH') or die('No direct script access.');

return array(
	'email.not_empty'	=> 'Email must be not empty',
	'email.is_unique_email' => 'We have already your :field :value. Mb sign in ;)?',
	'email.email'		=> 'It\'s realy email?', 

	'username.not_empty'	=> 'We realy need know your username',
	'username.min_length'	=> 'Sorry, min length value is :param2',
	'username.max_length'	=> 'Sorry, max length value is :param2',
	'username.regex'	=> 'We need sepcial format of username, for more usability',

	'password.not_empty'	=> 'Input your strong pass',
	'password.min_length'	=> 'Less :param2 chars not secure. Need more',
	'password.max_length'	=> 'Sorry, max length value is :param2',

	'password.is_auth_data' => 'Email + password not matched',
);
