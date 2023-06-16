<?php if($router['1']=='students'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['danh-sach-hoc-sinh']?></h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
				<li class="breadcrumb-item active" aria-current="page"><?=$lang['ho-so']?></li>
			</ol>
		</div>
	</nav>
	<?php if($jatbi->permission('students.add','button')==true || $jatbi->permission('students.delete','button')==true){?>
		<div class="fixed-action-btn">
			<a class="btn btn-large btn-primary rounded-circle">
				<i class="fas fa-bars" aria-hidden="true"></i>
			</a>
			<ul>
				<?php if($jatbi->permission('students.delete','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/profiles/students-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
				<?php }?>
				<?php if($jatbi->permission('students.add','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-info" data-url="/profiles/students-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
								<?php if($jatbi->permission('students.delete','button')==true){?>
									<th width="1%" class="text-center">
										<div class="form-check">
											<input class="form-check-input selectall" type="checkbox" value="" id="all">
											<label class="form-check-label" for="all">
											</label>
										</div>
									</th>
								<?php }?>
								<th width="50"></th>
								<th><?=$lang['ma-hoc-sinh']?></th>
								<th><?=$lang['ho']?></th>
								<th><?=$lang['ten']?></th>
								<th><?=$lang['gioi-tinh']?></th>				        
								<th><?=$lang['ngay-sinh']?></th>


								<th><?=$lang['trang-thai']?></th>
								<?php if($jatbi->permission('students.edit','button')==true){?>
									<th width="2%"></th>
								<?php }?>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($datas as $data) { ?>
								<tr>
									<?php if($jatbi->permission('students.delete','button')==true){?>
										<td class="align-middle">
											<div class="form-check">
												<input class="form-check-input checker" type="checkbox" id="<?=$data['id']?>" name="BOX[<?=$data['id']?>]" value="<?=$data['id']?>">
												<label class="form-check-label" for="<?=$data['id']?>"></label>
											</div>
										</td>
									<?php }?>
									<td></td>
									
									<td><?=$data['id_student']?></td>
									<td><?=$data['firstname']?></td>
									<td><?=$data['lastname']?></td>
				            
				            <td><?=$data['gender']?></td>
				            <td><?=date("d/m/Y", strtotime($data['birthday']))?></td>


				            <td>	
				            	<div class="form-check form-switch">
				            		<input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/profiles/students-status/<?=$data['id']?>/">
				            		<label class="form-check-label" for="status"></label>
				            	</div>
				            </td>
				            <?php if($jatbi->permission('students','button')==true){?>
										<td>
											<a class="btn btn-sm btn-light pjax-load" href="/profiles/profiles/<?=$data['id']?>/"><i class="fas fa-eye" aria-hidden="true"></i></a>
										</td>
										<td>
				            		<a class="btn btn-sm btn-light modal-url <?=$data['face']==0?'text-dark':'text-success'?>" aria-hidden="true" data-url="/profiles/students-face/<?=$data['id']?>/"><i class="fas fa-grin-hearts"></i></a>
				            	</td>
									<?php }?>
				            <?php if($jatbi->permission('students.edit','button')==true){?>
				            	<td>
				            		<a href="#!" data-url="/profiles/students-face-delete/<?=$data['id']?>/" class="modal-url"><i class="fas fa-meh-blank"></i></a>
				            					            </td>
				            	<td>
				            		<a class="btn btn-sm btn-light modal-url" data-url="/profiles/students-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
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
<?php if($router['1']=='students-face'){?>
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
<?php if($router['1']=='students-add' || $router['1']=='students-edit'){?>
	<div class="modal fade modal-load" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><?=$router['1']=='students-add'?$lang['them']:$lang['sua']?> Học sinh </h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
					<div class="modal-body">
						<div class="row">
							<div class="col-sm-6">
								<div class="mb-3">
									<label><?=$lang['ma-hoc-sinh']?> <small class="text-danger">*</small></label>
									<input placeholder="<?=$lang['ma-hoc-sinh']?>" type="text" name="id_student" value="<?=$data['id_student']?>" class="form-control">
								</div>

								<div class="mb-3">
									<label><?=$lang['ho']?> <small class="text-danger">*</small></label>
									<input placeholder="<?=$lang['ho']?>" type="text" name="firstname" value="<?=$data['firstname']?>" class="form-control">
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
									<label><?=$lang['ngay-nhap-hoc']?></label>
									<input placeholder="<?=$lang['ngay-nhap-hoc']?>" type="date" name="year_of_admission" value="<?=$data['year_of_admission']?>" class="form-control">
								</div>				    
								<div class="mb-3">
									<label><?=$lang['gioi-tinh']?><small class="text-danger">*</small></label>
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
									<label><?=$lang['dia-chi']?><small class="text-danger">*</small></label>
									<input placeholder="<?=$lang['dia-chi']?>" type="text" name="address" value="<?=$data['address']?>" class="form-control">
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
									<label><?=$lang['khoa-hoc']?><small class="text-danger">*</small></label>
									<select name="course" class="select2 form-control" style="width:100%">
										<option value="" disabled selected><?=$lang['khoa-hoc']?></option>
										<?php foreach ($course as $course) { ?>
											<option value="<?=$course['id']?>"  <?=($data['course']==$course['id']?'selected':'')?>><?=$course['name']?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="col-sm-6">

								
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
									<label><?=$lang['hinh-dai-dien']?></label>
									<input type="file" class="form-control" name="avatar" value="<?=$data['avatar']?>">
								</div>
								<div class="mb-3">
									<label><?=$lang['phu-huynh']?><small class="text-danger">*</small></label>
									<select name="parent" class="select2 form-control" style="width:100%">
										<option value="" disabled selected><?=$lang['phu-huynh']?></option>						    
										<?php foreach($school_parents as $school_parent){
											$parentt=$database->get("parent","*",['id'=>$school_parent['parent'],"deleted"=> 0,"status"=>'A']);
											?>
											<option value="<?=$parentt['id']?>"  <?=($data['parent']==$parentt['id']?'selected':'')?>><?=$parentt['name']?> - <?=$parentt['phone_number']?></option>

										<?php } ?>
									</select>
								</div>
								<div class="mb-3">
									<label><?=$lang['doi-tuong']?><small class="text-danger">*</small></label>
									<select name="priority_object" class="select2 form-control" style="width:100%">
										<option value="" disabled selected><?=$lang['doi-tuong']?></option>
										<?php foreach ($priority_object as $priority_object) { ?>
											<option value="<?=$priority_object['id']?>"  <?=($data['priority_object']==$priority_object['id']?'selected':'')?>><?=$priority_object['name']?></option>
										<?php } ?>
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
									<label><?=$lang['so-thich']?><small class="text-danger">*</small></label>
									<input placeholder="<?=$lang['so-thich']?>" type="text" name="hobby" value="<?=$data['hobby']?>" class="form-control">
								</div>
								<div class="mb-3">
									<label><?=$lang['di-ung']?><small class="text-danger">*</small></label>
									<select name="allergy" class="select2 form-control" style="width:100%">
										<option value="" disabled selected><?=$lang['di-ung']?></option>
										<?php foreach ($allergy as $allergy) { ?>
											<option value="<?=$allergy['id']?>"  <?=($data['allergy']==$allergy['id']?'selected':'')?>><?=$allergy['name']?></option>
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
<?php if($router['1']=='students-delete' || $router['1']=='students-face-delete'){?>
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
<?php if($router['1']=='birthday'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4>Danh sách sinh nhật hôm nay</h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
				<li class="breadcrumb-item active" aria-current="page"><?=$lang['ho-so']?></li>
			</ol>
		</div>
	</nav>
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
						      <!-- <?php foreach ($permissions as $permission) { ?>
						      	<option value="<?=$permission['id']?>"  <?=($xss->xss($_GET['permission'])==$permission['id']?'selected':'')?>><?=$permission['name']?></option>
						      	<?php } ?> -->
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
								<?php if($jatbi->permission('accounts.delete','button')==true){?>
									<th width="1%" class="text-center">
										<div class="form-check">
											<input class="form-check-input selectall" type="checkbox" value="" id="all">
											<label class="form-check-label" for="all">
											</label>
										</div>
									</th>
								<?php }?>
								<th width="50"></th>
								<th>Mã học sinh</th>
								<th>Họ</th>
								<th>Tên</th>
								<th>Giới tính</th>				        
								<th>Ngày sinh</th>
							
								<th>Khóa học</th>	

								<th><?=$lang['trang-thai']?></th>
								<?php if($jatbi->permission('accounts.edit','button')==true){?>
									<th width="2%"></th>
								<?php }?>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($datas as $data) { ?>
								<tr>
									<?php if(date('d/m',strtotime($data['birthday']))==date("d/m")){?>
										<?php if($jatbi->permission('accounts.delete','button')==true){?>
											<td class="align-middle">
												<div class="form-check">
													<input class="form-check-input checker" type="checkbox" id="<?=$data['id']?>" name="BOX[<?=$data['id']?>]" value="<?=$data['id']?>">
													<label class="form-check-label" for="<?=$data['id']?>"></label>
												</div>
											</td>
										<?php }?>
										<td></td>
										<td><?=$data['id_student']?></td>
										<td><?=$data['firstname']?></td>
										<td><?=$data['lastname']?></td>
										<td><?=$data['gender']?></td>
										<td><?=date("d/m/Y",strtotime($data['birthday']))?></td>
										
										<td><?=$database->get("course", "name",["id"=>$data['course']])?></td>
										<td>	
											<div class="form-check form-switch">
												<input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/users/accounts-status/<?=$data['id']?>/">
												<label class="form-check-label" for="status"></label>
											</div>
										</td>
										<?php if($jatbi->permission('accounts.edit','button')==true){?>
											<td>
												<a class="btn btn-sm btn-light modal-url" data-url="/users/accounts-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
											</td>
										<?php }?>
									<?php } ?>
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
<?php if($router['1']=='parents'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4>Danh sách Phụ huynh</h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
				<li class="breadcrumb-item active" aria-current="page"><?=$lang['ho-so']?></li>
			</ol>
		</div>
	</nav>
	<?php if($jatbi->permission('parents.add','button')==true || $jatbi->permission('parents.delete','button')==true){?>
		<div class="fixed-action-btn">
			<a class="btn btn-large btn-primary rounded-circle">
				<i class="fas fa-bars" aria-hidden="true"></i>
			</a>
			<ul>
				<?php if($jatbi->permission('parents.delete','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/profiles/parents-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
				<?php }?>
				<?php if($jatbi->permission('parents.add','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-info" data-url="/profiles/parents-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
							3
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
								<?php if($jatbi->permission('parents.delete','button')==true){?>
									<th width="1%" class="text-center">
										<div class="form-check">
											<input class="form-check-input selectall" type="checkbox" value="" id="all">
											<label class="form-check-label" for="all">
											</label>
										</div>
									</th>
								<?php }?>
								<th width="50"></th>
								<th>Tên</th>
								<th>Năm sinh</th>
								<th>Số điện thoại</th>				        					       
								<th>Loại phụ huynh</th>
								<th>Địa chỉ</th>	

								<th><?=$lang['trang-thai']?></th>
								<?php if($jatbi->permission('parents.edit','button')==true){?>
									<th width="2%"></th>
								<?php }?>
							</tr>
						</thead>
						<tbody>

							<?php foreach($datas as $data){
								if($data['name']!=""){
								?>
								<tr>
									<?php if($jatbi->permission('parents.delete','button')==true){?>
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
									<td><?=$data['birthday']?></td>
									<td><?=$data['phone_number']?></td>

									<td><?=$data['type']?></td>
									<td><?=$data['address'],", ", $database->get("ward", "name",["id"=>$data['ward']]),
									", ",$database->get("district", "name",["id"=>$data['district']]),
									", ",$database->get("province", "name",["id"=>$data['province']])?></td>


									<td>	
										<div class="form-check form-switch">
											<input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/profiles/parents-status/<?=$data['id']?>/">
											<label class="form-check-label" for="status"></label>
										</div>
									</td>
									<?php if($jatbi->permission('parents.edit','button')==true){?>
										<td>
				            		<a class="btn btn-sm btn-light modal-url <?=$data['face']==0?'text-dark':'text-success'?>" aria-hidden="true" data-url="/profiles/parents-face/<?=$data['id']?>/"><i class="fas fa-grin-hearts"></i></a>
				            	</td>
				            	<td>
				            		<a href="#!" data-url="/profiles/parents-face-delete/<?=$data['id']?>/" class="modal-url"><i class="fas fa-meh-blank"></i></a>
				            					            </td>
										<td>
											<a class="btn btn-sm btn-light modal-url" data-url="/profiles/parents-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
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
<?php if($router['1']=='parents-face'){?>
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
<?php if($router['1']=='parents-add' || $router['1']=='parents-edit'){?>
	<div class="modal fade modal-load" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><?=$router['1']=='parents-add'?$lang['them']:$lang['sua']?> Phụ huynh</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
					<div class="modal-body">
						<div class="row">
							<div class="col-sm-6">
								<div class="mb-3">
									<label><?=$lang['ho-ten']?><small class="text-danger">*</small></label>
									<input placeholder="<?=$lang['ho-ten']?>" type="text" name="name" value="<?=$data['name']?>" class="form-control">
								</div>
								<div class="mb-3">
									<label><?=$lang['so-dien-thoai']?><small class="text-danger">*</small></label>
									<input placeholder="<?=$lang['so-dien-thoai']?>" type="text" name="phone_number" value="<?=$data['phone_number']?>" class="form-control">
								</div>				  		        	
								<div class="mb-3">
									<label><?=$lang['mat-khau']?><small class="text-danger">*</small></label>
									<input placeholder="<?=$lang['mat-khau']?>" type="password" name="password" class="form-control">
								</div>
								<div class="mb-3">
									<label><?=$lang['loai-phu-huynh']?><small class="text-danger">*</small></label>
									<select name="type" class="select2 form-control" style="width:100%">
										<?php if(isset($data['type'])){ ?>
											<option value="<?=$data['type']?>"  selected ><?=$data['type']?></option>
										<?php } else {?>
											<option value="" disabled selected >Chọn</option>
										<?php } ?>						   
										<option value="Ông" >Ông</option>
										<option value="Bà" >Bà</option>
										<option value="Cha" >Cha</option>
										<option value="Mẹ" >Mẹ</option>
										<option value="Bác" >Bác</option>
										<option value="Cô" >Cô</option>
										<option value="Chú " >Chú</option>
										<option value="Anh" >Anh</option>
										<option value="Chị " >Chị</option>						    
									</select>
								</div>
								<div class="mb-3">
									<label><?=$lang['nam-sinh']?></label>
									<input placeholder="<?=$lang['nam-sinh']?>" type="text" name="birthday" value="<?=$data['birthday']?>" class="form-control">
								</div>
								<div class="mb-3">
									<label><?=$lang['cccd']?> <small class="text-danger">*</small></label>
									<input placeholder="<?=$lang['cccd']?>" type="text" name="citizenId" value="<?=$data['citizenId']?>" class="form-control">
								</div>	
							</div> 		    
							<div class="col-sm-6">
								<div class="mb-3">
									<label><?=$lang['hinh-dai-dien']?></label>
									<input type="file" class="form-control" name="avatar" value="<?=$data['avatar']?>">
								</div>
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
<?php if($router['1']=='parents-delete' || $router['1']=='parents-face-delete'){?>
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
<?php if($router['1']=='timekeeping-class'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['diem-danh-lop-hoc']?></h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
				<li class="breadcrumb-item active" aria-current="page"><?=$lang['diem-danh']?></li>
			</ol>
		</div>
	</nav>
	
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

								<th width="50"></th>
								<th><?=$lang['ten-lop']?></th>
								<th><?=$lang['khoa-hoc']?></th>

								<th><?=$lang['trang-thai']?></th>
								<?php if($jatbi->permission('class.edit','button')==true){?>
									<th width="2%"></th>
								<?php }?>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($datas as $data) { ?>
								<tr>

									<td></td>


									<td><?=$database->get("class","name",['id'=>$data['class']])?></td>		
									<td><?=$database->get("course","name",['id'=>$data['course']])?></td>			    


									<td>	
										<div class="form-check form-switch">
											<input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/profiles/class-status/<?=$data['id']?>/">
											<label class="form-check-label" for="status"></label>
										</div>
									</td>
									<?php if($jatbi->permission('timekeeping','button')==true){?>
										<td>
											<a class="btn btn-sm btn-light pjax-load" href="/profiles/timekeeping/<?=$data['id']?>/"><i class="fas fa-eye" aria-hidden="true"></i></a>
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
<?php if($router['1']=='timekeeping'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
<div class="d-flex">
			<div>
				<button type="button" class="btn btn-sm btn-light me-1" onclick="history.back();">
									<span class="svg-icon svg-icon-muted svg-icon-1">
										<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path opacity="0.3" d="M11.85 10.7L21.75 5V19L11.85 13.3C10.85 12.7 10.85 11.3 11.85 10.7Z" fill="currentColor"/>
											<path d="M3.75 10.7L13.65 5V19L3.75 13.3C2.75 12.7 2.75 11.3 3.75 10.7Z" fill="currentColor"/>
										</svg>
									</span>
								</button>
			</div>
			<div>	<?php foreach ($datas as $key => $data) {?>
				<h4><?=$lang['diem-danh']?> - Lớp <?=$data['name']?></h4>
			<?php } ?>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
				<li class="breadcrumb-item active" aria-current="page"><?=$lang['diem-danh']?></li>
			</ol></div>
			
			
		</div>
		
	</nav>
	<?php if($jatbi->permission('timekeeping.add','button')==true || $jatbi->permission('timekeeping.delete','button')==true){?>
		<div class="fixed-action-btn">
			<a class="btn btn-large btn-primary rounded-circle">
				<i class="fas fa-bars" aria-hidden="true"></i>
			</a>
			<ul>

				<?php if($jatbi->permission('timekeeping.add','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-info" data-url="/profiles/timekeeping-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
								<label><?=$lang['hoc-sinh']?></label>
								<select name="students" class="form-control select2" style="width: 100%;">
									<option value=""><?=$lang['hoc-sinh']?></option>
									<?php foreach ($students as  $students) { ?>
										<option value="<?=$students['id']?>"  <?=($xss->xss($_GET['students'])==$students['id']?'selected':'')?>><?=$students['firstname']?> <?=$students['lastname']?></option>
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
								<?php foreach ($data['students'] as $key => $students) {?>
									<tr>
										<td class="p-1 text-nowrap align-middle"><?=$students['firstname']?> <?=$students['lastname']?></td>
										<?php foreach ($students['dates'] as $key => $date) {?>
											<td class="text-nowrap p-1 <?=$date['color']?> modal-url" data-url="/profiles/timekeeping-views/<?=$students['id_arr']?>/<?=$date['date']?>/">
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
								<span>Nghỉ học có xin phép</span>
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
<?php if($router['1']=='timekeeping-add' || $router['1']=='timekeeping-edit'){?>
	<div class="modal fade modal-load" tabindex="-1">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><?=$router['1']=='timekeeping-add'?$lang['them']:$lang['sua']?> <?=$lang['diem-danh']?></h5>
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
									<label><?=$lang['hoc-sinh']?> <small class="text-danger">*</small></label>
									<select name="arrange_class" class="form-control select2" style="width: 100%;">
										<option value=""><?=$lang['hoc-sinh']?></option>
										<?php foreach ($arrange_class as $students) { 
											$student=$database->get("students","*",['id'=>$students['students']]);
											?>
											<option value="<?=$students['id']?>"  <?=($xss->xss($data['arrange_class'])==$students['id']?'selected':'')?>><?=$student['firstname']?> <?=$student['lastname']?></option>
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
<?php if($router['1']=='timekeeping-views'){?>
	<div class="modal fade modal-load" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><?=$lang['nhat-ky-diem-danh']?>: <?=$students['firstname'];?> <?=$students['lastname'];?>- <?=date($setting['site_date'],strtotime($router['3']))?></h5>
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
								<?php $stt=1; foreach ($datas as $key => $data) { $timeLate = $database->get("timekeeping_time_late","*",["timekeeping"=>$data['id'],"deleted"=>0]);?>
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
		      					<button class="btn btn-sm text-danger click-action" data-url="/profiles/timekeeping-delete/<?=$data['id']?>/"><i class="fa fa-trash"></i></button>
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
<?php if($router['1']=='health'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['danh-sach-tinh-hinh-suc-khoe']?></h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
				<li class="breadcrumb-item active" aria-current="page"><?=$lang['ho-so']?></li>
			</ol>
		</div>
	</nav>
	<?php if($jatbi->permission('health.add','button')==true || $jatbi->permission('health.delete','button')==true){?>
		<div class="fixed-action-btn">
			<a class="btn btn-large btn-primary rounded-circle">
				<i class="fas fa-bars" aria-hidden="true"></i>
			</a>
			<ul>
				<?php if($jatbi->permission('health.delete','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/profiles/health-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
				<?php }?>
				<?php if($jatbi->permission('health.add','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-info" data-url="/profiles/health-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
								<?php if($jatbi->permission('health.delete','button')==true){?>
									<th width="1%" class="text-center">
										<div class="form-check">
											<input class="form-check-input selectall" type="checkbox" value="" id="all">
											<label class="form-check-label" for="all">
											</label>
										</div>
									</th>
								<?php }?>
								<th width="50"></th>
								<th><?=$lang['ten-hoc-sinh']?></th>
								<th><?=$lang['ngay-kham']?></th>
								<th><?=$lang['nhip-tim']?> (Nhịp/phút)</th>					        			        	
								<th><?=$lang['huyet-ap']?> (mmHg)</th>     
								<th><?=$lang['nhiet-do']?> (độ C)</th>
								<th><?=$lang['can-nang']?> (KG)</th>
								<th><?=$lang['chieu-cao']?> (CM)</th>
								<th><?=$lang['tien-su']?></th>


								<th><?=$lang['trang-thai']?></th>
								<?php if($jatbi->permission('health.edit','button')==true){?>
									<th width="2%"></th>
								<?php }?>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($datas as $data) { ?>
								<tr>
									<?php if($jatbi->permission('health.delete','button')==true){?>
										<td class="align-middle">
											<div class="form-check">
												<input class="form-check-input checker" type="checkbox" id="<?=$data['id']?>" name="BOX[<?=$data['id']?>]" value="<?=$data['id']?>">
												<label class="form-check-label" for="<?=$data['id']?>"></label>
											</div>
										</td>
									<?php }?>
									<td></td>				          				           
									<td><?=$database->get("students", "firstname",["id"=>$data['students']])?> <?=$database->get("students", "lastname",["id"=>$data['students']])?></td>
									<td><?=date("d/m/Y", strtotime($data['date']))?></td>
									<td><?=$data['heartbeat']?></td>
									<td><?=$data['blood_pressure']?></td>
									<td><?=$data['temperature']?></td>
									<td><?=$data['weight']?></td>
									<td><?=$data['height']?></td>
									<td><?=$data['prehistoric']?></td>

									<td>	
										<div class="form-check form-switch">
											<input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/profiles/health-status/<?=$data['id']?>/">
											<label class="form-check-label" for="status"></label>
										</div>
									</td>
									<?php if($jatbi->permission('health.edit','button')==true){?>
										<td>
											<a class="btn btn-sm btn-light modal-url" data-url="/profiles/health-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
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
<?php if($router['1']=='health-add' || $router['1']=='health-edit'){?>
	<div class="modal fade modal-load" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><?=$router['1']=='health-add'?$lang['them']:$lang['sua']?>thông tin sức khỏe	</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
					<div class="modal-body">
						<div class="row">
							<div class="col-sm-6">
								<div class="mb-3">
									<label>Tên học sinh<small class="text-danger">*</small></label>
									<select name="students" class="select2 form-control" style="width:100%">
										<option value="" disabled selected>Tên học sinh</option>
										<?php foreach ($students as $students) { ?>
											<option value="<?=$students['id']?>"  <?=($data['students']==$students['id']?'selected':'')?>><?=$students['id_student']?> - <?=$students['firstname']?> <?=$students['lastname']?></option>
										<?php } ?>
									</select>
								</div>	
								<div class="mb-3">
									<label><?=$lang['ngay-kham']?><small class="text-danger">*</small></label>
									<input placeholder="<?=$lang['ngay-kham']?>" type="date" name="date" value="<?=$data['date']?>" class="form-control">
								</div>
								<div class="mb-3">
									<label><?=$lang['nhip-tim']?><small class="text-danger">*</small></label>
									<input placeholder="<?=$lang['nhip-tim']?>" type="text" name="heartbeat" value="<?=$data['heartbeat']?>" class="form-control">
								</div>
								<div class="mb-3">
									<label><?=$lang['huyet-ap']?><small class="text-danger">*</small></label>
									<input placeholder="<?=$lang['huyet-ap']?>" type="text" name="blood_pressure" value="<?=$data['blood_pressure']?>" class="form-control">
								</div>
								<div class="mb-3">
									<label><?=$lang['nhiet-do']?><small class="text-danger">*</small></label>
									<input placeholder="<?=$lang['nhiet-do']?>" type="text" name="temperature" value="<?=$data['temperature']?>" class="form-control">
								</div>
							</div> 		    
							<div class="col-sm-6">	
								<div class="mb-3">
									<label><?=$lang['can-nang']?><small class="text-danger">*</small></label>
									<input placeholder="<?=$lang['can-nang']?>" type="text" name="weight" value="<?=$data['weight']?>" class="form-control">
								</div>
								<div class="mb-3">
									<label><?=$lang['chieu-cao']?><small class="text-danger">*</small></label>
									<input placeholder="<?=$lang['chieu-cao']?>" type="text" name="height" value="<?=$data['height']?>" class="form-control">
								</div>
								<div class="mb-3">
									<label><?=$lang['tien-su']?><small class="text-danger">*</small></label>
									<input placeholder="<?=$lang['tien-su']?>" type="text" name="prehistoric" value="<?=$data['prehistoric']?>" class="form-control">
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
<?php if($router['1']=='health-delete'){?>
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
<?php if($router['1']=='vaccination'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4>Danh sách tình hình vắc-xin</h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
				<li class="breadcrumb-item active" aria-current="page"><?=$lang['ho-so']?></li>
			</ol>
		</div>
	</nav>
	<?php if($jatbi->permission('vaccination.add','button')==true || $jatbi->permission('vaccination.delete','button')==true){?>
		<div class="fixed-action-btn">
			<a class="btn btn-large btn-primary rounded-circle">
				<i class="fas fa-bars" aria-hidden="true"></i>
			</a>
			<ul>
				<?php if($jatbi->permission('vaccination.delete','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/profiles/vaccination-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
				<?php }?>
				<?php if($jatbi->permission('vaccination.add','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-info" data-url="/profiles/vaccination-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
								<?php if($jatbi->permission('vaccination.delete','button')==true){?>
									<th width="1%" class="text-center">
										<div class="form-check">
											<input class="form-check-input selectall" type="checkbox" value="" id="all">
											<label class="form-check-label" for="all">
											</label>
										</div>
									</th>
								<?php }?>
								<th width="50"></th>
								<th><?=$lang['ten-hoc-sinh']?></th>
								<th><?=$lang['ten-vacxin']?></th>
								<th><?=$lang['loai-vacxin']?></th>						       
								<th><?=$lang['ngay-tiem']?></th>


								<th><?=$lang['trang-thai']?></th>
								<?php if($jatbi->permission('vaccination.edit','button')==true){?>
									<th width="2%"></th>
								<?php }?>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($datas as $data) { ?>
								<tr>
									<?php if($jatbi->permission('vaccination.delete','button')==true){?>
										<td class="align-middle">
											<div class="form-check">
												<input class="form-check-input checker" type="checkbox" id="<?=$data['id']?>" name="BOX[<?=$data['id']?>]" value="<?=$data['id']?>">
												<label class="form-check-label" for="<?=$data['id']?>"></label>
											</div>
										</td>
									<?php }?>
									<td></td>				          				           
									<td><?=$database->get("students", "firstname",["id"=>$data['students']])?> <?=$database->get("students", "lastname",["id"=>$data['students']])?></td>
									<td><?=$data['name']?></td>
									<td><?=$data['namevacxin']?></td>
									<td><?=date("d/m/Y", strtotime($data['date']))?></td>



									<td>	
										<div class="form-check form-switch">
											<input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/profiles/vaccination-status/<?=$data['id']?>/">
											<label class="form-check-label" for="status"></label>
										</div>
									</td>
									<?php if($jatbi->permission('vaccination.edit','button')==true){?>
										<td>
											<a class="btn btn-sm btn-light modal-url" data-url="/profiles/vaccination-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
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
<?php if($router['1']=='vaccination-add' || $router['1']=='vaccination-edit'){?>
	<div class="modal fade modal-load" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><?=$router['1']=='vaccination-add'?$lang['them']:$lang['sua']?>thông tin tiêm vắc-xin</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
					<div class="modal-body">
						<div class="row">
							<div class="col-sm-6">
								<div class="mb-3">
									<label>Tên học sinh<small class="text-danger">*</small></label>
									<select name="students" class="select2 form-control" style="width:100%">
										<option value="" disabled selected>Tên học sinh</option>
										<?php foreach ($students as $students) { ?>
											<option value="<?=$students['id']?>"  <?=($data['students']==$students['id']?'selected':'')?>><?=$students['id_student']?> - <?=$students['firstname']?> <?=$students['lastname']?></option>
										<?php } ?>
									</select>
								</div>	
								<div class="mb-3">
									<label>Tên vắc-xin<small class="text-danger">*</small></label>
									<input placeholder="Tên vắc-xin" type="text" name="name" value="<?=$data['name']?>" class="form-control">
								</div>
								<div class="mb-3">
									<label>Loại vắc-xin<small class="text-danger">*</small></label>
									<input placeholder="Loại vắc-xin" type="text" name="namevacxin" value="<?=$data['namevacxin']?>" class="form-control">
								</div>



							</div> 		    
							<div class="col-sm-6">	
								<div class="mb-3">
									<label>Ngày tiêm<small class="text-danger">*</small></label>
									<input placeholder="Ngày khám" type="date" name="date" value="<?=$data['date']?>" class="form-control">
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
<?php if($router['1']=='vaccination-delete'){?>
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
<?php if($router['1']=='point'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['diem-hoc-sinh']?></h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
				<li class="breadcrumb-item active" aria-current="page"><?=$lang['ho-so']?></li>
			</ol>
		</div>
	</nav>
	<?php if($jatbi->permission('point.add','button')==true || $jatbi->permission('point.delete','button')==true){?>
		<div class="fixed-action-btn">
			<a class="btn btn-large btn-primary rounded-circle">
				<i class="fas fa-bars" aria-hidden="true"></i>
			</a>
			<ul>
				<?php if($jatbi->permission('point.delete','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/profiles/point-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
				<?php }?>
				<?php if($jatbi->permission('point.add','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-info" data-url="/profiles/point-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
							<div class="filer-item date">
					    	<label><?=$lang['ngay']?></label>
					    	<input type="text" class="form-control float-right daterange-select" name="date" value="<?=date('d/m/Y',strtotime($date_from))?> - <?=date('d/m/Y',strtotime($date_to))?>">
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
								<?php if($jatbi->permission('point.delete','button')==true){?>
									<th width="1%" class="text-center">
										<div class="form-check">
											<input class="form-check-input selectall" type="checkbox" value="" id="all">
											<label class="form-check-label" for="all">
											</label>
										</div>
									</th>
								<?php }?>
								<th width="50"></th>
								<th><?= $lang['ngay-nhap']?></th>	
								<th><?= $lang['ma-hoc-sinh']?></th>
								<th><?= $lang['hoc-sinh']?></th>
								<th><?= $lang['lop']?></th>
								<th><?= $lang['hoc-ki']?></th>
								<th><?= $lang['khoa-hoc']?></th>
								<th><?= $lang['mon-hoc']?></th>	
								<th><?= $lang['diem']?></th>
								<th><?= $lang['loai-diem']?></th>

								<th><?=$lang['trang-thai']?></th>
								<?php if($jatbi->permission('point.edit','button')==true){?>
									<th width="2%"></th>
								<?php }?>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($datas as $data) { ?>
								<tr>
									<?php if($jatbi->permission('point.delete','button')==true){?>
										<td class="align-middle">
											<div class="form-check">
												<input class="form-check-input checker" type="checkbox" id="<?=$data['id']?>" name="BOX[<?=$data['id']?>]" value="<?=$data['id']?>">
												<label class="form-check-label" for="<?=$data['id']?>"></label>
											</div>
										</td>
									<?php }?>
									<td></td>
									<td><?=date("d/m/Y", strtotime($data['date']))?></td>	
									<td><?=$database->get("students","id_student",["id"=>$database->get("arrange_class","students",['id'=>$data['arrange_class']])])?></td>	
									<td><?=$database->get("students", "firstname",["id"=>$database->get("arrange_class","students",['id'=>$data['arrange_class']])])?> <?=$database->get("students", "lastname",["id"=>$database->get("arrange_class","students",['id'=>$data['arrange_class']])])?></td>		            
									<td><?=$database->get("class", "name",[
										"id"=>$database->get("class_diagram","class",[
											'id'=>$database->get("arrange_class","class_diagram",[
												'id'=>$data['arrange_class']])])])
											?></td>
											<td><?=$database->get("semester", "name",["id"=>$database->get("assigning_teachers","semester",['id'=>$data['assigning_teachers']])])?></td>
											<td><?=$database->get("course", "name",["id"=>$database->get("semester","course",["id"=>$database->get("assigning_teachers","semester",['id'=>$data['assigning_teachers']])])])?></td>
											<td><?=$database->get("subject", "name",["id"=>$database->get("assigning_teachers","subject",['id'=>$data['assigning_teachers']])])?></td>
											<td><?=$data['score']?></td>
											<td><?=$database->get("typescore", "name",["id"=>$data['typescore']])?></td>





											<td>	
												<div class="form-check form-switch">
													<input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/profiles/point-status/<?=$data['id']?>/">
													<label class="form-check-label" for="status"></label>
												</div>
											</td>
											<?php if($jatbi->permission('point.edit','button')==true){?>
												<td>
													<a class="btn btn-sm btn-light modal-url" data-url="/profiles/point-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
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
<?php if($router['1']=='point-add'){?>
			<div class="modal fade modal-load" tabindex="-1">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title"><?=$router['1']=='point-add'?$lang['them']:$lang['sua']?><?=$lang['diem']?></h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
							<div class="modal-body">
								<div class="row">
									<div class="col-sm-6">
										<div class="mb-3">
											<label><?= $lang['lop-hoc']?><small class="text-danger">*</small></label>
											<select name="class_course" class="select2 form-control class-course" style="width:100%">
												<option value="" disabled selected><?=$lang['chon-lop']?></option>
												<?php foreach ($class_course as $class_courses) { ?>
													<option value="<?=$class_courses['id']?>" <?=($data['class_diagram']==$class_courses['id']?'selected':'')?>><?=$database->get("class","name",['id'=>$class_courses['class']])?> (<?=$database->get("course","name",['id'=>$class_courses['course']])?>)
													</option>
												<?php } ?>
											</select>
										</div>	
										<!-- <div class="mb-3">
											<label><?= $lang['hoc-sinh']?><small class="text-danger">*</small></label>
											<select name="students" class="select2 form-control areas-students" style="width:100%">
												<option value="" disabled selected><?= $lang['hoc-sinh']?></option>
												<?php foreach ($arrange_class as $arrange_classs) { ?>
													<option value="<?=$arrange_classs['id']?>"  <?=($data['arrange_class']==$arrange_classs['id']?'selected':'')?>><?=$database->get("students","firstname",['id'=>$arrange_classs['students']])?> <?=$database->get("students","lastname",['id'=>$arrange_classs['students']])?></option>
												<?php } ?>
											</select>
										</div>   -->
										<div class="mb-3">
											<label><?= $lang['mon-hoc']?><small class="text-danger">*</small></label>
											<select name="assigning_teachers" class="select2 form-control areas-subjects" style="width:100%">
												<option value="" disabled selected><?= $lang['mon-hoc']?></option>
												<?php foreach ($subject as $subject) { ?>
													<option value="<?=$subject['id']?>"  <?=($data['subject']==$subject['id']?'selected':'')?>><?=$subject['name']?></option>
												<?php } ?>
											</select>
										</div>     	
									</div> 		    
									<div class="col-sm-6">

										<div class="mb-3">
											<label><?= $lang['loai-diem']?><small class="text-danger">*</small></label>
											<select name="typescore" class="select2 form-control" style="width:100%">
												<option value="" disabled selected><?= $lang['loai-diem']?></option>
												<?php foreach ($typescore as $typescore) { ?>
													<option value="<?=$typescore['id']?>"  <?=($data['typescore']==$typescore['id']?'selected':'')?>><?=$typescore['name']?></option>
												<?php } ?>
											</select>
										</div>
										<!-- <div class="mb-3">
											<label><?= $lang['diem']?><small class="text-danger">*</small></label>
											<input placeholder="<?= $lang['diem']?>" type="text" name="score" value="<?=$data['score']?>" class="form-control">
										</div> -->
										<div class="mb-3">
											<label><?=$lang['trang-thai']?> <small class="text-danger">*</small></label>
											<select name="status" class="select2 form-control" style="width:100%">
												<option value="A" <?=($data['status']=='A'?'selected':'')?>><?=$lang['kich-hoat']?></option>
												<option value="D" <?=($data['status']=='D'?'selected':'')?>><?=$lang['khong-kich-hoat']?></option>
											</select>
										</div>	
									</div>
								</div>
								<table class="table table-questions-list">
									<thead>
										<tr>
											<th><?=$lang['hoc-sinh']?></th>
											<th><?=$lang['diem-so']?></th>
											<th><a href="#" class="text-primary add-row"><i class="fas fa-plus"></i></a></th>
										</tr>
									</thead>
									<tbody class="areas-students">
								
									</tbody>
								</table>
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
				$('.add-row').on('click',function(){
					$('.table-questions-list tbody tr:last').clone().appendTo('.table-questions-list tbody').find('input').val('');
					$('.table-questions-list tbody tr:last').show();
			  	});
			  	$(document).on('click','.deleted-row', function(){
			        $(this).parents('tr').hide();
			        $(this).parents('tr').find(".delete").val("1");
			    });
			</script>
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
<?php if($router['1']=='point-edit'){?>
			<div class="modal fade modal-load" tabindex="-1">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title"><?=$router['1']=='point-add'?$lang['them']:$lang['sua']?><?=$lang['diem']?></h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
							<div class="modal-body">
								<div class="row">
									<div class="col-sm-6">	
										<div class="mb-3">
											<label><?= $lang['hoc-sinh']?><small class="text-danger">*</small></label>
											<select name="students" class="select2 form-control areas-students" style="width:100%">
												<option value="" disabled selected><?= $lang['hoc-sinh']?></option>
												<?php foreach ($arrange_class as $arrange_classs) { ?>
													<option value="<?=$arrange_classs['id']?>"  <?=($data['arrange_class']==$arrange_classs['id']?'selected':'')?>><?=$database->get("students","firstname",['id'=>$arrange_classs['students']])?> <?=$database->get("students","lastname",['id'=>$arrange_classs['students']])?></option>
												<?php } ?>
											</select>
										</div>
										<div class="mb-3">
											<label><?= $lang['mon-hoc']?><small class="text-danger">*</small></label>
											<select name="assigning_teachers" class="select2 form-control areas-subjects" style="width:100%">
												<option value="" disabled selected><?= $lang['mon-hoc']?></option>
												<?php foreach ($assigning_teachers as $assigning_teachers) { ?>
													<option value="<?=$assigning_teachers['id']?>"  <?=($data['assigning_teachers']==$assigning_teachers['id']?'selected':'')?>><?=$database->get("subject","name",['id'=>$assigning_teachers['subject']])?></option>
												<?php } ?>
											</select>
										</div>       	
									</div> 		    
									<div class="col-sm-6">

										<div class="mb-3">
											<label><?= $lang['loai-diem']?><small class="text-danger">*</small></label>
											<select name="typescore" class="select2 form-control" style="width:100%">
												<option value="" disabled selected><?= $lang['loai-diem']?></option>
												<?php foreach ($typescore as $typescore) { ?>
													<option value="<?=$typescore['id']?>"  <?=($data['typescore']==$typescore['id']?'selected':'')?>><?=$typescore['name']?></option>
												<?php } ?>
											</select>
										</div>
										<div class="mb-3">
											<label><?= $lang['diem']?><small class="text-danger">*</small></label>
											<input placeholder="<?= $lang['diem']?>" type="text" name="score" value="<?=$data['score']?>" class="form-control">
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
		<?php if($router['1']=='point-delete'){?>
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
<?php if($router['1']=='furlough-delete'){?>
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
<?php if($router['1']=='furlough'){?>
			<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
				<div class="">
					<h4><?=$lang['danh-sach-nghi-phep']?></h4>
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
						<li class="breadcrumb-item active" aria-current="page"><?=$lang['ho-so']?></li>
					</ol>
				</div>
			</nav>
			<?php if($jatbi->permission('furlough.add','button')==true || $jatbi->permission('furlough.delete','button')==true){?>
				<div class="fixed-action-btn">
					<a class="btn btn-large btn-primary rounded-circle">
						<i class="fas fa-bars" aria-hidden="true"></i>
					</a>
					<ul>
						<?php if($jatbi->permission('furlough.delete','button')==true){?>
							<li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/profiles/furlough-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
						<?php }?>
					</ul>
				</div>
			<?php }?>
			<div class="card card-custom">
				<div class="card-body">
					<form method="GET" class="pjax-content mb-4 search-form">
						<div class="form-group col-4">
							<input placeholder="<?=$lang['tim-kiem']?>" type="text" name="lastname" value="<?=$xss->xss($_GET['lastname'])?>" class="form-control">
						</div>
						<div class="form-group">
							<div class="dropdown">
								<button class="border dropdown-toggle w-100 filler" type="button" id="fillers" data-bs-auto-close="false" data-bs-toggle="dropdown" aria-expanded="false">
									<i class="fas fa-filter"></i> <?=$lang['them-dieu-kien-loc']?>
								</button>
								<div class="dropdown-menu filler-details p-3" aria-labelledby="fillers">
									<p class="mb-2"><?=$lang['tim-kiem-theo-dieu-kien']?></p>
									
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
										<?php if($jatbi->permission('furlough.delete','button')==true){?>
											<th width="1%" class="text-center">
												<div class="form-check">
													<input class="form-check-input selectall" type="checkbox" value="" id="all">
													<label class="form-check-label" for="all">
													</label>
												</div>
											</th>
										<?php }?>
										<th width="50"></th>
										<th><?=$lang['ngay-xin-nghi']?></th>
										<th><?=$lang['ten-hoc-sinh']?></th>
										<th><?=$lang['so-ngay-nghi']?></th>
										<th><?=$lang['ngay-bat-dau']?></th>
										<th><?=$lang['ngay-ket-thuc']?></th>				        
										<th><?=$lang['ly-do-nghi']?></th>
										<th><?=$lang['tinh-trang']?></th>
										<th><?=$lang['trang-thai']?></th>

									</tr>
								</thead>
								<tbody>
									<?php foreach ($datas as $data) { ?>
										<tr>
											<?php if($jatbi->permission('furlough.delete','button')==true){?>
												<td class="align-middle">
													<div class="form-check">
														<input class="form-check-input checker" type="checkbox" id="<?=$data['id']?>" name="BOX[<?=$data['id']?>]" value="<?=$data['id']?>">
														<label class="form-check-label" for="<?=$data['id']?>"></label>
													</div>
												</td>
											<?php }?>
											<td></td>
											<td><?=date("d/m/Y", strtotime($data['datecurrent']))?></td>
											<td><?=$database->get("students", "firstname",["id"=>$database->get("arrange_class","students",['id'=>$data['arrange_class']])])?> <?=$database->get("students", "lastname",["id"=>$database->get("arrange_class","students",['id'=>$data['arrange_class']])])?></td>
											<td><?=$data['numberday']?></td>
											<td><?=date("d/m/Y", strtotime($data['date_start']))?></td>
											<td><?=date("d/m/Y", strtotime($data['date_end']))?></td>			            
											<td><?=$data['reason']?></td>	
											<?php if($data['statu']=="A"){
												?>
												<td><span class="font-weight-bold text-danger"><?=$lang['chua-duyet']?></span></td>		         
											<?}elseif($data['statu']=="D"){?>		      
													<td><strong style="color:green;" class="font-weight-bold "><?=$lang['da-duyet']?></strong></td>	
											<?}elseif($data['statu']=="C"){?>		      
													<td><span class="font-weight-bold text-danger"><?=$lang['khong-duyet']?></span></td>			
											<?php }?>     
												<td>	
													<div class="form-check form-switch">
														<input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/profiles/furlough-status/<?=$data['id']?>/">
														<label class="form-check-label" for="status"></label>
													</div>
												</td>
												<?php if($jatbi->permission('furlough.edit','button')==true){?>
													<td>
														<a class="btn btn-sm btn-light modal-url" data-url="/profiles/furlough-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
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
<?php if($router['1']=='furlough-edit'){?>
				<div class="modal fade modal-load" tabindex="-1">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title"><?=$lang['xac-nhan-nghi-phep']?></h5>
								<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
							</div>
							<form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
								<div class="modal-body">
									<div class="row">
										<div class="col-sm-6">
											<div class="mb-3">
												<label><?=$lang['ngay-gui']?><small class="text-danger">*</small></label>
												<input placeholder="<?=$lang['ngay-gui']?>" type="date" name="datecurrent" value="<?=$data['datecurrent']?>" class="form-control" readonly>
											</div>
											<div class="mb-3">
												<label><?=$lang['ngay-bat-dau']?><small class="text-danger">*</small></label>
												<input placeholder="<?=$lang['ngay-bat-dau']?>" type="date" name="date_start" value="<?=$data['date_start']?>" class="form-control" readonly>
											</div>
											<div class="mb-3">
												<label><?=$lang['ngay-ket-thuc']?><small class="text-danger">*</small></label>
												<input placeholder="<?=$lang['ngay-ket-thuc']?>" type="date" name="date_end" value="<?=$data['date_end']?>" class="form-control" readonly>
											</div>

											<div class="mb-3">
												<label><?=$lang['so-ngay-nghi']?><small class="text-danger">*</small></label>
												<input placeholder="<?=$lang['so-ngay-nghi']?>" type="text" name="numberday" value="<?=$data['numberday']?>" class="form-control" readonly>
											</div>
										</div> 		    
										<div class="col-sm-6">	
											<div class="mb-3">
												<label><?= $lang['hoc-sinh']?><small class="text-danger">*</small></label>
												<select name="arrange_class" class="select2 form-control areas-students" style="width:100%">

													<option value="<?=$data['arrange_class']?>" selected><?=$database->get("students","firstname",['id'=>$database->get('arrange_class','students',['id'=>$data['arrange_class']])])?> <?=$database->get("students","lastname",['id'=>$database->get('arrange_class','students',['id'=>$data['arrange_class']])])?></option>

												</select>
											</div> 
											<div class="mb-3">
												<label><?=$lang['ly-do-nghi']?><small class="text-danger">*</small></label>
												<input placeholder="<?=$lang['ly-do-nghi']?>" type="text" name="reason" value="<?=$data['reason']?>" class="form-control" readonly>
											</div>
											<div class="mb-3">
												<label><?=$lang['tinh-trang']?> <small class="text-danger">*</small></label>
												<select name="statu" class="select2 form-control" style="width:100%">
													<option value="A" <?=($data['statu']=='A'?'selected':'')?>><?=$lang['chua-duyet']?></option>
													<option value="D" <?=($data['statu']=='D'?'selected':'')?>><?=$lang['da-duyet']?></option>
													<option value="C" <?=($data['statu']=='C'?'selected':'')?>><?=$lang['khong-duyet']?></option>
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
<?php if($router['1']=='priority_object'){?>
				<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
					<div class="">
						<h4><?=$lang['danh-sach-doi-tuong']?></h4>
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
							<li class="breadcrumb-item active" aria-current="page"><?=$lang['ho-so']?></li>
						</ol>
					</div>
				</nav>
				<?php if($jatbi->permission('priority_object.add','button')==true || $jatbi->permission('priority_object.delete','button')==true){?>
					<div class="fixed-action-btn">
						<a class="btn btn-large btn-primary rounded-circle">
							<i class="fas fa-bars" aria-hidden="true"></i>
						</a>
						<ul>
							<?php if($jatbi->permission('priority_object.delete','button')==true){?>
								<li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/profiles/priority_object-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
							<?php }?>
							<?php if($jatbi->permission('priority_object.add','button')==true){?>
								<li><a class="modal-url btn rounded-circle btn-info" data-url="/profiles/priority_object-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
											<?php if($jatbi->permission('priority_object.delete','button')==true){?>
												<th width="1%" class="text-center">
													<div class="form-check">
														<input class="form-check-input selectall" type="checkbox" value="" id="all">
														<label class="form-check-label" for="all">
														</label>
													</div>
												</th>
											<?php }?>
											<th width="50"></th>
											<th>Tên</th>
											<th>Miễn giảm(%)</th>		
											<th><?=$lang['trang-thai']?></th>
											<?php if($jatbi->permission('priority_object.edit','button')==true){?>
												<th width="2%"></th>
											<?php }?>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($datas as $data) { ?>
											<tr>
												<?php if($jatbi->permission('priority_object.delete','button')==true){?>
													<td class="align-middle">
														<div class="form-check">
															<input class="form-check-input checker" type="checkbox" id="<?=$data['id']?>" name="BOX[<?=$data['id']?>]" value="<?=$data['id']?>">
															<label class="form-check-label" for="<?=$data['id']?>"></label>
														</div>
													</td>
												<?php }?>
												<td></td>


												<td><?=$data['name']?></td>
												<td><?=$data['exemptions']?></td>



												<td>	
													<div class="form-check form-switch">
														<input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/profiles/priority_object-status/<?=$data['id']?>/">
														<label class="form-check-label" for="status"></label>
													</div>
												</td>
												<?php if($jatbi->permission('priority_object.edit','button')==true){?>
													<td>
														<a class="btn btn-sm btn-light modal-url" data-url="/profiles/priority_object-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
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
<?php if($router['1']=='priority_object-add' || $router['1']=='priority_object-edit'){?>
				<div class="modal fade modal-load" tabindex="-1">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title"><?=$router['1']=='priority_object-add'?$lang['them']:$lang['sua']?><?=$lang['doi-tuong']?></h5>
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
											<div class="mb-3">
												<label><?=$lang['mien-giam']?><small class="text-danger">*</small></label>
												<input placeholder="<?=$lang['mien-giam']?>" type="number" name="exemptions" value="<?=$data['exemptions']?>" class="form-control">
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
<?php if($router['1']=='priority_object-delete'){?>
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
<?php if($router['1']=='profiles'){?>
				<div class="container">
					<!--begin::Toolbar-->
					<div id="kt_app_toolbar" class="app-toolbar py-1 py-lg-6">
						<!--begin::Toolbar container-->
						<div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
							<!--begin::Page title-->
							<div class="page-title d-flex justify-content-center flex-wrap me-1">
								<button type="button" class="btn btn-sm btn-light me-1" onclick="history.back();">
									<span class="svg-icon svg-icon-muted svg-icon-1">
										<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path opacity="0.3" d="M11.85 10.7L21.75 5V19L11.85 13.3C10.85 12.7 10.85 11.3 11.85 10.7Z" fill="currentColor"/>
											<path d="M3.75 10.7L13.65 5V19L3.75 13.3C2.75 12.7 2.75 11.3 3.75 10.7Z" fill="currentColor"/>
										</svg>
									</span>
								</button>
								<div>
									<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0"><?=$lang['thong-tin']?> <?=$datas['firstname']?> <?=$datas['lastname']?></h1>
									<!--end::Title-->
									<!--begin::Breadcrumb-->
									<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
										
										
									</ul>
									<!--end::Breadcrumb-->
								</div>
							</div>
							<!--end::Page title-->
						</div>
						<!--end::Toolbar container-->
					</div>
					<!--end::Toolbar-->
				</div>
				<div class="app-container container">
					<div class="card card-custom ">
						<div class="card-body pb-0">
							<div class="row mb-3">
								<div class="col-lg-3">
									
									<div class="d-flex justify-content-center mb-4">
										<img class="w-75 rounded-circle" src="<?=$datas['avatar']?>" alt="image">
									</div>
									<div class="text-center">
										<div class="mb-2 fs-6"><b><?=$datas['firstname']?> <?=$datas['lastname']?></b></div>
										<div class="mb-2"><?=$datas['id_student']?></div>
									</div>
								</div>
								<div class="col-lg-9">
									<div class="d-lg-flex justify-content-between align-items-start">
										<div class="fs-5 fw-bold text-dark">HỌC SINH</div>
										
									</div>
									
									<div class="d-flex flex-wrap flex-stack mt-4">
										<div class="col-6">Mã học sinh: <b><?=$datas['id_student']?></b></div>
										<div class="col-6">Họ và tên: <b><?=$datas['firstname']?> <?=$datas['lastname']?></b></div>
									</div>
									<div class="d-flex flex-wrap flex-stack mt-2">
										<div class="col-6">Giới tính: <b><?=$datas['gender']?></b></div>
										<div class="col-6">Sinh nhật: <b><?=date("d/m/Y", strtotime($datas['birthday']))?></b></div>
									</div>
									<div class="d-flex flex-wrap flex-stack mt-2">
										<div class="col-6">Phụ huynh: <b><?=$database->get('parent','name',["id"=>$datas['parent']])?></b></div>
										<div class="col-6">Số điện thoại phụ huynh: <b><?=$database->get('parent','phone_number',["id"=>$datas['parent']])?></b></div>
									</div>
									
									<div class="d-flex flex-wrap flex-stack mt-2">
										<div class="col-6">Ngày nhập học: <b><?=date("d/m/Y", strtotime($datas['year_of_admission']))?></b></div>
										<div class="col-6">Bảo hiểm y tế: <b><?=$datas['health_insurance_id']?></b></div>
									</div>
									<div class="d-flex flex-wrap flex-stack mt-2">
										<div class="col-6">Bảo hiểm thân thể: <b><?=$datas['body_insurance_id']?></b></div>
										<div class="col-6">Tôn giáo: <b><?=$database->get('religion','name',["id"=>$datas['religion']])?></b></div>
									</div>
									<div class="d-flex flex-wrap flex-stack mt-2">
										<div class="col-6">Dân tộc: <b><?=$database->get('ethnic','name',["id"=>$datas['ethnic']])?></b></div>
										<div class="col-6">Quốc tịch: <b><?=$database->get('nationality','name',["id"=>$datas['nationality']])?></b></div>
									</div>
									<div class="d-flex flex-wrap flex-stack mt-2">
										<div class="col-12">Địa chỉ hiện tại: <b><?=$datas['address']?>, <?=$database->get('ward','name',["id"=>$datas['ward']])?>, <?=$database->get('district','name',["id"=>$datas['district']])?>, <?=$database->get('province','name',["id"=>$datas['province']])?></b></div>
									</div>
									<div class="d-flex flex-wrap flex-stack mt-2">
										<div class="col-12">Đối tượng: <b><?=$database->get('priority_object','name',["id"=>$datas['priority_object']])?></b></div>
									</div>
									<div class="d-flex flex-wrap flex-stack mt-2">
										<div class="col-12">Sở thích: <b><?=$datas['hobby']?></b></div>
									</div>
									<div class="d-flex flex-wrap flex-stack mt-2">
										<div class="col-12">Dị ứng: <b><?=$database->get('allergy','name',["id"=>$datas['allergy']])?></b></div>
									</div>
									
								</div>
							</div>
						</div>
					</div>

					
					<div class="card card-custom mt-5">
						<div class="card-body pb-0">
							<div class="d-lg-flex justify-content-between align-items-start mb-4">
								<div class="fs-5 fw-bold text-dark">CÁC LỚP HỌC SINH</div>
								
							</div>
							<table class="table table-striped table-hover">
								<thead>
									<tr>
										<th>
											<input type="checkbox" id="check">
										</th>
										<th scope="col">STT</th>
										<th scope="col">Lớp học</th>
										<th scope="col">Giáo viên chủ nhiệm</th>
										<th scope="col">Khóa học</th>
										<th scope="col">Khối học</th>
										<th scope="col">Ngày vào học</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($arrange_classs as $data) {
										$t+=1;
										$class_diagram=$database->get("class_diagram","*",["id"=>$data['class_diagram']]);
									?>
									<tr>
										<td>
											<input type="checkbox" id="check">
										</td>
										<th scope="row"><?=$t?></th>
										<td><?=$database->get("class","name",["id"=>$class_diagram['class']])?></td>
										<td><?=$database->get("teacher","firstname",["id"=>$class_diagram['homeroom_teacher']])?> <?=$database->get("teacher","lastname",["id"=>$class_diagram['homeroom_teacher']])?></td>
										<td><?=$database->get("course","name",["id"=>$class_diagram['course']])?></td>
										<td><?=$database->get("grade","name",["id"=>$class_diagram['grade']])?></td>
										<td><?=date("d/m/Y", strtotime($data['date']))?></td>
									</tr>
								<?php }?>
								</tbody>
							</table>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-3">

						</div>
						<div class="col-lg-9"></div>
					</div>
				</div>
<?php } ?>
<?php if($router['1']=='allergy'){?>
				<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
					<div class="">
						<h4><?=$lang['danh-sach-cac-loai-di-ung']?></h4>
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
							<li class="breadcrumb-item active" aria-current="page"><?=$lang['ho-so']?></li>
						</ol>
					</div>
				</nav>
				<?php if($jatbi->permission('allergy.add','button')==true || $jatbi->permission('allergy.delete','button')==true){?>
					<div class="fixed-action-btn">
						<a class="btn btn-large btn-primary rounded-circle">
							<i class="fas fa-bars" aria-hidden="true"></i>
						</a>
						<ul>
							<?php if($jatbi->permission('allergy.delete','button')==true){?>
								<li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/profiles/allergy-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
							<?php }?>
							<?php if($jatbi->permission('allergy.add','button')==true){?>
								<li><a class="modal-url btn rounded-circle btn-info" data-url="/profiles/allergy-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
											<?php if($jatbi->permission('allergy.delete','button')==true){?>
												<th width="1%" class="text-center">
													<div class="form-check">
														<input class="form-check-input selectall" type="checkbox" value="" id="all">
														<label class="form-check-label" for="all">
														</label>
													</div>
												</th>
											<?php }?>
											<th width="50"></th>
											<th>Tên</th>
											
											<th><?=$lang['trang-thai']?></th>
											<?php if($jatbi->permission('allergy.edit','button')==true){?>
												<th width="2%"></th>
											<?php }?>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($datas as $data) { ?>
											<tr>
												<?php if($jatbi->permission('allergy.delete','button')==true){?>
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
														<input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/profiles/allergy-status/<?=$data['id']?>/">
														<label class="form-check-label" for="status"></label>
													</div>
												</td>
												<?php if($jatbi->permission('allergy.edit','button')==true){?>
													<td>
														<a class="btn btn-sm btn-light modal-url" data-url="/profiles/allergy-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
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
<?php if($router['1']=='allergy-add' || $router['1']=='allergy-edit'){?>
				<div class="modal fade modal-load" tabindex="-1">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title"><?=$router['1']=='allergy-add'?$lang['them']:$lang['sua']?><?=$lang['di-ung']?></h5>
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
<?php if($router['1']=='allergy-delete'){?>
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