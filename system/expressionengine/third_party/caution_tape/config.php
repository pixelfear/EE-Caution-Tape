<?php

/**
 * Basic Config
 *
**/
$config['enabled'] = 'yes';  // 'yes' or 'no'
$config['align'] = 'right';   // 'right', 'left', or 'center'


/**
 *	If you ARE using Focus Lab's Master Config Bootstrap,
 *	make sure to add:
 *  define('ENV_SHOW_TAPE', TRUE);
 *  to each environment's case statement.
 *
 *	If you are NOT using Focus Lab's Master Config Bootstrap,
 *	uncomment and modify the array below to match your
 *  intended environment setup.
**/

/*
$config['method'] = "http_host"; // 'http_host'

$config['environments'] = array(
	'sandbox.live' => array(
		'label' => 'Production',
		'show'  => false
	),
	'development' => array(
		'label' => 'Development',
		'show'  => true
	)
);
*/