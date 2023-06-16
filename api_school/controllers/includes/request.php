<?php 
if (!defined('JATBI')) die("Hacking attempt");
	$request = [
		"main"=>[
			"name"=>$lang['chinh'],
			"item"=>[
				''=>[
					"menu"=>$lang['trang-chu'],
					"url"=>'/',
					"icon"=>'<i class="fas fa-tachometer-alt "></i>',
					"controllers"=>"controllers/core/dashboard.php",
					"hidden"=>'false',
					"main"=>'true',
				],
			],
		],
		"content"=>[
			"name"=>$lang['noi-dung'],
			"item"=>[
				'profiles'	=>[	
					"menu"	=>	$lang['ho-so'],
					"url"	=>	'/profiles/profiles/',
					"icon"	=>'<i class="fas fa-business-time"></i>',
					"sub"=>[
						'students'	=>[
							"name"		=> $lang['hoc-sinh'],
							"router"	=> 'students',
							"icon"		=> '<i class="fas fa-users"></i>',
						],
						'parents'	=>[
							"name"		=> $lang['phu-huynh'],
							"router"	=> 'parents',
							"icon"		=> '<i class="fas fa-user-friends"></i>',
						],
						'timekeeping'	=> [
							"name"		=> $lang['diem-danh-lop-hoc'],
							"router"	=> 'timekeeping-class',
							"icon"		=> '<i class="fas fa-braille"></i>',
						],
						'birthday'	=> [
							"name"		=> $lang['sinh-nhat-hoc-sinh'],
							"router"	=> 'birthday',
							"icon"		=> '<i class="fa fa-birthday-cake"></i>',
						],
						'health'	=>[
							"name"		=> $lang['suc-khoe-hoc-sinh'],
							"router"	=> 'health',
							"icon"		=> '<i class="fas fa-globe"></i>',
						],
						'vaccination'	=> [
							"name"		=> $lang['tinh-trang-tiem-vacxin-hoc-sinh'],
							"router"	=> 'vaccination',
							"icon"		=> '<i class="	fas fa-user-friends"></i>',
						],
						'point'	=>[
							"name"		=> $lang['diem-thi'],
							"router"	=> 'point',
							"icon"		=> '<i class="fas fa-user"></i>',
						],
						'furlough'	=>[
							"name"		=> $lang['xin-phep-nghi-hoc'],
							"router"	=> 'furlough',
							"icon"		=> '<i class="fas fa-user"></i>',
						],
						'priority_object'	=>[
							"name"		=> $lang['doi-tuong'].'<small class="text-danger">*</small>',
							"router"	=> 'priority_object',
							"icon"		=> '<i class="fas fa-user"></i>',
						],
						'allergy'	=>[
							"name"		=> $lang['di-ung'].'<small class="text-danger">*</small>',
							"router"	=> 'allergy',
							"icon"		=> '<i class="fas fa-user"></i>',
						],
					],
					"controllers"=>"controllers/core/profiles.php",
					"hidden"=>'false',
					"main"=>'false',
					"colspan"=>'1',
					"permission"=>[
						'students'=>$lang['hoc-sinh'],
						'students.add' => $lang['them'].$lang['hoc-sinh'],
						'students.edit'=>$lang['sua'].$lang['hoc-sinh'],
						'students.delete'=>$lang['xoa'].$lang['hoc-sinh'],
						'parents'=>$lang['phu-huynh'],	
						'parents.add' => $lang['them'].$lang['phu-huynh'],
						'parents.edit'=>$lang['sua'].$lang['phu-huynh'],
						'parents.delete'=>$lang['xoa'].$lang['phu-huynh'],					
						'timekeeping'=>$lang['diem-danh'],
						'timekeeping.add' => $lang['them'].$lang['diem-danh'],
						'timekeeping.edit'=>$lang['sua'].$lang['diem-danh'],
						'timekeeping.delete'=>$lang['xoa'].$lang['diem-danh'],
						'timekeeping.class'=>$lang['chon-lop'].$lang['diem-danh'],
						'birthday'=>$lang['sinh-nhat-hoc-sinh'],						
						'health'=>$lang['suc-khoe-hoc-sinh'],
						'health.add' => $lang['them'].$lang['suc-khoe-hoc-sinh'],
						'health.edit'=>$lang['sua'].$lang['suc-khoe-hoc-sinh'],
						'health.delete'=>$lang['xoa'].$lang['suc-khoe-hoc-sinh'],		

						'vaccination'=>$lang['tiem-vacxin-hoc-sinh'],
						'vaccination.add' => $lang['them'].$lang['tiem-vacxin-hoc-sinh'],
						'vaccination.edit'=>$lang['sua'].$lang['tiem-vacxin-hoc-sinh'],
						'vaccination.delete'=>$lang['xoa'].$lang['tiem-vacxin-hoc-sinh'],

						'point'=>$lang['diem-thi'],
						'point.add' => $lang['them'].$lang['diem-thi'],
						'point.edit'=>$lang['sua'].$lang['diem-thi'],
						'point.delete'=>$lang['xoa'].$lang['diem-thi'],
						'furlough'=>$lang['xin-phep-nghi-hoc'],
						'furlough.add' => $lang['them'].$lang['xin-phep-nghi-hoc'],
						'furlough.edit'=>$lang['sua'].$lang['xin-phep-nghi-hoc'],
						'furlough.delete'=>$lang['xoa'].$lang['xin-phep-nghi-hoc'],
						'priority_object'=>$lang['doi-tuong'],
						'priority_object.add' => $lang['them'].$lang['doi-tuong'],
						'priority_object.edit'=>$lang['sua'].$lang['doi-tuong'],
						'priority_object.delete'=>$lang['xoa'].$lang['doi-tuong'],
						'allergy'=>$lang['di-ung'],
						'allergy.add' => $lang['them'].$lang['di-ung'],
						'allergy.edit'=>$lang['sua'].$lang['di-ung'],
						'allergy.delete'=>$lang['xoa'].$lang['di-ung'],
						// 'timework_details'=>$lang['thoi-gian-hoc-chi-tiet'],
						// 'timework_details.add' => $lang['them'].$lang['thoi-gian-hoc-chi-tiet'],
						// 'timework_details.edit'=>$lang['sua'].$lang['thoi-gian-hoc-chi-tiet'],
						// 'timework_details.delete'=>$lang['xoa'].$lang['thoi-gian-hoc-chi-tiet'],
						
					]
				],
				'class-academic'	=>[	
					"menu"	=>	$lang['lop-&-hoc-vu'],
					"url"	=>	'/class-academic/class-academic/',
					"icon"	=>	'<i class="fas fa-door-open"></i>',
					"sub"=>[
						'class_diagram'	=>[
							"name"		=> $lang['so-do-lop'],
							"router"	=> 'class_diagram',
							"icon"		=> '<i class="fas fa-globe"></i>',
						],
						'arrange_class'	=>[
							"name"		=> $lang['xep-lop'],
							"router"	=> 'arrange_class',
							"icon"		=> '<i class="fas fa-globe"></i>',
						],
						'change_class'	=>[
							"name"		=> $lang['chuyen-lop'],
							"router"	=> 'change_class',
							"icon"		=> '<i class="fas fa-globe"></i>',
						],
						'up_class'	=>[
							"name"		=> $lang['len-lop'],
							"router"	=> 'up_class',
							"icon"		=> '<i class="fas fa-globe"></i>',
						],
						'first_book'	=>[
							"name"		=> $lang['so-dau-bai'],
							"router"	=> 'first_book-class',
							"icon"		=> '<i class="fas fa-globe"></i>',
						],
						'schedule'	=> [
							"name"		=> $lang['thoi-khoa-bieu'],
							"router"	=> 'schedule',
							"icon"		=> '<i class="fas fa-solid fa-camera"></i>',
						],
						'assigning_teachers'	=> [
							"name"		=> $lang['phan-cong-gv'],
							"router"	=> 'assigning_teachers',
							"icon"		=> '<i class="fas fa-solid fa-camera"></i>',
						],
						
						'classroom'	=> [
							"name"		=> 'Phòng học'.'<small class="text-danger">*</small>',
							"router"	=> 'classroom',
							"icon"		=> '<i class="fas fa-school"></i>',
						],
						'classroom_type'	=> [
							"name"		=> $lang['loai-phong-hoc'].'<small class="text-danger">*</small>',
							"router"	=> 'classroom_type',
							"icon"		=> '<i class="fas fa-school"></i>',
						],
						'departments'	=> [
							"name"		=> $lang['phong-ban-giao-vien'].'<small class="text-danger">*</small>',
							"router"	=> 'departments',
							"icon"		=> '<i class="fas fa-door-closed"></i>',
						],
						'location'	=> [
							"name"		=> $lang['khu-vuc'].'<small class="text-danger">*</small>',
							"router"	=> 'location',
							"icon"		=> '<i class="fas fa-globe"></i>',
						],
						'grade'	=>[
							"name"		=> $lang['khoi'].'<small class="text-danger">*</small>',
							"router"	=> 'grade',
							"icon"		=> '<i class="fas fa-globe"></i>',
						],
						'class'	=> [
							"name"		=> $lang['danh-sach-lop'],
							"router"	=> 'class',
							"icon"		=> '<i class="fas fa-solid fa-camera"></i>',
						],
						'subject'	=> [
							"name"		=> $lang['mon-hoc'].'<small class="text-danger">*</small>',
							"router"	=> 'subject',
							"icon"		=> '<i class="fas fa-solid fa-book"></i>',
						],
						'course'	=> [
							"name"		=> $lang['khoa-hoc'].'<small class="text-danger">*</small>',
							"router"	=> 'course',
							"icon"		=> '<i class="	fas fa-user-friends"></i>',
						],
						'semester'	=> [
							"name"		=> $lang['hoc-ki'].'<small class="text-danger">*</small>',
							"router"	=> 'semester',
							"icon"		=> '<i class="	fas fa-user-friends"></i>',
						],
						'typescore'	=> [
							"name"		=> $lang['loai-diem'].'<small class="text-danger">*</small>',
							"router"	=> 'typescore',
							"icon"		=> '<i class="	fas fa-user-friends"></i>',
						],
					],
					"controllers"=>"controllers/core/class-academic.php",
					"hidden"=>'false',
					"main"=>'false',
					"colspan"=>'1',
					"permission"=>[
						'class_diagram'=>$lang['so-do-lop'],
						'class_diagram.add' => $lang['them'].$lang['so-do-lop'],
						'class_diagram.edit'=>$lang['sua'].$lang['so-do-lop'],
						'class_diagram.delete'=>$lang['xoa'].$lang['so-do-lop'], 
						'class_diagram_student'=>$lang['so-do-lop-hoc-sinh'],
						'arrange_class'=>$lang['xep-lop'],
						'arrange_class.add' => $lang['them'].$lang['xep-lop'],
						'arrange_class.edit'=>$lang['sua'].$lang['chuyen-lop'],
						'arrange_class.delete'=>$lang['xoa'].$lang['xep-lop'], 
						
						'change_class'=>$lang['chuyen-lop'],
						'change_class.edit'=>$lang['sua'].$lang['chuyen-lop'],

						'up_class'=>$lang['len-lop'],
						'up_class.add'=>$lang['them'].$lang['len-lop'],

						'first_book-class'=>$lang['so-dau-bai-theo-lop'],			
						'first_book'=>$lang['so-dau-bai'],						
						'first_book.edit'=>$lang['sua'].$lang['so-dau-bai'],
						'first_book.class'=>$lang['lop'].$lang['so-dau-bai'],
															
						'grade'=>$lang['khoi'],
						'grade.add' => $lang['them'].$lang['khoi'],
						'grade.edit'=>$lang['sua'].$lang['khoi'],
						'grade.delete'=>$lang['xoa'].$lang['khoi'],		

						'course'=>$lang['khoa-hoc'],
						'course.add' => $lang['them'].$lang['khoa-hoc'],
						'course.edit'=>$lang['sua'].$lang['khoa-hoc'],
						'course.delete'=>$lang['xoa'].$lang['khoa-hoc'],
						'semester'=>$lang['hoc-ki'],
						'semester.add' => $lang['them'].$lang['hoc-ki'],
						'semester.edit'=>$lang['sua'].$lang['hoc-ki'],
						'semester.delete'=>$lang['xoa'].$lang['hoc-ki'],

						'classroom'=>$lang['lop-hoc'],
						'classroom.add' => $lang['them'].$lang['lop-hoc'],
						'classroom.edit'=>$lang['sua'].$lang['lop-hoc'],
						'classroom.delete'=>$lang['xoa'].$lang['lop-hoc'],

						'classroom_type'=>$lang['loai-phong-hoc'],
						'classroom_type.add' => $lang['them'].$lang['loai-phong-hoc'],
						'classroom_type.edit'=>$lang['sua'].$lang['loai-phong-hoc'],
						'classroom_type.delete'=>$lang['xoa'].$lang['loai-phong-hoc'],

						'location'=>$lang['khu-vuc'],
						'location.add' => $lang['them'].$lang['khu-vuc'],
						'location.edit'=>$lang['sua'].$lang['khu-vuc'],
						'location.delete'=>$lang['xoa'].$lang['khu-vuc'],
						
						'class'=>$lang['danh-sach-lop'],
						'class.add' => $lang['them'].$lang['danh-sach-lop'],
						'class.edit'=>$lang['sua'].$lang['danh-sach-lop'],
						'class.delete'=>$lang['xoa'].$lang['danh-sach-lop'],

					
						'assigning_teachers'=>$lang['phan-cong-gv'],
						'assigning_teachers.add' => $lang['them'].$lang['phan-cong-gv'],
						'assigning_teachers.edit'=>$lang['sua'].$lang['phan-cong-gv'],
						'assigning_teachers.delete'=>$lang['xoa'].$lang['phan-cong-gv'],
						'schedule'=>$lang['thoi-khoa-bieu'],
						'schedule.add' => $lang['them'].$lang['thoi-khoa-bieu'],
						'schedule.edit'=>$lang['sua'].$lang['thoi-khoa-bieu'],
						'schedule.delete'=>$lang['xoa'].$lang['thoi-khoa-bieu'],
						'schedule.detail'=>$lang['chi-tiet'].$lang['thoi-khoa-bieu'],
			
						'subject'=>$lang['mon-hoc'],
						'subject.add' => $lang['them'].$lang['mon-hoc'],
						'subject.edit'=>$lang['sua'].$lang['mon-hoc'],
						'subject.delete'=>$lang['xoa'].$lang['mon-hoc'], 
						'departments'=>$lang['phong-ban-giao-vien'],
						'departments.add' => $lang['them'].$lang['phong-ban-giao-vien'],
						'departments.edit'=>$lang['sua'].$lang['phong-ban-giao-vien'],
						'departments.delete'=>$lang['xoa'].$lang['phong-ban-giao-vien'],
						'typescore'=>$lang['loai-diem'],
						'typescore.add' => $lang['them'].$lang['loai-diem'],
						'typescore.edit'=>$lang['sua'].$lang['loai-diem'],
						'typescore.delete'=>$lang['xoa'].$lang['loai-diem'],
						
					]
				],
				'kitchen'	=>[	
					"menu"	=>	$lang['bep'],
					"url"	=>	'/kitchen/kitchen/',
					"icon"	=>'<i class="fas fa-business-time"></i>',
					"sub"=>[
						'food_menu'	=>[
							"name"		=> $lang['thuc-don-mon-an'],
							"router"	=> 'food_menu',
							"icon"		=> '<i class="fas fa-user"></i>',
						],
						'dish'	=>[
							"name"		=> $lang['mon-an'],
							"router"	=> 'dish',
							"icon"		=> '<i class="fas fa-user"></i>',
						],
						'chef'	=>[
							"name"		=> $lang['dau-bep'],
							"router"	=> 'chef',
							"icon"		=> '<i class="fas fa-user"></i>',
						],
						'food_warehouse'	=>[
							"name"		=> $lang['kho-thuc-pham'],
							"router"	=> 'food_warehouse',
							"icon"		=> '<i class="fas fa-globe"></i>',
						],	
						'food_import'	=>[
							"name"		=> $lang['nhap-hang'],
							"router"	=> 'food_import',
							"icon"		=> '<i class="fas fa-globe"></i>',
						],	
						'food_export'	=>[
							"name"		=> $lang['xuat-hang'],
							"router"	=> 'food_export',
							"icon"		=> '<i class="fas fa-globe"></i>',
						],	
						'category_food'	=>[
							"name"		=> $lang['danh-muc-thuc-pham'].'<small class="text-danger">*</small>',
							"router"	=> 'category_food',
							"icon"		=> '<i class="fas fa-globe"></i>',
						],	
						'supplier_food'	=>[
							"name"		=> $lang['nha-cung-cap'].'<small class="text-danger">*</small>',
							"router"	=> 'supplier_food',
							"icon"		=> '<i class="fas fa-globe"></i>',
						],
						'unit_food'	=>[
							"name"		=> $lang['don-vi'].'<small class="text-danger">*</small>',
							"router"	=> 'unit_food',
							"icon"		=> '<i class="fas fa-globe"></i>',
						],	
					],
					"controllers"=>"controllers/core/kitchen.php",
					"hidden"=>'false',
					"main"=>'false',
					"colspan"=>'1',
					"permission"=>[
						'food_menu'=>$lang['thuc-don-mon-an'],
						'food_menu.add' => $lang['them'].$lang['thuc-don-mon-an'],
						'food_menu.edit'=>$lang['sua'].$lang['thuc-don-mon-an'],
						'food_menu.delete'=>$lang['xoa'].$lang['thuc-don-mon-an'],
						'food_menu.detail'=>$lang['chi-tiet'].$lang['thuc-don-mon-an'],		
						'dish'=>$lang['mon-an'],
						'dish.add' => $lang['them'].$lang['mon-an'],
						'dish.edit'=>$lang['sua'].$lang['mon-an'],
						'dish.delete'=>$lang['xoa'].$lang['mon-an'],	
						'chef'=>$lang['dau-bep'],
						'chef.add' => $lang['them'].$lang['dau-bep'],
						'chef.edit'=>$lang['sua'].$lang['dau-bep'],
						'chef.delete'=>$lang['xoa'].$lang['dau-bep'],	
						'food_warehouse'=>$lang['kho-thuc-pham'],
						'food_warehouse.add' => $lang['them'].$lang['kho-thuc-pham'],
						'food_warehouse.edit'=>$lang['sua'].$lang['kho-thuc-pham'],
						'food_warehouse.delete'=>$lang['xoa'].$lang['kho-thuc-pham'],
						'food_import'=>$lang['nhap-hang'],
						'food_import.add' => $lang['them'].$lang['nhap-hang'],
						'food_import.edit'=>$lang['sua'].$lang['nhap-hang'],
						'food_import.delete'=>$lang['xoa'].$lang['nhap-hang'],
						'food_export'=>$lang['xuat-hang'],
						'food_export.add' => $lang['them'].$lang['xuat-hang'],
						'food_export.edit'=>$lang['sua'].$lang['xuat-hang'],
						'food_export.delete'=>$lang['xoa'].$lang['xuat-hang'],
						'category_food'=>$lang['danh-muc-thuc-pham'],
						'supplier_food'=>$lang['nha-cung-cap'],
						'unit_food'=>$lang['don-vi'],	
						'unit_food.add' => $lang['them'].$lang['don-vi'],
						'unit_food.edit'=>$lang['sua'].$lang['don-vi'],
						'unit_food.delete'=>$lang['xoa'].$lang['don-vi'],
						'supplier_food.add' => $lang['them'].$lang['nha-cung-cap'],
						'supplier_food.edit'=>$lang['sua'].$lang['nha-cung-cap'],
						'supplier_food.delete'=>$lang['xoa'].$lang['nha-cung-cap'],
						'category_food.add' => $lang['them'].$lang['danh-muc-thuc-pham'],
						'category_food.edit'=>$lang['sua'].$lang['danh-muc-thuc-pham'],
						'category_food.delete'=>$lang['xoa'].$lang['danh-muc-thuc-pham'],
						'warehouses-history'=>$lang['lich-su-nhap-hang'],
					]
				],
				'learning_outcomes'	=>[	
					"menu"	=>	$lang['cap-nhat-hoc-tap'],
					"url"	=>	'/learning_outcomes/learning_outcomes/',
					"icon"	=>'<i class="fas fa-business-time"></i>',
					"sub"=>[
						
						'school_announcement'	=>[
							"name"		=> $lang['thong-bao-cua-truong'],
							"router"	=> 'school_announcement',
							"icon"		=> '<i class="fas fa-user"></i>',
						],
						'teacher_announcement'	=>[
							"name"		=> $lang['thong-bao-cua-thay-co'],
							"router"	=> 'teacher_announcement',
							"icon"		=> '<i class="fas fa-user"></i>',
						],
						
						'school_activities'	=>[
							"name"		=> $lang['hoat-dong-cua-truong'],
							"router"	=> 'school_activities',
							"icon"		=> '<i class="fas fa-user"></i>',
						],
						'opinion'	=>[
							"name"		=> $lang['gop-y-cua-phu-huynh'],
							"router"	=> 'opinion',
							"icon"		=> '<i class="fas fa-user"></i>',
						],
					],
					"controllers"=>"controllers/core/learning_outcomes.php",
					"hidden"=>'false',
					"main"=>'false',
					"colspan"=>'1',
					"permission"=>[
						
						'school_announcement'=>$lang['thong-bao-cua-truong'],
						'school_announcement.add' => $lang['them'].$lang['thong-bao-cua-truong'],
						'school_announcement.edit'=>$lang['sua'].$lang['thong-bao-cua-truong'],
						'school_announcement.delete'=>$lang['xoa'].$lang['thong-bao-cua-truong'],
						'teacher_announcement'=>$lang['thong-bao-cua-thay-co'],
						'teacher_announcement.add' => $lang['them'].$lang['thong-bao-cua-thay-co'],
						'teacher_announcement.edit'=>$lang['sua'].$lang['thong-bao-cua-thay-co'],
						'teacher_announcement.delete'=>$lang['xoa'].$lang['thong-bao-cua-thay-co'],
						
						'school_activities'=>$lang['hoat-dong-cua-truong'],
						'school_activities.add' => $lang['them'].$lang['hoat-dong-cua-truong'],
						'school_activities.edit'=>$lang['sua'].$lang['hoat-dong-cua-truong'],
						'school_activities.delete'=>$lang['xoa'].$lang['hoat-dong-cua-truong'],	
						'opinion'=>$lang['gop-y-cua-phu-huynh'],
						
					]
				],
				'tuitions'	=>[	
					"menu"	=>	$lang['hoc-phi'],
					"url"	=>	'/tuitions/tuition/',
					"icon"	=>	'<i class="fas fa-door-open"></i>',
					"sub"=>[	
						'tuition_order'	=>[
							"name"		=> $lang['thu-hoc-phi'],
							"router"	=> 'tuition_order',
							"icon"		=> '<i class="fas fa-globe"></i>',
						],
						'content_tuition'	=>[
							"name"		=> $lang['thong-tin-hoc-phi'],
							"router"	=> 'content_tuition-class',
							"icon"		=> '<i class="fas fa-globe"></i>',
						],				
						'tuition'	=>[
							"name"		=>  $lang['hoa-don-thu-hoc-phi'],
							"router"	=> 'tuition',
							"icon"		=> '<i class="fas fa-globe"></i>',
						],
						'revenue'	=> [
							"name"		=> $lang['doanh-thu'],
							"router"	=> 'revenue',
							"icon"		=> '<i class="	fas fa-user-friends"></i>',
						],		
						'tuition_debt'	=> [
							"name"		=> $lang['cong-no-hoc-sinh'],
							"router"	=> 'tuition_debt',
							"icon"		=> '<i class="	fas fa-user-friends"></i>',
						],	
						
						'expenditure'	=> [
							"name"		=> $lang['so-thu-chi'],
							"router"	=> 'expenditure',
							"icon"		=> '<i class="	fas fa-user-friends"></i>',
						],	
						'type-payments'	=> [
							"name"		=> $lang['hinh-thuc-thanh-toan'].'<small class="text-danger">*</small>',
							"router"	=> 'type-payments',
							"icon"		=> '<i class="	fas fa-user-friends"></i>',
						],			
						
					],
					"controllers"=>"controllers/core/tuitions.php",
					"hidden"=>'false',
					"main"=>'false',
					"colspan"=>'1',
					"permission"=>[		
						'tuition'=>$lang['hoa-don-thu-hoc-phi'],
						'tuition_order'=>$lang['thu-hoc-phi'],
						'tuition_order_detail'=>$lang['chi-tiet-thanh-toan'],
						'tuition.add' => $lang['them'].$lang['hoa-don-thu-hoc-phi'],
						'tuition.edit'=>$lang['sua'].$lang['hoa-don-thu-hoc-phi'],
						'tuition.delete'=>$lang['xoa'].$lang['hoa-don-thu-hoc-phi'],		
						'revenue'=>$lang['doanh-thu'],
						
						'content_tuition-class'=>$lang['thong-tin-hoc-phi-theo-nam'],
						'content_tuition'=>$lang['thong-tin-hoc-phi'],
						'content_tuition.add' => $lang['them'].$lang['thong-tin-hoc-phi'],
						'content_tuition.edit'=>$lang['sua'].$lang['thong-tin-hoc-phi'],
						'content_tuition.delete'=>$lang['xoa'].$lang['thong-tin-hoc-phi'],
						
						'tuition_debt'=>$lang['cong-no-hoc-sinh'],
						'tuition_debt_detail'=>$lang['xem-chi-tiet-cong-no'],
						'expenditure'=>$lang['so-thu-chi'],
						'expenditure.add' => $lang['them'].$lang['so-thu-chi'],
						'expenditure.edit'=>$lang['sua'].$lang['so-thu-chi'],
						'expenditure.delete'=>$lang['xoa'].$lang['so-thu-chi'],
						'type-payments'=>$lang['hinh-thuc-thanh-toan'],
						'type-payments.add' => $lang['them'].$lang['hinh-thuc-thanh-toan'],
						'type-payments.edit'=>$lang['sua'].$lang['hinh-thuc-thanh-toan'],
						'type-payments.delete'=>$lang['xoa'].$lang['hinh-thuc-thanh-toan'],
				
					]
				],
				'car_driver'	=>[	
					"menu"	=>	$lang['dich-vu'],
					"url"	=>	'/car_driver/car_driver/',
					"icon"	=>	'<i class="fas fa-door-open"></i>',
					"sub"=>[	
						'car_schedule'	=>[
							"name"		=> $lang['xep-xe'],
							"router"	=> 'car_schedule',
							"icon"		=> '<i class="fas fa-globe"></i>',
						],
						'student_register_car'	=>[
							"name"		=> $lang['dang-ki-dua-ruoc'],
							"router"	=> 'student_register_car',
							"icon"		=> '<i class="fas fa-globe"></i>',
						],
						'car'	=>[
							"name"		=> $lang['phuong-tien'].'<small class="text-danger">*</small>',
							"router"	=> 'car',
							"icon"		=> '<i class="fas fa-globe"></i>',
						],	
						'driver'	=>[
							"name"		=> $lang['tai-xe'].'<small class="text-danger">*</small>',
							"router"	=> 'driver',
							"icon"		=> '<i class="fas fa-globe"></i>',
						],
							
						'route'	=>[
							"name"		=> $lang['tuyen-duong'].'<small class="text-danger">*</small>',
							"router"	=> 'route',
							"icon"		=> '<i class="fas fa-globe"></i>',
						],	
						'schedule_driver'	=>[
							"name"		=> $lang['lich-xe-cua-tai-xe'],
							"router"	=> 'schedule_driver',
							"icon"		=> '<i class="fas fa-globe"></i>',
						],
						
					],
					"controllers"=>"controllers/core/car_driver.php",
					"hidden"=>'false',
					"main"=>'false',
					"colspan"=>'1',
					"permission"=>[		
						'car'=>$lang['phuong-tien'],
						'car.add' => $lang['them'].$lang['phuong-tien'],
						'car.edit'=>$lang['sua'].$lang['phuong-tien'],
						'car.delete'=>$lang['xoa'].$lang['phuong-tien'],	
						'driver'=>$lang['tai-xe'],
						'driver.add' => $lang['them'].$lang['tai-xe'],
						'driver.edit'=>$lang['sua'].$lang['tai-xe'],
						'driver.delete'=>$lang['xoa'].$lang['tai-xe'],
						'student_register_car'=>$lang['dang-ki-dua-ruoc'],
						'student_register_car.add' => $lang['them'].$lang['dang-ki-dua-ruoc'],
						'student_register_car.edit'=>$lang['sua'].$lang['dang-ki-dua-ruoc'],
						'student_register_car.delete'=>$lang['xoa'].$lang['dang-ki-dua-ruoc'],
						'route'=>$lang['tuyen-duong'],
						'route.add' => $lang['them'].$lang['tuyen-duong'],
						'route.edit'=>$lang['sua'].$lang['tuyen-duong'],
						'route.delete'=>$lang['xoa'].$lang['tuyen-duong'],
						'car_schedule'=>$lang['xep-xe'],
						'car_schedule.add' => $lang['them'].$lang['xep-xe'],
						'car_schedule.edit'=>$lang['sua'].$lang['xep-xe'],
						'car_schedule.delete'=>$lang['xoa'].$lang['xep-xe'],
						'car_schedule_detail'=>$lang['danh-sach-hoc-sinh'],
						'car_schedule_detail.add' => $lang['them'].$lang['danh-sach-hoc-sinh'],
						'car_schedule_detail.edit' => $lang['sua'].$lang['danh-sach-hoc-sinh'],
						'car_schedule_detail.delete'=>$lang['xoa'].$lang['danh-sach-hoc-sinh'],
						'schedule_driver'=>$lang['lich-xe-cua-tai-xe'],
					]
				],
				'device'	=>[	
					"menu"	=>	$lang['thiet-bi'],
					"url"	=>	'/device/device/',
					"icon"	=>	'<i class="fas fa-door-open"></i>',
					"sub"=>[	
						'warehouse'	=>[
							"name"		=> $lang['kho-hang'],
							"router"	=> 'warehouse',
							"icon"		=> '<i class="fas fa-globe"></i>',
						],	
						'import_goods'	=>[
							"name"		=> $lang['nhap-hang'],
							"router"	=> 'import_goods',
							"icon"		=> '<i class="fas fa-globe"></i>',
						],	
						'export_goods'	=>[
							"name"		=> $lang['xuat-hang'],
							"router"	=> 'export_goods',
							"icon"		=> '<i class="fas fa-globe"></i>',
						],	
						'category_device'	=>[
							"name"		=> $lang['danh-muc-thiet-bi'].'<small class="text-danger">*</small>',
							"router"	=> 'category_device',
							"icon"		=> '<i class="fas fa-globe"></i>',
						],	
						'supplier'	=>[
							"name"		=> $lang['nha-cung-cap'].'<small class="text-danger">*</small>',
							"router"	=> 'supplier',
							"icon"		=> '<i class="fas fa-globe"></i>',
						],
						'units'	=>[
							"name"		=> $lang['don-vi'].'<small class="text-danger">*</small>',
							"router"	=> 'units',
							"icon"		=> '<i class="fas fa-globe"></i>',
						],				
						
					],
					"controllers"=>"controllers/core/device.php",
					"hidden"=>'false',
					"main"=>'false',
					"colspan"=>'1',
					"permission"=>[		
						'warehouse'=>$lang['kho-hang'],
						'warehouse.add' => $lang['them'].$lang['kho-hang'],
						'warehouse.edit'=>$lang['sua'].$lang['kho-hang'],
						'warehouse.delete'=>$lang['xoa'].$lang['kho-hang'],
						'import_goods'=>$lang['nhap-hang'],
						'import_goods.add' => $lang['them'].$lang['nhap-hang'],
						'import_goods.edit'=>$lang['sua'].$lang['nhap-hang'],
						'import_goods.delete'=>$lang['xoa'].$lang['nhap-hang'],
						'export_goods'=>$lang['xuat-hang'],
						'export_goods.add' => $lang['them'].$lang['xuat-hang'],
						'export_goods.edit'=>$lang['sua'].$lang['xuat-hang'],
						'export_goods.delete'=>$lang['xoa'].$lang['xuat-hang'],
						'category_device'=>$lang['danh-muc-thiet-bi'],
						'supplier'=>$lang['nha-cung-cap'],
						'supplier.add' => $lang['them'].$lang['nha-cung-cap'],
						'supplier.edit'=>$lang['sua'].$lang['nha-cung-cap'],
						'supplier.delete'=>$lang['xoa'].$lang['nha-cung-cap'],
						'units'=>$lang['don-vi'],
						'units.add' => $lang['them'].$lang['don-vi'],
						'units.edit'=>$lang['sua'].$lang['don-vi'],
						'units.delete'=>$lang['xoa'].$lang['don-vi'],
						
					]
				],
				'personel'	=>[	
					"menu"	=>	$lang['nhan-su'],
					"url"	=>	'/personel/personel/',
					"icon"	=>	'<i class="fas fa-door-open"></i>',
					"sub"=>[
						
						'teachers'	=> [
							"name"		=> $lang['giao-vien'],
							"router"	=> 'teachers',
							"icon"		=> '<i class="fas fa-chalkboard-teacher"></i>',
						],
						'timekeeping_teachers'	=> [
							"name"		=> $lang['diem-danh-giao-vien'],
							"router"	=> 'timekeeping_teachers',
							"icon"		=> '<i class="fas fa-braille"></i>',
						],
						'personels'	=> [
							"name"		=> $lang['nhan-vien'],
							"router"	=> 'personels',
							"icon"		=> '<i class="fas fa-chalkboard-teacher"></i>',
						],
						'timekeeping_personels'	=> [
							"name"		=> $lang['diem-danh-nhan-vien'],
							"router"	=> 'timekeeping_personels',
							"icon"		=> '<i class="fas fa-braille"></i>',
						],
						'regent'	=> [
							"name"		=> $lang['chuc-vu'].'<small class="text-danger">*</small>',
							"router"	=> 'regent',
							"icon"		=> '<i class="fas fa-braille"></i>',
						],
						
					],
					"controllers"=>"controllers/core/personel.php",
					"hidden"=>'false',
					"main"=>'false',
					"colspan"=>'1',
					"permission"=>[
						'teachers'=>$lang['giao-vien'],
						'teachers.add' => $lang['them'].$lang['giao-vien'],
						'teachers.edit'=>$lang['sua'].$lang['giao-vien'],
						'teachers.delete'=>$lang['xoa'].$lang['giao-vien'],
						'personels'=>$lang['nhan-vien'],
						'personels.add' => $lang['them'].$lang['nhan-vien'],
						'personels.edit'=>$lang['sua'].$lang['nhan-vien'],
						'personels.delete'=>$lang['xoa'].$lang['nhan-vien'],
						'timekeeping_teachers'=>$lang['diem-danh-gv'],
						'timekeeping_teachers.add' => $lang['them'].$lang['diem-danh-gv'],
						'timekeeping_teachers.edit'=>$lang['sua'].$lang['diem-danh-gv'],
						'timekeeping_teachers.delete'=>$lang['xoa'].$lang['diem-danh-gv'],
						'timekeeping_personels'=>$lang['diem-danh-nv'],
						'timekeeping_personels.add' => $lang['them'].$lang['diem-danh-nv'],
						'timekeeping_personels.edit'=>$lang['sua'].$lang['diem-danh-nv'],
						'timekeeping_personels.delete'=>$lang['xoa'].$lang['diem-danh-nv'],
						'regent'=>$lang['chuc-vu'],
						'regent.add' => $lang['them'].$lang['chuc-vu'],
						'regent.edit'=>$lang['sua'].$lang['chuc-vu'],
						'regent.delete'=>$lang['xoa'].$lang['chuc-vu'],

					]
				],
				'camera'	=>[	
					"menu"	=>	$lang['cam'],
					"url"	=>	'/camera/camera/',
					"icon"	=>	'<i class="fas fa-door-open"></i>',
					"sub"=>[
						'faceid'	=> [
							"name"		=> $lang['lich-su-nhan-dien'],
							"router"	=> 'faceid',
							"icon"		=> '<i class="fas fa-grin-hearts"></i>',
						],
						'check_cam'	=> [
							"name"		=> $lang['nhan-dien-phu-huynh'],
							"router"	=> 'check_cam',
							"icon"		=> '<i class="fas fa-grin-hearts"></i>',
						],
						'camera_channel'	=> [
							"name"	=> $lang['kenh-camera'],
							"router"	=> 'camera_channel',
							"icon"	=> '<i class="fas fa-grin-hearts"></i>',
						],
						'camera_setting'	=> [
							"name"	=> $lang['cau-hinh-camera'],
							"router"	=> 'camera_setting',
							"icon"	=> '<i class="fas fa-grin-hearts"></i>',
						],
						
					],
					"controllers"=>"controllers/core/camera.php",
					"hidden"=>'false',
					"main"=>'false',
					"colspan"=>'1',
					"permission"=>[
						'faceid'=>$lang['lich-su-nhan-dien'],
						'check_cam'=>$lang['nhan-dien-phu-huynh'],
						'camera_channel'=>$lang['kenh-camera'],
						'camera_channel.add' => $lang['them'].$lang['kenh-camera'],
						'camera_channel.edit'=>$lang['sua'].$lang['kenh-camera'],
						'camera_channel.delete'=>$lang['xoa'].$lang['kenh-camera'],
						'camera_setting'=>$lang['cau-hinh-camera'],
						'camera_setting.add' => $lang['them'].$lang['cau-hinh-camera'],
						'camera_setting.edit'=>$lang['sua'].$lang['cau-hinh-camera'],
						'camera_setting.delete'=>$lang['xoa'].$lang['cau-hinh-camera'],
					]
				],
			],
		],
		"page"=>[
			"name"=>$lang['quan-tri'],
			"item"=>[
				'users'=>[
					"menu"=>$lang['nguoi-dung'],
					"url"=>'/users/accounts/',
					"icon"=>'<i class="fas fa-user "></i>',
					"sub"=>[
						'accounts'		=>[
							"name"	=> $lang['tai-khoan'],
							"router"=> 'accounts',
							"icon"	=> '<i class="fas fa-user"></i>',
						],
						'permission'	=>[
							"name"	=> $lang['nhom-quyen'].'<small class="text-danger">*</small>',
							"router"=> 'permission',
							"icon"	=> '<i class="fas fa-universal-access"></i>',
						],
							
					],
					"controllers"=>"controllers/core/users.php",
					"hidden"=>'false',
					"main"=>'false',
					"colspan"=>'1',
					"permission"=>[
						'accounts'=>$lang['tai-khoan'],
						'accounts.add' => $lang['them'].$lang['tai-khoan'],
						'accounts.edit'=>$lang['sua'].$lang['tai-khoan'],
						'accounts.delete'=>$lang['xoa'].$lang['tai-khoan'],
						'permission'=>$lang['nhom-quyen'],
						'permission.add' =>$lang['them'].$lang['nhom-quyen'],
						'permission.edit'=>$lang['sua'].$lang['nhom-quyen'],
						'permission.delete'=>$lang['xoa'].$lang['nhom-quyen'],		
						
					]
				],
				'admin'	=>[	
					"menu"=>$lang['quan-tri'],
					"url"=>'/admin/logs/',
					"icon"=>'<i class="fas fa-cog "></i>',
					"sub"=>[
						'flood'	=> [
							"name"	=> $lang['danh-sach-chan'],
							"router"	=> 'flood',
							"icon"	=> '<i class="fas fa-shield-alt"></i>',
						],
						'blockip'	=> [
							"name"	=> $lang['chan-truy-cap'],
							"router"	=> 'blockip',
							"icon"	=> '<i class="fas fa-ban"></i>',
						],
						'notification'	=> [
							"name"	=> $lang['thong-bao'],
							"router"	=> 'notification',
							"icon"	=> '<i class="far fa-bell"></i>',
						],
						'logs'	=> [
							"name"	=> $lang['nhat-ky'],
							"router"	=> 'logs',
							"icon"	=> '<i class="fa fa-list-alt"></i>',
						],
						'config'	=> [
							"name"	=> $lang['cau-hinh'].'<small class="text-danger">*</small>',
							"router"	=> 'config',
							"icon"	=> '<i class="fa fa-cog"></i>',
							"req"	=> 'modal-url',
						],
					],
					"controllers"=>"controllers/core/admin.php",
					"hidden"=>'false',
					"main"=>'false',
					"colspan"=>'1',
					"permission"=>[
						'faceid'		=>$lang['nhat-ky-nhan-dien'],
						'flood'			=>$lang['danh-sach-chan'],
						'flood.delete'			=>$lang['xoa'].$lang['danh-sach-chan'],
						'blockip'		=>$lang['chan-truy-cap'],
						'blockip.add' => $lang['them'].$lang['chan-truy-cap'],
						'blockip.edit'=>$lang['sua'].$lang['chan-truy-cap'],
						'blockip.delete'=>$lang['xoa'].$lang['chan-truy-cap'],
						'calendar' => $lang['lich'],
						'notification'	=>$lang['thong-bao'],
						'config'	=>$lang['cau-hinh'],
						'logs'		=>$lang['nhat-ky'],
					]
				],

			],
		],
	];

	$expenditure_type = [
		"1"=>[
			"name"=>$lang['thu'],
			"id"=>1,
		],
		"2"=>[
			"name"=>$lang['chi'],
			"id"=>2,
		],
	];
	$proposal_type = [
		"1"=>[
			"name"=>$lang['thu'],
			"id"=>1,
		],
		"2"=>[
			"name"=>$lang['chi'],
			"id"=>2,
		],
		"3"=>[
			"name"=>$lang['khac'],
			"id"=>3,
		],
	];
	$idtypes = [
		"1"=>[
			"name"=>$lang['cmnd'],
			"id"=>1,
		],
		"2"=>[
			"name"=>$lang['cccd'],
			"id"=>2,
		],
		"3"=>[
			"name"=>$lang['cccd-gan-chip'],
			"id"=>3,
		],
		"4"=>[
			"name"=>$lang['passport'],
			"id"=>4,
		],
	];
	$personnels_contracts = [
		"1"=>[
			"name"=>$lang['thu-viec'],
			"id"=>1,
		],
		"2"=>[
			"name"=>$lang['chinh-thuc-lan-1'],
			"id"=>2,
		],
		"3"=>[
			"name"=>$lang['chinh-thuc-lan-2'],
			"id"=>3,
		],
		"4"=>[
			"name"=>$lang['khong-xac-dinh-thoi-han'],
			"id"=>4,
		],
	];
	$duration_types = [
		"1"=>[
			"name"=>$lang['gio'],
			"code"=>'hour',
			"id"=>1,
		],
		"2"=>[
			"name"=>$lang['phut'],
			"code"=>'minute',
			"id"=>2,
		],
		"3"=>[
			"name"=>$lang['ngay'],
			"code"=>'day',
			"id"=>3,
		],
		"4"=>[
			"name"=>$lang['thang'],
			"code"=>'month',
			"id"=>4,
		],
		"5"=>[
			"name"=>$lang['nam'],
			"code"=>'year',
			"id"=>5,
		],
	];
	$salarys_type_categorys = [
		"1"=>[
			"name"=>$lang['tien-luong'],
			"id"=>1,
		],
		"2"=>[
			"name"=>$lang['phu-cap'],
			"id"=>2,
		],
		"3"=>[
			"name"=>$lang['tang-ca'],
			"id"=>3,
		],
	];
	$customer_process = [
		"1"=>[
			"name"=>$lang['de-xuat'],
			"color"=>'danger',
			"id"=>1,
		],
		"2"=>[
			"name"=>$lang['da-duyet'],
			"color"=>'success',
			"id"=>2,
		],
		"3"=>[
			"name"=>$lang['khong-duyet'],
			"color"=>'dark',
			"id"=>3,
		],
	];
	$status_programs = [
		"1"=>[
			"name"=>$lang['ke-hoach'],
			"color"=>'warning',
			"id"=>1,
		],
		"2"=>[
			"name"=>$lang['hoan-thanh'],
			"color"=>'success',
			"id"=>2,
		],
	];
	$status_todo = [
		"1"=>[
			"name"=>$lang['chua-bat-dau'],
			"color"=>'danger',
			"id"=>1,
		],
		"2"=>[
			"name"=>$lang['thuc-hien'],
			"color"=>'primary',
			"id"=>2,
		],
		"3"=>[
			"name"=>$lang['hoan-thanh'],
			"color"=>'success',
			"id"=>3,
		],
	];
	$status_process = [
		"1"=>[
			"name"=>$lang['cho-duyet'],
			"color"=>'warning',
			"id"=>1,
		],
		"2"=>[
			"name"=>$lang['da-duyet'],
			"color"=>'success',
			"id"=>2,
		],
		"3"=>[
			"name"=>$lang['khong-duyet'],
			"color"=>'dark',
			"id"=>3,
		],
		"4"=>[
			"name"=>$lang['da-but-toan'],
			"color"=>'primary',
			"id"=>4,
		],
		"10"=>[
			"name"=>$lang['yeu-cau-huy'],
			"color"=>'danger',
			"id"=>10,
		],
		"20"=>[
			"name"=>$lang['da-huy'],
			"color"=>'secondary',
			"id"=>20,
		],
	];
	$ballot_code = [
		"projects"=> 'DA',
		"proposal"=> 'ĐX',
	];
	$priority_codes = [
		"1"=>[
			"name"=>$lang['thap'],
			"color"=>'primary',
			"id"=>1,
		],
		"2"=>[
			"name"=>$lang['trung-binh'],
			"color"=>'warning',
			"id"=>2,
		],
		"3"=>[
			"name"=>$lang['cao'],
			"color"=>'danger',
			"id"=>3,
		],
	];
	
	$task_repeat = [
		"0"=>[
			"name"=>$lang['mot-lan'],
			"color"=>'dark',
			"id"=>0,
		],
		"1"=>[
			"name"=>$lang['hang-ngay'],
			"color"=>'primary',
			"id"=>1,
		],
		"2"=>[
			"name"=>$lang['hang-tuan'],
			"color"=>'warning',
			"id"=>2,
		],
		"3"=>[
			"name"=>$lang['hang-thang'],
			"color"=>'success',
			"id"=>3,
		],
		"4"=>[
			"name"=>$lang['hang-nam'],
			"color"=>'danger',
			"id"=>4,
		],
		"5"=>[
			"name"=>$lang['ngay-trong-tuan'],
			"color"=>'info',
			"id"=>5,
		],
		"6"=>[
			"name"=>$lang['tuy-chon'],
			"color"=>'dark',
			"id"=>6,
		],
	];
	$payment_type = [
		"1"=>[
			"name"=>$lang['dong-hoc-phi'],
			"id"=>1,
		],
		"2"=>[
			"name"=>$lang['nhap-kho'],
			"id"=>2,
		],
	];
?>