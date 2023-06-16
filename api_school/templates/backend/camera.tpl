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
<?php if($router['1']=='faceid'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['nhat-ky-nhan-dien']?></h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
				<li class="breadcrumb-item active" aria-current="page"><?=$lang['nhat-ky-nhan-dien']?></li>
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
							<div class="filer-item date">
								<label><?=$lang['ngay']?></label>
								<input type="text" class="form-control float-right daterange-select" name="date" value="<?=date('d/m/Y',strtotime($date_from))?> - <?=date('d/m/Y',strtotime($date_to))?>">
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

								<th><?=$lang['ngay']?></th>
								<th><?=$lang['ten']?></th>
								<th>Loại</th>
								<th></th>
								<th width="1%"></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($datas as $data) { ?>
								<tr>
									<td><img src="<?=$data['images']?>" class="border border-light shadow-sm w-100"></td>

									<td><?=date($setting['site_datetime'],strtotime($data['date_face']))?></td>
									<?php if(unserialize($data['content'])['type']==0){
										$personnels = $database->get("students", "*",["id"=>$database->get("arrange_class", "students",["id"=>$data['object']])]);?>
										<td><?=$personnels['firstname']?> <?=$personnels['lastname']?></td>
										<td><?=$lang['hoc-sinh']?></td>
									<?php } elseif (unserialize($data['content'])['type']==1) {$personnels = $database->get("teacher", "*",["id"=>$data['object']]);?>
									<td><?=$personnels['firstname']?> <?=$personnels['lastname']?></td>
									<td><?=$lang['giao-vien']?></td>
								<?php } elseif (unserialize($data['content'])['type']==2) {$personnels = $database->get("personels", "*",["id"=>$data['object']]);?>
								<td><?=$personnels['name']?></td>
								<td><?=$lang['nhan-vien']?></td>
							<?php } elseif (unserialize($data['content'])['type']==3) {$personnels = $database->get("parent", "*",["id"=>$data['object']]);?>
							<td><?=$personnels['name']?></td>
							<td><?=$lang['phu-huynh']?></td>
						<?php } else{?>
							<td></td>
							<td><span class="text-danger"><?=$lang['nguoi-la']?></span></td>
						<?php }?>
						<td>
							<a class="btn btn-sm btn-light modal-url" data-url="/camera/faceid-views/<?=$data['id']?>/"><i class="fas fa-eye" aria-hidden="true"></i></a>
						</td>
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
<?php if($router['1']=='faceid-views'){?>
	<div class="modal fade modal-load" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body text-break">
					<pre><?=print_r($data['logs'])?></pre>
					<img src="<?=$data['images']?>" class="border border-light shadow-sm w-100">
				</div>
			</div>
		</div>
	</div>
<?php } ?>
<?php if($router['1']=='check_cam'){?>
	<div class="content">
		<div class="row">
			<div class=" text-success fs-2 text-center" style="font-weight: 700;"><?=$school_current['name']?></div>
			<div class="text-success fs-4 text-center fw-bold">Hệ thống nhận diện phụ huynh đón học sinh</div>
		</div>
		
		<div class="list">
			<div class="content">
		
		<div class="row">
			<div class="col">
				<div class="row">
					<div class="fw-bold fs-5 text-primary text-center">THÔNG TIN PHỤ HUYNH</div>
					<div class="w-100">
						<img src="https://i.pinimg.com/originals/f1/0f/f7/f10ff70a7155e5ab666bcdd1b45b726d.jpg" class="w-100" />
					</div>
					<div class="w-100 px-4 mt-3 d-flex justify-items-center">
						<table class="table table-bordered">
							<tr>
								<td width="30%" class="fw-bold">Loại</td>
								<td class="text-danger fw-bold">Mẹ</td>
							</tr>
							<tr>
								<td class="fw-bold">Phụ huynh</td>
								<td>Nguyễn Thị Thanh Thúy</td>
							</tr>
							<tr>
								<td class="fw-bold">Điện thoại</td>
								<td>0977729700</td>
							</tr>
							<tr>
								<td class="fw-bold">Địa chỉ</td>
								<td>Phường Bình Hòa-Thị xã Thuận An-Tỉnh Bình Dương</td>
							</tr>
						</table>
					</div>

					<div class="w-100 px-4 mt-2 d-flex justify-items-center">
						<table class="table table-bordered">
							<thead >
								<th width="30%" scope="col" style="text-transform: none;" class="text-black">Loại</th>
								<th scope="col"  style="text-transform: none;" class="text-black">Tên</th>
								<th scope="col"  style="text-transform: none;" class="text-black">Điện thoại</th>
							</thead>
							<tbody>
								<tr>
									<td class="fw-bold text-danger">Mẹ</td>
									<td>Nguyễn Thị Thanh Thúy</td>
									<td>0123456789</td>
								</tr>
								
							</tbody>

						</table>

					</div>
				</div>
			</div>
			<div class="col">
				<div class="row mt-4">
					<div class="text-center text-black fs-2 fw-bold">
						THÔNG BÁO 
						
					</div>
				</div>
				

			</div>
			<div class="col">
				<div class="row">
					<div class="fw-bold fs-5 text-warning text-center">THÔNG TIN HỌC SINH</div>
					<div class="w-100">
						<img src="https://i.pinimg.com/originals/f1/0f/f7/f10ff70a7155e5ab666bcdd1b45b726d.jpg" class="w-100" />
					</div>
					<div class="w-100 px-4 mt-3 d-flex justify-items-center">
						<table class="table table-bordered">

							<tr>
								<td  width="30%" class="fw-bold">Học sinh</td>
								<td>Nguyễn Thị Thanh Quyên</td>
							</tr>
							<tr>
								<td class="fw-bold">Ngày sinh</td>
								<td>05/03/2021</td>
							</tr>
							<tr>
								<td class="fw-bold">Khóa học</td>
								<td>Năm học 2022-2023</td>
							</tr>
							<tr>
								<td class="fw-bold">Khối học</td>
								<td>1</td>
							</tr>
							<tr>
								<td class="fw-bold">Lớp học</td>
								<td>1A</td>
							</tr>
							<tr>
								<td class="fw-bold">Thời gian</td>
								<td>09:43:00 - 06/06/2023</td>
							</tr>
							<tr>
								<td class="fw-bold">Đóng tiền tháng này</td>
								<td>Đóng tiền tháng này</td>
							</tr>
						</table>
					</div>
				</div>
			</div>

		</div>
	</div>
		</div>
		<script
		src="https://code.jquery.com/jquery-3.6.0.min.js"
		integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
		crossorigin="anonymous"></script>
		<script>
			var conn = new WebSocket('wss://gym.cam.eclo.io:8031/1432a24dbeb856ebaabc4b7b58df3901');
			conn.onopen = function(e) { 
				$('.button').on("click",function(){
					var value = $('.value').val();
					conn.send(value); 
					$(".list").prepend("<div>"+value+"</div>");
				});

			};
			conn.onmessage = function(e) { 
			    console.log(e.data); 
			    var getData = JSON.parse(e.data);

			    // Gửi yêu cầu AJAX đến API hoặc tệp PHP để truy vấn dữ liệu phụ huynh
			    $.ajax({
			        url: '/getparent/',
			        type: 'POST',
			        data: { type: getData.emp_id,
			        		token: getData.token,
			        		place: getData.place_active },
			        success: function(parentData) {
			            // Xử lý dữ liệu phụ huynh và cập nhật giao diện
			            var data = JSON.parse(parentData);
			            console.log(data);
			            var parent = data.parents;
			            var student= data.student;
			            var newData = `
			         <div class="row">
			            <div class="col">
			                <div class="row">
			                    <div class="fw-bold fs-5 text-primary text-center">THÔNG TIN PHỤ HUYNH</div>
			                    <div class="w-100 pt-3">
			                        <img src='${getData.photo}' class="w-100" />
			                    </div>
			                    <div class="w-100 px-4 mt-3 d-flex justify-items-center">
			                        <table class="table table-bordered">
			                            <tr>
			                                <td width="30%" class="fw-bold">Loại</td>
			                                <td class="text-danger fw-bold">${getData.type}</td>
			                            </tr>
			                            <tr>
			                                <td class="fw-bold">Phụ huynh</td>
			                                <td>${parent.name}</td>
			                            </tr>
			                            <tr>
			                                <td class="fw-bold">Điện thoại</td>
			                                <td>${parent.phone_number}</td>
			                            </tr>
			                            <tr>
			                                <td class="fw-bold">CMND/CCCD</td>
			                                <td>${parent.citizenId}</td>
			                            </tr>
			                            <tr>
			                                <td class="fw-bold">Địa chỉ</td>
			                                <td>${parent.address}, ${parent.ward}, ${parent.district}, ${parent.province}</td>
			                            </tr>
			                        </table>
			                    </div>
			                    <div class="w-100 px-4 mt-2 d-flex justify-items-center">
			                        <table class="table table-bordered">
			                            <thead>
			                                <th width="30%" scope="col" style="text-transform: none;" class="text-black">Loại</th>
			                                <th scope="col"  style="text-transform: none;" class="text-black">Tên</th>
			                                <th scope="col"  style="text-transform: none;" class="text-black">Điện thoại</th>
			                            </thead>
			                            <tbody>
			                                <tr>
			                                    <td class="fw-bold text-danger">${parent.type}</td>
			                                    <td>${parent.name}</td>
			                                    <td>${parent.phone_number}</td>
			                                </tr>
			                            </tbody>
			                        </table>
			                    </div>
			                </div>
			            </div>
			            <div class="col">
			                <div class="row mt-4">
			                    <div class="text-center text-black fs-2 fw-bold">
			                        THÔNG BÁO 
			                    </div>
			                </div>
			                <div class="text-center fs-5">*****</div>
			            </div>
			            <div class="col">
			                ${student}
			            </div>
			        	</div>
			            `;
			            $(".list").html(newData);
			            console.log(data);
			        },
			        error: function() {
			            // Xử lý lỗi nếu cần thiết
			        }
			    });
			};
		</script>
	</div>
<?php } ?>
<?php if($router['1']=='camera_setting'){?>
		<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
			<div class="">
				<h4><?=$lang['cau-hinh-camera']?></h4>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
					<li class="breadcrumb-item active" aria-current="page"><?=$lang['cau-hinh-camera']?></li>
				</ol>
			</div>
		</nav>
		<?php if($jatbi->permission('camera_setting.add','button')==true || $jatbi->permission('camera_setting.delete','button')==true){?>
			<div class="fixed-action-btn">
				<a class="btn btn-large btn-primary rounded-circle">
					<i class="fas fa-bars" aria-hidden="true"></i>
				</a>
				<ul>
					<?php if($jatbi->permission('camera_setting.delete','button')==true){?>
						<li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/camera/camera_setting-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
					<?php }?>
					<?php if($jatbi->permission('camera_setting.add','button')==true){?>
						<li><a class="modal-url btn rounded-circle btn-info" data-url="/camera/camera_setting-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
									<?php if($jatbi->permission('camera_setting.delete','button')==true){?>
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
									<th><?=$lang['duong-dan']?></th>	
									<th><?=$lang['tai-khoan']?></th>					        			        					      
									<th><?=$lang['mat-khau']?></th>	
									<th>PORT</th>	
									<th><?=$lang['trang-thai']?></th>
									<?php if($jatbi->permission('camera_setting.edit','button')==true){?>
										<th width="2%"></th>
									<?php }?>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($datas as $data) { ?>
									<tr>
										<?php if($jatbi->permission('camera_setting.delete','button')==true){?>
											<td class="align-middle">
												<div class="form-check">
													<input class="form-check-input checker" type="checkbox" id="<?=$data['id']?>" name="BOX[<?=$data['id']?>]" value="<?=$data['id']?>">
													<label class="form-check-label" for="<?=$data['id']?>"></label>
												</div>
											</td>
										<?php }?>
										<td></td>


										<td><?=$data['name']?></td>
										<td><?=$data['link']?></td>
										<td><?=$data['accounts_cam']?></td>
										<td><?=$data['password']?></td>
										<td><?=$data['port']?></td>
										<td>	
											<div class="form-check form-switch">
												<input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/camera/camera_setting-status/<?=$data['id']?>/">
												<label class="form-check-label" for="status"></label>
											</div>
										</td>
										<?php if($jatbi->permission('camera_setting.edit','button')==true){?>
											<td>
												<a class="btn btn-sm btn-light modal-url" data-url="/camera/camera_setting-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
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
<?php if($router['1']=='camera_setting-add' || $router['1']=='camera_setting-edit'){?>
		<div class="modal fade modal-load" tabindex="-1">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title"><?=$router['1']=='camera_setting-add'?$lang['them']:$lang['sua']?> <?=$lang['cau-hinh-camera']?></h5>
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
										<label><?=$lang['duong-dan']?><small class="text-danger">*</small></label>
										<input placeholder="<?=$lang['duong-dan']?>" type="text" name="link" value="<?=$data['link']?>" class="form-control">
									</div>
								
									<div class="mb-3">
										<label><?=$lang['tai-khoan']?><small class="text-danger">*</small></label>
										<input placeholder="<?=$lang['tai-khoan']?>" type="text" name="accounts_cam" value="<?=$data['accounts_cam']?>" class="form-control">
									</div>
								
									<div class="mb-3">
										<label><?=$lang['mat-khau']?><small class="text-danger">*</small></label>
										<input placeholder="<?=$lang['mat-khau']?>" type="text" name="password" value="<?=$data['password']?>" class="form-control">
									</div>
								</div> 		    
								<div class="col-sm-6">	
									<div class="mb-3">
										<label>Port<small class="text-danger">*</small></label>
										<input placeholder="Port" type="text" name="port" value="<?=$data['port']?>" class="form-control">
									</div>
									<div class="mb-3">
										<label><?=$lang['ghi-chu']?><small class="text-danger">*</small></label>
										<input placeholder="<?=$lang['ghi-chu']?>" type="text" name="note" value="<?=$data['note']?>" class="form-control">
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
<?php if($router['1']=='camera_setting-delete'){?>
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
<?php if($router['1']=='camera_channel'){?>
		<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
			<div class="">
				<h4><?=$lang['kenh-camera']?></h4>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
					<li class="breadcrumb-item active" aria-current="page"><?=$lang['kenh-camera']?></li>
				</ol>
			</div>
		</nav>
		<?php if($jatbi->permission('camera_channel.add','button')==true || $jatbi->permission('camera_channel.delete','button')==true){?>
			<div class="fixed-action-btn">
				<a class="btn btn-large btn-primary rounded-circle">
					<i class="fas fa-bars" aria-hidden="true"></i>
				</a>
				<ul>
					<?php if($jatbi->permission('camera_channel.delete','button')==true){?>
						<li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/camera/camera_channel-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
					<?php }?>
					<?php if($jatbi->permission('camera_channel.add','button')==true){?>
						<li><a class="modal-url btn rounded-circle btn-info" data-url="/camera/camera_channel-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
									<?php if($jatbi->permission('camera_channel.delete','button')==true){?>
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
									<th><?=$lang['dau-thu']?></th>	
									<th><?=$lang['kenh']?></th>					        			        					      
									<th><?=$lang['man-hinh']?></th>	
									<th><?=$lang['lop-hoc']?></th>	
									<th><?=$lang['ghi-chu']?></th>
							
									<th><?=$lang['trang-thai']?></th>
									<?php if($jatbi->permission('camera_channel.edit','button')==true){?>
										<th width="2%"></th>
									<?php }?>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($datas as $data) { ?>
									<tr>
										<?php if($jatbi->permission('camera_channel.delete','button')==true){?>
											<td class="align-middle">
												<div class="form-check">
													<input class="form-check-input checker" type="checkbox" id="<?=$data['id']?>" name="BOX[<?=$data['id']?>]" value="<?=$data['id']?>">
													<label class="form-check-label" for="<?=$data['id']?>"></label>
												</div>
											</td>
										<?php }?>
										<td></td>


										<td><?=$data['name']?></td>
										<td><?=$database->get("camera_setting","name",["id"=>$data['camera_setting']])?></td>
										<td><?=$data['channel']?></td>
										<td><?=$data['display']?></td>
										<td><?=$database->get("class", "name",["id"=>$database->get("class_diagram","class",["id"=>$data['class_diagram']])])?></td>
										<td><?=$data['note']?></td>
										<td>	
											<div class="form-check form-switch">
												<input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/camera/camera_channel-status/<?=$data['id']?>/">
												<label class="form-check-label" for="status"></label>
											</div>
										</td>
										<?php if($jatbi->permission('camera_channel.edit','button')==true){?>
											<td>
												<a  class="btn btn-light w-100 pjax-load" href="/camera/camera_channel-eye/"><i class="fas fa-eye" aria-hidden="true"></i></a>
											</td>
											<td>
												<a class="btn btn-sm btn-light modal-url" data-url="/camera/camera_channel-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
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
<?php if($router['1']=='camera_channel-add' || $router['1']=='camera_channel-edit'){?>
		<div class="modal fade modal-load" tabindex="-1">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title"><?=$router['1']=='camera_channel-add'?$lang['them']:$lang['sua']?> <?=$lang['kenh-camera']?></h5>
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
											<label><?= $lang['dau-thu']?><small class="text-danger">*</small></label>
											<select name="camera_setting" class="select2 form-control class-course" style="width:100%">
												<option value="" disabled selected><?=$lang['dau-thu']?></option>
												<?php foreach ($camera_setting as $camera_settings) { ?>
													<option value="<?=$camera_settings['id']?>" <?=($data['camera_setting']==$camera_settings['id']?'selected':'')?>><?=$camera_settings['name']?>
													</option>
												<?php } ?>
											</select>
										</div>	
								
									<div class="mb-3">
										<label><?=$lang['kenh']?><small class="text-danger">*</small></label>
										<input placeholder="<?=$lang['kenh']?>" type="text" name="channel" value="<?=$data['channel']?>" class="form-control">
									</div>
								
									<div class="mb-3">
									    <label><?=$lang['man-hinh']?><small class="text-danger">*</small></label>
									    <input placeholder="<?=$lang['man-hinh']?>" type="number" name="display" value="<?=$data['display']?>" class="form-control">
									</div>

								</div> 		    
								<div class="col-sm-6">	
									<div class="mb-3">
											<label><?= $lang['lop-hoc']?><small class="text-danger">*</small></label>
											<select name="class_diagram" class="select2 form-control" style="width:100%">
												<option value="" disabled selected><?=$lang['chon-lop']?></option>
												<?php foreach ($class_course as $class_courses) { ?>
													<option value="<?=$class_courses['id']?>" <?=($data['class_diagram']==$class_courses['id']?'selected':'')?>><?=$database->get("class","name",['id'=>$class_courses['class']])?> (<?=$database->get("course","name",['id'=>$class_courses['course']])?>)
													</option>
												<?php } ?>
											</select>
										</div>	
									<div class="mb-3">
										<label><?=$lang['ghi-chu']?><small class="text-danger">*</small></label>
										<input placeholder="<?=$lang['ghi-chu']?>" type="text" name="note" value="<?=$data['note']?>" class="form-control">
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
<?php if($router['1']=='camera_channel-eye'){?>
	<div>
    <canvas id="video-canvas" style="width:100%">
    </canvas>
  </div>

  <script type="text/javascript">
  var url = "ws://testrtsp.cam.eclo.io:8077";
  var canvas = document.getElementById('video-canvas');
  var player = new JSMpeg.Player(url, {canvas: canvas});
  </script>
<?php } ?>
<?php if($router['1']=='camera_channel-delete'){?>
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