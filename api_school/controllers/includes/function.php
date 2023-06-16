<?php 
	if (!defined('JATBI')) die("Hacking attempt");
	class jatbi{
		public function permission($permission,$type=null){
			global $database,$account;
	        if($account['permission']==0 && $account['root']==1){
	           if($type=='button'){
	                if(isset($permission)){
	                    return 'true';
	                }
	            } 
	        }
	        else {
	            $group = unserialize($database->get("permission", 'group', ["AND"=>["deleted"=> 0,"id"=>$account['permission'],"status"=>'A']]));
	            if($type=='button'){
	                if($group[$permission]==$permission){
	                    return 'true';
	                }
	            } 
	            else {
	                if($group[$permission]!=$permission){
	                   header("HTTP/1.0 404 Not Found");
						die();
	                }
	            }
	        }
		}
		public function random($length){
			$random = bin2hex(random_bytes($length).time());
			return $random;
		}
		public function number_color($number) {
			if($number<0){
				$color = 'text-danger';
			}
			elseif($number==0){
				$color = 'text-dark';
			}
			else {
				$color = 'text-success';
			}
			return $color;
		}
		public function number_min_max($numberm,$min,$max) {
			if($number<$min){
				$color = 'text-primary';
			}
			elseif($number>$min && $number<$max){
				$color = 'text-success';
			}
			elseif($number>$min && $number>$max){
				$color = 'text-danger';
			}
			return $color;
		}
		public function cut_string($string,$len){
	        global $lang,$router,$database;
	        if (strlen($string) <=$len) { 
	            return $string; 
	        } else { 
	            return mb_substr($string, 0, $len, "utf-8") . '...'; 
	        } 
	    }
		public function cash_flow($status,$color=null) {
			global $lang,$router;
			if($color!=''){
			    switch($status){
			            case "0": $status = 'primary';break;
			            case "1": $status = 'success';break;
			            case "2": $status = 'danger';break;
			    }
				return $status;
			}
			else {
			    switch($status){
			            case "0": $status = $lang['ke-hoach'];break;
			            case "1": $status = $lang['da-thanh-toan'];break;
			            case "2": $status = $lang['khong-thanh-toan'];break;
			    }
				return $status;
			}
		   
		}
		public function colors($point){
			if($point<=75 && $point>50){
				$color = 'bg-warning';
			}
			elseif($point<=50){
				$color = 'bg-danger';
			}
			else {
				$color = 'bg-success';
			}
			return $color;
		}
		public function files_mine($GetID,$type=null){
			global $setting,$lang,$database,$upload;
			if($type==''){
				$datas = $database->get("datas","*",["id"=>$GetID]);
				$getuser = $database->get("accounts","active",["id"=>$datas['user']]);
				$files = $datas['name_ext'];
				$url = $setting['site_url'].$upload['images']['datas']['url'].$getuser.'/'.$datas['code'];
			}
			if($type=='social'){
				$datas = $database->get("social_data","*",["id"=>$GetID]);
				$files = $datas['name_ext'];
				$url = $setting['site_url'].$upload['images']['social']['url'].$datas['code'];
			}
			if($files=="pdf"){
				$data['icon'] = $setting['site_url'].$setting['site_backend']."assets/img/files/pdf.png";
				$data['url'] = $url;
				$data['modal'] = "max-width:90%";
				$data['file'] = $files;
				$data['views'] = "<iframe src='https://docs.google.com/viewer?url=".$url."&embedded=true' width='100%' style='height: calc(100vh - 100px);'' frameborder='0'></iframe>";
			}
			elseif($files=="doc"){
				$data['icon'] = $setting['site_url'].$setting['site_backend']."assets/img/files/doc.png";
				$data['url'] = $url;
				$data['modal'] = "max-width:90%";
				$data['file'] = $files;
				$data['views'] = "<iframe src='https://view.officeapps.live.com/op/embed.aspx?src=".$url."' width='100%' style='height: calc(100vh - 100px);'' frameborder='0'></iframe>";
			}
			elseif($files=="zip"){
				$data['icon'] = $setting['site_url'].$setting['site_backend']."assets/img/files/zip.png";
				$data['url'] = $url;
				$data['modal'] = "max-width:20%";
				$data['file'] = $files;
				$data['views'] = '<div class="text-center p-3">
					<span class="mb-2 d-block fw-bold fs-6">'.$lang['ten'].': '.$datas['name'].'</span>
					<span class="mb-2 d-block">'.$lang['dung-luong'].':'.number_format($datas['size']).'Kb</span>
					<a href="'.$url.'" class="btn btn-primary w-100 mt-3">'.$lang['tai-ve'].'</a>
				</div>';
			}
			elseif($files=="rar"){
				$data['icon'] = $setting['site_url'].$setting['site_backend']."assets/img/files/rar.png";
				$data['url'] = $url;
				$data['modal'] = "max-width:20%";
				$data['file'] = $files;
				$data['views'] = '<div class="text-center p-3">
					<span class="mb-2 d-block fw-bold fs-6">'.$lang['ten'].': '.$datas['name'].'</span>
					<span class="mb-2 d-block">'.$lang['dung-luong'].':'.number_format($datas['size']).'Kb</span>
					<a href="'.$url.'" class="btn btn-primary w-100 mt-3">'.$lang['tai-ve'].'</a>
				</div>';
			}
			elseif($files=="ppt"){
				$data['icon'] = $setting['site_url'].$setting['site_backend']."assets/img/files/ppt.png";
				$data['url'] = $url;
				$data['modal'] = "max-width:90%";
				$data['file'] = $files;
				$data['views'] = "<iframe src='https://view.officeapps.live.com/op/embed.aspx?src=".$url."' width='100%' style='height: calc(100vh - 100px);'' frameborder='0'></iframe>";
			}
			elseif($files=="xls" || $files=="xlsx"){
				$data['icon'] = $setting['site_url'].$setting['site_backend']."assets/img/files/xls.png";
				$data['url'] = $url;
				$data['modal'] = "max-width:90%";
				$data['file'] = $files;
				$data['views'] = "<iframe src='https://view.officeapps.live.com/op/embed.aspx?src=".$url."' width='100%' style='height: calc(100vh - 100px);'' frameborder='0'></iframe>";
			}
			elseif($files=="png" || $files=="jpg" || $files=="jpeg"  || $files=="jpe"  || $files=="gif"  || $files=="bmp"  || $files=="tiff"){
				$data['icon'] = $url;
				$data['url'] = $url;
				$data['modal'] = "max-width:50%";
				$data['file'] = $files;
				$data['views'] = "<img src='".$url."' class='w-100'>";
			}
			else {
				$data['icon'] = $setting['site_url'].$setting['site_backend']."assets/img/files/files.png";
				$data['url'] = $url;
				$data['modal'] = "max-width:20%";
				$data['file'] = $files;
				$data['views'] = '<div class="text-center p-3">
					<span class="mb-2 d-block fw-bold fs-6">'.$lang['ten'].': '.$datas['name'].'</span>
					<span class="mb-2 d-block">'.$lang['dung-luong'].':'.number_format($datas['size']).'Kb</span>
					<a href="'.$url.'" class="btn btn-primary w-100 mt-3">'.$lang['tai-ve'].'</a>
				</div>';
			}
			return $data;
		}
		public function formatBytes($size, $precision = 2){
		    $base = log($size, 1024);
		    $suffixes = array('', 'K', 'M', 'G', 'T');   
		    return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
		}
		public function logs($dispatch,$action,$content){
			global $database;
			$ip = $_SERVER['REMOTE_ADDR'];
		    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		        $ip = $_SERVER['HTTP_CLIENT_IP'];
		    } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		    }
			$database->insert("logs",[
				"user" 		=> $_SESSION['accounts']['id'],
				"dispatch" 	=> $dispatch,
				"action" 	=> $action,
				"date" 		=> date('Y-m-d H:i:s'),
				"url" 		=> 'http://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"],
				"ip" 		=> $ip,
				"browsers"	=> $_SERVER["HTTP_USER_AGENT"],
	            "content"   => $content,
				"branch"	=> $_SESSION['accounts']['branch'],
			]);
		}
	    public function week_day($datas){
	      global $lang,$router;
	      sort($datas);
	      $week = str_replace(['1','2','3','4','5','6','7'],[$lang['thu-hai'],$lang['thu-ba'],$lang['thu-tu'],$lang['thu-nam'],$lang['thu-sau'],$lang['thu-bay'],$lang['chu-nhat']],implode(', ', $datas));
	      if(implode('', $datas)=='1234567'){
	        return $lang['thu-hai'].' -> '.$lang['chu-nhat'];
	      }
	      elseif(implode('', $datas)=='123456') {
	        return $lang['thu-hai'].' -> '.$lang['thu-bay'];
	      }
	      elseif(implode('', $datas)=='12345') {
	        return $lang['thu-hai'].' -> '.$lang['thu-sau'];
	      }
	      elseif(implode('', $datas)=='1234') {
	        return $lang['thu-hai'].' -> '.$lang['thu-nam'];
	      }
	      elseif(implode('', $datas)=='123') {
	        return $lang['thu-hai'].' -> '.$lang['thu-tu'];
	      }
	      else {
	        return $week;
	      }
	    }
		public function accounts_logs($user,$data,$type=null,$content=null,$update=null){
	        global $database,$router;
	        $ip = $_SERVER['REMOTE_ADDR'];
	        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
	            $ip = $_SERVER['HTTP_CLIENT_IP'];
	        } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
	            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	        }
	        $Getlogs = $database->get("accounts_logs","*",["accounts"=>$user,"ORDER"=>["id"=>"DESC"]]);
	        $date = date("Y-m-d H:i:s");
	        $date1 = date("Y-m-d H:i:s",strtotime($Getlogs['date']));
	        $date2 = $date;
	        $diff = abs(strtotime($date2) - strtotime($date1));
	        if($Getlogs['time']=='0' || $Getlogs['time']==''){
	            $database->update("accounts_logs",["time"=>$diff],["id"=>$Getlogs['id']]);
	        }
	        if($update==''){
	            $insert = [
	                "accounts"  => $user,
	                "date"      => $date,
	                "type"      => $router['0'],
	                "action"    => $router['1'],
	                "data"    	=> $data,
	                "link"      => $_SERVER['REQUEST_URI'],
	                "time"      => '0',
	                "ip"        => $ip,
	                "browsers"  => $_SERVER["HTTP_USER_AGENT"],
	                "content"   => $content,
	            ];
	            $database->insert("accounts_logs",$insert);
	        }
	    }
		public function checkaccount($str) {
	        if(!$str) return false;
	        $utf8 = array(
	                'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ|Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
	                'd'=>'đ|Đ',
	                'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ|É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
	                'i'=>'í|ì|ỉ|ĩ|ị|Í|Ì|Ỉ|Ĩ|Ị',
	                'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ|Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
	                'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự|Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
	                'y'=>'ý|ỳ|ỷ|ỹ|ỵ|Ý|Ỳ|Ỷ|Ỹ|Ỵ',
	                );
	        foreach($utf8 as $ascii=>$uni) 
	        $str = preg_replace("/($uni)/i",$ascii,$str);
	        $str = htmlentities($str);
	        $str = strtolower($str);
	        $str = str_replace( "ß", "ss", $str);
	        $str = str_replace( "%", "", $str);
	        $str = preg_replace("/[^_a-zA-Z0-9 -]/", "",$str);
	        $str = str_replace(array('%20', ' '), '', $str);
	        $str = str_replace("----","",$str);
	        $str = str_replace("---","",$str);
	        $str = str_replace("--","",$str);
	        $str = str_replace("-","",$str);
	        $str = str_replace(" ","",$str);
	        $str = str_replace("+","",$str);
	        $str = str_replace("@","",$str);
	        $str = str_replace("^","",$str);
	        $str = str_replace("/","",$str);
	        $str = str_replace("\\","",$str);
	        $str = str_replace("~","",$str);
	        $str = str_replace("\"","",$str);
	        $str = str_replace("\'","",$str);
	        return $str;
	    }
	    public function active($length) {
			$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
			$size = strlen($chars);
			for( $i = 0; $i < $length; $i++ ) {
				$str .= $chars[rand(0, $size - 1) ];
			}
			return $str;
		}
		public function pages($count,$limit,$page,$name=null){
	        global $view,$lang,$router,$detect;
	        $total = ceil($count/$limit);
	        $name = $name==''?'pg':$name;
	        $return .= '<ul class="pagination">';
	        if($total>1){
	            $url = $_SERVER['REQUEST_URI'];
	            if($_SERVER['QUERY_STRING']==''){
	                $view = $url.'?';
	            } else {
	                $view = '?'.$_SERVER['QUERY_STRING'].'&';
	            }
	            $view = preg_replace("#(/?|&)".$name."=([0-9]{1,})#","",$view);
	            if($page!=1){
	            	$return .= '<li class="page-item"><a href="'.$view.$name.'=1" class="page-link pjax-content">&laquo;&laquo;</a></li>';
	                $return .= '<li class="page-item d-none d-md-block"><a href="'.$view.$name.'='.($page-1).'" class="page-link pjax-content">&laquo;</a></li>';
	            }
	            for ($number=1; $number<=$total; $number++) { 
	                if($page>2 && $number==1 || $page<$total-1 && $number==$total){
	                    $return .= '<li class="page-item d-none d-md-block"><a href="#" class="page-link page-link-hide">...</a><li>';
	                }
	                if($number<$page+2 && $number>$page-2){
	                    $return .= '<li class="page-item '.($page==$number?'active':'').'"><a href="'.$view.$name.'='.$number.'" class="page-link pjax-content">'.$number.'</a></li>';
	                }
	                $getnumber = $number;
	            }
	            if($page!=$total){
	                $return .= '<li class="page-item d-none d-md-block"><a href="'.$view.$name.'='.($page+1).'" class="page-link pjax-content">&raquo;</a></li>';
	                $return .= '<li class="page-item"><a href="'.$view.$name.'='.$total.'" class="page-link pjax-content">&raquo;&raquo;</a></li>';
	            }
	        }
	        $return .= '</ul>';
	        if($total==1){
	        	$getnumber = 1;
            	$getcount = $count;
	        }
            elseif($page==1) {
            	$getnumber = 1;
            	$getcount = $page*$limit;
            }
            elseif($page==$total){
            	$getnumber = $limit*($page-1)+1;
            	$getcount = $count;
            }
            else {
            	$getnumber = $limit*($page-1)+1;
            	$getcount = $page*$limit;
            }
            for ($row=0; $row<=500; $row+=50) { 
            	$getpage .= '<li><a class="dropdown-item page-row btn" data-row="'.($row==0?10:$row).'">'.($row==0?10:$row).'</a></li>';
            }
            $return .= '
            	<div class="d-flex justify-content-between align-items-center">
            		<div class="dropdown">
					  <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="getpage" data-bs-toggle="dropdown" aria-expanded="false">
					    '.$limit.'
					  </button>
					  <ul class="dropdown-menu" aria-labelledby="getpage">
					    '.$getpage.'
					  </ul>
					</div>
					<span class="ms-3 d-none d-md-block">'.$lang['hien-thi'].' '.($getnumber).' - '.($getcount).' '.$lang['cua-tong'].' '.$count.'</span>
            	</div>
            ';
	        return $return;
	    }
	    public function status($value){
	      global $lang,$router;
	      $status = $value;
	      switch($status){
	            case "A": $status = '<span class="font-weight-bold">'.$lang['kich-hoat'].'</span>';break;
	            case "D": $status = '<span class="font-weight-bold">'.$lang['khong-kich-hoat'].'</span>';break;
	      }
	      return $status;
	    }
	    public function gender($value){
	      global $lang,$router;
	      $status = $value;
	      switch($status){
	            case "1": $status = '<span class="font-weight-bold">'.$lang['gt-nam'].'</span>';break;
	            case "2": $status = '<span class="font-weight-bold">'.$lang['gt-nu'].'</span>';break;
	            case "3": $status = '<span class="font-weight-bold">'.$lang['gt-khac'].'</span>';break;
	      }
	      return $status;
	    }
	    public function week($value){
	      global $lang,$router;
	      $status = $value;
	      switch($status){
	            case "1": $status = 'T2';break;
	            case "2": $status = 'T3';break;
	            case "3": $status = 'T4';break;
	            case "4": $status = 'T5';break;
	            case "5": $status = 'T6';break;
	            case "6": $status = 'T7';break;
	            case "7": $status = 'CN';break;
	      }
	      return $status;
	    }
	    public function blockip() {
			global $database;
			$ip = $_SERVER['REMOTE_ADDR'];
		    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		        $ip = $_SERVER['HTTP_CLIENT_IP'];
		    } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		    }
			$getip = $database->get("blockip","*",["ip"=>$ip,"status"=>'A',"deleted"=>0]);
			if($getip>1){
				header("HTTP/1.0 404 Not Found");
				die();
			}
		}
		public function notification($user,$accounts=null,$permission=null,$title,$content,$url,$template=null,$type=null,$data=null){
	        global $database,$setting;
	        if($permission!=''){
	        	$getAccounts = $database->select("accounts",["id","permission"],["deleted"=>0,"status"=>'A']);
	        	foreach ($getAccounts as $key => $value) {
	        		$group = unserialize($database->get("permission", 'group', ["AND"=>["deleted"=> 0,"id"=>$value['permission'],"status"=>'A']]));
	                if($group[$permission]==$permission){
				        $getnotis = $database->select("acccounts_notification","token",["account"=>$value['id'],"deleted"=>0]);
			        	foreach ($getnotis as $getnoti) {
						    $registration_ids[$value['id']] .= '"'.$getnoti.'",';
						}
					  	$curl = curl_init();
					  	$active = $this->active(32);
					  	$click_action = $setting['site_url'].'admin/notification-views/'.$active.'/';
					  	curl_setopt_array($curl, array(
						    CURLOPT_URL => 'https://fcm.googleapis.com/fcm/send',
						    CURLOPT_RETURNTRANSFER => true,
						    CURLOPT_ENCODING => '',
						    CURLOPT_MAXREDIRS => 10,
						    CURLOPT_TIMEOUT => 0,
						    CURLOPT_FOLLOWLOCATION => true,
						    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						    CURLOPT_CUSTOMREQUEST => 'POST',
						    CURLOPT_POSTFIELDS => '{
						        "registration_ids":['.$registration_ids[$value['id']].'],
						        "notification": {
						            "title": "'.$title.'",
						            "body": "'.$content.'",
						            "icon":"https://pscmedia.eclo.io/templates/backend/assets/img/psclogo-new.png",
						            "click_action": "'.$click_action.'",
						        },
						        "data": {
							    	"user": '.$value['id'].'
							  	}
						    }',
						    CURLOPT_HTTPHEADER => array(
						      'Content-Type: application/json',
						      'Authorization: key=AAAAp8GZhl4:APA91bGgYbY5RDeicn8Xwrfh90L3hIbwY0MS1LZb5eB5a39oR00OWCKD2qC8B9bhnuCVl7oxJgRAgxUv7GgPEXn2Yqp_6EY48R14dHhcT_IIhcun36bvo42xJmcgePH7PorkdhO27k7s'
						    ),
					  	));
					  	$response = curl_exec($curl);
					  	curl_close($curl);
	                   	$database->insert("notification",[
				        	"user"		=> $user,
				            "accounts"  => $value['id'],
				            "date"      => date('Y-m-d H:i:s'),
				            "title"     => $title,
				            "content"   => $content,
				            "url"       => $url,
				            "deleted"   => 0,
				            "views"     => 0,
				            "active"    => $active,
				            "template" => $template,
				            "fcm"		=> $response,
				            "type"		=> $type,
				            "logs"		=> $click_action,
				            "data"		=> $data,
							"school"        =>$_SESSION['school'], 
				        ]);
				        // }
	                }
	        	}
	        }
	        else {
		        $getnotis = $database->select("acccounts_notification","token",["account"=>$accounts,"deleted"=>0]);
		        foreach ($getnotis as $getnoti) {
				    $registration_ids .= '"'.$getnoti.'",';
				}
			  	$curl = curl_init();
			  	$active = $this->active(32);
				$click_action = $setting['site_url'].'admin/notification-views/'.$active.'/';
			  	curl_setopt_array($curl, array(
				    CURLOPT_URL => 'https://fcm.googleapis.com/fcm/send',
				    CURLOPT_RETURNTRANSFER => true,
				    CURLOPT_ENCODING => '',
				    CURLOPT_MAXREDIRS => 10,
				    CURLOPT_TIMEOUT => 0,
				    CURLOPT_FOLLOWLOCATION => true,
				    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				    CURLOPT_CUSTOMREQUEST => 'POST',
				    CURLOPT_POSTFIELDS => '{
				        "registration_ids":['.$registration_ids.'],
				        "notification": {
				            "title": "'.$title.'",
				            "body": "'.$content.'",
				            "icon":"https://pscmedia.eclo.io/templates/backend/assets/img/psclogo-new.png",
				            "click_action": "'.$click_action.'",
				        },
				        "data": {
					    	"user": '.$accounts.'
					  	}
				    }',
				    CURLOPT_HTTPHEADER => array(
				      'Content-Type: application/json',
				      'Authorization: key=AAAAp8GZhl4:APA91bGgYbY5RDeicn8Xwrfh90L3hIbwY0MS1LZb5eB5a39oR00OWCKD2qC8B9bhnuCVl7oxJgRAgxUv7GgPEXn2Yqp_6EY48R14dHhcT_IIhcun36bvo42xJmcgePH7PorkdhO27k7s'
				    ),
			  	));
			  	$response = curl_exec($curl);
			  	curl_close($curl);
		        $database->insert("notification",[
		        	"user"		=> $user,
		            "accounts"  => $accounts,
		            "date"      => date('Y-m-d H:i:s'),
		            "title"     => $title,
		            "content"   => $content,
		            "url"       => $url,
		            "deleted"   => 0,
		            "views"     => 0,
		            "active"    => $active,
				    "template" => $template,
				    "fcm"		=> $response,
				    "type"		=> $type,
				    "logs"		=> $click_action,
				    "data"		=> $data,
					"school"        =>$_SESSION['school'], 
		        ]);
	        }
	        
			// echo $response;
	    }
	    public function org_chart($main){
	    	global $database,$lang;
	    	$getMain = $database->get("org_chart","*",["id"=>$main,"deleted"=>0]);
	    	if($getMain>1){
	    		$Getdetails = $database->select("org_chart_details","*",["org_chart"=>$getMain['id'],"deleted"=>0]);
	    		if(count($Getdetails)>0){
	    			foreach ($Getdetails as $key => $value) {
	    				$array[] = [
	    					"accounts" => $value['user'],
	    				];
	    			}
	    			return $array;
	    		}
	    	}
	    }
	    public function count_date($date_from,$date_to,$type=null,$color=null){
	        global $lang,$router;
	        $hieu_so = strtotime($date_to)-strtotime($date_from);  
	        $nam = floor($hieu_so / (365*60*60*24));  
	        $thang = floor(($hieu_so - $nam * 365*60*60*24) / (30*60*60*24)); 
	        $ngay = floor(($hieu_so - $nam * 365*60*60*24 - $thang*30*60*60*24)/ (60*60*24));  
	        $songay = $hieu_so / 86400;
	        $shownam = ($nam==0)?'':$nam.' '.$lang['nam']; 
	        $showthang= ($thang==0)?'':$thang.' '.$lang['thang']; 
	        $showngay = ($ngay==0)?'':$ngay.' '.$lang['ngay'];
	       	if($songay>5){
	       		$mau = 'text-secondary';
	       	} 
	       	elseif($songay<5 && $songay>2){
	       		$mau = 'text-primary';
	       	}
	       	elseif($songay<=2 && $songay>0){
	       		$mau = 'text-warning';
	       	}
	       	elseif($songay<=0){
	       		$mau = 'text-danger';
	       	}
	        if($songay>=0){
	        	if($type=='day'){
	        		if($color=='true'){
	        			return '<span class="'.$mau.'">'.$songay.' '.$lang['ngay'].'</span>';
	        		}
	        		else {
	        			return $songay;
	        		}
	        	}
	        	else {
	        		if($color=='true'){
	        			return '<span class="'.$mau.'">'.$shownam.' '.$showthang.' '.$showngay.'</span>';
	        		}
	        		else {
	        			return $shownam.' '.$showthang.' '.$showngay;
	        		}
	        	}
	        }
	        else {
	            $hieu_so = strtotime($date_from)-strtotime($date_to);  
	            $nam = floor($hieu_so / (365*60*60*24));  
	            $thang = floor(($hieu_so - $nam * 365*60*60*24) / (30*60*60*24)); 
	            $ngay = floor(($hieu_so - $nam * 365*60*60*24 - $thang*30*60*60*24)/ (60*60*24));  
	            $songay = $hieu_so / 86400;
	            $shownam = ($nam==0)?'':$nam.' '.$lang['nam']; 
	            $showthang= ($thang==0)?'':$thang.' '.$lang['thang']; 
	            $showngay = ($ngay==0)?'':$ngay.' '.$lang['ngay'];
	            if($type=='day'){
	        		if($color=='true'){
	        			return '<span class="'.$mau.'">-'.$songay.' '.$lang['ngay'].'</span>';
	        		}
	        		else {
	        			return $songay;
	        		}
	        	}
	        	else {
	        		if($color=='true'){
	        			return '<span class="'.$mau.'">-'.$shownam.' '.$showthang.' '.$showngay.'</span>';
	        		}
	        		else {
	        			return $shownam.' '.$showthang.' '.$showngay;
	        		}
	        	}
	        }
	    }
	    public function count_time($date_from,$date_to,$type=null,$color=null,$css=null){
	    	global $lang,$router;
	    	$start_date = new DateTime($date_from);
	    	$end_date = new DateTime($date_to);
			$diff = $end_date->diff($start_date);
			$total = $diff->days;
			$yeas =  $diff->y;
			$month = $diff->m;
			$day = $diff->d;
			$hour = $diff->h;
			$minute = $diff->i;
			$second = $diff->s;
	       	if($diff->invert==0){
	       		$invert = '-';
	       		$mau = $css.'danger';
	       	}
	       	else {
	       		if($total>5 && $color==''){
		       		$mau = $css.'dark';
		       	} 
		       	elseif($total<5 && $total>2 && $color==''){
		       		$mau = $css.'primary';
		       	}
		       	elseif($total<=2 && $total>0 && $color==''){
		       		$mau = $css.'warning';
		       	}
		       	elseif($total<=0 && $color==''){
		       		$mau = $css.'indigo';
		       	}
		       	else {
					$mau = $css.'success';
		       	}
	       	}
	       	if($css!=''){
	       		$class = '<span class="'.$mau.'">';
	       		$end_class = '</span>';
	       	}
			if($type=='day'){
				return $invert.''.$diff->days;
			}
			else {
				if($minute>0 && $hour==0 &&  $day==0){
					return $class.$invert.' '.$minute.' '.$lang['phut'].$end_class;
				}
				elseif($hour>0 && $month==0 &&  $day==0){
					return $class.$invert.' '.$hour.' '.$lang['gio'].' '.$minute.' '.$lang['phut'].$end_class;
				}
				elseif($day>0 && $month==0 &&  $yeas==0){
					return $class.$invert.' '.$day.' '.$lang['ngay'].' '.$hour.' '.$lang['gio'].' '.$minute.' '.$lang['phut'].$end_class;
				}
				elseif($day>0 && $month>0 &&  $yeas==0){
					return $class.$invert.' '.$month.' '.$lang['thang'].' '.$day.' '.$lang['ngay'].' '.$hour.' '.$lang['gio'].' '.$minute.' '.$lang['phut'].$end_class;
				}
				else {
					return $class.$invert.' '.$yeas.' '.$lang['nam'].' '.$month.' '.$lang['thang'].' '.$day.' '.$lang['ngay'].' '.$hour.' '.$lang['gio'].' '.$minute.' '.$lang['phut'].$end_class;
				}
			}
	    }
	    public function getDatesFromRange($date_from, $date_to, $format = 'Y-m-d') {
		    $array = array();
		    $interval = new DateInterval('P1D');
		    $realEnd = new DateTime($date_to);
		    $realEnd->add($interval);
		    $period = new DatePeriod(new DateTime($date_from), $interval, $realEnd);
		    foreach($period as $date) { 
		        $array[$date->format($format)] = $date->format($format); 
		    }
		    return $array;
		}
	}
?>