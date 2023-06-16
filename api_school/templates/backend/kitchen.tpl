<?php if($router['1']=='dish'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4>Danh sách món ăn</h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
				<li class="breadcrumb-item active" aria-current="page">Lớp & Học vụ</li>
			</ol>
		</div>
	</nav>
	<?php if($jatbi->permission('dish.add','button')==true || $jatbi->permission('dish.delete','button')==true){?>
		<div class="fixed-action-btn">
			<a class="btn btn-large btn-primary rounded-circle">
				<i class="fas fa-bars" aria-hidden="true"></i>
			</a>
			<ul>
				<?php if($jatbi->permission('dish.delete','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/kitchen/dish-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
				<?php }?>
				<?php if($jatbi->permission('dish.add','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-info" data-url="/kitchen/dish-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
								<?php if($jatbi->permission('dish.delete','button')==true){?>
									<th width="1%" class="text-center">
										<div class="form-check">
											<input class="form-check-input selectall" type="checkbox" value="" id="all">
											<label class="form-check-label" for="all">
											</label>
										</div>
									</th>
								<?php }?>
								<th width="50"></th>
								<th>Tên món ăn</th>					        			        					      
								<th><?=$lang['trang-thai']?></th>
								<?php if($jatbi->permission('dish.edit','button')==true){?>
									<th width="2%"></th>
								<?php }?>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($datas as $data) { ?>
								<tr>
									<?php if($jatbi->permission('dish.delete','button')==true){?>
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
											<input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/kitchen/dish-status/<?=$data['id']?>/">
											<label class="form-check-label" for="status"></label>
										</div>
									</td>
									<?php if($jatbi->permission('dish.edit','button')==true){?>
										<td>
											<a class="btn btn-sm btn-light modal-url" data-url="/kitchen/dish-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
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
<?php if($router['1']=='dish-add' || $router['1']=='dish-edit'){?>
	<div class="modal fade modal-load" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><?=$router['1']=='dish-add'?$lang['them']:$lang['sua']?>Món ăn</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
					<div class="modal-body">
						<div class="row">
							<div class="col-sm-6">
								<div class="mb-3">
									<label>Tên món ăn<small class="text-danger">*</small></label>
									<input placeholder="Tên món ăn" type="text" name="name" value="<?=$data['name']?>" class="form-control">
								</div>
								<div class="mb-3">
									<label><?=$lang['hinh-dai-dien']?></label>
									<input type="file" class="form-control" name="avatar" value="<?=$data['avatar']?>">
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
		<?php if($router['1']=='dish-delete'){?>
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
<?php if($router['1']=='food_menu'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4>Danh sách thực đơn</h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
				<li class="breadcrumb-item active" aria-current="page">Lớp & Học vụ</li>
			</ol>
		</div>
	</nav>
	<?php if($jatbi->permission('food_menu.add','button')==true || $jatbi->permission('food_menu.delete','button')==true){?>
		<div class="fixed-action-btn">
			<a class="btn btn-large btn-primary rounded-circle">
				<i class="fas fa-bars" aria-hidden="true"></i>
			</a>
			<ul>
				<?php if($jatbi->permission('food_menu.delete','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/kitchen/food_menu-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
				<?php }?>
				<?php if($jatbi->permission('food_menu.add','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-info" data-url="/kitchen/food_menu-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
								<?php if($jatbi->permission('food_menu.delete','button')==true){?>
									<th width="1%" class="text-center">
										<div class="form-check">
											<input class="form-check-input selectall" type="checkbox" value="" id="all">
											<label class="form-check-label" for="all">
											</label>
										</div>
									</th>
								<?php }?>
								<th width="50"></th>
								
								<th>Ngày bắt đầu</th>
								<th>Ngày kết thúc</th>
								<th>Tên</th>
								
								

								<th><?=$lang['trang-thai']?></th>
								
								<?php if($jatbi->permission('food_menu.edit','button')==true){?>
									<th width="2%"></th>
								<?php }?>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($datas as $data) { ?>
								<tr>
									<?php if($jatbi->permission('food_menu.delete','button')==true){?>
										<td class="align-middle">
											<div class="form-check">
												<input class="form-check-input checker" type="checkbox" id="<?=$data['id']?>" name="BOX[<?=$data['id']?>]" value="<?=$data['id']?>">
												<label class="form-check-label" for="<?=$data['id']?>"></label>
											</div>
										</td>
									<?php }?>
									<td></td>
									
									
									
									<td><?=date("d/m/Y", strtotime($data['date_start']))?></td>
									<td><?=date("d/m/Y", strtotime($data['date_end']))?></td>
									<td><?=$data['name']?></td>
									
									
									
									<td>	
										<div class="form-check form-switch">
											<input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/kitchen/food_menu-status/<?=$data['id']?>/">
											<label class="form-check-label" for="status"></label>
										</div>
									</td>
									<?php if($jatbi->permission('food_menu.detail','button')==true){?>
										<td>
											<a class="btn btn-sm btn-light pjax-load" href="/kitchen/food_menu-detail/<?=$data['id']?>/"><i class="fas fa-eye" aria-hidden="true"></i></a>
										</td>
									<?php }?>
									<?php if($jatbi->permission('food_menu.edit','button')==true){?>
										<td>
											<a class="btn btn-sm btn-light modal-url" data-url="/kitchen/food_menu-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
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
<?php if($router['1']=='food_menu-add' || $router['1']=='food_menu-edit'){?>
	<div class="modal fade modal-load" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><?=$router['1']=='food_menu-add'?$lang['them']:$lang['sua']?> Thực đơn</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
					<div class="modal-body">
						<div class="row">
							<div class="col-sm-6">
								
								<div class="mb-3">
									<label>Ngày bắt đầu<small class="text-danger">*</small></label>
									<input placeholder="Ngày bắt đầu" type="date" name="date_start" value="<?=$data['date_start']?>" class="form-control">
								</div>
								<div class="mb-3">
									<label>Ngày kết thúc<small class="text-danger">*</small></label>
									<input placeholder="Ngày kết thúc" type="date" name="date_end" value="<?=$data['date_end']?>" class="form-control">
								</div>
								
							</div> 		    
							<div class="col-sm-6">
								<div class="mb-3">
									<label>Tên<small class="text-danger">*</small></label>
									<input placeholder="Tên" type="text" name="name" value="<?=$data['name']?>" class="form-control">
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
<?php if($router['1']=='food_menu-delete'){?>
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
<?php if($router['1']=='food_menu-detail'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4>Chi tiết thực đơn</h4>
			
		</div>
	</nav>
	<div class="fixed-action-btn">
		<a class="btn btn-large btn-primary rounded-circle">
			<i class="fas fa-bars" aria-hidden="true"></i>
		</a>
		<ul>
			
			<li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/kitchen/food_menu_detail-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
			
			
			<li><a class="modal-url btn rounded-circle btn-info" data-url="/kitchen/food_menu_detail-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
		</ul>
	</div>
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
								
								<th width="1%" class="text-center">
									<div class="form-check">
										<input class="form-check-input selectall" type="checkbox" value="" id="all">
										<label class="form-check-label" for="all">
										</label>
									</div>
								</th>
								
								<th width="50"></th>
								<th>Thứ</th>
								<th>Buổi</th>
								<th>Món ăn</th>								        
								<th><?=$lang['trang-thai']?></th>
								
								
								<th width="2%"></th>
								
							</tr>
						</thead>
						<tbody>
							<?php foreach ($datas as $data) { ?>
								<tr>
									
									<td class="align-middle">
										<div class="form-check">
											<input class="form-check-input checker" type="checkbox" id="<?=$data['id']?>" name="BOX[<?=$data['id']?>]" value="<?=$data['id']?>">
											<label class="form-check-label" for="<?=$data['id']?>"></label>
										</div>
									</td>
									
									<td></td>
									
									
									<td><?=$database->get("day", "name",["id"=>$data['day']])?></td>
									<td><?=$database->get("typemenu", "name",["id"=>$data['typemenu']])?></td>
									<td><?=$database->get("dish", "name",["id"=>$data['dish']])?></td>
									
									<td>	
										<div class="form-check form-switch">
											<input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/kitchen/food_menu_detail-status/<?=$data['id']?>/">
											<label class="form-check-label" for="status"></label>
										</div>
									</td>
									
									<td>
										<a class="btn btn-sm btn-light modal-url" data-url="/kitchen/food_menu_detail-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
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
<?php if($router['1']=='food_menu_detail-add' || $router['1']=='food_menu_detail-edit'){?>
	<div class="modal fade modal-load" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><?=$router['1']=='food_menu_detail-add'?$lang['them']:$lang['sua']?>Chi tiết thực đơn</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
					<div class="modal-body">
						<div class="row">
							<div class="col-sm-6">
								<div class="mb-3">
									<label>Tên thực đơn<small class="text-danger">*</small></label>
									
									<select name="food_menu" class="select2 form-control" style="width:100%">
										<?php foreach ($food_menu as $food_menu) { ?>
											
											<option value="<?=$food_menu['id']?>"  <?=($data['food_menu']==$food_menu['id']?'selected':'')?>><?=$food_menu['name']?></option>
										<?php } ?>
									</select>
								</div>	
								<div class="mb-3">
									<label>Thứ<small class="text-danger">*</small></label>
									<select name="day" class="select2 form-control" style="width:100%">
										<option value="" disabled selected>Thứ</option>
										<?php foreach ($day as $day) { ?>
											<option value="<?=$day['id']?>"  <?=($data['day']==$day['id']?'selected':'')?>><?=$day['name']?></option>
										<?php } ?>
									</select>
								</div>
								<div class="mb-3">
									<label>Loại <small class="text-danger">*</small></label>
									<select name="typemenu" class="select2 form-control" style="width:100%">
										<option value="" disabled selected>Loại</option>
										<?php foreach ($typemenu as $typemenu) { ?>
											<option value="<?=$typemenu['id']?>"  <?=($data['typemenu']==$typemenu['id']?'selected':'')?>><?=$typemenu['name']?></option>
										<?php } ?>
									</select>
								</div>
								
							</div> 		    
							<div class="col-sm-6">
								<div class="mb-3">
									<label>Món ăn<small class="text-danger">*</small></label>
									<select name="dish" class="select2 form-control" style="width:100%">
										<option value="" disabled selected>Món ăn</option>
										<?php foreach ($dish as $dish) { ?>
											<option value="<?=$dish['id']?>"  <?=($data['dish']==$dish['id']?'selected':'')?>><?=$dish['name']?></option>
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
<?php if($router['1']=='food_menu_detail-delete'){?>
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
<?php if($router['1']=='unit_food'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['danh-sach-don-vi']?></h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
				<li class="breadcrumb-item active" aria-current="page"><?=$lang['bep']?></li>
			</ol>
		</div>
	</nav>
	<?php if($jatbi->permission('unit_food.add','button')==true || $jatbi->permission('unit_food.delete','button')==true){?>
		<div class="fixed-action-btn">
			<a class="btn btn-large btn-primary rounded-circle">
				<i class="fas fa-bars" aria-hidden="true"></i>
			</a>
			<ul>
				<?php if($jatbi->permission('unit_food.delete','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/kitchen/unit_food-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
				<?php }?>
				<?php if($jatbi->permission('unit_food.add','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-info" data-url="/kitchen/unit_food-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
								<?php if($jatbi->permission('unit_food.delete','button')==true){?>
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
								<th><?=$lang['ghi-chu']?></th>					        			        					      
								<th><?=$lang['trang-thai']?></th>
								<?php if($jatbi->permission('unit_food.edit','button')==true){?>
									<th width="2%"></th>
								<?php }?>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($datas as $data) { ?>
								<tr>
									<?php if($jatbi->permission('unit_food.delete','button')==true){?>
										<td class="align-middle">
											<div class="form-check">
												<input class="form-check-input checker" type="checkbox" id="<?=$data['id']?>" name="BOX[<?=$data['id']?>]" value="<?=$data['id']?>">
												<label class="form-check-label" for="<?=$data['id']?>"></label>
											</div>
										</td>
									<?php }?>
									<td></td>


									<td><?=$data['name']?></td>
									<td><?=$data['notes']?></td>

									<td>	
										<div class="form-check form-switch">
											<input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/kitchen/unit_food-status/<?=$data['id']?>/">
											<label class="form-check-label" for="status"></label>
										</div>
									</td>
									<?php if($jatbi->permission('unit_food.edit','button')==true){?>
										<td>
											<a class="btn btn-sm btn-light modal-url" data-url="/kitchen/unit_food-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
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
<?php if($router['1']=='unit_food-add' || $router['1']=='unit_food-edit'){?>
	<div class="modal fade modal-load" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><?=$router['1']=='unit_food-add'?$lang['them']:$lang['sua']?><?=$lang['don-vi']?></h5>
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
									<label><?=$lang['ghi-chu']?><small class="text-danger">*</small></label>
									<input placeholder="<?=$lang['ghi-chu']?>" type="text" name="notes" value="<?=$data['notes']?>" class="form-control">
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
<?php if($router['1']=='unit_food-delete'){?>
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
<?php if($router['1']=='category_food'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['danh-sach-danh-muc']?></h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
				<li class="breadcrumb-item active" aria-current="page"><?=$lang['bep']?></li>
			</ol>
		</div>
	</nav>
	<?php if($jatbi->permission('category_food.add','button')==true || $jatbi->permission('category_food.delete','button')==true){?>
		<div class="fixed-action-btn">
			<a class="btn btn-large btn-primary rounded-circle">
				<i class="fas fa-bars" aria-hidden="true"></i>
			</a>
			<ul>
				<?php if($jatbi->permission('category_food.delete','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/kitchen/category_food-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
				<?php }?>
				<?php if($jatbi->permission('category_food.add','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-info" data-url="/kitchen/category_food-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
								<?php if($jatbi->permission('category_food.delete','button')==true){?>
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
								<th><?=$lang['ghi-chu']?></th>					        			        					      
								<th><?=$lang['trang-thai']?></th>
								<?php if($jatbi->permission('category_food.edit','button')==true){?>
									<th width="2%"></th>
								<?php }?>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($datas as $data) { ?>
								<tr>
									<?php if($jatbi->permission('category_food.delete','button')==true){?>
										<td class="align-middle">
											<div class="form-check">
												<input class="form-check-input checker" type="checkbox" id="<?=$data['id']?>" name="BOX[<?=$data['id']?>]" value="<?=$data['id']?>">
												<label class="form-check-label" for="<?=$data['id']?>"></label>
											</div>
										</td>
									<?php }?>
									<td></td>


									<td><?=$data['name']?></td>
									<td><?=$data['notes']?></td>

									<td>	
										<div class="form-check form-switch">
											<input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/kitchen/category_food-status/<?=$data['id']?>/">
											<label class="form-check-label" for="status"></label>
										</div>
									</td>
									<?php if($jatbi->permission('category_food.edit','button')==true){?>
										<td>
											<a class="btn btn-sm btn-light modal-url" data-url="/kitchen/category_food-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
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
<?php if($router['1']=='category_food-add' || $router['1']=='category_food-edit'){?>
	<div class="modal fade modal-load" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><?=$router['1']=='category_food-add'?$lang['them']:$lang['sua']?><?=$lang['danh-muc']?></h5>
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
									<label><?=$lang['ghi-chu']?><small class="text-danger">*</small></label>
									<input placeholder="<?=$lang['ghi-chu']?>" type="text" name="notes" value="<?=$data['notes']?>" class="form-control">
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
<?php if($router['1']=='category_food-delete'){?>
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
<?php if($router['1']=='supplier_food'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['danh-sach-nha-cung-cap']?></h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
				<li class="breadcrumb-item active" aria-current="page"><?=$lang['bep']?></li>
			</ol>
		</div>
	</nav>
	<?php if($jatbi->permission('supplier_food.add','button')==true || $jatbi->permission('supplier_food.delete','button')==true){?>
		<div class="fixed-action-btn">
			<a class="btn btn-large btn-primary rounded-circle">
				<i class="fas fa-bars" aria-hidden="true"></i>
			</a>
			<ul>
				<?php if($jatbi->permission('supplier_food.delete','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/kitchen/supplier_food-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
				<?php }?>
				<?php if($jatbi->permission('supplier_food.add','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-info" data-url="/kitchen/supplier_food-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
								<?php if($jatbi->permission('supplier_food.delete','button')==true){?>
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
								<th><?=$lang['so-dien-thoai']?></th>	
								<th><?=$lang['email']?></th>	
								<th><?=$lang['dia-chi']?></th>					        			        					      
								<th><?=$lang['trang-thai']?></th>
								<?php if($jatbi->permission('supplier_food.edit','button')==true){?>
									<th width="2%"></th>
								<?php }?>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($datas as $data) { ?>
								<tr>
									<?php if($jatbi->permission('supplier_food.delete','button')==true){?>
										<td class="align-middle">
											<div class="form-check">
												<input class="form-check-input checker" type="checkbox" id="<?=$data['id']?>" name="BOX[<?=$data['id']?>]" value="<?=$data['id']?>">
												<label class="form-check-label" for="<?=$data['id']?>"></label>
											</div>
										</td>
									<?php }?>
									<td></td>


									<td><?=$data['name']?></td>
									<td><?=$data['phone_number']?></td>
									<td><?=$data['email']?></td>
									<td><?=$data['address']?></td>

									<td>	
										<div class="form-check form-switch">
											<input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/kitchen/supplier_food-status/<?=$data['id']?>/">
											<label class="form-check-label" for="status"></label>
										</div>
									</td>
									<?php if($jatbi->permission('supplier_food.edit','button')==true){?>
										<td>
											<a class="btn btn-sm btn-light modal-url" data-url="/kitchen/supplier_food-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
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
<?php if($router['1']=='supplier_food-add' || $router['1']=='supplier_food-edit'){?>
	<div class="modal fade modal-load" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><?=$router['1']=='supplier_food-add'?$lang['them']:$lang['sua']?><?=$lang['nha-cung-cap']?></h5>
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
									<label><?=$lang['email']?><small class="text-danger">*</small></label>
									<input placeholder="<?=$lang['email']?>" type="text" name="email" value="<?=$data['email']?>" class="form-control">
								</div>
								<div class="mb-3">
									<label><?=$lang['so-dien-thoai']?><small class="text-danger">*</small></label>
									<input placeholder="<?=$lang['so-dien-thoai']?>" type="text" name="phone_number" value="<?=$data['phone_number']?>" class="form-control">
								</div>
							</div> 		    
							<div class="col-sm-6">	
							<div class="mb-3">
									<label><?=$lang['dia-chi']?><small class="text-danger">*</small></label>
									<input placeholder="<?=$lang['dia-chi']?>" type="text" name="address" value="<?=$data['address']?>" class="form-control">
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
<?php if($router['1']=='supplier_food-delete'){?>
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
<?php if($router['1']=='chef'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['danh-sach-dau-bep']?></h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
				<li class="breadcrumb-item active" aria-current="page"><?=$lang['bep']?></li>
			</ol>
		</div>
	</nav>
	<?php if($jatbi->permission('chef.add','button')==true || $jatbi->permission('chef.delete','button')==true){?>
		<div class="fixed-action-btn">
			<a class="btn btn-large btn-primary rounded-circle">
				<i class="fas fa-bars" aria-hidden="true"></i>
			</a>
			<ul>
				<?php if($jatbi->permission('chef.delete','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/kitchen/chef-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
				<?php }?>
				<?php if($jatbi->permission('chef.add','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-info" data-url="/kitchen/chef-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
								<?php if($jatbi->permission('chef.delete','button')==true){?>
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
								<th><?=$lang['chuc-vu']?></th>	
								<th><?=$lang['trang-thai']?></th>
								<?php if($jatbi->permission('chef.edit','button')==true){?>
									<th width="2%"></th>
								<?php }?>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($datas as $data) { ?>
								<tr>
									<?php if($jatbi->permission('chef.delete','button')==true){?>
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
									<td><?=$data['regent']?></td>				          
									<td>	
										<div class="form-check form-switch">
											<input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/kitchen/chef-status/<?=$data['id']?>/">
											<label class="form-check-label" for="status"></label>
										</div>
									</td>
									<?php if($jatbi->permission('chef.edit','button')==true){?>
										<td>
											<a class="btn btn-sm btn-light modal-url" data-url="/kitchen/chef-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
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
<?php if($router['1']=='chef-add' || $router['1']=='chef-edit'){?>
	<div class="modal fade modal-load" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><?=$router['1']=='chef-add'?$lang['them']:$lang['sua']?> <?=$lang['dau-bep']?></h5>
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
									<label><?=$lang['chuc-vu']?><small class="text-danger">*</small></label>
									<select name="regent" class="select2 form-control" style="width:100%">
										<?php if(isset($data['regent'])){ ?>
											<option value="<?=$data['regent']?>"  selected ><?=$data['regent']?></option>
										<?php } else {?>
											<option value="" disabled selected >Chọn</option>
										<?php } ?>					   
										<option value="Bếp trưởng" >Bếp trưởng</option>
										<option value="Bếp phó" >Bếp phó</option>
										<option value="Đầu bếp" >Đầu bếp</option>
										<option value="Phụ bếp" >Phụ bếp</option>						    
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
<?php if($router['1']=='chef-delete'){?>
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
<?php if($router['1']=='food_warehouse'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['kho-thuc-pham']?></h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
				<li class="breadcrumb-item active" aria-current="page"><?=$lang['bep']?></li>
			</ol>
		</div>
	</nav>
	<?php if($jatbi->permission('food_warehouse.add','button')==true || $jatbi->permission('food_warehouse.delete','button')==true){?>
	<div class="fixed-action-btn">
	    <a class="btn btn-large btn-primary rounded-circle">
	      <i class="fas fa-bars" aria-hidden="true"></i>
	    </a>
	    <ul>
	      <?php if($jatbi->permission('food_warehouse.delete','button')==true){?>
	      <li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/kitchen/food_warehouse-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
	      <?php }?>
	      <?php if($jatbi->permission('food_warehouse.add','button')==true){?>
	      <li><a class="modal-url btn rounded-circle btn-info" data-url="/kitchen/food_warehouse-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
			    <div class="col-lg-3">
				<a href="/kitchen/warehouses-history/" class="btn btn-light w-100 pjax-load"><?=$lang['lich-su-xuat-nhap-hang']?></a>
			</div>
				<div class="form-group">
					
			    	<div class="dropdown">

					  <button class="border dropdown-toggle w-100 filler" type="button" id="fillers" data-bs-auto-close="false" data-bs-toggle="dropdown" aria-expanded="false">
					    <i class="fas fa-filter"></i> <?=$lang['them-dieu-kien-loc']?>
					  </button>
					  <div class="dropdown-menu filler-details p-3" aria-labelledby="fillers">
					  	<p class="mb-2"><?=$lang['tim-kiem-theo-dieu-kien']?></p>
					   <!--  <div class="filer-item type">
					    	<label><?=$lang['loai-cua-hang']?></label>
					    	<select name="type" class="select2 form-select" style="width:100%">
						      <option value=""><?=$lang['loai-cua-hang']?></option>
						      <?php foreach ($device_types as $key => $device_type) {?>
						      	<option value="<?=$device_type['id']?>" <?=$device_type['id']==$xss->xss($_GET['type'])?>><?=$device_type['name']?></option>
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
					        <?php if($jatbi->permission('food_warehouse.delete','button')==true){?>
					      	<th width="1%" class="text-center">
								<div class="form-check">
								  <input class="form-check-input selectall" type="checkbox" value="" id="all">
								  <label class="form-check-label" for="all">
								  </label>
								</div>
					      	</th>
					      	<?php }?>
					      	<th width="2%"></th>
					      	<th><?=$lang['ma-san-pham']?></th>
					      	<th><?=$lang['loai-thuc-pham']?></th>
					        <th><?=$lang['thuc-pham']?></th>
					        <th><?=$lang['so-luong']?></th>
					        <th><?=$lang['don-vi']?></th>
					        <th><?=$lang['nha-cung-cap']?></th>					        
					        <th><?=$lang['trang-thai']?></th>
					        <th><?=$lang['ghi-chu']?></th>
					        <?php if($jatbi->permission('food_warehouse.edit','button')==true){?>
					        <th width="2%"></th>
					        <?php }?>
					    </tr>
					  </thead>
					  <tbody>
					    <?php foreach ($datas as $data) { ?>
							<tr>
				            <?php if($jatbi->permission('food_warehouse.delete','button')==true){?>
				            <td class="align-middle">
			            		<div class="form-check">
									<input class="form-check-input checker" type="checkbox" id="<?=$data['id']?>" name="BOX[<?=$data['id']?>]" value="<?=$data['id']?>">
									<label class="form-check-label" for="<?=$data['id']?>"></label>
								</div>
				            </td>
				            <?php }?>
				          <th width="2%"></th>
				          	<td><?=$data['id_food']?></td>
				            <td><?=$database->get("category_food","name",["id"=>$data['category_food']])?></td>
				            <td><?=$data['name']?></td>
				            <td><?=$data['amounts']?></td>
				            <td><?=$database->get("unit_food","name",["id"=>$data['unit_food']])?></td>
				            <td><?=$database->get("supplier_food","name",["id"=>$data['supplier_food']])?></td>
				            <td>	
				            	<div class="form-check form-switch">
								  <input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/kitchen/food_warehouse-status/<?=$data['id']?>/">
								  <label class="form-check-label" for="status"></label>
								</div>
				            </td>
				            <td><?=$data['notes']?></td>
				           
				            <?php if($jatbi->permission('food_warehouse.edit','button')==true){?>
				            	<td>
				            		<a class="btn btn-sm btn-light modal-url" data-url="/kitchen/food_warehouse-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
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
<?php if($router['1']=='food_warehouse-add' || $router['1']=='food_warehouse-edit'){?>
	<div class="modal fade modal-load" tabindex="-1">
	  <div class="modal-dialog modal-lg">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title"><?=$router['1']=='food_warehouse-add'?$lang['them']:$lang['sua']?> <?=$lang['thuc-pham']?></h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
	      <div class="modal-body">
	      	<div class="row">
		        <div class="col-md-6">
				    <div class="mb-3">
		        		<label><?=$lang['loai-thuc-pham']?> <small class="text-danger">*</small></label>
					   	<select name="category_device" class="select2 form-control" style="width:100%">
					   		<option value=""><?=$lang['loai-thuc-pham']?></option>
			        		<?php foreach ($category_food as $key => $device_type) { ?>
			        			<option value="<?=$device_type['id']?>" <?=$data['category_food']==$device_type['id']?'selected':''?>><?=$device_type['name']?></option>
			        		<?php } ?>
					    </select>
				    </div>		        	
		        	<div class="mb-3">
		        		<label><?=$lang['thuc-pham']?> <small class="text-danger">*</small></label>
					    <input placeholder="<?=$lang['thuc-pham']?>" type="text" name="name" value="<?=$data['name']?>" class="form-control">
				    </div>
				    <div class="mb-3">
		        		<label><?=$lang['don-vi']?> <small class="text-danger">*</small></label>
					   	<select name="units" class="select2 form-control" style="width:100%">
					   		<option value=""><?=$lang['don-vi']?></option>
			        		<?php foreach ($units as $key => $unit) { ?>
			        			<option value="<?=$unit['id']?>" <?=$data['unit_food']==$unit['id']?'selected':''?>><?=$unit['name']?></option>
			        		<?php } ?>
					    </select>
				    </div>
				   
		        </div>
		        <div class="col-md-6">
		        	<div class="mb-3">
		        		<label><?=$lang['ma-san-pham']?> <small class="text-danger">*</small></label>
					    <input placeholder="<?=$lang['ma-san-pham']?>" type="text" name="id_food" value="<?=$data['id_food']?>" class="form-control">
				    </div>
		        	<div class="mb-3">
		        		<label><?=$lang['hinh-dai-dien']?></label>
						<input type="file" class="form-control" name="images">
				    </div>		        	
		        	<div class="mb-3">
		        		<label><?=$lang['nha-cung-cap']?> <small class="text-danger">*</small></label>
					   	<select name="supplier" class="select2 form-control" style="width:100%">
					   		<option value=""><?=$lang['nha-cung-cap']?></option>
			        		<?php foreach ($suppliers as $key => $supplier) { ?>
			        			<option value="<?=$supplier['id']?>" <?=$data['supplier_food']==$supplier['id']?'selected':''?>><?=$supplier['name']?></option>
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
		    <div class="col-md-12 mt-3">
	        	<div class="mb-3">
	        		<label><?=$lang['ghi-chu']?></label>
	        		<textarea placeholder="<?=$lang['ghi-chu']?>" name="notes"  class="form-control" style="height: 100px;"><?=$data['notes']?></textarea>
			    </div>
			</div>
	      </div>
	      <div class="modal-footer">
	      	<input type="hidden" name="token" value="<?=$_SESSION['csrf-token']?>">
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
<?php if($router['1']=='food_warehouse-delete'){?>
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
<?php if($router['1']=='food_import'){?>
	<div class="pjax-content-load ">
		<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
			<div class="">
				<h4><?=$lang['nhap-hang']?></h4>
				<ol class="breadcrumb">
				    <li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
				    <li class="breadcrumb-item active" aria-current="page"><?=$lang['nhap-hang']?></li>
				</ol>
			</div>
		</nav>
		<?php if($jatbi->permission('food_import.add','button')==true || $jatbi->permission('food_import.delete','button')==true){?>
		<div class="fixed-action-btn">
		    <a class="btn btn-large btn-primary rounded-circle">
		      <i class="fas fa-bars" aria-hidden="true"></i>
		    </a>
		    <ul>
		      <?php if($jatbi->permission('food_import.delete','button')==true){?>
		      <li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/kitchen/food_import-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
		      <?php }?>
		      <?php if($jatbi->permission('food_import.add','button')==true){?>
		      <li><a class="pjax-load btn rounded-circle btn-info" href="/kitchen/food_import-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
						    <div class="filer-item vendor">
						    	<label><?=$lang['nha-cung-cap']?></label>
						    	<select name="vendor" class="form-control select2" style="width: 100%;">
						    		<option value=""><?=$lang['tat-ca']?></option>
						    		<?php foreach ($vendors as $vendor) { ?>
								      	<option value="<?=$vendor['id']?>"  <?=($xss->xss($_GET['vendor'])==$vendor['id']?'selected':'')?>><?=$vendor['name']?></option>
								    <?php } ?>
							    </select>
						    </div>
						    <div class="filer-item status_pay">
						    	<label><?=$lang['trang-thai']?></label>
						    	<select name="status_pay" class="select2 form-select" style="width:100%">
							      <option value=""><?=$lang['tat-ca']?></option>
							      <?php foreach ($Status_invoices as $key => $Status_invoice) {?>
							      	<option value="<?=$Status_invoice['id']?>" <?=($xss->xss($_GET['status_pay'])==$Status_invoice['id']?'selected':'')?>><?=$Status_invoice['name']?></option>
							      <?php } ?>
							    </select>
						    </div>
						    <div class="filer-item status">
						    	<label><?=$lang['tien-trinh']?></label>
						    	<select name="status" class="select2 form-select" style="width:100%">
							      <option value=""><?=$lang['tat-ca']?></option>
							      <?php foreach ($Status_purchase as $key => $Status_purchas) {?>
							      	<option value="<?=$Status_purchas['id']?>" <?=($xss->xss($_GET['status'])==$Status_purchas['id']?'selected':'')?>><?=$Status_purchas['name']?></option>
							      <?php } ?>
							    </select>
						    </div>
							<div class="filer-item date">
					    		<label><?=$lang['tu-ngay']?> - <?=$lang['den-ngay']?></label>
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
			    <div class="">
					<div class="table-responsive">
			   			<table class="table table-striped table-hover align-middle">
						  <thead>
						    <tr>
						        <?php if($jatbi->permission('food_import.delete','button')==true){?>
						      	<th width="1%" class="text-center align-middle">
									<div class="form-check">
									  <input class="form-check-input selectall" type="checkbox" value="" id="all">
									  <label class="form-check-label" for="all">
									  </label>
									</div>
						      	</th>
						      	<?php }?>
						        <th class="align-middle"><?=$lang['ma-don-hang']?></th>
						        <th class="align-middle"><?=$lang['nha-cung-cap']?></th>
						        <th class="align-middle"><?=$lang['tong-tien']?></th>
						        <th class="align-middle"><?=$lang['giam-tru']?></th>
						        <th class="align-middle"><?=$lang['giam-gia']?></th>
						   
						        <th class="align-middle"><?=$lang['thanh-toan']?></th>
						        
						        
						        <th class="align-middle"><?=$lang['ngay']?></th>
						        <th class="align-middle"><?=$lang['tai-khoan']?></th>
						        <th width="2%"></th>
						        <th width="2%"></th>
						        <?php if($jatbi->permission('food_import.edit','button')==true){?>
						        <th width="2%"></th>
						        <?php }?>
						        <th width="2%"></th>
						    </tr>
						  </thead>
						  <tbody>
						    <?php foreach ($datas as $data) { ?>
								<tr>
					            <?php if($jatbi->permission('food_import.delete','button')==true){?>
					            <td class="align-middle">
					            	<?php if($data['status']==1 || $data['status']==4){?>
					            		<div class="form-check">
											<input class="form-check-input checker" type="checkbox" id="<?=$data['id']?>" name="BOX[<?=$data['id']?>]" value="<?=$data['id']?>">
											<label class="form-check-label" for="<?=$data['id']?>"></label>
										</div>
									<?php } ?>
					            </td>
					            <?php }?>
					            <td><a class="modal-url" data-url="/kitchen/food_import-views/<?=$data['id']?>/">#-<?=$data['code']?></a></td>
					            <td><?=$database->get("supplier_food","name",["id"=>$data['vendor']])?></td>
					            <td class="fw-bold text-primary"><?=number_format($data['total'])?></td>
					            <td class="fw-bold text-info"><?=number_format($data['minus'])?></td>
					            <td class="fw-bold text-info"><?=number_format($data['discount'])?></td>
					            <td class="fw-bold text-success"><?=number_format($data['payments'])?></td>
					            <td><?=date($setting['site_datetime'],strtotime($data['date']))?></td>
					            <td><?=$database->get("accounts","name",["id"=>$data['user']])?></td>
				            
					            <td>
						            <a class="p-1 rounded-3 small btn-light pjax-load" href="/kitchen/food_import-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
					            </td>
					            <td>
				            		<a class="btn btn-sm btn-light modal-url" data-url="/kitchen/purchase-views/<?=$data['id']?>/"><i class="fas fa-eye" aria-hidden="true"></i></a>
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
	</div>
<?php } ?>
<?php if($router['1']=='food_import-add' || $router['1']=='food_import-edit'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['tao-hoa-don']?></h4>
			<ol class="breadcrumb">
			    <li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
			    <li class="breadcrumb-item active" aria-current="page"><?=$lang['bep']?></li>
			</ol>
		</div>
	</nav>
	<div class="row justify-content-center align-items-center pjax-content-load">
		<div class="col-md-12">
			<div class="card card-custom">
				<div class="card-header bg-light border-0">
					<div class="row">
						<div class="mb-3 col-lg-4">
							<label class="col-form-label"><?=$lang['loai']?> <span class="text-danger">*</span></label>
					    	<select name="type" class="form-control select2 change-update" style="width: 100%;" data-url="/kitchen/purchase-update/<?=$action?>/type/">
							      	<option value="1" <?=1==$_SESSION['purchase'][$action]['type']?'selected':''?>><?=$lang['nhap-kho-bep']?></option>
						    </select>
						</div>
						<div class="mb-3 col-md-4">
							<label class="col-form-label"><?=$lang['nha-cung-cap']?> <span class="text-danger">*</span></label>
							<select name="vendor" class="form-control select2 change-update" style="width: 100%;" data-url="/kitchen/purchase-update/<?=$action?>/vendor/">
							      <option value="" disabled selected><?=$lang['nha-cung-cap']?></option>
					    		<?php foreach ($vendors as $vendor) { ?>
							      	<option value="<?=$vendor['id']?>" <?=$vendor['id']==$_SESSION['purchase'][$action]['vendor']['id']?'selected':''?>><?=$vendor['name']?></option>
							    <?php } ?>
						    </select>
						</div>
						<div class="mb-3 col-md-4">
							<label class="col-form-label"><?=$lang['ngay']?> <span class="text-danger">*</span></label>
					    	<input type="date" name="date" class="form-control blur-update" data-load="false" data-url="/kitchen/purchase-update/<?=$action?>/date/" value="<?=$data['date']?>">
						</div>
					</div>
				</div>
				<div class="card-body">
				    <div class="">
				    	<div class="row">
							<div class="mb-3 col-lg-12">
								<label class="col-form-label"><?=$lang['san-pham']?> <span class="text-danger">*</span></label>	
								<select name="ingredient" class="form-control select2 change-update" style="width: 100%;" multiple="" data-url="/kitchen/purchase-update/<?=$action?>/products/add/">
						    		<?php foreach ($ingredient as $ingred) { ?>
								      	<option value="<?=$ingred['id']?>" ><?=$ingred['name']?></option>
								    <?php } ?>
							    </select>
							</div>
				    	</div>
						<div class="table-responsive">
							<table class="table table-hover table-striped table-bordered align-middle">
								<thead>
									<tr>
										<th width="4%">STT</th>
										<th><?=$lang['san-pham']?></th>
										<th width="10%"><?=$lang['so-luong']?></th>
										<th><?=$lang['don-vi']?></th>
										<th><?=$lang['nha-cung-cap']?></th>
										<th><?=$lang['don-gia']?></th>
										<th><?=$lang['thanh-tien']?></th>
										<th></th>
									</tr>
									
								</thead>
								<tbody>
									<?php 
										foreach ($SelectProducts as $key => $SelectProduct) {
											$getPro = $database->get("food_warehouse","*",["id"=>$SelectProduct['products']]); 
											$total_price = $SelectProduct['amount']*$SelectProduct['price'];
											$total += $total_price;			
											$t+=1;					 										
									?>
									<tr>
										<td><?=$t?></td>
										<td class="p-1">
											<?=$getPro['name']?>
										</td>
										<td class="p-0">
												<input type="number" name="amount" class="blur-update border-0 w-100  h-100 p-3 bg-transparent" data-url="/kitchen/purchase-update/<?=$action?>/products/amount/<?=$key?>/" value="<?=$SelectProduct['amount']?>" data-load="true">
										</td>
										<td class="p-1">
											<?=$database->get("unit_food","name",["id"=>$getPro['unit_food']])?>
										</td>
										<td class="p-1">
											<?=$database->get("supplier_food","name",["id"=>$getPro['supplier_food']])?>
										</td>
										<td class="p-0">
											<input type="text" name="price" class="blur-update border-0 w-100  h-100 p-3 bg-transparent number" data-url="/kitchen/purchase-update/<?=$action?>/products/price/<?=$key?>/" value="<?=$SelectProduct['price']?>" data-load="true">
										</td>
										<td class="text-end fw-bold">
											<?=number_format($total_price)?>
										</td>
										<td class="text-center"><a class="click-update  text-danger" data-load="" data-url="/kitchen/purchase-update/<?=$action?>/products/deleted/<?=$key?>/"><i class="fa fa-trash"></i></a></td>
									</tr>
									<?php } ?>
									
								</tbody>								
								<tfoot>
								
									<tr>
										<td colspan="6" class="text-end fw-bold"><?=$lang['tong-tien']?></td>
										<td class="text-end fw-bold text-primary"><?=number_format($total)?></td>
										<td></td>
									</tr>
									<tr>
										<td colspan="6" class="text-end fw-bold">
											<?=$lang['giam-gia']?>
											<?php $discount = ($data['discount']*$total/100); ?> 
											<?=number_format($discount)?> đ
										</td>
										<td class="text-end fw-bold p-0">
											<input type="text" name="discount" class="blur-update border-0 w-100  h-100 p-1 bg-transparent text-end" data-url="/kitchen/purchase-update/<?=$action?>/discount/" value="<?=$data['discount']?>" data-load="true">
										</td>
										<td class="text-center">%</td>
									</tr>
									<tr>
										<td colspan="6" class="text-end fw-bold"><?=$lang['thanh-toan']?></td>
										<td class="text-end fw-bold text-success">
											<?php $payment = (($total-$minu-$discount)+$surcharge)?>
											<?=number_format($payment)?>
										</td>
										<td></td>
									</tr>
								</tfoot>
							</table>
						</div>
						<div class="row pt-2">
			        	<div class="col-md-12 mb-3">
			        		<label><?=$lang['hinh-thuc-thanh-toan']?> <small class="text-danger">*</small></label>
						   	<select name="type_payments_kitchen" class="form-control select2 change-update" style="width:100%" data-url="/kitchen/purchase-update/<?=$action?>/type_payments_kitchen/">
						   		<option value="" disabled selected><?=$lang['hinh-thuc-thanh-toan']?></option>
				        		<?php foreach ($type_payments as $type_payment) { ?>
				        			<option value="<?=$type_payment['id']?>" <?=$data['type_payments']==$type_payment['id']?'selected':''?>><?=$type_payment['name']?></option>
				        		<?php } ?>
						    </select>
					    </div>
					</div>
						<div class="row">
							<div class="col-md-12">
								<div class="mb-3 ">
									<label class="col-form-label"><?=$lang['noi-dung']?> <span class="text-danger">*</span></label>
									<textarea name="content" class="form-control blur-update" style="height: 100px;" data-load="false" data-url="/kitchen/purchase-update/<?=$action?>/content/"><?=$data['content']?></textarea>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer text-end bg-light border-0">
					<a class="click-update btn btn-danger" data-load="" data-url="/kitchen/purchase-update/<?=$action?>/cancel/"><?=$lang['huy']?></a>
					<button class="click-update btn btn-success" data-load="/kitchen/food_import/" data-url="/kitchen/purchase-update/<?=$action?>/completed/"><?=$lang['hoan-tat']?></button>
				</div>
			</div>
		</div>
	</div>
<?php } ?>
<?php if($router['1']=='purchase-update' && $router['3']=='details'){?>
	<div class="modal fade modal-load" tabindex="-1">
	  <div class="modal-dialog modal-lg">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title"><?=$lang['chi-tiet-thanh-toan']?></h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
	      <div class="modal-body">
	      	<div class="row">
		        <div class="col-sm-4">
		        	<?php if($router['4']=='discount'){?>
				    <div class="mb-3">
		        		<label><?=$lang['phan-tram']?> </label>
					    <input placeholder="<?=$lang['phan-tram']?>" type="text" name="precent" value="<?=$data['precent']?>" class="form-control number">
				    </div>
					<?php } else { ?>
					<div class="mb-3">
		        		<label><?=$lang['so-tien']?> </label>
					    <input placeholder="<?=$lang['so-tien']?>" type="text" name="price" value="<?=$data['price']?>" class="form-control number">
				    </div>
					<?php } ?>
				    <div class="mb-3">
		        		<label><?=$lang['ngay']?> </label>
					    <input placeholder="<?=$lang['ngay']?>" type="date" name="date" value="<?=date("Y-m-d")?>" class="form-control">
				    </div>
				    <div class="mb-3">
		        		<label><?=$lang['noi-dung']?> </label>
					    <textarea name="content" class="form-control" placeholder="<?=$lang['noi-dung']?>" style="height: 100px;"><?=$data['content']?></textarea>
				    </div>
				    <div class="mb-3">
					    <button type="submit" class="btn btn-primary ajax-submit">
					    	<div class="spinner-button" style="display: none">
						    	<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
						    	<span class="me-1"><?=$lang['dang-tai']?></span>
						    </div>
					    	<span class="name-button"><?=$lang['hoan-tat']?></span>
					    </button>
					</div>
		        </div>
		        <div class="col-sm-8">
		        	<table class="table table-hover table-striped table-bordered">
		        		<thead>
		        			<tr>
		        				<th><?=$lang['ngay']?></th>
		        				<th><?=$lang['so-tien']?></th>
		        				<th><?=$lang['noi-dung']?></th>
		        				<th><?=$lang['tai-khoan']?></th>
		        				<th></th>
		        			</tr>
		        		</thead>
		        		<tbody>
		        			<?php foreach ($datas as $key => $data) {?>
		        				<tr>
		        					<td><?=date($setting['site_datetime'],strtotime($data['date']))?></td>
		        					<td><?=number_format($data['price'])?></td>
		        					<td><?=$data['content']?></td>
		        					<td><?=$database->get("accounts","name",["id"=>$data['user']])?></td>
		        					<td class="text-center"><a class="click-update  text-danger" data-load="" data-url="/kitchen/purchase-update/<?=$action?>/details-deleted/<?=$router['4']?>/<?=$key?>/"><i class="fa fa-trash"></i></a></td>
		        				</tr>
		        			<?php } ?>
		        		</tbody>
		        	</table>
		        </div>
		    </div>
	      </div>
	      <div class="modal-footer">
	      	<input type="hidden" name="token" value="<?=$_SESSION['csrf-token']?>">
	        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?=$lang['huy']?></button>
	      </div>
	  	  </form>
	    </div>
	  </div>
	</div>
<?php } ?>
<?php if($router['1']=='purchase-delete'){?>
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
<?php if($router['1']=='purchase-views'){?>
	<div class="modal fade modal-load" tabindex="-1">
	  <div class="modal-dialog modal-lg">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title">#<?=$ballot_code['purchase']?>-<?=$data['code']?></h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <div class="modal-body">
	      	<div class="table-responsive">
	      		<table class="table table-striped table-bordered">
	      			<thead>
	      				<tr>
	      					<td colspan="4">
	      						<strong><?=$lang['nha-cung-cap']?>:</strong> <?=$database->get("supplier_food","name",["id"=>$data['vendor']])?>
	      					</td>
	      					<td colspan="3">
	      						<strong><?=$lang['dien-thoai']?>:</strong> <?=$database->get("supplier_food","phone_number",["id"=>$data['vendor']])?>
	      					</td>
	      				</tr>
	      				<tr>
	      					<td colspan="4">
	      						<strong><?=$lang['ma-hoa-don']?>:</strong><?=$data['code']?>
	      					</td>
	      					<td colspan="3">
	      						<strong><?=$lang['ngay']?>:</strong> <?=date($setting['site_date'],strtotime($data['date']))?> (<?=date($setting['site_datetime'],strtotime($data['date_poster']))?>)
	      					</td>
	      				</tr>
	      				
	      				<tr>
	      					<td colspan="7">
	      						<strong><?=$lang['ghi-chu']?>:</strong> <?=$data['content']?>
	      					</td>
	      				</tr>
	      								
						<tr>
							
							<th><?=$lang['ma-hang']?></th>
							<th><?=$lang['ten']?></th>
							<th><?=$lang['so-luong']?></th>
							<th><?=$lang['don-vi']?></th>
							<th><?=$lang['gia-tien']?></th>
							<th><?=$lang['thanh-tien']?></th>
						</tr>	
						
					</thead>
					<tbody>
						<?php foreach ($SelectProducts as $key => $SelectProduct) {  
							$getPro = $database->get("food_warehouse","*",["id"=>$SelectProduct['products']]);
												
							$price = $SelectProduct['amount']*$SelectProduct['price'];
							?>
						<tr>
							
							<td><?=$getPro['id']?></td>
							<td><?=$getPro['name']?></td>
							<td class=""><?=$SelectProduct['amount']?></td>
							<td class="">
								<?=$database->get("unit_food","name",["id"=>$getPro['unit_food']])?>
							</td>
							<td class="">
								<?=number_format($SelectProduct['price'])?>
							</td>
							<td class="text-end fw-bold">
								<?=number_format($price)?>
							</td>
						</tr>						
					
						<?php } ?>
					</tbody>
					<tfoot>
						<?php if($get['type']==1){?>
						<tr>
							<td colspan="6" class="text-end fw-bold"><?=$lang['tong-tien']?></td>
							<td class="text-end fw-bold text-primary"><?=number_format($data['total'])?></td>
						</tr>
						<tr>
							<td colspan="6" class="text-end fw-bold">
								<?=$lang['giam-gia']?>
								<?=$data['discount']?>%
							</td>
							<td class="text-end fw-bold">
								<?=number_format($data['discount_price'])?>
							</td>
						</tr>
						<tr>
							<td colspan="6" class="text-end fw-bold"><?=$lang['thanh-toan']?></td>
							<td class="text-end fw-bold text-success">
								<?=number_format($data['payments'])?>
							</td>
						</tr>
						<tr>
						
						<?php }?>
					</tfoot>
	      		</table>
	      	</div>
			<div class="card">
				<div class="card-header bg-white  d-flex justify-content-between align-items-center">
					<?=$lang['nhat-ky']?>
				</div>
				<div class="card-body">
					<table class="table">
						<?php foreach ($logs as $log) {?>
						<tr>
							<td>
								<?=$database->get("accounts","name",["id"=>$log['user']])?>
							</td>
							<td>
								<?=date($setting['site_datetime'],strtotime($log['date']))?>
							</td>
							<td class="fw-bold text-<?=$Status_purchase[$log['status']]['color']?>">
								<?=$Status_purchase[$log['status']]['name']?>
							</td>
							<td>
								<?=$log['content']?>
							</td>
						</tr>
						<?php } ?>
					</table>
				</div>
			</div>
	      </div>
	    </div>
	  </div>
	</div>
<?php } ?>
<?php if($router['1']=='warehouses-history'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['lich-su-xuat-nhap-hang']?></h4>
			<ol class="breadcrumb">
			    <li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
			    <li class="breadcrumb-item active" aria-current="page"><?=$lang['bep']?></li>
			</ol>
		</div>
	</nav>
	<?php if($jatbi->permission('warehouses-move','button')==true){?>
	<div class="fixed-action-btn">
	    <a class="btn btn-large btn-primary rounded-circle">
	      <i class="fas fa-bars" aria-hidden="true"></i>
	    </a>
	    <ul>
	      <?php if($jatbi->permission('warehouses-move','button')==true){?>
	      <li><a class="btn rounded-circle btn-info pjax-load" href="/warehouses/warehouses-move/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
				<div class="form-group d-flex">
					<?php if($jatbi->permission('warehouses-import','button')==true){?>
					<div class="dropdown me-2">
					  <button class="border dropdown-toggle w-100 filler text-white bg-primary" type="button" id="import" data-bs-auto-close="true" data-bs-toggle="dropdown" aria-expanded="false">
					    <i class="fas fa-file-import me-2"></i> <?=$lang['nhap-hang']?>
					  </button>
					  <div class="dropdown-menu dropdown-menu-end">
					  	<?php if($jatbi->permission('products-import','button')==true){?>
					  	<a class="dropdown-item pjax-load" href="/warehouses/products-import-crafting/"><?=$lang['nhap-hang-che-tac']?></a>
			    		<a class="dropdown-item pjax-load" href="/warehouses/warehouses-import/"><?=$lang['nhap-hang-thu-cong']?></a>
			    		<!-- <a class="dropdown-item pjax-load" href="/warehouses/warehouses-import-purchase/"><?=$lang['nhap-hang-tu-phieu-mua-hang']?></a> -->
			    		<a class="dropdown-item pjax-load" href="/warehouses/warehouses-import-move/"><?=$lang['nhap-hang-tu-chuyen-hang']?></a>
			    		<a class="dropdown-item pjax-load" href="/warehouses/warehouses-move/"><?=$lang['chuyen-hang']?></a>
			    		<?php } ?>
			    		<hr>
					  	<a class="dropdown-item pjax-load" href="/warehouses/warehouses-history/import/"><?=$lang['lich-su-nhap-hang']?></a>
			    		<a class="dropdown-item pjax-load" href="/warehouses/warehouses-history/move/"><?=$lang['lich-su-chuyen-hang']?></a>
			    		<a class="dropdown-item pjax-load" href="/warehouses/warehouses-history/cancel/"><?=$lang['lich-su-huy-hang']?></a>
					  </div>
					</div>
					<?php } ?>
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
					    	<th><?=$lang['ma']?></th>
					        <th><?=$lang['noi-dung']?></th>
					        <th><?=$lang['ngay']?></th>
					  
					        <th><?=$lang['tai-khoan']?></th>
					        <th><?=$lang['trang-thai']?></th>
					        <th></th>
					        <th></th>
					    </tr>
					  </thead>
					  <tbody>	
					    <?php foreach ($datas as $data) { ?>
							<tr>
					            <td><a href="#" class="modal-url" data-url="/warehouses/warehouses-history-views/<?=$data['id']?>/">#<?=$data['code']?><?=$data['id']?></a></td>
					            <td><?=$data['content']?></td>
					            <td><?=date($setting['site_datetime'],strtotime($data['date_poster']))?></td>
					            
					            <td><?=$database->get("accounts","name",["id"=>$data['user']])?></td>
					            <td>
					            	<?php if($data['type']=='1'){?>
					            		<span class="fw-bold p-1 rounded-3 small btn-primary"><?=$lang['da-nhap-hang']?></span>
					            	<?php } elseif ($data['type']=='2') {
					            	?>
					            	<span class="fw-bold p-1 rounded-3 small btn-primary"><?=$lang['da-xuat-hang']?></span>
					            	<?php }?>
					     
					            </td>
					            <td>
					            	<a href="#" class="modal-url btn btn-light" data-url="/kitchen/warehouses-history-views/<?=$data['id']?>/">
						            	<i class="fa fa-eye"></i>
						            </a>
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
<?php if($router['1']=='warehouses-history-views'){?>
	<div class="modal fade modal-load" tabindex="-1">
	  <div class="modal-dialog modal-lg">
	    <div class="modal-content">
	      	<div class="modal-body">
	      		
			    
			    <table style="width: 100%">
			    	<?php if($data['type']=='1'){?>
				    	 <tr>
							<td><?=$lang['ma-nhap-hang']?>: #<?=$data['code']?><?=$data['id']?></td>
							<td><?=$lang['tai-khoan']?>: <?=$database->get("accounts","name",["id"=>$data['user']])?></td>
						</tr>
				    	<? } ?>
				    	
					<tr>
						<td>
							<?=$lang['trang-thai']?>: 
			      			<?php if($data['type']=='import'){?>
				            	<span class="fw-bold p-1 rounded-3 small text-primary"><?=$lang['da-nhap-hang']?></span>
				            <?php } ?>
				            <?php if($data['type']=='cancel'){?>
				            	<span class="fw-bold p-1 rounded-3 small text-danger"><?=$lang['da-huy-hang']?></span>
				            <?php } ?>
				            <?php if($data['type']=='move' || $data['type']=='return'){?>
					            <span class="fw-bold p-1 rounded-3 small text-<?=$Status_warehouser_move[$data['receive_status']]['color']?>"><?=$Status_warehouser_move[$data['receive_status']]['name']?></span>
					            <?php if($data['receive_status']==2){?>
					            <small class="d-block"><?=date($setting['site_datetime'],strtotime($data['receive_date']))?></small>
					            <?php } ?>
				            <?php } ?>
						</td>
					</tr>
					<tr>
						<td><?=$lang['noi-dung']?>: <?=$data['content']?></td>	
						<td></td>		
					</tr>
				</table>
		      	<div class="table-responsive">
					<table class="table table-hover table-striped table-bordered align-middle">
						<thead>
							<tr>
								<th><?=$lang['ma-san-pham']?></th>
								<th><?=$lang['san-pham']?></th>
								<th width="10%" class="text-center"><?=$lang['so-luong']?></th>
								<th class="text-center"><?=$lang['don-vi']?></th>
								<th class="text-center"><?=$lang['don-gia']?></th>
								<th class="text-end"><?=$lang['thanh-tien']?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($details as $key => $SelectProduct) {  
								$getPro = $database->get("food_warehouse","*",["id"=>$SelectProduct['products']]); 
								$total_price = $SelectProduct['amount']*$getPro['price'];
								$total += $total_price;
								$total_sele += $getPro['price'];
								$total_amount += $SelectProduct['amount'];
								$total_puchase = $SelectProduct['amount']*$SelectProduct['price'];
								$tong += $SelectProduct['price'];
								$tong_puchase += $total_puchase;
							?>
							<tr>
								<td>
									<?=$getPro['id_food']?>
								</td>
								<td class="p-2 pe-2 ps-2">
									<?=$getPro['name']?>
								</td>
								<td class="text-center">
									<?=number_format($SelectProduct['amount'])?>
								</td>
								<td class="text-center">
									<?=$database->get("unit_food","name",["id"=>$getPro['unit_food']])?>
								</td>
								<?php if($data['purchase']!=''){?>
								<td class="text-center"><?=number_format($SelectProduct['price'])?></td>
								<td class="text-center"><?=number_format($total_puchase)?></td>
								<?php }else{ ?>
								<td class="text-center"><?=number_format($getPro['price'])?></td>
								<td class="text-end"><?=number_format($total_price)?></td>
								<?php } ?>
							</tr>
							<?php } ?>
							<tr>
								<td></td>
								<td class="text-center"><?=$lang['tong']?></td>
								<td class="text-center"><?=number_format($total_amount)?></td>
								<td></td>
								<?php if($data['purchase']!=''){?>
								<td class="text-center"><?=number_format($tong)?></td>
								<td class="text-center"><?=number_format($tong_puchase)?></td>	
								<?php }else{?>
								<td class="text-center"><?=number_format($total_sele)?></td>
								<td class="text-end"><?=number_format($total)?></td>
								<?php } ?>
							</tr>
						</tbody>
					</table>
					
					
		
	      	</div>
	      	<div class="modal-footer d-print-none">
		        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?=$lang['huy']?></button>
		       
		    </div>
	    </div>
	  </div>
	</div>

<?php } ?>
<?php if($router['1']=='food_export'){?>
	<div class="pjax-content-load ">
		<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
			<div class="">
				<h4><?=$lang['xuat-kho']?></h4>
				<ol class="breadcrumb">
				    <li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
				    <li class="breadcrumb-item active" aria-current="page"><?=$lang['xuat-kho']?></li>
				</ol>
			</div>
		</nav>
		<?php if($jatbi->permission('food_import.add','button')==true || $jatbi->permission('food_import.delete','button')==true){?>
		<div class="fixed-action-btn">
		    <a class="btn btn-large btn-primary rounded-circle">
		      <i class="fas fa-bars" aria-hidden="true"></i>
		    </a>
		    <ul>
		      <?php if($jatbi->permission('food_export.delete','button')==true){?>
		      <li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/kitchen/food_export-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
		      <?php }?>
		      <?php if($jatbi->permission('food_export.add','button')==true){?>
		      <li><a class="pjax-load btn rounded-circle btn-info" href="/kitchen/food_export-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
						    <div class="filer-item vendor">
						    	<label><?=$lang['nha-cung-cap']?></label>
						    	<select name="vendor" class="form-control select2" style="width: 100%;">
						    		<option value=""><?=$lang['tat-ca']?></option>
						    		<?php foreach ($vendors as $vendor) { ?>
								      	<option value="<?=$vendor['id']?>"  <?=($xss->xss($_GET['vendor'])==$vendor['id']?'selected':'')?>><?=$vendor['name']?></option>
								    <?php } ?>
							    </select>
						    </div>
						    <div class="filer-item status_pay">
						    	<label><?=$lang['trang-thai']?></label>
						    	<select name="status_pay" class="select2 form-select" style="width:100%">
							      <option value=""><?=$lang['tat-ca']?></option>
							      <?php foreach ($Status_invoices as $key => $Status_invoice) {?>
							      	<option value="<?=$Status_invoice['id']?>" <?=($xss->xss($_GET['status_pay'])==$Status_invoice['id']?'selected':'')?>><?=$Status_invoice['name']?></option>
							      <?php } ?>
							    </select>
						    </div>
						    <div class="filer-item status">
						    	<label><?=$lang['tien-trinh']?></label>
						    	<select name="status" class="select2 form-select" style="width:100%">
							      <option value=""><?=$lang['tat-ca']?></option>
							      <?php foreach ($Status_purchase as $key => $Status_purchas) {?>
							      	<option value="<?=$Status_purchas['id']?>" <?=($xss->xss($_GET['status'])==$Status_purchas['id']?'selected':'')?>><?=$Status_purchas['name']?></option>
							      <?php } ?>
							    </select>
						    </div>
							<div class="filer-item date">
					    		<label><?=$lang['tu-ngay']?> - <?=$lang['den-ngay']?></label>
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
			    <div class="">
					<div class="table-responsive">
			   			<table class="table table-striped table-hover align-middle">
						  <thead>
						    <tr>
						        <?php if($jatbi->permission('food_import.delete','button')==true){?>
						      	<th width="1%" class="text-center align-middle">
									<div class="form-check">
									  <input class="form-check-input selectall" type="checkbox" value="" id="all">
									  <label class="form-check-label" for="all">
									  </label>
									</div>
						      	</th>
						      	<?php }?>
						        <th class="align-middle"><?=$lang['ma-xuat-hang']?></th>
						        <th class="align-middle"><?=$lang['noi-dung']?></th>
						        <th class="align-middle"><?=$lang['ngay']?></th>
						        <th class="align-middle"><?=$lang['tai-khoan']?></th>
						        <th width="2%"></th>
						        <th width="2%"></th>
						        <?php if($jatbi->permission('food_import.edit','button')==true){?>
						        <th width="2%"></th>
						        <?php }?>
						        <th width="2%"></th>
						    </tr>
						  </thead>
						  <tbody>
						    <?php foreach ($datas as $data) { ?>
								<tr>
					            <?php if($jatbi->permission('food_import.delete','button')==true){?>
					            <td class="align-middle">
					            	<?php if($data['status']==1 || $data['status']==4){?>
					            		<div class="form-check">
											<input class="form-check-input checker" type="checkbox" id="<?=$data['id']?>" name="BOX[<?=$data['id']?>]" value="<?=$data['id']?>">
											<label class="form-check-label" for="<?=$data['id']?>"></label>
										</div>
									<?php } ?>
					            </td>
					            <?php }?>
					            <td><a class="modal-url" data-url="/kitchen/food_import-views/<?=$data['id']?>/">#-<?=$data['code']?></a></td>
					            <td><?=$data['content']?></td>
					          
					            <td><?=date($setting['site_datetime'],strtotime($data['date']))?></td>
					            <td><?=$database->get("accounts","name",["id"=>$data['user']])?></td>
				            
					            <td>
						            <a class="p-1 rounded-3 small btn-light pjax-load" href="/kitchen/food_export-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
					            </td>
					            <td>
				            		<a class="btn btn-sm btn-light modal-url" data-url="/kitchen/purchase-views/<?=$data['id']?>/"><i class="fas fa-eye" aria-hidden="true"></i></a>
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
	</div>
<?php } ?>
<?php if($router['1']=='food_export-add' || $router['1']=='food_export-edit'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['xuat-kho']?></h4>
			<ol class="breadcrumb">
			    <li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
			    <li class="breadcrumb-item active" aria-current="page"><?=$lang['bep']?></li>
			</ol>
		</div>
	</nav>
	<div class="row justify-content-center align-items-center pjax-content-load">
		<div class="col-md-12">
			<div class="card card-custom">
				<div class="card-header bg-light border-0">
					<div class="row">
						<div class="mb-3 col-lg-4">
							<label class="col-form-label"><?=$lang['loai']?> <span class="text-danger">*</span></label>
					    	<select name="type" class="form-control select2 change-update" style="width: 100%;" data-url="/kitchen/purchase_export-update/<?=$action?>/typee/">
							      	<option value="2" <?=2==$_SESSION['purchase'][$action]['type']?'selected':''?>><?=$lang['xuat-kho']?></option>
						    </select>
						</div>
						
						<div class="mb-3 col-md-4">
							<label class="col-form-label"><?=$lang['ngay']?> <span class="text-danger">*</span></label>
					    	<input type="date" name="date" class="form-control blur-update" data-load="false" data-url="/kitchen/purchase_export-update/<?=$action?>/datee/" value="<?=$data['date']?>">
						</div>
						<div class="mb-3 col-md-4">
							<label class="col-form-label"><?=$lang['thuc-don-mon-an']?> <span class="text-danger">*</span></label>	
							
							<select name="food_menu" class="form-control select2 change-update" style="width: 100%;" data-url="/kitchen/purchase_export-update/<?=$action?>/food_menu/">
							<option value="" disabled selected><?=$lang['thuc-don-mon-an']?></option>
							<?php foreach ($food_menu as $f) { ?>
								<option value="<?=$f['id']?>"  <?=($data['food_menu']==$f['id']?'selected':'')?>><?=$f['name']?></option>
							<?php } ?>
						</select>
							</div>
					</div>
				</div>
				<div class="card-body">
				    <div class="">
				    	<div class="row">
							<div class="mb-3 col-lg-12">
								<label class="col-form-label"><?=$lang['san-pham']?> <span class="text-danger">*</span></label>	
								<select name="ingredient" class="form-control select2 change-update" style="width: 100%;" multiple="" data-url="/kitchen/purchase_export-update/<?=$action?>/productss/add/">
						    		<?php foreach ($ingredient as $ingred) { ?>
								      	<option value="<?=$ingred['id']?>" ><?=$ingred['name']?></option>
								    <?php } ?>
							    </select>
							</div>
				    	</div>
						<div class="table-responsive">
							<table class="table table-hover table-striped table-bordered align-middle">
								<thead>
									<tr>
										<th width="4%">STT</th>
										<th><?=$lang['san-pham']?></th>
										<th width="10%"><?=$lang['so-luong']?></th>
										<th><?=$lang['don-vi']?></th>
										<th><?=$lang['nha-cung-cap']?></th>
										<th><?=$lang['don-gia']?></th>
										<th><?=$lang['thanh-tien']?></th>
										<th></th>
									</tr>
									
								</thead>
								<tbody>
									<?php 
										foreach ($SelectProducts as $key => $SelectProduct) {
											$getPro = $database->get("food_warehouse","*",["id"=>$SelectProduct['products']]); 
											$total_price = $SelectProduct['amount']*$SelectProduct['price'];
											$total += $total_price;			
											$t+=1;					 										
									?>
									<tr>
										<td><?=$t?></td>
										<td class="p-1">
											<?=$getPro['name']?>
										</td>
										<td class="p-0">
												<input type="number" name="amount" class="blur-update border-0 w-100  h-100 p-3 bg-transparent" data-url="/kitchen/purchase_export-update/<?=$action?>/productss/amount/<?=$key?>/" value="<?=$SelectProduct['amount']?>" data-load="true">
										</td>
										<td class="p-1">
											<?=$database->get("unit_food","name",["id"=>$getPro['unit_food']])?>
										</td>
										<td class="p-1">
											<?=$database->get("supplier_food","name",["id"=>$getPro['supplier_food']])?>
										</td>
										<td class="p-0">
											<input type="text" name="price" class="blur-update border-0 w-100  h-100 p-3 bg-transparent number" data-url="/kitchen/purchase_export-update/<?=$action?>/productss/price/<?=$key?>/" value="<?=$SelectProduct['price']?>" data-load="true">
										</td>
										<td class="text-end fw-bold">
											<?=number_format($total_price)?>
										</td>
										<td class="text-center"><a class="click-update  text-danger" data-load="" data-url="/kitchen/purchase_export-update/<?=$action?>/productss/deleted/<?=$key?>/"><i class="fa fa-trash"></i></a></td>
									</tr>
									<?php } ?>
									
								</tbody>								
								<tfoot>
								
									<tr>
										<td colspan="6" class="text-end fw-bold"><?=$lang['tong-tien']?></td>
										<td class="text-end fw-bold text-primary"><?=number_format($total)?></td>
										<td></td>
									</tr>
									<tr>
										<td colspan="6" class="text-end fw-bold">
											<?=$lang['giam-gia']?>
											<?php $discount = ($data['discount']*$total/100); ?> 
											<?=number_format($discount)?> đ
										</td>
										<td class="text-end fw-bold p-0">
											<input type="text" name="discount" class="blur-update border-0 w-100  h-100 p-1 bg-transparent text-end" data-url="/kitchen/purchase_export-update/<?=$action?>/discountt/" value="<?=$data['discount']?>" data-load="true">
										</td>
										<td class="text-center">%</td>
									</tr>
									<tr>
										<td colspan="6" class="text-end fw-bold"><?=$lang['thanh-toan']?></td>
										<td class="text-end fw-bold text-success">
											<?php $payment = (($total-$minu-$discount)+$surcharge)?>
											<?=number_format($payment)?>
										</td>
										<td></td>
									</tr>
								</tfoot>
							</table>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="mb-3 ">
									<label class="col-form-label"><?=$lang['noi-dung']?> <span class="text-danger">*</span></label>
									<textarea name="content" class="form-control blur-update" style="height: 100px;" data-load="false" data-url="/kitchen/purchase_export-update/<?=$action?>/contentt/"><?=$data['content']?></textarea>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer text-end bg-light border-0">
					<a class="click-update btn btn-danger" data-load="" data-url="/kitchen/purchase_export-update/<?=$action?>/cancel/"><?=$lang['huy']?></a>
					<button class="click-update btn btn-success" data-load="/kitchen/food_export/" data-url="/kitchen/purchase_export-update/<?=$action?>/completed/"><?=$lang['hoan-tat']?></button>
				</div>
			</div>
		</div>
	</div>
<?php } ?>
