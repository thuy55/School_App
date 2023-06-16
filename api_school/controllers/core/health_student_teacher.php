<?php
if (!defined('JATBI')) die("Hacking attempt");
$school_id=$_SESSION['school'];
$students = $database->select("students", "*",["school"        =>$school_id,"deleted"=> 0,"status"=>'A']);
$school_teachers=$database->select("school_teacher","*",['school'=>$school_id['id'],"deleted"=> 0,"status"=>'A']);

if($router['1']=='health_teacher'){
    $jatbi->permission('health_teacher');
    $count = $database->count("health_teacher",[
        'AND' => [
            "deleted"       => 0,
        ]]
    );
    $pg = $_GET['pg'];
    if (!$pg) $pg = 1;
    $datas = $database->select("health_teacher", "*",[
        "AND" => [
            "OR"=>[
             
                'date[~]'    => ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']), 
                'heartbeat[~]'    => ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']), 
                'blood_pressure[~]'    => ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
                'temperature[~]'    => ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
                'weight[~]'    => ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
                'height[~]'    => ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
                'prehistoric[~]'    => ($xss->xss($_GET['prehistoric'])=='')?'%':$xss->xss($_GET['prehistoric']),                 
            ],
            'teacher[<>]'=> ($xss->xss($_GET['teacher'])=='')?:[$xss->xss($_GET['teacher']),$xss->xss($_GET['teacher'])],
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
    $templates = $setting['site_backend'].'health_student_teacher.tpl';
}
elseif($router['1']=='health_teacher-add'){
    $jatbi->permission('health_teacher.add');
    $ajax = 'true';
    if(isset($_POST['token'])){
        $handle = new Upload($_FILES['avatar']);
        if($_POST['token']!=$_SESSION['csrf']['token']){
            echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
        }
        elseif($_POST['heartbeat'] == "" || $_POST['blood_pressure'] == "" || $_POST['temperature'] == "" || $_POST['weight'] == "" || $_POST['height'] == "" || $_POST['teacher'] == "" || $_POST['date'] == ""){
            echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
        }
        
        if ($handle->processed  && $_POST['heartbeat'] && $_POST['blood_pressure'] && $_POST['temperature'] && $_POST['weight'] && $_POST['height'] && $_POST['teacher'] && $_POST['date']) {
            $insert = [  
                "date"      => date('Y-m-d',strtotime(str_replace('/','-',$_POST['date']))),                
                "heartbeat"         => $xss->xss($_POST['heartbeat']),
                "blood_pressure"         => $xss->xss($_POST['blood_pressure']),
                "temperature"         => $xss->xss($_POST['temperature']),
                "weight"         => $xss->xss($_POST['weight']),
                "height"         => $xss->xss($_POST['height']),
                "prehistoric"         => $xss->xss($_POST['prehistoric']),
                "teacher"         => $xss->xss($_POST['teacher']),
                "status"        => $xss->xss($_POST['status']),
                "school"        =>$school_id,
            ];
            $database->insert("health_teacher",$insert);
            $jatbi->logs('health_teacher','add',$insert);
            echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
        }
    } 
    else {
        $templates = $setting['site_backend'].'health_student_teacher.tpl';
    }
}
elseif($router['1']=='health_teacher-edit'){
    $jatbi->permission('health_teacher.edit');
    $ajax = 'true';
    if($router['2']){
        $data = $database->get("health_teacher", "*",["id"=>$xss->xss($router['2'])]);
        if($data>1){
            if(isset($_POST['token'])){
                $partten = "/^[A-Za-z0-9_\.]{".$setting['site_characters'].",32}$/";
                
                $handle = new Upload($_FILES['avatar']);
                if($_POST['token']!=$_SESSION['csrf']['token']){
                    echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
                }
                elseif($_POST['heartbeat'] == "" || $_POST['blood_pressure'] == "" || $_POST['temperature'] == "" || $_POST['weight'] == "" || $_POST['height'] == "" || $_POST['teacher'] == "" || $_POST['date'] == ""){
                    echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
                }
                
                if ($handle->processed  && $_POST['heartbeat'] && $_POST['blood_pressure'] && $_POST['temperature'] && $_POST['weight'] && $_POST['height'] && $_POST['teacher'] && $_POST['date']) {
                    $insert = [  
                        "date"      => date('Y-m-d',strtotime(str_replace('/','-',$_POST['date']))),                
                        "heartbeat"         => $xss->xss($_POST['heartbeat']),
                        "blood_pressure"         => $xss->xss($_POST['blood_pressure']),
                        "temperature"         => $xss->xss($_POST['temperature']),
                        "weight"         => $xss->xss($_POST['weight']),
                        "height"         => $xss->xss($_POST['height']),
                        "prehistoric"         => $xss->xss($_POST['prehistoric']),
                        "teacher"         => $xss->xss($_POST['teacher']),
                        "status"        => $xss->xss($_POST['status']),
                        "school"        =>$school_id,
                    ];
                    $database->update("health_teacher",$insert,["id"=>$data['id']]);
                    $jatbi->logs('health_teacher','edit',$insert);
                    echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
                }
            } else {
                $templates = $setting['site_backend'].'health_student_teacher.tpl';
            }
        }
        else {
            header("HTTP/1.0 404 Not Found");
            die();
        }
    }
}
elseif($router['1']=='health_teacher-delete'){
    $jatbi->permission('health_teacher.delete');
    $ajax = 'true';
    if($router['2']){
        $datas = $database->select("health_teacher","*",["id"=>explode(',', $xss->xss($router['2']))]);
        if(isset($_POST['submit'])){
            $jatbi->logs('health_teacher','delete',$datas);
            $database->update("health_teacher",["deleted" => 1,],["id"=>explode(',', $xss->xss($router['2']))]);
            echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
        } else {
            $templates = $setting['site_backend'].'health_student_teacher.tpl';
        }
    }
    else {
        header("HTTP/1.0 404 Not Found");
        die();
    }
}
elseif($router['1']=='health_teacher-status'){
    $jatbi->permission('health_teacher.edit');
    $ajax = 'true';
    if($router['2']){
        $data = $database->get("health_teacher", "*",["id"=>$xss->xss($router['2'])]);
        if($data>1){
            if($data['status']==='A'){
                $status = "D";
            } 
            elseif($data['status']==='D'){
                $status = "A";
            }
            $database->update("health_teacher",["status"=>$status],["id"=>$data['id']]);
            $jatbi->logs('health_teacher','status',["data"=>$data,"status"=>$status]);
            echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-trang-thai'],'sound'=>$setting['site_sound']]);
        }
        else {
            echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-that-bai'],]);
        }
    }
}
elseif($router['1']=='vaccination_teacher'){
    $jatbi->permission('vaccination_teacher');
    $count = $database->count("vaccination_teacher",[
        'AND' => [
            "deleted"       => 0,
        ]]
    );
    $pg = $_GET['pg'];
    if (!$pg) $pg = 1;
    $datas = $database->select("vaccination_teacher", "*",[
        "AND" => [
            "OR"=>[
              
                'name[~]'    => ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']), 
                'namevacxin[~]'    => ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']),
                'date[~]'    => ($xss->xss($_GET['name'])=='')?'%':$xss->xss($_GET['name']), 
                
                       
            ],
            'teacher[<>]'=> ($xss->xss($_GET['teacher'])=='')?:[$xss->xss($_GET['teacher']),$xss->xss($_GET['teacher'])],
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
    $templates = $setting['site_backend'].'health_student_teacher.tpl';
}
elseif($router['1']=='vaccination_teacher-add'){
    $jatbi->permission('vaccination_teacher.add');
    $ajax = 'true';
    if(isset($_POST['token'])){
        $handle = new Upload($_FILES['avatar']);
        if($_POST['token']!=$_SESSION['csrf']['token']){
            echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
        }
        elseif($_POST['name'] == "" || $_POST['namevacxin'] == ""  || $_POST['teacher'] == "" || $_POST['date'] == ""){
            echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
        }
        
        if ($handle->processed  && $_POST['name'] && $_POST['namevacxin'] && $_POST['teacher'] && $_POST['date']) {
            $insert = [  
                "date"      => date('Y-m-d',strtotime(str_replace('/','-',$_POST['date']))),                
                "name"         => $xss->xss($_POST['name']),
                "namevacxin"         => $xss->xss($_POST['namevacxin']),
                "teacher"         => $xss->xss($_POST['teacher']),
                "status"        => $xss->xss($_POST['status']),
                "school"        =>$school_id,
            ];
            $database->insert("vaccination_teacher",$insert);
            $jatbi->logs('vaccination_teacher','add',$insert);
            echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
        }
    } 
    else {
        $templates = $setting['site_backend'].'health_student_teacher.tpl';
    }
}
elseif($router['1']=='vaccination_teacher-edit'){
    $jatbi->permission('vaccination_teacher.edit');
    $ajax = 'true';
    if($router['2']){
        $data = $database->get("vaccination_teacher", "*",["id"=>$xss->xss($router['2'])]);
        if($data>1){
            if(isset($_POST['token'])){
                $partten = "/^[A-Za-z0-9_\.]{".$setting['site_characters'].",32}$/";
                
                $handle = new Upload($_FILES['avatar']);
                if($_POST['token']!=$_SESSION['csrf']['token']){
                    echo json_encode(['status'=>'error','content'=>$lang['token-khong-dung']]);
                }
                elseif($_POST['name'] == "" || $_POST['namevacxin'] == ""  || $_POST['teacher'] == "" || $_POST['date'] == ""){
                    echo json_encode(['status'=>'error','content'=>$lang['loi-trong'],'sound'=>$setting['site_sound']]);
                }
                
                if ($handle->processed  && $_POST['name'] && $_POST['namevacxin'] && $_POST['teacher'] && $_POST['date']) {
                    $insert = [  
                        "date"      => date('Y-m-d',strtotime(str_replace('/','-',$_POST['date']))),                
                        "name"         => $xss->xss($_POST['name']),
                        "namevacxin"         => $xss->xss($_POST['namevacxin']),   
                        "teacher"         => $xss->xss($_POST['teacher']),
                        "status"        => $xss->xss($_POST['status']),
                        "school"        =>$school_id,
                    ];
                    $database->update("vaccination_teacher",$insert,["id"=>$data['id']]);
                    $jatbi->logs('vaccination_teacher','edit',$insert);
                    echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
                }
            } else {
                $templates = $setting['site_backend'].'health_student_teacher.tpl';
            }
        }
        else {
            header("HTTP/1.0 404 Not Found");
            die();
        }
    }
}
elseif($router['1']=='vaccination_teacher-delete'){
    $jatbi->permission('vaccination_teacher.delete');
    $ajax = 'true';
    if($router['2']){
        $datas = $database->select("vaccination_teacher","*",["id"=>explode(',', $xss->xss($router['2']))]);
        if(isset($_POST['submit'])){
            $jatbi->logs('vaccination_teacher','delete',$datas);
            $database->update("vaccination_teacher",["deleted" => 1,],["id"=>explode(',', $xss->xss($router['2']))]);
            echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-thanh-cong'],"url"=>$_SERVER['HTTP_REFERER']]);
        } else {
            $templates = $setting['site_backend'].'health_student_teacher.tpl';
        }
    }
    else {
        header("HTTP/1.0 404 Not Found");
        die();
    }
}
elseif($router['1']=='vaccination_teacher-status'){
    $jatbi->permission('vaccination_teacher.edit');
    $ajax = 'true';
    if($router['2']){
        $data = $database->get("vaccination_teacher", "*",["id"=>$xss->xss($router['2'])]);
        if($data>1){
            if($data['status']==='A'){
                $status = "D";
            } 
            elseif($data['status']==='D'){
                $status = "A";
            }
            $database->update("vaccination_teacher",["status"=>$status],["id"=>$data['id']]);
            $jatbi->logs('vaccination_teacher','status',["data"=>$data,"status"=>$status]);
            echo json_encode(['status'=>'success','content'=>$lang['cap-nhat-trang-thai'],'sound'=>$setting['site_sound']]);
        }
        else {
            echo json_encode(['status'=>'error','content'=>$lang['cap-nhat-that-bai'],]);
        }
    }
}
?>