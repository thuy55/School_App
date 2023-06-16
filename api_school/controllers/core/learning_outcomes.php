<?php
    if (!defined('JATBI')) die("Hacking attempt");
    $school_id=$_SESSION['school'];
    $school = $database->get("school", "*",["id"        =>$school_id,"deleted"=> 0,"status"=>'A']);
    $accounts = $database->select("accounts", "*",["school"        =>$school_id,"deleted"=> 0,"status"=>'A']);
    $teacher = $database->select("teacher", "*",["deleted"=> 0,"status"=>'A']);
    $date = date("Y-m-d");
            
    $courses = $database->select("course", "*", [
        "school" => $school_id,
        "status" => 'A',
        "deleted" => 0
    ]);

    foreach ($courses as $value) {
        $date_timestamp = strtotime($date);
        $start_timestamp = strtotime($value['startdate']);
        $end_timestamp = strtotime($value['enddate']);

        if ($date_timestamp >= $start_timestamp && $date_timestamp <= $end_timestamp) {
            $class = $database->select("class_diagram", "*", [
                "AND" => [
                    "deleted" => 0,
                    'course' => $value['id'],
                    "school" => $school_id
                ],
                "ORDER" => [
                    "id" => "DESC"
                ]
            ]);
        }
    }
    $typescore = $database->select("typescore", "*",["deleted"=> 0,"status"=>'A']);
    $semester = $database->select("semester", "*",["deleted"=> 0,"status"=>'A']);
   
    $subject = $database->select("subject", "*",["school"        =>$school_id,"deleted"=> 0,"status"=>'A']);
    $students = $database->select("students", "*",["school"        =>$school_id,"deleted"=> 0,"status"=>'A']);
    $course = $database->select("course", "*",["school"        =>$school_id,"deleted"=> 0,"status"=>'A']);
    $parent = $database->select("parent", "*",["deleted"=> 0,"status"=>'A']);
    $opinion = $database->select("opinion", "*",["school"        =>$school_id,"deleted"=> 0]);
    
    if($router['1']=='school_activities'){
        $jatbi->permission('school_activities');
        $count = $database->count("news",[
            'AND' => [
                "deleted"       => 0,
            ]]
        );
        $pg = $_GET['pg'];
        if (!$pg) $pg = 1;
        $datas = $database->select("news", "*",[
            "AND" => [
                "OR"=>[
                    
                    'name[~]'    => ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']), 
                  
                ],
                'accounts[<>]'=> ($xss->xss($_GET['accounts'])=='')?:[$xss->xss($_GET['accounts']),$xss->xss($_GET['accounts'])],
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
        $templates = $setting['site_backend'].'learning_outcomes.tpl';
    }
    elseif($router['1']=='school_activities-add'){
		$jatbi->permission('school_activities.add');
        $ajax = 'true';
		if(isset($_POST['status']) ){
            $handle = new Upload($_FILES['avatar']);

            if($_POST['name'] == "" || $_POST['description'] == ""|| $_POST['content'] == ""){
                echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
            }
            if($handle->uploaded){
		        $handle->allowed 		= array('application/msword', 'image/*');
		        $handle->Process($upload['images']['avatar']['url']);
		    }
			if ($_POST['name']  && $_POST['description'] && $_POST['content'] ) {
                $img = $setting['site_url'].$upload['images']['avatar']['url'].$handle->file_dst_name;
				$insert = [                  
                    "name"         => $xss->xss($_POST['name']),
                    "date"         => date('Y-m-d H:i:s'),
                    "description"         => $xss->xss($_POST['description']),
                    "content"         => $_POST['content'],
                    "accounts"         => $account['id'],                                  
                    "status"        => $xss->xss($_POST['status']),
                    "school"        =>$school_id,
                    "avatar"        => $img,            
                ];
                $database->insert("news",$insert);
                $device1 = $database->select("device_parent", "device_id",["school"=>$school_id,"deleted"=> 0,"status"=>'A']);
                $device2 = $database->select("device_teacher", "device_id",["school"=>$school_id,"deleted"=> 0,"status"=>'A']);
                $device = array_merge($device1, $device2);
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
                $title =  $school['name'];
                $message = $_POST['description'];
                $result = sendNotification($title, $message, $device);
               

                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
			}
		} else {
			$templates = $setting['site_backend'].'learning_outcomes.tpl';
		}
	}
    elseif($router['1']=='school_activities-edit'){
        $jatbi->permission('school_activities.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("news", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if(isset($_POST['token'])){
                    $partten = "/^[A-Za-z0-9_\.]{".$setting['site_characters'].",32}$/";
                    
                    $handle = new Upload($_FILES['avatar']);

                    if($_POST['name'] == "" ||$_POST['description'] == ""||$_POST['content'] == ""){
                        echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
                    }
                    if($handle->uploaded){
                        $handle->allowed 		= array('application/msword', 'image/*');
                        $handle->Process($upload['images']['avatar']['url']);
                    }
                    if ($_POST['name']  && $_POST['description'] && $_POST['content'] ) {
                        $img = $setting['site_url'].$upload['images']['avatar']['url'].$handle->file_dst_name;
                        $insert = [                  
                            "name"         => $xss->xss($_POST['name']),
                            "date"         => date('Y-m-d H:i:s'),
                            "description"         => $xss->xss($_POST['description']),
                            "content"         => $_POST['content'],
                            "accounts"         => $account['id'],                                  
                            "status"        => $xss->xss($_POST['status']),
                            "school"        =>$school_id,
                            "avatar"        => $img,            
                        ];
                        $database->update("news",$insert,["id"=>$data['id']]);
                        $device1= $database->select("device_parent","device_id",["school"=>$school_id,"deleted"=> 0,"status"=>'A']);
                        $device2 = $database->select("device_teacher","device_id",["school"=>$school_id,"deleted"=> 0,"status"=>'A']);
                        $device = array_merge($device1,$device2);

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
                        $message = $_POST['description'];
                        $result = sendNotification($title,$message,$device);
           
                        
                       
                        $jatbi->logs('news','edit',$insert);
                        echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
                    }
                } else {
                    $templates = $setting['site_backend'].'learning_outcomes.tpl';
                }
            }
            else {
                header("HTTP/1.0 404 Not Found");
                die();
            }
        }
    }
    elseif($router['1']=='school_activities-delete'){
        $jatbi->permission('school_activities.delete');
        $ajax = 'true';
        if($router['2']){
            $datas = $database->select("news","*",["id"=>explode(',', $xss->xss($router['2']))]);
            if(isset($_POST['submit'])){
                $jatbi->logs('news','delete',$datas);
                $database->update("news",["deleted" => 1,],["id"=>explode(',', $xss->xss($router['2']))]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            } else {
                $templates = $setting['site_backend'].'learning_outcomes.tpl';
            }
        }
        else {
            header("HTTP/1.0 404 Not Found");
            die();
        }
    }
    elseif($router['1']=='school_activities-status'){
        $jatbi->permission('school_activities.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("news", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if($data['status']==='A'){
                    $status = "D";
                } 
                elseif($data['status']==='D'){
                    $status = "A";
                }
                $database->update("newss",["status"=>$status],["id"=>$data['id']]);
                $jatbi->logs('news','status',["data"=>$data,"status"=>$status]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-trang-thai'],'sound'=>$setting['site_sound']]);
            }
            else {
                echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-that-bai'],]);
            }
        }
    }
    elseif($router['1']=='teacher_announcement'){
        $jatbi->permission('teacher_announcement');
        $count = $database->count("teacher_announcement",[
            'AND' => [
                "deleted"       => 0,
            ]]
        );
        $pg = $_GET['pg'];
        if (!$pg) $pg = 1;
        $datas = $database->select("teacher_announcement", "*",[
            "AND" => [
                "OR"=>[
                  
                    'name[~]'    => ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']), 
                    'date[~]'    => ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),   
                     
                ],
                'teacher[<>]'=> ($xss->xss($_GET['teacher'])=='')?:[$xss->xss($_GET['teacher']),$xss->xss($_GET['teacher'])],
                'class[<>]'=> ($xss->xss($_GET['class'])=='')?:[$xss->xss($_GET['class']),$xss->xss($_GET['class'])],
                'accounts[<>]'=> ($xss->xss($_GET['accounts'])=='')?:[$xss->xss($_GET['accounts']),$xss->xss($_GET['accounts'])],
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
        $templates = $setting['site_backend'].'learning_outcomes.tpl';
    }
    elseif($router['1']=='teacher_announcement-add'){
        $jatbi->permission('teacher_announcement.add');
        $ajax = 'true';
        if(isset($_POST['token'])){
            
            if($_POST['token']!=$_SESSION['csrf']['token']){
                echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
            }
            elseif($_POST['name'] == "" ||$_POST['description'] == ""||$_POST['content'] == "" || $_POST['teacher'] == "" || $_POST['class'] == ""){
                echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
            }
            if ( $_POST['name']  && $_POST['description'] && $_POST['content'] && $_POST['teacher'] && $_POST['class']) {
                $insert = [                  
                    "name"         => $xss->xss($_POST['name']),
                    "date"         => date('Y-m-d'),
                    "description"         => $xss->xss($_POST['description']),
                    "content"         => $xss->xss($_POST['content']),
                    "teacher"         => $xss->xss($_POST['teacher']),
                    "class_diagram"         => $xss->xss($_POST['class']),                             
                    "status"        => $xss->xss($_POST['status']),
                    "school"        =>$school_id,
                ];
                $database->insert("teacher_announcement",$insert);
                $arr = $database->select("arrange_class", "*", [
                    "class_diagram" => $xss->xss($_POST['class']),
                    "deleted" => 0,
                    "status" => 'A',
                    "school" => $school_id
                ]);
                
                $device = array(); // Khởi tạo mảng $device trước khi sử dụng
                
                foreach ($arr as $arrange) {
                    $parent = $database->get("students", "parent", [
                        "id" => $arrange['students'],
                        "deleted" => 0,
                        "status" => 'A',
                        "school" => $school_id
                    ]);
                
                    $devices = $database->select("device_parent", "device_id", [
                        "parent" => $parent,
                        "school" => $school_id,
                        "deleted" => 0,
                        "status" => 'A'
                    ]);
                
                    $device = array_merge($device, $devices); // Thêm các phần tử vào mảng $device
                }
                
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
                $teacher=$database->get("teacher","fullname",['id'=>$xss->xss($_POST['teacher'])]);
                $title =  $school['name'];
                        $message = $teacher.'-'.$_POST['description'];
                $result = sendNotification($title, $message, $device);
                $jatbi->logs('teacher_announcement','add',$insert);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            }
        } 
        else {
            $templates = $setting['site_backend'].'learning_outcomes.tpl';
        }
    }
    elseif($router['1']=='teacher_announcement-edit'){
        $jatbi->permission('teacher_announcement.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("teacher_announcement", "*",["school"        =>$school_id,"id"=>$xss->xss($router['2'])]);
            if($data>1){
                if(isset($_POST['token'])){
                    $partten = "/^[A-Za-z0-9_\.]{".$setting['site_characters'].",32}$/";
                    
                   
                    if($_POST['token']!=$_SESSION['csrf']['token']){
                        echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
                    }
                    elseif($_POST['name'] == "" ||$_POST['description'] == ""||$_POST['content'] == "" || $_POST['teacher'] == "" || $_POST['class'] == ""){
                        echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
                    }
                    if ( $_POST['name']  && $_POST['description'] && $_POST['content'] && $_POST['teacher'] && $_POST['class']) {
                        $insert = [                  
                            "name"         => $xss->xss($_POST['name']),
                            "date"         => date('Y-m-d'),
                            "description"   => $xss->xss($_POST['description']),
                            "content"       => $xss->xss($_POST['content']),
                            "teacher"       => $xss->xss($_POST['teacher']),
                            "class_diagram" => $xss->xss($_POST['class']),
                                                          
                            "status"        => $xss->xss($_POST['status']),
                            "school"        =>$school_id,
                        ];
                        $database->update("teacher_announcement",$insert,["id"=>$data['id']]);
                        $arr = $database->select("arrange_class", "*", [
                            "class_diagram" => $xss->xss($_POST['class']),
                            "deleted" => 0,
                            "status" => 'A',
                            "school" => $school_id
                        ]);
                        
                        $device = array(); // Khởi tạo mảng $device trước khi sử dụng
                        
                        foreach ($arr as $arrange) {
                            $parent = $database->get("students", "parent", [
                                "id" => $arrange['students'],
                                "deleted" => 0,
                                "status" => 'A',
                                "school" => $school_id
                            ]);
                        
                            $devices = $database->select("device_parent", "device_id", [
                                "parent" => $parent,
                                "school" => $school_id,
                                "deleted" => 0,
                                "status" => 'A'
                            ]);
                        
                            $device = array_merge($device, $devices); // Thêm các phần tử vào mảng $device
                        }
                        
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
                        $teacher=$database->get("teacher","fullname",['id'=>$xss->xss($_POST['teacher'])]);
                        $title =  $school['name'];
                        $message = $teacher.'-'.$_POST['description'];
                        $result = sendNotification($title, $message, $device);
                        $jatbi->logs('teacher_announcement','edit',$insert);
                        echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
                    }
                } else {
                    $templates = $setting['site_backend'].'learning_outcomes.tpl';
                }
            }
            else {
                header("HTTP/1.0 404 Not Found");
                die();
            }
        }
    }
    elseif($router['1']=='teacher_announcement-delete'){
        $jatbi->permission('teacher_announcement.delete');
        $ajax = 'true';
        if($router['2']){
            $datas = $database->select("teacher_announcement","*",["id"=>explode(',', $xss->xss($router['2']))]);
            if(isset($_POST['submit'])){
                $jatbi->logs('teacher_announcement','delete',$datas);
                $database->update("teacher_announcement",["deleted" => 1,],["id"=>explode(',', $xss->xss($router['2']))]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            } else {
                $templates = $setting['site_backend'].'learning_outcomes.tpl';
            }
        }
        else {
            header("HTTP/1.0 404 Not Found");
            die();
        }
    }
    elseif($router['1']=='teacher_announcement-status'){
        $jatbi->permission('teacher_announcement.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("teacher_announcement", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if($data['status']==='A'){
                    $status = "D";
                } 
                elseif($data['status']==='D'){
                    $status = "A";
                }
                $database->update("teacher_announcement",["status"=>$status],["id"=>$data['id']]);
                $jatbi->logs('teacher_announcement','status',["data"=>$data,"status"=>$status]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-trang-thai'],'sound'=>$setting['site_sound']]);
            }
            else {
                echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-that-bai'],]);
            }
        }
    }
    elseif($router['1']=='school_announcement'){
        $jatbi->permission('school_announcement');
        $count = $database->count("school_announcement",[
            'AND' => [
                "deleted"       => 0,
            ]]
        );
        $pg = $_GET['pg'];
        if (!$pg) $pg = 1;
        $datas = $database->select("school_announcement", "*",[
            "AND" => [
                "OR"=>[
                  
                    'name[~]'    => ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']), 
                    'date[~]'    => ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),   
                              
                ],
                'accounts[<>]'=> ($xss->xss($_GET['accounts'])=='')?:[$xss->xss($_GET['accounts']),$xss->xss($_GET['accounts'])],
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
        $templates = $setting['site_backend'].'learning_outcomes.tpl';
    }
    elseif($router['1']=='school_announcement-add'){
        $jatbi->permission('school_announcement.add');
        $ajax = 'true';
        if(isset($_POST['token'])){
            $handle = new Upload($_FILES['avatar']);
            if($_POST['token']!=$_SESSION['csrf']['token']){
                echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
            }
            elseif($_POST['name'] == ""  ||$_POST['description'] == ""||$_POST['content'] == "" ){
                echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
            }
            if($handle->uploaded){
		        $handle->allowed 		= array('application/msword', 'image/*');
		        $handle->Process($upload['images']['avatar']['url']);
		    }
            if ($handle->processed  && $_POST['name']  && $_POST['description'] && $_POST['content']) {
                $img = $setting['site_url'].$upload['images']['avatar']['url'].$handle->file_dst_name;
                $insert = [                  
                    "name"         => $xss->xss($_POST['name']),
                    "date"         => date('Y-m-d H:i:s'),
                    "description"         => $xss->xss($_POST['description']),
                    "content"         => $xss->xss($_POST['content']),
                    "accounts"         => $account['id'],  
                    "avatar"        => $img,                                 
                    "status"        => $xss->xss($_POST['status']),
                    "school"        =>$school_id,
                ];
                $database->insert("school_announcement",$insert);
                $device1 = $database->select("device_parent", "device_id",["school"=>$school_id,"deleted"=> 0,"status"=>'A']);
                $device2 = $database->select("device_teacher", "device_id",["school"=>$school_id,"deleted"=> 0,"status"=>'A']);
                $device = array_merge($device1,$device2);
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
                $title =  $school['name'];
                $message = $_POST['description'];
                $result = sendNotification($title, $message, $device);

                $jatbi->logs('school_announcement','add',$insert);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            }
        } 
        else {
            $templates = $setting['site_backend'].'learning_outcomes.tpl';
        }
    }
    elseif($router['1']=='school_announcement-edit'){
        $jatbi->permission('school_announcement.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("school_announcement", "*",["school"        =>$school_id,"id"=>$xss->xss($router['2'])]);
            if($data>1){
                if(isset($_POST['token'])){
                    $partten = "/^[A-Za-z0-9_\.]{".$setting['site_characters'].",32}$/";
                    
                    $handle = new Upload($_FILES['avatar']);
                    if($_POST['token']!=$_SESSION['csrf']['token']){
                        echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
                    }
                    elseif($_POST['name'] == "" ||$_POST['description'] == ""||$_POST['content'] == "" ){
                        echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
                    }
                    if($handle->uploaded){
                        $handle->allowed 		= array('application/msword', 'image/*');
                        $handle->Process($upload['images']['avatar']['url']);
                    }
                    if ($handle->processed  && $_POST['name']  && $_POST['description'] && $_POST['content']) {
                        $img = $setting['site_url'].$upload['images']['avatar']['url'].$handle->file_dst_name;
                        $insert = [                  
                            "name"         => $xss->xss($_POST['name']),
                            "date"         => date('Y-m-d H:i:s'),
                            "description"         => $xss->xss($_POST['description']),
                            "content"         => $xss->xss($_POST['content']),
                            "accounts"         => $account['id'],  
                            "avatar"        => $img,                                 
                            "status"        => $xss->xss($_POST['status']),
                            "school"        =>$school_id,
                        ];
                        $database->update("school_announcement",$insert,["id"=>$data['id']]);
                        $device1 = $database->select("device_parent", "device_id",["school"=>$school_id,"deleted"=> 0,"status"=>'A']);
                        $device2 = $database->select("device_teacher", "device_id",["school"=>$school_id,"deleted"=> 0,"status"=>'A']);
                        $device = array_merge($device1,$device2);
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
                $title =  $school['name'];
                $message = $_POST['description'];
                $result = sendNotification($title, $message, $device);
                        $jatbi->logs('school_announcement','edit',$insert);
                        echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
                    }
                } else {
                    $templates = $setting['site_backend'].'learning_outcomes.tpl';
                }
            }
            else {
                header("HTTP/1.0 404 Not Found");
                die();
            }
        }
    }
    elseif($router['1']=='school_announcement-delete'){
        $jatbi->permission('school_announcement.delete');
        $ajax = 'true';
        if($router['2']){
            $datas = $database->select("school_announcement","*",["id"=>explode(',', $xss->xss($router['2']))]);
            if(isset($_POST['submit'])){
                $jatbi->logs('school_announcement','delete',$datas);
                $database->update("school_announcement",["deleted" => 1,],["id"=>explode(',', $xss->xss($router['2']))]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            } else {
                $templates = $setting['site_backend'].'learning_outcomes.tpl';
            }
        }
        else {
            header("HTTP/1.0 404 Not Found");
            die();
        }
    }
    elseif($router['1']=='school_announcement-status'){
        $jatbi->permission('school_announcement.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("school_announcement", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if($data['status']==='A'){
                    $status = "D";
                } 
                elseif($data['status']==='D'){
                    $status = "A";
                }
                $database->update("school_announcement",["status"=>$status],["id"=>$data['id']]);
                $jatbi->logs('school_announcement','status',["data"=>$data,"status"=>$status]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-trang-thai'],'sound'=>$setting['site_sound']]);
            }
            else {
                echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-that-bai'],]);
            }
        }
    }
    elseif($router['1']=='opinion'){
        $jatbi->permission('opinion');
        $count = $database->count("opinion",[
            'AND' => [
                "deleted"       => 0,
            ]]
        );
        $pg = $_GET['pg'];
        if (!$pg) $pg = 1;
        $datas = $database->select("opinion", "*",[
            "AND" => [
                "OR"=>[
                  
                    
                    'date[~]'    => ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
                    'title[~]'    => ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
                   
                             
                ],
                'parent[<>]'=> ($xss->xss($_GET['parent'])=='')?:[$xss->xss($_GET['parent']),$xss->xss($_GET['parent'])],
                "deleted"       => 0,
                "school"        =>$school_id,
            ],
            "LIMIT" =>[(($pg-1)*$setting['site_page']),$setting['site_page']],
            "ORDER" => [
                "id"=>"DESC",
            ]
        ]);
        $page = $jatbi->pages($count,$setting['site_page'],$pg);
        $templates = $setting['site_backend'].'learning_outcomes.tpl';
    }
    elseif($router['1']=='opinion-edit'){
       
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("opinion", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if(isset($_POST['token'])){
                    $partten = "/^[A-Za-z0-9_\.]{".$setting['site_characters'].",32}$/";
                    
                    $handle = new Upload($_FILES['avatar']);
                    if($_POST['token']!=$_SESSION['csrf']['token']){
                        echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
                    }
                    elseif($_POST['subject'] == "" || $_POST['students'] == ""  || $_POST['typescore'] == "" || $_POST['score'] == ""|| $_POST['semester'] == "" || $_POST['teacher'] == "" || $_POST['school_year'] == ""){
                        echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
                    }
                    if ($handle->processed  && $_POST['subject'] && $_POST['students'] && $_POST['typescore'] && $_POST['score'] && $_POST['semester'] && $_POST['teacher'] && $_POST['school_year']) {
                        $insert = [                  
                            "subject"         => $xss->xss($_POST['subject']), 
                            "students"         => $xss->xss($_POST['students']), 
                            "typescore"         => $xss->xss($_POST['typescore']),  
                            "score"         => $xss->xss($_POST['score']),  
                            "semester"         => $xss->xss($_POST['semester']),
                            "date"         => date('Y-m-d H:i:s'),
                            "teacher"         => $xss->xss($_POST['teacher']), 
                            "accounts"         => $account['id'], 
                            "school_year"         => $xss->xss($_POST['school_year']),                         
                            "status"        => $xss->xss($_POST['status']),
                            "school"        =>$school_id,
                        ];
                        $database->update("scores",$insert,["id"=>$data['id']]);
                        $jatbi->logs('scores','edit',$insert);
                        echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
                    }
                } else {
                    $templates = $setting['site_backend'].'learning_outcomes.tpl';
                }
            }
            else {
                header("HTTP/1.0 404 Not Found");
                die();
            }
        }
    }
?>