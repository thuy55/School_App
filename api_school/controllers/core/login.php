<?php
if (!defined('JATBI')) die("Hacking attempt");
	use \Firebase\JWT\JWT;
	$getflood = $database->select("flood","*",["AND"=>["url"=>$_SERVER['SERVER_NAME'],"ip"=>$xss->xss($_SERVER['REMOTE_ADDR'])]]);
	$getdateflood = $database->get("flood","date",["AND"=>["url"=>$_SERVER['SERVER_NAME'],"ip"=>$xss->xss($_SERVER['REMOTE_ADDR'])],"ORDER"=>["id"=>"DESC"]]);
	if(count($getflood)==5 && strtotime(date("Y-m-d H:i:s", strtotime($getdateflood))." + 30 minute")>=strtotime(date('Y-m-d H:i:s'))){
		$date = strtotime(date("Y-m-d H:i:s", strtotime($getdateflood))." + 30 minute");
		$lock = 'true';
		$lock_content = 'Bạn bị khóa trong 30 phút. Vui lòng liên hệ quản trị viên để được hỗ trợ';
	}
	elseif(count($getflood)==10 && strtotime(date("Y-m-d H:i:s", strtotime($getdateflood))." + 2 hour")>=strtotime(date('Y-m-d H:i:s'))){
		$date = strtotime(date("Y-m-d H:i:s", strtotime($getdateflood))." + 2 hour");
		$lock = 'true';
		$lock_content = 'Bạn bị khóa trong 2 giờ. Vui lòng liên hệ quản trị viên để được hỗ trợ';
	}
	elseif(count($getflood)==15 && strtotime(date("Y-m-d H:i:s", strtotime($getdateflood))." + 24 hour")>=strtotime(date('Y-m-d H:i:s'))){
		$date = strtotime(date("Y-m-d H:i:s", strtotime($getdateflood))." + 24 hour");
		$lock = 'true';
		$lock_content = 'Bạn bị khóa IP trong 24 giờ. Vui lòng liên hệ quản trị viên để được hỗ trợ';
	}
	elseif(count($getflood)>=20 && strtotime(date("Y-m-d H:i:s", strtotime($getdateflood))." + 3600 hour")>=strtotime(date('Y-m-d H:i:s'))){
		$date = strtotime(date("Y-m-d H:i:s", strtotime($getdateflood))." + 3600 hour");
		$lock = 'true';
		$lock_content = 'Bạn bị khóa IP trong 3600 giờ. Vui lòng liên hệ quản trị viên để được hỗ trợ';
	}
	if($router['0']=='login'){
		// $get_csrf_token = JWT::decode($_SESSION['csrf']['token'], $setting['secret-key'], array('HS256'));
		// $decoded_csrf_token = (array) $get_csrf_token;
		// if($_SESSION['csrf']['key']==$decoded_csrf_token['key'] && $_SERVER['REMOTE_ADDR']==$decoded_csrf_token['ip']) {
			if($date<=strtotime(date("Y-m-d H:i:s"))){
				$login = $database->get("accounts", '*',[
					"AND" => [
						"OR"=>[
							"email" 	=> $xss->xss($_POST['account']),
							"account"	=> $xss->xss($_POST['account']),
						],
						"status" 	=> 'A',
						"deleted"	=> 0,
					]
				]);
				if($login>1){
					if (password_verify($xss->xss($_POST['password']), $login['password'])) {
						$gettoken = $jatbi->random(256);
						$payload = [
							"ip"		=> $xss->xss($_SERVER['REMOTE_ADDR']),
						    "id" 		=> $login['id'],
						    "account"  	=> $login['account'],
						    "token"  	=> $gettoken,
						    "agent" 	=> $_SERVER["HTTP_USER_AGENT"],
						];
						$token = JWT::encode($payload, $setting['secret-key']);
						$getLogins = $database->get("accounts_login","*",[
							"accounts" 	=> $payload['id'],
							"agent"		=> $payload['agent'],
							"deleted"	=> 0,
						]);
						if($getLogins>1){
							$database->update("accounts_login",[
								"accounts" => $login['id'],
								"ip" 	=> 	$payload['ip'],
								"token"	=>	$payload['token'],
								"agent" =>  $payload["agent"],
								"date"	=> date("Y-m-d H:i:s"),
							],["id"=>$getLogins['id']]);
						}
						else {
							$database->insert("accounts_login",[
								"accounts" => $login['id'],
								"ip" 	=> 	$payload['ip'],
								"token"	=>	$payload['token'],
								"agent" =>  $payload["agent"],
								"date"	=> date("Y-m-d H:i:s"),
							]);
						}
						$_SESSION['accounts'] = [
							"id" => $login['id'],
							"agent" => $payload['agent'],
							"token" => $payload['token'],
						];
						setcookie ('token',$token, time()+$setting['cookie_time'],'/');
						$jatbi->logs('accounts','login',[
							'user'	   	=> $xss->xss($_POST['account']),
							'token'		=> $_SESSION['accounts'],
						]);
					    echo json_encode(['status'=>'success','content'=>$lang['dang-nhap-thanh-cong'],"test"=>$getaccountslogin,]);
					}
					else {
						$database->insert("flood",[
							"ip"		=>$xss->xss($_SERVER['REMOTE_ADDR']),
							"browsers"	=> $_SERVER["HTTP_USER_AGENT"],
							"url"		=> $_SERVER['SERVER_NAME'],
							"date" 		=> date('Y-m-d H:i:s'),
							"count"		=> 1,
							"content"	=> [
								"user"=>$xss->xss($_POST['account']),
								"pass"=>$xss->xss($_POST['password']),
								"token"=>$_SESSION['csrf'],
							],
						]);
						echo json_encode(['status'=>'error','content'=>$lang['tai-khoan-mat-khau-khong-dung']]);
					}
				}
				else {
					$database->insert("flood",[
						"ip"		=>$xss->xss($_SERVER['REMOTE_ADDR']),
						"browsers"	=> $_SERVER["HTTP_USER_AGENT"],
						"url"		=> $_SERVER['SERVER_NAME'],
						"date" 		=> date('Y-m-d H:i:s'),
						"count"		=> 1,
						"content"	=> [
							"user"=>$xss->xss($_POST['account']),
							"pass"=>$xss->xss($_POST['password']),
							"token"=>$_SESSION['csrf'],
						],
					]);
					echo json_encode(['status'=>'error','content'=>$lang['tai-khoan-mat-khau-khong-dung']]);
				}
			}
			else {
				echo json_encode(['status'=>'error','content'=>$lock_content]);
			}
		// }
		// else {
		// 	echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
		// }
	}
	else{
		include($setting['site_backend']."login.tpl");
	}
?>