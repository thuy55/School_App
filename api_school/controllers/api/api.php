<?php
if (!defined('JATBI'))
	die("Hacking attempt");
use \Firebase\JWT\JWT;

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Credentials: true");

header("Access-Control-Expose-Headers: FooBar");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Authorization");
//header("Access-Control-Allow-Headers: Origin,Content-Type ");
header("Content-Type:application/json ");

$input = @file_get_contents("php://input");
$data = json_decode($input, true);
 

if (count($data) == 0) {
	echo json_encode(['status' => 'error', 'content' => 'Lỗi dữ liệu']);
} else {
	if($router['1'] == 'login') {
		if (isset($data['phone_number'])) {
			$parent = $database->get("parent", '*', [
				"AND" => [
					"phone_number" => $data['phone_number'],
					"status" => 'A',
					"deleted" => 0,
				]
			]);
			$check = crypt($xss->xss($data['password']), $parent['password']);
			if ($parent > 1 && $xss->xss($data['phone_number']) != '') {
				if ($check === $parent['password']) {
					$payload = [
						"phone_number" => $parent['phone_number'],
						"accounts" => $parent['id'],
						"agent" => $_SERVER['HTTP_USER_AGENT'],
						"date" => date('Y-m-d H:i:s'),
						"identify" => $jatbi->active(32),
					];
					$school = $database->select("school_parent", '*', [
				    "AND" => [
					"parent" =>$parent['id'],
					"status" => 'A',
					"deleted" => 0,
						]
					]);
					foreach($school as $news){
					$device_parent = $database->get("device_parent", '*', [
				    "AND" => [
					"parent" =>$parent['id'],
					"device_id"=>$xss->xss($data['device_id']),
					"school"=>$news['school'],
					"status" => 'A',
					"deleted" => 0,
						]
					]);
					if($device_parent==null && $data['device_id']!=null){
						$insert = [
						"parent" => $parent['id'],
						"device_id"=>$xss->xss($data['device_id']),
						"school"=>$news['school'],
						"status" => 'A',
						"deleted" => 0,
						
					];
					$database->insert("device_parent", $insert);
					$jatbi->logs('device_parent', 'add', $insert);
					//echo json_encode(['status' => 'success', 'device_parent' => $insert]);
					}
				}


					$token = JWT::encode($payload, $setting['secret-key']);
					$database->insert("payload", $payload);
					echo json_encode(['status' => 'success', "content" => "Đăng nhập thành công", "token" => $token, "parent" => $parent['name'], "phone_number" => $parent['phone_number']]);
				} else {
					echo json_encode(['status' => 'error', "content" => "Mật khẩu không đúng"]);
				}
			}
			 elseif ($xss->xss($_POST['phone_number']) == '' || $xss->xss($_POST['password']) == '') {
				echo json_encode(['status' => 'error', "content" => "Vui lòng không để trống"]);
			}
			 else {
				echo json_encode(['status' => 'error', "content" => "Số điện thoại không đúng"]);
			}
		}
	} elseif ($router['1'] == 'register_school'){
		$count_taxcode = $database->count("school",[
            'AND' => [
            	"tax_code"  	=> $xss->xss($data['taxcode']),
            	"status"        => 'A',  
            	"deleted"       => 0,
            ]
        ]);
	    $accounts = $database->get("accounts","id",[
	        'AND' => [
	            	"phone"  	=> $xss->xss($data['phone']),
	            	"account"  	=> $xss->xss($data['account']),
	            	"email" 	=> $xss->xss($data['email']),
	            	"status"        => 'A',  
	            	"deleted"       => 0,
	        ]
	    ]);
        if($count_taxcode>0){
        	echo json_encode(['status' => 'error', 'content' =>"Mã số thuế đã tồn tại"]);
	    }
	    elseif($accounts && !password_verify($xss->xss($data['password']), $accounts['password'])){
	    	echo json_encode(['status' => 'error', 'content' =>"Email đã tồn tại"]);
	    }
	    else{
	    	$insert_school = [
		        "name"	=>$xss->xss($data['name_school']),
		        "phone_number"	=>$xss->xss($data['phone_number']),
		        "address"	=>$xss->xss($data['address_school']),
		        "id_school"=>$xss->xss($data['id_school']),
		        "email"	=>$xss->xss($data['email_school']),
		        "website"	=>$xss->xss($data['website_school']),
		        "tax_code"	=>$xss->xss($data['taxcode']),
		        "status"=>"A",
		        "deleted"=>0,	
	        ];
		    $database->insert("school", $insert_school);
		    $school_id = $database->id(); 
	        $count = $database->count("accounts",[
	            'AND' => [
	            	"phone"  	=> $xss->xss($data['phone']),
	            	"account"  	=> $xss->xss($data['account']),
	            	"email" 	=> $xss->xss($data['email']),
	            	"status"        => 'A',  
	            	"deleted"       => 0,
	            ]
	        ]);
	        $checkaccount = $database->get("accounts", "*",["account"=>$jatbi->checkaccount($data['account']),"deleted"=>0]);
	        if($count>0 && $school_id !=''){
	            $insert_register = [
	            		"accounts"=> $accounts,
	            		"school"=> $school_id,
	            		"status"=>'A',
	            ];
		        $database->insert("account_school",$insert_register);
		        $jatbi->logs('account_school','add',$insert_register);
		        echo json_encode(['status' => 'success', 'content' =>"Thêm trường học thành công","ab"=>$insert_register,"abd"=>$insert_school]);
	        }
	        if($count==0 && $school_id !=''){
	            if ($data['name'] && $data['email']) {
	            	$insert = [
	            		"main" 			=> 0,
	            		"name" 			=> $xss->xss($data['name']),
	            		"email" 		=> $xss->xss($data['email']),
	            		"account" 		=> $xss->xss($data['account']),
	            		"phone" 		=> $xss->xss($data['phone']),
	            		"password" 		=> password_hash($xss->xss($data['password']), PASSWORD_DEFAULT),
	            		"permission" 	=> 1,
	            		"data" 			=> 1,
	            		"type" 			=> 1,
	            		"active"		=> $jatbi->active(32),
	            		"avatar"		=> '',
	            		"birthday"		=> date('Y-m-d',strtotime(str_replace('/','-',$data['birthday']))),
	            		"gender"		=> '',
	            		"date" 			=> date('Y-m-d H:i:s'),
	            		"status" 		=> 'A',
	            	];
	            	$database->insert("accounts",$insert);
	            	$tui = $database->id();
	            	$insert_register = [
	            		"accounts"=> $tui,
	            		"school"=> $school_id,
	            		"status"=>'A',
	            	];
	            	$database->insert("account_school",$insert_register);
	            	$jatbi->logs('account_school','add',$insert_register);
	            	$jatbi->logs('accounts','add',$insert);
	            	echo json_encode(['status' =>'success', 'content' =>"Thêm thành công","ab"=>$insert ,"abd"=>$insert_school ,"abc"=>$insert_register ]);
	            }
	        }
	    } 
    } elseif ($router['1'] == 'add_file_lesson_plan_teacher') {
		   $getToken = $xss->xss($data['token']);
			$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
			$decoded_token = (array) $token;
			$payload = $database->get("payload", "*", [
				"phone_number" => $decoded_token['phone_number'],
				"accounts" => $decoded_token['accounts'],
				"agent" => $decoded_token['agent'],
				"date" => $decoded_token['date'],
				"identify" => $decoded_token['identify'],
			]);
			 if ($payload>1) {
			// $handle = new Upload($_FILES['avatar']);
			// if($handle->uploaded){
		    //   $handle->allowed= array('application/*', 'image/*');
		    //    $handle->Process($upload['images']['avatar']['url']);
			//     }
			  //  if ($handle->processed && $_POST['title']) {
	        //    $img=$setting['site_url'].$upload['images']['avatar']['url'].$handle->file_dst_name;
						$insert = [
							"title" =>  $data['title'],
							"file" => $data['avatar'],
							"teacher" =>$payload['accounts'],
							"status" => 'A',
							"name"=>$filename = basename($data['avatar']),
							"date_post"=>date('Y-m-d'),
							"deleted" => 0,
							
						];
						$database->insert("lesson_plan", $insert);
						$jatbi->logs('lesson_plan', 'add', $insert);
						echo json_encode(['status' => 'success', 'lesson_plan' => $insert]);
			 // }

		} else {
			 echo json_encode(['status' => 'error', 'content' => 'error']);
		}
    } elseif ($router['1'] == 'parent'){
			$getToken = $xss->xss($data['token']);
			$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
			$decoded_token = (array) $token;
			$payload = $database->get("payload", "*", [
				"phone_number" => $decoded_token['phone_number'],
				"accounts" => $decoded_token['accounts'],
				"agent" => $decoded_token['agent'],
				"date" => $decoded_token['date'],
				"identify" => $decoded_token['identify'],
			]);
		if ($payload > 1) {
				$parents = $database->select("parent", '*', [
					"AND" => [
						"id" => $payload['accounts'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$parent = $database->get("parent", '*', [
					"AND" => [
						"id" => $payload['accounts'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$ward = $database->select("ward", "*", [
					"AND" => [
						"id" => $parent['ward'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$province = $database->select("province", "*", [
					"AND" => [
						"id" => $parent['province'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$district = $database->select("district", "*", [
					"AND" => [					"id" => $parent['district'],
					"status" => 'A',
					"deleted" => 0,
				]
			]);
				echo json_encode(['status' => 'success', 'content' => $parents, 'ward' => $ward, 'province' => $province, 'district' => $district]);
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'school-list') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			$parents = $database->get("parent", '*', [
				"AND" => [
					"id" => $payload['accounts'],
					"status" => 'A',
					"deleted" => 0,
				]
			]);
			$school_parent = $database->select("school_parent", '*', [
				"AND" => [
					"parent" => $parents['id'],
					"status" => 'A',
					"deleted" => 0,
				]
			]);
			foreach ($school_parent as $data) {
				$school[] = $database->get("school", "*", [
					"AND" => [
						"id" => $data['school'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
			}
			// $school= $database->select("school","*",["AND"=>["id"=>$school_parent['school'],"status" 	=> 'A',
			//  	"deleted"	=> 0,]]);
			echo json_encode(['status' => 'success', 'content' => $school]);
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'students-list') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']) {
				$parents = $database->get("parent", '*', [
					"AND" => [
						"id" => $payload['accounts'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$students = $database->select("students", "*", [
					"AND" => [
						"school" => $router['2'],
						"parent" => $parents['id'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$school = $database->select("school", "*", [
					"AND" => [
						"id" => $router['2'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				echo json_encode(['status' => 'success', 'content' => $students,'school'=>$school]);
			}
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'student_class') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			$parents = $database->get("parent", '*', [
				"AND" => [
					"id" => $payload['accounts'],
					"status" => 'A',
					"deleted" => 0,
				]
			]);
			$parent = $database->select("parent", '*', [
				"AND" => [
					"id" => $payload['accounts'],
					"status" => 'A',
					"deleted" => 0,
				]
			]);
			if ($parents > 1) {
				if ($router['2']) {
					$students = $database->select("students", "*", [
						"AND" => [
							"id" => $router['2'],
							"parent" => $parents['id'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					$getStudent = $database->get("students", "*", [
						"AND" => [
							"id" => $router['2'],
							"parent" => $parents['id'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					// $date = date("Y-m-d");
				    // $timestamp = strtotime($date);
				    //  $course = $database->select("course", "*", [
					//     "AND" => [
					//         "startdate[<]"=>$date,
					//         "enddate[>]"=>$date,
					//         "status" => 'A',
					// 	    "deleted" => 0,
					//     ]
					// ]); 
				     
					$arrange_class = $database->select("arrange_class", "*", [
					    "AND" => [
					        "students" => $getStudent['id'],
					        "school" => $getStudent['school'],
					        "status" => 'A',
					        "deleted" => 0,
					    ]
					]);
					foreach($arrange_class as $arrange_class2){
						$class_diagram= $database->get("class_diagram", "*", [
						"AND" => [
							"id" => $arrange_class2['class_diagram'],
							"school" => $getStudent['school'],
							
							"status" => 'A',
							"deleted" => 0,
						]
					]);
						$class_diagram_2[]=$class_diagram;
					}

					foreach($class_diagram_2 as $class_diagram_3){
						$class2 = $database->get("class", "*", [
						"AND" => [
							"id" => $class_diagram_3['class'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
						$class[]=[
							"id_class_diagram"=>$class_diagram_3['id'],
							"name"=>$class2['name']
						];

					}
					
							echo json_encode(['status' => 'success', 'class' =>$class ]);
					
				}
			}
		} else {
			echo json_encode(['status' => 'error', 'content' => 'Không thể kết nối đến server',]);
		}
	} elseif ($router['1'] == 'students') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			$parents = $database->get("parent", '*', [
				"AND" => [
					"id" => $payload['accounts'],
					"status" => 'A',
					"deleted" => 0,
				]
			]);
			$parent = $database->select("parent", '*', [
				"AND" => [
					"id" => $payload['accounts'],
					"status" => 'A',
					"deleted" => 0,
				]
						]);
			if ($parents > 1) {
				if ($router['2']) {
					$students = $database->select("students", "*", [
						"AND" => [
							"id" => $xss->xss($data['id_student']),
							"parent" => $parents['id'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					$getStudent = $database->get("students", "*", [
						"AND" => [
							"id" => $xss->xss($data['id_student']),
							"parent" => $parents['id'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					
					$class_diagram = $database->get("class_diagram", "*", [
						"AND" => [
							"id" => $router['2'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					$class = $database->select("class", "*", [
						"AND" => [
							"id" => $class_diagram['class'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					
					$classroom = $database->select("classroom", "*", [
						"AND" => [
							"school" => $getStudent['school'],
							"id" => $class_diagram['classroom'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					$ward = $database->select("ward", "*", [
						"AND" => [
							"id" => $getStudent['ward'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					$province = $database->select("province", "*", [
						"AND" => [
							"id" => $getStudent['province'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					$district = $database->select("district", "*", [
						"AND" => [
							"id" => $getStudent['district'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					$priority_object = $database->select("priority_object", "*", [
						"AND" => [
							"id" => $getStudent['priority_object'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					$school = $database->select("school", "*", [
						"AND" => [
							"id" => $getStudent['school'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					$nationality = $database->select("nationality", "*", [
						"AND" => [
							"id" => $getStudent['nationality'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					$ethnic = $database->select("ethnic", "*", [
						"AND" => [
							"id" => $getStudent['ethnic'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					$religion = $database->select("religion", "*", [
						"AND" => [
							"id" => $getStudent['religion'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					$arrange_class = $database->get("arrange_class", "*", [
						"AND" => [
							"class_diagram" => $router['2'],
							"students" => $xss->xss($data['id_student']),
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					$ht=date('Y-m-d');
					$semester = $database->get("semester", "*", [
						"AND" => [
							"course" => $class_diagram['course'],
							"startdate[<=]" => $ht,
							"enddate[>=]" => $ht,
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					$student_register_car = $database->get("student_register_car", "*", [
						"AND" => [
							
							"arrange_class" => $arrange_class['id'],
							"semester"=>$semester['id'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
				    $car_schedule_detail = $database->select("car_schedule_detail", "*", [
						"AND" => [
							"student_register_car" => $student_register_car['id'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);

					foreach($car_schedule_detail as $value){
						$car_schedule_new= $database->get("car_schedule", "*", [
						"AND" => [
							"id" => $value['car_schedule'],
							"date"=>$ht,
							"status" => 'A',
							"deleted" => 0,
						]
					]);
						if ($car_schedule_new!=null) {
							$car_schedule=$car_schedule_new;
						}
					}
					$route=$database->get("route" , "*",[
						"AND" => [
						"id" =>$car_schedule['route'],
						"status" => "A",
						"deleted" => 0,
						]
					]);

					$car = $database->select("car", "*", [
						"AND" => [
							"id"=>$car_schedule['car'],
							"status" => "A",
							"deleted" => 0,
						]
					]);	
					$driver = $database->select("driver", "*", [
						"AND" => [
							"id"=>$car_schedule['driver'],
							"status" => "A",
							"deleted" => 0,
						]
					]);
						$teacher_announcement = $database->count("teacher_announcement", [
						"AND" => [
							// "school" => $students['school'],
							"view"=>0,
							"class_diagram" => $router['2'],
							"status" => 'A',
							"deleted" => 0,
						]
						]);
						$course=$database->get("course" , "*",[
					    "AND" => [
						"id"=>$class_diagram['course'],
						"status" => 'A',
						"deleted" => 0,
				     	]
				     ]);
						$school_announcement = $database->count("school_announcement", [
						"AND" => [
							"school" => $class_diagram['school'],
							"view"=>0,
							"date[<>]"=>[$course['startdate'],$course['enddate']],
							"status" => 'A',
							"deleted" => 0,
						]
						]);
						$furlough = $database->get("furlough", "*", [
							"AND" => [
								"arrange_class"=>$arrange_class['id'],
								"status" => 'A',
								"deleted" => 0,
							],
							"ORDER" => [
								"id"=>"DESC",
							]
						]);
						$student_register_car2 = $database->get("student_register_car", "*", [
							"AND" => [
								"arrange_class"=>$arrange_class['id'],
								"semester"=>$semester['id'],
								"status" => 'A',
								"deleted" => 0,
							],
							"ORDER" => [
								"id"=>"DESC",
							]
						]);

						if($furlough['count']==1 && $furlough['statu']=='D' ){
							// echo json_encode(['Xin nghỉ phép của bạn đã được duyệt']);
							$update=['count'=>3];
							$database->update("furlough", $update,["id"=>$furlough['id']]);
				            $jatbi->logs('furlough', 'update', $update);


						}
						if($furlough['count']==2 && $furlough['statu']=='C' ){
							// echo json_encode(['Xin nghỉ phép của bạn đã được duyệt']);
							$update=['count'=>3];

							$database->update("furlough", $update,["id"=>$furlough['id']]);
				            $jatbi->logs('furlough', 'update', $update);


						}

						if($student_register_car2['count']==1 && $student_register_car2['statu']=='D' ){
							// echo json_encode(['Xin nghỉ phép của bạn đã được duyệt']);
							$update=['count'=>3];

							$database->update("student_register_car", $update,["id"=>$student_register_car2['id']]);
				            $jatbi->logs('student_register_car', 'update', $update);


						}
						if($student_register_car2['count']==2 && $student_register_car2['statu']=='C' ){
							// echo json_encode(['Xin nghỉ phép của bạn đã được duyệt']);
							$update=['count'=>3];

							$database->update("student_register_car", $update,["id"=>$student_register_car2['id']]);
				            $jatbi->logs('student_register_car', 'update', $update);


						}
						$timekeeping=$database->get("timekeeping" , "*",[
							"AND" => [
								"date"=>$date=date('Y-m-d'),
								"arrange_class"=>$arrange_class['id'],
								//"school"=>$data2['school'],

							]
						]);

							//echo json_encode(['status' => 'success', 'car' => $getStudent]);
					echo json_encode(['status' => 'success','route'=>$route['name'], 'car' =>$car,'driver' => $driver, 'parent' => $parent, 'content' => $students, 'class' => $class, 'ward' => $ward, 'province' => $province, 'district' => $district, 'classroom' => $classroom, 'priority_object' => $priority_object, 'school' => $school, 'nationality' => $nationality, 'ethnic' => $ethnic, 'religion' => $religion,'count_teacher'=>$teacher_announcement,'count_school'=>$school_announcement,'furlough'=>intval($furlough['count']),'student_register_car'=>intval($student_register_car2['count']),'timekeeping'=>$timekeeping]);
				}
			}
		} else {
			echo json_encode(['status' => 'error', 'content' => 'Không thể kết nối đến server',]);
		}
	} elseif ($router['1'] == 'teacher-class') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']) {
				$students = $database->get("students", "*", [
					"AND" => [
						"id" => $router['2'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				
					$class_diagram_new= $database->get("class_diagram", "*", [
						"AND" => [
							"id" => $xss->xss($data['id_class_diagram']),
							"school" => $students['school'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
				
				$teacher = $database->get("teacher", "*", [
					"AND" => [
						"id" => $class_diagram_new['homeroom_teacher'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$school_teacher = $database->get("school_teacher", "*", [
					"AND" => [
						"school" => $students['school'],
						"teacher"=>$teacher['id'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);

				$subject = $database->get("subject", "*", [
					"AND" => [
						"id" => $school_teacher['subject'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				
				$assigning_teacherss = $database->select("assigning_teachers", "*", [
					"AND" => [
						"class_diagram" => $class_diagram_new['id'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$ward = $database->get("ward", "*", [
					"AND" => [
						"id" => $teacher['ward'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$province = $database->get("province", "*", [
					"AND" => [
						"id" => $teacher['province'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$district = $database->get("district", "*", [
					"AND" => [
						"id" => $teacher['district'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);

				$content[] = [
					"id_teacher" => $school_teacher['id_teacher'],
					"firstname" => $teacher['firstname'],
					"lastname" => $teacher['lastname'],
					"avatar" => $teacher['avatar'],
					"subject" => $subject['name'],
					"academic_function" => $teacher['academic_function'],
					"phone_number" => $teacher['phone_number'],
					"address" => $teacher['address'],
					"email" => $teacher['email'],
					"birthday" => $teacher['birthday'],
					"gender" => $teacher['gender'],
					"province" => $province['name'],
					"ward" => $ward['name'],
					"district" => $district['name'],
				];
				foreach ($assigning_teacherss as $data) {
					$teacherss = $database->get("teacher", "*", [
						"AND" => [
							"id" => $data['teacher'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					$wards = $database->get("ward", "*", [
						"AND" => [
							"id" => $teacherss['ward'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					$provinces = $database->get("province", "*", [
						"AND" => [
							"id" => $teacherss['province'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					$districts = $database->get("district", "*", [
						"AND" => [
							"id" => $teacherss['district'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					$subjects = $database->get("subject", "*", [
						"AND" => [
							"id" => $data['subject'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					$school_teacher = $database->get("school_teacher", "*", [
					"AND" => [
						"school" => $students['school'],
						"teacher"=>$teacherss['id'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
					$assigning_teacher[]= [
						"id_teacher" => $school_teacher['id_teacher'],
						"firstname" => $teacherss['firstname'],
						"lastname" => $teacherss['lastname'],
						"avatar" => $teacherss['avatar'],
						"subject" => $subjects['name'],
						"academic_function" => $teacherss['academic_function'],
						"phone_number" => $teacherss['phone_number'],
						"address" => $teacherss['address'],
						"email" => $teacherss['email'],
						"birthday" => $teacherss['birthday'],
						"gender" => $teacherss['gender'],
						"province" => $provinces['name'],
						"ward" => $wards['name'],
						"district" => $districts['name'],
					];
				}
					// echo json_encode(['status' => 'success', 'homeroom_teacher' => $content]);
				echo json_encode(['status' => 'success', 'homeroom_teacher' =>$content, 'assigning_teacher' => $assigning_teacher]);
			}
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'opinion') {
		$getToken = $xss->xss($data['token']);

		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			$parents = $database->get("parent", '*', [
				"AND" => [
					"id" => $payload['accounts'],
					"status" => 'A',
					"deleted" => 0,
				]
			]);
			$class_diagram = $database->get("class_diagram", "*", [
						"AND" => [
							"id" => $xss->xss($data['id_class_diagram']),
							"status" => 'A',
							"deleted" => 0,
						]
					]);
			$course = $database->get("course", "*", [
						"AND" => [
							"id" => $class_diagram['course'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
			$opinion = $database->select("opinion", "*", [
				"AND" => [
					"parent" => $parents['id'],
					"date[<>]"=>[$course['startdate'],$course['enddate']],

					"deleted" => 0,
				],
				"ORDER" => [
					"id"=>"DESC",
				]
			]);
			echo json_encode(['status' => 'success', 'content' => $opinion]);
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'opinion-add') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']) {
				$students = $database->get("students", "*", [
					"AND" => [
						"id" => $router['2'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$insert = [
					"date" => date('Y-m-d'),
					"title" => $xss->xss($data['title']),
					"content" => $xss->xss($data['content']),
					"parent" => $payload['accounts'],
					"school" => $students['school'],
				];
			}
			

			$database->insert("opinion", $insert);
			$account_school = $database->select("account_school","*",["school"=>$students['school'],"deleted"=>0,"status"=>'A']);
			foreach($account_school as $accounts){
				$jatbi->notification($payload['accounts'],$accounts['accounts'],'','Thư góp ý','Phụ huynh gửi góp ý','/learning_outcomes/opinion/','','accounts');
			}
			echo json_encode(['status' => 'success', 'content' => $insert]);
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'health_student') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			$parents = $database->get("parent", '*', [
				"AND" => [
					"id" => $payload['accounts'],
					"status" => 'A',
					"deleted" => 0,
				]
			]);
			if ($parents > 1) {
				if ($router['2']) {
					$students = $database->select("students", "*", [
						"AND" => [
							"id" => $router['2'],
							"parent" => $parents['id'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					$getStudent = $database->get("students", "*", [
						"AND" => [
							"id" => $router['2'],
							"parent" => $parents['id'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					$health_student = $database->select("health", "*", [
						"AND" => [
							"students" => $router['2'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					$vaccination = $database->select("vaccination", "*", [
						"AND" => [
							"students" => $router['2'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);

				}
			}
			echo json_encode(['status' => 'success', 'content' => $students, 'health' => $health_student, 'vaccination' => $vaccination]);
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'dish') {
		$getToken = $xss->xss($data['token']);

		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']) {
				$dish = $database->select("dish", "*", [
					"AND" => [
						"id"=>$router['2'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				echo json_encode(['status' => 'success', 'content' => $dish]);
			}
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'school_announcement') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']) {
				$students = $database->get("students", "*", [
					"AND" => [
						"id" => $router['2'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$class_diagram = $database->get("class_diagram", "*", [
						"AND" => [
							"id" => $data['id_class_diagram'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
				$course=$database->get("course" , "*",[
					    "AND" => [
						"id"=>$class_diagram['course'],
						"status" => 'A',
						"deleted" => 0,
				     	]
				     ]);
				$school_announcement = $database->select("school_announcement", "*", [
					"AND" => [
						"date[<>]"=>[$course['startdate'],$course['enddate']],
						"school" => $students['school'],
						"status" => 'A',
						"deleted" => 0,
					], "ORDER" => [
					        "date" => "DESC" // Sắp xếp theo trường 'date_added' giảm dần (mới nhất đến cũ nhất)
					    ],
				]);

				echo json_encode(['status' => 'success', 'content' => $school_announcement]);
			}
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'teacher_announcement') {
		$getToken = $xss->xss($data['token']);

		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {

			if ($router['2']) {
				$students = $database->get("students", "*", [
					"AND" => [
						"id" => $router['2'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				
				$teacher_announcement = $database->select("teacher_announcement", "*", [
					"AND" => [
						"school" => $students['school'],
						"class_diagram" => $xss->xss($data['id_class_diagram']),
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$teacher_announcement2 = $database->count("teacher_announcement", [
					"AND" => [
						"school" => $students['school'],
						"view"=>0,
						"class_diagram" => $xss->xss($data['id_class_diagram']),
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				foreach ($teacher_announcement as $data) {
					$teacher = $database->get("teacher", "*", [
						"AND" => [
							"id" => $data['teacher'],
							"status" => 'A',
							"deleted" => 0,
						],
						"ORDER" => [
							"id"=>"DESC",
						]
					]);
					$content[] = [
						"id" =>$data['id'],
						"first_teacher" => $teacher['firstname'],
						"last_teacher" => $teacher['lastname'],
						"view" => $data['view'],
						"avatar" => $teacher['avatar'],
						"name_announcement" => $data['name'],
						"content" => $data['content'],
						"date" => $data['date'],
						"description" => $data['description'],
					];

				}

				echo json_encode(['status' => 'success', 'content' => $content,'count_view'=>$teacher_announcement2]);
			}
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'furlough') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']) {
				$students = $database->get("students", "*", [
					"AND" => [
						"id" => $router['2'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$student = $database->select("students", "*", [
					"AND" => [
						"id" => $router['2'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);

				$arrange_class = $database->get("arrange_class", "*",[
						"AND" => [
							"deleted"       => 0,
							"status"		=>"A",
							"students"		=>$students['id'],
							"class_diagram" => $xss->xss($data['id_class_diagram']),
						],"ORDER" => [
							"date" => "DESC",
						],
				]);
				$furlough = $database->select("furlough", "*", [
					"AND" => [
						"arrange_class"=>$arrange_class['id'],
						"status" => 'A',
						"deleted" => 0,
					],
					"ORDER" => [
						"id"=>"DESC",
					]
				]);
				foreach ($furlough as $data){
					if($data['statu']=='A'){
						$stutas='Chưa duyệt';
					}elseif($data['statu']=='C'){
						$stutas='Từ chối';
					} else $stutas='Đã duyệt';
					$content[]=[
						"id" => $data['id'],
						"date_start"=>$data['date_start'],
						"date_end"=>$data['date_end'],
						"datecurrent"=>$data['datecurrent'],
						"numberday"=>$data['numberday'],
						"reason"=>$data['reason'],
						"statu"=>$stutas,
					];
				}
				echo json_encode(['status' => 'success', 'content' =>$content,'student' => $student]);
			}
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'furlough-add') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']) {
				$students = $database->get("students", "*", [
					"AND" => [
						"id" => $router['2'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);

				
				$arrange_class = $database->get("arrange_class", "*",[
						"AND" => [
							"deleted"       => 0,
							"status"		=>"A",
							"students"		=>$students['id'],
							"class_diagram" =>$xss->xss($data['id_class_diagram']),
						]
				]);
			  $start_date = strtotime($data['date_start']);
			  $end_date = strtotime($data['date_end'] );
				// Tạo một mảng để lưu trữ tất cả các ngày trong khoảng thời gian này
			  $current_date = $start_date;
			

			while ($current_date <= $end_date) {
			    $date_list[] = date('Y-m-d', $current_date);
			    $current_date = strtotime('+1 day', $current_date);
			}

			foreach ($date_list as $list_date) {
			    $timestamp = strtotime($list_date);
			    $weekday = date('N', $timestamp);
			    $weekday = intval($weekday); 
			    $day_number[]=$weekday;
			}

			$timework_details = $database->select("timework_details", "week",[
						"AND" => [
							"deleted"       => 0,
							"off"		=>1,
							"school" =>$xss->xss($data['id_school']),
						]
				]);
	
			$day_off=0;
			foreach ($day_number as $date5 ) {
			   if (!in_array($date5,$timework_details)) {
			   //	echo("ab +1");
			   $day_off=$day_off+1;
			   } 
			}

				
				$insert = [
					"date_start"=>$xss->xss($data['date_start']),
					"date_end"=>$xss->xss($data['date_end']),
					"datecurrent"=>date('Y-m-d'),
					"numberday"=>$day_off,
					"view"=>0,
					"count"=>0,
					"reason"=>$xss->xss($data['reason']),
					"status"=>"A",
					"statu"=>"A",
					"deleted"=>0,
					"arrange_class" => $arrange_class['id'],
					"school" => $students['school'],
				];
				$database->insert("furlough", $insert);
				$jatbi->logs('furlough', 'add', $insert);
				$account_school = $database->select("account_school","*",["school"=>$students['school'],"deleted"=>0,"status"=>'A']);

				$class_diagram = $database->get("class_diagram", "*", [
					"AND" => [
						"id" => $xss->xss($data['id_class_diagram']),
						"status" => 'A',
						"deleted" => 0,
					]
				    ]);
				 $teacher = $database->get("teacher", "*", [
					"AND" => [
						"id" => $class_diagram['homeroom_teacher'],
						"status" => 'A',
						"deleted" => 0,
					]
				    ]);
					
					  $school = $database->get("school", "*", [
					"AND" => [
						"id" => $students['school'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
					 $device = $database->select("device_teacher","device_id",["school"=>$students['school'],'teacher'=>$teacher['id'],"deleted"=> 0,"status"=>'A']);

					 function sendNotification($title,$message,$device) {
                            $content = array(
                                "en" => $message // Nội dung thông báo (có thể thay đổi ngôn ngữ ở đây)
                            );
                        
                            $fields = [
                                'app_id' => 'c0bd1290-a222-4a69-b48f-e1a756d3e1b6', // ID ứng dụng OneSignal của bạn
                                'include_player_ids' =>$device, // Danh sách các device token
                                'contents' => $content,
                                'headings' => array("en" => $title) // Tiêu đề thông báo
                            ];
                        
                            $fields = json_encode($fields);
                        
                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                'Content-Type: application/json; charset=utf-8',
                                'Authorization: Basic ODQzZTk1NmMtMjIwNi00NmNhLTgxZDMtMzg2NTBkODJjYTBl' // Thay YOUR_REST_API_KEY bằng khóa REST API của bạn
                            ));
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_HEADER, false);
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        
                            $result = curl_exec($ch);
                        
                            if ($result === FALSE) {
                                die('Curl failed: ' . curl_error($ch));
                            }
                        
                            curl_close($ch);
                        
                            return $result;
                        }
                        $st=date('d-m-Y', strtotime($data['date_start']));
                        $en=date('d-m-Y', strtotime($data['date_end']));
                        // Gọi hàm sendNotification để gửi thông báo đẩy
                        $title =  $school['name'];
                        $message = "Phụ huynh xin nghỉ phép cho học sinh ".$students['fullname']." từ ngày ".$st." đến ngày ".$en;
                        $result = sendNotification($title,$message,$device);
				
				echo json_encode(['status' => 'success', 'content' =>"Thêm thành công","ab"=> $device]);
			}
			
			
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'teacher_announcement_detail') {
		$getToken = $xss->xss($data['token']);

		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']) {
				$teacher_announcements = $database->select("teacher_announcement", "*", [
					"AND" => [
						"id" => $router['2'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$teacher_announcement = $database->get("teacher_announcement", "*", [
					"AND" => [
						"id" => $router['2'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				if ($teacher_announcement['view']==0) {
					$update=['view'=>1,];
				}
				$teacher=$database->select("teacher", "*", [
					"AND" => [
						"id" => $teacher_announcement['teacher'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				

				$database->update("teacher_announcement", $update,["id"=>$teacher_announcement['id']]);
				$jatbi->logs('teacher_announcement', 'update', $update);

				echo json_encode(['status' => 'success', 'content' =>$teacher_announcements,'teacher' =>$teacher]);
			}
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'school_announcement_detail') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']) {
				$school_announcements = $database->select("school_announcement", "*", [
					"AND" => [
						"id" => $router['2'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
			
					$update=['view' =>1,];
				$database->update("school_announcement", $update,["id"=>$router['2']]);
				$jatbi->logs('school_announcement', 'update', $update);
				echo json_encode(['status' => 'success', 'content' => $school_announcements]);
			}
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'class_fund_book') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']) {
				$students = $database->get("students", "*", [
					"AND" => [
						"id" => $router['2'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				   
				$class_fund_book = $database->select("class_fund_book", "*", [
					"AND" => [
						"class_diagram" =>$xss->xss($data['id_class_diagram']),
						"school" =>$students['school'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);

				foreach ($class_fund_book as $data){
					$month_year1 = date('Y-m');

					$date_str =$data['date'];
					$timestamp = strtotime($date_str);
					$month_year = date('Y-m', $timestamp);
					if($month_year1==$month_year){
						$datanew[]=$data;
					}
					
				}
				foreach ($datanew as $data){
					$sum+=$data['price'];

				}
				echo json_encode(['status' => 'success', 'content' =>$datanew,'sum'=>$sum,'month_year'=>$month_year1]);
			}
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'revenue_expenditure') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']) {
				$students = $database->get("students", "*", [
					"AND" => [
						"id" =>  $xss->xss($data['id_student']),
						"status" => 'A',
						"deleted" => 0,
					]
				]);
		
				$revenue_expenditure = $database->select("revenue_expenditure", "*", [
					"AND" => [
						"class_diagram" =>$xss->xss($data['id_class_diagram']),
						"school" =>$students['school'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$month_year1 = $router['2'];
				foreach ($revenue_expenditure as $data){
					$month_year1 = $router['2'];

					$date_str =$data['date'];
					$timestamp = strtotime($date_str);
					$month_year = date('Y-m', $timestamp);
					if($month_year1==$month_year){
						$datanew[]=$data;
					}
					
				}
				foreach ($datanew as $data){
					$sum+=$data['price'];

				}
				echo json_encode(['status' => 'success', 'content' => $datanew,'sum'=>$sum,'month_year'=>$month_year1]);
			}
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'class_fund_book_click') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']) {
				$students = $database->get("students", "*", [
					"AND" => [
						"id" => $xss->xss($data['id_student']),
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				
				$class_fund_book = $database->select("class_fund_book", "*", [
					"AND" => [
						"class_diagram" =>$xss->xss($data['id_class_diagram']),
						"school" =>$students['school'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);

				foreach ($class_fund_book as $data4){
					$month_year1 = $router['2'];
					$date_str =$data4['date'];
					$timestamp = strtotime($date_str);
					$month_year = date('Y-m', $timestamp);
					if($month_year1==$month_year){
						$datanew[]=$data4;
					}
					
				}
				foreach ($datanew as $data2){
					$sum+=$data2['price'];

				}
				$revenue_expenditure = $database->select("revenue_expenditure", "*", [
					"AND" => [
						"class_diagram" =>$xss->xss($data['id_class_diagram']),
						"school" =>$students['school'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$month_year2 = $router['2'];
				foreach ($revenue_expenditure as $data){
					$month_year2 = $router['2'];

					$date_str =$data['date'];
					$timestamp = strtotime($date_str);
					$month_year = date('Y-m', $timestamp);
					if($month_year1==$month_year){
						$datanew2[]=$data;
					}
					
				}
				foreach ($datanew2 as $data){
					$sum1+=$data['price'];

				}


				echo json_encode(['status' => 'success', 'thu' =>$datanew,'chi' => $datanew2,'sum2'=>$sum1,'sum1'=>$sum,'month_year'=>$month_year1]);
			}
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'changepass-parent'){
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if($payload>1){
			$parent = $database->get("parent", '*',["AND"=>["id"=>$payload['accounts'],]]);
			$check = crypt($xss->xss($data['passwordold']), $parent['password']);
			if($parent>1 && $check===$parent['password']){
				if($xss->xss($data['password'])!=$xss->xss($data['passwordcomfirm'])){
					echo json_encode(['status'=>'error',"content"=>"Mật khẩu không trùng khớp"]);
				}
				if($xss->xss($data['password'])==$xss->xss($data['passwordcomfirm'])){
					$insert = [
						"password"          => password_hash($xss->xss($data['password']), PASSWORD_DEFAULT),
					];
					$database->update("parent",$insert,["id"=>$parent['id']]);
					$jatbi->logs('parent','changepass',$insert);
					echo json_encode(['status'=>'success',"content"=>"Thay đổi thành công",]);
					
				
				}
			}
			else {
				echo json_encode(['status'=>'error','content'=>'Mật khẩu không đúng']);
			}
		}
		else {
			echo json_encode(['status'=>'error','content'=>'error']);
		}
	} elseif ($router['1'] == 'opinion-detail') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			$parents = $database->get("parent", '*', [
				"AND" => [
					"id" => $payload['accounts'],
					"status" => 'A',
					"deleted" => 0,
				]
			]);
			if ($router['2']) {
				$opinion = $database->select("opinion", "*", [
					"AND" => [
						"id" => $router['2'],
						"deleted" => 0,
					]
				]);
			}
			echo json_encode(['status' => 'success', 'content' => $opinion]);
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'schedule') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			
			$day = $database->select("day", "*", [
				"AND" => [
					"status" => "A",
					"deleted" => 0,
				]
			]);	


			echo json_encode(['status' => 'success', 'content' => $day]);
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'schedule_detail') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']) {
				$students = $database->get("students", "*", [
					"AND" => [
						"id" => $xss->xss($data['id_student']),
						"status" => "A",
						"deleted" => 0,
					]
				]);
				
				$ngayHienTai = date('Y-m-d');

				$schedule = $database->get("schedule", "*", [
					"AND" => [
						"class_diagram"	=>$xss->xss($data['id_class_diagram']),
						"school" => $students['school'],
						"date_start[<=]" => $ngayHienTai,
						"date_end[>=]" => $ngayHienTai,
						"status" => "A",
						"deleted" => 0,
					]
				]);
				$schedule_detail_monday=$database->select("schedule_detail", "*", [
					"AND" => [
						"schedule" 	=> $schedule['id'],
						"day"		=>$router['2'],
						"status" 	=> "A",
						"deleted" 	=> 0,
					],"ORDER" => [
						"lesson" => "ASC",
					]
				]);
				$assigning_teachers=$database->select("assigning_teachers", "*", [
					"AND" => [
						"class_diagram"	=>$xss->xss($data['id_class_diagram']),
						"status" 	=> "A",
						"deleted" 	=> 0,
					]
				]);

				foreach ($assigning_teachers as $valu){
					$teacher[]=$database->get("teacher", "*", [
						"AND" => [
							"id"		=>$valu['teacher'],
							"status" 	=> "A",
							"deleted" 	=> 0,
						]
					]);

				}
				foreach ($schedule_detail_monday as $data){
					$day=$database->get("day", "*", [
						"AND" => [
							"id"		=>$data['day'],
							"status" 	=> "A",
							"deleted" 	=> 0,
						]
					]);
					$subject=$database->get("subject", "*", [
						"AND" => [
							"id"		=>$data['subject'],
							"status" 	=> "A",
							"deleted" 	=> 0,
						]
					]);
					$classroom=$database->get("classroom", "*", [
						"AND" => [
							"id"		=>$data['classroom'],
							"status" 	=> "A",
							"deleted" 	=> 0,
						]
					]);
					foreach ($teacher as $valuee){
						$school_teacher[]=$database->get("school_teacher", "*", [
							"AND" => [
								"subject"		=>$data['subject'],
								"status" 	=> "A",
								"deleted" 	=> 0,
							]
						]);
						foreach ($school_teacher as $value){
							$teachers=$database->get("teacher", "*", [
								"AND" => [
									"id"		=>$value['teacher'],
									"status" 	=> "A",
									"deleted" 	=> 0,
								]
							]);

						}
					}
					$detail[]=[
						"day"=> $day['name'],
						"lesson"=> $data['lesson'],
						"subject"=>$subject['name'],
						"classroom"=>$classroom['name'],
						"firstname_teachers"=>$teachers['firstname'],
						"lastname_teachers"=>$teachers['lastname'],
					];
				}
				
			}
			echo json_encode(['status' => 'success', 'content' =>$detail]);
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'car_driver') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']) {
				$driver = $database->select("driver", "*", [
					"AND" => [
						"id"=>$router['2'],
						"status" => "A",
						"deleted" => 0,
					]
				]);
				foreach ($driver as $data) {
					$ward = $database->get("ward", "*", [
						"AND" => [
							"id" => $data['ward'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					$province = $database->get("province", "*", [
						"AND" => [
							"id" => $data['province'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					$district = $database->get("district", "*", [
						"AND" => [
							"id" => $data['district'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
				}

				echo json_encode(['status' => 'success','driver' => $driver,'ward'=>$ward['name'] ,'province'=>$province['name'],'district'=>$district['name']]);
			}
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'news') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']) {
				$students = $database->get("students", "*", [
					"AND" => [
						"id" => $router['2'],
						"status" => "A",
						"deleted" => 0,
					]
				]);
	
		
				$news = $database->select("news", "*", [
					"AND" => [
						"school" => $students['school'],
						
						"status" => "A",
						"deleted" => 0,
					]
				]);
				foreach($news as $text){
					//$text2 = json_decode($text, true);
					$html = str_replace('"', "'", $text['content']);
					 $html = str_replace('../../', "https://school.hewo.vn/", $html);
					// $html1 = str_replace('</p>', "", $html1);
					// // $decodedContent = stripslashes($text['content']);
					// $decodedContent = html_entity_decode($decodedContent);
					$news_school[]=[
						"id"=>$text['id'],
						"name"=>$text['name'],
						"date"=>$text['date'],
						"description"=>$text['description'],
						"content"=>$html,
						"avatar"=>$text['avatar'],
					];

				}

				$school_announcement = $database->select("school_announcement", "*", [
					"AND" => [
					"school" => $students['school'],
					"status" => 'A',
					"deleted" => 0,
					
				],
					    "ORDER" => [
					        "id" => "DESC" // Sắp xếp theo trường 'date_added' giảm dần (mới nhất đến cũ nhất)
					    ],
					    "LIMIT" => 10 // Giới hạn kết quả trả về là 1 bản ghiS
			]);

				
			}
			echo json_encode(['status' => 'success', 'news' => $news_school,'school_announcement'=>$school_announcement]);
		}
	} elseif ($router['1'] == 'news-detail') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']) {
				
				$news = $database->select("news", "*", [
					"AND" => [
						"id" => $router['2'],
						"deleted" => 0,
					]
				]);
				foreach($news as $text){
					//$text2 = json_decode($text, true);
					$html = str_replace('"', "'", $text['content']);
					 $html = str_replace('../../', "https://school.hewo.vn/", $html);
					// $html1 = str_replace('<p>', "", $html);
					// $html1 = str_replace('</p>', "", $html1);
					// // $decodedContent = stripslashes($text['content']);
					// $decodedContent = html_entity_decode($decodedContent);
					$news_school[]=[
						"name"=>$text['name'],
						"date"=>$text['date'],
						"description"=>$text['description'],
						"content"=>$html,
						"avatar"=>$text['avatar'],
					];

				}

			}
			echo json_encode(['status' => 'success', 'content' => $news_school]);
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'parent_announcement') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			// $date=date('Y-m-d');
			
				// $arrange_class=$database->get("arrange_class" , "*",[
				// 	"AND" => [
				// 		"class_diagram"=>$xss->xss($data['id_class_diagram']),
				// 		"status" => 'A',
				// 		"deleted" => 0,
				// 	]
				// ]);
				// $student=$database->get("students" , "*",[
				// 	"AND" => [
				// 		"id"=>$arrange_class['students'],
				// 		"status" => 'A',
				// 		"deleted" => 0,
				// 	]
				// ]);
				$class_diagram=$database->get("class_diagram" , "*",[
					"AND" => [
						"id"=>$xss->xss($data['id_class_diagram']),
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$teacher=$database->get("teacher" , "*",[
					"AND" => [
						"id"=>$class_diagram['homeroom_teacher'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);

				$course=$database->get("course" , "*",[
					"AND" => [
						"id"=>$class_diagram['course'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
			$parent_announcement = $database->select("parent_announcement", "*", [
				"AND" => [
					"school" => $xss->xss($data['id_school']),
					"parent" => $payload['accounts'],
					"student"=> $xss->xss($data['id_student']),
					//"date[<>]"=>[$course['startdate'],$course['enddate']],
					"class_diagram"=>$xss->xss($data['id_class_diagram']),
					"status" => 'A',
					"deleted" => 0,
				]
			]);

			foreach($parent_announcement as $data2){
				$class_diagram2= $database->get("class_diagram", "*", [
					"AND" => [
						"id" =>$data2['class_diagram'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$class= $database->get("class", "*", [
					"AND" => [
						"id" =>$class_diagram2['class'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$student=$database->get("students" , "*",[
					"AND" => [
						"id"=>$data2['student'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$assigning[]=[

					'firstname'=>$student['firstname'],
					'lastname'=>$student['lastname'],
					'firstname_teachers'=>$teacher['firstname'],
					'lastname_teachers'=>$teacher['lastname'],
					'id'=>$data2['id'],
					'name'=>$data2['name'],
					'date'=>$data2['date'],
					'description'=>$data2['description'],
					'content'=>$data2['content'],
					'parent'=>$data2['parent'],
					'description'=>$data2['description'],
					'content'=>$data2['content'],
					'class'=>$class['name'],
				];
			}
			$ht=date('Y-m-d');
			if($ht>=$course['startdate'] && $ht<=$course['enddate']){
				$type=1;
			} else $type=0;

			echo json_encode(['status' => 'success', 'content' =>$assigning,'type'=>$type ]);
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'getstudent_parent_announcement') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			// $date=date('Y-m-d');
			
				// $arrange_class=$database->get("arrange_class" , "*",[
				// 	"AND" => [
				// 		"class_diagram"=>$xss->xss($data['id_class_diagram']),
				// 		"status" => 'A',
				// 		"deleted" => 0,
				// 	]
				// ]);
				$student=$database->select("students" , "*",[
					"AND" => [
						"id"=>$xss->xss($data['id_student']),
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$class_diagram=$database->get("class_diagram" , "*",[
					"AND" => [
						"id"=>$xss->xss($data['id_class_diagram']),
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$teacher=$database->select("teacher" , "*",[
					"AND" => [
						"id"=>$class_diagram['homeroom_teacher'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);

				
			echo json_encode(['status' => 'success', 'teacher' =>$teacher,'student'=>$student ]);
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'announcement_add_parent') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			
				if($data['name'] == "" || $data['description'] == "" || $data['id_student'] == "" || $data['id_class_diagram'] == ""|| $data['content'] == ""|| $data['id_school'] == "")
				{
					echo json_encode(['status' => 'error', 'content' => 'Lỗi dữ liệu trống']);
				} elseif($data['name'] && $data['description'] && $data['id_student'] && $data['id_class_diagram'] && $data['content'] && $data['id_school']){

				
					$insert = [
						"date" => date('Y-m-d'),
						"view"=>0,
						"student"=>$xss->xss($data['id_student']),
						"name" => $xss->xss($data['name']),
						"description" => $xss->xss($data['description']),
						"content" => $xss->xss($data['content']),
						"parent" => $payload['accounts'],
						"class_diagram"=>$xss->xss($data['id_class_diagram']),
						"status" => 'A',
						"deleted" => 0,
						"school" => $xss->xss($data['id_school']),
					];
					$database->insert("parent_announcement", $insert);
					$jatbi->logs('parent_announcement', 'add', $insert);
					echo json_encode(['status' => 'success', 'content' => $insert]);
					$class_diagram = $database->get("class_diagram", "*", [
					"AND" => [
						"id" => $xss->xss($data['id_class_diagram']),
						"status" => 'A',
						"deleted" => 0,
					]
				    ]);
					 $teacher = $database->get("teacher", "*", [
					"AND" => [
						"id" => $class_diagram['homeroom_teacher'],
						"status" => 'A',
						"deleted" => 0,
					]
				    ]);
					 $student = $database->get("students", "*", [
						"AND" => [
							"id" => $xss->xss($data['id_student']),
							"status" => 'A',
							"deleted" => 0,
						]
					    ]);
					  $school = $database->get("school", "*", [
					"AND" => [
						"id" => $xss->xss($data['id_school']),
						"status" => 'A',
						"deleted" => 0,
					]
				]);
					 $device = $database->select("device_teacher","device_id",["school"=>$xss->xss($data['id_school']),'teacher'=>$teacher['id'],"deleted"=> 0,"status"=>'A']);
					  function sendNotification($title,$message,$device) {
                            $content = array(
                                "en" => $message // Nội dung thông báo (có thể thay đổi ngôn ngữ ở đây)
                            );
                        
                            $fields = [
                                'app_id' => 'c0bd1290-a222-4a69-b48f-e1a756d3e1b6', // ID ứng dụng OneSignal của bạn
                                'include_player_ids' =>$device, // Danh sách các device token
                                'contents' => $content,
                                'headings' => array("en" => $title) // Tiêu đề thông báo
                            ];
                        
                            $fields = json_encode($fields);
                        
                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                'Content-Type: application/json; charset=utf-8',
                                'Authorization: Basic ODQzZTk1NmMtMjIwNi00NmNhLTgxZDMtMzg2NTBkODJjYTBl' // Thay YOUR_REST_API_KEY bằng khóa REST API của bạn
                            ));
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_HEADER, false);
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        
                            $result = curl_exec($ch);
                        
                            if ($result === FALSE) {
                                die('Curl failed: ' . curl_error($ch));
                            }
                        
                            curl_close($ch);
                        
                            return $result;
                        }
                        
                        // Gọi hàm sendNotification để gửi thông báo đẩy
                        $title =  $school['name'];
                        $message = "Thông báo của phụ huynh học sinh ".$student['fullname']. " Với nội dung ".$xss->xss($data['description']);
                        $result = sendNotification($title,$message,$device);
                        	
				}

		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'scores') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']) {
				$students = $database->get("students", "*", [
					"AND" => [
						"id" => $router['2'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
			$class_diagram = $database->get("class_diagram", "*", [
						"AND" => [
							"id" => $xss->xss($data['id_class_diagram']),
							"status" => 'A',
							"deleted" => 0,
						]
					]);
			    $course = $database->get("course", "*", [
						"AND" => [
							"id" => $class_diagram['course'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
				$semester = $database->select("semester", "*", [
					"AND" => [
						"course" => $course['id'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				
				foreach($semester as $resultArray2){
					$course = $database->get("course", "*", [
					    "AND" => [
					        "id"=>$resultArray2['course'],
					        "status" => 'A',
						    "deleted" => 0,
					    ]
					]); 
					$resultArray_new[]=[
						"id"=>$resultArray2['id'],
						"name"=>$resultArray2['name'],
						"startdate"=>$resultArray2['startdate'],
						"enddate"=>$resultArray2['enddate'],
						"course"=>$resultArray2['course'],
						"school"=>$resultArray2['school'],
						"course_name"=>$course['name'],
						
					];
				}
				
				echo json_encode(['status' => 'success','semester' =>$resultArray_new]);
			} 
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'subject_scores') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']) {
				$semester = $database->get("semester", "*", [
					"AND" => [
						"id"=>$router['2'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);

				$students = $database->get("students", "*", [
					"AND" => [
						"id" => $xss->xss($data['id_student']),
						"status" => 'A',
						"deleted" => 0,
					]
				]);
			     
					$assigning_teachers= $database->select("assigning_teachers", "*", [
						"AND" => [
							
							"school" => $students['school'],
							"semester" => $router['2'],
							"class_diagram"=> $xss->xss($data['id_class_diagram']),
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					foreach($assigning_teachers as $assigning_teachers){
						$subject= $database->get("subject", "*", [
						"AND" => [
							"id" => $assigning_teachers['subject'],
						]
					]);
						$teacher= $database->get("teacher", "*", [
						"AND" => [
							"id" => $assigning_teachers['teacher'],
						]
					]);
						$subject_scores[]=[
							"id_assigning_teachers"=>$assigning_teachers['id'],
							"subject"=>$subject['name'],
							"id_subject"=>$subject['id'],
							"teacher_lastname"=>$teacher['lastname'],
							"teacher_firstname"=>$teacher['firstname'],
							"class_diagram"=>$assigning_teachers['class_diagram'],

						];
					}


				echo json_encode(['status' => 'success','semester' =>$subject_scores]);
			} 
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'scores-detail') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']) {
				$students = $database->get("students", "*", [
					"AND" => [
						"id" => $xss->xss($data['id_student']),
						"status" => 'A',
						"deleted" => 0,
					]
				]);

				$arrange_class = $database->get("arrange_class", "*", [
					    "AND" => [
					        "students" => $students['id'],
					        "school" => $students['school'],
					        "class_diagram"=>$xss->xss($data['id_class_diagram']),
					        "status" => 'A',
					        "deleted" => 0,
					    ]
				]);
				     
				$scores=$database->select("scores" , "*",[
					"AND" => [
						"arrange_class"=>$arrange_class['id'],
						"school"=>$students['school'],
						"assigning_teachers" =>$router['2'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);

				foreach ($scores as $data) {
					$typescore = $database->get("typescore", "*", [
						"AND" => [
							"id" =>$data['typescore'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					
					$subject_teacher[]= [
						"id_typescore"=>$typescore['id'],
						"typescore"=>$typescore['name'],
						"scores"=>$data['score'],

					];
				}
											$diemtk=$database->select("scores","*",["typescore"=>$database->get("typescore", "id", ["school"        =>$students['school'],"id_type_scores" =>"m", "deleted" => 0, "status" => 'A']),"school"=>$students['school'],"assigning_teachers"=>$router['2'],"arrange_class"=>$arrange_class['id']]);
											$diem15=$database->select("scores","*",["typescore"=>$database->get("typescore", "id", ["school"        =>$students['school'],"id_type_scores" =>"15p", "deleted" => 0, "status" => 'A']),"school"=>$students['school'],"assigning_teachers"=>$router['2'],"arrange_class"=>$arrange_class['id']]);
											$diem45p=$database->select("scores","*",["typescore"=>$database->get("typescore", "id", ["school"        =>$students['school'],"id_type_scores" =>"45p", "deleted" => 0, "status" => 'A']),"school"=>$students['school'],"assigning_teachers"=>$router['2'],"arrange_class"=>$arrange_class['id']]);
											$diemgk=$database->get("scores","score",["typescore"=>$database->get("typescore", "id", ["school"        =>$students['school'],"id_type_scores" =>"gk", "deleted" => 0, "status" => 'A']),"school"=>$students['school'],"assigning_teachers"=>$router['2'],"arrange_class"=>$arrange_class['id']]);
											$diemck=$database->get("scores","score",["typescore"=>$database->get("typescore", "id", ["school"        =>$students['school'],"id_type_scores" =>"ck", "deleted" => 0, "status" => 'A']),"school"=>$students['school'],"assigning_teachers"=>$router['2'],"arrange_class"=>$arrange_class['id']]);
											$diemth=$database->select("scores","*",["typescore"=>$database->get("typescore", "id", ["school"        =>$students['school'],"id_type_scores" =>"th", "deleted" => 0, "status" => 'A']),"school"=>$students['school'],"assigning_teachers"=>$router['2'],"arrange_class"=>$arrange_class['id']]);
											$totaltk=0;
											$total15=0;
											$total45=0;
											$totalth=0;
											$totalgk=0;
											$totalck=0;
											$hesotk=$database->get("typescore", "heso", ["school"=>$students['school'],"id_type_scores" =>"m", "deleted" => 0, "status" => 'A']);
											$heso15=$database->get("typescore", "heso", ["school"=>$students['school'],"id_type_scores" =>"15p", "deleted" => 0, "status" => 'A']);
											$heso45=$database->get("typescore", "heso", ["school"=>$students['school'],"id_type_scores" =>"45p", "deleted" => 0, "status" => 'A']);
											$hesoth=$database->get("typescore", "heso", ["school"=>$students['school'],"id_type_scores" =>"th", "deleted" => 0, "status" => 'A']);
											$hesogk=$database->get("typescore", "heso", ["school"=>$students['school'],"id_type_scores" =>"gk", "deleted" => 0, "status" => 'A']);
											$hesock=$database->get("typescore", "heso", ["school"=>$students['school'],"id_type_scores" =>"ck", "deleted" => 0, "status" => 'A']);
											$countDiemtk = count($diemtk);
											$countDiem15 = count($diem15);
											$countDiem45p = count($diem45p);

										$countDiemgk = ($diemgk !== false) ? 1 : 0; // Kiểm tra nếu $diemgk có giá trị thì gán 1, ngược lại gán 0
										$countDiemck = ($diemck !== false) ? 1 : 0; // Kiểm tra nếu $diemck có giá trị thì gán 1, ngược lại gán 0
										$countDiemth = count($diemth);
										// Tính tổng điểm từ $diemtk
										foreach ($diemtk as $score) {
											$totaltk += $score['score'];
										}

										// Tính tổng điểm từ $diem15
										foreach ($diem15 as $score) {
											$total15 += $score['score'];
										}

										// Tính tổng điểm từ $diem45p
										foreach ($diem45p as $score) {
											$total45 += $score['score'];
										}

										// Thêm điểm giữa kỳ $diemgk vào tổng điểm
										$totalgk = $diemgk;

										// Thêm điểm cuối kỳ $diemck vào tổng điểm
										$totalck = $diemck;

										// Tính tổng điểm từ $diemth
										foreach ($diemth as $score) {
											$totalth += $score['score'];
										}
										
										$dtbm=($totaltk*$hesotk+$total15*$heso15+$total45*$heso45+$totalgk*$hesogk+$totalck*$hesock+$totalth*$hesoth)/($countDiemtk*$hesotk+$countDiem15*$heso15+$countDiem45p*$heso45+$countDiemth*$hesoth+$hesogk+$hesock);
			$roundedNumber = round($dtbm, 2);

				$subject_teachers[]= [

					"typescore"=>"Chưa có điểm",
					"scores"=>"Trống",

				];
				if(empty($subject_teacher)){
					echo json_encode(['status' => 'success','subject_teacher' => 
						$subject_teachers]);
					
				}else{
					echo json_encode(['status' => 'success','subject_teacher' => 
						$subject_teacher,'diemTrungBinh'=>$roundedNumber]);
				}
				
			} 
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'car-day') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']) {
			$students = $database->get("students", "*", [
				"AND" => [
					"id" => $xss->xss($data['id_student']),
					"status" => 'A',
					"deleted" => 0,
				]
			]);
		$class_diagram = $database->get("class_diagram", "*", [
						"AND" => [
							"id" => $router['2'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
			$arrange_class = $database->get("arrange_class", "*", [
						"AND" => [
							"class_diagram" => $router['2'],
							"students" => $xss->xss($data['id_student']),
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					$ht=date('Y-m-d');
					$semester = $database->get("semester", "*", [
						"AND" => [
							"course" => $class_diagram['course'],
							"startdate[<=]" => $ht,
							"enddate[>=]" => $ht,
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					$student_register_car = $database->get("student_register_car", "*", [
						"AND" => [
							
							"arrange_class" => $arrange_class['id'],
							"semester"=>$semester['id'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
				    $car_schedule_detail = $database->select("car_schedule_detail", "*", [
						"AND" => [
							"student_register_car" => $student_register_car['id'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);

					foreach($car_schedule_detail as $value){
						$car_schedule_new= $database->get("car_schedule", "*", [
						"AND" => [
							"id" => $value['car_schedule'],
							"date"=>$ht,
							"status" => 'A',
							"deleted" => 0,
						]
					]);
						if ($car_schedule_new!=null) {
							$car_schedule=$car_schedule_new;
						}
					}



			$car=$database->get("car" , "*",[
				"AND" => [
					"id"=>$car_schedule['car'],
					"status" => 'A',
					"deleted" => 0,
				]
			]);
			$driver=$database->get("driver" , "*",[
				"AND" => [
					"id"=>$car_schedule['driver'],
					"status" => 'A',
					"deleted" => 0,
				]
			]);
			$student_register_number=$database->count("car_schedule" , "*",[
				"AND" => [
					//"id"=>$car_schedule['car'],
					"date"=>date('Y-m-d'),
					"car"=>$car['id'],
					"driver"=>$driver['id'],
					"status" => 'A',
					"deleted" => 0,
				]
			]);
			if (!isset($car_schedule['id'])) {
				$student_register_number=null;
			} 
			$car_schedule_student[]= [
				"id_schedule" => $car_schedule['id'],
				"namedriver" => $driver['name'],
				"typecar" => $car['typecar'],
				"frame_number" => $car['frame_number'],
				"student_register_number"=> $student_register_number,
			];
		}
			echo json_encode(['status' => 'success', 'content' => $car_schedule_student]);
		}
	} elseif ($router['1'] == 'car_schedule') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']) {
				$car_schedule=$database->get("car_schedule" , "*",[
					"AND" => [
						"id"=>$router['2'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				
				$driver = $database->get("driver", "*", [
					"AND" => [
						"id" => $car_schedule['driver'],
						"school"=>$car_schedule['school'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$ward = $database->get("ward", "*", [
					"AND" => [
						"id" => $driver['ward'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$province = $database->get("province", "*", [
					"AND" => [
						"id" => $driver['province'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$district = $database->get("district", "*", [
					"AND" => [
						"id" => $driver['district'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);

				echo json_encode(['status' => 'success','driver' => $driver,'ward' => $ward, 'province' => $province, 'district' => $district]);
			} 
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'car_schedule_go') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']) {
				$students = $database->get("students", "*", [
					"AND" => [
						"id" =>$xss->xss($data['id_student']) ,
						"status" => 'A',
						"deleted" => 0,
					]
				]);

				
			$class_diagram = $database->get("class_diagram", "*", [
						"AND" => [
							"id" => $router['2'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
			$arrange_class = $database->get("arrange_class", "*", [
						"AND" => [
							"class_diagram" => $router['2'],
							"students" => $xss->xss($data['id_student']),
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					$ht=date('Y-m-d');
					$semester = $database->get("semester", "*", [
						"AND" => [
							"course" => $class_diagram['course'],
							"startdate[<=]" => $ht,
							"enddate[>=]" => $ht,
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					$student_register_car = $database->get("student_register_car", "*", [
						"AND" => [
							
							"arrange_class" => $arrange_class['id'],
							"semester"=>$semester['id'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
				    $car_schedule_detail = $database->select("car_schedule_detail", "*", [
						"AND" => [
							"student_register_car" => $student_register_car['id'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);

					foreach($car_schedule_detail as $value){
						$car_schedule_new= $database->get("car_schedule", "*", [
						"AND" => [
							"id" => $value['car_schedule'],
							"type"=>1,
							"status" => 'A',
							"deleted" => 0,
						],
					    "ORDER" => [
					        "date" => "DESC" // Sắp xếp theo trường 'date_added' giảm dần (mới nhất đến cũ nhất)
					    ],
					    "LIMIT" => 20 // Giới hạn kết quả trả về là 1 bản ghi
					]);
						if ($car_schedule_new!=null) {
							$car_schedule[]=$car_schedule_new;
						}
					}

				foreach ($car_schedule as $data) {
					$driver = $database->get("driver", "*", [
						"AND" => [
							"id" => $data['driver'],
							"school"=>$data['school'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					$car= $database->get("car", "*", [
						"AND" => [
							"id" => $data['car'],
							"school"=>$data['school'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					$date=$data['date'];
					$date_formatted = date('Y-m-d', strtotime($date));
                    $day_of_week = date('l', strtotime($date_formatted));
					if ($day_of_week=="Monday") {
						$day_of_week="Thứ 2";
					} 
					else if ($day_of_week=="Tuesday")
					{
						$day_of_week="Thứ 3";
					}
					else if ($day_of_week=="Wednesday")
					{
						$day_of_week="Thứ 4";
					} 
					else if ($day_of_week=="Thursday")
					{
						$day_of_week="Thứ 5";
					}
					else if ($day_of_week=="Friday")
					{
						$day_of_week="Thứ 6";
					}
					else if ($day_of_week=="Saturday")
					{
						$day_of_week="Thứ 7";
					}
					else if ($day_of_week=="Sunday")
					{
						$day_of_week="Chủ nhật";
					}
					$route= $database->get("route", "*", [
						"AND" => [
							"id" => $data['route'],
							//"school"=>$data['school'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					$car_schedule_go[]= [
						"id_schedule" => $data['id'],
						"route"=>$route['name'],
						"driver" =>$data['driver'],
						"namedriver" => $driver['name'],
						"typecar" => $car['typecar'],
						"frame_number" => $car['frame_number'],
						"license_plates" => $car['license_plates'],
						"date" => $data['date'],
						"day_of_week" =>$day_of_week
					];

				}
				echo json_encode(['status' => 'success','content' => $car_schedule_go]);
			} 
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}		
	} elseif ($router['1'] == 'car_schedule_comeback') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']) {
				$students = $database->get("students", "*", [
					"AND" => [
						"id" =>$xss->xss($data['id_student']) ,
						"status" => 'A',
						"deleted" => 0,
					]
				]);

				
			$class_diagram = $database->get("class_diagram", "*", [
						"AND" => [
							"id" => $router['2'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
			$arrange_class = $database->get("arrange_class", "*", [
						"AND" => [
							"class_diagram" => $router['2'],
							"students" => $xss->xss($data['id_student']),
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					$ht=date('Y-m-d');
					$semester = $database->get("semester", "*", [
						"AND" => [
							"course" => $class_diagram['course'],
							"startdate[<=]" => $ht,
							"enddate[>=]" => $ht,
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					$student_register_car = $database->get("student_register_car", "*", [
						"AND" => [
							
							"arrange_class" => $arrange_class['id'],
							"semester"=>$semester['id'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
				    $car_schedule_detail = $database->select("car_schedule_detail", "*", [
						"AND" => [
							"student_register_car" => $student_register_car['id'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);

					foreach($car_schedule_detail as $value){
						$car_schedule_new= $database->get("car_schedule", "*", [
						"AND" => [
							"id" => $value['car_schedule'],
							"type"=>2,
							"status" => 'A',
							"deleted" => 0,
						],
					    "ORDER" => [
					        "date" => "DESC" // Sắp xếp theo trường 'date_added' giảm dần (mới nhất đến cũ nhất)
					    ],
					    "LIMIT" => 20 // Giới hạn kết quả trả về là 1 bản ghi
					]);
						if ($car_schedule_new!=null) {
							$car_schedule[]=$car_schedule_new;
						}
					}

				foreach ($car_schedule as $data) {
					$driver = $database->get("driver", "*", [
						"AND" => [
							"id" => $data['driver'],
							"school"=>$data['school'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					$car= $database->get("car", "*", [
						"AND" => [
							"id" => $data['car'],
							"school"=>$data['school'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					$date=$data['date'];
					$date_formatted = date('Y-m-d', strtotime($date));
					$day_of_week = date('l', strtotime($date_formatted));
					if ($day_of_week=="Monday") {
						$day_of_week="Thứ 2";
					} 
					else if ($day_of_week=="Tuesday")
					{
						$day_of_week="Thứ 3";
					}
					else if ($day_of_week=="Wednesday")
					{
						$day_of_week="Thứ 4";
					} 
					else if ($day_of_week=="Thursday")
					{
						$day_of_week="Thứ 5";
					}
					else if ($day_of_week=="Friday")
					{
						$day_of_week="Thứ 6";
					}
					else if ($day_of_week=="Saturday")
					{
						$day_of_week="Thứ 7";
					}
					else if ($day_of_week=="Sunday")
					{
						$day_of_week="Chủ nhật";
					}
					$route= $database->get("route", "*", [
						"AND" => [
							"id" => $data['route'],
							//"school"=>$data['school'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					$car_schedule_go[]= [
						"id_schedule" => $data['id'],
						"route"=>$route['name'],
						"driver" =>$data['driver'],
						"namedriver" => $driver['name'],
						"typecar" => $car['typecar'],
						"frame_number" => $car['frame_number'],
						"license_plates" => $car['license_plates'],
						"date" => $data['date'],
						"day_of_week" =>$day_of_week
					];

				}
				echo json_encode(['status' => 'success','content' => $car_schedule_go]);
			} 
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'attendance') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']) {
				$today_date = date("N");
				if ($today_date==1) {
					$startDate =date('Y-m-d', strtotime('Monday'));
					$date = strtotime('Monday');
					$endDate = date('Y-m-d',strtotime('+6 days',$date));

					} else{
					$startDate =date('Y-m-d', strtotime('last Monday'));
					$date = strtotime('last Monday');
					$endDate = date('Y-m-d',strtotime('+6 days',$date));
					}


				$getStudent = $database->get("students", "*", [
											"AND" => [
												"id" => $router['2'],
												"parent" => $payload['accounts'],
												"status" => 'A',
												"deleted" => 0,
											]
										]);
		
					$arrange_class_new = $database->get("arrange_class", "*", [
					    "AND" => [
					        "students" => $getStudent['id'],
					        "school" => $getStudent['school'],
					        "class_diagram" =>$xss->xss($data['id_class_diagram']),
					        "status" => 'A',
					        "deleted" => 0,
					    ]
					]);

				$timekeeping=$database->select("timekeeping" , "*",[
					"AND" => [
						"arrange_class"=>$arrange_class_new['id'],
						"date[<>]"=>[$startDate,$endDate],
						
					]
				]);
				$today2 = date('Y-m-d');
				$first_day_of_week = date('Y-m-d', strtotime("monday this week"));
				for ($j = 0; $j <= 6; $j++) {
					$day2 = date('Y-m-d', strtotime("+$j day", strtotime($first_day_of_week)));
					$days2[] = $day2;
				}
				if($timekeeping!=null){
				foreach($timekeeping as $data)
				{
					$day=$data['date'];
					$date_formatted = date('Y-m-d', strtotime($day));
					$day_of_week = date('l', strtotime($date_formatted));
					if ($day_of_week=="Monday") {
						$day_of_week="Thứ 2";
					} 
					else if ($day_of_week=="Tuesday")
					{
						$day_of_week="Thứ 3";
					}
					else if ($day_of_week=="Wednesday")
					{
						$day_of_week="Thứ 4";
					} 
					else if ($day_of_week=="Thursday")
					{
						$day_of_week="Thứ 5";
					}
					else if ($day_of_week=="Friday")
					{
						$day_of_week="Thứ 6";
					}
					else if ($day_of_week=="Saturday")
					{
						$day_of_week="Thứ 7";
					}
					else if ($day_of_week=="Sunday")
					{
						$day_of_week="Chủ nhật";
					}

					if ($data['checkin']== null && $data['checkout']== null) {
						$type="3";
					} 
					else if( $data['checkin']== null || $data['checkout']== null) {
						$type="2";
					} 
					else  {
						$type="1";
					}

					$today = time();
					$ht=date('Y-m-d');
				// Lấy ngày đầu tiên của tuần
					$firstDayOfWeek = strtotime('monday this week', $today);

				// Tạo một mảng chứa 7 ngày và thứ tương ứng
					$weekDays = array();
					for ($i = 0; $i < 7; $i++) {
						$day = strtotime('+' . $i . ' day', $firstDayOfWeek);
						$weekDays[date('l', $day)] = date('Y-m-d', $day);
					}
					$timekeeping_day[]= [
						"id" => $data['id'],
						"arrange_class" => $data['arrange_class'],
						"date" => $data['date'],
						"checkin" => $data['checkin'],
						"checkout" => $data['checkout'],
						"date_poster" =>$data['date_poster'],
						"school" => $data['school'],
						"day_of_week" =>$day_of_week,
						"type" => $type,
					];
					$timekeeping_day_new=$timekeeping_day;

				foreach ($weekDays as $day => $date) {
					    $found = false;
					    foreach ($timekeeping_day as $item) {
					        if ($item['date'] === $date) {
					            $found = true;
					            break;
					        }
					    }
					    if (!$found ) {
					    	if($date >= $ht){
					        $new_item = array(
					            'id' => null,
					            'arrange_class' => null,
					            'date' => $date,
					            'checkin' => null,
					            'checkout' => null,
					            'date_poster' => null,
					            'school' => null,
					            'day_of_week' => $day,
					            'type' => null
					        );
					    }
					    if($date <$ht){
					        $new_item = array(
					            'id' => null,
					            'arrange_class' => null,
					            'date' => $date,
					            'checkin' => null,
					            'checkout' => null,
					            'date_poster' => null,
					            'school' => null,
					            'day_of_week' => $day,
					            'type' => 4
					        );
					    }
					        array_push($timekeeping_day_new, $new_item);
					    }
					}
				
			}
		} else {
					$firstDayOfWeek = strtotime($first_day_of_week);
               //$firstdayofweek = $date->format('Y-m-d');
				// Tạo một mảng chứa 7 ngày và thứ tương ứng
					$weekDays = array();
					for ($i = 0; $i < 7; $i++) {
						$day = strtotime('+' . $i . ' day', $firstDayOfWeek);
						$weekDays[date('l', $day)] = date('Y-m-d', $day);
					}

					$timekeeping_day_new=array();
					foreach ($weekDays as $day => $date) {
					        $ht=date('Y-m-d');
					        if($date >= $ht){
					        $new_item2 = array(
					            'id' => null,
					            'arrange_class' => null,
					            'date' => $date,
					            'checkin' => null,
					            'checkout' => null,
					            'date_poster' => null,
					            'school' => null,
					            'day_of_week' => $day,
					            'type' => null
					        );
					    }
					    elseif($date <$ht){
					        $new_item2 = array(
					            'id' => null,
					            'arrange_class' => null,
					            'date' => $date,
					            'checkin' => null,
					            'checkout' => null,
					            'date_poster' => null,
					            'school' => null,
					            'day_of_week' => $day,
					            'type' => 4
					        );
					    }
					        array_push($timekeeping_day_new, $new_item2);
					    
					}
				}

				echo json_encode(['status' => 'success','content' =>$timekeeping_day_new,'datestart'=>$startDate,'dateend'=>$timekeeping]);
			} 
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'attendance_search') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']) {

				$date_string =$router['2'];
				$timestamp = strtotime($date_string);

				// Lấy ngày đầu tuần
				$first_day_of_week = date('Y-m-d', strtotime('monday this week', $timestamp));

				// Lấy ngày cuối tuần
				 $last_day_of_week= date('Y-m-d', strtotime('sunday this week', $timestamp));


				$getStudent = $database->get("students", "*", [
											"AND" => [
												"id" =>  $xss->xss($data['id_student']),
												"parent" => $payload['accounts'],
												"status" => 'A',
												"deleted" => 0,
											]
										]);
				
					$arrange_class_new = $database->get("arrange_class", "*", [
					    "AND" => [
					        "students" => $getStudent['id'],
					        "school" => $getStudent['school'],
					        "class_diagram" => $xss->xss($data['id_class_diagram']),
					        "status" => 'A',
					        "deleted" => 0,
					    ]
					]);

				$timekeeping=$database->select("timekeeping" , "*",[
					"AND" => [
						"arrange_class"=>$arrange_class_new['id'],
						"date[<>]"=>[$first_day_of_week,$last_day_of_week]
					]
				]);
				if($timekeeping!=null){

				foreach($timekeeping as $data)
				{ 

					$day=$data['date'];
					$date_formatted = date('Y-m-d', strtotime($day));
					$day_of_week = date('l', strtotime($date_formatted));
					if ($day_of_week=="Monday") {
						$day_of_week="Thứ 2";
					} 
					else if ($day_of_week=="Tuesday")
					{
						$day_of_week="Thứ 3";
					}
					else if ($day_of_week=="Wednesday")
					{
						$day_of_week="Thứ 4";
					} 
					else if ($day_of_week=="Thursday")
					{
						$day_of_week="Thứ 5";
					}
					else if ($day_of_week=="Friday")
					{
						$day_of_week="Thứ 6";
					}
					else if ($day_of_week=="Saturday")
					{
						$day_of_week="Thứ 7";
					}
					else if ($day_of_week=="Sunday")
					{
						$day_of_week="Chủ nhật";
					}

					if ($data['checkin']== null && $data['checkout']== null) {
						$type="3";
					} 
					else if( $data['checkin']== null || $data['checkout']== null) {
						$type="2";
					} 
					else  {
						$type="1";
					}
					$ht=date('Y-m-d');
				// Lấy ngày đầu tiên của tuần
					$firstDayOfWeek = strtotime($first_day_of_week);
               //$firstdayofweek = $date->format('Y-m-d');
				// Tạo một mảng chứa 7 ngày và thứ tương ứng
					$weekDays = array();
					for ($i = 0; $i < 7; $i++) {
						$day = strtotime('+' . $i . ' day', $firstDayOfWeek);
						$weekDays[date('l', $day)] = date('Y-m-d', $day);
					}


					$timekeeping_day[]= [
						"id" => $data['id'],
						"arrange_class" => $data['arrange_class'],
						"date" => $data['date'],
						"checkin" => $data['checkin'],
						"checkout" => $data['checkout'],
						"date_poster" =>$data['date_poster'],
						"shool" => $data['school'],
						"day_of_week" =>$day_of_week,
						"type" => $type,
					];
					$timekeeping_day_new=$timekeeping_day;
			if($timekeeping_day !=null){
				foreach ($weekDays as $day => $date) {
					    $found = false;
					    foreach ($timekeeping_day as $item) {
					        if ($item['date'] === $date) {
					            $found = true;
					            break;
					        }
					    }
					    if (!$found ) {

					    	if($date >= $ht){
					        $new_item = array(
					            'id' => null,
					            'arrange_class' => null,
					            'date' => $date,
					            'checkin' => null,
					            'checkout' => null,
					            'date_poster' => null,
					            'school' => null,
					            'day_of_week' => $day,
					            'type' => null
					        );
					    }
					    if($date <$ht){
					        $new_item = array(
					            'id' => null,
					            'arrange_class' => null,
					            'date' => $date,
					            'checkin' => null,
					            'checkout' => null,
					            'date_poster' => null,
					            'school' => null,
					            'day_of_week' => $day,
					            'type' => 4
					        );
					    }
					        array_push($timekeeping_day_new, $new_item);
					    }
					}
				}
			  }
			} else {
					$firstDayOfWeek = strtotime($first_day_of_week);
               //$firstdayofweek = $date->format('Y-m-d');
				// Tạo một mảng chứa 7 ngày và thứ tương ứng
					$weekDays = array();
					for ($i = 0; $i < 7; $i++) {
						$day = strtotime('+' . $i . ' day', $firstDayOfWeek);
						$weekDays[date('l', $day)] = date('Y-m-d', $day);
					}

					$timekeeping_day_new=array();
					foreach ($weekDays as $day => $date) {
						$ht=date('Y-m-d');
					        if($date >= $ht){
					        $new_item2 = array(
					            'id' => null,
					            'arrange_class' => null,
					            'date' => $date,
					            'checkin' => null,
					            'checkout' => null,
					            'date_poster' => null,
					            'school' => null,
					            'day_of_week' => $day,
					            'type' => null
					        );
					    }
					    elseif($date <$ht){
					        $new_item2 = array(
					            'id' => null,
					            'arrange_class' => null,
					            'date' => $date,
					            'checkin' => null,
					            'checkout' => null,
					            'date_poster' => null,
					            'school' => null,
					            'day_of_week' => $day,
					            'type' => 4
					        );
					    }
					        array_push($timekeeping_day_new, $new_item2);
					    
					}
				}
				echo json_encode(['status' => 'success','content' => $timekeeping_day_new,'date_now'=>$weekDays]);
			} 
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'menu') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			$day = $database->select("day", "*", [
				"AND" => [
					"status" => "A",
					"school"=>$xss->xss($data['id_school']),
					"deleted" => 0,
				]
			]);	

			$mondayfood=$database->select("food_menu_detail", "*", [
				"AND" => [
					"day"=>1,
					"status" => "A",
					"deleted" => 0,
				]
			]);	
			foreach($mondayfood as $data){
				$days = $database->get("day", "*", [
					"AND" => [
						"id"=>$data['day'],
						"status" => "A",
						"deleted" => 0,
					]
				]);	
				$dish = $database->get("dish", "*", [
					"AND" => [
						"id"=>$data['dish'],
						"status" => "A",
						"deleted" => 0,
					]
				]);	
				$typemenu = $database->get("typemenu", "*", [
					"AND" => [
						"id"=>$data['typemenu'],
						"status" => "A",
						"deleted" => 0,
					]
				]);	
				$monday[]=[
					"typemenu"=>$typemenu['name'],
					"namefood"=>$dish['name'],
					"avatar"=>$dish['avatar'],
					"id"=>$dish['id'],

				];
			}

			echo json_encode(['status' => 'success',"monday"=>$monday]);
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'menu_day') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']) {
				$day = $database->select("day", "*", [
					"AND" => [
						"status" => "A",
						"deleted" => 0,
					]
				]);	

				$mondayfood=$database->select("food_menu_detail", "*", [
					"AND" => [
						"day"=>$router['2'],
						"school"=>$xss->xss($data['id_school']),
						"status" => "A",
						"deleted" => 0,
					]
				]);	
				foreach($mondayfood as $data){
					$days = $database->get("day", "*", [
						"AND" => [
							"id"=>$data['day'],
							"status" => "A",
							"deleted" => 0,
						]
					]);	
					$dish = $database->get("dish", "*", [
						"AND" => [
							"id"=>$data['dish'],
							"status" => "A",
							"deleted" => 0,
						]
					]);	
					$typemenu = $database->get("typemenu", "*", [
						"AND" => [
							"id"=>$data['typemenu'],
							"status" => "A",
							"deleted" => 0,

						]
					]);	
					$monday[]=[
						
						"typemenu"=>$typemenu['name'],
						"namefood"=>$dish['name'],
						"avatar"=>$dish['avatar'],
						"id"=>$dish['id'],
						"day"=>$data['day'],

					];
				}

				echo json_encode(['status' => 'success',"content"=>$monday]);
			}} else {
				echo json_encode(['status' => 'error', 'content' => 'error']);
			}
	} elseif ($router['1'] == 'students-parent') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']) {
				$parents = $database->get("parent", '*', [
					"AND" => [
						"id" => $payload['accounts'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$students = $database->select("students", "*", [
					"AND" => [
						"school" => $router['2'],
						"parent" => $parents['id'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);

				foreach ($students as $data){
					$ward = $database->get("ward", "*", [
						"AND" => [
							"id" => $data['ward'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					$parents = $database->get("parent", "*", [
						"AND" => [
							"id" => $data['parent'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					$province = $database->get("province", "*", [
						"AND" => [
							"id" => $data['province'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					$district = $database->get("district", "*", [
						"AND" => [
							"id" => $data['district'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					$priority_object = $database->get("priority_object", "*", [
						"AND" => [
							"id" => $data['priority_object'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					$school = $database->get("school", "*", [
						"AND" => [
							"id" => $data['school'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					$nationality = $database->get("nationality", "*", [
						"AND" => [
							"id" => $data['nationality'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					$ethnic = $database->get("ethnic", "*", [
						"AND" => [
							"id" => $data['ethnic'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					$religion = $database->get("religion", "*", [
						"AND" => [
							"id" => $data['religion'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					$course = $database->get("course", "*", [
						"AND" => [
							"id" => $data['course'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					$allergy = $database->get("allergy", "*", [
						"AND" => [
							"id" => $data['allergy'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					$getStudent[]=[
						'allergy'=>$allergy['name'],
						'hobby'=>$data['hobby'],
						'student'=>$data['id'],
						'student_id'=>$data['id_student'],
						'address'=>$data['address'],
						'avatar'=>$data['avatar'],
						'firstname'=>$data['firstname'],
						'lastname'=>$data['lastname'],
						'birthday'=>$data['birthday'],			
						'year_of_admission'=>$data['year_of_admission'],
						'gender'=>$data['gender'],
						'ward'=>$ward['name'],
						'province' =>$province['name'],
						'district' =>$district['name'],
						'priority_object'=>$priority_object['name'],
						'school' =>$school['name'],
						'nationality' =>$nationality['name'],
						'ethnic' =>$ethnic['name'],
						'religion' =>$religion['name'],
						'health_insurance_id' =>$data['health_insurance_id'],
						'body_insurance_id' =>$data['body_insurance_id'],
						'year_of_admission' =>$data['year_of_admission'],
						'course' =>$course['name'],

					];
				}


				echo json_encode(['status' => 'success', 'students' => $getStudent,'parents'=>$parents]);
			}
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'login_teacher') {
		if (isset($data['phone_number'])) {
			$teacher = $database->get("teacher", '*', [
				"AND" => [
					"phone_number" => $data['phone_number'],
					"status" => 'A',
					"deleted" => 0,
				]
			]);
			$check = crypt($xss->xss($data['password']), $teacher['password']);
			if ($teacher > 1 && $xss->xss($data['phone_number']) != '') {
				if ($check === $teacher['password']) {
					$payload = [
						"phone_number" => $teacher['phone_number'],
						"accounts" => $teacher['id'],
						"agent" => $_SERVER['HTTP_USER_AGENT'],
						"date" => date('Y-m-d H:i:s'),
						"identify" => $jatbi->active(32),
					];
					$school = $database->select("school_teacher", '*', [
				    "AND" => [
					"teacher" =>$teacher['id'],
					"status" => 'A',
					"deleted" => 0,
						]
					]);
					foreach($school as $news){
					$device_parent = $database->get("device_teacher", '*', [
				    "AND" => [
					"teacher" =>$teacher['id'],
					"device_id"=>$xss->xss($data['device_id_teacher']),
					"school"=>$news['school'],
					"status" => 'A',
					"deleted" => 0,
						]
					]);
					if($device_parent==null  && $data['device_id_teacher']!=null){
						$insert = [
						"teacher" =>$teacher['id'],
						"device_id"=>$xss->xss($data['device_id_teacher']),
						"school"=>$news['school'],
						"status" => 'A',
						"deleted" => 0,
						
					];
					$database->insert("device_teacher", $insert);
					$jatbi->logs('device_teacher', 'add', $insert);
					echo json_encode(['status' => 'success', 'device_teacher' => $insert]);
					}
				}
					$token = JWT::encode($payload, $setting['secret-key']);
					$database->insert("payload", $payload);
					echo json_encode(['status' => 'success', "content" => "Đăng nhập thành công", "token" => $token, "firstname" => $teacher['firstname'],"id_teacher" => $payload['accounts'],"lastname" => $teacher['lastname'], "phone_number" => $teacher['phone_number']]);
				} else {
					echo json_encode(['status' => 'error', "content" => "Mật khẩu không đúng"]);
				}
			} elseif ($xss->xss($_POST['phone_number']) == '' || $xss->xss($_POST['password']) == '') {
				echo json_encode(['status' => 'error', "content" => "Vui lòng không để trống"]);
			} else {
				echo json_encode(['status' => 'error', "content" => "Số điện thoại không đúng"]);
			}
		}
	} elseif ($router['1'] == 'school-teacher') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			$teachers = $database->get("teacher", '*', [
				"AND" => [
					"id" => $payload['accounts'],
					"status" => 'A',
					"deleted" => 0,
				]
			]);
			$school_teacher = $database->select("school_teacher", '*', [
				"AND" => [
					"teacher" => $teachers['id'],
					"status" => 'A',
					"deleted" => 0,
				]
			]);
			foreach ($school_teacher as $data) {
				$school[] = $database->get("school", "*", [
					"AND" => [
						"id" => $data['school'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
			}
		// $school= $database->select("school","*",["AND"=>["id"=>$school_parent['school'],"status" 	=> 'A',
		//  	"deleted"	=> 0,]]);
			echo json_encode(['status' => 'success', 'content' => $school]);
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'course-school-teacher') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']) {
			$teachers = $database->get("teacher", '*', [
				"AND" => [
					"id" => $payload['accounts'],
					"status" => 'A',
					"deleted" => 0,
				]
			]);
			$course = $database->select("course", '*', [
				"AND" => [
					"school" => $router['2'],
					"status" => 'A',
					"deleted" => 0,
				],"ORDER" => [
						"id" => DESC,
					],"LIMIT"=>10,
			]);
			}
			$school = $database->select("school", "*", [
					"AND" => [
						"id" => $router['2'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
		// $school= $database->select("school","*",["AND"=>["id"=>$school_parent['school'],"status" 	=> 'A',
		//  	"deleted"	=> 0,]]);
			echo json_encode(['status' => 'success', 'content' => $course,'school'=>$school ]);
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'teachers') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']) {
				$school_teacher=$database->get("school_teacher" , "*",[
					"AND" => [
						"school"=> $xss->xss($data['id_school_teacher']),
						"teacher"=>$payload['accounts'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$teacher=$database->select("teacher" , "*",[
					"AND" => [
						"id"=>$payload['accounts'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$getTeacher=$database->get("teacher" , "*",[
					"AND" => [
						"id"=>$payload['accounts'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$regent=$database->select("regent" , "*",[
					"AND" => [
						"id"=>$school_teacher['regent'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);

				$class_diagram=$database->get("class_diagram" , "*",[
					"AND" => [	
						"homeroom_teacher"=>$payload['accounts'],
						"course"=>$router['2'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$getclass=$database->select("class" , "*",[
					"AND" => [	
						"id"=>$class_diagram['class'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$classroom=$database->select("classroom" , "*",[
					"AND" => [	
						"id"=>$class_diagram['classroom'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$ward = $database->get("ward", "*", [
					"AND" => [
						"id" => $getTeacher['ward'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$province = $database->get("province", "*", [
					"AND" => [
						"id" => $getTeacher['province'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$district = $database->get("district", "*", [
					"AND" => [
						"id" => $getTeacher['district'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$nationality = $database->get("nationality", "*", [
					"AND" => [
						"id" => $getTeacher['nationality'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$ethnic = $database->get("ethnic", "*", [
					"AND" => [
						"id" => $getTeacher['ethnic'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$religion = $database->get("religion", "*", [
					"AND" => [
						"id" => $getTeacher['religion'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$parent_announcement = $database->count("parent_announcement", [
						"AND" => [
							// "school" => $students['school'],
							"view"=>0,
							"class_diagram" =>$class_diagram['id'],
							"status" => 'A',
							"deleted" => 0,
						]
						]);
				$course=$database->get("course" , "*",[
					    "AND" => [
						"id"=>$class_diagram['course'],
						"status" => 'A',
						"deleted" => 0,
				     	]
				     ]);
				$school_announcement = $database->count("school_announcement", [
						"AND" => [
							"school" => $class_diagram['school'],
							"view"=>0,
							"date[<>]"=>[$course['startdate'],$course['enddate']],
							"status" => 'A',
							"deleted" => 0,
						]
						]);
				$arrange_class=$database->select("arrange_class" , "*",[
					"AND" => [	
						"school" => $class_diagram['school'],
						"class_diagram"=>$class_diagram['id'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$ht=date('Y-m-d');
					$semester = $database->get("semester", "*", [
						"AND" => [
							"course" => $router['2'],
							"startdate[<=]" => $ht,
							"enddate[>=]" => $ht,
							"status" => 'A',
							"deleted" => 0,
						]
					]);
				
				$count_student_register_car=0;
				$count_furlough=0;
				foreach($arrange_class as $value){

				$student_register_car5 = $database->count("student_register_car", [
						"AND" => [
							"school" => $class_diagram['school'],
						    "view"=>0,
						    "semester"=>$semester['id'],
							"arrange_class"=>$value['id'],
							"status" => 'A',
							"deleted" => 0,
						]
						]);
				$furlough = $database->count("furlough",[
					"AND" => [
						"arrange_class"=>$value['id'],
						"view"=>0,
						//"date[<>]"=>[$semester['date_start'],$semester['date_end']],
						"status" => 'A',
						"deleted" => 0,
					]
				]);


					if ($furlough!=null) {
						$count_furlough=$count_furlough+$furlough;
					}
					if ($student_register_car5!=null) {
						$count_student_register_car=$count_student_register_car+$student_register_car5	;
					}
				}
				$timekeeping=$database->get("timekeeping_teachers" , "*",[
							"AND" => [
								"date"=>$date=date('Y-m-d'),
								"teacher"=>$payload['accounts'],
								"school"=>$xss->xss($data['id_school_teacher']),

							]
						]);

				echo json_encode(['status' => 'success', 'teacher' => $teacher,'id_teacher' => $school_teacher['id_teacher'],'date' => $school_teacher['date_start_work'],'regent' => $regent,'class' => $getclass,'classroom' => $classroom,'ward' => $ward['name'], 'province' => $province['name'], 'district' => $district['name'] ,'nationality' => $nationality['name'], 'ethnic' => $ethnic['name'], 'religion' => $religion['name'],'count_parent'=>$parent_announcement,'count_school'=>$school_announcement,'count_student_register_car'=>$count_student_register_car,'count_furlough'=>$count_furlough,'timekeeping'=>$timekeeping]);
			}
		} else {
			echo json_encode(['status' => 'error', 'content' => 'Không thể kết nối đến server',]);
		}
	} elseif ($router['1'] == 'changepass-teacher'){
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if($payload>1){
			$teacher = $database->get("teacher", '*',["AND"=>["id"=>$payload['accounts'],]]);
			$check = crypt($xss->xss($data['passwordold']), $teacher['password']);
			if($teacher>1 && $check===$teacher['password']){
				if($xss->xss($data['password'])!=$xss->xss($data['passwordcomfirm'])){
					echo json_encode(['status'=>'error',"content"=>"Mật khẩu không trùng khớp",'a'=>$data['password'],'b'=>$data['passwordcomfirm']]);
				}
				if($xss->xss($data['password'])==$xss->xss($data['passwordcomfirm'])){
					$insert = [
						"password"          => password_hash($xss->xss($data['password']), PASSWORD_DEFAULT),
					];
					$database->update("teacher",$insert,["id"=>$teacher['id']]);
					$jatbi->logs('teacher','changepass',$insert);
					echo json_encode(['status'=>'success',"content"=>"Thay đổi thành công",]);
				}
			}
			else {
				echo json_encode(['status'=>'error','content'=>'Mật khẩu không đúng','a'=>$data['password'],'b'=>$data['passwordcomfirm']]);
			}
		}
		else {
			echo json_encode(['status'=>'error','content'=>'error']);
		}
	} elseif ($router['1'] == 'student-teacher-list') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']) {
				$arrange_class=$database->select("arrange_class" , "*",[
					"AND" => [
						"class_diagram"=>$router['2'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				foreach($arrange_class as $arrange_class){
				$students=$database->get("students" , "*",[
					"AND" => [
						"id"=>$arrange_class['students'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$student_list[]=$students;
			}
				echo json_encode(['status' => 'success', 'liststudent'=>$student_list]);
			}
		} else {
			echo json_encode(['status' => 'error', 'content' => 'Không thể kết nối đến server',]);
		}
	} elseif ($router['1'] == 'grade') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']) {
				$grade=$database->select("grade" , "*",[
					"AND" => [
						"school"=>$router['2'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				echo json_encode(['status' => 'success', 'grade'=>$grade]);
			}
		} else {
			echo json_encode(['status' => 'error', 'content' => 'Không thể kết nối đến server',]);
		}
	} elseif ($router['1'] == 'class_teacher_full') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']) {
				$date=date('Y-m-d');
	

				$class_diagram=$database->select("class_diagram" , "*",[
					"AND" => [
						"grade"=>$router['2'],
						"course"=>$xss->xss($data['id_course']),
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				foreach($class_diagram as $class_diagram){
					$class=$database->get("class" , "*",[
					"AND" => [
						"id"=> $class_diagram['class'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
					$class_new[]=[
						"id_class_diagram"=>$class_diagram['id'],
						"name"=>$class['name'],
					];
				}
				echo json_encode(['status' => 'success', 'class'=>$class_new]);
			}
		} else {
			echo json_encode(['status' => 'error', 'content' => 'Không thể kết nối đến server',]);
		}
	} elseif ($router['1'] == 'class_teacher') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			
				$date=date('Y-m-d');
				$course=$database->get("course" , "*",[
					"AND" => [
						"id"=>$xss->xss($data['id_course']),
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$semester=$database->get("semester" , "*",[
					"AND" => [
						"enddate[>=]"=> $date,
						"startdate[<=]"=> $date,
						"course"=>$course['id'],
						"school"=>$xss->xss($data['id_school_teacher']),
						"status" => 'A',
						"deleted" => 0,
					]
				]);

				$class_diagram2=$database->get("class_diagram" , "*",[
					"AND" => [
						"course"=>$course['id'],
						"homeroom_teacher"=>$payload['accounts'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				
				$assigning_teachers=$database->select("assigning_teachers" , "*",[
					"AND" => [
						"semester"=>$semester['id'],
						"teacher"=>$payload['accounts'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				foreach($assigning_teachers as $assigning_teachers){
					$class_diagram=$database->get("class_diagram" , "*",[
					"AND" => [
						"id"=>$assigning_teachers['class_diagram'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
					$class_diagram_new[]=$class_diagram;
					
				}
				if ($class_diagram2!=null) {
						array_push($class_diagram_new, $class_diagram2);
					}
					// $existingIds = array();

					// // Duyệt qua mảng $myArray
					// for ($i = 0; $i < count($class_diagram_new); $i++) {
					//     $currentId = $class_diagram_new[$i]["id"];
					//     // Nếu ID đã tồn tại trong $existingIds
					//     if (in_array($currentId, $existingIds)) {
					//         // Loại bỏ phần tử khỏi mảng $class_diagram_new
					//         unset($class_diagram_new[$i]);
					//     } else {
					//         // Thêm ID vào mảng $existingIds
					//         $existingIds[] = $currentId;
					//     }
					// }
					foreach ($class_diagram_new as $item) {

				    if (!in_array($item['id'], $existing_ids)) {
				        // Nếu trường "id" chưa tồn tại trong mảng $existing_ids, đưa phần tử vào mảng mới và thêm trường "id" vào mảng $existing_ids
				        $unique_class[] = $item;
				        $existing_ids[] = $item['id'];
				    }
				}

					// Chuyển đổi lại các chỉ số của mảng $myArray để không có khoảng trống
					$class_diagram_new= array_values($unique_class);

				foreach($class_diagram_new as $class_diagram_new4){
					
					$class=$database->get("class" , "*",[
					"AND" => [
						"id"=> $class_diagram_new4['class'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
					$class_new[]=[
						"id_class_diagram"=>$class_diagram_new4['id'],
						"name"=>$class['name'],
					];
				}
				echo json_encode(['status' => 'success', 'class'=>$class_new]);
		} else {
			echo json_encode(['status' => 'error', 'content' => 'Không thể kết nối đến server',]);
		}
	} elseif ($router['1'] == 'subject') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']) {
				$subject=$database->select("subject" , "*",[
					"AND" => [
						"school"=>$router['2'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				echo json_encode(['status' => 'success', 'subject'=>$subject]);
			}
		} else {
			echo json_encode(['status' => 'error', 'content' => 'Không thể kết nối đến server',]);
		}
	} elseif ($router['1'] == 'subject_teacher') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']) {
				$date=date('Y-m-d');
				$semester=$database->get("semester" , "*",[
						"AND" => [
							"course"=>$xss->xss($data['id_course']),
							"startdate[<=]"=>$date,
							"enddate[>=]"=>$date,
							"status" => 'A',
							"deleted" => 0,
						]
					]);

				$assigning_teachers=$database->select("assigning_teachers" , "*",[
					"AND" => [
						"school"=>$xss->xss($data['id_school_teacher']),
						"subject"=>$router['2'],
						"semester"=>$semester['id'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);

				foreach($assigning_teachers as $data2){
					$teacher=$database->get("teacher" , "*",[
						"AND" => [
				//	"school"=>$xss->xss($data['id_school']),
							"id"=>$data2['teacher'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					$school_teacher=$database->get("school_teacher" , "*",[
						"AND" => [
							"school"=>$xss->xss($data['id_school_teacher']),
							"teacher"=>$teacher['id'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					$subject=$database->get("subject" , "*",[
						"AND" => [

							"id"=>$router['2'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);


					$new[]=[
						'teacher'=> $teacher,
						'specialized'=> $subject
					];

				}
				foreach ($new as $item) {
				    $is_duplicate = false;
				    foreach ($unique_array as $unique_item) {
				        if ($unique_item["id"] == $item["id"] && $unique_item["name"] == $item["name"]) {
				            // Nếu phần tử đã tồn tại trong mảng kết quả, đánh dấu là phần tử bị trùng lặp và thoát khỏi vòng lặp
				            $is_duplicate = true;
				            break;
				        }
				    }
				    if (!$is_duplicate) {
				        // Nếu phần tử không bị trùng lặp, thêm nó vào mảng kết quả
				        $unique_array[] = $item;
				    }
				}
				echo json_encode(['status' => 'success', 'subject'=>$unique_array]);
			}
		} else {
			echo json_encode(['status' => 'error', 'content' => 'Không thể kết nối đến server',]);
		}
	} elseif ($router['1'] == 'profile_student') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']) {
				$student2=$database->select("students" , "*",[
					"AND" => [
						"id"=>$router['2'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$students=$database->get("students" , "*",[
					"AND" => [
						"id"=>$router['2'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$ward = $database->get("ward", "*", [
					"AND" => [
						"id" => $students['ward'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$province = $database->get("province", "*", [
					"AND" => [
						"id" => $students['province'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$district = $database->get("district", "*", [
					"AND" => [
						"id" => $students['district'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$nationality = $database->get("nationality", "*", [
					"AND" => [
						"id" => $students['nationality'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$ethnic = $database->get("ethnic", "*", [
					"AND" => [
						"id" => $students['ethnic'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$religion = $database->get("religion", "*", [
					"AND" => [
						"id" => $students['religion'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$allergy = $database->get("allergy", "*", [
					"AND" => [
						"id" => $students['allergy'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);

				$priority_object = $database->get("priority_object", "*", [
					"AND" => [
						"id" => $students['priority_object'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				echo json_encode(['status' => 'success', 'students' => $student2,'ward' => $ward['name'], 'province' => $province['name'], 'district' => $district['name'] ,'nationality' => $nationality['name'], 'ethnic' => $ethnic['name'], 'religion' => $religion['name'],'priority_object' => $priority_object['name'] ,'allergy'=>$allergy['name']]);
			   }
		} else {
			echo json_encode(['status' => 'error', 'content' => 'Không thể kết nối đến server',]);
	   }
	} elseif ($router['1'] == 'school_announcement_teacher') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']) {
				$date=date('Y-m-d');
				$course=$database->get("course" , "*",[
					"AND" => [
						"enddate[>=]"=> $date,
						"startdate[<=]"=> $date,
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$school_announcement = $database->select("school_announcement", "*", [
					"AND" => [
						"school" => $router['2'],
						"date[<>]"=>[$course['startdate'],$course['enddate']],
						"status" => 'A',
						"deleted" => 0,
					], "ORDER" => [
					        "date" => "DESC" // Sắp xếp theo trường 'date_added' giảm dần (mới nhất đến cũ nhất)
					    ],
				]);
				echo json_encode(['status' => 'success', 'content' =>$school_announcement]);
			}
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'teacher_announcement_teacher') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			$date=date('Y-m-d');
				$course=$database->get("course" , "*",[
					"AND" => [
						"id"=>$xss->xss($data['id_course']),
						"status" => 'A',
						"deleted" => 0,
					]
				]);
			$teacher_announcement = $database->select("teacher_announcement", "*", [
				"AND" => [
					"school" => $xss->xss($data['id_school_teacher']),
					"teacher" => $payload['accounts'] ,
					"date[<>]"=>[$course['startdate'],$course['enddate']],
					"status" => 'A',
					"deleted" => 0,
				]
			]);

			foreach($teacher_announcement as $data){
				$class_diagram= $database->get("class_diagram", "*", [
					"AND" => [
						"id" =>$data['class_diagram'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$class= $database->get("class", "*", [
					"AND" => [
						"id" =>$class_diagram['class'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$assigning[]=[
					'id'=>$data['id'],
					'view'=>$data['view'],
					'name'=>$data['name'],
					'date'=>$data['date'],
					'description'=>$data['description'],
					'content'=>$data['content'],
					'teacher'=>$data['teacher'],
					'description'=>$data['description'],
					'content'=>$data['content'],
					'class'=>$class['name'],
				];
			}

			echo json_encode(['status' => 'success', 'content' =>$assigning ]);
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'teacher_class_2') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			$assigning_teachers = $database->select("assigning_teachers", "*", [
				"AND" => [
					"school" => $xss->xss($data['id_school_teacher']),
					"teacher"=>$payload ['accounts'],
					"status" => 'A',
					"deleted" => 0,
				]
			]);
			foreach($assigning_teachers as $data){
				$subject=$database->get("subject", "*", [
					"AND" => [
						"id"=>$data['subject'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$subject_teacher[]=[
					'subject'=>$subject['name'],
					'id'=>$subject['id'],
				];
			}
			echo json_encode(['status' => 'success', 'content' => $assigning_teachers]);
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'announcement_add_teacher') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']!=0 && isset($router['2'])) {
				if($data['name'] == "" || $data['description'] == ""|| $data['content'] == ""|| $data['id_school_teacher'] == "")
				{
					echo json_encode(['status' => 'error', 'content' => 'Lỗi dữ liệu trống']);
				} elseif($data['name'] && $data['description'] && $data['content'] && $data['id_school_teacher']){
					$insert = [
						"date" => date('Y-m-d'),
						"name" => $xss->xss($data['name']),
						"description" => $xss->xss($data['description']),
						"content" => $xss->xss($data['content']),
						"teacher" => $payload['accounts'],
						"view"=>0,
						"class_diagram"=>$router['2'],
						"status" => 'A',
						"deleted" => 0,
						"school" => $xss->xss($data['id_school_teacher']),
					];
					$database->insert("teacher_announcement", $insert);
					$jatbi->logs('teacher_announcement', 'add', $insert);

					$arrange_class = $database->select("arrange_class", "*", [
					"AND" => [
						"class_diagram" => $router['2'],
						"status" => 'A',
						"deleted" => 0,
					]
				    ]);

				    $teacher = $database->get("teacher", "*", [
					"AND" => [
						"id" => $payload['accounts'],
						"status" => 'A',
						"deleted" => 0,
					]
				    ]);
				    $school = $database->get("school", "*", [
					"AND" => [
						"id" => $xss->xss($data['id_school_teacher']),
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				    foreach($arrange_class as $to){
					    $student = $database->get("students", "*", [
						"AND" => [
							"id" => $to['students'],
							"status" => 'A',
							"deleted" => 0,
						]
					    ]);
					   $students[]= $student;

			        }
			       $parents=array();
			        foreach($students as $td){
				$parent = $database->get("parent", "*", [
					"AND" => [
						"id" =>$td['parent'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				//$parents=$parent;
				if(in_array($parent['id'], array_column($parents, 'id')) == false && $parent!=null){
					$parents[]=$parent;
				}
			}	$combinedParents=array();
				foreach($parents as $newparent){
					$device_1= $database->select("device_parent","device_id",["school"=>
						$data['id_school_teacher'],"deleted"=> 0,
					"parent"=>$newparent['id'],
					"school"=>$data['id_school_teacher'],
					"status"=>'A']);
					if($device_1!=[]){
				   $device = array_merge($combinedParents, $device_1);
					}

				}
                        // $device2 = $database->select("device_teacher","device_id",["school"=>$school_id,"deleted"=> 0,"status"=>'A']);
                        // $device = array_merge($device1, $device2);

                        function sendNotification($title,$message,$device) {
                            $content = array(
                                "en" => $message // Nội dung thông báo (có thể thay đổi ngôn ngữ ở đây)
                            );
                        
                            $fields = [
                                'app_id' => 'c0bd1290-a222-4a69-b48f-e1a756d3e1b6', // ID ứng dụng OneSignal của bạn
                                'include_player_ids' =>$device, // Danh sách các device token
                                'contents' => $content,
                                'headings' => array("en" => $title) // Tiêu đề thông báo
                            ];
                        
                            $fields = json_encode($fields);
                        
                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                'Content-Type: application/json; charset=utf-8',
                                'Authorization: Basic ODQzZTk1NmMtMjIwNi00NmNhLTgxZDMtMzg2NTBkODJjYTBl' // Thay YOUR_REST_API_KEY bằng khóa REST API của bạn
                            ));
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_HEADER, false);
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        
                            $result = curl_exec($ch);
                        
                            if ($result === FALSE) {
                                die('Curl failed: ' . curl_error($ch));
                            }
                        
                            curl_close($ch);
                        
                            return $result;
                        }
                        
                        // Gọi hàm sendNotification để gửi thông báo đẩy
                        $title =  $school['name'];
                        $message = "Thông báo của giáo viên ".$teacher['fullname']. " Với nội dung ".$xss->xss($data['description']);
                        $result = sendNotification($title,$message,$device);
					echo json_encode(['status' => 'success', 'content' => $insert,'parents'=>$parents]);
				}


			}

		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'class_fund_book_teacher') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
		$date=date('Y-m-d');
				$course=$database->get("course" , "*",[
					"AND" => [
						"id"=>$xss->xss($data['id_course']),
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$class_diagram=$database->get("class_diagram" , "*",[
					"AND" => [
						"course"=>$course['id'],
						"homeroom_teacher"=>$payload['accounts'],
						"school"=>$xss->xss($data['id_school_teacher']),
						"status" => 'A',
						"deleted" => 0,
					]
				]);
			
			$class_fund_book = $database->select("class_fund_book", "*", [
				"AND" => [
					"class_diagram" =>$class_diagram['id'],
					"school" =>$xss->xss($data['id_school_teacher']),
					"status" => 'A',
					"deleted" => 0,
				]
			]);

			foreach ($class_fund_book as $data){
				$month_year1 = date('Y-m');

				$date_str =$data['date'];
				$timestamp = strtotime($date_str);
				$month_year = date('Y-m', $timestamp);
				if($month_year1==$month_year){
					$datanew[]=$data;
				}
				
			}
			foreach ($datanew as $data){
				$sum+=$data['price'];

			}
			echo json_encode(['status' => 'success', 'content' => $datanew,'sum'=>$sum,'month_year'=>$month_year1]);

		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'revenue_expenditure_teacher') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']) {
				$course=$database->get("course" , "*",[
					"AND" => [
						"id"=>$xss->xss($data['id_course']),
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$class_diagram=$database->get("class_diagram" , "*",[
					"AND" => [
						"course"=>$course['id'],
						"homeroom_teacher"=>$payload['accounts'],
						"school"=>$xss->xss($data['id_school_teacher']),
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$revenue_expenditure = $database->select("revenue_expenditure", "*", [
					"AND" => [
						"class_diagram" =>$class_diagram['id'],
						"school" =>$xss->xss($data['id_school_teacher']),
						"status" => 'A',
						"deleted" => 0,
					]
				]);
			//$month_year1 = $router['2'];
				foreach ($revenue_expenditure as $data){
					$month_year1 = $router['2'];
					$date_str =$data['date'];
					$timestamp = strtotime($date_str);
					$month_year = date('Y-m', $timestamp);
					if($month_year1==$month_year){
						$datanew[]=$data;
					}
				}
				foreach ($datanew as $data){
					$sum+=$data['price'];

				}
				echo json_encode(['status' => 'success', 'content' => $datanew,'sum'=>$sum,'month_year'=>$month_year1]);
			}
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'class_fund_book_click_teacher') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']) {
				$course=$database->get("course" , "*",[
					"AND" => [
						"id"=>$xss->xss($data['id_course']),
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$class_diagram=$database->get("class_diagram" , "*",[
					"AND" => [
						"course"=>$course['id'],
						"homeroom_teacher"=>$payload['accounts'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$class_fund_book = $database->select("class_fund_book", "*", [
					"AND" => [
						"class_diagram" =>$class_diagram['id'],
					     "school" =>$xss->xss($data['id_school_teacher']),
						"status" => 'A',
						"deleted" => 0,
					]
				]);

				foreach ($class_fund_book as $valu){
					$month_year1 = $router['2'];
					$date_str =$valu['date'];
					$timestamp = strtotime($date_str);
					$month_year = date('Y-m', $timestamp);
					if($month_year1==$month_year){
						$datanew[]=$valu;
					}

				}
				foreach ($datanew as $new){
					$sum+=$new['price'];

				}
				$revenue_expenditure = $database->select("revenue_expenditure", "*", [
					"AND" => [
						"class_diagram" =>$class_diagram['id'],
						"school" =>$xss->xss($data['id_school_teacher']),
						"status" => 'A',
						"deleted" => 0,
					]
				]);
			//$month_year1 = $router['2'];
				foreach ($revenue_expenditure as $data2){
					$month_year1 = $router['2'];
					$date_str2 =$data2['date'];
					$timestamp2 = strtotime($date_str2);
					$month_year2 = date('Y-m', $timestamp2);
					if($month_year1==$month_year2){
						$datanew2[]=$data2;
					}
				}
				foreach ($datanew2 as $data4){
					$sum1+=$data4['price'];

				}


				echo json_encode(['status' => 'success', 'thu' => $datanew,'chi' =>$datanew2,'sum2'=>$sum1,'sum1'=>$sum,'month_year'=>$month_year1]);
			}
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'car_schedule_go_teacher') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			$course=$database->get("course" , "*",[
					"AND" => [
						"id"=>$xss->xss($data['id_course']),
						"status" => 'A',
						"deleted" => 0,
					]
				]);
			  $date=date('Y-m-d');
				$semester=$database->get("semester" , "*",[
					"AND" => [
						"enddate[>=]"=> $date,
						"startdate[<=]"=> $date,
						"course"=>$course['id'],
						"school"=>$xss->xss($data['id_school_teacher']),
						"status" => 'A',
						"deleted" => 0,
					]
				]);

				$class_diagram=$database->get("class_diagram" , "*",[
					"AND" => [
						"course"=>$course['id'],
						"homeroom_teacher"=>$payload['accounts'],
						"school"=>$xss->xss($data['id_school_teacher']),
						"status" => 'A',
						"deleted" => 0,
					]
				]);

				$arrange_class=$database->select("arrange_class" , "*",[
					"AND" => [
						"school"=>$xss->xss($data['id_school_teacher']),
						"class_diagram"=>$class_diagram['id'],
						"school"=>$xss->xss($data['id_school_teacher']),
						"status" => 'A',
						"deleted" => 0,
					]
				]);

				foreach($arrange_class as $valu){
					$student_register_car=$database->get("student_register_car" , "*",[
					"AND" => [
						"arrange_class"=>$valu['id'],
						"semester"=>$semester['id'],
						"school"=>$xss->xss($data['id_school_teacher']),
						"status" => 'A',
						"deleted" => 0,
					]
				]);
					if ($student_register_car!=null) {
				
					$student_register_car_new[]=$student_register_car;
				}
			}


			$car_schedule=$database->select("car_schedule" , "*",[
				"AND" => [
					"date"=>$today = date("Y-m-d"),
					"type"=>1,
					"status" => 'A',
					"deleted" => 0,
				],
			]);
			
			$stt = 1;
			foreach ($car_schedule as $data) {
				$driver = $database->get("driver", "*", [
					"AND" => [
						"id" => $data['driver'],
						"school"=>$data['school'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$car= $database->get("car", "*", [
					"AND" => [
						"id" => $data['car'],
						"school"=>$data['school'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				
				$car_schedule_go[]= [
					"STT"=>$stt,
					"id_schedule" => $data['id'],
					"driver" =>$data['driver'],
					"namedriver" => $driver['name'],
					"typecar" => $car['typecar'],
					"frame_number" => $car['frame_number'],
					"license_plates" => $car['license_plates'],
					"date" => $data['date'],
					
				];
				$stt++;

			} 
			echo json_encode(['status' => 'success','today'=>$today,'content' => $car_schedule_go]);

		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'car_schedule_comeback_teacher') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']) {
				$course=$database->get("course" , "*",[
					"AND" => [
						"id"=>$xss->xss($data['id_course']),
						"status" => 'A',
						"deleted" => 0,
					]
				]);
			  $date=date('Y-m-d');
				$semester=$database->get("semester" , "*",[
					"AND" => [
						"enddate[>=]"=> $date,
						"startdate[<=]"=> $date,
						"course"=>$course['id'],
						"school"=>$xss->xss($data['id_school_teacher']),
						"status" => 'A',
						"deleted" => 0,
					]
				]);

				$class_diagram=$database->get("class_diagram" , "*",[
					"AND" => [
						"course"=>$course['id'],
						"homeroom_teacher"=>$payload['accounts'],
						"school"=>$xss->xss($data['id_school_teacher']),
						"status" => 'A',
						"deleted" => 0,
					]
				]);

				$arrange_class=$database->select("arrange_class" , "*",[
					"AND" => [
						"school"=>$xss->xss($data['id_school_teacher']),
						"class_diagram"=>$class_diagram['id'],
						"school"=>$xss->xss($data['id_school_teacher']),
						"status" => 'A',
						"deleted" => 0,
					]
				]);

				foreach($arrange_class as $valu){
					$student_register_car=$database->get("student_register_car" , "*",[
					"AND" => [
						"arrange_class"=>$valu['id'],
						"semester"=>$semester['id'],
						"school"=>$xss->xss($data['id_school_teacher']),
						"status" => 'A',
						"deleted" => 0,
					]
				]);
					if ($student_register_car!=null) {
				
					$student_register_car_new[]=$student_register_car;
				}
			}


			$car_schedule=$database->select("car_schedule" , "*",[
				"AND" => [
					"date"=>$router['2'],
					"type"=>2,
					"status" => 'A',
					"deleted" => 0,
				],
			]);
				$stt = 1;
				foreach ($car_schedule as $data) {
					$driver = $database->get("driver", "*", [
						"AND" => [
							"id" => $data['driver'],
							"school"=>$data['school'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					$car= $database->get("car", "*", [
						"AND" => [
							"id" => $data['car'],
							"school"=>$data['school'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);

					$car_schedule_go[]= [
						"STT"=>$stt,
						"id_schedule" => $data['id'],
						"driver" =>$data['driver'],
						"namedriver" => $driver['name'],
						"typecar" => $car['typecar'],
						"frame_number" => $car['frame_number'],
						"license_plates" => $car['license_plates'],
						"date" => $data['date'],

					];
					$stt++;

				} 
				echo json_encode(['status' => 'success','today'=>$router['2'],'content' => $car_schedule_go]);
			}
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'car_schedule_go_teacher_search') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']) {
				$course=$database->get("course" , "*",[
									"AND" => [
										"id"=>$xss->xss($data['id_course']),
										"status" => 'A',
										"deleted" => 0,
									]
								]);
							  $date=date('Y-m-d');
								$semester=$database->get("semester" , "*",[
									"AND" => [
										"enddate[>=]"=> $date,
										"startdate[<=]"=> $date,
										"course"=>$course['id'],
										"school"=>$xss->xss($data['id_school_teacher']),
										"status" => 'A',
										"deleted" => 0,
									]
								]);

								$class_diagram=$database->get("class_diagram" , "*",[
									"AND" => [
										"course"=>$course['id'],
										"homeroom_teacher"=>$payload['accounts'],
										"school"=>$xss->xss($data['id_school_teacher']),
										"status" => 'A',
										"deleted" => 0,
									]
								]);

								$arrange_class=$database->select("arrange_class" , "*",[
									"AND" => [
										"school"=>$xss->xss($data['id_school_teacher']),
										"class_diagram"=>$class_diagram['id'],
										"school"=>$xss->xss($data['id_school_teacher']),
										"status" => 'A',
										"deleted" => 0,
									]
								]);

								foreach($arrange_class as $valu){
									$student_register_car=$database->get("student_register_car" , "*",[
									"AND" => [
										"arrange_class"=>$valu['id'],
										"semester"=>$semester['id'],
										"school"=>$xss->xss($data['id_school_teacher']),
										"status" => 'A',
										"deleted" => 0,
									]
								]);
									if ($student_register_car!=null) {
								
									$student_register_car_new[]=$student_register_car;
								}
							}


							$car_schedule=$database->select("car_schedule" , "*",[
								"AND" => [
									"date"=>$router['2'],
									"type"=>1,
									"status" => 'A',
									"deleted" => 0,
								],
							]);
				$stt = 1;
				foreach ($car_schedule as $data) {
					$driver = $database->get("driver", "*", [
						"AND" => [
							"id" => $data['driver'],
							"school"=>$data['school'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					$car= $database->get("car", "*", [
						"AND" => [
							"id" => $data['car'],
							"school"=>$data['school'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);

					$car_schedule_go[]= [
						"STT"=>$stt,
						"id_schedule" => $data['id'],
						"driver" =>$data['driver'],
						"namedriver" => $driver['name'],
						"typecar" => $car['typecar'],
						"frame_number" => $car['frame_number'],
						"license_plates" => $car['license_plates'],
						"date" => $data['date'],

					];
					$stt++;

				}
				$car_schedule2=$database->select("car_schedule" , "*",[
								"AND" => [
									"date"=>$router['2'],
									"type"=>2,
									"status" => 'A',
									"deleted" => 0,
								],
							]);
				$stt2 = 1;
				foreach ($car_schedule2 as $value) {
					$driver = $database->get("driver", "*", [
						"AND" => [
							"id" => $value['driver'],
							"school"=>$value['school'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					$car= $database->get("car", "*", [
						"AND" => [
							"id" => $value['car'],
							"school"=>$value['school'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);

					$car_schedule_back[]= [
						"STT"=>$stt2,
						"id_schedule" => $value['id'],
						"driver" =>$value['driver'],
						"namedriver" => $driver['name'],
						"typecar" => $car['typecar'],
						"frame_number" => $car['frame_number'],
						"license_plates" => $car['license_plates'],
						"date" => $value['date'],

					];
					$stt2++;

				}  
				echo json_encode(['status' => 'success','today'=>$router['2'],'go' => $car_schedule_go,'back' => $car_schedule_back]);
			}
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'car_driver_teacher') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']) {
				$car_schedule=$database->get("car_schedule" , "*",[
					"AND" => [
						"id"=>$router['2'],
						"status" => 'A',
						"deleted" => 0,
					],
				]);
				$route=$database->get("route" , "*",[
					"AND" => [
						"id"=>$car_schedule['route'],
						"status" => 'A',
						"deleted" => 0,
					],
				]);

				$driver = $database->get("driver", "*", [
					"AND" => [
						"id"=>$car_schedule['driver'],
						"status" => "A",
						"deleted" => 0,
					]
				]);
				$driver2 = $database->select("driver", "*", [
					"AND" => [
						"id"=>$car_schedule['driver'],
						"status" => "A",
						"deleted" => 0,
					]
				]);
				$ward = $database->get("ward", "*", [
					"AND" => [
						"id" => $driver['ward'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$province = $database->get("province", "*", [
					"AND" => [
						"id" => $driver['province'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$district = $database->get("district", "*", [
					"AND" => [
						"id" => $driver['district'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$course=$database->get("course" , "*",[
					"AND" => [
						"id"=>$xss->xss($data['id_course']),
						"status" => 'A',
						"deleted" => 0,
					]
				]);

			  $date=date('Y-m-d');
				$semester=$database->get("semester" , "*",[
					"AND" => [
						"enddate[>=]"=> $date,
						"startdate[<=]"=> $date,
						"course"=>$course['id'],
						"school"=>$xss->xss($data['id_school_teacher']),
						"status" => 'A',
						"deleted" => 0,
					]
				]);

				$class_diagram=$database->get("class_diagram" , "*",[
					"AND" => [
						"course"=>$course['id'],
						"homeroom_teacher"=>$payload['accounts'],
						"school"=>$xss->xss($data['id_school_teacher']),
						"status" => 'A',
						"deleted" => 0,
					]
				]);

				$arrange_class=$database->select("arrange_class" , "*",[
					"AND" => [
						"school"=>$xss->xss($data['id_school_teacher']),
						"class_diagram"=>$class_diagram['id'],
						"school"=>$xss->xss($data['id_school_teacher']),
						"status" => 'A',
						"deleted" => 0,
					]
				]);

				foreach($arrange_class as $valu){
					$student_register_car=$database->get("student_register_car" , "*",[
					"AND" => [
						"arrange_class"=>$valu['id'],
						"semester"=>$semester['id'],
						"school"=>$xss->xss($data['id_school_teacher']),
						"status" => 'A',
						"deleted" => 0,
					]
				]);
					if ($student_register_car!=null) {
				
					$student_register_car_new[]=$student_register_car;
				}
			}

				foreach ($student_register_car_new as $student_register){
					$car_schedule_detail=$database->get("car_schedule_detail" , "*",[
					"AND" => [
						"car_schedule"=>$car_schedule['id'],
						"student_register_car"=>$student_register['id'],
						"status" => 'A',
						"deleted" => 0,
					],
				]);
					if($car_schedule_detail!=null){
					$new_students[]=$car_schedule_detail;
					}
				}
				foreach($new_students as $hs){
					$student_schedule_detail=$database->get("student_register_car" , "*",[
					"AND" => [
						"id"=>$hs['student_register_car'],
						"school"=>$xss->xss($data['id_school_teacher']),
						"status" => 'A',
						"deleted" => 0,
					],
				]);
					if ($student_schedule_detail!=null) {
						$register_car_list[]=$student_schedule_detail;
					}
					
				}
				foreach($register_car_list as $hs2){
					$arrange_class_2=$database->get("arrange_class" , "*",[
					"AND" => [
						"id"=>$hs2['arrange_class'],
						"school"=>$xss->xss($data['id_school_teacher']),
						"status" => 'A',
						"deleted" => 0,
					],
				]);
					$arrange_class_new[]=$arrange_class_2;
				}
				foreach($arrange_class_new as $hs3){
					$students=$database->get("students" , "*",[
					"AND" => [
						"id"=>$hs3['students'],
						"school"=>$xss->xss($data['id_school_teacher']),
						"status" => 'A',
						"deleted" => 0,
					],
				]);
					$student_list_car[]=$students;
				}
	
				echo json_encode(['status' => 'success','driver' => $driver2,'ward'=>$ward['name'] ,'province'=>$province['name'],'district'=>$district['name'],'route'=>$route['name'],'student_schedule'=>$student_list_car]);
			}
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'news_teacher') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			$news = $database->select("news", "*", [
				"AND" => [
					"school" => $xss->xss($data['id_school_teacher']),
					"status" => "A",
					"deleted" => 0,
				]
			]);
			foreach($news as $text){
					//$text2 = json_decode($text, true);
					$html = str_replace('"', "'", $text['content']);
					 $html = str_replace('../../', "https://school.hewo.vn/", $html);
					// $html1 = str_replace('</p>', "", $html1);
					// // $decodedContent = stripslashes($text['content']);
					// $decodedContent = html_entity_decode($decodedContent);
					$news_school[]=[
						"id"=>$text['id'],
						"name"=>$text['name'],
						"date"=>$text['date'],
						"description"=>$text['description'],
						"content"=>$html,
						"avatar"=>$text['avatar'],
					];

				}

			$school_announcement = $database->select("school_announcement", "*", [
				
				"school" => $xss->xss($data['id_school_teacher']),
				"status" => 'A',
				"deleted" => 0,
				"LIMIT"=>10,
				"ORDER" => ["id" => "DESC"]

			]);
			echo json_encode(['status' => 'success', 'news' => $news,'school_announcement'=>$school_announcement]);
		}
	} elseif ($router['1'] == 'tuition_debt') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if($router['2']){
				$student=$database->get("students", "*", [
					"AND" => [
						
						"id" => $xss->xss($data['id_student']),
						"status" => 'A',
						"deleted" => 0,
					]
				]);
			
				$arrange_class = $database->get("arrange_class", "*", [
					"AND" => [
						
						"students" => $xss->xss($data['id_student']),
						"class_diagram" => $router['2'],
						"status" => 'A',
						"deleted" => 0,
						"school" => $student['school'],
					]
				]);
				$students = $database->get("students", "*", [
					"AND" => [
						"id" => $arrange_class['students'],
						"status" => "A",
						"deleted" => 0,
					]
				]);
				$class_diagram = $database->get("class_diagram", "*", [
					"AND" => [
						"school" => $students['school'],
						"id" => $router['2'],
						"status" => "A",
						"deleted" => 0,
					]
				]);
				
				$courses=$database->get("course", "*", [
					"AND" => [
						"school" => $students['school'],
						"id" => $class_diagram['course'],
						"status" => "A",
						"deleted" => 0,
					]
				]);
				$content_tuitions = $database->select("content_tuition", "*", [
					"AND" => [
						"type"=>[0,1],
						"school" => $students['school'],
						"class_diagram" =>$arrange_class['class_diagram'],
						"status" => "A",
						"deleted" => 0,  
					]

				]);
				$months=date('m');
				if($months<=12 && $months>= date("m", strtotime($courses['startdate']))){
					$month=[
						"months"=>$months,
						"year"=>date("Y", strtotime($courses['startdate'])),
					];
				}elseif($months>=1 && $months<= date("m", strtotime($courses['enddate']))){
					$month=[
						"months"=>$months,
						"year"=>date("Y", strtotime($courses['enddate'])),
					];
				} 
				$tuition_order_detail = $database->select("tuition_order_detail", "*", [
					"AND" => [
						"school" => $students['school'],
						"arrange_class" =>$arrange_class['id'],
						"status" => "A",
						"deleted" => 0,
					]
				]);
				foreach($content_tuitions as $content_tuition){
					$datas1[]=[
						"id"=>$content_tuition['id'],
						"content"=>$content_tuition['content'],
						"class_diagram"=>$content_tuition['class_diagram'],
						"price"=>$content_tuition['price'],
						"payment_deadline"=>$month['year'],
						"month"=>$month['months'],
						"number_of_month"=>$content_tuition['number_of_month'],  
					];
				}
	            
				$m=date("m", strtotime($student['year_of_admission']));
				$y=date("Y", strtotime($student['year_of_admission']));
				if(($month['months'] >= $m && $month['year'] == $y) || ($month['months'] < $m && $month['year'] > $y)){
					if($tuition_order_detail==[]){
						foreach($datas1 as $data){
							$congno[]=[
								'month'=>$data['month'],
								//'semester'=>$data['semester'],
								'content'=>$data['content'],
								'price'=>$data['price'],
								'type'=> 'Chưa đóng'
							];
							
						}
					}else{
						foreach($datas1 as $data){
							$found = false; // Khởi tạo biến found là false
							foreach($tuition_order_detail as $value){
								// So sánh giá trị của $data["id"] với $value
								if ($data["id"] == $value['content_tuition'] && $data['month']==$value['month']) {
									$found = true; // Nếu tìm thấy, đánh dấu là true
									break; // Thoát khỏi vòng lặp nếu đã tìm thấy
								}
							}
						
							// Dựa vào giá trị của biến $found để đưa vào mảng $congno
							if($found){
								// $congno[]=[
								// 	'month'=>$data['month'],
								// 	'content'=>$data['content'],
								// 	'price'=>$data['price'],
								// 	'type'=> 'Đã đóng'
								// ];
							}else{
								$congno[]=[
									'month'=>$data['month'],
									'content'=>$data['content'],
									'price'=>$data['price'],
									'type'=> 'Chưa đóng'
								];
							}
						}
						
					}
					$tong=0;
				
					foreach($congno as $count){
						$tong=$tong+$count['price'];
					}
				}
				
				echo json_encode(['status' => 'success', 'content' =>$congno,'tong'=>$tong]);
			}
		}
	} elseif ($router['1'] == 'health_student_teacher') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			$class_diagram = $database->get("class_diagram", "*", [
					    "AND" => [
					        "course"=>$xss->xss($data['id_course']),
					        "homeroom_teacher"=> $payload['accounts'],
					        "school"=>$xss->xss($data['id_school_teacher']),
					        "status" => 'A',
						    "deleted" => 0,
					    ]
					]); 
			$arrange_class=$database->select("arrange_class" , "*",[
					"AND" => [
						"class_diagram"=>$class_diagram['id'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				foreach($arrange_class as $arrange_class){
				$students=$database->get("students" , "*",[
					"AND" => [
						"id"=>$arrange_class['students'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$student_list[]=$students;
			}
				echo json_encode(['status' => 'success', 'liststudent'=>$student_list]);
			} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'health_student_teacher_click') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
				if ($router['2']) {
					$students = $database->get("students", "*", [
						"AND" => [
							"id" => $router['2'],
							
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					$getStudent = $database->get("students", "*", [
						"AND" => [
							"id" => $router['2'],
							
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					$health_student = $database->select("health", "*", [
						"AND" => [
							"students" => $router['2'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					$vaccination = $database->select("vaccination", "*", [
						"AND" => [
							"students" => $router['2'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);

				}
			echo json_encode(['status' => 'success', 'content' => $students, 'health' => $health_student, 'vaccination' => $vaccination]);
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'attendance_student_teacher') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {

			$today_date = date("N");
				if ($today_date==1) {
					$startDate =date('Y-m-d', strtotime('Monday'));
					$date = strtotime('Monday');
					$endDate = date('Y-m-d',strtotime('+6 days',$date));

					} else{
					$startDate =date('Y-m-d', strtotime('last Monday'));
					$date = strtotime('last Monday');
					$endDate = date('Y-m-d',strtotime('+6 days',$date));
					}

			$class_diagram = $database->get("class_diagram", "*", [
					    "AND" => [
					        "course"=>$xss->xss($data['id_course']),
					        "homeroom_teacher"=> $payload['accounts'],
					        "school"=>$xss->xss($data['id_school_teacher']),
					        "status" => 'A',
						    "deleted" => 0,
					    ]
					]); 

			$students=$database->select("arrange_class" , "*",[
				"AND" => [
					"class_diagram"=>$class_diagram['id'],
					"school"=>$xss->xss($data['id_school_teacher']),
					"status" => "A",
					"deleted" => 0,
				]
			]);
			foreach($students as $data2){
				$timekeeping=$database->get("timekeeping" , "*",[
					"AND" => [
						"date"=>$date=date('Y-m-d'),
						"arrange_class"=>$data2['id'],
						"school"=>$data2['school'],

					]
				]);
				$student=$database->get("students" , "*",[
				"AND" => [
					"id"=>$data2['students'],
					"school"=>$xss->xss($data['id_school_teacher']),
					"status" => "A",
					"deleted" => 0,
				]
			]);
				if ($timekeeping==null) {	
					$type=0;	
					$timekeepingnew[]=[
						'id'=>null,
						'arrange_class'=>$data2['id'],
						'id_student'=>$student['id_student'],
						'firstname'=>$student['firstname'],
						'lastname'=>$student['lastname'],
						'date'=>null,
						'checkin'=>null,
						'checkout'=>null,
						'school'=>null,
						'date_poster'=>null,


						'type'=>$type,

					];
				} elseif ($timekeeping!=null && $timekeeping['checkin']!=null && $timekeeping['checkout']!=null ){
					$type=1;
					$timekeepingnew[]=[
						'id'=>$timekeeping['id'],
						'id_student'=>$student['id_student'],
						'students'=>$timekeeping['students'],
						'firstname'=>$student['firstname'],
						'lastname'=>$student['lastname'],
						'date'=>$timekeeping['date'],
						'checkin'=>$timekeeping['checkin'],
						'checkout'=>$timekeeping['checkout'],
						'school'=>$timekeeping['school'],
						'date_poster'=>$timekeeping['date_poster'],

						'type'=>$type,

					];

				}elseif ($timekeeping!=null && $timekeeping['checkin']==null && $timekeeping['checkout']==null ){
					$type=3;
					$timekeepingnew[]=[
						'id'=>$timekeeping['id'],
						'id_student'=>$student['id_student'],
						'students'=>$timekeeping['students'],
						'firstname'=>$student['firstname'],
						'lastname'=>$student['lastname'],
						'date'=>$timekeeping['date'],
						'checkin'=>$timekeeping['checkin'],
						'checkout'=>$timekeeping['checkout'],
						'school'=>$timekeeping['school'],
						'date_poster'=>$timekeeping['date_poster'],
						'type'=>$type,

					];

				} else{
					$type=2;
					$timekeepingnew[]=[
						'id'=>$timekeeping['id'],
						'id_student'=>$student['id_student'],
						'students'=>$timekeeping['students'],
						'firstname'=>$student['firstname'],
						'lastname'=>$student['lastname'],
						'date'=>$timekeeping['date'],
						'checkin'=>$timekeeping['checkin'],
						'checkout'=>$timekeeping['checkout'],
						'school'=>$timekeeping['school'],
						'date_poster'=>$timekeeping['date_poster'],
						'type'=>$type,

					];

				}
			}
			echo json_encode(['status' => 'success','content' =>$timekeepingnew,]);

		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'attendance_student_teacher_search') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']) {
				$class_diagram = $database->get("class_diagram", "*", [
					    "AND" => [
					        "course"=>$xss->xss($data['id_course']),
					        "homeroom_teacher"=> $payload['accounts'],
					        "school"=>$xss->xss($data['id_school_teacher']),
					        "status" => 'A',
						    "deleted" => 0,
					    ]
					]); 

			$students=$database->select("arrange_class" , "*",[
				"AND" => [
					"class_diagram"=>$class_diagram['id'],
					"school"=>$xss->xss($data['id_school_teacher']),
					"status" => "A",
					"deleted" => 0,
				]
			]);
				foreach($students as $data2){
					$timekeeping=$database->get("timekeeping" , "*",[
						"AND" => [
							"date"=>$router['2'],
							"arrange_class"=>$data2['id'],
							"school"=>$data2['school'],

						]
					]);
					$student=$database->get("students" , "*",[
						"AND" => [
							"id"=>$data2['students'],
							"school"=>$xss->xss($data['id_school_teacher']),
							"status" => "A",
							"deleted" => 0,
						]
					]);
					if ($timekeeping==null) {	
						$type=0;	
						$timekeepingnew[]=[
							'id'=>null,
							'students'=>$data2['id'],
							'id_student'=>$student['id_student'],
							'firstname'=>$student['firstname'],
							'lastname'=>$student['lastname'],
							'date'=>null,
							'checkin'=>null,
							'checkout'=>null,
							'school'=>null,
							'date_poster'=>null,


							'type'=>$type,

						];
					} elseif ($timekeeping!=null && $timekeeping['checkin']!=null && $timekeeping['checkout']!=null ){
						$type=1;
						$timekeepingnew[]=[
							'id'=>$timekeeping['id'],
							'id_student'=>$student['id_student'],
							'students'=>$timekeeping['students'],
							'firstname'=>$student['firstname'],
							'lastname'=>$student['lastname'],
							'date'=>$timekeeping['date'],
							'checkin'=>$timekeeping['checkin'],
							'checkout'=>$timekeeping['checkout'],
							'school'=>$timekeeping['school'],
							'date_poster'=>$timekeeping['date_poster'],

							'type'=>$type,

						];

					}elseif ($timekeeping!=null && $timekeeping['checkin']==null && $timekeeping['checkout']==null ){
						$type=3;
						$timekeepingnew[]=[
							'id'=>$timekeeping['id'],
							'id_student'=>$student['id_student'],
							'students'=>$timekeeping['students'],
							'firstname'=>$student['firstname'],
							'lastname'=>$student['lastname'],
							'date'=>$timekeeping['date'],
							'checkin'=>$timekeeping['checkin'],
							'checkout'=>$timekeeping['checkout'],
							'school'=>$timekeeping['school'],
							'date_poster'=>$timekeeping['date_poster'],
							'type'=>$type,

						];

					} else{
						$type=2;
						$timekeepingnew[]=[
							'id'=>$timekeeping['id'],
							'id_student'=>$student['id_student'],
							'students'=>$timekeeping['students'],
							'firstname'=>$student['firstname'],
							'lastname'=>$student['lastname'],
							'date'=>$timekeeping['date'],
							'checkin'=>$timekeeping['checkin'],
							'checkout'=>$timekeeping['checkout'],
							'school'=>$timekeeping['school'],
							'date_poster'=>$timekeeping['date_poster'],
							'type'=>$type,

						];

					}
				}
				echo json_encode(['status' => 'success','content' => $timekeepingnew,]);
			}
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'student_class_teacher') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']) {
			$course=$database->get("course" , "*",[
					"AND" => [
						"id"=>$xss->xss($data['id_course']),
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$class_diagram=$database->get("class_diagram" , "*",[
					"AND" => [
						"course"=>$course['id'],
						"homeroom_teacher"=>$payload['accounts'],
						"school"=>$xss->xss($data['id_school_teacher']),
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$arrange_class=$database->select("arrange_class" , "*",[
										"AND" => [
											"class_diagram"=>$class_diagram['id'],
											"status" => 'A',
											"deleted" => 0,
										]
									]);
				foreach($arrange_class as $value){

			$students=$database->get("students" , "*",[
				"AND" => [
					"id"=>$value['students'],
					"school"=>$xss->xss($data['id_school_teacher']),
					"status" => "A",
					"deleted" => 0,
				]
			]);
			if ($students!=null) {
				$listStudent[]=[
					"id_arrange_class"=>$value['id'],
					"firstname"=>$students['firstname'],
					"lastname"=>$students['lastname'],
					"id_student"=>$students['id_student'],
				];
			}

			}
			foreach($listStudent as $list){
			//	$timekeeping2= $list['id_arrange_class'];
				$timekeeping=$database->get("timekeeping" , "*",[
						"AND" => [
							"date"=>$router['2'],
							"arrange_class"=> $list['id_arrange_class'],
							//"school"=>$data2['school'],

						]
					]);
				if ($timekeeping==null || $timekeeping['checkin']==null || $timekeeping['checkout']==null) {
					$listStudent_2[]=$list;
				} 
			}
			}
			echo json_encode(['status' => 'success','content' =>$listStudent_2]);

		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'timekeeping_add_teacher') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']!=0 && isset($router['2'])) {
				$timekeeping=$database->get("timekeeping" , "*",[
					"AND" => [
						"date"=>$data['date'],
						"arrange_class"=>$router['2'],
						"school"=>$data['id_school_teacher'],

					]
				]);
				$datetime =  $xss->xss($data['date']) . ' ' . $xss->xss($data['check']);
			    $datetime_formatted = date('Y-m-d H:i:s', strtotime($datetime));

				
				if( $data['check'] != ""  && $data['type'] == 1 && $timekeeping!=null){		  	
					if( $data['date'] == ""|| $data['check'] == ""|| $data['id_school_teacher'] == "")
					{
						echo json_encode(['status' => 'error', 'content' => 'Lỗi dữ liệu trống']);
					} elseif($data['date'] && $data['id_school_teacher'] && $data['check'] ){
						$update = [
							"date" => $xss->xss($data['date']),
							"arrange_class" => $router['2'],
							"checkin" => $xss->xss($data['check']),
							"date_poster" => date('Y-m-d H:i:s'),
							"school" =>  $xss->xss($data['id_school_teacher']),
						];
						
						$insert_timekeeping_details = [
							"date" =>$datetime_formatted,
							"notes"=>$xss->xss($data['notes']),
							"arrange_class" => $router['2'],
							"status" => $xss->xss($data['type']),
							"deleted" => 0,
							"accounts" =>  $payload['accounts'],
							"date_poster" => date('Y-m-d H:i:s'),
							"school" =>  $xss->xss($data['id_school_teacher']),
						];
					}
					$database->insert("timekeeping_details", $insert_timekeeping_details);
					$jatbi->logs('timekeeping_details', 'add', $insert_timekeeping_details);

					$database->update("timekeeping", $update,["id"=>$timekeeping['id']]);
					$jatbi->logs('timekeeping', 'add', $insert);
					$arrange_class = $database->get("arrange_class", "*", [
						"AND" => [
							"id" => $router['2'],
							"status" => 'A',
							"deleted" => 0,
						]
					    ]);
					    $teacher = $database->get("teacher", "*", [
						"AND" => [
							"id" => $payload['accounts'],
							"status" => 'A',
							"deleted" => 0,
						]
					    ]);
					    $students = $database->get("students", "*", [
						"AND" => [
							"id" =>$arrange_class['students'],
							"status" => 'A',
							"deleted" => 0,
						]
					    ]);
					        $parent = $database->get("parent", "*", [
						"AND" => [
							"id" =>$students['parent'],
							"status" => 'A',
							"deleted" => 0,
						]
					    ]);

					    $school = $database->get("school", "*", [
						"AND" => [
							"id" => $xss->xss($data['id_school_teacher']),
							"status" => 'A',
							"deleted" => 0,
						]
				]);
					     $device = $database->select("device_parent","device_id",[
					     	"school"=>$data['id_school_teacher'],
					     	"parent"=>$parent['id'],
					     	"deleted"=> 0,
					     	"status"=>'A']);
					 function sendNotification($title,$message,$device) {
                            $content = array(
                                "en" => $message // Nội dung thông báo (có thể thay đổi ngôn ngữ ở đây)
                            );
                        
                            $fields = [
                                'app_id' => 'c0bd1290-a222-4a69-b48f-e1a756d3e1b6', // ID ứng dụng OneSignal của bạn
                                'include_player_ids' =>$device, // Danh sách các device token
                                'contents' => $content,
                                'headings' => array("en" => $title) // Tiêu đề thông báo
                            ];
                        
                            $fields = json_encode($fields);
                        
                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                'Content-Type: application/json; charset=utf-8',
                                'Authorization: Basic ODQzZTk1NmMtMjIwNi00NmNhLTgxZDMtMzg2NTBkODJjYTBl' // Thay YOUR_REST_API_KEY bằng khóa REST API của bạn
                            ));
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_HEADER, false);
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        
                            $result = curl_exec($ch);
                        
                            if ($result === FALSE) {
                                die('Curl failed: ' . curl_error($ch));
                            }
                        
                            curl_close($ch);
                        
                            return $result;
                        }
                        
                        // Gọi hàm sendNotification để gửi thông báo đẩy
                        $title =  $school['name'];
                        $message = "Giáo viên ".$teacher['fullname']. " đã điểm danh cho học sinh ".$students['fullname'];
                        $result = sendNotification($title,$message,$device);
					echo json_encode(['status' => 'success', 'content' => $update,'insert_timekeeping_details'=>$insert_timekeeping_details]);
				}

				if( $data['check'] != "" && $data['type'] ==2  && $timekeeping!=null){		  	
					if( $data['date'] == ""|| $data['check'] == ""|| $data['id_school_teacher'] == "")
					{
						echo json_encode(['status' => 'error', 'content' => 'Lỗi dữ liệu trống']);
					} elseif($data['date'] && $data['id_school_teacher'] && $data['check'] ){
						$update = [
							"date" => $xss->xss($data['date']),
							"arrange_class" => $router['2'],
							"checkout" => $xss->xss($data['check']),
							"date_poster" => date('Y-m-d H:i:s'),
							"school" =>  $xss->xss($data['id_school_teacher']),
						];
						$insert_timekeeping_details = [
							"date" =>$datetime_formatted,
							"notes"=>$xss->xss($data['notes']),
							"arrange_class" => $router['2'],
							"status" => $xss->xss($data['type']),
							"deleted" => 0,
							"accounts" =>  $payload['accounts'],
							"date_poster" => date('Y-m-d H:i:s'),
							"school" =>  $xss->xss($data['id_school_teacher']),
						];
					}
				$database->insert("timekeeping_details", $insert_timekeeping_details);
					$jatbi->logs('timekeeping_details', 'add', $insert_timekeeping_details);

					$database->update("timekeeping", $update,["id"=>$timekeeping['id']]);
					$jatbi->logs('timekeeping', 'add', $insert);
					$arrange_class = $database->get("arrange_class", "*", [
						"AND" => [
							"id" => $router['2'],
							"status" => 'A',
							"deleted" => 0,
						]
					    ]);
					    $teacher = $database->get("teacher", "*", [
						"AND" => [
							"id" => $payload['accounts'],
							"status" => 'A',
							"deleted" => 0,
						]
					    ]);
					    $students = $database->get("students", "*", [
						"AND" => [
							"id" =>$arrange_class['students'],
							"status" => 'A',
							"deleted" => 0,
						]
					    ]);
					        $parent = $database->get("parent", "*", [
						"AND" => [
							"id" =>$students['parent'],
							"status" => 'A',
							"deleted" => 0,
						]
					    ]);

					    $school = $database->get("school", "*", [
						"AND" => [
							"id" => $xss->xss($data['id_school_teacher']),
							"status" => 'A',
							"deleted" => 0,
						]
				]);
					     $device = $database->select("device_parent","device_id",[
					     	"school"=>$data['id_school_teacher'],
					     	"parent"=>$parent['id'],
					     	"deleted"=> 0,
					     	"status"=>'A']);
					 function sendNotification($title,$message,$device) {
                            $content = array(
                                "en" => $message // Nội dung thông báo (có thể thay đổi ngôn ngữ ở đây)
                            );
                        
                            $fields = [
                                'app_id' => 'c0bd1290-a222-4a69-b48f-e1a756d3e1b6', // ID ứng dụng OneSignal của bạn
                                'include_player_ids' =>$device, // Danh sách các device token
                                'contents' => $content,
                                'headings' => array("en" => $title) // Tiêu đề thông báo
                            ];
                        
                            $fields = json_encode($fields);
                        
                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                'Content-Type: application/json; charset=utf-8',
                                'Authorization: Basic ODQzZTk1NmMtMjIwNi00NmNhLTgxZDMtMzg2NTBkODJjYTBl' // Thay YOUR_REST_API_KEY bằng khóa REST API của bạn
                            ));
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_HEADER, false);
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        
                            $result = curl_exec($ch);
                        
                            if ($result === FALSE) {
                                die('Curl failed: ' . curl_error($ch));
                            }
                        
                            curl_close($ch);
                        
                            return $result;
                        }
                        
                        // Gọi hàm sendNotification để gửi thông báo đẩy
                        $title =  $school['name'];
                        $message = "Giáo viên ".$teacher['fullname']. " đã điểm danh cho học sinh ".$students['fullname'];
                        $result = sendNotification($title,$message,$device);
					echo json_encode(['status' => 'success', 'content' => $update,'insert_timekeeping_details'=>$insert_timekeeping_details]);


				}

				if( $data['check'] != "" && $data['type'] == 1 && $timekeeping==null){		  	
					if($data['date'] == ""|| $data['check'] == ""|| $data['id_school_teacher'] == "")
					{
						echo json_encode(['status' => 'error', 'content' => 'Lỗi dữ liệu trống']);
					} elseif($data['date'] && $data['id_school_teacher'] && $data['check'] ){
						$insert = [
							"date" => $xss->xss($data['date']),
							"arrange_class" => $router['2'],
							"checkin" => $xss->xss($data['check']),
							"checkout"=>null,
							"date_poster" => date('Y-m-d H:i:s'),
							"school" =>  $xss->xss($data['id_school_teacher']),
						];
						$insert_timekeeping_details = [
							"date" =>$datetime_formatted,
							"notes"=>$xss->xss($data['notes']),
							"arrange_class" => $router['2'],
							"status" => $xss->xss($data['type']),
							"deleted" => 0,
							"accounts" =>  $payload['accounts'],
							"date_poster" => date('Y-m-d H:i:s'),
							"school" =>  $xss->xss($data['id_school_teacher']),
						];
					}
					$database->insert("timekeeping_details", $insert_timekeeping_details);
					$jatbi->logs('timekeeping_details', 'add', $insert_timekeeping_details);

					$database->insert("timekeeping", $insert);
					$jatbi->logs('timekeeping', 'add', $insert);

						$arrange_class = $database->get("arrange_class", "*", [
						"AND" => [
							"id" => $router['2'],
							"status" => 'A',
							"deleted" => 0,
						]
					    ]);
					    $teacher = $database->get("teacher", "*", [
						"AND" => [
							"id" => $payload['accounts'],
							"status" => 'A',
							"deleted" => 0,
						]
					    ]);
					    $students = $database->get("students", "*", [
						"AND" => [
							"id" =>$arrange_class['students'],
							"status" => 'A',
							"deleted" => 0,
						]
					    ]);
					        $parent = $database->get("parent", "*", [
						"AND" => [
							"id" =>$students['parent'],
							"status" => 'A',
							"deleted" => 0,
						]
					    ]);

					    $school = $database->get("school", "*", [
						"AND" => [
							"id" => $xss->xss($data['id_school_teacher']),
							"status" => 'A',
							"deleted" => 0,
						]
				]);
					     $device = $database->select("device_parent","device_id",[
					     	"school"=>$data['id_school_teacher'],
					     	"parent"=>$parent['id'],
					     	"deleted"=> 0,
					     	"status"=>'A']);
					 function sendNotification($title,$message,$device) {
                            $content = array(
                                "en" => $message // Nội dung thông báo (có thể thay đổi ngôn ngữ ở đây)
                            );
                        
                            $fields = [
                                'app_id' => 'c0bd1290-a222-4a69-b48f-e1a756d3e1b6', // ID ứng dụng OneSignal của bạn
                                'include_player_ids' =>$device, // Danh sách các device token
                                'contents' => $content,
                                'headings' => array("en" => $title) // Tiêu đề thông báo
                            ];
                        
                            $fields = json_encode($fields);
                        
                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                'Content-Type: application/json; charset=utf-8',
                                'Authorization: Basic ODQzZTk1NmMtMjIwNi00NmNhLTgxZDMtMzg2NTBkODJjYTBl' // Thay YOUR_REST_API_KEY bằng khóa REST API của bạn
                            ));
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_HEADER, false);
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        
                            $result = curl_exec($ch);
                        
                            if ($result === FALSE) {
                                die('Curl failed: ' . curl_error($ch));
                            }
                        
                            curl_close($ch);
                        
                            return $result;
                        }
                        
                        // Gọi hàm sendNotification để gửi thông báo đẩy
                        $title =  $school['name'];
                        $message = "Giáo viên ".$teacher['fullname']. " đã điểm danh cho học sinh ".$students['fullname'];
                        $result = sendNotification($title,$message,$device);
					echo json_encode(['status' => 'success', 'content' => $insert,'insert_timekeeping_details'=>$insert_timekeeping_details]);


				}


				if( $data['check'] != "" && $data['type'] == 2 && $timekeeping==null){		  	
					if( $data['date'] == ""|| $data['check'] == ""|| $data['id_school_teacher'] == "")
					{
						echo json_encode(['status' => 'error', 'content' => 'Lỗi dữ liệu trống']);
					} elseif( $data['date'] && $data['id_school_teacher'] && $data['check'] ){
						$insert = [
							"date" => $xss->xss($data['date']),
							"arrange_class" => $router['2'],
							"checkout" => $xss->xss($data['check']),
							"checkin"=>null,
							"date_poster" => date('Y-m-d H:i:s'),
							"school" =>  $xss->xss($data['id_school_teacher']),
						];
							$insert_timekeeping_details = [
							"date" =>$datetime_formatted,
							"notes"=>$xss->xss($data['notes']),
							"arrange_class" => $router['2'],
							"status" => $xss->xss($data['type']),
							"deleted" => 0,
							"accounts" =>  $payload['accounts'],
							"date_poster" => date('Y-m-d H:i:s'),
							"school" =>  $xss->xss($data['id_school_teacher']),
						];
					}
					$database->insert("timekeeping_details", $insert_timekeeping_details);
					$jatbi->logs('timekeeping_details', 'add', $insert_timekeeping_details);


					$database->insert("timekeeping", $insert);
					$jatbi->logs('timekeeping', 'add', $insert);
					$arrange_class = $database->get("arrange_class", "*", [
						"AND" => [
							"id" => $router['2'],
							"status" => 'A',
							"deleted" => 0,
						]
					    ]);
					    $teacher = $database->get("teacher", "*", [
						"AND" => [
							"id" => $payload['accounts'],
							"status" => 'A',
							"deleted" => 0,
						]
					    ]);
					    $students = $database->get("students", "*", [
						"AND" => [
							"id" =>$arrange_class['students'],
							"status" => 'A',
							"deleted" => 0,
						]
					    ]);
					        $parent = $database->get("parent", "*", [
						"AND" => [
							"id" =>$students['parent'],
							"status" => 'A',
							"deleted" => 0,
						]
					    ]);

					    $school = $database->get("school", "*", [
						"AND" => [
							"id" => $xss->xss($data['id_school_teacher']),
							"status" => 'A',
							"deleted" => 0,
						]
				]);
					     $device = $database->select("device_parent","device_id",[
					     	"school"=>$data['id_school_teacher'],
					     	"parent"=>$parent['id'],
					     	"deleted"=> 0,
					     	"status"=>'A']);
					 function sendNotification($title,$message,$device) {
                            $content = array(
                                "en" => $message // Nội dung thông báo (có thể thay đổi ngôn ngữ ở đây)
                            );
                        
                            $fields = [
                                'app_id' => 'c0bd1290-a222-4a69-b48f-e1a756d3e1b6', // ID ứng dụng OneSignal của bạn
                                'include_player_ids' =>$device, // Danh sách các device token
                                'contents' => $content,
                                'headings' => array("en" => $title) // Tiêu đề thông báo
                            ];
                        
                            $fields = json_encode($fields);
                        
                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                'Content-Type: application/json; charset=utf-8',
                                'Authorization: Basic ODQzZTk1NmMtMjIwNi00NmNhLTgxZDMtMzg2NTBkODJjYTBl' // Thay YOUR_REST_API_KEY bằng khóa REST API của bạn
                            ));
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_HEADER, false);
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        
                            $result = curl_exec($ch);
                        
                            if ($result === FALSE) {
                                die('Curl failed: ' . curl_error($ch));
                            }
                        
                            curl_close($ch);
                        
                            return $result;
                        }
                        
                        // Gọi hàm sendNotification để gửi thông báo đẩy
                        $title =  $school['name'];
                        $message = "Giáo viên ".$teacher['fullname']. " đã điểm danh cho học sinh ".$students['fullname'];
                        $result = sendNotification($title,$message,$device);
					echo json_encode(['status' => 'success', 'content' => $insert,'insert_timekeeping_details'=>$insert_timekeeping_details]);
				}


			} 

		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'firstbook_teacher') {
			$getToken = $xss->xss($data['token']);
			$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
			$decoded_token = (array) $token;
			$payload = $database->get("payload", "*", [
				"phone_number" => $decoded_token['phone_number'],
				"accounts" => $decoded_token['accounts'],
				"agent" => $decoded_token['agent'],
				"date" => $decoded_token['date'],
				"identify" => $decoded_token['identify'],
			]);
			if ($payload > 1) {
				//if ($router['2']) {
					$class_diagram = $database->get("class_diagram", "*", [
						"AND" => [
							"id" => $xss->xss($data['id_class_diagram']),
							"school" => $xss->xss($data['id_school_teacher']),
							"status" => "A",
							"deleted" => 0,
						]
					]);
					$today_date = date("N");
					if ($today_date==1) {
					$startDate =date('Y-m-d', strtotime('Monday'));
					$date = strtotime('Monday');
					$endDate = date('Y-m-d',strtotime('+6 days',$date));

					} else{
					$startDate =date('Y-m-d', strtotime('last Monday'));
					$date = strtotime('last Monday');
					$endDate = date('Y-m-d',strtotime('+6 days',$date));
					}
					
					$schedule = $database->get("schedule", "*", [
						"AND" => [
							"class_diagram" => $class_diagram['id'],
							"school" => $xss->xss($data['id_school_teacher']),
							"date_start[<=]"=>$startDate,
							"date_end[>=]"=>$endDate,
							"status" => "A",
							"deleted" => 0,
						]
					]);
					//$newsss=date('N');
					$schedule_detail_monday=$database->select("schedule_detail", "*", [
						"AND" => [
							"schedule" 	=> $schedule['id'],
							"day"		=>date('N'),
							"status" 	=> "A",
							"deleted" 	=> 0,
						],"ORDER" => [
							"lesson" => "ASC",
						]
					]);

					$course=$database->get("course" , "*",[
					"AND" => [
						"id"=>$xss->xss($data['id_course']),
						"status" => 'A',
						"deleted" => 0,
					]
				]);
			    $date=date('Y-m-d');
				$semester=$database->get("semester" , "*",[
					"AND" => [
						"enddate[>=]"=> $date,
						"startdate[<=]"=> $date,
						"course"=>$course['id'],
						"school"=>$xss->xss($data['id_school_teacher']),
						"status" => 'A',
						"deleted" => 0,
					]
				]);

			$day_thu=$database->get("day", "*", [
							"AND" => [
								"id"		=>date('N'),
								"status" 	=> "A",
								"deleted" 	=> 0,
							]
						]);
					foreach ($schedule_detail_monday as $data4){
						$day2=$database->get("day", "*", [
							"AND" => [
								"id"		=>$data4['day'],
								"status" 	=> "A",
								"deleted" 	=> 0,
							]
						]);
						$subject=$database->get("subject", "*", [
							"AND" => [
								"id"		=>$data4['subject'],
								"status" 	=> "A",
								"deleted" 	=> 0,
							]
						]);
						$classroom=$database->get("classroom", "*", [
							"AND" => [
								"id"		=>$data4['classroom'],
								"status" 	=> "A",
								"deleted" 	=> 0,
							]
						]);

							$assigning_teachers=$database->get("assigning_teachers", "*", [
								"AND" => [
									"class_diagram"	=>$xss->xss($data['id_class_diagram']),
									"status" 	=> "A",
									"subject"=>$subject['id'],
									"semester"=>$semester['id'],
									"deleted" 	=> 0,
								]
							]);
							$teachers=$database->get("teacher", "*", [
									"AND" => [
										"id"		=>$assigning_teachers['teacher'],
										"status" 	=> "A",
										"deleted" 	=> 0,
									]
								]);
						$detail[]=[

							"id"=>$data4['id'],
							"day"=> $day2['name'],
							"lesson_id"=> $data4['lesson'],
							"subject"=>$subject['name'],
							"subject_id"=>$subject['id'],
							"classroom"=>$classroom['name'],
							"firstname_teachers"=>$teachers['firstname'],
							"lastname_teachers"=>$teachers['lastname'],
							"id_teachers"=>$teachers['id'],
						];
					}   

					// $startDate =date('Y-m-d', strtotime('last Monday'));
					// $date = strtotime('last Monday');
					// $endDate = date('Y-m-d',strtotime('+6 days',$date));

					$first_book=$database->select("first_book", "*", [
						"AND" => [
							"date_subject"=>date('Y-m-d'),
							"class_diagram"=>$xss->xss($data['id_class_diagram']),
							"status" 	=> "A",
							"deleted" 	=> 0,
						]
					]);
					foreach ($first_book as $first_book3) {
				        // So sánh giá trị của trường "id"
						$new[]=$first_book3['lesson'];
					}
					foreach ($detail as $detail2) {
				    // Duyệt qua các phần tử của mảng thứ hai
						foreach ($first_book as $first_book2) { 	
							if ($detail2['lesson_id'] == $first_book2['lesson']) {
				            // Nếu trùng khớp, thêm phần tử vào mảng mới
								$result[] =[
									"id"=>$detail2['id'],
									"day"=>$detail2['day'],
									"lesson_id"=>$detail2['lesson_id'],
									"subject"=>$detail2['subject'],
									"subject_id"=>$detail2['subject_id'],
									"classroom"=>$detail2['classroom'],
									"firstname_teachers"=>$detail2['firstname_teachers'],
									"lastname_teachers"=>$detail2['lastname_teachers'],
									"id_teachers"=>$detail2['id_teachers'],
									"title"=>$first_book2['title'],
									"content"=>$first_book2['content'],
									"comment"=>$first_book2['comment'],
									"evaluate"=>$first_book2['evaluate'],
									"date_subject"=>$first_book2['date_subject'],
								];
							} 

						}

					}
					foreach ($detail as $detail3){
						if (!in_array($detail3['lesson_id'], $new)){
							$result[] =[
								"id"=>$detail3['id'],
								"day"=>$detail3['day'],
								"lesson_id"=>$detail3['lesson_id'],
								"subject"=>$detail3['subject'],
								"subject_id"=>$detail3['subject_id'],
								"classroom"=>$detail3['classroom'],
								"firstname_teachers"=>$detail3['firstname_teachers'],
								"lastname_teachers"=>$detail3['lastname_teachers'],
								"id_teachers"=>$detail3['id_teachers'],
								"title"=>null,
								"content"=>null,
								"comment"=>null,
								"evaluate"=>null,
								"date_subject"=>null,
							];
						}
					}


					
					  // $merged_array = $result + $result2;
					$today = time();

			// Lấy ngày đầu tiên của tuần
					$firstDayOfWeek = strtotime('monday this week', $today);

			// Tạo một mảng chứa 7 ngày và thứ tương ứng
					$weekDays = array();
					for ($i = 0; $i < 7; $i++) {
						$day = strtotime('+' . $i . ' day', $firstDayOfWeek);
						$weekDays[date('l', $day)] = date('Y-m-d', $day);
					}


			 //	}

				echo json_encode(['status' => 'success','weekDays' =>$weekDays,'subject' =>$result,'thu'=>$day_thu ]);
			} else {
				echo json_encode(['status' => 'error', 'content' => 'error']);
			}
	} elseif ($router['1'] == 'firstbook_teacher_clickdate') {
			$getToken = $xss->xss($data['token']);
			$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
			$decoded_token = (array) $token;
			$payload = $database->get("payload", "*", [
				"phone_number" => $decoded_token['phone_number'],
				"accounts" => $decoded_token['accounts'],
				"agent" => $decoded_token['agent'],
				"date" => $decoded_token['date'],
				"identify" => $decoded_token['identify'],
			]);
			if ($payload > 1) {
				if ($router['2']) {
					$class_diagram = $database->get("class_diagram", "*", [
						"AND" => [
							"id" => $xss->xss($data['id_class_diagram']),
							"school" => $xss->xss($data['id_school_teacher']),
							"status" => "A",
							"deleted" => 0,
						]
					]);

					$today = $router['2']; // ngày được truyền vào
					$timestamp = strtotime($today);


					// $first_day_of_week = strtotime('last Monday', $timestamp); // ngày đầu tiên của tuần
					// $dt=date('Y-m-d',$first_day_of_week);
					// $last_day_of_week = strtotime('next Sunday', $timestamp); // ngày cuối cùng của tuần
					$today_date = date("N",strtotime($router['2']));
					if ($today_date==1 ) {
					$first_day_of_week = strtotime('Monday', $timestamp); // ngày đầu tiên của tuần
					
					$last_day_of_week = strtotime('Sunday', $timestamp); // ngày cuối cùng của tuần
					
					} 
					elseif($today_date==7){
					//$first_day_of_week = strtotime('next Monday', $timestamp); // ngày đầu tiên của tuần
					$first_day_of_week = strtotime('previous monday', strtotime($router['2']));
					$last_day_of_week = strtotime('Sunday', $timestamp); // ngày cuối cùng của tuần
					//$dt5=date('Y-m-d',$last_day_of_week);
					//$dt5=date('Y-m-d',$prevMonday);
					}
					 else{
					$first_day_of_week = strtotime('last Monday', $timestamp); // ngày đầu tiên của tuần
					
					$last_day_of_week = strtotime(' next Sunday', $timestamp); // ngày cuối cùng của tuần
					//$dt=date('Y-m-d',$last_day_of_week);
					}

					$current_day = $first_day_of_week;
					$result = array();
					while ($current_day <= $last_day_of_week) {
					  $date = date('Y-m-d', $current_day);
					  $day = date('l', $current_day);
					  $result2[$day] = $date;
					  $current_day = strtotime('+1 day', $current_day);
					}
					$first_day_of_week2 =$result2['Monday']; // ngày đầu tiên của tuần
					$last_day_of_week2 =date('Y-m-d', strtotime('next Sunday', $timestamp)); // ngày cuối cùng của tuần

					$schedule = $database->get("schedule", "*", [
						"AND" => [
							"class_diagram" => $class_diagram['id'],
							"school" => $xss->xss($data['id_school_teacher']),
						    "date_start[<=]"=>$first_day_of_week2,
						    "date_end[>=]"=>$last_day_of_week2,
							"status" => "A",
							"deleted" => 0,
						]
					]);


					$schedule_detail_monday=$database->select("schedule_detail", "*", [
						"AND" => [
							"schedule" 	=> $schedule['id'],
							"day"		=>$today_date,
							"status" 	=> "A",
							"deleted" 	=> 0,
						],"ORDER" => [
							"lesson" => "ASC",
						]
					]);

					$course=$database->get("course" , "*",[
					"AND" => [
						"id"=>$xss->xss($data['id_course']),
						"status" => 'A',
						"deleted" => 0,
					]
				]);
			    $date=date('Y-m-d');
				$semester=$database->get("semester" , "*",[
					"AND" => [
						"enddate[>=]"=> $date,
						"startdate[<=]"=> $date,
						"course"=>$course['id'],
						"school"=>$xss->xss($data['id_school_teacher']),
						"status" => 'A',
						"deleted" => 0,
					]
				]);

				$day_thu=$database->get("day", "*", [
							"AND" => [
								"id"		=>date('N',strtotime($router['2'])),
								"status" 	=> "A",
								"deleted" 	=> 0,
							]
						]);
					foreach ($schedule_detail_monday as $data4){
						$day2=$database->get("day", "*", [
							"AND" => [
								"id"		=>$data4['day'],
								"status" 	=> "A",
								"deleted" 	=> 0,
							]
						]);
						$subject=$database->get("subject", "*", [
							"AND" => [
								"id"		=>$data4['subject'],
								"status" 	=> "A",
								"deleted" 	=> 0,
							]
						]);
						$classroom=$database->get("classroom", "*", [
							"AND" => [
								"id"		=>$data4['classroom'],
								"status" 	=> "A",
								"deleted" 	=> 0,
							]
						]);

							$assigning_teachers=$database->get("assigning_teachers", "*", [
								"AND" => [
									"class_diagram"	=>$xss->xss($data['id_class_diagram']),
									"status" 	=> "A",
									"subject"=>$subject['id'],
									"semester"=>$semester['id'],
									"deleted" 	=> 0,
								]
							]);
							$teachers=$database->get("teacher", "*", [
									"AND" => [
										"id"		=>$assigning_teachers['teacher'],
										"status" 	=> "A",
										"deleted" 	=> 0,
									]
								]);
						$detail[]=[
							"id"=>$data4['id'],
							"day"=> $day2['name'],
							"lesson_id"=> $data4['lesson'],
							"subject"=>$subject['name'],
							"subject_id"=>$subject['id'],
							"classroom"=>$classroom['name'],
							"firstname_teachers"=>$teachers['firstname'],
							"lastname_teachers"=>$teachers['lastname'],
							"id_teachers"=>$teachers['id'],
						];
					}   

					$today_date = date("N",strtotime($router['2']));
					if ($today_date==1 ) {
					$startDate =date('Y-m-d', strtotime('Monday'));
					$date = strtotime('Monday');
					$endDate = date('Y-m-d',strtotime('+6 days',$date));

					}
					elseif($today_date==7){
					//$first_day_of_week = strtotime('next Monday', $timestamp); // ngày đầu tiên của tuần
					$startDate =date('Y-m-d',strtotime('previous monday', strtotime($router['2'])));
					$endDate = date('Y-m-d',strtotime('Sunday', $timestamp)); // ngày cuối cùng của tuần
					//$dt5=date('Y-m-d',$last_day_of_week);
					//$dt5=date('Y-m-d',$prevMonday);
					}

					 else{
					$startDate =date('Y-m-d', strtotime('last Monday'));
					$date = strtotime('last Monday');
					$endDate = date('Y-m-d',strtotime('+6 days',$date));
					}
					$first_book=$database->select("first_book", "*", [
						"AND" => [
							"date_subject"=>$router['2'],
							"status" 	=> "A",
							"deleted" 	=> 0,
						]
					]);
					foreach ($first_book as $first_book3) {
				        // So sánh giá trị của trường "id"
						$new[]=$first_book3['lesson'];
					}
				foreach ($detail as $detail2) {
				    // Duyệt qua các phần tử của mảng thứ hai
						foreach ($first_book as $first_book2) { 	
							if ($detail2['lesson_id'] == $first_book2['lesson']) {
				            // Nếu trùng khớp, thêm phần tử vào mảng mới
								$result[] =[
									"id"=>$detail2['id'],
									"day"=>$detail2['day'],
									"lesson_id"=>$detail2['lesson_id'],
									"subject"=>$detail2['subject'],
									"subject_id"=>$detail2['subject_id'],
									"classroom"=>$detail2['classroom'],
									"firstname_teachers"=>$detail2['firstname_teachers'],
									"lastname_teachers"=>$detail2['lastname_teachers'],
									"id_teachers"=>$detail2['id_teachers'],
									"title"=>$first_book2['title'],
									"content"=>$first_book2['content'],
									"comment"=>$first_book2['comment'],
									"evaluate"=>$first_book2['evaluate'],
									"date_subject"=>$first_book2['date_subject'],
								];
							} 

						}

					}
					foreach ($detail as $detail3){
						if (!in_array($detail3['lesson_id'], $new)){
							$result[] =[
								"id"=>$detail3['id'],
								"day"=>$detail3['day'],
								"lesson_id"=>$detail3['lesson_id'],
								"subject"=>$detail3['subject'],
								"subject_id"=>$detail3['subject_id'],
								"classroom"=>$detail3['classroom'],
								"firstname_teachers"=>$detail3['firstname_teachers'],
								"lastname_teachers"=>$detail3['lastname_teachers'],
								"id_teachers"=>$detail3['id_teachers'],
								"title"=>null,
								"content"=>null,
								"comment"=>null,
								"evaluate"=>null,
								"date_subject"=>null,
							];
						}
					}

					
					  }
					  $firstDayOfWeek3 = strtotime($first_day_of_week2);
               //$firstdayofweek = $date->format('Y-m-d');
				// Tạo một mảng chứa 7 ngày và thứ tương ứng
					$weekDays = array();
					for ($i = 0; $i < 7; $i++) {
						$day = strtotime('+' . $i . ' day', $firstDayOfWeek3);
						$weekDays[date('l', $day)] = date('Y-m-d', $day);
					}


			echo json_encode(['status' => 'success','weekDays' =>$first_book ,'subject' =>$result,'thu'=>$day_thu,]);
			 	} else {
				echo json_encode(['status' => 'error', 'content' => 'error']);
			}
	} elseif ($router['1'] == 'firstbook_teacher_search') {
			$getToken = $xss->xss($data['token']);
			$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
			$decoded_token = (array) $token;
			$payload = $database->get("payload", "*", [
				"phone_number" => $decoded_token['phone_number'],
				"accounts" => $decoded_token['accounts'],
				"agent" => $decoded_token['agent'],
				"date" => $decoded_token['date'],
				"identify" => $decoded_token['identify'],
			]);
			if ($payload > 1) {
				if ($router['2']) {
					$class_diagram = $database->get("class_diagram", "*", [
						"AND" => [
							"id" => $xss->xss($data['id_class_diagram']),
							"school" => $xss->xss($data['id_school_teacher']),
							"status" => "A",
							"deleted" => 0,
						]
					]);

					$today = $router['2']; // ngày được truyền vào
					$timestamp = strtotime($today);

					$today_date = date("N",strtotime($router['2']));
					if ($today_date==1 ) {
					$first_day_of_week = strtotime('Monday', $timestamp); // ngày đầu tiên của tuần
					
					$last_day_of_week = strtotime('Sunday', $timestamp); // ngày cuối cùng của tuần
					
					} 
					elseif($today_date==7){
					//$first_day_of_week = strtotime('next Monday', $timestamp); // ngày đầu tiên của tuần
					$first_day_of_week = strtotime('previous monday', strtotime($router['2']));
					$last_day_of_week = strtotime('Sunday', $timestamp); // ngày cuối cùng của tuần
					//$dt5=date('Y-m-d',$last_day_of_week);
					//$dt5=date('Y-m-d',$prevMonday);
					}
					 else{
					$first_day_of_week = strtotime('last Monday', $timestamp); // ngày đầu tiên của tuần
					
					$last_day_of_week = strtotime(' next Sunday', $timestamp); // ngày cuối cùng của tuần
					//$dt=date('Y-m-d',$last_day_of_week);
					}
					$current_day = $first_day_of_week;
					$result = array();
					while ($current_day <= $last_day_of_week) {
					  $date = date('Y-m-d', $current_day);
					  $day = date('l', $current_day);
					  $result2[$day] = $date;
					  $current_day = strtotime('+1 day', $current_day);
					}
					$first_day_of_week2 =$result2['Monday']; // ngày đầu tiên của tuần
					$last_day_of_week2 =date('Y-m-d', strtotime('next Sunday', $timestamp)); // ngày cuối cùng của tuần

					$schedule = $database->get("schedule", "*", [
						"AND" => [
							"class_diagram" => $class_diagram['id'],
							"school" => $xss->xss($data['id_school_teacher']),
						    "date_start[<=]"=>$first_day_of_week2,
						    "date_end[>=]"=>$last_day_of_week2,
							"status" => "A",
							"deleted" => 0,
						]
					]);

					$schedule_detail_monday=$database->select("schedule_detail", "*", [
						"AND" => [
							"schedule" 	=> $schedule['id'],
							"day"		=>date("N",strtotime($router['2'])),
							"status" 	=> "A",
							"deleted" 	=> 0,
						],"ORDER" => [
							"lesson" => "ASC",
						]
					]);

					$course=$database->get("course" , "*",[
					"AND" => [
						"id"=>$xss->xss($data['id_course']),
						"status" => 'A',
						"deleted" => 0,
					]
				]);
			    $date=date('Y-m-d');
				$semester=$database->get("semester" , "*",[
					"AND" => [
						"enddate[>=]"=> $date,
						"startdate[<=]"=> $date,
						"course"=>$course['id'],
						"school"=>$xss->xss($data['id_school_teacher']),
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$day_thu=$database->get("day", "*", [
							"AND" => [
								"id"		=>date('N',strtotime($router['2'])),
								"status" 	=> "A",
								"deleted" 	=> 0,
							]
						]);

					foreach ($schedule_detail_monday as $data4){
						$day=$database->get("day", "*", [
							"AND" => [
								"id"		=>$data4['day'],
								"status" 	=> "A",
								"deleted" 	=> 0,
							]
						]);
						$subject=$database->get("subject", "*", [
							"AND" => [
								"id"		=>$data4['subject'],
								"status" 	=> "A",
								"deleted" 	=> 0,
							]
						]);
						$classroom=$database->get("classroom", "*", [
							"AND" => [
								"id"		=>$data4['classroom'],
								"status" 	=> "A",
								"deleted" 	=> 0,
							]
						]);

							$assigning_teachers=$database->get("assigning_teachers", "*", [
								"AND" => [
									"class_diagram"	=>$xss->xss($data['id_class_diagram']),
									"status" 	=> "A",
									"subject"=>$subject['id'],
									"semester"=>$semester['id'],
									"deleted" 	=> 0,
								]
							]);
						$teachers=$database->get("teacher", "*", [
									"AND" => [
										"id"		=>$assigning_teachers['teacher'],
										"status" 	=> "A",
										"deleted" 	=> 0,
									]
								]);
						$detail[]=[
							"id"=>$data4['id'],
							"day"=> $day['name'],
							"lesson_id"=> $data4['lesson'],
							"subject"=>$subject['name'],
							"subject_id"=>$subject['id'],
							"classroom"=>$classroom['name'],
							"firstname_teachers"=>$teachers['firstname'],
							"lastname_teachers"=>$teachers['lastname'],
							"id_teachers"=>$teachers['id'],
						];
					}   

					$today_date = date("N",strtotime($router['2']));
					if ($today_date==1 ) {
					$startDate =date('Y-m-d', strtotime('Monday'));
					$date = strtotime('Monday');
					$endDate = date('Y-m-d',strtotime('+6 days',$date));

					}
					elseif($today_date==7){
					//$first_day_of_week = strtotime('next Monday', $timestamp); // ngày đầu tiên của tuần
					$startDate =date('Y-m-d',strtotime('previous monday', strtotime($router['2'])));
					$endDate = date('Y-m-d',strtotime('Sunday', $timestamp)); // ngày cuối cùng của tuần
					//$dt5=date('Y-m-d',$last_day_of_week);
					//$dt5=date('Y-m-d',$prevMonday);
					}
					 else{
					$startDate =date('Y-m-d', strtotime('last Monday'));
					$date = strtotime('last Monday');
					$endDate = date('Y-m-d',strtotime('+6 days',$date));
					}
					$first_book=$database->select("first_book", "*", [
						"AND" => [
							"date_subject"=>$router['2'],
							"status" 	=> "A",
							"deleted" 	=> 0,
						]
					]);
					foreach ($first_book as $first_book3) {
				        // So sánh giá trị của trường "id"
						$new[]=$first_book3['lesson'];
					}
				foreach ($detail as $detail2) {
				    // Duyệt qua các phần tử của mảng thứ hai
						foreach ($first_book as $first_book2) { 	
							if ($detail2['lesson_id'] == $first_book2['lesson']) {
				            // Nếu trùng khớp, thêm phần tử vào mảng mới
								$result[] =[
									"id"=>$detail2['id'],
									"day"=>$detail2['day'],
									"lesson_id"=>$detail2['lesson_id'],
									"subject"=>$detail2['subject'],
									"subject_id"=>$detail2['subject_id'],
									"classroom"=>$detail2['classroom'],
									"firstname_teachers"=>$detail2['firstname_teachers'],
									"lastname_teachers"=>$detail2['lastname_teachers'],
									"id_teachers"=>$detail2['id_teachers'],
									"title"=>$first_book2['title'],
									"content"=>$first_book2['content'],
									"comment"=>$first_book2['comment'],
									"evaluate"=>$first_book2['evaluate'],
									"date_subject"=>$first_book2['date_subject'],
								];
							} 

						}

					}
					foreach ($detail as $detail3){
						if (!in_array($detail3['lesson_id'], $new)){
							$result[] =[
								"id"=>$detail3['id'],
								"day"=>$detail3['day'],
								"lesson_id"=>$detail3['lesson_id'],
								"subject"=>$detail3['subject'],
								"subject_id"=>$detail3['subject_id'],
								"classroom"=>$detail3['classroom'],
								"firstname_teachers"=>$detail3['firstname_teachers'],
								"lastname_teachers"=>$detail3['lastname_teachers'],
								"id_teachers"=>$detail3['id_teachers'],
								"title"=>null,
								"content"=>null,
								"comment"=>null,
								"evaluate"=>null,
								"date_subject"=>null,
							];
						}
					}

					
					  }
					  $firstDayOfWeek3 = strtotime($first_day_of_week2);
               //$firstdayofweek = $date->format('Y-m-d');
				// Tạo một mảng chứa 7 ngày và thứ tương ứng
					$weekDays = array();
					for ($i = 0; $i < 7; $i++) {
						$day = strtotime('+' . $i . ' day', $firstDayOfWeek3);
						$weekDays[date('l', $day)] = date('Y-m-d', $day);
					}


			echo json_encode(['status' => 'success','weekDays' =>$weekDays ,'subject' =>$result,'thu'=>$day_thu]);
			 	} else {
				echo json_encode(['status' => 'error', 'content' => 'error']);
			}
	} elseif ($router['1'] == 'firstbook_add_firstbook') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']!=0 && isset($router['2'])) {
				if($data['subject_id'] == "" || $data['date_subject'] == ""|| $data['title'] == ""|| $data['id_school_teacher'] == "" || $data['content'] == "" || $data['evaluate'] == "")
				{
					echo json_encode(['status' => 'error', 'content' => 'Lỗi dữ liệu trống']);
				} elseif($data['subject_id'] && $data['date_subject'] && $data['title'] && $data['id_school_teacher'] && $data['content'] && $data['evaluate'] && $data['id_class_diagram'] && $data['id_school_teacher']){
					$insert = [
						"subject" => $xss->xss($data['subject_id']),
						"lesson" => $router['2'],
						"date" => date('Y-m-d H:i:s'),
						"date_subject" => $xss->xss($data['date_subject']),
						"title" => $xss->xss($data['title']),
						"content" => $xss->xss($data['content']),
						"comment" => $xss->xss($data['comment']),
						"teacher" => $payload['accounts'],
						"evaluate" => $xss->xss($data['evaluate']),
						"class_diagram"=>$xss->xss($data['id_class_diagram']),
						"school" => $xss->xss($data['id_school_teacher']),
						"status" => 'A',
						"deleted" => 0,
						
					];
					$database->insert("first_book", $insert);
					$jatbi->logs('first_book', 'add', $insert);
					echo json_encode(['status' => 'success', 'content' => $insert]);
				}


			}

		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'class_fund_book_add_teacher') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']!=0 && isset($router['2'])) {
				if($router['2']==1){
				if($data['title'] == ""|| $data['content'] == "" || $data['price'] == "" || $data['id_school_teacher'] == "")
				{
					echo json_encode(['status' => 'error', 'content' => 'Lỗi dữ liệu trống']);
				} elseif($data['title'] && $data['id_school_teacher'] && $data['content'] && $data['price'] && $data['id_school_teacher']){
					$course=$database->get("course" , "*",[
					"AND" => [
						"id"=>$xss->xss($data['id_course']),
						"status" => 'A',
						"deleted" => 0,
					]
				]);
					$class_diagram = $database->get("class_diagram", "*", [
						"AND" => [
							"homeroom_teacher" =>$payload['accounts'],
							"school" => $xss->xss($data['id_school_teacher']),
							"course"=>$course['id'],
							"status" => "A",
							"deleted" => 0,
						]
					]);
					$insert = [
						"date" => date('Y-m-d'),
						"month"=> date('m'),
						"title" => $xss->xss($data['title']),
						"content" => $xss->xss($data['content']),
						"price" => $xss->xss($data['price']),
						"teacher" => $payload['accounts'],
						"class_diagram"=>$class_diagram['id'],
						"school" => $xss->xss($data['id_school_teacher']),
						"status" => 'A',
						"deleted" => 0,
						
					];
					$database->insert("class_fund_book", $insert);
					$jatbi->logs('class_fund_book', 'add', $insert);
					echo json_encode(['status' => 'success', 'content' => $insert]);
				}
			} elseif($router['2']==2){
				if($data['title'] == ""|| $data['content'] == "" || $data['price'] == "" || $data['id_school_teacher'] == "")
				{
					echo json_encode(['status' => 'error', 'content' => 'Lỗi dữ liệu trống']);
				} elseif($data['title'] && $data['id_school_teacher'] && $data['content'] && $data['price'] && $data['id_school_teacher']){

					$course=$database->get("course" , "*",[
					"AND" => [
						"id"=>$xss->xss($data['id_course']),
						"status" => 'A',
						"deleted" => 0,
					]
				]);
					$class_diagram = $database->get("class_diagram", "*", [
						"AND" => [
							"homeroom_teacher" =>$payload['accounts'],
							"school" => $xss->xss($data['id_school_teacher']),
							"course"=>$course['id'],
							"status" => "A",
							"deleted" => 0,
						]
					]);
					$insert = [
						"date" => date('Y-m-d'),
						
						"title" => $xss->xss($data['title']),
						"content" => $xss->xss($data['content']),
						"price" => $xss->xss($data['price']),
						"teacher" => $payload['accounts'],
						"class_diagram"=>$class_diagram['id'],
						"school" => $xss->xss($data['id_school_teacher']),
						"status" => 'A',
						"deleted" => 0,
						
					];
					$database->insert("revenue_expenditure", $insert);
					$jatbi->logs('revenue_expenditure', 'add', $insert);
					echo json_encode(['status' => 'success', 'content' => $insert]);
				}
			} 


			}

		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'tuition_debt_search') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if($router['2']){
				$content_tuitions = $database->select("content_tuition", "*", [
					"AND" => [
						"type"=>[0,1],
						"school" => $xss->xss($data['id_school']),
						"class_diagram" =>$xss->xss($data['id_class_diagram']),
						"status" => "A",
						"deleted" => 0,  
					]

				]);
				$arrange_class = $database->get("arrange_class", "*", [
						"AND" => [
							"class_diagram" => $xss->xss($data['id_class_diagram']),
							"students" => $xss->xss($data['id_student']),
							"status" => 'A',
							"deleted" => 0,
						]
					]);
				$students = $database->get("students", "*", [
						"AND" => [
							"id" => $xss->xss($data['id_student']),
							"status" => "A",
							"deleted" => 0,
						]
					]);
				$class_diagram = $database->get("class_diagram", "*", [
						"AND" => [
							"school" => $xss->xss($data['id_school']),
							"id" =>$xss->xss($data['id_class_diagram']),
							"status" => "A",
							"deleted" => 0,
						]
					]);
				$course_current=$database->get("course", "*", [
						"AND" => [
							"school" => $xss->xss($data['id_school']),
							"id" => $class_diagram['course'],
							"status" => "A",
							"deleted" => 0,
						]
				]);
				for($i=1; $i<13;$i++){
					if($i<=12 && $i>= date("m", strtotime($course_current['startdate']))){
						$months[]=[
							"months"=>$i,
							"year"=>date("Y", strtotime($course_current['startdate'])),
						];
					}elseif($i>=1 && $i<= date("m", strtotime($course_current['enddate']))){
						$months[]=[
							"months"=>$i,
							"year"=>date("Y", strtotime($course_current['enddate'])),
						];
					}
				}

				$tuition_order_detail = $database->select("tuition_order_detail", "*", [
					"AND" => [
						"school" => $arrange_class['school'],
						"arrange_class" =>$arrange_class['id'],
						"status" => "A",
						"deleted" => 0,
					]
				]);
				foreach($months as $month){
	                foreach($content_tuitions as $content_tuition){
	                    $datas1[]=[
	                        "id"=>$content_tuition['id'],
	                        "content"=>$content_tuition['content'],
	                        "class_diagram"=>$content_tuition['class_diagram'],
	                        "price"=>$content_tuition['price'],
	                        "payment_deadline"=>$content_tuition['payment_deadline'],
	                        "month"=>$month['months'],
	                        "number_of_month"=>$content_tuition['number_of_month'],  
	                        "year"=>$month['year'],
	                    ];
	                }
	            }

				if($tuition_order_detail==[]){
					foreach($datas1 as $data){
						$congno[]=[
							'month'=>$data['month'],
							'year'=>$data['year'],
							'content'=>$data['content'],
							'price'=>$data['price'],
							'type'=> 'Chưa đóng'
						];
						
					}
				}else{
					foreach($datas1 as $data){
						$found = false; // Khởi tạo biến found là false
						foreach($tuition_order_detail as $value){
							// So sánh giá trị của $data["id"] với $value
							if ($data["id"] == $value['content_tuition'] && $data['month']==$value['month']) {
								$found = true; // Nếu tìm thấy, đánh dấu là true
								break; // Thoát khỏi vòng lặp nếu đã tìm thấy
							}
						}
					
						// Dựa vào giá trị của biến $found để đưa vào mảng $congno
						if($found){
							// $congno[]=[
							// 	'month'=>$data['month'],
							// 	'year'=>$data['year'],
							// 	'content'=>$data['content'],
							// 	'price'=>$data['price'],
							// 	'type'=> 'Đã đóng'
							// ];
						}else{
							$congno[]=[
								'month'=>$data['month'],
								'year'=>$data['year'],
								'content'=>$data['content'],
								'price'=>$data['price'],
								'type'=> 'Chưa đóng'
							];
						}
					}
						
				}
				
				$month_in=date("m",strtotime($router['2']));
				$year_in=date("Y",strtotime($router['2']));
				$m=date("m", strtotime($students['year_of_admission']));
				$y=date("Y", strtotime($students['year_of_admission']));
				if(($month_in >= $m && $year_in == $y) || ($month_in < $m && $year_in > $y)){
					foreach($congno as $data){
						if ($data['month']==$month_in && $data['year']==$year_in) {
							$congnonew[]=$data;
						}
					}
				}

				$tong=0;
				
					foreach($congnonew as $count){
						$tong=$tong+$count['price'];
					}
			}

			echo json_encode(['status' => 'success', 'content' => $congnonew,'tong'=>$tong]);
		}
	} elseif ($router['1'] == 'tuition_debt_teacher') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			
				$class_diagram = $database->get("class_diagram", "*", [
											"AND" => [
												"homeroom_teacher" => $payload['accounts'],
												"school" => $xss->xss($data['id_school_teacher']),
												"course"=>$xss->xss($data['id_course']),
												"status" => "A",
												"deleted" => 0,
											]
										]);
				$arrange_class = $database->select("arrange_class", "*", [
											"AND" => [
												"class_diagram" => $class_diagram['id'],
												"school" => $xss->xss($data['id_school_teacher']),
												"status" => "A",
												"deleted" => 0,
											]
										]);
				foreach($arrange_class as $valu){
					$students= $database->get("students", "*", [
											"AND" => [
												"id"=>$valu['students'],
												"school" => $xss->xss($data['id_school_teacher']),
												"status" => "A",
												"deleted" => 0,
											]
										]);
					$iist_student[]=[
						"id_arrange_class"=>$valu['id'],
						"id_student"=>$students['id_student'],
						"firstname"=>$students['firstname'],
						"lastname"=>$students['lastname'],
					];

				}

			echo json_encode(['status' => 'success', 'content' =>$iist_student]);
		}
	} elseif ($router['1'] == 'menu_teacher') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			$day = $database->select("day", "*", [
				"AND" => [
					"status" => "A",
					"school"=>$xss->xss($data['id_school_teacher']),
					"deleted" => 0,
				]
			]);	

			$mondayfood=$database->select("food_menu_detail", "*", [
				"AND" => [
					"day"=>1,
					"status" => "A",
					"deleted" => 0,
				]
			]);	
			foreach($mondayfood as $data){
				$days = $database->get("day", "*", [
					"AND" => [
						"id"=>$data['day'],
						"status" => "A",
						"deleted" => 0,
					]
				]);	
				$dish = $database->get("dish", "*", [
					"AND" => [
						"id"=>$data['dish'],
						"status" => "A",
						"deleted" => 0,
					]
				]);	
				$typemenu = $database->get("typemenu", "*", [
					"AND" => [
						"id"=>$data['typemenu'],
						"status" => "A",
						"deleted" => 0,
					]
				]);	
				$monday[]=[
					"typemenu"=>$typemenu['name'],
					"namefood"=>$dish['name'],
					"avatar"=>$dish['avatar'],
					"id"=>$dish['id'],

				];
			}

			echo json_encode(['status' => 'success',"monday"=>$monday]);
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'menu_day_teacher') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']) {
				$day = $database->select("day", "*", [
					"AND" => [
						"status" => "A",
						"deleted" => 0,
					]
				]);	

				$mondayfood=$database->select("food_menu_detail", "*", [
					"AND" => [
						"day"=>$router['2'],
						"status" => "A",
						"school"=>$xss->xss($data['id_school_teacher']),
						"deleted" => 0,
					]
				]);	
				foreach($mondayfood as $data){
					$days = $database->get("day", "*", [
						"AND" => [
							"id"=>$data['day'],
							"status" => "A",
							"deleted" => 0,
						]
					]);	
					$dish = $database->get("dish", "*", [
						"AND" => [
							"id"=>$data['dish'],
							"status" => "A",
							"deleted" => 0,
						]
					]);	
					$typemenu = $database->get("typemenu", "*", [
						"AND" => [
							"id"=>$data['typemenu'],
							"status" => "A",
							"deleted" => 0,

						]
					]);	
					$monday[]=[
						
						"typemenu"=>$typemenu['name'],
						"namefood"=>$dish['name'],
						"avatar"=>$dish['avatar'],
						"id"=>$dish['id'],
						"day"=>$data['day'],

					];
				}

				echo json_encode(['status' => 'success',"content"=>$monday]);
			}} else {
				echo json_encode(['status' => 'error', 'content' => 'error']);
			}
	} elseif ($router['1'] == 'scores_semester_teacher') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			$course = $database->get("course", "*", [
				"AND" => [
				"id" => $xss->xss($data['id_course']),
					"status" => "A",
					"deleted" => 0,
					]
				]);	
				$semester = $database->select("semester", "*", [
				"AND" => [
				"course" => $xss->xss($data['id_course']),
					"status" => "A",
					"deleted" => 0,
					]
				]);	
				
				echo json_encode(['status' => 'success','semester' => $semester,'course' => $course]);
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'scores_class_teacher') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
				$assigning_teachers = $database->select("assigning_teachers", "*", [
					    "AND" => [
					        "teacher"=>$payload['accounts'],
					        "school"=>$xss->xss($data['id_school_teacher']),
					        "semester"=>$xss->xss($data['id_semester']),
					        "status" => 'A',
						    "deleted" => 0,
					    ]
					]); 
				foreach($assigning_teachers as $data2){
			    $class_diagram = $database->get("class_diagram", "*", [
					    "AND" => [
					        "course"=>$xss->xss($data['id_course']),
					        "id"=> $data2['class_diagram'],
					        "status" => 'A',
						    "deleted" => 0,
					    ]
					]); 

			    if ($class_diagram!=null) {
			      $class_diagram_new[]= $class_diagram;
			    }
			 }	
			 foreach($class_diagram_new as $class_diagram_new){
					 $class= $database->get("class", "*", [
											    "AND" => [
											        
											        "id"=> $class_diagram_new['class'],
											        "status" => 'A',
												    "deleted" => 0,
											    ]
											]); 
					  if ($class!=null) {
			      $class_new[]= [
			      	"id_class_diagram" =>$class_diagram_new['id'],
			      	"name" =>  $class['name'],
			      ];

			    }

			} 
			$array = $class_new;
			$uniqueArray = array();

			foreach ($array as $value) {
			    if (!in_array($value, $uniqueArray)) {
			        $uniqueArray[] = $value;
			    }
			}
				echo json_encode(['status' => 'success','class' =>$uniqueArray,]);
	
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'scores_subject_teacher') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']) {
				$date = date("Y-m-d");
				$timestamp = strtotime($date);
				
				$class_diagram = $database->get("class_diagram", "*", [
					    "AND" => [
					        "course"=>$xss->xss($data['id_course']),
					        "id"=> $router['2'],
					        "status" => 'A',
						    "deleted" => 0,
					    ]
					]); 
				
				$assigning_teachers = $database->select("assigning_teachers", "*", [
					    "AND" => [
					        "teacher"=>$payload['accounts'],
					        "school"=>$xss->xss($data['id_school_teacher']),
					        "class_diagram"=>$class_diagram['id'],
					        "status" => 'A',
						    "deleted" => 0,
					    ]
					]); 
			  
		      foreach($assigning_teachers as $data){
			   $subject = $database->get("subject", "*", [
			 		    "AND" => [
					        "id"=>$data['subject'],

					        "status" => 'A',
						    "deleted" => 0,
					    ]
					]); 
			$new_subject[]=[
				"id_assigning_teachers"=>$data['id'],
				"subject" => $subject['name'],
			];
		}
				

				
				echo json_encode(['status' => 'success','assigning_teachers' => $new_subject]);
			}
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'list_student_class_teacher') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']) {
			$assigning_teachers=$database->get("assigning_teachers" , "*",[
				"AND" => [
					"class_diagram"=>$xss->xss($data['id_class_diagram']),
					"id"=>$router['2'],
					"status" => "A",
					"deleted" => 0,
				]
			]);
			$class_diagram=$database->get("class_diagram" , "*",[
				"AND" => [
					"id"=>$assigning_teachers['class_diagram'],
					"school"=>$xss->xss($data['id_school_teacher']),
					"status" => "A",
					"deleted" => 0,
				]
			]);
			$arrange_class=$database->select("arrange_class" , "*",[
				"AND" => [
					"class_diagram"=>$class_diagram['id'],
					"school"=>$xss->xss($data['id_school_teacher']),
					"status" => "A",
					"deleted" => 0,
				]
			]);
			foreach($arrange_class as $valu){
       	  $students=$database->get("students" , "*",[
				"AND" => [
					"id"=>$valu['students'],
					"school"=>$xss->xss($data['id_school_teacher']),
					"status" => "A",
					"deleted" => 0,
				]
			]);
       	  $student_list[]=[
       	  	"id_arrange_class"=>$valu['id'],
       	  	"id_student"=>$students['id_student'],
       	  	"firstname"=>$students['firstname'],
       	  	"lastname"=>$students['lastname'],

       	  ];
       	  }
       	}
			echo json_encode(['status' => 'success','content' =>$student_list]);

		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'scores_student_class_teacher') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']) {
				$scores = $database->select("scores", "*", [
					"AND" => [
						"assigning_teachers" => $xss->xss($data['id_assigning_teachers']),
						"arrange_class" =>$router['2'],
						"school" =>$xss->xss($data['id_school_teacher']),
						"status" => 'A',
						"deleted" => 0,
					]
				]);
					foreach ($scores as $data2) {
					$typescore = $database->get("typescore", "*", [
						"AND" => [
							"id" =>$data2['typescore'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
					
					$subject_teacher[]= [
						"id_typescore"=>$typescore['id'],
						"typescore"=>$typescore['name'],
						"scores"=>$data2['score'],

					];
				}
											$diemtk=$database->select("scores","*",["typescore"=>$database->get("typescore", "id", ["school"        =>$xss->xss($data['id_school_teacher']),"id_type_scores" =>"m", "deleted" => 0, "status" => 'A']),"school"=>$xss->xss($data['id_school_teacher']),"assigning_teachers"=>$xss->xss($data['id_assigning_teachers']),"arrange_class"=>$router['2']]);
											$diem15=$database->select("scores","*",["typescore"=>$database->get("typescore", "id", ["school"        =>$xss->xss($data['id_school_teacher']),"id_type_scores" =>"15p", "deleted" => 0, "status" => 'A']),"school"=>$xss->xss($data['id_school_teacher']),"assigning_teachers"=>$xss->xss($data['id_assigning_teachers']),"arrange_class"=>$router['2']]);
											$diem45p=$database->select("scores","*",["typescore"=>$database->get("typescore", "id", ["school"        =>$xss->xss($data['id_school_teacher']),"id_type_scores" =>"45p", "deleted" => 0, "status" => 'A']),"school"=>$xss->xss($data['id_school_teacher']),"assigning_teachers"=>$xss->xss($data['id_assigning_teachers']),"arrange_class"=>$router['2']]);
											$diemgk=$database->get("scores","score",["typescore"=>$database->get("typescore", "id", ["school"        =>$xss->xss($data['id_school_teacher']),"id_type_scores" =>"gk", "deleted" => 0, "status" => 'A']),"school"=>$xss->xss($data['id_school_teacher']),"assigning_teachers"=>$xss->xss($data['id_assigning_teachers']),"arrange_class"=>$router['2']]);
											$diemck=$database->get("scores","score",["typescore"=>$database->get("typescore", "id", ["school"        =>$xss->xss($data['id_school_teacher']),"id_type_scores" =>"ck", "deleted" => 0, "status" => 'A']),"school"=>$xss->xss($data['id_school_teacher']),"assigning_teachers"=>$xss->xss($data['id_assigning_teachers']),"arrange_class"=>$router['2']]);
											$diemth=$database->select("scores","*",["typescore"=>$database->get("typescore", "id", ["school"        =>$xss->xss($data['id_school_teacher']),"id_type_scores" =>"th", "deleted" => 0, "status" => 'A']),"school"=>$xss->xss($data['id_school_teacher']),"assigning_teachers"=>$xss->xss($data['id_assigning_teachers']),"arrange_class"=>$router['2']]);
											$totaltk=0;
											$total15=0;
											$total45=0;
											$totalth=0;
											$totalgk=0;
											$totalck=0;
											$hesotk=$database->get("typescore", "heso", ["school"=>$xss->xss($data['id_school_teacher']),"id_type_scores" =>"m", "deleted" => 0, "status" => 'A']);
											$heso15=$database->get("typescore", "heso", ["school"=>$xss->xss($data['id_school_teacher']),"id_type_scores" =>"15p", "deleted" => 0, "status" => 'A']);
											$heso45=$database->get("typescore", "heso", ["school"=>$xss->xss($data['id_school_teacher']),"id_type_scores" =>"45p", "deleted" => 0, "status" => 'A']);
											$hesoth=$database->get("typescore", "heso", ["school"=>$xss->xss($data['id_school_teacher']),"id_type_scores" =>"th", "deleted" => 0, "status" => 'A']);
											$hesogk=$database->get("typescore", "heso", ["school"=>$xss->xss($data['id_school_teacher']),"id_type_scores" =>"gk", "deleted" => 0, "status" => 'A']);
											$hesock=$database->get("typescore", "heso", ["school"=>$xss->xss($data['id_school_teacher']),"id_type_scores" =>"ck", "deleted" => 0, "status" => 'A']);
											$countDiemtk = count($diemtk);
											$countDiem15 = count($diem15);
											$countDiem45p = count($diem45p);

										$countDiemgk = ($diemgk !== false) ? 1 : 0; // Kiểm tra nếu $diemgk có giá trị thì gán 1, ngược lại gán 0
										$countDiemck = ($diemck !== false) ? 1 : 0; // Kiểm tra nếu $diemck có giá trị thì gán 1, ngược lại gán 0
										$countDiemth = count($diemth);
										// Tính tổng điểm từ $diemtk
										foreach ($diemtk as $score) {
											$totaltk += $score['score'];
										}

										// Tính tổng điểm từ $diem15
										foreach ($diem15 as $score) {
											$total15 += $score['score'];
										}

										// Tính tổng điểm từ $diem45p
										foreach ($diem45p as $score) {
											$total45 += $score['score'];
										}

										// Thêm điểm giữa kỳ $diemgk vào tổng điểm
										$totalgk = $diemgk;

										// Thêm điểm cuối kỳ $diemck vào tổng điểm
										$totalck = $diemck;

										// Tính tổng điểm từ $diemth
										foreach ($diemth as $score) {
											$totalth += $score['score'];
										}
										
										$dtbm=($totaltk*$hesotk+$total15*$heso15+$total45*$heso45+$totalgk*$hesogk+$totalck*$hesock+$totalth*$hesoth)/($countDiemtk*$hesotk+$countDiem15*$heso15+$countDiem45p*$heso45+$countDiemth*$hesoth+$hesogk+$hesock);
			$roundedNumber = round($dtbm, 2);

				$subject_teachers[]= [
					"typescore"=>"Chưa có điểm",
					"scores"=>"Trống"

				];
				if(empty($subject_teacher)){
					echo json_encode(['status' => 'success','subject_teacher' => $subject_teachers]);
					
				}else{
					echo json_encode(['status' => 'success','subject_teacher' => $subject_teacher,'tb'=>$roundedNumber]);
				}
			}

		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'typescore_teacher') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
				$typescore = $database->select("typescore", "*", [
				"AND" => [
					"status" => "A",
					"deleted" => 0,
					]
				]);	
				
				echo json_encode(['status' => 'success','typescore' => $typescore]);
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'getClass_semester_add_teacher') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			$ht=date('Y-m-d');
					$semester = $database->get("semester", "*", [
						"AND" => [
							"startdate[<=]" => $ht,
							"enddate[>=]" => $ht,
							"school" =>$xss->xss($data['id_school_teacher']),
							"status" => 'A',
							"deleted" => 0,
						]
					]);
				$assigning_teachers = $database->get("assigning_teachers", "*", [
					    "AND" => [
					    	"id"=>$xss->xss($data['id_assigning_teachers']),
					       "teacher"=>$payload['accounts'],
					        "semester"=>$semester['id'],
					        "school"=>$xss->xss($data['id_school_teacher']),
					        //"class_diagram"=>$router['2'],
					        "status" => 'A',
						    "deleted" => 0,
					    ]
					]); 
			  
					    
						$subject = $database->get("subject", "*", [
						 		    "AND" => [
								        "id"=>$assigning_teachers['subject'],

								        "status" => 'A',
									    "deleted" => 0,
								    ]
								]); 
						$new_subject=[
							"id_assigning_teachers"=>$assigning_teachers['id'],
							"subject" => $subject['name'],
						];
				
				
						$class_diagram= $database->get("class_diagram", "*", [
						"AND" => [
							"id" => $xss->xss($data['id_class_diagram']),
							"school" =>$xss->xss($data['id_school_teacher']),
							"status" => 'A',
							"deleted" => 0,
						]
					]);
							$class2 = $database->get("class", "*", [
						"AND" => [
							"id" => $class_diagram['class'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
						$class=[
							"id_class_diagram"=>$class_diagram['id'],
							"name"=>$class2['name'],
						];



					// foreach($class_diagram_2 as $class_diagram_3){
					// 	$class2 = $database->get("class", "*", [
					// 	"AND" => [
					// 		"id" => $class_diagram_3['class'],
					// 		"status" => 'A',
					// 		"deleted" => 0,
					// 	]
					// ]);
					// 	$class[]=[
					// 		"id_class_diagram"=>$class_diagram_3['id'],
					// 		"name"=>$class2['name']
					// 	];

					// }
					$arrange_class=$database->select("arrange_class" , "*",[
							"AND" => [
								"class_diagram" => $xss->xss($data['id_class_diagram']),
								"school"=>$xss->xss($data['id_school_teacher']),
								"status" => "A",
								"deleted" => 0,
							]
						]);
						foreach($arrange_class as $valu){
			       	  $students=$database->get("students" , "*",[
							"AND" => [
								"id"=>$valu['students'],
								"school"=>$xss->xss($data['id_school_teacher']),
								"status" => "A",
								"deleted" => 0,
							]
						]);
			       	  $student_list[]=[
			       	  	"id_arrange_class"=>$valu['id'],
			       	  	"id_student"=>$students['id_student'],
			       	  	"firstname"=>$students['firstname'],
			       	  	"lastname"=>$students['lastname'],

			       	  ];
			       	  }

				echo json_encode(['status' => 'success','student_list'=>$student_list,'class' =>$class ,'subject'=>$new_subject, 'semester'=>$semester]);
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'getStudent_class_add_teacher') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']) {
			$arrange_class=$database->select("arrange_class" , "*",[
				"AND" => [
					"class_diagram"=>$router['2'],
					"school"=>$xss->xss($data['id_school_teacher']),
					"status" => "A",
					"deleted" => 0,
				]
			]);
			foreach($arrange_class as $valu){
       	  $students=$database->get("students" , "*",[
				"AND" => [
					"id"=>$valu['students'],
					"school"=>$xss->xss($data['id_school_teacher']),
					"status" => "A",
					"deleted" => 0,
				]
			]);
       	  $student_list[]=[
       	  	"id_arrange_class"=>$valu['id'],
       	  	"id_student"=>$students['id_student'],
       	  	"firstname"=>$students['firstname'],
       	  	"lastname"=>$students['lastname'],

       	  ];
       	  }
       	
       	$ht=date('Y-m-d');
				$semester = $database->get("semester", "*", [
						"AND" => [
							"startdate[<=]" => $ht,
							"enddate[>=]" => $ht,
							"school" =>$xss->xss($data['id_school_teacher']),
							"status" => 'A',
							"deleted" => 0,
						]
					]);
				$assigning_teachers = $database->select("assigning_teachers", "*", [
					    "AND" => [
					        "teacher"=>$payload['accounts'],
					        "semester"=>$semester['id'],
					        "school"=>$xss->xss($data['id_school_teacher']),
					        "class_diagram"=>$router['2'],
					        "status" => 'A',
						    "deleted" => 0,
					    ]
					]); 
			  
		      foreach($assigning_teachers as $data){
			   $subject = $database->get("subject", "*", [
			 		    "AND" => [
					        "id"=>$data['subject'],

					        "status" => 'A',
						    "deleted" => 0,
					    ]
					]); 
			$new_subject[]=[
				"id_assigning_teachers"=>$data['id'],
				"subject" => $subject['name'],
			];
		}
				}
			echo json_encode(['status' => 'success','content' =>$student_list,'subject' => $new_subject]);

		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'getsubject_add_class_teacher') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']) {
				$ht=date('Y-m-d');
				$semester = $database->get("semester", "*", [
						"AND" => [
							"startdate[<=]" => $ht,
							"enddate[>=]" => $ht,
							"school" =>$xss->xss($data['id_school_teacher']),
							"status" => 'A',
							"deleted" => 0,
						]
					]);
				$assigning_teachers = $database->select("assigning_teachers", "*", [
					    "AND" => [
					        "teacher"=>$payload['accounts'],
					        "semester"=>$semester['id'],
					        "school"=>$xss->xss($data['id_school_teacher']),
					        "class_diagram"=>$router['2'],
					        "status" => 'A',
						    "deleted" => 0,
					    ]
					]); 
			  
		      foreach($assigning_teachers as $data){
			   $subject = $database->get("subject", "*", [
			 		    "AND" => [
					        "id"=>$data['subject'],

					        "status" => 'A',
						    "deleted" => 0,
					    ]
					]); 
			$new_subject[]=[
				"id_assigning_teachers"=>$data['id'],
				"subject" => $subject['name'],
			];
		}
				

				
				echo json_encode(['status' => 'success','assigning_teachers' => $new_subject]);
			}
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'scores_student_add_teacher') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
				if( $data['typescore'] == "" || $data['id_school_teacher'] == "" || $data['scores'] == "" || $data['id_assigning_teachers'] == "" )
				{
					echo json_encode(['status' => 'error', 'content' => 'Lỗi dữ liệu trống']);
				} else
				if( $data['typescore'] && $data['id_school_teacher'] && $data['scores'] && $data['id_assigning_teachers']){
				foreach($data['scores'] as $score){
				
					if($score['score']!=null){
					$insert = [
						"arrange_class" => $score['id'],
						"date" => date('Y-m-d'),
						"typescore" => $xss->xss($data['typescore']),
						"score" => $score['score'],
						"accounts"=>$payload['accounts'],
						"assigning_teachers" => $xss->xss($data['id_assigning_teachers']),
						"school" =>  $xss->xss($data['id_school_teacher']),
						"status" => 'A',
						"deleted" => 0,
					];
					$database->insert("scores", $insert);
					$jatbi->logs('scores', 'add', $insert);
					
					}
				}
					

					$assigning_teachers = $database->get("assigning_teachers", "*", [
					"AND" => [
						"id" =>$xss->xss($data['id_assigning_teachers']),
						"status" => 'A',
						"deleted" => 0,
					]
				    ]);
				     $teacher = $database->get("teacher", "*", [
					"AND" => [
						"id" => $payload['accounts'],
						"status" => 'A',
						"deleted" => 0,
					]
				    ]);

				    $subject= $database->get("subject", "*", [
					"AND" => [
						"id" => $assigning_teachers['subject'],
						"status" => 'A',
						"deleted" => 0,
					]
				    ]);

				    $school = $database->get("school", "*", [
					"AND" => [
						"id" => $xss->xss($data['id_school_teacher']),
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				    foreach($data['scores'] as $arrange_class_new){
				    	 $arrange_class = $database->get("arrange_class", "*", [
						"AND" => [
							"id" => $arrange_class_new['id'],
							"status" => 'A',
							"deleted" => 0,
						]
					    ]);
					    $student = $database->get("students", "*", [
						"AND" => [
							"id" => $arrange_class['students'],
							"status" => 'A',
							"deleted" => 0,
						]
					    ]);
					   $students[]= $student;

			        }
			       $parents=array();
			        foreach($students as $td){
				$parent = $database->get("parent", "*", [
					"AND" => [
						"id" =>$td['parent'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				//$parents=$parent;
				if(in_array($parent['id'], array_column($parents, 'id')) == false && $parent!=null){
					$parents[]=$parent;
				}
			}	$combinedParents=array();
				foreach($parents as $newparent){
					$device_1= $database->select("device_parent","device_id",[
					"school"=> $data['id_school_teacher'],
					"deleted"=> 0,
					"parent"=>$newparent['id'],
					"school"=>$data['id_school_teacher'],
					"status"=>'A']);
					if($device_1!=[]){
				   $device = array_merge($combinedParents, $device_1);
					}

				}

					 function sendNotification($title,$message,$device) {
                            $content = array(
                                "en" => $message // Nội dung thông báo (có thể thay đổi ngôn ngữ ở đây)
                            );
                        
                            $fields = [
                                'app_id' => 'c0bd1290-a222-4a69-b48f-e1a756d3e1b6', // ID ứng dụng OneSignal của bạn
                                'include_player_ids' =>$device, // Danh sách các device token
                                'contents' => $content,
                                'headings' => array("en" => $title) // Tiêu đề thông báo
                            ];
                        
                            $fields = json_encode($fields);
                        
                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                'Content-Type: application/json; charset=utf-8',
                                'Authorization: Basic ODQzZTk1NmMtMjIwNi00NmNhLTgxZDMtMzg2NTBkODJjYTBl' // Thay YOUR_REST_API_KEY bằng khóa REST API của bạn
                            ));
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_HEADER, false);
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        
                            $result = curl_exec($ch);
                        
                            if ($result === FALSE) {
                                die('Curl failed: ' . curl_error($ch));
                            }
                        
                            curl_close($ch);
                        
                            return $result;
                        }
                        
                        // Gọi hàm sendNotification để gửi thông báo đẩy
                        $title =  $school['name'];
                        $message = "Giáo viên ".$teacher['fullname']. "đã cập nhật điểm môn ".$subject['name'];
                        $result = sendNotification($title,$message,$device);
                        echo json_encode(['status' => 'success', 'content' =>$device]);
					
				}
			

		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'homeroom_student_teacher') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			$class_diagram = $database->get("class_diagram", "*", [
					    "AND" => [
					        "course"=>$xss->xss($data['id_course']),
					        "homeroom_teacher"=> $payload['accounts'],
					        "school"=>$xss->xss($data['id_school_teacher']),
					        "status" => 'A',
						    "deleted" => 0,
					    ]
					]); 
			$arrange_class=$database->select("arrange_class" , "*",[
					"AND" => [
						"class_diagram"=>$class_diagram['id'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				foreach($arrange_class as $arrange_class){
				$students=$database->get("students" , "*",[
					"AND" => [
						"id"=>$arrange_class['students'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$student_list[]=[
			"id_arrange_class"=>$arrange_class['id'],
       	  	"id_student"=>$students['id_student'],
       	  	"firstname"=>$students['firstname'],
       	  	"lastname"=>$students['lastname'],
			
				];
			}
				echo json_encode(['status' => 'success', 'liststudent'=>$student_list]);
			} 
	} elseif ($router['1'] == 'tuition_debt_student_teacher') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if($router['2']){
			
				$arrange_class = $database->get("arrange_class", "*", [
					"AND" => [
						"id"=>$router['2'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$students = $database->get("students", "*", [
					"AND" => [
						"id" => $arrange_class['students'],
						"status" => "A",
						"deleted" => 0,
					]
				]);
				$student = $database->select("students", "*", [
					"AND" => [
						"id" => $arrange_class['students'],
						"status" => "A",
						"deleted" => 0,
					]
				]);
				$class_diagram = $database->get("class_diagram", "*", [
					"AND" => [
						"school" => $students['school'],
						"id" => $arrange_class['class_diagram'],
						"status" => "A",
						"deleted" => 0,
					]
				]);
				
				$courses=$database->get("course", "*", [
					"AND" => [
						"school" => $students['school'],
						"id" => $class_diagram['course'],
						"status" => "A",
						"deleted" => 0,
					]
				]);
				$content_tuitions = $database->select("content_tuition", "*", [
					"AND" => [
						"type"=>[0,1],
						"school" => $students['school'],
						"class_diagram" =>$arrange_class['class_diagram'],
						"status" => "A",
						"deleted" => 0,  
					]

				]);
				$months=date('m');
				if($months<=12 && $months>= date("m", strtotime($courses['startdate']))){
					$month=[
						"months"=>$months,
						"year"=>date("Y", strtotime($courses['startdate'])),
					];
				}elseif($months>=1 && $months<= date("m", strtotime($courses['enddate']))){
					$month=[
						"months"=>$months,
						"year"=>date("Y", strtotime($courses['enddate'])),
					];
				} 
				$tuition_order_detail = $database->select("tuition_order_detail", "*", [
					"AND" => [
						"school" => $students['school'],
						"arrange_class" =>$arrange_class['id'],
						"status" => "A",
						"deleted" => 0,
					]
				]);
				foreach($content_tuitions as $content_tuition){
					$datas1[]=[
						"id"=>$content_tuition['id'],
						"content"=>$content_tuition['content'],
						"class_diagram"=>$content_tuition['class_diagram'],
						"price"=>$content_tuition['price'],
						"payment_deadline"=>$month['year'],
						"month"=>$month['months'],
						"number_of_month"=>$content_tuition['number_of_month'],  
					];
				}
	            
				$m=date("m", strtotime($students['year_of_admission']));
				$y=date("Y", strtotime($students['year_of_admission']));
				if(($month['months'] >= $m && $month['year'] == $y) || ($month['months'] < $m && $month['year'] > $y)){
					if($tuition_order_detail==[]){
						foreach($datas1 as $data){
							$congno[]=[
								'month'=>$data['month'],
								//'semester'=>$data['semester'],
								'content'=>$data['content'],
								'price'=>$data['price'],
								'type'=> 'Chưa đóng'
							];
							
						}
					}else{
						foreach($datas1 as $data){
							$found = false; // Khởi tạo biến found là false
							foreach($tuition_order_detail as $value){
								// So sánh giá trị của $data["id"] với $value
								if ($data["id"] == $value['content_tuition'] && $data['month']==$value['month']) {
									$found = true; // Nếu tìm thấy, đánh dấu là true
									break; // Thoát khỏi vòng lặp nếu đã tìm thấy
								}
							}
						
							// Dựa vào giá trị của biến $found để đưa vào mảng $congno
							if($found){
								// $congno[]=[
								// 	'month'=>$data['month'],
								// 	'content'=>$data['content'],
								// 	'price'=>$data['price'],
								// 	'type'=> 'Đã đóng'
								// ];
							}else{
								$congno[]=[
									'month'=>$data['month'],
									'content'=>$data['content'],
									'price'=>$data['price'],
									'type'=> 'Chưa đóng'
								];
							}
						}
						
					}
					$tong=0;
				
					foreach($congno as $count){
						$tong=$tong+$count['price'];
					}
				}
				
				echo json_encode(['status' => 'success', 'content' =>$congno,'students' =>$students,'tong'=>$tong]);
			}
		}
	} elseif ($router['1'] == 'tuition_debt_search_teacher') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if($router['2']){
				$arrange_class = $database->get("arrange_class", "*", [
						"AND" => [
							"id" => $xss->xss($data['id_arrange_class']),
							"status" => 'A',
							"deleted" => 0,
							"school" => $xss->xss($data['id_school_teacher']),
						]
					]);
					$students = $database->get("students", "*", [
						"AND" => [
							"id" => $arrange_class['students'],
							"status" => "A",
							"deleted" => 0,
							"school" => $xss->xss($data['id_school_teacher']),
						]
					]);
				$content_tuitions = $database->select("content_tuition", "*", [
					"AND" => [
						"type"=>[0,1],
						"school" => $xss->xss($data['id_school_teacher']),
						"class_diagram" =>$arrange_class['class_diagram'],
						"status" => "A",
						"deleted" => 0,  
					]
				]);
				
				$class_diagram = $database->get("class_diagram", "*", [
					"AND" => [
						"school" => $xss->xss($data['id_school_teacher']),
						"id" =>$arrange_class['class_diagram'],
						"status" => "A",
						"deleted" => 0,
					]
				]);
			$course_current=$database->get("course", "*", [
					"AND" => [
						"school" => $xss->xss($data['id_school_teacher']),
						"id" => $class_diagram['course'],
						"status" => "A",
						"deleted" => 0,
					]
			]);
			for($i=1; $i<13;$i++){
				if($i<=12 && $i>= date("m", strtotime($course_current['startdate']))){
					$months[]=[
						"months"=>$i,
						"year"=>date("Y", strtotime($course_current['startdate'])),
					];
				}elseif($i>=1 && $i<= date("m", strtotime($course_current['enddate']))){
					$months[]=[
						"months"=>$i,
						"year"=>date("Y", strtotime($course_current['enddate'])),
					];
				}
			}

			$tuition_order_detail = $database->select("tuition_order_detail", "*", [
				"AND" => [
					"school" => $arrange_class['school'],
					"arrange_class" =>$arrange_class['id'],
					"status" => "A",
					"deleted" => 0,
				]
			]);
			foreach($months as $month){
				foreach($content_tuitions as $content_tuition){
					$datas1[]=[
						"id"=>$content_tuition['id'],
						"content"=>$content_tuition['content'],
						"class_diagram"=>$content_tuition['class_diagram'],
						"price"=>$content_tuition['price'],
						"payment_deadline"=>$content_tuition['payment_deadline'],
						"month"=>$month['months'],
						"number_of_month"=>$content_tuition['number_of_month'],  
						"year"=>$month['year'],
					];
				}
			}

			if($tuition_order_detail==[]){
				foreach($datas1 as $data){
					$congno[]=[
						'month'=>$data['month'],
						'year'=>$data['year'],
						'content'=>$data['content'],
						'price'=>$data['price'],
						'type'=> 'Chưa đóng'
					];
					
				}
			}else{
				foreach($datas1 as $data){
					$found = false; // Khởi tạo biến found là false
					foreach($tuition_order_detail as $value){
						// So sánh giá trị của $data["id"] với $value
						if ($data["id"] == $value['content_tuition'] && $data['month']==$value['month']) {
							$found = true; // Nếu tìm thấy, đánh dấu là true
							break; // Thoát khỏi vòng lặp nếu đã tìm thấy
						}
					}
				
					// Dựa vào giá trị của biến $found để đưa vào mảng $congno
					if($found){
						// $congno[]=[
						// 	'month'=>$data['month'],
						// 	'year'=>$data['year'],
						// 	'content'=>$data['content'],
						// 	'price'=>$data['price'],
						// 	'type'=> 'Đã đóng'
						// ];
					}else{
						$congno[]=[
							'month'=>$data['month'],
							'year'=>$data['year'],
							'content'=>$data['content'],
							'price'=>$data['price'],
							'type'=> 'Chưa đóng'
						];
					}
				}
					
			}
			
			$month_in=date("m",strtotime($router['2']));
			$year_in=date("Y",strtotime($router['2']));
			$m=date("m", strtotime($students['year_of_admission']));
			$y=date("Y", strtotime($students['year_of_admission']));
			if(($month_in >= $m && $year_in == $y) || ($month_in < $m && $year_in > $y)){
				foreach($congno as $data){
					if ($data['month']==$month_in && $data['year']==$year_in) {
						$congnonew[]=$data;
					}
				}
			}

			$tong=0;
				
					foreach($congnonew as $count){
						$tong=$tong+$count['price'];
					}
		}

		echo json_encode(['status' => 'success', 'content' => $congnonew,'tong'=>$tong]);
		}
	} elseif ($router['1'] == 'schedule_detail_teacher') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']) {

				$ngayHienTai = date('Y-m-d');
				$schedule3= $database->select("schedule", "*", [
					"AND" => [
						"school" => $xss->xss($data['id_school_teacher']),
						"date_start[<=]" => $ngayHienTai,
						"date_end[>=]" => $ngayHienTai,
						"status" => "A",
						"deleted" => 0,
					]
				]);
				$schedule_detail_monday = array();
				foreach($schedule3 as $schedule){
				$schedule_detail=$database->select("schedule_detail", "*", [
					"AND" => [
						"schedule" 	=> $schedule['id'],
						"day"		=>$router['2'],
						"status" 	=> "A",
						"deleted" 	=> 0,
					],"ORDER" => [
						"lesson" => "ASC",
					]
				]);
				if($schedule_detail!=null){
					$schedule_detail_monday = array_merge($schedule_detail_monday, $schedule_detail);
						}
				}
				foreach($schedule_detail_monday as $monday){
					$assigning_teachers=$database->get("assigning_teachers", "*", [
					"AND" => [
						"subject"	=>$monday['subject'],
						"teacher"=>$payload['accounts'],
						"school" => $xss->xss($data['id_school_teacher']),
						"status" 	=> "A",
						"deleted" 	=> 0,
					]
				]);
					if ($assigning_teachers!=null) {
				$subject=$database->get("subject", "*", [
						"AND" => [
							"id"		=>$assigning_teachers['subject'],
							"status" 	=> "A",
							"deleted" 	=> 0,
						]
					]);
				$class_diagram=$database->get("class_diagram", "*", [
						"AND" => [
							"id"		=>$assigning_teachers['class_diagram'],
							"status" 	=> "A",
							"deleted" 	=> 0,
						]
					]);
				$class=$database->get("class", "*", [
						"AND" => [
							"id"		=>$class_diagram['class'],
							"status" 	=> "A",
							"deleted" 	=> 0,
						]
					]);
				$classroom=$database->get("classroom", "*", [
						"AND" => [
							"id"		=>$monday['classroom'],
							"status" 	=> "A",
							"deleted" 	=> 0,
						]
					]);
				$day=$database->get("day", "*", [
						"AND" => [
							"id"		=>$monday['day'],
							"status" 	=> "A",
							"deleted" 	=> 0,
						]
					]);
						$assigning_teachers_schedule_detail[]=[
							"assigning_teachers"=>$assigning_teachers['id'],
							"subject"=>$monday['id'],
							"subject_name"=>$subject['name'],
							"lesson"=> $monday['lesson'],
							"classroom"=>$classroom['name'],
							"schedule_detail"=>$monday['id'],
							"day"=> $day['name'],
							"class"=>$class['name'],
						];
					}
				}
			}
			echo json_encode(['status' => 'success','day'=>$day['name'], 'content' =>$assigning_teachers_schedule_detail]);
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'students-list-register_car') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			
				$parents = $database->get("parent", '*', [
					"AND" => [
						"id" => $payload['accounts'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$students = $database->select("students", "*", [
					"AND" => [
						"school" =>$xss->xss($data['id_school']),
						"parent" => $parents['id'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				foreach($students as $value){
					$date = date("Y-m-d");
				    $timestamp = strtotime($date);
				     $course = $database->get("course", "*", [
					    "AND" => [
					        "startdate[<]"=>$date,
					        "enddate[>]"=>$date,
					        "status" => 'A',
						    "deleted" => 0,
					    ]
					]); 
				     $class_diagram= $database->select("class_diagram", "*", [
						"AND" => [
						//	"id" => $arrange_class['class_diagram'],
							"school" => $xss->xss($data['id_school']),
							"course" => $course['id'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
				    foreach($class_diagram as $valu){
					$arrange_class = $database->get("arrange_class", "*", [
							"AND" => [
								"class_diagram" => $valu['id'],
								"students" =>  $value['id'],
								"status" => 'A',
								"deleted" => 0,
							]
						]);

						if ($arrange_class!=null) {
				     	$arrange_class_2[]=[
				     		"id_arrange_class"=>$arrange_class['id'],
				     		"firstname"=>$value['firstname'],
				     		"lastname"=>$value['lastname'],
				     	];
				      }
					 }
					}
				
				
				
				 $date=date('Y-m-d');
				$semester=$database->get("semester" , "*",[
					"AND" => [
						"enddate[>=]"=> $date,
						"startdate[<=]"=> $date,
						//"course"=>$course['id'],
						"school"=>$xss->xss($data['id_school']),
						"status" => 'A',
						"deleted" => 0,
					]
				]);

				foreach($arrange_class_2 as $arrange_class4){
				$student_register_car = $database->get("student_register_car", "*", [
						"AND" => [
							
							"arrange_class" => $arrange_class4['id_arrange_class'],
							"semester"=>$semester['id'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
				if ($student_register_car==null) {
					$arrange_class_student[]=$arrange_class4;
				}
				}
				echo json_encode(['status' => 'success', 'content' =>	$arrange_class_student,'semester'=>$semester]);
			
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'register_semester_route') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			
				$route=$database->select("route" , "*",[
				"AND" => [
					"school" =>$xss->xss($data['id_school']),
					"status" => "A",
					"deleted" => 0,
				]
			]);
				
				echo json_encode(['status' => 'success','route' => $route]);
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'add_student_register_car') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']!=0 && isset($router['2'])) {
				if($data['id_route'] == "" )
				{
					echo json_encode(['status' => 'error', 'content' => 'Lỗi dữ liệu trống']);
				} elseif($data['id_route']){

			    $date=date('Y-m-d');
				$semester=$database->get("semester" , "*",[
					"AND" => [
						"enddate[>=]"=> $date,
						"startdate[<=]"=> $date,
						//"course"=>$course['id'],
						"school"=>$xss->xss($data['id_school']),
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$arrange_class = $database->get("arrange_class", "*",[
						"AND" => [
							"deleted"       => 0,
							"status"		=>"A",
						//	"students"		=>$students['id'],
							"id" =>$router['2'],
						]
				]);
					$insert = [
						"arrange_class" => $router['2'],
						"semester" => $semester['id'],
						"statu" => 'A',
						"route" => $xss->xss($data['id_route']),
						"school" => $xss->xss($data['id_school']),
						"status" => 'A',
						"deleted" => 0,
						
					];
					$database->insert("student_register_car", $insert);
					$jatbi->logs('student_register_car', 'add', $insert);
					echo json_encode(['status' => 'success', 'student_register_car' => $insert]);
				}
				$account_school = $database->select("account_school","*",["school"=>$arrange_class['school'],"deleted"=>0,"status"=>'A']);
				foreach($account_school as $accounts){
					$jatbi->notification($payload['accounts'],$accounts['accounts'],'','Đăng Ký Xe','Xác Nhận Đăng Ký Xe','/car_driver/student_register_car/','','accounts');
				}



			}

		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'students-register_car') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			
				$parents = $database->get("parent", '*', [
					"AND" => [
						"id" => $payload['accounts'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$students = $database->select("students", "*", [
					"AND" => [
						"school" =>$xss->xss($data['id_school']),
						"parent" => $parents['id'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				foreach($students as $value){
					$date = date("Y-m-d");
				    $timestamp = strtotime($date);
				     $course = $database->get("course", "*", [
					    "AND" => [
					        "startdate[<]"=>$date,
					        "enddate[>]"=>$date,
					        "status" => 'A',
						    "deleted" => 0,
					    ]
					]); 
				     $class_diagram= $database->select("class_diagram", "*", [
						"AND" => [
						//	"id" => $arrange_class['class_diagram'],
							"school" => $xss->xss($data['id_school']),
							"course" => $course['id'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
				    foreach($class_diagram as $valu){
					$arrange_class = $database->get("arrange_class", "*", [
							"AND" => [
								"class_diagram" => $valu['id'],
								"students" =>  $value['id'],
								"status" => 'A',
								"deleted" => 0,
							]
						]);

						if ($arrange_class!=null) {
				     	$arrange_class_2[]=[
				     		"id_arrange_class"=>$arrange_class['id'],
				     		"students"=>$arrange_class['students'],
				     		"firstname"=>$value['firstname'],
				     		"lastname"=>$value['lastname'],
				     	];
				      }
					 }
					}
				
				
				
				 $date=date('Y-m-d');
				$semester=$database->get("semester" , "*",[
					"AND" => [
						"enddate[>=]"=> $date,
						"startdate[<=]"=> $date,
						//"course"=>$course['id'],
						"school"=>$xss->xss($data['id_school']),
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$course = $database->get("course", '*', [
					"AND" => [
						"id" => $semester['course'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);

				foreach($arrange_class_2 as $arrange_class4){
				$student_register_car = $database->get("student_register_car", "*", [
						"AND" => [
							
							"arrange_class" => $arrange_class4['id_arrange_class'],
							"semester"=>$semester['id'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
				$students = $database->get("students", "*", [
					"AND" => [
						"school" =>$xss->xss($data['id_school']),
						"id" => $arrange_class4['students'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$route=$database->get("route" , "*",[
				"AND" => [
					"school" =>$xss->xss($data['id_school']),
					"id"=>$student_register_car['route'],
					"status" => "A",
					"deleted" => 0,
				]
			]);

				if ($student_register_car!=null) {
					$arrange_class_student[]=[
						"id_arrange_class"=>$student_register_car['arrange_class'],
						"view"=>$student_register_car['view'],
						"firstname"=>$students['firstname'],
						"lastname"=>$students['lastname'],
						"semester"=>$semester['name'],
						"route"=>$route['name'],
						"statu"=>$student_register_car['statu'],
						"course"=>$course['name'],

					];
				}
				}
				echo json_encode(['status' => 'success', 'content' =>	$arrange_class_student,'semester'=>$semester]);
			
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'file_lesson_plan_teacher') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
				$lesson_plan = $database->select("lesson_plan", "*", [
				"AND" => [
					"teacher" =>$payload['accounts'],
					"status" => "A",
					"deleted" => 0,
					]
				]);	
				
				echo json_encode(['status' => 'success','lesson_plan' => $lesson_plan]);
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'delete_file_lesson_plan_teacher') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			
				if($router['2']){
				// 	 echo json_encode(['status' => 'success', 'lesson_plan' => $data['avatar']]);
			    // $handle = new Upload($data['avatar']);
			    // echo json_encode(['status' => 'success', 'lesson_plan' => $handle]);
			    //    if($handle->uploaded){
				//         $handle->allowed 		= array('application/msword', 'image/*');
				//         $handle->Process($upload['images']['avatar']['url']);
				//     }
				//     $img = $setting['site_url'].$upload['images']['avatar']['url'].$handle->file_dst_name;
					$update = [
						"id"=>$router['2'],
						"teacher" =>$payload['accounts'],
						"status" => 'A',
						"deleted" => 1,
						
					];
					$database->update("lesson_plan",$update,["id"=>$router['2']]);
					$jatbi->logs('lesson_plan', 'update', $update);
					echo json_encode(['status' => 'success', 'lesson_plan' =>  $update]);
				}

		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'add_file_lesson_plan_teacher2') {
		$getToken = $_POST['token'];
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		 if ($payload>1) {
		$handle = new Upload($_FILES['avatar']);
		if($handle->uploaded){
	      $handle->allowed= array('application/*', 'image/*');
	       $handle->Process($upload['images']['avatar']['url']);
		    }
		   if ($handle->processed && $_POST['title']) {
           $img=$setting['site_url'].$upload['images']['avatar']['url'].$handle->file_dst_name;
					$insert = [
						"title" =>  $_POST['title'],
						"file" => $img,
						"teacher" =>$payload['accounts'],
						"status" => 'A',
						"name"=>'$handle->file_dst_name',
						"date_post"=>date('Y-m-d'),
						"deleted" => 0,
						
					];
					$database->insert("lesson_plan", $insert);
					$jatbi->logs('lesson_plan', 'add', $insert);
					echo json_encode(['status' => 'success', 'lesson_plan' => $insert]);
		 }


		 } else {
		 	echo json_encode(['status' => 'error', 'content' => 'error']);
	 }
	} elseif ($router['1'] == 'note_book_teacher') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
				$note_book=$database->get("note_book" , "*",[
					"AND" => [
						"teacher"=>$payload['accounts'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				echo json_encode(['status' => 'success', 'subject'=>$note_book]);
		} else {
			echo json_encode(['status' => 'error', 'content' => 'Không thể kết nối đến server',]);
		}
	} elseif ($router['1'] == 'attendance_of_teacher') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
				$today_date = date("N");
				if ($today_date==1) {
					$startDate =date('Y-m-d', strtotime('Monday'));
					$date = strtotime('Monday');
					$endDate = date('Y-m-d',strtotime('+6 days',$date));

					} else{
					$startDate =date('Y-m-d', strtotime('last Monday'));
					$date = strtotime('last Monday');
					$endDate = date('Y-m-d',strtotime('+6 days',$date));
					}


				$teacher = $database->get("teacher", "*", [
											"AND" => [
												"id" => $payload['accounts'],
												
												
											]
										]);

				$timekeeping=$database->select("timekeeping_teachers" , "*",[
					"AND" => [
						"teacher"=>$payload['accounts'],
						"date[<>]"=>[$startDate,$endDate],
						"school" =>$xss->xss($data['id_school_teacher']),
						"status" => 'A',
						"deleted" => 0,

					]
				]);
				$today2 = date('Y-m-d');
				$first_day_of_week = date('Y-m-d', strtotime("monday this week"));
				for ($j = 0; $j <= 6; $j++) {
					$day2 = date('Y-m-d', strtotime("+$j day", strtotime($first_day_of_week)));
					$days2[] = $day2;
				}
				if($timekeeping!=null){
				foreach($timekeeping as $data)
				{
					$day=$data['date'];
					$date_formatted = date('Y-m-d', strtotime($day));
					$day_of_week = date('l', strtotime($date_formatted));
					if ($day_of_week=="Monday") {
						$day_of_week="Thứ 2";
					} 
					else if ($day_of_week=="Tuesday")
					{
						$day_of_week="Thứ 3";
					}
					else if ($day_of_week=="Wednesday")
					{
						$day_of_week="Thứ 4";
					} 
					else if ($day_of_week=="Thursday")
					{
						$day_of_week="Thứ 5";
					}
					else if ($day_of_week=="Friday")
					{
						$day_of_week="Thứ 6";
					}
					else if ($day_of_week=="Saturday")
					{
						$day_of_week="Thứ 7";
					}
					else if ($day_of_week=="Sunday")
					{
						$day_of_week="Chủ nhật";
					}

					if ($data['checkin']== null && $data['checkout']== null) {
						$type="3";
					} 
					else if( $data['checkin']== null || $data['checkout']== null) {
						$type="2";
					} 
					else  {
						$type="1";
					}

					$today = time();
					$ht=date('Y-m-d');
				// Lấy ngày đầu tiên của tuần
					$firstDayOfWeek = strtotime('monday this week', $today);

				// Tạo một mảng chứa 7 ngày và thứ tương ứng
					$weekDays = array();
					for ($i = 0; $i < 7; $i++) {
						$day = strtotime('+' . $i . ' day', $firstDayOfWeek);
						$weekDays[date('l', $day)] = date('Y-m-d', $day);
					}
					$timekeeping_day[]= [
						"id" => $data['id'],
						"lastname" => $teacher['lastname'],
						"firstname" => $teacher['firstname'],
						"date" => $data['date'],
						"checkin" => $data['checkin'],
						"checkout" => $data['checkout'],
						"date_poster" =>$data['date_poster'],
						"school" => $data['school'],
						"day_of_week" =>$day_of_week,
						"type" => $type,
					];
					$timekeeping_day_new=$timekeeping_day;

				foreach ($weekDays as $day => $date) {
					    $found = false;
					    foreach ($timekeeping_day as $item) {
					        if ($item['date'] === $date) {
					            $found = true;
					            break;
					        }
					    }
					    if (!$found ) {
					    	if($date >= $ht){
					        $new_item = array(
					            'id' => null,
					           'lastname' => $teacher['lastname'],
						       'firstname' => $teacher['firstname'],
					            'date' => $date,
					            'checkin' => null,
					            'checkout' => null,
					            'date_poster' => null,
					            'school' => null,
					            'day_of_week' => $day,
					            'type' => null
					        );
					    }
					    if($date <$ht){
					        $new_item = array(
					            'id' => null,
					            'lastname' => $teacher['lastname'],
						       'firstname' => $teacher['firstname'],
					            'date' => $date,
					            'checkin' => null,
					            'checkout' => null,
					            'date_poster' => null,
					            'school' => null,
					            'day_of_week' => $day,
					            'type' => 4
					        );
					    }
					        array_push($timekeeping_day_new, $new_item);
					    }
					}
				
			}
		} else {
					$firstDayOfWeek = strtotime($first_day_of_week);
               //$firstdayofweek = $date->format('Y-m-d');
				// Tạo một mảng chứa 7 ngày và thứ tương ứng
					$weekDays = array();
					for ($i = 0; $i < 7; $i++) {
						$day = strtotime('+' . $i . ' day', $firstDayOfWeek);
						$weekDays[date('l', $day)] = date('Y-m-d', $day);
					}

					$timekeeping_day_new=array();
					foreach ($weekDays as $day => $date) {
					        $ht=date('Y-m-d');
					        if($date >= $ht){
					        $new_item2 = array(
					            'id' => null,
					             'lastname' => $teacher['lastname'],
						       'firstname' => $teacher['firstname'],
					            'date' => $date,
					            'checkin' => null,
					            'checkout' => null,
					            'date_poster' => null,
					            'school' => null,
					            'day_of_week' => $day,
					            'type' => null
					        );
					    }
					    elseif($date <$ht){
					        $new_item2 = array(
					            'id' => null,
					           'lastname' => $teacher['lastname'],
						       'firstname' => $teacher['firstname'],
					            'date' => $date,
					            'checkin' => null,
					            'checkout' => null,
					            'date_poster' => null,
					            'school' => null,
					            'day_of_week' => $day,
					            'type' => 4
					        );
					    }
					        array_push($timekeeping_day_new, $new_item2);
					    
					}
				}

				echo json_encode(['status' => 'success','content' =>$timekeeping_day_new,'datestart'=>$startDate,'dateend'=>$endDate]);
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'attendance_search_of_teacher') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
				if($router['2']){

				$date_string =$router['2'];
				// $date = new DateTime($date_string);

				
				// $date->modify('this week');

				// $date_last = new DateTime($date_string);
				// $date_last->modify('this week +6 days');

				// $first_day_of_week = $date->format('Y-m-d');
				// $last_day_of_week = $date_last->format('Y-m-d');
				// Chuyển đổi sang Unix timestamp
				$timestamp = strtotime($date_string);

				// Lấy ngày đầu tuần
				$first_day_of_week = date('Y-m-d', strtotime('monday this week', $timestamp));

				// Lấy ngày cuối tuần
				 $last_day_of_week= date('Y-m-d', strtotime('sunday this week', $timestamp));
	            $teacher = $database->get("teacher", "*", [
											"AND" => [
												"id" => $payload['accounts'],
												
												
											]
										]);

				$timekeeping=$database->select("timekeeping_teachers" , "*",[
					"AND" => [
						"teacher"=>$payload['accounts'],
						"date[<>]"=>[$first_day_of_week,$last_day_of_week],
						"school" =>$xss->xss($data['id_school_teacher']),
						"status" => 'A',
						"deleted" => 0,

					]
				]);

				if($timekeeping!=null){

				foreach($timekeeping as $data)
				{ 

					$day=$data['date'];
					$date_formatted = date('Y-m-d', strtotime($day));
					$day_of_week = date('l', strtotime($date_formatted));
					if ($day_of_week=="Monday") {
						$day_of_week="Thứ 2";
					} 
					else if ($day_of_week=="Tuesday")
					{
						$day_of_week="Thứ 3";
					}
					else if ($day_of_week=="Wednesday")
					{
						$day_of_week="Thứ 4";
					} 
					else if ($day_of_week=="Thursday")
					{
						$day_of_week="Thứ 5";
					}
					else if ($day_of_week=="Friday")
					{
						$day_of_week="Thứ 6";
					}
					else if ($day_of_week=="Saturday")
					{
						$day_of_week="Thứ 7";
					}
					else if ($day_of_week=="Sunday")
					{
						$day_of_week="Chủ nhật";
					}

					if ($data['checkin']== null && $data['checkout']== null) {
						$type="3";
					} 
					else if( $data['checkin']== null || $data['checkout']== null) {
						$type="2";
					} 
					else  {
						$type="1";
					}
					$ht=date('Y-m-d');
				// Lấy ngày đầu tiên của tuần
					$firstDayOfWeek = strtotime($first_day_of_week);
               //$firstdayofweek = $date->format('Y-m-d');
				// Tạo một mảng chứa 7 ngày và thứ tương ứng
					$weekDays = array();
					for ($i = 0; $i < 7; $i++) {
						$day = strtotime('+' . $i . ' day', $firstDayOfWeek);
						$weekDays[date('l', $day)] = date('Y-m-d', $day);
					}


					$timekeeping_day[]= [
						"id" => $data['id'],
						"arrange_class" => $data['arrange_class'],
						"date" => $data['date'],
						"checkin" => $data['checkin'],
						"checkout" => $data['checkout'],
						"date_poster" =>$data['date_poster'],
						"shool" => $data['school'],
						"day_of_week" =>$day_of_week,
						"type" => $type,
					];
					$timekeeping_day_new=$timekeeping_day;
			if($timekeeping_day !=null){
				foreach ($weekDays as $day => $date) {
					    $found = false;
					    foreach ($timekeeping_day as $item) {
					        if ($item['date'] === $date) {
					            $found = true;
					            break;
					        }
					    }
					    if (!$found ) {

					    	if($date >= $ht){
					        $new_item = array(
					            'id' => null,
					            'arrange_class' => null,
					            'date' => $date,
					            'checkin' => null,
					            'checkout' => null,
					            'date_poster' => null,
					            'school' => null,
					            'day_of_week' => $day,
					            'type' => null
					        );
					    }
					    if($date <$ht){
					        $new_item = array(
					            'id' => null,
					            'arrange_class' => null,
					            'date' => $date,
					            'checkin' => null,
					            'checkout' => null,
					            'date_poster' => null,
					            'school' => null,
					            'day_of_week' => $day,
					            'type' => 4
					        );
					    }
					        array_push($timekeeping_day_new, $new_item);
					    }
					}
				}
			  }
			} else {
					$firstDayOfWeek = strtotime($first_day_of_week);
               //$firstdayofweek = $date->format('Y-m-d');
				// Tạo một mảng chứa 7 ngày và thứ tương ứng
					$weekDays = array();
					for ($i = 0; $i < 7; $i++) {
						$day = strtotime('+' . $i . ' day', $firstDayOfWeek);
						$weekDays[date('l', $day)] = date('Y-m-d', $day);
					}

					$timekeeping_day_new=array();
					foreach ($weekDays as $day => $date) {
						$ht=date('Y-m-d');
					        if($date >= $ht){
					        $new_item2 = array(
					            'id' => null,
					            'arrange_class' => null,
					            'date' => $date,
					            'checkin' => null,
					            'checkout' => null,
					            'date_poster' => null,
					            'school' => null,
					            'day_of_week' => $day,
					            'type' => null
					        );
					    }
					    elseif($date <$ht){
					        $new_item2 = array(
					            'id' => null,
					            'arrange_class' => null,
					            'date' => $date,
					            'checkin' => null,
					            'checkout' => null,
					            'date_poster' => null,
					            'school' => null,
					            'day_of_week' => $day,
					            'type' => 4
					        );
					    }
					        array_push($timekeeping_day_new, $new_item2);
					    
					}
				}

				echo json_encode(['status' => 'success','content' =>$timekeeping_day_new,'datestart'=>$first_day_of_week,'dateend'=> $last_day_of_week]);
			}
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'parent_announcement_teacher') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			// $date=date('Y-m-d');
			$course=$database->get("course" , "*",[
					"AND" => [
						"id"=>$xss->xss($data['id_course']),
						"status" => 'A',
						"deleted" => 0,
					]
				]);
			$class_diagram = $database->get("class_diagram", "*", [
						"AND" => [
							"homeroom_teacher" =>$payload['accounts'],
							"school" => $xss->xss($data['id_school_teacher']),
							"course"=>$course['id'],
							"status" => "A",
							"deleted" => 0,
						]
					]);

				

				$course=$database->get("course" , "*",[
					"AND" => [
						"id"=>$class_diagram['course'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
			$parent_announcement = $database->select("parent_announcement", "*", [
				"AND" => [
					"school" => $xss->xss($data['id_school_teacher']),
					//"parent" => $payload['accounts'] ,
					"date[<>]"=>[$course['startdate'],$course['enddate']],
					"class_diagram"=>$class_diagram['id'],
					"status" => 'A',
					"deleted" => 0,
				]
			]);

			foreach($parent_announcement as $data2){
				$class_diagram2= $database->get("class_diagram", "*", [
					"AND" => [
						"id" =>$data2['class_diagram'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$class= $database->get("class", "*", [
					"AND" => [
						"id" =>$class_diagram2['class'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$parent = $database->get("parent", '*', [
					"AND" => [
						"id" => $data2['parent'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);

				// $arrange_class=$database->get("arrange_class" , "*",[
				// 	"AND" => [
				// 		"class_diagram"=>$xss->xss($data['id_class_diagram']),
				// 		"status" => 'A',
				// 		"deleted" => 0,
				// 	]
				// ]);
				$students=$database->get("students" , "*",[
					"AND" => [
						"id"=>$data2['student'],
						//"parent"=> $data2['parent'],	
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				
				$assigning[]=[

					'name_parent'=>$parent['name'],
					'firstname'=>$students['firstname'],
					'lastname'=>$students['lastname'],
					'view'=>$data2['view'],
					'id'=>$data2['id'],
					'name'=>$data2['name'],
					'date'=>$data2['date'],
					'description'=>$data2['description'],
					'content'=>$data2['content'],
					'parent'=>$data2['parent'],
					'description'=>$data2['description'],
					'content'=>$data2['content'],
					'class'=>$class['name'],
				];
			}
		

			echo json_encode(['status' => 'success', 'content' =>$assigning]);
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'parent_announcement_detail_teacher') {
		$getToken = $xss->xss($data['token']);

		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']) {
			
				$parent_announcement = $database->get("parent_announcement", "*", [
					"AND" => [
						"id" => $router['2'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				
				$update=['view'=>1,];
				// $teacher=$database->select("teacher", "*", [
				// 	"AND" => [
				// 		"id" => $teacher_announcement['teacher'],
				// 		"status" => 'A',
				// 		"deleted" => 0,
				// 	]
				// ]);
				

				$database->update("parent_announcement", $update,["id"=>$parent_announcement['id']]);
				$jatbi->logs('parent_announcement', 'update', $update);

				echo json_encode(['status' => 'success', 'content' =>$parent_announcement]);
			}
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'furlough_announcement_teacher') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			// $date=date('Y-m-d');
			$course=$database->get("course" , "*",[
					"AND" => [
						"id"=>$xss->xss($data['id_course']),
						"status" => 'A',
						"deleted" => 0,
					]
				]);
			$class_diagram = $database->get("class_diagram", "*", [
						"AND" => [
							"homeroom_teacher" =>$payload['accounts'],
							"school" => $xss->xss($data['id_school_teacher']),
							"course"=>$course['id'],
							"status" => "A",
							"deleted" => 0,
						]
					]);

			$arrange_class = $database->select("arrange_class", "*", [
					    "AND" => [
					    	"class_diagram"=>$class_diagram['id'],
					       // "students" => $getStudent['id'],
					        //"school" => $getStudent['school'],
					        "status" => 'A',
					        "deleted" => 0,
					    ]
					]);
			     $furlough = [];
					foreach($arrange_class as $arrange_class2){
						 $furlough2 = $database->select("furlough", "*", [
					    "AND" => [
						"arrange_class"=>$arrange_class2['id'],
						//"status" => 'A',
						"deleted" => 0,
					],
					"ORDER" => [
						"id"=>"DESC",
					]
				]); 
				if ($furlough2!=null) {
					$furlough=array_merge($furlough, $furlough2);
				}
					}
					// Tạo một mảng chứa giá trị id
				$ids = array_column($furlough, 'id');

				// Sắp xếp mảng $mergedArray theo giá trị id giảm dần
				array_multisort($ids, SORT_DESC, $furlough);
			 
				foreach ($furlough as $data){
					if($data['statu']=='A'){
						$statu='Chưa duyệt';
					} elseif($data['statu']=='C'){
						$statu='Từ chối';
					}
					else{
						$statu='Đã duyệt';
					}
					$arrange_class = $database->get("arrange_class", "*", [
					    "AND" => [
					    	"id"=>$data['arrange_class'],
					       // "students" => $getStudent['id'],
					        //"school" => $getStudent['school'],
					        "status" => 'A',
					        "deleted" => 0,
					    ]
					]);
					$students=$database->get("students", "*", [
					    "AND" => [
					    	"id"=>$arrange_class['students'],
					       // "students" => $getStudent['id'],
					        //"school" => $getStudent['school'],
					        "status" => 'A',
					        "deleted" => 0,
					    ]
					]);
					$content[]=[
						"id" => $data['id'],
						"view"=>$data['view'],
						"firstname_student"=>$students['firstname'],
						"lastname_student"=>$students['lastname'],
						"date_start"=>$data['date_start'],
						"date_end"=>$data['date_end'],
						"datecurrent"=>$data['datecurrent'],
						"numberday"=>$data['numberday'],
						"reason"=>$data['reason'],
						"statu"=>$statu,
					];
				}

			// $ht=date('Y-m-d');
			// if($ht>=$course['startdate'] && $ht<=$course['enddate']){
			// 	$type=1;
			// } else $type=0;

			echo json_encode(['status' => 'success','furlough'=>$content]);
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'furlough_browser_teacher') {
		$getToken = $xss->xss($data['token']);

		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']) {
			
				$furlough_announcement = $database->get("furlough", "*", [
					"AND" => [
						"id" => $router['2'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$school = $database->get("school", "*", [
					"AND" => [
						"id" => $furlough_announcement['school'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$arrange_class = $database->get("arrange_class", "*", [
					"AND" => [
						"id" => $furlough_announcement['arrange_class'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$students = $database->get("students", "*", [
					"AND" => [
						"id" => $arrange_class['students'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$parents = $database->get("parent", "*", [
					"AND" => [
						"id" => $students['parent'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);

				
				$update=['statu'=>'D','count'=>1];

				$teacher=$database->select("teacher", "*", [
					"AND" => [
						"id" => $teacher_announcement['teacher'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				

				$database->update("furlough", $update,["id"=>$furlough_announcement['id']]);
				$jatbi->logs('furlough', 'update', $update);

				$device= $database->select("device_parent","device_id",["school"=>$furlough_announcement['school'],"deleted"=> 0,
					"parent"=>$parents['id'],
					"status"=>'A']);
                        // $device2 = $database->select("device_teacher","device_id",["school"=>$school_id,"deleted"=> 0,"status"=>'A']);
                        // $device = array_merge($device1, $device2);

                        function sendNotification($title,$message,$device) {
                            $content = array(
                                "en" => $message // Nội dung thông báo (có thể thay đổi ngôn ngữ ở đây)
                            );
                        
                            $fields = [
                                'app_id' => 'c0bd1290-a222-4a69-b48f-e1a756d3e1b6', // ID ứng dụng OneSignal của bạn
                                'include_player_ids' =>$device, // Danh sách các device token
                                'contents' => $content,
                                'headings' => array("en" => $title) // Tiêu đề thông báo
                            ];
                        
                            $fields = json_encode($fields);
                        
                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                'Content-Type: application/json; charset=utf-8',
                                'Authorization: Basic ODQzZTk1NmMtMjIwNi00NmNhLTgxZDMtMzg2NTBkODJjYTBl' // Thay YOUR_REST_API_KEY bằng khóa REST API của bạn
                            ));
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_HEADER, false);
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        
                            $result = curl_exec($ch);
                        
                            if ($result === FALSE) {
                                die('Curl failed: ' . curl_error($ch));
                            }
                        
                            curl_close($ch);
                        
                            return $result;
                        }
                        
                        // Gọi hàm sendNotification để gửi thông báo đẩy
                        $title =  $school['name'];
                        $message = "Đã duyệt xin nghỉ phép cho học sinh ".$students['fullname'];
                        $result = sendNotification($title,$message,$device);

				echo json_encode(['status' => 'success', 'device'=>$device,'content' =>$furlough_announcement]);
			}
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'furlough__delete_browser_teacher') {
		$getToken = $xss->xss($data['token']);

		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']) {
			
				$furlough_announcement = $database->get("furlough", "*", [
					"AND" => [
						"id" => $router['2'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$school = $database->get("school", "*", [
					"AND" => [
						"id" => $furlough_announcement['school'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$arrange_class = $database->get("arrange_class", "*", [
					"AND" => [
						"id" => $furlough_announcement['arrange_class'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$students = $database->get("students", "*", [
					"AND" => [
						"id" => $arrange_class['students'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$parents = $database->get("parent", "*", [
					"AND" => [
						"id" => $students['parent'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				
				$update=['statu'=>'C','count'=>2];

				$teacher=$database->select("teacher", "*", [
					"AND" => [
						"id" => $teacher_announcement['teacher'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				

				$database->update("furlough", $update,["id"=>$furlough_announcement['id']]);
				$jatbi->logs('furlough', 'update', $update);
				$device= $database->select("device_parent","device_id",["school"=>$furlough_announcement['school'],"deleted"=> 0,
					"parent"=>$parents['id'],
					"status"=>'A']);
                        // $device2 = $database->select("device_teacher","device_id",["school"=>$school_id,"deleted"=> 0,"status"=>'A']);
                        // $device = array_merge($device1, $device2);

                        function sendNotification($title,$message,$device) {
                            $content = array(
                                "en" => $message // Nội dung thông báo (có thể thay đổi ngôn ngữ ở đây)
                            );
                        
                            $fields = [
                                'app_id' => 'c0bd1290-a222-4a69-b48f-e1a756d3e1b6', // ID ứng dụng OneSignal của bạn
                                'include_player_ids' =>$device, // Danh sách các device token
                                'contents' => $content,
                                'headings' => array("en" => $title) // Tiêu đề thông báo
                            ];
                        
                            $fields = json_encode($fields);
                        
                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                'Content-Type: application/json; charset=utf-8',
                                'Authorization: Basic ODQzZTk1NmMtMjIwNi00NmNhLTgxZDMtMzg2NTBkODJjYTBl' // Thay YOUR_REST_API_KEY bằng khóa REST API của bạn
                            ));
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_HEADER, false);
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        
                            $result = curl_exec($ch);
                        
                            if ($result === FALSE) {
                                die('Curl failed: ' . curl_error($ch));
                            }
                        
                            curl_close($ch);
                        
                            return $result;
                        }
                        
                        // Gọi hàm sendNotification để gửi thông báo đẩy
                        $title =  $school['name'];
                        $message = "Đã từ chối xin nghỉ phép của học ".$students['fullname'];
                        $result = sendNotification($title,$message,$device);

				echo json_encode(['status' => 'success', 'content' =>$furlough_announcement]);
			}
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'furlough_announcement_detail_teacher') {
		$getToken = $xss->xss($data['token']);

		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']) {
			
				$furlough = $database->get("furlough", "*", [
					"AND" => [
						"id" => $router['2'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				
				$update=['view'=>1,];
				// $teacher=$database->select("teacher", "*", [
				// 	"AND" => [
				// 		"id" => $teacher_announcement['teacher'],
				// 		"status" => 'A',
				// 		"deleted" => 0,
				// 	]
				// ]);
				

				$database->update("furlough", $update,["id"=>$furlough['id']]);
				$jatbi->logs('furlought', 'update', $update);

				echo json_encode(['status' => 'success', 'content' =>$furlough]);
			}
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'students_register_car_teacher') {
		$getToken = $xss->xss($data['token']);
		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			
				$course=$database->get("course" , "*",[
					"AND" => [
						"id"=>$xss->xss($data['id_course']),
						"status" => 'A',
						"deleted" => 0,
					]
				]);
			$class_diagram = $database->get("class_diagram", "*", [
						"AND" => [
							"homeroom_teacher" =>$payload['accounts'],
							"school" => $xss->xss($data['id_school_teacher']),
							"course"=>$course['id'],
							"status" => "A",
							"deleted" => 0,
						]
					]);

			$arrange_class = $database->select("arrange_class", "*", [
					    "AND" => [
					    	"class_diagram"=>$class_diagram['id'],
					       // "students" => $getStudent['id'],
					        //"school" => $getStudent['school'],
					        "status" => 'A',
					        "deleted" => 0,
					    ]
					]);
			
				
				
				
				 $date=date('Y-m-d');
				$semester=$database->get("semester" , "*",[
					"AND" => [
						"enddate[>=]"=> $date,
						"startdate[<=]"=> $date,
						"course"=>$course['id'],
						"school"=>$xss->xss($data['id_school_teacher']),
						"status" => 'A',
						"deleted" => 0,
					]
				]);
		

				foreach($arrange_class as $arrange_class4){
				$student_register_car = $database->get("student_register_car", "*", [
						"AND" => [
							
							"arrange_class" => $arrange_class4['id'],
							"semester"=>$semester['id'],
							"status" => 'A',
							"deleted" => 0,
						]
					]);
				$students = $database->get("students", "*", [
					"AND" => [
						"school" =>$xss->xss($data['id_school_teacher']),
						"id" => $arrange_class4['students'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$route=$database->get("route" , "*",[
				"AND" => [
					"school" =>$xss->xss($data['id_school_teacher']),
					"id"=>$student_register_car['route'],
					"status" => "A",
					"deleted" => 0,
				]
			]);

				if ($student_register_car!=null) {
					$arrange_class_student[]=[
						"id_arrange_class"=>$student_register_car['arrange_class'],
						"id_student_register_car"=>$student_register_car['id'],
						"firstname"=>$students['firstname'],
						"view"=>$student_register_car['view'],
						"count"=>$student_register_car['count'],
						"lastname"=>$students['lastname'],
						"semester"=>$semester['name'],
						"route"=>$route['name'],
						"statu"=>$student_register_car['statu'],
						"course"=>$course['name'],

					];
				}
				}
				echo json_encode(['status' => 'success', 'content' =>	$arrange_class_student,'semester'=>$semester]);
			
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'students_register_car_browser_teacher') {
		$getToken = $xss->xss($data['token']);

		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']) {
			
				$students_register_car = $database->get("student_register_car", "*", [
					"AND" => [
						"id" => $router['2'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$school = $database->get("school", "*", [
					"AND" => [
						"id" => $students_register_car['school'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$arrange_class = $database->get("arrange_class", "*", [
					"AND" => [
						"id" => $students_register_car['arrange_class'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$students = $database->get("students", "*", [
					"AND" => [
						"id" => $arrange_class['students'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$parents = $database->get("parent", "*", [
					"AND" => [
						"id" => $students['parent'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				
				$update=['statu'=>'D','count'=>1];

				$database->update("student_register_car", $update,["id"=>$students_register_car['id']]);
				$jatbi->logs('student_register_car', 'update', $update);

				$device= $database->select("device_parent","device_id",["school"=>$students_register_car['school'],"deleted"=> 0,
					"parent"=>$parents['id'],
					"status"=>'A']);
                        // $device2 = $database->select("device_teacher","device_id",["school"=>$school_id,"deleted"=> 0,"status"=>'A']);
                        // $device = array_merge($device1, $device2);

                        function sendNotification($title,$message,$device) {
                            $content = array(
                                "en" => $message // Nội dung thông báo (có thể thay đổi ngôn ngữ ở đây)
                            );
                        
                            $fields = [
                                'app_id' => 'c0bd1290-a222-4a69-b48f-e1a756d3e1b6', // ID ứng dụng OneSignal của bạn
                                'include_player_ids' =>$device, // Danh sách các device token
                                'contents' => $content,
                                'headings' => array("en" => $title) // Tiêu đề thông báo
                            ];
                        
                            $fields = json_encode($fields);
                        
                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                'Content-Type: application/json; charset=utf-8',
                                'Authorization: Basic ODQzZTk1NmMtMjIwNi00NmNhLTgxZDMtMzg2NTBkODJjYTBl' // Thay YOUR_REST_API_KEY bằng khóa REST API của bạn
                            ));
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_HEADER, false);
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        
                            $result = curl_exec($ch);
                        
                            if ($result === FALSE) {
                                die('Curl failed: ' . curl_error($ch));
                            }
                        
                            curl_close($ch);
                        
                            return $result;
                        }
                        
                        // Gọi hàm sendNotification để gửi thông báo đẩy
                        $title =  $school['name'];
                        $message = "Đã duyệt đăng ký xe cho học sinh ".$students['fullname'];
                        $result = sendNotification($title,$message,$device);
				echo json_encode(['status' => 'success', 'content' =>$students_register_car]);
			}
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'students_register_car__delete_browser_teacher') {
		$getToken = $xss->xss($data['token']);

		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']) {
			
				$students_register_car = $database->get("student_register_car", "*", [
					"AND" => [
						"id" => $router['2'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$school = $database->get("school", "*", [
					"AND" => [
						"id" => $students_register_car['school'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$arrange_class = $database->get("arrange_class", "*", [
					"AND" => [
						"id" => $students_register_car['arrange_class'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$students = $database->get("students", "*", [
					"AND" => [
						"id" => $arrange_class['students'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				$parents = $database->get("parent", "*", [
					"AND" => [
						"id" => $students['parent'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				
				$update=['statu'=>'C','count'=>2];


				$database->update("student_register_car", $update,["id"=>$students_register_car['id']]);
				$jatbi->logs('student_register_car', 'update', $update);
				$device= $database->select("device_parent","device_id",["school"=>$students_register_car['school'],"deleted"=> 0,
					"parent"=>$parents['id'],
					"status"=>'A']);
                        // $device2 = $database->select("device_teacher","device_id",["school"=>$school_id,"deleted"=> 0,"status"=>'A']);
                        // $device = array_merge($device1, $device2);

                        function sendNotification($title,$message,$device) {
                            $content = array(
                                "en" => $message // Nội dung thông báo (có thể thay đổi ngôn ngữ ở đây)
                            );
                        
                            $fields = [
                                'app_id' => 'c0bd1290-a222-4a69-b48f-e1a756d3e1b6', // ID ứng dụng OneSignal của bạn
                                'include_player_ids' =>$device, // Danh sách các device token
                                'contents' => $content,
                                'headings' => array("en" => $title) // Tiêu đề thông báo
                            ];
                        
                            $fields = json_encode($fields);
                        
                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                'Content-Type: application/json; charset=utf-8',
                                'Authorization: Basic ODQzZTk1NmMtMjIwNi00NmNhLTgxZDMtMzg2NTBkODJjYTBl' // Thay YOUR_REST_API_KEY bằng khóa REST API của bạn
                            ));
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_HEADER, false);
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        
                            $result = curl_exec($ch);
                        
                            if ($result === FALSE) {
                                die('Curl failed: ' . curl_error($ch));
                            }
                        
                            curl_close($ch);
                        
                            return $result;
                        }
                        
                        // Gọi hàm sendNotification để gửi thông báo đẩy
                        $title =  $school['name'];
                        $message = "Từ chối đăng ký xe của học sinh ".$students['fullname'];
                        $result = sendNotification($title,$message,$device);

				echo json_encode(['status' => 'success', 'content' =>$students_register_car]);
			}
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'students-register_car_detail_teacher') {
		$getToken = $xss->xss($data['token']);

		$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
		$decoded_token = (array) $token;
		$payload = $database->get("payload", "*", [
			"phone_number" => $decoded_token['phone_number'],
			"accounts" => $decoded_token['accounts'],
			"agent" => $decoded_token['agent'],
			"date" => $decoded_token['date'],
			"identify" => $decoded_token['identify'],
		]);
		if ($payload > 1) {
			if ($router['2']) {
			
				$students_register_car = $database->get("student_register_car", "*", [
					"AND" => [
						"id" => $router['2'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
				
				$update=['view'=>1];
				// $teacher=$database->select("teacher", "*", [
				// 	"AND" => [
				// 		"id" => $teacher_announcement['teacher'],
				// 		"status" => 'A',
				// 		"deleted" => 0,
				// 	]
				// ]);
				

				$database->update("student_register_car", $update,["id"=>$students_register_car['id']]);
				$jatbi->logs('student_register_car', 'update', $update);

				echo json_encode(['status' => 'success', 'content' =>$students_register_car]);
			}
		} else {
			echo json_encode(['status' => 'error', 'content' => 'error']);
		}
	} elseif ($router['1'] == 'class_noteBook_teacher') {
			$getToken = $xss->xss($data['token']);
			$token = JWT::decode($getToken, $setting['secret-key'], array('HS256'));
			$decoded_token = (array) $token;
			$payload = $database->get("payload", "*", [
				"phone_number" => $decoded_token['phone_number'],
				"accounts" => $decoded_token['accounts'],
				"agent" => $decoded_token['agent'],
				"date" => $decoded_token['date'],
				"identify" => $decoded_token['identify'],
			]);
			if ($payload > 1) {
				if($data['content'] == "" )
				{
					echo json_encode(['status' => 'error', 'content' => 'Lỗi dữ liệu trống']);
				} elseif($data['content']){
			$note_book=$database->get("note_book" , "*",[
					"AND" => [
						"teacher" => $payload['accounts'],
						"status" => 'A',
						"deleted" => 0,
					]
				]);
			if ($note_book==null) {
					$insert = [
						"content" => $xss->xss($data['content']),
						"teacher" => $payload['accounts'],
						"status" => 'A',
						"deleted" => 0,
						
					];
					$database->insert("note_book", $insert);
					$jatbi->logs('note_book', 'add', $insert);
					echo json_encode(['status' => 'success', 'note_book' => $insert]);
				}
				else {
					$insert = [
						"content" => $xss->xss($data['content']),
						"teacher" => $payload['accounts'],
						"status" => 'A',
						"deleted" => 0,
						
					];
					$database->update("note_book",$insert,["id"=>$note_book['id']]);
					$jatbi->logs('note_book', 'add', $insert);
					echo json_encode(['status' => 'success', 'note_book' => $insert]);
				}
			}
		  
		} else {
			echo json_encode(['status' => 'error', 'content' => 'Không thể kết nối đến server',]);
		}
	} 
}

?>