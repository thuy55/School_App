<?php
	define('JATBI', true);
	require_once 'controllers/includes/database.php';
	require_once 'controllers/includes/function.php';
	require_once 'controllers/includes/xss.php';
	$jatbi 	  = new jatbi;
	$xss 	  = new jatbi_xss;
	class Message{
		public $database;
		public $jatbi;
		public function update_online($active,$type){
			global $database;
			$getaccounts = $database->get("accounts","*",["active"=>$active]);
			if($getaccounts>1){
				if($type=='online'){
					$database->update("accounts",["online"=>1],["id"=>$getaccounts['id']]);
				}
				if($type=='offline'){
					$database->update("accounts",["online"=>0],["id"=>$getaccounts['id']]);
				}
			}
		}
		public function send($data){
			global $database,$jatbi;
			$insert = [
				"active" => $jatbi->active(31),
				"user_to" => $data['active'],
				"user_from" => $data['receiver'],
				"content" => $data['content'],
				"type" => $data['type'],
				"status" => 0,
				"date" => date("Y-m-d H:i:s"),
			];
			$database->insert("chat",$insert);
			$count = $database->count("chat","id",["user_from"=>$data['receiver'],"status"=>0,"deleted"=>0]);
			$active = $database->get("accounts","id",["active"=>$data['active']]);
			$receiver = $database->get("accounts","id",["active"=>$data['receiver']]);
			$jatbi->notification($active,$receiver,'','Tin nhắn mới','Bạn có một tin nhắn mới','','','chat');
			return $count>99?'99+':$count;
		}
		public function select($data){
			global $database;
			$database->update("chat",["status"=>1],["user_from"=>$data['active'],"deleted"=>0,"status"=>0]);
			$datas = $database->select("chat","*",[
				"OR #Actually, this comment feature can be used on every AND and OR relativity condition"=>[
					"AND #the first condition"=>[
						"user_to"=>$data['active'],
						"user_from"=>$data['receiver'],
					],
					"AND #the second condition"=>[
						"user_from"=>$data['active'],
						"user_to"=>$data['receiver'],
					],
				],
				"deleted"=>0,
			]);
			return $datas;
		}
		public function get_user($data){
			global $database;
			$getdata = $database->get("accounts","*",["active"=>$data['receiver']]);
			$count = $database->count("chat","id",["user_from"=>$data['active'],"user_to"=>$data['receiver'],"status"=>0,"deleted"=>0]);
			if($getdata['online']==0){
				$content = 'Đang ngoại tuyến';
				$type = 'offline';
			}
			if($getdata['online']==1){
				$content = 'Đang truy cập';
				$type = 'online';
			}
			$datas = [
				"name" => $getdata['name'],
				"avatar" => '/images/accounts/'.$getdata['avatar'],
				"status" => [
					"content" => $content,
					"type" => $type,
				],
				"count" => ($count>99?'99+':$count),
			];
			return $datas;
		}
	}
?>