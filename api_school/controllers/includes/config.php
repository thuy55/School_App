<?php
	if (!defined('JATBI')) die("Hacking attempt");
	require_once  'vendor/autoload.php';
	require_once 'database.php';
	require_once 'lang/vi.php';
	require_once 'class.upload.php';
	require_once 'JWT/JWT.php';
	require_once 'xss.php';
	require_once 'function.php';
	require_once 'Mobile_Detect.php';
	require_once 'request.php';
	use Kreait\Firebase\Factory;
	use Kreait\Firebase\Messaging\CloudMessage;
	$factory = (new Factory())->withServiceAccount('controllers/includes/eclo-b31e2-firebase-adminsdk-p8x9r-437d9ea529.json')->withDatabaseUri('https://eclo-b31e2.firebaseapp.com');
	$firebase = $factory->createDatabase();
	$messaging = $factory->createMessaging();
	$jatbi 	  = new jatbi;
	$xss 	  = new jatbi_xss;
	$detect = new Mobile_Detect;
	//* cấu hình cài đặt hệ thống*//
	// $getsetting = $database->get("settings","*",[""]);
	$getsetting = $database->get("settings","*",["school"=>$_SESSION['school']]);
	$setting = (isset($getsetting)) ? [
			"site_url" 		=> 'https://school.hewo.vn/',
			"site_name"		=> $getsetting['name']==''?'Hệ thống quản lý trường học - ECLO':$getsetting['name'],
			"site_manager"	=> 'manager',
			"site_backend"	=> 'templates/backend/',	
			"site_frontend"	=> 'templates/ver2/',
			"site_page"		=> ($_SESSION['page']==''?$getsetting['page']:$_SESSION['page']),
			"site_characters" => $getsetting['characters'],
			"site_date"		=> $getsetting['date'],
			"site_time"		=> $getsetting['time'],
			"site_datetime"	=> $getsetting['datetime'],
			"timework_from"	=> $getsetting['timework_from'],
			"timework_to"	=> $getsetting['timework_to'],
			"secret-key"	=> '19a3d43a4df700dc5d35f6a7a69e5e79d522d91784e66bdaa2fa475731ae0abc31363138323237313233',
			"cookie_time"	=> (3600 * 24 * 30)*12, // 1 năm
			"site_start"    => '2021-01-01',
		] : [
				"site_url" 		=> 'https://school.hewo.vn/',
				"site_name"		=> 'Hệ thống quản lý trường học - ECLO',
				"site_manager"	=> 'manager',
				"site_backend"	=> 'templates/backend/',	
				"site_frontend"	=> 'templates/ver2/',
				"site_page"		=> 10,
				"site_characters" => 2,
				"site_date"		=> date("Y-m-d"),
				"site_time"		=> date("H:i:s"),
				"site_datetime"	=> date("Y-m-d H:i:s"),
				"timework_from"	=> date("H:i:s"),
				"timework_to"	=> date("H:i:s"),
				"secret-key"	=> '19a3d43a4df700dc5d35f6a7a69e5e79d522d91784e66bdaa2fa475731ae0abc31363138323237313233',
				"cookie_time"	=> (3600 * 24 * 30)*12, // 1 năm
				"site_start"    => '2021-01-01',
				];
	
	// info@eclo.vn namnamnam
	// $hanet = [
	// 	"client_id" => '0d46a83f158ab5a690ede7e9f4473346',
	// 	"client_secret" => '9c5187293dfbfbd85b96f573c0ac7ddf',
	// 	"token" => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjUwOTY3Nzg1MTE2NDg4NjU2NTciLCJlbWFpbCI6ImluZm9AZWNsby52biIsImNsaWVudF9pZCI6IjBkNDZhODNmMTU4YWI1YTY5MGVkZTdlOWY0NDczMzQ2IiwidHlwZSI6ImF1dGhvcml6YXRpb25fY29kZSIsImlhdCI6MTY2NjMyNjgyMywiZXhwIjoxNjk3ODYyODIzfQ.9aI78bxTPX9jK61EV-bZGLGNx1AYduaeuNDDdKmhAng',
	// 	"placeID" => '9732',
	// ];
	$school_current=$database->get("school","*",['id'=>$_SESSION['school']]);
	$APIfaceid = [
		//"key" => '2cd3fcc19428d9cf35d54de6f874dc57030adf6519ab3267d0b1701dbf9e935d',
		//"secret" => '42ca878bc69b9fd999edf2a1a6f3deb9fc1e72009435280d63a8ab4b091ee9de',
		"token" => $school_current['token'],
		"place" => $school_current['place'],
	];

	$upload = [
		"images" => [
			"avatar" => [
				"url"		=> "images/accounts/",
				"thumb_y" 	=> "300",
				"thumb_x" 	=> "300",
			],
			"products" => [
				"url"		=> "images/products/",
				"thumb_y" 	=> "300",
				"thumb_x" 	=> "300",
			],
			"personnels" => [
				"url"		=> "images/personnels/",
				"thumb_y" 	=> "500",
				"thumb_x" 	=> "500",
			],
			"customers" => [
				"url"		=> "images/customers/",
				"thumb_y" 	=> "500",
				"thumb_x" 	=> "500",
			],
			"logo" => [
				"url"		=> "images/logo/",
			],
			"datas" => [
				"url"		=> "datas/",
			],
			"social" => [
				"url"		=> "social-data/",
			],
		]
	];
	// định tuyến //
	$TheRouter = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
	$router = [];
	foreach ($TheRouter as $KeyRouter => $varRouter) {
		$router[$KeyRouter] = $varRouter;
	}
	require_once  'main.php';
?>