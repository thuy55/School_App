<?php
	if (!defined('JATBI')) die("Hacking attempt");
	$school_id=$_SESSION['school'];
	$permissions = $database->select("permission", "*",["school"        =>$school_id,"deleted"=> 0,"status"=>'A']);
	$account_school=$database->select("account_school","*",['school'=>$school_id,"deleted"=> 0,"status"=>'A', "ORDER" => [
        "id"=>"DESC",
    ]]);
	if($router['1']=='accounts'){
		$jatbi->permission('accounts');
		$count = $database->count("accounts",[
			'AND' => [
				"OR"=>[
					'name[~]'  		=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
					'account[~]'  	=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
					'email[~]'  	=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
				],
				'main[<>]'=> ($xss->xss($_GET['main'])=='')?:[$xss->xss($_GET['main']),$xss->xss($_GET['main'])], 
				'permission[<>]'=> ($xss->xss($_GET['permission'])=='')?:[$xss->xss($_GET['permission']),$xss->xss($_GET['permission'])], 
				'status' 		=> ($xss->xss($_GET['status'])=='')?[A,D]:$xss->xss($_GET['status']),
				"deleted"		=> 0,
				"school"        =>$school_id,
			]]
		);
		$pg = $_GET['pg'];
		if (!$pg) $pg = 1;
		foreach ($account_school as $account){
			$datas[] = $database->get("accounts", "*",[
				"AND" => [
					"OR"=>[
						'name[~]'  		=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
						'account[~]'  	=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
						'email[~]'  	=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
					],
					'main[<>]'=> ($xss->xss($_GET['main'])=='')?:[$xss->xss($_GET['main']),$xss->xss($_GET['main'])], 
					'permission[<>]'=> ($xss->xss($_GET['permission'])=='')?:[$xss->xss($_GET['permission']),$xss->xss($_GET['permission'])], 
					'status' 		=> ($xss->xss($_GET['status'])=='')?[A,D]:$xss->xss($_GET['status']), 
					"deleted"		=> 0,
					"id"        =>$account['accounts'],
				],
				"LIMIT" =>[(($pg-1)*$setting['site_page']),$setting['site_page']],
				"ORDER"	=> [
					"id"=>"DESC",
				]
			]);
		}
		$page = $jatbi->pages($count,$setting['site_page'],$pg);
		$templates = $setting['site_backend'].'users.tpl';
	}
	elseif($router['1']=='accounts-add'){
		$jatbi->permission('accounts.add');
		$ajax = 'true';
		$count = $database->count("accounts",[
			'AND' => [
				'OR'=>[
					"phone"  => $xss->xss($_POST['phone']),
					"account"  => $xss->xss($_POST['account']),
				],
				
				"status"        => 'A',  
				"deleted"       => 0,
			]]
		);
		$accounts=$database->get("accounts","id",[
			'AND' => [
				'OR'=>[
					"phone"  => $xss->xss($_POST['phone']),
					"account"  => $xss->xss($_POST['account']),
				],
				"status"        => 'A',  
				"deleted"       => 0,
			]]
		);

		$count_active = $database->count("account_school", [
			'AND' => [
				"accounts[IN]" => $accounts,
				'school' => $school_id,
				"status" => 'A',
				"deleted" => 0,
			]
		]);
		
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
			$checkaccount = $database->get("accounts", "*",["account"=>$jatbi->checkaccount($_POST['account']),"deleted"=>0]);
		    $handle = new Upload($_FILES['avatar']);
			if($_POST['token']!=$_SESSION['csrf']['token']){
				echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
			}
		    elseif($_POST['type'] == "" || $_POST['account'] == "" || $_POST['email'] == "" || $_POST['name'] == "" || $_POST['permission'] == ""){
				echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
			}
			elseif(!preg_match($partten ,$_POST['account'])){
				echo json_encode(['status'=>'error','content'=>$lang['tai-khoan-khong-hop-le'],'sound'=>$setting['site_sound']]);
			}
			elseif($jatbi->checkaccount($_POST['account']) == $checkaccount['account']){
				echo json_encode(['status'=>'error','content'=>$lang['tai-khoan-co-nguoi-su-dung'],'sound'=>$setting['site_sound']]);
			}
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
			if($count>0){
                if($count_active==0){
                    $insert_register=[
                        "accounts"=> $accounts,
                        "school"=> $school_id,
                        "status"=>'A',
                    ];
                    $database->insert("account_school",$insert_register);
                    $jatbi->logs('account_school','add',$insert_register);
                    echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
                   
                }else{
                    echo json_encode(['status'=>'error','content'=>$lang['tai-khoan-da-dang-ki'],'sound'=>$setting['site_sound']]);   
                }
            }
			elseif($count==0 && $count_active==0){
		    if ($handle->processed && $_POST['name'] && $_POST['type'] && $_POST['email'] && $_POST['permission'] && $_POST['email'] != $checkemail['email'] && $jatbi->checkaccount($_POST['account']) != $checkaccount['account'] && preg_match($partten ,$_POST['account']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		    	$insert = [
					"main" 			=> $xss->xss($_POST['main']),
					"name" 			=> $xss->xss($_POST['name']),
					"email" 		=> $xss->xss($_POST['email']),
					"account" 		=> $xss->xss($jatbi->checkaccount($_POST['account'])),
					"phone" 		=> $xss->xss($_POST['phone']),
					"password" 		=> password_hash($xss->xss($_POST['password']), PASSWORD_DEFAULT),
					"permission" 	=> $xss->xss($_POST['permission']),
					"data" 			=> $xss->xss($_POST['data']),
					"type" 			=> $xss->xss($_POST['type']),
					"active"		=> $jatbi->active(32),
					"avatar"		=> $handle->file_dst_name==''?$rand_avatar:$handle->file_dst_name,
					"birthday"		=> date('Y-m-d',strtotime(str_replace('/','-',$_POST['birthday']))),
					"gender"		=> $xss->xss($_POST['gender']),
					"date" 			=> date('Y-m-d H:i:s'),
					"status" 		=> $xss->xss($_POST['status']),
				];
				$database->insert("accounts",$insert);
                    $tui = $database->id();
                    $insert_register=[
                        "accounts"=> $tui,
                        "school"=> $school_id,
                        "status"=>'A',
                    ];
					$database->insert("account_school",$insert_register);
                    $jatbi->logs('account_school','add',$insert_register);
				$jatbi->logs('accounts','add',$insert);
				echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
	        }
		}
		} 
		else {
			$templates = $setting['site_backend'].'users.tpl';
		}
	}
	elseif($router['1']=='accounts-edit'){
		$jatbi->permission('accounts.edit');
		$ajax = 'true';
		if($router['2']){
			$data = $database->get("accounts", "*",["id"=>$xss->xss($router['2'])]);
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
					if($data['email']!=$_POST['email']){
						$checkemail = $database->get("accounts", "*", ["email"=>$_POST['email'],"deleted"=>0]);
					}
					if($data['account']!=$_POST['account']){
						$checkaccount = $database->get("accounts", "*",["account"=>$jatbi->checkaccount($_POST['account']),"deleted"=>0]);
					}
				    $handle = new Upload($_FILES['avatar']);
					if($_POST['token']!=$_SESSION['csrf']['token']){
						echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
					}
				    elseif($_POST['type'] == "" || $_POST['account'] == "" || $_POST['email'] == "" || $_POST['name'] == "" || $_POST['permission'] == ""){
						echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
					}
					elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
				      	echo json_encode(['status'=>'error','content'=>$lang['email-khong-dung'],'sound'=>$setting['site_sound']]);
				    }
					elseif($_POST['email'] == $checkemail['email']){
						echo json_encode(['status'=>'error','content'=>$lang['email-co-nguoi-su-dung'],'sound'=>$setting['site_sound']]);
					}
					elseif(!preg_match($partten ,$_POST['account'])){
						echo json_encode(['status'=>'error','content'=>$lang['tai-khoan-khong-hop-le'],'sound'=>$setting['site_sound']]);
					}
					elseif($jatbi->checkaccount($_POST['account']) == $checkaccount['account']){
						echo json_encode(['status'=>'error','content'=>$lang['tai-khoan-co-nguoi-su-dung'],'sound'=>$setting['site_sound']]);
					}
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
				    if ($handle->processed && $_POST['name'] && $_POST['type'] && $_POST['email']  && $_POST['permission'] && $_POST['email'] != $checkemail['email'] && $jatbi->checkaccount($_POST['account']) != $checkaccount['account'] && preg_match($partten ,$_POST['account']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
				    	$insert = [
				    		"main" 			=> $xss->xss($_POST['main']),
							"name" 			=> $xss->xss($_POST['name']),
							"email" 		=> $xss->xss($_POST['email']),
							"account" 		=> $xss->xss($jatbi->checkaccount($_POST['account'])),
							"phone" 		=> $xss->xss($_POST['phone']),
							"password" 		=> ($_POST['password']==''?$data['password']:password_hash($xss->xss($_POST['password']), PASSWORD_DEFAULT)),
							"permission" 	=> $xss->xss($_POST['permission']),
							"data" 			=> $xss->xss($_POST['data']),
							"type" 			=> $xss->xss($_POST['type']),
							"avatar"		=> $handle->file_dst_name==''?$data['avatar']:$handle->file_dst_name,
							"birthday"		=> date('Y-m-d',strtotime(str_replace('/','-',$_POST['birthday']))),
							"gender"		=> $xss->xss($_POST['gender']),
							"date" 			=> date('Y-m-d H:i:s'),
							"status" 		=> $xss->xss($_POST['status']),
							"school"        =>$school_id,
						];
						$database->update("accounts",$insert,["id"=>$data['id']]);
						$jatbi->logs('accounts','edit',$insert);
						echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
			        }
				} else {
					$templates = $setting['site_backend'].'users.tpl';
				}
			}
			else {
				header("HTTP/1.0 404 Not Found");
				die();
			}
		}
	}
	elseif($router['1']=='accounts-change'){
		$ajax = 'true';
		$data = $database->get("accounts", "*",["id"=>$account['id']]);
		if($data>1){
			if(isset($_POST['token'])){
			    $handle = new Upload($_FILES['avatar']);
				if($_POST['token']!=$_SESSION['csrf']['token']){
					echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
				}
			    elseif($_POST['name'] == ""){
					echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
				}
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
			    if ($handle->processed && $_POST['name']) {
			    	$insert = [
						"name" 			=> $xss->xss($_POST['name']),
						"phone" 		=> $xss->xss($_POST['phone']),
						"password" 		=> ($_POST['password']==''?$data['password']:password_hash($xss->xss($_POST['password']), PASSWORD_DEFAULT)),
						"avatar"		=> $handle->file_dst_name==''?$data['avatar']:$handle->file_dst_name,
						"birthday"		=> date('Y-m-d',strtotime(str_replace('/','-',$_POST['birthday']))),
						"gender"		=> $xss->xss($_POST['gender']),
						"date" 			=> date('Y-m-d H:i:s'),
					];
					$database->update("accounts",$insert,["id"=>$data['id']]);
					$jatbi->logs('accounts','edit',$insert);
					$jatbi->notification($account['id'],$account['id'],'','Sửa tài khoản','Sửa tài khoản thành công','/users/accounts/','','accounts');
					echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
		        }
			} else {
				$templates = $setting['site_backend'].'users.tpl';
			}
		}
		else {
			header("HTTP/1.0 404 Not Found");
			die();
		}
	}
	elseif($router['1']=='accounts-status'){
		$jatbi->permission('accounts.edit');
		$ajax = 'true';
		if($router['2']){
			$data = $database->get("accounts", "*",["id"=>$xss->xss($router['2'])]);
			if($data>1){
				if($data['status']==='A'){
					$status = "D";
				} 
				elseif($data['status']==='D'){
					$status = "A";
				}
				$database->update("accounts",["status"=>$status],["id"=>$data['id']]);
				$jatbi->logs('accounts','status',["data"=>$data,"status"=>$status]);
				echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-trang-thai'],'sound'=>$setting['site_sound']]);
			}
			else {
				echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-that-bai'],]);
			}
		}
	}
	elseif($router['1']=='accounts-delete'){
		$jatbi->permission('accounts.delete');
		$ajax = 'true';
		if($router['2']){
			$datas = $database->select("accounts","*",["id"=>explode(',', $xss->xss($router['2']))]);
			if(isset($_POST['submit'])){
				$jatbi->logs('accounts','delete',$datas);
				$database->update("accounts",["deleted"	=> 1,],["id"=>explode(',', $xss->xss($router['2']))]);
				echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
			} else {
				$templates = $setting['site_backend'].'users.tpl';
			}
		}
		else {
			header("HTTP/1.0 404 Not Found");
			die();
		}
	}
	elseif($router['1']=='permission'){
		$jatbi->permission('permission');
		$count = $database->count("permission",[
			'AND' => [
				'name[~]'  		=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']), 
				'status' 		=> ($xss->xss($_GET['status'])=='')?[A,D]:$xss->xss($_GET['status']),
				"deleted"		=> 0,
				"school"        =>$school_id,
			]]
		);
		$pg = $_GET['pg'];
		if (!$pg) $pg = 1;
		$datas = $database->select("permission", "*",[
			"AND" => [
				'name[~]'  		=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']), 
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
		$templates = $setting['site_backend'].'users.tpl';
	}
	elseif($router['1']=='permission-add'){
		$jatbi->permission('permission.add');
		$ajax = 'true';
		if(isset($_POST['token'])){
			if($_POST['name'] == ""){
				echo json_encode(['status'=>'error','content'=>$lang['loi-trong']]);
			}
			if ($_POST['name']){
				$insert = [
					"name" 			=> $xss->xss($_POST['name']),
					"level" 		=> $xss->xss($_POST['level']),
					"status" 		=> $xss->xss($_POST['status']),
					"group" 		=> $_POST['group'],
					"school"        =>$school_id,
				];
				$database->insert("permission",$insert);
				$jatbi->logs('permission','add',$insert);
				echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
			}
		} else {
			$templates = $setting['site_backend'].'users.tpl';
		}
	}
	elseif($router['1']=='permission-edit'){
		$jatbi->permission('permission.edit');
		$ajax = 'true';
		if($router['2']){
			$data = $database->get("permission", "*",["id"=>$xss->xss($router['2'])]);
			if($data>1){
				if(isset($_POST['token'])){
					if($_POST['name'] == ""){
						echo json_encode(['status'=>'error','content'=>$lang['loi-trong']]);
					}
					if ($_POST['name']){
						$insert = [
							"name" 			=> $xss->xss($_POST['name']),
							"level" 		=> $xss->xss($_POST['level']),
							"status" 		=> $xss->xss($_POST['status']),
							"group" 		=> $_POST['group'],
							"school"        =>$school_id,
						];
						$database->update("permission",$insert,["id"=>$data['id']]);
						$jatbi->logs('permission','add',$insert);
						echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
					}
				} else {
					$vgroup = unserialize($data['group']);
					$templates = $setting['site_backend'].'users.tpl';
				}
			}
			else {
				header("HTTP/1.0 404 Not Found");
				die();
			}
		}
	}
	elseif($router['1']=='permission-status'){
		$jatbi->permission('permission.edit');
		$ajax = 'true';
		if($router['2']){
			$data = $database->get("permission", "*",["id"=>$xss->xss($router['2'])]);
			if($data>1){
				if($data['status']==='A'){
					$status = "D";
				} 
				elseif($data['status']==='D'){
					$status = "A";
				}
				$database->update("permission",["status"=>$status],["id"=>$data['id']]);
				$jatbi->logs('permission','status',["data"=>$data,"status"=>$status]);
				echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-trang-thai'],'sound'=>$setting['site_sound']]);
			}
			else {
				echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-that-bai'],]);
			}
		}
	}
	elseif($router['1']=='permission-delete'){
		$jatbi->permission('permission.delete');
		$ajax = 'true';
		if($router['2']){
			$datas = $database->select("permission","*",["id"=>explode(',', $xss->xss($router['2']))]);
			if(isset($_POST['submit'])){
				$jatbi->logs('permission','delete',$datas);
				$database->update("permission",["deleted"	=> 1,],["id"=>explode(',', $xss->xss($router['2']))]);
				echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
			} else {
				$templates = $setting['site_backend'].'users.tpl';
			}
		}
		else {
			header("HTTP/1.0 404 Not Found");
			die();
		}
	}
	elseif($router['1']=='my-accounts'){
		$data = $database->get("personnels", "*",["id"=>$account['data']]);
		if($data>1){
			$contracts = $database->select("personnels_contract","*",["personnels"=>$data['id'],"deleted"=>0]);
			$insurrances = $database->select("personnels_insurrance","*",["personnels"=>$data['id'],"deleted"=>0]);
			$date = explode('-',$xss->xss($_GET['date']));
			$date_from = ($_GET['date']=='')?date('2021-01-01 00:00:00'):date('Y-m-d',strtotime(str_replace('/','-',$date[0]))).' 00:00:00';
			$date_to = ($_GET['date']=='')?date('Y-m-d 23:59:59'):date('Y-m-d',strtotime(str_replace('/','-',$date[1]))).' 23:59:59';
			$count = $database->count("webhook",[
				'AND' => [
					"personnels"	=>$data['id'],
					"date_face[<>]" => [$date_from,$date_to],
					"deleted"		=> 0,
				]]
			);
			$pg = $_GET['pg'];
			if (!$pg) $pg = 1;
			$webhooks = $database->select("webhook", "*",[
				"AND" => [
					"personnels"	=> $data['id'],
					"date_face[<>]" => [$date_from,$date_to],
					"deleted"		=> 0,
				],
				"LIMIT" =>[(($pg-1)*$setting['site_page']),$setting['site_page']],
				"ORDER"	=> [
					"id"=>"DESC",
				]
			]);
			$page = $jatbi->pages($count,$setting['site_page'],$pg);
			$furlough_count = $database->count("furlough",[
				'AND' => [
					'personnels'	=> $data['id'],
					'type[<>]'		=> ($xss->xss($_GET['type'])=='')?:[$xss->xss($_GET['type']),$xss->xss($_GET['type'])], 
					'status' 		=> ($xss->xss($_GET['status'])=='')?[A,D]:$xss->xss($_GET['status']),
					"deleted"		=> 0,
				]]
			);
			$furlough_datas = $database->select("furlough", "*",[
				"AND" => [
					'personnels'	=> $data['id'], 
					'type[<>]'		=> ($xss->xss($_GET['type'])=='')?:[$xss->xss($_GET['type']),$xss->xss($_GET['type'])],  
					'status' 		=> ($xss->xss($_GET['status'])=='')?[A,D]:$xss->xss($_GET['status']), 
					"deleted"		=> 0,
				],
				"LIMIT" =>[(($pg-1)*$setting['site_page']),$setting['site_page']],
				"ORDER"	=> [
					"id"=>"DESC",
				]
			]);
			$furlough_page = $jatbi->pages($furlough_count,$setting['site_page'],$pg);
			$reward_count = $database->count("reward_discipline",[
				'AND' => [
					'content[~]'  		=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']), 
					'personnels'	=> $data['id'], 
					'type[<>]'=> ($xss->xss($_GET['type'])=='')?:[$xss->xss($_GET['type']),$xss->xss($_GET['type'])], 
					"deleted"		=> 0,
				]]
			);
			$reward_datas = $database->select("reward_discipline", "*",[
				"AND" => [
					'content[~]'  		=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']), 
					'personnels'	=> $data['id'], 
					'type[<>]'=> ($xss->xss($_GET['type'])=='')?:[$xss->xss($_GET['type']),$xss->xss($_GET['type'])], 
					"deleted"		=> 0,
				],
				"LIMIT" =>[(($pg-1)*$setting['site_page']),$setting['site_page']],
				"ORDER"	=> [
					"id"=>"DESC",
				]
			]);
			$reward_page = $jatbi->pages($reward_count,$setting['site_page'],$pg);
			$templates = $setting['site_backend'].'users.tpl';
		}
		else {
			header("HTTP/1.0 404 Not Found");
			die();
		}
	}
	elseif($router['1']=='org-chart'){
		$jatbi->permission('org-chart');
		$datas = $database->select("org_chart", ["id","main"],["deleted"=>0]);
		$first = $database->get("org_chart", "*",["main"=>0,"deleted"=>0]);
		if(count($datas)==0){
			$database->insert("org_chart",[
				"main" => 0,
				"name" => '',
				"offices" => '',
				"position" => 1,
			]);
		}
		$templates = $setting['site_backend'].'users.tpl';
	}
	elseif($router['1']=='org-chart-add'){
		$jatbi->permission('org-chart.add');
		$ajax = 'true';
		if($router['2']){
			$data = $database->get("org_chart","*",["id"=>$router['2'],"deleted"=>0]);
			if($data>1){
				$database->insert("org_chart",[
					"main" => $data['id'],
					"name" => $lang['tieu-de'],
					"offices" => '',
					"position" => 1,
				]);
				echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
			}
			else {
				echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-thanh-cong']]);
			}
		}
	}
	elseif($router['1']=='org-chart-name'){
		$jatbi->permission('org-chart.add');
		$ajax = 'true';
		if($router['2']){
			$data = $database->get("org_chart","*",["id"=>$router['2'],"deleted"=>0]);
			if($data>1){
				$database->update("org_chart",[
					"name" => $xss->xss($_POST['value']),
				],["id"=>$data['id']]);
				echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
			}
			else {
				echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-thanh-cong']]);
			}
		}
	}
	elseif($router['1']=='org-chart-delete'){
		$jatbi->permission('org-chart.delete');
		$ajax = 'true';
		if($router['2']){
			$data = $database->get("org_chart","*",["id"=>$router['2'],"deleted"=>0]);
			if($data>1){
				$database->update("org_chart",["deleted"=>1],["id"=>$data['id']]);
				$database->update("org_chart",["deleted"=>1],["main"=>$data['id']]);
				echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
			}
			else {
				echo json_encode(['error'=>'error','content'=>$lang['loi-trong']]);
			}
		}
	}
	elseif($router['1']=='org-chart-user'){
		$jatbi->permission('org-chart.add');
		$ajax = 'true';
		if($router['2']){
			$data = $database->get("org_chart","*",["id"=>$router['2'],"deleted"=>0]);
			if($data>1){
				if(isset($_POST['token'])){
					if($_POST['user'] == ""){
						echo json_encode(['status'=>'error','content'=>$lang['loi-trong']]);
					}
					if ($_POST['user']){
						$Getdetails = $database->get("org_chart_details","*",["user"=>$_POST['user'],"deleted"=>0]);
						if($Getdetails>1){
							$database->update("org_chart_details",["deleted"=>1],["id"=>$Getdetails['id']]);
						}
						$insert = [
							"org_chart"		=> $data['id'],
							"org_chart_main"=> $data['main'],
							"user" 			=> $xss->xss($_POST['user']),
							"type" 			=> $xss->xss($router['3']),
							"notes" 		=> $xss->xss($_POST['notes']),
						];
						$database->insert("org_chart_details",$insert);
						// $SelectDetails = $database->select("org_chart_details","*",["org_chart"=>$data['id'],"type"=>$router['3'],"deleted"=>0]);
						// foreach ($SelectDetails as $key => $value) {
						// 	$datas[$value['user']] = $value['user'];
						// }
						// if($router['3']=='manager'){
						// 	$database->update("org_chart",["managers"=>$datas],["id"=>$data['id']]);
						// }
						// if($router['3']=='personnels'){
						// 	$database->update("org_chart",["personnels"=>$datas],["id"=>$data['id']]);
						// }
						$jatbi->logs('org-chart-details','add',$insert);
						echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
					}
				} else {
					$templates = $setting['site_backend'].'users.tpl';
				}
			}
			else {
				echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-thanh-cong']]);
			}
		}
	}
	elseif($router['1']=='org-chart-user-delete'){
		$jatbi->permission('org-chart.delete');
		$ajax = 'true';
		if($router['2']){
			$data = $database->get("org_chart_details","*",["id"=>$router['2'],"deleted"=>0]);
			if($data>1){
				$database->update("org_chart_details",["deleted"=>1],["id"=>$data['id']]);
				echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
			}
			else {
				echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-thanh-cong']]);
			}
		}
	}

?>