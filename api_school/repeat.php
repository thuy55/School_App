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
	$getTasks = $database->select("task","*",["repeat[!]"=>0,"deleted"=>0,"repeat_task"=>0]);
	foreach ($getTasks as $key => $task) {
		$date_from = date("Y-m-d H:i:s",strtotime($task['date_from']));
		$date_to = date("Y-m-d H:i:s",strtotime($task['date_to']));
		$date_day = date("Y-m-d H:i:s",strtotime(date("Y-m-d 00:00:00", strtotime($date_from))."+1 day"));
		$date_week = date("Y-m-d H:i:s",strtotime(date("Y-m-d 00:00:00", strtotime($date_from))."+1 week"));
		$date_month = date("Y-m-d H:i:s",strtotime(date("Y-m-d 00:00:00", strtotime($date_from))."+1 month"));
		$date_year = date("Y-m-d H:i:s",strtotime(date("Y-m-d 00:00:00", strtotime($date_from))."+1 year"));
		$date_thisweek = date("Y-m-d H:i:s",strtotime(date("Y-m-d 00:00:00", strtotime($date_from))."this week"));
		$date_lasweek = date("Y-m-d H:i:s",strtotime(date("Y-m-d 00:00:00", strtotime($date_from))."next week"));
		$getTaskAccounts = [];
		if($task['assign']=='0'){
			$getTaskAccounts[] = $task['user'];
			$getRatingsUser = $task['user'];
			$error_accounts = 0;
		}
		elseif($task['assign']=='1'){
			if($task['myself']==1){
				$getRatingsUser = $task['ratings_user'];
				$getTaskAccounts[] = $task['user'];
				$getTaskAccountsRating[] = $getRatingsUser;
			}
			else {
				$getRatingsUser = $task['user'];
				$getTaskAccounts = unserialize($task['accounts']);
			}
		}
		$SelectTodos = $database->select("todos","*",["task"=>$task['id'],"deleted"=>0,"repeat"=>1]);
		$auto_repeat = 'false';
		if($task['repeat']==1 && strtotime($date_day)==strtotime(date("Y-m-d 00:00:00"))){
			$date_from_clone = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s", strtotime($date_from))." +1 day"));
			$date_from_to = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s", strtotime($date_to))." +1 day"));
			$auto_repeat = 'true';
			$repeat_content = 'Ngày';
		}
		elseif($task['repeat']==2 && strtotime($date_week)==strtotime(date("Y-m-d 00:00:00"))){
			$date_from_clone = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s", strtotime($date_from))." +1 week"));
			$date_from_to = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s", strtotime($date_to))." +1 week"));
			$auto_repeat = 'true';
			$repeat_content = 'Week';
		}
		elseif($task['repeat']==3 && strtotime($date_month)==strtotime(date("Y-m-d 00:00:00"))){
			$date_from_clone = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s", strtotime($date_from))." +1 month"));
			$date_from_to = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s", strtotime($date_to))." +1 month"));
			$auto_repeat = 'true';
			$repeat_content = 'Tháng';
		}
		elseif($task['repeat']==4 && strtotime($date_year)==strtotime(date("Y-m-d 00:00:00"))){
			$date_from_clone = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s", strtotime($date_from))." +1 year"));
			$date_from_to = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s", strtotime($date_to))." +1 year"));
			$auto_repeat = 'true';
			$repeat_content = 'Năm';
		}
		elseif($task['repeat']==5){
			$getWeek = $jatbi->getDatesFromRange($date_thisweek,$date_lasweek);
			foreach ($getWeek as $key => $week) {
				$weekday = date("N",strtotime($week));
				if(strtotime($week)>strtotime($date_from)){
					$arrayWeek[$weekday] = [
						"week" => $weekday,
						"text" => date("l",strtotime($week)),
						"day" => $week,
					];
				}
			}
			foreach ($task['week'] as $key => $value) {
				if($value==$arrayWeek[$value]['week']){
					$date_from_week = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s", strtotime($date_from))." next ".$arrayWeek[$value]['text']));
					$date_to_week = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s", strtotime($date_to))." next ".$arrayWeek[$value]['text']));
					$DayWeek[] = [
						"date_from" => $date_from_week,
						"date_to" => $date_to_week,
					];
				}
			}
			sort($DayWeek);
			if(strtotime($DayWeek[0]['date_from'])==strtotime(date("Y-m-d 00:00:00"))){
				$date_from_clone = date("Y-m-d H:i:s",strtotime($DayWeek[0]['date_from']));
				$date_from_to = date("Y-m-d H:i:s",strtotime($DayWeek[0]['date_to']));
				$auto_repeat = 'true';
				$repeat_content = 'Các ngày trong tuần';
			}
		}
		elseif($task['repeat']==6){
			if($task['repeat_type']==1){
				$date_day_6 = date("Y-m-d H:i:s",strtotime(date("Y-m-d 00:00:00", strtotime($date_from))."+".$task['repeat_value']." day"));
			}
			elseif($task['repeat_type']==2){
				$date_week_6 = date("Y-m-d H:i:s",strtotime(date("Y-m-d 00:00:00", strtotime($date_from))."+".$task['repeat_value']." week"));
			}
			elseif($task['repeat_type']==3){
				$date_month_6 = date("Y-m-d H:i:s",strtotime(date("Y-m-d 00:00:00", strtotime($date_from))."+".$task['repeat_value']." month"));
			}
			elseif($task['repeat_type']==4){
				$date_year_6 = date("Y-m-d H:i:s",strtotime(date("Y-m-d 00:00:00", strtotime($date_from))."+".$task['repeat_value']." year"));
			}
			
			if($task['repeat_type']==1 && strtotime($date_day_6)==strtotime(date("Y-m-d 00:00:00"))){
				$date_from_clone = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s", strtotime($date_from))." +".$task['repeat_value']." day"));
				$date_from_to = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s", strtotime($date_to))." +".$task['repeat_value']." day"));
				$auto_repeat = 'true';
				$repeat_content = 'Ngày';
			}
			elseif($task['repeat_type']==2 && strtotime($date_week_6)==strtotime(date("Y-m-d 00:00:00"))){
				$date_from_clone = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s", strtotime($date_from))." +".$task['repeat_value']." week"));
				$date_from_to = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s", strtotime($date_to))." +".$task['repeat_value']." week"));
				$auto_repeat = 'true';
				$repeat_content = 'Week';
			}
			elseif($task['repeat_type']==3 && strtotime($date_month_6)==strtotime(date("Y-m-d 00:00:00"))){
				$date_from_clone = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s", strtotime($date_from))." +".$task['repeat_value']." month"));
				$date_from_to = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s", strtotime($date_to))." +".$task['repeat_value']." month"));
				$auto_repeat = 'true';
				$repeat_content = 'Tháng';
			}
			elseif($task['repeat_type']==4 && strtotime($date_year_6)==strtotime(date("Y-m-d 00:00:00"))){
				$date_from_clone = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s", strtotime($date_from))." +".$task['repeat_value']." year"));
				$date_from_to = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s", strtotime($date_to))." +".$task['repeat_value']." year"));
				$auto_repeat = 'true';
				$repeat_content = 'Năm';
			}
		}
		if($auto_repeat=='true'){
			$clone = [
				"main"		=> $task['main'],
				"code"		=> strtotime(date("Y-m-d H:i:s")),
				"position"	=> $task['position'],
				"repeat"	=> $task['repeat'],
				"type" 		=> $task['type'],
				"projects" 	=> $task['projects'],
				"week" 		=> $task['week'],
				"name" 		=> $task['name'],
				"content" 	=> $task['content'],
				"date_from" => $date_from_clone,
				"date_to" 	=> $date_from_to,
				"date_end" 	=> $date_from_to,
				"views" 	=> $task['views'],
				"ratings_status" => $task['ratings_status'],
				"accounts" 	=> $getTaskAccounts,
				"date" 		=> date("Y-m-d H:i:s"),
				"user" 		=> $task['user'],
				"status" 	=> $database->get("process","id",["status"=>"A","data"=>"task","deleted"=>0,"ORDER"=>["position"=>"ASC"]]),
				"assign"	=> $task['assign'],
				"ratings_user" => $getRatingsUser,
				"myself"	=> $task['myself'],
				"task_description" => $task['task_description'],
				"main_sub"	=> $task['main_sub'],
			];
			$database->insert("task",$clone);
			$getTaskID = $database->id();
			$reminds = $database->select("task_remind","*",["task"=>$task['id'],"deleted"=>0]);
			foreach ($reminds as $key => $remind_value) {
				if($remind_value['type']==1){
					$remind_date = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s", strtotime($clone['date_end']))."-".$remind_value['value']." minute"));
				}
				elseif($remind_value['type']==2){
					$remind_date = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s", strtotime($clone['date_end']))."-".$remind_value['value']." hour"));
				}
				elseif($remind_value['type']==3){
					$remind_date = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s", strtotime($clone['date_end']))."-".$remind_value['value']." day"));
				}
				elseif($remind_value['type']==4){
					$remind_date = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s", strtotime($clone['date_end']))."-".$remind_value['value']." week"));
				}
				$remind = [
					"task" => $getTaskID,
					"date" => $remind_date,
					"value" => $remind_value['value'],
					"type" => $remind_value['type'],
				];
				$database->insert("task_remind",$remind);
			}
			foreach ($SelectTodos as $key => $todo) {
				$todos = [
					"task"		=> $getTaskID,
					"position" 	=> $todo['position'],
					"content" 	=> $todo['content'],
					"date_from" => date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s", strtotime($todo['date_from']))." +1 day")),
					"date_to" 	=> date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s", strtotime($todo['date_to']))." +1 day")),
					"date" 		=> date("Y-m-d H:i:s"),
					"user" 		=> $todo['user'],
					"status"	=> 1,
				];
				$database->insert("todos",$todos);
			}
			$task_add = [
				"type"		=> 0,
				"task" 		=> $getTaskID,
				"accounts"	=> $clone['user'],
				"date" 		=> date("Y-m-d H:i:s"),
			];
			$database->insert("task_accounts",$task_add);
			foreach ($getTaskAccounts as $task_account) {
				$task_accounts = [
					"type"		=> 1,
					"task" 		=> $getTaskID,
					"accounts"	=> $task_account,
					"date" 		=> date("Y-m-d H:i:s"),
				];
				$database->insert("task_accounts",$task_accounts);
				// if($task_account!=$clone['user']){
					$jatbi->notification($clone['user'],$task_account,'','Lặp công việc mới',' Đã lặp lại cho bạn một công việc mới #'.$clone['code'],'/works/tasks-views/'.$getTaskID.'/','','task',$getTaskID);
				// }
			}
			foreach (unserialize($clone['views']) as $task_view) {
				$task_views = [
					"type"		=> 2,
					"task" 		=> $getTaskID,
					"accounts"	=> $task_view,
					"date" 		=> date("Y-m-d H:i:s"),
				];
				$database->insert("task_accounts",$task_views);
				if($task_view!=$clone['user']){
					$jatbi->notification($clone['user'],$task_view,'','Theo dõi công việc','Đã lặp lại yêu cầu bạn theo dõi công việc #'.$clone['code'],'/works/tasks-views/'.$getTaskID.'/','','task',$getTaskID);
				}
			}
			foreach($getTaskAccountsRating as $userRating){
				$task_rating = [
					"type"		=> 3,
					"task" 		=> $getTaskID,
					"accounts"	=> $userRating,
					"date" 		=> date("Y-m-d H:i:s"),
				];
				$database->insert("task_accounts",$task_rating);
				if($userRating!=$clone['user']){
					$jatbi->notification($clone['user'],$userRating,'','Theo dõi đánh gia công việc','Đã lặp lại yêu cầu bạn theo dõi đánh giá công việc #'.$clone['code'],'/works/tasks-views/'.$getTaskID.'/','','task',$getTaskID);
				}
			}
			$getAccountsTasks = $database->select("task_accounts","*",["task"=>$clone['main'],"deleted"=>0,"type"=>0]);
			foreach ($getAccountsTasks as $key => $getAccountsTask) {
				$task_accounts_main = [
					"type"		=> 4,
					"task" 		=> $getTaskID,
					"accounts"	=> $getAccountsTask['accounts'],
					"date" 		=> date("Y-m-d H:i:s"),
				];
				$database->insert("task_accounts",$task_accounts_main);
			}
			$database->insert("task_logs",[
				"name"		=> "Khởi tạo lặp lại công việc",
				"task"		=> $getTaskID,
				"accounts" 	=> $clone['user'],
				"date" 		=> date("Y-m-d H:i:s"),
				"user" 		=> $clone['user'],
				"status" 	=> 1,
				"content"	=> $clone,
			]);
			$database->update("task",["repeat_task"=>$getTaskID,"repeat_completed"=>date("Y-m-d H:i:s")],["id"=>$task['id']]);
			$jatbi->logs('task','add',$clone);
		}
	}
	// echo ($repeat_content);
?>