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
<?php if($router['1']=='car'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['danh-sach-xe']?></h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
				<li class="breadcrumb-item active" aria-current="page"><?=$lang['dich-vu']?></li>
			</ol>
		</div>
	</nav>
	<?php if($jatbi->permission('car.add','button')==true || $jatbi->permission('car.delete','button')==true){?>
		<div class="fixed-action-btn">
			<a class="btn btn-large btn-primary rounded-circle">
				<i class="fas fa-bars" aria-hidden="true"></i>
			</a>
			<ul>
				<?php if($jatbi->permission('car.delete','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/car_driver/car-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
				<?php }?>
				<?php if($jatbi->permission('car.add','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-info" data-url="/car_driver/car-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
								<?php if($jatbi->permission('car.delete','button')==true){?>
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
								<th>Số khung</th>
								<th>Loại xe</th>
								<th>Hãng xe</th>				        					        
								<th>Biển số</th>	
								<th><?=$lang['trang-thai']?></th>
								<?php if($jatbi->permission('car.edit','button')==true){?>
									<th width="2%"></th>
								<?php }?>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($datas as $data) { ?>
								<tr>
									<?php if($jatbi->permission('car.delete','button')==true){?>
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
									<td><?=$data['frame_number']?></td>
									<td><?=$data['typecar']?> chỗ</td>
									<td><?=$data['manufacturer']?></td>
									<td><?=$data['license_plates']?></td>		          
									<td>	
										<div class="form-check form-switch">
											<input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/car_driver/car-status/<?=$data['id']?>/">
											<label class="form-check-label" for="status"></label>
										</div>
									</td>
									<?php if($jatbi->permission('car.edit','button')==true){?>
										<td>
											<a class="btn btn-sm btn-light modal-url" data-url="/car_driver/car-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
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
<?php if($router['1']=='car-add' || $router['1']=='car-edit'){?>
	<div class="modal fade modal-load" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><?=$router['1']=='car-add'?$lang['them']:$lang['sua']?><?=$lang['phuong-tien']?></h5>
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
									<label><?=$lang['so-khung']?><small class="text-danger">*</small></label>
									<input placeholder="<?=$lang['so-khung']?>" type="text" name="frame_number" value="<?=$data['frame_number']?>" class="form-control">
								</div>
								<div class="mb-3">
									<label><?=$lang['loai-xe']?> <small class="text-danger">*</small></label>
									<input placeholder="<?=$lang['loai-xe']?>" type="text" name="typecar" value="<?=$data['typecar']?>" class="form-control">
								</div>
								<div class="mb-3">
									<label><?=$lang['hang-xe']?> <small class="text-danger">*</small></label>
									<input placeholder="<?=$lang['hang-xe']?>" type="text" name="manufacturer" value="<?=$data['manufacturer']?>" class="form-control">
								</div>



							</div>
							<div class="col-sm-6">

								<div class="mb-3">
									<label><?=$lang['thong-so-ky-thuat']?> <small class="text-danger">*</small></label>
									<input placeholder="<?=$lang['thong-so-ky-thuat']?>" type="text" name="specifications" value="<?=$data['specifications']?>" class="form-control">
								</div>
								<div class="mb-3">
									<label><?=$lang['bien-so']?> <small class="text-danger">*</small></label>
									<input placeholder="<?=$lang['bien-so']?>" type="text" name="license_plates" value="<?=$data['license_plates']?>" class="form-control">
								</div>
								<div class="mb-3">
									<label><?=$lang['hinh-dai-dien']?></label>
									<input type="file" class="form-control" name="avatar" value="<?=$data['avatar']?>">
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
<?php if($router['1']=='car-delete'){?>
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
<?php if($router['1']=='driver'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['danh-sach-tai-xe']?></h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
				<li class="breadcrumb-item active" aria-current="page"><?=$lang['dich-vu']?></li>
			</ol>
		</div>
	</nav>
	<?php if($jatbi->permission('driver.add','button')==true || $jatbi->permission('driver.delete','button')==true){?>
		<div class="fixed-action-btn">
			<a class="btn btn-large btn-primary rounded-circle">
				<i class="fas fa-bars" aria-hidden="true"></i>
			</a>
			<ul>
				<?php if($jatbi->permission('driver.delete','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/car_driver/driver-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
				<?php }?>
				<?php if($jatbi->permission('driver.add','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-info" data-url="/car_driver/driver-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
								<?php if($jatbi->permission('driver.delete','button')==true){?>
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
								<th><?=$lang['trang-thai']?></th>
								<?php if($jatbi->permission('driver.edit','button')==true){?>
									<th width="2%"></th>
								<?php }?>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($datas as $data) { ?>
								<tr>
									<?php if($jatbi->permission('driver.delete','button')==true){?>
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
									<td>	
										<div class="form-check form-switch">
											<input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/car_driver/driver-status/<?=$data['id']?>/">
											<label class="form-check-label" for="status"></label>
										</div>
									</td>
									<?php if($jatbi->permission('driver.edit','button')==true){?>
										<td>
											<a class="btn btn-sm btn-light modal-url" data-url="/car_driver/driver-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
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
<?php if($router['1']=='driver-add' || $router['1']=='driver-edit'){?>
	<div class="modal fade modal-load" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><?=$router['1']=='driver-add'?$lang['them']:$lang['sua']?> <?=$lang['tai-xe']?></h5>
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
									<label>Số điện thoại</label>
									<input placeholder="Số điện thoại" type="text" name="phone_number" value="<?=$data['phone_number']?>" class="form-control">
								</div>	
								 <div class="mb-3">
					        		<label><?=$lang['mat-khau']?> <small class="text-danger">*</small></label>
								    <input placeholder="<?=$lang['mat-khau']?>" type="password" name="password" value="" class="form-control">
							    </div>
							     <div class="mb-3">
					        		<label><?=$lang['nhom-quyen']?> <small class="text-danger">*</small></label>
					        		<select name="permission" class="select2 form-control" style="width:100%">
									    <option value="" disabled selected><?=$lang['nhom-quyen']?></option>
									    <?php foreach ($permissions as $permission) { ?>
									      	<option value="<?=$permission['id']?>"  <?=($data['permission']==$permission['id']?'selected':'')?>><?=$permission['name']?></option>
									    <?php } ?>
									</select>
							    </div>
									   
							</div>
							<div class="col-sm-6">
								<div class="mb-3">
									<label><?=$lang['cccd']?> <small class="text-danger">*</small></label>
									<input placeholder="<?=$lang['cccd']?>" type="text" name="citizenId" value="<?=$data['citizenId']?>" class="form-control">
								</div>	
								<div class="mb-3">
									<label><?=$lang['ma-bang-lai']?> <small class="text-danger">*</small></label>
									<input placeholder="<?=$lang['ma-bang-lai']?>" type="text" name="driver_license_id" value="<?=$data['driver_license_id']?>" class="form-control">
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
									<label><?=$lang['hinh-dai-dien']?></label>
									<input type="file" class="form-control" name="avatar" value="<?=$data['avatar']?>">
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
<?php if($router['1']=='driver-delete'){?>
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
<?php if($router['1']=='student_register_car'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['danh-sach-dang-ki-dua-don']?></h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
				<li class="breadcrumb-item active" aria-current="page"><?=$lang['dich-vu']?></li>
			</ol>
		</div>
	</nav>
	<?php if($jatbi->permission('student_register_car.add','button')==true || $jatbi->permission('student_register_car.delete','button')==true){?>
		<div class="fixed-action-btn">
			<a class="btn btn-large btn-primary rounded-circle">
				<i class="fas fa-bars" aria-hidden="true"></i>
			</a>
			<ul>
				<?php if($jatbi->permission('student_register_car.delete','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/car_driver/student_register_car-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
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
								<?php if($jatbi->permission('student_register_car.delete','button')==true){?>
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
								<th><?=$lang['ten-hoc-sinh']?></th>
								<th><?=$lang['lop-hoc']?></th>
								<th><?=$lang['hoc-ki']?></th>	
								<th><?=$lang['khoa-hoc']?></th>	
								<th><?=$lang['tuyen-duong']?></th>	
								<th><?=$lang['tinh-trang']?></th>		        			        					      
								<th><?=$lang['trang-thai']?></th>
								<?php if($jatbi->permission('student_register_car.edit','button')==true){?>
									<th width="2%"></th>
								<?php }?>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($datas as $data) { ?>
								<tr>
									<?php if($jatbi->permission('student_register_car.delete','button')==true){?>
										<td class="align-middle">
											<div class="form-check">
												<input class="form-check-input checker" type="checkbox" id="<?=$data['id']?>" name="BOX[<?=$data['id']?>]" value="<?=$data['id']?>">
												<label class="form-check-label" for="<?=$data['id']?>"></label>
											</div>
										</td>
									<?php }?>
									<td></td>

									<td><?=$database->get("students","id_student",['id'=>$database->get("arrange_class","students",["id"=>$data['arrange_class']])])?></td>
									<td><?=$database->get("students","firstname",['id'=>$database->get("arrange_class","students",["id"=>$data['arrange_class']])])?> <?=$database->get("students","lastname",['id'=>$database->get("arrange_class","students",["id"=>$data['arrange_class']])])?></td>
									<td><?=$database->get("class","name",['id'=>$database->get("class_diagram","class",['id'=>$database->get("arrange_class","class_diagram",["id"=>$data['arrange_class']])])])?></td>
									<td><?=$database->get("semester","name",['id'=>$data['semester']])?></td>
									<td><?=$database->get("course","name",['id'=>$database->get("semester","course",['id'=>$data['semester']])])?></td>
									<td><?=$database->get("route","name",['id'=>$data['route']])?></td>
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
												<input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/car_driver/student_register_car-status/<?=$data['id']?>/">
												<label class="form-check-label" for="status"></label>
											</div>
										</td>
										<?php if($jatbi->permission('student_register_car.edit','button')==true){?>
											<td>
												<a class="btn btn-sm btn-light modal-url" data-url="/car_driver/student_register_car-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
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
<?php if($router['1']=='student_register_car-delete'){?>
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
<?php if($router['1']=='student_register_car-add' || $router['1']=='student_register_car-edit'){?>
	<div class="modal fade modal-load" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><?=$router['1']=='course-add'?$lang['them']:$lang['sua']?> <?=$lang['dang-ki-dua-ruoc']?></h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
					<div class="modal-body">
						<div class="row">
							<div class="col-sm-6">	
								<div class="mb-3">
									<label><?=$lang['hoc-sinh']?> <small class="text-danger">*</small></label>
									<select name="arrange_class" class="form-control select2" style="width: 100%;">
										<option value=""><?=$lang['hoc-sinh']?></option>
										<?php foreach ($arrange_class as $arrange_class) { 
											?>
											<option value="<?=$arrange_class['id']?>"  <?=($data['arrange_class']==$arrange_class['id']?'selected':'')?>><?=$database->get('students','id_student',['id'=>$database->get('arrange_class','students',['id'=>$data['arrange_class']])])?> - <?=$database->get('students','firstname',['id'=>$database->get('arrange_class','students',['id'=>$data['arrange_class']])])?> <?=$database->get('students','lastname',['id'=>$database->get('arrange_class','students',['id'=>$data['arrange_class']])])?></option>
										<?php } ?>
									</select>
								</div>	
								<div class="mb-3">
									<label><?=$lang['hoc-ki']?><small class="text-danger">*</small></label>
									<select name="semester" class="select2 form-control" style="width:100%">
										<?php foreach ($semesters as $semester ) { ?>
											<option value="<?=$semester['id']?>"  <?=($data['semester']==$semester['id']?'selected':'')?> selected><?=$semester['name']?> (<?=$database->get('course','name',['id'=>$semester['course']])?>)</option>
										<?php } ?>
									</select>
								</div>	
								<div class="mb-3">
									<label><?=$lang['tuyen-duong']?><small class="text-danger">*</small></label>
									<select name="route" class="select2 form-control" style="width:100%">
										<?php foreach ($route as $route ) { ?>
											<option value="<?=$route['id']?>"  <?=($data['route']==$route['id']?'selected':'')?> selected><?=$route['name']?></option>
										<?php } ?>
									</select>
								</div>
							</div>	    
							<div class="col-sm-6">	
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
<?php if($router['1']=='route'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['danh-sach-tuyen-duong']?></h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
				<li class="breadcrumb-item active" aria-current="page"><?=$lang['dich-vu']?></li>
			</ol>
		</div>
	</nav>
	<?php if($jatbi->permission('route.add','button')==true || $jatbi->permission('route.delete','button')==true){?>
		<div class="fixed-action-btn">
			<a class="btn btn-large btn-primary rounded-circle">
				<i class="fas fa-bars" aria-hidden="true"></i>
			</a>
			<ul>
				<?php if($jatbi->permission('route.delete','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/car_driver/route-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
				<?php }?>
				<?php if($jatbi->permission('route.add','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-info" data-url="/car_driver/route-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
								<?php if($jatbi->permission('route.delete','button')==true){?>
									<th width="1%" class="text-center">
										<div class="form-check">
											<input class="form-check-input selectall" type="checkbox" value="" id="all">
											<label class="form-check-label" for="all">
											</label>
										</div>
									</th>
								<?php }?>
								<th width="50"></th>
								<th><?=$lang['tuyen-duong']?></th>					        			        				   
								<th><?=$lang['trang-thai']?></th>
								<?php if($jatbi->permission('route.edit','button')==true){?>
									<th width="2%"></th>
								<?php }?>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($datas as $data) { ?>
								<tr>
									<?php if($jatbi->permission('route.delete','button')==true){?>
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
											<input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/car_driver/route-status/<?=$data['id']?>/">
											<label class="form-check-label" for="status"></label>
										</div>
									</td>
									<?php if($jatbi->permission('route.edit','button')==true){?>
										<td>
											<a class="btn btn-sm btn-light modal-url" data-url="/car_driver/route-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
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
<?php if($router['1']=='route-add' || $router['1']=='route-edit'){?>
	<div class="modal fade modal-load" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><?=$router['1']=='route-add'?$lang['them']:$lang['sua']?> <?=$lang['tuyen-duong']?></h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
					<div class="modal-body">
						<div class="row">
							<div class="col-sm-6">
								<div class="mb-3">
									<label><?=$lang['tuyen-duong']?><small class="text-danger">*</small></label>
									<input placeholder="<?=$lang['tuyen-duong']?>" type="text" name="name" value="<?=$data['name']?>" class="form-control">
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
<?php if($router['1']=='route-delete'){?>
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
<?php if($router['1']=='car_schedule'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['danh-sach-xep-lich']?></h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
				<li class="breadcrumb-item active" aria-current="page"><?=$lang['dich-vu']?></li>
			</ol>
		</div>
	</nav>
	<?php if($jatbi->permission('car_schedule.add','button')==true || $jatbi->permission('car_schedule.delete','button')==true){?>
		<div class="fixed-action-btn">
			<a class="btn btn-large btn-primary rounded-circle">
				<i class="fas fa-bars" aria-hidden="true"></i>
			</a>
			<ul>
				<?php if($jatbi->permission('car_schedule.delete','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/car_driver/car_schedule-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
				<?php }?>
				<?php if($jatbi->permission('car_schedule.add','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-info" data-url="/car_driver/car_schedule-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
								<?php if($jatbi->permission('car_schedule.delete','button')==true){?>
									<th width="1%" class="text-center">
										<div class="form-check">
											<input class="form-check-input selectall" type="checkbox" value="" id="all">
											<label class="form-check-label" for="all">
											</label>
										</div>
									</th>
								<?php }?>
								<th width="50"></th>
								<th><?=$lang['ngay']?></th>
								<th><?=$lang['xe']?></th>
								<th><?=$lang['loai-xe']?></th>	
								<th><?=$lang['tai-xe']?></th>
								<th><?=$lang['so-dien-thoai']?></th>
								<th><?=$lang['tuyen-duong']?></th>
								<th><?=$lang['dich-vu']?></th>	        			        					      
								<th><?=$lang['trang-thai']?></th>
								<?php if($jatbi->permission('car_schedule.edit','button')==true){?>
									<th width="2%"></th>
								<?php }?>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($datas as $data) { ?>
								<tr>
									<?php if($jatbi->permission('car_schedule.delete','button')==true){?>
										<td class="align-middle">
											<div class="form-check">
												<input class="form-check-input checker" type="checkbox" id="<?=$data['id']?>" name="BOX[<?=$data['id']?>]" value="<?=$data['id']?>">
												<label class="form-check-label" for="<?=$data['id']?>"></label>
											</div>
										</td>
									<?php }?>
									<td></td>


									<td><?=date("d/m/Y", strtotime($data['date']))?></td>
									<td><?=$database->get("car","name",["id"=>$data['car']])?></td>
									<td><?=$database->get("car","typecar",["id"=>$data['car']])?> chỗ</td>
									<td><?=$database->get("driver","name",["id"=>$data['driver']])?></td>
									<td><?=$database->get("driver","phone_number",["id"=>$data['driver']])?></td>
									<td><?=$database->get("route","name",["id"=>$data['route']])?></td>
									<?php if($data['type']=="1"){
										?>
										<td><span class="font-weight-bold text-danger"><?=$lang['don-di']?></span></td>		         
										<?}elseif($data['type']=="2"){?>		      
											<td><strong style="color:green;" class="font-weight-bold "><?=$lang['don-ve']?></strong></td>	
										<?php }?>

										<td>	
											<div class="form-check form-switch">
												<input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/car_driver/car_schedule-status/<?=$data['id']?>/">
												<label class="form-check-label" for="status"></label>
											</div>
										</td>
										<?php if($jatbi->permission('car_schedule.edit','button')==true){?>
											<td>
												<a class="btn btn-sm btn-light modal-url" data-url="/car_driver/car_schedule-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
											</td>
										<?php }?>
										<?php if($jatbi->permission('car_schedule_detail','button')==true){?>
											<td>
												<a class="btn btn-sm btn-light pjax-load" href="/car_driver/car_schedule_detail/<?=$data['id']?>/"><i class="fas fa-eye" aria-hidden="true"></i></a>
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
<?php if($router['1']=='car_schedule-add'){?>
	<div class="modal fade modal-load" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><?=$router['1']=='car_schedule-add'?$lang['them']:$lang['sua']?> <?=$lang['chuyen-xe']?></h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
					<div class="modal-body">
						<div class="row">
							<div class="col-sm-12">
								<div class="mb-3">
									<label><?=$lang['ngay']?><small class="text-danger">*</small></label>
									<input placeholder="<?=$lang['ngay']?>" type="date" name="date" value="<?=$data['date']?>" class="form-control">
								</div>	
								<div class="mb-3">
									<label><?=$lang['xe']?><small class="text-danger">*</small></label>
									<select name="car" class="select2 form-control" style="width:100%">
										<option value="" disabled selected><?=$lang['chon-xe']?></option>
										<?php foreach ($car as $car ) { ?>
											<option value="<?=$car['id']?>"  <?=($data['car']==$car['id']?'selected':'')?>><?=$car['name']?> - <?=$car['typecar']?> chỗ</option>
										<?php } ?>
									</select>
								</div>

								<div class="mb-3">
									<label><?=$lang['tai-xe']?><small class="text-danger">*</small></label>
									<select name="driver" class="select2 form-control" style="width:100%">
										<option value="" disabled selected><?=$lang['tai-xe']?></option>
										<?php foreach ($driver as $driver ) { ?>
											<option value="<?=$driver['id']?>"  <?=($data['driver']==$driver['id']?'selected':'')?>><?=$driver['name']?> - <?=$driver['phone_number']?></option>
										<?php } ?>
									</select>
								</div>	
								<div class="mb-3">
									<label><?=$lang['tuyen-duong']?><small class="text-danger">*</small></label>
									<select name="route" class="select2 form-control" style="width:100%">
										<option value="" disabled selected><?=$lang['tuyen-duong']?></option>
										<?php foreach ($route as $route ) { ?>
											<option value="<?=$route['id']?>"  <?=($data['route']==$route['id']?'selected':'')?>><?=$route['name']?></option>
										<?php } ?>
									</select>
								</div>
								<!-- <div class="mb-3">
									<label><?=$lang['hoc-sinh']?><small class="text-danger">*</small></label>
									<select  name="student_register_car[]" class="select2 form-control areas-student_register_car" style="width:100%" multiple>
										<?php foreach ($student_register_car as $student_register_cars ) { 
											?>
											<option value="<?=$student_register_cars['id']?>"><?=$database->get("students","id_student",["id"=>$database->get("arrange_class","students",["id"=>$database->get("student_register_car","arrange_class",["id"=>$student_register_cars['id']])])])?> - <?=$database->get("students","firstname",["id"=>$database->get("arrange_class","students",["id"=>$database->get("student_register_car","arrange_class",["id"=>$student_register_cars['id']])])])?> <?=$database->get("students","lastname",["id"=>$database->get("arrange_class","students",["id"=>$database->get("student_register_car","arrange_class",["id"=>$student_register_cars['id']])])])?>
										</option> 

									<?php } ?>
								</select>

							</div> 	 -->

						</div> 	
						<div class="mb-3">
							<label><?=$lang['dich-vu']?> <small class="text-danger">*</small></label>
							<select name="type" class="select2 form-control" style="width:100%">
								<option value="1" <?=($data['status']==1?'selected':'')?>><?=$lang['don-di']?></option>
								<option value="2" <?=($data['status']==2?'selected':'')?>><?=$lang['don-ve']?></option>
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
<?php if($router['1']=='car_schedule-edit'){?>
	<div class="modal fade modal-load" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><?=$router['1']=='car_schedule-add'?$lang['them']:$lang['sua']?> <?=$lang['xep-xe']?></h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
					<div class="modal-body">
						<div class="row">
							<div class="col-sm-12">
								<div class="mb-3">
									<label><?=$lang['ngay']?><small class="text-danger">*</small></label>
									<input placeholder="<?=$lang['ngay']?>" type="date" name="date" value="<?=$data['date']?>" class="form-control">
								</div>	
								<div class="mb-3">
									<label><?=$lang['xe']?><small class="text-danger">*</small></label>
									<select name="car" class="select2 form-control" style="width:100%">
										<option value="" disabled selected><?=$lang['chon-xe']?></option>
										<?php foreach ($car as $car ) { ?>
											<option value="<?=$car['id']?>"  <?=($data['car']==$car['id']?'selected':'')?>><?=$car['name']?> - <?=$car['typecar']?> chỗ</option>
										<?php } ?>
									</select>
								</div>

								<div class="mb-3">
									<label><?=$lang['tai-xe']?><small class="text-danger">*</small></label>
									<select name="driver" class="select2 form-control" style="width:100%">
										<option value="" disabled selected><?=$lang['tai-xe']?></option>
										<?php foreach ($driver as $driver ) { ?>
											<option value="<?=$driver['id']?>"  <?=($data['driver']==$driver['id']?'selected':'')?>><?=$driver['name']?> - <?=$driver['phone_number']?></option>
										<?php } ?>
									</select>
								</div>	
								<div class="mb-3">
									<label><?=$lang['tuyen-duong']?><small class="text-danger">*</small></label>
									<select name="route" class="select2 form-control route-student" style="width:100%">
										<option value="" disabled selected><?=$lang['tuyen-duong']?></option>
										<?php foreach ($route as $route ) { ?>
											<option value="<?=$route['id']?>"  <?=($data['route']==$route['id']?'selected':'')?>><?=$route['name']?></option>
										<?php } ?>
									</select>
								</div>	
						</div> 	
						<div class="mb-3">
							<label><?=$lang['dich-vu']?> <small class="text-danger">*</small></label>
							<select name="type" class="select2 form-control" style="width:100%">
								<option value="1" <?=($data['status']==1?'selected':'')?>><?=$lang['don-di']?></option>
								<option value="2" <?=($data['status']==2?'selected':'')?>><?=$lang['don-ve']?></option>
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
<?php if($router['1']=='car_schedule-delete'){?>
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
<?php if($router['1']=='car_schedule_detail'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['danh-sach-hoc-sinh']?></h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
				<li class="breadcrumb-item active" aria-current="page"><?=$lang['dich-vu']?></li>
			</ol>
		</div>
	</nav>
	<?php if($jatbi->permission('car_schedule_detail.add','button')==true || $jatbi->permission('car_schedule_detail.delete','button')==true){?>
		<div class="fixed-action-btn">
			<a class="btn btn-large btn-primary rounded-circle">
				<i class="fas fa-bars" aria-hidden="true"></i>
			</a>
			<ul>
				<?php if($jatbi->permission('car_schedule_detail.delete','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/car_driver/car_schedule_detail-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
				<?php }?>
				<?php if($jatbi->permission('car_schedule_detail.add','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-info" data-url="/car_driver/car_schedule_detail-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
				<?php }?>
			</ul>
		</div>
	<?php }?>
	<div class="card card-custom">
		<div class="card-body">
			<form method="GET" class="pjax-content mb-4 search-form">

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
									<option value="A" <?=($_GET['status']=='A'?'selected':'')?>><?=$lang['co-mat']?></option>
									<option value="D" <?=($_GET['status']=='D'?'selected':'')?>><?=$lang['vang-mat']?></option>
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
								<?php if($jatbi->permission('car_schedule_detail.delete','button')==true){?>
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
								<th><?=$lang['ten-hoc-sinh']?></th>
								<th><?=$lang['lop-hoc']?></th>	
								<th><?=$lang['phu-huynh']?></th>
								<th><?=$lang['so-dien-thoai']?></th>
								<th><?=$lang['dia-chi']?></th>	 
								<th><?=$lang['diem-danh']?></th>	     			        					      
							</tr>
						</thead>
						<tbody>
							<?php foreach ($datas as $data) { ?>
								<tr>
									<?php if($jatbi->permission('car_schedule_detail.delete','button')==true){?>
										<td class="align-middle">
											<div class="form-check">
												<input class="form-check-input checker" type="checkbox" id="<?=$data['id']?>" name="BOX[<?=$data['id']?>]" value="<?=$data['id']?>">
												<label class="form-check-label" for="<?=$data['id']?>"></label>
											</div>
										</td>
									<?php }?>
									<td></td>
									<td><?=$database->get("students","id_student",["id"=>$database->get("arrange_class","students",["id"=>$database->get("student_register_car","arrange_class",["id"=>$data['student_register_car']])])])?></td>
									<td><?=$database->get("students","firstname",["id"=>$database->get("arrange_class","students",["id"=>$database->get("student_register_car","arrange_class",["id"=>$data['student_register_car']])])])?> <?=$database->get("students","lastname",["id"=>$database->get("arrange_class","students",["id"=>$database->get("student_register_car","arrange_class",["id"=>$data['student_register_car']])])])?></td>
									<td><?=$database->get("class","name",["id"=>$database->get("class_diagram","class",["id"=>$database->get("arrange_class","class_diagram",["id"=>$database->get("student_register_car","arrange_class",["id"=>$data['student_register_car']])])])])?></td>
									<td><?=$database->get("parent","name",["id"=>$database->get("students","parent",["id"=>$database->get("arrange_class","students",["id"=>$database->get("student_register_car","arrange_class",["id"=>$data['student_register_car']])])])])?></td>
									<td><?=$database->get("parent","phone_number",["id"=>$database->get("students","parent",["id"=>$database->get("arrange_class","students",["id"=>$database->get("student_register_car","arrange_class",["id"=>$data['student_register_car']])])])])?></td>
									<td><?=$database->get("parent","address",["id"=>$database->get("students","parent",["id"=>$database->get("arrange_class","students",["id"=>$database->get("student_register_car","arrange_class",["id"=>$data['student_register_car']])])])])?>, <?=$database->get("ward","name",["id"=>$database->get("parent","ward",["id"=>$database->get("students","parent",["id"=>$database->get("arrange_class","students",["id"=>$database->get("student_register_car","arrange_class",["id"=>$data['student_register_car']])])])])])?>, <?=$database->get("district","name",["id"=>$database->get("parent","ward",["id"=>$database->get("students","parent",["id"=>$database->get("arrange_class","students",["id"=>$database->get("student_register_car","arrange_class",["id"=>$data['student_register_car']])])])])])?>, <?=$database->get("province","name",["id"=>$database->get("parent","ward",["id"=>$database->get("students","parent",["id"=>$database->get("arrange_class","students",["id"=>$database->get("student_register_car","arrange_class",["id"=>$data['student_register_car']])])])])])?></td>
										<?php if($data['status']=="D"){
										?>
										<td><span class="font-weight-bold text-danger"><?=$lang['vang-mat']?></span></td>		         
										<?}elseif($data['status']=="A"){?>		      
											<td><strong style="color:green;" class="font-weight-bold "><?=$lang['co-mat']?></strong></td>	
										<?php }?>
										<?php if($jatbi->permission('car_schedule_detail.edit','button')==true){?>
											<td>
												<a class="btn btn-sm btn-light modal-url" data-url="/car_driver/car_schedule_detail-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
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
<?php if($router['1']=='car_schedule_detail-add' || $router['1']=='car_schedule_detail-edit'){?>
	<div class="modal fade modal-load" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><?=$router['1']=='car_schedule_detail-add'?$lang['them']:$lang['sua']?> <?=$lang['danh-sach-hoc-sinh']?> <?=$check['student_register_car']?></h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
					<div class="modal-body">
						<div class="row">
							<div class="col-sm-12">
								<div class="mb-3">
									<label><?=$lang['hoc-sinh']?><small class="text-danger">*</small></label>
									<select  name="student_register_car[]" class="select2 form-control areas-student_register_car" style="width:100%" multiple>
										
								                
								             <?php foreach ($student_register_car as $student_register_cars ) { 
														?>
															<option value="<?=$student_register_cars['id']?>" <?=($data['student_register_car']==$student_register_cars['id']?'selected':'')?>><?=$database->get("students","firstname",["id"=>$database->get("arrange_class","students",["id"=>$database->get("student_register_car","arrange_class",["id"=>$student_register_cars['id']])])])?> <?=$database->get("students","lastname",["id"=>$database->get("arrange_class","students",["id"=>$database->get("student_register_car","arrange_class",["id"=>$student_register_cars['id']])])])?>
															</option> 							   
											<?php }?>
									
								</select>

							</div> 	

						</div> 	    	    
						<div class="mb-3">
							<label><?=$lang['diem-danh']?> <small class="text-danger">*</small></label>
							<select name="status" class="select2 form-control" style="width:100%">
								<option value="A" <?=($data['status']=='A'?'selected':'')?>><?=$lang['co-mat']?></option>
								<option value="D" <?=($data['status']=='D'?'selected':'')?>><?=$lang['vang-mat']?></option>
							</select>
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
<?php if($router['1']=='car_schedule_detail-delete'){?>
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

<?php if($router['1']=='schedule_driver'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['danh-sach-xep-lich']?></h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
				<li class="breadcrumb-item active" aria-current="page"><?=$lang['dich-vu']?></li>
			</ol>
		</div>
	</nav>
	<?php if($jatbi->permission('car_schedule.add','button')==true || $jatbi->permission('car_schedule.delete','button')==true){?>
		<div class="fixed-action-btn">
			<a class="btn btn-large btn-primary rounded-circle">
				<i class="fas fa-bars" aria-hidden="true"></i>
			</a>
			<ul>
				<?php if($jatbi->permission('car_schedule.delete','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/car_driver/car_schedule-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
				<?php }?>
				<?php if($jatbi->permission('car_schedule.add','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-info" data-url="/car_driver/car_schedule-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
								<?php if($jatbi->permission('car_schedule.delete','button')==true){?>
									<th width="1%" class="text-center">
										<div class="form-check">
											<input class="form-check-input selectall" type="checkbox" value="" id="all">
											<label class="form-check-label" for="all">
											</label>
										</div>
									</th>
								<?php }?>
								<th width="50"></th>
								<th><?=$lang['ngay']?></th>
								<th><?=$lang['xe']?></th>
								<th><?=$lang['loai-xe']?></th>	
								<th><?=$lang['tai-xe']?></th>
								<th><?=$lang['so-dien-thoai']?></th>
								<th><?=$lang['tuyen-duong']?></th>
								<th><?=$lang['dich-vu']?></th>	        			        					      
								<th><?=$lang['trang-thai']?></th>
								<?php if($jatbi->permission('car_schedule.edit','button')==true){?>
									<th width="2%"></th>
								<?php }?>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($datas as $data) { ?>
								<tr>
									<?php if($jatbi->permission('car_schedule.delete','button')==true){?>
										<td class="align-middle">
											<div class="form-check">
												<input class="form-check-input checker" type="checkbox" id="<?=$data['id']?>" name="BOX[<?=$data['id']?>]" value="<?=$data['id']?>">
												<label class="form-check-label" for="<?=$data['id']?>"></label>
											</div>
										</td>
									<?php }?>
									<td></td>


									<td><?=date("d/m/Y", strtotime($data['date']))?></td>
									<td><?=$database->get("car","name",["id"=>$data['car']])?></td>
									<td><?=$database->get("car","typecar",["id"=>$data['car']])?> chỗ</td>
									<td><?=$database->get("driver","name",["id"=>$data['driver']])?></td>
									<td><?=$database->get("driver","phone_number",["id"=>$data['driver']])?></td>
									<td><?=$database->get("route","name",["id"=>$data['route']])?></td>
									<?php if($data['type']=="1"){
										?>
										<td><span class="font-weight-bold text-danger"><?=$lang['don-di']?></span></td>		         
										<?}elseif($data['type']=="2"){?>		      
											<td><strong style="color:green;" class="font-weight-bold "><?=$lang['don-ve']?></strong></td>	
										<?php }?>

										<td>	
											<div class="form-check form-switch">
												<input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/car_driver/car_schedule-status/<?=$data['id']?>/">
												<label class="form-check-label" for="status"></label>
											</div>
										</td>
										<?php if($jatbi->permission('car_schedule.edit','button')==true){?>
											<td>
												<a class="btn btn-sm btn-light modal-url" data-url="/car_driver/car_schedule-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
											</td>
										<?php }?>
										<?php if($jatbi->permission('car_schedule_detail','button')==true){?>
											<td>
												<a class="btn btn-sm btn-light pjax-load" href="/car_driver/car_schedule_detail/<?=$data['id']?>/"><i class="fas fa-eye" aria-hidden="true"></i></a>
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