<?php if($_SESSION['school']==0){?>
	<div class="modal fade modal-stores" tabindex="-1" data-bs-backdrop="static">
		<div class="modal-dialog modal-sm" style="max-width:500px">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><?=$lang['truong-hoc']?></h5>
				</div>
				<div class="modal-body p-1">
					<?php foreach ($schools as $school) { ?>
						<a class="dropdown-item pjax-load p-2 sales-change-stores border-bottom <?=$_SESSION['school']==$school['id']?'active':''?>" href="/change-school/<?=$school['id']?>/">
							<?=$school['name']?>

							<div class="small fst-italic" style="font-size: 10px;">
								<?=$school['name']?> - <?=$school['id_school']?>
							</div>

						</a>
					<?php } ?>

				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$('.modal-stores').modal('show');
		$('.sales-change-stores').on("click",function(){
			$('.modal-stores').modal('hide');
		});
	</script>
<?php } ?>
<?php if($router['1']=='teachers'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4>Danh sách Giáo viên</h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
				<li class="breadcrumb-item active" aria-current="page">Hồ sơ</li>
			</ol>
		</div>
	</nav>
	<?php if($jatbi->permission('teachers.add','button')==true || $jatbi->permission('teachers.delete','button')==true){?>
		<div class="fixed-action-btn">
			<a class="btn btn-large btn-primary rounded-circle">
				<i class="fas fa-bars" aria-hidden="true"></i>
			</a>
			<ul>
				<?php if($jatbi->permission('teachers.delete','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/personel/teachers-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
				<?php }?>
				<?php if($jatbi->permission('teachers.add','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-info" data-url="/personel/teachers-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
				<?php }?>
			</ul>
		</div>
	<?php }?>
	<div class="card card-custom">
		<div class="card-body">
			<form method="GET" class="pjax-content mb-4 search-form">
				<div class="form-group col-4">
					<input placeholder="<?=$lang['tim-kiem']?>" type="text" name="name" value="<?=$xss->xss($_GET['name'])?>" class="form-control">
				</div>
				<div class="form-group">
					<div class="dropdown">
						<button class="border dropdown-toggle w-100 filler" type="button" id="fillers" data-bs-auto-close="false" data-bs-toggle="dropdown" aria-expanded="false">
							<i class="fas fa-filter"></i> <?=$lang['them-dieu-kien-loc']?>
						</button>
						<div class="dropdown-menu filler-details p-3" aria-labelledby="fillers">
							<p class="mb-2"><?=$lang['tim-kiem-theo-dieu-kien']?></p>
							<!-- <div class="filer-item permission">
								<label><?=$lang['nhom-quyen']?></label>
								<select name="permission" class="select2 form-select" style="width:100%">
									<option value=""><?=$lang['tat-ca']?></option>
									<?php foreach ($permissions as $permission) { ?>
										<option value="<?=$permission['id']?>"  <?=($xss->xss($_GET['permission'])==$permission['id']?'selected':'')?>><?=$permission['name']?></option>
									<?php } ?>
								</select>
							</div> -->
							<div class="filer-item status">
								<label><?=$lang['trang-thai']?></label>
								<select name="status" class="select2 form-control" style="width:100%">
									<option value=""><?=$lang['tat-ca']?></option>
									<option value="A" <?=($_GET['status']=='A'?'selected':'')?>><?=$lang['kich-hoat']?></option>
									<option value="D" <?=($_GET['status']=='D'?'selected':'')?>><?=$lang['khong-kich-hoat']?></option>
								</select>
							</div>
							<div class="d-flex justify-content-between align-items-center mt-3">
								<button type="button" class="btn btn-secondary filler-cancel"><?=$lang['huy']?></button>
								<button class="btn btn-primary filler-add"><?=$lang['them-dieu-kien']?></button>
							</div>
						</div>
					</div>
				</div>
			</form>
			<div class="pjax-content-load">
				<div class="table-responsive">
					<table class="table table-striped table-hover align-middle">
						<thead>
							<tr>
								<?php if($jatbi->permission('teachers.delete','button')==true){?>
									<th width="1%" class="text-center">
										<div class="form-check">
											<input class="form-check-input selectall" type="checkbox" value="" id="all">
											<label class="form-check-label" for="all">
											</label>
										</div>
									</th>
								<?php }?>
								<th width="50"></th>

								<th><?=$lang['ho']?></th>
								<th><?=$lang['ten']?></th>
								<th><?=$lang['ngay-sinh']?></th>
								<th><?=$lang['so-dien-thoai']?></th>
								<th><?=$lang['gioi-tinh']?></th>				        					        
								<th><?=$lang['chuc-vu']?></th>

								<th><?=$lang['trang-thai']?></th>
								<?php if($jatbi->permission('teachers.edit','button')==true){?>
									<th width="2%"></th>
								<?php }?>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($datas as $data) {
							if($data['lastname']!=""){ ?>
								<tr>
									<?php if($jatbi->permission('teachers.delete','button')==true){?>
										<td class="align-middle">
											<div class="form-check">
												<input class="form-check-input checker" type="checkbox" id="<?=$data['id']?>" name="BOX[<?=$data['id']?>]" value="<?=$data['id']?>">
												<label class="form-check-label" for="<?=$data['id']?>"></label>
											</div>
										</td>
									<?php }?>
									<td></td>

									<td><?=$data['firstname']?></td>
									<td><?=$data['lastname']?></td>
									<td><?=date("d/m/Y", strtotime($data['birthday']))?></td>
									<td><?=$data['phone_number']?></td>	
									<td><?=$data['gender']?></td>	
									<td><?=$database->get("regent","name",['id'=>$database->get("school_teacher","regent",["school"=>$_SESSION['school'],'teacher'=>$data['id']])])?></td>			          
									<td>	
										<div class="form-check form-switch">
											<input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/personel/teachers-status/<?=$data['id']?>/">
											<label class="form-check-label" for="status"></label>
										</div>
									</td>
									<td>
				            		<a class="btn btn-sm btn-light modal-url <?=$data['face']==0?'text-dark':'text-success'?>" aria-hidden="true" data-url="/personel/teacher-face/<?=$data['id']?>/"><i class="fas fa-grin-hearts"></i></a>
				            	</td>
									<?php if($jatbi->permission('teachers.edit','button')==true){?>
										<td>
				            		<a href="#!" data-url="/personel/teachers-face-delete/<?=$data['id']?>/" class="modal-url"><i class="fas fa-meh-blank"></i></a>
				            					            </td>
										<td>
											<a class="btn btn-sm btn-light modal-url" data-url="/personel/teachers-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
										</td>
									<?php }?>
								</tr>
							<?php } ?>
							<?php } ?>
						</tbody>
					</table>
				</div>
				<nav class="d-flex justify-content-between align-items-center paginations" aria-label="Page navigation">
					<?=$page?>
				</nav>
			</div>
		</div>
	</div>
<?php } ?>
<?php if($router['1']=='teacher-face'){?>
	<div class="modal fade modal-load" tabindex="-1">
	  <div class="modal-dialog" >
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title"><?=$lang['nhan-dien-nhan-vien']?></h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
	      <div class="modal-body preview-images ">
	      	<div class="row">
	      		<div class="col-md-12">
		        	<div class="form-group row">
		        		<label class="col-sm-12"><?=$lang['hinh-anh']?> <?=$array?></label>
		        		<div class="col-sm-12">
				    		<div id="camera" class="w-100"></div>
		        			<div class="w-100 d-block">
			        			<?php if($data['face']==1){?>
						    		<img src="<?=$data['avatar']?>" class="preview-data w-100">
						    	<?php } else { ?>
						    		<img src="" class="preview-data w-100">
						    		
						    	<?php } ?>
					    	</div>
					    	<div>
					    		<?=$data['lastname']?>
					    	</div>
					    	
				    	</div>
			    	</div>
		        </div>
		        <div class="mb-3">
					<input type="file" class="form-control getImg" name="avatar">
			    </div>
		    </div>
	      </div>
	      <div class="modal-footer">
	      	<input type="hidden" name="token" value="<?=$_SESSION['csrf']['token']?>">
	      	<!-- <input type="hidden" name="images" value="" class="input-image"> -->
		    <!-- <button type="button" class="btn btn-danger click-image pull-left"><?=$lang['chup-anh']?></button> -->
	        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?=$lang['huy']?></button>
		    <button type="submit" class="btn btn-primary ajax-submit">
		    	<div class="spinner-button" style="display: none">
			    	<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
			    	<span class="me-1"><?=$lang['dang-tai']?></span>
			    </div>
		    	<span class="name-button"><?=$lang['hoan-tat']?></span>
		    </button>
	      </div>
	  	  </form>
	    </div>
	  </div>
	</div>
	<script language="JavaScript">
		Webcam.set({
			width: '720',
			height: '415',
			dest_width: 1280,
			dest_height: 738,
			image_format:'jpeg',
			jpeg_quality: 100,
			flip_horiz: false,
			constraints: {
				facingMode: 'environment', // user
			}
		});
		Webcam.attach('#camera');
		$('.click-image').on("click",function(){
			Webcam.snap( function(data) {
				$('.customer-image').attr("src",data);
				$('.input-image').val(data);
			} );
		});
	</script>
<?php } ?>
<?php if($router['1']=='teachers-add' || $router['1']=='teachers-edit'){?>
	<div class="modal fade modal-load" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><?=$router['1']=='teachers-add'?$lang['them']:$lang['sua']?> Giáo viên</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
					<div class="modal-body">
						<div class="row">
							<div class="col-sm-6">
								<div class="mb-3">
									<label>Mã giáo viên<small class="text-danger">*</small></label>
									<input placeholder="Mã giáo viên" type="text" name="id_teacher" value="<?=$data_teacher_school['id_teacher']?>" class="form-control">
								</div>
								<div class="mb-3">
									<label>Họ <small class="text-danger">*</small></label>
									<input placeholder="Họ" type="text" name="firstname" value="<?=$data['firstname']?>" class="form-control">
								</div>
								<div class="mb-3">
									<label><?=$lang['ten']?> <small class="text-danger">*</small></label>
									<input placeholder="<?=$lang['ten']?>" type="text" name="lastname" value="<?=$data['lastname']?>" class="form-control">
								</div>
								<div class="mb-3">
									<label><?=$lang['sinh-nhat']?></label>
									<input placeholder="<?=$lang['sinh-nhat']?>" type="date" name="birthday" value="<?=$data['birthday']?>" class="form-control">
								</div>	
								<div class="mb-3">
									<label><?=$lang['cccd']?> <small class="text-danger">*</small></label>
									<input placeholder="<?=$lang['cccd']?>" type="text" name="citizenId" value="<?=$data['citizenId']?>" class="form-control">
								</div>			    
								<div class="mb-3">
									<label>Số điện thoại</label>
									<input placeholder="Số điện thoại" type="text" name="phone_number" value="<?=$data['phone_number']?>" class="form-control">
								</div>	
								<div class="mb-3">
									<label><?=$lang['mat-khau']?><small class="text-danger">*</small></label>
									<input placeholder="<?=$lang['mat-khau']?>" type="password" name="password" class="form-control">
								</div>
								<div class="mb-3">
									<label>Email</label>
									<input placeholder="email" type="text" name="email" value="<?=$data['email']?>" class="form-control">
								</div>
								<div class="mb-3">
									<label>Giới tính <small class="text-danger">*</small></label>
									<select name="gender" class="select2 form-control" style="width:100%">
										<?php if(isset($data['gender'])){ ?>
											<option value="<?=$data['gender']?>"  selected ><?=$data['gender']?></option>
										<?php } else {?>
											<option value="" disabled selected >Chọn</option>
										<?php } ?>					   
										<option value="Nam" >Nam</option>
										<option value="Nữ" >Nữ</option>						    
									</select>
								</div>
								<div class="mb-3">
									<label>Học hàm<small class="text-danger">*</small></label>
									<select name="academic_function" class="select2 form-control" style="width:100%">
										<?php if(isset($data['academic_function'])){ ?>
											<option value="<?=$data['academic_function']?>" selected ><?=$data['academic_function']?></option>
										<?php } else {?>
											<option value="" disabled selected >Chọn</option>
										<?php } ?>					   						    
										<option value="Giáo sư" >Giáo sư</option>
										<option value="Phó giáo sư" >Phó giáo sư</option>
										<option value="Tiến sĩ" >Tiến sĩ</option>
										<option value="Thạc sĩ" >Thạc sĩ</option>
										<option value="Cử nhân" >Cử nhân</option>
										<option value="Kỹ sư" >Kỹ sư</option>
										<option value="Nghiên cứu sinh" >Nghiên cứu sinh</option>
										<option value="Thực tập sinh" >Thực tập sinh</option>						    
									</select>
								</div>
								<div class="mb-3">
									<label><?=$lang['ma-bao-hiem-y-te']?><small class="text-danger">*</small></label>
									<input placeholder="<?=$lang['ma-bao-hiem-y-te']?>" type="text" name="health_insurance_id" value="<?=$data['health_insurance_id']?>" class="form-control">
								</div>
								<div class="mb-3">
									<label><?=$lang['ma-bao-hiem-than-the']?><small class="text-danger">*</small></label>
									<input placeholder="<?=$lang['ma-bao-hiem-than-the']?>" type="text" name="body_insurance_id" value="<?=$data['body_insurance_id']?>" class="form-control">
								</div>
								<div class="mb-3">
									<label>Ngày bắt đầu làm việc</label>
									<input placeholder="Ngày nhập học" type="date" name="date_start_work" value="<?=$data_teacher_school['date_start_work']?>" class="form-control">
								</div>
							</div>
							<div class="col-sm-6">

								<div class="mb-3">
									<label>Địa chỉ <small class="text-danger">*</small></label>
									<input placeholder="Địa chỉ" type="text" name="address" value="<?=$data['address']?>" class="form-control">
								</div>

								<div class="select-areas">
									<div class="mb-3">
										<label><?=$lang['tinh-thanh']?></label>
										<select name="province" class="select2 form-control areas-province" style="width:100%">
											<option><?=$lang['tinh-thanh']?></option>
											<?php foreach ($provinces as $key => $province) { ?>
												<option value="<?=$province['id']?>" <?=$data['province']==$province['id']?'selected':''?> ><?=$province['name']?></option>
											<?php } ?>
										</select>
									</div>
									<div class="mb-3">
										<label><?=$lang['quan-huyen']?></label>
										<select name="district" class="select2 form-control areas-district" style="width:100%">
											<option><?=$lang['quan-huyen']?></option>
											<?php $districts = $database->select("district","*",["status"=>A,"deleted"=>0,"
											province"=>$data['province']])?>
											<?php foreach ($districts as $key => $district) { ?>
												<option value="<?=$district['id']?>" <?=$data['district']==$district['id']?'selected':''?>><?=$district['name']?></option>
											<?php } ?>
										</select>
									</div>
									<div class="mb-3">
										<label><?=$lang['phuong-xa']?></label>
										<select name="ward" class="select2 form-control areas-ward" style="width:100%">
											<option><?=$lang['phuong-xa']?></option>
											<?php $wards = $database->select("ward","*",["status"=>A,"deleted"=>0,"
											district"=>$data['district']])?>
											<?php foreach ($wards as $key => $ward) { ?>
												<option value="<?=$ward['id']?>" <?=$data['ward']==$ward['id']?'selected':''?>><?=$ward['name']?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<!-- <div class="mb-3">
									<label><?=$lang['hinh-dai-dien']?></label>
									<input type="file" class="form-control" name="avatar" value="<?=$data['avatar']?>">
								</div>	 -->
								<div class="mb-3">
									<label><?=$lang['quoc-tich']?><small class="text-danger">*</small></label>
									<select name="nationality" class="select2 form-control" style="width:100%">
										<option value="" disabled selected><?=$lang['quoc-tich']?></option>
										<?php foreach ($nationality as $nationality) { ?>
											<option value="<?=$nationality['id']?>"  <?=($data['nationality']==$nationality['id']?'selected':'')?>><?=$nationality['name']?></option>
										<?php } ?>
									</select>
								</div>
								<div class="mb-3">
									<label><?=$lang['dan-toc']?><small class="text-danger">*</small></label>
									<select name="ethnic" class="select2 form-control" style="width:100%">
										<option value="" disabled selected><?=$lang['dan-toc']?></option>
										<?php foreach ($ethnic as $ethnic) { ?>
											<option value="<?=$ethnic['id']?>"  <?=($data['ethnic']==$ethnic['id']?'selected':'')?>><?=$ethnic['name']?></option>
										<?php } ?>
									</select>
								</div>
								<div class="mb-3">
									<label><?=$lang['ton-giao']?><small class="text-danger">*</small></label>
									<select name="religion" class="select2 form-control" style="width:100%">
										<option value="" disabled selected><?=$lang['ton-giao']?></option>
										<?php foreach ($religion as $religion) { ?>
											<option value="<?=$religion['id']?>"  <?=($data['religion']==$religion['id']?'selected':'')?>><?=$religion['name']?></option>
										<?php } ?>
									</select>
								</div>	
								<div class="mb-3">
									<label>Phòng ban <small class="text-danger">*</small></label>
									<select name="department" class="select2 form-control" style="width:100%">
										<option value="" disabled selected>Phòng ban</option>
										<?php foreach ($department as $department) { ?>
											<option value="<?=$department['id']?>"  <?=($data_teacher_school['department']==$department['id']?'selected':'')?>><?=$department['name']?></option>
										<?php } ?>
									</select>
								</div>
								<div class="mb-3">
									<label>Chức vụ<small class="text-danger">*</small></label>
									<select name="regent" class="select2 form-control" style="width:100%">
										<option value="" disabled selected>Chức vụ</option>
										<?php foreach ($regent as $regent) { ?>
											<option value="<?=$regent['id']?>"  <?=($data_teacher_school['regent']==$regent['id']?'selected':'')?>><?=$regent['name']?></option>
										<?php } ?>
									</select>
								</div>
								<div class="mb-3">
									<label>Chuyên môn<small class="text-danger">*</small></label>
									<select name="subject" class="select2 form-control" style="width:100%">
										<option value="" disabled selected>Chuyên môn</option>
										<?php foreach ($subject as $subject) { ?>
											<option value="<?=$subject['id']?>"  <?=($data_teacher_school['subject']==$subject['id']?'selected':'')?>><?=$subject['name']?></option>
										<?php } ?>
									</select>
								</div>	    
								<div class="mb-3">
									<label><?=$lang['trang-thai']?> <small class="text-danger">*</small></label>
									<select name="status" class="select2 form-control" style="width:100%">
										<option value="A" <?=($data['status']=='A'?'selected':'')?>><?=$lang['kich-hoat']?></option>
										<option value="D" <?=($data['status']=='D'?'selected':'')?>><?=$lang['khong-kich-hoat']?></option>
									</select>
								</div>
							</div>

						</div>
					</div>
					<div class="modal-footer">
						<input type="hidden" name="token" value="<?=$_SESSION['csrf']['token']?>">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?=$lang['huy']?></button>
						<button type="submit" class="btn btn-primary ajax-submit">
							<div class="spinner-button" style="display: none">
								<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
								<span class="me-1"><?=$lang['dang-tai']?></span>
							</div>
							<span class="name-button"><?=$lang['hoan-tat']?></span>
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$(document).on("change",".type-data",function() {
			if($(this).val()==2){
				$(".data").show();
			}
			else {
				$(".data").hide();
			}
		})
	</script>
<?php } ?>
<?php if($router['1']=='teachers-delete' || $router['1']=='teachers-face-delete'){?>
	<div class="modal fade modal-load" tabindex="-1">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-body text-center">
					<i class="fas fa-exclamation-triangle remove-error text-danger p-3" aria-hidden="true" style="font-size:50px;"></i>
					<p><strong><?=$lang['ban-muon-xoa']?></strong></p>
					<p><?=$lang['noi-dung-ban-muon-xoa']?></p>
					<form method="POST" autocomplete="off" class="ajax-form">
						<input type="hidden" name="submit">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?=$lang['huy']?></button>
						<input type="submit" value="<?=$lang['dong-y']?>" class="btn btn-danger ajax-submit">
					</form>
				</div>
			</div>
		</div>
	</div>
<?php } ?>
<?php if($router['1']=='personels'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['danh-sach-nhan-vien']?></h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
				<li class="breadcrumb-item active" aria-current="page"><?=$lang['nhan-su']?></li>
			</ol>
		</div>
	</nav>
	<?php if($jatbi->permission('personels.add','button')==true || $jatbi->permission('personels.delete','button')==true){?>
		<div class="fixed-action-btn">
			<a class="btn btn-large btn-primary rounded-circle">
				<i class="fas fa-bars" aria-hidden="true"></i>
			</a>
			<ul>
				<?php if($jatbi->permission('personels.delete','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/personel/personels-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
				<?php }?>
				<?php if($jatbi->permission('personels.add','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-info" data-url="/personel/personels-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
				<?php }?>
			</ul>
		</div>
	<?php }?>
	<div class="card card-custom">
		<div class="card-body">
			<form method="GET" class="pjax-content mb-4 search-form">
				<div class="form-group col-4">
					<input placeholder="<?=$lang['tim-kiem']?>" type="text" name="name" value="<?=$xss->xss($_GET['name'])?>" class="form-control">
				</div>
				<div class="form-group">
					<div class="dropdown">
						<button class="border dropdown-toggle w-100 filler" type="button" id="fillers" data-bs-auto-close="false" data-bs-toggle="dropdown" aria-expanded="false">
							<i class="fas fa-filter"></i> <?=$lang['them-dieu-kien-loc']?>
						</button>
						<div class="dropdown-menu filler-details p-3" aria-labelledby="fillers">
							<p class="mb-2"><?=$lang['tim-kiem-theo-dieu-kien']?></p>
							<!-- <div class="filer-item permission">
								<label><?=$lang['nhom-quyen']?></label>
								<select name="permission" class="select2 form-select" style="width:100%">
									<option value=""><?=$lang['tat-ca']?></option>
									<?php foreach ($permissions as $permission) { ?>
										<option value="<?=$permission['id']?>"  <?=($xss->xss($_GET['permission'])==$permission['id']?'selected':'')?>><?=$permission['name']?></option>
									<?php } ?>
								</select>
							</div> -->
							<div class="filer-item status">
								<label><?=$lang['trang-thai']?></label>
								<select name="status" class="select2 form-control" style="width:100%">
									<option value=""><?=$lang['tat-ca']?></option>
									<option value="A" <?=($_GET['status']=='A'?'selected':'')?>><?=$lang['kich-hoat']?></option>
									<option value="D" <?=($_GET['status']=='D'?'selected':'')?>><?=$lang['khong-kich-hoat']?></option>
								</select>
							</div>
							<div class="d-flex justify-content-between align-items-center mt-3">
								<button type="button" class="btn btn-secondary filler-cancel"><?=$lang['huy']?></button>
								<button class="btn btn-primary filler-add"><?=$lang['them-dieu-kien']?></button>
							</div>
						</div>
					</div>
				</div>
			</form>
			<div class="pjax-content-load">
				<div class="table-responsive">
					<table class="table table-striped table-hover align-middle">
						<thead>
							<tr>
								<?php if($jatbi->permission('personels.delete','button')==true){?>
									<th width="1%" class="text-center">
										<div class="form-check">
											<input class="form-check-input selectall" type="checkbox" value="" id="all">
											<label class="form-check-label" for="all">
											</label>
										</div>
									</th>
								<?php }?>
								<th width="50"></th>
								<th><?=$lang['ten']?></th>
								<th><?=$lang['nam-sinh']?></th>
								<th><?=$lang['cccd']?></th>
								<th><?=$lang['gioi-tinh']?></th>				        					        
								<th><?=$lang['so-dien-thoai']?></th>
								<th><?=$lang['loai']?></th>	
								<th><?=$lang['trang-thai']?></th>
								<?php if($jatbi->permission('personels.edit','button')==true){?>
									<th width="2%"></th>
								<?php }?>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($datas as $data) { ?>
								<tr>
									<?php if($jatbi->permission('personels.delete','button')==true){?>
										<td class="align-middle">
											<div class="form-check">
												<input class="form-check-input checker" type="checkbox" id="<?=$data['id']?>" name="BOX[<?=$data['id']?>]" value="<?=$data['id']?>">
												<label class="form-check-label" for="<?=$data['id']?>"></label>
											</div>
										</td>
									<?php }?>
									<td></td>
									<!-- <td><img src="/<?=$upload['images']['avatar']['url'].$data['avatar']?>" class="border border-light rounded-circle shadow-sm w-100"></td> -->
									<td><?=$data['name']?></td>
									<td><?=date("d/m/Y", strtotime($data['birthday']))?></td>
									<td><?=$data['citizenId']?></td>
									<td><?=$data['gender']?></td>
									<td><?=$data['phone_number']?></td>	
									<td><?=$data['type']?></td>				          
									<td>	
										<div class="form-check form-switch">
											<input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/personel/personels-status/<?=$data['id']?>/">
											<label class="form-check-label" for="status"></label>
										</div>
									</td>
									<?php if($jatbi->permission('personels.edit','button')==true){?>
										<td>
				            		<a class="btn btn-sm btn-light modal-url <?=$data['face']==0?'text-dark':'text-success'?>" aria-hidden="true" data-url="/personel/personels-face/<?=$data['id']?>/"><i class="fas fa-grin-hearts"></i></a>

				            	</td>
				            	<td>
				            		<a href="#!" data-url="/personel/personels-face-delete/<?=$data['id']?>/" class="modal-url"><i class="fas fa-meh-blank"></i></a>
				            					            </td>
										<td>
											<a class="btn btn-sm btn-light modal-url" data-url="/personel/personels-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
										</td>
									<?php }?>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
				<nav class="d-flex justify-content-between align-items-center paginations" aria-label="Page navigation">
					<?=$page?>
				</nav>
			</div>
		</div>
	</div>
<?php } ?>
<?php if($router['1']=='personels-face'){?>
	<div class="modal fade modal-load" tabindex="-1">
	  <div class="modal-dialog" >
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title"><?=$lang['nhan-dien-nhan-vien']?></h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
	      <div class="modal-body preview-images ">
	      	<div class="row">
	      		<div class="col-md-12">
		        	<div class="form-group row">
		        		<label class="col-sm-12"><?=$lang['hinh-anh']?> <?=$array?></label>
		        		<div class="col-sm-12">
				    		<div id="camera" class="w-100"></div>
		        			<div class="w-100 d-block">
			        			<?php if($data['face']==1){?>
						    		<img src="<?=$data['avatar']?>" class="preview-data w-100">
						    	<?php } else { ?>
						    		<img src="" class="preview-data w-100">
						    		
						    	<?php } ?>
					    	</div>
					    	<div>
					    		<?=$data['lastname']?>
					    	</div>
					    	
				    	</div>
			    	</div>
		        </div>
		        <div class="mb-3">
					<input type="file" class="form-control getImg" name="avatar">
			    </div>
		    </div>
	      </div>
	      <div class="modal-footer">
	      	<input type="hidden" name="token" value="<?=$_SESSION['csrf']['token']?>">
	      	<!-- <input type="hidden" name="images" value="" class="input-image"> -->
		    <!-- <button type="button" class="btn btn-danger click-image pull-left"><?=$lang['chup-anh']?></button> -->
	        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?=$lang['huy']?></button>
		    <button type="submit" class="btn btn-primary ajax-submit">
		    	<div class="spinner-button" style="display: none">
			    	<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
			    	<span class="me-1"><?=$lang['dang-tai']?></span>
			    </div>
		    	<span class="name-button"><?=$lang['hoan-tat']?></span>
		    </button>
	      </div>
	  	  </form>
	    </div>
	  </div>
	</div>
	<script language="JavaScript">
		Webcam.set({
			width: '720',
			height: '415',
			dest_width: 1280,
			dest_height: 738,
			image_format:'jpeg',
			jpeg_quality: 100,
			flip_horiz: false,
			constraints: {
				facingMode: 'environment', // user
			}
		});
		Webcam.attach('#camera');
		$('.click-image').on("click",function(){
			Webcam.snap( function(data) {
				$('.customer-image').attr("src",data);
				$('.input-image').val(data);
			} );
		});
	</script>
<?php } ?>
<?php if($router['1']=='personels-add' || $router['1']=='personels-edit'){?>
	<div class="modal fade modal-load" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><?=$router['1']=='personels-add'?$lang['them']:$lang['sua']?> <?=$lang['nhan-su']?></h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
					<div class="modal-body">
						<div class="row">
							<div class="col-sm-6">
								<div class="mb-3">
									<label>Ngày bắt đầu làm việc</label>
									<input placeholder="Ngày nhập học" type="date" name="date_start_work" value="<?=$data['date_start_work']?>" class="form-control">
								</div>	
								<div class="mb-3">
									<label><?=$lang['ten']?> <small class="text-danger">*</small></label>
									<input placeholder="<?=$lang['ten']?>" type="text" name="name" value="<?=$data['name']?>" class="form-control">
								</div>
								<div class="mb-3">
									<label><?=$lang['sinh-nhat']?></label>
									<input placeholder="<?=$lang['sinh-nhat']?>" type="date" name="birthday" value="<?=$data['birthday']?>" class="form-control">
								</div>
								<div class="mb-3">
									<label>Giới tính <small class="text-danger">*</small></label>
									<select name="gender" class="select2 form-control" style="width:100%">
										<?php if(isset($data['gender'])){ ?>
											<option value="<?=$data['gender']?>"  selected ><?=$data['gender']?></option>
										<?php } else {?>
											<option value="" disabled selected >Chọn</option>
										<?php } ?>					   
										<option value="Nam" >Nam</option>
										<option value="Nữ" >Nữ</option>						    
									</select>
								</div>	
								<div class="mb-3">
									<label><?=$lang['loai']?><small class="text-danger">*</small></label>
									<select name="type" class="select2 form-control" style="width:100%">
										<?php if(isset($data['type'])){ ?>
											<option value="<?=$data['type']?>"  selected ><?=$data['type']?></option>
										<?php } else {?>
											<option value="" disabled selected >Chọn</option>
										<?php } ?>					   
										<option value="Bảo vệ" >Bảo vệ</option>
										<option value="Tạp vụ" >Tạp vụ</option>						    
									</select>
								</div>		    			    
								<div class="mb-3">
									<label>Số điện thoại</label>
									<input placeholder="Số điện thoại" type="text" name="phone_number" value="<?=$data['phone_number']?>" class="form-control">
								</div>	
								<div class="mb-3">
									<label><?=$lang['cccd']?> <small class="text-danger">*</small></label>
									<input placeholder="<?=$lang['cccd']?>" type="text" name="citizenId" value="<?=$data['citizenId']?>" class="form-control">
								</div>	
								<div class="mb-3">
									<label><?=$lang['hinh-dai-dien']?></label>
									<input type="file" class="form-control" name="avatar" value="<?=$data['avatar']?>">
								</div>
							</div>
							<div class="col-sm-6">

								<div class="mb-3">
									<label>Địa chỉ <small class="text-danger">*</small></label>
									<input placeholder="Địa chỉ" type="text" name="address" value="<?=$data['address']?>" class="form-control">
								</div>

								<div class="select-areas">
									<div class="mb-3">
										<label><?=$lang['tinh-thanh']?></label>
										<select name="province" class="select2 form-control areas-province" style="width:100%">
											<option><?=$lang['tinh-thanh']?></option>
											<?php foreach ($provinces as $key => $province) { ?>
												<option value="<?=$province['id']?>" <?=$data['province']==$province['id']?'selected':''?> ><?=$province['name']?></option>
											<?php } ?>
										</select>
									</div>
									<div class="mb-3">
										<label><?=$lang['quan-huyen']?></label>
										<select name="district" class="select2 form-control areas-district" style="width:100%">
											<option><?=$lang['quan-huyen']?></option>
											<?php $districts = $database->select("district","*",["status"=>A,"deleted"=>0,"
											province"=>$data['province']])?>
											<?php foreach ($districts as $key => $district) { ?>
												<option value="<?=$district['id']?>" <?=$data['district']==$district['id']?'selected':''?>><?=$district['name']?></option>
											<?php } ?>
										</select>
									</div>
									<div class="mb-3">
										<label><?=$lang['phuong-xa']?></label>
										<select name="ward" class="select2 form-control areas-ward" style="width:100%">
											<option><?=$lang['phuong-xa']?></option>
											<?php $wards = $database->select("ward","*",["status"=>A,"deleted"=>0,"
											district"=>$data['district']])?>
											<?php foreach ($wards as $key => $ward) { ?>
												<option value="<?=$ward['id']?>" <?=$data['ward']==$ward['id']?'selected':''?>><?=$ward['name']?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="mb-3">
									<label><?=$lang['quoc-tich']?><small class="text-danger">*</small></label>
									<select name="nationality" class="select2 form-control" style="width:100%">
										<option value="" disabled selected><?=$lang['quoc-tich']?></option>
										<?php foreach ($nationality as $nationality) { ?>
											<option value="<?=$nationality['id']?>"  <?=($data['nationality']==$nationality['id']?'selected':'')?>><?=$nationality['name']?></option>
										<?php } ?>
									</select>
								</div>
								<div class="mb-3">
									<label><?=$lang['dan-toc']?><small class="text-danger">*</small></label>
									<select name="ethnic" class="select2 form-control" style="width:100%">
										<option value="" disabled selected><?=$lang['dan-toc']?></option>
										<?php foreach ($ethnic as $ethnic) { ?>
											<option value="<?=$ethnic['id']?>"  <?=($data['ethnic']==$ethnic['id']?'selected':'')?>><?=$ethnic['name']?></option>
										<?php } ?>
									</select>
								</div>
								<div class="mb-3">
									<label><?=$lang['ton-giao']?><small class="text-danger">*</small></label>
									<select name="religion" class="select2 form-control" style="width:100%">
										<option value="" disabled selected><?=$lang['ton-giao']?></option>
										<?php foreach ($religion as $religion) { ?>
											<option value="<?=$religion['id']?>"  <?=($data['religion']==$religion['id']?'selected':'')?>><?=$religion['name']?></option>
										<?php } ?>
									</select>
								</div>	
												     					    
								<div class="mb-3">
									<label><?=$lang['trang-thai']?> <small class="text-danger">*</small></label>
									<select name="status" class="select2 form-control" style="width:100%">
										<option value="A" <?=($data['status']=='A'?'selected':'')?>><?=$lang['kich-hoat']?></option>
										<option value="D" <?=($data['status']=='D'?'selected':'')?>><?=$lang['khong-kich-hoat']?></option>
									</select>
								</div>
							</div>

						</div>
					</div>
					<div class="modal-footer">
						<input type="hidden" name="token" value="<?=$_SESSION['csrf']['token']?>">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?=$lang['huy']?></button>
						<button type="submit" class="btn btn-primary ajax-submit">
							<div class="spinner-button" style="display: none">
								<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
								<span class="me-1"><?=$lang['dang-tai']?></span>
							</div>
							<span class="name-button"><?=$lang['hoan-tat']?></span>
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$(document).on("change",".type-data",function() {
			if($(this).val()==2){
				$(".data").show();
			}
			else {
				$(".data").hide();
			}
		})
	</script>
<?php } ?>
<?php if($router['1']=='personels-delete' || $router['1']=='personels-face-delete'){?>
	<div class="modal fade modal-load" tabindex="-1">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-body text-center">
					<i class="fas fa-exclamation-triangle remove-error text-danger p-3" aria-hidden="true" style="font-size:50px;"></i>
					<p><strong><?=$lang['ban-muon-xoa']?></strong></p>
					<p><?=$lang['noi-dung-ban-muon-xoa']?></p>
					<form method="POST" autocomplete="off" class="ajax-form">
						<input type="hidden" name="submit">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?=$lang['huy']?></button>
						<input type="submit" value="<?=$lang['dong-y']?>" class="btn btn-danger ajax-submit">
					</form>
				</div>
			</div>
		</div>
	</div>
<?php } ?>
<?php if($router['1']=='timekeeping_teachers'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['diem-danh-gv']?></h4>
			<ol class="breadcrumb">
			    <li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
			    <li class="breadcrumb-item active" aria-current="page"><?=$lang['nhan-su']?></li>
			</ol>
		</div>
	</nav>
	<?php if($jatbi->permission('timekeeping_teachers.add','button')==true || $jatbi->permission('timekeeping_teachers.delete','button')==true){?>
	<div class="fixed-action-btn">
	    <a class="btn btn-large btn-primary rounded-circle">
	      <i class="fas fa-bars" aria-hidden="true"></i>
	    </a>
	    <ul>
	      
	      <?php if($jatbi->permission('timekeeping_teachers.add','button')==true){?>
	      <li><a class="modal-url btn rounded-circle btn-info" data-url="/personel/timekeeping_teachers-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
	      <?php }?>
	    </ul>
	</div>
	<?php }?>
	<div class="card card-custom">
		<div class="card-body">
			<form method="GET" class="pjax-content mb-4 search-form">
				<div class="form-group col-4">
				    <input placeholder="<?=$lang['tim-kiem']?>" type="text" name="name" value="<?=$xss->xss($_GET['name'])?>" class="form-control">
			    </div>
				<div class="form-group">
			    	<div class="dropdown">
					  <button class="border dropdown-toggle w-100 filler" type="button" id="fillers" data-bs-auto-close="false" data-bs-toggle="dropdown" aria-expanded="false">
					    <i class="fas fa-filter"></i> <?=$lang['them-dieu-kien-loc']?>
					  </button>
					  <div class="dropdown-menu filler-details p-3" aria-labelledby="fillers">
					  	<p class="mb-2"><?=$lang['tim-kiem-theo-dieu-kien']?></p>
					    <div class="filer-item personnels">
					    	<label><?=$lang['giao-vien']?></label>
					    	<select name="teachers" class="form-control select2" style="width: 100%;">
					    		<option value=""><?=$lang['giao-vien']?></option>
					    		<?php foreach ($school_teachers as  $school_teachers) {
					    			 $teachers = $database->get("teacher", "*",["id"=>$school_teachers["teacher"],
					    			 	"deleted"=> 0,
					    			 	"status"=>"A"]);
					    		 ?>
							      	<option value="<?=$teachers['id']?>"  <?=($xss->xss($_GET['teachers'])==$teachers['id']?'selected':'')?>><?=$teachers['firstname']?> <?=$teachers['lastname']?></option>
							    <?php } ?>
						    </select>
					    </div>
					    <div class="filer-item month">
					    	<label><?=$lang['thang']?></label>
			    			<select name="month" class="form-control select2" style="width: 100%;">
					    		<option value=""><?=$lang['thang']?></option>
					    		<?php for ($imonth=1; $imonth<=12 ; $imonth++) { ?>
							      	<option value="<?=$imonth?>"  <?=($month==$imonth?'selected':'')?>><?=$imonth?></option>
							    <?php } ?>
						    </select>
					    </div>
					    <div class="filer-item year">
					    	<label><?=$lang['nam']?></label>
					    	<select name="year" class="form-control select2" style="width: 100%;">
					    		<option value=""><?=$lang['nam']?></option>
					    		<?php for ($iyear=2021; $iyear<=date("Y") ; $iyear++) { ?>
							      	<option value="<?=$iyear?>"  <?=($year==$iyear?'selected':'')?>><?=$iyear?></option>
							    <?php } ?>
						    </select>
					    </div>
					    <div class="d-flex justify-content-between align-items-center mt-3">
					    	<button type="button" class="btn btn-secondary filler-cancel"><?=$lang['huy']?></button>
					    	<button class="btn btn-primary filler-add"><?=$lang['them-dieu-kien']?></button>
					    </div>
					  </div>
					</div>
			    </div>
		    </form>
		    <div class="pjax-content-load">
				<div class="table-responsive">
		   			<table class="table table-bordered align-top small">
					  <thead>
					    <tr>
					    	<td class="fw-bold align-middle text-center p-1" rowspan="2"><?=$lang['ngay']?></td>
					    	<?php foreach ($dates as $date) {?>
					    	<td class="text-center align-middle fw-bold small p-1" style="<?=$date['week']==6?'background: #ffe7ca':''?><?=$date['week']==7?'background: #e1ffca':''?>">
					    		<?=$jatbi->week($date['week'])?>
					    	</td>
					    	<?php } ?>
					    </tr>
					    <tr>
					    	<?php foreach ($dates as $date) {?>
					    	<td class="text-center align-middle fw-bold small p-1" style="<?=$date['week']==6?'background: #ffe7ca':''?><?=$date['week']==7?'background: #e1ffca':''?>">
					    		<?=$date['name']?>
					    	</td>
					    	<?php } ?>
					    </tr>
					  </thead>
					  <tbody>
					  	<?php foreach ($datas as $key => $data) {?>
					  		<tr>
					  			<td colspan="100" class="fw-bold p-1 text-nowrap"><?=$data['name']?></td>
					  		</tr>
					  		<?php foreach ($data['teachers'] as $key => $teachers) {?>
					  			<tr>
					  				<td class="p-1 text-nowrap align-middle"><?=$teachers['firstname']?> <?=$teachers['lastname']?></td>
					  				<?php foreach ($teachers['dates'] as $key => $date) {?>
					  					<td class="text-nowrap p-1 <?=$date['color']?> modal-url" data-url="/personel/timekeeping_teachers-views/<?=$teachers['id']?>/<?=$date['date']?>/">
					  						<p class="mb-0 fw-bold"><?=$date['timework']['name']?></p>
					  						<?php if($date['off']['status']==0) {?>
					  						<p class="mb-0">
					  							<?=$date['checkin']['time']==''?'':'<span class="'.$date['checkin']['text'].'">'.date("H:i",strtotime($date['checkin']['time'])).'</span>'?>
					  							<?=$date['checkout']['time']==''?'':'<br><span class="'.$date['checkout']['text'].'">'.date("H:i",strtotime($date['checkout']['time'])).'</span>'?>
					  						</p>
					  						<?php } else { ?>
					  							<p class="mb-0"><?=$date['off']['content']?></p>
					  						<?php } ?>
					  					</td>
					  				<?php } ?>
					  			</tr>
					  		<?php } ?>
					  	<?php } ?>
					  </tbody>
					</table>
				</div>
				<div class="mt-4">
					<div class="row justify-content-start align-items-start">
						<div class="col-lg-3">
							<div class="d-flex justify-content-start align-items-center mb-2">
								<div class="p-3 bg-danger bg-opacity-10 me-2 border"></div>
								<span>Chưa điểm danh về</span>
							</div>
							<div class="d-flex justify-content-start align-items-center mb-2">
								<div class="p-3 bg-warning bg-opacity-10 me-2 border"></div>
								<span>Không điểm danh trễ ngày</span>
							</div>
							<div class="d-flex justify-content-start align-items-center mb-2">
								<div class="p-3 bg-success bg-opacity-10 me-2 border"></div>
								<span>Điểm danh đủ</span>
							</div>
							<div class="d-flex justify-content-start align-items-center mb-2">
								<div class="p-3 bg-primary bg-opacity-10 me-2 border"></div>
								<span>Nghỉ học theo buổi học</span>
							</div>
							<div class="d-flex justify-content-start align-items-center mb-2">
								<div class="p-3 bg-primary bg-opacity-25 me-2 border"></div>
								<span>Nghỉ làm có xin phép</span>
							</div>
						</div>
						<div class="col-lg-3">
							<?php foreach ($furlough_categorys as $key => $furlough_category) {?>
								<div class="d-flex justify-content-start align-items-center mb-2">
									<div class="p-2 bg-primary bg-opacity-25 me-2 border">
										<?=$furlough_category['code']?>
									</div>
									<span><?=$furlough_category['name']?></span>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php } ?>
<?php if($router['1']=='timekeeping_teachers-add' || $router['1']=='timekeeping_teachers-edit'){?>
	<div class="modal fade modal-load" tabindex="-1">
	  <div class="modal-dialog modal-sm">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title"><?=$router['1']=='timekeeping_teachers-add'?$lang['them']:$lang['sua']?> <?=$lang['diem-danh']?></h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
	      <div class="modal-body">
	      	<div class="row">
		        <div class="col-sm-12">
		        	<div class="mb-3">
		        		<label><?=$lang['ngay']?> <small class="text-danger">*</small></label>
					    <input placeholder="<?=$lang['ngay']?>" type="datetime-local" name="date" value="<?=$data['date']==""?date("Y-m-d\TH:i"):date("Y-m-d\TH:i",strtotime($data['date']))?>" class="form-control">
				    </div>
		        	<div class="mb-3">
		        		<label><?=$lang['giao-vien']?></label>
					    	<select name="teacher" class="form-control select2" style="width: 100%;">
					    		<option value=""><?=$lang['giao-vien']?></option>
					    		<?php foreach ($school_teachers as  $school_teachers) {
					    			 $teachers = $database->get("teacher", "*",["id"=>$school_teachers["teacher"],
					    			 	"deleted"=> 0,
					    			 	"status"=>"A"]);
					    		 ?>
							      	<option value="<?=$teachers['id']?>"  <?=($xss->xss($_GET['teachers'])==$teachers['id']?'selected':'')?>><?=$teachers['firstname']?> <?=$teachers['lastname']?></option>
							    <?php } ?>
						    </select>
				    </div>
				    <div class="mb-3">
		        		<label><?=$lang['ghi-chu']?><small class="text-danger">*</small></label>
					    <input placeholder="<?=$lang['ghi-chu']?>" type="text" name="notes" value="<?=$data['notes']?>" class="form-control">
				    </div>
				    <div class="mb-3">
		        		<label><?=$lang['trang-thai']?> <small class="text-danger">*</small></label>
				    	<select name="status" class="select2 form-control" style="width:100%">
					      <option value="1" <?=($data['status']=='1'?'selected':'')?>><?=$lang['di-vao']?></option>
					      <option value="2" <?=($data['status']=='2'?'selected':'')?>><?=$lang['di-ra']?></option>
					    </select>
				    </div>
		        </div>
		    </div>
		    <!-- <pre><?=print_r($studentss)?></pre> -->
	      </div>
	      <div class="modal-footer">
	      	<input type="hidden" name="token" value="<?=$_SESSION['csrf']['token']?>">
	        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?=$lang['huy']?></button>
		    <button type="submit" class="btn btn-primary ajax-submit">
		    	<div class="spinner-button" style="display: none">
			    	<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
			    	<span class="me-1"><?=$lang['dang-tai']?></span>
			    </div>
		    	<span class="name-button"><?=$lang['hoan-tat']?></span>
		    </button>
	      </div>
	  	  </form>
	    </div>
	  </div>
	</div>
<?php } ?>
<?php if($router['1']=='timekeeping_teachers-views'){?>
	<div class="modal fade modal-load" tabindex="-1">
	  <div class="modal-dialog modal-lg">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title"><?=$lang['nhat-ky-diem-danh']?>: <?=$teachers['firstname'];?> <?=$teachers['lastname'];?>- <?=date($setting['site_date'],strtotime($router['3']))?></h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <div class="modal-body">
	      	<div class="table-responsive">
	      		<table class="table table-striped table-bordered table-hover">
	      			<thead>
	      				<tr>
	      					<th><?=$lang['so-thu-tu']?></th>
	      					<th><?=$lang['loai']?></th>
	      					<th><?=$lang['gio']?></th>
	      					<th><?=$lang['ghi-chu']?></th>
	      					<th><?=$lang['ngay']?></th>
	      					<th width="1%"></th>
	      				</tr>
	      			</thead>
	      			<tbody>
	      				<?php $stt=1; foreach ($datas as $key => $data) { $timeLate = $database->get("timekeeping_teachers_time_late","*",["timekeeping_teachers"=>$data['id'],"deleted"=>0]);?>
	      				<tr>
	      					<td><?=$stt++?></td>
	      					<td><?=$data['status']=='1'?$lang['di-vao']:$lang['di-ra']?></td>
	      					<td><?=date('H:i:s',strtotime($data['date']))?></td>
	      					<!-- <td class="text-danger">
	      						<?php if($timeLate>1){?>
		      						<?=$timeLate['status']==1?$lang['di-tre'].' '.$timeLate['time'].' '.$lang['phut']:$lang['ve-som'].' '.$timeLate['time'].' '.$lang['phut']?> / <?=number_format($timeLate['price'])?>
		      					<?php } ?>
	      					</td> -->
	      					<td><?=$data['notes']?></td>
	      					<td><?=date($setting['site_datetime'],strtotime($data['date_poster']))?></td>
	      					<td>
	      						<button class="btn btn-sm text-danger click-action" data-url="/personel/timekeeping_teachers-delete/<?=$data['id']?>/"><i class="fa fa-trash"></i></button>
	      					</td>
	      				</tr>
	      				<?php } ?>
	      			</tbody>
	      		</table>
	      	</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?=$lang['huy']?></button>
	      </div>
	    </div>
	  </div>
	</div>
<?php } ?>
<?php if($router['1']=='timekeeping_personels'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['diem-danh-nv']?></h4>
			<ol class="breadcrumb">
			    <li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
			    <li class="breadcrumb-item active" aria-current="page"><?=$lang['nhan-su']?></li>
			</ol>
		</div>
	</nav>
	<?php if($jatbi->permission('timekeeping_personels.add','button')==true || $jatbi->permission('timekeeping_personels.delete','button')==true){?>
	<div class="fixed-action-btn">
	    <a class="btn btn-large btn-primary rounded-circle">
	      <i class="fas fa-bars" aria-hidden="true"></i>
	    </a>
	    <ul>
	      
	      <?php if($jatbi->permission('timekeeping_personels.add','button')==true){?>
	      <li><a class="modal-url btn rounded-circle btn-info" data-url="/personel/timekeeping_personels-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
	      <?php }?>
	    </ul>
	</div>
	<?php }?>
	<div class="card card-custom">
		<div class="card-body">
			<form method="GET" class="pjax-content mb-4 search-form">
				<div class="form-group col-4">
				    <input placeholder="<?=$lang['tim-kiem']?>" type="text" name="name" value="<?=$xss->xss($_GET['name'])?>" class="form-control">
			    </div>
				<div class="form-group">
			    	<div class="dropdown">
					  <button class="border dropdown-toggle w-100 filler" type="button" id="fillers" data-bs-auto-close="false" data-bs-toggle="dropdown" aria-expanded="false">
					    <i class="fas fa-filter"></i> <?=$lang['them-dieu-kien-loc']?>
					  </button>
					  <div class="dropdown-menu filler-details p-3" aria-labelledby="fillers">
					  	<p class="mb-2"><?=$lang['tim-kiem-theo-dieu-kien']?></p>
					    <div class="filer-item personnels">
					    	<label><?=$lang['nhan-vien']?></label>
					    	<select name="personels" class="form-control select2" style="width: 100%;">
					    		<option value=""><?=$lang['nhan-vien']?></option>
					    		<?php foreach ($personelss as  $personels) {
					    		 ?>
							      	<option value="<?=$personels['id']?>"  <?=($xss->xss($_GET['personels'])==$personels['id']?'selected':'')?>><?=$personels['name']?></option>
							    <?php } ?>
						    </select>
					    </div>
					    <div class="filer-item month">
					    	<label><?=$lang['thang']?></label>
			    			<select name="month" class="form-control select2" style="width: 100%;">
					    		<option value=""><?=$lang['thang']?></option>
					    		<?php for ($imonth=1; $imonth<=12 ; $imonth++) { ?>
							      	<option value="<?=$imonth?>"  <?=($month==$imonth?'selected':'')?>><?=$imonth?></option>
							    <?php } ?>
						    </select>
					    </div>
					    <div class="filer-item year">
					    	<label><?=$lang['nam']?></label>
					    	<select name="year" class="form-control select2" style="width: 100%;">
					    		<option value=""><?=$lang['nam']?></option>
					    		<?php for ($iyear=2021; $iyear<=date("Y") ; $iyear++) { ?>
							      	<option value="<?=$iyear?>"  <?=($year==$iyear?'selected':'')?>><?=$iyear?></option>
							    <?php } ?>
						    </select>
					    </div>
					    <div class="d-flex justify-content-between align-items-center mt-3">
					    	<button type="button" class="btn btn-secondary filler-cancel"><?=$lang['huy']?></button>
					    	<button class="btn btn-primary filler-add"><?=$lang['them-dieu-kien']?></button>
					    </div>
					  </div>
					</div>
			    </div>
		    </form>
		    <div class="pjax-content-load">
				<div class="table-responsive">
		   			<table class="table table-bordered align-top small">
					  <thead>
					    <tr>
					    	<td class="fw-bold align-middle text-center p-1" rowspan="2"><?=$lang['ngay']?></td>
					    	<?php foreach ($dates as $date) {?>
					    	<td class="text-center align-middle fw-bold small p-1" style="<?=$date['week']==6?'background: #ffe7ca':''?><?=$date['week']==7?'background: #e1ffca':''?>">
					    		<?=$jatbi->week($date['week'])?>
					    	</td>
					    	<?php } ?>
					    </tr>
					    <tr>
					    	<?php foreach ($dates as $date) {?>
					    	<td class="text-center align-middle fw-bold small p-1" style="<?=$date['week']==6?'background: #ffe7ca':''?><?=$date['week']==7?'background: #e1ffca':''?>">
					    		<?=$date['name']?>
					    	</td>
					    	<?php } ?>
					    </tr>
					  </thead>
					  <tbody>
					  	<?php foreach ($datas as $key => $data) {?>
					  		<tr>
					  			<td colspan="100" class="fw-bold p-1 text-nowrap"><?=$data['name']?></td>
					  		</tr>
					  		<?php foreach ($data['personels'] as $key => $personels) {?>
					  			<tr>
					  				<td class="p-1 text-nowrap align-middle"><?=$personels['name']?></td>
					  				<?php foreach ($personels['dates'] as $key => $date) {?>
					  					<td class="text-nowrap p-1 <?=$date['color']?> modal-url" data-url="/personel/timekeeping_personels-views/<?=$personels['id']?>/<?=$date['date']?>/">
					  						<p class="mb-0 fw-bold"><?=$date['timework']['name']?></p>
					  						<?php if($date['off']['status']==0) {?>
					  						<p class="mb-0">
					  							<?=$date['checkin']['time']==''?'':'<span class="'.$date['checkin']['text'].'">'.date("H:i",strtotime($date['checkin']['time'])).'</span>'?>
					  							<?=$date['checkout']['time']==''?'':'<br><span class="'.$date['checkout']['text'].'">'.date("H:i",strtotime($date['checkout']['time'])).'</span>'?>
					  						</p>
					  						<?php } else { ?>
					  							<p class="mb-0"><?=$date['off']['content']?></p>
					  						<?php } ?>
					  					</td>
					  				<?php } ?>
					  			</tr>
					  		<?php } ?>
					  	<?php } ?>
					  </tbody>
					</table>
				</div>
				<div class="mt-4">
					<div class="row justify-content-start align-items-start">
						<div class="col-lg-3">
							<div class="d-flex justify-content-start align-items-center mb-2">
								<div class="p-3 bg-danger bg-opacity-10 me-2 border"></div>
								<span>Chưa điểm danh về</span>
							</div>
							<div class="d-flex justify-content-start align-items-center mb-2">
								<div class="p-3 bg-warning bg-opacity-10 me-2 border"></div>
								<span>Không điểm danh trễ ngày</span>
							</div>
							<div class="d-flex justify-content-start align-items-center mb-2">
								<div class="p-3 bg-success bg-opacity-10 me-2 border"></div>
								<span>Điểm danh đủ</span>
							</div>
							<div class="d-flex justify-content-start align-items-center mb-2">
								<div class="p-3 bg-primary bg-opacity-10 me-2 border"></div>
								<span>Nghỉ học theo buổi học</span>
							</div>
							<div class="d-flex justify-content-start align-items-center mb-2">
								<div class="p-3 bg-primary bg-opacity-25 me-2 border"></div>
								<span>Nghỉ làm có xin phép</span>
							</div>
						</div>
						<div class="col-lg-3">
							<?php foreach ($furlough_categorys as $key => $furlough_category) {?>
								<div class="d-flex justify-content-start align-items-center mb-2">
									<div class="p-2 bg-primary bg-opacity-25 me-2 border">
										<?=$furlough_category['code']?>
									</div>
									<span><?=$furlough_category['name']?></span>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php } ?>
<?php if($router['1']=='timekeeping_personels-add' || $router['1']=='timekeeping_personels-edit'){?>
	<div class="modal fade modal-load" tabindex="-1">
	  <div class="modal-dialog modal-sm">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title"><?=$router['1']=='timekeeping_personels-add'?$lang['them']:$lang['sua']?> <?=$lang['diem-danh']?></h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
	      <div class="modal-body">
	      	<div class="row">
		        <div class="col-sm-12">
		        	<div class="mb-3">
		        		<label><?=$lang['ngay']?> <small class="text-danger">*</small></label>
					    <input placeholder="<?=$lang['ngay']?>" type="datetime-local" name="date" value="<?=$data['date']==""?date("Y-m-d\TH:i"):date("Y-m-d\TH:i",strtotime($data['date']))?>" class="form-control">
				    </div>
		        	<div class="mb-3">
		        		<label><?=$lang['nhan-vien']?></label>
					    	<select name="personels" class="form-control select2" style="width: 100%;">
					    		<option value=""><?=$lang['nhan-vien']?></option>
					    		<?php foreach ($personelss as  $personels) {
					    		 ?>
							      	<option value="<?=$personels['id']?>"  <?=($xss->xss($_GET['personels'])==$personels['id']?'selected':'')?>><?=$personels['name']?></option>
							    <?php } ?>
						    </select>
				    </div>
				    <div class="mb-3">
		        		<label><?=$lang['ghi-chu']?><small class="text-danger">*</small></label>
					    <input placeholder="<?=$lang['ghi-chu']?>" type="text" name="notes" value="<?=$data['notes']?>" class="form-control">
				    </div>
				    <div class="mb-3">
		        		<label><?=$lang['trang-thai']?> <small class="text-danger">*</small></label>
				    	<select name="status" class="select2 form-control" style="width:100%">
					      <option value="1" <?=($data['status']=='1'?'selected':'')?>><?=$lang['di-vao']?></option>
					      <option value="2" <?=($data['status']=='2'?'selected':'')?>><?=$lang['di-ra']?></option>
					    </select>
				    </div>
		        </div>
		    </div>
		    <!-- <pre><?=print_r($studentss)?></pre> -->
	      </div>
	      <div class="modal-footer">
	      	<input type="hidden" name="token" value="<?=$_SESSION['csrf']['token']?>">
	        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?=$lang['huy']?></button>
		    <button type="submit" class="btn btn-primary ajax-submit">
		    	<div class="spinner-button" style="display: none">
			    	<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
			    	<span class="me-1"><?=$lang['dang-tai']?></span>
			    </div>
		    	<span class="name-button"><?=$lang['hoan-tat']?></span>
		    </button>
	      </div>
	  	  </form>
	    </div>
	  </div>
	</div>
<?php } ?>
<?php if($router['1']=='timekeeping_personels-views'){?>
	<div class="modal fade modal-load" tabindex="-1">
	  <div class="modal-dialog modal-lg">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title"><?=$lang['nhat-ky-diem-danh']?>: <?=$personels['firstname'];?> <?=$personels['lastname'];?>- <?=date($setting['site_date'],strtotime($router['3']))?></h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <div class="modal-body">
	      	<div class="table-responsive">
	      		<table class="table table-striped table-bordered table-hover">
	      			<thead>
	      				<tr>
	      					<th><?=$lang['so-thu-tu']?></th>
	      					<th><?=$lang['loai']?></th>
	      					<th><?=$lang['gio']?></th>
	      					<th><?=$lang['ghi-chu']?></th>
	      					<th><?=$lang['ngay']?></th>
	      					<th width="1%"></th>
	      				</tr>
	      			</thead>
	      			<tbody>
	      				<?php $stt=1; foreach ($datas as $key => $data) { $timeLate = $database->get("timekeeping_teachers_time_late","*",["timekeeping_teachers"=>$data['id'],"deleted"=>0]);?>
	      				<tr>
	      					<td><?=$stt++?></td>
	      					<td><?=$data['status']=='1'?$lang['di-vao']:$lang['di-ra']?></td>
	      					<td><?=date('H:i:s',strtotime($data['date']))?></td>
	      					<!-- <td class="text-danger">
	      						<?php if($timeLate>1){?>
		      						<?=$timeLate['status']==1?$lang['di-tre'].' '.$timeLate['time'].' '.$lang['phut']:$lang['ve-som'].' '.$timeLate['time'].' '.$lang['phut']?> / <?=number_format($timeLate['price'])?>
		      					<?php } ?>
	      					</td> -->
	      					<td><?=$data['notes']?></td>
	      					<td><?=date($setting['site_datetime'],strtotime($data['date_poster']))?></td>
	      					<td>
	      						<button class="btn btn-sm text-danger click-action" data-url="/personel/timekeeping_teachers-delete/<?=$data['id']?>/"><i class="fa fa-trash"></i></button>
	      					</td>
	      				</tr>
	      				<?php } ?>
	      			</tbody>
	      		</table>
	      	</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?=$lang['huy']?></button>
	      </div>
	    </div>
	  </div>
	</div>
<?php } ?>
<?php if($router['1']=='regent'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['danh-sach-chuc-vu']?></h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
				<li class="breadcrumb-item active" aria-current="page"><?=$lang['nhan-su']?></li>
			</ol>
		</div>
	</nav>
	<?php if($jatbi->permission('regent.add','button')==true || $jatbi->permission('regent.delete','button')==true){?>
		<div class="fixed-action-btn">
			<a class="btn btn-large btn-primary rounded-circle">
				<i class="fas fa-bars" aria-hidden="true"></i>
			</a>
			<ul>
				<?php if($jatbi->permission('regent.delete','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/personel/regent-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
				<?php }?>
				<?php if($jatbi->permission('regent.add','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-info" data-url="/personel/regent-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
				<?php }?>
			</ul>
		</div>
	<?php }?>
	<div class="card card-custom">
		<div class="card-body">
			<form method="GET" class="pjax-content mb-4 search-form">
				<div class="form-group col-4">
					<input placeholder="<?=$lang['tim-kiem']?>" type="text" name="name" value="<?=$xss->xss($_GET['name'])?>" class="form-control">
				</div>
				<div class="form-group">
					<div class="dropdown">
						<button class="border dropdown-toggle w-100 filler" type="button" id="fillers" data-bs-auto-close="false" data-bs-toggle="dropdown" aria-expanded="false">
							<i class="fas fa-filter"></i> <?=$lang['them-dieu-kien-loc']?>
						</button>
						<div class="dropdown-menu filler-details p-3" aria-labelledby="fillers">
							<p class="mb-2"><?=$lang['tim-kiem-theo-dieu-kien']?></p>
							<div class="filer-item permission">
								<label><?=$lang['nhom-quyen']?></label>
								<select name="permission" class="select2 form-select" style="width:100%">
									<option value=""><?=$lang['tat-ca']?></option>
									<?php foreach ($permissions as $permission) { ?>
										<option value="<?=$permission['id']?>"  <?=($xss->xss($_GET['permission'])==$permission['id']?'selected':'')?>><?=$permission['name']?></option>
									<?php } ?>
								</select>
							</div>
							<div class="filer-item status">
								<label><?=$lang['trang-thai']?></label>
								<select name="status" class="select2 form-control" style="width:100%">
									<option value=""><?=$lang['tat-ca']?></option>
									<option value="A" <?=($_GET['status']=='A'?'selected':'')?>><?=$lang['kich-hoat']?></option>
									<option value="D" <?=($_GET['status']=='D'?'selected':'')?>><?=$lang['khong-kich-hoat']?></option>
								</select>
							</div>
							<div class="d-flex justify-content-between align-items-center mt-3">
								<button type="button" class="btn btn-secondary filler-cancel"><?=$lang['huy']?></button>
								<button class="btn btn-primary filler-add"><?=$lang['them-dieu-kien']?></button>
							</div>
						</div>
					</div>
				</div>
			</form>
			<div class="pjax-content-load">
				<div class="table-responsive">
					<table class="table table-striped table-hover align-middle">
						<thead>
							<tr>
								<?php if($jatbi->permission('regent.delete','button')==true){?>
									<th width="1%" class="text-center">
										<div class="form-check">
											<input class="form-check-input selectall" type="checkbox" value="" id="all">
											<label class="form-check-label" for="all">
											</label>
										</div>
									</th>
								<?php }?>
								<th width="50"></th>
								<th><?=$lang['ten']?></th>					        			        					      
								<th><?=$lang['trang-thai']?></th>
								<?php if($jatbi->permission('regent.edit','button')==true){?>
									<th width="2%"></th>
								<?php }?>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($datas as $data) { ?>
								<tr>
									<?php if($jatbi->permission('regent.delete','button')==true){?>
										<td class="align-middle">
											<div class="form-check">
												<input class="form-check-input checker" type="checkbox" id="<?=$data['id']?>" name="BOX[<?=$data['id']?>]" value="<?=$data['id']?>">
												<label class="form-check-label" for="<?=$data['id']?>"></label>
											</div>
										</td>
									<?php }?>
									<td></td>


									<td><?=$data['name']?></td>



									<td>	
										<div class="form-check form-switch">
											<input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/personel/regent-status/<?=$data['id']?>/">
											<label class="form-check-label" for="status"></label>
										</div>
									</td>
									<?php if($jatbi->permission('regent.edit','button')==true){?>
										<td>
											<a class="btn btn-sm btn-light modal-url" data-url="/personel/regent-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
										</td>
									<?php }?>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
				<nav class="d-flex justify-content-between align-items-center paginations" aria-label="Page navigation">
					<?=$page?>
				</nav>
			</div>
		</div>
	</div>
<?php } ?>
<?php if($router['1']=='regent-add' || $router['1']=='regent-edit'){?>
	<div class="modal fade modal-load" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><?=$router['1']=='regent-add'?$lang['them']:$lang['sua']?><?=$lang['chuc-vu']?></h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
					<div class="modal-body">
						<div class="row">
							<div class="col-sm-6">
								<div class="mb-3">
									<label><?=$lang['ten']?><small class="text-danger">*</small></label>
									<input placeholder="<?=$lang['ten']?>" type="text" name="name" value="<?=$data['name']?>" class="form-control">
								</div>

							</div> 		    
							<div class="col-sm-6">				    	    
								<div class="mb-3">
									<label><?=$lang['trang-thai']?> <small class="text-danger">*</small></label>
									<select name="status" class="select2 form-control" style="width:100%">
										<option value="A" <?=($data['status']=='A'?'selected':'')?>><?=$lang['kich-hoat']?></option>
										<option value="D" <?=($data['status']=='D'?'selected':'')?>><?=$lang['khong-kich-hoat']?></option>
									</select>
								</div>
							</div>

						</div>
					</div>
					<div class="modal-footer">
						<input type="hidden" name="token" value="<?=$_SESSION['csrf']['token']?>">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?=$lang['huy']?></button>
						<button type="submit" class="btn btn-primary ajax-submit">
							<div class="spinner-button" style="display: none">
								<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
								<span class="me-1"><?=$lang['dang-tai']?></span>
							</div>
							<span class="name-button"><?=$lang['hoan-tat']?></span>
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$(document).on("change",".type-data",function() {
			if($(this).val()==2){
				$(".data").show();
			}
			else {
				$(".data").hide();
			}
		})
	</script>
<?php } ?>
<?php if($router['1']=='regent-delete'){?>
	<div class="modal fade modal-load" tabindex="-1">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-body text-center">
					<i class="fas fa-exclamation-triangle remove-error text-danger p-3" aria-hidden="true" style="font-size:50px;"></i>
					<p><strong><?=$lang['ban-muon-xoa']?></strong></p>
					<p><?=$lang['noi-dung-ban-muon-xoa']?></p>
					<form method="POST" autocomplete="off" class="ajax-form">
						<input type="hidden" name="submit">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?=$lang['huy']?></button>
						<input type="submit" value="<?=$lang['dong-y']?>" class="btn btn-danger ajax-submit">
					</form>
				</div>
			</div>
		</div>
	</div>
<?php } ?>

