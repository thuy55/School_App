<?php
    if (!defined('JATBI')) die("Hacking attempt");
    $school_id=$_SESSION['school'];
    $typeroom = $database->select("typeroom", "*",["school"=>$school_id,"deleted"=> 0,"status"=>'A']);
    $day= $database->select("day", "*",["deleted"=> 0,"status"=>'A']);
    $areas = $database->select("areas", "*",["school"=>$school_id,"deleted"=> 0,"status"=>'A']);
    $stu=$database->select("arrange_class","students",["school"=>$school_id,"deleted"=> 0,"status"=>'A']);
   
    $students = $database->select("students","*",
                        ["id[!]"=>$stu,
                        "school"=>$school_id,
                        "deleted"=> 0,
                        "status"=>'A']);
    $semesters = $database->select("semester", "*",["school"=>$school_id,"deleted"=> 0,"status"=>'A']);
    $course = $database->select("course", "*",["school"=>$school_id,"deleted"=> 0,"status"=>'A']);
  
    $grade = $database->select("grade", "*",["school"=>$school_id,"deleted"=> 0,"status"=>'A']);
    $class = $database->select("class", "*",["school"=>$school_id,"deleted"=> 0,"status"=>'A']);
    $classroom = $database->select("classroom", "*",["school"=>$school_id,"deleted"=> 0,"status"=>'A']);
    $subject = $database->select("subject", "*",["school"=>$school_id,"deleted"=> 0,"status"=>'A']);
    $schedule = $database->select("schedule", "*",["school"=>$school_id,"deleted"=> 0,"status"=>'A']);
    $day = $database->select("day", "*",["deleted"=> 0,"status"=>'A']);
    $lesson = $database->select("lesson", "*");
    $school_teacher=$database->select("school_teacher", "*",["school"=>$school_id,"deleted"=> 0,"status"=>'A']);
    $class_diagram=$database->select("class_diagram", "*",
                        ["school"=>$school_id,
                        "deleted"=> 0,
                        "status"=>'A'
                    ]);
    $school_teachers=$database->select("school_teacher","*",['school'=>$school_id['id'],"deleted"=> 0,"status"=>'A']);

    if($router['1']=='grade'){
        $jatbi->permission('grade');
        $count = $database->count("grade",[
            'AND' => [
               
                "deleted"       => 0,
                "school"    =>$school_id,
            ]]
        );
        $pg = $_GET['pg'];
        if (!$pg) $pg = 1;
        $datas = $database->select("grade", "*",[
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
        $templates = $setting['site_backend'].'class-academic.tpl';
    }
    elseif($router['1']=='grade-add'){
        $jatbi->permission('grade.add');
        $ajax = 'true';
        if(isset($_POST['token'])){
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
                    "status"        => $xss->xss($_POST['status']),
                    "school"        =>$school_id,
                ];
                $database->insert("grade",$insert);
                $jatbi->logs('grade','add',$insert);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            }
        } 
        else {
            $templates = $setting['site_backend'].'class-academic.tpl';
        }
    }
    elseif($router['1']=='grade-edit'){
        $jatbi->permission('grade.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("grade", "*",["id"=>$xss->xss($router['2'])]);
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
                            "name"         => $xss->xss($_POST['name']),                                  
                            "status"        => $xss->xss($_POST['status']),
                            "school"        =>$school_id,
                        ];
                        $database->update("grade",$insert,["id"=>$data['id']]);
                        $jatbi->logs('grade','edit',$insert);
                        echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
                    }
                } else {
                    $templates = $setting['site_backend'].'class-academic.tpl';
                }
            }
            else {
                header("HTTP/1.0 404 Not Found");
                die();
            }
        }
    }
    elseif($router['1']=='grade-delete'){
        $jatbi->permission('grade.delete');
        $ajax = 'true';
        if($router['2']){
            $datas = $database->select("grade","*",["id"=>explode(',', $xss->xss($router['2']))]);
            if(isset($_POST['submit'])){
                $jatbi->logs('grade','delete',$datas);
                $database->update("grade",["deleted" => 1,],["id"=>explode(',', $xss->xss($router['2']))]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            } else {
                $templates = $setting['site_backend'].'class-academic.tpl';
            }
        }
        else {
            header("HTTP/1.0 404 Not Found");
            die();
        }
    }
    elseif($router['1']=='grade-status'){
        $jatbi->permission('grade.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("grade", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if($data['status']==='A'){
                    $status = "D";
                } 
                elseif($data['status']==='D'){
                    $status = "A";
                }
                $database->update("grade",["status"=>$status],["id"=>$data['id']]);
                $jatbi->logs('grade','status',["data"=>$data,"status"=>$status]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-trang-thai'],'sound'=>$setting['site_sound']]);
            }
            else {
                echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-that-bai'],]);
            }
        }
    }
    elseif($router['1']=='class_diagram'){
        $jatbi->permission('class_diagram');
        
        $count = $database->count("class_diagram",[
            'AND' => [
                'name[~]'  		=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']), 
                "deleted"       => 0,
            ]]
        );
        
        $pg = $_GET['pg'];
        if (!$pg) $pg = 1;
        $datas = $database->select("class_diagram", "*",[
            "AND" => [
                'status'        => ($xss->xss($_GET['status'])=='')?[A,D]:$xss->xss($_GET['status']), 
                "deleted"       => 0,
                "school"    =>$school_id,
                'course[<>]'=> ($xss->xss($_GET['course'])=='')?:[$xss->xss($_GET['course']),$xss->xss($_GET['course'])], 
            ],

            "LIMIT" =>[(($pg-1)*$setting['site_page']),$setting['site_page']],
            "ORDER" => [
                "id"=>"DESC",
            ]
        ]);
        $page = $jatbi->pages($count,$setting['site_page'],$pg);
        $templates = $setting['site_backend'].'class-academic.tpl';
    }
    elseif($router['1']=='class_diagram-add'){
        $jatbi->permission('class_diagram.add');
        $ajax = 'true';
        if(isset($_POST['token'])){
            $handle = new Upload($_FILES['avatar']);
            if($_POST['token']!=$_SESSION['csrf']['token']){
                echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
            }
            elseif($_POST['homeroom_teacher'] == "" ||  $_POST['course'] == "" ||  $_POST['grade'] == ""  ||  $_POST['class'] == ""){
                echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
            }
            if ($handle->processed    && $_POST['homeroom_teacher'] && $_POST['course'] && $_POST['grade'] && $_POST['class']) {
                $insert = [                  
                    "homeroom_teacher" => $xss->xss($_POST['homeroom_teacher']),      
                    "course"          => $xss->xss($_POST['course']),
                    "grade"          => $xss->xss($_POST['grade']),
                    "class"          => $xss->xss($_POST['class']),                            
                    "status"        => $xss->xss($_POST['status']),
                    "classroom"        => $xss->xss($_POST['classroom']),
                    "school"        =>$school_id,
                ];
                $database->insert("class_diagram",$insert);
                $jatbi->logs('class_diagram','add',$insert);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            }
        } 
        else {
            $templates = $setting['site_backend'].'class-academic.tpl';
        }
    }
    elseif($router['1']=='class_diagram-edit'){
        $jatbi->permission('class_diagram.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("class_diagram", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if(isset($_POST['token'])){
                    $partten = "/^[A-Za-z0-9_\.]{".$setting['site_characters'].",32}$/";
                    
                    $handle = new Upload($_FILES['avatar']);
                    if($_POST['token']!=$_SESSION['csrf']['token']){
                        echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
                    }
                    elseif($_POST['homeroom_teacher'] == "" ||  $_POST['course'] == "" ||  $_POST['grade'] == ""  ||  $_POST['class'] == ""){
                        echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
                    }
                    if ($handle->processed  && $_POST['homeroom_teacher'] && $_POST['course'] && $_POST['grade'] && $_POST['class']) {
                        $insert = [                  
                           
                            "homeroom_teacher" => $xss->xss($_POST['homeroom_teacher']),      
                            "course"          => $xss->xss($_POST['course']),
                            "grade"          => $xss->xss($_POST['grade']),
                            "class"          => $xss->xss($_POST['class']),                            
                            "status"        => $xss->xss($_POST['status']),
                            "classroom"        => $xss->xss($_POST['classroom']),
                            "school"        =>$school_id,
                        ];
                        $database->update("class_diagram",$insert,["id"=>$data['id']]);
                        $jatbi->logs('class_diagram','edit',$insert);
                        echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
                    }
                } else {
                    $templates = $setting['site_backend'].'class-academic.tpl';
                }
            }
            else {
                header("HTTP/1.0 404 Not Found");
                die();
            }
        }
    }
    elseif($router['1']=='class_diagram-delete'){
        $jatbi->permission('class_diagram.delete');
        $ajax = 'true';
        if($router['2']){
            $datas = $database->select("class_diagram","*",["id"=>explode(',', $xss->xss($router['2']))]);
            if(isset($_POST['submit'])){
                $jatbi->logs('class_diagram','delete',$datas);
                $database->update("class_diagram",["deleted" => 1,],["id"=>explode(',', $xss->xss($router['2']))]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            } else {
                $templates = $setting['site_backend'].'class-academic.tpl';
            }
        }
        else {
            header("HTTP/1.0 404 Not Found");
            die();
        }
    }
    elseif($router['1']=='class_diagram-status'){
        $jatbi->permission('class_diagram.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("class_diagram", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if($data['status']==='A'){
                    $status = "D";
                } 
                elseif($data['status']==='D'){
                    $status = "A";
                }
                $database->update("class_diagram",["status"=>$status],["id"=>$data['id']]);
                $jatbi->logs('class_diagram','status',["data"=>$data,"status"=>$status]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-trang-thai'],'sound'=>$setting['site_sound']]);
            }
            else {
                echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-that-bai'],]);
            }
        }
    }
    elseif($router['1']=='class_diagram_student'){
        $jatbi->permission('class_diagram_student');
        if($router['2']){
            $count = $database->count("arrange_class",[
                'AND' => [
                    'name[~]'  		=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']), 
                    "deleted"       => 0,
                    "school"    =>$school_id,
                    "class_diagram"=>$router['2'],
                ]]
            );
            $pg = $_GET['pg'];
            if (!$pg) $pg = 1;
            $datas = $database->select("arrange_class", "*",[
                "AND" => [
                    'status'        => ($xss->xss($_GET['status'])=='')?[A,D]:$xss->xss($_GET['status']), 
                    "deleted"       => 0,
                    "school"    =>$school_id,
                    "class_diagram"=>$router['2'],
                ],
                "LIMIT" =>[(($pg-1)*$setting['site_page']),$setting['site_page']],
                "ORDER" => [
                    "id"=>"DESC",
                ]
            ]);
            $page = $jatbi->pages($count,$setting['site_page'],$pg);
            $templates = $setting['site_backend'].'class-academic.tpl';
        }
       
    }
    elseif($router['1']=='course'){
        $jatbi->permission('course');
        $count = $database->count("course",[
            'AND' => [
                "deleted"       => 0,
            ]]
        );
        $pg = $_GET['pg'];
        if (!$pg) $pg = 1;
        $datas = $database->select("course", "*",[
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
        $templates = $setting['site_backend'].'class-academic.tpl';
    }
    elseif($router['1']=='course-add'){
        $jatbi->permission('course.add');
        $ajax = 'true';
        if(isset($_POST['token'])){
            $handle = new Upload($_FILES['avatar']);
            if($_POST['token']!=$_SESSION['csrf']['token']){
                echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
            }
            elseif($_POST['name'] == "" ||$_POST['startdate'] == ""||$_POST['enddate'] == ""){
                echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
            }
            if ($handle->processed  && $_POST['name'] && $_POST['startdate'] && $_POST['enddate'] ){
                $insert = [                  
                    "name"         => $xss->xss($_POST['name']),
                    "startdate"         => $xss->xss($_POST['startdate']),
                    "enddate"         => $xss->xss($_POST['enddate']),                                  
                    "status"        => $xss->xss($_POST['status']),
                    "school"        =>$school_id,
                ];
                $database->insert("course",$insert);
                $jatbi->logs('course','add',$insert);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            }
        } 
        else {
            $templates = $setting['site_backend'].'class-academic.tpl';
        }
    }
    elseif($router['1']=='course-edit'){
        $jatbi->permission('course.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("course", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if(isset($_POST['token'])){
                    $partten = "/^[A-Za-z0-9_\.]{".$setting['site_characters'].",32}$/";
                    
                    $handle = new Upload($_FILES['avatar']);
                    if($_POST['token']!=$_SESSION['csrf']['token']){
                        echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
                    }
                    elseif($_POST['name'] == "" ||$_POST['startdate'] == ""||$_POST['enddate'] == ""){
                        echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
                    }
                    if ($handle->processed  && $_POST['name'] && $_POST['startdate'] && $_POST['enddate'] ){
                        $insert = [                  
                            "name"         => $xss->xss($_POST['name']),   
                            "startdate"         => $xss->xss($_POST['startdate']),
                            "enddate"         => $xss->xss($_POST['enddate']),                                   
                            "status"        => $xss->xss($_POST['status']),
                            "school"        =>$school_id,
                        ];
                        $database->update("course",$insert,["id"=>$data['id']]);
                        $jatbi->logs('course','edit',$insert);
                        echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
                    }
                } else {
                    $templates = $setting['site_backend'].'class-academic.tpl';
                }
            }
            else {
                header("HTTP/1.0 404 Not Found");
                die();
            }
        }
    }
    elseif($router['1']=='course-delete'){
        $jatbi->permission('course.delete');
        $ajax = 'true';
        if($router['2']){
            $datas = $database->select("course","*",["id"=>explode(',', $xss->xss($router['2']))]);
            if(isset($_POST['submit'])){
                $jatbi->logs('course','delete',$datas);
                $database->update("course",["deleted" => 1,],["id"=>explode(',', $xss->xss($router['2']))]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            } else {
                $templates = $setting['site_backend'].'class-academic.tpl';
            }
        }
        else {
            header("HTTP/1.0 404 Not Found");
            die();
        }
    }
    elseif($router['1']=='course-status'){
        $jatbi->permission('course.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("course", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if($data['status']==='A'){
                    $status = "D";
                } 
                elseif($data['status']==='D'){
                    $status = "A";
                }
                $database->update("course",["status"=>$status],["id"=>$data['id']]);
                $jatbi->logs('course','status',["data"=>$data,"status"=>$status]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-trang-thai'],'sound'=>$setting['site_sound']]);
            }
            else {
                echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-that-bai'],]);
            }
        }
    }
    elseif($router['1']=='semester'){
        $jatbi->permission('semester');
        $count = $database->count("semester",[
            'AND' => [
                "deleted"       => 0,
            ]]
        );
        $pg = $_GET['pg'];
        if (!$pg) $pg = 1;
        $datas = $database->select("semester", "*",[
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
        $templates = $setting['site_backend'].'class-academic.tpl';
    }
    elseif($router['1']=='semester-add'){
        $jatbi->permission('semester.add');
        $ajax = 'true';
        if(isset($_POST['token'])){
           
            if($_POST['token']!=$_SESSION['csrf']['token']){
                echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
            }
            elseif($_POST['name'] == "" ||$_POST['startdate'] == ""||$_POST['enddate'] == ""||$_POST['course'] == ""){
                echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
            }
            if ($_POST['name'] && $_POST['startdate'] && $_POST['enddate'] && $_POST['course']){
                $insert = [     
                    "course"    => $xss->xss($_POST['course']),
                    "name"         => $xss->xss($_POST['name']),
                    "startdate"         => $xss->xss($_POST['startdate']),
                    "enddate"         => $xss->xss($_POST['enddate']),                                  
                    "status"        => $xss->xss($_POST['status']),
                    "school"        =>$school_id,
                ];
                $database->insert("semester",$insert);
                $jatbi->logs('semester','add',$insert);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            }
        } 
        else {
            $templates = $setting['site_backend'].'class-academic.tpl';
        }
    }
    elseif($router['1']=='semester-edit'){
        $jatbi->permission('semester.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("semester", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if(isset($_POST['token'])){
                    $partten = "/^[A-Za-z0-9_\.]{".$setting['site_characters'].",32}$/";
                    
                    $handle = new Upload($_FILES['avatar']);
                    if($_POST['token']!=$_SESSION['csrf']['token']){
                        echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
                    }
                    elseif($_POST['name'] == "" ||$_POST['startdate'] == ""||$_POST['enddate'] == ""||$_POST['course'] == ""){
                        echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
                    }
                    if ($_POST['name'] && $_POST['startdate'] && $_POST['enddate'] && $_POST['course']){
                        $insert = [     
                            "course"    => $xss->xss($_POST['course']),
                            "name"         => $xss->xss($_POST['name']),
                            "startdate"         => $xss->xss($_POST['startdate']),
                            "enddate"         => $xss->xss($_POST['enddate']),                                  
                            "status"        => $xss->xss($_POST['status']),
                            "school"        =>$school_id,
                        ];
                        $database->update("semester",$insert,["id"=>$data['id']]);
                        $jatbi->logs('semester','edit',$insert);
                        echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
                    }
                } else {
                    $templates = $setting['site_backend'].'class-academic.tpl';
                }
            }
            else {
                header("HTTP/1.0 404 Not Found");
                die();
            }
        }
    }
    elseif($router['1']=='semester-delete'){
        $jatbi->permission('semester.delete');
        $ajax = 'true';
        if($router['2']){
            $datas = $database->select("semester","*",["id"=>explode(',', $xss->xss($router['2']))]);
            if(isset($_POST['submit'])){
                $jatbi->logs('semester','delete',$datas);
                $database->update("semester",["deleted" => 1,],["id"=>explode(',', $xss->xss($router['2']))]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            } else {
                $templates = $setting['site_backend'].'class-academic.tpl';
            }
        }
        else {
            header("HTTP/1.0 404 Not Found");
            die();
        }
    }
    elseif($router['1']=='semester-status'){
        $jatbi->permission('semester.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("semester", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if($data['status']==='A'){
                    $status = "D";
                } 
                elseif($data['status']==='D'){
                    $status = "A";
                }
                $database->update("semester",["status"=>$status],["id"=>$data['id']]);
                $jatbi->logs('semester','status',["data"=>$data,"status"=>$status]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-trang-thai'],'sound'=>$setting['site_sound']]);
            }
            else {
                echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-that-bai'],]);
            }
        }
    }
    elseif($router['1']=='location'){
        $jatbi->permission('location');
        $count = $database->count("areas",[
            'AND' => [
                "deleted"       => 0,
            ]]
        );
        $pg = $_GET['pg'];
        if (!$pg) $pg = 1;
        $datas = $database->select("areas", "*",[
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
        $templates = $setting['site_backend'].'class-academic.tpl';
    }
    elseif($router['1']=='location-add'){
        $jatbi->permission('location.add');
        $ajax = 'true';
        if(isset($_POST['token'])){
            $handle = new Upload($_FILES['avatar']);
            if($_POST['token']!=$_SESSION['csrf']['token']){
                echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
            }
            elseif($_POST['name'] == "" ){
                echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
            }
            if ($handle->processed  && $_POST['name']) {
                $insert = [                  
                    "name"         => $xss->xss($_POST['name']),                                  
                    "status"        => $xss->xss($_POST['status']),
                    "school"        =>$school_id,
                ];
                $database->insert("areas",$insert);
                $jatbi->logs('areas','add',$insert);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            }
        } 
        else {
            $templates = $setting['site_backend'].'class-academic.tpl';
        }
    }
    elseif($router['1']=='location-edit'){
        $jatbi->permission('location.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("areas", "*",["id"=>$xss->xss($router['2'])]);
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
                            "name"         => $xss->xss($_POST['name']),                                  
                            "status"        => $xss->xss($_POST['status']),
                            "school"        =>$school_id,
                        ];
                        $database->update("areas",$insert,["id"=>$data['id']]);
                        $jatbi->logs('areas','edit',$insert);
                        echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
                    }
                } else {
                    $templates = $setting['site_backend'].'class-academic.tpl';
                }
            }
            else {
                header("HTTP/1.0 404 Not Found");
                die();
            }
        }
    }
    elseif($router['1']=='location-delete'){
        $jatbi->permission('location.delete');
        $ajax = 'true';
        if($router['2']){
            $datas = $database->select("areas","*",["id"=>explode(',', $xss->xss($router['2']))]);
            if(isset($_POST['submit'])){
                $jatbi->logs('areas','delete',$datas);
                $database->update("areas",["deleted" => 1,],["id"=>explode(',', $xss->xss($router['2']))]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            } else {
                $templates = $setting['site_backend'].'class-academic.tpl';
            }
        }
        else {
            header("HTTP/1.0 404 Not Found");
            die();
        }
    }
    elseif($router['1']=='location-status'){
        $jatbi->permission('location.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("areas", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if($data['status']==='A'){
                    $status = "D";
                } 
                elseif($data['status']==='D'){
                    $status = "A";
                }
                $database->update("areas",["status"=>$status],["id"=>$data['id']]);
                $jatbi->logs('areas','status',["data"=>$data,"status"=>$status]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-trang-thai'],'sound'=>$setting['site_sound']]);
            }
            else {
                echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-that-bai'],]);
            }
        }
    }
    elseif($router['1']=='classroom_type'){
        $jatbi->permission('classroom_type');
        $count = $database->count("typeroom",[
            'AND' => [
                "deleted"       => 0,
            ]]
        );
        $pg = $_GET['pg'];
        if (!$pg) $pg = 1;
        $datas = $database->select("typeroom", "*",[
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
        $templates = $setting['site_backend'].'class-academic.tpl';
    }
    elseif($router['1']=='classroom_type-add'){
        $jatbi->permission('classroom_type.add');
        $ajax = 'true';
        if(isset($_POST['token'])){
            $handle = new Upload($_FILES['avatar']);
            if($_POST['token']!=$_SESSION['csrf']['token']){
                echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
            }
            elseif($_POST['name'] == "" ){
                echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
            }
            if ($handle->processed  && $_POST['name']) {
                $insert = [                  
                    "name"         => $xss->xss($_POST['name']),                                  
                    "status"        => $xss->xss($_POST['status']),
                    "school"        =>$school_id,
                ];
                $database->insert("typeroom",$insert);
                $jatbi->logs('typeroom','add',$insert);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            }
        } 
        else {
            $templates = $setting['site_backend'].'class-academic.tpl';
        }
    }
    elseif($router['1']=='classroom_type-edit'){
        $jatbi->permission('classroom_type.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("typeroom", "*",["id"=>$xss->xss($router['2'])]);
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
                            "name"         => $xss->xss($_POST['name']),                                  
                            "status"        => $xss->xss($_POST['status']),
                            "school"        =>$school_id,
                        ];
                        $database->update("typeroom",$insert,["id"=>$data['id']]);
                        $jatbi->logs('typeroom','edit',$insert);
                        echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
                    }
                } else {
                    $templates = $setting['site_backend'].'class-academic.tpl';
                }
            }
            else {
                header("HTTP/1.0 404 Not Found");
                die();
            }
        }
    }
    elseif($router['1']=='classroom_type-delete'){
        $jatbi->permission('classroom_type.delete');
        $ajax = 'true';
        if($router['2']){
            $datas = $database->select("typeroom","*",["id"=>explode(',', $xss->xss($router['2']))]);
            if(isset($_POST['submit'])){
                $jatbi->logs('typeroom','delete',$datas);
                $database->update("typeroom",["deleted" => 1,],["id"=>explode(',', $xss->xss($router['2']))]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            } else {
                $templates = $setting['site_backend'].'class-academic.tpl';
            }
        }
        else {
            header("HTTP/1.0 404 Not Found");
            die();
        }
    }
    elseif($router['1']=='classroom_type-status'){
        $jatbi->permission('classroom_type.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("typeroom", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if($data['status']==='A'){
                    $status = "D";
                } 
                elseif($data['status']==='D'){
                    $status = "A";
                }
                $database->update("typeroom",["status"=>$status],["id"=>$data['id']]);
                $jatbi->logs('typeroom','status',["data"=>$data,"status"=>$status]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-trang-thai'],'sound'=>$setting['site_sound']]);
            }
            else {
                echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-that-bai'],]);
            }
        }
    }
    elseif($router['1']=='classroom'){
        $jatbi->permission('classroom');
        $count = $database->count("classroom",[
            'AND' => [
                "deleted"       => 0,
            ]]
        );
        $pg = $_GET['pg'];
        if (!$pg) $pg = 1;
        $datas = $database->select("classroom", "*",[
            "AND" => [
                "OR"=>[
                  
                    'name[~]'    => ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),                  
                ],
                'typeroom[<>]'=> ($xss->xss($_GET['typeroom'])=='')?:[$xss->xss($_GET['typeroom']),$xss->xss($_GET['typeroom'])], 
                'areas[<>]'=> ($xss->xss($_GET['areas'])=='')?:[$xss->xss($_GET['areas']),$xss->xss($_GET['areas'])],
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
        $templates = $setting['site_backend'].'class-academic.tpl';
    }
    elseif($router['1']=='classroom-add'){
        $jatbi->permission('classroom.add');
        $ajax = 'true';
        if(isset($_POST['token'])){
            $handle = new Upload($_FILES['avatar']);
            if($_POST['token']!=$_SESSION['csrf']['token']){
                echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
            }
            elseif($_POST['name'] == "" || $_POST['typeroom'] == ""  || $_POST['areas'] == ""){
                echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
            }
            if ($handle->processed  && $_POST['name'] && $_POST['typeroom'] && $_POST['areas']) {
                $insert = [                  
                    "name"         => $xss->xss($_POST['name']), 
                    "typeroom"         => $xss->xss($_POST['typeroom']), 
                    "areas"         => $xss->xss($_POST['areas']),                                    
                    "status"        => $xss->xss($_POST['status']),
                    "school"        =>$school_id,
                ];
                $database->insert("classroom",$insert);
                $jatbi->logs('classroom','add',$insert);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            }
        } 
        else {
            $templates = $setting['site_backend'].'class-academic.tpl';
        }
    }
    elseif($router['1']=='classroom-edit'){
        $jatbi->permission('classroom.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("classroom", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if(isset($_POST['token'])){
                    $partten = "/^[A-Za-z0-9_\.]{".$setting['site_characters'].",32}$/";
                    
                    $handle = new Upload($_FILES['avatar']);
                    if($_POST['token']!=$_SESSION['csrf']['token']){
                        echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
                    }
                    elseif($_POST['name'] == "" || $_POST['typeroom'] == ""  || $_POST['areas'] == ""){
                        echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
                    }
                    if ($handle->processed  && $_POST['name'] && $_POST['typeroom'] && $_POST['areas']) {
                        $insert = [                  
                            "name"         => $xss->xss($_POST['name']), 
                            "typeroom"         => $xss->xss($_POST['typeroom']), 
                            "areas"         => $xss->xss($_POST['areas']),                                    
                            "status"        => $xss->xss($_POST['status']),
                            "school"        =>$school_id,
                        ];
                        $database->update("classroom",$insert,["id"=>$data['id']]);
                        $jatbi->logs('classroom','edit',$insert);
                        echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
                    }
                } else {
                    $templates = $setting['site_backend'].'class-academic.tpl';
                }
            }
            else {
                header("HTTP/1.0 404 Not Found");
                die();
            }
        }
    }
    elseif($router['1']=='classroom-delete'){
        $jatbi->permission('classroom.delete');
        $ajax = 'true';
        if($router['2']){
            $datas = $database->select("classroom","*",["id"=>explode(',', $xss->xss($router['2']))]);
            if(isset($_POST['submit'])){
                $jatbi->logs('classroom','delete',$datas);
                $database->update("classroom",["deleted" => 1,],["id"=>explode(',', $xss->xss($router['2']))]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            } else {
                $templates = $setting['site_backend'].'class-academic.tpl';
            }
        }
        else {
            header("HTTP/1.0 404 Not Found");
            die();
        }
    }
    elseif($router['1']=='classroom-status'){
        $jatbi->permission('classroom.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("classroom", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if($data['status']==='A'){
                    $status = "D";
                } 
                elseif($data['status']==='D'){
                    $status = "A";
                }
                $database->update("classroom",["status"=>$status],["id"=>$data['id']]);
                $jatbi->logs('classroom','status',["data"=>$data,"status"=>$status]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-trang-thai'],'sound'=>$setting['site_sound']]);
            }
            else {
                echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-that-bai'],]);
            }
        }
    }
    elseif($router['1']=='class'){
        $jatbi->permission('class');
        $count = $database->count("class",[
            'AND' => [
                "deleted"       => 0,
                "school"        =>$school_id,
            ]]
        );
        $pg = $_GET['pg'];
        if (!$pg) $pg = 1;
        $datas = $database->select("class", "*",[
            "AND" => [
                "OR"=>[
                    
                    'name[~]'    => ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
                               
                ],
            
                'grade[<>]'=> ($xss->xss($_GET['grade'])=='')?:[$xss->xss($_GET['grade']),$xss->xss($_GET['grade'])],
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
        $templates = $setting['site_backend'].'class-academic.tpl';
    }
    elseif($router['1']=='class-add'){
        $jatbi->permission('class.add');
        $ajax = 'true';
        if(isset($_POST['token'])){
            if($_POST['token']!=$_SESSION['csrf']['token']){
                echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
            }
            elseif($_POST['name'] == ""){
                echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
            }
            if ($_POST['name']) {
                $insert = [                  
                    "name"         => $xss->xss($_POST['name']), 
                   
                    "status"        => $xss->xss($_POST['status']),
                    "school"        =>$school_id,
                ];
                $database->insert("class",$insert);
                $jatbi->logs('class','add',$insert);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            }
        } 
        else {
            $templates = $setting['site_backend'].'class-academic.tpl';
        }
    }
    elseif($router['1']=='class-edit'){
        $jatbi->permission('class.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("class", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if(isset($_POST['token'])){
                    $partten = "/^[A-Za-z0-9_\.]{".$setting['site_characters'].",32}$/";
                    
                    $handle = new Upload($_FILES['avatar']);
                    if($_POST['token']!=$_SESSION['csrf']['token']){
                        echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
                    }
                    elseif($_POST['name'] == ""){
                        echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
                    }
                    if ($_POST['name']) {
                        $insert = [                  
                            "name"         => $xss->xss($_POST['name']), 
                           
                            "status"        => $xss->xss($_POST['status']),
                            "school"        =>$school_id,
                        ];
                        $database->update("class",$insert,["id"=>$data['id']]);
                        $jatbi->logs('class','edit',$insert);
                        echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
                    }
                } else {
                    $templates = $setting['site_backend'].'class-academic.tpl';
                }
            }
            else {
                header("HTTP/1.0 404 Not Found");
                die();
            }
        }
    }
    elseif($router['1']=='class-delete'){
        $jatbi->permission('class.delete');
        $ajax = 'true';
        if($router['2']){
            $datas = $database->select("class","*",["id"=>explode(',', $xss->xss($router['2']))]);
            if(isset($_POST['submit'])){
                $jatbi->logs('class','delete',$datas);
                $database->update("class",["deleted" => 1,],["id"=>explode(',', $xss->xss($router['2']))]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            } else {
                $templates = $setting['site_backend'].'class-academic.tpl';
            }
        }
        else {
            header("HTTP/1.0 404 Not Found");
            die();
        }
    }
    elseif($router['1']=='class-status'){
        $jatbi->permission('class.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("class", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if($data['status']==='A'){
                    $status = "D";
                } 
                elseif($data['status']==='D'){
                    $status = "A";
                }
                $database->update("class",["status"=>$status],["id"=>$data['id']]);
                $jatbi->logs('class','status',["data"=>$data,"status"=>$status]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-trang-thai'],'sound'=>$setting['site_sound']]);
            }
            else {
                echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-that-bai'],]);
            }
        }
    }
    elseif($router['1']=='subject'){
        $jatbi->permission('subject');
        $count = $database->count("subject",[
            'AND' => [
                "deleted"       => 0,
            ]]
        );
        $pg = $_GET['pg'];
        if (!$pg) $pg = 1;
        $datas = $database->select("subject", "*",[
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
        $templates = $setting['site_backend'].'class-academic.tpl';
    }
    elseif($router['1']=='subject-add'){
        $jatbi->permission('subject.add');
        $ajax = 'true';
        if(isset($_POST['token'])){
            $handle = new Upload($_FILES['avatar']);
            if($_POST['token']!=$_SESSION['csrf']['token']){
                echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
            }
            elseif($_POST['name'] == "" ){
                echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
            }
            if ($handle->processed  && $_POST['name']) {
                $insert = [                  
                    "name"         => $xss->xss($_POST['name']),                                  
                    "status"        => $xss->xss($_POST['status']),
                    "school"        =>$school_id, 
                ];
                $database->insert("subject",$insert);
                $jatbi->logs('subject','add',$insert);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            }
        } 
        else {
            $templates = $setting['site_backend'].'class-academic.tpl';
        }
    }
    elseif($router['1']=='subject-edit'){
        $jatbi->permission('subject.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("subject", "*",["id"=>$xss->xss($router['2'])]);
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
                            "name"         => $xss->xss($_POST['name']),                                  
                            "status"        => $xss->xss($_POST['status']),
                            "school"        =>$school_id, 
                        ];
                        $database->update("subject",$insert,["id"=>$data['id']]);
                        $jatbi->logs('subject','edit',$insert);
                        echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
                    }
                } else {
                    $templates = $setting['site_backend'].'class-academic.tpl';
                }
            }
            else {
                header("HTTP/1.0 404 Not Found");
                die();
            }
        }
    }
    elseif($router['1']=='subject-delete'){
        $jatbi->permission('subject.delete');
        $ajax = 'true';
        if($router['2']){
            $datas = $database->select("subject","*",["id"=>explode(',', $xss->xss($router['2']))]);
            if(isset($_POST['submit'])){
                $jatbi->logs('subject','delete',$datas);
                $database->update("subject",["deleted" => 1,],["id"=>explode(',', $xss->xss($router['2']))]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            } else {
                $templates = $setting['site_backend'].'class-academic.tpl';
            }
        }
        else {
            header("HTTP/1.0 404 Not Found");
            die();
        }
    }
    elseif($router['1']=='subject-status'){
        $jatbi->permission('subject.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("subject", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if($data['status']==='A'){
                    $status = "D";
                } 
                elseif($data['status']==='D'){
                    $status = "A";
                }
                $database->update("subject",["status"=>$status],["id"=>$data['id']]);
                $jatbi->logs('subject','status',["data"=>$data,"status"=>$status]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-trang-thai'],'sound'=>$setting['site_sound']]);
            }
            else {
                echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-that-bai'],]);
            }
        }
    }
    elseif($router['1']=='schedule'){
        $jatbi->permission('schedule');
        $count = $database->count("schedule",[
            'AND' => [
                "deleted"       => 0,
            ]]
        );
        $pg = $_GET['pg'];
        if (!$pg) $pg = 1;
        $datas = $database->select("schedule", "*",[
            "AND" => [
                "OR"=>[
                  
                    'name[~]'       => ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
                    'date_start[~]'    => ($xss->xss($_GET['date_start'])=='')?'%':$xss->xss($_GET['date_start']),
                    'date_end[~]'    => ($xss->xss($_GET['date_end'])=='')?'%':$xss->xss($_GET['date_end']),                                                         
                ],
                
                'semester[<>]'=> ($xss->xss($_GET['semester'])=='')?:[$xss->xss($_GET['semester']),$xss->xss($_GET['semester'])],  
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
        $templates = $setting['site_backend'].'class-academic.tpl';
    }
    elseif($router['1']=='schedule-add'){
        $jatbi->permission('schedule.add');
        $ajax = 'true';
        if(isset($_POST['token'])){
            $handle = new Upload($_FILES['avatar']);
            if($_POST['token']!=$_SESSION['csrf']['token']){
                echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
            }
            elseif($_POST['date_start'] == "" || $_POST['date_end'] == "" || $_POST['class_diagram'] == "" || $_POST['name'] == ""){
                echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
            }
            if ($handle->processed  && $_POST['date_start'] && $_POST['date_end'] && $_POST['class_diagram'] && $_POST['name']) {
                $insert = [                  
                    
                    "date_start"      => date('Y-m-d',strtotime(str_replace('/','-',$_POST['date_start']))),
                    "date_end"      => date('Y-m-d',strtotime(str_replace('/','-',$_POST['date_end']))),
                    "class_diagram"         => $xss->xss($_POST['class_diagram']),
                    "name"         => $xss->xss($_POST['name']),
                    "school"=>$school_id,
                    "status"        => $xss->xss($_POST['status']),
                ];
                $database->insert("schedule",$insert);
                $jatbi->logs('schedule','add',$insert);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            }
        } 
        else {
            $templates = $setting['site_backend'].'class-academic.tpl';
        }
    }
    elseif($router['1']=='schedule-edit'){
        $jatbi->permission('schedule.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("schedule", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if(isset($_POST['token'])){
                    $partten = "/^[A-Za-z0-9_\.]{".$setting['site_characters'].",32}$/";
                    
                    $handle = new Upload($_FILES['avatar']);
                    if($_POST['token']!=$_SESSION['csrf']['token']){
                        echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
                    }
                    elseif($_POST['date_start'] == "" || $_POST['date_end'] == "" || $_POST['class_diagram'] == "" || $_POST['name'] == ""){
                        echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
                    }
                    if ($handle->processed  && $_POST['date_start'] && $_POST['date_end'] && $_POST['class_diagram'] && $_POST['name']) {
                        $insert = [                  
                            
                            "date_start"      => date('Y-m-d',strtotime(str_replace('/','-',$_POST['date_start']))),
                            "date_end"      => date('Y-m-d',strtotime(str_replace('/','-',$_POST['date_end']))),
                            "class_diagram"         => $xss->xss($_POST['class_diagram']),
                            "name"         => $xss->xss($_POST['name']),
                            "school"=>$school_id,
                            "status"        => $xss->xss($_POST['status']),
                        ];
                        $database->update("schedule",$insert,["id"=>$data['id']]);
                        $jatbi->logs('schedule','edit',$insert);
                        echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
                    }
                } else {
                    $templates = $setting['site_backend'].'class-academic.tpl';
                }
            }
            else {
                header("HTTP/1.0 404 Not Found");
                die();
            }
        }
    }
    elseif($router['1']=='schedule-delete'){
        $jatbi->permission('schedule.delete');
        $ajax = 'true';
        if($router['2']){
            $datas = $database->select("schedule","*",["id"=>explode(',', $xss->xss($router['2']))]);
            if(isset($_POST['submit'])){
                $jatbi->logs('schedule','delete',$datas);
                $database->update("schedule",["deleted" => 1,],["id"=>explode(',', $xss->xss($router['2']))]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            } else {
                $templates = $setting['site_backend'].'class-academic.tpl';
            }
        }
        else {
            header("HTTP/1.0 404 Not Found");
            die();
        }
    }
    elseif($router['1']=='schedule-status'){
        $jatbi->permission('schedule.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("schedule", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if($data['status']==='A'){
                    $status = "D";
                } 
                elseif($data['status']==='D'){
                    $status = "A";
                }
                $database->update("schedule",["status"=>$status],["id"=>$data['id']]);
                $jatbi->logs('schedule','status',["data"=>$data,"status"=>$status]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-trang-thai'],'sound'=>$setting['site_sound']]);
            }
            else {
                echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-that-bai'],]);
            }
        }
    }
    elseif($router['1']=='schedule-detail'){
        if ($router['2']) {
            $_SESSION['router2']=$router['2'];
            $schedule=$database->get("schedule","*",["school"=>$school_id,'id'=>$_SESSION['router2']]);
            $count = $database->count(
                "schedule_detail",
                [
                    'AND' => [
                        "schedule"=>$xss->xss($router['2']),
                        "deleted" => 0,     
                        "school"=>$school_id,                             
                    ]
                ]
            );
            $pg = $_GET['pg'];
            if (!$pg)
                $pg = 1;
            $datas = $database->select("schedule_detail", "*", [
                "AND" => [
                    "OR" => [
                       
                       
                        'lesson[~]' => ($xss->xss($_GET['lesson']) == '') ? '%' : $xss->xss($_GET['lesson']),

                        
                    ],
                    'day[<>]' => ($xss->xss($_GET['day']) == '') ?: [$xss->xss($_GET['day']), $xss->xss($_GET['day'])],
                    'subject[<>]' => ($xss->xss($_GET['subject']) == '') ?: [$xss->xss($_GET['subject']), $xss->xss($_GET['subject'])],
                    'classroom[<>]' => ($xss->xss($_GET['classroom']) == '') ?: [$xss->xss($_GET['classroom']), $xss->xss($_GET['classroom'])],
                    'status' => ($xss->xss($_GET['status']) == '') ? [A, D] : $xss->xss($_GET['status']),
                    "deleted" => 0,
                    "schedule"=>$xss->xss($router['2']),
                    "school"=>$school_id,
                ],
                "LIMIT" => [(($pg - 1) * $setting['site_page']), $setting['site_page']],
                "ORDER" => [
                    "id" => "DESC",
                ]
            ]);
            $page = $jatbi->pages($count, $setting['site_page'], $pg);
            $templates = $setting['site_backend'] . 'class-academic.tpl';

        }
        
    }
    elseif($router['1']=='schedule_detail-add'){
        $schedule=$database->get("schedule","*",["school"=>$school_id,'id'=>$_SESSION['router2']]);
        $ajax = 'true';
        if(isset($_POST['token'])){
            $handle = new Upload($_FILES['avatar']);
            if($_POST['token']!=$_SESSION['csrf']['token']){
                echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
            }
            elseif($_POST['schedule'] == "" || $_POST['day'] == "" || $_POST['lesson'] == "" || $_POST['subject'] == ""){
                echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
            }
            if ($handle->processed  && $_POST['day'] && $_POST['lesson'] && $_POST['subject']) {
                $insert = [                  
                    
                    "schedule"      => $xss->xss($_POST['schedule']), 
                    "day"         => $xss->xss($_POST['day']),                
                    "lesson"         => $xss->xss($_POST['lesson']),
                    
                    "subject"         => $xss->xss($_POST['subject']),
                    "classroom"         => $xss->xss($_POST['classroom']),
                    "school"=>$school_id,
                    "status"        => $xss->xss($_POST['status']),
                ];
                $database->insert("schedule_detail",$insert);
                $jatbi->logs('schedule_detail','add',$insert);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            }
        } 
        else {
            $templates = $setting['site_backend'].'class-academic.tpl';
        }
    }
    elseif($router['1']=='schedule_detail-edit'){
        $ajax = 'true';
        $schedule=$database->get("schedule","*",["school"=>$school_id,'id'=>$_SESSION['router2']]);
        if($router['2']){
            $data = $database->get("schedule_detail", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if(isset($_POST['token'])){
                    $partten = "/^[A-Za-z0-9_\.]{".$setting['site_characters'].",32}$/";
                    
                    $handle = new Upload($_FILES['avatar']);
                    if($_POST['token']!=$_SESSION['csrf']['token']){
                        echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
                    }
                    elseif( $_POST['day'] == "" || $_POST['lesson'] == "" || $_POST['subject'] == ""){
                        echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
                    }
                    if ($handle->processed  && $_POST['day'] && $_POST['lesson'] && $_POST['subject']) {
                        $insert = [                  
                            
                            "schedule"      => $xss->xss($_POST['schedule']), 
                            "day"         => $xss->xss($_POST['day']),                
                            "lesson"         => $xss->xss($_POST['lesson']),
                            "subject"         => $xss->xss($_POST['subject']),
                            "classroom"         => $xss->xss($_POST['classroom']),
                            "school"=>$school_id,
                            "status"        => $xss->xss($_POST['status']),
                        ];
                        $database->update("schedule_detail",$insert,["id"=>$data['id']]);
                        $jatbi->logs('schedule_detail','edit',$insert);
                        echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
                    }
                } else {
                    $templates = $setting['site_backend'].'class-academic.tpl';
                }
            }
            else {
                header("HTTP/1.0 404 Not Found");
                die();
            }
        }
    }
    elseif($router['1']=='schedule_detail-delete'){
        $ajax = 'true';
        if($router['2']){
            $datas = $database->select("schedule_detail","*",["id"=>explode(',', $xss->xss($router['2']))]);
            if(isset($_POST['submit'])){
                $jatbi->logs('schedule_detail','delete',$datas);
                $database->update("schedule_detail",["deleted" => 1,],["id"=>explode(',', $xss->xss($router['2']))]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            } else {
                $templates = $setting['site_backend'].'class-academic.tpl';
            }
        }
        else {
            header("HTTP/1.0 404 Not Found");
            die();
        }
    }
    elseif($router['1']=='schedule_detail-status'){
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("schedule_detail", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if($data['status']==='A'){
                    $status = "D";
                } 
                elseif($data['status']==='D'){
                    $status = "A";
                }
                $database->update("schedule_detail",["status"=>$status],["id"=>$data['id']]);
                $jatbi->logs('schedule_detail','status',["data"=>$data,"status"=>$status]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-trang-thai'],'sound'=>$setting['site_sound']]);
            }
            else {
                echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-that-bai'],]);
            }
        }
    }
    elseif($router['1']=='departments'){
        $jatbi->permission('departments');
        $count = $database->count("department",[
            'AND' => [
                "deleted"       => 0,
            ]]
        );
        $pg = $_GET['pg'];
        if (!$pg) $pg = 1;
        $datas = $database->select("department", "*",[
            "AND" => [
                "OR"=>[
                    
                    'name[~]'    => ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
                 
                ],
               
                'areas[<>]'=> ($xss->xss($_GET['areas'])=='')?:[$xss->xss($_GET['areas']),$xss->xss($_GET['areas'])], 
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
        $templates = $setting['site_backend'].'class-academic.tpl';
    }
    elseif($router['1']=='departments-add'){
        $jatbi->permission('departments.add');
        $ajax = 'true';
        if(isset($_POST['token'])){
            $handle = new Upload($_FILES['avatar']);
            if($_POST['token']!=$_SESSION['csrf']['token']){
                echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
            }
            elseif($_POST['name'] == "" || $_POST['areas'] == "" ){
                echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
            }
            if ($handle->processed  && $_POST['name'] &&  $_POST['areas']) {
                $insert = [                  
                    "name"         => $xss->xss($_POST['name']),
                    "areas"         => $xss->xss($_POST['areas']),   
                    "school"    =>$school_id,                                  
                    "status"        => $xss->xss($_POST['status']),
                ];
                $database->insert("department",$insert);
                $jatbi->logs('department','add',$insert);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            }
        } 
        else {
            $templates = $setting['site_backend'].'class-academic.tpl';
        }
    }
    elseif($router['1']=='departments-edit'){
        $jatbi->permission('departments.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("department", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if(isset($_POST['token'])){
                    $partten = "/^[A-Za-z0-9_\.]{".$setting['site_characters'].",32}$/";
                    
                    $handle = new Upload($_FILES['avatar']);
                    if($_POST['token']!=$_SESSION['csrf']['token']){
                        echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
                    }
                    elseif($_POST['name'] == "" || $_POST['areas'] == "" ){
                        echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
                    }
                    if ($handle->processed  && $_POST['name'] &&  $_POST['areas']) {
                        $insert = [                  
                            "name"         => $xss->xss($_POST['name']),
                            "areas"         => $xss->xss($_POST['areas']),      
                            "school"    =>$school_id,                               
                            "status"        => $xss->xss($_POST['status']),
                        ];
                        $database->update("department",$insert,["id"=>$data['id']]);
                        $jatbi->logs('department','edit',$insert);
                        echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
                    }
                } else {
                    $templates = $setting['site_backend'].'class-academic.tpl';
                }
            }
            else {
                header("HTTP/1.0 404 Not Found");
                die();
            }
        }
    }
    elseif($router['1']=='departments-delete'){
        $jatbi->permission('departments.delete');
        $ajax = 'true';
        if($router['2']){
            $datas = $database->select("department","*",["id"=>explode(',', $xss->xss($router['2']))]);
            if(isset($_POST['submit'])){
                $jatbi->logs('department','delete',$datas);
                $database->update("department",["deleted" => 1,],["id"=>explode(',', $xss->xss($router['2']))]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            } else {
                $templates = $setting['site_backend'].'class-academic.tpl';
            }
        }
        else {
            header("HTTP/1.0 404 Not Found");
            die();
        }
    }
    elseif($router['1']=='departments-status'){
        $jatbi->permission('departments.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("department", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if($data['status']==='A'){
                    $status = "D";
                } 
                elseif($data['status']==='D'){
                    $status = "A";
                }
                $database->update("department",["status"=>$status],["id"=>$data['id']]);
                $jatbi->logs('department','status',["data"=>$data,"status"=>$status]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-trang-thai'],'sound'=>$setting['site_sound']]);
            }
            else {
                echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-that-bai'],]);
            }
        }
    } 
    elseif ($router['1'] =='first_book-class') {
        $jatbi->permission('first_book-class');
        $count = $database->count("class_diagram",
            [
                'AND' => [
                    "deleted" => 0,
                    "status" =>"A",
                    "school"=>$school_id
                ]
            ]
        );
        $pg = $_GET['pg'];
        if (!$pg)
            $pg = 1;
        $datas = $database->select("class_diagram", "*", [
            "AND" => [
                "OR" => [
                    'id[~]' => ($xss->xss($_GET['id']) == '') ? '%' : $xss->xss($_GET['id']),

                ],
                'status' => ($xss->xss($_GET['status']) == '') ? [A, D] : $xss->xss($_GET['status']),
                "deleted" => 0,
                "school"=>$school_id
            ],
            "LIMIT" => [(($pg - 1) * $setting['site_page']), $setting['site_page']],
            "ORDER" => [
                "id" => "DESC",
            ]
        ]);
        $page = $jatbi->pages($count, $setting['site_page'], $pg);
        $templates = $setting['site_backend'] . 'class-academic.tpl';
    }   
    elseif($router['1']=='first_book'){
        if ($router['2']) {
            $count = $database->count(
                "first_book",
                [
                    'AND' => [
                        "class_diagram"=>$xss->xss($router['2']),
                        "deleted" => 0,                                  
                    ]
                ]
            );
            $pg = $_GET['pg'];
            if (!$pg)
                $pg = 1;
            $datas = $database->select("first_book", "*", [
                "AND" => [
                    "OR" => [
                        'date[~]' => ($xss->xss($_GET['date']) == '') ? '%' : $xss->xss($_GET['date']),
                        'title[~]' => ($xss->xss($_GET['title']) == '') ? '%' : $xss->xss($_GET['title']),
                        'content[~]' => ($xss->xss($_GET['content']) == '') ? '%' : $xss->xss($_GET['content']),
                        'comment[~]' => ($xss->xss($_GET['comment']) == '') ? '%' : $xss->xss($_GET['comment']),
                        'evaluate[~]' => ($xss->xss($_GET['evaluate']) == '') ? '%' : $xss->xss($_GET['evaluate']),
                    ],
                    'lesson[<>]' => ($xss->xss($_GET['lesson']) == '') ?: [$xss->xss($_GET['lesson']), $xss->xss($_GET['lesson'])],
                    'subject[<>]' => ($xss->xss($_GET['subject']) == '') ?: [$xss->xss($_GET['subject']), $xss->xss($_GET['subject'])],
                    'teacher[<>]' => ($xss->xss($_GET['teacher']) == '') ?: [$xss->xss($_GET['teacher']), $xss->xss($_GET['teacher'])],
                    'status' => ($xss->xss($_GET['status']) == '') ? [A, D] : $xss->xss($_GET['status']),
                    "deleted" => 0,
                    "class_diagram"=>$xss->xss($router['2']),
                    "school"=>$school_id
                ],
                "LIMIT" => [(($pg - 1) * $setting['site_page']), $setting['site_page']],
                "ORDER" => [
                    "id" => "DESC",
                ]
            ]);
            $page = $jatbi->pages($count, $setting['site_page'], $pg);
            $templates = $setting['site_backend'] . 'class-academic.tpl';

        }
        
    }
    elseif($router['1']=='first_book-edit'){
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("first_book", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if(isset($_POST['token'])){
                    $partten = "/^[A-Za-z0-9_\.]{".$setting['site_characters'].",32}$/";
                    
                    $handle = new Upload($_FILES['avatar']);
                    if($_POST['token']!=$_SESSION['csrf']['token']){
                        echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
                    }
                    if ($handle->processed  && $_POST['subject']) {
                        $insert = [                  
                            "subject"         => $xss->xss($_POST['subject']), 
                            "title"         => $xss->xss($_POST['title']), 
                            "content"         => $xss->xss($_POST['content']),  
                            "comment"         => $xss->xss($_POST['comment']),  
                            "evaluate"         => $xss->xss($_POST['evaluate']),
                            "date"         => date('Y-m-d H:i:s'),
                            "teacher"         => $xss->xss($_POST['teacher']), 
                            "school"=>$school_id,
                            "status"        => $xss->xss($_POST['status']),
                        ];
                        $database->update("first_book",$insert,["id"=>$data['id']]);
                        $jatbi->logs('first_book','edit',$insert);
                        echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
                    }
                } else {
                    $templates = $setting['site_backend'].'class-academic.tpl';
                }
            }
            else {
                header("HTTP/1.0 404 Not Found");
                die();
            }
        }
    }
    elseif($router['1']=='assigning_teachers'){
        $jatbi->permission('assigning_teachers');
        $count = $database->count("assigning_teachers",[
            'AND' => [
                "deleted"       => 0,
            ]]
        );
        $pg = $_GET['pg'];
        if (!$pg) $pg = 1;
        $datas = $database->select("assigning_teachers", "*",[
            "AND" => [
                "OR"=>[
                    'id[~]'       => ($xss->xss($_GET['id'])=='')?'%':$xss->xss($_GET['id']),
                                  
                ],
            
                'teacher[<>]'=> ($xss->xss($_GET['teacher'])=='')?:[$xss->xss($_GET['teacher']),$xss->xss($_GET['teacher'])],
                'subject[<>]'=> ($xss->xss($_GET['subject'])=='')?:[$xss->xss($_GET['subject']),$xss->xss($_GET['subject'])],
                
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
        $templates = $setting['site_backend'].'class-academic.tpl';
    }
    elseif($router['1']=='assigning_teachers-add'){
        $jatbi->permission('assigning_teachers.add');
        $ajax = 'true';
        if(isset($_POST['token'])){
         
            if($_POST['token']!=$_SESSION['csrf']['token']){
                echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
            }
            elseif($_POST['teacher'] == "" || $_POST['class_diagram'] == ""|| $_POST['semester'] == ""   ){
                echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
            }
            if ($_POST['teacher'] && $_POST['class_diagram'] && $_POST['semester']) {
                $insert = [                  
                    "semester"   =>$xss->xss($_POST['semester']),
                    "teacher"         => $xss->xss($_POST['teacher']),                    
                    "class_diagram"         => $xss->xss($_POST['class_diagram']), 
                    "subject"         => $xss->xss($_POST['subject']),                                    
                    "status"        => $xss->xss($_POST['status']),
                    "school"=>$school_id,
                ];
                $database->insert("assigning_teachers",$insert);
                $jatbi->logs('assigning_teachers','add',$insert);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            }
        } 
        else {
            $templates = $setting['site_backend'].'class-academic.tpl';
        }
    }
    elseif($router['1']=='assigning_teachers-edit'){
        $jatbi->permission('assigning_teachers.edit');
        $ajax = 'true';
        
        if($router['2']){
            $data = $database->get("assigning_teachers", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if(isset($_POST['token'])){
                    $partten = "/^[A-Za-z0-9_\.]{".$setting['site_characters'].",32}$/";
                    
                    $handle = new Upload($_FILES['avatar']);
                    if($_POST['token']!=$_SESSION['csrf']['token']){
                        echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
                    }
                    elseif($_POST['teacher'] == "" || $_POST['class_diagram'] == ""|| $_POST['semester'] == ""   ){
                        echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
                    }
                    if ($_POST['teacher'] && $_POST['class_diagram'] && $_POST['semester']) {
                        $insert = [                  
                            "semester"   =>$xss->xss($_POST['semester']),
                            "teacher"         => $xss->xss($_POST['teacher']),                    
                            "class_diagram"         => $xss->xss($_POST['class_diagram']), 
                            "subject"         => $xss->xss($_POST['subject']),                                    
                            "status"        => $xss->xss($_POST['status']),
                            "school"=>$school_id,
                        ];
                        $database->update("assigning_teachers",$insert,["id"=>$data['id']]);
                        $jatbi->logs('assigning_teachers','edit',$insert);
                        echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
                    }
                } else {
                    $templates = $setting['site_backend'].'class-academic.tpl';
                }
            }
            else {
                header("HTTP/1.0 404 Not Found");
                die();
            }
        }
    }
    elseif($router['1']=='assigning_teachers-delete'){
        $jatbi->permission('assigning_teachers.delete');
        $ajax = 'true';
        if($router['2']){
            $datas = $database->select("assigning_teachers","*",["id"=>explode(',', $xss->xss($router['2']))]);
            if(isset($_POST['submit'])){
                $jatbi->logs('assigning_teachers','delete',$datas);
                $database->update("assigning_teachers",["deleted" => 1,],["id"=>explode(',', $xss->xss($router['2']))]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            } else {
                $templates = $setting['site_backend'].'class-academic.tpl';
            }
        }
        else {
            header("HTTP/1.0 404 Not Found");
            die();
        }
    }
    elseif($router['1']=='assigning_teachers-status'){
        $jatbi->permission('assigning_teachers.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("assigning_teachers", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if($data['status']==='A'){
                    $status = "D";
                } 
                elseif($data['status']==='D'){
                    $status = "A";
                }
                $database->update("assigning_teachers",["status"=>$status],["id"=>$data['id']]);
                $jatbi->logs('assigning_teachers','status',["data"=>$data,"status"=>$status]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-trang-thai'],'sound'=>$setting['site_sound']]);
            }
            else {
                echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-that-bai'],]);
            }
        }
    } 
    elseif($router['1']=='arrange_class'){
        $jatbi->permission('arrange_class');
        $count = $database->count("arrange_class",[
            'AND' => [
                'name[~]'  		=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']), 
                "deleted"       => 0,
                "school"    =>$school_id,
            ]]
        );
        $pg = $_GET['pg'];
        if (!$pg) $pg = 1;
        $datas = $database->select("arrange_class", "*",[
            "AND" => [
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
        $templates = $setting['site_backend'].'class-academic.tpl';
    }
    elseif($router['1']=='arrange_class-add'){
        $jatbi->permission('arrange_class.add');
        $ajax = 'true';
       
        if(isset($_POST['token'])){
            $handle = new Upload($_FILES['avatar']);
            if($_POST['token']!=$_SESSION['csrf']['token']){
                echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
            }
            elseif($_POST['students'] == "" || $_POST['class_diagram'] == ""){
                echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
            }
            if ( $_POST['students']&& $_POST['class_diagram']) {
                foreach($_POST['students'] as $student){
                    $insert = [                  
                        "students"      =>$student,                                  
                        "class_diagram" => $xss->xss($_POST['class_diagram']),
                        "note"          => $xss->xss($_POST['note']),
                        "date"          => date("y-m-d"),
                        "school"        =>$school_id,
                        "status"        => $xss->xss($_POST['status']),
                    ];
                    $database->insert("arrange_class",$insert);
                }
                
                $jatbi->logs('arrange_class','add',$insert);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            }
        } 
        else {
            $templates = $setting['site_backend'].'class-academic.tpl';
        }
    }
    elseif($router['1']=='arrange_class-edit'){
        $jatbi->permission('arrange_class.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("arrange_class", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if(isset($_POST['token'])){
                    $handle = new Upload($_FILES['avatar']);
                    if($_POST['token']!=$_SESSION['csrf']['token']){
                        echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
                    }
                    elseif($_POST['students'] == "" || $_POST['class_diagram'] == ""){
                        echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
                    }
                    if ( $_POST['students']&& $_POST['class_diagram']) {
                        foreach($_POST['students'] as $student){
                            $insert = [                  
                                "students"      =>$student,                                  
                                "class_diagram" => $xss->xss($_POST['class_diagram']),
                                "note"          => $xss->xss($_POST['note']),
                                "date"          => date("y-m-d"),
                                "school"        =>$school_id,
                                "status"        => $xss->xss($_POST['status']),
                            ];
                            $database->insert("arrange_class",$insert);
                        }
                        
                        $jatbi->logs('arrange_class','add',$insert);
                        echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
                    }
                }  else {
                    $templates = $setting['site_backend'].'class-academic.tpl';
                }
            }
            else {
                header("HTTP/1.0 404 Not Found");
                die();
            }
        }
    }
    elseif($router['1']=='arrange_class-delete'){
        $jatbi->permission('arrange_class.delete');
        $ajax = 'true';
        if($router['2']){
            $datas = $database->select("arrange_class","*",["id"=>explode(',', $xss->xss($router['2']))]);
            if(isset($_POST['submit'])){
                $jatbi->logs('arrange_class','delete',$datas);
                $database->update("arrange_class",["deleted" => 1,],["id"=>explode(',', $xss->xss($router['2']))]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            } else {
                $templates = $setting['site_backend'].'class-academic.tpl';
            }
        }
        else {
            header("HTTP/1.0 404 Not Found");
            die();
        }
    }
    elseif($router['1']=='arrange_class-status'){
        $jatbi->permission('arrange_class.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("arrange_class", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if($data['status']==='A'){
                    $status = "D";
                } 
                elseif($data['status']==='D'){
                    $status = "A";
                }
                $database->update("arrange_class",["status"=>$status],["id"=>$data['id']]);
                $jatbi->logs('arrange_class','status',["data"=>$data,"status"=>$status]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-trang-thai'],'sound'=>$setting['site_sound']]);
            }
            else {
                echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-that-bai'],]);
            }
        }
    }  
    elseif($router['1']=='change_class'){
        $jatbi->permission('change_class');
        $count = $database->count("arrange_class",[
            'AND' => [
                'name[~]'  		=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']), 
                "deleted"       => 0,
                "school"    =>$school_id,
            ]]
        );
        $pg = $_GET['pg'];
        if (!$pg) $pg = 1;
        $datas = $database->select("arrange_class", "*",[
            "AND" => [
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
        $templates = $setting['site_backend'].'class-academic.tpl';
    }
    elseif($router['1']=='change_class-edit'){
        $jatbi->permission('arrange_class.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("arrange_class", "*",["id"=>$xss->xss($router['2'])]);
            $class_diagrams=$database->select("class_diagram", "*",[
                "course"    =>$database->get("course","id",["id"=>$database->get('class_diagram','course',['id'=>$data['class_diagram']])]),
                "school"    =>$school_id,
                "deleted"   => 0,
                "status"    =>'A']);
            if($data>1){
                if(isset($_POST['token'])){
                    $handle = new Upload($_FILES['avatar']);
                    if($_POST['token']!=$_SESSION['csrf']['token']){
                        echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
                    }
                    elseif($_POST['students'] == "" || $_POST['class_diagram'] == ""){
                        echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
                    }
                    if ( $_POST['students']&& $_POST['class_diagram']) {
                        
                            $insert = [                  
                                "students"      =>$xss->xss($_POST['students']),                                  
                                "class_diagram" => $xss->xss($_POST['class_diagram']),
                                "note"          => $xss->xss($_POST['note']),
                                "date"          => date("y-m-d"),
                                "school"        =>$school_id,
                                "status"        => $xss->xss($_POST['status']),
                            ];
                            
                            $database->update("arrange_class",$insert,["id"=>$data['id']]);
                        
                        
                        $jatbi->logs('arrange_class','add',$insert);
                        echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
                    }
                }  else {
                    $templates = $setting['site_backend'].'class-academic.tpl';
                }
            }
            else {
                header("HTTP/1.0 404 Not Found");
                die();
            }
        }
    }
    elseif($router['1']=='up_class'){
        $jatbi->permission('up_class');
        $count = $database->count("arrange_class",[
            'AND' => [
                'name[~]'  		=> ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']), 
                "deleted"       => 0,
                "school"    =>$school_id,
            ]]
        );
        $pg = $_GET['pg'];
        if (!$pg) $pg = 1;
        $datas = $database->select("arrange_class", "*",[
            "AND" => [
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
        $templates = $setting['site_backend'].'class-academic.tpl';
    }
    elseif($router['1']=='up_class-add'){
        $jatbi->permission('up_class.add');
        $ajax = 'true';
        if($router['2']){
        $data = $database->get("arrange_class", "*",["id"=>$xss->xss($router['2'])]);
        $class_diagrams=$database->select("class_diagram", "*",[
            "course"    =>$database->get("course","id",["id"=>$database->get('class_diagram','course',['id'=>$data['class_diagram']])]),
            "school"    =>$school_id,
            "deleted"   => 0,
            "status"    =>'A']);
        if(isset($_POST['token'])){
            $handle = new Upload($_FILES['avatar']);
            if($_POST['token']!=$_SESSION['csrf']['token']){
                echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
            }
            elseif($_POST['students'] == "" || $_POST['class_diagram'] == ""){
                echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
            }
            if ( $_POST['students']&& $_POST['class_diagram']) {
               
                    $insert = [                  
                        "students"      =>$xss->xss($_POST['students']),                               
                        "class_diagram" => $xss->xss($_POST['class_diagram']),
                        "note"          => $xss->xss($_POST['note']),
                        "date"          => date("y-m-d"),
                        "school"        =>$school_id,
                        "status"        => $xss->xss($_POST['status']),
                    ];
                    $database->insert("arrange_class",$insert);
                
                
                $jatbi->logs('arrange_class','add',$insert);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            }
        } 
        else {
            $templates = $setting['site_backend'].'class-academic.tpl';
        }
    }
    }
    elseif($router['1']=='profiles'){
        $jatbi->permission('students'); 
        if($router['2']){
            $arrange_class=$database->get("arrange_class","*",["school"        =>$school_id,"id"=>$router['2']]);
            
            $datas = $database->get("students", "*",[
                "AND" => [
                    'status'        => ($xss->xss($_GET['status'])=='')?[A,D]:$xss->xss($_GET['status']), 
                    "deleted"       => 0,
                    "school"        =>$school_id,
                    "id"            =>$arrange_class['students'],
                ],
                "LIMIT" =>[(($pg-1)*$setting['site_page']),$setting['site_page']],
                "ORDER" => [
                    "id"=>"DESC",
                ]
            ]);
            $arrange_classs=$database->select("arrange_class","*",["school"        =>$school_id,"students"=>$arrange_class['students']]);
            $templates = $setting['site_backend'].'profiles.tpl';
        }
    }
    elseif($router['1']=='up_class_list-add'){
        $jatbi->permission('up_class.add');
        $ajax = 'true';
        if($router['2']){
            $data = $database->select("arrange_class", "*",[  "school"    =>$school_id,"class_diagram"=>$xss->xss($router['2'])]);
        $class_diagrams=$database->select("class_diagram", "*",[
            "course"    =>$database->get("course","id",["id"=>$database->get('class_diagram','course',['id'=>$data['class_diagram']])]),
            "school"    =>$school_id,
            "deleted"   => 0,
            "status"    =>'A']);
        if(isset($_POST['token'])){
            $handle = new Upload($_FILES['avatar']);
            if($_POST['token']!=$_SESSION['csrf']['token']){
                echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
            }
            elseif($_POST['students'] == "" || $_POST['class_diagram'] == ""){
                echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
            }
            if ( $_POST['students']&& $_POST['class_diagram']) {
               
                    $insert = [                  
                        "students"      =>$xss->xss($_POST['students']),                               
                        "class_diagram" => $xss->xss($_POST['class_diagram']),
                        "note"          => $xss->xss($_POST['note']),
                        "date"          => date("y-m-d"),
                        "school"        =>$school_id,
                        "status"        => $xss->xss($_POST['status']),
                    ];
                    $database->insert("arrange_class",$insert);
                
                
                $jatbi->logs('arrange_class','add',$insert);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            }
        } 
        else {
            $templates = $setting['site_backend'].'class-academic.tpl';
        }
    }
    }
    elseif($router['1']=='contact_book'){
        $jatbi->permission('students'); 
        if($router['2']){
            $arrange_class=$database->get("arrange_class","*",["school"        =>$school_id,"id"=>$router['2']]);
            $student=$database->get("students","*",["school"        =>$school_id,"id"=>$arrange_class['students']]);
            $class_diagram=$database->get("class_diagram","*",["school"        =>$school_id,"id"=>$arrange_class['class_diagram']]);
            $semester=$database->select("semester","*",["status"=>"A","school"        =>$school_id,"course"=>$class_diagram['course']]);
            
            
            $templates = $setting['site_backend'].'class-academic.tpl';
        }
    }
    elseif($router['1']=='schedule_view'){
        $jatbi->permission('students'); 
        if($router['2']){
            $schedule=$database->select("schedule", "*",["class_diagram"=>$router['2'],"school"=>$school_id,"deleted"=> 0,"status"=>'A']);
            $date = date("Y-m-d");
            $day=$database->select("day", "*",["deleted"=> 0,"status"=>'A']);
            foreach($schedule as $value){
                    $date_timestamp = strtotime($date);
                    $start_timestamp = strtotime($value['date_start']);
                    $end_timestamp = strtotime($value['date_end']);

                    if ($date_timestamp >= $start_timestamp && $date_timestamp <= $end_timestamp) {
                        $schedule_detail = $database->select("schedule_detail", "*", [
                            "AND" => [
                                "deleted" => 0,
                                "schedule"=>$value['id'],
                                "school" => $school_id,
                            ],
                        ]);
                    }
                }
            $templates = $setting['site_backend'].'class-academic.tpl';
        }
        
    }
    elseif($router['1']=='typescore'){
        $jatbi->permission('typescore');
        $count = $database->count("typescore",[
            'AND' => [
                "deleted"       => 0,
                "school"    =>$school_id,
            ]]
        );
        $pg = $_GET['pg'];
        if (!$pg) $pg = 1;
        $datas = $database->select("typescore", "*",[
            "AND" => [
                "OR"=>[
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
        $templates = $setting['site_backend'].'class-academic.tpl';
    }
    elseif($router['1']=='typescore-add'){
        $jatbi->permission('typescore.add');
        $ajax = 'true';
        if(isset($_POST['token'])){
           
            if($_POST['token']!=$_SESSION['csrf']['token']){
                echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
            }
            elseif($_POST['name'] == ""||$_POST['heso'] == "" ||$_POST['id_type_scores'] == ""){
                echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
            }
            if ( $_POST['name'] && $_POST['heso']&& $_POST['id_type_scores']) {
                $insert = [                  
                    "id_type_scores"          => $xss->xss($_POST['id_type_scores']),    
                    "name"          => $xss->xss($_POST['name']),    
                    "heso"          => $xss->xss($_POST['heso']),                                  
                    "status"        => $xss->xss($_POST['status']),
                    "school"        =>$school_id,
                ];
                $database->insert("typescore",$insert);
                $jatbi->logs('typescore','add',$insert);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            }
        } 
        else {
            $templates = $setting['site_backend'].'class-academic.tpl';
        }
    }
    elseif($router['1']=='typescore-edit'){
        $jatbi->permission('typescore.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("typescore", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if(isset($_POST['token'])){
                    $partten = "/^[A-Za-z0-9_\.]{".$setting['site_characters'].",32}$/";
                    
                    $handle = new Upload($_FILES['avatar']);
                    if($_POST['token']!=$_SESSION['csrf']['token']){
                        echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
                    }
                    elseif($_POST['name'] == ""||$_POST['heso'] == "" ||$_POST['id_type_scores'] == ""){
                        echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
                    }
                    if ( $_POST['name'] && $_POST['heso']&& $_POST['id_type_scores']) {
                        $insert = [                  
                            "id_type_scores"          => $xss->xss($_POST['id_type_scores']),    
                            "name"          => $xss->xss($_POST['name']),    
                            "heso"          => $xss->xss($_POST['heso']),                                  
                            "status"        => $xss->xss($_POST['status']),
                            "school"        =>$school_id,
                        ];
                        $database->update("typescore",$insert,["id"=>$data['id']]);
                        $jatbi->logs('typescore','edit',$insert);
                        echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
                    }
                } else {
                    $templates = $setting['site_backend'].'class-academic.tpl';
                }
            }
            else {
                header("HTTP/1.0 404 Not Found");
                die();
            }
        }
    }
    elseif($router['1']=='typescore-delete'){
        $jatbi->permission('typescore.delete');
        $ajax = 'true';
        if($router['2']){
            $datas = $database->select("typescore","*",["id"=>explode(',', $xss->xss($router['2']))]);
            if(isset($_POST['submit'])){
                $jatbi->logs('typescore','delete',$datas);
                $database->update("typescore",["deleted" => 1,],["id"=>explode(',', $xss->xss($router['2']))]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
            } else {
                $templates = $setting['site_backend'].'class-academic.tpl';
            }
        }
        else {
            header("HTTP/1.0 404 Not Found");
            die();
        }
    }
    elseif($router['1']=='typescore-status'){
        $jatbi->permission('typescore.edit');
        $ajax = 'true';
        if($router['2']){
            $data = $database->get("typescore", "*",["id"=>$xss->xss($router['2'])]);
            if($data>1){
                if($data['status']==='A'){
                    $status = "D";
                } 
                elseif($data['status']==='D'){
                    $status = "A";
                }
                $database->update("typescore",["status"=>$status],["id"=>$data['id']]);
                $jatbi->logs('typescore','status',["data"=>$data,"status"=>$status]);
                echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-trang-thai'],'sound'=>$setting['site_sound']]);
            }
            else {
                echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-that-bai'],]);
            }
        }
    }
?>