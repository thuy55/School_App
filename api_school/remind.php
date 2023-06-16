<?php
	define('JATBI', true);
	ini_set('display_errors', 0);
	ini_set('display_startup_errors', 0);
	error_reporting(E_ALL);
	header("Content-Type: text/html; charset=utf8");
	date_default_timezone_set('Asia/Ho_Chi_Minh');
	ob_start();
	session_start();
	require_once 'controllers/includes/database.php';
	require_once 'controllers/includes/function.php';
	$jatbi 	  = new jatbi;
	$getTasks = $database->select("task","*",["completed"=>0,"deleted"=>0,]);
	foreach ($getTasks as $key => $task) {
		$reminds = $database->select("task_remind","*",["task"=>$task['id'],"deleted"=>0,"status"=>0,"ORDER"=>["type"=>"DESC","value"=>"DESC"]]);
		// echo print_r($reminds);
		foreach ($reminds as $key => $value) {
			if(strtotime($value['date'])<=strtotime(date("Y-m-d H:i:s"))){
				$getAccounts = $database->select("task_accounts","*",["task"=>$value['id'],"deleted"=>0]);
				$database->update("task_remind",["status"=>1],["id"=>$value['id']]);
				if($value['type']==1){
					$content = 'cảnh báo trước '.$value['value'].' Phút #'.$task['code'].' Vui lòng thực hiện';
				}
				elseif($value['type']==2){
					$content = 'cảnh báo trước '.$value['value'].' Giờ #'.$task['code'].' Vui lòng thực hiện';
				}
				elseif($value['type']==3){
					$content = 'cảnh báo trước '.$value['value'].' Ngày #'.$task['code'].' Vui lòng thực hiện';
				}
				elseif($value['type']==4){
					$content = 'cảnh báo trước '.$value['value'].' Tuần #'.$task['code'].' Vui lòng thực hiện';
				}
				else{
					$content = 'đã hết hạn #'.$task['code'].' vui lòng hoàn tất';
				}
				foreach ($getAccounts as $task_account) {
					$jatbi->notification($task['user'],$task_account['accounts'],'','Nhắc nhở công việc',' Bạn có một công việc '.$content,'/works/tasks-views/'.$task['id'].'/','','task',$task['id']);
				}
			}
		}
		// $saphethan = $database->count("task_remind","*",["task"=>$task['id'],"type"=>1]);
		// $dahethan = $database->count("task_remind","*",["task"=>$task['id'],"type"=>2]);
		// $date_end = date("Y-m-d H:i:s",strtotime($task['date_end']));
		// $date_remind = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s", strtotime($date_end))."-1 hour"));
		// if($saphethan==0 && strtotime($date_remind)<=strtotime(date("Y-m-d H:i:s"))){
		// 	$database->insert("task_remind",[
		// 		"task" => $task['id'],
		// 		"type" => 1,
		// 		"date" => date("Y-m-d H:i:s"),
		// 	]);
		// 	foreach (unserialize($task['accounts']) as $task_account) {
		// 		$jatbi->notification($task['user'],$task_account,'','Nhắc nhở công việc',' Bạn có một công việc sắp hết hạn #'.$task['code'].' vui lòng thực hiện','/works/tasks-views/'.$task['id'].'/','','task');
		// 	}
		// 	// $jatbi->notification($task['user'],$task['user'],'','Nhắc nhở công việc',' Bạn có một công việc sắp hết hạn #'.$task['code'].' vui lòng thực hiện','/works/tasks-views/'.$task['id'].'/','','task');
		// }
		// if($dahethan==0 && $saphethan>0 && strtotime($date_end)<=strtotime(date("Y-m-d H:i:s"))){
		// 	$database->insert("task_remind",[
		// 		"task" => $task['id'],
		// 		"type" => 2,
		// 		"date" => date("Y-m-d H:i:s"),
		// 	]);
		// 	foreach (unserialize($task['accounts']) as $task_account) {
		// 		$jatbi->notification($task['user'],$task_account,'','Nhắc nhở công việc',' Bạn có một công việc đã hết hạn #'.$task['code'].' vui lòng hoàn tất','/works/tasks-views/'.$task['id'].'/','','task');
		// 	}
		// }
	}
	// echo '<pre>'.print_r($test).'</pre>';
	// $database->insert("task_remind_cron",["date"=>date("Y-m-d H:i:s")]);
?>