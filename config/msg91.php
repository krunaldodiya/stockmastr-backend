<?php

return array(

	/* Auth key from msg91  (required) */
	'auth_key' => env('MSG91_KEY', '152885AFVVkzCa591d6b98'),

	/* Default sender id (required) */
	'sender_id' => env('MSG91_SENDER_ID', 'SOCIAL'),

	/* Default route, 1 for promotional, 4 for transactional id (required) */
	'route' => env('MSG91_ROUTE', 4),

	/* Country option, 0 for international, 91 for India, 1 for US (optional) */
	'country' => env('MSG91_COUNTRY', 91),

	/* Credit limit, if true message will be limted to 1 credit (optional) */
	'limit_credit' => env('MSG91_LIMIT_CREDIT', false),

);