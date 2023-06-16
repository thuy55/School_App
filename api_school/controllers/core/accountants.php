<?php
	if (!defined('JATBI')) die("Hacking attempt");
	$accounts = $database->select("accounts", "*",["deleted"=> 0,"status"=>'A']);
	$accountants_codes = $database->select("accountants_code", "*",["deleted"=> 0,"status"=>'A',"main"=>0]);
	$accountants = $database->select("accountants_code", "*",["deleted"=> 0,"status"=>'A']);
	$customers = $database->select("customers", "*",["deleted"=> 0,"status"=>'A',]);
	$projects = $database->select("projects", "*",["deleted"=> 0,]);
	$proposals = $database->select("proposal", "*",["deleted"=> 0,"status"=>[2,4,10]]);
	$personnels = $database->select("personnels", "*",["deleted"=> 0,"status"=>'A',]);
	$vendors = $database->select("vendors", "*",["deleted"=> 0,"status"=>'A',]);
	if($router['1']=='expenditure'){
		$jatbi->permission('expenditure');
		$date = explode('-',$xss->xss($_GET['date']));
		$date_from = ($_GET['date']=='')?date('Y-01-01'):date('Y-m-d',strtotime(str_replace('/','-',$date[0])));
		$date_to = ($_GET['date']=='')?date('Y-m-d'):date('Y-m-d',strtotime(str_replace('/','-',$date[1])));
		$count = $database->count("expenditure",[
			'AND' => [
				"OR"=>[
					'ballot[~]'  		=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
				],
				'type[<>]'		=> ($xss->xss($_GET['type'])=='')?'':[$xss->xss($_GET['type']),$xss->xss($_GET['type'])],
				'debt[<>]'		=> ($xss->xss($_GET['debt'])=='')?'':[$xss->xss($_GET['debt']),$xss->xss($_GET['debt'])],
				'has[<>]'		=> ($xss->xss($_GET['has'])=='')?'':[$xss->xss($_GET['has']),$xss->xss($_GET['has'])],
				'user[<>]'		=> ($xss->xss($_GET['user'])=='')?'':[$xss->xss($_GET['user']),$xss->xss($_GET['user'])],
				"date[<>]" 		=> [$date_from,$date_to],
				"deleted"		=> 0,
			]]
		);
		$pg = $_GET['pg'];
		if (!$pg) $pg = 1;
		$datas = $database->select("expenditure", "*",[
			"AND" => [
				"OR"=>[
					'ballot[~]'  		=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
				],
				'type[<>]'		=> ($xss->xss($_GET['type'])=='')?'':[$xss->xss($_GET['type']),$xss->xss($_GET['type'])],
				'debt[<>]'		=> ($xss->xss($_GET['debt'])=='')?'':[$xss->xss($_GET['debt']),$xss->xss($_GET['debt'])],
				'has[<>]'		=> ($xss->xss($_GET['has'])=='')?'':[$xss->xss($_GET['has']),$xss->xss($_GET['has'])],
				'user[<>]'		=> ($xss->xss($_GET['user'])=='')?'':[$xss->xss($_GET['user']),$xss->xss($_GET['user'])],
				"date[<>]" 		=> [$date_from,$date_to],
				"deleted"		=> 0,
			],
			"LIMIT" =>[(($pg-1)*$setting['site_page']),$setting['site_page']],
			"ORDER"	=> [
				"date"=>"ASC",
			]
		]);
		$total_first_thu = $database->sum("expenditure", "price",[
			"AND" => [
				"OR"=>[
					'ballot[~]'  		=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
				],
				'debt[<>]'		=> ($xss->xss($_GET['debt'])=='')?'':[$xss->xss($_GET['debt']),$xss->xss($_GET['debt'])],
				'has[<>]'		=> ($xss->xss($_GET['has'])=='')?'':[$xss->xss($_GET['has']),$xss->xss($_GET['has'])],
				'user[<>]'		=> ($xss->xss($_GET['user'])=='')?'':[$xss->xss($_GET['user']),$xss->xss($_GET['user'])],
				'type'			=> 1,
				"date[<]" 		=> $date_from,
				"deleted"		=> 0,
			],
			"ORDER"	=> [
				"date"=>"ASC",
			]
		]);
		$total_first_chi = $database->sum("expenditure", "price",[
			"AND" => [
				"OR"=>[
					'ballot[~]'  		=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
				],
				'debt[<>]'		=> ($xss->xss($_GET['debt'])=='')?'':[$xss->xss($_GET['debt']),$xss->xss($_GET['debt'])],
				'has[<>]'		=> ($xss->xss($_GET['has'])=='')?'':[$xss->xss($_GET['has']),$xss->xss($_GET['has'])],
				'user[<>]'		=> ($xss->xss($_GET['user'])=='')?'':[$xss->xss($_GET['user']),$xss->xss($_GET['user'])],
				'type'			=> 2,
				"date[<]" 		=> $date_from,
				"deleted"		=> 0,
			],
			"ORDER"	=> [
				"date"=>"ASC",
			]
		]);
		$total_last_thu = $database->sum("expenditure", "price",[
			"AND" => [
				"OR"=>[
					'ballot[~]'  		=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
				],
				'debt[<>]'		=> ($xss->xss($_GET['debt'])=='')?'':[$xss->xss($_GET['debt']),$xss->xss($_GET['debt'])],
				'has[<>]'		=> ($xss->xss($_GET['has'])=='')?'':[$xss->xss($_GET['has']),$xss->xss($_GET['has'])],
				'user[<>]'		=> ($xss->xss($_GET['user'])=='')?'':[$xss->xss($_GET['user']),$xss->xss($_GET['user'])],
				'type'			=> 1,
				"date[<=]" 		=> $date_to,
				"deleted"		=> 0,
			],
			"ORDER"	=> [
				"date"=>"ASC",
			]
		]);
		$total_last_chi = $database->sum("expenditure", "price",[
			"AND" => [
				"OR"=>[
					'ballot[~]'  		=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
				],
				'debt[<>]'		=> ($xss->xss($_GET['debt'])=='')?'':[$xss->xss($_GET['debt']),$xss->xss($_GET['debt'])],
				'has[<>]'		=> ($xss->xss($_GET['has'])=='')?'':[$xss->xss($_GET['has']),$xss->xss($_GET['has'])],
				'user[<>]'		=> ($xss->xss($_GET['user'])=='')?'':[$xss->xss($_GET['user']),$xss->xss($_GET['user'])],
				'type'			=> 2,
				"date[<=]" 		=> $date_to,
				"deleted"		=> 0,
			],
			"ORDER"	=> [
				"date"=>"ASC",
			]
		]);
		$page = $jatbi->pages($count,$setting['site_page'],$pg);
		$templates = $setting['site_backend'].'accountants.tpl';
	}
	elseif($router['1']=='expenditure-add'){
		$jatbi->permission('expenditure.add');
		$ajax = 'true';
		if(isset($_POST['token'])){
			if($_POST['token']!=$_SESSION['csrf']['token']){
				echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
			}
			elseif($_POST['type'] == "" || $_POST['debt'] == "" || $_POST['has'] == "" || $_POST['price'] == "" || $_POST['content'] == "" || $_POST['date'] == ""){
				echo json_encode(['status'=>'error','content'=>$lang['loi-trong']]);
			}
			if ($_POST['type'] && $_POST['debt'] && $_POST['has'] && $_POST['price'] && $_POST['content'] && $_POST['date']){
				if($xss->xss($_POST['type'])==1){
					$price = $xss->xss(str_replace([','],'',$_POST['price']));
				}
				if($xss->xss($_POST['type'])==2){
					$price = '-'.$xss->xss(str_replace([','],'',$_POST['price']));
				}
				$insert = [
					"type" 			=> $xss->xss($_POST['type']),
					"debt" 			=> $xss->xss($_POST['debt']),
					"has" 			=> $xss->xss($_POST['has']),
					"price" 		=> $price,
					"content" 		=> $xss->xss($_POST['content']),
					"date" 			=> $xss->xss($_POST['date']),
					"ballot" 		=> $xss->xss($_POST['ballot']),
					"projects" 		=> $xss->xss($_POST['projects']),
					"customers" 	=> $xss->xss($_POST['customers']),
					"personnels" 	=> $xss->xss($_POST['personnels']),
					"proposal" 		=> $xss->xss($_POST['proposal']),
					"vendor" 		=> $xss->xss($_POST['vendor']),
					"notes" 		=> $xss->xss($_POST['notes']),
					"user"			=> $account['id'],
					"date_poster"	=> date("Y-m-d H:i:s"),
				];
				$database->insert("expenditure",$insert);
				$GetID = $database->id();
				$jatbi->logs('expenditure','add',$insert);
				if($insert['proposal']!=''){
					$database->update("proposal",["expenditure"=>$GetID,"status"=>4],["id"=>$insert['proposal'],"status"=>2,"deleted"=>0]);
				}
				echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
			}
		} else {
			if($router['2']=='proposal'){
				$data = $database->get("proposal","*",["id"=>$router['3'],"status"=>2,"deleted"=>0]);
				$objects = $database->get("proposal_objects","*",["id"=>$data['objects'],"deleted"=>0]);
				$data['has'] = $objects['has'];
				$data['debt'] = $objects['debt'];
				$data['ballot'] = '#'.$ballot_code['proposal'].'-'.$data['code'];
				$data['proposal'] = $data['id'];
			}
			$templates = $setting['site_backend'].'accountants.tpl';
		}
	}
	elseif($router['1']=='expenditure-edit'){
		$jatbi->permission('expenditure.edit');
		$ajax = 'true';
		if($router['2']){
			$data = $database->get("expenditure", "*",["id"=>$xss->xss($router['2'])]);
			if($data>1){
				if(isset($_POST['token'])){
					if($_POST['token']!=$_SESSION['csrf']['token']){
						echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
					}
					elseif($_POST['type'] == "" || $_POST['debt'] == "" || $_POST['has'] == "" || $_POST['price'] == "" || $_POST['content'] == "" || $_POST['date'] == ""){
						echo json_encode(['status'=>'error','content'=>$lang['loi-trong']]);
					}
					if ($_POST['type'] && $_POST['debt'] && $_POST['has'] && $_POST['price'] && $_POST['content'] && $_POST['date']){
						if($xss->xss($_POST['type'])==1){
							$price = $xss->xss(str_replace([','],'',$_POST['price']));
						}
						if($xss->xss($_POST['type'])==2){
							$price = '-'.$xss->xss(str_replace([','],'',$_POST['price']));
						}
						$insert = [
							"type" 			=> $xss->xss($_POST['type']),
							"debt" 			=> $xss->xss($_POST['debt']),
							"has" 			=> $xss->xss($_POST['has']),
							"price" 		=> $price,
							"content" 		=> $xss->xss($_POST['content']),
							"date" 			=> $xss->xss($_POST['date']),
							"ballot" 		=> $xss->xss($_POST['ballot']),
							"projects" 		=> $xss->xss($_POST['projects']),
							"customers" 	=> $xss->xss($_POST['customers']),
							"personnels" 	=> $xss->xss($_POST['personnels']),
							"proposal" 		=> $xss->xss($_POST['proposal']),
							"vendor" 		=> $xss->xss($_POST['vendor']),
							"notes" 		=> $xss->xss($_POST['notes']),
							"user"			=> $account['id'],
							"date_poster"	=> date("Y-m-d H:i:s"),
						];
						$database->update("expenditure",$insert,["id"=>$data['id']]);
						$jatbi->logs('expenditure','edit',$insert);
						echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
					}
				} else {
					$vgroup = unserialize($data['group']);
					$templates = $setting['site_backend'].'accountants.tpl';
				}
			}
			else {
				header("HTTP/1.0 404 Not Found");
				die();
			}
		}
	}
	elseif($router['1']=='expenditure-delete'){
		$jatbi->permission('expenditure.delete');
		$ajax = 'true';
		if($router['2']){
			$datas = $database->select("expenditure","*",["id"=>explode(',', $xss->xss($router['2']))]);
			if(isset($_POST['submit'])){
				$jatbi->logs('expenditure','delete',$datas);
				$database->update("expenditure",["deleted"	=> 1,],["id"=>explode(',', $xss->xss($router['2']))]);
				echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
			} else {
				$templates = $setting['site_backend'].'accountants.tpl';
			}
		}
		else {
			header("HTTP/1.0 404 Not Found");
			die();
		}
	}
	elseif($router['1']=='expenditure-views'){
		$jatbi->permission('expenditure');
		$ajax = 'true';
		if($router['2']){
			$data = $database->get("expenditure", "*",["id"=>$xss->xss($router['2'])]);
			if($data>1){
				if($data['orders']!=0){ 
					$Getorders = $database->get("orders","*",["id"=>$data['orders'],"deleted"=>0]);
            	}
            	if($data['invoices']!=0){
            		$GetInvoices = $database->get("invoices","*",["id"=>$data['invoices'],"deleted"=>0]);
            	}
            	if($data['customers']!='' || $data['customers']!=0){
            		$GetCustomers = $database->get("customers","*",["id"=>$data['customers'],"deleted"=>0]);
            	}
            	if($data['personnels']!='' || $data['personnels']!=0){
            		$GetPersonnel = $database->get("personnels","*",["id"=>$data['personnels'],"deleted"=>0]);
            	}
            	if($data['purchase']!='' || $data['purchase']!=0){
            	}
            	if($data['vendor']!='' || $data['vendor']!=0){
            	}
				$templates = $setting['site_backend'].'accountants.tpl';
			}
			else {
				header("HTTP/1.0 404 Not Found");
				die();
			}
		}
	}
	elseif($router['1']=='accounts-code'){
		$jatbi->permission('accounts-code');
		$count = $database->count("accountants_code",[
			'AND' => [
				"OR"=>[
					'name[~]'  		=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
					'code[~]'  		=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
				],
				'status' 		=> ($xss->xss($_GET['status'])=='')?[A,D]:$xss->xss($_GET['status']),
				"deleted"		=> 0,
				"main"			=> 0,
			]]
		);
		$pg = $_GET['pg'];
		if (!$pg) $pg = 1;
		$datas = $database->select("accountants_code", "*",[
			"AND" => [
				"OR"=>[
					'name[~]'  		=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
					'code[~]'  		=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
				],
				'status' 		=> ($xss->xss($_GET['status'])=='')?[A,D]:$xss->xss($_GET['status']), 
				"deleted"		=> 0,
				"main"			=> 0,
			],
			"LIMIT" =>[(($pg-1)*$setting['site_page']),$setting['site_page']],
			"ORDER"	=> [
				"code"=>"ASC",
			]
		]);
		$page = $jatbi->pages($count,$setting['site_page'],$pg);
		$templates = $setting['site_backend'].'accountants.tpl';
	}
	elseif($router['1']=='accounts-code-add'){
		$jatbi->permission('accounts-code.add');
		$ajax = 'true';
		if(isset($_POST['token'])){
			if($_POST['token']!=$_SESSION['csrf']['token']){
				echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
			}
			elseif($_POST['name'] == "" || $_POST['main'] == "" || $_POST['code'] == ""){
				echo json_encode(['status'=>'error','content'=>$lang['loi-trong']]);
			}
			if ($_POST['name'] && $_POST['main'] && $_POST['code']){
				$insert = [
					"main" 			=> $xss->xss($_POST['main']),
					"name" 			=> $xss->xss($_POST['name']),
					"code" 			=> $xss->xss($_POST['code']),
					"notes" 		=> $xss->xss($_POST['notes']),
					"status" 		=> $xss->xss($_POST['status']),
				];
				$database->insert("accountants_code",$insert);
				$jatbi->logs('accounts-code','add',$insert);
				echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
			}
		} else {
			$templates = $setting['site_backend'].'accountants.tpl';
		}
	}
	elseif($router['1']=='accounts-code-edit'){
		$jatbi->permission('accounts-code.edit');
		$ajax = 'true';
		if($router['2']){
			$data = $database->get("accountants_code", "*",["id"=>$xss->xss($router['2'])]);
			if($data>1){
				if(isset($_POST['token'])){
					if($_POST['token']!=$_SESSION['csrf']['token']){
						echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
					}
					elseif($_POST['name'] == "" || $_POST['main'] == "" || $_POST['code'] == ""){
						echo json_encode(['status'=>'error','content'=>$lang['loi-trong']]);
					}
					if ($_POST['name'] && $_POST['main'] && $_POST['code']){
						$insert = [
							"main" 			=> $xss->xss($_POST['main']),
							"name" 			=> $xss->xss($_POST['name']),
							"code" 			=> $xss->xss($_POST['code']),
							"name" 			=> $xss->xss($_POST['name']),
							"notes" 		=> $xss->xss($_POST['notes']),
							"status" 		=> $xss->xss($_POST['status']),
						];
						$database->update("accountants_code",$insert,["id"=>$data['id']]);
						$jatbi->logs('accounts-code','edit',$insert);
						echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
					}
				} else {
					$vgroup = unserialize($data['group']);
					$templates = $setting['site_backend'].'accountants.tpl';
				}
			}
			else {
				header("HTTP/1.0 404 Not Found");
				die();
			}
		}
	}
	elseif($router['1']=='accounts-code-status'){
		$jatbi->permission('accounts-code.edit');
		$ajax = 'true';
		if($router['2']){
			$data = $database->get("accountants_code", "*",["id"=>$xss->xss($router['2'])]);
			if($data>1){
				if($data['status']==='A'){
					$status = "D";
				} 
				elseif($data['status']==='D'){
					$status = "A";
				}
				$database->update("accountants_code",["status"=>$status],["id"=>$data['id']]);
				$jatbi->logs('accounts-code','status',["data"=>$data,"status"=>$status]);
				echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-trang-thai'],'sound'=>$setting['site_sound']]);
			}
			else {
				echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-that-bai'],]);
			}
		}
	}
	elseif($router['1']=='accounts-code-delete'){
		$jatbi->permission('accounts-code.delete');
		$ajax = 'true';
		if($router['2']){
			$datas = $database->select("accountants_code","*",["id"=>explode(',', $xss->xss($router['2']))]);
			if(isset($_POST['submit'])){
				$jatbi->logs('accounts-code','delete',$datas);
				$database->update("accountants_code",["deleted"	=> 1,],["id"=>explode(',', $xss->xss($router['2']))]);
				echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
			} else {
				$templates = $setting['site_backend'].'accountants.tpl';
			}
		}
		else {
			header("HTTP/1.0 404 Not Found");
			die();
		}
	}
?>