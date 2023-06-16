<?php
    if(!defined('JATBI')) die("Hacking attempt");
    $school_id=$_SESSION['school'];
    $school = $database->get("school", "*",["id"=>$school_id,"deleted"=> 0,"status"=>'A']);
    $car = $database->select("car", "*",["school"=>$school_id,"deleted"=> 0,"status"=>'A']);
    $driver = $database->select("driver", "*",["school"=>$school_id,"deleted"=> 0,"status"=>'A']);
    $route = $database->select("route", "*",["school"=>$school_id,"deleted"=> 0,"status"=>'A']);
    $permissions = $database->select("permission", "*",["school"        =>$school_id,"deleted"=> 0,"status"=>'A']);
    if($router['1']=='car'){
        $jatbi->permission('car');
        $count = $database->count("car",[
            'AND' => [
                "deleted"       => 0,
            ]]
        );
        $pg = $_GET['pg'];
        if (!$pg) $pg = 1;
        $datas = $database->select("car", "*",[
            "AND" => [
                "OR"=>[
                    'name[~]'       => ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
                    'license_plates[~]'       => ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
                ],
                'subject[<>]'=> ($xss->xss($_GET['subject'])=='')?:[$xss->xss($_GET['subject']),$xss->xss($_GET['subject'])], 
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
        $templates = $setting['site_backend'].'car_driver.tpl';
    }
    elseif($router['1']=='car-add'){
        $jatbi->permission('car.add');
        $ajax = 'true';
        if(isset($_POST['token'])){
            $handle = new Upload($_FILES['avatar']);
            if($_POST['token']!=$_SESSION['csrf']['token']){
                echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
            }
            elseif($_POST['name'] == "" || $_POST['frame_number'] == "" || $_POST['typecar'] == "" || $_POST['license_plates'] == ""){
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
            
            if ($handle->processed && $_POST['name'] &&  $_POST['frame_number']  && $_POST['typecar'] && $_POST['license_plates']){
                $insert = [
                    "name"              => $xss->xss($_POST['name']),
                    "frame_number"      => $xss->xss($_POST['frame_number']),
                    "typecar"           => $xss->xss($_POST['typecar']),
                    "manufacturer"      => $xss->xss($_POST['manufacturer']),
                    "specifications"    => $xss->xss($_POST['specifications']),
                    "license_plates"   => $xss->xss($_POST['license_plates']),
                    "avatar"            => $handle->file_dst_name==''?$rand_avatar:$handle->file_dst_name,                                           
                    "status"            => $xss->xss($_POST['status']),
                    "school"=>$school_id,
                ];
                $database->insert("car",$insert);
                $jatbi->logs('car','add',$insert);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            }
        }
        else {
            $templates = $setting['site_backend'].'car_driver.tpl';
        }
    }
    elseif($router['1']=='car-edit'){
        $jatbi->permission('car.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("car", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if(isset($_POST['token'])){
                    $partten = "/^[A-Za-z0-9_\.]{".$setting['site_characters'].",32}$/";
                    
                    $handle = new Upload($_FILES['avatar']);
                    if($_POST['token']!=$_SESSION['csrf']['token']){
                        echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
                    }
                    elseif($_POST['name'] == "" || $_POST['frame_number'] == "" || $_POST['typecar'] == "" || $_POST['license_plates'] == ""){
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
                    if ($handle->processed && $_POST['name'] &&  $_POST['frame_number']  && $_POST['typecar'] && $_POST['license_plates']){
                        $insert = [
                            "name"              => $xss->xss($_POST['name']),
                            "frame_number"      => $xss->xss($_POST['frame_number']),
                            "typecar"           => $xss->xss($_POST['typecar']),
                            "manufacturer"      => $xss->xss($_POST['manufacturer']),
                            "specifications"    => $xss->xss($_POST['specifications']),
                            "license_plates"   => $xss->xss($_POST['license_plates']),
                            "avatar"        => $handle->file_dst_name==''?$rand_avatar:$handle->file_dst_name,                                                       
                            "status"        => $xss->xss($_POST['status']),
                            "school"=>$school_id,
                        ];
                        $database->update("car",$insert,["id"=>$data['id']]);
                        $jatbi->logs('car','edit',$insert);
                        echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
                    }
                } else {
                    $templates = $setting['site_backend'].'car_driver.tpl';
                }
            }
            else {
                header("HTTP/1.0 404 Not Found");
                die();
            }
        }
    }
    // elseif($router['1']=='car-add'){
    //     $jatbi->permission('car.add');
    //     $ajax = 'true';
    //     if(isset($_POST['token'])){
    //         $handle = new Upload($_FILES['avatar']);
    //         if($_POST['token']!=$_SESSION['csrf']['token']){
    //             echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
    //         }
    //         elseif($_POST['name'] == "" || $_POST['frame_number'] == "" || $_POST['typecar'] == "" || $_POST['license_plates'] == ""){
    //             echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
    //         }
           
    //         if ($handle->uploaded) {
    //             $handle->allowed        = array('application/msword', 'image/*');
    //             $handle->Process($upload['images']['avatar']['url']);
    //             $handle->image_resize   = true;
    //             $handle->image_ratio_crop  = true;
    //             $handle->image_y        = $upload['images']["avatar"]['thumb_y'];
    //             $handle->image_x        = $upload['images']["avatar"]['thumb_x'];
    //             $handle->allowed        = array('application/msword', 'image/*');
    //             $handle->Process($upload['images']['avatar']['url'].'thumb/');
    //         }
    //         if ($handle->processed && $_POST['name'] &&  $_POST['frame_number']  && $_POST['typecar'] && $_POST['license_plates']){
    //             $insert = [
    //                 "name"              => $xss->xss($_POST['name']),
    //                 "frame_number"      => $xss->xss($_POST['frame_number']),
    //                 "typecar"           => $xss->xss($_POST['typecar']),
    //                 "manufacturer"      => $xss->xss($_POST['manufacturer']),
    //                 "specifications"    => $xss->xss($_POST['specifications']),
    //                 "license_plates	"   => $xss->xss($_POST['license_plates']),
    //                 "avatar"        => $handle->file_dst_name==''?$rand_avatar:$handle->file_dst_name,                                                       
    //                 "status"        => $xss->xss($_POST['status']),
    //             ];
    //             $database->insert("car",$insert);
    //             $jatbi->logs('car','add',$insert);
    //             echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
    //         }
    //     } 
    //     else {
    //         $templates = $setting['site_backend'].'car_driver.tpl';
    //     }
    // }
    // elseif($router['1']=='car-edit'){
    //     $jatbi->permission('car.edit');
    //     $ajax = 'true';
    //     if($router['2']){
    //         $data = $database->get("car", "*",["id"=>$xss->xss($router['2'])]);
    //         if($data>1){
    //             if(isset($_POST['token'])){
    //                 $partten = "/^[A-Za-z0-9_\.]{".$setting['site_characters'].",32}$/";
    //                 if($_POST['gender']==1){
    //                     $avatar = ["avatar.png", "avatar1.png", "avatar3.png", "avatar4.png"];
    //                     $rand_avatar = $avatar[array_rand($avatar)];
    //                 } 
    //                 elseif($_POST['gender']==2){
    //                     $avatar = ["avatar2.png", "avatar5.png", "avatar6.png"];
    //                     $rand_avatar = $avatar[array_rand($avatar)];
    //                 }
    //                 else{
    //                     $avatar = ["avatar.png", "avatar1.png", "avatar2.png", "avatar3.png", "avatar4.png","avatar5.png","avatar6.png"];
    //                     $rand_avatar = $avatar[array_rand($avatar)];
    //                 }
                    
    //                 $handle = new Upload($_FILES['avatar']);
    //                 if($_POST['token']!=$_SESSION['csrf']['token']){
    //                     echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
    //                 }
    //                 elseif($_POST['name'] == "" || $_POST['frame_number'] == "" || $_POST['typecar'] == "" || $_POST['license_plates'] == ""){
    //                     echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
    //                 }
                   
    //                 if ($handle->uploaded) {
    //                     $handle->allowed        = array('application/msword', 'image/*');
    //                     $handle->Process($upload['images']['avatar']['url']);
    //                     $handle->image_resize   = true;
    //                     $handle->image_ratio_crop  = true;
    //                     $handle->image_y        = $upload['images']["avatar"]['thumb_y'];
    //                     $handle->image_x        = $upload['images']["avatar"]['thumb_x'];
    //                     $handle->allowed        = array('application/msword', 'image/*');
    //                     $handle->Process($upload['images']['avatar']['url'].'thumb/');
    //                 }
    //                 if ($handle->processed && $_POST['name'] &&  $_POST['frame_number']  && $_POST['typecar'] && $_POST['license_plates']) {
    //                     $insert = [
    //                         "name"          => $xss->xss($_POST['name']),
    //                         "frame_number"          => $xss->xss($_POST['frame_number']),
    //                         "typecar"         => $xss->xss($_POST['typecar']),
    //                         "manufacturer"         => $xss->xss($_POST['manufacturer']),
    //                         "specifications"         => $xss->xss($_POST['specifications']),
    //                         "license_plates	"         => $xss->xss($_POST['license_plates']),
    //                         "avatar"        => $handle->file_dst_name==''?$rand_avatar:$handle->file_dst_name,                                                       
    //                         "status"        => $xss->xss($_POST['status']),
                           
    //                     ];
    //                     $database->update("car",$insert,["id"=>$data['id']]);
    //                     $jatbi->logs('car','edit',$insert);
    //                     echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
    //                 }
    //             } else {
    //                 $templates = $setting['site_backend'].'car_driver.tpl';
    //             }
    //         }
    //         else {
    //             header("HTTP/1.0 404 Not Found");
    //             die();
    //         }
    //     }
    // }
    elseif($router['1']=='car-delete'){
        $jatbi->permission('car.delete');
        $ajax = 'true';
        if($router['2']){
            $datas = $database->select("car","*",["id"=>explode(',', $xss->xss($router['2']))]);
            if(isset($_POST['submit'])){
                $jatbi->logs('car','delete',$datas);
                $database->update("car",["deleted" => 1,],["id"=>explode(',', $xss->xss($router['2']))]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            } else {
                $templates = $setting['site_backend'].'car_driver.tpl';
            }
        }
        else {
            header("HTTP/1.0 404 Not Found");
            die();
        }
    }
    elseif($router['1']=='car-status'){
        $jatbi->permission('car.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("car", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if($data['status']==='A'){
                    $status = "D";
                } 
                elseif($data['status']==='D'){
                    $status = "A";
                }
                $database->update("car",["status"=>$status],["id"=>$data['id']]);
                $jatbi->logs('car','status',["data"=>$data,"status"=>$status]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-trang-thai'],'sound'=>$setting['site_sound']]);
            }
            else {
                echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-that-bai'],]);
            }
        }
    }
    elseif($router['1']=='driver'){
        $jatbi->permission('driver');
        $count = $database->count("driver",[
            'AND' => [
                "deleted"       => 0,
            ]]
        );
        $pg = $_GET['pg'];
        if (!$pg) $pg = 1;
        $datas = $database->select("driver", "*",[
            "AND" => [
                "OR"=>[
                    'name[~]'       => ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
                    'citizenId[~]'    => ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
                    'driver_license_id	[~]'      => ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
                 
                ],
                 
                'subject[<>]'=> ($xss->xss($_GET['subject'])=='')?:[$xss->xss($_GET['subject']),$xss->xss($_GET['subject'])], 
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
        $templates = $setting['site_backend'].'car_driver.tpl';
    }
    elseif($router['1']=='driver-add'){
        $jatbi->permission('driver.add');
        $ajax = 'true';
        if(isset($_POST['token'])){
            $handle = new Upload($_FILES['avatar']);
            if($_POST['token']!=$_SESSION['csrf']['token']){
                echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
            }
            elseif($_POST['name'] == "" || $_POST['gender'] == "" || $_POST['birthday'] == "" || $_POST['phone_number'] == ""|| $_POST['address'] == ""|| $_POST['address'] == "" || $_POST['province'] == "" || $_POST['district'] == "" || $_POST['ward'] == "" || $_POST['citizenId'] == "" || $_POST['driver_license_id'] == "" || $_POST['date_start_work'] == ""){
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
            if ($handle->processed && $_POST['name'] && $_POST['gender'] && $_POST['birthday'] && $_POST['phone_number'] && $_POST['address'] && $_POST['address'] && $_POST['province'] && $_POST['district'] && $_POST['ward'] && $_POST['citizenId'] && $_POST['driver_license_id'] && $_POST['date_start_work']) {
                $insert = [
                    "date_start_work"          => date('Y-m-d H:i:s'),
                    "name"          => $xss->xss($_POST['name']),
                    "gender"        => $xss->xss($_POST['gender']),  
                    "birthday"      => date('Y-m-d',strtotime(str_replace('/','-',$_POST['birthday']))),      
                    "citizenId"         => $xss->xss($_POST['citizenId']),
                    "address"         => $xss->xss($_POST['address']),
                    "province"         => $xss->xss($_POST['province']),
                    "district"         => $xss->xss($_POST['district']),
                    "ward"         => $xss->xss($_POST['ward']),        
                    "phone_number"          => $xss->xss($_POST['phone_number']),
                    "driver_license_id"         => $xss->xss($_POST['driver_license_id']),                   
                    "avatar"        => $handle->file_dst_name==''?$rand_avatar:$handle->file_dst_name,                                      
                    "status"        => $xss->xss($_POST['status']),
                    "school"=>$school_id,
                   
                ];
                $database->insert("driver",$insert);
                $tuis = $database->id();
                $insertt = [
                    "object"    =>$tuis,
					"main" 			=> 2,
					"name" 			=> $xss->xss($_POST['name']),
					"email" 		=> "",
					"account" 		=> $xss->xss($_POST['phone_number']),
					"phone" 		=> $xss->xss($_POST['phone_number']),
					"password" 		=> password_hash($xss->xss($_POST['password']), PASSWORD_DEFAULT),
					"permission" 	=> $xss->xss($_POST['permission']),
					"data" 			=> 0,
					"type" 			=> 2,
					"active"		=> $jatbi->active(32),
					"avatar"		=> $handle->file_dst_name==''?$rand_avatar:$handle->file_dst_name,
					"birthday"		=> date('Y-m-d',strtotime(str_replace('/','-',$_POST['birthday']))),
					"gender"		=> $xss->xss($_POST['gender']),
					"date" 			=> date('Y-m-d H:i:s'),
					"status" 		=> $xss->xss($_POST['status']),
				];
				$database->insert("accounts",$insertt);
                    $tui = $database->id();
                    $insert_register=[
                        "accounts"=> $tui,
                        "school"=> $school_id,
                        "status"=>'A',
                        "type"=>'1',
                    ];
					$database->insert("account_school",$insert_register);
                    $jatbi->logs('account_school','add',$insert_register);
				$jatbi->logs('accounts','add',$insert);
                $jatbi->logs('driver','add',$insert);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            }
        } 
        else {
            $templates = $setting['site_backend'].'car_driver.tpl';
        }
    }
    elseif($router['1']=='driver-edit'){
        $jatbi->permission('driver.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("driver", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if(isset($_POST['token'])){
                    $partten = "/^[A-Za-z0-9_\.]{".$setting['site_characters'].",32}$/";
                    if($_POST['gender']==1){
                        $avatar = ["avatar.png", "avatar1.png", "avatar3.png", "avatar4.png"];
                        $rand_avatar = $avatar[array_rand($avatar)];
                    } 
                    elseif($_POST['gender']==2){
                        $avatar = ["avatar2.png", "avatar5.png", "avatar6.png"];
                        $rand_avatar = $avatar[array_rand($avatar)];
                    }
                    else{
                        $avatar = ["avatar.png", "avatar1.png", "avatar2.png", "avatar3.png", "avatar4.png","avatar5.png","avatar6.png"];
                        $rand_avatar = $avatar[array_rand($avatar)];
                    }
                    
                    $handle = new Upload($_FILES['avatar']);
                    if($_POST['token']!=$_SESSION['csrf']['token']){
                        echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
                    }
                    elseif($_POST['name'] == "" || $_POST['gender'] == "" || $_POST['birthday'] == "" || $_POST['phone_number'] == ""|| $_POST['address'] == ""|| $_POST['address'] == "" || $_POST['province'] == "" || $_POST['district'] == "" || $_POST['ward'] == "" || $_POST['citizenId'] == "" || $_POST['driver_license_id'] == "" || $_POST['date_start_work'] == ""){
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
                    if ($handle->processed && $_POST['name'] && $_POST['gender'] && $_POST['birthday'] && $_POST['phone_number'] && $_POST['address'] && $_POST['address'] && $_POST['province'] && $_POST['district'] && $_POST['ward'] && $_POST['citizenId'] && $_POST['driver_license_id'] && $_POST['date_start_work']) {
                        $insert = [
                            "date_start_work"          => date('Y-m-d H:i:s'),
                            "name"          => $xss->xss($_POST['name']),
                            "gender"        => $xss->xss($_POST['gender']),  
                            "birthday"      => date('Y-m-d',strtotime(str_replace('/','-',$_POST['birthday']))),      
                            "citizenId"         => $xss->xss($_POST['citizenId']),
                            "address"         => $xss->xss($_POST['address']),
                            "province"         => $xss->xss($_POST['province']),
                            "district"         => $xss->xss($_POST['district']),
                            "ward"         => $xss->xss($_POST['ward']),        
                            "phone_number"          => $xss->xss($_POST['phone_number']),
                            "driver_license_id"         => $xss->xss($_POST['driver_license_id']),                   
                            "avatar"        => $handle->file_dst_name==''?$rand_avatar:$handle->file_dst_name,                                      
                            "status"        => $xss->xss($_POST['status']),
                            "school"=>$school_id,
                           
                        ];
                        $database->update("driver",$insert,["id"=>$data['id']]);
                        $jatbi->logs('driver','edit',$insert);
                        echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
                    }
                } else {
                    $templates = $setting['site_backend'].'car_driver.tpl';
                }
            }
            else {
                header("HTTP/1.0 404 Not Found");
                die();
            }
        }
    }
    elseif($router['1']=='driver-delete'){
        $jatbi->permission('driver.delete');
        $ajax = 'true';
        if($router['2']){
            $datas = $database->select("driver","*",["id"=>explode(',', $xss->xss($router['2']))]);
            if(isset($_POST['submit'])){
                $jatbi->logs('driver','delete',$datas);
                $database->update("driver",["deleted" => 1,],["id"=>explode(',', $xss->xss($router['2']))]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            } else {
                $templates = $setting['site_backend'].'car_driver.tpl';
            }
        }
        else {
            header("HTTP/1.0 404 Not Found");
            die();
        }
    }
    elseif($router['1']=='driver-status'){
        $jatbi->permission('driver.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("driver", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if($data['status']==='A'){
                    $status = "D";
                } 
                elseif($data['status']==='D'){
                    $status = "A";
                }
                $database->update("driver",["status"=>$status],["id"=>$data['id']]);
                $jatbi->logs('driver','status',["data"=>$data,"status"=>$status]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-trang-thai'],'sound'=>$setting['site_sound']]);
            }
            else {
                echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-that-bai'],]);
            }
        }
    }
    elseif($router['1']=='student_register_car'){
        $jatbi->permission('student_register_car');
        $count = $database->count("student_register_car",[
            'AND' => [
                "deleted"       => 0,
            ]]
        );
        $pg = $_GET['pg'];
        if (!$pg) $pg = 1;
        $datas = $database->select("student_register_car", "*",[
            "AND" => [
                'status'        => ($xss->xss($_GET['status'])=='')?[A,D]:$xss->xss($_GET['status']), 
                "deleted"       => 0,
                "school"        =>$school_id,
            ],
            "LIMIT" =>[(($pg-1)*$setting['site_page']),$setting['site_page']],
            "ORDER" => [
                "id"=>"DESC",
            ]
        ]);
        $page = $jatbi->pages($count,$setting['site_page'],$pg);
        $templates = $setting['site_backend'].'car_driver.tpl';
    }
    elseif($router['1']=='student_register_car-edit'){
        $jatbi->permission('student_register_car.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("student_register_car", "*",["id"=>$xss->xss($router['2'])]);
            $semesters = $database->select("semester", "*",[
                "AND" => [
                    "deleted"       => 0,
                    "status"=>"A",
                    "id"=>$data['semester'],
                    "school"=>$school_id,
                ],
            ]);
            $arrange_class = $database->select("arrange_class", "*",[
                "AND" => [
                    "deleted"       => 0,
                    "status"=>"A",
                    "id"=>$data['arrange_class'],
                    "school"=>$school_id,
                ],
            ]);
            $route = $database->select("route", "*",[
                "AND" => [
                    "deleted"       => 0,
                    "status"=>"A",
                    "id"=>$data['route'],
                    "school"=>$school_id,
                ],
            ]);

            if($data>1){
                if(isset($_POST['token'])){
                    $partten = "/^[A-Za-z0-9_\.]{".$setting['site_characters'].",32}$/";
                    
                
                    if($_POST['token']!=$_SESSION['csrf']['token']){
                        echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
                    }
                    elseif($_POST['arrange_class'] == "" ||$_POST['semester']== ""||$_POST['statu']== "" ||$_POST['route']== ""){
                        echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
                    }
                    $counts=1;
                    if($_POST['statu']=='C'){
                        $counts=2;
                    }
                    if ($_POST['arrange_class'] && $_POST['semester'] && $_POST['statu'] && $_POST['route']){
                        $insert = [                  
                            "arrange_class"         => $xss->xss($_POST['arrange_class']),
                            "semester"         => $xss->xss($_POST['semester']),
                            "route"         => $xss->xss($_POST['route']),
                            "statu"        => $xss->xss($_POST['statu']),                
                            "status"        => $xss->xss($_POST['status']),
                            "count"         =>$counts,
                            "school"        =>$school_id,
                        ];
                        $database->update("student_register_car",$insert,["id"=>$data['id']]);
                        $arr=$database->get("arrange_class", "*",["id"=>$xss->xss($_POST['arrange_class']),"deleted"=> 0,"status"=>'A',"school"=>$school_id]);
                        $device= $database->select("device_parent", "device_id",[
                                "parent"=>$database->get("students","parent",["id"=>$arr['students'],"deleted"=> 0,"status"=>'A',"school"=>$school_id]),
                                "school"=>$school_id,
                                "deleted"=> 0,
                                "status"=>'A']);

                        
                        function sendNotification($title, $message,$device) {
                            $content = array(
                                "en" => $message // Nội dung thông báo (có thể thay đổi ngôn ngữ ở đây)
                            );
                        
                            $fields = [
                                'app_id' => 'c0bd1290-a222-4a69-b48f-e1a756d3e1b6', // ID ứng dụng OneSignal của bạn
                                'include_player_ids' =>  $device, // Danh sách các device token
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
                       $student=$database->get("students","fullname",["id"=>$arr['students'],"deleted"=> 0,"status"=>'A',"school"=>$school_id]);
                        $title = $school['name'];
                        if($_POST['statu']=='C'){
                            $message ="Đăng kí xe của ".$student." KHÔNG được duyệt";
                        }elseif($_POST['statu']=='D'){
                            $message ="Đăng kí xe của ".$student." ĐÃ được duyệt";
                        }
                        $result = sendNotification($title, $message, $device);
                        $jatbi->logs('student_register_car','edit',$insert);
                        echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
                    }
                } else {
                    $templates = $setting['site_backend'].'car_driver.tpl';
                }
            }
            else {
                header("HTTP/1.0 404 Not Found");
                die();
            }
        }
    }
    elseif($router['1']=='student_register_car-delete'){
        $jatbi->permission('student_register_car.delete');
        $ajax = 'true';
        if($router['2']){
            $datas = $database->select("student_register_car","*",["id"=>explode(',', $xss->xss($router['2']))]);
            if(isset($_POST['submit'])){
                $jatbi->logs('student_register_car','delete',$datas);
                $database->update("student_register_car",["deleted" => 1,],["id"=>explode(',', $xss->xss($router['2']))]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            } else {
                $templates = $setting['site_backend'].'car_driver.tpl';
            }
        }
        else {
            header("HTTP/1.0 404 Not Found");
            die();
        }
    }
    elseif($router['1']=='student_register_car-status'){
        $jatbi->permission('student_register_car.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("student_register_car", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if($data['status']==='A'){
                    $status = "D";
                } 
                elseif($data['status']==='D'){
                    $status = "A";
                }
                $database->update("student_register_car",["status"=>$status],["id"=>$data['id']]);
                $jatbi->logs('student_register_car','status',["data"=>$data,"status"=>$status]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-trang-thai'],'sound'=>$setting['site_sound']]);
            }
            else {
                echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-that-bai'],]);
            }
        }
    }
    elseif($router['1']=='route'){
        $jatbi->permission('route');
        $count = $database->count("route",[
            'AND' => [
                'name[~]'  		=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']), 
                "deleted"       => 0,
            ]]
        );
        $pg = $_GET['pg'];
        if (!$pg) $pg = 1;
        $datas = $database->select("route", "*",[
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
        $templates = $setting['site_backend'].'car_driver.tpl';
    }
    elseif($router['1']=='route-add'){
        $jatbi->permission('route.add');
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
                $database->insert("route",$insert);
                $jatbi->logs('route','add',$insert);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            }
        } 
        else {
            $templates = $setting['site_backend'].'car_driver.tpl';
        }
    }
    elseif($router['1']=='route-edit'){
        $jatbi->permission('route.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("route", "*",["id"=>$xss->xss($router['2'])]);
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
                        $database->update("route",$insert,["id"=>$data['id']]);
                        $jatbi->logs('route','edit',$insert);
                        echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
                    }
                } else {
                    $templates = $setting['site_backend'].'car_driver.tpl';
                }
            }
            else {
                header("HTTP/1.0 404 Not Found");
                die();
            }
        }
    }
    elseif($router['1']=='route-delete'){
        $jatbi->permission('route.delete');
        $ajax = 'true';
        if($router['2']){
            $datas = $database->select("route","*",["id"=>explode(',', $xss->xss($router['2']))]);
            if(isset($_POST['submit'])){
                $jatbi->logs('route','delete',$datas);
                $database->update("route",["deleted" => 1,],["id"=>explode(',', $xss->xss($router['2']))]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            } else {
                $templates = $setting['site_backend'].'car_driver.tpl';
            }
        }
        else {
            header("HTTP/1.0 404 Not Found");
            die();
        }
    }
    elseif($router['1']=='route-status'){
        $jatbi->permission('route.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("route", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if($data['status']==='A'){
                    $status = "D";
                } 
                elseif($data['status']==='D'){
                    $status = "A";
                }
                $database->update("route",["status"=>$status],["id"=>$data['id']]);
                $jatbi->logs('route','status',["data"=>$data,"status"=>$status]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-trang-thai'],'sound'=>$setting['site_sound']]);
            }
            else {
                echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-that-bai'],]);
            }
        }
    }
    elseif($router['1']=='car_schedule'){
        $jatbi->permission('car_schedule');
        $count = $database->count("car_schedule",[
            'AND' => [
                "status"=>"A",
                "deleted"       => 0,
            ]]
        );
        $pg = $_GET['pg'];
        if (!$pg) $pg = 1;
        $datas = $database->select("car_schedule", "*",[
            "AND" => [
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
        $templates = $setting['site_backend'].'car_driver.tpl';
    }
    elseif($router['1']=='schedule_driver'){
        $jatbi->permission('schedule_driver');
        $count = $database->count("car_schedule",[
            'AND' => [
                "status"=>"A",
                "driver"        =>$account['object'],
                "deleted"       => 0,
            ]]
        );
        $pg = $_GET['pg'];
        if (!$pg) $pg = 1;
        $datas = $database->select("car_schedule", "*",[
            "AND" => [
                'status'        => ($xss->xss($_GET['status'])=='')?[A,D]:$xss->xss($_GET['status']), 
                "deleted"       => 0,
                "driver"        =>$account['object'],
                "school"    =>$school_id,
            ],
            "LIMIT" =>[(($pg-1)*$setting['site_page']),$setting['site_page']],
            "ORDER" => [
                "id"=>"DESC",
            ]
        ]);
        $page = $jatbi->pages($count,$setting['site_page'],$pg);
        $templates = $setting['site_backend'].'car_driver.tpl';
    }
    elseif($router['1']=='car_schedule-add'){
        $jatbi->permission('car_schedule.add');
        $ajax = 'true';
        $count=$database->count("car_schedule",[
            "AND" => [
                "OR"=>[
                    "driver"        => $xss->xss($_POST['driver']),  
                    "car"           => $xss->xss($_POST['car']), 
                ],
                "date"          =>$xss->xss($_POST['date']),
                "type"          => $xss->xss($_POST['type']),   
                "deleted"       => 0,
                "school"        =>$school_id,
            ],
        ]);
        if(isset($_POST['token'])){
            if($_POST['token']!=$_SESSION['csrf']['token']){
                echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
            }
            
            elseif($_POST['car'] == ""||$_POST['driver'] == "" ||$_POST['type'] == "" ||$_POST['route'] == ""||$_POST['date'] == ""){
                echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
            }
            elseif($count>0){
                echo json_encode(['status'=>'error','content'=>$lang['du-lieu-nay-da-co'],'sound'=>$setting['site_sound']]);
            }
            elseif ($_POST['car'] && $_POST['driver'] &&$_POST['type']&& $_POST['route'] && $_POST['date']) {
                $insert = [                  
                    "car"           => $xss->xss($_POST['car']),  
                    "date"          => $xss->xss($_POST['date']), 
                    "datecurrent"   => date("y-m-d h:i:s"),
                    "driver"        => $xss->xss($_POST['driver']),                                   
                    "type"          => $xss->xss($_POST['type']),   
                    "route"         => $xss->xss($_POST['route']),   
                    "status"        => $xss->xss($_POST['status']),
                    "school"        =>$school_id,
                ];
                $database->insert("car_schedule",$insert);
                $tui = $database->id();
                foreach($_POST['student_register_car'] as $item){
                        $up = [
                            "car_schedule" 		    => $tui,
                            "student_register_car"	=> $item['id'],
                            "school"                => $school_id,
                            "status"			    => 'A',
                            ];
                        $database->insert("car_schedule_detail",$up);
                }

                $jatbi->logs('car_schedule','add',$insert);
                $jatbi->logs('car_schedule_detail','add',$up);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            }
        } 
        else {
            $templates = $setting['site_backend'].'car_driver.tpl';
        }
    }
    elseif($router['1']=='car_schedule-edit'){
        $jatbi->permission('car_schedule.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("car_schedule", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if(isset($_POST['token'])){
                    $partten = "/^[A-Za-z0-9_\.]{".$setting['site_characters'].",32}$/";
                    
                    $handle = new Upload($_FILES['avatar']);
                    if($_POST['token']!=$_SESSION['csrf']['token']){
                        echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
                    }
                    elseif($_POST['car'] == ""||$_POST['driver'] == "" ||$_POST['type'] == "" ||$_POST['route'] == ""||$_POST['date'] == ""){
                        echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
                    }
                    if ($_POST['car'] && $_POST['driver'] &&$_POST['type']&& $_POST['route'] && $_POST['date']) {
                        $insert = [                  
                            "car"           => $xss->xss($_POST['car']),  
                            "date"          => $xss->xss($_POST['date']), 
                            "datecurrent"   => date("y-m-d h:i:s"),
                            "driver"        => $xss->xss($_POST['driver']),                                   
                            "type"          => $xss->xss($_POST['type']),   
                            "route"         => $xss->xss($_POST['route']),   
                            "status"        => $xss->xss($_POST['status']),
                            "school"        =>$school_id,
                        ];
                        $database->update("car_schedule",$insert,["id"=>$data['id']]);
                        $jatbi->logs('car_schedule','edit',$insert);
                        echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
                    }
                } else {
                    $templates = $setting['site_backend'].'car_driver.tpl';
                }
            }
            else {
                header("HTTP/1.0 404 Not Found");
                die();
            }
        }
    }
    elseif($router['1']=='car_schedule-delete'){
        $jatbi->permission('car_schedule.delete');
        $ajax = 'true';
        if($router['2']){
            $datas = $database->select("car_schedule","*",["id"=>explode(',', $xss->xss($router['2']))]);
            if(isset($_POST['submit'])){
                $jatbi->logs('car_schedule','delete',$datas);
                $database->update("car_schedule",["deleted" => 1,],["id"=>explode(',', $xss->xss($router['2']))]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            } else {
                $templates = $setting['site_backend'].'car_driver.tpl';
            }
        }
        else {
            header("HTTP/1.0 404 Not Found");
            die();
        }
    }
    elseif($router['1']=='car_schedule-status'){
        $jatbi->permission('car_schedule.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("car_schedule", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if($data['status']==='A'){
                    $status = "D";
                } 
                elseif($data['status']==='D'){
                    $status = "A";
                }
                $database->update("car_schedule",["status"=>$status],["id"=>$data['id']]);
                $jatbi->logs('car_schedule','status',["data"=>$data,"status"=>$status]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-trang-thai'],'sound'=>$setting['site_sound']]);
            }
            else {
                echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-that-bai'],]);
            }
        }
    }
    elseif($router['1']=='car_schedule_detail'){
        $jatbi->permission('car_schedule_detail');
        $_SESSION['router']=$router['2'];
        if($router['2']){
            $count = $database->count("car_schedule_detail",[
                'AND' => [
                    "status"=>"A",
                    "deleted"       => 0,
                    "car_schedule"=>$router['2'],
                ]]
            );
            $pg = $_GET['pg'];
            if (!$pg) $pg = 1;
            $datas = $database->select("car_schedule_detail", "*",[
                "AND" => [
                    "deleted"       => 0,
                    "car_schedule"=>$router['2'],
                    "school"    =>$school_id,
                ],
                "LIMIT" =>[(($pg-1)*$setting['site_page']),$setting['site_page']],
                "ORDER" => [
                    "id"=>"DESC",
                ]
            ]);
            $page = $jatbi->pages($count,$setting['site_page'],$pg);
            $templates = $setting['site_backend'].'car_driver.tpl';
        }
        
    }
    elseif($router['1']=='car_schedule_detail-add'){
        $jatbi->permission('car_schedule_detail.add');
        $ajax = 'true';
        // $car_schedule = $database->get("car_schedule", "*", ["id" => $_SESSION['router'], "school" => $school_id, "deleted" => 0, "status" => 'A']);
        // $car_schedulee = $database->select("car_schedule", "id", ["type" => $car_schedule["type"], "date" => $car_schedule["date"], "route" => $car_schedule["route"], "school" => $school_id, "deleted" => 0, "status" => 'A']);

        // $check = [];
        // foreach ($car_schedulee as $valu) {
        //     $check_student[]= array_merge($check, $database->select("car_schedule_detail", "student_register_car", ["car_schedule" => $valu, "school" => $school_id, "deleted" => 0, "status" => 'A']));
        // }

        // $student_register_car = $database->select("student_register_car", "*", [
        //     "school" => $_SESSION['school'],
        //     "route" => $car_schedule['route'],
        //     "id[!]" => $check,
        //     "status" => 'A',
        //     "deleted" => 0
        // ]);

        $car_schedule = $database->get("car_schedule", "*", ["id" => $_SESSION['router'], "school" => $_SESSION['school'], "deleted" => 0, "status" => 'A']);
        $car_schedulee = $database->select("car_schedule", "id", ["type" => $car_schedule["type"], "date" => $car_schedule["date"], "route" => $car_schedule["route"], "school" => $_SESSION['school'], "deleted" => 0, "status" => 'A']);
        
        // $check = [];
        // foreach ($car_schedulee as $valu) {
        //     $check = $database->select("car_schedule_detail","*",["car_schedule" => $valu, "school" => $_SESSION['school'], "deleted" => 0, "status" => 'A']);
        // }
        $check = $database->select("car_schedule_detail","*",["car_schedule[]" => $car_schedulee, "school" => $_SESSION['school'], "deleted" => 0, "status" => 'A']);
        foreach($check as $checks){
            $check_student[]=$checks['student_register_car'];
        }
        $student_register_car = $database->select("student_register_car", "*", [
            "school" => $_SESSION['school'],
            "route" => $car_schedule['route'],
            "id[!]" =>  $check_student,
            "status" => 'A',
            "statu" => 'D',
            "deleted" => 0
        ]);
        
            
                 
            if(isset($_POST['token'])){
                if($_POST['token']!=$_SESSION['csrf']['token']){
                    echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
                }
                elseif($_POST['student_register_car'] == ""){
                    echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
                }
                if ($_POST['student_register_car']) {
                    foreach($_POST['student_register_car'] as $datass){
                        $insert = [                  
                            "car_schedule" 		    => $_SESSION['router'],
                            "student_register_car"	=> $datass['id'],   
                            "school"                => $school_id,
                            "status"        => $xss->xss($_POST['status']),
                        ];
                        $database->insert("car_schedule_detail",$insert);
                    }
                    
                    $jatbi->logs('car_schedule_detail','add',$insert);
                    echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
                }
            } 
            else {
                $templates = $setting['site_backend'].'car_driver.tpl';
            }
        
        
    }
    elseif($router['1']=='car_schedule_detail-edit'){
        $jatbi->permission('car_schedule_detail.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("car_schedule_detail", "*",["id"=>$xss->xss($router['2'])]);
          
            $student_register_car = $database->select("student_register_car","*",["school"=>$_SESSION['school'],"status"=>'A',"deleted"=>0]);
            if(isset($_POST['token'])){
                if($_POST['token']!=$_SESSION['csrf']['token']){
                    echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
                }
                elseif($_POST['student_register_car'] == ""){
                    echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
                }
                if ($_POST['student_register_car']) {
                    foreach($_POST['student_register_car'] as $datass){
                        $insert = [                  
                            "car_schedule" 		    => $_SESSION['router'],
                            "student_register_car"	=> $datass['id'],   
                            "school"                => $school_id,
                            "status"        => $xss->xss($_POST['status']),
                        ];
                        $database->update("car_schedule_detail",$insert,["id"=>$data['id']]);   
                    }
                   
                    $jatbi->logs('car_schedule_detail','add',$insert);
                    echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
                }
            } 
            else {
                $templates = $setting['site_backend'].'car_driver.tpl';
            }
        }
        
    }
    elseif($router['1']=='car_schedule_detail-delete'){
        $jatbi->permission('car_schedule_detail.delete');
        $ajax = 'true';
        if($router['2']){
            $datas = $database->select("car_schedule_detail","*",["id"=>explode(',', $xss->xss($router['2']))]);
            if(isset($_POST['submit'])){
                $jatbi->logs('car_schedule_detail','delete',$datas);
                $database->update("car_schedule_detail",["deleted" => 1,],["id"=>explode(',', $xss->xss($router['2']))]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            } else {
                $templates = $setting['site_backend'].'car_driver.tpl';
            }
        }
        else {
            header("HTTP/1.0 404 Not Found");
            die();
        }
    }
    elseif($router['1']=='car_schedule_detail-status'){
        $jatbi->permission('car_schedule_detail');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("car_schedule_detail", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if($data['status']==='A'){
                    $status = "D";
                } 
                elseif($data['status']==='D'){
                    $status = "A";
                }
                $database->update("car_schedule_detail",["status"=>$status],["id"=>$data['id']]);
                $jatbi->logs('car_schedule_detail','status',["data"=>$data,"status"=>$status]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-trang-thai'],'sound'=>$setting['site_sound']]);
            }
            else {
                echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-that-bai'],]);
            }
        }
    }
?>