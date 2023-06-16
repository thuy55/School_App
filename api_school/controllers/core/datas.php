<?php
	if (!defined('JATBI')) die("Hacking attempt");
	if($router['1']=='files'){
		$jatbi->permission('files');
		$date = explode('-',$xss->xss($_GET['date']));
		$date_from = ($_GET['date']=='')?date('Y-m-d 00:00:00',strtotime($setting['site_start'])):date('Y-m-d',strtotime(str_replace('/','-',$date[0]))).' 00:00:00';
		$date_to = ($_GET['date']=='')?date('Y-m-d 23:59:59'):date('Y-m-d',strtotime(str_replace('/','-',$date[1]))).' 23:59:59';
		$count = $database->count("datas",[
			'AND' => [
				'user'		=> $account['id'],
				'name[~]' 	=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
				"date[<>]" => [$date_from,$date_to],
				"deleted"		=> 0,
			]]
		);
		$pg = $_GET['pg'];
		if (!$pg) $pg = 1;
		$datas = $database->select("datas", "*",[
			"AND" => [
				'user'		=> $account['id'],
				'name[~]' 	=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
				"date[<>]" 		=> [$date_from,$date_to],
				"deleted"		=> 0,
			],
			"LIMIT" =>[(($pg-1)*$setting['site_page']),$setting['site_page']],
			"ORDER"	=> [
				"id"=>"DESC",
			]
		]);
		$page = $jatbi->pages($count,$setting['site_page'],$pg);
		$templates = $setting['site_backend'].'datas.tpl';
	}
	elseif($router['1']=='files-add'){
		$jatbi->permission('files.add');
		$ajax = 'true';
		if(isset($_POST['token'])){
			$handle = new Upload($_FILES['files'],"vn_VN");
			if($_POST['token']!=$_SESSION['csrf']['token']){
				echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
			}
			elseif($_POST['name']=="" && $_FILES['files']['name']==""){
				echo json_encode(['status'=>'error','content'=>$lang['loi-trong']]);
			}
			if ($handle->uploaded) {
		        $handle->allowed 		= array('application/*','image/*');
		        $handle->file_new_name_body = strtotime("Y-m-d H:i:s").$jatbi->active(32);
		        $handle->Process($upload['images']['datas']['url'].$account['active'].'/');
		    }
			if ($handle->processed && $_FILES['files']['name'] && $_POST['name']){
				$insert = [
					"code"		=> $handle->file_dst_name,
					"name"		=> $xss->xss($_POST['name']),
					"size"		=> $handle->file_src_size,
					"name_ext"	=> $handle->file_dst_name_ext,
					"file"		=> $handle->file_src_mime,
					"date" 		=> date("Y-m-d H:i:s"),
					"user" 		=> $account['id'],
				];
				if($router['2']=='task'){
					$gettask = $database->get("task","*",["id"=>$xss->xss($router['3']),"deleted"=>0]);
					$insert['type'] = "task";
					$insert['data'] = $gettask['id'];
					$database->insert("task_logs",[
						"name"		=> "Thêm dữ liệu",
						"task"		=> $gettask['id'],
						"accounts" 	=> $account['id'],
						"date" 		=> date("Y-m-d H:i:s"),
						"user" 		=> $account['id'],
						"status" 	=> $gettask['status'],
						"content"	=> $insert,
					]);
					$jatbi->logs('tasks-files','add',$insert);
				}
				elseif($router['2']=='projects'){
					$getprojects = $database->get("projects","*",["id"=>$xss->xss($router['3']),"deleted"=>0]);
					$insert['type'] = "projects";
					$insert['data'] = $getprojects['id'];
					$logs = [
						"projects" => $getprojects['id'],
						"type" => "files",
						"content" => "Thêm dữ liệu",
						"date" => date("Y-m-d H:i:s"),
						"user" => $account['id'],
						"status" => $getprojects['status'],
						"process" => $getprojects['process'],
						"logs" => $insert,
					];
					$database->insert("projects_logs",$logs);
					$jatbi->logs('projects-files','add',$insert);
				}
				elseif($router['2']=='programs'){
					$getprojects = $database->get("programs","*",["id"=>$xss->xss($router['3']),"deleted"=>0]);
					$insert['type'] = "programs";
					$insert['data'] = $getprojects['id'];
					$logs = [
						"programs" => $getprojects['id'],
						"type" => "files",
						"content" => "Thêm dữ liệu",
						"date" => date("Y-m-d H:i:s"),
						"user" => $account['id'],
						"process" => $getprojects['process'],
						"logs" => $insert,
					];
					$database->insert("programs_logs",$logs);
					$jatbi->logs('programs-files','add',$insert);
				}
				elseif($router['2']=='proposal'){
					$getproposal = $database->get("proposal","*",["id"=>$xss->xss($router['3']),"deleted"=>0]);
					$insert['type'] = "proposal";
					$insert['data'] = $getproposal['id'];
					$logs = [
						"proposal" => $getproposal['id'],
						"name" => "Thêm dữ liệu",
						"date" => date("Y-m-d H:i:s"),
						"user" => $account['id'],
						"process" => $getproposal['process'],
						"content" => $insert,
					];
					$database->insert("proposal_logs",$logs);
					$jatbi->logs('proposal-files','add',$insert);
				}
				else {
					$insert['type'] = 'data';
				}
				$database->insert("datas",$insert);
				$jatbi->logs('files','add',$insert);
				echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
			}
			else {
				echo json_encode(['status'=>'error','content'=>$handle->error,]);
			}
		} else {
			$templates = $setting['site_backend'].'datas.tpl';
		}
	}
	elseif($router['1']=='files-delete'){
		$jatbi->permission('files.delete');
		$ajax = 'true';
		if($router['2']){
			$datas = $database->select("datas","*",["id"=>explode(',', $xss->xss($router['2']))]);
			if(isset($_POST['submit'])){
				$jatbi->logs('files','delete',$datas);
				$database->update("datas",["deleted"=> 1,],["id"=>explode(',', $xss->xss($router['2']))]);
				echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
			} else {
				$templates = $setting['site_backend'].'datas.tpl';
			}
		}
		else {
			header("HTTP/1.0 404 Not Found");
			die();
		}
	}
	elseif($router['1']=='files-views'){
		$jatbi->permission('files');
		$ajax = 'true';
		if($router['2']){
			if($router['3']==''){
				$data = $database->get("datas","*",["id"=>$xss->xss($router['2']),"deleted"=>0]);
				$type = '';
			}
			if($router['3']=='social'){
				$data = $database->get("social_data","*",["id"=>$xss->xss($router['2']),"deleted"=>0]);
				$type = 'social';
			}
			if($data>1){
				$file = $jatbi->files_mine($data['id'],$type);
				$templates = $setting['site_backend'].'datas.tpl';
			}
			else {
				header("HTTP/1.0 404 Not Found");
				die();
			}
		}
		else {
			header("HTTP/1.0 404 Not Found");
			die();
		}
	}
	elseif($router['1']=='trash'){
		$jatbi->permission('trash');
		$date = explode('-',$xss->xss($_GET['date']));
		$date_from = ($_GET['date']=='')?date('Y-m-d 00:00:00',strtotime($setting['site_start'])):date('Y-m-d',strtotime(str_replace('/','-',$date[0]))).' 00:00:00';
		$date_to = ($_GET['date']=='')?date('Y-m-d 23:59:59'):date('Y-m-d',strtotime(str_replace('/','-',$date[1]))).' 23:59:59';
		$count = $database->count("datas",[
			'AND' => [
				'user'		=> $account['id'],
				'name[~]' 	=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
				"date[<>]" 	=> [$date_from,$date_to],
				"deleted"	=> 1,
			]]
		);
		$pg = $_GET['pg'];
		if (!$pg) $pg = 1;
		$datas = $database->select("datas", "*",[
			"AND" => [
				'user'		=> $account['id'],
				'name[~]' 	=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
				"date[<>]" 	=> [$date_from,$date_to],
				"deleted"	=> 1,
			],
			"LIMIT" =>[(($pg-1)*$setting['site_page']),$setting['site_page']],
			"ORDER"	=> [
				"id"=>"DESC",
			]
		]);
		$page = $jatbi->pages($count,$setting['site_page'],$pg);
		$templates = $setting['site_backend'].'datas.tpl';
	}
	elseif($router['1']=='trash-delete'){
		$jatbi->permission('trash.delete');
		$ajax = 'true';
		if($router['2']){
			$datas = $database->select("datas","*",["id"=>explode(',', $xss->xss($router['2']))]);
			if(isset($_POST['submit'])){
				$jatbi->logs('files','delete',$datas);
				foreach ($datas as $key => $data) {
					$getuser = $database->get("accounts","active",["id"=>$data['user']]);
					unlink($upload['images']['datas']['url'].$getuser.'/'.$data['code']);
					$database->delete("datas",["id"=>$data['id']]);
				}
				echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
			} else {
				$templates = $setting['site_backend'].'datas.tpl';
			}
		}
		else {
			header("HTTP/1.0 404 Not Found");
			die();
		}
	}
?>