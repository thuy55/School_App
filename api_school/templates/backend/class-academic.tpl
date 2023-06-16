<?php if($router['1']=='class_diagram'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['so-do-lop']?></h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
				<li class="breadcrumb-item active" aria-current="page">Lớp & Học vụ</li>
			</ol>
		</div>
	</nav>
	<?php if($jatbi->permission('class_diagram.add','button')==true || $jatbi->permission('class_diagram.delete','button')==true){?>
		<div class="fixed-action-btn">
			<a class="btn btn-large btn-primary rounded-circle">
				<i class="fas fa-bars" aria-hidden="true"></i>
			</a>
			<ul>
				<?php if($jatbi->permission('class_diagram.delete','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/class-academic/class_diagram-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
				<?php }?>
				<?php if($jatbi->permission('class_diagram.add','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-info" data-url="/class-academic/class_diagram-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
								<label><?=$lang['khoa-hoc']?></label>
								<select name="course" class="select2 form-select" style="width:100%">
									<option value=""><?=$lang['tat-ca']?></option>
									<?php foreach ($course as $permission) { ?>
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
								<?php if($jatbi->permission('class_diagram.delete','button')==true){?>
									<th width="1%" class="text-center">
										<div class="form-check">
											<input class="form-check-input selectall" type="checkbox" value="" id="all">
											<label class="form-check-label" for="all">
											</label>
										</div>
									</th>
								<?php }?>
								<th width="50"></th>
								<th><?=$lang['ten-lop']?></th>
								<th><?=$lang['giao-vien-chu-nhiem']?></th>
								<th><?=$lang['si-so']?></th>
								<th><?=$lang['khoi-lop']?></th>		
								<th><?=$lang['khoa-hoc']?></th>	
								<th><?=$lang['phong-hoc']?></th>		        			        					      
								<th><?=$lang['trang-thai']?></th>
								<?php if($jatbi->permission('class_diagram.edit','button')==true){?>
									<th width="2%"></th>
								<?php }?>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($datas as $data) { ?>
								<tr>
									<?php if($jatbi->permission('class_diagram.delete','button')==true){?>
										<td class="align-middle">
											<div class="form-check">
												<input class="form-check-input checker" type="checkbox" id="<?=$data['id']?>" name="BOX[<?=$data['id']?>]" value="<?=$data['id']?>">
												<label class="form-check-label" for="<?=$data['id']?>"></label>
											</div>
										</td>
									<?php }?>
									<td></td>
									<td><?=$database->get('class','name',['id'=>$data['class']])?></td>
									<td><?=$database->get('teacher','firstname',['id'=>$data['homeroom_teacher']])?> <?=$database->get('teacher','lastname',['id'=>$data['homeroom_teacher']])?></td>
									<?php $count = $database->count("arrange_class",[
										'AND' => [
											"class_diagram"	=> $data['id'],
											"status"		=>"A",
											"deleted"       => 0,
										]]
									);?>
									<td><?=$count?></td>
									<td><?=$database->get('grade','name',['id'=>$data['grade']])?></td>
									<td><?=$database->get('course','name',['id'=>$data['course']])?></td>
									<td><?=$database->get('classroom','name',['id'=>$data['classroom']])?></td>
									<td>	
										<div class="form-check form-switch">
											<input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/class-academic/class_diagram-status/<?=$data['id']?>/">
											<label class="form-check-label" for="status"></label>
										</div>
									</td>
									<?php if($jatbi->permission('class_diagram_student','button')==true){?>
										<td>
											<a class="btn btn-sm btn-light pjax-load" href="/class-academic/class_diagram_student/<?=$data['id']?>/"><i class="fas fa-eye" aria-hidden="true"></i></a>
										</td>
									<?php }?>
									<?php if($jatbi->permission('class_diagram.edit','button')==true){?>
										<td>
											<a class="btn btn-sm btn-light modal-url" data-url="/class-academic/class_diagram-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
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
<?php if($router['1']=='class_diagram-add' || $router['1']=='class_diagram-edit'){?>
	<div class="modal fade modal-load" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><?=$router['1']=='class_diagram-add'?$lang['them']:$lang['sua']?> <?=$lang['so-do-lop']?></h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
					<div class="modal-body">
						<div class="row">
							<div class="col-sm-6">
								<div class="mb-3">
									<label><?=$lang['khoa-hoc']?><small class="text-danger">*</small></label>
									<select name="course" class="select2 form-control" style="width:100%">
										<option value="" disabled selected><?=$lang['khoa-hoc']?></option>
										<?php foreach ($course as $course ) { ?>
											<option value="<?=$course['id']?>"  <?=($data['course']==$course['id']?'selected':'')?>><?=$course['name']?></option>
										<?php } ?>
									</select>
								</div>
								<div class="mb-3">
									<label><?=$lang['khoi-lop']?><small class="text-danger">*</small></label>
									<select name="grade" class="select2 form-control" style="width:100%">
										<option value="" disabled selected><?=$lang['khoi-lop']?></option>
										<?php foreach ($grade as $grade ) { ?>
											<option value="<?=$grade['id']?>"  <?=($data['grade']==$grade['id']?'selected':'')?>><?=$grade['name']?></option>
										<?php } ?>
									</select>
								</div>
								<div class="mb-3">
									<label><?=$lang['ten-lop']?><small class="text-danger">*</small></label>
									<select name="class" class="select2 form-control" style="width:100%">
										<option value="" disabled selected><?=$lang['ten-lop']?></option>
										<?php foreach ($class as $class ) { ?>
											<option value="<?=$class['id']?>"  <?=($data['class']==$class['id']?'selected':'')?>><?=$class['name']?></option>
										<?php } ?>
									</select>
								</div>

							</div> 		    
							<div class="col-sm-6">		
								<div class="mb-3">
									<label><?=$lang['giao-vien-chu-nhiem']?><small class="text-danger">*</small></label>
									<select name="homeroom_teacher" class="select2 form-control" style="width:100%">
										<option value="" disabled selected><?=$lang['giao-vien-chu-nhiem']?></option>
										<?php foreach ($school_teacher as $school_teacher ) { 
											$teacher = $database->get("teacher", "*",["id"=>$school_teacher['teacher'],"deleted"=> 0,"status"=>'A']);?>
											<option value="<?=$teacher['id']?>"  <?=($data['homeroom_teacher']==$teacher['id']?'selected':'')?>><?=$teacher['firstname']?> <?=$teacher['lastname']?></option>
										<?php } ?>
									</select>
								</div>		
								<div class="mb-3">
									<label><?=$lang['phong-hoc']?><small class="text-danger">*</small></label>
									<select name="classroom" class="select2 form-control" style="width:100%">
										<option value="" disabled selected><?=$lang['phong-hoc']?></option>
										<?php foreach ($classroom as $classroom ) { ?>
											<option value="<?=$classroom['id']?>"  <?=($data['classroom']==$classroom['id']?'selected':'')?>><?=$classroom['name']?></option>
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
<?php if($router['1']=='class_diagram-delete'){?>
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
<?php if($router['1']=='class_diagram_student'){?>
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
			<div><h4><?=$lang['danh-sach-hoc-sinh']?> <?=$lang['lop']?> <?=$database->get('class','name',["id"=>$database->get('class_diagram','class',['id'=>$router['2']])])?></h4>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
					<li class="breadcrumb-item active" aria-current="page"><?=$lang['lop-hoc-vu']?></li>
				</ol></div>	
			</div>
		</nav>
		<div class="card card-custom">
			<div class="card-body">
				<div class="row">
					<div class="col-lg-2">
						<a href="/tuitions/content_tuition/<?=$router['2']?>/" class="btn btn-light w-100 pjax-load"><?=$lang['thong-tin-hoc-phi']?></a>
					</div>
					<div class="col-lg-2">
						<a href="/class-academic/first_book/<?=$router['2']?>/" class="btn btn-light w-100 pjax-load"><?=$lang['so-dau-bai']?></a>
					</div>
					<div class="col-lg-2">
						<a href="/class-academic/schedule_view/<?=$router['2']?>/" class="btn btn-light w-100 pjax-load"><?=$lang['thoi-khoa-bieu']?></a>
					</div>
					<div class="col-lg-2">
						<a href="/profiles/timekeeping/<?=$router['2']?>/" class="btn btn-light w-100 pjax-load"><?=$lang['diem-danh']?></a>
					</div>
					<div class="col-lg-2">
						<a  data-url="/class-academic/up_class_list-add/<?=$router['2']?>/" class="btn btn-light w-100 modal-url"><?=$lang['len-lop']?></a>
					</div>
				</div>
				<form method="GET" class="pjax-content mb-4 search-form">
					<div class="form-group col-4">

						<!-- <input placeholder="<?=$lang['tim-kiem']?>" type="text" name="name" value="<?=$xss->xss($_GET['name'])?>" class="form-control"> -->
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
								<div class="filer-item permission">
									<label><?=$lang['lop-hoc']?></label>
									<select name="class" class="select2 form-select" style="width:100%">
										<option value=""><?=$lang['tat-ca']?></option>
										<?php foreach ($class as $clas) { ?>
											<option value="<?=$clas['id']?>"  <?=($xss->xss($_GET['clas'])==$clas['id']?'selected':'')?>><?=$clas['name']?></option>
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
									<th>STT</th>
									<th><?=$lang['ma-hoc-sinh']?></th>
									<th><?=$lang['ho-ten']?></th>

									<th><?=$lang['gioi-tinh']?></th>				        
									<th><?=$lang['ngay-sinh']?></th>
									<th><?=$lang['ngay-nhap-hoc']?></th>
									<th><?=$lang['phu-huynh']?></th>



									<?php if($jatbi->permission('students.edit','button')==true){?>
										<th width="2%"></th>
									<?php }?>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($datas as $data) { $t+=1;?>

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
										<td><?=$t?></td>
										<td><?=$database->get('students','id_student',['id'=>$data['students']])?></td>
										<td><?=$database->get('students','firstname',['id'=>$data['students']])?> <?=$database->get('students','lastname',['id'=>$data['students']])?></td>
										<td><?=$database->get('students','gender',['id'=>$data['students']])?></td>
										<td><?=date("d/m/Y", strtotime($database->get('students','birthday',['id'=>$data['students']])))?></td>
										<td><?=date("d/m/Y", strtotime($database->get('students','year_of_admission',['id'=>$data['students']])))?></td>
										<td><?=$database->get('parent','name',["id"=>$database->get('students','parent',['id'=>$data['students']])])?></td>


										<td class="dropdown">
											<button class="btn btn-sm btn-light dropdown-toggle" data-bs-boundary="window" type="button" id="menu-<?=$data['id']?>"  data-bs-toggle="dropdown" aria-expanded="false">
												<i class="fas fa-cog"></i>
											</button>
											<ul class="dropdown-menu " aria-labelledby="menu-<?=$data['id']?>">
												<li><a class="dropdown-item pjax-load" href="/class-academic/profiles/<?=$data['id']?>/">Xem</a></li>
												<li><a class="dropdown-item modal-url" data-url="/class-academic/change_class-edit/<?=$data['id']?>/"><?=$lang['chuyen-lop']?></a></li>
												<li><a class="dropdown-item modal-url" data-url="/class-academic/up_class-add/<?=$data['id']?>/"><?=$lang['len-lop']?></i></a></li>		
												<li><a class="dropdown-item modal-url" data-url="/class-academic/up_class-add/<?=$data['id']?>/">Ở lại lớp</i></a></li>		
												<li><a class="dropdown-item pjax-load" href="/tuitions/tuition_debt_detail/<?=$data['id']?>/"><?=$lang['cong-no']?></a></li>
												<li><a class="dropdown-item pjax-load" href="/class-academic/contact_book/<?=$data['id']?>/"><?=$lang['so-lien-lac']?></a></li>

											</ul>
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
<?php if($router['1']=='grade'){?>
		<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
			<div class="">
				<h4><?=$lang['danh-sach-khoi-lop']?></h4>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
					<li class="breadcrumb-item active" aria-current="page">Lớp & Học vụ</li>
				</ol>
			</div>
		</nav>
		<?php if($jatbi->permission('grade.add','button')==true || $jatbi->permission('grade.delete','button')==true){?>
			<div class="fixed-action-btn">
				<a class="btn btn-large btn-primary rounded-circle">
					<i class="fas fa-bars" aria-hidden="true"></i>
				</a>
				<ul>
					<?php if($jatbi->permission('grade.delete','button')==true){?>
						<li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/class-academic/grade-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
					<?php }?>
					<?php if($jatbi->permission('grade.add','button')==true){?>
						<li><a class="modal-url btn rounded-circle btn-info" data-url="/class-academic/grade-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
									<?php if($jatbi->permission('grade.delete','button')==true){?>
										<th width="1%" class="text-center">
											<div class="form-check">
												<input class="form-check-input selectall" type="checkbox" value="" id="all">
												<label class="form-check-label" for="all">
												</label>
											</div>
										</th>
									<?php }?>
									<th width="50"></th>
									<th>Khối lớp</th>					        			        					      
									<th><?=$lang['trang-thai']?></th>
									<?php if($jatbi->permission('grade.edit','button')==true){?>
										<th width="2%"></th>
									<?php }?>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($datas as $data) { ?>
									<tr>
										<?php if($jatbi->permission('grade.delete','button')==true){?>
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
												<input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/class-academic/grade-status/<?=$data['id']?>/">
												<label class="form-check-label" for="status"></label>
											</div>
										</td>
										<?php if($jatbi->permission('grade.edit','button')==true){?>
											<td>
												<a class="btn btn-sm btn-light modal-url" data-url="/class-academic/grade-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
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
<?php if($router['1']=='grade-add' || $router['1']=='grade-edit'){?>
		<div class="modal fade modal-load" tabindex="-1">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title"><?=$router['1']=='grade-add'?$lang['them']:$lang['sua']?> Khối lớp</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
						<div class="modal-body">
							<div class="row">
								<div class="col-sm-6">
									<div class="mb-3">
										<label>Tên khối lớp<small class="text-danger">*</small></label>
										<input placeholder="Tên khối lớp" type="text" name="name" value="<?=$data['name']?>" class="form-control">
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
<?php if($router['1']=='grade-delete'){?>
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
<?php if($router['1']=='classroom_type'){?>
		<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
			<div class="">
				<h4>Danh sách Loại phòng học</h4>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
					<li class="breadcrumb-item active" aria-current="page">Lớp & Học vụ</li>
				</ol>
			</div>
		</nav>
		<?php if($jatbi->permission('classroom_type.add','button')==true || $jatbi->permission('classroom_type.delete','button')==true){?>
			<div class="fixed-action-btn">
				<a class="btn btn-large btn-primary rounded-circle">
					<i class="fas fa-bars" aria-hidden="true"></i>
				</a>
				<ul>
					<?php if($jatbi->permission('classroom_type.delete','button')==true){?>
						<li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/class-academic/classroom_type-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
					<?php }?>
					<?php if($jatbi->permission('classroom_type.add','button')==true){?>
						<li><a class="modal-url btn rounded-circle btn-info" data-url="/class-academic/classroom_type-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
									<?php if($jatbi->permission('classroom_type.delete','button')==true){?>
										<th width="1%" class="text-center">
											<div class="form-check">
												<input class="form-check-input selectall" type="checkbox" value="" id="all">
												<label class="form-check-label" for="all">
												</label>
											</div>
										</th>
									<?php }?>
									<th width="50"></th>
									<th>Tên loại phòng học</th>					        			        					      
									<th><?=$lang['trang-thai']?></th>
									<?php if($jatbi->permission('classroom_type.edit','button')==true){?>
										<th width="2%"></th>
									<?php }?>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($datas as $data) { ?>
									<tr>
										<?php if($jatbi->permission('classroom_type.delete','button')==true){?>
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



										<td>	
											<div class="form-check form-switch">
												<input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/class-academic/classroom_type-status/<?=$data['id']?>/">
												<label class="form-check-label" for="status"></label>
											</div>
										</td>
										<?php if($jatbi->permission('classroom_type.edit','button')==true){?>
											<td>
												<a class="btn btn-sm btn-light modal-url" data-url="/class-academic/classroom_type-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
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
<?php if($router['1']=='classroom_type-add' || $router['1']=='classroom_type-edit'){?>
		<div class="modal fade modal-load" tabindex="-1">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title"><?=$router['1']=='classroom_type-add'?$lang['them']:$lang['sua']?> Loại phòng học</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
						<div class="modal-body">
							<div class="row">
								<div class="col-sm-6">
									<div class="mb-3">
										<label>Tên loại phòng học<small class="text-danger">*</small></label>
										<input placeholder="Tên loại phòng học" type="text" name="name" value="<?=$data['name']?>" class="form-control">
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
<?php if($router['1']=='classroom_type-delete'){?>
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
<?php if($router['1']=='classroom'){?>
		<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
			<div class="">
				<h4>Danh sách Phòng học</h4>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
					<li class="breadcrumb-item active" aria-current="page">Lớp & Học vụ</li>
				</ol>
			</div>
		</nav>
		<?php if($jatbi->permission('classroom.add','button')==true || $jatbi->permission('classroom.delete','button')==true){?>
			<div class="fixed-action-btn">
				<a class="btn btn-large btn-primary rounded-circle">
					<i class="fas fa-bars" aria-hidden="true"></i>
				</a>
				<ul>
					<?php if($jatbi->permission('classroom.delete','button')==true){?>
						<li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/class-academic/classroom-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
					<?php }?>
					<?php if($jatbi->permission('classroom.add','button')==true){?>
						<li><a class="modal-url btn rounded-circle btn-info" data-url="/class-academic/classroom-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
									<?php if($jatbi->permission('classroom.delete','button')==true){?>
										<th width="1%" class="text-center">
											<div class="form-check">
												<input class="form-check-input selectall" type="checkbox" value="" id="all">
												<label class="form-check-label" for="all">
												</label>
											</div>
										</th>
									<?php }?>
									<th width="50"></th>
									<th>Tên Phòng học</th>
									<th>Loại phòng học</th>
									<th>Khu vực</th>				        			        					      
									<th><?=$lang['trang-thai']?></th>
									<?php if($jatbi->permission('classroom.edit','button')==true){?>
										<th width="2%"></th>
									<?php }?>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($datas as $data) { ?>
									<tr>
										<?php if($jatbi->permission('classroom.delete','button')==true){?>
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
										<td><?=$database->get("typeroom", "name",["id"=>$data['typeroom']])?></td>
										<td><?=$database->get("areas", "name",["id"=>$data['areas']])?></td>


										<td>	
											<div class="form-check form-switch">
												<input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/class-academic/classroom-status/<?=$data['id']?>/">
												<label class="form-check-label" for="status"></label>
											</div>
										</td>
										<?php if($jatbi->permission('classroom.edit','button')==true){?>
											<td>
												<a class="btn btn-sm btn-light modal-url" data-url="/class-academic/classroom-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
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
<?php if($router['1']=='classroom-add' || $router['1']=='classroom-edit'){?>
		<div class="modal fade modal-load" tabindex="-1">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title"><?=$router['1']=='classroom-add'?$lang['them']:$lang['sua']?> Phòng học</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
						<div class="modal-body">
							<div class="row">
								<div class="col-sm-6">
									<div class="mb-3">
										<label>Tên phòng học<small class="text-danger">*</small></label>
										<input placeholder="Tên phòng học" type="text" name="name" value="<?=$data['name']?>" class="form-control">
									</div>
									<div class="mb-3">
										<label>Loại phòng học<small class="text-danger">*</small></label>
										<select name="typeroom" class="select2 form-control" style="width:100%">
											<option value="" disabled selected>Loại phòng học</option>
											<?php foreach ($typeroom as $typeroom ) { ?>
												<option value="<?=$typeroom['id']?>"  <?=($data['typeroom']==$typeroom['id']?'selected':'')?>><?=$typeroom['name']?></option>
											<?php } ?>
										</select>
									</div>
								</div> 		    
								<div class="col-sm-6">	
									<div class="mb-3">
										<label>Khu vực<small class="text-danger">*</small></label>
										<select name="areas" class="select2 form-control" style="width:100%">
											<option value="" disabled selected>Khu vực</option>
											<?php foreach ($areas as $areas ) { ?>
												<option value="<?=$areas ['id']?>"  <?=($data['areas']==$areas['id']?'selected':'')?>><?=$areas['name']?></option>
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
<?php if($router['1']=='classroom-delete'){?>
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
	<?php if($router['1']=='class'){?>
		<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
			<div class="">
				<h4>Danh sách Lớp học</h4>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
					<li class="breadcrumb-item active" aria-current="page">Lớp & Học vụ</li>
				</ol>
			</div>
		</nav>
		<?php if($jatbi->permission('class.add','button')==true || $jatbi->permission('class.delete','button')==true){?>
			<div class="fixed-action-btn">
				<a class="btn btn-large btn-primary rounded-circle">
					<i class="fas fa-bars" aria-hidden="true"></i>
				</a>
				<ul>
					<?php if($jatbi->permission('class.delete','button')==true){?>
						<li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/class-academic/class-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
					<?php }?>
					<?php if($jatbi->permission('class.add','button')==true){?>
						<li><a class="modal-url btn rounded-circle btn-info" data-url="/class-academic/class-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
									<?php if($jatbi->permission('class.delete','button')==true){?>
										<th width="1%" class="text-center">
											<div class="form-check">
												<input class="form-check-input selectall" type="checkbox" value="" id="all">
												<label class="form-check-label" for="all">
												</label>
											</div>
										</th>
									<?php }?>
									<th width="50"></th>
									<th>Tên Lớp</th>   

									<th><?=$lang['trang-thai']?></th>
									<?php if($jatbi->permission('class.edit','button')==true){?>
										<th width="2%"></th>
									<?php }?>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($datas as $data) { ?>
									<tr>
										<?php if($jatbi->permission('class.delete','button')==true){?>
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

										<td>	
											<div class="form-check form-switch">
												<input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/class-academic/class-status/<?=$data['id']?>/">
												<label class="form-check-label" for="status"></label>
											</div>
										</td>
										<?php if($jatbi->permission('class.edit','button')==true){?>
											<td>
												<a class="btn btn-sm btn-light modal-url" data-url="/class-academic/class-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
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
<?php if($router['1']=='class-add' || $router['1']=='class-edit'){?>
		<div class="modal fade modal-load" tabindex="-1">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title"><?=$router['1']=='class-add'?$lang['them']:$lang['sua']?> Lớp học</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
						<div class="modal-body">
							<div class="row">
								<div class="col-sm-6">
									<div class="mb-3">
										<label>Tên lớp học<small class="text-danger">*</small></label>
										<input placeholder="Tên lớp học" type="text" name="name" value="<?=$data['name']?>" class="form-control">
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
<?php if($router['1']=='class-delete'){?>
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
	<?php if($router['1']=='course'){?>
		<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
			<div class="">
				<h4>Danh sách khóa học</h4>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
					<li class="breadcrumb-item active" aria-current="page">Lớp & Học vụ</li>
				</ol>
			</div>
		</nav>
		<?php if($jatbi->permission('course.add','button')==true || $jatbi->permission('course.delete','button')==true){?>
			<div class="fixed-action-btn">
				<a class="btn btn-large btn-primary rounded-circle">
					<i class="fas fa-bars" aria-hidden="true"></i>
				</a>
				<ul>
					<?php if($jatbi->permission('course.delete','button')==true){?>
						<li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/class-academic/course-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
					<?php }?>
					<?php if($jatbi->permission('course.add','button')==true){?>
						<li><a class="modal-url btn rounded-circle btn-info" data-url="/class-academic/course-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
									<?php if($jatbi->permission('course.delete','button')==true){?>
										<th width="1%" class="text-center">
											<div class="form-check">
												<input class="form-check-input selectall" type="checkbox" value="" id="all">
												<label class="form-check-label" for="all">
												</label>
											</div>
										</th>
									<?php }?>
									<th width="50"></th>
									<th><?=$lang['ten-khoa-hoc']?></th>
									<th><?=$lang['ngay-khai-giang']?></th>
									<th><?=$lang['ngay-be-giang']?></th>					        			        					      
									<th><?=$lang['trang-thai']?></th>
									<?php if($jatbi->permission('course.edit','button')==true){?>
										<th width="2%"></th>
									<?php }?>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($datas as $data) { ?>
									<tr>
										<?php if($jatbi->permission('course.delete','button')==true){?>
											<td class="align-middle">
												<div class="form-check">
													<input class="form-check-input checker" type="checkbox" id="<?=$data['id']?>" name="BOX[<?=$data['id']?>]" value="<?=$data['id']?>">
													<label class="form-check-label" for="<?=$data['id']?>"></label>
												</div>
											</td>
										<?php }?>
										<td></td>


										<td><?=$data['name']?></td>
										<td><?=date("d/m/Y", strtotime($data['startdate']))?></td>
										<td><?=date("d/m/Y", strtotime($data['enddate']))?></td>



										<td>	
											<div class="form-check form-switch">
												<input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/class-academic/course-status/<?=$data['id']?>/">
												<label class="form-check-label" for="status"></label>
											</div>
										</td>
										<?php if($jatbi->permission('course.edit','button')==true){?>
											<td>
												<a class="btn btn-sm btn-light modal-url" data-url="/class-academic/course-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
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
<?php if($router['1']=='course-delete'){?>
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
<?php if($router['1']=='course-add' || $router['1']=='course-edit'){?>
		<div class="modal fade modal-load" tabindex="-1">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title"><?=$router['1']=='course-add'?$lang['them']:$lang['sua']?> Khóa học</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
						<div class="modal-body">
							<div class="row">
								<div class="col-sm-6">
									<div class="mb-3">
										<label><?=$lang['ten-khoa-hoc']?><small class="text-danger">*</small></label>
										<input placeholder="<?=$lang['ten-khoa-hoc']?>" type="text" name="name" value="<?=$data['name']?>" class="form-control">
									</div>
									<div class="mb-3">
										<label><?=$lang['ngay-khai-giang']?><small class="text-danger">*</small></label>
										<input placeholder="<?=$lang['ngay-khai-giang']?>" type="date" name="startdate" value="<?=$data['startdate']?>" class="form-control">
									</div>

								</div> 		    
								<div class="col-sm-6">	
									<div class="mb-3">
										<label><?=$lang['ngay-be-giang']?><small class="text-danger">*</small></label>
										<input placeholder="<?=$lang['ngay-be-giang']?>" type="date" name="enddate" value="<?=$data['enddate']?>" class="form-control">
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
<?php if($router['1']=='location'){?>
		<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
			<div class="">
				<h4>Danh sách lớp học</h4>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
					<li class="breadcrumb-item active" aria-current="page">Lớp & Học vụ</li>
				</ol>
			</div>
		</nav>
		<?php if($jatbi->permission('location.add','button')==true || $jatbi->permission('location.delete','button')==true){?>
			<div class="fixed-action-btn">
				<a class="btn btn-large btn-primary rounded-circle">
					<i class="fas fa-bars" aria-hidden="true"></i>
				</a>
				<ul>
					<?php if($jatbi->permission('location.delete','button')==true){?>
						<li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/class-academic/location-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
					<?php }?>
					<?php if($jatbi->permission('location.add','button')==true){?>
						<li><a class="modal-url btn rounded-circle btn-info" data-url="/class-academic/location-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
									<?php if($jatbi->permission('location.delete','button')==true){?>
										<th width="1%" class="text-center">
											<div class="form-check">
												<input class="form-check-input selectall" type="checkbox" value="" id="all">
												<label class="form-check-label" for="all">
												</label>
											</div>
										</th>
									<?php }?>
									<th width="50"></th>
									<th>Tên khu vực</th>					        			        					      
									<th><?=$lang['trang-thai']?></th>
									<?php if($jatbi->permission('location.edit','button')==true){?>
										<th width="2%"></th>
									<?php }?>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($datas as $data) { ?>
									<tr>
										<?php if($jatbi->permission('location.delete','button')==true){?>
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
												<input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/class-academic/location-status/<?=$data['id']?>/">
												<label class="form-check-label" for="status"></label>
											</div>
										</td>
										<?php if($jatbi->permission('location.edit','button')==true){?>
											<td>
												<a class="btn btn-sm btn-light modal-url" data-url="/class-academic/location-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
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
<?php if($router['1']=='location-add' || $router['1']=='location-edit'){?>
		<div class="modal fade modal-load" tabindex="-1">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title"><?=$router['1']=='location-add'?$lang['them']:$lang['sua']?> Khu vực</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
						<div class="modal-body">
							<div class="row">
								<div class="col-sm-6">
									<div class="mb-3">
										<label>Tên khu vực<small class="text-danger">*</small></label>
										<input placeholder="Tên khu vực" type="text" name="name" value="<?=$data['name']?>" class="form-control">
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
<?php if($router['1']=='location-delete'){?>
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
<?php if($router['1']=='subject'){?>
		<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
			<div class="">
				<h4>Danh sách môn học</h4>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
					<li class="breadcrumb-item active" aria-current="page">Lớp & Học vụ</li>
				</ol>
			</div>
		</nav>
		<?php if($jatbi->permission('subject.add','button')==true || $jatbi->permission('subject.delete','button')==true){?>
			<div class="fixed-action-btn">
				<a class="btn btn-large btn-primary rounded-circle">
					<i class="fas fa-bars" aria-hidden="true"></i>
				</a>
				<ul>
					<?php if($jatbi->permission('subject.delete','button')==true){?>
						<li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/class-academic/subject-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
					<?php }?>
					<?php if($jatbi->permission('subject.add','button')==true){?>
						<li><a class="modal-url btn rounded-circle btn-info" data-url="/class-academic/subject-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
									<?php if($jatbi->permission('subject.delete','button')==true){?>
										<th width="1%" class="text-center">
											<div class="form-check">
												<input class="form-check-input selectall" type="checkbox" value="" id="all">
												<label class="form-check-label" for="all">
												</label>
											</div>
										</th>
									<?php }?>
									<th width="50"></th>
									<th>Tên môn học</th>					        			        					      
									<th><?=$lang['trang-thai']?></th>
									<?php if($jatbi->permission('subject.edit','button')==true){?>
										<th width="2%"></th>
									<?php }?>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($datas as $data) { ?>
									<tr>
										<?php if($jatbi->permission('subject.delete','button')==true){?>
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



										<td>	
											<div class="form-check form-switch">
												<input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/class-academic/subject-status/<?=$data['id']?>/">
												<label class="form-check-label" for="status"></label>
											</div>
										</td>
										<?php if($jatbi->permission('subject.edit','button')==true){?>
											<td>
												<a class="btn btn-sm btn-light modal-url" data-url="/class-academic/subject-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
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
<?php if($router['1']=='subject-add' || $router['1']=='subject-edit'){?>
		<div class="modal fade modal-load" tabindex="-1">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title"><?=$router['1']=='subject-add'?$lang['them']:$lang['sua']?> Môn học</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
						<div class="modal-body">
							<div class="row">
								<div class="col-sm-6">
									<div class="mb-3">
										<label>Tên môn học<small class="text-danger">*</small></label>
										<input placeholder="Tên môn học" type="text" name="name" value="<?=$data['name']?>" class="form-control">
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
<?php if($router['1']=='subject-delete'){?>
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
<?php if($router['1']=='schedule'){?>
		<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
			<div class="">
				<h4>Danh sách thời khóa biểu</h4>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
					<li class="breadcrumb-item active" aria-current="page">Lớp & Học vụ</li>
				</ol>
			</div>
		</nav>
		<?php if($jatbi->permission('schedule.add','button')==true || $jatbi->permission('schedule.delete','button')==true){?>
			<div class="fixed-action-btn">
				<a class="btn btn-large btn-primary rounded-circle">
					<i class="fas fa-bars" aria-hidden="true"></i>
				</a>
				<ul>
					<?php if($jatbi->permission('schedule.delete','button')==true){?>
						<li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/class-academic/schedule-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
					<?php }?>
					<?php if($jatbi->permission('schedule.add','button')==true){?>
						<li><a class="modal-url btn rounded-circle btn-info" data-url="/class-academic/schedule-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
									<?php if($jatbi->permission('schedule.delete','button')==true){?>
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
									<th><?=$lang['ngay-bat-dau']?></th>
									<th><?=$lang['ngay-ket-thuc']?></th>
									<th><?=$lang['lop-hoc']?></th>
									<th><?=$lang['nam-hoc']?></th>	



									<th><?=$lang['trang-thai']?></th>

									<?php if($jatbi->permission('schedule.edit','button')==true){?>
										<th width="2%"></th>
									<?php }?>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($datas as $data) { ?>
									<tr>
										<?php if($jatbi->permission('schedule.delete','button')==true){?>
											<td class="align-middle">
												<div class="form-check">
													<input class="form-check-input checker" type="checkbox" id="<?=$data['id']?>" name="BOX[<?=$data['id']?>]" value="<?=$data['id']?>">
													<label class="form-check-label" for="<?=$data['id']?>"></label>
												</div>
											</td>
										<?php }?>
										<td></td>


										<td><?=$data['name']?></td>
										<td><?=date("d/m/Y", strtotime($data['date_start']))?></td>
										<td><?=date("d/m/Y", strtotime($data['date_end']))?></td>
										<td><?=$database->get("class","name",["id"=>$database->get("class_diagram","class",["id"=>$data['class_diagram']])])?></td>
										<td><?=$database->get("course","name",["id"=>$database->get("class_diagram","course",["id"=>$data['class_diagram']])])?></td>


										<td>	
											<div class="form-check form-switch">
												<input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/class-academic/schedule-status/<?=$data['id']?>/">
												<label class="form-check-label" for="status"></label>
											</div>
										</td>
										<?php if($jatbi->permission('schedule.detail','button')==true){?>
											<td>
												<a class="btn btn-sm btn-light pjax-load" href="/class-academic/schedule-detail/<?=$data['id']?>/"><i class="fas fa-eye" aria-hidden="true"></i></a>
											</td>
										<?php }?>
										<?php if($jatbi->permission('schedule.edit','button')==true){?>
											<td>
												<a class="btn btn-sm btn-light modal-url" data-url="/class-academic/schedule-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
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
<?php if($router['1']=='schedule-add' || $router['1']=='schedule-edit'){?>
		<div class="modal fade modal-load" tabindex="-1">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title"><?=$router['1']=='schedule-add'?$lang['them']:$lang['sua']?> Thời khóa biểu</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
						<div class="modal-body">
							<div class="row">
								<div class="col-sm-6">
									<div class="mb-3">
										<label>Tên<small class="text-danger">*</small></label>
										<input placeholder="Tên" type="text" name="name" value="<?=$data['name']?>" class="form-control">
									</div>
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
										<label>Lớp <small class="text-danger">*</small></label>
										<select name="class_diagram" class="select2 form-control" style="width:100%">
											<option value="" disabled selected>Lớp</option>
											<?php foreach ($class_diagram as $class ) { ?>
												<option value="<?=$class ['id']?>"  <?=($data['class_diagram']==$class['id']?'selected':'')?>><?=$database->get('class','name',['id'=>$class['class']])?> (<?=$database->get('course','name',['id'=>$class['course']])?>)</option>
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
<?php if($router['1']=='schedule-delete'){?>
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
<?php if($router['1']=='schedule-detail'){?>
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
				<div><h4>Chi  lịch học - <?=$schedule['name']?></h4>
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
						<li class="breadcrumb-item active" aria-current="page"><?=$lang['thoi-khoa-bieu']?></li>
					</ol></div>	
				</div>
			</nav>
		<div class="fixed-action-btn">
			<a class="btn btn-large btn-primary rounded-circle">
				<i class="fas fa-bars" aria-hidden="true"></i>
			</a>
			<ul>

				<li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/class-academic/schedule_detail-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>


				<li><a class="modal-url btn rounded-circle btn-info" data-url="/class-academic/schedule_detail-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
			</ul>
		</div>
		<div class="card card-custom">
			<div class="card-body">
				<form method="GET" class="pjax-content mb-4 search-form">
					<div class="form-group col-4">
						<input placeholder="<?=$lang['tim-kiem']?>" type="text" name="name" value="<?=$xss->xss($_GET['name'])?>" class="form-control">
						
					</div>
					<div class="col-lg-3">
				<a href="/class-academic/schedule_view/<?=$schedule['class_diagram']?>/" class="btn btn-light w-100 pjax-load"><?=$lang['thoi-khoa-bieu']?></a>
			</div>
					<div class="form-group">
						<div class="dropdown">
							<button class="border dropdown-toggle w-100 filler" type="button" id="fillers" data-bs-auto-close="false" data-bs-toggle="dropdown" aria-expanded="false">
								<i class="fas fa-filter"></i> <?=$lang['them-dieu-kien-loc']?>
							</button>
							
						
							<div class="dropdown-menu filler-details p-3" aria-labelledby="fillers">
								<p class="mb-2"><?=$lang['tim-kiem-theo-dieu-kien']?></p>
								<div class="filer-item permission">
									<label><?=$lang['ngay']?></label>
									<select name="day" class="select2 form-select" style="width:100%">
										<option value=""><?=$lang['tat-ca']?></option>
										<?php foreach ($day as $permission) { ?>
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

									<th width="1%" class="text-center">
										<div class="form-check">
											<input class="form-check-input selectall" type="checkbox" value="" id="all">
											<label class="form-check-label" for="all">
											</label>
										</div>
									</th>

									<th width="50"></th>
									<th>Thứ</th>
									<th>Tiết</th>
									<th>Môn học</th>
									<th>Phòng học</th>									        
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
										<td><?=$database->get("lesson", "name",["id"=>$data['lesson']])?></td>
										<td><?=$database->get("subject", "name",["id"=>$data['subject']])?></td>
										<td><?=$database->get("classroom", "name",["id"=>$data['classroom']])?></td>	           				           				           				          
										<td>	
											<div class="form-check form-switch">
												<input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/class-academic/schedule_detail-status/<?=$data['id']?>/">
												<label class="form-check-label" for="status"></label>
											</div>
										</td>

										<td>
											<a class="btn btn-sm btn-light modal-url" data-url="/class-academic/schedule_detail-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
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
<?php if($router['1']=='schedule_detail-add' || $router['1']=='schedule_detail-edit'){?>
		<div class="modal fade modal-load" tabindex="-1">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title"><?=$router['1']=='schedule_detail-add'?$lang['them']:$lang['sua']?> Lịch học - <?=$schedule['name']?></h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
						<div class="modal-body">
							<div class="row">
								<div class="col-sm-6">
									<div class="mb-3">
										<label>Lịch học lớp<small class="text-danger">*</small></label>
										<select name="schedule" class="select2 form-control" style="width:100%">


											<option value="<?=$schedule['id']?>"  <?=($data['schedule']==$schedule['id']?'selected':'')?> selected><?=$schedule['name']?></option>

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
										<label> học<small class="text-danger">*</small></label>
										<select name="lesson" class="select2 form-control" style="width:100%">
											<option value="" disabled selected> học</option>
											<?php foreach ($lesson as $lesson) { ?>
												<option value="<?=$lesson['id']?>"  <?=($data['lesson']==$lesson['id']?'selected':'')?>><?=$lesson['name']?></option>
											<?php } ?>
										</select>
									</div>

								</div> 		    
								<div class="col-sm-6">

									<div class="mb-3">
										<label>Môn học<small class="text-danger">*</small></label>
										<select name="subject" class="select2 form-control" style="width:100%">
											<option value="" disabled selected>Môn học</option>
											<?php foreach ($subject as $subject) { ?>
												<option value="<?=$subject['id']?>"  <?=($data['subject']==$subject['id']?'selected':'')?>><?=$subject['name']?></option>
											<?php } ?>
										</select>
									</div>
									<div class="mb-3">
										<label>Phòng học<small class="text-danger">*</small></label>
										<select name="classroom" class="select2 form-control" style="width:100%">
											<option value="" disabled selected>Phòng học</option>
											<?php foreach ($classroom as $classroom) { ?>
												<option value="<?=$classroom['id']?>"  <?=($data['classroom']==$classroom['id']?'selected':'')?>><?=$classroom['name']?></option>
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
<?php if($router['1']=='schedule_detail-delete'){?>
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
<?php if($router['1']=='homeroom_teacher'){?>
		<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
			<div class="">
				<h4><?=$lang['phan-cong-gvcn']?></h4>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
					<li class="breadcrumb-item active" aria-current="page">Lớp & Học vụ</li>
				</ol>
			</div>
		</nav>
		<?php if($jatbi->permission('homeroom_teacher.add','button')==true || $jatbi->permission('homeroom_teacher.delete','button')==true){?>
			<div class="fixed-action-btn">
				<a class="btn btn-large btn-primary rounded-circle">
					<i class="fas fa-bars" aria-hidden="true"></i>
				</a>
				<ul>
					<?php if($jatbi->permission('homeroom_teacher.delete','button')==true){?>
						<li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/class-academic/homeroom_teacher-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
					<?php }?>
					<?php if($jatbi->permission('homeroom_teacher.add','button')==true){?>
						<li><a class="modal-url btn rounded-circle btn-info" data-url="/class-academic/homeroom_teacher-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
									<?php if($jatbi->permission('homeroom_teacher.delete','button')==true){?>
										<th width="1%" class="text-center">
											<div class="form-check">
												<input class="form-check-input selectall" type="checkbox" value="" id="all">
												<label class="form-check-label" for="all">
												</label>
											</div>
										</th>
									<?php }?>
									<th width="50"></th>
									<th><?=$lang['ten-lop']?></th>
									<th><?=$lang['giao-vien']?></th>
									<th><?=$lang['nam-hoc']?></th>		        			        					      
									<th><?=$lang['trang-thai']?></th>
									<?php if($jatbi->permission('homeroom_teacher.edit','button')==true){?>
										<th width="2%"></th>
									<?php }?>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($datas as $data) { ?>
									<tr>
										<?php if($jatbi->permission('homeroom_teacher.delete','button')==true){?>
											<td class="align-middle">
												<div class="form-check">
													<input class="form-check-input checker" type="checkbox" id="<?=$data['id']?>" name="BOX[<?=$data['id']?>]" value="<?=$data['id']?>">
													<label class="form-check-label" for="<?=$data['id']?>"></label>
												</div>
											</td>
										<?php }?>
										<td></td>
										<td><?=$database->get("class", "name",["id"=>$data['class']])?></td>
										<td><?=$database->get("teacher", "firstname",["id"=>$data['teacher']])?> <?=$database->get("teacher", "lastname",["id"=>$data['teacher']])?></td>
										<td><?=$database->get("school_year","name",["id"=>$database->get("class","school_year",["id"=>$data['class']])])?></td>

										<td>	
											<div class="form-check form-switch">
												<input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/class-academic/homeroom_teacher-status/<?=$data['id']?>/">
												<label class="form-check-label" for="status"></label>
											</div>
										</td>
										<?php if($jatbi->permission('homeroom_teacher.edit','button')==true){?>
											<td>
												<a class="btn btn-sm btn-light modal-url" data-url="/class-academic/homeroom_teacher-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
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
<?php if($router['1']=='homeroom_teacher-add' || $router['1']=='homeroom_teacher-edit'){?>
		<div class="modal fade modal-load" tabindex="-1">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title"><?=$router['1']=='classroom_type-add'?$lang['them']:$lang['sua']?> <?=$lang['phan-cong-gvcn']?></h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
						<div class="modal-body">
							<div class="row">
								<div class="col-sm-6">
									<div class="mb-3">
										<label><?=$lang['giao-vien']?><small class="text-danger">*</small></label>
										<select name="teacher" class="select2 form-control" style="width:100%">
											<option value="" disabled selected><?=$lang['giao-vien']?></option>
											<?php foreach ($teacher as $teacher ) { ?>
												<option value="<?=$teacher['id']?>"  <?=($data['teacher']==$teacher['id']?'selected':'')?>><?=$teacher['firstname']?> <?=$teacher['lastname']?></option>
											<?php } ?>
										</select>
									</div>	
								</div> 		 						        			        					 
								<div class="col-sm-6">			        	
									<div class="mb-3">
										<label><?=$lang['lop-hoc']?><small class="text-danger">*</small></label>
										<select name="class" class="select2 form-control" style="width:100%">
											<option value="" disabled selected><?=$lang['lop-hoc']?></option>
											<?php foreach ($class as $class ) { ?>
												<option value="<?=$class ['id']?>"  <?=($data['class']==$class['id']?'selected':'')?>><?=$class['name']?></option>
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
<?php if($router['1']=='homeroom_teacher-delete'){?>
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
<?php if($router['1']=='departments'){?>
		<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
			<div class="">
				<h4>Danh sách Phòng ban</h4>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
					<li class="breadcrumb-item active" aria-current="page">Hồ sơ</li>
				</ol>
			</div>
		</nav>
		<?php if($jatbi->permission('departments.add','button')==true || $jatbi->permission('departments.delete','button')==true){?>
			<div class="fixed-action-btn">
				<a class="btn btn-large btn-primary rounded-circle">
					<i class="fas fa-bars" aria-hidden="true"></i>
				</a>
				<ul>
					<?php if($jatbi->permission('departments.delete','button')==true){?>
						<li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/class-academic/departments-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
					<?php }?>
					<?php if($jatbi->permission('departments.add','button')==true){?>
						<li><a class="modal-url btn rounded-circle btn-info" data-url="/class-academic/departments-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
									<?php if($jatbi->permission('departments.delete','button')==true){?>
										<th width="1%" class="text-center">
											<div class="form-check">
												<input class="form-check-input selectall" type="checkbox" value="" id="all">
												<label class="form-check-label" for="all">
												</label>
											</div>
										</th>
									<?php }?>
									<th width="50"></th>					      					     
									<th>Tên phòng ban</th>
									<th>Khu vực</th>	
									<th><?=$lang['trang-thai']?></th>
									<?php if($jatbi->permission('departments.edit','button')==true){?>
										<th width="2%"></th>
									<?php }?>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($datas as $data) { ?>
									<tr>
										<?php if($jatbi->permission('departments.delete','button')==true){?>
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

										<td><?=$database->get("areas", "name",["id"=>$data['areas']])?></td>

										<td>	
											<div class="form-check form-switch">
												<input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/class-academic/departments-status/<?=$data['id']?>/">
												<label class="form-check-label" for="status"></label>
											</div>
										</td>
										<?php if($jatbi->permission('departments.edit','button')==true){?>
											<td>
												<a class="btn btn-sm btn-light modal-url" data-url="/class-academic/departments-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
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
<?php if($router['1']=='departments-add' || $router['1']=='departments-edit'){?>
		<div class="modal fade modal-load" tabindex="-1">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title"><?=$router['1']=='departments-add'?$lang['them']:$lang['sua']?> Phòng ban</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
						<div class="modal-body">
							<div class="row">
								<div class="col-sm-6">
									<div class="mb-3">
										<label>Tên phòng ban<small class="text-danger">*</small></label>
										<input placeholder="Tên phòng ban" type="text" name="name" value="<?=$data['name']?>" class="form-control">
									</div>
									<div class="mb-3">
										<label>Khu vực<small class="text-danger">*</small></label>
										<select name="areas" class="select2 form-control" style="width:100%">
											<option value="" disabled selected>Khu vực</option>
											<?php foreach ($areas as $areas ) { ?>
												<option value="<?=$areas['id']?>"  <?=($data['areas']==$areas['id']?'selected':'')?>><?=$areas['name']?></option>
											<?php } ?>
										</select>
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
<?php if($router['1']=='departments-delete'){?>
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
<?php if($router['1']=='first_book-class'){?>
		<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
			<div class="">
				<h4><?=$lang['so-dau-bai']?></h4>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
					<li class="breadcrumb-item active" aria-current="page">Lớp & Học vụ</li>
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
									<th><?=$lang['ten-lop']?></th>
									<th><?=$lang['giao-vien']?></th>
									<th><?=$lang['khoa-hoc']?></th>		        			        					      
									<th><?=$lang['trang-thai']?></th>
									<?php if($jatbi->permission('homeroom_teacher.edit','button')==true){?>
										<th width="2%"></th>
									<?php }?>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($datas as $data) { ?>
									<tr>

										<td></td>
										<td><?=$database->get("class","name",["id"=>$data['class']])?></td>
										<td><?=$database->get("teacher","firstname",["id"=>$data['homeroom_teacher']])?> <?=$database->get("teacher","lastname",["id"=>$data['homeroom_teacher']])?></td>
										<td><?=$database->get("course","name",["id"=>$data['course']])?></td>

										<td>	
											<div class="form-check form-switch">
												<input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/class-academic/class_diagram-status/<?=$data['id']?>/">
												<label class="form-check-label" for="status"></label>
											</div>
										</td>
										<?php if($jatbi->permission('first_book','button')==true){?>
											<td>
												<a class="btn btn-sm btn-light pjax-load" href="/class-academic/first_book/<?=$data['id']?>/"><i class="fas fa-eye" aria-hidden="true"></i></a>
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
<?php if($router['1']=='first_book'){?>
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
				<div><h4><?=$lang['chi-tiet-so-dau-bai']?></h4></div>

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
									<th>Ngày</th>
									<th>Tiết</th>
									<th>Môn học</th>
									<th>Bài học</th>
									<th>Nội dung</th>
									<th>Nhận xét</th>
									<th>Đánh giá</th>
									<th>Giáo viên</th>								        
									<th><?=$lang['trang-thai']?></th>


									<th width="2%"></th>

								</tr>
							</thead>
							<tbody>
								<?php foreach ($datas as $data) { ?>
									<tr>				            			    			        
										<td></td>

										<td><?=date("d/m/Y", strtotime($data['date']))?></td>				          				 
										<td><?=$database->get("lesson", "name",["id"=>$data['lesson']])?></td>						
										<td><?=$database->get("subject", "name",["id"=>$data['subject']])?></td>
										<td><?=$data['title']?></td>
										<td><?=$data['content']?></td>
										<td><?=$data['comment']?></td>
										<td><?=$data['evaluate']?></td>
										<td><?=$database->get("teacher","firstname",["id"=>$data['teacher']])?> <?=$database->get("teacher","lastname",["id"=>$data['teacher']])?></td>

										<td>	
											<div class="form-check form-switch">
												<input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/class-academic/schedule_detail-status/<?=$data['id']?>/">
												<label class="form-check-label" for="status"></label>
											</div>
										</td>

										<td>
											<a class="btn btn-sm btn-light modal-url" data-url="/class-academic/first_book-edit/<?=$data['id']?>/"><i class="fas fa-eye" aria-hidden="true"></i></a>
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
<?php if($router['1']=='first_book-edit'){?>
		<div class="modal fade modal-load" tabindex="-1">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title"><?=$lang['chi-tiet-so-dau-bai']?></h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
						<div class="modal-body">
							<div class="row">
								<div class="col-sm-12">
									<div class="mb-3">
										<label><?=$lang['ngay']?><small class="text-danger">*</small></label>
										<input placeholder="<?=$lang['ngay']?>"  name="date" value="<?=date("d/m/Y", strtotime($data['date']))?>" class="form-control">
									</div>			    				    	
								</div>
								<div class="mb-3">
									<label><?= $lang['tiet']?><small class="text-danger">*</small></label>
									<input placeholder="<?= $lang['tiet']?>" type="text" name="lesson" value="<?=$database->get("lesson", "name",["id"=>$data['lesson']])?>" class="form-control">
								</div>
								<div class="mb-3">
									<label><?= $lang['mon-hoc']?><small class="text-danger">*</small></label>
									<input placeholder="<?= $lang['mon-hoc']?>" type="text" name="subject" value="<?=$database->get("subject", "name",["id"=>$data['subject']])?>" class="form-control">
								</div>
								<div class="mb-3">
									<label><?= $lang['tieu-de']?><small class="text-danger">*</small></label>
									<input placeholder="<?= $lang['tieu-de']?>" type="text" name="title" value="<?=$data['title']?>" class="form-control">
								</div>				    				    	
							</div> 
							<div class="mb-3">
								<label><?= $lang['noi-dung']?><small class="text-danger">*</small></label>
								<textarea placeholder="<?= $lang['noi-dung']?>"  name="content"  class="form-control"><?=$data['content']?></textarea>
							</div>	
							<div class="mb-3">
								<label><?= $lang['nhan-xet']?><small class="text-danger">*</small></label>
								<textarea placeholder="<?= $lang['nhan-xet']?>"    class="form-control"><?=$data['comment']?></textarea>
							</div>	
							<div class="mb-3">
								<label><?= $lang['danh-gia']?><small class="text-danger">*</small></label>
								<textarea placeholder="<?= $lang['danh-gia']?>"    class="form-control"><?=$data['evaluate']?></textarea>
							</div>	
							<div class="mb-3">
								<label><?= $lang['giao-vien']?><small class="text-danger">*</small></label>
								<input placeholder="<?= $lang['giao-vien']?>" type="text" name="content" value="<?=$database->get("teacher", "firstname",["id"=>$data['teacher']])?> <?=$database->get("teacher", "lastname",["id"=>$data['teacher']])?>" class="form-control">
							</div>			    				    	
						</div> 		    


					</div>
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
<?php if($router['1']=='assigning_teachers'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['phan-cong-gv']?></h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
				<li class="breadcrumb-item active" aria-current="page">Lớp & Học vụ</li>
			</ol>
		</div>
	</nav>
	<?php if($jatbi->permission('assigning_teachers.add','button')==true || $jatbi->permission('assigning_teachers.delete','button')==true){?>
		<div class="fixed-action-btn">
			<a class="btn btn-large btn-primary rounded-circle">
				<i class="fas fa-bars" aria-hidden="true"></i>
			</a>
			<ul>
				<?php if($jatbi->permission('assigning_teachers.delete','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/class-academic/assigning_teachers-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
				<?php }?>
				<?php if($jatbi->permission('assigning_teachers.add','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-info" data-url="/class-academic/assigning_teachers-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
								<?php if($jatbi->permission('assigning_teachers.delete','button')==true){?>
									<th width="1%" class="text-center">
										<div class="form-check">
											<input class="form-check-input selectall" type="checkbox" value="" id="all">
											<label class="form-check-label" for="all">
											</label>
										</div>
									</th>
								<?php }?>
								<th width="50"></th>
								<th><?=$lang['ten-lop']?></th>
								<th><?=$lang['mon-hoc']?></th>	
								<th><?=$lang['giao-vien']?></th>									        	        	
								<th><?=$lang['khoa-hoc']?></th>		
								<th><?=$lang['hoc-ki']?></th>			      
								<th><?=$lang['trang-thai']?></th>
								<?php if($jatbi->permission('assigning_teachers.edit','button')==true){?>
									<th width="2%"></th>
								<?php }?>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($datas as $data) { ?>
								<tr>
									<?php if($jatbi->permission('assigning_teachers.delete','button')==true){?>
										<td class="align-middle">
											<div class="form-check">
												<input class="form-check-input checker" type="checkbox" id="<?=$data['id']?>" name="BOX[<?=$data['id']?>]" value="<?=$data['id']?>">
												<label class="form-check-label" for="<?=$data['id']?>"></label>
											</div>
										</td>
									<?php }?>
									<td></td>
									<td><?=$database->get("class", "name",["id"=>$database->get("class_diagram","class",["id"=>$data['class_diagram']])])?></td>
									<td><?=$database->get("subject", "name",["id"=>$data['subject']])?></td>
									<td><?=$database->get("teacher", "firstname",["id"=>$data['teacher']])?> <?=$database->get("teacher", "lastname",["id"=>$data['teacher']])?></td>
									<td><?=$database->get("course","name",["id"=>$database->get("semester","course",["id"=>$data['semester']])])?></td>
									<td><?=$database->get("semester","name",["id"=>$data['semester']])?></td>

									<td>	
										<div class="form-check form-switch">
											<input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/class-academic/assigning_teachers-status/<?=$data['id']?>/">
											<label class="form-check-label" for="status"></label>
										</div>
									</td>
									<?php if($jatbi->permission('assigning_teachers.edit','button')==true){?>
										<td>
											<a class="btn btn-sm btn-light modal-url" data-url="/class-academic/assigning_teachers-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
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
<?php if($router['1']=='assigning_teachers-add' || $router['1']=='assigning_teachers-edit'){?>
	<div class="modal fade modal-load" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><?=$router['1']=='classroom_type-add'?$lang['them']:$lang['sua']?> <?=$lang['phan-cong-gv']?></h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
					<div class="modal-body">
						<div class="row">
							<div class="col-sm-6">
								<div class="mb-3">
									<label><?=$lang['lop-hoc']?><small class="text-danger">*</small></label>
									<select name="class_diagram" class="select2 form-control" style="width:100%">
										<option value="" disabled selected><?=$lang['lop-hoc']?></option>
										<?php foreach ($class_diagram as $class ) { ?>
											<option value="<?=$class ['id']?>"  <?=($data['class_diagram']==$class['id']?'selected':'')?>><?=$database->get('class','name',['id'=>$class['class']])?> (<?=$database->get('course','name',['id'=>$class['course']])?>)</option>
										<?php } ?>
									</select>
								</div>
								<div class="mb-3">
									<label><?=$lang['hoc-ki']?><small class="text-danger">*</small></label>
									<select name="semester" class="select2 form-control" style="width:100%">
										<option value="" disabled selected><?=$lang['hoc-ki']?></option>
										<?php foreach ($semesters as $semester ) { ?>
											<option value="<?=$semester['id']?>"  <?=($data['semester']==$semester['id']?'selected':'')?>><?=$semester['name']?> (<?=$database->get('course','name',['id'=>$semester['course']])?>)</option>
										<?php } ?>
									</select>
								</div>
								<div class="mb-3">
									<label><?=$lang['mon-hoc']?><small class="text-danger">*</small></label>
									<select name="subject" class="select2 form-control" style="width:100%">
										<option value="" disabled selected><?=$lang['mon-hoc']?></option>
										<?php foreach ($subject as $subject ) { ?>
											<option value="<?=$subject['id']?>"  <?=($data['subject']==$subject['id']?'selected':'')?>><?=$subject['name']?></option>
										<?php } ?>
									</select>
								</div>

							</div> 		 						        			        					 
							<div class="col-sm-6">			        	
								<div class="mb-3">
									<label><?=$lang['giao-vien']?><small class="text-danger">*</small></label>
									<select name="teacher" class="select2 form-control" style="width:100%">
										<option value="" disabled selected><?=$lang['giao-vien']?></option>
										<?php foreach ($school_teachers as $teachers ) { 
											$teacher=$database->get("teacher","*",["id"=>$teachers['teacher']]);
											?>
											<option value="<?=$teacher['id']?>"  <?=($data['teacher']==$teacher['id']?'selected':'')?>><?=$teacher['firstname']?> <?=$teacher['lastname']?> - <?=$database->get('subject','name',['id'=>$teachers['subject']])?></option>
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
<?php if($router['1']=='assigning_teachers-delete'){?>
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
<?php if($router['1']=='arrange_class'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['xep-lop']?></h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
				<li class="breadcrumb-item active" aria-current="page">Lớp & Học vụ</li>
			</ol>
		</div>
	</nav>
	<?php if($jatbi->permission('arrange_class.add','button')==true || $jatbi->permission('arrange_class.delete','button')==true){?>
		<div class="fixed-action-btn">
			<a class="btn btn-large btn-primary rounded-circle">
				<i class="fas fa-bars" aria-hidden="true"></i>
			</a>
			<ul>
				<?php if($jatbi->permission('arrange_class.delete','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/class-academic/arrange_class-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
				<?php }?>
				<?php if($jatbi->permission('arrange_class.add','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-info" data-url="/class-academic/arrange_class-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
								<?php if($jatbi->permission('arrange_class.delete','button')==true){?>
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
								<th><?=$lang['ten-lop']?></th>
								<th><?=$lang['khoa-hoc']?></th>	
								<th><?=$lang['ghi-chu']?></th>	
								<th><?=$lang['ngay']?></th>				        			        					      
								<th><?=$lang['trang-thai']?></th>
								<?php if($jatbi->permission('arrange_class.edit','button')==true){?>
									<th width="2%"></th>
								<?php }?>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($datas as $data) { ?>
								<tr>
									<?php if($jatbi->permission('arrange_class.delete','button')==true){?>
										<td class="align-middle">
											<div class="form-check">
												<input class="form-check-input checker" type="checkbox" id="<?=$data['id']?>" name="BOX[<?=$data['id']?>]" value="<?=$data['id']?>">
												<label class="form-check-label" for="<?=$data['id']?>"></label>
											</div>
										</td>
									<?php }?>
									<td></td>
									<td><?=$database->get('students','id_student',['id'=>$data['students']])?></td>
									<td><?=$database->get('students','firstname',['id'=>$data['students']])?> <?=$database->get('students','lastname',['id'=>$data['students']])?></td>
									<td><?=$database->get('class','name',['id'=>$database->get('class_diagram','class',['id'=>$data['class_diagram']])])?></td>
									<td><?=$database->get('course','name',['id'=>$database->get('class_diagram','course',['id'=>$data['class_diagram']])])?></td>
									<td><?=$data['note']?></td>
									<td><?=date("d/m/Y", strtotime($data['date']))?></td>
									<td>	
										<div class="form-check form-switch">
											<input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/class-academic/arrange_class-status/<?=$data['id']?>/">
											<label class="form-check-label" for="status"></label>
										</div>
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
<?php if($router['1']=='arrange_class-add'){?>
	<div class="modal fade modal-load" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><?=$router['1']=='arrange_class-add'?$lang['xep']:$lang['chuyen']?> <?=$lang['lop']?></h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
					<div class="modal-body">
						<div class="row">
							<div class="col-sm-12">
								<div class="mb-3">
									<label><?=$lang['khoa-hoc']?><small class="text-danger">*</small></label>
									<select name="course_class" class="select2 form-control course-class" style="width:100%">
										<option value="" disabled selected><?=$lang['khoa-hoc']?></option>
										<?php foreach ($course as $course ) { ?>
											<option value="<?=$course['id']?>"  <?=($database->get("course","id",["id"=>$database->get('class_diagram','course',['id'=>$data['class_diagram']])])==$course['id']?'selected':'')?>><?=$course['name']?></option>
										<?php } ?>
									</select>
								</div>
								<div class="mb-3">
									<label><?=$lang['ten-lop']?><small class="text-danger">*</small></label>
									<select  name="class_diagram" class="select2 form-control areas-class" style="width:100%">
										<option value="" disabled selected><?=$lang['ten-lop']?></option>
										<?php foreach ($class_diagram as $class_diagram ) { 
											$lass = $database->select("class_diagram","*",["id"=>$course["id"]]);
											foreach($lass as $las){?>
												<option value="<?=$las['id']?>"  <?=($las['class']==$las['id']?'selected':'')?>></option>
											<?php } ?>
										<?php } ?>
									</select>

								</div> 	
								<div class="mb-3">
									<label><?=$lang['hoc-sinh']?> </label>
									<select name="students[]" class="select2 form-control" style="width:100%" multiple>
										<?php foreach ($students as $key => $student) {?>
											<option value="<?=$student['id']?>" <?=($data['students']==$student['id']?'selected':'')?>><?=$student['id_student']?> - <?=$student['firstname']?> <?=$student['lastname']?></option>
										<?php } ?>
									</select>
								</div>
								<div class="mb-3">
									<label><?= $lang['ghi-chu']?><small class="text-danger">*</small></label>
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
	<?php if($router['1']=='arrange_class-delete'){?>
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
	<?php if($router['1']=='change_class'){?>
		<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
			<div class="">
				<h4><?=$lang['chuyen-lop']?></h4>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
					<li class="breadcrumb-item active" aria-current="page">Lớp & Học vụ</li>
				</ol>
			</div>
		</nav>
	<!-- <?php if($jatbi->permission('arrange_class.add','button')==true || $jatbi->permission('arrange_class.delete','button')==true){?>
		<div class="fixed-action-btn">
			<a class="btn btn-large btn-primary rounded-circle">
				<i class="fas fa-bars" aria-hidden="true"></i>
			</a>
			<ul>
				<?php if($jatbi->permission('arrange_class.delete','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/class-academic/arrange_class-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
				<?php }?>
				<?php if($jatbi->permission('arrange_class.add','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-info" data-url="/class-academic/arrange_class-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
				<?php }?>
			</ul>
		</div>
		<?php }?> -->
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
									<?php if($jatbi->permission('arrange_class.delete','button')==true){?>
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
									<th><?=$lang['ten-lop']?></th>
									<th><?=$lang['khoa-hoc']?></th>	
									<th><?=$lang['ghi-chu']?></th>	
									<th><?=$lang['ngay']?></th>				        			        					      
									<th><?=$lang['trang-thai']?></th>
									<?php if($jatbi->permission('arrange_class.edit','button')==true){?>
										<th width="2%"></th>
									<?php }?>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($datas as $data) { ?>
									<tr>
										<?php if($jatbi->permission('arrange_class.delete','button')==true){?>
											<td class="align-middle">
												<div class="form-check">
													<input class="form-check-input checker" type="checkbox" id="<?=$data['id']?>" name="BOX[<?=$data['id']?>]" value="<?=$data['id']?>">
													<label class="form-check-label" for="<?=$data['id']?>"></label>
												</div>
											</td>
										<?php }?>
										<td></td>
										<td><?=$database->get('students','id_student',['id'=>$data['students']])?></td>
										<td><?=$database->get('students','firstname',['id'=>$data['students']])?> <?=$database->get('students','lastname',['id'=>$data['students']])?></td>
										<td><?=$database->get('class','name',['id'=>$database->get('class_diagram','class',['id'=>$data['class_diagram']])])?></td>
										<td><?=$database->get('course','name',['id'=>$database->get('class_diagram','course',['id'=>$data['class_diagram']])])?></td>
										<td><?=$data['note']?></td>
										<td><?=date("d/m/Y", strtotime($data['date']))?></td>
										<td>	
											<div class="form-check form-switch">
												<input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/class-academic/arrange_class-status/<?=$data['id']?>/">
												<label class="form-check-label" for="status"></label>
											</div>
										</td>
										<?php if($jatbi->permission('change_class.edit','button')==true){?>
											<td>
												<a class="btn btn-sm btn-light modal-url" data-url="/class-academic/change_class-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
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
	<?php if($router['1']=='change_class-edit'){?>
		<div class="modal fade modal-load" tabindex="-1">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title"><?=$router['1']=='arrange_class-add'?$lang['them']:$lang['chuyen']?> <?=$lang['lop']?></h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
						<div class="modal-body">
							<div class="row">
								<div class="col-sm-12">
									<div class="mb-3">
										<label><?=$lang['khoa-hoc']?><small class="text-danger">*</small></label>
										<select  name="course_class" class="select2 form-control" style="width:100%">
											<option value="<?=$database->get("course","id",["id"=>$database->get('class_diagram','course',['id'=>$data['class_diagram']])])?>" selected ><?=$database->get("course","name",["id"=>$database->get('class_diagram','course',['id'=>$data['class_diagram']])])?>
										</option>
									</select>
								</div>
								<div class="mb-3">
									<label><?=$lang['ten-lop']?><small class="text-danger">*</small></label>
									<select  name="class_diagram" class="select2 form-control " style="width:100%">
										<option value="" disabled selected><?=$lang['ten-lop']?></option>
										<?php foreach ($class_diagrams as $class_diagram ) { ?>
											<option value="<?=$class_diagram['id']?>"  <?=($data['class_diagram']==$class_diagram['id']?'selected':'')?>>
												<?=$database->get("class","name",["id"=>$class_diagram["class"]])?> - 
												<?=$database->get("teacher","firstname",["id"=>$class_diagram["homeroom_teacher"]])?> 
												<?=$database->get("teacher","lastname",["id"=>$class_diagram["homeroom_teacher"]])?>

											</option>


										<?php } ?>
									</select>

								</div> 	
								<div class="mb-3">
									<label><?=$lang['hoc-sinh']?><small class="text-danger">*</small></label>
									<select  name="students" class="select2 form-control" style="width:100%">
										<option value="<?=$database->get("students","id",["id"=>$data["students"]])?>" selected ><?=$database->get("students","firstname",["id"=>$data["students"]])?> <?=$database->get("students","lastname",["id"=>$data["students"]])?>
									</option>
								</select>
							</div>	 
							<div class="mb-3">
								<label><?= $lang['ghi-chu']?><small class="text-danger">*</small></label>
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
<?php if($router['1']=='up_class'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['len-lop']?></h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
				<li class="breadcrumb-item active" aria-current="page">Lớp & Học vụ</li>
			</ol>
		</div>
	</nav>
	<!-- <?php if($jatbi->permission('arrange_class.add','button')==true || $jatbi->permission('arrange_class.delete','button')==true){?>
		<div class="fixed-action-btn">
			<a class="btn btn-large btn-primary rounded-circle">
				<i class="fas fa-bars" aria-hidden="true"></i>
			</a>
			<ul>
				<?php if($jatbi->permission('arrange_class.delete','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/class-academic/arrange_class-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
				<?php }?>
				<?php if($jatbi->permission('arrange_class.add','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-info" data-url="/class-academic/arrange_class-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
				<?php }?>
			</ul>
		</div>
		<?php }?> -->
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
									<?php if($jatbi->permission('arrange_class.delete','button')==true){?>
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
									<th><?=$lang['ten-lop']?></th>
									<th><?=$lang['khoa-hoc']?></th>	
									<th><?=$lang['ghi-chu']?></th>	
									<th><?=$lang['ngay']?></th>				        			        					      
									<th><?=$lang['trang-thai']?></th>
									<?php if($jatbi->permission('arrange_class.edit','button')==true){?>
										<th width="2%"></th>
									<?php }?>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($datas as $data) { ?>
									<tr>
										<?php if($jatbi->permission('arrange_class.delete','button')==true){?>
											<td class="align-middle">
												<div class="form-check">
													<input class="form-check-input checker" type="checkbox" id="<?=$data['id']?>" name="BOX[<?=$data['id']?>]" value="<?=$data['id']?>">
													<label class="form-check-label" for="<?=$data['id']?>"></label>
												</div>
											</td>
										<?php }?>
										<td></td>
										<td><?=$database->get('students','id_student',['id'=>$data['students']])?></td>
										<td><?=$database->get('students','firstname',['id'=>$data['students']])?> <?=$database->get('students','lastname',['id'=>$data['students']])?></td>
										<td><?=$database->get('class','name',['id'=>$database->get('class_diagram','class',['id'=>$data['class_diagram']])])?></td>
										<td><?=$database->get('course','name',['id'=>$database->get('class_diagram','course',['id'=>$data['class_diagram']])])?></td>
										<td><?=$data['note']?></td>
										<td><?=date("d/m/Y", strtotime($data['date']))?></td>
										<td>	
											<div class="form-check form-switch">
												<input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/class-academic/arrange_class-status/<?=$data['id']?>/">
												<label class="form-check-label" for="status"></label>
											</div>
										</td>
										<?php if($jatbi->permission('up_class.add','button')==true){?>
											<td>
												<a class="btn btn-sm btn-light modal-url" data-url="/class-academic/up_class-add/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
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
<?php if($router['1']=='up_class-add'){?>
		<div class="modal fade modal-load" tabindex="-1">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title"><?=$router['1']=='up_class-add'?$lang['thay-doi']:$lang['chuyen']?> <?=$lang['lop']?></h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
						<div class="modal-body">
							<div class="row">
								<div class="col-sm-12">
									<div class="mb-3">
										<label><?=$lang['khoa-hoc']?><small class="text-danger">*</small></label>
										<select name="course_class" class="select2 form-control course-class" style="width:100%">
											<option value="" disabled selected><?=$lang['khoa-hoc']?></option>
											<?php foreach ($course as $course ) { ?>
												<option value="<?=$course['id']?>"  <?=($database->get("course","id",["id"=>$database->get('class_diagram','course',['id'=>$data['class_diagram']])])==$course['id']?'selected':'')?>><?=$course['name']?></option>
											<?php } ?>
										</select>
									</div>
									<div class="mb-3">
										<label><?=$lang['ten-lop']?><small class="text-danger">*</small></label>
										<select  name="class_diagram" class="select2 form-control areas-class" style="width:100%">
											<option value="" disabled selected><?=$lang['ten-lop']?></option>
											<?php foreach ($class_diagram as $class_diagram ) { 
												$lass = $database->select("class_diagram","*",["id"=>$course["id"]]);
												foreach($lass as $las){?>
													<option value="<?=$las['id']?>"  <?=($las['class']==$las['id']?'selected':'')?>></option>
												<?php } ?>
											<?php } ?>
										</select>

									</div> 	
									<div class="mb-3">
										<label><?=$lang['hoc-sinh']?><small class="text-danger">*</small></label>
										<select  name="students" class="select2 form-control" style="width:100%">
											<option value="<?=$database->get("students","id",["id"=>$data["students"]])?>" selected ><?=$database->get("students","firstname",["id"=>$data["students"]])?> <?=$database->get("students","lastname",["id"=>$data["students"]])?>
										</option>
									</select>
								</div>
								<div class="mb-3">
									<label><?= $lang['ghi-chu']?><small class="text-danger">*</small></label>
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
<?php if($router['1']=='semester'){?>
		<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
			<div class="">
				<h4>Danh sách <?=$lang['hoc-ki']?></h4>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
					<li class="breadcrumb-item active" aria-current="page">Lớp & Học vụ</li>
				</ol>
			</div>
		</nav>
		<?php if($jatbi->permission('semester.add','button')==true || $jatbi->permission('semester.delete','button')==true){?>
			<div class="fixed-action-btn">
				<a class="btn btn-large btn-primary rounded-circle">
					<i class="fas fa-bars" aria-hidden="true"></i>
				</a>
				<ul>
					<?php if($jatbi->permission('semester.delete','button')==true){?>
						<li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/class-academic/semester-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
					<?php }?>
					<?php if($jatbi->permission('semester.add','button')==true){?>
						<li><a class="modal-url btn rounded-circle btn-info" data-url="/class-academic/semester-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
									<?php if($jatbi->permission('semester.delete','button')==true){?>
										<th width="1%" class="text-center">
											<div class="form-check">
												<input class="form-check-input selectall" type="checkbox" value="" id="all">
												<label class="form-check-label" for="all">
												</label>
											</div>
										</th>
									<?php }?>
									<th width="50"></th>
									<th><?=$lang['hoc-ki']?></th>
									<th><?=$lang['ngay-bat-dau']?></th>
									<th><?=$lang['ngay-ket-thuc']?></th>					        			        					
									<th><?=$lang['khoa-hoc']?></th>
									<th><?=$lang['trang-thai']?></th>
									<?php if($jatbi->permission('semester.edit','button')==true){?>
										<th width="2%"></th>
									<?php }?>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($datas as $data) { ?>
									<tr>
										<?php if($jatbi->permission('semester.delete','button')==true){?>
											<td class="align-middle">
												<div class="form-check">
													<input class="form-check-input checker" type="checkbox" id="<?=$data['id']?>" name="BOX[<?=$data['id']?>]" value="<?=$data['id']?>">
													<label class="form-check-label" for="<?=$data['id']?>"></label>
												</div>
											</td>
										<?php }?>
										<td></td>


										<td><?=$data['name']?></td>
										<td><?=date("d/m/Y", strtotime($data['startdate']))?></td>
										<td><?=date("d/m/Y", strtotime($data['enddate']))?></td>
										<td><?=$database->get('course','name',['id'=>$data['course']])?></td>


										<td>	
											<div class="form-check form-switch">
												<input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/class-academic/semester-status/<?=$data['id']?>/">
												<label class="form-check-label" for="status"></label>
											</div>
										</td>
										<?php if($jatbi->permission('semester.edit','button')==true){?>
											<td>
												<a class="btn btn-sm btn-light modal-url" data-url="/class-academic/semester-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
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
<?php if($router['1']=='semester-delete'){?>
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
<?php if($router['1']=='semester-add' || $router['1']=='semester-edit'){?>
		<div class="modal fade modal-load" tabindex="-1">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title"><?=$router['1']=='semester-add'?$lang['them']:$lang['sua']?><?=$lang['hoc-ki']?></h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
						<div class="modal-body">
							<div class="row">
								<div class="col-sm-6">
									<div class="mb-3">
										<label><?=$lang['khoa-hoc']?><small class="text-danger">*</small></label>
										<select name="course" class="select2 form-control course-class" style="width:100%">
											<option value="" disabled selected><?=$lang['khoa-hoc']?></option>
											<?php foreach ($course as $course ) { ?>
												<option value="<?=$course['id']?>"  <?=($data['course']==$course['id']?'selected':'')?>><?=$course['name']?></option>
											<?php } ?>
										</select>
									</div>
									<div class="mb-3">
										<label><?=$lang['hoc-ki']?><small class="text-danger">*</small></label>
										<input placeholder="<?=$lang['hoc-ki']?>" type="text" name="name" value="<?=$data['name']?>" class="form-control">
									</div>
									<div class="mb-3">
										<label><?=$lang['ngay-bat-dau']?><small class="text-danger">*</small></label>
										<input placeholder="<?=$lang['ngay-bat-dau']?>" type="date" name="startdate" value="<?=$data['startdate']?>" class="form-control">
									</div>

								</div> 		    
								<div class="col-sm-6">	
									<div class="mb-3">
										<label><?=$lang['ngay-ket-thuc']?><small class="text-danger">*</small></label>
										<input placeholder="<?=$lang['ngay-ket-thuc']?>" type="date" name="enddate" value="<?=$data['enddate']?>" class="form-control">
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
<?php if($router['1']=='up_class_list-add'){?>
		<div class="modal fade modal-load" tabindex="-1">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title"><?=$router['1']=='up_class-add'?$lang['thay-doi']:$lang['thay-doi']?> <?=$lang['lop']?></h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
						<div class="modal-body">
							<div class="row">
								<div class="col-sm-12">
									<div class="mb-3">
										<label><?=$lang['khoa-hoc']?><small class="text-danger">*</small></label>
										<select name="course_class" class="select2 form-control course-class" style="width:100%">
											<option value="" disabled selected><?=$lang['khoa-hoc']?></option>
											<?php foreach ($course as $course ) { ?>
												<option value="<?=$course['id']?>"  <?=($database->get("course","id",["id"=>$database->get('class_diagram','course',['id'=>$data['class_diagram']])])==$course['id']?'selected':'')?>><?=$course['name']?></option>
											<?php } ?>
										</select>
									</div>
									<div class="mb-3">
										<label><?=$lang['ten-lop']?><small class="text-danger">*</small></label>
										<select  name="class_diagram" class="select2 form-control areas-class" style="width:100%">
											<option value="" disabled selected><?=$lang['ten-lop']?></option>
											<?php foreach ($class_diagram as $class_diagram ) { 
												$lass = $database->select("class_diagram","*",["id"=>$course["id"]]);
												foreach($lass as $las){?>
													<option value="<?=$las['id']?>"  <?=($las['class']==$las['id']?'selected':'')?>></option>
												<?php } ?>
											<?php } ?>
										</select>

									</div> 	
									<div class="mb-3">
										<label><?=$lang['hoc-sinh']?><small class="text-danger">*</small></label>
										<select  name="students" class="select2 form-control" style="width:100%" multiple>
											<?php foreach ($data as $data) {?>
												<option value="<?=$database->get("students","id",["id"=>$data["students"]])?>" selected ><?=$database->get("students","id_student",["id"=>$data["students"]])?> - <?=$database->get("students","firstname",["id"=>$data["students"]])?> <?=$database->get("students","lastname",["id"=>$data["students"]])?>
											</option>
										<?php } ?>
									</select>
								</div>
								<div class="mb-3">
									<label><?= $lang['ghi-chu']?><small class="text-danger">*</small></label>
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
<?php if($router['1']=='contact_book'){?>
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
				<div><h4>Sổ liên lạc của học sinh <?=$student['fullname']?></h4>
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
						<li class="breadcrumb-item active" aria-current="page">Sơ đồ lớp</li>
					</ol></div>	
				</div>
			</nav>

			<div class="card card-custom">
				<div class="card-body">
					<div class="pjax-content-load ">
						<div class="table-responsive rounded-3">
							<table class="table table-bordered table-striped table-hover align-middle ">
								<thead>
									<tr class="text-center " style="background-color: #c9c9c9b5; ">

										<th class="text-dark">STT</th>
										<th class="text-dark">MÔN HỌC</th>
										<th class="text-dark" colspan="5">MIỆNG</th>							
										<th class="text-dark" colspan="3">KIỂM TRA 15P</th>
										<th class="text-dark" colspan="5">KIỂM TRA 45P</th>
										<th class="text-dark">GIỮA KỲ</th>
										<th class="text-dark" colspan="3">THỰC HÀNH</th>
										<th class="text-dark">CUỐI KỲ</th>
										<th class="text-dark">TRUNG BÌNH MÔN</th>



									</tr>
								</thead>
								<?php foreach ($semester as $value) {$dtbm=0; $dthk=0; $c=0; $d+=1; unset($c);
									$assigning_teachers=$database->select("assigning_teachers","*",["class_diagram"=>$class_diagram['id'],"school"=>$value['school'],"semester"=>$value['id']]);
									?>
									<tbody >
										<tr>
											<td colspan="21" class="fw-bold">HỌC KÌ <?=$value['name']?> (<?=$database->get("course","name",["id"=>$value['course']])?>)</td>
										</tr>
										<?php foreach ($assigning_teachers as $ass){$c+=1;
											$diemtk=$database->select("scores","*",["typescore"=>$database->get("typescore", "id", ["school"        =>$value['school'],"id_type_scores" =>"m", "deleted" => 0, "status" => 'A']),"school"=>$value['school'],"assigning_teachers"=>$ass['id'],"arrange_class"=>$arrange_class['id']]);
											$diem15=$database->select("scores","*",["typescore"=>$database->get("typescore", "id", ["school"        =>$value['school'],"id_type_scores" =>"15p", "deleted" => 0, "status" => 'A']),"school"=>$value['school'],"assigning_teachers"=>$ass['id'],"arrange_class"=>$arrange_class['id']]);
											$diem45p=$database->select("scores","*",["typescore"=>$database->get("typescore", "id", ["school"        =>$value['school'],"id_type_scores" =>"45p", "deleted" => 0, "status" => 'A']),"school"=>$value['school'],"assigning_teachers"=>$ass['id'],"arrange_class"=>$arrange_class['id']]);
											$diemgk=$database->get("scores","score",["typescore"=>$database->get("typescore", "id", ["school"        =>$value['school'],"id_type_scores" =>"gk", "deleted" => 0, "status" => 'A']),"school"=>$value['school'],"assigning_teachers"=>$ass['id'],"arrange_class"=>$arrange_class['id']]);
											$diemck=$database->get("scores","score",["typescore"=>$database->get("typescore", "id", ["school"        =>$value['school'],"id_type_scores" =>"ck", "deleted" => 0, "status" => 'A']),"school"=>$value['school'],"assigning_teachers"=>$ass['id'],"arrange_class"=>$arrange_class['id']]);
											$diemth=$database->select("scores","*",["typescore"=>$database->get("typescore", "id", ["school"        =>$value['school'],"id_type_scores" =>"th", "deleted" => 0, "status" => 'A']),"school"=>$value['school'],"assigning_teachers"=>$ass['id'],"arrange_class"=>$arrange_class['id']]);
											$totaltk=0;
											$total15=0;
											$total45=0;
											$totalth=0;
											$totalgk=0;
											$totalck=0;
											$hesotk=$database->get("typescore", "heso", ["school"=>$value['school'],"id_type_scores" =>"m", "deleted" => 0, "status" => 'A']);
											$heso15=$database->get("typescore", "heso", ["school"=>$value['school'],"id_type_scores" =>"15p", "deleted" => 0, "status" => 'A']);
											$heso45=$database->get("typescore", "heso", ["school"=>$value['school'],"id_type_scores" =>"45p", "deleted" => 0, "status" => 'A']);
											$hesoth=$database->get("typescore", "heso", ["school"=>$value['school'],"id_type_scores" =>"th", "deleted" => 0, "status" => 'A']);
											$hesogk=$database->get("typescore", "heso", ["school"=>$value['school'],"id_type_scores" =>"gk", "deleted" => 0, "status" => 'A']);
											$hesock=$database->get("typescore", "heso", ["school"=>$value['school'],"id_type_scores" =>"ck", "deleted" => 0, "status" => 'A']);
											$countDiemtk = count($diemtk);
											$countDiem15 = count($diem15);
											$countDiem45p = count($diem45p);

										$countDiemgk = ($diemgk !== false) ? 1 : 0; // Kiểm tra nếu $diemgk có giá trị thì gán 1, ngược lại gán 0
										$countDiemck = ($diemck !== false) ? 1 : 0; // Kiểm tra nếu $diemck có giá trị thì gán 1, ngược lại gán 0
										$countDiemth = count($diemth);
										// Tính tổng điểm từ $diemtk
										foreach ($diemtk as $score) {
											$totaltk += $score['score'];
										}

										// Tính tổng điểm từ $diem15
										foreach ($diem15 as $score) {
											$total15 += $score['score'];
										}

										// Tính tổng điểm từ $diem45p
										foreach ($diem45p as $score) {
											$total45 += $score['score'];
										}

										// Thêm điểm giữa kỳ $diemgk vào tổng điểm
										$totalgk = $diemgk;

										// Thêm điểm cuối kỳ $diemck vào tổng điểm
										$totalck = $diemck;

										// Tính tổng điểm từ $diemth
										foreach ($diemth as $score) {
											$totalth += $score['score'];
										}
										
										$dtbm=($totaltk*$hesotk+$total15*$heso15+$total45*$heso45+$totalgk*$hesogk+$totalck*$hesock+$totalth*$hesoth)/($countDiemtk*$hesotk+$countDiem15*$heso15+$countDiem45p*$heso45+$countDiemth*$hesoth+$hesogk+$hesock);
										$dthk+=$dtbm;

									?>
									<tr class="text-center">
									    <td><?= $c ?></td>
									    <td><?= $database->get("subject", "name", ["id" => $ass['subject']]) ?></td>
									    <?php if (count($diemtk) >= 1 && count($diemtk) <= 5): ?>
									        <?php foreach ($diemtk as $diem): ?>
									            <td <?= $diem['score'] <= 5 ? 'style="color: red;"' : '' ?>><?= $diem['score'] ?></td>
									        <?php endforeach; ?>
									        <?php for ($i = count($diemtk); $i < 5; $i++): ?>
									            <td></td>
									        <?php endfor; ?>
									    <?php elseif (count($diemtk) == 0): ?>
									        <?php for ($i = 0; $i < 5; $i++): ?>
									            <td></td>
									        <?php endfor; ?>
									    <?php endif; ?>

									    <?php if (count($diem15) >= 1 && count($diem15) <= 3): ?>
									        <?php foreach ($diem15 as $diem): ?>
									            <td <?= $diem['score'] <= 5 ? 'style="color: red;"' : '' ?>><?= $diem['score'] ?></td>
									        <?php endforeach; ?>
									        <?php for ($i = count($diem15); $i < 3; $i++): ?>
									            <td></td>
									        <?php endfor; ?>
									    <?php elseif (count($diem15) == 0): ?>
									        <?php for ($i = 0; $i < 3; $i++): ?>
									            <td></td>
									        <?php endfor; ?>
									    <?php endif; ?>

									    <?php if (count($diem45p) >= 1 && count($diem45p) <= 5): ?>
									        <?php foreach ($diem45p as $diem): ?>
									            <td <?= $diem['score'] <= 5 ? 'style="color: red;"' : '' ?>><?= $diem['score'] ?></td>
									        <?php endforeach; ?>
									        <?php for ($i = count($diem45p); $i < 5; $i++): ?>
									            <td></td>
									        <?php endfor; ?>
									    <?php elseif (count($diem45p) == 0): ?>
									        <?php for ($i = 0; $i < 5; $i++): ?>
									            <td></td>
									        <?php endfor; ?>
									    <?php endif; ?>

									     <td <?= $diemgk <= 5 ? 'style="color: red;"' : '' ?>><?= $diemgk ?></td>

									    <?php if (count($diemth) >= 1 && count($diemth) <= 3): ?>
									        <?php foreach ($diemth as $diem): ?>
									            <td <?= $diem['score'] <= 5 ? 'style="color: red;"' : '' ?>><?= $diem['score'] ?></td>
									        <?php endforeach; ?>
									        <?php for ($i = count($diemth); $i < 3; $i++): ?>
									            <td></td>
									        <?php endfor; ?>
									    <?php elseif (count($diemth) == 0): ?>
									        <?php for ($i = 0; $i < 3; $i++): ?>
									            <td></td>
									        <?php endfor; ?>
									    <?php endif; ?>
									    <td <?= $diemck <= 5 ? 'style="color: red;"' : '' ?>><?= $diemck ?></td>
									   
									    <td><?= round($dtbm, 2) ?></td>
									</tr>


					<?php }?>
					</tr>
					<th colspan="20" class="text-dark text-end">Điểm trung binh học kì <?=$value['name']?>: </th>
					<?php $dthktb=0; $dthktb=$dthk/$c;?>
					<th class="text-dark text-center"><?=round($dthktb, 2)?></th></tr>


			</tbody>
		<?php }?>
	</table>

	</div>
	<nav class="d-flex justify-content-between align-items-center paginations" aria-label="Page navigation">
		<?=$page?>
	</nav>
	</div>
	</div>

	</div>
<?php } ?>
<?php if($router['1']=='schedule_view'){?>
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
				<div><h4>Thời khóa biểu </h4>
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
						<li class="breadcrumb-item active" aria-current="page">Sơ đồ lớp</li>
					</ol></div>	
				</div>
			</nav>
	<div class="card card-custom">
		<div class="card-body">
			<div class="pjax-content-load ">
				<div class="table-responsive rounded-3">
					<table class="table table-bordered table-striped table-hover align-middle ">
						<thead>
							<tr class="text-center " style="background-color: #c9c9c9b5; ">
								<th class="text-dark"></th>
								<th class="text-dark" style="width: 5%;">Tiết</th>
								<?php foreach($day as $days){?>
								<th class="text-dark"><?=$days['name']?></th>
								<?php }?>
							</tr>
						</thead>
						<tbody >
							<tr>
								<td rowspan="6" class="fw-bold text-center">Sáng</td>
							</tr>
							<tr class="text-center">
								<td> 1</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>	
							</tr>
							<tr class="text-center">
								<td> 2</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
							</tr>
							<tr class="text-center">
								<td> 3</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
							</tr>

							<tr class="text-center">
								<td> 4</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
							</tr>

							<tr class="text-center">
								<td> 5</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
							</tr>
							<tr>
								<td colspan="8"></td>
							</tr>
							<tr>
								<td rowspan="6" class="fw-bold text-center">Chiều</td>
							</tr>
							<tr class="text-center">
								<td> 6</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>	
							</tr>
							<tr class="text-center">
								<td> 7</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
							</tr>
							<tr class="text-center">
								<td> 8</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
							</tr>

							<tr class="text-center">
								<td> 9</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
							</tr>

							<tr class="text-center">
								<td> 10</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
							</tr>
							<tr>
								<td colspan="8"></td>
							</tr>
							<tr>
								<td rowspan="6" class="fw-bold text-center">Tối</td>
							</tr>
							<tr class="text-center">
								<td> 11</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>	
							</tr>
							<tr class="text-center">
								<td> 12</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
							</tr>
							<tr class="text-center">
								<td> 13</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
							</tr>

							<tr class="text-center">
								<td> 14</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
							</tr>

							<tr class="text-center">
								<td> 15</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
								<td>Hóa học</td>
							</tr>



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
<?php if($router['1']=='typescore'){?>
		<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
			<div class="">
				<h4><?=$lang['loai-diem']?></h4>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
					<li class="breadcrumb-item active" aria-current="page">Lớp & Học vụ</li>
				</ol>
			</div>
		</nav>
		<?php if($jatbi->permission('typescore.add','button')==true || $jatbi->permission('typescore.delete','button')==true){?>
			<div class="fixed-action-btn">
				<a class="btn btn-large btn-primary rounded-circle">
					<i class="fas fa-bars" aria-hidden="true"></i>
				</a>
				<ul>
					<?php if($jatbi->permission('typescore.delete','button')==true){?>
						<li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/class-academic/typescore-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
					<?php }?>
					<?php if($jatbi->permission('typescore.add','button')==true){?>
						<li><a class="modal-url btn rounded-circle btn-info" data-url="/class-academic/typescore-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
									<?php if($jatbi->permission('typescore.delete','button')==true){?>
										<th width="1%" class="text-center">
											<div class="form-check">
												<input class="form-check-input selectall" type="checkbox" value="" id="all">
												<label class="form-check-label" for="all">
												</label>
											</div>
										</th>
									<?php }?>
									<th width="50"></th>
									<th><?=$lang['id']?></th>
									<th><?=$lang['ten']?></th>	
									<th><?=$lang['he-so']?></th>					        			        					      
									<th><?=$lang['trang-thai']?></th>
									<?php if($jatbi->permission('typescore.edit','button')==true){?>
										<th width="2%"></th>
									<?php }?>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($datas as $data) { ?>
									<tr>
										<?php if($jatbi->permission('typescore.delete','button')==true){?>
											<td class="align-middle">
												<div class="form-check">
													<input class="form-check-input checker" type="checkbox" id="<?=$data['id']?>" name="BOX[<?=$data['id']?>]" value="<?=$data['id']?>">
													<label class="form-check-label" for="<?=$data['id']?>"></label>
												</div>
											</td>
										<?php }?>
										<td></td>

										<td><?=$data['id_type_scores']?></td>
										<td><?=$data['name']?></td>
										<td><?=$data['heso']?></td>


										<td>	
											<div class="form-check form-switch">
												<input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/class-academic/typescore-status/<?=$data['id']?>/">
												<label class="form-check-label" for="status"></label>
											</div>
										</td>
										<?php if($jatbi->permission('typescore.edit','button')==true){?>
											<td>
												<a class="btn btn-sm btn-light modal-url" data-url="/class-academic/typescore-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
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
<?php if($router['1']=='typescore-add' || $router['1']=='typescore-edit'){?>
		<div class="modal fade modal-load" tabindex="-1">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title"><?=$router['1']=='typescore-add'?$lang['them']:$lang['sua']?> <?=$lang['loai-diem']?></h5>
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
										<label><?=$lang['he-so']?><small class="text-danger">*</small></label>
										<input placeholder="<?=$lang['he-so']?>" type="text" name="heso" value="<?=$data['heso']?>" class="form-control">
									</div>
								</div> 		    
								<div class="col-sm-6">		
								<div class="mb-3">
										<label><?=$lang['id']?><small class="text-danger">*</small></label>
										<input placeholder="<?=$lang['id']?>" type="text" name="id_type_scores" value="<?=$data['id_type_scores']?>" class="form-control">
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
<?php if($router['1']=='typescore-delete'){?>
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