<?php
    if (!defined('JATBI')) die("Hacking attempt");
    $school_id=$_SESSION['school'];
    $school = $database->get("school", "*",["id"        =>$school_id,"deleted"=> 0,"status"=>'A']);
    $accountants = $database->select("accountants_code", "*",["deleted"=> 0,"status"=>'A']);
	$type_payments = $database->select("type_payments", "*",["school"        =>$school_id,"deleted"=> 0,"type"=> 1,"main"=>0,"status"=>'A']);
    // $vendors[]= $database->select("supplier_food", "*",["deleted"=> 0,"status"=>'A',"school"=>$school_id]);
    $vendors= $database->select("supplier", "*",["deleted"=> 0,"status"=>'A',"school"=>$school_id]);
    $purchase=$database->select("purchase", "*", [
        "AND" => [
            "deleted" => 0,
            "school"=>$school_id,
            
        ],
        "ORDER" => [
            "id" => "DESC",
        ]
    ]);
    $tuition=$database->select("tuition", "*", [
        "AND" => [
            'status' =>"A",
            "deleted" => 0,
            "school"=>$school_id,
            
        ],
        "ORDER" => [
            "id" => "DESC",
        ]
    ]);
    $date=date("Y-m-d");
        $course=$database->select("course","*",[
            "school"        =>$school_id,
            "status"        =>'A',
            "deleted"       => 0,
        ]);
        foreach($course as $value){
            $date_timestamp = strtotime($date);
            $start_timestamp = strtotime($value['startdate']);
            $end_timestamp = strtotime($value['enddate']);
            
            if ($date_timestamp >= $start_timestamp && $date_timestamp <= $end_timestamp) {
                $semester = $database->select("semester", "*",[
                    "AND" => [
                        "deleted"       => 0,
                        'course'        => $value['id'],
                        "school"=>$school_id,
                    ],
                ]);

            }
        }
    if($router['1']=='tuition'){
        $jatbi->permission('tuition');
        $date = explode('-',$xss->xss($_GET['date']));
		$date_from = ($_GET['date']=='')?date('Y-01-01'):date('Y-m-d',strtotime(str_replace('/','-',$date[0])));
		$date_to = ($_GET['date']=='')?date('Y-m-d'):date('Y-m-d',strtotime(str_replace('/','-',$date[1])));
        $count = $database->count("tuition",
            [
                'AND' => [
                    "class"=>$xss->xss($router['2']),
                    "deleted" => 0,                                  
                ]
            ]
        );
        $pg = $_GET['pg'];
        if (!$pg)
            $pg = 1;
        $datas = $database->select("tuition", "*", [
            "AND" => [
                "OR" => [
                    
                    'id_tuition[~]' => ($xss->xss($_GET['name']) == '') ? '%' : $xss->xss($_GET['name']),                      
                ],
                'arrange_class[<>]'=> ($xss->xss($_GET['arrange_class'])=='')?:[$xss->xss($_GET['arrange_class']),$xss->xss($_GET['arrange_class'])], 
                'class_diagram[<>]'=> ($xss->xss($_GET['class_diagram'])=='')?:[$xss->xss($_GET['class_diagram']),$xss->xss($_GET['class_diagram'])], 
                'status' => ($xss->xss($_GET['status']) == '') ? [A, D] : $xss->xss($_GET['status']),
                "date[<>]" 		=> [$date_from,$date_to],
                "deleted" => 0,
                "school"=>$school_id,
                
            ],
            "LIMIT" => [(($pg - 1) * $setting['site_page']), $setting['site_page']],
            "ORDER" => [
                "id" => "DESC",
            ]
        ]);
        $page = $jatbi->pages($count, $setting['site_page'], $pg);
        $templates = $setting['site_backend'] . 'tuitions.tpl';
    }
    elseif($router['1']=='tuition_order_detail'){
        $jatbi->permission('tuition_order_detail');
        if ($router['2']) {      
            $_SESSION['router'] = $router['2'];   
            $count = $database->count("tuition_order_detail",
                [
                    'AND' => [
                        "tuition"=>$xss->xss($router['2']),
                        "deleted" => 0,                                  
                    ]
                ]
            );
            $pg = $_GET['pg'];
            if (!$pg)
                $pg = 1;
            $datas = $database->select("tuition_order_detail", "*", [
                "AND" => [
                    "OR" => [
                       
                        'id[~]' => ($xss->xss($_GET['name']) == '') ? '%' : $xss->xss($_GET['name']),                      
                    ],
                    'students[<>]'=> ($xss->xss($_GET['students'])=='')?:[$xss->xss($_GET['students']),$xss->xss($_GET['students'])], 
                    'content_tuition[<>]'=> ($xss->xss($_GET['content_tuition'])=='')?:[$xss->xss($_GET['content_tuition']),$xss->xss($_GET['content_tuition'])], 
                    'status' => ($xss->xss($_GET['status']) == '') ? [A, D] : $xss->xss($_GET['status']),
                    "deleted" => 0,
                    "tuition"=>$xss->xss($router['2']),
                ],
                "LIMIT" => [(($pg - 1) * $setting['site_page']), $setting['site_page']],
                "ORDER" => [
                    "id" => "DESC",
                ]
            ]);
            $page = $jatbi->pages($count, $setting['site_page'], $pg);
            $templates = $setting['site_backend'] . 'tuitions.tpl';
        }
        
    }
    elseif($router['1']=='tuition-add'){
        $jatbi->permission('tuition.add');
        $ajax = 'true';
        $studentss = $database->select("students", "*", [
            "class" =>  $_SESSION['router'],
            "deleted" => 0,
            "status" => 'A'
        ]);   
        $classs = $database->get("class", "*", [
            "id" =>  $_SESSION['router'],
            "deleted" => 0,
            "status" => 'A'
        ]);  
        $tuition = $database->select("tuition", "*", [
            "deleted" => 0,
        ]); 
        if(isset($_POST['token'])){
            $handle = new Upload($_FILES['avatar']);
            if($_POST['token']!=$_SESSION['csrf']['token']){
                echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
            }
            
            elseif($_POST['id_tuition'] == "" || $_POST['date'] == "" || $_POST['students'] == "" || $_POST['content'] == "" || $_POST['price'] == ""){
                echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
            }
            elseif( $_POST['id_tuition'] ==$tuition['id_tuition'] ){
                echo json_encode(['status'=>'error','content'=>$lang['trung-id'],'sound'=>$setting['site_sound']]);
            }
            if ($handle->processed  && $_POST['id_tuition'] && $_POST['date']&& $_POST['students'] && $_POST['content'] && $_POST['price']) {
                $insert = [                  
                    
                    "id_tuition"      => $xss->xss($_POST['id_tuition']), 
                    "date"         => $xss->xss($_POST['date']),                
                    "students"         => $xss->xss($_POST['students']),                   
                    "content"         => $xss->xss($_POST['content']),
                    "class"         => $xss->xss($_POST['class']),
                    "exemptions"         => $xss->xss($_POST['exemptions']),
                    "price"         => $xss->xss($_POST['price']),
                    "pay"         => $xss->xss($_POST['pay']),
                    "status"        => $xss->xss($_POST['status']),
                    "accounts"         => $xss->xss($_POST['accounts']),
                ];
                $database->insert("tuition",$insert);
                $jatbi->logs('tuition','add',$insert);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            }
        } 
        else {
            $templates = $setting['site_backend'].'tuitions.tpl';
        }
    }
    elseif($router['1']=='tuition-edit'){
        $jatbi->permission('tuition.edit');
        $ajax = 'true';
        $studentss = $database->select("students", "*", [
            "class" =>  $_SESSION['router'],
            "deleted" => 0,
            "status" => 'A'
        ]);   
        $classs = $database->get("class", "*", [
            "id" =>  $_SESSION['router'],
            "deleted" => 0,
            "status" => 'A'
        ]);  
        $tuition = $database->get("tuition", "*", [
            "deleted" => 0,
        ]); 
        if($router['2']){
            $data = $database->get("tuition", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if(isset($_POST['token'])){
                    $partten = "/^[A-Za-z0-9_\.]{".$setting['site_characters'].",32}$/";
                    
                    $handle = new Upload($_FILES['avatar']);
                    if($_POST['token']!=$_SESSION['csrf']['token']){
                        echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
                    }
                    
                    elseif($_POST['id_tuition'] == "" || $_POST['date'] == "" || $_POST['students'] == "" || $_POST['content'] == "" || $_POST['price'] == ""){
                        echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
                    }
                    elseif( $_POST['id_tuition'] ==$tuition['id_tuition'] ){
                        echo json_encode(['status'=>'error','content'=>$lang['trung-id'],'sound'=>$setting['site_sound']]);
                    }
                    if ($handle->processed  && $_POST['id_tuition'] && $_POST['date']&& $_POST['students'] && $_POST['content'] && $_POST['price']) {
                        $insert = [                  
                            
                            "id_tuition"      => $xss->xss($_POST['id_tuition']), 
                            "date"         => $xss->xss($_POST['date']),                
                            "students"         => $xss->xss($_POST['students']),                   
                            "content"         => $xss->xss($_POST['content']),
                            "class"         => $xss->xss($_POST['class']),
                            "exemptions"         => $xss->xss($_POST['exemptions']),
                            "price"         => $xss->xss($_POST['price']),
                            "pay"         => $xss->xss($_POST['pay']),
                            "accounts"         => $xss->xss($_POST['accounts']),
                            "status"        => $xss->xss($_POST['status']),
                        ];
                        $database->update("tuition",$insert,["id"=>$data['id']]);
                        $jatbi->logs('tuition','edit',$insert);
                        echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
                    }
                } else {
                    $templates = $setting['site_backend'].'tuitions.tpl';
                }
            }
            else {
                header("HTTP/1.0 404 Not Found");
                die();
            }
        }
    }
    elseif($router['1']=='tuition-delete'){
        $jatbi->permission('tuition.delete');
        $ajax = 'true';
        if($router['2']){
            $datas = $database->select("tuition","*",["id"=>explode(',', $xss->xss($router['2']))]);
            if(isset($_POST['submit'])){
                $jatbi->logs('tuition','delete',$datas);
                $database->update("tuition",["deleted" => 1,],["id"=>explode(',', $xss->xss($router['2']))]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            } else {
                $templates = $setting['site_backend'].'tuitions.tpl';
            }
        }
        else {
            header("HTTP/1.0 404 Not Found");
            die();
        }
    }
    elseif($router['1']=='revenue'){
        $jatbi->permission('revenue');
        $date = explode('-',$xss->xss($_GET['date']));
		$date_from = ($_GET['date']=='')?date('Y-01-01'):date('Y-m-d',strtotime(str_replace('/','-',$date[0])));
		$date_to = ($_GET['date']=='')?date('Y-m-d'):date('Y-m-d',strtotime(str_replace('/','-',$date[1])));
        $count = $database->count("tuition",
            [
                'AND' => [
                    "status" => 'A',
                    "deleted" => 0,    
                    'school'=>$school_id['id'],                              
                ]
            ]
        );
        $pg = $_GET['pg'];
        if (!$pg)
            $pg = 1;
        $datas = $database->select("tuition", "*", [
            "AND" => [
                
                'arrange_class[<>]'=> ($xss->xss($_GET['arrange_class'])=='')?:[$xss->xss($_GET['arrange_class']),$xss->xss($_GET['arrange_class'])], 
                'class_diagram[<>]'=> ($xss->xss($_GET['class_diagram'])=='')?:[$xss->xss($_GET['class_diagram']),$xss->xss($_GET['class_diagram'])], 
                "date[<>]" 		=> [$date_from,$date_to],
                "status" => 'A',
                "deleted" => 0,
                'school'=>$school_id['id'],
               
            ],
            "LIMIT" => [(($pg - 1) * $setting['site_page']), $setting['site_page']],
            "ORDER" => [
            "id" => "DESC",
            ]
        ]);
        $page = $jatbi->pages($count, $setting['site_page'], $pg);
        $templates = $setting['site_backend'] . 'tuitions.tpl';
    }
    elseif($router['1']=='content_tuition'){
        $jatbi->permission('content_tuition');
        $_SESSION['router']=$router['2'];
        if($router['2']) {
            $jatbi->permission('content_tuition');
            $count = $database->count("content_tuition",[
                'AND' => [
                    "class_diagram" =>$xss->xss($router['2']),
                    "deleted"       => 0,
                    'school'=>$school_id['id'],
                ]]
            );
            $pg = $_GET['pg'];
            if (!$pg) $pg = 1;
            $datas = $database->select("content_tuition", "*",[
                "AND" => [
                    "OR"=>[
                        
                        'content[~]'    => ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
                                
                    ],
                    'status'        => ($xss->xss($_GET['status'])=='')?[A,D]:$xss->xss($_GET['status']), 
                    "deleted"       => 0,
                    "class_diagram" =>$xss->xss($router['2']),
                    'school'=>$school_id['id'],
                ],
                "LIMIT" =>[(($pg-1)*$setting['site_page']),$setting['site_page']],
                "ORDER" => [
                    "id"=>"DESC",
                    
                ]
            ]);
            $page = $jatbi->pages($count,$setting['site_page'],$pg);
            $templates = $setting['site_backend'].'tuitions.tpl';
        }
    }
    elseif($router['1']=='content_tuition-add'){
        
        $jatbi->permission('content_tuition.add');
        $ajax = 'true';
        $classs = $database->get("class_diagram", "*", [
            "id" =>  $_SESSION['router'],
            "deleted" => 0,
            "status" => 'A'
        ]);  
        if(isset($_POST['token'])){
            
            if($_POST['token']!=$_SESSION['csrf']['token']){
                echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
            }
            elseif($_POST['content'] == "" ||$_POST['price'] == ""){
                echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
            }
            if ($_POST['content'] && $_POST['price']) {
                $insert = [                  
                    "class_diagram"         => $xss->xss($_POST['class']),                              
                    "content"         => $xss->xss($_POST['content']), 
                    "price"         => $xss->xss($_POST['price']), 
                    "payment_deadline"         => date('Y-m-d'),
                    "status"        => $xss->xss($_POST['status']),
                    "type"        => $xss->xss($_POST['type']),
                    "school"=>$school_id,
                ];
                $database->insert("content_tuition",$insert);
                $jatbi->logs('content_tuition','add',$insert);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            }
        } 
        else {
            $templates = $setting['site_backend'].'tuitions.tpl';
        }
    }
    elseif($router['1']=='content_tuition-edit'){
        $jatbi->permission('content_tuition.edit');
        $ajax = 'true';
        $classs = $database->get("class_diagram", "*", [
            "id" =>  $_SESSION['router'],
            "deleted" => 0,
            "status" => 'A'
        ]);  
        if($router['2']){
            $data = $database->get("content_tuition", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if(isset($_POST['token'])){
                    $partten = "/^[A-Za-z0-9_\.]{".$setting['site_characters'].",32}$/";
                    
                    $handle = new Upload($_FILES['avatar']);
                    if($_POST['token']!=$_SESSION['csrf']['token']){
                        echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
                    }
                    elseif($_POST['content'] == "" ||$_POST['price'] == ""){
                        echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
                    }
                    if ($_POST['content'] && $_POST['price'] && $_POST['payment_deadline'] ) {
                        $insert = [                  
                            "class_diagram"         => $xss->xss($_POST['class']),                              
                            "content"         => $xss->xss($_POST['content']), 
                            "price"         => $xss->xss($_POST['price']), 
                            "payment_deadline"         => date('Y-m-d'),
                            "status"        => $xss->xss($_POST['status']),
                            "type"        => $xss->xss($_POST['type']),
                            "school"=>$school_id,
                        ];
                        $database->update("content_tuition",$insert,["id"=>$data['id']]);
                        $jatbi->logs('content_tuition','edit',$insert);
                        echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
                    }
                } else {
                    $templates = $setting['site_backend'].'tuitions.tpl';
                }
            }
            else {
                header("HTTP/1.0 404 Not Found");
                die();
            }
        }
    }
    elseif($router['1']=='content_tuition-delete'){
        $jatbi->permission('content_tuition.delete');
        $ajax = 'true';
        if($router['2']){
            $datas = $database->select("content_tuition","*",["id"=>explode(',', $xss->xss($router['2']))]);
            if(isset($_POST['submit'])){
                $jatbi->logs('content_tuition','delete',$datas);
                $database->update("content_tuition",["deleted" => 1,],["id"=>explode(',', $xss->xss($router['2']))]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            } else {
                $templates = $setting['site_backend'].'tuitions.tpl';
            }
        }
        else {
            header("HTTP/1.0 404 Not Found");
            die();
        }
    }
    elseif($router['1']=='content_tuition-status'){
        $jatbi->permission('content_tuition.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("content_tuition", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if($data['status']==='A'){
                    $status = "D";
                } 
                elseif($data['status']==='D'){
                    $status = "A";
                }
                $database->update("content_tuition",["status"=>$status],["id"=>$data['id']]);
                $jatbi->logs('content_tuition','status',["data"=>$data,"status"=>$status]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-trang-thai'],'sound'=>$setting['site_sound']]);
            }
            else {
                echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-that-bai'],]);
            }
        }
    }
    elseif($router['1']=='content_tuition-class'){
        $jatbi->permission('content_tuition-class');
        $count = $database->count("class_diagram",[
            'AND' => [
                "school"=>$school_id,
                "deleted"       => 0,
            ]]
        );
        $date=date("Y-m-d");
        $course=$database->select("course","*",[
            "school"        =>$school_id,
            "status"        =>'A',
            "deleted"       => 0,
        ]);
        $pg = $_GET['pg'];
        if (!$pg) $pg = 1;
        foreach($course as $value){
            $date_timestamp = strtotime($date);
            $start_timestamp = strtotime($value['startdate']);
            $end_timestamp = strtotime($value['enddate']);
            
            if ($date_timestamp >= $start_timestamp && $date_timestamp <= $end_timestamp) {
                $datas = $database->select("class_diagram", "*",[
                    "AND" => [
                        'status'        => ($xss->xss($_GET['status'])=='')?[A,D]:$xss->xss($_GET['status']), 
                        "deleted"       => 0,
                        'course'        => $value['id'],
                        "school"=>$school_id,
                    ],
                    "LIMIT" =>[(($pg-1)*$setting['site_page']),$setting['site_page']],
                    "ORDER" => [
                        "id"=>"DESC",
                    ]
                ]);
            }
            

        }
        $page = $jatbi->pages($count,$setting['site_page'],$pg);
        $templates = $setting['site_backend'].'tuitions.tpl';
        
    }
    elseif($router['1']=='tuition_order'){
		$jatbi->permission('tuition_order');
        $date=date("Y-m-d");
        $school_years=$database->select("course","*",[
            "school"        =>$school_id,
            "enddate[>=]"       =>$date,
            "startdate[<=]"       =>$date,
            "status"        =>'A',
            "deleted"       => 0,
        ]);
		$action = "add";
		if($_SESSION['pairing'][$action]['school_year']==''){
		 	$_SESSION['pairing'][$action]['school_year'] = '';
		 }
        if($_SESSION['pairing'][$action]['class']==''){
            $_SESSION['pairing'][$action]['class'] = '';
        }
        if($_SESSION['pairing'][$action]['student']==''){
          
            $_SESSION['pairing'][$action]['student'] = '';
        }
        if($_SESSION['pairing'][$action]['exemptions_current']==''){
            $_SESSION['pairing'][$action]['exemptions_current'] =0;
        }
        if($_SESSION['pairing'][$action]['type_payments']==''){
			$_SESSION['pairing'][$action]['type_payments']= 1;

        }
		$data = [
			"school_year" => $_SESSION['pairing'][$action]['school_year'],
            "class" => $_SESSION['pairing'][$action]['class'], 
			"student" => $_SESSION['pairing'][$action]['student'],
            "exemptions" => $_SESSION['pairing'][$action]['exemptions'],   
            "exemptions_current" => $_SESSION['pairing'][$action]['exemptions_current'],   
            "note" => $_SESSION['pairing'][$action]['note'],
            "type_payments" => $_SESSION['pairing'][$action]['type_payments'],
            "payment_deadline" => $_SESSION['pairing'][$action]['payment_deadline'],
        
		];
        
		$SelectProducts = $_SESSION['pairing'][$action]['content_tuition'];       
        $studentss = $database->get("arrange_class", "*",["school"=>$school_id,"deleted"=> 0,"status"=>'A',"id"=>$data['student']]);
        $phantram=$database->get("priority_object","exemptions",["id"=>$database->get("students","priority_object",['id'=>$studentss['students']])]);
        
        $data['exemptions']=$phantram;
        $details=$database->select('tuition_order_detail','content_tuition',["type" =>2,"school"=>$school_id,"arrange_class"=>$data['student'],"deleted"=> 0,"status"=>'A']);
        if(count($details)!=0){
            $content_tuition = $database->select("content_tuition", "*",[
                "id[!]"=>$details,
                "type" =>2,
                "school"=>$school_id,
                "deleted"=> 0,
                "status"=>'A',
                "class_diagram"=>$data['class']]);
        }else{
            $content_tuition = $database->select("content_tuition", "*",[
                "type" =>2,
                "school"=>$school_id,
                "deleted"=> 0,
                "status"=>'A',
                "class_diagram"=>$data['class']]);
        }
       
        $students = $database->select("arrange_class", "*",["school"=>$school_id,"deleted"=> 0,"status"=>'A',"class_diagram"=>$data['class']]);
		$classs = $database->select("class_diagram", "*",["school"=>$school_id,"deleted"=> 0,"status"=>'A',"course"=>$data['school_year']]);   
        $furlough = $database->select("furlough", "*",["statu"=>'D',"school"=>$school_id,"deleted"=> 0,"status"=>'A',"arrange_class"=>$data['student']]);  
		$page = $jatbi->pages($count,$setting['site_page'],$pg);
		$templates = $setting['site_backend'].'tuitions.tpl';
	}
	elseif($router['1']=='tuition-update'){
		$ajax = 'true';
		$action = $router['2'];
		if($router['3']=='school_year'){
            unset($_SESSION['pairing'][$action]['student']);
			unset($_SESSION['pairing'][$action]['class']);
            unset($_SESSION['pairing'][$action]['exemptions']);
            unset($_SESSION['pairing'][$action]['exemptions_current']);
            unset($_SESSION['pairing'][$action]['content_tuition']);
			$_SESSION['pairing'][$action]['school_year'] = $xss->xss($_POST['value']);
			echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],]);
		}
        elseif($router['3']=='class'){
			unset($_SESSION['pairing'][$action]['student']);
            unset($_SESSION['pairing'][$action]['note']);
            unset($_SESSION['pairing'][$action]['exemptions']);
            unset($_SESSION['pairing'][$action]['exemptions_current']);
            unset($_SESSION['pairing'][$action]['content_tuition']);
			$_SESSION['pairing'][$action]['class'] = $xss->xss($_POST['value']);
			echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],]);
		}
        elseif($router['3']=='reload'){
            unset($_SESSION['pairing'][$action]['content_tuition']);
			$_SESSION['pairing'][$action]['reload'] = $xss->xss($_POST['value']);
			echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],]);
		}
        elseif($router['3']=='payment_deadline'){
            $data = $_SESSION['pairing'][$action];
            $month_in=$xss->xss($_POST['value']);
            $students = $database->get("students", "*",["school"=>$school_id,"deleted"=> 0,"status"=>'A',"id"=>$database->get("arrange_class", "students",["school"=>$school_id,"deleted"=> 0,"status"=>'A',"id"=>$data['student']])]);  
            $courses = $database->get("course", "*",["school"=>$school_id,"deleted"=> 0,"status"=>'A',"id"=>$data['school_year']]);  
            if($month_in<=12 && $month_in>= date("m", strtotime($courses['startdate']))){
                $month=[
                    "months"=>$month_in,
                    "year"=>date("Y", strtotime($courses['startdate'])),
                ];
            }elseif($month_in>=1 && $month_in<= date("m", strtotime($courses['enddate']))){
                $month=[
                    "months"=>$month_in,
                    "year"=>date("Y", strtotime($courses['enddate'])),
                ];
            } 
            $content_tuitions=$database->select("content_tuition", ["id","content","price","payment_deadline","type"],[
                        "school"=>$school_id,
                        "deleted"=> 0,
                        "status"=>'A',
                        "class_diagram"=>$data['class'],
                        "type" =>[0,1],
                        ]);  
            $con=$database->count("content_tuition",[
                            "school"=>$school_id,
                            "deleted"=> 0,
                            "status"=>'A',
                            "class_diagram"=>$data['class'],
                            "type" =>[0,1],
                            ]);  
    
            $tuition_order_details=$database->select('tuition_order_detail','*',["type" =>[0,1],"school"=>$school_id,"arrange_class"=>$data['student'],"deleted"=> 0,"status"=>'A']);
            $m=date("m", strtotime($students['year_of_admission']));
            $y=date("Y", strtotime($students['year_of_admission']));
            if($content_tuitions>1 && $month['months']>=$m && $month['year']==$y  || $content_tuitions>1 &&($month['months'] < $m && $month['year'] > $y)){
                $dem=0;
                foreach ($content_tuitions as $value) {
                    $found = false;
                    if($data['content_tuition']==[]){
                        
                        foreach ($tuition_order_details as $valuee) {
                            if($valuee['month']==$xss->xss($_POST['value'])  && $valuee['content_tuition']==$value['id']){
                                $found = true;
                                $dem+=1;
                            //    $error_message = 'Khoản tiền này đã đóng!';
                            //     echo json_encode(['status' => 'error', 'content' => $error_message]);
                            //     return;
                                
                             }
                        }

                        if($dem==$con){
                            $error_message = 'Khoản tiền này đã đóng!';
                                echo json_encode(['status' => 'error', 'content' => $error_message]);
                                return;
                        }elseif(!$found){
                               
                                $_SESSION['pairing'][$action]['content_tuition'][] = [
                                    "content_tuition" => $value['id'],
                                    "content"=>$value['content'],
                                    "price"=>$value['price'],
                                    "type"=>$value['type'],
                                    "number_of_month"=>0,
                                    "payment_deadline"=>date('Y-m-d'),
                                    "month"=>$xss->xss($_POST['value']),
                                    
                                ];
                                $SelectProducts = $_SESSION['pairing'][$action]['content_tuition'][$value['id']];  
                        }
                    }
                    elseif($data['content_tuition']!=[]){
                        foreach ($tuition_order_details as $valuee) {
                            if($valuee['month']==$xss->xss($_POST['value'])  && $valuee['content_tuition']==$value['id']){
                                $found = true;
                                $dem+=1;
                                // $error_message = 'Khoản tiền này đã đóng!';
                                // echo json_encode(['status' => 'error', 'content' => $error_message]);
                                // return;
                               
                             }
                        }
                        foreach ($data['content_tuition'] as $values) {
                            if($values['month']==$xss->xss($_POST['value']) && $values['content']==$value['content']){
                                $found = true;
                                $error_message = 'Lặp dữ liệu trong bảng thanh toán!';
                                echo json_encode(['status' => 'error', 'content' => $error_message]);
                                return;
                                break;
                            }
                        }
                        if($dem==$con){
                            $error_message = 'Khoản tiền này đã đóng!';
                                echo json_encode(['status' => 'error', 'content' => $error_message]);
                                return;
                        }elseif(!$found){
                               
                                $_SESSION['pairing'][$action]['content_tuition'][] = [
                                    "content_tuition" => $value['id'],
                                    "content"=>$value['content'],
                                    "price"=>$value['price'],
                                    "type"=>$value['type'],
                                    "number_of_month"=>0,
                                    "payment_deadline"=>date('Y-m-d'),
                                    "month"=>$xss->xss($_POST['value']),
                                    
                                ];
                                $SelectProducts = $_SESSION['pairing'][$action]['content_tuition'][$value['id']];  
                        }
                        
                        
                    }
                    
                
                }
            }else {
                $error_message = 'Không tìm thấy nội dung học phí.';
                echo json_encode(['status' => 'error', 'content' => $error_message]);
                return;
            }
            
			$_SESSION['pairing'][$action]['payment_deadline'] =  $xss->xss($_POST['value']);
			echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],]);
		}
        elseif($router['3']=='student'){
            
            $data = $_SESSION['pairing'][$action];
            unset($_SESSION['pairing'][$action]['content_tuition']);
            unset($_SESSION['pairing'][$action]['exemptions']); 
            unset($_SESSION['pairing'][$action]['exemptions_current']);
            $furlough_student=$database->select("furlough", "*",["statu"=>'D',"school"=>$school_id,"deleted"=> 0,"status"=>'A',"arrange_class"=>$xss->xss($_POST['value'])]);
            $content_tuitions=$database->get("content_tuition", ["id","content","price","payment_deadline","type"],[
                "school"=>$school_id,
                "deleted"=> 0,
                "status"=>'A',
                "class_diagram"=>$data['class'],
                "type" =>0,
                ]);   
            $thangg=[1,2,3,4,5,6,7,8,9,10,11,12];
            if($furlough_student>1){
                foreach ($thangg as $thang) {
                    $numberfur=0;
                    $furlough_studentt=$database->select("furlough","*",[
                       
                        "statu"=>'D',"school"=>$school_id,
                        "deleted"=> 0,"status"=>'A',
                        "arrange_class"=>$xss->xss($_POST['value'])]);
                        foreach ($furlough_studentt as $fur) {
                            if(date("m", strtotime($fur['date_start']))==$thang){
                                $numberfur+=$fur['numberday'];
                            }
                        }
                        $tuition_order_detail = $database->count("tuition_order_detail",[
                            "AND" => [
                                'status'        => "A", 
                                "deleted"       => 0,
                                "month"         =>$thang,    
                                "school"        =>$school_id,  
                                "content_tuition" => $content_tuitions['id'],
                                "arrange_class"=>$xss->xss($_POST['value']),              
                            ],
                        ]);
                        $tuition_order_detailss = $database->count("tuition_order_detail",[
                            "AND" => [
                                'status'        => "A", 
                                "deleted"       => 0,
                                "month"         =>$thang,  
                                "type"          =>4,  
                                "school"        =>$school_id,  
                                "content_tuition" => $content_tuitions['id'],
                                "arrange_class"=>$xss->xss($_POST['value']),              
                            ],
                        ]);
                        if($numberfur>0 &&  $tuition_order_detail>0 && $tuition_order_detailss<1){
                            $_SESSION['pairing'][$action]['content_tuition'][] = [
                                "content_tuition" => $content_tuitions['id'],
                                "content"=>"Trả tiền ăn",
                                "price"=> $content_tuitions['price'],
                                "type"=>4,
                                "number_of_month"=>$numberfur,
                                "payment_deadline"=>date('Y-m-d'),
                                "month"=>$thang,
                            ];
                            $SelectProducts = $_SESSION['pairing'][$action]['content_tuition'][$value['id']];
                        }                           
                    }                                          
                }
			$_SESSION['pairing'][$action]['student'] = $xss->xss($_POST['value']);
			echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],]);
		}
		elseif($router['3']=='content_tuition'){
			if($router['4']=='add'){
                $data = $_SESSION['pairing'][$action];
				$value = $database->get("content_tuition", "*",["type" =>2,"id"=>$xss->xss($_POST['value'])]);
				if($data>1){
                    
                 
                        if($data['content_tuition']!=[]){
                            foreach ($data['content_tuition'] as $values) {
                                if($values['type']==$value['type'] && $values['content']==$value['content']&& $values['content_tuition']==$value['id']){
                                    $found = true;
                                    $error_message = 'Lặp dữ liệu trong bảng thanh toán!';
                                    echo json_encode(['status' => 'error', 'content' => $error_message]);
                                    return;
                                    break;
                                }
                            }
                            if(!$found){
                                $_SESSION['pairing'][$action]['content_tuition'][] = [
                                    "content_tuition" => $value['id'],
                                    "content"=>$value['content'],
                                    "price"=>$value['price'],
                                    "type"=>$value['type'],
                                    "number_of_month"=>0,
                                    "payment_deadline"=>date('Y-m-d'),
                                    "month"=>date('m'),
                                ];
                                $SelectProducts = $_SESSION['pairing'][$action]['content_tuition'][$value['id']];  
                            }
                        }else{
                            $_SESSION['pairing'][$action]['content_tuition'][] = [
                                "content_tuition" => $value['id'],
                                "content"=>$value['content'],
                                "price"=>$value['price'],
                                "type"=>$value['type'],
                                "number_of_month"=>0,
                                "payment_deadline"=>date('Y-m-d'),
                                "month"=>date('m'),
                            ];
                            $SelectProducts = $_SESSION['pairing'][$action]['content_tuition'][$value['id']];
                        }
                        

                    
					
								
							echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],]);

                }else {
					echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-that-bai'],]);
				}
			}
			elseif($router['4']=='deleted'){
				unset($_SESSION['pairing'][$action]['content_tuition'][$router['5']]);
				// $_SESSION['pairing'][$action]['code'] = $jatbi->getcode($_SESSION['pairing'][$action]['content_tuition']);
				echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],]);
			}
            
        }      
        elseif($router['3']=='exemptions' || $router['3']=='note' ||  $router['3']=='type_payments'||  $router['3']=='exemptions_current'){
			$_SESSION['pairing'][$action][$router['3']] = $xss->xss($_POST['value']);
			echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],]);
		}
		elseif($router['3']=='completed'){
			$data = $_SESSION['pairing'][$action];
            $total_content=0;
            $furlough = $database->select("furlough", "*",["statu"=>'D',"school"=>$school_id,"deleted"=> 0,"status"=>'A',"arrange_class"=>$data['student']]);
			foreach ($data['content_tuition'] as $value) {
                $timework_details = $database->select("timework_details", "week",[
                    "AND" => [
                        "deleted"       => 0,
                        "off"		=>1,
                        "school" =>$_SESSION['school'],
                    ]
                 ]); 
                $number_day=0;
                $songay=0;

                $thang=$value['month'];
                $nam=date("Y", strtotime($value['payment_deadline']));

                if (!function_exists('cal_days_in_month')) {
                function cal_days_in_month($calendar, $month, $year) {
                    return intval(date('t', strtotime($year . '-' . $month . '-01')));
                }

                }

                $ngaytrongthang= cal_days_in_month(CAL_GREGORIAN,$value['month'], date("Y", strtotime($value['payment_deadline'])));

                for ($ngay = 1; $ngay <= $ngaytrongthang; $ngay++) {
                    $ngayhientai = date('N', strtotime("$nam-$thang-$ngay"));
                    if (!in_array($ngayhientai,$timework_details)) {
                        $songay++;
                    }
                }

                if($value['type']==0){
                    $total_content += $value['price']*($songay);
                }elseif($value['type']==4){
                    $total_content  -=$value['price']*$value['number_of_month'];
                }else{
                    $total_content += $value['price'];
                }
				
			}
            $studentss = $database->get("arrange_class", "*",["school"=>$school_id,"deleted"=> 0,"status"=>'A',"id"=>$data['student']]);
            $phantram=$database->get("priority_object","exemptions",["id"=>$database->get("students","priority_object",['id'=>$studentss['students']])]);
            $data['exemptions']=$phantram;
            $totall=$total_content-($total_content*$data['exemptions'])/100;
            $total=$totall-($totall*$data['exemptions_current'])/100;
            
			if($data['note']==''|| $data['type_payments']==''){
				$error = ["status"=>'error','content'=>$lang['loi-trong']];
			}
			if(count($error)==0){
                $insert = [
                    "id_tuition" 		=> strtotime(date("y-m-d h:i:s")),
					"date"			=> date("y-m-d h:i:s"),
					"class_diagram"			=> $data['class'],
					"arrange_class"		=> $data['student'],
					"exemptions"		=> $data['exemptions'],
                    "exemptions_current"		=> $data['exemptions_current'],
					"note"		=> $data['note'],
                    "total"		=> $total,
                    "accounts"		=> $account['id'],
                    "type_payment" =>$data['type_payments'],
                    "status"			=> 'A',
                    "school"        =>$school_id,
                ];
                    
				$database->insert("tuition",$insert);
				$tui = $database->id();
                foreach($data['content_tuition'] as $item){
                    $timework_details = $database->select("timework_details", "week",[
                        "AND" => [
                            "deleted"       => 0,
                            "off"		=>1,
                            "school" =>$_SESSION['school'],
                        ]
                     ]); 
                    $number_day=0;
                    $songay=0;
    
                    $thang=$item['month'];
                    $nam=date("Y", strtotime($item['payment_deadline']));
    
                    if (!function_exists('cal_days_in_month')) {
                    function cal_days_in_month($calendar, $month, $year) {
                        return intval(date('t', strtotime($year . '-' . $month . '-01')));
                    }
    
                    }
    
                    $ngaytrongthang= cal_days_in_month(CAL_GREGORIAN,$item['month'], date("Y", strtotime($item['payment_deadline'])));
    
                    for ($ngay = 1; $ngay <= $ngaytrongthang; $ngay++) {
                        $ngayhientai = date('N', strtotime("$nam-$thang-$ngay"));
                        if (!in_array($ngayhientai,$timework_details)) {
                            $songay++;
                        }
                    }
                    if( $item['type']==0){
                        $up = [
                            "tuition" 		=> $tui,
                            "content_tuition"	=> $item['content_tuition'],
                            "month"=>$item['month'],
                            "arrange_class"		=> $data['student'],
                            "type"		=> $item['type'],
                            "status"			=> 'A',
                            "school"        =>$school_id,
                            "number_of_month"=>$songay,
                            "year"=>date("Y", strtotime($item['payment_deadline'])),
                            ];
                        $database->insert("tuition_order_detail",$up);
                    }elseif( $item['type']==4){
                        $up = [
                            "tuition" 		=> $tui,
                            "content_tuition"	=> $item['content_tuition'],
                            "month"=>$item['month'],
                            "arrange_class"		=> $data['student'],
                            "type"		=> $item['type'],
                            "status"			=> 'A',
                            "school"        =>$school_id,
                            "number_of_month"=>$item["number_of_month"],
                            "year"=>date("Y", strtotime($item['payment_deadline'])),
                            ];
                        $database->insert("tuition_order_detail",$up);
                    }else{
                        
                        $up = [
                            "tuition" 		=> $tui,
                            "content_tuition"	=> $item['content_tuition'],
                            "month"=>$item['month'],
                            "arrange_class"		=> $data['student'],
                            "type"		=> $item['type'],
                            "status"			=> 'A',
                            "school"        =>$school_id,
                            "number_of_month"=>0,
                            "year"=>date("Y", strtotime($item['payment_deadline'])),
                            ];
                        $database->insert("tuition_order_detail",$up);
                    }
                        
                }
                $type_pay = $database->get("type_payments", "*",["school"        =>$school_id,"id"=>$data['type_payments'],"deleted"=> 0,"main"=>0,"status"=>'A']);
                $inser = [
					"type" 			=> 1,
					"debt" 			=>$type_pay['debt'],
					"has" 			=>$type_pay['has'],
					"price" 		=> $total,
					"content" 		=> $data['note'],
					"date" 			=> date("y-m-d h:i:s"),
					"customers" 	=> $data['student'],
					"purchase" 		=> $tui,
                    "ballot"        => strtotime(date("y-m-d")),
					"user"			=> $account['id'],
					"date_poster"	=> date("Y-m-d H:i:s"),
					"school"		=> $school_id,
				];
				$database->insert("expenditure",$inser);
                        $arr=$database->get("arrange_class", "*",["id"=>$data['student'],"deleted"=> 0,"status"=>'A',"school"=>$school_id]);
                        $device= $database->select("device_parent", "device_id",[
                                "parent"=>$database->get("students","parent",["id"=>$arr['students'],"deleted"=> 0,"status"=>'A',"school"=>$school_id]),
                                "school"=>$school_id,
                                "deleted"=> 0,
                                "status"=>'A']);

                        
                        function sendNotification($title, $message,$device) {
                            $content = array(
                                "en" => $message // Nội dung thông báo (có thể thay đổi ngôn ngữ ở đây)
                            );
                        
                            $fields = [
                                'app_id' => 'c0bd1290-a222-4a69-b48f-e1a756d3e1b6', // ID ứng dụng OneSignal của bạn
                                'include_player_ids' =>  $device, // Danh sách các device token
                                'contents' => $content,
                                'headings' => array("en" => $title) // Tiêu đề thông báo
                            ];
                        
                            $fields = json_encode($fields);
                        
                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                'Content-Type: application/json; charset=utf-8',
                                'Authorization: Basic ODQzZTk1NmMtMjIwNi00NmNhLTgxZDMtMzg2NTBkODJjYTBl' // Thay YOUR_REST_API_KEY bằng khóa REST API của bạn
                            ));
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_HEADER, false);
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        
                            $result = curl_exec($ch);
                        
                            if ($result === FALSE) {
                                die('Curl failed: ' . curl_error($ch));
                            }
                        
                            curl_close($ch);
                        
                            return $result;
                        }
                        
                        // Gọi hàm sendNotification để gửi thông báo đẩy
                       $student=$database->get("students","fullname",["id"=>$arr['students'],"deleted"=> 0,"status"=>'A',"school"=>$school_id]);
                        $title = $school['name'];
                        $message =$student.' đã đóng học phí nội dung : '. $data['note'];
                        $result = sendNotification($title, $message, $device);
				$jatbi->logs('expenditure','add',$inser);
				$jatbi->logs('pairing',$action,[$insert,$pro_logs,$_SESSION['pairing'][$action]]);
                $jatbi->logs('pairing',$action,[$up,$pro_logs,$_SESSION['pairing'][$action]]);
				unset($_SESSION['pairing'][$action]);
                echo json_encode(['status'=>'success','content'=>$lang['thanh-toan-thanh-cong']]);
				
			}
			else {
				echo json_encode(['status'=>'error','content'=>$error['content']]);
			}
        }	 
	}
    elseif($router['1']=='tuition_debt'){
        $jatbi->permission('tuition_debt');
            $student_arr = $database->select("arrange_class", "*",[
                "AND" => [
                    'status'        =>'A', 
                    "deleted"       => 0,
                    "school"        =>$school_id,
                ]  
            ]);
            foreach ($student_arr as $data) {
                $class_st = $database->get('arrange_class', 'class_diagram', [
                    "school" => $school_id,
                    "id" => $data['id'],
                    "deleted" => 0,
                    "status" => 'A'
                ]);
            
                $students = $database->get('students', '*', [
                    "school" => $school_id,
                    "id" => $database->get('arrange_class', 'students', [
                        "id" => $data['id'],
                        "deleted" => 0,
                        "status" => 'A'
                    ]),
                    "deleted" => 0,
                    "status" => 'A'
                ]);
            
                $date = date("Y-m-d");
            
                $course = $database->select("course", "*", [
                    "school" => $school_id,
                    "status" => 'A',
                    "deleted" => 0
                ]);
            
                foreach ($course as $value) {
                    $date_timestamp = strtotime($date);
                    $start_timestamp = strtotime($value['startdate']);
                    $end_timestamp = strtotime($value['enddate']);
            
                    if ($date_timestamp >= $start_timestamp && $date_timestamp <= $end_timestamp) {
                        $class_course = $database->get("class_diagram", "*", [
                            "AND" => [
                                "deleted" => 0,
                                "id" => $class_st,
                                'course' => $value['id'],
                                "school" => $school_id
                            ],
                            "ORDER" => [
                                "id" => "DESC"
                            ]
                        ]);
                    }
                }
            
                $course_current = $database->get('course', '*', [
                    "id" => $class_course['course'],
                    "deleted" => 0,
                    "status" => 'A'
                ]);
            
                $tuition_order_detail = $database->select('tuition_order_detail', 'content_tuition', [
                    "arrange_class" => $data['id'],
                    "deleted" => 0,
                    "status" => 'A',
                    "school" => $school_id
                ]);
            
                $month = [];
                for ($i = 1; $i < 13; $i++) {
                    if ($i <= 12 && $i >= date("m", strtotime($course_current['startdate']))) {
                        $month[] = [
                            "months" => $i,
                            "year" => date("Y", strtotime($course_current['startdate']))
                        ];
                    } elseif ($i >= 1 && $i <= date("m", strtotime($course_current['enddate']))) {
                        $month[] = [
                            "months" => $i,
                            "year" => date("Y", strtotime($course_current['enddate']))
                        ];
                    }
                }
            
                $content_tuitions = $database->select("content_tuition", "*", [
                    "AND" => [
                        'status' => "A",
                        "deleted" => 0,
                        "class_diagram" => $class_st,
                        "school" => $school_id,
                        "type" => [0, 1]
                    ]
                ]);
            
                $m = date("m", strtotime($students['year_of_admission']));
                $y = date("Y", strtotime($students['year_of_admission']));
            
                $datas1 = [];
            
                foreach ($month as $monthh) {
                    if (($monthh['months'] >= $m && $monthh['year'] == $y) || ($monthh['months'] < $m && $monthh['year'] > $y)) {
                        foreach ($content_tuitions as $content_tuition) {
                            $timework_details = $database->select("timework_details", "week", [
                                "AND" => [
                                    "deleted" => 0,
                                    "off" => 1,
                                    "school" => $school_id
                                ]
                            ]);
            
                            $number_day = 0;
                            $songay = 0;
                            $thang = $monthh['months'];
                            $nam = date("Y", strtotime($value['payment_deadline']));
            
                            if (!function_exists('cal_days_in_month')) {
                                function cal_days_in_month($calendar, $thang, $year)
                                {
                                    return intval(date('t', strtotime($year . '-' . $thang . '-01')));
                                }
                            }
            
                            $ngaytrongthang = cal_days_in_month(CAL_GREGORIAN, $thang, date("Y", strtotime($value['payment_deadline'])));
            
                            for ($ngay = 1; $ngay <= $ngaytrongthang; $ngay++) {
                                $ngayhientai = date('N', strtotime("$nam-$thang-$ngay"));
            
                                if (!in_array($ngayhientai, $timework_details)) {
                                    $songay++;
                                }
                            }
            
                            $datas1[] = [
                                "id" => $content_tuition['id'],
                                "content" => $content_tuition['content'],
                                "class_diagram" => $content_tuition['class_diagram'],
                                "price" => $content_tuition['price'],
                                "payment_deadline" => $monthh['year'],
                                "month" => $monthh['months'],
                                "type" => $content_tuition['type'],
                                "number_of_month" => $songay
                            ];
                        }
                    }
                }
            
                $tuition_order_details = $database->select('tuition_order_detail', '*', [
                    "school" => $school_id,
                    "arrange_class" => $data['id'],
                    "deleted" => 0,
                    "status" => 'A'
                ]);
            
                $tutition = [];
            
                foreach ($datas1 as $datac) {
                    $found = false;
            
                    foreach ($tuition_order_details as $value) {
                        if ($datac["id"] == $value['content_tuition'] && $datac["month"] == $value['month']) {
                            $found = true;
                            break;
                        }
                    }
            
                    if (!$found) {
                        if ($datac['month']) {
                            $tutition[] = [
                                "id" => $datac['id'],
                                "content" => $datac['content'],
                                "class_diagram" => $datac['class_diagram'],
                                "price" => $datac['price'],
                                "payment_deadline" => $datac['payment_deadline'],
                                "month" => $datac['month'],
                                "type" => $datac['type'],
                                "number_of_month" => $datac['number_of_month']
                            ];
                        }
                    }
                }
            
                if (!empty($tutition) && $content_tuitions != []) {
                    $count = $database->count("arrange_class", [
                        'AND' => [
                            'id' => $data['id'],
                            'status' => 'A',
                            "school" => $school_id,
                            "deleted" => 0
                        ]
                    ]);
            
                    $student_debt[] = $database->get("arrange_class", "*", [
                        "AND" => [
                            'id' => $data['id'],
                            'status' => 'A',
                            "deleted" => 0,
                            "school" => $school_id
                        ]
                    ]);
                }
            
                unset($tutition);
            }
            
            
            $page = $jatbi->pages($count,$setting['site_page'],$pg);
            $templates = $setting['site_backend'] . 'tuitions.tpl';
    }
    elseif($router['1']=='tuition_debt_detail'){
        $jatbi->permission('tuition_debt_detail');
        if ($router['2']) {    
            $class_st=$database->get('arrange_class','class_diagram',["id"=>$xss->xss($router['2']),"deleted"=> 0,"status"=>'A']); 
            $students=$database->get('students','*',["id"=>$database->get('arrange_class','students',["id"=>$xss->xss($router['2']),"deleted"=> 0,"status"=>'A']),"deleted"=> 0,"status"=>'A']); 
            $date=date("Y-m-d");
            $course=$database->select("course","*",[
                "school"        =>$school_id,
                "status"        =>'A',
                "deleted"       => 0,
            ]);
            foreach($course as $value){
                $date_timestamp = strtotime($date);
                $start_timestamp = strtotime($value['startdate']);
                $end_timestamp = strtotime($value['enddate']);
                
                if ($date_timestamp >= $start_timestamp && $date_timestamp <= $end_timestamp) {
                    $class_course = $database->get("class_diagram", "*",[
                        "AND" => [
                            "deleted"       => 0,
                            "id"    => $class_st,
                            'course'        => $value['id'],
                            "school"=>$school_id,
                        ],
                        "ORDER" => [
                            "id"=>"DESC",
                        ]
                    ]);    
                }
            }
            $course_current=$database->get('course','*',["id"=>$class_course['course'],"deleted"=> 0,"status"=>'A']); 
            // $count = $database->count("content_tuition",[
            //     'AND' => [
            //         "class_diagram"         =>$class_st,
            //         "deleted"       => 0,
            //         "school"        =>$school_id,
            //     ]]
            // );
            $tuition_order_detail= $database->select('tuition_order_detail','content_tuition',["arrange_class"=>$xss->xss($router['2']),"deleted"=> 0,"status"=>'A',"school"        =>$school_id]);
            for($i=1; $i<13;$i++){
                if($i<=12 && $i>= date("m", strtotime($course_current['startdate']))){
                    $month[]=[
                        "months"=>$i,
                        "year"=>date("Y", strtotime($course_current['startdate'])),
                    ];
                }elseif($i>=1 && $i<= date("m", strtotime($course_current['enddate']))){
                    $month[]=[
                        "months"=>$i,
                        "year"=>date("Y", strtotime($course_current['enddate'])),
                    ];
                }
            }
            $content_tuitions = $database->select("content_tuition", "*",[
                "AND" => [
                    'status'        => "A", 
                    "deleted"       => 0,
                    "class_diagram"         =>$class_st,    
                    "school"        =>$school_id,  
                    "type"          =>[0,1],                 
                ],
            ]);
            $m=date("m", strtotime($students['year_of_admission']));
            $y=date("Y", strtotime($students['year_of_admission']));
            foreach($month as $monthh){
                if($monthh['months']>=$m && $monthh['year']==$y || $monthh['months']<$m && $monthh['year']>$y){
                foreach($content_tuitions as $content_tuition){
                    $timework_details = $database->select("timework_details", "week",[
                        "AND" => [
                            "deleted"       => 0,
                            "off"		=>1,
                            "school" =>$_SESSION['school'],
                        ]
                     ]); 
                    $number_day=0;
                    $songay=0;
                    $thang=$monthh['months'];
                    $nam=date("Y", strtotime($value['payment_deadline']));
    
                    if (!function_exists('cal_days_in_month')) {
                        function cal_days_in_month($calendar, $thang, $year) {
                            return intval(date('t', strtotime($year . '-' . $thang . '-01')));
                        }
                    }
                    $ngaytrongthang= cal_days_in_month(CAL_GREGORIAN,$thang, date("Y", strtotime($value['payment_deadline'])));
                    for ($ngay = 1; $ngay <= $ngaytrongthang; $ngay++) {
                        $ngayhientai = date('N', strtotime("$nam-$thang-$ngay"));
                        if (!in_array($ngayhientai,$timework_details)) {
                            $songay++;
                        }
                    }
                    $datas1[]=[
                        "id"=>$content_tuition['id'],
                        "content"=>$content_tuition['content'],
                        "class_diagram"=>$content_tuition['class_diagram'],
                        "price"=>$content_tuition['price'],
                        "payment_deadline"=>$monthh['year'],
                        "month"=>$monthh['months'],
                        "type"=>$content_tuition['type'],
                        "number_of_month"=>$songay,  
                    ];
                }
            }
            }
            $pg = $_GET['pg'];
            if (!$pg)
                $pg = 1;
                $tuition_order_details=$database->select('tuition_order_detail','*',["school"        =>$school_id,"arrange_class"=>$xss->xss($router['2']),"deleted"=> 0,"status"=>'A']);
                $students=$database->get('students','*',["school"        =>$school_id,"id"=>$database->get('arrange_class','students',["id"=>$xss->xss($router['2']),"deleted"=> 0,"status"=>'A']),"deleted"=> 0,"status"=>'A']);
                foreach($datas1 as $data){
                    $found = false;
                    foreach($tuition_order_details as $value){
                        if ($data["id"] == $value['content_tuition'] && $data["month"] == $value['month']) {
                            $found = true;
                            break;
                        }
                    }
                    if(!$found){
                        if($data['month']){
                        $datas[]=[
                            "id"=>$data['id'],
                            "content"=>$data['content'],
                            "class_diagram"=>$data['class_diagram'],
                            "price"=>$data['price'],
                            "payment_deadline"=>$data['payment_deadline'],
                            "month"=>$data['month'],
                            "type"=>$data['type'],
                            "number_of_month"=>$data['number_of_month'],  
                        ];
                    }
                    }
                }
            // $count = count($datas);
            // $page = $jatbi->pages($count, $setting['site_page'], $pg);
            $templates = $setting['site_backend'] . 'tuitions.tpl';
        }
        
    }
    elseif($router['1']=='type-payments'){
		$jatbi->permission('type-payments');
		$count = $database->count("type_payments",[
			'AND' => [
				'name[~]'  		=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']), 
				'status' 		=> ($xss->xss($_GET['status'])=='')?[A,D]:$xss->xss($_GET['status']),
				"deleted"		=> 0,
                "school"        =>$school_id,
			]]
		);
		$pg = $_GET['pg'];
		if (!$pg) $pg = 1;
		$datas = $database->select("type_payments", "*",[
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
		$templates = $setting['site_backend'].'tuitions.tpl';
	}
	elseif($router['1']=='type-payments-add'){
		$jatbi->permission('type-payments.add');
		$ajax = 'true';
		if(isset($_POST['token'])){
			if($_POST['name'] == "" || $_POST['has'] == "" || $_POST['debt'] == "" || $_POST['type'] == "" ){
				echo json_encode(['status'=>'error','content'=>$lang['loi-trong']]);
			}
			if ($_POST['name'] && $_POST['has'] && $_POST['debt'] && $_POST['type'] ){
				$insert = [
					"code" 			=> $xss->xss($_POST['code']),
					"main" 			=> $xss->xss($_POST['main']),
					"name" 			=> $xss->xss($_POST['name']),
					"has" 			=> $xss->xss($_POST['has']),
					"debt" 			=> $xss->xss($_POST['debt']),
					"notes" 		=> $xss->xss($_POST['notes']),
					"status" 		=> $xss->xss($_POST['status']),
					"type"			=> $xss->xss($_POST['type']),
                    "school"        =>$school_id,
				];
				$database->insert("type_payments",$insert);
				$jatbi->logs('type-payments','add',$insert);
				echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
			}
		} else {
			$templates = $setting['site_backend'].'tuitions.tpl';
		}
	}
	elseif($router['1']=='type-payments-edit'){
		$jatbi->permission('type-payments.edit');
		$ajax = 'true';
		if($router['2']){
			$data = $database->get("type_payments", "*",["id"=>$xss->xss($router['2'])]);
			if($data>1){
				if(isset($_POST['token'])){
					if($_POST['name'] == "" || $_POST['has'] == "" || $_POST['debt'] == "" || $_POST['type'] == ""){
						echo json_encode(['status'=>'error','content'=>$lang['loi-trong']]);
					}
					if ($_POST['name'] && $_POST['has'] && $_POST['debt'] && $_POST['type']){
						$insert = [
							"code" 			=> $xss->xss($_POST['code']),
							"main" 			=> $xss->xss($_POST['main']),
							"name" 			=> $xss->xss($_POST['name']),
							"has" 			=> $xss->xss($_POST['has']),
							"debt" 			=> $xss->xss($_POST['debt']),
							"notes" 		=> $xss->xss($_POST['notes']),
							"status" 		=> $xss->xss($_POST['status']),
							"type"			=> $xss->xss($_POST['type']),
                            "school"        =>$school_id,
						];
						$database->update("type_payments",$insert,["id"=>$data['id']]);
						$jatbi->logs('type-payments','edit',$insert);
						echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
					}
				} else {
					$vgroup = unserialize($data['group']);
					$templates = $setting['site_backend'].'tuitions.tpl';
				}
			}
			else {
				header("HTTP/1.0 404 Not Found");
				die();
			}
		}
	}
	elseif($router['1']=='type-payments-status'){
		$jatbi->permission('type-payments.edit');
		$ajax = 'true';
		if($router['2']){
			$data = $database->get("type_payments", "*",["id"=>$xss->xss($router['2'])]);
			if($data>1){
				if($data['status']==='A'){
					$status = "D";
				} 
				elseif($data['status']==='D'){
					$status = "A";
				}
				$database->update("type_payments",["status"=>$status],["id"=>$data['id']]);
				$jatbi->logs('type-payments','status',["data"=>$data,"status"=>$status]);
				echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-trang-thai'],'sound'=>$setting['site_sound']]);
			}
			else {
				echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-that-bai'],]);
			}
		}
	}
	elseif($router['1']=='type-payments-delete'){
		$jatbi->permission('type-payments.delete');
		$ajax = 'true';
		if($router['2']){
			$datas = $database->select("type_payments","*",["id"=>explode(',', $xss->xss($router['2']))]);
			if(isset($_POST['submit'])){
				$jatbi->logs('type-payments','delete',$datas);
				$database->update("type_payments",["deleted"	=> 1,],["id"=>explode(',', $xss->xss($router['2']))]);
				echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
			} else {
				$templates = $setting['site_backend'].'tuitions.tpl';
			}
		}
		else {
			header("HTTP/1.0 404 Not Found");
			die();
		}
	}
    elseif($router['1']=='expenditure'){
		$jatbi->permission('expenditure');
		$date = explode('-',$xss->xss($_GET['date']));
		$date_from = ($_GET['date']=='')?date('Y-01-01'):date('Y-m-d',strtotime(str_replace('/','-',$date[0])));
		$date_to = ($_GET['date']=='')?date('Y-m-d'):date('Y-m-d',strtotime(str_replace('/','-',$date[1])));
		$count = $database->count("expenditure",[
			'AND' => [
				"OR"=>[
					'ballot[~]'  		=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
					'content[~]'  		=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
				],
				'type[<>]'		=> ($xss->xss($_GET['type'])=='')?'':[$xss->xss($_GET['type']),$xss->xss($_GET['type'])],
				'debt[<>]'		=> ($xss->xss($_GET['debt'])=='')?'':[$xss->xss($_GET['debt']),$xss->xss($_GET['debt'])],
				'has[<>]'		=> ($xss->xss($_GET['has'])=='')?'':[$xss->xss($_GET['has']),$xss->xss($_GET['has'])],
				'user[<>]'		=> ($xss->xss($_GET['user'])=='')?'':[$xss->xss($_GET['user']),$xss->xss($_GET['user'])],
				"date[<>]" 		=> [$date_from,$date_to],
                "school"=>$school_id,
				"deleted"		=> 0,
			]]
		);
		$pg = $_GET['pg'];
		if (!$pg) $pg = 1;
		$datas = $database->select("expenditure", "*",[
			"AND" => [
				"OR"=>[
					
					'content[~]'  		=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
				],
				'type[<>]'		=> ($xss->xss($_GET['type'])=='')?'':[$xss->xss($_GET['type']),$xss->xss($_GET['type'])],
				'debt[<>]'		=> ($xss->xss($_GET['debt'])=='')?'':[$xss->xss($_GET['debt']),$xss->xss($_GET['debt'])],
				'has[<>]'		=> ($xss->xss($_GET['has'])=='')?'':[$xss->xss($_GET['has']),$xss->xss($_GET['has'])],
				'user[<>]'		=> ($xss->xss($_GET['user'])=='')?'':[$xss->xss($_GET['user']),$xss->xss($_GET['user'])],
				"date[<>]" 		=> [$date_from,$date_to],
                "school"=>$school_id,
				"deleted"		=> 0,
			],
			"LIMIT" =>[(($pg-1)*$setting['site_page']),$setting['site_page']],
			"ORDER"	=> [
				"date"=>"ASC",
			]
		]);
		$total_first_thu_page = $database->select("expenditure", ["price","type"],[
			"AND" => [
				"OR"=>[
					'ballot[~]'  		=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
					'content[~]'  		=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
				],
				'type[<>]'		=> ($xss->xss($_GET['type'])=='')?'':[$xss->xss($_GET['type']),$xss->xss($_GET['type'])],
				'debt[<>]'		=> ($xss->xss($_GET['debt'])=='')?'':[$xss->xss($_GET['debt']),$xss->xss($_GET['debt'])],
				'has[<>]'		=> ($xss->xss($_GET['has'])=='')?'':[$xss->xss($_GET['has']),$xss->xss($_GET['has'])],
				'user[<>]'		=> ($xss->xss($_GET['user'])=='')?'':[$xss->xss($_GET['user']),$xss->xss($_GET['user'])],
				"date[<>]" 		=> [$date_from,$date_to],
                "school"=>$school_id,
				"deleted"		=> 0,
			],
			"LIMIT" =>(($pg-1)*$setting['site_page']),
			"ORDER"	=> [
				"date"=>"ASC",
			]
		]);
		foreach ($total_first_thu_page as $key => $value) {
			$total_page[$value['type']][] = $value['price'];
		}
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
                "school"=>$school_id,
				"deleted"		=> 0,
			],
			// "LIMIT" =>[(($pg-1)*$setting['site_page']),$setting['site_page']],
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
                "school"=>$school_id,
				"deleted"		=> 0,
			],
			// "LIMIT" =>[(($pg-1)*$setting['site_page']),$setting['site_page']],
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
                "school"=>$school_id,
				"deleted"		=> 0,
			],
			// "LIMIT" =>[(($pg-1)*$setting['site_page']),$setting['site_page']],
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
                "school"=>$school_id,
				"deleted"		=> 0,
			],
			// "LIMIT" =>[(($pg-1)*$setting['site_page']),$setting['site_page']],
			"ORDER"	=> [
				"date"=>"ASC",
			]
		]);
		$page = $jatbi->pages($count,$setting['site_page'],$pg);
		$templates = $setting['site_backend'].'tuitions.tpl';
	}
	elseif($router['1']=='expenditure-add'){
		$jatbi->permission('expenditure.add');
		$ajax = 'true';
		if(isset($_POST['token'])){
			
			if($_POST['token']!=$_SESSION['csrf']['token']){
				echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
			}
			elseif($_POST['type'] == "" || $_POST['debt'] == "" || $_POST['has'] == "" || $_POST['price'] == "" || $_POST['content'] == "" || $_POST['date'] == "" ){
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
					"purchase" 		=> $xss->xss($_POST['purchase']),
					"notes" 		=> $xss->xss($_POST['notes']),
					"user"			=> $account['id'],
					"date_poster"	=> date("Y-m-d H:i:s"),
					"school"        =>$school_id,
				];
				$database->insert("expenditure",$insert);
				$jatbi->logs('expenditure','add',$insert);
				echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
			}
		} else {
			$templates = $setting['site_backend'].'tuitions.tpl';
		}
	}
	elseif($router['1']=='expenditure-edit'){
		$jatbi->permission('expenditure.edit');
		$ajax = 'true';
		if($router['2']){
			$data = $database->get("expenditure", "*",[ "school"        =>$school_id,"id"=>$xss->xss($router['2'])]);
			if($data>1){
				if(isset($_POST['token'])){
					if($_POST['token']!=$_SESSION['csrf']['token']){
						echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
					}
					elseif($_POST['type'] == "" || $_POST['debt'] == "" || $_POST['has'] == "" || $_POST['price'] == "" || $_POST['content'] == "" || $_POST['date'] == ""  || $input_stores==""){
						echo json_encode(['status'=>'error','content'=>$lang['loi-trong']]);
					}
					if ($_POST['type'] && $_POST['debt'] && $_POST['has'] && $_POST['price'] && $_POST['content'] && $_POST['date'] && $input_stores){
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
                            "purchase" 		=> $xss->xss($_POST['purchase']),
                            "notes" 		=> $xss->xss($_POST['notes']),
                            "user"			=> $account['id'],
                            "date_poster"	=> date("Y-m-d H:i:s"),
                            "school"        =>$school_id,
						];
						$database->update("expenditure",$insert,["id"=>$data['id']]);
						$jatbi->logs('expenditure','edit',$insert);
						echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
					}
				} else {
					$vgroup = unserialize($data['group']);
					$templates = $setting['site_backend'].'tuitions.tpl';
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
				$templates = $setting['site_backend'].'tuitions.tpl';
			}
		}
		else {
			header("HTTP/1.0 404 Not Found");
			die();
		}
	}
?>