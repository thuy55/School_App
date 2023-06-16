<?php
	if (!defined('JATBI')) die("Hacking attempt");
	if($router['0']==''){
		$date = explode('-',$xss->xss($_GET['date']));
		$date_from = ($_GET['date']=='')?date('Y-m-01 00:00:00'):date('Y-m-d',strtotime(str_replace('/','-',$date[0]))).' 00:00:00';
		$date_to = ($_GET['date']=='')?date('Y-m-t 23:59:59'):date('Y-m-t',strtotime(str_replace('/','-',$date[1]))).' 23:59:59';
		$templates = $setting['site_backend'].'dashboard.tpl';
	}
	elseif($router['0']=='logout'){
		unset($_SESSION['accounts']);
		unset($_SESSION['school']);
		unset($_SESSION['csrf']);
		unset($_COOKIE['token']);
		setcookie('token','', time()-$setting['cookie_time'],"/");
		header("location: /");
	}
	elseif($router['0']=='skin'){
		$ajax = 'true';
		if($router['1']=='mode'){
			$_SESSION['mode'] = $_POST['skin'];
			$database->update("accounts",["mode"=>$_POST['skin']],["id"=>$account['id']]);
		}
		if($router['1']=='dark'){
			$_SESSION['dark'] = $_POST['skin'];
			$database->update("accounts",["skin"=>$_POST['skin']],["id"=>$account['id']]);
		}
		echo json_encode(['status'=>'success']);
	}
	elseif($router['0']=='accounts-notification'){
		$ajax = 'true';
		if(isset($_POST['token'])){
			$gettoken = $database->get("acccounts_notification","id",["AND"=>["token"=>$xss->xss($_POST['token'])]]);
			if($gettoken==''){
				$insert = [
					"account" => $account['id'],
					"token" => $xss->xss($_POST['token']),
					"date" => date("Y-m-d H:i:s"),
					"browsers" => $_SERVER["HTTP_USER_AGENT"],
					"school"        =>$_SESSION['school'], 
				];
				$database->insert("acccounts_notification",$insert);
				echo json_encode(['status'=>'success',"content"=>"Token Notification"]);
			}
			else {
				$insert = [
					"account" => $account['id'],
					"token" => $xss->xss($_POST['token']),
					"date" => date("Y-m-d H:i:s"),
					"browsers" => $_SERVER["HTTP_USER_AGENT"],
					"school"        =>$_SESSION['school'], 
				];
				$database->update("acccounts_notification",$insert,["id"=>$gettoken]);
				echo json_encode(['status'=>'success',"content"=>"Update Token Notification"]);
			}
		}
	}
	elseif($router['0']=='row'){
		$_SESSION['page'] = $_POST['page'];
		$ajax = 'true';
		echo json_encode(['status'=>'success','content'=>$_POST['page']]);
	}
	elseif($router['0']=='district'){
		$ajax = 'true';
		$value = $xss->xss($_POST['value']);
		$data = $database->get("province","*",["id"=>$value,"status"=>'A',"deleted"=>0]);
		if($data>1){
			$GetDistrict = $database->select("district","*",["province"=>$data['id'],"status"=>'A',"deleted"=>0]);
			$html = '<option value="">'.$lang['quan-huyen'].'</option>';
			foreach ($GetDistrict as $key => $value) {
				$html .= '<option value="'.$value['id'].'">'.$value['name'].'</option>';
			}
			echo json_encode(['status'=>'success',"html"=>$html]);
		}
	}
	elseif($router['0']=='ward'){
		$ajax = 'true';
		$value = $xss->xss($_POST['value']);
		$data = $database->get("district","*",["id"=>$value,"status"=>'A',"deleted"=>0]);
		if($data>1){
			$GetWard = $database->select("ward","*",["district"=>$data['id'],"status"=>'A',"deleted"=>0]);
			$html = '<option value="">'.$lang['phuong-xa'].'</option>';
			foreach ($GetWard as $key => $value) {
				$html .= '<option value="'.$value['id'].'">'.$value['name'].'</option>';
			}
			echo json_encode(['status'=>'success',"html"=>$html]);
		}
	}
		elseif($router['0']=='projects1'){
		$ajax = 'true';
		$value = $xss->xss($_POST['value']);
		$data = $database->get("project","*",["token"=>$value,"status"=>'A',"deleted"=>0]);
		if($data>1){
			$GetWard = $database->select("place","*",["project"=>$data['token'],"status"=>'A',"deleted"=>0]);
			$html = '<option value="">'.$lang['khu-vuc'].'</option>';
			foreach ($GetWard as $key => $value) {
				$html .= '<option value="'.$value['active'].'">'.$value['name'].'</option>';
			}
			echo json_encode(['status'=>'success',"html"=>$html]);
		}
	}
	elseif($router['0']=='change-school'){
		foreach ($schools as $key => $value) {
			if($value['id']==$router['1'] || $router['1']==0){
				$change_school[] = "true";
			}
		}
		if(count($change_school)>0){
			$_SESSION['school'] = $router['1'];
			header("location: ".$_SERVER['HTTP_REFERER']);
		}
		else {
			header("HTTP/1.0 404 Not Found");
			die();
		}
	}
	elseif($router['0']=='course-class'){
		$ajax = 'true';
		$value = $xss->xss($_POST['value']);
		$data = $database->get("course","*",["id"=>$value,"status"=>'A',"deleted"=>0]);
		if($data>1){
			$Getclass = $database->select("class_diagram","*",["school"=>$_SESSION['school'],"course"=>$data['id'],"status"=>'A',"deleted"=>0]);
			$html = '<option value="">'.$lang['xep-lop'].'</option>';
			foreach ($Getclass as $key => $value) {
				$html .= '<option value="'.$value['id'].'">Lớp: '.$database->get("class","name",["id"=>$value["class"]]).' - GVCN: '.$database->get("teacher","firstname",["id"=>$value["homeroom_teacher"]]).' '.$database->get("teacher","lastname",["id"=>$value["homeroom_teacher"]]).'</option>';
			}
			echo json_encode(['status'=>'success',"html"=>$html]);
		}
	}
	elseif($router['0']=='route-student'){
		$ajax = 'true';
		$value = $xss->xss($_POST['value']);
		$data = $database->get("route","*",["id"=>$value,"status"=>'A',"deleted"=>0]);
		if($data>1){
			$GetStudentRegister = $database->select("student_register_car","*",["school"=>$_SESSION['school'],"route"=>$data['id'],"status"=>'A',"deleted"=>0]);
			$html = '<option value="">'.$lang['chon-hoc-sinh'].'</option>';
			foreach ($GetStudentRegister as $key => $GetStudentRegister) {
				$html .= '<option value="'.$value['id'].'">'.$database->get("students","id_student",["id"=>$database->get("arrange_class","students",["id"=>$database->get("student_register_car","arrange_class",["id"=>$GetStudentRegister['id']])])]).' - '.$database->get("students","firstname",["id"=>$database->get("arrange_class","students",["id"=>$database->get("student_register_car","arrange_class",["id"=>$GetStudentRegister['id']])])]).' '.$database->get("students","lastname",["id"=>$database->get("arrange_class","students",["id"=>$database->get("student_register_car","arrange_class",["id"=>$GetStudentRegister['id']])])]).'</option>';
			}
			echo json_encode(['status'=>'success',"html"=>$html]);
		}
	}
	elseif($router['0']=='class-course'){
		$ajax = 'true';
		$value = $xss->xss($_POST['value']);
		$data = $database->get("class_diagram","*",["id"=>$value,"status"=>'A',"deleted"=>0]);
		if($data>1){
			$GetStudents = $database->select("arrange_class","*",["school"=>$_SESSION['school'],"class_diagram"=>$data['id'],"status"=>'A',"deleted"=>0]);
			
			foreach ($GetStudents as $key => $value) {
				$html .= '<tr>
							<td>
								
								<select name="questions_content[]" class="select2 form-control areas-students" style="width:100%">
									<option value="" disabled selected>Học sinh</option>';
									
						foreach ($GetStudents as $arrange_classs) {
							$selected = ($value['id'] == $arrange_classs['id']) ? 'selected' : '';							
							$html .= '<option value="'.$arrange_classs['id'].'" '.($value['id']==$arrange_classs['id']?'selected':'').'>'.$database->get("students","fullname",['id'=>$arrange_classs['students']]).'</option>';

						}
									
						$html .= '</select>
							</td>
							<td>
								
								<input type="number" id="number" name="questions_point[]" step="any" min="0" max="10" class="form-control">
							</td>
							<td>
								<input type="hidden" name="questions_deleted[]" class="delete" value="">
								<input type="hidden" name="questions_id[]" value="">
								<a href="#" class="text-danger deleted-row"><i class="fas fa-trash"></i></a>
							</td>
						</tr>';

				
			}
			$school_id=$_SESSION['school'];
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
					$semesterss = $database->select("semester", "*",[
						"AND" => [
							"deleted"       => 0,
							'course'        => $value['id'],
							"school"=>$school_id,
						],
					]);
					foreach($semesterss as $valu){
						$start_timestam = strtotime($valu['startdate']);
						$end_timestam = strtotime($valu['enddate']);
						if ($date_timestamp >= $start_timestam && $date_timestamp <= $end_timestam) {
							$semester = $database->get("semester", "*",[
								"AND" => [
									"deleted"       => 0,
									'id'        => $valu['id'],
									"school"=>$school_id,
								],
							]);

						}
					}
				}
			}
			$GetSubjects = $database->select("assigning_teachers","*",["school"=>$_SESSION['school'],"class_diagram"=>$data['id'],"semester"=>$semester['id'],"status"=>'A',"deleted"=>0]);
			$htmls = '<option value="">'.$lang['chon-mon-hoc'].'</option>';
			foreach ($GetSubjects as $key => $value) {
				$htmls .= '<option value="'.$value['id'].'">'.$database->get("subject","name",["id"=>$value["subject"]]).' - '.$database->get("teacher","firstname",["id"=>$value["teacher"]]).' '.$database->get("teacher","lastname",["id"=>$value["teacher"]]).'</option>';
			}
			echo json_encode(['status'=>'success',"html"=>$html,"htmls"=>$htmls]);
		}
	}
	elseif($router['0']=='getparent'){
		$ajax = 'true';
		$parents=$database->get("parent","*",["active"=>$_POST['type'],"deleted"=> 0,"status"=>'A']);
		$parentts=[
			"id"=>$parents['id'],
			"name"=>$parents['name'],
			"phone_number"=>$parents['phone_number'],
			"address"=>$parents['address'],
			"ward"=>$database->get("ward","name",["id"=>$parents['ward']]),
			"district"=>$database->get("district","name",["id"=>$parents['district']]),
			"province"=>$database->get("province","name",["id"=>$parents['province']]),
			"citizenId"=>$parents['citizenId'],
			"type"=>$parents['type'],
		];
		$school_iid=$database->get("school","id",["token"=>$_POST['token'],"place"=>$_POST['place'],"deleted"=> 0,"status"=>'A']);
		$studentt=$database->select("students","*",["school"=>$school_iid,"parent"=>$parents['id'],"deleted"=> 0,"status"=>'A']);
		foreach ($studentt as $key => $student) {
			$date=date("Y-m-d");
			$course=$database->select("course","*",[
				"school"        =>$school_iid,
				"status"        =>'A',
				"deleted"       => 0,
			]);
			$arrange_class = $database->select("arrange_class", "*",[
				"AND" => [
					"students"=>$student['id'],
					"deleted"       => 0,
					"school"=>$school_iid,
					"status"=>"A",
				],
				"ORDER" => [
					"id"=>"DESC",
				]
			]);
			foreach($arrange_class as $data){
				foreach($course as $value){
					$date_timestamp = strtotime($date);
					$start_timestamp = strtotime($value['startdate']);
					$end_timestamp = strtotime($value['enddate']);
					
					if ($date_timestamp >= $start_timestamp && $date_timestamp <= $end_timestamp) {
						$class_course = $database->get("class_diagram", "*",[
							"AND" => [
								"id"=>$data['class_diagram'],
								"deleted"       => 0,
								'course'        => $value['id'],
								"school"=>$school_iid,
							],
						]);
						$arrange_class_current = $database->get("arrange_class", "*",[
							"AND" => [
								"class_diagram"=>$class_course['id'],
								"students"=>$student['id'],
								"deleted"       => 0,
								"school"=>$school_iid,
								"status"=>"A",
							],
						]);
						$timekeeping_details = $database->get("timekeeping_details", "*", [
							"AND" => [
								"arrange_class" => $arrange_class_current['id'],
								"deleted" => 0,
								"school" => $school_iid,
							],
							"ORDER" => ["id" => "DESC"],
							"LIMIT" => 1
						]);
						$details=$database->count('tuition_order_detail',["month"=>date('m'),"type" =>[0,1],"school"=>$school_iid,"arrange_class"=>$arrange_class_current['id'],"deleted"=> 0,"status"=>'A']);
						$content_tuition = $database->count("content_tuition",[
							"type" =>[0,1],
							"school"=>$school_iid,
							"deleted"=> 0,
							"status"=>'A',
							"class_diagram"=>$class_course['id']]);
						if($details==$content_tuition){
							$note="Đã đóng";
						}elseif($details==0){
							$note="Chưa đóng";
						}elseif($details>0 && $details<$content_tuition){
							$note="Đóng thiếu";
						}
					
					}
				}
			}
			
			
			$studenthtml .= '<div class="row">
			<div class="fw-bold fs-5 text-warning text-center">THÔNG TIN HỌC SINH</div>
			<div class="w-100 pt-3">
				<img src="'.$student['avatar'].'" class="w-100" />
			</div>
			<div class="w-100 px-4 mt-3 d-flex justify-items-center">
				<table class="table table-bordered">
					<tr>
						<td  width="30%" class="fw-bold">Học sinh</td>
						<td>'.$student['fullname'].'</td>
					</tr>
					<tr>
						<td class="fw-bold">Ngày sinh</td>
						<td>'.date("d/m/Y", strtotime($student['birthday'])).'</td>
					</tr>
					<tr>
						<td class="fw-bold">Khối học</td>
						<td>'.$database->get("grade","name",["id"=>$class_course['grade'],"school"=>$school_iid,]).'</td>
					</tr>
					<tr>
						<td class="fw-bold">Lớp học</td>
						<td>'.$database->get("class", "name",[
							"id"=>$class_course['class'],
							"school"=>$school_iid,
					]).'</td>
					</tr>
					<tr>
						<td class="fw-bold">Thời gian</td>
						<td>'.$timekeeping_details['date'].'</td>
					</tr>
					<tr>
						<td class="fw-bold">Đóng tiền tháng này</td>
						<td class="text-danger">'.$note.'</td>
					</tr>
				</table>
			</div>
		</div>';
		}
		echo json_encode(["parents"=>$parentts,"student"=>$studenthtml]);
		
	}
	elseif($router['0']=='error'){
		$templates = $setting['site_backend'].'error.tpl';
	}
	else {
		header("location: /");
	}
?>