<?php
    if (!defined('JATBI')) die("Hacking attempt");
    $school_id=$_SESSION['school'];
    $day = $database->select("day", "*",["deleted"=> 0,"status"=>'A']);
   
    $dish = $database->select("dish", "*",["school"        =>$school_id,"deleted"=> 0,"status"=>'A']);
    $food_menu = $database->select("food_menu", "*",["school"        =>$school_id,"deleted"=> 0,"status"=>'A']);
    $typemenu = $database->select("typemenu", "*",["school"=>$school_id,"deleted"=> 0,"status"=>'A']);
    $priority_object= $database->select("priority_object", "*",["school"=>$school_id,"deleted"=> 0,"status"=>'A']);
    $religion= $database->select("religion", "*",["deleted"=> 0,"status"=>'A']);
    $ethnic= $database->select("ethnic", "*",["deleted"=> 0,"status"=>'A']);
    $nationality= $database->select("nationality", "*",["deleted"=> 0,"status"=>'A']);
    $province = $database->select("province", "*",["deleted"=> 0,"status"=>'A']);
    $district = $database->select("district", "*",["deleted"=> 0,"status"=>'A']);
    $ward = $database->select("ward", "*",["deleted"=> 0,"status"=>'A']);
    $units = $database->select("unit_food", "*",["deleted"=> 0,"status"=>'A',"school"=>$school_id]);
	$category_food = $database->select("category_food", "*",["deleted"=> 0,"status"=>'A',"school"=>$school_id]);
	$suppliers = $database->select("supplier_food", "*",["deleted"=> 0,"status"=>'A',"school"=>$school_id]);
    $vendors = $database->select("supplier_food", "*",["deleted"=> 0,"status"=>'A',"school"=>$school_id]);
    $accountants = $database->select("accountants_code", "*",["deleted"=> 0,"status"=>'A']);
	$type_payments = $database->select("type_payments", "*",["school"        =>$school_id,"type"=> 2,"deleted"=> 0,"main"=>0,"status"=>'A']);
    if($router['1']=='dish'){
        $jatbi->permission('dish');
        $count = $database->count("dish",[
            'AND' => [
                "deleted"       => 0,
            ]]
        );
        $pg = $_GET['pg'];
        if (!$pg) $pg = 1;
        $datas = $database->select("dish", "*",[
            "AND" => [
                "OR"=>[
                   
                    'name[~]'    => ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),                  
                ],
                'status'        => ($xss->xss($_GET['status'])=='')?[A,D]:$xss->xss($_GET['status']), 
                "deleted"       => 0,
                "school"        =>$school_id,
            ],
            "LIMIT" =>[(($pg-1)*$setting['site_page']),$setting['site_page']],
            "ORDER" => [
                "id"=>"DESC",
            ]
        ]);
        $page = $jatbi->pages($count,$setting['site_page'],$pg);
        $templates = $setting['site_backend'].'kitchen.tpl';
    }
    elseif($router['1']=='dish-add'){
        $jatbi->permission('dish.add');
        $ajax = 'true';
        if(isset($_POST['token'])){
            $handle = new Upload($_FILES['avatar']);
            if($_POST['token']!=$_SESSION['csrf']['token']){
                echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
            }
            elseif($_POST['name'] == "" ){
                echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
            }
            if($handle->uploaded){
		        $handle->allowed 		= array('application/msword', 'image/*');
		        $handle->Process($upload['images']['avatar']['url']);
		    }
            if ($handle->processed  && $_POST['name']) {
                $img = $setting['site_url'].$upload['images']['avatar']['url'].$handle->file_dst_name;
                $insert = [                  
                    "name"         => $xss->xss($_POST['name']),
                    "avatar"        => $img,                                     
                    "status"        => $xss->xss($_POST['status']),
                    "school"        =>$school_id,
                ];
                $database->insert("dish",$insert);
                $jatbi->logs('dish','add',$insert);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            }
        } 
        else {
            $templates = $setting['site_backend'].'kitchen.tpl';
        }
    }
    elseif($router['1']=='dish-edit'){
        $jatbi->permission('dish.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("dish", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if(isset($_POST['token'])){
                    $partten = "/^[A-Za-z0-9_\.]{".$setting['site_characters'].",32}$/";
                    
                    $handle = new Upload($_FILES['avatar']);
                    if($_POST['token']!=$_SESSION['csrf']['token']){
                        echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
                    }
                    elseif($_POST['name'] == "" ){
                        echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
                    }
                    if($handle->uploaded){
                        $handle->allowed 		= array('application/msword', 'image/*');
                        $handle->Process($upload['images']['avatar']['url']);
                    }
                    if ($handle->processed  && $_POST['name']) {
                        $img = $setting['site_url'].$upload['images']['avatar']['url'].$handle->file_dst_name;
                        $insert = [                  
                            "name"         => $xss->xss($_POST['name']),    
                            "avatar"        => $img,                              
                            "status"        => $xss->xss($_POST['status']),
                            "school"        =>$school_id,
                        ];
                        $database->update("dish",$insert,["id"=>$data['id']]);
                        $jatbi->logs('dish','edit',$insert);
                        echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
                    }
                } else {
                    $templates = $setting['site_backend'].'kitchen.tpl';
                }
            }
            else {
                header("HTTP/1.0 404 Not Found");
                die();
            }
        }
    }
    elseif($router['1']=='dish-delete'){
        $jatbi->permission('dish.delete');
        $ajax = 'true';
        if($router['2']){
            $datas = $database->select("dish","*",["id"=>explode(',', $xss->xss($router['2']))]);
            if(isset($_POST['submit'])){
                $jatbi->logs('dish','delete',$datas);
                $database->update("dish",["deleted" => 1,],["id"=>explode(',', $xss->xss($router['2']))]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            } else {
                $templates = $setting['site_backend'].'kitchen.tpl';
            }
        }
        else {
            header("HTTP/1.0 404 Not Found");
            die();
        }
    }
    elseif($router['1']=='dish-status'){
        $jatbi->permission('dish.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("dish", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if($data['status']==='A'){
                    $status = "D";
                } 
                elseif($data['status']==='D'){
                    $status = "A";
                }
                $database->update("dish",["status"=>$status],["id"=>$data['id']]);
                $jatbi->logs('dish','status',["data"=>$data,"status"=>$status]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-trang-thai'],'sound'=>$setting['site_sound']]);
            }
            else {
                echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-that-bai'],]);
            }
        }
    }
    elseif($router['1']=='food_menu'){
        $jatbi->permission('food_menu');
        $count = $database->count("food_menu",[
            'AND' => [
                "deleted"       => 0,
            ]]
        );
        $pg = $_GET['pg'];
        if (!$pg) $pg = 1;
        $datas = $database->select("food_menu", "*",[
            "AND" => [
                "OR"=>[
                    'id[~]'       => ($xss->xss($_GET['id'])=='')?'%':$xss->xss($_GET['id']),
                    'date_start[~]'    => ($xss->xss($_GET['date_start'])=='')?'%':$xss->xss($_GET['date_start']),
                    'date_end[~]'    => ($xss->xss($_GET['date_end'])=='')?'%':$xss->xss($_GET['date_end']),                                                         
                ],
                'type[<>]'=> ($xss->xss($_GET['type'])=='')?:[$xss->xss($_GET['type']),$xss->xss($_GET['type'])], 
                
                'status'        => ($xss->xss($_GET['status'])=='')?[A,D]:$xss->xss($_GET['status']), 
                "deleted"       => 0,
                "school"        =>$school_id,
            ],
            "LIMIT" =>[(($pg-1)*$setting['site_page']),$setting['site_page']],
            "ORDER" => [
                "id"=>"DESC",
            ]
        ]);
        $page = $jatbi->pages($count,$setting['site_page'],$pg);
        $templates = $setting['site_backend'].'kitchen.tpl';
    }
    elseif($router['1']=='food_menu-add'){
        $jatbi->permission('food_menu.add');
        $ajax = 'true';
        if(isset($_POST['token'])){
            $handle = new Upload($_FILES['avatar']);
            if($_POST['token']!=$_SESSION['csrf']['token']){
                echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
            }
            elseif($_POST['date_start'] == "" || $_POST['date_end'] == "" || $_POST['name'] == "" ){
                echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
            }
            if ($handle->processed  && $_POST['date_start'] && $_POST['date_end'] && $_POST['name'] ) {
                $insert = [                  
                    
                    "date_start"      => date('Y-m-d',strtotime(str_replace('/','-',$_POST['date_start']))),
                    "date_end"      => date('Y-m-d',strtotime(str_replace('/','-',$_POST['date_end']))),
                    "name"         => $xss->xss($_POST['name']),                  
                    "status"        => $xss->xss($_POST['status']),
                    "school"        =>$school_id,
                ];
                $database->insert("food_menu",$insert);
                $jatbi->logs('food_menu','add',$insert);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            }
        } 
        else {
            $templates = $setting['site_backend'].'kitchen.tpl';
        }
    }
    elseif($router['1']=='food_menu-edit'){
        $jatbi->permission('food_menu.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("food_menu", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if(isset($_POST['token'])){
                    $partten = "/^[A-Za-z0-9_\.]{".$setting['site_characters'].",32}$/";
                    
                    $handle = new Upload($_FILES['avatar']);
                    if($_POST['token']!=$_SESSION['csrf']['token']){
                        echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
                    }
                    elseif($_POST['date_start'] == "" || $_POST['date_end'] == "" || $_POST['name'] == "" ){
                        echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
                    }
                    if ($handle->processed  && $_POST['date_start'] && $_POST['date_end'] && $_POST['name'] ) {
                        $insert = [                  
                            
                            "date_start"      => date('Y-m-d',strtotime(str_replace('/','-',$_POST['date_start']))),
                            "date_end"      => date('Y-m-d',strtotime(str_replace('/','-',$_POST['date_end']))),
                            "name"         => $xss->xss($_POST['name']),                  
                            "status"        => $xss->xss($_POST['status']),
                            "school"        =>$school_id,
                        ];
                        $database->update("food_menu",$insert,["id"=>$data['id']]);
                        $jatbi->logs('food_menu','edit',$insert);
                        echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
                    }
                } else {
                    $templates = $setting['site_backend'].'kitchen.tpl';
                }
            }
            else {
                header("HTTP/1.0 404 Not Found");
                die();
            }
        }
    }
    elseif($router['1']=='food_menu-delete'){
        $jatbi->permission('food_menu.delete');
        $ajax = 'true';
        if($router['2']){
            $datas = $database->select("food_menu","*",["id"=>explode(',', $xss->xss($router['2']))]);
            if(isset($_POST['submit'])){
                $jatbi->logs('food_menu','delete',$datas);
                $database->update("food_menu",["deleted" => 1,],["id"=>explode(',', $xss->xss($router['2']))]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            } else {
                $templates = $setting['site_backend'].'kitchen.tpl';
            }
        }
        else {
            header("HTTP/1.0 404 Not Found");
            die();
        }
    }
    elseif($router['1']=='food_menu-status'){
        $jatbi->permission('food_menu.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("food_menu", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if($data['status']==='A'){
                    $status = "D";
                } 
                elseif($data['status']==='D'){
                    $status = "A";
                }
                $database->update("food_menu",["status"=>$status],["id"=>$data['id']]);
                $jatbi->logs('food_menu','status',["data"=>$data,"status"=>$status]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-trang-thai'],'sound'=>$setting['site_sound']]);
            }
            else {
                echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-that-bai'],]);
            }
        }
    }
    elseif($router['1']=='food_menu-detail'){
        if ($router['2']) {
            $_SESSION['router'] = $router['2'];  
            $count = $database->count(
                "food_menu_detail",
                [
                    'AND' => [
                        "food_menu"=>$xss->xss($router['2']),
                        "deleted" => 0,                                  
                    ]
                ]
            );
            $pg = $_GET['pg'];
            if (!$pg)
                $pg = 1;
            $datas = $database->select("food_menu_detail", "*", [
                "AND" => [
                    "OR" => [
                        'id[~]' => ($xss->xss($_GET['id']) == '') ? '%' : $xss->xss($_GET['id']),                        
                    ],
                    'food_menu[<>]' => ($xss->xss($_GET['food_menu']) == '') ?: [$xss->xss($_GET['food_menu']), $xss->xss($_GET['food_menu'])],
                    'day[<>]' => ($xss->xss($_GET['day']) == '') ?: [$xss->xss($_GET['day']), $xss->xss($_GET['day'])],
                    'dish[<>]' => ($xss->xss($_GET['dish']) == '') ?: [$xss->xss($_GET['dish']), $xss->xss($_GET['dish'])],
                    'status' => ($xss->xss($_GET['status']) == '') ? [A, D] : $xss->xss($_GET['status']),
                    "deleted" => 0,
                    "food_menu"=>$xss->xss($router['2']),
                    "school"        =>$school_id,
                ],
                "LIMIT" => [(($pg - 1) * $setting['site_page']), $setting['site_page']],
                "ORDER" => [
                    "id" => "DESC",
                ]
            ]);
            $page = $jatbi->pages($count, $setting['site_page'], $pg);
            $templates = $setting['site_backend'] . 'kitchen.tpl';

        }
        
    }
    elseif($router['1']=='food_menu_detail-add'){
        
        $ajax = 'true';

         $food_menu = $database->select("food_menu", "*", [
            "id" =>  $_SESSION['router'],
            "deleted" => 0,
            "status" => 'A'
        ]); 
            if(isset($_POST['token'])){
                $handle = new Upload($_FILES['avatar']);
                if($_POST['token']!=$_SESSION['csrf']['token']){
                    echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
                }
                elseif($_POST['food_menu'] == "" || $_POST['day'] == "" || $_POST['dish'] == "" ){
                    echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
                }
                if ($handle->processed  && $_POST['day'] && $_POST['dish'] && $_POST['food_menu']) {
                    $insert = [                  
                        
                        "food_menu"      => $xss->xss($_POST['food_menu']), 
                        "day"         => $xss->xss($_POST['day']),                
                        "dish"         => $xss->xss($_POST['dish']),
                        "typemenu"         => $xss->xss($_POST['typemenu']),
                        "school"        =>$school_id,
                        "status"        => $xss->xss($_POST['status']),
                    ];
                    $database->insert("food_menu_detail",$insert);
                    $jatbi->logs('food_menu_detail','add',$insert);
                    echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
                }
            } 
            else {
                $templates = $setting['site_backend'].'kitchen.tpl';
            }
        
    }
    elseif($router['1']=='food_menu_detail-edit'){
        $ajax = 'true';
        $food_menu = $database->select("food_menu", "*", [
            "id" =>  $_SESSION['router'],
            "deleted" => 0,
            "status" => 'A'
        ]);
        if($router['2']){
            $data = $database->get("food_menu_detail", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if(isset($_POST['token'])){
                    $partten = "/^[A-Za-z0-9_\.]{".$setting['site_characters'].",32}$/";
                    
                    $handle = new Upload($_FILES['avatar']);
                    if($_POST['token']!=$_SESSION['csrf']['token']){
                        echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
                    }
                    elseif($_POST['food_menu'] == "" || $_POST['day'] == "" || $_POST['dish'] == "" ){
                        echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
                    }
                    if ($handle->processed  && $_POST['day'] && $_POST['dish'] && $_POST['food_menu']) {
                        $insert = [                  
                            
                            "food_menu"      => $xss->xss($_POST['food_menu']), 
                            "day"         => $xss->xss($_POST['day']),                
                            "dish"         => $xss->xss($_POST['dish']),
                            "typemenu"         => $xss->xss($_POST['typemenu']),
                            "school"        =>$school_id,
                            "status"        => $xss->xss($_POST['status']),
                        ];
                        $database->update("food_menu_detail",$insert,["id"=>$data['id']]);
                        $jatbi->logs('food_menu_detail','edit',$insert);
                        echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
                    }
                } else {
                    $templates = $setting['site_backend'].'kitchen.tpl';
                }
            }
            else {
                header("HTTP/1.0 404 Not Found");
                die();
            }
        }
    }
    elseif($router['1']=='food_menu_detail-delete'){
        $ajax = 'true';
        if($router['2']){
            $datas = $database->select("food_menu_detail","*",["id"=>explode(',', $xss->xss($router['2']))]);
            if(isset($_POST['submit'])){
                $jatbi->logs('food_menu_detail','delete',$datas);
                $database->update("food_menu_detail",["deleted" => 1,],["id"=>explode(',', $xss->xss($router['2']))]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            } else {
                $templates = $setting['site_backend'].'kitchen.tpl';
            }
        }
        else {
            header("HTTP/1.0 404 Not Found");
            die();
        }
    }
    elseif($router['1']=='food_menu_detail-status'){
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("food_menu_detail", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if($data['status']==='A'){
                    $status = "D";
                } 
                elseif($data['status']==='D'){
                    $status = "A";
                }
                $database->update("food_menu_detail",["status"=>$status],["id"=>$data['id']]);
                $jatbi->logs('food_menu_detail','status',["data"=>$data,"status"=>$status]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-trang-thai'],'sound'=>$setting['site_sound']]);
            }
            else {
                echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-that-bai'],]);
            }
        }
    }
    elseif($router['1']=='unit_food'){
        $jatbi->permission('unit_food');
        $count = $database->count("unit_food",[
            'AND' => [
                'name[~]'  		=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']), 
                "deleted"       => 0,
            ]]
        );
        $pg = $_GET['pg'];
        if (!$pg) $pg = 1;
        $datas = $database->select("unit_food", "*",[
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
        $templates = $setting['site_backend'].'kitchen.tpl';
    }
    elseif($router['1']=='unit_food-add'){
        $jatbi->permission('unit_food.add');
        $ajax = 'true';
        if(isset($_POST['token'])){
            if($_POST['token']!=$_SESSION['csrf']['token']){
                echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
            }
            elseif($_POST['name'] == "" ){
                echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
            }
            if ($_POST['name']) {
                $insert = [                  
                    "name"          => $xss->xss($_POST['name']),
                    "notes"          => $xss->xss($_POST['notes']),                                  
                    "status"        => $xss->xss($_POST['status']),
                    "school"        =>$school_id,
                ];
                $database->insert("unit_food",$insert);
                $jatbi->logs('unit_food','add',$insert);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            }
        } 
        else {
            $templates = $setting['site_backend'].'kitchen.tpl';
        }
    }
    elseif($router['1']=='unit_food-edit'){
        $jatbi->permission('unit_food.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("unit_food", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if(isset($_POST['token'])){
                    $partten = "/^[A-Za-z0-9_\.]{".$setting['site_characters'].",32}$/";
                    
                    $handle = new Upload($_FILES['avatar']);
                    if($_POST['token']!=$_SESSION['csrf']['token']){
                        echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
                    }
                    elseif($_POST['name'] == "" ){
                        echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
                    }
                    if ($handle->processed  && $_POST['name']) {
                        $insert = [                  
                            "name"          => $xss->xss($_POST['name']),
                            "notes"          => $xss->xss($_POST['notes']),                                  
                            "status"        => $xss->xss($_POST['status']),
                            "school"        =>$school_id,
                        ];
                        $database->update("unit_food",$insert,["id"=>$data['id']]);
                        $jatbi->logs('unit_food','edit',$insert);
                        echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
                    }
                } else {
                    $templates = $setting['site_backend'].'kitchen.tpl';
                }
            }
            else {
                header("HTTP/1.0 404 Not Found");
                die();
            }
        }
    }
    elseif($router['1']=='unit_food-delete'){
        $jatbi->permission('unit_food.delete');
        $ajax = 'true';
        if($router['2']){
            $datas = $database->select("unit_food","*",["id"=>explode(',', $xss->xss($router['2']))]);
            if(isset($_POST['submit'])){
                $jatbi->logs('unit_food','delete',$datas);
                $database->update("unit_food",["deleted" => 1,],["id"=>explode(',', $xss->xss($router['2']))]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            } else {
                $templates = $setting['site_backend'].'kitchen.tpl';
            }
        }
        else {
            header("HTTP/1.0 404 Not Found");
            die();
        }
    }
    elseif($router['1']=='unit_food-status'){
        $jatbi->permission('unit_food.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("unit_food", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if($data['status']==='A'){
                    $status = "D";
                } 
                elseif($data['status']==='D'){
                    $status = "A";
                }
                $database->update("unit_food",["status"=>$status],["id"=>$data['id']]);
                $jatbi->logs('unit_food','status',["data"=>$data,"status"=>$status]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-trang-thai'],'sound'=>$setting['site_sound']]);
            }
            else {
                echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-that-bai'],]);
            }
        }
    }
    elseif($router['1']=='category_food'){
        $jatbi->permission('category_food');
        $count = $database->count("category_food",[
            'AND' => [
                'name[~]'  		=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']), 
                "deleted"       => 0,
            ]]
        );
        $pg = $_GET['pg'];
        if (!$pg) $pg = 1;
        $datas = $database->select("category_food", "*",[
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
        $templates = $setting['site_backend'].'kitchen.tpl';
    }
    elseif($router['1']=='category_food-add'){
        $jatbi->permission('category_food.add');
        $ajax = 'true';
        if(isset($_POST['token'])){
            if($_POST['token']!=$_SESSION['csrf']['token']){
                echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
            }
            elseif($_POST['name'] == "" ){
                echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
            }
            if ($_POST['name']) {
                $insert = [                  
                    "name"          => $xss->xss($_POST['name']),
                    "notes"          => $xss->xss($_POST['notes']),                                  
                    "status"        => $xss->xss($_POST['status']),
                    "school"        =>$school_id,
                ];
                $database->insert("category_food",$insert);
                $jatbi->logs('category_food','add',$insert);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            }
        } 
        else {
            $templates = $setting['site_backend'].'kitchen.tpl';
        }
    }
    elseif($router['1']=='category_food-edit'){
        $jatbi->permission('category_food.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("category_food", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if(isset($_POST['token'])){
                    $partten = "/^[A-Za-z0-9_\.]{".$setting['site_characters'].",32}$/";
                    
                    $handle = new Upload($_FILES['avatar']);
                    if($_POST['token']!=$_SESSION['csrf']['token']){
                        echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
                    }
                    elseif($_POST['name'] == "" ){
                        echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
                    }
                    if ($handle->processed  && $_POST['name']) {
                        $insert = [                  
                            "name"          => $xss->xss($_POST['name']),
                            "notes"          => $xss->xss($_POST['notes']),                                  
                            "status"        => $xss->xss($_POST['status']),
                            "school"        =>$school_id,
                        ];
                        $database->update("category_food",$insert,["id"=>$data['id']]);
                        $jatbi->logs('category_food','edit',$insert);
                        echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
                    }
                } else {
                    $templates = $setting['site_backend'].'kitchen.tpl';
                }
            }
            else {
                header("HTTP/1.0 404 Not Found");
                die();
            }
        }
    }
    elseif($router['1']=='category_food-delete'){
        $jatbi->permission('category_food.delete');
        $ajax = 'true';
        if($router['2']){
            $datas = $database->select("category_food","*",["id"=>explode(',', $xss->xss($router['2']))]);
            if(isset($_POST['submit'])){
                $jatbi->logs('category_food','delete',$datas);
                $database->update("category_food",["deleted" => 1,],["id"=>explode(',', $xss->xss($router['2']))]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            } else {
                $templates = $setting['site_backend'].'kitchen.tpl';
            }
        }
        else {
            header("HTTP/1.0 404 Not Found");
            die();
        }
    }
    elseif($router['1']=='category_food-status'){
        $jatbi->permission('category_food.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("category_food", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if($data['status']==='A'){
                    $status = "D";
                } 
                elseif($data['status']==='D'){
                    $status = "A";
                }
                $database->update("category_food",["status"=>$status],["id"=>$data['id']]);
                $jatbi->logs('category_food','status',["data"=>$data,"status"=>$status]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-trang-thai'],'sound'=>$setting['site_sound']]);
            }
            else {
                echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-that-bai'],]);
            }
        }
    }
    elseif($router['1']=='supplier_food'){
        $jatbi->permission('supplier_food');
        $count = $database->count("supplier_food",[
            'AND' => [
                'name[~]'  		=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']), 
                "deleted"       => 0,
            ]]
        );
        $pg = $_GET['pg'];
        if (!$pg) $pg = 1;
        $datas = $database->select("supplier_food", "*",[
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
        $templates = $setting['site_backend'].'kitchen.tpl';
    }
    elseif($router['1']=='supplier_food-add'){
        $jatbi->permission('supplier_food.add');
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
                $database->insert("supplier_food",$insert);
                $jatbi->logs('supplier_food','add',$insert);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            }
        } 
        else {
            $templates = $setting['site_backend'].'kitchen.tpl';
        }
    }
    elseif($router['1']=='supplier_food-edit'){
        $jatbi->permission('supplier_food.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("supplier_food", "*",["id"=>$xss->xss($router['2'])]);
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
                        $database->update("supplier_food",$insert,["id"=>$data['id']]);
                        $jatbi->logs('supplier_food','edit',$insert);
                        echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
                    }
                } else {
                    $templates = $setting['site_backend'].'kitchen.tpl';
                }
            }
            else {
                header("HTTP/1.0 404 Not Found");
                die();
            }
        }
    }
    elseif($router['1']=='supplier_food-delete'){
        $jatbi->permission('supplier_food.delete');
        $ajax = 'true';
        if($router['2']){
            $datas = $database->select("supplier_food","*",["id"=>explode(',', $xss->xss($router['2']))]);
            if(isset($_POST['submit'])){
                $jatbi->logs('supplier_food','delete',$datas);
                $database->update("supplier_food",["deleted" => 1,],["id"=>explode(',', $xss->xss($router['2']))]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            } else {
                $templates = $setting['site_backend'].'kitchen.tpl';
            }
        }
        else {
            header("HTTP/1.0 404 Not Found");
            die();
        }
    }
    elseif($router['1']=='supplier_food-status'){
        $jatbi->permission('supplier_food.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("supplier_food", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if($data['status']==='A'){
                    $status = "D";
                } 
                elseif($data['status']==='D'){
                    $status = "A";
                }
                $database->update("supplier_food",["status"=>$status],["id"=>$data['id']]);
                $jatbi->logs('supplier_food','status',["data"=>$data,"status"=>$status]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-trang-thai'],'sound'=>$setting['site_sound']]);
            }
            else {
                echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-that-bai'],]);
            }
        }
    }
    elseif($router['1']=='chef'){
        $jatbi->permission('chef');
        $count = $database->count("chef",[
            'AND' => [
                "deleted"       => 0,
                "school"=>$school_id,
            ]]
        );
        $pg = $_GET['pg'];
        if (!$pg) $pg = 1;
     
        $datas= $database->select("chef", "*",[
            "AND" => [
                "OR"=>[
                    'name[~]'    => ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
                    'birthday[~]'      => ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
                    'gender[~]'      => ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
                    'phone_number[~]'      => ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
                ],
                'status'        => ($xss->xss($_GET['status'])=='')?[A,D]:$xss->xss($_GET['status']), 
                "deleted"       => 0,
                "school"=>$school_id,
            ],
            "LIMIT" =>[(($pg-1)*$setting['site_page']),$setting['site_page']],
            "ORDER" => [    
                "id"=>"DESC",
            ]
        ]);
        
        $page = $jatbi->pages($count,$setting['site_page'],$pg);
        $templates = $setting['site_backend'].'kitchen.tpl';
    }
    elseif($router['1']=='chef-add'){
        $jatbi->permission('chef.add');
        $ajax = 'true';
        if(isset($_POST['token'])){
            $handle = new Upload($_FILES['avatar']);
            if($_POST['token']!=$_SESSION['csrf']['token']){
                echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
            }
            elseif($_POST['name'] == "" || $_POST['gender'] == "" || $_POST['birthday'] == "" || $_POST['phone_number'] == ""|| $_POST['address'] == "" || $_POST['province'] == "" || $_POST['district'] == "" || $_POST['ward'] == "" || $_POST['citizenId'] == ""  || $_POST['date_start_work'] == ""|| $_POST['regent'] == ""){
                echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
            }
            if ($handle->uploaded) {
                $handle->allowed        = array('application/msword', 'image/*');
                $handle->Process($upload['images']['avatar']['url']);
                $handle->image_resize   = true;
                $handle->image_ratio_crop  = true;
                $handle->image_y        = $upload['images']["avatar"]['thumb_y'];
                $handle->image_x        = $upload['images']["avatar"]['thumb_x'];
                $handle->allowed        = array('application/msword', 'image/*');
                $handle->Process($upload['images']['avatar']['url'].'thumb/');
            }
            if ($handle->processed && $_POST['name'] && $_POST['gender'] && $_POST['birthday'] && $_POST['phone_number'] && $_POST['address'] && $_POST['regent'] && $_POST['province'] && $_POST['district'] && $_POST['ward'] && $_POST['citizenId']  && $_POST['date_start_work']) {
                $img = $setting['site_url'].$upload['images']['avatar']['url'].$handle->file_dst_name;
                $insert = [
                    "name"          => $xss->xss($_POST['name']),
                    "birthday"      => date('Y-m-d',strtotime(str_replace('/','-',$_POST['birthday']))),      
                    "gender"        => $xss->xss($_POST['gender']),  
                    "phone_number"          => $xss->xss($_POST['phone_number']),
                    "citizenId"         => $xss->xss($_POST['citizenId']),
                    "date_start_work"          => date('Y-m-d H:i:s'),
                    "email"         => $xss->xss($_POST['email']), 
                    "address"         => $xss->xss($_POST['address']),
                    "province"         => $xss->xss($_POST['province']),
                    "district"         => $xss->xss($_POST['district']),
                    "ward"         => $xss->xss($_POST['ward']),                       
                    "avatar"        => $img,    
                    "nationality"         => $xss->xss($_POST['nationality']),
                    "ethnic"         => $xss->xss($_POST['ethnic']),
                    "religion"         => $xss->xss($_POST['religion']),     
                    "regent"         => $xss->xss($_POST['regent']),           
                    "status"        => $xss->xss($_POST['status']),
                    "school"=>$school_id,
                   
                ];
                $database->insert("chef",$insert);
                $jatbi->logs('chef','add',$insert);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            }
        } 
        else {
            $templates = $setting['site_backend'].'kitchen.tpl';
        }
    }
    elseif($router['1']=='chef-edit'){
        $jatbi->permission('chef.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("chef", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if(isset($_POST['token'])){
                    $handle = new Upload($_FILES['avatar']);
            if($_POST['token']!=$_SESSION['csrf']['token']){
                echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
            }
            elseif($_POST['name'] == "" || $_POST['gender'] == "" || $_POST['birthday'] == "" || $_POST['phone_number'] == ""|| $_POST['address'] == "" || $_POST['province'] == "" || $_POST['district'] == "" || $_POST['ward'] == "" || $_POST['citizenId'] == ""  || $_POST['date_start_work'] == ""|| $_POST['regent'] == ""){
                echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
            }
            if ($handle->uploaded) {
                $handle->allowed        = array('application/msword', 'image/*');
                $handle->Process($upload['images']['avatar']['url']);
                $handle->image_resize   = true;
                $handle->image_ratio_crop  = true;
                $handle->image_y        = $upload['images']["avatar"]['thumb_y'];
                $handle->image_x        = $upload['images']["avatar"]['thumb_x'];
                $handle->allowed        = array('application/msword', 'image/*');
                $handle->Process($upload['images']['avatar']['url'].'thumb/');
            }
            if ($handle->processed && $_POST['name'] && $_POST['gender'] && $_POST['birthday'] && $_POST['phone_number'] && $_POST['address'] && $_POST['regent'] && $_POST['province'] && $_POST['district'] && $_POST['ward'] && $_POST['citizenId']  && $_POST['date_start_work']) {
                $img = $setting['site_url'].$upload['images']['avatar']['url'].$handle->file_dst_name;
                $insert = [
                    "name"          => $xss->xss($_POST['name']),
                    "birthday"      => date('Y-m-d',strtotime(str_replace('/','-',$_POST['birthday']))),      
                    "gender"        => $xss->xss($_POST['gender']),  
                    "phone_number"          => $xss->xss($_POST['phone_number']),
                    "citizenId"         => $xss->xss($_POST['citizenId']),
                    "date_start_work"          => date('Y-m-d H:i:s'),
                    "email"         => $xss->xss($_POST['email']), 
                    "address"         => $xss->xss($_POST['address']),
                    "province"         => $xss->xss($_POST['province']),
                    "district"         => $xss->xss($_POST['district']),
                    "ward"         => $xss->xss($_POST['ward']),                       
                    "avatar"        => $img,    
                    "nationality"         => $xss->xss($_POST['nationality']),
                    "ethnic"         => $xss->xss($_POST['ethnic']),
                    "religion"         => $xss->xss($_POST['religion']),     
                    "regent"         => $xss->xss($_POST['regent']),           
                    "status"        => $xss->xss($_POST['status']),
                    "school"=>$school_id,
                   
                ];
                        $database->update("chef",$insert,["id"=>$data['id']]);
                        $jatbi->logs('chef','edit',$insert);
                        echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
                    }
                } else {
                    $templates = $setting['site_backend'].'kitchen.tpl';
                }
            }
            else {
                header("HTTP/1.0 404 Not Found");
                die();
            }
        }
    }
    elseif($router['1']=='chef-delete'){
        $jatbi->permission('chef.delete');
        $ajax = 'true';
        if($router['2']){
            $datas = $database->select("chef","*",["id"=>explode(',', $xss->xss($router['2']))]);
            if(isset($_POST['submit'])){
                $jatbi->logs('chef','delete',$datas);
                $database->update("chef",["deleted" => 1,],["id"=>explode(',', $xss->xss($router['2']))]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            } else {
                $templates = $setting['site_backend'].'kitchen.tpl';
            }
        }
        else {
            header("HTTP/1.0 404 Not Found");
            die();
        }
    }
    elseif($router['1']=='chef-status'){
        $jatbi->permission('chef.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("chef", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if($data['status']==='A'){
                    $status = "D";
                } 
                elseif($data['status']==='D'){
                    $status = "A";
                }
                $database->update("chef",["status"=>$status],["id"=>$data['id']]);
                $jatbi->logs('chef','status',["data"=>$data,"status"=>$status]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-trang-thai'],'sound'=>$setting['site_sound']]);
            }
            else {
                echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-that-bai'],]);
            }
        }
    }
    elseif($router['1']=='food_warehouse'){
		$jatbi->permission('food_warehouse');
		$count = $database->count("food_warehouse",[
			'AND' => [
				"OR"=>[
					'name[~]'  		=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),  
				], 
				
				"deleted"		=> 0,
				"type"			=> 1,
				'school'		=> ($xss->xss($_GET['school'])=='')?$school_id:[$xss->xss($_GET['school']),$xss->xss($_GET['school'])], 
			]
		]);
		$pg = $_GET['pg'];
		if (!$pg) $pg = 1;
		$datas = $database->select("food_warehouse", "*",[
			'AND' => [
				"OR"=>[
					'name[~]'  		=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),  
				],				 
				'category_food[<>]'	=> ($xss->xss($_GET['category_food'])=='')?:[$xss->xss($_GET['category_food']),$xss->xss($_GET['category_food'])], 
				'unit_food[<>]'		=> ($xss->xss($_GET['unit_food'])=='')?:[$xss->xss($_GET['unit_food']),$xss->xss($_GET['unit_food'])],
				'supplier_food[<>]'		=> ($xss->xss($_GET['supplier_food'])=='')?:[$xss->xss($_GET['supplier_food']),$xss->xss($_GET['supplier_food'])],  
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
		$templates = $setting['site_backend'].'kitchen.tpl';
	}
	elseif($router['1']=='food_warehouse-add'){
		$jatbi->permission('food_warehouse.add');
		$ajax = 'true';
		//$type = $router['2'];
		if(isset($_POST['token'])){
		    $handle = new Upload($_FILES['images']);
			if($_POST['token']!=$_SESSION['csrf-token']){
				echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
			}
		    elseif($_POST['id_food'] == "" ||$_POST['name'] == "" || $_POST['category_device'] == "" || $_POST['units'] == "" || $_POST['supplier'] == "" || $_POST['status'] == ""){
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
		    if($handle->processed && $_POST['id_food'] && $_POST['name'] && $_POST['category_device'] && $_POST['units'] && $_POST['supplier'] && $_POST['status']){
		    	$insert = [
					"type" 				=> 1,
                    "name" 				=> $xss->xss($_POST['name']),
					"id_food" 				=> $xss->xss($_POST['id_food']),
					"category_food" 	=> $xss->xss($_POST['category_device']),
					"unit_food" 			=> $xss->xss($_POST['units']),
					"images"			=> $handle->file_dst_name==''?'no-images.jpg':$handle->file_dst_name,
					"date" 				=> date('Y-m-d'),
					"status" 			=> $xss->xss($_POST['status']),
					"supplier_food" 			=> $xss->xss($_POST['supplier']),
					"notes" 			=> $xss->xss($_POST['notes']),
					"account" 			=> $account['id'],
					"school"			=> $school_id,
				];
				$database->insert("food_warehouse",$insert);
				echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
	        }
		} 
		else {
			$templates = $setting['site_backend'].'kitchen.tpl';
		}
	}
	elseif($router['1']=='food_warehouse-edit'){
		$jatbi->permission('food_warehouse.edit');
		$ajax = 'true';
		if($router['2']){
			$data = $database->get("food_warehouse", "*",["id"=>$xss->xss($router['2'])]);
			if($data>1){
				if(isset($_POST['token'])){
					$handle = new Upload($_FILES['images']);
					if($_POST['token']!=$_SESSION['csrf-token']){
						echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
					}
                    elseif($_POST['id_food'] == "" ||$_POST['name'] == "" || $_POST['category_device'] == "" || $_POST['units'] == "" || $_POST['supplier'] == "" || $_POST['status'] == ""){
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
                    if($handle->processed && $_POST['id_food'] && $_POST['name'] && $_POST['category_device'] && $_POST['units'] && $_POST['supplier'] && $_POST['status']){
                        $insert = [
                            "type" 				=> 1,
                            "name" 				=> $xss->xss($_POST['name']),
                            "id_food" 				=> $xss->xss($_POST['id_food']),
                            "category_food" 	=> $xss->xss($_POST['category_device']),
                            "unit_food" 			=> $xss->xss($_POST['units']),
                            "images"			=> $handle->file_dst_name==''?'no-images.jpg':$handle->file_dst_name,
                            "date" 				=> date('Y-m-d'),
                            "status" 			=> $xss->xss($_POST['status']),
                            "supplier_food" 			=> $xss->xss($_POST['supplier']),
                            "notes" 			=> $xss->xss($_POST['notes']),
                            "account" 			=> $account['id'],
                            "school"			=> $school_id,
                        ];
						$database->update("food_warehouse",$insert,["id"=>$data['id']]);
						echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
			        }
				} else {
					$templates = $setting['site_backend'].'kitchen.tpl';
				}
			}
			else {
				header("HTTP/1.0 404 Not Found");
				die();
			}
		}
	}
	elseif($router['1']=='food_warehouse-status'){
		$jatbi->permission('food_warehouse.edit');
		$ajax = 'true';
		if($router['2']){
			$data = $database->get("food_warehouse", "*",["id"=>$xss->xss($router['2'])]);
			if($data>1){
				if($data['status']==='A'){
					$status = "D";
				} 
				elseif($data['status']==='D'){
					$status = "A";
				}
				$database->update("food_warehouse",["status"=>$status],["id"=>$data['id']]);
				$jatbi->logs('food_warehouse','status',["data"=>$data,"status"=>$status]);
				echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-trang-thai'],'sound'=>$setting['site_sound']]);
			}
			else {
				echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-that-bai'],]);
			}
		}
	}
	elseif($router['1']=='food_warehouse-delete'){
		$jatbi->permission('food_warehouse.delete');
		$ajax = 'true';
		if($router['2']){
			$datas = $database->select("food_warehouse","*",["id"=>explode(',', $xss->xss($router['2']))]);
			if(isset($_POST['submit'])){
				$jatbi->logs('food_warehouse','delete',$datas);
				$database->update("food_warehouse",["deleted"	=> 1,],["id"=>explode(',', $xss->xss($router['2']))]);
				echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
			} else {
				$templates = $setting['site_backend'].'kitchen.tpl';
			}
		}
		else {
			header("HTTP/1.0 404 Not Found");
			die();
		}
	}
    elseif($router['1']=='food_import'){
        $jatbi->permission('food_import');
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
                "type"=>1,
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
                "type"=>1,
			],
			"LIMIT" =>[(($pg-1)*$setting['site_page']),$setting['site_page']],
			"ORDER"	=> [
				"id"=>"DESC",
			]
		]);
		$page = $jatbi->pages($count,$setting['site_page'],$pg);
		$templates = $setting['site_backend'].'kitchen.tpl';
	}
    elseif($router['1']=='food_export'){
        $jatbi->permission('food_export');
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
                "type"=>2,
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
                "type"=>2,
                "school"        =>$school_id,
			],
			"LIMIT" =>[(($pg-1)*$setting['site_page']),$setting['site_page']],
			"ORDER"	=> [
				"id"=>"DESC",
			]
		]);
		$page = $jatbi->pages($count,$setting['site_page'],$pg);
		$templates = $setting['site_backend'].'kitchen.tpl';
	}
	elseif($router['1']=='food_import-add'){
		$jatbi->permission('food_import.add');
		$action = "add";
		if($_SESSION['purchase'][$action]['type']==''){
			$_SESSION['purchase'][$action]['type'] = 1;
		}
        if($_SESSION['purchase'][$action]['type_payments_kitchen']==''){
			$_SESSION['purchase'][$action]['type_payments_kitchen'] ="";
		}

        if($_SESSION['purchase'][$action]['discount']==''){
			$_SESSION['purchase'][$action]['discount'] = 0;
		}
		if($_SESSION['purchase'][$action]['date']==''){
			$_SESSION['purchase'][$action]['date'] = date("Y-m-d");
		}
		$data = [
			"type" => $_SESSION['purchase'][$action]['type'],
            "type_payments" => $_SESSION['purchase'][$action]['type_payments_kitchen'],
			"date" => $_SESSION['purchase'][$action]['date'],
			"content" => $_SESSION['purchase'][$action]['content'],
			"vendor" => $_SESSION['purchase'][$action]['vendor'],
			"discount" => $_SESSION['purchase'][$action]['discount'],
			"status" => 1,
		];


			$SelectProducts = $_SESSION['purchase'][$action]['products'];
			$ingredient = $database->select("food_warehouse", "*",["school"        =>$school_id,"deleted"=> 0,"status"=>'A',"supplier_food"=>$data['vendor']]);
		
		$templates = $setting['site_backend'].'kitchen.tpl';
	}
	elseif($router['1']=='food_import-edit'){
		$jatbi->permission('food_import.edit');
		$action = "edit";
		$invoices = $database->get("purchase","*",["id"=>$xss->xss($router['2']),"deleted"=>0]);
		if($invoices>1){
			$Cus = $database->get("supplier_food","*",["id"=>$invoices['vendor']]);
			$Pros = $database->select("purchase_products","*",["purchase"=>$invoices['id'],"deleted"=>0]);
			$Details = $database->select("purchase_details","*",["purchase"=>$invoices['id'],"deleted"=>0]);
			if($_SESSION['purchase'][$action]['order']!=$invoices['id']){
				unset($_SESSION['purchase'][$action]);
				$_SESSION['purchase'][$action]['status'] = $invoices['status'];
				$_SESSION['purchase'][$action]['status_pay'] = $invoices['status_pay'];
				$_SESSION['purchase'][$action]['discount'] = $invoices['discount'];
				$_SESSION['purchase'][$action]['code'] = $invoices['code'];
				$_SESSION['purchase'][$action]['content'] = $invoices['content'];
				$_SESSION['purchase'][$action]['type'] = $invoices['type'];
				$_SESSION['purchase'][$action]['date'] = date("Y-m-d",strtotime($invoices['date']));
				$_SESSION['purchase'][$action]['vendor'] = [
					"id"=>$Cus['id'],
					"name"=>$Cus['name'],
					"phone"=>$Cus['phone_number'],
					"email"=>$Cus['email'],
				];
				foreach ($Pros as $key => $value) {
					$GetPro = $database->get("food_warehouse","*",["id"=>$value['products'],"deleted"=>0]);
					$_SESSION['purchase'][$action]['products'][$value['id']] = [
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
					$_SESSION['purchase'][$action][$detail['type']][] = [
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
				"date" => $_SESSION['purchase'][$action]['date'],
				"discount" => $_SESSION['purchase'][$action]['discount'],
				"content" => $_SESSION['purchase'][$action]['content'],
				"status" => $_SESSION['purchase'][$action]['status'],
			];
			$getCus = $database->get("supplier_food","*",["id"=>$_SESSION['purchase'][$action]['vendor']['id']]);
			$SelectProducts = $_SESSION['purchase'][$action]['products'];
			$templates = $setting['site_backend'].'kitchen.tpl';
		}
		else {
			header("HTTP/1.0 404 Not Found");
			die();
		}
    }
    elseif($router['1']=='purchase-update'){
		$ajax = 'true';
		$action = $router['2'];
		if($router['3']=='vendor'){
			$data = $database->get("supplier_food", "*",["school"        =>$school_id,"id"=>$xss->xss($_POST['value'])]);
			if($data>1){
				unset($_SESSION['purchase'][$action]['products']);
                unset($_SESSION['purchase'][$action]['discount']);
				$_SESSION['purchase'][$action]['vendor'] = [
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
		elseif($router['3']=='products'){
			if($router['4']=='add'){
				$data = $database->get("food_warehouse", "*",["id"=>$xss->xss($_POST['value'])]);
				if($data>1){
					$_SESSION['purchase'][$action]['products'][] = [
						"products"=>$data['id'],
						"amount"=>1,
						"price"=>'',
						"vendor"=>$data['supplier_food'],
						"code"=>$data['code'],
						"name"=>$data['name'],
						"categorys"=>$data['category_food'],
						"units"=>$data['unit_food'],
						"notes"=>$data['notes'],
					];
					echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],]);
				}
				else {
					echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-that-bai'],]);
				}
			}
			elseif($router['4']=='deleted'){
				unset($_SESSION['purchase'][$action]['products'][$router['5']]);
				echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],]);
			}
			elseif($router['4']=='price'){
				$_SESSION['purchase'][$action]['products'][$router['5']][$router['4']] = $xss->xss(str_replace([','],'',$_POST['value']));
				echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],]);
			}
			else {
				$_SESSION['purchase'][$action]['products'][$router['5']][$router['4']] = $xss->xss($_POST['value']);
				echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],]);
			}
		}
		elseif($router['3']=='date' || $router['3']=='discount' || $router['3']=='content'|| $router['3']=='type_payments_kitchen'){
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
			    elseif($_POST['date'] == ""){
					echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
				}
			    if ($_POST['date']) {
			    	$_SESSION['purchase'][$action][$router['4']][] = [
						"code"			=> strtotime(date('Y-m-d H:i:s')),
			    		"type"			=> $router['4'],
						"price" 		=> $xss->xss(str_replace([','],'',$_POST['price'])),
						"content" 		=> $xss->xss($_POST['content']),
						"date" 			=> date('Y-m-d H:i:s',strtotime($xss->xss($_POST['date']))),
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
			foreach ($_SESSION['purchase'][$action]['products'] as $value) {
				$total_products += $value['amount']*$value['price'];
				if($value['amount']=='' || $value['amount']==0){
					$error_warehouses = 'true';
				}
			}
			$discount = ($_SESSION['purchase'][$action]['discount']*$total_products)/100;
			$payments = ($total_products-$total_minus-$discount)+$total_surcharge;
			$payments1 = ($total_ingredient-$total_minus-$discount)+$total_surcharge;
			if($_SESSION['purchase'][$action]['vendor']['id']==''  || $_SESSION['purchase'][$action]['content']==''){
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
					"type"			=> $_SESSION['purchase'][$action]['type'],
					"vendor"		=> $_SESSION['purchase'][$action]['vendor']['id'],
					"code"			=> $code,
					"date"			=> $_SESSION['purchase'][$action]['date'],
					"total"			=> $_SESSION['purchase'][$action]['type']==1?$total_products:$total_ingredient,
					"minus"			=> 0,
					"surcharge"		=> 0,
					"prepay_req"	=> 0,
					"prepay"		=> 0,
					"discount"		=> $_SESSION['purchase'][$action]['discount'],
					"discount_price"=> $discount,
					"payments"		=> $_SESSION['purchase'][$action]['type']==1?$payments:$payments1,
					"user"			=> $account['id'],
					"date_poster"	=> date("Y-m-d H:i:s"),
					"status"		=> 1,
					"status_pay"	=> $_SESSION['purchase'][$action]['status_pay']==0?2:$_SESSION['purchase'][$action]['status_pay'],
					"content"		=> $_SESSION['purchase'][$action]['content'],
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
						"content" 	=> $xss->xss('Mua hàng'),
						"status" 	=> $xss->xss($insert['status']),
						"date"		=> date('Y-m-d H:i:s'),
                        "school"        =>$school_id,
					]);
                    $type_pay = $database->get("type_payments", "*",["school"        =>$school_id,"id"=>$_SESSION['purchase'][$action]['type_payments_kitchen'],"deleted"=> 0,"main"=>0,"status"=>'A']);
                    $inser = [
						"type" 			=> 2,
						"debt" 			=>$type_pay['debt'],
						"has" 			=>$type_pay['has'],
						"price" 		=> $_SESSION['purchase'][$action]['type']==1?'-'.$total_products:'-'.$total_ingredient,
						"content" 		=>  $_SESSION['purchase'][$action]['content'],
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
                        "code"			=> $datas['type'],
                        "type"			=> $datas['type'],
                        "data"			=> "",
                        "stores"		=> "",
                        "branch"		=> "",
                        "stores_receive"=> "",
                        "branch_receive"=> "",
                        "content"		=> $datas['content'],
                        "vendor"		=> $datas['vendor']['id'],
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
					$database->update("purchase",$insertt,["id"=>$_SESSION['purchase'][$action]['order']]);
					$orderIdd = $_SESSION['purchase'][$action]['order'];
					$database->insert("purchase_logs",[
						"purchase" 	=> $orderIdd,
						"user"		=> $account['id'],
						"content" 	=> $xss->xss('Sửa mua hàng'),
						"status" 	=> $xss->xss($insertt['status']),
						"date"		=> date('Y-m-d H:i:s'),
                        "school"        =>$school_id,
					]);
				}
                
				if($_SESSION['purchase'][$action]['type']==1){
				    foreach ($_SESSION['purchase'][$action]['products'] as $key => $value) {
					$getProducts = $database->get("food_warehouse","*",["id"=>$value['products']]);
                    $database->update("food_warehouse",["amounts"=>$getProducts['amounts']+$value['amount']],["school"        =>$school_id,"id"=>$getProducts['id']]);  
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
	elseif($router['1']=='food_import-delete'){
		$jatbi->permission('food_import.delete');
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
				$templates = $setting['site_backend'].'kitchen.tpl';
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
					$templates = $setting['site_backend'].'kitchen.tpl';
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
                    "type"        =>[1,2],
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
                    "type[]"        =>[1,2],
                    "deleted"		=> 0,
                ],
                "LIMIT" =>[(($pg-1)*$setting['site_page']),$setting['site_page']],
                "ORDER"	=> [
                    "id"=>"DESC",
                ]
            ]);
            $page = $jatbi->pages($count,$setting['site_page'],$pg);
            $templates = $setting['site_backend'].'kitchen.tpl';
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
		$templates = $setting['site_backend'].'kitchen.tpl';
	}
    elseif($router['1']=='food_export-add'){
		$jatbi->permission('food_export.add');
		$action = "add";
		if($_SESSION['purchase'][$action]['typee']==''){
			$_SESSION['purchase'][$action]['typee'] = 2;
		}
        if($_SESSION['purchase'][$action]['discountt']==''){
			$_SESSION['purchase'][$action]['discountt'] = 0;
		}
        if($_SESSION['purchase'][$action]['food_menu']==''){
			$_SESSION['purchase'][$action]['food_menu'] = '';
		}
		if($_SESSION['purchase'][$action]['datee']==''){
			$_SESSION['purchase'][$action]['datee'] = date("Y-m-d");
		}
		$data = [
			"type" => $_SESSION['purchase'][$action]['typee'],
			"date" => $_SESSION['purchase'][$action]['datee'],
			"content" => $_SESSION['purchase'][$action]['contentt'],
			"food_menu" => $_SESSION['purchase'][$action]['food_menu'],
			"discount" => $_SESSION['purchase'][$action]['discountt'],
			"status" => 1,
		];


			$SelectProducts = $_SESSION['purchase'][$action]['productss'];
			$ingredient = $database->select("food_warehouse", "*",["amounts[>]"=>0,"school"        =>$school_id,"deleted"=> 0,"status"=>'A']);
		
		$templates = $setting['site_backend'].'kitchen.tpl';
	}
	elseif($router['1']=='food_export-edit'){
		$jatbi->permission('food_export.edit');
		$action = "edit";
		$invoices = $database->get("purchase","*",["id"=>$xss->xss($router['2']),"deleted"=>0]);
		if($invoices>1){
			$Cus = $database->get("supplier_food","*",["id"=>$invoices['vendor']]);
			$Pros = $database->select("purchase_products","*",["purchase"=>$invoices['id'],"deleted"=>0]);
			$Details = $database->select("purchase_details","*",["purchase"=>$invoices['id'],"deleted"=>0]);
			if($_SESSION['purchase'][$action]['order']!=$invoices['id']){
				unset($_SESSION['purchase'][$action]);
				$_SESSION['purchase'][$action]['status'] = $invoices['status'];
				$_SESSION['purchase'][$action]['status_pay'] = $invoices['status_pay'];
				$_SESSION['purchase'][$action]['discount'] = $invoices['discount'];
				$_SESSION['purchase'][$action]['code'] = $invoices['code'];
				$_SESSION['purchase'][$action]['content'] = $invoices['content'];
				$_SESSION['purchase'][$action]['type'] = $invoices['type'];
				$_SESSION['purchase'][$action]['date'] = date("Y-m-d",strtotime($invoices['date']));
				$_SESSION['purchase'][$action]['vendor'] = [
					"id"=>$Cus['id'],
					"name"=>$Cus['name'],
					"phone"=>$Cus['phone_number'],
					"email"=>$Cus['email'],
				];
				foreach ($Pros as $key => $value) {
					$GetPro = $database->get("food_warehouse","*",["id"=>$value['products'],"deleted"=>0]);
					$_SESSION['purchase'][$action]['products'][$value['id']] = [
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
					$_SESSION['purchase'][$action][$detail['type']][] = [
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
				"date" => $_SESSION['purchase'][$action]['date'],
				"discount" => $_SESSION['purchase'][$action]['discount'],
				"content" => $_SESSION['purchase'][$action]['content'],
				"status" => $_SESSION['purchase'][$action]['status'],
			];
			$getCus = $database->get("supplier_food","*",["id"=>$_SESSION['purchase'][$action]['vendor']['id']]);
			$SelectProducts = $_SESSION['purchase'][$action]['products'];
			$templates = $setting['site_backend'].'kitchen.tpl';
		}
		else {
			header("HTTP/1.0 404 Not Found");
			die();
		}
	}
    elseif($router['1']=='purchase_export-update'){
		$ajax = 'true';
		$action = $router['2'];
		if($router['3']=='productss'){
			if($router['4']=='add'){
				$data = $database->get("food_warehouse", "*",["id"=>$xss->xss($_POST['value'])]);
				if($data>1){
					$_SESSION['purchase'][$action]['productss'][] = [
						"products"=>$data['id'],
						"amount"=>1,
						"price"=>'',
						"vendor"=>$data['supplier_food'],
						"code"=>$data['code'],
						"name"=>$data['name'],
						"categorys"=>$data['category_food'],
						"units"=>$data['unit_food'],
						"notes"=>$data['notes'],
					];
					echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],]);
				}
				else {
					echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-that-bai'],]);
				}
			}
			elseif($router['4']=='deleted'){
				unset($_SESSION['purchase'][$action]['productss'][$router['5']]);
				echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],]);
			}
			elseif($router['4']=='price'){
				$_SESSION['purchase'][$action]['productss'][$router['5']][$router['4']] = $xss->xss(str_replace([','],'',$_POST['value']));
				echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],]);
			}
			else {
				$_SESSION['purchase'][$action]['productss'][$router['5']][$router['4']] = $xss->xss($_POST['value']);
				echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],]);
			}
		}
		elseif($router['3']=='datee' || $router['3']=='discountt' || $router['3']=='contentt' || $router['3']=='food_menu'){
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
			    elseif($_POST['datee'] == ""){
					echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
				}
			    if ($_POST['date']) {
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
				$templates = $setting['site_backend'].'purchases.tpl';
			}	
		}
		elseif($router['3']=='completed'){
            $datas = $_SESSION['purchase'][$action];
			foreach ($_SESSION['purchase'][$action]['productss'] as $value) {
				$total_products += $value['amount']*$value['price'];
				if($value['amount']=='' || $value['amount']==0){
					$error_warehouses = 'true';
				}
			}
			$discount = ($_SESSION['purchase'][$action]['discountt']*$total_products)/100;
			$payments = ($total_products-$total_minus-$discount)+$total_surcharge;
			$payments1 = ($total_ingredient-$total_minus-$discount)+$total_surcharge;
			if($_SESSION['purchase'][$action]['contentt']==''||$_SESSION['purchase'][$action]['food_menu']==''){
				$error = ["status"=>'error','content'=>$lang['loi-trong']];
			}
			elseif($error_warehouses=='true'){
				$error = ['status'=>'error','content'=>$lang['vui-long-chon-kho-hang'],];
			}
            foreach ($_SESSION['purchase'][$action]['productss'] as $key => $value) {
                $getProducts = $database->get("food_warehouse","*",["id"=>$value['products']]);
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
					"type"			=> $_SESSION['purchase'][$action]['typee'],
					"vendor"		=> "",
					"code"			=> $code,
					"date"			=> $_SESSION['purchase'][$action]['datee'],
					"total"			=> $_SESSION['purchase'][$action]['typee']==2?$total_products:$total_ingredient,
					"minus"			=> 0,
					"surcharge"		=> 0,
					"prepay_req"	=> 0,
					"prepay"		=> 0,
					"discount"		=> $_SESSION['purchase'][$action]['discountt'],
					"discount_price"=> $discount,
					"payments"		=> $_SESSION['purchase'][$action]['typee']==2?$payments:$payments1,
					"user"			=> $account['id'],
					"date_poster"	=> date("Y-m-d H:i:s"),
					"status"		=> 1,
					"status_pay"	=> $_SESSION['purchase'][$action]['status_pay']==0?2:$_SESSION['purchase'][$action]['status_pay'],
					"content"		=> $_SESSION['purchase'][$action]['contentt'],
					"active"		=> $jatbi->active(30),
					"keycode"		=> $jatbi->random(6),
                    "school"        =>$school_id,
                    "food_menu"     =>$_SESSION['purchase'][$action]['food_menu'],
				];
                
				if($action=="add"){
					$database->insert("purchase",$insertt);
					$orderIdd = $database->id();
					$database->insert("purchase_logs",[
						"purchase" 	=> $orderIdd,
						"user"		=> $account['id'],
						"content" 	=> $xss->xss('Xuất hàng'),
						"status" 	=> $xss->xss($insert['status']),
						"date"		=> date('Y-m-d H:i:s'),
                        "school"        =>$school_id,
					]);
                    $insert = [
                        "code"			=> $datas['typee'],
                        "type"			=> $datas['typee'],
                        "data"			=> "",
                        "stores"		=> "",
                        "branch"		=> "",
                        "stores_receive"=> "",
                        "branch_receive"=> "",
                        "content"		=> $datas['contentt'],
                        "vendor"		=> "",
                        "user"			=> $account['id'],
                        "date"			=> $datas['datee'],
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
						"content" 	=> $xss->xss('Sửa xuất hàng'),
						"status" 	=> $xss->xss($insertt['status']),
						"date"		=> date('Y-m-d H:i:s'),
                        "school"        =>$school_id,
					]);
				}
                
				if($_SESSION['purchase'][$action]['typee']==2){
				    foreach ($_SESSION['purchase'][$action]['productss'] as $key => $value) {
                        $getProducts = $database->get("food_warehouse","*",["id"=>$value['products']]);
                        if($getProducts['amounts']>=$value['amount']){
                            $database->update("food_warehouse",["amounts"=>$getProducts['amounts']-$value['amount']],["school"        =>$school_id,"id"=>$getProducts['id']]);  
                            $pro = [
                                "warehouses" => $orderId,
                                "data"=>$insert['data'],
                                "type"=>$insert['type'],
                                "vendor"=>$getProducts['supplier_food'],
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
                                "vendor"=>$getProducts['supplier_food'],
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