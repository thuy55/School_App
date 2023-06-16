<?php
	if (!defined('JATBI')) die("Hacking attempt");
	$permissions = $database->select("permission", "*",["deleted"=> 0,"status"=>'A']);
	$personnels = $database->select("personnels", "*",["deleted"=> 0,"status"=>'A']);
	if($router['1']=='report-timecodes'){
		$jatbi->permission('report-timecodes');
		$date = explode('-',$xss->xss($_GET['date']));
		$date_from = ($_GET['date']=='')?date('Y-m-01',):date('Y-m-d',strtotime(str_replace('/','-',$date[0])));
		$date_to = ($_GET['date']=='')?date('Y-m-t'):date('Y-m-d',strtotime(str_replace('/','-',$date[1])));
		$count = $database->count("timecodes",[
			'AND' => [
				"OR"=>[
					'name[~]'  		=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
					'code[~]'  		=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
				],
				// 'customers[<>]'=> ($xss->xss($_GET['customers'])=='')?:[$xss->xss($_GET['customers']),$xss->xss($_GET['customers'])], 
				// 'status' 		=> ($xss->xss($_GET['status'])=='')?[A,D]:$xss->xss($_GET['status']),
				"deleted"		=> 0,
			]]
		);
		$pg = $_GET['pg'];
		if (!$pg) $pg = 1;
		$getdatas = $database->select("timecodes", "*",[
			"AND" => [
				"OR"=>[
					'name[~]'  		=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
					'code[~]'  		=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
				],
				// 'customers[<>]'=> ($xss->xss($_GET['customers'])=='')?:[$xss->xss($_GET['customers']),$xss->xss($_GET['customers'])], 
				// 'status' 		=> ($xss->xss($_GET['status'])=='')?[A,D]:$xss->xss($_GET['status']), 
				"deleted"		=> 0,
			],
			"LIMIT" =>[(($pg-1)*$setting['site_page']),$setting['site_page']],
			"ORDER"	=> [
				"code"=>"ASC",
			]
		]);
		if($router['2']==''){
			$status = 1;
		}
		elseif($router['2']=='plan'){
			$status = [0,2];
		}
		elseif($router['2']=='total'){
			$status = [0,1,2];
		}
		foreach ($getdatas as $key => $getdata) {
			$gettargets[$getdata['id']] = $database->select("projects_target","*",[
				"timecodes"=>$getdata['id'],
				"deleted"=>0,
				"date_from[<=]"=> $date_to,
				"status" => $status,
			]);
			foreach ($gettargets[$getdata['id']] as $key => $target) {
				$getcustomers = $database->get("customers","*",["id"=>$target['customers']]);
		    	$getprojects = $database->get("projects","*",["id"=>$target['projects']]);
		    	$gettimecode = $database->get("timecodes","*",["id"=>$target['timecodes']]);
		    	$targets[$getdata['id']][$target['id']] = [
					"id"=>$target['id'],
					"name"=>$target['name'],
					"customers" => $getcustomers['name'],
					"projects" => $getprojects['code'],
					"count" => $target['count'],
				];
				foreach ($jatbi->getDatesFromRange($date_from,$date_to) as $key => $value) {
					$getTargetTimecode[$target['id']] = $database->select("projects_timecodes","time",[
						"deleted"=>0,
						"date"=>$value,
						"target" => $target['id'],
					]);
					$getTargetTimecodeStatus[$target['id']] = $database->count("projects_timecodes","status",[
						"status" => 2,
						"deleted"=>0,
						"date"=>$value,
						"target" => $target['id'],
					]);
					$total_sum[$target['id']] += array_sum($getTargetTimecode[$target['id']]);
					$total_count[$target['id']] += count($getTargetTimecode[$target['id']]);
					$targets[$getdata['id']][$target['id']]['timecode'][$value] = [
						"sum" => array_sum($getTargetTimecode[$target['id']])>0?array_sum($getTargetTimecode[$target['id']]):'',
						"count" => count($getTargetTimecode[$target['id']])>0?count($getTargetTimecode[$target['id']]):'',
						"status"=> $getTargetTimecodeStatus[$target['id']]>0?'text-danger':'',
					];
				}
				$targets[$getdata['id']][$target['id']]['total_sum'] = $total_sum[$target['id']]>0?$total_sum[$target['id']]:'';
				$targets[$getdata['id']][$target['id']]['total_count'] = $total_count[$target['id']]>0?$total_count[$target['id']]:'';
			}
			if(count($gettargets)>0){
				$datas[$getdata['id']] = [
					"id" 		=> $getdata['id'],
					"name" 		=> $getdata['name'],
					"code" 		=> $getdata['code'],
					"type" 		=> $getdata['type'],
					"channels" 	=> $getdata['channels'],
					"vendor" 	=> $getdata['vendor'],
					"time_min" 	=> $getdata['time_min'],
					"time_max" 	=> $getdata['time_max'],
					"price_max" => $getdata['price_max'],
					"targets" 	=> $targets[$getdata['id']],
				];
			}
			
		}
		$page = $jatbi->pages($count,$setting['site_page'],$pg);
		$templates = $setting['site_backend'].'reports.tpl';
	}
?>