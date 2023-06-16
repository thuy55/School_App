<?php if($router['1']=='tuition'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['danh-sach-hoc-phi']?></h4>
			
		</div>
	</nav>
	<div class="fixed-action-btn">
		<a class="btn btn-large btn-primary rounded-circle">
			<i class="fas fa-bars" aria-hidden="true"></i>
		</a>
		<ul>

			<li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/tuitions/tuition-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>


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
							<div class="filer-item date">
					    	<label><?=$lang['ngay']?></label>
					    	<input type="text" class="form-control float-right daterange-select" name="date" value="<?=date('d/m/Y',strtotime($date_from))?> - <?=date('d/m/Y',strtotime($date_to))?>">
					    	</div>
							<div class="filer-item status">
								<label><?=$lang['trang-thai']?></label>
								<select name="status" class="select2 form-control" style="width:100%">
									<option value=""><?=$lang['tat-ca']?></option>
									<option value="A" <?=($_GET['status']=='A'?'selected':'')?>><?=$lang['kich-hoat']?></option>
									<option value="D" <?=($_GET['status']=='D'?'selected':'')?>><?=$lang['chua-kich-hoat']?></option>
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
								<th><?=$lang['ma-hoc-phi']?></th>
								<th><?=$lang['ngay']?></th>
								<th><?=$lang['ho-ten']?></th>
								<th><?=$lang['noi-dung']?></th>	
								<th><?=$lang['mien-giam']?></th>
								<th>Miễn giảm theo đối tượng</th>
								<th><?=$lang['da-dong']?></th> 
								<th width="2%"></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($datas as $data) {  

								
								?>
								<tr>
									<td class="align-middle">
										<div class="form-check">
											<input class="form-check-input checker" type="checkbox" id="<?=$data['id']?>" name="BOX[<?=$data['id']?>]" value="<?=$data['id']?>">
											<label class="form-check-label" for="<?=$data['id']?>"></label>
										</div>
									</td>
									<td></td>
									<td><?=$data['id_tuition']?></td>
									<td><?=date("d/m/Y", strtotime($data['date']))?></td>
									<td><?=$database->get("students", "firstname",["id"=>$database->get("arrange_class", "students",["id"=>$data['arrange_class']])])?> <?=$database->get("students", "lastname",["id"=>$database->get("arrange_class", "students",["id"=>$data['arrange_class']])])?></td>
									<td><?=$data['note']?></td>
									<td><?=$data['exemptions_current']?></td>
									<td><?=$data['exemptions']?></td>
									
									<td><?=number_format($data['total'])?></td> 
									
									


									<td>
										<?php if($jatbi->permission('tuition','button')==true){?>
											<td>
												<a class="btn btn-sm btn-light pjax-load" href="/tuitions/tuition_order_detail/<?=$data['id']?>/"><i class="fas fa-eye" aria-hidden="true"></i></a>
											</td>
										<?php }?>
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
<?php if($router['1']=='tuition_order_detail'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['chi-tiet-thanh-toan']?></h4>
			
		</div>
	</nav>
	
	<div class="card card-custom">
		<div class="card-body">
			
			<div class="pjax-content-load">
				<div class="table-responsive">
					<table class="table table-striped table-hover align-middle">
						<thead>
							<tr>

								

								<th width="50"></th>
								<th><?=$lang['thang']?></th>
								<th><?=$lang['noi-dung']?></th>
								<th><?=$lang['thang']?></th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($datas as $data) {  

								
								?>
								<tr>
									

									<td></td>
									<td><?=$data['month']?></td>
									
									<?php if($data['type']==0){?>
														<td><?=$database->get("content_tuition", "content",["id"=>$data['content_tuition']])?></td>
														<td><?=number_format($database->get("content_tuition", "price",["id"=>$data['content_tuition']]))?>đ/Ngày</td>
														<td><?=$data['number_of_month']?> Ngày</td>
									<?php }elseif($data['type']==4){?>
														<td>Trả <?=$database->get("content_tuition", "content",["id"=>$data['content_tuition']])?></td>
														<td><?=number_format($database->get("content_tuition", "price",["id"=>$data['content_tuition']]))?>đ/Ngày</td>
														<td><?=$data['number_of_month']?> Ngày</td>
									<?php }elseif($data['type']==1){
									?>
														<td><?=$database->get("content_tuition", "content",["id"=>$data['content_tuition']])?></td>
														<td><?=number_format($database->get("content_tuition", "price",["id"=>$data['content_tuition']]))?>đ/Tháng</td>
														<td></td>
									<?php }elseif($data['type']==2){
									?>
														<td><?=$database->get("content_tuition", "content",["id"=>$data['content_tuition']])?></td>
														<td><?=number_format($database->get("content_tuition", "price",["id"=>$data['content_tuition']]))?>đ/Năm</td>
														<td></td>
									<?php 
									}?>
									
									


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
<?php if($router['1']=='tuition-add' || $router['1']=='tuition-edit'){?>
	<div class="modal fade modal-load" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><?=$router['1']=='tuition-add'?$lang['them']:$lang['sua']?> <?=$lang['dong-hoc-phi']?></h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
					<div class="modal-body">
						<div class="row">
							<div class="col-sm-6">
								<div class="mb-3">
									<label><?=$lang['ma-hoc-phi']?> <small class="text-danger">*</small></label>
									<input placeholder="<?=$lang['ma-hoc-phi']?>" type="text" name="id_tuition" value="<?=$data['id_tuition']?>" class="form-control">
								</div>
								<div class="mb-3">
									<label><?=$lang['ngay']?></label>
									<input placeholder="<?=$lang['ngay']?>" type="date" name="date" value="<?=$data['date']?>" class="form-control">
								</div>
								<div class="mb-3">
									<label><?=$lang['noi-dung']?></label>
									<input placeholder="<?=$lang['noi-dung']?>" type="text" name="content" value="<?=$data['content']?>" class="form-control">
								</div>
								<div class="mb-3">
									<label><?=$lang['lop-hoc']?></label>		        		
									<input placeholder="<?=$lang['lop-hoc']?>" type="text" name="class" value="<?=$classs['name']?>" class="form-control">
								</div>
								<div class="mb-3">
									<label><?=$lang['hoc-sinh']?> <small class="text-danger">*</small></label>
									<select name="students" class="form-control select2" style="width: 100%;">
										<?php if(isset($data['students'])){ ?>
											<option value="<?=$data['students']?>"  selected ><?=$database->get("students", "firstname",["id"=>$data['students']])?> <?=$database->get("students", "lastname",["id"=>$data['students']])?></option>
										<?php } else {?>
											<option value="" disabled selected><?=$lang['hoc-sinh']?></option>
										<?php } ?>			    		
										<?php foreach ($studentss as $student) { ?>
											<option value="<?=$student['id']?>"  <?=($xss->xss($data['student'])==$student['id']?'selected':'')?>><?=$student['id_student']?> - <?=$student['firstname']?> <?=$student['lastname']?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="mb-3">
									<label><?=$lang['mien-giam']?><small class="text-danger">*</small></label>
									<input placeholder="<?=$lang['mien-giam']?>" type="text" name="exemptions" value="<?=$data['exemptions']?>" class="form-control">
								</div>

								<div class="mb-3">
									<label><?=$lang['so-tien-vnd']?><small class="text-danger">*</small></label>
									<input placeholder="<?=$lang['so-tien-vnd']?>" type="text" name="price" value="<?=$data['price']?>" class="form-control">
								</div>
								<div class="mb-3">
									<label><?=$lang['da-dong']?><small class="text-danger">*</small></label>
									<input placeholder="<?=$lang['da-dong']?>" type="text" name="pay" value="<?=$data['pay']?>" class="form-control">
								</div>



								<div class="mb-3">
									<label><?=$lang['trang-thai']?> <small class="text-danger">*</small></label>
									<select name="status" class="select2 form-control" style="width:100%">
										<option value="A" <?=($data['status']=='A'?'selected':'')?>><?=$lang['chua-dong']?></option>
										<option value="A" <?=($data['status']=='A'?'selected':'')?>><?=$lang['tam-nop']?></option>
										<option value="D" <?=($data['status']=='D'?'selected':'')?>><?=$lang['da-nop']?></option>
									</select>
								</div>
								<div class="mb-3">
									<label><?= $lang['tai-khoan']?><small class="text-danger">*</small></label>
									<?php $account == $accounts  ?>
									<input  type="text" name="accounts" value="<?=$account['name']?>" class="form-control" readonly>
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
<?php } ?>
<?php if($router['1']=='revenue'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['doanh-thu']?></h4>			
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

								<th width="1%" class="text-center">
									<div class="form-check">
										<input class="form-check-input selectall" type="checkbox" value="" id="all">
										<label class="form-check-label" for="all">
										</label>
									</div>
								</th>

								<th width="50"></th>
								<th><?=$lang['ma-hoc-phi']?></th>
								<th><?=$lang['ngay']?></th>
								<th><?=$lang['ho-ten']?></th>
								<th><?=$lang['noi-dung']?></th>	
								<th><?=$lang['mien-giam']?></th>
								
								<th><?=$lang['da-dong']?></th> 
								<th width="2%"></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($datas as $data) {  
								$revenue+=$data['total']
								
								?>
								<tr>
									<td class="align-middle">
										<div class="form-check">
											<input class="form-check-input checker" type="checkbox" id="<?=$data['id']?>" name="BOX[<?=$data['id']?>]" value="<?=$data['id']?>">
											<label class="form-check-label" for="<?=$data['id']?>"></label>
										</div>
									</td>
									<td></td>
									<td><?=$data['id_tuition']?></td>
									<td><?=date("d/m/Y", strtotime($data['date']))?></td>
									<td><?=$database->get("students", "firstname",["id"=>$database->get("arrange_class", "students",["id"=>$data['arrange_class']])])?> <?=$database->get("students", "lastname",["id"=>$database->get("arrange_class", "students",["id"=>$data['arrange_class']])])?></td>
									<td><?=$data['note']?></td>
									<td><?=$data['exemptions']?></td>
									
									<td><?=number_format($data['total'])?></td> 
									
									




								</tr>
							<?php } ?>
						</tbody>
						<tfoot>
							<td colspan="6"></td>
							<td><strong>Tổng doanh thu: </strong></td>
							<td><strong><?=number_format($revenue)?> đ</strong></td>
						</tfoot>
					</table>
				</div>
				<nav class="d-flex justify-content-between align-items-center paginations" aria-label="Page navigation">
					<?=$page?>
				</nav>
			</div>
		</div>
	</div>
<?php } ?>
<?php if($router['1']=='content_tuition'){?>
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
			<div><h4><?=$lang['thong-tin-hoc-phi']?> <?=$lang['lop']?> <?=$database->get("class", "name",["id"=>$database->get("class_diagram", "class",["id"=>$_SESSION['router']])])?></h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
				<li class="breadcrumb-item active" aria-current="page"><?=$lang['hoc-phi']?></li>
			</ol></div>
			
			
		</div>
		
	</nav>
	<?php if($jatbi->permission('content_tuition.add','button')==true || $jatbi->permission('content_tuition.delete','button')==true){?>
		<div class="fixed-action-btn">
			<a class="btn btn-large btn-primary rounded-circle">
				<i class="fas fa-bars" aria-hidden="true"></i>
			</a>
			<ul>
				<?php if($jatbi->permission('content_tuition.delete','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/tuitions/content_tuition-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
				<?php }?>
				<?php if($jatbi->permission('content_tuition.add','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-info" data-url="/tuitions/content_tuition-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
								<?php if($jatbi->permission('content_tuition.delete','button')==true){?>
									<th width="1%" class="text-center">
										<div class="form-check">
											<input class="form-check-input selectall" type="checkbox" value="" id="all">
											<label class="form-check-label" for="all">
											</label>
										</div>
									</th>
								<?php }?>
								<th width="50"></th>
								
								<th><?=$lang['noi-dung']?></th>
								<th><?=$lang['so-tien']?></th>
								<th><?=$lang['thoi-gian']?></th>		

								<th><?=$lang['trang-thai']?></th>
								<?php if($jatbi->permission('content_tuition.edit','button')==true){?>
									<th width="2%"></th>
								<?php }?>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($datas as $data) { ?>
								<tr>
									<?php if($jatbi->permission('content_tuition.delete','button')==true){?>
										<td class="align-middle">
											<div class="form-check">
												<input class="form-check-input checker" type="checkbox" id="<?=$data['id']?>" name="BOX[<?=$data['id']?>]" value="<?=$data['id']?>">
												<label class="form-check-label" for="<?=$data['id']?>"></label>
											</div>
										</td>
									<?php }?>
									<td></td>
									
									
									<td><?=$data['content']?></td>
									<?php if($data['type'] == 0){?>
										<td><?=number_format($data['price'])?>đ/Ngày</td>
									<?php }elseif($data['type'] == 1){
									?>
									<td><?=number_format($data['price'])?>đ/Tháng</td>
									<?php }elseif($data['type'] == 2){
									?>
									<td><?=number_format($data['price'])?>đ/Năm</td>
									<?php  
									}?>
									<td><?=date("d/m/Y", strtotime($data['payment_deadline']))?></td>
									
									<td>	
										<div class="form-check form-switch">
											<input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/tuitions/content_tuition-status/<?=$data['id']?>/">
											<label class="form-check-label" for="status"></label>
										</div>
									</td>
									<?php if($jatbi->permission('content_tuition.edit','button')==true){?>
										<td>
											<a class="btn btn-sm btn-light modal-url" data-url="/tuitions/content_tuition-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
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
<?php if($router['1']=='content_tuition-add' || $router['1']=='content_tuition-edit'){?>
	<div class="modal fade modal-load" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><?=$router['1']=='content_tuition-add'?$lang['them']:$lang['sua']?> <?=$lang['hoc-phi']?></h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
					<div class="modal-body">
						<div class="row">
							<div class="col-sm-6">
							
								<div class="mb-3">
									<label><?=$lang['lop-hoc']?><small class="text-danger">*</small></label>
									<select name="class" class="select2 form-control" style="width:100%">
											<option value="<?=$classs['id']?>"  selected><?=$database->get("class", "name",["id"=>$database->get("class_diagram", "class",["id"=>$_SESSION['router']])])?></option>	
									</select>
								</div>
			
								<div class="mb-3">
									<label><?=$lang['noi-dung']?><small class="text-danger">*</small></label>
									<input placeholder="<?=$lang['noi-dung']?>" type="text" name="content" value="<?=$data['content']?>" class="form-control">
								</div>
								<div class="mb-3">
									<label><?=$lang['so-tien']?><small class="text-danger">*</small></label>
									<input placeholder="<?=$lang['so-tien']?>" type="text" name="price" value="<?=$data['price']?>" class="form-control">
								</div>	
							</div> 	

							<div class="col-sm-6">	
										
								<div class="mb-3">
									<label><?=$lang['loai']?> <small class="text-danger">*</small></label>
									<select name="type" class="select2 form-control" style="width:100%">
										<option value="0" <?=($data['status']==0?'selected':'')?>><?=$lang['ngay']?></option>
										<option value="1" <?=($data['status']==1?'selected':'')?>><?=$lang['thang']?></option>
										<option value="2" <?=($data['status']==2?'selected':'')?>><?=$lang['nam']?></option>
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
<?php if($router['1']=='content_tuition-delete'){?>
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
<?php if($router['1']=='content_tuition-class'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['thong-tin-hoc-phi']?> </h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
				<li class="breadcrumb-item active" aria-current="page"><?=$lang['lop-hoc-vu']?></li>
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
								  <input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/class-academic/class-status/<?=$data['id']?>/">
								  <label class="form-check-label" for="status"></label>
								</div>
				            </td>
				            <?php if($jatbi->permission('timekeeping','button')==true){?>
				            	<td>
				            		<a class="btn btn-sm btn-light pjax-load" href="/tuitions/content_tuition/<?=$data['id']?>/"><i class="fas fa-eye" aria-hidden="true"></i></a>
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
<?php if($router['1']=='tuition_order'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['thu-hoc-phi']?> <?=$counts?></h4>			
		</div>
	</nav>
	<div class="sales-pos">
		<div class="row">
			<div class="col-lg-8">
				<div class="card p-2 mb-3">
					<div class="card-body p-1">
						<div class="row">
							<div class="col-lg-9">
								<div class="input-group">
									<a href="#" class="btn btn-light p-1 pe-3 ps-3"><i class="fa fa-bars"></i></a>
									<div class="dropdown w-100 dropdown-autocomplete">
										<select  class="form-control select2 change-update" style="width: 100%;" data-url="/tuitions/tuition-update/<?=$action?>/content_tuition/add/">
											<option value="" disabled selected><?=$lang['chon-loai-hoc-phi']?></option>
											<?php foreach ($content_tuition as $content_tuition) { ?>
												<option value="<?=$content_tuition['id']?>"  <?=($data['content_tuition']==$content_tuition['id']?'selected':'')?>><?=$content_tuition['content']?></option>
											<?php } ?>
										</select>																				
									</div>
								</div>
								<div class="input-group pt-2">
									<a href="#" class="btn btn-light p-1 pe-3 ps-3"><i class="fa fa-bars"></i></a>
									<div class="dropdown w-100 dropdown-autocomplete">
										<select  class="form-control select2 change-update" style="width: 100%;" data-url="/tuitions/tuition-update/<?=$action?>/payment_deadline/">
											<option value="" disabled selected><?=$lang['dong-tien-theo-thang']?></option>
												<option value="1">1</option>
												<option value="2">2</option>
												<option value="3">3</option>
												<option value="4">4</option>
												<option value="5">5</option>
												<option value="6">6</option>
												<option value="7">7</option>
												<option value="8">8</option>
												<option value="9">9</option>
												<option value="10">10</option>
												<option value="11">11</option>
												<option value="12">12</option>
											
										</select>																				
									</div>
								</div>

							</div>
							<div class="col-lg-3">
								<div>
									<a href="/tuitions/content_tuition/<?=$data['class']?>/" class="btn btn-light w-100 pjax-load"><?=$lang['thong-tin-hoc-phi']?></a>
								</div>
								
								<div class="pt-3">
									<button data-url="/tuitions/tuition-update/<?=$action?>/reload/" class="btn btn-light w-100 click-update"><?=$lang['lam-moi']?></button>
								</div>
							</div>

						</div>
					</div>
				</div>
				<div class="sales-infomation">
					<div class="card sales-products pjax-content-load ">
						<div class="card-body p-1">
							<div class="list-products mt-4">
								<div class="table-responsive">
									<table class="table align-middle" style="font-size:10px;">
										<thead>
											<tr>

											
												<th width="20%"><?=$lang['thang']?></th>
												<th width="20%"><?=$lang['noi-dung']?></th>									
												<th width="10%" ><?=$lang['so-tien-vnd']?></th>				
												<th width="10%"></th>
												<th width="1%"></th>
											</tr>
										</thead>
										<tbody>

											<?php foreach ($SelectProducts as $key => $select) { 
												$getPro = $database->get("content_tuition","*",["id"=>$select['content_tuition']]);
												$timework_details = $database->select("timework_details", "week",[
																													"AND" => [
																														"deleted"       => 0,
																														"off"		=>1,
																														"school" =>$_SESSION['school'],
																													]
																											]); 
												$number_day=0;
												$songay=0;
												$thang=$select['month'];
												$nam=date("Y", strtotime($getPro['payment_deadline']));
												
												if (!function_exists('cal_days_in_month')) {
												    function cal_days_in_month($calendar, $month, $year) {
													    return intval(date('t', strtotime($year . '-' . $month . '-01')));
													}

												}

												$ngaytrongthang= cal_days_in_month(CAL_GREGORIAN,$select['month'], date("Y", strtotime($getPro['payment_deadline'])));

												for ($ngay = 1; $ngay <= $ngaytrongthang; $ngay++) {
												    $ngayhientai = date('N', strtotime("$nam-$thang-$ngay"));
												    if (!in_array($ngayhientai,$timework_details)) {
												        $songay++;
												    }
												}
													if($select['type'] == 0){
														
														$sum +=$getPro['price']*($songay);
													}elseif($select['type'] == 4){
														$sum -=$getPro['price']*$select['number_of_month'];
													}else{
														$sum +=$getPro['price'];
													}	
												?>
												<?php if($select['type']==4) {?>
													<tr> 
													<td><?=$select['month']?></td>
													<td><?=$select['content']?></td>
													<td><?=number_format($getPro['price'])?>đ/Ngày</td>
													<td><?=$select['number_of_month']?> Ngày</td>
													
													<td class="text-center"><a class="click-update  text-danger" data-load="" data-url="/tuitions/tuition-update/<?=$action?>/content_tuition/deleted/<?=$key?>/"><i class="fa fa-trash"></i></a></td>
												</tr>

												<?php }else{?>
												<tr> 
													<td><?=$select['month']?></td>
													<td><?=$select['content']?></td>
													<?php if($getPro['type']==0){?>
														<td><?=number_format($getPro['price'])?>đ/Ngày</td>
														<td><?=$songay?> Ngày</td>
													<?php }elseif($getPro['type']==1){
													?>
														<td><?=number_format($getPro['price'])?>đ/Tháng</td>
														<td></td>
														<?php }elseif($getPro['type']==2){
													?>
														<td><?=number_format($getPro['price'])?>đ/Năm</td>
														<td></td>
														<?php 
													}?>
													<td class="text-center"><a class="click-update  text-danger" data-load="" data-url="/tuitions/tuition-update/<?=$action?>/content_tuition/deleted/<?=$key?>/"><i class="fa fa-trash"></i></a></td>
												</tr>
												<?php } ?>
											<?php } ?>
											
										</tbody>
										<tfoot>
											<td colspan="2"></td>
											<td><strong><?=$lang['tong-cong']?> : </strong></td>
											<td><strong><?=number_format($sum)?>đ</strong></td>
										</tfoot>
									</table>
								</div>
							</div> 
						</div>
					</div>
					<div class="border rounded-3 p-2">
						<div class="row">
							<div class="col-lg-6">
								<div class="mb-1">
									<label class="col-form-label"><?=$lang['ghi-chu']?> <small class="text-danger">*</small></label>
									<textarea name="note" class="form-control blur-update" style="height: 100px;" data-load="false" data-url="/tuitions/tuition-update/<?=$action?>/note/"><?=$data['note']?></textarea>
								</div>
							</div>

						</div>
					</div> 
				</div>
			</div>
			<div class="col-lg-4">
				<div class="card sales-payment p-3 pjax-content-load ">
					<div class="input-group">							
						<span class="input-group-text bg-white"><?=$lang['nam-hoc']?> </span>
						<select  class="form-control select2 change-update" style="width: 100%;" data-url="/tuitions/tuition-update/<?=$action?>/school_year/">
							<option value="" disabled selected><?=$lang['chon-nam-hoc']?></option>
							<?php foreach ($school_years as $school_year) { ?>
								<option value="<?=$school_year['id']?>"  <?=($data['school_year']==$school_year['id']?'selected':'')?>><?=$school_year['name']?></option>
							<?php } ?>
						</select>						   
					</div>
				</br>
				<div class="input-group">							
					<span class="input-group-text bg-white"><?=$lang['lop']?> </span>
					<select name="class" class="form-control select2 change-update" style="width: 100%;" data-url="/tuitions/tuition-update/<?=$action?>/class/">
						<option value="" disabled selected><?=$lang['chon-lop']?></option>
						<?php foreach ($classs as $class) { ?>
							<option value="<?=$class['id']?>"  <?=($data['class']==$class['id']?'selected':'')?>><?=$database->get("class","name",['id'=>$class['class']])?></option>
						<?php } ?>
					</select>						   
				</div>
			</br>
			<div class="input-group">							
				<span class="input-group-text bg-white"><?=$lang['hoc-sinh']?> </span>
				<select name="student" class="form-control select2 change-update" style="width: 100%;" data-url="/tuitions/tuition-update/<?=$action?>/student/">
					<option value="" disabled selected><?=$lang['chon-hoc-sinh']?></option>
					<?php foreach ($students as $student) { ?>
						<option value="<?=$student['id']?>"  <?=($data['student']==$student['id']?'selected':'')?>><?=$database->get("students","firstname",['id'=>$student['students']])?> <?=$database->get("students","lastname",['id'=>$student['students']])?></option>
					<?php } ?>
				</select>						   
			</div>
			<div class="row d-flex align-items-start mt-3">
				<div class="col-md-6 mb-2 d-flex">
					<span class="fst-italic text-muted d-block me-2"><?=$lang['ma-hoc-sinh']?>: </span>
					<strong><?=$database->get("students","id_student",['id'=>$studentss['students']])?></strong>
				</div>

				<div class="col-md-6 mb-2 d-flex">
					<span class="fst-italic text-muted d-block me-2"><?=$lang['ngay-sinh']?>: </span>
					<strong><?=date("d/m/Y", strtotime($database->get("students","birthday",['id'=>$studentss['students']])))?></strong>
				</div>
				<div class="col-md-6 mb-2 d-flex">
					<span class="fst-italic text-muted d-block me-2"><?=$lang['gioi-tinh']?>: </span>
					<strong><?=$database->get("students","gender",['id'=>$studentss['students']])?></strong>
				</div>
				<div class="col-md-12 mb-2 d-flex">
					<span class="fst-italic text-muted d-block me-2"><?=$lang['ngay-nhap-hoc']?>: </span>
					<strong><?=date("d/m/Y", strtotime($database->get("students","year_of_admission",['id'=>$studentss['students']])))?></strong>
				</div>
				<div class="col-md-12 mb-2 d-flex">
					<span class="fst-italic text-muted d-block me-2"><?=$lang['phu-huynh']?>: </span>
					<strong><?=$database->get("parent","name",["id"=>$database->get("students","parent",['id'=>$studentss['students']])])?></strong>
				</div>
				<div class="col-md-12 mb-2 d-flex">
					<span class="fst-italic text-muted d-block me-2"><?=$lang['doi-tuong']?>: </span>
					<strong><?=$database->get("priority_object","name",["id"=>$database->get("students","priority_object",['id'=>$studentss['students']])])?></strong>
				</div>
			</div>
		</div>
		<div class="details border-bottom mt-3">
			<?php if(date("m", strtotime($database->get("students","year_of_admission",['id'=>$studentss['students']])))==date('m')&&date("Y", strtotime($database->get("students","year_of_admission",['id'=>$studentss['students']])))==date('Y')){?>
			<div class="mb-2">
				<span class="fst-italic  d-block me-2 text-danger">Tháng <?=date('m')?> trùng với tháng nhập học</span>
				<div class="input-group">
					<span class="input-group-text bg-white">Giảm học phí</span>
					<input placeholder="<?=$lang['mien-giam']?>" type="number" name="exemptions_current" class="form-control blur-update" data-load="true" data-url="/tuitions/tuition-update/<?=$action?>/exemptions_current/" value="<?=$data['exemptions_current']?>" min="0" max="100" step="1">
					<div class="input-group-text">%</div>
				</div>
			</div>
			<?php } ?>
			<div class="mb-2">
				<div class="input-group">
					<span class="input-group-text bg-white">Miễn giảm theo đối tượng</span>
					<input placeholder="<?=$lang['mien-giam']?>" type="number" name="exemptions" class="form-control blur-update" data-load="true" data-url="/tuitions/tuition-update/<?=$action?>/exemptions/" value="<?=$data['exemptions']?>" min="0" max="100" step="1" readonly>
					<div class="input-group-text">%</div>
				</div>
			</div>
		
			
		</div>
		
			        	<div class="col-md-12 mb-3">
			        		<label><?=$lang['hinh-thuc-thanh-toan']?> <small class="text-danger">*</small></label>
						   	<select name="type_payments" class="form-control select2 change-update" style="width:100%" data-url="/tuitions/tuition-update/<?=$action?>/type_payments/">
						   		<option value="" disabled selected><?=$lang['hinh-thuc-thanh-toan']?></option>
				        		<?php foreach ($type_payments as $type_payment) { ?>
				        			<option value="<?=$type_payment['id']?>" <?=$data['type_payments']==$type_payment['id']?'selected':''?>><?=$type_payment['name']?></option>
				        		<?php } ?>
						    </select>
					    </div>
					
		<div class="payment mt-2">
			<div class="col-lg-12 mb-3">
				<div class="row fw-bold mb-2">
					<div class="col">
						<?=$lang['tong-tien-hoc-phi']?>
					</div>
					<div class="col text-end">
						<?=number_format($sum)?>
					</div>
				</div>
				<div class="row fw-bold mb-2">
					<div class="col">
						<a href="#" class="modal-url" >
							Miễn giảm theo đối tượng:
						</a>
					</div>
					<div class="col text-end">
						<?php $exemptions = ($data['exemptions']*$sum)/100;?>
						<?=number_format($exemptions)?>
					</div>
				</div>
				<?php if(date("m", strtotime($database->get("students","year_of_admission",['id'=>$studentss['students']])))==date('m')&&date("Y", strtotime($database->get("students","year_of_admission",['id'=>$studentss['students']])))==date('Y')){?>
				<div class="row fw-bold mb-2">
					<div class="col">
						<a href="#" class="modal-url" >
							Giảm học phí:
						</a>
					</div>
					<div class="col text-end">
						<?php $exemptions_current = ($data['exemptions_current']*($sum-$exemptions))/100 ?>
						<?=number_format($exemptions_current)?>
					</div>
				</div>
				<?php } ?>
				<?php 
					if(date("m", strtotime($database->get("students","year_of_admission",['id'=>$studentss['students']])))==date('m')&&date("Y", strtotime($database->get("students","year_of_admission",['id'=>$studentss['students']])))==date('Y')){
						$total_payment = $sum-$exemptions_current;
					}else{
						$total_payment = $sum-$exemptions;
					} ?>
				
				<div class="row fw-bold mb-2 text-dark">
					<div class="col">
						<?=$lang['thanh-tien']?>
					</div>
					<div class="col text-end">
						<?=number_format($total_payment)?>
					</div>
				</div>			
			</div>
			<div class="d-flex flex-row bd-highlight mb-3">
				<button  class="btn btn-primary p-2 bd-highlight click-update btn btn-success w-100 p-2 fs-5"   data-url="/tuitions/tuition-update/<?=$action?>/completed/"><?=$lang['thanh-toan']?> <?=number_format($total_payment)?> đ</button>

			</div>

		</div>
		</div>
	</div>
	</div>
	</div>
<?php } ?>
<?php if($router['1']=='tuition_debt-school_year'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['xem-cong-no-theo-nam']?></h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
				<li class="breadcrumb-item active" aria-current="page"><?=$lang['lop-hoc-vu']?></li>
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
								<th><?=$lang['nam-hoc']?></th>	                			        					      
								<th><?=$lang['trang-thai']?></th>

							</tr>
						</thead>
						<tbody>
							<?php foreach ($datas as $data) { ?>
								<tr>				            
									<td></td>				           				           
									<td><?=$data['name']?></td>
									<td>	
										<div class="form-check form-switch">
											<input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/class-academic/school_year-status/<?=$data['id']?>/">
											<label class="form-check-label" for="status"></label>
										</div>
									</td>
									<?php if($jatbi->permission('tuition','button')==true){?>
										<td>
											<a class="btn btn-sm btn-light pjax-load" href="/tuitions/tuition_debt-class/<?=$data['id']?>/"><i class="fas fa-eye" aria-hidden="true"></i></a>
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
<?php if($router['1']=='tuition_debt-class'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['xem-cong-no-theo-lop']?> </h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
				<li class="breadcrumb-item active" aria-current="page"><?=$lang['lop-hoc-vu']?></li>
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
								<th><?=$lang['lop-hoc']?></th>	                			        					      
								<th><?=$lang['trang-thai']?></th>

							</tr>
						</thead>
						<tbody>
							<?php foreach ($datas as $data) { ?>
								<tr>				            
									<td></td>				           				           
									<td><?=$data['name']?></td>
									<td>	
										<div class="form-check form-switch">
											<input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/class-academic/class-status/<?=$data['id']?>/">
											<label class="form-check-label" for="status"></label>
										</div>
									</td>
									<?php if($jatbi->permission('tuition','button')==true){?>
										<td>
											<a class="btn btn-sm btn-light pjax-load" href="/tuitions/tuition_debt/<?=$data['id']?>/"><i class="fas fa-eye" aria-hidden="true"></i></a>
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
<?php if($router['1']=='tuition_debt'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['danh-sach-cong-no']?></h4>
			
		</div>
	</nav>
	<div class="fixed-action-btn">
		<a class="btn btn-large btn-primary rounded-circle">
			<i class="fas fa-bars" aria-hidden="true"></i>
		</a>
		<ul>
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
									<option value="D" <?=($_GET['status']=='D'?'selected':'')?>><?=$lang['chua-kich-hoat']?></option>
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
								<th><?=$lang['ma-hoc-sinh']?></th>
								<th><?=$lang['ho-ten']?></th>	
								<th><?=$lang['lop-hoc']?></th>
								<th><?=$lang['khoa-hoc']?></th>								
								<th><?=$lang['trang-thai']?></th> 
								<th width="2%"></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($student_debt as $data) { 
							?>
							
								<tr>
									<td class="align-middle">
										<div class="form-check">
											<input class="form-check-input checker" type="checkbox" id="<?=$data['id']?>" name="BOX[<?=$data['id']?>]" value="<?=$data['id']?>">
											<label class="form-check-label" for="<?=$data['id']?>"></label>
										</div>
									</td>

									<td></td>
									<td><?=$database->get("students", "id_student",["id"=>$data['students']])?></td>
									<td><?=$database->get("students", "firstname",["id"=>$data['students']])?> <?=$database->get("students", "lastname",["id"=>$data['students']])?></td>
									<td><?=$database->get("class", "name",["id"=>$database->get("class_diagram", "class",["id"=>$data['class_diagram']])])?></td>
									<td><?=$database->get("course", "name",["id"=>$database->get("class_diagram", "course",["id"=>$data['class_diagram']])])?></td>
									<td><span class="font-weight-bold text-danger">Còn nợ <?=$d?></span></td>
									<td>
										<?php if($jatbi->permission('tuition','button')==true){?>
											<td>
												<a class="btn btn-sm btn-light pjax-load" href="/tuitions/tuition_debt_detail/<?=$data['id']?>/"><i class="fas fa-eye" aria-hidden="true"></i></a>
											</td>
										<?php }?>
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
<?php if($router['1']=='tuition_debt_detail'){?>
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
			<div><h4><?=$lang['xem-chi-tiet-cong-no']?> của học sinh <?=$students['fullname']?></h4></div>
			
			
		</div>
	</nav>
	
	<div class="card card-custom">
		<div class="card-body">
			
			<div class="pjax-content-load">
				<div class="table-responsive">
					<table class="table table-striped table-hover align-middle">
						<thead>
							<tr>
								<th width="50"></th>
								<th><?=$lang['thang']?></th>
								<th><?=$lang['noi-dung']?></th>
								<th><?=$lang['so-tien-vnd']?></th>
								
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php if($tuition_order_detail==[]){
							?> 
								<?php foreach ($datas1 as $data) { 
									
								?>
									<tr>
										<td></td>
										<th><?=$data['month']?>/<?=$data['payment_deadline']?></th>
										<th><?=$data['content']?></th>
									<?php if($data['type']==0 ){?>
														<td><?=number_format($data['price'])?>đ/Ngày</td>
														<td><?=$data['number_of_month']?> Ngày</td>
									<?php }elseif($data['type']==1){
									?>
														<td><?=number_format($data['price'])?>đ/Tháng</td>
														<td></td>
									<?php }elseif($data['type']==2){
									?>
														<td><?=number_format($data['price'])?>đ/Năm</td>
														<td></td>
									<?php 
									}?>

									</tr>
								
								<?php
								} ?>
							<?php 
							}else { ?>

								<?php foreach ($datas as $data) { 
									
								?>
									<tr>
										<td></td>
										<th><?=$data['month']?>/<?=$data['payment_deadline']?></th>
										<th><?=$data['content']?></th>
										<?php if($data['type']==0 ){?>
														<td><?=number_format($data['price'])?>đ/Ngày</td>
														<td><?=$data['number_of_month']?> Ngày</td>
									<?php }elseif($data['type']==1){
									?>
														<td><?=number_format($data['price'])?>đ/Tháng</td>
														<td></td>
									<?php }elseif($data['type']==2){
									?>
														<td><?=number_format($data['price'])?>đ/Năm</td>
														<td></td>
									<?php 
									}?>				
										
									</tr>
						
								
							<?php }
							} ?>
						</tbody>
					</table>
				</div>
				<!-- <nav class="d-flex justify-content-between align-items-center paginations" aria-label="Page navigation">
					<?=$page?>
				</nav> -->
			</div>
		</div>
	</div>
<?php } ?>
<?php if($router['1']=='type-payments'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['hinh-thuc-thanh-toan']?></h4>
			<ol class="breadcrumb">
			    <li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
			    <li class="breadcrumb-item active" aria-current="page"><?=$lang['hinh-thuc-thanh-toan']?></li>
			</ol>
		</div>
	</nav>
	<?php if($jatbi->permission('type-payments.add','button')==true || $jatbi->permission('type-payments.delete','button')==true){?>
	<div class="fixed-action-btn">
	    <a class="btn btn-large btn-primary rounded-circle">
	      <i class="fas fa-bars" aria-hidden="true"></i>
	    </a>
	    <ul>
	      <?php if($jatbi->permission('type-payments.delete','button')==true){?>
	      <li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/tuitions/type-payments-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
	      <?php }?>
	      <?php if($jatbi->permission('type-payments.add','button')==true){?>
	      <li><a class="modal-url btn rounded-circle btn-info" data-url="/tuitions/type-payments-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
					        <?php if($jatbi->permission('type-payments.delete','button')==true){?>
					      	<th width="1%" class="text-center">
								<div class="form-check">
								  <input class="form-check-input selectall" type="checkbox" value="" id="all">
								  <label class="form-check-label" for="all">
								  </label>
								</div>
					      	</th>
					      	<?php }?>
					        <th><?=$lang['ten']?></th>
					        <th><?=$lang['tai-khoan-co']?></th>
					        <th><?=$lang['tai-khoan-no']?></th>
					        <th><?=$lang['muc-chinh']?></th>
					        <th><?=$lang['loai-thanh-toan']?></th>
					        <th><?=$lang['ghi-chu']?></th>
					        <th><?=$lang['trang-thai']?></th>
					        <?php if($jatbi->permission('type-payments.edit','button')==true){?>
					        <th width="2%"></th>
					        <?php }?>
					    </tr>
					  </thead>
					  <tbody>
					    <?php foreach ($datas as $data) { ?>
							<tr>
				            <?php if($jatbi->permission('type-payments.delete','button')==true){?>
				            <td class="align-middle">
			            		<div class="form-check">
									<input class="form-check-input checker" type="checkbox" id="<?=$data['id']?>" name="BOX[<?=$data['id']?>]" value="<?=$data['id']?>">
									<label class="form-check-label" for="<?=$data['id']?>"></label>
								</div>
				            </td>
				            <?php }?>
				            <td><?=$data['name']?></td>
				            <td><?=$database->get("accountants_code","code",["code"=>$data['has']])?> - <?=$database->get("accountants_code","name",["code"=>$data['has']])?></td>
				            <td><?=$database->get("accountants_code","code",["code"=>$data['debt']])?> - <?=$database->get("accountants_code","name",["code"=>$data['debt']])?></td>
				            <td><?=$database->get("type_payments","name",["id"=>$data['main']])?></td>
				             <td><?=$payment_type[$data['type']]['name']?></td>
				            <td><?=$data['notes']?></td>
				            <td>	
				            	<div class="form-check form-switch">
								  <input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/tuitions/type-payments-status/<?=$data['id']?>/">
								  <label class="form-check-label" for="status"></label>
								</div>
				            </td>
				            <?php if($jatbi->permission('type-payments.edit','button')==true){?>
				            	<td>
				            		<a class="btn btn-sm btn-light modal-url" data-url="/tuitions/type-payments-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
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
<?php if($router['1']=='type-payments-add' || $router['1']=='type-payments-edit'){?>
	<div class="modal fade modal-load" tabindex="-1">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title"><?=$router['1']=='type-payments-add'?$lang['them']:$lang['sua']?> <?=$lang['hinh-thuc-thanh-toan']?></h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
	      <div class="modal-body">
	      	<div class="row">
		        <div class="col-sm-12">
		        	<div class="mb-3">
		        		<label>Mã <small class="text-danger">*</small></label>
		        		<input type="text" name="code" class="form-control" value="<?=$data['code']?>">
				    </div>
		        	<div class="mb-3">
		        		<label><?=$lang['loai-thanh-toan']?> <small class="text-danger">*</small></label>
					   	<select name="type" class="select2 form-control" style="width:100%">
					   		<option value=""><?=$lang['loai-thanh-toan']?></option>
			        		<?php foreach ($payment_type  as $key => $type) { ?>
			        			<option value="<?=$type['id']?>" <?=$data['type']==$type['id']?'selected':''?>><?=$type['name']?></option>
			        		<?php } ?>
					    </select>
				    </div>
		        	
		        	<div class="mb-3">
		        		<label><?=$lang['ten']?> <small class="text-danger">*</small></label>
					    <input placeholder="<?=$lang['ten']?>" type="text" name="name" value="<?=$data['name']?>" class="form-control">
				    </div>
				    <div class="row">
			        	<div class="col-md-6 mb-3">
			        		<label><?=$lang['tai-khoan-no']?> <small class="text-danger">*</small></label>
						   	<select name="debt" class="select2 form-control" style="width:100%">
						   		<option value=""><?=$lang['tai-khoan-no']?></option>
				        		<?php foreach ($accountants as $key => $debt) { ?>
				        			<option value="<?=$debt['code']?>" <?=$data['debt']==$debt['code']?'selected':''?>><?=$debt['code']?> - <?=$debt['name']?></option>
				        		<?php } ?>
						    </select>
					    </div>
			        	<div class="col-md-6 mb-3">
			        		<label><?=$lang['tai-khoan-co']?> <small class="text-danger">*</small></label>
						   	<select name="has" class="select2 form-control" style="width:100%">
						   		<option value=""><?=$lang['tai-khoan-co']?></option>
				        		<?php foreach ($accountants as $key => $has) { ?>
				        			<option value="<?=$has['code']?>" <?=$data['has']==$has['code']?'selected':''?>><?=$has['code']?> - <?=$has['name']?></option>
				        		<?php } ?>
						    </select>
					    </div>
					</div>
				    <div class="mb-3">
		        		<label><?=$lang['ghi-chu']?></label>
		        		<textarea name="notes" class="form-control" style="height: 150px;"><?=$data['notes']?></textarea>
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
<?php } ?>
<?php if($router['1']=='type-payments-delete'){?>
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

<?php if($router['1']=='expenditure'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['thu-chi']?></h4>
			<ol class="breadcrumb">
			    <li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
			    <li class="breadcrumb-item active" aria-current="page"><?=$lang['thu-chi']?></li>
			</ol>
		</div>
	</nav>
	<?php if($jatbi->permission('expenditure.add','button')==true || $jatbi->permission('expenditure.delete','button')==true){?>
	<div class="fixed-action-btn">
	    <a class="btn btn-large btn-primary rounded-circle">
	      <i class="fas fa-bars" aria-hidden="true"></i>
	    </a>
	    <ul>
	      <?php if($jatbi->permission('expenditure.delete','button')==true){?>
	      <li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/tuitions/expenditure-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
	      <?php }?>
	      <?php if($jatbi->permission('expenditure.add','button')==true){?>
	      <li><a class="modal-url btn rounded-circle btn-info" data-url="/tuitions/expenditure-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
					    <div class="filer-item type">
					    	<label><?=$lang['loai']?></label>
					    	<select name="type" class="select2 form-control" style="width:100%">
					    		<option value=""><?=$lang['tat-ca']?></option>
					    		<?php foreach ($expenditure_type as $key => $type) { ?>
				        			<option value="<?=$type['id']?>" <?=$data['type']==$type['id']?'selected':''?>><?=$type['name']?></option>
				        		<?php } ?>
						    </select>
					    </div>
					    <div class="filer-item has">
					    	<label><?=$lang['tai-khoan-co']?></label>
					    	<select name="has" class="select2 form-control" style="width:100%">
					    		<option value=""><?=$lang['tat-ca']?></option>
					    		<?php foreach ($accountants as $key => $has) { ?>
				        			<option value="<?=$has['id']?>" <?=$data['has']==$has['id']?'selected':''?>><?=$has['code']?> - <?=$has['name']?></option>
				        		<?php } ?>
						    </select>
					    </div>
					    <div class="filer-item debt">
					    	<label><?=$lang['tai-khoan-no']?></label>
					    	<select name="debt" class="select2 form-control" style="width:100%">
					    		<option value=""><?=$lang['tat-ca']?></option>
					    		<?php foreach ($accountants as $key => $debt) { ?>
				        			<option value="<?=$debt['id']?>" <?=$data['debt']==$debt['id']?'selected':''?>><?=$debt['code']?> - <?=$debt['name']?></option>
				        		<?php } ?>
						    </select>
					    </div>
					    <?php if(count($stores)>1){?>
						<div class="filer-item stores">
					    	<label><?=$lang['cua-hang']?></label>
					    	<select name="stores" class="select2 form-select" style="width:100%">
						      <option value=""><?=$lang['tat-ca']?></option>
						      <?php foreach ($stores as $store) { ?>
						      	<option value="<?=$store['id']?>"  <?=($xss->xss($_GET['stores'])==$store['id']?'selected':'')?>><?=$store['name']?></option>
						      <?php } ?>
						    </select>
					    </div>
						<?php } ?>
					    <div class="filer-item user">
					    	<label><?=$lang['tai-khoan']?></label>
					    	<select name="user" class="select2 form-control" style="width:100%">
					    		<option value=""><?=$lang['tat-ca']?></option>
					    		<?php foreach ($accounts as $user) { ?>
							      	<option value="<?=$user['id']?>"  <?=($xss->xss($_GET['user'])==$user['id']?'selected':'')?>><?=$user['name']?></option>
							    <?php } ?>
						    </select>
					    </div>
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
		   			<table class="table table-striped table-bordered table-hover align-middle">
					  <thead>
					    <tr>			
					      	<th rowspan="2" width="1%" class="text-center align-middle">
					      	<?php if($jatbi->permission('expenditure.delete','button')==true){?>
								<div class="form-check">
								  <input class="form-check-input selectall" type="checkbox" value="" id="all">
								  <label class="form-check-label" for="all">
								  </label>
								</div>
							<?php }?>
					      	</th>					      	
					        <th colspan="3" class="align-middle text-center"><?=$lang['chung-tu']?></th>
					        <th rowspan="2" class="align-middle text-center"><?=$lang['dien-giai']?></th>
					        <th rowspan="2" class="align-middle text-center"><?=$lang['doi-tuong']?></th>
					        <th colspan="2" class="align-middle text-center"><?=$lang['tai-khoan']?></th>
					        <th colspan="3" class="align-middle text-center"><?=$lang['so-tien']?></th>
					        <?php if($jatbi->permission('expenditure.edit','button')==true){?>
					        <th rowspan="2" width="2%"></th>
					        <?php }?>
					        <?php if($jatbi->permission('expenditure.move','button')==true){?>
					        <th rowspan="2" width="2%"></th>
					        <?php }?>
					    </tr>
					    <tr>
					        <th class="align-middle text-center"><?=$lang['ngay']?></th>
					        <th class="align-middle text-center"><?=$lang['thu']?></th>
					        <th class="align-middle text-center"><?=$lang['chi']?></th>
					        <th class="align-middle text-center"><?=$lang['tai-khoan-no']?></th>
					        <th class="align-middle text-center"><?=$lang['tai-khoan-co']?></th>
					        <th class="align-middle text-center"><?=$lang['thu']?></th>
					        <th class="align-middle text-center"><?=$lang['chi']?></th>
					        <th class="align-middle text-center"><?=$lang['ton']?></th>
					    </tr>
					  	<tr>
					  		<td colspan="<?=($jatbi->permission('expenditure.edit','button')==true)?8:7?>" class="text-end fw-bold"><?=$lang['dau-ky']?></td>
					  		<td class="text-end text-success fw-bold"><?=number_format($total_first_thu+array_sum($total_page[1]))?></td>
				            <td class="text-end text-danger fw-bold"><?=number_format($total_first_chi+array_sum($total_page[2]))?></td>
				            <td class="text-end fw-bold"><?=number_format($total_first_thu+$total_first_chi+array_sum($total_page[1])+array_sum($total_page[2]))?></td>
				            <?php if($jatbi->permission('expenditure.edit','button')==true){?>
				            <td></td>
				        	<?php } ?>
				        	<?php if($jatbi->permission('expenditure.move','button')==true){?>
				            <td></td>
				        	<?php } ?>
					  	</tr>
					  </thead>
					  <tbody>
					    <?php 
					    	$total_first = $total_first_thu+$total_first_chi+array_sum($total_page[1])+array_sum($total_page[2]);
					    	foreach ($datas as $key => $data) { 
					    		if($data['type']==1){
					    			$thu = $data['price'];
					    			$chi = '';
					    			$total_thu += $thu;
					    		}
					    		if($data['type']==2){
					    			$thu = '';
					    			$chi = $data['price'];
					    			$total_chi += $chi;
					    		}
					    		$expenditure = (($expenditure==0)?$total_first:$expenditure)+$datas[$key-1]['price'];
					    ?>
							<tr>
				            
					            <td class="align-middle">
					            	<?php if($jatbi->permission('expenditure.delete','button')==true){?>
				            		<div class="form-check">
										<input class="form-check-input checker" type="checkbox" id="<?=$data['id']?>" name="BOX[<?=$data['id']?>]" value="<?=$data['id']?>">
										<label class="form-check-label" for="<?=$data['id']?>"></label>
									</div>
									 <?php }?>
					            </td>					       
					            <td>
					            	<a href="#!" class="modal-url" data-url="/accountants/expenditure-views/<?=$data['id']?>/"><?=date($setting['site_date'],strtotime($data['date']))?></a>
					            </td>
					            <td class="text-center"><?=$data['type']==1?$data['ballot']:''?></td>
					            <td class="text-center"><?=$data['type']==2?$data['ballot']:''?></td>
					            <td><?=$data['content']?></td>
					            <td>
					            	<?php if($data['orders']!=0){ $Getorders = $database->get("orders","*",["id"=>$data['orders'],"deleted"=>0]);?>
					            		<p class="mb-0"><a href="#!" class="modal-url" data-url="/invoices/orders-views/<?=$Getorders['id']?>">#<?=$ballot_code['orders']?>-<?=$Getorders['code']?><?=$Getorders['id']?></a></p>
					            	<?php } ?>
					            	<?php if($data['invoices']!=0){ $GetInvoices = $database->get("invoices","*",["id"=>$data['invoices'],"deleted"=>0]);?>
					            		<p class="mb-0"><a class="pjax-load" href="/invoices/invoices-views/<?=$GetInvoices['id']?>">#<?=$ballot_code['invoices']?>-<?=$GetInvoices['code']?><?=$GetInvoices['id']?></a></p>
					            	<?php } ?>
					            	<?php if($data['customers']!='' || $data['customers']!=0){$GetCustomers = $database->get("customers","*",["id"=>$data['customers'],"deleted"=>0]);?>
					            		<p class="mb-0"><?=$GetCustomers['name']?></p>
					            	<?php } ?>
					            	<?php if($data['personnels']!='' || $data['personnels']!=0){$GetPersonnel = $database->get("personnels","*",["id"=>$data['personnels'],"deleted"=>0]);?>
					            		<p class="mb-0"><?=$GetPersonnel['name']?></p>
					            	<?php } ?>
					            	<?php if($data['purchase']!=0){ $Getpurchase = $database->get("purchase","*",["id"=>$data['purchase'],"deleted"=>0]);?>
					            		<p class="mb-0"><a href="#!" class="modal-url" data-url="/purchases/purchase-views/<?=$Getpurchase['id']?>">#<?=$ballot_code['purchase']?>-<?=$Getpurchase['code']?></a></p>

					            	<?php } ?>
					            	<?php if($data['vendor']!='' || $data['vendor']!=0){ $Getvendor = $database->get("vendors","*",["id"=>$data['vendor'],"deleted"=>0]);?>
					            		<p class="mb-0"><?=$Getvendor['name']?></p>
					            	<?php } ?>					          
					            </td>
					            <td class="text-center fw-bold"><?=$database->get("accountants_code","code",["code"=>$data['debt']])?></td>
					            <td class="text-center fw-bold"><?=$database->get("accountants_code","code",["code"=>$data['has']])?></td>
					            <td class="text-end text-success fw-bold"><?=number_format($thu)?></td>
					            <td class="text-end text-danger fw-bold"><?=number_format($chi)?></td>
					            <td class="text-end fw-bold"><?=number_format($expenditure+$thu+$chi)?></td>
					            <?php if($jatbi->permission('expenditure.edit','button')==true){?>
				            	<td>
				            		<a class="btn btn-sm btn-light modal-url" data-url="/tuitions/expenditure-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
				            	</td>				            	
					            <?php }?>	
					            			            				   
				    	<?php } ?>
					  </tbody>
					  <tfoot>
					  	<tr>
					  		<td colspan="<?=($jatbi->permission('expenditure.edit','button')==true)?8:7?>" class="text-end fw-bold"><?=$lang['tong-cong']?></td>
					  		<td class="text-end text-success fw-bold"><?=number_format($total_thu)?></td>
				            <td class="text-end text-danger fw-bold"><?=number_format($total_chi)?></td>
				            <td class="text-end fw-bold"><?=number_format($total_first+$total_thu+$total_chi)?></td>
				            <?php if($jatbi->permission('expenditure.edit','button')==true){?>
				            <td></td>
				        	<?php } ?>
				        	
					  	</tr>
					  	<tr class="bg-success bg-opacity-25">
					  		<td colspan="<?=($jatbi->permission('expenditure.edit','button')==true)?8:7?>" class="text-end fw-bold"><?=$lang['cuoi-ky']?></td>
					  		<td class="text-end text-success fw-bold"><?=number_format($total_last_thu)?></td>
				            <td class="text-end text-danger fw-bold"><?=number_format($total_last_chi)?></td>
				            <td class="text-end fw-bold"><?=number_format($total_last_thu+$total_last_chi)?></td>
				            <?php if($jatbi->permission('expenditure.edit','button')==true){?>
				            <td></td>
				        	<?php } ?>
				        	
					  	</tr>
					  </tfoot>
					</table>
				</div>
				<nav class="d-flex justify-content-between align-items-center paginations" aria-label="Page navigation">
				    <?=$page?>
				</nav>
			</div>
		</div>
	</div>
<?php } ?>
<?php if($router['1']=='expenditure-add' || $router['1']=='expenditure-edit'){?>
	<div class="modal fade modal-load" tabindex="-1">
	  <div class="modal-dialog modal-lg">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title"><?=$router['1']=='expenditure-add'?$lang['them']:$lang['sua']?> <?=$lang['thu-chi']?></h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
	      <div class="modal-body">
	      	<div class="row">
		        <div class="col-sm-6">
		        	<div class="mb-3">
		        		<label><?=$lang['loai']?> <small class="text-danger">*</small></label>
					   	<select name="type" class="select2 form-control expenditure-type" style="width:100%">
					   		<option value=""><?=$lang['loai']?></option>
			        		<option value="1" <?=$data['type']==1?"selected":''?>><?=$lang['thu']?></option>
						    <option value="2" <?=$data['type']==2?"selected":''?>><?=$lang['chi']?></option>
					    </select>
				    </div>
		        	<div class="mb-3">
		        		<label><?=$lang['ngay']?> <small class="text-danger">*</small></label>
					    <input placeholder="<?=$lang['ngay']?>" type="date" name="date" value="<?=$data['date']==''?date("Y-m-d"):$data['date']?>" class="form-control">
				    </div>
				    <div class="row">
			        	<div class="col-md-6 mb-3">
			        		<label><?=$lang['tai-khoan-no']?> <small class="text-danger">*</small></label>
						   	<select name="debt" class="select2 form-control" style="width:100%">
						   		<option value=""><?=$lang['tai-khoan-no']?></option>
				        		<?php foreach ($accountants as $key => $debt) { ?>
				        			<option value="<?=$debt['code']?>" <?=$data['debt']==$debt['code']?'selected':''?>><?=$debt['code']?> - <?=$debt['name']?></option>
				        		<?php } ?>
						    </select>
					    </div>
			        	<div class="col-md-6 mb-3">
			        		<label><?=$lang['tai-khoan-co']?> <small class="text-danger">*</small></label>
						   	<select name="has" class="select2 form-control" style="width:100%">
						   		<option value=""><?=$lang['tai-khoan-co']?></option>
				        		<?php foreach ($accountants as $key => $has) { ?>
				        			<option value="<?=$has['code']?>" <?=$data['has']==$has['code']?'selected':''?>><?=$has['code']?> - <?=$has['name']?></option>
				        		<?php } ?>
						    </select>
					    </div>
					</div>
		        	<div class="mb-3">
		        		<label><?=$lang['so-tien']?> <small class="text-danger">*</small></label>
					    <input placeholder="<?=$lang['so-tien']?>" type="text" name="price" value="<?=$data['price']?>" class="form-control number">
				    </div>
		        	<div class="mb-3">
		        		<label><?=$lang['so-phieu']?></label>
					    <input placeholder="<?=$lang['so-phieu']?>" type="text" name="ballot" value="<?=$data['ballot']?>" class="form-control">
				    </div>
				    <div class="mb-3">
		        		<label><?=$lang['dien-giai']?> <small class="text-danger">*</small></label>
		        		<textarea name="content" class="form-control" style="height: 308px;"><?=$data['content']?></textarea>
				    </div>
		        </div>
		        <div class="col-sm-6">
				    <div class="card mb-3">
				    	<div class="card-header"><?=$lang['doi-tuong']?></div>
				    	<div class="card-body">				    						    		
				    		<div class="thu mb-3" style="<?=$data['type']==1 || $data['type']==''?'display: block':'display: none'?>">
				        		<label><?=$lang['hoa-don-thu-hoc-phi']?></label>
							   	<select name="purchase" class="select2 form-control" style="width:100%">
							   		<option value=""><?=$lang['hoa-don']?></option>
					        		<?php foreach ($tuition as $key => $invoice) { ?>
					        			<option value="<?=$invoice['id']?>" <?=$data['purchase']==$invoice['id']?'selected':''?>>#<?=$invoice['id_tuition']?> - <?=$invoice['note']?></option>
					        		<?php } ?>
							    </select>
						    </div>
				    		<div class="chi mb-3" style="<?=$data['type']==2 || $data['type']==''?'display: block':'display: none'?>">
				        		<label><?=$lang['hoa-don-mua-hang']?></label>
							   	<select name="purchase" class="select2 form-control" style="width:100%">
							   		<option value=""><?=$lang['hoa-don-mua-hang']?></option>
							   		<?php foreach ($purchase as $key => $invoice) { ?>
					        			<option value="<?=$invoice['id']?>" <?=$data['purchase']==$invoice['id']?'selected':''?>>#<?=$invoice['code']?> -  <?=$invoice['content']?></option>
					        		<?php } ?>
							    </select>
						    </div>
				    	</div>
				    </div>
				    <div class="mb-3">
		        		<label><?=$lang['ghi-chu']?></label>
		        		<textarea name="notes" class="form-control" style="height: 150px;"><?=$data['notes']?></textarea>
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
		$(".expenditure-type").on("change",function() {
			if($(this).val()==1){
				$(".thu").show();
				$(".chi").hide();
			}
			if($(this).val()==2){
				$(".thu").hide();
				$(".chi").show();
			}
		})
	</script>
<?php } ?>
<?php if($router['1']=='expenditure-delete'){?>
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