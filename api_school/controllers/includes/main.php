<?php
	use \Firebase\JWT\JWT;
	$jatbi->blockip();
	if(count($_SESSION['csrf'])==0){
		$csrf_token = [
		    "ip" 	=> $xss->xss($_SERVER['REMOTE_ADDR']),
		    "key"  	=> $jatbi->random(255),
		];
		$_SESSION['csrf']['key'] = $csrf_token['key'];
		$_SESSION['csrf']['token'] = JWT::encode($csrf_token, $setting['secret-key']);
	}
	if($_SESSION['assets-token']==''){
		$_SESSION['assets-token'] = $jatbi->random(30);
	}
	if(!empty($_COOKIE['token']) && empty($_SESSION['accounts']['id']) && empty($_SESSION['accounts']['token'])){
		$cookie_token = JWT::decode($_COOKIE['token'], $setting['secret-key'], array('HS256'));
		$cookie_decoded = (array) $cookie_token;
		$accounts_login = $database->get("accounts_login","*",[
			"accounts"	=> $cookie_decoded['id'],
			"token"		=> $cookie_decoded['token'],
			"ip"		=> $cookie_decoded['ip'],
			"agent" 	=> $cookie_decoded["agent"],
			"deleted"	=> 0,
			"ORDER"		=> [
				"id"	=> "DESC",	
			]
		]);
		if($accounts_login>1){
			$_SESSION['accounts'] = [
				"id" 	=> $accounts_login['accounts'],
				"token" => $accounts_login['token'],
				"agent" => $accounts_login['agent'],
			];
			$database->update("accounts_login",["date"=>date("Y-m-d H:i:s")],["id"=>$accounts_login['id']]);
			$jatbi->logs('accounts','login-cookie',$_SESSION['accounts']);
		}
	}
	if (empty($_SESSION['accounts']['id']) && empty($_SESSION['accounts']['token']) && $router[0]!='assets' && $router[0]!='api') {
		include('controllers/core/login.php');
	}
	elseif(!empty($_SESSION['accounts']['id']) && !empty($_SESSION['accounts']['token']) && $router[0]!='assets' && $router[0]!='api') {
		$accounts_check = $database->get("accounts_login","*",[
			"accounts"	=> $_SESSION['accounts']['id'],
			"token"		=> $_SESSION['accounts']['token'],
			"agent" 	=> $_SESSION['accounts']["agent"],
			"deleted"	=> 0,
		]);
		$account = $database->get("accounts","*",[
			"id"		=> $accounts_check['accounts'],
			"status"	=> 'A',
			"deleted"	=> 0,
		]);
		if($account>1){
			
			// thong bao khac //
			$notifications = $database->select("notification","*",["type[!]"=>["task",'proposal','chat','rating',"voted",'rating-completed'],"school"        =>$_SESSION['school'],"accounts"=>$account['id'],"deleted"=>0,"ORDER"=>["id"=>"DESC"],"LIMIT"=>10]);
			$count_notifi = $database->count("notification","*",["type[!]"=>["task",'proposal','chat','rating',"voted",'rating-completed'],"school"        =>$_SESSION['school'],"accounts"=>$account['id'],"deleted"=>0,"views"=>0,]);
			// thong bao tin nhan //
			$notifications_chats = $database->select("notification","*",["type"=>"chat","school"        =>$_SESSION['school'],"accounts"=>$account['id'],"deleted"=>0,"ORDER"=>["id"=>"DESC"],"LIMIT"=>10]);
			$notifi_chat = $database->count("notification","*",["type"=>"chat","accounts"=>$account['id'],"school"        =>$_SESSION['school'],"deleted"=>0,"views"=>0,]);
			// thong bao cong viec //
			$notifications_tasks = $database->select("notification","*",["type"=>["task","rating","voted",'rating-completed'],"school"        =>$_SESSION['school'],"accounts"=>$account['id'],"deleted"=>0,"ORDER"=>["id"=>"DESC"],"LIMIT"=>10]);
			$notifi_task = $database->count("notification","*",["type"=>["task","rating","voted",'rating-completed'],"school"        =>$_SESSION['school'],"accounts"=>$account['id'],"deleted"=>0,"views"=>0,]);
			// thong bao de xuat //
			$notifications_proposals = $database->select("notification","*",["type"=>"proposal","accounts"=>$account['id'],"school"        =>$_SESSION['school'],"deleted"=>0,"ORDER"=>["id"=>"DESC"],"LIMIT"=>10]);
			$notifi_proposal = $database->count("notification","*",["type"=>"proposal","accounts"=>$account['id'],"school"        =>$_SESSION['school'],"deleted"=>0,"views"=>0,]);

			$provinces = $database->select("province","*",["deleted"=>0,"status"=>'A',]);
			// chat //
			$contacts = $database->select("accounts","*",["deleted"=>0,"status"=>'A',"id[!]"=>$account['id'],"ORDER"=>["online"=>"DESC","name"=>"ASC"]]);
			// $infomation = $database->get("personnels","*",["id"=>$account['data']]);
			$getOrgChart = $database->get("org_chart_details","org_chart_main",["user"=>$account['id'],"deleted"=>0]);
			$account_school = $database->select("account_school","*",["accounts"=>$account['id'],"deleted"=>0,"status"=>'A']);
			$account_sch_count = $database->count("account_school","*",["accounts"=>$account['id'],"deleted"=>0,"status"=>'A']);
			

			foreach($account_school as $data){
				$schools[] = $database->get("school","*",["id"=>$data['school'],"deleted"=>0,"status"=>'A']);

			};
			if($account_sch_count==1){
				foreach ($schools as $school){
					$_SESSION['school']=$school['id'];
				}
				
			}
			$date=date("Y-m-d");
        	$course=$database->select("course","*",[
				"school"        =>$_SESSION['school'],
				"status"        =>'A',
				"deleted"       => 0,
        	]);
			foreach($course as $value){
				$date_timestamp = strtotime($date);
				$start_timestamp = strtotime($value['startdate']);
				$end_timestamp = strtotime($value['enddate']);
				
				if ($date_timestamp >= $start_timestamp && $date_timestamp <= $end_timestamp) {
					$class = $database->select("class_diagram", "*",[
						"AND" => [
							'status'        => "A", 
							"deleted"       => 0,
							'course'        => $value['id'],
							"school"=>$_SESSION['school'],
						]
					]);
				}
			}
			foreach($class as $value){
				$count += $database->count("arrange_class",[
					'AND' => [
						"class_diagram"	=> $value['id'],
						"status"		=>"A",
						"deleted"       => 0,
					]]);
			}
			$furlough = $database->select("furlough", "*",[
				"AND" => [
					'status'        => "A", 
					'statu'        => "D", 
					"deleted"       => 0,
					"school"        =>$_SESSION['school'],
				],            
				
			]);
			$student_furlough=0;
			foreach($furlough as $value){
				$date_timestamp = strtotime($date);
				$start_timestamp = strtotime($value['date_start']);
				$end_timestamp = strtotime($value['date_end']);
				if ($date_timestamp >= $start_timestamp && $date_timestamp <= $end_timestamp) {
					$student_furlough +=1;
				}
			}
			$student = $database->select("students", "*",[
				"AND" => [
					'status'        => "A", 
					"deleted"       => 0,
					"school"        =>$_SESSION['school'],
				],            
			]);
			$student_number =0;
			foreach($student as $value){
				$date_timestamp = date('m');
				$year_of_admission = date('m', strtotime($value['year_of_admission']));
				$date_timestamp_y = date('Y');
				$year_of_admission_y = date('Y', strtotime($value['year_of_admission']));
				
				if ($date_timestamp ==$year_of_admission && $date_timestamp_y ==$year_of_admission_y) {
					$student_number +=1;
				}
			}
			$tuition = $database->select("tuition", "*",[
				"AND" => [
					'status'        => "A", 
					"deleted"       => 0,
					"school"        =>$_SESSION['school'],
				],            
			]);

			$tuition_number =0;
			foreach($tuition as $value){
				$date_timestamp = date('m');
				$year_of_admission = date('m', strtotime($value['date']));
				$date_timestamp_y = date('Y');
				$year_of_admission_y = date('Y', strtotime($value['date']));
				
				if ($date_timestamp ==$year_of_admission && $date_timestamp_y ==$year_of_admission_y) {
					$tuition_number +=1;
					$student_tution[]=$database->get("arrange_class","id",[
						"school"        =>$_SESSION['school'],
						"id"=>$value['arrange_class'],
						"status"        =>'A',
						"deleted"       => 0,
					]);
				}
			}
			foreach($class as $value){
				$count_tu_stu += $database->count("arrange_class",[
						'AND' => [
							"class_diagram"	=> $value['id'],
							"id[!]"=>$student_tution,
							"status"		=>"A",
							"deleted"       => 0,
						]]);
			}
			
			$purchase= $database->select("purchase", "*",[
				"AND" => [
					"type"			=>[1,3],
					"deleted"       => 0,
					"school"        =>$_SESSION['school'],
				],            
			]);
			$purchase_number =0;
			foreach($purchase as $value){
				$date_timestamp = date('m');
				$year_of_admission = date('m', strtotime($value['date']));
				$date_timestamp_y = date('Y');
				$year_of_admission_y = date('Y', strtotime($value['date']));
				
				if ($date_timestamp ==$year_of_admission && $date_timestamp_y ==$year_of_admission_y) {
					$purchase_number +=1;
				}
			}
			$allergy = $database->select("allergy", "*",[
				"AND" => [
				
					'status'        => "A", 
					"deleted"       => 0,
					"school"        =>$_SESSION['school'],
				],            
				
			]);
			foreach ($request as $key => $menus) {
				$main_names[$key]["name"] = $menus['name'];
				foreach ($menus['item'] as $key_item => $item) {
					if($item['hidden']=='false'){	
						if(!empty($item['sub'])){
							$main_names[$key]['items'][$key_item]["menu"]	= $item['menu'];
							$main_names[$key]['items'][$key_item]["url"]	= $item['url'];
							$main_names[$key]['items'][$key_item]["main"]	= $item['main'];
							$main_names[$key]['items'][$key_item]["icon"]	= $item['icon'];
							foreach ($item['sub'] as $sub_key => $subs) {
								if($jatbi->permission($sub_key,'button')=='true') {
									$main_names[$key]['items'][$key_item]["sub"][$sub_key]=$subs;
								}
							}
							if(empty($main_names[$key]['items'][$key_item]["sub"])){
								unset($main_names[$key]['items'][$key_item]);
							}
						}
						else {
							if($jatbi->permission($key_item,'button')=='true') {
								$main_names[$key]['items'][$key_item]["menu"]	= $item['menu'];
								$main_names[$key]['items'][$key_item]["url"]	= $item['url'];
								$main_names[$key]['items'][$key_item]["icon"]	= $item['icon'];
							}
						}
						$controllers[$key_item] = $item['controllers'];
						$request_permissions[$key_item] = $item;
					}
				}
			}
			
			$furloughss = $database->count("furlough",[
				"AND" => [
					'status'        => "A", 
					'statu'        => "A", 
					"deleted"       => 0,
					"school"        =>$_SESSION['school'],
				],            
				
			]);
			$student_register_car = $database->count("student_register_car",[
				"AND" => [
					'status'        => "A", 
					'statu'        => "A", 
					"deleted"       => 0,
					"school"        =>$_SESSION['school'],
				],            
				
			]);
			if(array_key_exists($router['0'], $controllers)) {
	            include($controllers[$router['0']]);
	        } else {
	            include($controllers['']);
	        }
	        if($ajax!='true'){
				include($setting['site_backend']."home.tpl");
			}
			else {
				include($templates);
			}
		}
		else {
			unset($_SESSION['accounts']);
			unset($_SESSION['school']);
			unset($_SESSION['csrf']);
			unset($_COOKIE['token']);
			setcookie('token','', time()-$setting['cookie_time'],"/");
			header("location: /");
		}
	}
	elseif($router[0]=='assets'){
		include('controllers/includes/assets.php');
	}
	elseif($router[0]=='api'){
		include('controllers/api/api.php');
	}
	elseif($router[0]=='manager'){
		include('controllers/core/login.php');
	}
	else {
		die();
	}
?>