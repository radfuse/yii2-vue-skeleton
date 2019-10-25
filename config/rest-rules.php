<?php

return [
	[
		'class' => 'yii\rest\UrlRule',
		'controller' => "site",
		'pluralize' => false,
		'only' => ['ping', 'login', 'register', 'refresh-token'],
		'extraPatterns' => [
			'GET,OPTIONS ping' => 'ping',
			'POST,OPTIONS login' => 'login',
			'POST,OPTIONS register' => 'register',
			'POST,OPTIONS refresh-token' => 'refresh-token',
		]
	],
];