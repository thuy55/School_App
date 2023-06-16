<?php if($router['1']=='health'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['danh-sach-tinh-hinh-suc-khoe']?></h4>
			<ol class="breadcrumb">
			    <li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
			    <li class="breadcrumb-item active" aria-current="page">Lớp & Học vụ</li>
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
	      <li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/health_student_teacher/health-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
	      <?php }?>
	      <?php if($jatbi->permission('health.add','button')==true){?>
	      <li><a class="modal-url btn rounded-circle btn-info" data-url="/health_student_teacher/health-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
								  <input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/health_student_teacher/health-status/<?=$data['id']?>/">
								  <label class="form-check-label" for="status"></label>
								</div>
				            </td>
				            <?php if($jatbi->permission('health.edit','button')==true){?>
				            	<td>
				            		<a class="btn btn-sm btn-light modal-url" data-url="/health_student_teacher/health-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
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
						      	<option value="<?=$students['id']?>"  <?=($data['students']==$students['id']?'selected':'')?>><?=$students['firstname']?> <?=$students['lastname']?></option>
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
			    <li class="breadcrumb-item active" aria-current="page">Lớp & Học vụ</li>
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
	      <li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/health_student_teacher/vaccination-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
	      <?php }?>
	      <?php if($jatbi->permission('vaccination.add','button')==true){?>
	      <li><a class="modal-url btn rounded-circle btn-info" data-url="/health_student_teacher/vaccination-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
								  <input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/health_student_teacher/vaccination-status/<?=$data['id']?>/">
								  <label class="form-check-label" for="status"></label>
								</div>
				            </td>
				            <?php if($jatbi->permission('vaccination.edit','button')==true){?>
				            	<td>
				            		<a class="btn btn-sm btn-light modal-url" data-url="/health_student_teacher/vaccination-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
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
						      	<option value="<?=$students['id']?>"  <?=($data['students']==$students['id']?'selected':'')?>><?=$students['firstname']?> <?=$students['lastname']?></option>
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
<?php if($router['1']=='health_teacher'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['danh-sach-tinh-hinh-suc-khoe']?></h4>
			<ol class="breadcrumb">
			    <li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
			    <li class="breadcrumb-item active" aria-current="page">Lớp & Học vụ</li>
			</ol>
		</div>
	</nav>
	<?php if($jatbi->permission('health_teacher.add','button')==true || $jatbi->permission('health_teacher.delete','button')==true){?>
	<div class="fixed-action-btn">
	    <a class="btn btn-large btn-primary rounded-circle">
	      <i class="fas fa-bars" aria-hidden="true"></i>
	    </a>
	    <ul>
	      <?php if($jatbi->permission('health_teacher.delete','button')==true){?>
	      <li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/health_student_teacher/health_teacher-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
	      <?php }?>
	      <?php if($jatbi->permission('health_teacher.add','button')==true){?>
	      <li><a class="modal-url btn rounded-circle btn-info" data-url="/health_student_teacher/health_teacher-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
					        <?php if($jatbi->permission('health_teacher.delete','button')==true){?>
					      	<th width="1%" class="text-center">
								<div class="form-check">
								  <input class="form-check-input selectall" type="checkbox" value="" id="all">
								  <label class="form-check-label" for="all">
								  </label>
								</div>
					      	</th>
					      	<?php }?>
					        <th width="50"></th>
					        <th><?=$lang['ten-giao-vien']?></th>
					        <th><?=$lang['ngay-kham']?></th>
					        <th><?=$lang['nhip-tim']?> (Nhịp/phút)</th>					        			        	
					        <th><?=$lang['huyet-ap']?> (mmHg)</th>     
					        <th><?=$lang['nhiet-do']?> (độ C)</th>
					        <th><?=$lang['can-nang']?> (KG)</th>
					        <th><?=$lang['chieu-cao']?> (CM)</th>
					        <th><?=$lang['tien-su']?></th>


					        <th><?=$lang['trang-thai']?></th>
					        <?php if($jatbi->permission('health_teacher.edit','button')==true){?>
					        <th width="2%"></th>
					        <?php }?>
					    </tr>
					  </thead>
					  <tbody>
					    <?php foreach ($datas as $data) { ?>
							<tr>
				            <?php if($jatbi->permission('health_teacher.delete','button')==true){?>
				            <td class="align-middle">
			            		<div class="form-check">
									<input class="form-check-input checker" type="checkbox" id="<?=$data['id']?>" name="BOX[<?=$data['id']?>]" value="<?=$data['id']?>">
									<label class="form-check-label" for="<?=$data['id']?>"></label>
								</div>
				            </td>
				            <?php }?>
				            <td></td>				          				           
				            <td><?=$database->get("teacher", "firstname",["id"=>$data['teacher']])?> <?=$database->get("teacher", "lastname",["id"=>$data['teacher']])?></td>
				            <td><?=date("d/m/Y", strtotime($data['date']))?></td>
				            <td><?=$data['heartbeat']?></td>
				            <td><?=$data['blood_pressure']?></td>
				            <td><?=$data['temperature']?></td>
				            <td><?=$data['weight']?></td>
				            <td><?=$data['height']?></td>
				            <td><?=$data['prehistoric']?></td>

				            <td>	
				            	<div class="form-check form-switch">
								  <input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/health_student_teacher/health_teacher-status/<?=$data['id']?>/">
								  <label class="form-check-label" for="status"></label>
								</div>
				            </td>
				            <?php if($jatbi->permission('health_teacher.edit','button')==true){?>
				            	<td>
				            		<a class="btn btn-sm btn-light modal-url" data-url="/health_student_teacher/health_teacher-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
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
<?php if($router['1']=='health_teacher-add' || $router['1']=='health_teacher-edit'){?>
	<div class="modal fade modal-load" tabindex="-1">
	  <div class="modal-dialog modal-lg">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title"><?=$router['1']=='health-add'?$lang['them']:$lang['sua']?><?=$lang['thong-tin-suc-khoe']?></h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
	      <div class="modal-body">
	      	<div class="row">
		        <div class="col-sm-6">
		        	<div class="mb-3">
		        		<label><?=$lang['ten-giao-vien']?><small class="text-danger">*</small></label>
		        		<select name="teacher" class="select2 form-control" style="width:100%">
						    <option value="" disabled selected><?=$lang['ten-giao-vien']?></option>
						    <?php foreach ($school_teachers as $school_teacher) { 
						    	$teacher = $database->get("teacher", "*",["id"=>$school_teacher['teacher'],"deleted"=> 0,"status"=>'A']);?>
						      	<option value="<?=$teacher['id']?>"  <?=($data['teacher']==$teacher['id']?'selected':'')?>><?=$teacher['firstname']?> <?=$teacher['lastname']?></option>
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
<?php if($router['1']=='health_teacher-delete'){?>
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
<?php if($router['1']=='vaccination_teacher'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['danh-sach-tinh-trang-tiem-vacxin']?></h4>
			<ol class="breadcrumb">
			    <li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
			    <li class="breadcrumb-item active" aria-current="page">Lớp & Học vụ</li>
			</ol>
		</div>
	</nav>
	<?php if($jatbi->permission('vaccination_teacher.add','button')==true || $jatbi->permission('vaccination_teacher.delete','button')==true){?>
	<div class="fixed-action-btn">
	    <a class="btn btn-large btn-primary rounded-circle">
	      <i class="fas fa-bars" aria-hidden="true"></i>
	    </a>
	    <ul>
	      <?php if($jatbi->permission('vaccination_teacher.delete','button')==true){?>
	      <li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/health_student_teacher/vaccination_teacher-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
	      <?php }?>
	      <?php if($jatbi->permission('vaccination_teacher.add','button')==true){?>
	      <li><a class="modal-url btn rounded-circle btn-info" data-url="/health_student_teacher/vaccination_teacher-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
					        <?php if($jatbi->permission('vaccination_teacher.delete','button')==true){?>
					      	<th width="1%" class="text-center">
								<div class="form-check">
								  <input class="form-check-input selectall" type="checkbox" value="" id="all">
								  <label class="form-check-label" for="all">
								  </label>
								</div>
					      	</th>
					      	<?php }?>
					        <th width="50"></th>
					        <th><?=$lang['ten-giao-vien']?></th>
					        <th><?=$lang['ten-vacxin']?></th>
					        <th><?=$lang['loai-vacxin']?></th>						       
					        <th><?=$lang['ngay-tiem']?></th>


					        <th><?=$lang['trang-thai']?></th>
					        <?php if($jatbi->permission('vaccination_teacher.edit','button')==true){?>
					        <th width="2%"></th>
					        <?php }?>
					    </tr>
					  </thead>
					  <tbody>
					    <?php foreach ($datas as $data) { ?>
							<tr>
				            <?php if($jatbi->permission('vaccination_teacher.delete','button')==true){?>
				            <td class="align-middle">
			            		<div class="form-check">
									<input class="form-check-input checker" type="checkbox" id="<?=$data['id']?>" name="BOX[<?=$data['id']?>]" value="<?=$data['id']?>">
									<label class="form-check-label" for="<?=$data['id']?>"></label>
								</div>
				            </td>
				            <?php }?>
				            <td></td>				          				           
				            <td><?=$database->get("teacher", "firstname",["id"=>$data['teacher']])?> <?=$database->get("teacher", "lastname",["id"=>$data['teacher']])?></td>
				            <td><?=$data['name']?></td>
				            <td><?=$data['namevacxin']?></td>
				            <td><?=date("d/m/Y", strtotime($data['date']))?></td>
				            
				            

				            <td>	
				            	<div class="form-check form-switch">
								  <input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/health_student_teacher/vaccination_teacher-status/<?=$data['id']?>/">
								  <label class="form-check-label" for="status"></label>
								</div>
				            </td>
				            <?php if($jatbi->permission('vaccination_teacher.edit','button')==true){?>
				            	<td>
				            		<a class="btn btn-sm btn-light modal-url" data-url="/health_student_teacher/vaccination_teacher-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
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
<?php if($router['1']=='vaccination_teacher-add' || $router['1']=='vaccination_teacher-edit'){?>
	<div class="modal fade modal-load" tabindex="-1">
	  <div class="modal-dialog modal-lg">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title"><?=$router['1']=='vaccination_teacher-add'?$lang['them']:$lang['sua']?><?=$lang['thong-tin-tiem-vacxin']?></h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
	      <div class="modal-body">
	      	<div class="row">
		        <div class="col-sm-6">
		        	<div class="mb-3">
		        		<label><?=$lang['ten-giao-vien']?><small class="text-danger">*</small></label>
		        		<select name="teacher" class="select2 form-control" style="width:100%">
						    <option value="" disabled selected><?=$lang['ten-giao-vien']?></option>
						    <?php foreach ($school_teachers as $school_teacher) { 
						    	$teacher = $database->get("teacher", "*",["id"=>$school_teacher['teacher'],"deleted"=> 0,"status"=>'A']);?>
						      	<option value="<?=$teacher['id']?>"  <?=($data['teacher']==$teacher['id']?'selected':'')?>><?=$teacher['firstname']?> <?=$teacher['lastname']?></option>
						    <?php } ?>
						</select>
						</div>
				    <div class="mb-3">
		        		<label><?=$lang['ten-vacxin']?><small class="text-danger">*</small></label>
					    <input placeholder="<?=$lang['ten-vacxin']?>" type="text" name="name" value="<?=$data['name']?>" class="form-control">
				    </div>
				    <div class="mb-3">
		        		<label><?=$lang['loai-vacxin']?><small class="text-danger">*</small></label>
					    <input placeholder="<?=$lang['loai-vacxin']?>" type="text" name="namevacxin" value="<?=$data['namevacxin']?>" class="form-control">
				    </div>
				    
		        	
				    
				 </div> 		    
		        <div class="col-sm-6">	
		       		  <div class="mb-3">
		        		<label><?=$lang['ngay-tiem']?><small class="text-danger">*</small></label>
					    <input placeholder="<?=$lang['ngay-tiem']?>" type="date" name="date" value="<?=$data['date']?>" class="form-control">
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
<?php if($router['1']=='vaccination_teacher-delete'){?>
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