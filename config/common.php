<?php 

return  [
	'pre' => 'jiebei-',
	'redis_keys' => [
		'pre' => 'jiebei:',
		'permission' => [
			'pre' => 'permission:',
			'expire' => 300,		// 5分钟
			'checkManagerHasPermission' => 'checkManagerHasPermission-',
		],
		'token' => [
			'pre' => 'token:',
			'expire' => 3600,
			'tokenSave' => 'tokenSave-',
		],
		'jiekuan' => [
			'pre' => 'jiekuan:',
			'userAccountNotInPlatform' => 'userAccountNotInPlatform-set',
			'addAccountToApplyStatusList' => 'addAccountToApplyStatusList-zset',
		],

	]
];