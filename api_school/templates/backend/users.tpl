<?php if($router['1']=='accounts'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['tai-khoan']?></h4>
			<ol class="breadcrumb">
			    <li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
			    <li class="breadcrumb-item active" aria-current="page"><?=$lang['tai-khoan']?></li>
			</ol>
		</div>
	</nav>
	
	
		<div class="fixed-action-btn">
			<a class="btn btn-large btn-primary rounded-circle">
				<i class="fas fa-bars" aria-hidden="true"></i>
			</a>
			<ul>
				
					<li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/users/accounts-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
				
					<li><a class="modal-url btn rounded-circle btn-info" data-url="/users/accounts-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>

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
					        <th><?=$lang['ho-ten']?></th>
					        <th><?=$lang['loai']?></th>
					        <th><?=$lang['tai-khoan']?></th>
					        <th><?=$lang['email']?></th>
					        <th><?=$lang['nhom-quyen']?></th>
					    
					        <th><?=$lang['trang-thai']?></th>
					        <?php if($jatbi->permission('accounts.edit','button')==true){?>
					        <th width="2%"></th>
					        <?php }?>
					    </tr>
					  </thead>
					  <tbody>
					    <?php foreach ($datas as $data) { ?>
							<tr>
				            <?php if($jatbi->permission('accounts.delete','button')==true){?>
				            <td class="align-middle">
			            		<div class="form-check">
									<input class="form-check-input checker" type="checkbox" id="<?=$data['id']?>" name="BOX[<?=$data['id']?>]" value="<?=$data['id']?>">
									<label class="form-check-label" for="<?=$data['id']?>"></label>
								</div>
				            </td>
				            <?php }?>
				            <td><img src="/<?=$upload['images']['avatar']['url'].$data['avatar']?>" class="border border-light rounded-circle shadow-sm w-100"></td>
				            <td><?=$data['name']?></td>
				            <td>
				            	<?=$data['type']==1?$lang['quan-tri']:$lang['nhan-vien']?>
				            	<small class="d-block"><?=$database->get("personnels","name",["id"=>$data['data']])?></small>
				            </td>
				            <td><?=$data['account']?></td>
				            <td><?=$data['email']?></td>
				            <td><?=$database->get("permission", "name",["id"=>$data['permission']])?></td>
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
<?php if($router['1']=='accounts-add' || $router['1']=='accounts-edit'){?>
	<div class="modal fade modal-load" tabindex="-1">
	  <div class="modal-dialog modal-lg">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title"><?=$router['1']=='accounts-add'?$lang['them']:$lang['sua']?> <?=$lang['tai-khoan']?></h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
	      <div class="modal-body">
	      	<div class="row">
		        <div class="col-sm-6">
				    <div class="mb-3">
		        		<label><?=$lang['loai']?> <small class="text-danger">*</small></label>
		        		<select name="type" class="select2 form-control type-data" style="width:100%">
						    <option value="" disabled selected><?=$lang['loai']?></option>
						    <option value="1"  <?=($data['type']==1?'selected':'')?>><?=$lang['quan-tri']?></option>
						    <option value="2"  <?=($data['type']==2?'selected':'')?>><?=$lang['nhan-vien']?></option>
						</select>
				    </div>
		        	<div class="mb-3">
		        		<label><?=$lang['ho-ten']?> <small class="text-danger">*</small></label>
					    <input placeholder="<?=$lang['ho-ten']?>" type="text" name="name" value="<?=$data['name']?>" class="form-control">
				    </div>
				    <div class="mb-3">
		        		<label><?=$lang['tai-khoan']?> <small class="text-danger">*</small></label>
					    <input placeholder="<?=$lang['tai-khoan']?>" type="text" name="account" value="<?=$data['account']?>" class="form-control">
				    </div>
				    <div class="mb-3">
		        		<label><?=$lang['email']?> <small class="text-danger">*</small></label>
					    <input placeholder="<?=$lang['email']?>" type="email" name="email" value="<?=$data['email']?>" class="form-control">
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
		        		<label><?=$lang['hinh-dai-dien']?></label>
						<input type="file" class="form-control" name="avatar">
				    </div>
				    <div class="mb-3">
		        		<label><?=$lang['sinh-nhat']?></label>
		        		<input placeholder="<?=$lang['sinh-nhat']?>" type="date" name="birthday" value="<?=$data['birthday']?>" class="form-control">
				    </div>
				    <div class="mb-3">
		        		<label><?=$lang['dien-thoai']?></label>
					    <input placeholder="<?=$lang['dien-thoai']?>" type="tel" name="phone" value="<?=$data['phone']?>" class="form-control">
				    </div>
				    <div class="mb-3">
		        		<label ><?=$lang['gioi-tinh']?></label>
				    	<select name="gender" class="select2 form-control" style="width:100%">
						    <option value="" disabled selected><?=$lang['gioi-tinh']?></option>
						    <option value="1"  <?=($data['gender']=='1'?'selected':'')?>><?=$lang['gt-nam']?></option>
						    <option value="2"  <?=($data['gender']=='2'?'selected':'')?>><?=$lang['gt-nu']?></option>
						    <option value="3"  <?=($data['gender']=='3'?'selected':'')?>><?=$lang['gt-khac']?></option>
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
		       <!--  <div class="col-sm-12">
				    <div class="mb-3">
		        		<label><?=$lang['nguoi-quan-ly']?> <small class="text-danger">*</small></label>
		        		<select name="main" class="select2 form-control" style="width:100%">
						    <option value="" disabled selected><?=$lang['nguoi-quan-ly']?></option>
						    <?php foreach ($users as $user) { ?>
						      	<option value="<?=$user['id']?>"  <?=($data['main']==$user['id']?'selected':'')?>><?=$user['name']?></option>
						    <?php } ?>
						</select>
				    </div>
		        </div> -->
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
<?php if($router['1']=='accounts-change'){?>
	<div class="modal fade modal-load" tabindex="-1">
	  <div class="modal-dialog modal-lg">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title"><?=$lang['sua']?> <?=$lang['tai-khoan']?></h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
	      <div class="modal-body">
	      	<div class="row">
		        <div class="col-sm-6">
		        	<div class="mb-3">
		        		<label><?=$lang['ho-ten']?> <small class="text-danger">*</small></label>
					    <input placeholder="<?=$lang['ho-ten']?>" type="text" name="name" value="<?=$data['name']?>" class="form-control">
				    </div>
				    <div class="mb-3">
		        		<label><?=$lang['tai-khoan']?> <small class="text-danger">*</small></label>
					    <input placeholder="<?=$lang['tai-khoan']?>" type="text" value="<?=$data['account']?>" class="form-control" disabled>
				    </div>
				    <div class="mb-3">
		        		<label><?=$lang['email']?> <small class="text-danger">*</small></label>
					    <input placeholder="<?=$lang['email']?>" type="email" value="<?=$data['email']?>" class="form-control" disabled>
				    </div>
				    <div class="mb-3">
		        		<label><?=$lang['mat-khau']?> <small class="text-danger">*</small></label>
					    <input placeholder="<?=$lang['mat-khau']?>" type="password" name="password" value="" class="form-control">
				    </div>
		        </div>
		        <div class="col-sm-6">
		        	<div class="mb-3">
		        		<label><?=$lang['hinh-dai-dien']?></label>
						<input type="file" class="form-control" name="avatar">
				    </div>
				    <div class="mb-3">
		        		<label><?=$lang['sinh-nhat']?></label>
		        		<input placeholder="<?=$lang['sinh-nhat']?>" type="date" name="birthday" value="<?=$data['birthday']?>" class="form-control">
				    </div>
				    <div class="mb-3">
		        		<label><?=$lang['dien-thoai']?></label>
					    <input placeholder="<?=$lang['dien-thoai']?>" type="tel" name="phone" value="<?=$data['phone']?>" class="form-control">
				    </div>
				    <div class="mb-3">
		        		<label ><?=$lang['gioi-tinh']?></label>
				    	<select name="gender" class="select2 form-control" style="width:100%">
						    <option value="" disabled selected><?=$lang['gioi-tinh']?></option>
						    <option value="1"  <?=($data['gender']=='1'?'selected':'')?>><?=$lang['gt-nam']?></option>
						    <option value="2"  <?=($data['gender']=='2'?'selected':'')?>><?=$lang['gt-nu']?></option>
						    <option value="3"  <?=($data['gender']=='3'?'selected':'')?>><?=$lang['gt-khac']?></option>
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
<?php if($router['1']=='accounts-delete'){?>
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
<?php if($router['1']=='permission'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['nhom-quyen']?></h4>
			<ol class="breadcrumb">
			    <li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
			    <li class="breadcrumb-item active" aria-current="page"><?=$lang['nhom-quyen']?></li>
			</ol>
		</div>
	</nav>
	<?php if($jatbi->permission('permission.add','button')==true || $jatbi->permission('permission.delete','button')==true){?>
	<div class="fixed-action-btn">
	    <a class="btn btn-large btn-primary rounded-circle">
	      <i class="fas fa-bars" aria-hidden="true"></i>
	    </a>
	    <ul>
	      <?php if($jatbi->permission('permission.delete','button')==true){?>
	      <li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/users/permission-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
	      <?php }?>
	      <?php if($jatbi->permission('permission.add','button')==true){?>
	      <li><a class="modal-url btn rounded-circle btn-info" data-url="/users/permission-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
					    <div  class="filer-item status">
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
					        <?php if($jatbi->permission('permission.delete','button')==true){?>
					      	<th width="1%" class="text-center">
								<div class="form-check">
								  <input class="form-check-input selectall" type="checkbox" value="" id="all">
								  <label class="form-check-label" for="all">
								  </label>
								</div>
					      	</th>
					      	<?php }?>
					        <th><?=$lang['ten']?></th>
					        <th><?=$lang['cap-do']?></th>
					        <th><?=$lang['trang-thai']?></th>
					        <?php if($jatbi->permission('permission.edit','button')==true){?>
					        <th width="2%"></th>
					        <?php }?>
					    </tr>
					  </thead>
					  <tbody>
					    <?php foreach ($datas as $data) { ?>
							<tr>
				            <?php if($jatbi->permission('permission.delete','button')==true){?>
				            <td class="align-middle">
			            		<div class="form-check">
									<input class="form-check-input checker" type="checkbox" id="<?=$data['id']?>" name="BOX[<?=$data['id']?>]" value="<?=$data['id']?>">
									<label class="form-check-label" for="<?=$data['id']?>"></label>
								</div>
				            </td>
				            <?php }?>
				            <td><?=$data['name']?></td>
				            <td><?=$data['level']?></td>
				            <td>	
				            	<div class="form-check form-switch">
								  <input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/users/permission-status/<?=$data['id']?>/">
								  <label class="form-check-label" for="status"></label>
								</div>
				            </td>
				            <?php if($jatbi->permission('permission.edit','button')==true){?>
				            	<td>
				            		<a class="btn btn-sm btn-light modal-url" data-url="/users/permission-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
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
<?php if($router['1']=='permission-add' || $router['1']=='permission-edit'){?>
	<div class="modal fade modal-load" tabindex="-1">
	  <div class="modal-dialog" style="max-width: 70%;">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title"><?=$router['1']=='permission-add'?$lang['them']:$lang['sua']?> <?=$lang['nhom-quyen']?></h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
	      <div class="modal-body">
	      	<div class="row">
		        <div class="col-sm-12">
		        	<div class="mb-3">
		        		<label><?=$lang['ten']?> <small class="text-danger">*</small></label>
					    <input placeholder="<?=$lang['ten']?>" type="text" name="name" value="<?=$data['name']?>" class="form-control">
				    </div>
		        	<div class="mb-3">
		        		<label><?=$lang['cap-do']?> </label>
					    <input placeholder="<?=$lang['cap-do']?>" type="number" name="level" value="<?=$data['level']?>" class="form-control">
				    </div>
				    <div class="mb-3">
		        		<label><?=$lang['trang-thai']?> <small class="text-danger">*</small></label>
				    	<select name="status" class="select2 form-control" style="width:100%">
					      <option value="A" <?=($data['status']=='A'?'selected':'')?>><?=$lang['kich-hoat']?></option>
					      <option value="D" <?=($data['status']=='D'?'selected':'')?>><?=$lang['khong-kich-hoat']?></option>
					    </select>
				    </div>
		        </div>
		        <div class="col-sm-12">
		        	<div class="card mb-3">
		        		<div class="card-body">
			        		<div class="form-check">
							  <input class="form-check-input permission-all" id="permission-all" type="checkbox">
							  <label class="form-check-label ps-2 pt-1" for="permission-all">
							  	<?=$lang['chon-tat-ca']?>
							  </label>
							</div>
						</div>
					</div>
					<?php foreach ($request_permissions as $key => $value) { ?>
						<?php if($value['main']=='false'){?>
				        	<div class="card mb-3">
				        		<div class="card-header bg-white">
				        			<?=$value['menu'];?>
				        		</div>
				        		<div class="card-body">
				        			<div class="row">
										<?php foreach ($value['permission'] as $pkey => $pdata) { ?>
											<div class="col-sm-3 mb-2">
												<div class="form-check">
												  <input class="form-check-input permission-item" id="<?=$pkey;?>" type="checkbox" name="group[<?=$pkey;?>]" value="<?=$pkey;?>" <?=($vgroup[$pkey]==$pkey?'checked':'')?>>
												  <label class="form-check-label ps-2 pt-1" for="<?=$pkey;?>">
												  	<?=$pdata;?>
												  </label>
												</div>
											</div>
										<?php } ?>
									</div>
				        		</div>
				        	</div>
						<?php } ?>
					<?php } ?>
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
<?php if($router['1']=='permission-delete'){?>
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
<?php if($router['1']=='my-accounts'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['nhan-vien']?>: <?=$data['name']?></h4>
			<ol class="breadcrumb">
			    <li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
			    <li class="breadcrumb-item active" aria-current="page"><?=$lang['nhan-vien']?>: <?=$data['name']?></li>
			</ol>
		</div>
	</nav>
	<div class="row">
		<div class="col-lg-12">
			<div class="card card-custom mb-4">
				<div class="card-body pb-0">
					<div class="row">
						<div class="col-lg-12">
							<div class="row justify-content-between align-items-center">
								<div class="col-lg-6">
									<h6 class="fw-bold mb-0"><?=$data['name']?></h6>
								</div>
								<div class="col-lg-6 text-end">
									<?php if($data['status']!=3 && count($details)>0){?>
										<a href="#!" class="modal-url btn btn-<?=$task_status[$data['status']]['color']?>" data-url="/works/tasks-status/<?=$data['id']?>/"><?=$task_status[$data['status']]['name']?></a>
									<?php } else { ?>
										<span class="btn btn-<?=$task_status[$data['status']]['color']?>"><?=$task_status[$data['status']]['name']?></span>
									<?php } ?>
								</div>
								<div class="col-lg-12">
									<p class="text-muted mb-3"><?=$data['content']?></p>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-3">
									<div class="d-flex justify-content-start align-items-center">
										<div class="bg-light border bg-opacity-25 p-2 rounded-3 me-2 text-center" style="width: 30px;">
											<i class="far fa-star"></i>
										</div>
										<div>
											<small class="text-muted fst-italic"><?=$lang['gioi-tinh']?></small>
											<p class="fw-bold mb-1"><?=$jatbi->gender($data['gender'])?></p>
										</div>
									</div>
								</div>
								<div class="col-lg-3">
									<div class="d-flex justify-content-start align-items-center">
										<div class="bg-light border bg-opacity-25 p-2 rounded-3 me-2 text-center" style="width: 30px;">
											<i class="far fa-star"></i>
										</div>
										<div>
											<small class="text-muted fst-italic"><?=$lang['ngay-sinh']?></small>
											<p class="fw-bold mb-1"><?=date($setting['site_date'],strtotime($data['birthday']))?></p>
										</div>
									</div>
								</div>
								<div class="col-lg-3">
									<div class="d-flex justify-content-start align-items-center">
										<div class="bg-light border bg-opacity-25 p-2 rounded-3 me-2 text-center" style="width: 30px;">
											<i class="far fa-star"></i>
										</div>
										<div>
											<small class="text-muted fst-italic"><?=$lang['dien-thoai']?></small>
											<p class="fw-bold mb-1"><?=$data['phone']?></p>
										</div>
									</div>
								</div>
								<div class="col-lg-3">
									<div class="d-flex justify-content-start align-items-center">
										<div class="bg-light border bg-opacity-25 p-2 rounded-3 me-2 text-center" style="width: 30px;">
											<i class="far fa-star"></i>
										</div>
										<div>
											<small class="text-muted fst-italic"><?=$lang['email']?></small>
											<p class="fw-bold mb-1"><?=$data['email']?></p>
										</div>
									</div>
								</div>
								<?php if($data['projects']>0){?>
								<div class="col-lg-3">
									<div class="d-flex justify-content-start align-items-center">
										<div class="bg-light border bg-opacity-25 p-2 rounded-3 me-2 text-center" style="width: 30px;">
											<i class="fas fa-layer-group"></i>
										</div>
										<div>
											<small class="text-muted fst-italic"><?=$lang['du-an']?></small>
											<p class="fw-bold mb-1">
												<a href="/projects/projects-views/<?=$data['projects']?>/" class="pjax-load">
												<?=$database->get("projects","code",["id"=>$data['projects']])?>
												</a>
											</p>
										</div>
									</div>
								</div>
								<?php } ?>
							</div>
						</div>
					</div>
					<div class="nav-scroller projects-bar py-1 border-top mt-3">
					    <nav class="nav d-flex justify-content-start">
					      <a class="p-2 nav-link pjax-load <?=$router['2']==''?'active':''?>" href="/users/my-accounts/"><?=$lang['tong-quan']?></a>
					      <a class="p-2 nav-link pjax-load <?=$router['2']=='infomation'?'active':''?>" href="/users/my-accounts/infomation/"><?=$lang['thong-tin']?></a>
					      <a class="p-2 nav-link pjax-load <?=$router['2']=='furlough'?'active':''?>" href="/users/my-accounts/furlough/"><?=$lang['nghi-phep']?></a>
					      <a class="p-2 nav-link pjax-load <?=$router['2']=='reward'?'active':''?>" href="/users/my-accounts/reward/"><?=$lang['khen-thuong-ki-luat']?></a>
					      <a class="p-2 nav-link pjax-load  <?=$router['2']=='logs'?'active':''?>" href="/users/my-accounts/logs/"><?=$lang['nhat-ky']?></a>
					    </nav>
					  </div>
				</div>
			</div>
		</div>
	</div>
	<div class="pjax-content-load">
		<?php if($router['2']=='infomation'){?>
			<div class="row">
				<div class="col-md-3">
					<div class="card card-custom">
						<div class="card-body">
							<table class="table">
								<tr>
									<td colspan="2">
										<img src="<?=$setting['site_url'].$upload['images']['personnels']['url'].'thumb/'.$data['images']?>" class="w-100 rounded-3 p-3 border-3 border-white shadow mb-3">
									</td>
								</tr>
								<tr>
									<td class="fw-bold text-nowrap"><?=$lang['ho-ten']?></td>
									<td><?=$data['name']?></td>
								</tr>
								<tr>
									<td class="fw-bold text-nowrap"><?=$lang['ngay-sinh']?></td>
									<td><?=date($setting['site_date'],strtotime($data['birthday']))?></td>
								</tr>
								<tr>
									<td class="fw-bold text-nowrap"><?=$lang['gioi-tinh']?></td>
									<td><?=$jatbi->gender($data['gender'])?></td>
								</tr>
								<tr>
									<td class="fw-bold text-nowrap"><?=$lang['dien-thoai']?></td>
									<td><?=$data['phone']?></td>
								</tr>
								<tr>
									<td class="fw-bold text-nowrap"><?=$lang['email']?></td>
									<td><?=$data['email']?></td>
								</tr>
								<tr>
									<td class="fw-bold text-nowrap"><?=$lang['loai-giay-to']?></td>
									<td><?=$idtypes[$data['idtype']]['name']?></td>
								</tr>
								<tr>
									<td class="fw-bold text-nowrap"><?=$lang['so-giay-to']?></td>
									<td><?=$data['idcode']?></td>
								</tr>
								<tr>
									<td class="fw-bold text-nowrap"><?=$lang['ngay-cap']?></td>
									<td><?=$data['iddate']?></td>
								</tr>
								<tr>
									<td class="fw-bold text-nowrap"><?=$lang['noi-cap']?></td>
									<td><?=$data['idplace']?></td>
								</tr>
								<tr>
									<td class="fw-bold text-nowrap"><?=$lang['quoc-tich']?></td>
									<td><?=$data['nationality']?></td>
								</tr>
								<tr>
									<td class="fw-bold text-nowrap"><?=$lang['dan-toc']?></td>
									<td><?=$data['nation']?></td>
								</tr>
								<tr>
									<td class="fw-bold text-nowrap"><?=$lang['dia-chi-lien-lac']?></td>
									<td>
										<?=$data['address']?>
										<?=$data['ward']==''?'':', '.$database->get("ward","name",["id"=>$data['ward']])?>
										<?=$data['district']==''?'':', '.$database->get("district","name",["id"=>$data['district']])?>
										<?=$data['province']==''?'':', '.$database->get("province","name",["id"=>$data['province']])?>
									</td>
								</tr>
								<tr>
									<td class="fw-bold text-nowrap"><?=$lang['dia-chi-thuong-tru']?></td>
									<td>
										<?=$data['permanent_address']?>
										<?=$data['permanent_ward']==''?'':', '.$database->get("ward","name",["id"=>$data['permanent_ward']])?>
										<?=$data['permanent_district']==''?'':', '.$database->get("district","name",["id"=>$data['permanent_district']])?>
										<?=$data['permanent_province']==''?'':', '.$database->get("province","name",["id"=>$data['permanent_province']])?>
									</td>
								</tr>
								<tr>
									<td class="fw-bold text-nowrap"><?=$lang['ghi-chu']?></td>
									<td><?=$data['name']?></td>
								</tr>
							</table>
						</div>
					</div>
				</div>
				<div class="col-md-9">
					<div class="card card-custom mb-3">
						<div class="card-header bg-white d-flex justify-content-between align-items-center">
							<h5 class="mb-0"><?=$lang['hop-dong-lao-dong']?></h5>
							<div class="">
								<a class="btn btn-info modal-url" data-url="/hrm/personnels-salary-logs/<?=$data['id']?>/"><?=$lang['lich-su-luong']?></a>
								<?php if($jatbi->permission('contract.delete','button')==true){?>
									<a class="modal-url btn btn-danger" data-array="true" data-url="/hrm/contract-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a>
								<?php } ?>
								<?php if($jatbi->permission('contract.add','button')==true){?>
									<a class="btn btn-primary modal-url" data-url="/hrm/contract-add/<?=$data['id']?>/"><i class="fa fa-plus"></i></a>
								<?php } ?>
							</div>
						</div>
						<div class="card-body">
							<div class="table-responsive">
					   			<table class="table table-striped table-hover align-middle">
								  <thead>
								    <tr>
								        <th><?=$lang['loai-hop-dong']?></th>
								        <th><?=$lang['so-hop-dong']?></th>
								        <th><?=$lang['cong-viec']?></th>
								        <th><?=$lang['luong-co-ban']?></th>
								        <th><?=$lang['thoi-han-hop-dong']?></th>
								        <th><?=$lang['con-lai']?></th>
								        <th><?=$lang['ngay-lam-viec']?></th>
								        <th width="2%"></th>
								    </tr>
								  </thead>
								  <tbody>
								    <?php foreach ($contracts as $contract) { ?>
										<tr>
							            <td><?=$personnels_contracts[$contract['type']]['name']?></td>
							            <td><?=$contract['code']?></td>
							            <td><?=$database->get("offices","name",["id"=>$contract['offices']])?></td>
							            <td><?=number_format($contract['salary'])?></td>
							            <td><?=$contract['duration']?> <?=$lang['thang']?></td>
							            <td>
							            	<?=$jatbi->count_date(date("Y-m-d"),date("Y-m-d",strtotime(date("Y-m-d", strtotime($contract['date_contract']))." +".$contract['duration']." month")))?>
							            </td>
							            <td><?=date($setting['site_date'],strtotime($contract['workday']))?></td>
						            	<td>
						            		<a class="btn btn-sm btn-light modal-url" data-url="/hrm/contract-views/<?=$contract['id']?>/"><i class="fas fa-eye" aria-hidden="true"></i></a>
						            	</td>
								      </tr>
							    	<?php } ?>
								  </tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="card card-custom mb-3">
						<div class="card-header bg-white d-flex justify-content-between align-items-center">
							<h5 class="mb-0"><?=$lang['bao-hiem']?></h5>
							<div class="">
								<?php if($jatbi->permission('insurrance.delete','button')==true){?>
								<a class="modal-url btn btn-danger" data-array="true" data-url="/hrm/insurrance-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a>
								<?php } ?>
								<?php if($jatbi->permission('insurrance.delete','button')==true){?>
								<a class="btn btn-primary modal-url" data-url="/hrm/insurrance-add/<?=$data['id']?>/"><i class="fa fa-plus"></i></a>
								<?php } ?>
							</div>
						</div>
						<div class="card-body">
							<div class="table-responsive">
					   			<table class="table table-striped table-hover align-middle">
								  <thead>
								    <tr>
								        <th><?=$lang['so-tien']?></th>
								        <th><?=$lang['so-bao-hiem-xa-hoi']?></th>
								        <th><?=$lang['ngay-cap-bao-hiem-xa-hoi']?></th>
								        <th><?=$lang['noi-cap-bao-hiem-xa-hoi']?></th>
								        <th><?=$lang['so-bao-hiem-y-te']?></th>
								        <th><?=$lang['ngay-cap-bao-hiem-y-te']?></th>
								        <th><?=$lang['noi-cap-bao-hiem-y-te']?></th>
								        <th><?=$lang['ngay']?></th>
								        <th width="2%"></th>
								    </tr>
								  </thead>
								  <tbody>
								    <?php foreach ($insurrances as $insurrance) { ?>
										<tr>
							            <td><?=number_format($insurrance['price'])?></td>
							            <td><?=$insurrance['social']?></td>
							            <td><?=$insurrance['social_date']?></td>
							            <td><?=$insurrance['social_place']?></td>
							            <td><?=$insurrance['health']?></td>
							            <td><?=$insurrance['health_date']?></td>
							            <td><?=$insurrance['health_place']?></td>
							            <td><?=date($setting['site_datetime'],strtotime($insurrance['date']))?></td>
						            	<td>
						            		<a class="btn btn-sm btn-light modal-url" data-url="/hrm/insurrance-views/<?=$insurrance['id']?>/"><i class="fas fa-eye" aria-hidden="true"></i></a>
						            	</td>
								      </tr>
							    	<?php } ?>
								  </tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="card card-custom mb-3">
						<div class="card-header bg-white d-flex justify-content-between align-items-center">
							<h5 class="mb-0"><?=$lang['nhat-ky']?></h5>
						</div>
						<div class="card-body">
							<form method="GET" class="pjax-content mb-4">
								<div class="row">
								    <div class="col-md-4">
										<div class="form-group row">
								    		<label class="col-sm-12 col-form-label"><?=$lang['tu-ngay']?> - <?=$lang['den-ngay']?></label>
								    		<div class="col-sm-12">
								                <input type="text" class="form-control float-right daterange-select" name="date" value="<?=date('d/m/Y',strtotime($date_from))?> - <?=date('d/m/Y',strtotime($date_to))?>">
										    </div>
									    </div>
								    </div>
								    <div class="col-md-2">
										<div class="form-group row">
								    		<label class="col-sm-12 col-form-label"><br></label>
								    		<div class="col-sm-12">
										    	<button class="btn btn-primary"><i class="fas fa-search" aria-hidden="true"></i></button>
										    </div>
									    </div>
								    </div>
								</div>
						    </form>
							<div class="table-responsive">
					   			<table class="table table-striped table-hover align-middle">
								  <thead>
								    <tr>
								        <th width="5%"></th>
								        <th width="5%"></th>
								        <th width="25%"></th>
								        <th width="25%"></th>
								    </tr>
								  </thead>
								  <tbody>
								    <?php foreach ($webhooks as $log) { ?>
							            <td><?=$log['id']?></td>
							            <td>
							            	<img src="<?=$log['images']?>" class="w-100 rounded-10 shadow">
							            </td>
							            <td><?=date($setting['site_datetime'],strtotime($log['date_face']))?> (<?=date($setting['site_datetime'],strtotime($log['date']))?>)</td>
							            <td><?=$log['aliasID']?></td>
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
		<?php if ($router['2']=='furlough') { ?>
			<?php if($jatbi->permission('furlough.add','button')==true || $jatbi->permission('furlough.delete','button')==true){?>
			<div class="fixed-action-btn">
			    <a class="btn btn-large btn-primary rounded-circle">
			      <i class="fas fa-bars" aria-hidden="true"></i>
			    </a>
			    <ul>
			      <?php if($jatbi->permission('furlough.delete','button')==true){?>
			      <li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/hrm/furlough-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
			      <?php }?>
			      <?php if($jatbi->permission('furlough.add','button')==true){?>
			      <li><a class="modal-url btn rounded-circle btn-info" data-url="/hrm/furlough-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
							    <div class="filer-item furlough">
							    	<label><?=$lang['loai']?></label>
							    	<select name="furlough" class="select2 form-select" style="width:100%">
								      <option value=""><?=$lang['loai']?></option>
								      <?php foreach ($furlough_categorys as $key => $furlough_category) {?>
								      	<option value="<?=$furlough_category['id']?>" <?=($xss->xss($_GET['furlough'])==$furlough_category['id']?'selected':'')?>><?=$furlough_category['name']?></option>
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
							        <?php if($jatbi->permission('furlough.delete','button')==true){?>
							      	<th width="1%" class="text-center">
										<div class="form-check">
										  <input class="form-check-input selectall" type="checkbox" value="" id="all">
										  <label class="form-check-label" for="all">
										  </label>
										</div>
							      	</th>
							      	<?php }?>
							        <th><?=$lang['loai']?></th>
							        <th><?=$lang['so-ngay-nghi-phep']?></th>
							        <th><?=$lang['tu-ngay']?></th>
							        <th><?=$lang['den-ngay']?></th>
							        <th><?=$lang['ghi-chu']?></th>
							        <th><?=$lang['ngay']?></th>
							        <?php if($jatbi->permission('furlough.edit','button')==true){?>
							        <th width="2%"></th>
							        <?php }?>
							    </tr>
							  </thead>
							  <tbody>
							    <?php foreach ($furlough_datas as $furlough_data) { ?>
									<tr>
						            <?php if($jatbi->permission('furlough.delete','button')==true){?>
						            <td class="align-middle">
					            		<div class="form-check">
											<input class="form-check-input checker" type="checkbox" id="<?=$furlough_data['id']?>" name="BOX[<?=$furlough_data['id']?>]" value="<?=$furlough_data['id']?>">
											<label class="form-check-label" for="<?=$furlough_data['id']?>"></label>
										</div>
						            </td>
						            <?php }?>
						            <td><?=$database->get("furlough_categorys","name",["id"=>$furlough_data['furlough']])?></td>
						            <td><?=$jatbi->count_date($furlough_data['date_from'].' 00:00:00',$furlough_data['date_to'].' 24:00:00','day')?></td>
						            <td><?=date($setting['site_date'],strtotime($furlough_data['date_from']))?></td>
						            <td><?=date($setting['site_date'],strtotime($furlough_data['date_to']))?></td>
						            <td><?=$furlough_data['notes']?></td>
						            <td><?=date($setting['site_datetime'],strtotime($furlough_data['date']))?></td>
						            <?php if($jatbi->permission('furlough.edit','button')==true){?>
						            	<td>
						            		<a class="btn btn-sm btn-light modal-url" data-url="/hrm/furlough-edit/<?=$furlough_data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
						            	</td>
						            <?php }?>
							      </tr>
						    	<?php } ?>
							  </tbody>
							</table>
						</div>
						<nav class="d-flex justify-content-between align-items-center paginations" aria-label="Page navigation">
						    <?=$furlough_page?>
						</nav>
					</div>
				</div>
			</div>
		<?php } ?>
		<?php if($router['2']=='reward'){?>
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
							    	<select name="personnels" class="form-control select2" style="width: 100%;">
							    		<option value=""><?=$lang['nhan-vien']?></option>
							    		<?php foreach ($personnels as $personnel) { ?>
									      	<option value="<?=$personnel['id']?>"  <?=($xss->xss($_GET['personnels'])==$personnel['id']?'selected':'')?>><?=$personnel['name']?></option>
									    <?php } ?>
								    </select>
							    </div>
							    <div class="filer-item type">
							    	<label><?=$lang['loai']?></label>
							    	<select name="type" class="select2 form-select" style="width:100%">
								      <option value=""><?=$lang['loai']?></option>
								      <option value="1" <?=($xss->xss($_GET['type'])=='1'?'selected':'')?>><?=$lang['khen-thuong']?></option>
								      <option value="2" <?=($xss->xss($_GET['type'])=='2'?'selected':'')?>><?=$lang['ki-luat']?></option>
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
							        <th><?=$lang['loai']?></th>
							        <th><?=$lang['nhan-vien']?></th>
							        <th><?=$lang['so-tien']?></th>
							        <th><?=$lang['ngay-ap-dung']?></th>
							        <th><?=$lang['noi-dung']?></th>
							        <th><?=$lang['ngay']?></th>
							    </tr>
							  </thead>
							  <tbody>
							    <?php foreach ($reward_datas as $reward_data) { ?>
									<tr>
							            <td><?=$reward_data['type']==1?$lang['khen-thuong']:$lang['ki-luat']?></td>
							            <td><?=$database->get("personnels","name",["id"=>$reward_data['personnels']])?></td>
							            <td><?=number_format($reward_data['price'])?></td>
							            <td><?=date($setting['site_date'],strtotime($reward_data['date']))?></td>
							            <td><?=$reward_data['content']?></td>
							            <td><?=date($setting['site_datetime'],strtotime($reward_data['date_poster']))?></td>
							      	</tr>
						    	<?php } ?>
							  </tbody>
							</table>
						</div>
						<nav class="d-flex justify-content-between align-items-center paginations" aria-label="Page navigation">
						    <?=$reward_page?>
						</nav>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
<?php } ?>
<?php if($router['1']=='org-chart'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['so-do-tai-khoan']?></h4>
			<ol class="breadcrumb">
			    <li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
			    <li class="breadcrumb-item active" aria-current="page"><?=$lang['so-do-tai-khoan']?></li>
			</ol>
		</div>
	</nav>
	<div class="card card-custom pt-5 pb-5">
		<div class="card-body p-0">
		    <div class="pjax-content-load d-flex justify-content-center align-items-center">
			    	<?php 
							$nested_lists = [];
							$user_lists = [];
							foreach ($datas as $row) {
							    $main = $row['main'];
							    $user = $row['id'];

							    if ($main=='0') {
							        $nested_lists[$user] = [];
							        $user_lists[$user] = &$nested_lists[$user];
							    } else {
							        $pointer = &$user_lists[$main];
							        $pointer[$user] = [];
							        $user_lists[$user] = &$pointer[$user];
							    }
							}
							function build_list($arr){
								global $database,$jatbi;
							    if (count($arr) == 0) {
							        return '';
							    }
								if($jatbi->permission('org-chart.add','button')==true){
									$org_chart_add = 'true';
								}
								if($jatbi->permission('org-chart.delete','button')==true){
									$org_chart_delete = 'true';
								}
							    $html = '<div class="org-chart-items">';
							    foreach ($arr as $k => $v) {
							    	$getdata = $database->get("org_chart","*",["id"=>$k]);
							    	$details[$k] = $database->select("org_chart_details","*",["org_chart"=>$k,"deleted"=>0]);
							    	if($org_chart_add == 'true'){
							    		$html_user[$k] = '<button class="modal-url text-primary btn btn-light" data-url="/users/org-chart-user/'.$k.'/"><i class="fas fa-plus"></i></button>';
							    		$html_add[$k] = '<button class="btn bg-primary click-url" data-url="/users/org-chart-add/'.$k.'/"><i class="fas fa-plus"></i></button>';
							    	}
							    	if($org_chart_add == 'true'){
							    		$html_input[$k] = '<input class="text-nowrap w-100 blur-update border-0 p-2" data-load="false" data-url="/users/org-chart-name/'.$k.'/" value="'.$getdata['name'].'">';
							    	}
							    	else {
							    		$html_input[$k] = '<span class="fw-bold">'.$getdata['name'].'</span>';
							    	}
							    	if($org_chart_delete == 'true'){
							    		$html_delete[$k] = '<button class="click-url text-danger btn btn-light me-2" data-url="/users/org-chart-delete/'.$k.'/"><i class="fas fa-trash"></i></button>';
							    	}
							    	foreach ($details[$k] as $key => $detail) {

								    	if($org_chart_delete == 'true'){
								    		$html_delete_user[$k] = '<button class="click-url text-danger btn" data-url="/users/org-chart-user-delete/'.$detail['id'].'/"><i class="fas fa-trash"></i></button>';
								    	}
							    		$getuser = $database->get("accounts",["id","name","avatar"],["id"=>$detail['user']]);
							    		$html_details[$k] .= '
							    			<div class="d-flex justify-content-between align-items-center p-2">
							    				<div class="d-flex justify-content-start align-items-center">
							    					<img src="/images/accounts/thumb/'.$getuser['avatar'].'" alt="'.$getuser['name'].'" class="rounded-circle me-2" style="width: 40px;">
							    					<span class="fw-bold text-nowrap">'.$getuser['name'].'</span>
							    				</div>
							    				'.$html_delete_user[$k].'
								    		</div>
							    		';
							    	}
							        $html .= '<div class="org-chart-content">';
							        $html .= '<div class="org-chart-card card shadow">
							        			<div class="card-header d-flex justify-content-between align-items-center">
							        				'.$html_input[$k].'
								    				<div class="d-flex justify-content-between align-items-center">
									    				'.$html_delete[$k].$html_user[$k].'
								    				</div>
								    			</div>
								    			<div class="card-body p-0">
								    				'.$html_details[$k].'
								    			</div>
								    			<div class="org-chart-sub">
								    				'.$html_add[$k].'
								    			</div>
								    		</div>';
							        $html .= build_list($v);
							        $html .= '</div>';
							    }
							    $html .= '</div>';
							    return $html;
							}
					?>
				<div class="table-responsive">
		    		<div class="org-chart">
		    			<?php if($jatbi->permission('org-chart.add','button')==true){ ?>
		    			<button class="btn text-white bg-primary org-chart-first-button rounded-circle  click-url" data-url="/users/org-chart-add/1/"><i class="fas fa-plus"></i></button>
		    			<?php } ?>
		    			<?=build_list($nested_lists[$first['id']])?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php } ?>
<?php if($router['1']=='org-chart-user'){?>
	<div class="modal fade modal-load" tabindex="-1">
	  <div class="modal-dialog modal-sm">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title"><?=$lang['tai-khoan']?></h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
	      <div class="modal-body">
        	<div class="mb-3">
        		<label><?=$lang['tai-khoan']?> <small class="text-danger">*</small></label>
        		<select name="user" class="select2 form-control" style="width:100%">
        			<option value="" selected disabled></option>
        			<?php foreach ($users as $key => $value) {?>
        				<option value="<?=$value['id']?>"><?=$value['name']?></option>
        			<?php } ?>
        		</select>
		    </div>
        	<div class="mb-3">
        		<label><?=$lang['ghi-chu']?></label>
        		<textarea class="form-control" name="notes" style="height:100px"></textarea>
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
