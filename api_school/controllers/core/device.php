<?php
	if (!defined('JATBI')) die("Hacking attempt");
	$school_id = $_SESSION['school'];
	$units = $database->select("units", "*",["deleted"=> 0,"status"=>'A',"school"=>$school_id]);
	$category_devices = $database->select("category_device", "*",["deleted"=> 0,"status"=>'A',"school"=>$school_id]);
	$suppliers = $database->select("supplier", "*",["deleted"=> 0,"status"=>'A',"school"=>$school_id]);
	$vendors = $database->select("supplier", "*",["deleted"=> 0,"status"=>'A',"school"=>$school_id]);
	$accountants = $database->select("accountants_code", "*",["deleted"=> 0,"status"=>'A']);
	$type_payments = $database->select("type_payments", "*",["type"=> 1,"deleted"=> 0,"main"=>0,"status"=>'A',"school"=>$school_id]);
	if($router['1']=='warehouse'){
		$jatbi->permission('warehouse');
		$count = $database->count("device",[
			'AND' => [
				"OR"=>[
					'name[~]'  		=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),  
				], 
				'category_device[<>]'	=> ($xss->xss($_GET['category_device'])=='')?:[$xss->xss($_GET['category_device']),$xss->xss($_GET['category_device'])], 
				'units[<>]'		=> ($xss->xss($_GET['units'])=='')?:[$xss->xss($_GET['units']),$xss->xss($_GET['units'])], 
				'supplier[<>]'		=> ($xss->xss($_GET['supplier'])=='')?:[$xss->xss($_GET['supplier']),$xss->xss($_GET['supplier'])], 
				'status' 		=> ($xss->xss($_GET['status'])=='')?[A,D]:$xss->xss($_GET['status']),
				"deleted"		=> 0,
				"type"			=> 1,
				'school'		=> ($xss->xss($_GET['school'])=='')?$school_id:[$xss->xss($_GET['school']),$xss->xss($_GET['school'])], 
			]
		]);
		$pg = $_GET['pg'];
		if (!$pg) $pg = 1;
		$datas = $database->select("device", "*",[
			'AND' => [
				"OR"=>[
					'name[~]'  		=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),  
				],				 
				'category_device[<>]'	=> ($xss->xss($_GET['category_device'])=='')?:[$xss->xss($_GET['category_device']),$xss->xss($_GET['category_device'])], 
				'units[<>]'		=> ($xss->xss($_GET['units'])=='')?:[$xss->xss($_GET['units']),$xss->xss($_GET['units'])],
				'supplier[<>]'		=> ($xss->xss($_GET['supplier'])=='')?:[$xss->xss($_GET['supplier']),$xss->xss($_GET['supplier'])],  
				'status' 		=> ($xss->xss($_GET['status'])=='')?[A,D]:$xss->xss($_GET['status']),
				"deleted"		=> 0,
				"type"			=> 1,
				'school'		=> ($xss->xss($_GET['school'])=='')?$school_id:[$xss->xss($_GET['school']),$xss->xss($_GET['school'])], 
			],
			"LIMIT" =>[(($pg-1)*$setting['site_page']),$setting['site_page']],
			"ORDER"	=> [
				"id"=>"DESC",
			]
		]);
		$page = $jatbi->pages($count,$setting['site_page'],$pg);
		$templates = $setting['site_backend'].'device.tpl';
	}
	elseif($router['1']=='warehouse-add'){
		$jatbi->permission('warehouse.add');
		$ajax = 'true';
		//$type = $router['2'];
		if(isset($_POST['token'])){
		    $handle = new Upload($_FILES['images']);
			if($_POST['token']!=$_SESSION['csrf-token']){
				echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
			}
		    elseif($_POST['name'] == "" || $_POST['category_device'] == "" || $_POST['units'] == "" || $_POST['supplier'] == "" || $_POST['status'] == ""){
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
		    if($handle->processed && $_POST['name'] && $_POST['category_device'] && $_POST['units'] && $_POST['supplier'] && $_POST['status']){
		    	$insert = [
					"type" 				=> 1,
					"name" 				=> $xss->xss($_POST['name']),
					"category_device" 	=> $xss->xss($_POST['category_device']),
					"units" 			=> $xss->xss($_POST['units']),
					"images"			=> $handle->file_dst_name==''?'no-images.jpg':$handle->file_dst_name,
					"date" 				=> date('Y-m-d'),
					"datetime" 			=> date('Y-m-d H:i:s'),
					"status" 			=> $xss->xss($_POST['status']),
					"supplier" 			=> $xss->xss($_POST['supplier']),
					"notes" 			=> $xss->xss($_POST['notes']),
					"account" 			=> $account['id'],
					"school"			=> $school_id,
				];
				$database->insert("device",$insert);
				echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
	        }
		} 
		else {
			$templates = $setting['site_backend'].'device.tpl';
		}
	}
	elseif($router['1']=='warehouse-edit'){
		$jatbi->permission('warehouse.edit');
		$ajax = 'true';
		if($router['2']){
			$data = $database->get("device", "*",["id"=>$xss->xss($router['2'])]);
			if($data>1){
				if(isset($_POST['token'])){
					$handle = new Upload($_FILES['images']);
					if($_POST['token']!=$_SESSION['csrf-token']){
						echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
					}
		    		elseif($_POST['name'] == "" || $_POST['category_device'] == "" || $_POST['units'] == "" || $_POST['supplier'] == "" || $_POST['status'] == ""){
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
		    		if($handle->processed && $_POST['name'] && $_POST['category_device'] && $_POST['units'] && $_POST['supplier'] && $_POST['status']){
				    	$insert = [
							"type" 				=> 1,
							"name" 				=> $xss->xss($_POST['name']),
							"category_device" 	=> $xss->xss($_POST['category_device']),
							"units" 			=> $xss->xss($_POST['units']),
							"images"			=> $handle->file_dst_name==''?$data['images']:$handle->file_dst_name,
							"date" 				=> date('Y-m-d'),
							"datetime" 			=> date('Y-m-d H:i:s'),
							"status" 			=> $xss->xss($_POST['status']),
							"supplier" 			=> $xss->xss($_POST['supplier']),
							"notes" 			=> $xss->xss($_POST['notes']),
							"account" 			=> $account['id'],
							"school"			=> $school_id,
						];
						$database->update("device",$insert,["id"=>$data['id']]);
						echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
			        }
				} else {
					$templates = $setting['site_backend'].'device.tpl';
				}
			}
			else {
				header("HTTP/1.0 404 Not Found");
				die();
			}
		}
	}
	elseif($router['1']=='warehouse-status'){
		$jatbi->permission('warehouse.edit');
		$ajax = 'true';
		if($router['2']){
			$data = $database->get("device", "*",["id"=>$xss->xss($router['2'])]);
			if($data>1){
				if($data['status']==='A'){
					$status = "D";
				} 
				elseif($data['status']==='D'){
					$status = "A";
				}
				$database->update("device",["status"=>$status],["id"=>$data['id']]);
				$jatbi->logs('device','status',["data"=>$data,"status"=>$status]);
				echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-trang-thai'],'sound'=>$setting['site_sound']]);
			}
			else {
				echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-that-bai'],]);
			}
		}
	}
	elseif($router['1']=='warehouse-delete'){
		$jatbi->permission('device.delete');
		$ajax = 'true';
		if($router['2']){
			$datas = $database->select("device","*",["id"=>explode(',', $xss->xss($router['2']))]);
			if(isset($_POST['submit'])){
				$jatbi->logs('device','delete',$datas);
				$database->update("device",["deleted"	=> 1,],["id"=>explode(',', $xss->xss($router['2']))]);
				echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
			} else {
				$templates = $setting['site_backend'].'device.tpl';
			}
		}
		else {
			header("HTTP/1.0 404 Not Found");
			die();
		}
	}
	elseif($router['1']=='units'){
		$jatbi->permission('units');
		$count = $database->count("units",[
			'AND' => [
				'name[~]'  		=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']), 
				'status' 		=> ($xss->xss($_GET['status'])=='')?[A,D]:$xss->xss($_GET['status']),
				"deleted"		=> 0,
				'school'		=> ($xss->xss($_GET['school'])=='')?$school_id:[$xss->xss($_GET['school']),$xss->xss($_GET['school'])],
			]]
		);
		$pg = $_GET['pg'];
		if (!$pg) $pg = 1;
		$datas = $database->select("units", "*",[
			"AND" => [
				'name[~]'  		=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']), 
				'status' 		=> ($xss->xss($_GET['status'])=='')?[A,D]:$xss->xss($_GET['status']), 
				"deleted"		=> 0,
				'school'		=> ($xss->xss($_GET['school'])=='')?$school_id:[$xss->xss($_GET['school']),$xss->xss($_GET['school'])],
			],
			"LIMIT" =>[(($pg-1)*$setting['site_page']),$setting['site_page']],
			"ORDER"	=> [
				"id"=>"DESC",
			]
		]);
		$page = $jatbi->pages($count,$setting['site_page'],$pg);
		$templates = $setting['site_backend'].'device.tpl';
	}
	elseif($router['1']=='units-add'){
		$jatbi->permission('units.add');
		$ajax = 'true';
		if(isset($_POST['token'])){
			if($_POST['name'] == ""){
				echo json_encode(['status'=>'error','content'=>$lang['loi-trong']]);
			}
			if ($_POST['name']){
				$insert = [
					"name" 			=> $xss->xss($_POST['name']),
					"notes" 		=> $xss->xss($_POST['notes']),
					"status" 		=> $xss->xss($_POST['status']),
					"school"		=> $school_id,
				];
				$database->insert("units",$insert);
				$jatbi->logs('units','add',$insert);
				echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
			}
		} else {
			$templates = $setting['site_backend'].'device.tpl';
		}
	}
	elseif($router['1']=='units-edit'){
		$jatbi->permission('units.edit');
		$ajax = 'true';
		if($router['2']){
			$data = $database->get("units", "*",["id"=>$xss->xss($router['2'])]);
			if($data>1){
				if(isset($_POST['token'])){
					if($_POST['name'] == ""){
						echo json_encode(['status'=>'error','content'=>$lang['loi-trong']]);
					}
					if ($_POST['name']){
						$insert = [
							"name" 			=> $xss->xss($_POST['name']),
							"notes" 		=> $xss->xss($_POST['notes']),
							"status" 		=> $xss->xss($_POST['status']),
						];
						$database->update("units",$insert,["id"=>$data['id']]);
						$jatbi->logs('units','edit',$insert);
						echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
					}
				} else {
					$vgroup = unserialize($data['group']);
					$templates = $setting['site_backend'].'device.tpl';
				}
			}
			else {
				header("HTTP/1.0 404 Not Found");
				die();
			}
		}
	}
	elseif($router['1']=='units-status'){
		$jatbi->permission('units.edit');
		$ajax = 'true';
		if($router['2']){
			$data = $database->get("units", "*",["id"=>$xss->xss($router['2'])]);
			if($data>1){
				if($data['status']==='A'){
					$status = "D";
				} 
				elseif($data['status']==='D'){
					$status = "A";
				}
				$database->update("units",["status"=>$status],["id"=>$data['id']]);
				$jatbi->logs('units','status',["data"=>$data,"status"=>$status]);
				echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-trang-thai'],'sound'=>$setting['site_sound']]);
			}
			else {
				echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-that-bai'],]);
			}
		}
	}
	elseif($router['1']=='units-delete'){
		$jatbi->permission('units.delete');
		$ajax = 'true';
		if($router['2']){
			$datas = $database->select("units","*",["id"=>explode(',', $xss->xss($router['2']))]);
			if(isset($_POST['submit'])){
				$jatbi->logs('units','delete',$datas);
				$database->update("units",["deleted"	=> 1,],["id"=>explode(',', $xss->xss($router['2']))]);
				echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
			} else {
				$templates = $setting['site_backend'].'device.tpl';
			}
		}
		else {
			header("HTTP/1.0 404 Not Found");
			die();
		}
	}
	elseif($router['1']=='category_device'){
		$jatbi->permission('category_device');
		$count = $database->count("category_device",[
			'AND' => [
				'name[~]'  		=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']), 
				'status' 		=> ($xss->xss($_GET['status'])=='')?[A,D]:$xss->xss($_GET['status']),
				"deleted"		=> 0,
				'school'		=> ($xss->xss($_GET['school'])=='')?$school_id:[$xss->xss($_GET['school']),$xss->xss($_GET['school'])],
			]]
		);
		$pg = $_GET['pg'];
		if (!$pg) $pg = 1;
		$datas = $database->select("category_device", "*",[
			"AND" => [
				'name[~]'  		=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']), 
				'status' 		=> ($xss->xss($_GET['status'])=='')?[A,D]:$xss->xss($_GET['status']), 
				"deleted"		=> 0,
				'school'		=> ($xss->xss($_GET['school'])=='')?$school_id:[$xss->xss($_GET['school']),$xss->xss($_GET['school'])],
			],
			"LIMIT" =>[(($pg-1)*$setting['site_page']),$setting['site_page']],
			"ORDER"	=> [
				"id"=>"DESC",
			]
		]);
		$page = $jatbi->pages($count,$setting['site_page'],$pg);
		$templates = $setting['site_backend'].'device.tpl';
	}
	elseif($router['1']=='category_device-add'){
		$jatbi->permission('category_device.add');
		$ajax = 'true';
		if(isset($_POST['token'])){
			if($_POST['name'] == ""){
				echo json_encode(['status'=>'error','content'=>$lang['loi-trong']]);
			}
			if ($_POST['name']){
				$insert = [
					"name" 			=> $xss->xss($_POST['name']),
					"notes" 		=> $xss->xss($_POST['notes']),
					"status" 		=> $xss->xss($_POST['status']),
					"school"		=> $school_id,
				];
				$database->insert("category_device",$insert);
				$jatbi->logs('category_device','add',$insert);
				echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
			}
		} else {
			$templates = $setting['site_backend'].'device.tpl';
		}
	}
	elseif($router['1']=='category_device-edit'){
		$jatbi->permission('category_device.edit');
		$ajax = 'true';
		if($router['2']){
			$data = $database->get("category_device", "*",["id"=>$xss->xss($router['2'])]);
			if($data>1){
				if(isset($_POST['token'])){
					if($_POST['name'] == ""){
						echo json_encode(['status'=>'error','content'=>$lang['loi-trong']]);
					}
					if ($_POST['name']){
						$insert = [
							"name" 			=> $xss->xss($_POST['name']),
							"notes" 		=> $xss->xss($_POST['notes']),
							"status" 		=> $xss->xss($_POST['status']),
						];
						$database->update("category_device",$insert,["id"=>$data['id']]);
						$jatbi->logs('category_device','edit',$insert);
						echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
					}
				} else {
					$vgroup = unserialize($data['group']);
					$templates = $setting['site_backend'].'device.tpl';
				}
			}
			else {
				header("HTTP/1.0 404 Not Found");
				die();
			}
		}
	}
	elseif($router['1']=='category_device-status'){
		$jatbi->permission('category_device.edit');
		$ajax = 'true';
		if($router['2']){
			$data = $database->get("category_device", "*",["id"=>$xss->xss($router['2'])]);
			if($data>1){
				if($data['status']==='A'){
					$status = "D";
				} 
				elseif($data['status']==='D'){
					$status = "A";
				}
				$database->update("category_device",["status"=>$status],["id"=>$data['id']]);
				$jatbi->logs('category_device','status',["data"=>$data,"status"=>$status]);
				echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-trang-thai'],'sound'=>$setting['site_sound']]);
			}
			else {
				echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-that-bai'],]);
			}
		}
	}
	elseif($router['1']=='category_device-delete'){
		$jatbi->permission('category_device.delete');
		$ajax = 'true';
		if($router['2']){
			$datas = $database->select("category_device","*",["id"=>explode(',', $xss->xss($router['2']))]);
			if(isset($_POST['submit'])){
				$jatbi->logs('category_device','delete',$datas);
				$database->update("category_device",["deleted"	=> 1,],["id"=>explode(',', $xss->xss($router['2']))]);
				echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
			} else {
				$templates = $setting['site_backend'].'device.tpl';
			}
		}
		else {
			header("HTTP/1.0 404 Not Found");
			die();
		}
	}
    elseif($router['1']=='supplier'){
        $jatbi->permission('supplier');
        $count = $database->count("supplier",[
            'AND' => [
                'name[~]'  		=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']), 
                "deleted"       => 0,
            ]]
        );
        $pg = $_GET['pg'];
        if (!$pg) $pg = 1;
        $datas = $database->select("supplier", "*",[
            "AND" => [
                "OR"=>[
                    //'id[~]'       => ($xss->xss($_GET['id'])=='')?'%':$xss->xss($_GET['id']),
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
        $templates = $setting['site_backend'].'device.tpl';
    }
    elseif($router['1']=='supplier-add'){
        $jatbi->permission('supplier.add');
        $ajax = 'true';
        if(isset($_POST['token'])){
            if($_POST['token']!=$_SESSION['csrf']['token']){
                echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
            }
            elseif($_POST['name'] == ""||$_POST['email'] == "" || $_POST['phone_number'] == "" ||$_POST['address'] == ""){
                echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
            }
            if ($_POST['name'] && $_POST['email'] && $_POST['phone_number'] && $_POST['address']) {
                $insert = [                  
                    "name"          => $xss->xss($_POST['name']),
                    "email"          => $xss->xss($_POST['email']),  
                    "phone_number"          => $xss->xss($_POST['phone_number']),
                    "address"          => $xss->xss($_POST['address']),                                
                    "status"        => $xss->xss($_POST['status']),
                    "school"        =>$school_id,
                ];
                $database->insert("supplier",$insert);
                $jatbi->logs('supplier','add',$insert);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            }
        } 
        else {
            $templates = $setting['site_backend'].'device.tpl';
        }
    }
    elseif($router['1']=='supplier-edit'){
        $jatbi->permission('supplier.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("supplier", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if(isset($_POST['token'])){
                    $partten = "/^[A-Za-z0-9_\.]{".$setting['site_characters'].",32}$/";
                    if($_POST['token']!=$_SESSION['csrf']['token']){
                        echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
                    }
                    elseif($_POST['name'] == ""||$_POST['email'] == "" || $_POST['phone_number'] == "" ||$_POST['address'] == ""){
                        echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
                    }
                    if ($_POST['name'] && $_POST['email'] && $_POST['phone_number'] && $_POST['address']) {
                        $insert = [                  
                            "name"          => $xss->xss($_POST['name']),
                            "email"          => $xss->xss($_POST['email']),  
                            "phone_number"          => $xss->xss($_POST['phone_number']),
                            "address"          => $xss->xss($_POST['address']),                                
                            "status"        => $xss->xss($_POST['status']),
                            "school"        =>$school_id,
                        ];
                        $database->update("supplier",$insert,["id"=>$data['id']]);
                        $jatbi->logs('supplier','edit',$insert);
                        echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
                    }
                } else {
                    $templates = $setting['site_backend'].'device.tpl';
                }
            }
            else {
                header("HTTP/1.0 404 Not Found");
                die();
            }
        }
    }
    elseif($router['1']=='supplier-delete'){
        $jatbi->permission('supplier.delete');
        $ajax = 'true';
        if($router['2']){
            $datas = $database->select("supplier","*",["id"=>explode(',', $xss->xss($router['2']))]);
            if(isset($_POST['submit'])){
                $jatbi->logs('supplier','delete',$datas);
                $database->update("supplier",["deleted" => 1,],["id"=>explode(',', $xss->xss($router['2']))]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            } else {
                $templates = $setting['site_backend'].'device.tpl';
            }
        }
        else {
            header("HTTP/1.0 404 Not Found");
            die();
        }
    }
    elseif($router['1']=='supplier-status'){
        $jatbi->permission('supplier.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("supplier", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if($data['status']==='A'){
                    $status = "D";
                } 
                elseif($data['status']==='D'){
                    $status = "A";
                }
                $database->update("supplier",["status"=>$status],["id"=>$data['id']]);
                $jatbi->logs('supplier','status',["data"=>$data,"status"=>$status]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-trang-thai'],'sound'=>$setting['site_sound']]);
            }
            else {
                echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-that-bai'],]);
            }
        }
    }
	elseif($router['1']=='import_goods'){
        $jatbi->permission('import_goods');
		$date = explode('-',$xss->xss($_GET['date']));
		$date_from = ($_GET['date']=='')?date('2021-01-01 00:00:00'):date('Y-m-d',strtotime(str_replace('/','-',$date[0]))).' 00:00:00';
		$date_to = ($_GET['date']=='')?date('Y-m-d 23:59:59'):date('Y-m-d',strtotime(str_replace('/','-',$date[1]))).' 23:59:59';
		$count = $database->count("purchase",[
			'AND' => [
				'code[<>]'		=> ($xss->xss($_GET['name'])=='')?'':[$xss->xss($_GET['name']),$xss->xss($_GET['name'])],
				'status[<>]'	=> ($xss->xss($_GET['status'])=='')?'':[$xss->xss($_GET['status']),$xss->xss($_GET['status'])],
				'status_pay[<>]'=> ($xss->xss($_GET['status_pay'])=='')?'':[$xss->xss($_GET['status_pay']),$xss->xss($_GET['status_pay'])],
				'user[<>]'		=> ($xss->xss($_GET['user'])=='')?'':[$xss->xss($_GET['user']),$xss->xss($_GET['user'])],
				"date[<>]" 		=> [$date_from,$date_to],
                "school"        =>$school_id,
				"deleted"		=> 0,
                "type"=>3,
			]]
		);
		$pg = $_GET['pg'];
		if (!$pg) $pg = 1;
		$datas = $database->select("purchase", "*",[
			"AND" => [
				'code[<>]'	=> ($xss->xss($_GET['name'])=='')?'':[$xss->xss($_GET['name']),$xss->xss($_GET['name'])],
				'status[<>]'		=> ($xss->xss($_GET['status'])=='')?'':[$xss->xss($_GET['status']),$xss->xss($_GET['status'])],
				'status_pay[<>]'		=> ($xss->xss($_GET['status_pay'])=='')?'':[$xss->xss($_GET['status_pay']),$xss->xss($_GET['status_pay'])],
				'user[<>]'		=> ($xss->xss($_GET['user'])=='')?'':[$xss->xss($_GET['user']),$xss->xss($_GET['user'])],
				"date[<>]" 		=> [$date_from,$date_to],
				"deleted"		=> 0,
                "school"        =>$school_id,
                "type"=>3,
			],
			"LIMIT" =>[(($pg-1)*$setting['site_page']),$setting['site_page']],
			"ORDER"	=> [
				"id"=>"DESC",
			]
		]);
		$page = $jatbi->pages($count,$setting['site_page'],$pg);
		$templates = $setting['site_backend'].'device.tpl';
	}
	elseif($router['1']=='import_goods-add'){
		$jatbi->permission('import_goods.add');
		$action = "add";
		if($_SESSION['purchase'][$action]['type_device']==''){
			$_SESSION['purchase'][$action]['type_device'] = 3;
		}
        if($_SESSION['purchase'][$action]['discount_device']==''){
			$_SESSION['purchase'][$action]['discount_device'] = 0;
		}
		if($_SESSION['purchase'][$action]['debt_device']==''){
			$_SESSION['purchase'][$action]['debt_device'] = "";
		}
		if($_SESSION['purchase'][$action]['has_device']==''){
			$_SESSION['purchase'][$action]['has_device'] = "";
		}
		if($_SESSION['purchase'][$action]['date_device']==''){
			$_SESSION['purchase'][$action]['date_device'] = date("Y-m-d");
		}
		$data = [
			"type" => $_SESSION['purchase'][$action]['type_device'],
			"date" => $_SESSION['purchase'][$action]['date_device'],
			"debt" => $_SESSION['purchase'][$action]['debt_device'],
			"has" => $_SESSION['purchase'][$action]['has_device'],
			"content" => $_SESSION['purchase'][$action]['content_device'],
			"vendor" => $_SESSION['purchase'][$action]['vendor_device'],
			"discount" => $_SESSION['purchase'][$action]['discount_device'],
			"status" => 1,
		];


			$SelectProducts = $_SESSION['purchase'][$action]['products_device'];
			$ingredient = $database->select("device", "*",["school"        =>$school_id,"deleted"=> 0,"status"=>'A',"supplier"=>$data['vendor']]);
		
		$templates = $setting['site_backend'].'device.tpl';
	}
	elseif($router['1']=='import_goods-edit'){
		$jatbi->permission('import_goods.edit');
		$action = "edit";
		$invoices = $database->get("purchase","*",["id"=>$xss->xss($router['2']),"deleted"=>0]);
		if($invoices>1){
			$Cus = $database->get("supplier","*",[ "school"        =>$school_id,"id"=>$invoices['vendor']]);
			$Pros = $database->select("purchase_products","*",[ "school"        =>$school_id,"purchase"=>$invoices['id'],"deleted"=>0]);
			$Details = $database->select("purchase_details","*",[ "school"        =>$school_id,"purchase"=>$invoices['id'],"deleted"=>0]);
			if($_SESSION['purchase'][$action]['order']!=$invoices['id']){
				unset($_SESSION['purchase'][$action]);
				$_SESSION['purchase'][$action]['status'] = $invoices['status'];
				$_SESSION['purchase'][$action]['status_pay'] = $invoices['status_pay'];
				$_SESSION['purchase'][$action]['discount_device'] = $invoices['discount'];
				$_SESSION['purchase'][$action]['code'] = $invoices['code'];
				$_SESSION['purchase'][$action]['content_device'] = $invoices['content'];
				$_SESSION['purchase'][$action]['type_device'] = $invoices['type'];
				$_SESSION['purchase'][$action]['date_device'] = date("Y-m-d",strtotime($invoices['date']));
				$_SESSION['purchase'][$action]['vendor_device'] = [
					"id"=>$Cus['id'],
					"name"=>$Cus['name'],
					"phone"=>$Cus['phone_number'],
					"email"=>$Cus['email'],
				];
				foreach ($Pros as $key => $value) {
					$GetPro = $database->get("device","*",["id"=>$value['products'],"deleted"=>0]);
					$_SESSION['purchase'][$action]['products_device'][$value['id']] = [
						"id"=>$value['id'],
						"products"=>$value['products'],
						"images"=>$GetPro['images'],
						"code"=>$GetPro['code'],
						"name"=>$GetPro['name'],
						"categorys"=>$value['categorys'],
						"amount"=>$value['amount'],
						"price"=>$value['price'],
						"units"=>$GetPro['units'],
						"notes"=>$value['notes'],
						"status"=>$value['status'],
                        "school"        =>$school_id,
					];
				}
				foreach ($Details as $detail){
					$_SESSION['purchase'][$action][$detail['type_device']][] = [
						"type"			=> $detail['type'],
						"price" 		=> $xss->xss(str_replace([','],'',$detail['price'])),
						"content" 		=> $xss->xss($detail['content']),
						"date" 			=> $xss->xss($detail['date']),
						"user" 			=> $detail['user'],
					];
				}
				$_SESSION['purchase'][$action]['order'] = $invoices['id'];
			}
			$data = [
				"date" => $_SESSION['purchase'][$action]['date_device'],
				"discount" => $_SESSION['purchase'][$action]['discount_device'],
				"content" => $_SESSION['purchase'][$action]['content_device'],
				"status" => $_SESSION['purchase'][$action]['status'],
			];
			$getCus = $database->get("supplier","*",["id"=>$_SESSION['purchase'][$action]['vendor_device']['id']]);
			$SelectProducts = $_SESSION['purchase'][$action]['products_device'];
			$templates = $setting['site_backend'].'device.tpl';
		}
		else {
			header("HTTP/1.0 404 Not Found");
			die();
		}
	}
	elseif($router['1']=='purchase-update'){
		$ajax = 'true';
		$action = $router['2'];
		if($router['3']=='vendor_device'){
			$data = $database->get("supplier", "*",["school"        =>$school_id,"id"=>$xss->xss($_POST['value'])]);
			if($data>1){
				unset($_SESSION['purchase'][$action]['products_device']);
                unset($_SESSION['purchase'][$action]['discount_device']);
				$_SESSION['purchase'][$action]['vendor_device'] = [
					"id"=>$data['id'],
					"name"=>$data['name'],
					"phone"=>$data['phone_number'],
					"email"=>$data['email'],
				];
				echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],]);
			}
			else {
				echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-that-bai'],]);
			}
		}
		elseif($router['3']=='products_device'){
			if($router['4']=='add'){
				$data = $database->get("device", "*",["school"        =>$school_id,"id"=>$xss->xss($_POST['value'])]);
				if($data>1){
					$_SESSION['purchase'][$action]['products_device'][] = [
						"products"=>$data['id'],
						"amount"=>1,
						"price"=>'',
						"vendor"=>$data['supplier'],
						"code"=>$data['code'],
						"name"=>$data['name'],
						"categorys"=>$data['category_device'],
						"units"=>$data['units'],
						"notes"=>$data['notes'],
					];
					echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],]);
				}
				else {
					echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-that-bai'],]);
				}
			}
			elseif($router['4']=='deleted'){
				unset($_SESSION['purchase'][$action]['products_device'][$router['5']]);
				echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],]);
			}
			elseif($router['4']=='price'){
				$_SESSION['purchase'][$action]['products_device'][$router['5']][$router['4']] = $xss->xss(str_replace([','],'',$_POST['value']));
				echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],]);
			}
			else {
				$_SESSION['purchase'][$action]['products_device'][$router['5']][$router['4']] = $xss->xss($_POST['value']);
				echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],]);
			}
		}
		elseif($router['3']=='date_device' || $router['3']=='discount_device' || $router['3']=='content_device'|| $router['3']=='debt_device'|| $router['3']=='has_device'){
			$_SESSION['purchase'][$action][$router['3']] = $xss->xss($_POST['value']);
			echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],]);
		}
		elseif($router['3']=='cancel'){
			unset($_SESSION['purchase'][$action]);
			echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],]);
		}
		elseif($router['3']=='details-deleted'){
			unset($_SESSION['purchase'][$action][$router['4']][$router['5']]);
			echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],]);
		}
		elseif($router['3']=='details'){
			if(isset($_POST['token'])){
				if($_POST['token']!=$_SESSION['csrf-token']){
					echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
				}
			    elseif($_POST['date_device'] == ""){
					echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
				}
			    if ($_POST['date']) {
			    	$_SESSION['purchase'][$action][$router['4']][] = [
						"code"			=> strtotime(date('Y-m-d H:i:s')),
			    		"type"			=> $router['4'],
						"price" 		=> $xss->xss(str_replace([','],'',$_POST['price'])),
						"content" 		=> $xss->xss($_POST['content_device']),
						"date" 			=> date('Y-m-d H:i:s',strtotime($xss->xss($_POST['date_device']))),
						"user" 			=> $account['id'],
					];
					echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
		        }
			} else {
				$datas = $_SESSION['purchase'][$action][$router['4']];
				$templates = $setting['site_backend'].'purchases.tpl';
			}	
		}
		elseif($router['3']=='completed'){
            $datas = $_SESSION['purchase'][$action];
			foreach ($_SESSION['purchase'][$action]['products_device'] as $value) {
				$total_products += $value['amount']*$value['price'];
				if($value['amount']=='' || $value['amount']==0){
					$error_warehouses = 'true';
				}
			}
			$discount = ($_SESSION['purchase'][$action]['discount_device']*$total_products)/100;
			$payments = ($total_products-$total_minus-$discount)+$total_surcharge;
			$payments1 = ($total_ingredient-$total_minus-$discount)+$total_surcharge;
			if($_SESSION['purchase'][$action]['vendor_device']['id']==''  || $_SESSION['purchase'][$action]['content_device']==''){
				$error = ["status"=>'error','content'=>$lang['loi-trong']];
			}
			elseif($error_warehouses=='true'){
				$error = ['status'=>'error','content'=>$lang['vui-long-chon-kho-hang'],];
			}
			if(count($error)==0){
				if($action=='add'){
					$code = strtotime(date("Y-m-d H:i:s"));
				}
				if($action=='edit'){
					$code = $_SESSION['purchase'][$action]['code'];
					$database->update("purchase_details",["deleted"=>1],["purchase"=>$_SESSION['purchase'][$action]['order']]);
					$database->update("purchase_products",["deleted"=>1],["purchase"=>$_SESSION['purchase'][$action]['order']]);
				}
				$insertt = [
					"type"			=> $_SESSION['purchase'][$action]['type_device'],
					"vendor"		=> $_SESSION['purchase'][$action]['vendor_device']['id'],
					"code"			=> $code,
					"date"			=> $_SESSION['purchase'][$action]['date_device'],
					"total"			=> $_SESSION['purchase'][$action]['type_device']==3?$total_products:$total_ingredient,
					"minus"			=> 0,
					"surcharge"		=> 0,
					"prepay_req"	=> 0,
					"prepay"		=> 0,
					"discount"		=> $_SESSION['purchase'][$action]['discount_device'],
					"discount_price"=> $discount,
					"payments"		=> $_SESSION['purchase'][$action]['type_device']==3?$payments:$payments1,
					"user"			=> $account['id'],
					"date_poster"	=> date("Y-m-d H:i:s"),
					"status"		=> 1,
					"status_pay"	=> $_SESSION['purchase'][$action]['status_pay']==0?2:$_SESSION['purchase'][$action]['status_pay'],
					"content"		=> $_SESSION['purchase'][$action]['content_device'],
					"active"		=> $jatbi->active(30),
					"keycode"		=> $jatbi->random(6),
                    "school"        =>$school_id,
				];
                
				if($action=="add"){
					$database->insert("purchase",$insertt);
					$orderIdd = $database->id();
					$database->insert("purchase_logs",[
						"purchase" 	=> $orderIdd,
						"user"		=> $account['id'],
						"content" 	=> $xss->xss('Mua thiết bị'),
						"status" 	=> $xss->xss($insert['status']),
						"date"		=> date('Y-m-d H:i:s'),
                        "school"        =>$school_id,
					]);
					$inser = [
						"type" 			=> 2,
						"debt" 			=>$_SESSION['purchase'][$action]['debt_device'],
						"has" 			=>$_SESSION['purchase'][$action]['has_device'],
						"price" 		=> $_SESSION['purchase'][$action]['type_device']==3?'-'.$total_products:'-'.$total_ingredient,
						"content" 		=>  $_SESSION['purchase'][$action]['content_device'],
						"date" 			=> date("y-m-d h:i:s"),
						"purchase" 		=> $orderIdd,
						"ballot"        => strtotime(date("y-m-d  h:i")),
						"user"			=> $account['id'],
						"date_poster"	=> date("Y-m-d H:i:s"),
						"school"		=> $school_id,
					];
					$database->insert("expenditure",$inser);
					$jatbi->logs('expenditure','add',$inser);
                    $insert = [
                        "code"			=> $datas['type_device'],
                        "type"			=> $datas['type_device'],
                        "data"			=> "",
                        "stores"		=> "",
                        "branch"		=> "",
                        "stores_receive"=> "",
                        "branch_receive"=> "",
                        "content"		=> $datas['content_device'],
                        "vendor"		=> $datas['vendor_device']['id'],
                        "user"			=> $account['id'],
                        "date"			=> $datas['date'],
                        "active"		=> $jatbi->active(30),
                        "date_poster"	=> date("Y-m-d H:i:s"),
                        "purchase"		=> $orderIdd,
                        "move"			=> "",
                        "receive_status"=> 1,
                        "school"        =>$school_id,
                    ];
                    $database->insert("warehouses",$insert);
                    $orderId = $database->id();
				}
				if($action=="edit"){
					$database->update("purchase",$insertt,["school"        =>$school_id,"id"=>$_SESSION['purchase'][$action]['order']]);
					$orderIdd = $_SESSION['purchase'][$action]['order'];
					$database->insert("purchase_logs",[
						"purchase" 	=> $orderIdd,
						"user"		=> $account['id'],
						"content" 	=> $xss->xss('Sửa mua thiết bị'),
						"status" 	=> $xss->xss($insertt['status']),
						"date"		=> date('Y-m-d H:i:s'),
                        "school"        =>$school_id,
					]);
				}
                
				if($_SESSION['purchase'][$action]['type_device']==3){
				    foreach ($_SESSION['purchase'][$action]['products_device'] as $key => $value) {
					$getProducts = $database->get("device","*",["school"        =>$school_id,"id"=>$value['products']]);
                    $database->update("device",["amounts"=>$getProducts['amounts']+$value['amount']],["school"        =>$school_id,"id"=>$getProducts['id']]);  
					$pro = [
                        "warehouses" => $orderId,
                        "data"=>$insert['data'],
                        "type"=>$insert['type'],
                        "vendor"=>$value['vendor'],
                        "products"=>$value['products'],
                        "amount_buy" => $value['amount_buy'],
                        "amount"=>str_replace([','],'',$value['amount']),
                        "amount_total"=>str_replace([','],'',$value['amount']),
                        "price"=>$value['price'],
                        "notes"=>$value['notes'],
                        "date"=>date("Y-m-d H:i:s"),
                        "user"=>$account['id'],
                        "stores"	=> "",
                        "branch"	=> $insert['branch'],
                        "school"        =>$school_id,
                    ];
                    $database->insert("warehouses_details",$pro);
                    $GetID = $database->id();
                    $warehouses_logs = [
                        "type"=>$insert['type'],
                        "data"=>$insert['data'],
                        "warehouses"=>$orderId,
                        "details"=>$GetID,
                        "products"=>$value['products'],
                        "price"=>$value['price'],
                        "amount"=>str_replace([','],'',$value['amount']),
                        "total"=>$value['amount']*$value['price'],
                        "notes"=>$value['notes'],
                        "date" 	=> date('Y-m-d H:i:s'),
                        "user" 	=> $account['id'],
                        "stores"	=> "",
                        "school"        =>$school_id,
                    ];
                    $database->insert("warehouses_logs",$warehouses_logs);
                   
                    
                    $proo = [
						"purchase"=>$orderIdd,
						"vendor"=>$value['vendor'],
						"products"=>$value['products'],
						"categorys"=>$value['categorys'],
						"amount"=>$value['amount'],
						"weight"=>$value['weight'],
						"price"=>$value['price'],
						"total"=>$value['amount']*$value['price'],
						"date"=>date("Y-m-d H:i:s"),
						"user"=>$account['id'],
						"status"=>1,
						"active"=>$jatbi->active(30),
                        "school"        =>$school_id,
					];
					$database->insert("purchase_products",$proo);
					$pro_logs[] = $proo;
				    }
                }
				$jatbi->logs('purchase',$action,[$insert,$pro_logs,$_SESSION['purchase'][$action]]);
				unset($_SESSION['purchase'][$action]);
				echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            }
            else {
                    echo json_encode(['status'=>'error','content'=>$error['content']]);
            }
		} 
    }
	elseif($router['1']=='import_goods-delete'){
		$jatbi->permission('import_goods.delete');
		$ajax = 'true';
		if($router['2']){
			$datas = $database->select("purchase","*",["id"=>explode(',', $xss->xss($router['2']))]);
			if(isset($_POST['submit'])){
				$jatbi->logs('purchase','delete',$datas);
				foreach ($datas as $key => $data) {
					$database->update("purchase_details",["deleted"=>1],["purchase"=>$data['id']]);
					$database->update("purchase_products",["deleted"=>1],["purchase"=>$data['id']]);
					$database->update("purchase",["deleted"=>1],["id"=>$data['id']]);
				}
				echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
			} else {
				$templates = $setting['site_backend'].'device.tpl';
			}
		}
	}
	elseif($router['1']=='purchase-views'){
		$ajax = 'true';
		if($router['2']){
			$data = $database->get("purchase","*",["school"        =>$school_id,"id"=>$xss->xss($router['2']),"deleted"=>0]);
			if($data>1){
				$SelectProducts = $database->select("purchase_products","*",["purchase"=>$data['id'],"deleted"=>0]);
				$details = $database->select("purchase_details","*",["purchase"=>$data['id'],"deleted"=>0]);
				$logs = $database->select("purchase_logs","*",["purchase"=>$data['id'],"deleted"=>0]);
				if(isset($_POST['token'])){
					if($_POST['status']==''){
						$error = ['status'=>'error','content'=>$lang['loi-trong']];
					}
					if($_POST['status']==4 && $xss->xss($_POST['content'])==''){
						$error = ['status'=>'error','content'=>$lang['vui-long-cho-biet-ly-do']];
					}
					if(count($error)==0) {
						$insert = [
							"keycode" 	=> $jatbi->random(6),
							"status" 	=> $xss->xss($_POST['status']),
						];
						$database->update("purchase",$insert,["id"=>$data['id']]);
						$database->insert("purchase_logs",[
							"purchase" 	=> $data['id'],
							"user"		=> $account['id'],
							"content" 	=> $xss->xss($_POST['content'])==''?$lang['da-duyet']:$xss->xss($_POST['content']),
							"status" 	=> $xss->xss($_POST['status']),
							"date"		=> date('Y-m-d H:i:s'),
                            "school"        =>$school_id,
						]);
						$jatbi->notification($account['id'],$data['user'],'','Đề xuất mua hàng #'.$ballot_code['purchase'].'-'.$data['code'],'Yêu cầu #'.$ballot_code['purchase'].'-'.$data['code'].' '.$Status_purchase[$insert['status']]['name'],'/purchases/purchase-views/'.$data['id'].'/','modal-url');
						$jatbi->logs('purchase','approved',$insert);
						echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
					}
					else {
						echo json_encode(['status'=>'error','content'=>$error['content']]);
					}
				} else {
					$templates = $setting['site_backend'].'device.tpl';
				}
			} 
			else {
				header("HTTP/1.0 404 Not Found");
				die();
			}
		}
	}
    elseif($router['1']=='warehouses-history'){
        $jatbi->permission('warehouses-history');
            $date = explode('-',$xss->xss($_GET['date']));
            $date_from = ($_GET['date']=='')?date('Y-m-d 00:00:00',strtotime($setting['site_start'])):date('Y-m-d',strtotime(str_replace('/','-',$date[0]))).' 00:00:00';
            $date_to = ($_GET['date']=='')?date('Y-m-d 23:59:59'):date('Y-m-d',strtotime(str_replace('/','-',$date[1]))).' 23:59:59';
            $count = $database->count("warehouses",[
                'AND' => [				
                    "OR"=>[
                        'id[~]'  	=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']), 
                        'content[~]'  	=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']), 
                    ], 
                    "date[<>]" 		=> [$date_from,$date_to],
                    "school"        =>$school_id,
					"type"        =>[3,4],
                    "deleted"		=> 0,
                ]]
            );
            $pg = $_GET['pg'];
            if (!$pg) $pg = 1;
            $datas = $database->select("warehouses", "*",[
                "AND" => [
                    "OR"=>[
                        'id[~]'  	=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']), 
                        'content[~]'  	=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']), 
                    ],
                    "date[<>]" 		=> [$date_from,$date_to],
                    "school"        =>$school_id,
					"type"        =>[3,4],
                    "deleted"		=> 0,
                ],
                "LIMIT" =>[(($pg-1)*$setting['site_page']),$setting['site_page']],
                "ORDER"	=> [
                    "id"=>"DESC",
                ]
            ]);
            $page = $jatbi->pages($count,$setting['site_page'],$pg);
            $templates = $setting['site_backend'].'device.tpl';
    }
	elseif($router['1']=='warehouses-history-views'){
		$jatbi->permission('warehouses-history');
		$ajax = 'true';
		if($router['2']){
			$data = $database->get("warehouses", "*",["id"=>$xss->xss($router['2'])]);
			if($data>1){
				$details = $database->select("warehouses_details","*",["warehouses"=>$data['id']]);
			}
			else {
				header("HTTP/1.0 404 Not Found");
				die();
			}
		}
		$templates = $setting['site_backend'].'device.tpl';
	}
	elseif($router['1']=='export_goods'){
        $jatbi->permission('export_goods');
		$date = explode('-',$xss->xss($_GET['date']));
		$date_from = ($_GET['date']=='')?date('2021-01-01 00:00:00'):date('Y-m-d',strtotime(str_replace('/','-',$date[0]))).' 00:00:00';
		$date_to = ($_GET['date']=='')?date('Y-m-d 23:59:59'):date('Y-m-d',strtotime(str_replace('/','-',$date[1]))).' 23:59:59';
		$count = $database->count("purchase",[
			'AND' => [
				'code[<>]'		=> ($xss->xss($_GET['name'])=='')?'':[$xss->xss($_GET['name']),$xss->xss($_GET['name'])],
				'status[<>]'	=> ($xss->xss($_GET['status'])=='')?'':[$xss->xss($_GET['status']),$xss->xss($_GET['status'])],
				'status_pay[<>]'=> ($xss->xss($_GET['status_pay'])=='')?'':[$xss->xss($_GET['status_pay']),$xss->xss($_GET['status_pay'])],
				'user[<>]'		=> ($xss->xss($_GET['user'])=='')?'':[$xss->xss($_GET['user']),$xss->xss($_GET['user'])],
				"date[<>]" 		=> [$date_from,$date_to],
                "school"        =>$school_id,
				"deleted"		=> 0,
                "type"=>4,
			]]
		);
		$pg = $_GET['pg'];
		if (!$pg) $pg = 1;
		$datas = $database->select("purchase", "*",[
			"AND" => [
				'code[<>]'	=> ($xss->xss($_GET['name'])=='')?'':[$xss->xss($_GET['name']),$xss->xss($_GET['name'])],
				'status[<>]'		=> ($xss->xss($_GET['status'])=='')?'':[$xss->xss($_GET['status']),$xss->xss($_GET['status'])],
				'status_pay[<>]'		=> ($xss->xss($_GET['status_pay'])=='')?'':[$xss->xss($_GET['status_pay']),$xss->xss($_GET['status_pay'])],
				'user[<>]'		=> ($xss->xss($_GET['user'])=='')?'':[$xss->xss($_GET['user']),$xss->xss($_GET['user'])],
				"date[<>]" 		=> [$date_from,$date_to],
				"deleted"		=> 0,
                "type"=>4,
                "school"        =>$school_id,
			],
			"LIMIT" =>[(($pg-1)*$setting['site_page']),$setting['site_page']],
			"ORDER"	=> [
				"id"=>"DESC",
			]
		]);
		$page = $jatbi->pages($count,$setting['site_page'],$pg);
		$templates = $setting['site_backend'].'device.tpl';
	}
	elseif($router['1']=='export_goods-add'){
		$jatbi->permission('export_goods.add');
		$action = "add";
		if($_SESSION['purchase'][$action]['typees']==''){
			$_SESSION['purchase'][$action]['typees'] = 4;
		}
        if($_SESSION['purchase'][$action]['discountts']==''){
			$_SESSION['purchase'][$action]['discountts'] = 0;
		}
		if($_SESSION['purchase'][$action]['datees']==''){
			$_SESSION['purchase'][$action]['datees'] = date("Y-m-d");
		}
		$data = [
			"type" => $_SESSION['purchase'][$action]['typees'],
			"date" => $_SESSION['purchase'][$action]['datees'],
			"content" => $_SESSION['purchase'][$action]['contentts'],
			"discount" => $_SESSION['purchase'][$action]['discountts'],
			"status" => 1,
		];


			$SelectProducts = $_SESSION['purchase'][$action]['productsss'];
			$ingredient = $database->select("device", "*",["amounts[>]"=>0,"school"        =>$school_id,"deleted"=> 0,"status"=>'A']);
		
		$templates = $setting['site_backend'].'device.tpl';
	}
	elseif($router['1']=='export_goods-edit'){
		$jatbi->permission('export_goods.edit');
		$action = "edit";
		$invoices = $database->get("purchase","*",["id"=>$xss->xss($router['2']),"deleted"=>0]);
		if($invoices>1){
			$Cus = $database->get("supplier","*",["id"=>$invoices['vendor']]);
			$Pros = $database->select("purchase_products","*",["purchase"=>$invoices['id'],"deleted"=>0]);
			$Details = $database->select("purchase_details","*",["purchase"=>$invoices['id'],"deleted"=>0]);
			if($_SESSION['purchase'][$action]['order']!=$invoices['id']){
				unset($_SESSION['purchase'][$action]);
				$_SESSION['purchase'][$action]['status'] = $invoices['status'];
				$_SESSION['purchase'][$action]['status_pay'] = $invoices['status_pay'];
				$_SESSION['purchase'][$action]['discountts'] = $invoices['discount'];
				$_SESSION['purchase'][$action]['code'] = $invoices['code'];
				$_SESSION['purchase'][$action]['contentts'] = $invoices['content'];
				$_SESSION['purchase'][$action]['typees'] = $invoices['type'];
				$_SESSION['purchase'][$action]['datees'] = date("Y-m-d",strtotime($invoices['date']));
			
				foreach ($Pros as $key => $value) {
					$GetPro = $database->get("device","*",["id"=>$value['products'],"deleted"=>0]);
					$_SESSION['purchase'][$action]['productsss'][$value['id']] = [
						"id"=>$value['id'],
						"products"=>$value['products'],
						"images"=>$GetPro['images'],
						"code"=>$GetPro['code'],
						"name"=>$GetPro['name'],
						"categorys"=>$value['categorys'],
						"amount"=>$value['amount'],
						"price"=>$value['price'],
						"units"=>$GetPro['units'],
						"notes"=>$value['notes'],
						"status"=>$value['status'],
                        "school"        =>$school_id,
					];
				}
				foreach ($Details as $detail){
					$_SESSION['purchase'][$action][$detail['typees']][] = [
						"type"			=> $detail['type'],
						"price" 		=> $xss->xss(str_replace([','],'',$detail['price'])),
						"content" 		=> $xss->xss($detail['content']),
						"date" 			=> $xss->xss($detail['date']),
						"user" 			=> $detail['user'],
					];
				}
				$_SESSION['purchase'][$action]['order'] = $invoices['id'];
			}
			$data = [
				"date" => $_SESSION['purchase'][$action]['datees'],
				"discount" => $_SESSION['purchase'][$action]['discountts'],
				"content" => $_SESSION['purchase'][$action]['contentts'],
				"status" => $_SESSION['purchase'][$action]['status'],
			];
			$getCus = $database->get("supplier","*",["id"=>$_SESSION['purchase'][$action]['vendor']['id']]);
			$SelectProducts = $_SESSION['purchase'][$action]['products'];
			$templates = $setting['site_backend'].'device.tpl';
		}
		else {
			header("HTTP/1.0 404 Not Found");
			die();
		}
	}
    elseif($router['1']=='purchase_export-update'){
		$ajax = 'true';
		$action = $router['2'];
		if($router['3']=='productsss'){
			if($router['4']=='add'){
				$data = $database->get("device", "*",["id"=>$xss->xss($_POST['value'])]);
				if($data>1){
					$_SESSION['purchase'][$action]['productsss'][] = [
						"products"=>$data['id'],
						"amount"=>1,
						"price"=>'',
						"vendor"=>$data['supplier'],
						"code"=>$data['code'],
						"name"=>$data['name'],
						"categorys"=>$data['category_device'],
						"units"=>$data['units'],
						"notes"=>$data['notes'],
					];
					echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],]);
				}
				else {
					echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-that-bai'],]);
				}
			}
			elseif($router['4']=='deleted'){
				unset($_SESSION['purchase'][$action]['productsss'][$router['5']]);
				echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],]);
			}
			elseif($router['4']=='price'){
				$_SESSION['purchase'][$action]['productsss'][$router['5']][$router['4']] = $xss->xss(str_replace([','],'',$_POST['value']));
				echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],]);
			}
			else {
				$_SESSION['purchase'][$action]['productsss'][$router['5']][$router['4']] = $xss->xss($_POST['value']);
				echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],]);
			}
		}
		elseif($router['3']=='datees' || $router['3']=='discountts' || $router['3']=='contentts'){
			$_SESSION['purchase'][$action][$router['3']] = $xss->xss($_POST['value']);
			echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],]);
		}
		elseif($router['3']=='cancel'){
			unset($_SESSION['purchase'][$action]);
			echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],]);
		}
		elseif($router['3']=='details-deleted'){
			unset($_SESSION['purchase'][$action][$router['4']][$router['5']]);
			echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],]);
		}
		elseif($router['3']=='details'){
			if(isset($_POST['token'])){
				if($_POST['token']!=$_SESSION['csrf-token']){
					echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
				}
			    elseif($_POST['datees'] == ""){
					echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
				}
			    if ($_POST['datees']) {
			    	$_SESSION['purchase'][$action][$router['4']][] = [
						"code"			=> strtotime(date('Y-m-d H:i:s')),
			    		"type"			=> $router['4'],
						"price" 		=> $xss->xss(str_replace([','],'',$_POST['price'])),
						"content" 		=> $xss->xss($_POST['content']),
						"date" 			=> date('Y-m-d H:i:s',strtotime($xss->xss($_POST['datee']))),
						"user" 			=> $account['id'],
					];
					echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
		        }
			} else {
				$datas = $_SESSION['purchase'][$action][$router['4']];
				$templates = $setting['site_backend'].'device.tpl';
			}	
		}
		elseif($router['3']=='completed'){
            $datas = $_SESSION['purchase'][$action];
			foreach ($_SESSION['purchase'][$action]['productsss'] as $value) {
				$total_products += $value['amount']*$value['price'];
				if($value['amount']=='' || $value['amount']==0){
					$error_warehouses = 'true';
				}
			}
			$discount = ($_SESSION['purchase'][$action]['discountts']*$total_products)/100;
			$payments = ($total_products-$total_minus-$discount)+$total_surcharge;
			$payments1 = ($total_ingredient-$total_minus-$discount)+$total_surcharge;
			if($_SESSION['purchase'][$action]['contentts']==''){
				$error = ["status"=>'error','content'=>$lang['loi-trong']];
			}
			elseif($error_warehouses=='true'){
				$error = ['status'=>'error','content'=>$lang['vui-long-chon-kho-hang'],];
			}
            foreach ($_SESSION['purchase'][$action]['productsss'] as $key => $value) {
                $getProducts = $database->get("device","*",["id"=>$value['products']]);
                if($getProducts['amounts']<$value['amount']){
                        $error = ["status"=>'error','content'=>$lang['so-luong-ton-khong-du']];
                    
                }
            }
			if(count($error)==0){
				if($action=='add'){
					$code = strtotime(date("Y-m-d H:i:s"));
				}
				if($action=='edit'){
					$code = $_SESSION['purchase'][$action]['code'];
					$database->update("purchase_details",["deleted"=>1],["purchase"=>$_SESSION['purchase'][$action]['order']]);
					$database->update("purchase_products",["deleted"=>1],["purchase"=>$_SESSION['purchase'][$action]['order']]);
				}
				$insertt = [
					"type"			=> $_SESSION['purchase'][$action]['typees'],
					"vendor"		=> "",
					"code"			=> $code,
					"date"			=> $_SESSION['purchase'][$action]['datees'],
					"total"			=> $_SESSION['purchase'][$action]['typees']==2?$total_products:$total_ingredient,
					"minus"			=> 0,
					"surcharge"		=> 0,
					"prepay_req"	=> 0,
					"prepay"		=> 0,
					"discount"		=> $_SESSION['purchase'][$action]['discountts'],
					"discount_price"=> $discount,
					"payments"		=> $_SESSION['purchase'][$action]['typees']==2?$payments:$payments1,
					"user"			=> $account['id'],
					"date_poster"	=> date("Y-m-d H:i:s"),
					"status"		=> 1,
					"status_pay"	=> $_SESSION['purchase'][$action]['status_pay']==0?2:$_SESSION['purchase'][$action]['status_pay'],
					"content"		=> $_SESSION['purchase'][$action]['contentts'],
					"active"		=> $jatbi->active(30),
					"keycode"		=> $jatbi->random(6),
                    "school"        =>$school_id,
				];
                
				if($action=="add"){
					$database->insert("purchase",$insertt);
					$orderIdd = $database->id();
					
					$database->insert("purchase_logs",[
						"purchase" 	=> $orderIdd,
						"user"		=> $account['id'],
						"content" 	=> $xss->xss('Xuất thiết bị'),
						"status" 	=> $xss->xss($insert['status']),
						"date"		=> date('Y-m-d H:i:s'),
                        "school"        =>$school_id,
					]);
                    $insert = [
                        "code"			=> $datas['typees'],
                        "type"			=> $datas['typees'],
                        "data"			=> "",
                        "stores"		=> "",
                        "branch"		=> "",
                        "stores_receive"=> "",
                        "branch_receive"=> "",
                        "content"		=> $datas['contentts'],
                        "vendor"		=> "",
                        "user"			=> $account['id'],
                        "date"			=> $datas['datees'],
                        "active"		=> $jatbi->active(30),
                        "date_poster"	=> date("Y-m-d H:i:s"),
                        "purchase"		=> $orderIdd,
                        "move"			=> "",
                        "receive_status"=> 1,
                        "school"        =>$school_id,
                    ];
                    $database->insert("warehouses",$insert);
                    $orderId = $database->id();
				}
				if($action=="edit"){
					$database->update("purchase",$insertt,["id"=>$_SESSION['purchase'][$action]['order']]);
					$orderIdd = $_SESSION['purchase'][$action]['order'];
					$database->insert("purchase_logs",[
						"purchase" 	=> $orderIdd,
						"user"		=> $account['id'],
						"content" 	=> $xss->xss('Sửa xuất thiết bị'),
						"status" 	=> $xss->xss($insertt['status']),
						"date"		=> date('Y-m-d H:i:s'),
                        "school"        =>$school_id,
					]);
				}
                
				if($_SESSION['purchase'][$action]['typees']==4){
				    foreach ($_SESSION['purchase'][$action]['productsss'] as $key => $value) {
                        $getProducts = $database->get("device","*",["id"=>$value['products']]);
                        if($getProducts['amounts']>=$value['amount']){
                            $database->update("device",["amounts"=>$getProducts['amounts']-$value['amount']],["school"        =>$school_id,"id"=>$getProducts['id']]);  
                            $pro = [
                                "warehouses" => $orderId,
                                "data"=>$insert['data'],
                                "type"=>$insert['type'],
                                "vendor"=>$getProducts['supplier'],
                                "products"=>$value['products'],
                                "amount_buy" => $value['amount_buy'],
                                "amount"=>str_replace([','],'',$value['amount']),
                                "amount_total"=>str_replace([','],'',$value['amount']),
                                "price"=>$value['price'],
                                "notes"=>$value['notes'],
                                "date"=>date("Y-m-d H:i:s"),
                                "user"=>$account['id'],
                                "stores"	=> "",
                                "branch"	=> $insert['branch'],
                                "school"        =>$school_id,
                            ];
                            $database->insert("warehouses_details",$pro);
                            $GetID = $database->id();
                            $warehouses_logs = [
                                "type"=>$insert['type'],
                                "data"=>$insert['data'],
                                "warehouses"=>$orderId,
                                "details"=>$GetID,
                                "products"=>$value['products'],
                                "price"=>$value['price'],
                                "amount"=>str_replace([','],'',$value['amount']),
                                "total"=>$value['amount']*$value['price'],
                                "notes"=>$value['notes'],
                                "date" 	=> date('Y-m-d H:i:s'),
                                "user" 	=> $account['id'],
                                "stores"	=> "",
                                "school"        =>$school_id,
                            ];
                            $database->insert("warehouses_logs",$warehouses_logs);
                        
                            
                            $proo = [
                                "purchase"=>$orderIdd,
                                "vendor"=>$getProducts['supplier'],
                                "products"=>$value['products'],
                                "categorys"=>$value['categorys'],
                                "amount"=>$value['amount'],
                                "weight"=>$value['weight'],
                                "price"=>$value['price'],
                                "total"=>$value['amount']*$value['price'],
                                "date"=>date("Y-m-d H:i:s"),
                                "user"=>$account['id'],
                                "status"=>1,
                                "active"=>$jatbi->active(30),
                                "school"        =>$school_id,
                            ];
                            $database->insert("purchase_products",$proo);
                            $pro_logs[] = $proo;
                        }
				    }
                }
				$jatbi->logs('purchase',$action,[$insert,$pro_logs,$_SESSION['purchase'][$action]]);
				unset($_SESSION['purchase'][$action]);
				echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
                }
                else {
                    echo json_encode(['status'=>'error','content'=>$error['content']]);
                }
		    }
        
    }
?>