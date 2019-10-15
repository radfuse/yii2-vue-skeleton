<?php

return [
	[
		'class' => 'yii\rest\UrlRule',
		'controller' => "site",
		'pluralize' => false,
		'only' => ['ping', 'login', 'register'],
		'extraPatterns' => [
			'GET ping' => 'ping',
			'POST,OPTIONS login' => 'login',
			'POST,OPTIONS register' => 'register',
		]
	],
];