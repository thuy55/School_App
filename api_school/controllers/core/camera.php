<?php
	if (!defined('JATBI')) die("Hacking attempt");
	$school_id=$_SESSION['school'];
    $school = $database->get("school", "*",["id"        =>$school_id,"deleted"=> 0,"status"=>'A']);
	$permissions = $database->select("permission", "*",["school" => $school_id,"deleted"=> 0,"status"=>'A']);
	$camera_setting = $database->select("camera_setting", "*",["school" => $school_id,"deleted"=> 0,"status"=>'A']);
	$date = date("Y-m-d");
    $course = $database->select("course", "*", [
        "school" => $school_id,
        "status" => 'A',
        "deleted" => 0,
    ]);
    foreach ($course as $value) {
        $date_timestamp = strtotime($date);
        $start_timestamp = strtotime($value['startdate']);
        $end_timestamp = strtotime($value['enddate']);

        if ($date_timestamp >= $start_timestamp && $date_timestamp <= $end_timestamp) {
            $class_course = $database->select("class_diagram", "*", [
                "AND" => [
                    "deleted" => 0,
                    'course' => $value['id'],
                    "school" => $school_id,
                ],

                "ORDER" => [
                    "id" => "DESC",
                ]
            ]);
        }
    }
	if($router['1']=='faceid'){
		$jatbi->permission('faceid');
		$date = explode('-',$xss->xss($_GET['date']));
		$date_from = ($_GET['date']=='')?date('2021-01-01 00:00:00'):date('Y-m-d',strtotime(str_replace('/','-',$date[0]))).' 00:00:00';
		$date_to = ($_GET['date']=='')?date('Y-m-d 23:59:59'):date('Y-m-d',strtotime(str_replace('/','-',$date[1]))).' 23:59:59';
		$count = $database->count("webhook",[
			'AND' => [
				"OR"=>[
					'content[~]' 	=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
				],
				"date_face[<>]" 		=> [$date_from,$date_to],
				"deleted"		=> 0,
				"school"=>$school_id,
			]]
		);
		$pg = $_GET['pg'];
		if (!$pg) $pg = 1;
		$datas = $database->select("webhook", "*",[
			"AND" => [
				"OR"=>[
					'content[~]' 	=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
				],
				"date_face[<>]" 		=> [$date_from,$date_to],
				"deleted"		=> 0,
				"school"=>$school_id,
			],
			"LIMIT" =>[(($pg-1)*$setting['site_page']),$setting['site_page']],
			"ORDER"	=> [
				"id"=>"DESC",
			]
		]);
		$page = $jatbi->pages($count,$setting['site_page'],$pg);
		$templates = $setting['site_backend'].'camera.tpl';
	}
	elseif($router['1']=='faceid-views'){
		$jatbi->permission('faceid');
		$ajax = 'true';
		if($router['2']){
			$data = $database->get("webhook","*",["id"=>$xss->xss($router['2'])]);
			if($data>1){
				$data['logs']['content'] 	= unserialize($data['content']);
				$data['logs']['date_face']		= $data['date'];
				$templates = $setting['site_backend'].'camera.tpl';
			}
			else {
				header("HTTP/1.0 404 Not Found");
				die();
			}
		}
	}
	elseif($router['1']=='check_cam'){
		$jatbi->permission('check_cam');
		$templates = $setting['site_backend'].'camera.tpl';
	}
    elseif($router['1']=='camera_setting'){
        $jatbi->permission('camera_setting');
        $count = $database->count("camera_setting",[
            'AND' => [
      
                "deleted"       => 0,
				"school"    =>$school_id,
            ]]
        );
        $pg = $_GET['pg'];
        if (!$pg) $pg = 1;
        $datas = $database->select("camera_setting", "*",[
            "AND" => [
                "OR"=>[
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
        $templates = $setting['site_backend'].'camera.tpl';
    }
    elseif($router['1']=='camera_setting-add'){
        $jatbi->permission('camera_setting.add');
        $ajax = 'true';
        if(isset($_POST['token'])){
            if($_POST['token']!=$_SESSION['csrf']['token']){
                echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
            }
            elseif($_POST['name'] == "" || $_POST['link'] == "" || $_POST['accounts_cam'] == "" || $_POST['password'] == ""|| $_POST['port'] == ""){
                echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
            }
            if ($_POST['name'] && $_POST['link'] && $_POST['accounts_cam'] && $_POST['password'] && $_POST['port']) {
                
                
                
                $inserts = array(
                    "name" 			=> $xss->xss($_POST['name']),	
                    "address"       => $school['address'],
                    "token"     	=> $school['token'],		
                    "status" 		=> 'A',
                    "account"		=> '24',
                );
                $json = json_encode($inserts);

                $curl = curl_init();
                curl_setopt_array($curl, array(
                  CURLOPT_URL => 'https://api.cam.eclo.io/place/addplace/',
                    CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => '',
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 0,
                  CURLOPT_FOLLOWLOCATION => true,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_SSL_VERIFYPEER => false,
                  CURLOPT_CUSTOMREQUEST => 'POST',
                  CURLOPT_POSTFIELDS =>$json,
                  CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                  ),
                ));
                $response = curl_exec($curl);
                curl_close($curl);

                $getJson = json_decode($response,true);
                if($getJson['status']=='success'){
                    $insert = [                  
                        "name"          => $xss->xss($_POST['name']),   
                        "link"          => $xss->xss($_POST['link']),
                        "accounts_cam"          => $xss->xss($_POST['accounts_cam']),
                        "password"          => $xss->xss($_POST['password']),
                        "port"          => $xss->xss($_POST['port']),
                        "note"          => $xss->xss($_POST['note']),
                        "status"        => $xss->xss($_POST['status']),
                        "active"=> $getJson['data'],
                        "school"        =>$school_id,
                    ];
                    $database->insert("camera_setting",$insert);
                    echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER'],"json"=>$getJson]);
                }
                else {
                    echo json_encode(['status'=>'error','content'=>$getJson['content'],"url"=>$_SERVER['HTTP_REFERER'],"json"=>$getJson]);
                }                
            }
            $jatbi->logs('camera_setting','add',$insert);
                
        }else {
            $templates = $setting['site_backend'].'camera.tpl';
        }
    }
    elseif($router['1']=='camera_setting-edit'){
        $jatbi->permission('camera_setting.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("camera_setting", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if(isset($_POST['token'])){
                    $partten = "/^[A-Za-z0-9_\.]{".$setting['site_characters'].",32}$/";
                    
                    $handle = new Upload($_FILES['avatar']);
                    if($_POST['token']!=$_SESSION['csrf']['token']){
                        echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
                    }
                    elseif($_POST['name'] == "" || $_POST['link'] == "" || $_POST['accounts_cam'] == "" || $_POST['password'] == ""|| $_POST['port'] == ""){
						echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
					}
					if ($_POST['name'] && $_POST['link'] && $_POST['accounts_cam'] && $_POST['password'] && $_POST['port']) {
						$insert = [                  
							"name"          => $xss->xss($_POST['name']),   
							"link"          => $xss->xss($_POST['link']),
							"accounts_cam"          => $xss->xss($_POST['accounts_cam']),
							"password"          => $xss->xss($_POST['password']),
							"port"          => $xss->xss($_POST['port']),
							"note"          => $xss->xss($_POST['note']),
							"status"        => $xss->xss($_POST['status']),
							"school"        =>$school_id,
						];
                        $database->update("camera_setting",$insert,["id"=>$data['id']]);
                        $jatbi->logs('camera_setting','edit',$insert);
                        echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
                    }
                } else {
                    $templates = $setting['site_backend'].'camera.tpl';
                }
            }
            else {
                header("HTTP/1.0 404 Not Found");
                die();
            }
        }
    }
    elseif($router['1']=='camera_setting-delete'){
        $jatbi->permission('camera_setting.delete');
        $ajax = 'true';
        if($router['2']){
            $datas = $database->select("camera_setting","*",["id"=>explode(',', $xss->xss($router['2']))]);
            if(isset($_POST['submit'])){
                $jatbi->logs('camera_setting','delete',$datas);
                $database->update("camera_setting",["deleted" => 1,],["id"=>explode(',', $xss->xss($router['2']))]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            } else {
                $templates = $setting['site_backend'].'camera.tpl';
            }
        }
        else {
            header("HTTP/1.0 404 Not Found");
            die();
        }
    }
    elseif($router['1']=='camera_setting-status'){
        $jatbi->permission('camera_setting.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("camera_setting", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if($data['status']==='A'){
                    $status = "D";
                } 
                elseif($data['status']==='D'){
                    $status = "A";
                }
                $database->update("camera_setting",["status"=>$status],["id"=>$data['id']]);
                $jatbi->logs('camera_setting','status',["data"=>$data,"status"=>$status]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-trang-thai'],'sound'=>$setting['site_sound']]);
            }
            else {
                echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-that-bai'],]);
            }
        }
    }
	elseif($router['1']=='camera_channel'){
        $jatbi->permission('camera_channel');
        $count = $database->count("camera_channel",[
            'AND' => [
      
                "deleted"       => 0,
				"school"    =>$school_id,
            ]]
        );
        $pg = $_GET['pg'];
        if (!$pg) $pg = 1;
        $datas = $database->select("camera_channel", "*",[
            "AND" => [
                "OR"=>[
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
        $templates = $setting['site_backend'].'camera.tpl';
    }
    elseif($router['1']=='camera_channel-add'){
        $jatbi->permission('camera_channel.add');
        $ajax = 'true';
        if(isset($_POST['token'])){
            if($_POST['token']!=$_SESSION['csrf']['token']){
                echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
            }
            elseif($_POST['name'] == "" || $_POST['camera_setting'] == "" || $_POST['channel'] == "" || $_POST['display'] == ""|| $_POST['class_diagram'] == ""){
				echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
			}
			if($_POST['name'] && $_POST['camera_setting'] && $_POST['channel']  && $_POST['class_diagram']) {
				$insert = [                  
					"name"          => $xss->xss($_POST['name']),   
					"camera_setting"=> $xss->xss($_POST['camera_setting']),
					"channel"       => $xss->xss($_POST['channel']),
					"display"       => $xss->xss($_POST['display']),
					"class_diagram" => $xss->xss($_POST['class_diagram']),
					"note"          => $xss->xss($_POST['note']),
					"status"        => $xss->xss($_POST['status']),
					"school"        =>$school_id,
				];
                $database->insert("camera_channel",$insert);
                $jatbi->logs('camera_channel','add',$insert);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            }
        } 
        else {
            $templates = $setting['site_backend'].'camera.tpl';
        }
    }
    elseif($router['1']=='camera_channel-edit'){
        $jatbi->permission('camera_channel.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("camera_channel", "*",["school"        =>$school_id,"id"=>$xss->xss($router['2'])]);
            if($data>1){
                if(isset($_POST['token'])){
                    $partten = "/^[A-Za-z0-9_\.]{".$setting['site_characters'].",32}$/";
                    
                    $handle = new Upload($_FILES['avatar']);
                    if($_POST['token']!=$_SESSION['csrf']['token']){
                        echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
                    }
                    elseif($_POST['name'] == "" || $_POST['camera_setting'] == "" || $_POST['channel'] == "" || $_POST['display'] == ""|| $_POST['class_diagram'] == ""){
						echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
					}
					if ($_POST['name'] && $_POST['camera_setting'] && $_POST['channel']  && $_POST['class_diagram']) {
						$insert = [                  
							"name"          => $xss->xss($_POST['name']),   
							"camera_setting"          => $xss->xss($_POST['camera_setting']),
							"channel"          => $xss->xss($_POST['channel']),
							"display"          => $xss->xss($_POST['display']),
							"class_diagram"          => $xss->xss($_POST['class_diagram']),
							"note"          => $xss->xss($_POST['note']),
							"status"        => $xss->xss($_POST['status']),
							"school"        =>$school_id,
						];
                        $database->update("camera_channel",$insert,["id"=>$data['id']]);
                        $jatbi->logs('camera_channel','edit',$insert);
                        echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
                    }
                } else {
                    $templates = $setting['site_backend'].'camera.tpl';
                }
            }
            else {
                header("HTTP/1.0 404 Not Found");
                die();
            }
        }
    }
    elseif($router['1']=='camera_channel-eye'){
        $jatbi->permission('camera_channel.edit');
         $templates = $setting['site_backend'].'camera.tpl';

    }
    elseif($router['1']=='camera_channel-delete'){
        $jatbi->permission('camera_channel.delete');
        $ajax = 'true';
        if($router['2']){
            $datas = $database->select("camera_channel","*",["id"=>explode(',', $xss->xss($router['2']))]);
            if(isset($_POST['submit'])){
                $jatbi->logs('camera_channel','delete',$datas);
                $database->update("camera_channel",["deleted" => 1,],["id"=>explode(',', $xss->xss($router['2']))]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            } else {
                $templates = $setting['site_backend'].'camera.tpl';
            }
        }
        else {
            header("HTTP/1.0 404 Not Found");
            die();
        }
    }
    elseif($router['1']=='camera_channel-status'){
        $jatbi->permission('camera_channel.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("camera_channel", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if($data['status']==='A'){
                    $status = "D";
                } 
                elseif($data['status']==='D'){
                    $status = "A";
                }
                $database->update("camera_channel",["status"=>$status],["id"=>$data['id']]);
                $jatbi->logs('camera_channel','status',["data"=>$data,"status"=>$status]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-trang-thai'],'sound'=>$setting['site_sound']]);
            }
            else {
                echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-that-bai'],]);
            }
        }
    }
	
	

?>