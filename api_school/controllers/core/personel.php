<?php 
	if (!defined('JATBI')) die("Hacking attempt");
    $school_id=$_SESSION['school'];
    $school_teachers=$database->select("school_teacher","*",['school'=>$school_id,"deleted"=> 0,"status"=>'A']);
    $course = $database->select("course", "*",["school"=>$school_id,"deleted"=> 0,"status"=>'A']);
    $school_parents=$database->select("school_parent","*",['school'=>$school_id,"deleted"=> 0,"status"=>'A']);
    $personelss = $database->select("personels", "*",["school"=>$school_id,"deleted"=> 0,"status"=>'A']);
    $parent = $database->select("parent", "*",["deleted"=> 0,"status"=>'A']);
    $province = $database->select("province", "*",["deleted"=> 0,"status"=>'A']);
    $district = $database->select("district", "*",["deleted"=> 0,"status"=>'A']);
    $class = $database->select("class", "*",["school"=>$school_id,"deleted"=> 0,"status"=>'A']);
    $department=$database->select("department", "*",["school"=>$school_id,"deleted"=> 0,"status"=>'A']);
    $subject = $database->select("subject", "*",["school"=>$school_id,"deleted"=> 0,"status"=>'A']);
    $regent = $database->select("regent", "*",["school"=>$school_id,"deleted"=> 0,"status"=>'A']);
    $areas= $database->select("areas", "*",["school"=>$school_id,"deleted"=> 0,"status"=>'A']);
    $priority_object= $database->select("priority_object", "*",["deleted"=> 0,"status"=>'A']);
    $religion= $database->select("religion", "*",["deleted"=> 0,"status"=>'A']);
    $ethnic= $database->select("ethnic", "*",["deleted"=> 0,"status"=>'A']);
    $nationality= $database->select("nationality", "*",["deleted"=> 0,"status"=>'A']);
    if($router['1']=='teachers'){
        $jatbi->permission('teachers');
        $count = $database->count("teacher",[
            'AND' => [
                "id" => $school_teachers["teacher"],
                "deleted"       => 0,
            ]]
        );
        $pg = $_GET['pg'];
        if (!$pg) $pg = 1;
        foreach ($school_teachers as $school){
            $datas[]= $database->get("teacher", "*",[
            "AND" => [
                "OR"=>[
                    'firstname[~]'    => ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
                    'lastname[~]'      => ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
                    'birthday[~]'      => ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
                    'fullname[~]'      => ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
                    'gender[~]'      => ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
                    'phone_number[~]'      => ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
                    'academic_function[~]'      => ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
                ],
                'status'        => ($xss->xss($_GET['status'])=='')?[A,D]:$xss->xss($_GET['status']), 
                "deleted"       => 0,
                "id" => $school["teacher"],

            ],
            "LIMIT" =>[(($pg-1)*$setting['site_page']),$setting['site_page']],
            "ORDER" => [    
                "id"=>"DESC",
            ]
        ]);
        }
        $page = $jatbi->pages($count,$setting['site_page'],$pg);
        $templates = $setting['site_backend'].'personel.tpl';
    }
    elseif($router['1']=='teachers-face-delete'){
		$jatbi->permission('teachers.edit');
		$ajax = 'true';
		if($router['2']){
			$data = $database->get("teacher", "*",["id"=>$xss->xss($router['2'])]);
			if($data>1){
				if(isset($_POST['submit'])){
					if($data['face']==1){
						$curl = curl_init();
						$array = [
				    		"token" => $APIfaceid['token'],
				    		"place_active" => $APIfaceid['place'],
				    		"emp_id" => $data['active'],
				    	];
						curl_setopt_array($curl, array(
						  CURLOPT_URL => 'https://api.cam.eclo.io/face/delfacebyid',
						  CURLOPT_RETURNTRANSFER => true,
						  CURLOPT_ENCODING => '',
						  CURLOPT_MAXREDIRS => 10,
						  CURLOPT_TIMEOUT => 0,
						  CURLOPT_FOLLOWLOCATION => true,
						  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						  CURLOPT_CUSTOMREQUEST => 'POST',
                          CURLOPT_SSL_VERIFYPEER => false,
						  CURLOPT_POSTFIELDS =>json_encode($array),
						  CURLOPT_HTTPHEADER => array(
						    'Content-Type: application/json'
						  ),
						));
						$response = curl_exec($curl);
						curl_close($curl);
						$getData = json_decode($response,true);
						if($getData['status']=='success'){
							$update = [
					    		"face" => 0,
					    		"avatar" => 'no-images.jpg',
					    	];
					    	$database->update("teacher",$update,["id"=>$data['id']]);
							echo json_encode(['status'=>'success','content'=>$getData['content']]);
						}
						else {
							echo json_encode(['status'=>'error','content'=>$getData['content']]);
						}
					}
					else {
						echo json_encode(['status'=>'error','content'=>'Chưa đăng ký face']);
					}
				} else {
					$templates = $setting['site_backend'].'personel.tpl';
				}
			}
			else {
				header("HTTP/1.0 404 Not Found");
				die();
			}
		}
	}
    elseif($router['1']=='teacher-face'){
		$jatbi->permission('teachers.edit');
		$ajax = 'true';
		if($router['2']){
			$data = $database->get("teacher", "*",["id"=>$xss->xss($router['2'])]);
			if($data>1){
				if(isset($_POST['token'])){
					$handle = new Upload($_FILES['avatar']);
					if ($handle->uploaded) {
				        $handle->allowed 		= array('application/msword', 'image/*');
				        $handle->Process($upload['images']['avatar']['url']);
				        $handle->image_resize   = true;
				        $handle->image_ratio_crop  = true;
				        $handle->image_y        = $upload['images']["avatar"]['thumb_y'];
					    $handle->image_x        = $upload['images']["avatar"]['thumb_x'];
				        $handle->allowed 		= array('application/msword', 'image/*');
				        $handle->Process($upload['images']['avatar']['url'].'thumb/');
				    }
				    if ($handle->processed){
				    	$images = $handle->file_dst_name;
				    }
				    else {
				    	$error = json_encode(['status'=>'error','content'=>$handle->error]);
				    }
                    if(count($error)==0){
				    	if($data['face']==1){
				    		$api = 'https://api.cam.eclo.io/face/updateface';
				    	}
				    	elseif($data['face']==0){
				    		$api = 'https://api.cam.eclo.io/face/addface';
				    	}
				    	$photo = $setting['site_url'].$upload['images']['avatar']['url'].$images;
				    	$array = [
				    		"token" => $APIfaceid['token'],
				    		"place_active" => $APIfaceid['place'],
				    		"name" => $data['firstname'] . $data['lastname'],
				    		"emp_id" => $data['active'],
				    		"photo" => $photo,
				    		"type" => 1,
                            
				    	];
                 
				    	$curl = curl_init();
						curl_setopt_array($curl, array(
						  CURLOPT_URL => $api,
						  CURLOPT_RETURNTRANSFER => true,
						  CURLOPT_ENCODING => '',
						  CURLOPT_MAXREDIRS => 10,
						  CURLOPT_TIMEOUT => 0,
						  CURLOPT_FOLLOWLOCATION => true,
						  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						  CURLOPT_CUSTOMREQUEST => 'POST',
                          CURLOPT_SSL_VERIFYPEER => false,
						  CURLOPT_POSTFIELDS => json_encode($array),
						  CURLOPT_HTTPHEADER => array(
						    'Content-Type: application/json'
						  ),
						  
						));
						$response = curl_exec($curl);
						curl_close($curl);
						$getData = json_decode($response,true);
						if($getData['status']=='success'){
							$update = [
					    		"face" => 1,
					    		"avatar" => $photo,
					    	];
					    	$database->update("teacher",$update,["id"=>$data['id']]);
							echo json_encode(['status'=>'success','content'=>$getData['content'],"data"=>$getData,"array"=>$array]);
						}
						else {
							echo json_encode(['status'=>'error','content'=>$getData['content'],"data"=>$getData,"array"=>$array]);
						}
				    }
				    else {
				    	echo $error;
				    }
				} else {
					$templates = $setting['site_backend'].'personel.tpl';
				}
			}
			else {
				header("HTTP/1.0 404 Not Found");
				die();
			}
		}
	}
    elseif($router['1']=='teachers-add'){
        $jatbi->permission('teachers.add');
        $ajax = 'true';
        if(isset($_POST['token'])){
            // $handle = new Upload($_FILES['avatar']);
            $count = $database->count("teacher",[
                'AND' => [
                    "phone_number"  => $xss->xss($_POST['phone_number']),
                    "status"        => 'A',  
                    "deleted"       => 0,
                ]]
            );
            $teacherss=$database->get("teacher","id",[
                'AND' => [
                    "phone_number"  => $_POST['phone_number'],
                    "status"        => 'A',  
                    "deleted"       => 0,
                ]]
            );
            $count_active = $database->count("school_teacher",[
                'AND' => [
                    "teacher"  => $teacherss,
                    'school'    =>$school_id,
                    "status"        => 'A',  
                    "deleted"       => 0,
                ]]
            );
            // if($_POST['avatar'] == ""){
            //     $face=0;
            // }else{
            //     $face=1;
            // }
            if($_POST['token']!=$_SESSION['csrf']['token']){
                echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
            }
            elseif($_POST['firstname'] == "" || $_POST['password'] == "" || $_POST['lastname'] == "" || $_POST['birthday'] == "" || $_POST['phone_number'] == ""|| $_POST['address'] == ""|| $_POST['email'] == ""|| $_POST['address'] == "" || $_POST['province'] == "" || $_POST['district'] == "" || $_POST['ward'] == ""  ){
                echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
            }
            elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                echo json_encode(['status'=>'error','content'=>$lang['email-khong-dung'],'sound'=>$setting['site_sound']]);
            }
            // if ($handle->uploaded) {
            //     $handle->allowed        = array('application/msword', 'image/*');
            //     $handle->Process($upload['images']['avatar']['url']);
            //     $handle->image_resize   = true;
            //     $handle->image_ratio_crop  = true;
            //     $handle->image_y        = $upload['images']["avatar"]['thumb_y'];
            //     $handle->image_x        = $upload['images']["avatar"]['thumb_x'];
            //     $handle->allowed        = array('application/msword', 'image/*');
            //     $handle->Process($upload['images']['avatar']['url'].'thumb/');
            // }
            if($count>0){
                if($count_active==0){
                    $insert_register=[
                        "teacher"=> $teacherss,
                        "school"=> $school_id,
                        "id_teacher"=> $xss->xss($_POST['id_teacher']),
                        "regent"=> $xss->xss($_POST['regent']),
                        "department"=> $xss->xss($_POST['department']),
                        "subject"=> $xss->xss($_POST['subject']),
                        "date_start_work"=> $xss->xss($_POST['date_start_work']),
                        "status"=>'A',
                    ];
                    $database->insert("school_teacher",$insert_register);
                    $jatbi->logs('school_teacher','add',$insert_register);
                    echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
                   
                }else{
                    echo json_encode(['status'=>'error','content'=>$lang['tai-khoan-da-dang-ki'],'sound'=>$setting['site_sound']]);   
                }
            } elseif($count==0 && $count_active==0){
                if ($_POST['firstname'] && $_POST['password'] && $_POST['lastname']&& $_POST['birthday'] && $_POST['phone_number']  && $_POST['address'] && $_POST['email'] && $_POST['address'] && $_POST['province'] && $_POST['district'] && $_POST['ward'] ) {
                    // $img = $setting['site_url'].$upload['images']['avatar']['url'].$handle->file_dst_name;
                    $insert = [
                        "firstname"             => $xss->xss($_POST['firstname']),
                        "lastname"              => $xss->xss($_POST['lastname']),
                        "fullname"         => $xss->xss($_POST['firstname']).' '.$xss->xss($_POST['lastname']),
                        "birthday"              => date('Y-m-d',strtotime(str_replace('/','-',$_POST['birthday']))),    
                        "citizenId"                => $xss->xss($_POST['citizenId']),   
                        "gender"                => $xss->xss($_POST['gender']),          
                        "phone_number"          => $xss->xss($_POST['phone_number']),
                        "password"              => password_hash($xss->xss($_POST['password']), PASSWORD_DEFAULT),
                        "email"                 => $xss->xss($_POST['email']),                   
                        "address"               => $xss->xss($_POST['address']),
                        "province"              => $xss->xss($_POST['province']),
                        "district"              => $xss->xss($_POST['district']),
                        "ward"                  => $xss->xss($_POST['ward']),  
                        // "avatar"                => $img,       
                        "face"          => 0,      
                        "active"        =>$jatbi->active(32),                               
                        "academic_function"     => $xss->xss($_POST['academic_function']),
                        "health_insurance_id"         => $xss->xss($_POST['health_insurance_id']),
                        "body_insurance_id"         => $xss->xss($_POST['body_insurance_id']),
                        "nationality"         => $xss->xss($_POST['nationality']), 
                        "ethnic"         => $xss->xss($_POST['ethnic']), 
                        "religion"         => $xss->xss($_POST['religion']),  
                        "status"                => $xss->xss($_POST['status']),
                       
                    ];
                    $database->insert("teacher",$insert);
                    $tui = $database->id();
                    $insert_register=[
                        "teacher"=> $tui,
                        "school"=> $school_id,
                        "id_teacher"=> $xss->xss($_POST['id_teacher']),
                        "regent"=> $xss->xss($_POST['regent']),
                        "department"=> $xss->xss($_POST['department']),
                        "subject"=> $xss->xss($_POST['subject']),
                        "date_start_work"=> $xss->xss($_POST['date_start_work']),
                        "status"=>'A',
                    ];
                    $database->insert("school_teacher",$insert_register);
                    $jatbi->logs('teacher','add',$insert);
                    $jatbi->logs('school_teacher','add',$insert_register);
                    echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
                }
            } 
        } 
        else {
            $templates = $setting['site_backend'].'personel.tpl';
        }
    }
    elseif($router['1']=='teachers-edit'){
        $jatbi->permission('teachers.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("teacher", "*",["id"=>$xss->xss($router['2'])]);
            $data_teacher_school = $database->get("school_teacher", "*",["teacher"=>$xss->xss($router['2']),"school"=>$school_id]);
            if($data>1){
                if(isset($_POST['token'])){
                    $partten = "/^[A-Za-z0-9_\.]{".$setting['site_characters'].",32}$/";
                    // $handle = new Upload($_FILES['avatar']);
                    if($_POST['token']!=$_SESSION['csrf']['token']){
                        echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
                    }
                    elseif($_POST['firstname'] == "" || $_POST['password'] == "" || $_POST['lastname'] == "" || $_POST['birthday'] == "" || $_POST['phone_number'] == ""|| $_POST['address'] == ""|| $_POST['email'] == ""|| $_POST['address'] == "" || $_POST['province'] == "" || $_POST['district'] == "" || $_POST['ward'] == "" ){
                        echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
                    }
                    elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                        echo json_encode(['status'=>'error','content'=>$lang['email-khong-dung'],'sound'=>$setting['site_sound']]);
                    }
                    // if($handle->uploaded){
                    //     $handle->allowed 		= array('application/msword', 'image/*');
                    //     $handle->Process($upload['images']['avatar']['url']);
                    // }
                    // if($_POST['avatar'] == ""){
                    //     $face=0;
                    // }else{
                    //     $face=1;
                    // }
                    if ( $_POST['firstname'] && $_POST['password'] && $_POST['lastname']&& $_POST['birthday'] && $_POST['phone_number']  && $_POST['address'] && $_POST['email'] && $_POST['address'] && $_POST['province'] && $_POST['district'] && $_POST['ward'] ) {
                        // $img = $setting['site_url'].$upload['images']['avatar']['url'].$handle->file_dst_name;
                        $insert = [
                            "firstname"             => $xss->xss($_POST['firstname']),
                            "lastname"              => $xss->xss($_POST['lastname']),
                            "fullname"         => $xss->xss($_POST['firstname']).' '.$xss->xss($_POST['lastname']),
                            "birthday"              => date('Y-m-d',strtotime(str_replace('/','-',$_POST['birthday']))),    
                            "citizenId"                => $xss->xss($_POST['citizenId']),        
                            "gender"                => $xss->xss($_POST['gender']),          
                            "phone_number"          => $xss->xss($_POST['phone_number']),
                            "password"              => password_hash($xss->xss($_POST['password']), PASSWORD_DEFAULT),
                            "email"                 => $xss->xss($_POST['email']),                   
                            "address"               => $xss->xss($_POST['address']),
                            "province"              => $xss->xss($_POST['province']),
                            "district"              => $xss->xss($_POST['district']),
                            "ward"                  => $xss->xss($_POST['ward']),  
                            // "avatar"                => $img,      
                            // "face"          => $face,      
                            "active"        =>$jatbi->active(32),                                
                            "academic_function"     => $xss->xss($_POST['academic_function']),
                            "health_insurance_id"         => $xss->xss($_POST['health_insurance_id']),
                            "body_insurance_id"         => $xss->xss($_POST['body_insurance_id']),
                            "nationality"         => $xss->xss($_POST['nationality']), 
                            "ethnic"         => $xss->xss($_POST['ethnic']), 
                            "religion"         => $xss->xss($_POST['religion']),  
                            "status"                => $xss->xss($_POST['status']),
                           
                        ];
                        $database->update("teacher",$insert,["id"=>$data['id']]);
                        $tui = $database->id();
                        $insert_register=[
                            "teacher"=> $tui,
                            "school"=> $school_id,
                            "id_teacher"=> $xss->xss($_POST['id_teacher']),
                            "regent"=> $xss->xss($_POST['regent']),
                            "department"=> $xss->xss($_POST['department']),
                            "subject"=> $xss->xss($_POST['subject']),
                            "date_start_work"=> $xss->xss($_POST['date_start_work']),
                            "status"=>'A',
                        ];
                        $database->update("school_teacher",$insert_register,["teacher"=>$data['id'],"school"=> $school_id]);
                        $jatbi->logs('teacher','edit',$insert);
                        echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
                    }
                } else {
                    $templates = $setting['site_backend'].'personel.tpl';
                }
            }
            else {
                header("HTTP/1.0 404 Not Found");
                die();
            }
        }
    }
    elseif($router['1']=='teachers-delete'){
        $jatbi->permission('teachers.delete');
        $ajax = 'true';
        if($router['2']){
            $datas = $database->select("teacher","*",["id"=>explode(',', $xss->xss($router['2']))]);
            if(isset($_POST['submit'])){
                $jatbi->logs('teacher','delete',$datas);
                $database->update("teacher",["deleted" => 1,],["id"=>explode(',', $xss->xss($router['2']))]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            } else {
                $templates = $setting['site_backend'].'personel.tpl';
            }
        }
        else {
            header("HTTP/1.0 404 Not Found");
            die();
        }
    }
    elseif($router['1']=='teachers-status'){
        $jatbi->permission('teachers.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("teacher", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if($data['status']==='A'){
                    $status = "D";
                } 
                elseif($data['status']==='D'){
                    $status = "A";
                }
                $database->update("teacher",["status"=>$status],["id"=>$data['id']]);
                $jatbi->logs('teacher','status',["data"=>$data,"status"=>$status]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-trang-thai'],'sound'=>$setting['site_sound']]);
            }
            else {
                echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-that-bai'],]);
            }
        }
    }
    elseif($router['1']=='personels'){
        $jatbi->permission('personels');
        $count = $database->count("personels",[
            'AND' => [
                "deleted"       => 0,
            ]]
        );
        $pg = $_GET['pg'];
        if (!$pg) $pg = 1;
     
        $datas= $database->select("personels", "*",[
            "AND" => [
                "OR"=>[
                    'name[~]'    => ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
                    'birthday[~]'      => ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
                    'gender[~]'      => ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
                    'phone_number[~]'      => ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
                ],
                'status'        => ($xss->xss($_GET['status'])=='')?[A,D]:$xss->xss($_GET['status']), 
                "deleted"       => 0,
                "school"=>$school_id,
            ],
            "LIMIT" =>[(($pg-1)*$setting['site_page']),$setting['site_page']],
            "ORDER" => [    
                "id"=>"DESC",
            ]
        ]);
        
        $page = $jatbi->pages($count,$setting['site_page'],$pg);
        $templates = $setting['site_backend'].'personel.tpl';
    }
    elseif($router['1']=='personels-face-delete'){
		$jatbi->permission('personels.edit');
		$ajax = 'true';
		if($router['2']){
			$data = $database->get("personels", "*",["id"=>$xss->xss($router['2'])]);
			if($data>1){
				if(isset($_POST['submit'])){
					if($data['face']==1){
						$curl = curl_init();
						$array = [
				    		"token" => $APIfaceid['token'],
				    		"place_active" => $APIfaceid['place'],
				    		"emp_id" => $data['active'],
				    	];
						curl_setopt_array($curl, array(
						  CURLOPT_URL => 'https://api.cam.eclo.io/face/delfacebyid',
						  CURLOPT_RETURNTRANSFER => true,
						  CURLOPT_ENCODING => '',
						  CURLOPT_MAXREDIRS => 10,
						  CURLOPT_TIMEOUT => 0,
						  CURLOPT_FOLLOWLOCATION => true,
						  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						  CURLOPT_CUSTOMREQUEST => 'POST',
                          CURLOPT_SSL_VERIFYPEER => false,
						  CURLOPT_POSTFIELDS =>json_encode($array),
						  CURLOPT_HTTPHEADER => array(
						    'Content-Type: application/json'
						  ),
						));
						$response = curl_exec($curl);
						curl_close($curl);
						$getData = json_decode($response,true);
						if($getData['status']=='success'){
							$update = [
					    		"face" => 0,
					    		"avatar" => 'no-images.jpg',
					    	];
					    	$database->update("personels",$update,["id"=>$data['id']]);
							echo json_encode(['status'=>'success','content'=>$getData['content']]);
						}
						else {
							echo json_encode(['status'=>'error','content'=>$getData['content']]);
						}
					}
					else {
						echo json_encode(['status'=>'error','content'=>'Chưa đăng ký face']);
					}
				} else {
					$templates = $setting['site_backend'].'personel.tpl';
				}
			}
			else {
				header("HTTP/1.0 404 Not Found");
				die();
			}
		}
	}
    elseif($router['1']=='personels-face'){
		$jatbi->permission('personels.edit');
		$ajax = 'true';
		if($router['2']){
			$data = $database->get("personels", "*",["id"=>$xss->xss($router['2'])]);
			if($data>1){
				if(isset($_POST['token'])){
					$handle = new Upload($_FILES['avatar']);
					if ($handle->uploaded) {
				        $handle->allowed 		= array('application/msword', 'image/*');
				        $handle->Process($upload['images']['avatar']['url']);
				        $handle->image_resize   = true;
				        $handle->image_ratio_crop  = true;
				        $handle->image_y        = $upload['images']["avatar"]['thumb_y'];
					    $handle->image_x        = $upload['images']["avatar"]['thumb_x'];
				        $handle->allowed 		= array('application/msword', 'image/*');
				        $handle->Process($upload['images']['avatar']['url'].'thumb/');
				    }
				    if ($handle->processed){
				    	$images = $handle->file_dst_name;
				    }
				    else {
				    	$error = json_encode(['status'=>'error','content'=>$handle->error]);
				    }
                    if(count($error)==0){
				    	if($data['face']==1){
				    		$api = 'https://api.cam.eclo.io/face/updateface';
				    	}
				    	elseif($data['face']==0){
				    		$api = 'https://api.cam.eclo.io/face/addface';
				    	}
				    	$photo = $setting['site_url'].$upload['images']['avatar']['url'].$images;
				    	$array = [
				    		"token" => $APIfaceid['token'],
				    		"place_active" => $APIfaceid['place'],
				    		"name" => $data['name'],
				    		"emp_id" => $data['active'],
				    		"photo" => $photo,
				    		"type" => 2,
                            
				    	];
                 
				    	$curl = curl_init();
						curl_setopt_array($curl, array(
						  CURLOPT_URL => $api,
						  CURLOPT_RETURNTRANSFER => true,
						  CURLOPT_ENCODING => '',
						  CURLOPT_MAXREDIRS => 10,
						  CURLOPT_TIMEOUT => 0,
						  CURLOPT_FOLLOWLOCATION => true,
						  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						  CURLOPT_CUSTOMREQUEST => 'POST',
                          CURLOPT_SSL_VERIFYPEER => false,
						  CURLOPT_POSTFIELDS => json_encode($array),
						  CURLOPT_HTTPHEADER => array(
						    'Content-Type: application/json'
						  ),
						  
						));
						$response = curl_exec($curl);
						curl_close($curl);
						$getData = json_decode($response,true);
						if($getData['status']=='success'){
							$update = [
					    		"face" => 1,
					    		"avatar" => $photo,
					    	];
					    	$database->update("personels",$update,["id"=>$data['id']]);
							echo json_encode(['status'=>'success','content'=>$getData['content'],"data"=>$getData,"array"=>$array]);
						}
						else {
							echo json_encode(['status'=>'error','content'=>$getData['content'],"data"=>$getData,"array"=>$array]);
						}
				    }
				    else {
				    	echo $error;
				    }
				} else {
					$templates = $setting['site_backend'].'personel.tpl';
				}
			}
			else {
				header("HTTP/1.0 404 Not Found");
				die();
			}
		}
	}
    elseif($router['1']=='personels-add'){
        $jatbi->permission('personels.add');
        $ajax = 'true';
        if(isset($_POST['token'])){
            $handle = new Upload($_FILES['avatar']);
            if($_POST['token']!=$_SESSION['csrf']['token']){
                echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
            }
            elseif($_POST['name'] == "" || $_POST['gender'] == "" || $_POST['birthday'] == "" || $_POST['phone_number'] == ""|| $_POST['address'] == "" || $_POST['province'] == "" || $_POST['district'] == "" || $_POST['ward'] == "" || $_POST['citizenId'] == ""  || $_POST['date_start_work'] == ""|| $_POST['type'] == ""){
                echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
            }
            if ($handle->uploaded) {
                $handle->allowed        = array('application/msword', 'image/*');
                $handle->Process($upload['images']['avatar']['url']);
                $handle->image_resize   = true;
                $handle->image_ratio_crop  = true;
                $handle->image_y        = $upload['images']["avatar"]['thumb_y'];
                $handle->image_x        = $upload['images']["avatar"]['thumb_x'];
                $handle->allowed        = array('application/msword', 'image/*');
                $handle->Process($upload['images']['avatar']['url'].'thumb/');
            }
            if($_POST['avatar'] == ""){
                $face=0;
            }else{
                $face=1;
            }
            if ($handle->processed && $_POST['name'] && $_POST['gender'] && $_POST['birthday'] && $_POST['phone_number'] && $_POST['address'] && $_POST['type'] && $_POST['province'] && $_POST['district'] && $_POST['ward'] && $_POST['citizenId']  && $_POST['date_start_work']) {
                $img = $setting['site_url'].$upload['images']['avatar']['url'].$handle->file_dst_name;
                $insert = [
                    "name"          => $xss->xss($_POST['name']),
                    "birthday"      => date('Y-m-d',strtotime(str_replace('/','-',$_POST['birthday']))),      
                    "gender"        => $xss->xss($_POST['gender']),  
                    "phone_number"          => $xss->xss($_POST['phone_number']),
                    "citizenId"         => $xss->xss($_POST['citizenId']),
                    "date_start_work"          => date('Y-m-d H:i:s'),
                    "email"         => $xss->xss($_POST['email']), 
                    "address"         => $xss->xss($_POST['address']),
                    "province"         => $xss->xss($_POST['province']),
                    "district"         => $xss->xss($_POST['district']),
                    "ward"         => $xss->xss($_POST['ward']),                       
                    "avatar"        => $img,    
                    "face"          => $face,      
                    "active"        =>$jatbi->active(32),         
                    "nationality"         => $xss->xss($_POST['nationality']),
                    "ethnic"         => $xss->xss($_POST['ethnic']),
                    "religion"         => $xss->xss($_POST['religion']),     
                    "type"         => $xss->xss($_POST['type']),           
                    "status"        => $xss->xss($_POST['status']),
                    "school"=>$school_id,
                   
                ];
                $database->insert("personels",$insert);
                $jatbi->logs('personels','add',$insert);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            }
        } 
        else {
            $templates = $setting['site_backend'].'personel.tpl';
        }
    }
    elseif($router['1']=='personels-edit'){
        $jatbi->permission('personels.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("personels", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if(isset($_POST['token'])){
                    $handle = new Upload($_FILES['avatar']);
            if($_POST['token']!=$_SESSION['csrf']['token']){
                echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
            }
            elseif($_POST['name'] == "" || $_POST['gender'] == "" || $_POST['birthday'] == "" || $_POST['phone_number'] == ""|| $_POST['address'] == "" || $_POST['province'] == "" || $_POST['district'] == "" || $_POST['ward'] == "" || $_POST['citizenId'] == ""  || $_POST['date_start_work'] == ""|| $_POST['type'] == ""){
                echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
            }
            if ($handle->uploaded) {
                $handle->allowed        = array('application/msword', 'image/*');
                $handle->Process($upload['images']['avatar']['url']);
                $handle->image_resize   = true;
                $handle->image_ratio_crop  = true;
                $handle->image_y        = $upload['images']["avatar"]['thumb_y'];
                $handle->image_x        = $upload['images']["avatar"]['thumb_x'];
                $handle->allowed        = array('application/msword', 'image/*');
                $handle->Process($upload['images']['avatar']['url'].'thumb/');
            }
            if($_POST['avatar'] == ""){
                $face=0;
            }else{
                $face=1;
            }
            if ($handle->processed && $_POST['name'] && $_POST['gender'] && $_POST['birthday'] && $_POST['phone_number'] && $_POST['address'] && $_POST['type'] && $_POST['province'] && $_POST['district'] && $_POST['ward'] && $_POST['citizenId']  && $_POST['date_start_work']) {
                $img = $setting['site_url'].$upload['images']['avatar']['url'].$handle->file_dst_name;
                $insert = [
                    "name"          => $xss->xss($_POST['name']),
                    "birthday"      => date('Y-m-d',strtotime(str_replace('/','-',$_POST['birthday']))),      
                    "gender"        => $xss->xss($_POST['gender']),  
                    "phone_number"          => $xss->xss($_POST['phone_number']),
                    "citizenId"         => $xss->xss($_POST['citizenId']),
                    "date_start_work"          => date('Y-m-d H:i:s'),
                    "email"         => $xss->xss($_POST['email']), 
                    "address"         => $xss->xss($_POST['address']),
                    "province"         => $xss->xss($_POST['province']),
                    "district"         => $xss->xss($_POST['district']),
                    "ward"         => $xss->xss($_POST['ward']),                       
                    "avatar"        => $img,    
                    "face"          => $face,      
                    "active"        =>$jatbi->active(32),   
                    "nationality"         => $xss->xss($_POST['nationality']),
                    "ethnic"         => $xss->xss($_POST['ethnic']),
                    "religion"         => $xss->xss($_POST['religion']),     
                    "type"         => $xss->xss($_POST['type']),           
                    "status"        => $xss->xss($_POST['status']),
                    "school"=>$school_id,
                   
                ];
                        $database->update("personels",$insert,["id"=>$data['id']]);
                        $jatbi->logs('personels','edit',$insert);
                        echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
                    }
                } else {
                    $templates = $setting['site_backend'].'personel.tpl';
                }
            }
            else {
                header("HTTP/1.0 404 Not Found");
                die();
            }
        }
    }
    elseif($router['1']=='personels-delete'){
        $jatbi->permission('personels.delete');
        $ajax = 'true';
        if($router['2']){
            $datas = $database->select("personels","*",["id"=>explode(',', $xss->xss($router['2']))]);
            if(isset($_POST['submit'])){
                $jatbi->logs('personels','delete',$datas);
                $database->update("personels",["deleted" => 1,],["id"=>explode(',', $xss->xss($router['2']))]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            } else {
                $templates = $setting['site_backend'].'personel.tpl';
            }
        }
        else {
            header("HTTP/1.0 404 Not Found");
            die();
        }
    }
    elseif($router['1']=='personels-status'){
        $jatbi->permission('personels.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("personels", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if($data['status']==='A'){
                    $status = "D";
                } 
                elseif($data['status']==='D'){
                    $status = "A";
                }
                $database->update("personels",["status"=>$status],["id"=>$data['id']]);
                $jatbi->logs('personels','status',["data"=>$data,"status"=>$status]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-trang-thai'],'sound'=>$setting['site_sound']]);
            }
            else {
                echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-that-bai'],]);
            }
        }
    }
    elseif($router['1']=='timekeeping_teachers'){
            $jatbi->permission('timekeeping_teachers');
            $year = $xss->xss($_GET['year']) == '' ? date("Y") : $xss->xss($_GET['year']);
            $month = $xss->xss($_GET['month']) == '' ? date("m") : $xss->xss($_GET['month']);
            $date_form = date("t", strtotime($year . "-" . $month . "-01"));
            for ($day = 1; $day <= $date_form; $day++) {
                if ($day < 10) {
                    $day = '0' . $day;
                }
                $date = date("Y-m-d", strtotime($year . "-" . $month . "-" . $day));
                $week = date("N", strtotime($date));
                $dates[] = [
                    "name" => $day,
                    "date" => $date,
                    "week" => $week,
                ];
            }
            $school_teacher = $database->select("school_teacher", "*", [
                "deleted" => 0,
                "status" => 'A',
                "school"        =>$school_id,
            ]);
            
            foreach ($school_teacher as $key => $school_teacher) {
                $SelectPer[$school_teacher['id']] = $database->select("teacher", "*", [
                    // 'id[<>]' => ($xss->xss($_GET['teachers']) == '') ?: [$xss->xss($_GET['teachers']), $xss->xss($_GET['teachers'])],
                    "id"=>$school_teacher['teacher'],
                    "deleted" => 0,
                    "status" => 'A',
                ]);
                $datas[$key] = [
                    "name" => $database->get("regent","name",["id"=>$school_teacher['regent']]),
                ];
                foreach ($SelectPer[$school_teacher['id']] as $per) {
                    $datas[$key]["teachers"][$per['id']] = [
                        "id"=>$per['id'],
                        "firstname" => $per['firstname'],
                        "lastname" => $per['lastname'], 
                    ];
                    foreach ($dates as $date) {
                        if (strtotime($date['date']) >= strtotime($datas[$key]["teachers"][$per['id']]['contract'])) {
                            $datas[$key]["teachers"][$per['id']]["roster"] = $database->get("rosters", "timework", [
                                "date[<=]" => $date['date'],
                                "deleted" => 0,
                                "ORDER" => ["id" => "DESC"]
                            ]);
                            $checked[$per['id']] = $database->get("timekeeping_teachers", ["checkin", "checkout"], [
                                "teacher" => $per['id'],
                                "date" => date("Y-m-d", strtotime($date['date'])),
                                "school"        =>$school_id,
                            ]);
                            $timework_details[$per['id']] = $database->get("timework_details", "*", [
                                "week" => $date['week'],
                                "timework" => $datas[$key]["personnels"][$per['id']]['roster'],
                            ]);
                            $furloughs[$per['id']] = $database->get("furlough", "id", [
                                "arrange_class" => $per['id'],
                                "date_start[<=]" => $date['date'],
                                "date_end[>=]" => $date['date'],
                                "deleted" => 0,
                                "statu" => "D",
                                "status" => "A",
                                "school"        =>$school_id,
                            ]);
                            if ($timework_details[$per['id']]['off'] == 1) {
                                $off[$per['id']] = 1;
                                $offcontent[$per['id']] = 'OFF';
                                $color[$per['id']] = 'bg-primary bg-opacity-10';
                            } else {
                                $off[$per['id']] = 0;
                                if ($checked[$per['id']]['checkin'] != '' && $checked[$per['id']]['checkout'] == '') {
                                    $color[$per['id']] = 'bg-danger bg-opacity-10';
                                } elseif ($checked[$per['id']]['checkin'] == '' && $checked[$per['id']]['checkout'] == '') {
                                    if (strtotime($date['date'] . ' ' . $setting['timework_to']) <= strtotime(date("Y-m-d H:i:s"))) {
                                        $color[$per['id']] = 'bg-warning bg-opacity-10';
                                    } else {
                                        $color[$per['id']] = 'bg-light bg-opacity-10';
                                    }
                                } else {
                                    $color[$per['id']] = 'bg-success bg-opacity-10';
                                }
                            }
                            if ($furloughs[$per['id']] > 0) {
                                $off[$per['id']] = 1;
                                $offcontent[$per['id']] = $database->get("furlough_categorys", "code", ["deleted"=>0,"id" => $furloughs[$per['id']]]);
                                $color[$per['id']] = 'bg-primary bg-opacity-25';
                                if ($furloughs[$per['id']]['numberday'] == 4) {
                                    $furlough[$per['id']][$furloughs[$per['id']]['furlough']] = [
                                        "id" => $furloughs[$per['id']],
                                        "content" => $offcontent[$per['id']],
                                    ];
                                }
                                if ($furloughs[$per['id']]['numberday'] == 5) {
                                    $furlough[$per['id']][$furloughs[$per['id']]['furlough']] = [
                                        "id" => $furloughs[$per['id']],
                                        "content" => $offcontent[$per['id']],
                                    ];
                                }
                            }
                            $datas[$key]["teachers"][$per['id']]["dates"][$date['date']] = [
                                "id"=>$per['id'],
                                "firstname" => $per['firstname'],
                                "lastname" => $per['lastname'], 
                                "date" => $date['date'],
                                "week" => $date['week'],
                                "color" => $color[$per['id']],
                                "checkin" => [
                                    "time" => $checked[$per['id']]['checkin'],
                                ],
                                "checkout" => [
                                    "time" => $checked[$per['id']]['checkout'],
                                ],
                                "off" => [
                                    "status" => $off[$per['id']],
                                    "content" => $offcontent[$per['id']],
                                ],
                            ];
                        } else {
                            $datas[$key]["teachers"][$per['id']]["dates"][$date['date']] = [
                                "firstname" => $per['firstname'],
                                "lastname" => $per['lastname'], 
                                "date" => $date['date'],
                                "week" => $date['week'],
                                "status" => '',
                                "color" => "bg-secondary bg-opacity-25",
                            ];
                        }
                    }
                }
            }
            $templates = $setting['site_backend'] . 'personel.tpl';
    }
    elseif($router['1']=='timekeeping_teachers-add'){
    
        $jatbi->permission('timekeeping_teachers.add');
        $ajax = 'true';
        
        if (isset($_POST['token'])) {

            if ($_POST['teacher'] == "" || $_POST['date'] == "" || $_POST['status'] == "") {
                echo json_encode(['status' => 'error', 'content' => $lang['loi-trong']]);
            }
            if ($_POST['teacher'] && $_POST['date'] && $_POST['status']) {
                $gettime = $database->get("timekeeping_teachers", "*", [
                    "teacher" => $xss->xss($_POST['teacher']),
                    "date" => date("Y-m-d", strtotime($_POST['date'])),
                ]);
                if ($_POST['status'] == 1) {
                    $timekeeping_teachers = [
                        "teacher" => $xss->xss($_POST['teacher']),
                        "date" => $xss->xss(date("Y-m-d", strtotime($_POST['date']))),
                        "checkin" => $xss->xss(date("H:i:s", strtotime($_POST['date']))),
                        "date_poster" => date("Y-m-d H:i:s"),
                        "school"        =>$school_id,
                    ];
                }
                if ($_POST['status'] == 2) {
                    $timekeeping_teachers = [
                        "teacher" => $xss->xss($_POST['teacher']),
                        "date" => $xss->xss(date("Y-m-d", strtotime($_POST['date']))),
                        "checkout" => $xss->xss(date("H:i:s", strtotime($_POST['date']))),
                        "date_poster" => date("Y-m-d H:i:s"),
                        "school"        =>$school_id,
                    ];
                }
                if ($gettime > 1) {
                    $database->update("timekeeping_teachers", $timekeeping_teachers, ["id" => $gettime['id']]);
                    $getID = $gettime['id'];
                } else {
                    $database->insert("timekeeping_teachers", $timekeeping_teachers);
                    $getID = $database->id();
                }
                $insert = [
                    "teacher" => $xss->xss($_POST['teacher']),
                    "notes" => $xss->xss($_POST['notes']),
                    "date" => $xss->xss($_POST['date']),
                    "status" => $xss->xss($_POST['status']),
                    "accounts" => $account['id'],
                    "date_poster" => date("Y-m-d H:i:s"),
                    "school"        =>$school_id,
                ];
                $database->insert("timekeeping_teachers_details", $insert);
                $jatbi->logs('timekeeping_teachers_details', 'add', [$insert, $timeLate]);
                echo json_encode(['status' => 'success', 'content' => $lang['cap-nhat-thanh-cong'], "url" => $_SERVER['HTTP_REFERER']]);
            }
        } else {
            $templates = $setting['site_backend'] . 'personel.tpl';
        }
    }
    elseif($router['1']=='timekeeping_teachers-views'){
        $ajax = 'true';
        if($router['2']){
            $teachers=$database->get("teacher","*",['id'=>$router['2']]);
            if($teachers>1){
                $datas = $database->select("timekeeping_teachers_details", "*",[
                    "teacher"=>$router['2'],
                    "date[<>]"=>[date("Y-m-d 00:00:00",strtotime($router['3'])),date("Y-m-d 23:59:59",strtotime($router['3']))],
                    "school"        =>$school_id,
                    "deleted"=>0,
                ]);
                $templates = $setting['site_backend'].'personel.tpl';
            }
            else {
                header("HTTP/1.0 404 Not Found");
                die();
            }
        }
    }
    elseif($router['1']=='timekeeping_teachers-delete'){
        $jatbi->permission('timekeeping_teachers.delete');
        $ajax = 'true';
        if($router['2']){
            $datas = $database->select("timekeeping_teachers","*",["id"=>explode(',', $xss->xss($router['2']))]);
            $jatbi->logs('timekeeping_teachers','delete',$datas);
            $database->update("timekeeping_teachers",["deleted" => 1,],["id"=>explode(',', $xss->xss($router['2']))]);
            echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
        }
    }
    elseif($router['1']=='timekeeping_personels'){
        $jatbi->permission('timekeeping_personels');
        $year = $xss->xss($_GET['year']) == '' ? date("Y") : $xss->xss($_GET['year']);
        $month = $xss->xss($_GET['month']) == '' ? date("m") : $xss->xss($_GET['month']);
        $date_form = date("t", strtotime($year . "-" . $month . "-01"));
        for ($day = 1; $day <= $date_form; $day++) {
            if ($day < 10) {
                $day = '0' . $day;
            }
            $date = date("Y-m-d", strtotime($year . "-" . $month . "-" . $day));
            $week = date("N", strtotime($date));
            $dates[] = [
                "name" => $day,
                "date" => $date,
                "week" => $week,
            ];
        }
        $personel = ["Bảo vệ","Tạp vụ"];
        foreach ($personel as $key => $personels) {
            $SelectPer[$personels['id']] = $database->select("personels", "*", [
                // 'id[<>]' => ($xss->xss($_GET['teachers']) == '') ?: [$xss->xss($_GET['teachers']), $xss->xss($_GET['teachers'])],
                "type"  =>$personels,
                "school"        =>$school_id,
                "deleted" => 0,
                "status" => 'A',
            ]);
            $datas[$key] = [
                "name" => $personels,
            ];
            foreach ($SelectPer[$personels['id']] as $per) {
                $datas[$key]["personels"][$per['id']] = [
                    "id"=>$per['id'],
                    "name" => $per['name'],
                  
                ];
                foreach ($dates as $date) {
                    if (strtotime($date['date']) >= strtotime($datas[$key]["personels"][$per['id']]['contract'])) {
                        $datas[$key]["personels"][$per['id']]["roster"] = $database->get("rosters", "timework", [
                            "date[<=]" => $date['date'],
                            "deleted" => 0,
                            "ORDER" => ["id" => "DESC"]
                        ]);
                        $checked[$per['id']] = $database->get("timekeeping_personels", ["checkin", "checkout"], [
                            "personels" => $per['id'],
                            "date" => date("Y-m-d", strtotime($date['date'])),
                            "school"        =>$school_id,
                        ]);
                        $timework_details[$per['id']] = $database->get("timework_details", "*", [
                            "week" => $date['week'],
                            "timework" => $datas[$key]["personels"][$per['id']]['roster'],
                        ]);
                        $furloughs[$per['id']] = $database->get("furlough", "id", [
                            "personels" => $per['id'],
                            "date_start[<=]" => $date['date'],
                            "date_end[>=]" => $date['date'],
                            "deleted" => 0,
                            "statu" => "D",
                            "status" => "A",
                            "school"        =>$school_id,
                        ]);
                        if ($timework_details[$per['id']]['off'] == 1) {
                            $off[$per['id']] = 1;
                            $offcontent[$per['id']] = 'OFF';
                            $color[$per['id']] = 'bg-primary bg-opacity-10';
                        } else {
                            $off[$per['id']] = 0;
                            if ($checked[$per['id']]['checkin'] != '' && $checked[$per['id']]['checkout'] == '') {
                                $color[$per['id']] = 'bg-danger bg-opacity-10';
                            } elseif ($checked[$per['id']]['checkin'] == '' && $checked[$per['id']]['checkout'] == '') {
                                if (strtotime($date['date'] . ' ' . $setting['timework_to']) <= strtotime(date("Y-m-d H:i:s"))) {
                                    $color[$per['id']] = 'bg-warning bg-opacity-10';
                                } else {
                                    $color[$per['id']] = 'bg-light bg-opacity-10';
                                }
                            } else {
                                $color[$per['id']] = 'bg-success bg-opacity-10';
                            }
                        }
                        if ($furloughs[$per['id']] > 0) {
                            $off[$per['id']] = 1;
                            $offcontent[$per['id']] = $database->get("furlough_categorys", "code", ["deleted"=>0,"id" => $furloughs[$per['id']]]);
                            $color[$per['id']] = 'bg-primary bg-opacity-25';
                            if ($furloughs[$per['id']]['numberday'] == 4) {
                                $furlough[$per['id']][$furloughs[$per['id']]['furlough']] = [
                                    "id" => $furloughs[$per['id']],
                                    "content" => $offcontent[$per['id']],
                                ];
                            }
                            if ($furloughs[$per['id']]['numberday'] == 5) {
                                $furlough[$per['id']][$furloughs[$per['id']]['furlough']] = [
                                    "id" => $furloughs[$per['id']],
                                    "content" => $offcontent[$per['id']],
                                ];
                            }
                        }
                        $datas[$key]["personels"][$per['id']]["dates"][$date['date']] = [
                            "id"=>$per['id'],
                        
                            "name" => $per['name'], 
                            "date" => $date['date'],
                            "week" => $date['week'],
                            "color" => $color[$per['id']],
                            "checkin" => [
                                "time" => $checked[$per['id']]['checkin'],
                            ],
                            "checkout" => [
                                "time" => $checked[$per['id']]['checkout'],
                            ],
                            "off" => [
                                "status" => $off[$per['id']],
                                "content" => $offcontent[$per['id']],
                            ],
                        ];
                    } else {
                        $datas[$key]["personels"][$per['id']]["dates"][$date['date']] = [
                            "name" => $per['name'], 
                            "date" => $date['date'],
                            "week" => $date['week'],
                            "status" => '',
                            "color" => "bg-secondary bg-opacity-25",
                        ];
                    }
                }
            }
        }
        $templates = $setting['site_backend'] . 'personel.tpl';
    }
    elseif($router['1']=='timekeeping_personels-add'){

        $jatbi->permission('timekeeping_personels.add');
        $ajax = 'true';
        
        if (isset($_POST['token'])) {

            if ($_POST['personels'] == "" || $_POST['date'] == "" || $_POST['status'] == "") {
                echo json_encode(['status' => 'error', 'content' => $lang['loi-trong']]);
            }
            if ($_POST['personels'] && $_POST['date'] && $_POST['status']) {
                $gettime = $database->get("timekeeping_personels", "*", [
                    "personels" => $xss->xss($_POST['personels']),
                    "date" => date("Y-m-d", strtotime($_POST['date'])),
                ]);
                if ($_POST['status'] == 1) {
                    $timekeeping_personels = [
                        "personels" => $xss->xss($_POST['personels']),
                        "date" => $xss->xss(date("Y-m-d", strtotime($_POST['date']))),
                        "checkin" => $xss->xss(date("H:i:s", strtotime($_POST['date']))),
                        "date_poster" => date("Y-m-d H:i:s"),
                        "school"        =>$school_id,
                    ];
                }
                if ($_POST['status'] == 2) {
                    $timekeeping_personels = [
                        "personels" => $xss->xss($_POST['personels']),
                        "date" => $xss->xss(date("Y-m-d", strtotime($_POST['date']))),
                        "checkout" => $xss->xss(date("H:i:s", strtotime($_POST['date']))),
                        "date_poster" => date("Y-m-d H:i:s"),
                        "school"        =>$school_id,
                    ];
                }
                if ($gettime > 1) {
                    $database->update("timekeeping_personels", $timekeeping_personels, ["id" => $gettime['id']]);
                    $getID = $gettime['id'];
                } else {
                    $database->insert("timekeeping_personels", $timekeeping_personels);
                    $getID = $database->id();
                }
                $insert = [
                    "personels" => $xss->xss($_POST['personels']),
                    "notes" => $xss->xss($_POST['notes']),
                    "date" => $xss->xss($_POST['date']),
                    "status" => $xss->xss($_POST['status']),
                    "accounts" => $account['id'],
                    "date_poster" => date("Y-m-d H:i:s"),
                    "school"        =>$school_id,
                ];
                $database->insert("timekeeping_personels_details", $insert);
                $jatbi->logs('timekeeping_personels_details', 'add', [$insert, $timeLate]);
                echo json_encode(['status' => 'success', 'content' => $lang['cap-nhat-thanh-cong'], "url" => $_SERVER['HTTP_REFERER']]);
            }
        } else {
            $templates = $setting['site_backend'] . 'personel.tpl';
        }
    }
    elseif($router['1']=='timekeeping_personels-views'){
        $ajax = 'true';
        if($router['2']){
            $personels=$database->get("personels","*",['id'=>$router['2']]);
            if($personels>1){
                $datas = $database->select("timekeeping_personels_details", "*",[
                    "personels"=>$router['2'],
                    "date[<>]"=>[date("Y-m-d 00:00:00",strtotime($router['3'])),date("Y-m-d 23:59:59",strtotime($router['3']))],
                    "school"        =>$school_id,
                    "deleted"=>0,
                ]);
                $templates = $setting['site_backend'].'personel.tpl';
            }
            else {
                header("HTTP/1.0 404 Not Found");
                die();
            }
        }
    }
    elseif($router['1']=='timekeeping_personels-delete'){
        $jatbi->permission('timekeeping_personels.delete');
        $ajax = 'true';
        if($router['2']){
            $datas = $database->select("timekeeping_personels","*",["id"=>explode(',', $xss->xss($router['2']))]);
            $jatbi->logs('timekeeping_personels','delete',$datas);
            $database->update("timekeeping_personels",["deleted" => 1,],["id"=>explode(',', $xss->xss($router['2']))]);
            echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
        }
    }
    if($router['1']=='regent'){
        $jatbi->permission('regent');
        $count = $database->count("regent",[
            'AND' => [
                'name[~]'  		=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']), 
                "deleted"       => 0,
            ]]
        );
        $pg = $_GET['pg'];
        if (!$pg) $pg = 1;
        $datas = $database->select("regent", "*",[
            "AND" => [
                "OR"=>[
                    //'id[~]'       => ($xss->xss($_GET['id'])=='')?'%':$xss->xss($_GET['id']),
                    'name[~]'    => ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),                  
                ],
                'status'        => ($xss->xss($_GET['status'])=='')?[A,D]:$xss->xss($_GET['status']), 
                "deleted"       => 0,
                "school"    =>$school_id,
            ],
            "LIMIT" =>[(($pg-1)*$setting['site_page']),$setting['site_page']],
            "ORDER" => [
                "id"=>"DESC",
            ]
        ]);
        $page = $jatbi->pages($count,$setting['site_page'],$pg);
        $templates = $setting['site_backend'].'personel.tpl';
    }
    elseif($router['1']=='regent-add'){
        $jatbi->permission('regent.add');
        $ajax = 'true';
        if(isset($_POST['token'])){
            $handle = new Upload($_FILES['avatar']);
            if($_POST['token']!=$_SESSION['csrf']['token']){
                echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
            }
            elseif($_POST['name'] == "" ){
                echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
            }
            if ($handle->processed  && $_POST['name']) {
                $insert = [                  
                    "name"          => $xss->xss($_POST['name']),                                  
                    "status"        => $xss->xss($_POST['status']),
                    "school"        =>$school_id,
                ];
                $database->insert("regent",$insert);
                $jatbi->logs('regent','add',$insert);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            }
        } 
        else {
            $templates = $setting['site_backend'].'personel.tpl';
        }
    }
    elseif($router['1']=='regent-edit'){
        $jatbi->permission('regent.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("regent", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if(isset($_POST['token'])){
                    $partten = "/^[A-Za-z0-9_\.]{".$setting['site_characters'].",32}$/";
                    
                    $handle = new Upload($_FILES['avatar']);
                    if($_POST['token']!=$_SESSION['csrf']['token']){
                        echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
                    }
                    elseif($_POST['name'] == "" ){
                        echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
                    }
                    if ($handle->processed  && $_POST['name']) {
                        $insert = [                  
                            "name"         => $xss->xss($_POST['name']),                                  
                            "status"        => $xss->xss($_POST['status']),
                            "school"        =>$school_id,
                        ];
                        $database->update("regent",$insert,["id"=>$data['id']]);
                        $jatbi->logs('regent','edit',$insert);
                        echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
                    }
                } else {
                    $templates = $setting['site_backend'].'personel.tpl';
                }
            }
            else {
                header("HTTP/1.0 404 Not Found");
                die();
            }
        }
    }
    elseif($router['1']=='regent-delete'){
        $jatbi->permission('regent.delete');
        $ajax = 'true';
        if($router['2']){
            $datas = $database->select("regent","*",["id"=>explode(',', $xss->xss($router['2']))]);
            if(isset($_POST['submit'])){
                $jatbi->logs('regent','delete',$datas);
                $database->update("regent",["deleted" => 1,],["id"=>explode(',', $xss->xss($router['2']))]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            } else {
                $templates = $setting['site_backend'].'personel.tpl';
            }
        }
        else {
            header("HTTP/1.0 404 Not Found");
            die();
        }
    }
    elseif($router['1']=='regent-status'){
        $jatbi->permission('regent.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("regent", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if($data['status']==='A'){
                    $status = "D";
                } 
                elseif($data['status']==='D'){
                    $status = "A";
                }
                $database->update("regent",["status"=>$status],["id"=>$data['id']]);
                $jatbi->logs('regent','status',["data"=>$data,"status"=>$status]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-trang-thai'],'sound'=>$setting['site_sound']]);
            }
            else {
                echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-that-bai'],]);
            }
        }
    }
?>