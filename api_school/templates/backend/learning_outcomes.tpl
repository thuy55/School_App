
<?php if($router['1']=='school_activities'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['danh-sach-hoat-dong']?></h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
				<li class="breadcrumb-item active" aria-current="page"><?=$lang['cap-nhat-hoc-tap']?></li>
			</ol>
		</div>
	</nav>
	<?php if($jatbi->permission('school_activities.add','button')==true || $jatbi->permission('school_activities.delete','button')==true){?>
		<div class="fixed-action-btn">
			<a class="btn btn-large btn-primary rounded-circle">
				<i class="fas fa-bars" aria-hidden="true"></i>
			</a>
			<ul>
				<?php if($jatbi->permission('school_activities.delete','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/learning_outcomes/school_activities-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
				<?php }?>
				<?php if($jatbi->permission('school_activities.add','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-info" data-url="/learning_outcomes/school_activities-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
								<?php if($jatbi->permission('school_activities.delete','button')==true){?>
									<th width="1%" class="text-center">
										<div class="form-check">
											<input class="form-check-input selectall" type="checkbox" value="" id="all">
											<label class="form-check-label" for="all">
											</label>
										</div>
									</th>
								<?php }?>
								<th width="50"></th>
								<th><?= $lang['ten-hoat-dong']?></th>	
								<th><?= $lang['ngay-lap']?></th>
								<th><?= $lang['mo-ta']?></th>	        			        					      
								<th><?=$lang['trang-thai']?></th>
								<?php if($jatbi->permission('school_activities.edit','button')==true){?>
									<th width="2%"></th>
								<?php }?>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($datas as $data) { ?>
								<tr>
									<?php if($jatbi->permission('school_activities.delete','button')==true){?>
										<td class="align-middle">
											<div class="form-check">
												<input class="form-check-input checker" type="checkbox" id="<?=$data['id']?>" name="BOX[<?=$data['id']?>]" value="<?=$data['id']?>">
												<label class="form-check-label" for="<?=$data['id']?>"></label>
											</div>
										</td>
									<?php }?>
									<td></td>


									<td><?=$data['name']?></td>
									<td><?=date("d/m/Y", strtotime($data['date']))?></td>
									<td><?=$data['description']?></td>
									<td>	
										<div class="form-check form-switch">
											<input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/learning_outcomes/school_activities-status/<?=$data['id']?>/">
											<label class="form-check-label" for="status"></label>
										</div>
									</td>
									<?php if($jatbi->permission('school_activities.edit','button')==true){?>
										<td>
											<a class="btn btn-sm btn-light modal-url" data-url="/learning_outcomes/school_activities-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
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
<?php if($router['1']=='school_activities-add' || $router['1']=='school_activities-edit'){?>
	<div class="modal fade modal-load" tabindex="-1">
	  <div class="modal-dialog modal-lg" >
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title"><?=$router['1']=='school_activities-add'?$lang['them']:$lang['sua']?><?= $lang['hoat-dong-tin-tuc']?></h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
		      <div class="modal-body row">
		      	<div class="col-sm-12">
		      		<div class="form-group row">
		        		<label class="col-sm-12"><?=$lang['ten']?> <small class="text-danger">*</small></label>
		        		<div class="col-sm-12">
					    	<input placeholder="<?=$lang['ten']?>" type="text" name="name" value="<?=htmlspecialchars($data['name'])?>" class="form-control">
					    </div>
				    </div>
				    <div class="form-group row">
		        		<label class="col-sm-12"><?=$lang['noi-dung-ngan']?></label>
		        		<div class="col-sm-12">
					    	<textarea placeholder="<?=$lang['noi-dung-ngan']?>" name="description" class="form-control" style="height: 100px;"><?=$data['description']?></textarea>
					    </div>
				    </div>
				    <div class="form-group row">
		        		<label class="col-sm-12"><?=$lang['noi-dung']?></label>
		        		<div class="col-sm-12">
					    	<textarea placeholder="<?=$lang['noi-dung']?>" name="content" class="form-control tinymce" style="height: 200px;"><?=$data['content']?></textarea>
					    </div>
				    </div>
			    </div>
			    <div class="col-sm-12">
			    	<div class="form-group row">
		        		
		        		<div class="mb-3">
									<label><?=$lang['hinh-dai-dien']?></label>
									<input type="file" class="form-control" name="avatar" value="<?=$data['avatar']?>">
								</div>
				    </div>
				    <div class="form-group row">
		        		<label class="col-sm-12"><?=$lang['trang-thai']?> <small class="text-danger">*</small></label>
		        		<div class="col-sm-12">
					    	<select name="status" class="select2 form-control" style="width:100%">
						      <option value="A" <?=($data['status']=='A'?'selected':'')?>><?=$lang['kich-hoat']?></option>
						      <option value="D" <?=($data['status']=='D'?'selected':'')?>><?=$lang['khong-kich-hoat']?></option>
						    </select>
					    </div>
				    </div>
			    </div>
		        
		       <div class="col-sm-12 ">
			        <div class="progress" style="display: none">
						<div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" style="width: 0%"></div>
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
<?php if($router['1']=='school_activities-delete'){?>
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
<?php if($router['1']=='teacher_announcement'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['danh-sach-thong-bao-giao-viên']?></h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
				<li class="breadcrumb-item active" aria-current="page"><?=$lang['cap-nhat-hoc-tap']?></li>
			</ol>
		</div>
	</nav>
	<?php if($jatbi->permission('teacher_announcement.add','button')==true || $jatbi->permission('teacher_announcement.delete','button')==true){?>
		<div class="fixed-action-btn">
			<a class="btn btn-large btn-primary rounded-circle">
				<i class="fas fa-bars" aria-hidden="true"></i>
			</a>
			<ul>
				<?php if($jatbi->permission('teacher_announcement.delete','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/learning_outcomes/teacher_announcement-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
				<?php }?>
				<?php if($jatbi->permission('teacher_announcement.add','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-info" data-url="/learning_outcomes/teacher_announcement-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
								<?php if($jatbi->permission('teacher_announcement.delete','button')==true){?>
									<th width="1%" class="text-center">
										<div class="form-check">
											<input class="form-check-input selectall" type="checkbox" value="" id="all">
											<label class="form-check-label" for="all">
											</label>
										</div>
									</th>
								<?php }?>
								<th width="50"></th>
								<th><?= $lang['ten-thong-bao']?></th>	
								<th><?= $lang['ngay-lap']?></th>
								<th><?= $lang['mo-ta']?></th>
								<th><?= $lang['lop']?></th>
								<th><?= $lang['giao-vien']?></th>		        			        					      
								<th><?=$lang['trang-thai']?></th>
								<?php if($jatbi->permission('teacher_announcement.edit','button')==true){?>
									<th width="2%"></th>
								<?php }?>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($datas as $data) { ?>
								<tr>
									<?php if($jatbi->permission('teacher_announcement.delete','button')==true){?>
										<td class="align-middle">
											<div class="form-check">
												<input class="form-check-input checker" type="checkbox" id="<?=$data['id']?>" name="BOX[<?=$data['id']?>]" value="<?=$data['id']?>">
												<label class="form-check-label" for="<?=$data['id']?>"></label>
											</div>
										</td>
									<?php }?>
									<td></td>


									<td><?=$data['name']?></td>
									<td><?=date("d/m/Y", strtotime($data['date']))?></td>
									<td><?=$data['description']?></td>
									<td><?=$database->get("class", "name",["id"=>$database->get("class_diagram", "class",["id"=>$data['class_diagram']])])?></td>
									<td><?=$database->get("teacher", "firstname",["id"=>$data['teacher']])?> <?=$database->get("teacher", "lastname",["id"=>$data['teacher']])?></td>

									<td>	
										<div class="form-check form-switch">
											<input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/learning_outcomes/teacher_announcement-status/<?=$data['id']?>/">
											<label class="form-check-label" for="status"></label>
										</div>
									</td>
									<?php if($jatbi->permission('teacher_announcement.edit','button')==true){?>
										<td>
											<a class="btn btn-sm btn-light modal-url" data-url="/learning_outcomes/teacher_announcement-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
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
<?php if($router['1']=='teacher_announcement-add' || $router['1']=='teacher_announcement-edit'){?>
	<div class="modal fade modal-load" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><?=$router['1']=='teacher_announcement-add'?$lang['them']:$lang['sua']?><?=$lang['thong-bao-giao-vien']?></h5>
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
								
								<div class="form-group row">
					        		<label class="col-sm-12"><?=$lang['noi-dung-ngan']?></label>
					        		<div class="col-sm-12">
								    	<textarea placeholder="<?=$lang['noi-dung-ngan']?>" name="description" class="form-control" style="height: 100px;"><?=$data['description']?></textarea>
								    </div>
							    </div>	

								<div class="mb-3">
									<label><?= $lang['lop']?><small class="text-danger">*</small></label>
									<select name="class" class="select2 form-control" style="width:100%">
										<option value="" disabled selected><?= $lang['lop']?></option>
										<?php foreach ($class as $class) { ?>
											<option value="<?=$class['id']?>"  <?=($data['class_diagram']==$class['id']?'selected':'')?>><?=$database->get("class","name",["id"=> $class['class']])?></option>
										<?php } ?>
									</select>
								</div>	
								<div class="mb-3">
									<label><?= $lang['giao-vien']?><small class="text-danger">*</small></label>
									<select name="teacher" class="select2 form-control" style="width:100%">
										<option value="" disabled selected><?= $lang['giao-vien']?></option>
										<?php foreach ($teacher as $teacher ) { ?>
											<option value="<?=$teacher['id']?>"  <?=($data['teacher']==$teacher['id']?'selected':'')?>><?=$teacher['fullname']?></option>
										<?php } ?>
									</select>
								</div>		        	
							</div> 		    
							<div class="col-sm-6">
								<div class="form-group row">
					        		<label class="col-sm-12"><?=$lang['noi-dung']?></label>
					        		<div class="col-sm-12">
								    	<textarea placeholder="<?=$lang['noi-dung']?>" name="content" class="form-control" style="height: 100px;"><?=$data['content']?></textarea>
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
<?php if($router['1']=='teacher_announcement-delete'){?>
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
<?php if($router['1']=='school_announcement'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['danh-sach-thong-bao-truong']?></h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
				<li class="breadcrumb-item active" aria-current="page"><?=$lang['cap-nhat-hoc-tap']?></li>
			</ol>
		</div>
	</nav>
	<?php if($jatbi->permission('school_announcement.add','button')==true || $jatbi->permission('teacher_announcement.delete','button')==true){?>
		<div class="fixed-action-btn">
			<a class="btn btn-large btn-primary rounded-circle">
				<i class="fas fa-bars" aria-hidden="true"></i>
			</a>
			<ul>
				<?php if($jatbi->permission('school_announcement.delete','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/learning_outcomes/school_announcement-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
				<?php }?>
				<?php if($jatbi->permission('school_announcement.add','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-info" data-url="/learning_outcomes/school_announcement-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
								<?php if($jatbi->permission('school_announcement.delete','button')==true){?>
									<th width="1%" class="text-center">
										<div class="form-check">
											<input class="form-check-input selectall" type="checkbox" value="" id="all">
											<label class="form-check-label" for="all">
											</label>
										</div>
									</th>
								<?php }?>
								<th width="50"></th>
								<th><?= $lang['ten-thong-bao']?></th>	
								<th><?= $lang['ngay-lap']?></th>
								<th><?= $lang['mo-ta']?></th>		        			        					    
								<th><?=$lang['trang-thai']?></th>
								<?php if($jatbi->permission('school_announcement.edit','button')==true){?>
									<th width="2%"></th>
								<?php }?>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($datas as $data) { ?>
								<tr>
									<?php if($jatbi->permission('school_announcement.delete','button')==true){?>
										<td class="align-middle">
											<div class="form-check">
												<input class="form-check-input checker" type="checkbox" id="<?=$data['id']?>" name="BOX[<?=$data['id']?>]" value="<?=$data['id']?>">
												<label class="form-check-label" for="<?=$data['id']?>"></label>
											</div>
										</td>
									<?php }?>
									<td></td>


									<td><?=$data['name']?></td>
									<td><?=date("d/m/Y", strtotime($data['date']))?></td>
									<td><?=$data['description']?></td>
									<td>	
										<div class="form-check form-switch">
											<input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/learning_outcomes/school_announcement-status/<?=$data['id']?>/">
											<label class="form-check-label" for="status"></label>
										</div>
									</td>
									<?php if($jatbi->permission('school_announcement.edit','button')==true){?>
										<td>
											<a class="btn btn-sm btn-light modal-url" data-url="/learning_outcomes/school_announcement-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
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
<?php if($router['1']=='school_announcement-add' || $router['1']=='school_announcement-edit'){?>
	<div class="modal fade modal-load" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><?=$router['1']=='school_announcement-add'?$lang['them']:$lang['sua']?><?=$lang['thong-bao-cua-truong']?></h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
		      <div class="modal-body row">
		      	<div class="col-sm-12">
		      		<div class="form-group row">
		        		<label class="col-sm-12"><?=$lang['ten']?> <small class="text-danger">*</small></label>
		        		<div class="col-sm-12">
					    	<input placeholder="<?=$lang['ten']?>" type="text" name="name" value="<?=htmlspecialchars($data['name'])?>" class="form-control">
					    </div>
				    </div>
				    <div class="form-group row">
		        		<label class="col-sm-12"><?=$lang['noi-dung-ngan']?></label>
		        		<div class="col-sm-12">
					    	<textarea placeholder="<?=$lang['noi-dung-ngan']?>" name="description" class="form-control" style="height: 100px;"><?=$data['description']?></textarea>
					    </div>
				    </div>
				    <div class="form-group row">
		        		<label class="col-sm-12"><?=$lang['noi-dung']?></label>
		        		<div class="col-sm-12">
					    	<textarea placeholder="<?=$lang['noi-dung']?>" name="content" class="form-control tinymce" style="height: 200px;"><?=$data['content']?></textarea>
					    </div>
				    </div>
			    </div>
			    <div class="col-sm-12">
			    	<div class="form-group row">
		        		
		        		<div class="mb-3">
									<label><?=$lang['hinh-dai-dien']?></label>
									<input type="file" class="form-control" name="avatar" value="<?=$data['avatar']?>">
								</div>
				    </div>
				    <div class="form-group row">
		        		<label class="col-sm-12"><?=$lang['trang-thai']?> <small class="text-danger">*</small></label>
		        		<div class="col-sm-12">
					    	<select name="status" class="select2 form-control" style="width:100%">
						      <option value="A" <?=($data['status']=='A'?'selected':'')?>><?=$lang['kich-hoat']?></option>
						      <option value="D" <?=($data['status']=='D'?'selected':'')?>><?=$lang['khong-kich-hoat']?></option>
						    </select>
					    </div>
				    </div>
			    </div>
		        
		       <div class="col-sm-12 ">
			        <div class="progress" style="display: none">
						<div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" style="width: 0%"></div>
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
<?php if($router['1']=='school_announcement-delete'){?>
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
<?php if($router['1']=='opinion'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['gop-y-cua-phu-huynh']?></h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
				<li class="breadcrumb-item active" aria-current="page"><?=$lang['cap-nhat-hoc-tap']?></li>
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
								<th><?= $lang['ngay']?></th>	
								<th><?= $lang['tieu-de']?></th>
								<th><?= $lang['noi-dung']?></th>
								<th><?= $lang['phu-huynh']?></th>
								<th><?= $lang['chi-tiet']?></th>					       
							</tr>
						</thead>
						<tbody>
							<?php foreach ($datas as $data) { ?>
								<tr>

									<td></td>
									<td><?=date("d/m/Y", strtotime($data['date']))?></td>	
									<td><?=$data['title']?></td>
									<td><?=$jatbi->cut_string($data['content'],100)?></td>				            	            
									<td><?=$database->get("parent", "name",["id"=>$data['parent']])?></td>


									<td>
										<a class="btn btn-sm btn-light modal-url" data-url="/learning_outcomes/opinion-edit/<?=$data['id']?>/"><i class="fas fa-eye" aria-hidden="true"></i></a>
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
<?php if($router['1']=='opinion-edit'){?>
	<div class="modal fade modal-load" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><?=$lang['chi-tiet-gop-y']?></h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
					<div class="modal-body">
						<div class="row">
							<div class="col-sm-12">
								<div class="mb-3">
									<label><?= $lang['ngay']?><small class="text-danger">*</small></label>
									<input placeholder="<?= $lang['ngay']?>" type="date" name="date" value="<?=$data['date']?>" class="form-control">
								</div>				    				    	
							</div> 
							<div class="mb-3">
								<label><?= $lang['tieu-de']?><small class="text-danger">*</small></label>
								<input placeholder="<?= $lang['tieu-de']?>" type="text" name="title" value="<?=$data['title']?>" class="form-control">
							</div>				    				    	
						</div> 
						<div class="mb-3">
							<label><?= $lang['noi-dung']?><small class="text-danger">*</small></label>
							<textarea style="height: 400px;" placeholder="<?= $lang['noi-dung']?>"  name="content"  class="form-control"><?=$data['content']?></textarea>
						</div>	
						<div class="mb-3">
							<label><?= $lang['phu-huynh']?><small class="text-danger">*</small></label>
							<input placeholder="<?= $lang['phu-huynh']?>" type="text" name="content" value="<?=$database->get("parent", "name",["id"=>$data['parent']])?>" class="form-control">
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