<?php
	if (!defined('JATBI')) die("Hacking attempt");
	$school_id=$_SESSION['school'];
	$accounts = $database->select("accounts", "*",["deleted"=> 0,"status"=>'A']);
	$offices = $database->select("offices", "*",["deleted"=> 0,"status"=>'A']);
	if($router['1']=='logs'){
		$jatbi->permission('logs');
		$date = explode('-',$xss->xss($_GET['date']));
		$date_from = ($_GET['date']=='')?date('Y-m-d 00:00:00',strtotime($setting['site_start'])):date('Y-m-d',strtotime(str_replace('/','-',$date[0]))).' 00:00:00';
		$date_to = ($_GET['date']=='')?date('Y-m-d 23:59:59'):date('Y-m-d',strtotime(str_replace('/','-',$date[1]))).' 23:59:59';
		$count = $database->count("logs",[
			'AND' => [
				'user[<>]'		=> ($xss->xss($_GET['user'])=='')?'':[$xss->xss($_GET['user']),$xss->xss($_GET['user'])],
				"OR"=>[
					'dispatch[~]' 	=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
					'action[~]' 	=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
					'content[~]' 	=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
					'ip[~]' 		=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
					'url[~]' 		=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
				],
				"date[<>]" 		=> [$date_from,$date_to],
				"deleted"		=> 0,
				"school"        =>$school_id, 
			]]
		);
		$pg = $_GET['pg'];
		if (!$pg) $pg = 1;
		$datas = $database->select("logs", "*",[
			"AND" => [
				'user[<>]'		=> ($xss->xss($_GET['user'])=='')?'':[$xss->xss($_GET['user']),$xss->xss($_GET['user'])],
				"OR"=>[
					'dispatch[~]' 	=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
					'action[~]' 	=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
					'content[~]' 	=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
					'ip[~]' 		=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
					'url[~]' 		=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
				],
				"date[<>]" 		=> [$date_from,$date_to],
				"deleted"		=> 0,
				"school"        =>$school_id, 
			],
			"LIMIT" =>[(($pg-1)*$setting['site_page']),$setting['site_page']],
			"ORDER"	=> [
				"id"=>"DESC",
			]
		]);
		$page = $jatbi->pages($count,$setting['site_page'],$pg);
		$templates = $setting['site_backend'].'admin.tpl';
	}
	elseif($router['1']=='logs-views'){
		$jatbi->permission('logs');
		$ajax = 'true';
		if($router['2']){
			$data = $database->get("logs","*",[ "school"        =>$school_id, "id"=>$xss->xss($router['2'])]);
			if($data>1){
				$data['logs']['content'] 	= unserialize($data['content']);
				$data['logs']['browsers']	= $data['browsers'];
				$data['logs']['ip']			= $data['ip'];
				$data['logs']['date']		= $data['date'];
				$data['logs']['dispatch']	= $data['dispatch'];
				$data['logs']['action']		= $data['action'];
				$data['logs']['url']		= $data['url'];
				$data['logs']['user']		= $database->get("accounts","name",["id"=>$data['user']]);
				$data['logs']['user-id']	= $data['user'];
				$templates = $setting['site_backend'].'admin.tpl';
			}
			else {
				header("HTTP/1.0 404 Not Found");
				die();
			}
		}
	}
	elseif($router['1']=='notification'){
		$jatbi->permission('notification');
		$date = explode('-',$xss->xss($_GET['date']));
		$date_from = ($_GET['date']=='')?date('Y-m-d 00:00:00',strtotime($setting['site_start'])):date('Y-m-d',strtotime(str_replace('/','-',$date[0]))).' 00:00:00';
		$date_to = ($_GET['date']=='')?date('Y-m-d 23:59:59'):date('Y-m-d',strtotime(str_replace('/','-',$date[1]))).' 23:59:59';
		$count = $database->count("notification",[
			'AND' => [
				"accounts"		=> $account['id'],
				"content[~]"	=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
				"date[<>]" 		=> [$date_from,$date_to],
				"deleted"		=> 0,
				"type[<>]"			=> $_GET['type']==''?'':[$_GET['type'],$_GET['type']],	
			]]
		);
		$pg = $_GET['pg'];
		if (!$pg) $pg = 1;
		$datas = $database->select("notification", "*",[
			"AND" => [
				"accounts"		=> $account['id'],
				"content[~]"	=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
				"date[<>]" 		=> [$date_from,$date_to],
				"deleted"		=> 0,
				"type[<>]"			=> $_GET['type']==''?'':[$_GET['type'],$_GET['type']],	
			],
			"LIMIT" =>[(($pg-1)*$setting['site_page']),$setting['site_page']],
			"ORDER"	=> [
				"id"=>"DESC",
			]
		]);
		$page = $jatbi->pages($count,$setting['site_page'],$pg);
		$templates = $setting['site_backend'].'admin.tpl';
	}
	elseif($router['1']=='notification-views'){
		$ajax = 'true';
		if($router['2']){
			$data = $database->get("notification","*",["active"=>$router['2']]);
			if($data>1){
				$database->update("notification",["views"=>$data['views']+1],["type"=>$data['type'],"views"=>0,"data"=>$data['data'],"accounts"=>$account['id']]);
				if($data['type']=='customers'){
					header("location: /customers/customers-views/".$data['data'].'/');
				}
				elseif($data['type']=='proposal'){
					header("location: /proposal/proposal-views/".$data['data'].'/');
				}	
				elseif($data['type']=='task'){
					header("location: /works/tasks-views/".$data['data'].'/');
				}	
				elseif($data['type']=='rating'){
					header("location: /works/ratings-request-add/".$data['data'].'/');
				}	
				elseif($data['type']=='rating-completed'){
					header("location: /works/ratings-completed-views/".$data['data'].'/');
				}	
				elseif($data['type']=='voted'){
					$getvoted = $database->get("task_voted","task",["id"=>$data['data']]);
					$gettask = $database->get("task","id",["id"=>$getvoted]);
					header("location: /works/tasks-views/".$gettask.'/voted/'.$data['data'].'/');
				}	
				else {
					header("location: ".$data['url']);
				}
				
			}
			else {
				header("HTTP/1.0 404 Not Found");
				die();
			}
		}
	}
	elseif($router['1']=='faceid'){
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
			],
			"LIMIT" =>[(($pg-1)*$setting['site_page']),$setting['site_page']],
			"ORDER"	=> [
				"id"=>"DESC",
			]
		]);
		$page = $jatbi->pages($count,$setting['site_page'],$pg);
		$templates = $setting['site_backend'].'admin.tpl';
	}
	elseif($router['1']=='faceid-views'){
		$jatbi->permission('faceid');
		$ajax = 'true';
		if($router['2']){
			$data = $database->get("webhook","*",["id"=>$xss->xss($router['2'])]);
			if($data>1){
				$data['logs']['content'] 	= unserialize($data['content']);
				$data['logs']['date_face']		= $data['date'];
				$templates = $setting['site_backend'].'admin.tpl';
			}
			else {
				header("HTTP/1.0 404 Not Found");
				die();
			}
		}
	}
	elseif($router['1']=='flood'){
		$jatbi->permission('flood');
		$date = explode('-',$xss->xss($_GET['date']));
		$date_from = ($_GET['date']=='')?date('2021-01-01 00:00:00'):date('Y-m-d',strtotime(str_replace('/','-',$date[0]))).' 00:00:00';
		$date_to = ($_GET['date']=='')?date('Y-m-d 23:59:59'):date('Y-m-d',strtotime(str_replace('/','-',$date[1]))).' 23:59:59';
		$count = $database->count("flood",[
			'AND' => [
				"OR"=>[
					'content[~]' 	=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
				],
				"date[<>]" 		=> [$date_from,$date_to],
				"school"        =>$school_id, 
			]]
		);
		$pg = $_GET['pg'];
		if (!$pg) $pg = 1;
		$datas = $database->select("flood", "*",[
			"AND" => [
				"OR"=>[
					'content[~]' 	=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
				],
				"date[<>]" 		=> [$date_from,$date_to],
				"school"        =>$school_id, 
			],
			"LIMIT" =>[(($pg-1)*$setting['site_page']),$setting['site_page']],
			"ORDER"	=> [
				"id"=>"DESC",
			]
		]);
		$page = $jatbi->pages($count,$setting['site_page'],$pg);
		$templates = $setting['site_backend'].'admin.tpl';
	}
	elseif($router['1']=='flood-views'){
		$jatbi->permission('flood');
		$ajax = 'true';
		if($router['2']){
			$data = $database->get("flood","*",[ "school"        =>$school_id, "id"=>$xss->xss($router['2'])]);
			if($data>1){
				$data['logs']['content'] 	= unserialize($data['content']);
				$data['logs']['browsers']	= $data['browsers'];
				$data['logs']['ip']			= $data['ip'];
				$data['logs']['date']		= $data['date'];
				$data['logs']['url']		= $data['url'];
				$templates = $setting['site_backend'].'admin.tpl';
			}
			else {
				header("HTTP/1.0 404 Not Found");
				die();
			}
		}
	}
	elseif($router['1']=='flood-delete'){
		$jatbi->permission('flood.delete');
		$ajax = 'true';
		if($router['2']){
			$datas = $database->select("flood","*",["id"=>explode(',', $xss->xss($router['2']))]);
			if(isset($_POST['submit'])){
				$jatbi->logs('flood','delete',$datas);
				$database->delete("flood","*",["id"=>explode(',', $xss->xss($router['2']))]);
				echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
			} else {
				$templates = $setting['site_backend'].'admin.tpl';
			}
		}
		else {
			header("HTTP/1.0 404 Not Found");
			die();
		}
	}
	elseif($router['1']=='blockip'){
		$jatbi->permission('blockip');
		$count = $database->count("blockip",[
			'AND' => [
				'ip[~]'  		=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']), 
				'status' 		=> ($xss->xss($_GET['status'])=='')?[A,D]:$xss->xss($_GET['status']),
				"deleted"		=> 0,
				"school"        =>$school_id, 
			]]
		);
		$pg = $_GET['pg'];
		if (!$pg) $pg = 1;
		$datas = $database->select("blockip", "*",[
			"AND" => [
				'ip[~]'  		=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']), 
				'status' 		=> ($xss->xss($_GET['status'])=='')?[A,D]:$xss->xss($_GET['status']), 
				"deleted"		=> 0,
				"school"        =>$school_id, 
			],
			"LIMIT" =>[(($pg-1)*$setting['site_page']),$setting['site_page']],
			"ORDER"	=> [
				"id"=>"DESC",
			]
		]);
		$page = $jatbi->pages($count,$setting['site_page'],$pg);
		$templates = $setting['site_backend'].'admin.tpl';
	}
	elseif($router['1']=='blockip-add'){
		$jatbi->permission('blockip.add');
		$ajax = 'true';
		if(isset($_POST['token'])){
			if($_POST['ip'] == ""){
				echo json_encode(['status'=>'error','content'=>$lang['loi-trong']]);
			}
			if ($_POST['ip']){
				$insert = [
					"ip" 			=> $xss->xss($_POST['ip']),
					"content" 		=> $xss->xss($_POST['content']),
					"date" 			=> date("Y-m-d H:i:s"),
					"status" 		=> $xss->xss($_POST['status']),
					"school"        =>$school_id, 
				];
				$database->insert("blockip",$insert);
				$jatbi->logs('blockip','add',$insert);
				echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
			}
		} else {
			$templates = $setting['site_backend'].'admin.tpl';
		}
	}
	elseif($router['1']=='blockip-edit'){
		$jatbi->permission('blockip.edit');
		$ajax = 'true';
		if($router['2']){
			$data = $database->get("blockip", "*",["id"=>$xss->xss($router['2'])]);
			if($data>1){
				if(isset($_POST['token'])){
					if($_POST['ip'] == ""){
						echo json_encode(['status'=>'error','content'=>$lang['loi-trong']]);
					}
					if ($_POST['ip']){
						$insert = [
							"ip" 			=> $xss->xss($_POST['ip']),
							"content" 		=> $xss->xss($_POST['content']),
							"date" 			=> date("Y-m-d H:i:s"),
							"status" 		=> $xss->xss($_POST['status']),
							"school"        =>$school_id, 
						];
						$database->update("blockip",$insert,["id"=>$data['id']]);
						$jatbi->logs('blockip','edit',$insert);
						echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
					}
				} else {
					$vgroup = unserialize($data['group']);
					$templates = $setting['site_backend'].'admin.tpl';
				}
			}
			else {
				header("HTTP/1.0 404 Not Found");
				die();
			}
		}
	}
	elseif($router['1']=='blockip-status'){
		$jatbi->permission('blockip.edit');
		$ajax = 'true';
		if($router['2']){
			$data = $database->get("blockip", "*",["id"=>$xss->xss($router['2'])]);
			if($data>1){
				if($data['status']==='A'){
					$status = "D";
				} 
				elseif($data['status']==='D'){
					$status = "A";
				}
				$database->update("blockip",["status"=>$status],["id"=>$data['id']]);
				$jatbi->logs('blockip','status',["data"=>$data,"status"=>$status]);
				echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-trang-thai'],'sound'=>$setting['site_sound']]);
			}
			else {
				echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-that-bai'],]);
			}
		}
	}
	elseif($router['1']=='blockip-delete'){
		$jatbi->permission('blockip.delete');
		$ajax = 'true';
		if($router['2']){
			$datas = $database->select("blockip","*",["id"=>explode(',', $xss->xss($router['2']))]);
			if(isset($_POST['submit'])){
				$jatbi->logs('blockip','delete',$datas);
				$database->update("blockip",["deleted"	=> 1,],["id"=>explode(',', $xss->xss($router['2']))]);
				echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
			} else {
				$templates = $setting['site_backend'].'admin.tpl';
			}
		}
		else {
			header("HTTP/1.0 404 Not Found");
			die();
		}
	}
	elseif($router['1']=='config'){
		$jatbi->permission('config');
		$ajax = 'true';
		$school = $database->get("school","*",["id"        =>$school_id]);
		$data = $database->get("settings","*",["school"        =>$school_id]);
		$datas = $database->select("timework_details", "*",["off"=>0,"school"        =>$school_id]);
		$datass = $database->select("timework_details", "*",["off"=>1,"school"        =>$school_id]);
		if(isset($_POST['token'])){
			$handle = new Upload($_FILES['logo']);
			if ($handle->uploaded) {
		        $handle->allowed 		= array('application/msword', 'image/*');
		        $handle->Process($upload['images']['logo']['url']);
		    }
			$insert = [
				"name" 			=> $xss->xss($_POST['name']),
				"address" 		=> $xss->xss($_POST['address']),
				"phone" 		=> $xss->xss($_POST['phone']),
				"district" 		=> "",
				"province" 		=> "",
				"ward" 			=> "",
				"logo" 			=> $handle->file_dst_name==''?$data['logo']:$handle->file_dst_name,
				"characters" 	=> $xss->xss($_POST['characters']),
				"page" 			=> $xss->xss($_POST['page']),
				"date" 			=> $xss->xss($_POST['date']),
				"time" 			=> $xss->xss($_POST['time']),
				"datetime" 		=> $xss->xss($_POST['date']).' '.$xss->xss($_POST['time']),
				"timework_from" => $xss->xss($_POST['timework_from']),
				"timework_to" 	=> $xss->xss($_POST['timework_to']),
				"content" 		=> $xss->xss($_POST['content']),
				"school"        =>$school_id,
			];

			if($data>1){
				$database->update("settings",$insert,["id"=>$data['id']]);
				$jatbi->logs('settings','add',$insert);
			}
			else {
				$database->insert("settings",$insert);
				$jatbi->logs('settings','update',$insert);
			}
			if($datas!=[]){
				if($_POST['week']){
					foreach($_POST['week'] as $vallu){
						$datasa = $database->get("timework_details", "*",["week"=>$valu,"off"=>0,"school"        =>$school_id]);
						$insert = [            
							"week"          => $vallu, 
							"time_from"          => $xss->xss($_POST['timework_from']),
							"time_to"          => $xss->xss($_POST['timework_to']),                          
							"off"        => 0,
							"date"        => date("Y-m-d H:i:s"),
							"user"          => $account['id'],
							"school"        =>$school_id,
						];
						$database->update("timework_details",$insert,["id"=>$datasa['id']]);
						$jatbi->logs('timework_details','edit',$insert);
					}
				}
			}else{
				if($_POST['week']){
					foreach($_POST['week'] as $valuu){
						$insert= [            
							"week"          => $valuu, 
							"time_from"          => $xss->xss($_POST['timework_from']),
							"time_to"          => $xss->xss($_POST['timework_to']),                          
							"off"        => 0,
							"date"        => date("Y-m-d H:i:s"),
							"user"          => $account['id'],
							"school"        =>$school_id,
						];
						$database->insert("timework_details",$insert);
						$jatbi->logs('timework_details','add',$insert);
					}
				}
				
			}
			if($datass!=[]){
				if($_POST['weekk']){
					foreach($_POST['weekk'] as $valus){
						$datassa = $database->get("timework_details", "*",["week"=>$valus,"off"=>1,"school"        =>$school_id]);
						$insert = [            
							"week"          => $valus, 
							"time_from"          => $xss->xss($_POST['timework_from']),
							"time_to"          => $xss->xss($_POST['timework_to']),                          
							"off"        => 1,
							"date"        => date("Y-m-d H:i:s"),
							"user"          => $account['id'],
							"school"        =>$school_id,
						];
						$database->update("timework_details",$insert,["id"=>$datassa['id']]);
						$jatbi->logs('timework_details','edit',$insert);
					}
				}
			}else{
				if($_POST['weekk']){
					foreach($_POST['weekk'] as $valu){
						$insert = [            
							"week"          => $valu, 
							"time_from"          => $xss->xss($_POST['timework_from']),
							"time_to"          => $xss->xss($_POST['timework_to']),                          
							"off"        => 1,
							"date"        => date("Y-m-d H:i:s"),
							"user"          => $account['id'],
							"school"        =>$school_id
						];
						$database->insert("timework_details",$insert);
						$jatbi->logs('timework_details','add',$insert);
					}
				}
			}
			
			echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
		} else {
			$templates = $setting['site_backend'].'admin.tpl';
		}
	}
	elseif($router['1']=='projects-task'){
		$jatbi->permission('projects-task');
		$count = $database->count("projects_task",[
			'AND' => [
				'name[~]'  		=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']), 
				'status' 		=> ($xss->xss($_GET['status'])=='')?[A,D]:$xss->xss($_GET['status']),
				"deleted"		=> 0,
			]]
		);
		$pg = $_GET['pg'];
		if (!$pg) $pg = 1;
		$datas = $database->select("projects_task", "*",[
			"AND" => [
				'name[~]'  		=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']), 
				'status' 		=> ($xss->xss($_GET['status'])=='')?[A,D]:$xss->xss($_GET['status']), 
				"deleted"		=> 0,
			],
			"LIMIT" =>[(($pg-1)*$setting['site_page']),$setting['site_page']],
			"ORDER"	=> [
				"id"=>"DESC",
			]
		]);
		$page = $jatbi->pages($count,$setting['site_page'],$pg);
		$templates = $setting['site_backend'].'admin.tpl';
	}
	elseif($router['1']=='projects-task-add'){
		$jatbi->permission('projects-task.add');
		$ajax = 'true';
		if(isset($_POST['token'])){
			if($_POST['name'] == "" || $_POST['content'] == "" || $_POST['status'] == "" || $_POST['type'] == "" || $_POST['position'] == "" || $_POST['process'] == "" || $_POST['time'] == ""){
				echo json_encode(['status'=>'error','content'=>$lang['loi-trong']]);
			}
			if ($_POST['name'] && $_POST['content'] && $_POST['status'] && $_POST['type'] && $_POST['position'] && $_POST['process'] && $_POST['time']){
				$insert = [
					"name" 			=> $xss->xss($_POST['name']),
					"content" 		=> $xss->xss($_POST['content']),
					"type" 			=> $xss->xss($_POST['type']),
					"position" 		=> $xss->xss($_POST['position']),
					"process" 		=> $xss->xss($_POST['process']),
					"time" 			=> $xss->xss($_POST['time']),
					"accounts" 		=> $xss->xss($_POST['accounts']),
					"views" 		=> $xss->xss($_POST['views']),
					"offices" 		=> $xss->xss($_POST['offices']),
					"user" 			=> $account['id'],
					"date" 			=> date("Y-m-d H:i:s"),
					"status" 		=> $xss->xss($_POST['status']),
				];
				$database->insert("projects_task",$insert);
				$jatbi->logs('projects-task','add',$insert);
				echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
			}
		} else {
			$templates = $setting['site_backend'].'admin.tpl';
		}
	}
	elseif($router['1']=='projects-task-edit'){
		$jatbi->permission('projects-task.edit');
		$ajax = 'true';
		if($router['2']){
			$data = $database->get("projects_task", "*",["id"=>$xss->xss($router['2'])]);
			if($data>1){
				if(isset($_POST['token'])){
					if($_POST['name'] == "" || $_POST['content'] == "" || $_POST['status'] == "" || $_POST['type'] == "" || $_POST['position'] == "" || $_POST['process'] == "" || $_POST['time'] == ""){
						echo json_encode(['status'=>'error','content'=>$lang['loi-trong']]);
					}
					if ($_POST['name'] && $_POST['content'] && $_POST['status'] && $_POST['type'] && $_POST['position'] && $_POST['process'] && $_POST['time']){
						$insert = [
							"name" 			=> $xss->xss($_POST['name']),
							"content" 		=> $xss->xss($_POST['content']),
							"type" 			=> $xss->xss($_POST['type']),
							"position" 		=> $xss->xss($_POST['position']),
							"process" 		=> $xss->xss($_POST['process']),
							"time" 			=> $xss->xss($_POST['time']),
							"accounts" 		=> $xss->xss($_POST['accounts']),
							"views" 		=> $xss->xss($_POST['views']),
							"offices" 		=> $xss->xss($_POST['offices']),
							"user" 			=> $account['id'],
							"date" 			=> date("Y-m-d H:i:s"),
							"status" 		=> $xss->xss($_POST['status']),
						];
						$database->update("projects_task",$insert,["id"=>$data['id']]);
						$jatbi->logs('projects-task','edit',$insert);
						echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
					}
				} else {
					foreach (unserialize($data['accounts']) as $vaccount) {
						$vaccounts[$vaccount] = $vaccount;
					}
					foreach (unserialize($data['offices']) as $voffice) {
						$voffices[$voffice] = $voffice;
					}
					foreach (unserialize($data['views']) as $vview) {
						$vviews[$vview] = $vview;
					}
					$templates = $setting['site_backend'].'admin.tpl';
				}
			}
			else {
				header("HTTP/1.0 404 Not Found");
				die();
			}
		}
	}
	elseif($router['1']=='projects-task-status'){
		$jatbi->permission('projects-task.edit');
		$ajax = 'true';
		if($router['2']){
			$data = $database->get("projects_task", "*",["id"=>$xss->xss($router['2'])]);
			if($data>1){
				if($data['status']==='A'){
					$status = "D";
				} 
				elseif($data['status']==='D'){
					$status = "A";
				}
				$database->update("projects_task",["status"=>$status],["id"=>$data['id']]);
				$jatbi->logs('projects-task','status',["data"=>$data,"status"=>$status]);
				echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-trang-thai'],'sound'=>$setting['site_sound']]);
			}
			else {
				echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-that-bai'],]);
			}
		}
	}
	elseif($router['1']=='projects-task-delete'){
		$jatbi->permission('projects-task.delete');
		$ajax = 'true';
		if($router['2']){
			$datas = $database->select("projects_task","*",["id"=>explode(',', $xss->xss($router['2']))]);
			if(isset($_POST['submit'])){
				$jatbi->logs('projects-task','delete',$datas);
				$database->update("projects_task",["deleted"	=> 1,],["id"=>explode(',', $xss->xss($router['2']))]);
				echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
			} else {
				$templates = $setting['site_backend'].'admin.tpl';
			}
		}
		else {
			header("HTTP/1.0 404 Not Found");
			die();
		}
	}
?>