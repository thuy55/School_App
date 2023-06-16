<?php if($router['1']=='warehouse'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['cua-hang']?></h4>
			<ol class="breadcrumb">
			    <li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
			    <li class="breadcrumb-item active" aria-current="page"><?=$lang['thiet-bi']?></li>
			</ol>
		</div>
	</nav>
	<?php if($jatbi->permission('warehouse.add','button')==true || $jatbi->permission('warehouse.delete','button')==true){?>
	<div class="fixed-action-btn">
	    <a class="btn btn-large btn-primary rounded-circle">
	      <i class="fas fa-bars" aria-hidden="true"></i>
	    </a>
	    <ul>
	      <?php if($jatbi->permission('warehouse.delete','button')==true){?>
	      <li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/device/warehouse-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
	      <?php }?>
	      <?php if($jatbi->permission('warehouse.add','button')==true){?>
	      <li><a class="modal-url btn rounded-circle btn-info" data-url="/device/warehouse-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
				<a href="/device/warehouses-history/" class="btn btn-light w-100 pjax-load"><?=$lang['lich-su-xuat-nhap-hang']?></a>
			</div>
				<div class="form-group">
			    	<div class="dropdown">
					  <button class="border dropdown-toggle w-100 filler" type="button" id="fillers" data-bs-auto-close="false" data-bs-toggle="dropdown" aria-expanded="false">
					    <i class="fas fa-filter"></i> <?=$lang['them-dieu-kien-loc']?>
					  </button>
					  <div class="dropdown-menu filler-details p-3" aria-labelledby="fillers">
					  	<p class="mb-2"><?=$lang['tim-kiem-theo-dieu-kien']?></p>
					    <!-- <div class="filer-item type">
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
					        <?php if($jatbi->permission('warehouse.delete','button')==true){?>
					      	<th width="1%" class="text-center">
								<div class="form-check">
								  <input class="form-check-input selectall" type="checkbox" value="" id="all">
								  <label class="form-check-label" for="all">
								  </label>
								</div>
					      	</th>
					      	<?php }?>
					      	<th width="2%"></th>
					      	<th><?=$lang['loai-thiet-bi']?></th>
					        <th><?=$lang['thiet-bi']?></th>
					        <th><?=$lang['so-luong']?></th>
					        <th><?=$lang['don-vi']?></th>
					        <th><?=$lang['nha-cung-cap']?></th>					        
					        <th><?=$lang['trang-thai']?></th>
					        <th><?=$lang['ghi-chu']?></th>
					        <?php if($jatbi->permission('warehouse.edit','button')==true){?>
					        <th width="2%"></th>
					        <?php }?>
					    </tr>
					  </thead>
					  <tbody>
					    <?php foreach ($datas as $data) { ?>
							<tr>
				            <?php if($jatbi->permission('warehouse.delete','button')==true){?>
				            <td class="align-middle">
			            		<div class="form-check">
									<input class="form-check-input checker" type="checkbox" id="<?=$data['id']?>" name="BOX[<?=$data['id']?>]" value="<?=$data['id']?>">
									<label class="form-check-label" for="<?=$data['id']?>"></label>
								</div>
				            </td>
				            <?php }?>
				            <td></td>
				            <!-- <td><img src="/<?=$upload['images']['avatar']['url'].$data['images']?>" class="border border-light rounded-circle shadow-sm w-100"></td> -->
				            <td><?=$database->get("category_device","name",["id"=>$data['category_device']])?></td>
				            <td><?=$data['name']?></td>
				            <td><?=$data['amounts']?></td>
				            <td><?=$database->get("units","name",["id"=>$data['units']])?></td>
				            <td><?=$database->get("supplier","name",["id"=>$data['supplier']])?></td>
				            <td>	
				            	<div class="form-check form-switch">
								  <input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/device/warehouse-status/<?=$data['id']?>/">
								  <label class="form-check-label" for="status"></label>
								</div>
				            </td>
				            <td><?=$data['notes']?></td>
				            <?php if($jatbi->permission('warehouse.edit','button')==true){?>
				            	<td>
				            		<a class="btn btn-sm btn-light modal-url" data-url="/device/warehouse-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
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
<?php if($router['1']=='warehouse-add' || $router['1']=='warehouse-edit'){?>
	<div class="modal fade modal-load" tabindex="-1">
	  <div class="modal-dialog modal-lg">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title"><?=$router['1']=='warehouse-add'?$lang['them']:$lang['sua']?> <?=$lang['thiet-bi']?></h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
	      <div class="modal-body">
	      	<div class="row">
		        <div class="col-md-6">
				    <div class="mb-3">
		        		<label><?=$lang['loai-thiet-bi']?> <small class="text-danger">*</small></label>
					   	<select name="category_device" class="select2 form-control" style="width:100%">
					   		<option value=""><?=$lang['loai-thiet-bi']?></option>
			        		<?php foreach ($category_devices as $key => $device_type) { ?>
			        			<option value="<?=$device_type['id']?>" <?=$data['category_device']==$device_type['id']?'selected':''?>><?=$device_type['name']?></option>
			        		<?php } ?>
					    </select>
				    </div>		        	
		        	<div class="mb-3">
		        		<label><?=$lang['thiet-bi']?> <small class="text-danger">*</small></label>
					    <input placeholder="<?=$lang['thiet-bi']?>" type="text" name="name" value="<?=$data['name']?>" class="form-control">
				    </div>
				    <div class="mb-3">
		        		<label><?=$lang['don-vi']?> <small class="text-danger">*</small></label>
					   	<select name="units" class="select2 form-control" style="width:100%">
					   		<option value=""><?=$lang['don-vi']?></option>
			        		<?php foreach ($units as $key => $unit) { ?>
			        			<option value="<?=$unit['id']?>" <?=$data['units']==$unit['id']?'selected':''?>><?=$unit['name']?></option>
			        		<?php } ?>
					    </select>
				    </div>
		        </div>
		        <div class="col-md-6">
		        	<div class="mb-3">
		        		<label><?=$lang['hinh-dai-dien']?></label>
						<input type="file" class="form-control" name="images">
				    </div>		        	
		        	<div class="mb-3">
		        		<label><?=$lang['nha-cung-cap']?> <small class="text-danger">*</small></label>
					   	<select name="supplier" class="select2 form-control" style="width:100%">
					   		<option value=""><?=$lang['nha-cung-cap']?></option>
			        		<?php foreach ($suppliers as $key => $supplier) { ?>
			        			<option value="<?=$supplier['id']?>" <?=$data['supplier']==$supplier['id']?'selected':''?>><?=$supplier['name']?></option>
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
<?php if($router['1']=='warehouse-delete'){?>
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
<?php if($router['1']=='units'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['don-vi']?></h4>
			<ol class="breadcrumb">
			    <li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
			    <li class="breadcrumb-item active" aria-current="page"><?=$lang['don-vi']?></li>
			</ol>
		</div>
	</nav>
	<?php if($jatbi->permission('units.add','button')==true || $jatbi->permission('units.delete','button')==true){?>
	<div class="fixed-action-btn">
	    <a class="btn btn-large btn-primary rounded-circle">
	      <i class="fas fa-bars" aria-hidden="true"></i>
	    </a>
	    <ul>
	      <?php if($jatbi->permission('units.delete','button')==true){?>
	      <li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/device/units-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
	      <?php }?>
	      <?php if($jatbi->permission('units.add','button')==true){?>
	      <li><a class="modal-url btn rounded-circle btn-info" data-url="/device/units-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
					        <?php if($jatbi->permission('units.delete','button')==true){?>
					      	<th width="1%" class="text-center">
								<div class="form-check">
								  <input class="form-check-input selectall" type="checkbox" value="" id="all">
								  <label class="form-check-label" for="all">
								  </label>
								</div>
					      	</th>
					      	<?php }?>
					        <th><?=$lang['ten']?></th>
					        <th><?=$lang['ghi-chu']?></th>
					        <th><?=$lang['trang-thai']?></th>
					        <?php if($jatbi->permission('units.edit','button')==true){?>
					        <th width="2%"></th>
					        <?php }?>
					    </tr>
					  </thead>
					  <tbody>
					    <?php foreach ($datas as $data) { ?>
							<tr>
				            <?php if($jatbi->permission('units.delete','button')==true){?>
				            <td class="align-middle">
			            		<div class="form-check">
									<input class="form-check-input checker" type="checkbox" id="<?=$data['id']?>" name="BOX[<?=$data['id']?>]" value="<?=$data['id']?>">
									<label class="form-check-label" for="<?=$data['id']?>"></label>
								</div>
				            </td>
				            <?php }?>
				            <td><?=$data['name']?></td>
				            <td><?=$data['notes']?></td>
				            <td>	
				            	<div class="form-check form-switch">
								  <input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/device/units-status/<?=$data['id']?>/">
								  <label class="form-check-label" for="status"></label>
								</div>
				            </td>
				            <?php if($jatbi->permission('units.edit','button')==true){?>
				            	<td>
				            		<a class="btn btn-sm btn-light modal-url" data-url="/device/units-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
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
<?php if($router['1']=='units-add' || $router['1']=='units-edit'){?>
	<div class="modal fade modal-load" tabindex="-1">
	  <div class="modal-dialog modal-sm">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title"><?=$router['1']=='units-add'?$lang['them']:$lang['sua']?> <?=$lang['don-vi']?></h5>
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
<?php if($router['1']=='units-delete'){?>
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
<?php if($router['1']=='category_device'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['danh-muc-thiet-bi']?></h4>
			<ol class="breadcrumb">
			    <li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
			    <li class="breadcrumb-item active" aria-current="page"><?=$lang['danh-muc-thiet-bi']?></li>
			</ol>
		</div>
	</nav>
	<?php if($jatbi->permission('category_device.add','button')==true || $jatbi->permission('category_device.delete','button')==true){?>
	<div class="fixed-action-btn">
	    <a class="btn btn-large btn-primary rounded-circle">
	      <i class="fas fa-bars" aria-hidden="true"></i>
	    </a>
	    <ul>
	      <?php if($jatbi->permission('category_device.delete','button')==true){?>
	      <li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/device/category_device-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
	      <?php }?>
	      <?php if($jatbi->permission('category_device.add','button')==true){?>
	      <li><a class="modal-url btn rounded-circle btn-info" data-url="/device/category_device-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
					        <?php if($jatbi->permission('category_device.delete','button')==true){?>
					      	<th width="1%" class="text-center">
								<div class="form-check">
								  <input class="form-check-input selectall" type="checkbox" value="" id="all">
								  <label class="form-check-label" for="all">
								  </label>
								</div>
					      	</th>
					      	<?php }?>
					        <th><?=$lang['ma-li-ngoc']?></th>
					        <th><?=$lang['ten']?></th>
					        <th><?=$lang['ghi-chu']?></th>
					        <th><?=$lang['trang-thai']?></th>
					        <?php if($jatbi->permission('category_device.edit','button')==true){?>
					        <th width="2%"></th>
					        <?php }?>
					    </tr>
					  </thead>
					  <tbody>
					    <?php foreach ($datas as $data) { ?>
							<tr>
				            <?php if($jatbi->permission('category_device.delete','button')==true){?>
				            <td class="align-middle">
			            		<div class="form-check">
									<input class="form-check-input checker" type="checkbox" id="<?=$data['id']?>" name="BOX[<?=$data['id']?>]" value="<?=$data['id']?>">
									<label class="form-check-label" for="<?=$data['id']?>"></label>
								</div>
				            </td>
				            <?php }?>
				            <td><?=$data['code']?></td>
				            <td><?=$data['name']?></td>
				            <td><?=$data['notes']?></td>
				            <td>	
				            	<div class="form-check form-switch">
								  <input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/device/category_device-status/<?=$data['id']?>/">
								  <label class="form-check-label" for="status"></label>
								</div>
				            </td>
				            <?php if($jatbi->permission('category_device.edit','button')==true){?>
				            	<td>
				            		<a class="btn btn-sm btn-light modal-url" data-url="/device/category_device-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
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
<?php if($router['1']=='category_device-add' || $router['1']=='category_device-edit'){?>
	<div class="modal fade modal-load" tabindex="-1">
	  <div class="modal-dialog modal-sm">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title"><?=$router['1']=='category_device-add'?$lang['them']:$lang['sua']?> <?=$lang['danh-muc-thiet-bi']?></h5>
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
<?php if($router['1']=='category_device-delete'){?>
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
<?php if($router['1']=='supplier'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['danh-sach-nha-cung-cap']?></h4>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
				<li class="breadcrumb-item active" aria-current="page"><?=$lang['thiet-bi']?></li>
			</ol>
		</div>
	</nav>
	<?php if($jatbi->permission('supplier.add','button')==true || $jatbi->permission('supplier.delete','button')==true){?>
		<div class="fixed-action-btn">
			<a class="btn btn-large btn-primary rounded-circle">
				<i class="fas fa-bars" aria-hidden="true"></i>
			</a>
			<ul>
				<?php if($jatbi->permission('supplier.delete','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/device/supplier-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
				<?php }?>
				<?php if($jatbi->permission('supplier.add','button')==true){?>
					<li><a class="modal-url btn rounded-circle btn-info" data-url="/device/supplier-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
								<?php if($jatbi->permission('supplier.delete','button')==true){?>
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
								<?php if($jatbi->permission('supplier.edit','button')==true){?>
									<th width="2%"></th>
								<?php }?>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($datas as $data) { ?>
								<tr>
									<?php if($jatbi->permission('supplier.delete','button')==true){?>
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
											<input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/device/supplier-status/<?=$data['id']?>/">
											<label class="form-check-label" for="status"></label>
										</div>
									</td>
									<?php if($jatbi->permission('supplier.edit','button')==true){?>
										<td>
											<a class="btn btn-sm btn-light modal-url" data-url="/device/supplier-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
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
<?php if($router['1']=='supplier-add' || $router['1']=='supplier-edit'){?>
	<div class="modal fade modal-load" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><?=$router['1']=='supplier-add'?$lang['them']:$lang['sua']?><?=$lang['nha-cung-cap']?></h5>
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
<?php if($router['1']=='supplier-delete'){?>
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
<?php if($router['1']=='import_goods'){?>
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
		<?php if($jatbi->permission('import_goods.add','button')==true || $jatbi->permission('import_goods.delete','button')==true){?>
		<div class="fixed-action-btn">
		    <a class="btn btn-large btn-primary rounded-circle">
		      <i class="fas fa-bars" aria-hidden="true"></i>
		    </a>
		    <ul>
		      <?php if($jatbi->permission('import_goods.delete','button')==true){?>
		      <li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/device/import_goods-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
		      <?php }?>
		      <?php if($jatbi->permission('import_goods.add','button')==true){?>
		      <li><a class="pjax-load btn rounded-circle btn-info" href="/device/import_goods-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
						    	<select name="vendor_device" class="form-control select2" style="width: 100%;">
						    		<option value=""><?=$lang['tat-ca']?></option>
						    		<?php foreach ($vendors as $vendor) { ?>
								      	<option value="<?=$vendor['id']?>"  <?=($xss->xss($_GET['vendor'])==$vendor['id']?'selected':'')?>><?=$vendor['name']?></option>
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
						        <?php if($jatbi->permission('import_goods.delete','button')==true){?>
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
						        <?php if($jatbi->permission('import_goods.edit','button')==true){?>
						        <th width="2%"></th>
						        <?php }?>
						        <th width="2%"></th>
						    </tr>
						  </thead>
						  <tbody>
						    <?php foreach ($datas as $data) { ?>
								<tr>
					            <?php if($jatbi->permission('import_goods.delete','button')==true){?>
					            <td class="align-middle">
					            	<?php if($data['status']==1 || $data['status']==4){?>
					            		<div class="form-check">
											<input class="form-check-input checker" type="checkbox" id="<?=$data['id']?>" name="BOX[<?=$data['id']?>]" value="<?=$data['id']?>">
											<label class="form-check-label" for="<?=$data['id']?>"></label>
										</div>
									<?php } ?>
					            </td>
					            <?php }?>
					            <td><a class="modal-url" data-url="/device/import_goods-views/<?=$data['id']?>/">#-<?=$data['code']?></a></td>
					            <td><?=$database->get("supplier","name",["id"=>$data['vendor']])?></td>
					            <td class="fw-bold text-primary"><?=number_format($data['total'])?></td>
					            <td class="fw-bold text-info"><?=number_format($data['minus'])?></td>
					            <td class="fw-bold text-info"><?=number_format($data['discount'])?></td>
					            <td class="fw-bold text-success"><?=number_format($data['payments'])?></td>
					            <td><?=date($setting['site_datetime'],strtotime($data['date']))?></td>
					            <td><?=$database->get("accounts","name",["id"=>$data['user']])?></td>
				            
					            <td>
						            <a class="p-1 rounded-3 small btn-light pjax-load" href="/device/import_goods-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
					            </td>
					            <td>
				            		<a class="btn btn-sm btn-light modal-url" data-url="/device/purchase-views/<?=$data['id']?>/"><i class="fas fa-eye" aria-hidden="true"></i></a>
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
<?php if($router['1']=='import_goods-add' || $router['1']=='import_goods-edit'){?>
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
					    	<select name="type_device" class="form-control select2 change-update" style="width: 100%;" data-url="/device/purchase-update/<?=$action?>/type_device/">
							      	<option value="3" <?=3==$_SESSION['purchase'][$action]['type_device']?'selected':''?>><?=$lang['nhap-thiet-bi']?></option>
						    </select>
						</div>
						<div class="mb-3 col-md-4">
							<label class="col-form-label"><?=$lang['nha-cung-cap']?> <span class="text-danger">*</span></label>
							<select name="vendor_device" class="form-control select2 change-update" style="width: 100%;" data-url="/device/purchase-update/<?=$action?>/vendor_device/">
							      <option value="" disabled selected><?=$lang['nha-cung-cap']?></option>
					    		<?php foreach ($vendors as $vendor) { ?>
							      	<option value="<?=$vendor['id']?>" <?=$vendor['id']==$_SESSION['purchase'][$action]['vendor_device']['id']?'selected':''?>><?=$vendor['name']?></option>
							    <?php } ?>
						    </select>
						</div>
						<div class="mb-3 col-md-4">
							<label class="col-form-label"><?=$lang['ngay']?> <span class="text-danger">*</span></label>
					    	<input type="date" name="date_device" class="form-control blur-update" data-load="false" data-url="/device/purchase-update/<?=$action?>/date_device/" value="<?=$data['date']?>">
						</div>
					</div>
				</div>
				<div class="card-body">
				    <div class="">
				    	<div class="row">
							<div class="mb-3 col-lg-12">
								<label class="col-form-label"><?=$lang['thiet-bi']?> <span class="text-danger">*</span></label>	
								<select name="ingredient" class="form-control select2 change-update" style="width: 100%;" multiple="" data-url="/device/purchase-update/<?=$action?>/products_device/add/">
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
										<th><?=$lang['thiet-bi']?></th>
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
											$getPro = $database->get("device","*",["id"=>$SelectProduct['products']]); 
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
												<input type="number" name="amount" class="blur-update border-0 w-100  h-100 p-3 bg-transparent" data-url="/device/purchase-update/<?=$action?>/products_device/amount/<?=$key?>/" value="<?=$SelectProduct['amount']?>" data-load="true">
										</td>
										<td class="p-1">
											<?=$database->get("units","name",["id"=>$getPro['units']])?>
										</td>
										<td class="p-1">
											<?=$database->get("supplier","name",["id"=>$getPro['supplier']])?>
										</td>
										<td class="p-0">
											<input type="text" name="price" class="blur-update border-0 w-100  h-100 p-3 bg-transparent number" data-url="/device/purchase-update/<?=$action?>/products_device/price/<?=$key?>/" value="<?=$SelectProduct['price']?>" data-load="true">
										</td>
										<td class="text-end fw-bold">
											<?=number_format($total_price)?>
										</td>
										<td class="text-center"><a class="click-update  text-danger" data-load="" data-url="/device/purchase-update/<?=$action?>/products_device/deleted/<?=$key?>/"><i class="fa fa-trash"></i></a></td>
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
											<input type="text" name="discount" class="blur-update border-0 w-100  h-100 p-1 bg-transparent text-end" data-url="/device/purchase-update/<?=$action?>/discount_device/" value="<?=$data['discount']?>" data-load="true">
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
			        	<div class="col-md-6 mb-3">
			        		<label><?=$lang['tai-khoan-no']?> <small class="text-danger">*</small></label>
						   	<select name="debt" class="form-control select2 change-update" style="width:100%" data-url="/device/purchase-update/<?=$action?>/debt_device/">
						   		<option value=""><?=$lang['tai-khoan-no']?></option>
				        		<?php foreach ($accountants as $key => $debt) { ?>
				        			<option value="<?=$debt['code']?>" <?=$data['debt']==$debt['code']?'selected':''?>><?=$debt['code']?> - <?=$debt['name']?></option>
				        		<?php } ?>
						    </select>
					    </div>
			        	<div class="col-md-6 mb-3">
			        		<label><?=$lang['tai-khoan-co']?> <small class="text-danger">*</small></label>
						   	<select name="has" class="form-control select2 change-update" style="width:100%" data-url="/device/purchase-update/<?=$action?>/has_device/">
						   		<option value=""><?=$lang['tai-khoan-co']?></option>
				        		<?php foreach ($accountants as $key => $has) { ?>
				        			<option value="<?=$has['code']?>" <?=$data['has']==$has['code']?'selected':''?>><?=$has['code']?> - <?=$has['name']?></option>
				        		<?php } ?>
						    </select>
					    </div>
					</div>
						<div class="row">
							<div class="col-md-12">
								<div class="mb-3 ">
									<label class="col-form-label"><?=$lang['noi-dung']?> <span class="text-danger">*</span></label>
									<textarea name="content" class="form-control blur-update" style="height: 100px;" data-load="false" data-url="/device/purchase-update/<?=$action?>/content_device/"><?=$data['content']?></textarea>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer text-end bg-light border-0">
					<a class="click-update btn btn-danger" data-load="" data-url="/device/purchase-update/<?=$action?>/cancel/"><?=$lang['huy']?></a>
					<button class="click-update btn btn-success" data-load="/device/import_goods/" data-url="/device/purchase-update/<?=$action?>/completed/"><?=$lang['hoan-tat']?></button>
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
		        					<td class="text-center"><a class="click-update  text-danger" data-load="" data-url="/device/purchase-update/<?=$action?>/details-deleted/<?=$router['4']?>/<?=$key?>/"><i class="fa fa-trash"></i></a></td>
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
	      						<strong><?=$lang['nha-cung-cap']?>:</strong> <?=$database->get("supplier","name",["id"=>$data['vendor']])?>
	      					</td>
	      					<td colspan="3">
	      						<strong><?=$lang['dien-thoai']?>:</strong> <?=$database->get("supplier","phone_number",["id"=>$data['vendor']])?>
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
	      				<?php foreach ($SelectProducts as $key => $SelectProduct) {  							
							$get =  $database->get("purchase","*",["id"=>$SelectProduct['purchase']]);
							if($get["type"]==2){
						?>
						<tr>
							<th><?=$lang['ma-hang']?></th>
							<th><?=$lang['ten']?></th>
		
							<th><?=$lang['so-luong']?></th>
							<th><?=$lang['don-vi']?></th>
							<th><?=$lang['gia-tien']?></th>
							<th><?=$lang['thanh-tien']?></th>
						</tr>
						<?php }else{ ?>						
						<tr>
							
							<th><?=$lang['ma-hang']?></th>
							<th><?=$lang['ten']?></th>
							<th><?=$lang['so-luong']?></th>
							<th><?=$lang['don-vi']?></th>
							<th><?=$lang['gia-tien']?></th>
							<th><?=$lang['thanh-tien']?></th>
						</tr>	
						<?php } ?>	
						<?php } ?>				
					</thead>
					<tbody>
						<?php foreach ($SelectProducts as $key => $SelectProduct) {  
							$getPro = $database->get("device","*",["id"=>$SelectProduct['products']]);
												
							$price = $SelectProduct['amount']*$SelectProduct['price'];
							?>
						<tr>
							
							<td><?=$getPro['id']?></td>
							<td><?=$getPro['name']?></td>
							<td class=""><?=$SelectProduct['amount']?></td>
							<td class="">
								<?=$database->get("units","name",["id"=>$getPro['units']])?>
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
						<?php if($get['type']==3){?>
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
			<h4><?=$lang['lich-su-nhap-hang']?></h4>
			<ol class="breadcrumb">
			    <li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
			    <li class="breadcrumb-item active" aria-current="page"><?=$lang['bep']?></li>
			</ol>
		</div>
	</nav>
	<div class="card card-custom">
		<div class="card-body">
			<form method="GET" class="pjax-content mb-4 search-form">
				<div class="form-group col-4">
				    <input placeholder="<?=$lang['tim-kiem']?>" type="text" name="name" value="<?=$xss->xss($_GET['name'])?>" class="form-control">
			    </div>
				<div class="form-group d-flex">
					
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
					            	<?php if($data['type']=='3'){?>
					            		<span class="fw-bold p-1 rounded-3 small btn-primary"><?=$lang['da-nhap-hang']?></span>
					            	<?php } elseif ($data['type']=='4') {
					            	?>
					            	<span class="fw-bold p-1 rounded-3 small btn-primary"><?=$lang['da-xuat-hang']?></span>
					            	<?php }?>
					     
					            </td>
					            <td>
					            	<a href="#" class="modal-url btn btn-light" data-url="/device/warehouses-history-views/<?=$data['id']?>/">
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
			    	<?php if($data['type']=='3' ||$data['type']=='4'){?>
				    	 <tr>
							<td><?=$lang['ma-nhap-hang']?>: #<?=$data['code']?><?=$data['id']?></td>
							<td><?=$lang['tai-khoan']?>: <?=$database->get("accounts","name",["id"=>$data['user']])?></td>
						</tr>
				    	<? } ?>
				    	
					
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
								$getPro = $database->get("device","*",["id"=>$SelectProduct['products']]); 
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
									<?=$getPro['id_device']?>
								</td>
								<td class="p-2 pe-2 ps-2">
									<?=$getPro['name']?>
								</td>
								<td class="text-center">
									<?=number_format($SelectProduct['amount'])?>
								</td>
								<td class="text-center">
									<?=$database->get("units","name",["id"=>$getPro['units']])?>
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
<?php if($router['1']=='export_goods'){?>
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
		      <?php if($jatbi->permission('export_goods.delete','button')==true){?>
		      <li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/device/export_goods-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
		      <?php }?>
		      <?php if($jatbi->permission('export_goods.add','button')==true){?>
		      <li><a class="pjax-load btn rounded-circle btn-info" href="/device/export_goods-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
					          
					            <td class="align-middle">
					            	<?php if($data['status']==1 || $data['status']==4){?>
					            		<div class="form-check">
											<input class="form-check-input checker" type="checkbox" id="<?=$data['id']?>" name="BOX[<?=$data['id']?>]" value="<?=$data['id']?>">
											<label class="form-check-label" for="<?=$data['id']?>"></label>
										</div>
									<?php } ?>
					            </td>
					     
					            <td><a class="modal-url" data-url="/device/food_import-views/<?=$data['id']?>/">#-<?=$data['code']?></a></td>
					            <td><?=$data['content']?></td>
					          
					            <td><?=date($setting['site_datetime'],strtotime($data['date']))?></td>
					            <td><?=$database->get("accounts","name",["id"=>$data['user']])?></td>
				            
					            <td>
						            <a class="p-1 rounded-3 small btn-light pjax-load" href="/device/export_goods-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
					            </td>
					            <td>
				            		<a class="btn btn-sm btn-light modal-url" data-url="/device/purchase-views/<?=$data['id']?>/"><i class="fas fa-eye" aria-hidden="true"></i></a>
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
<?php if($router['1']=='export_goods-add' || $router['1']=='export_goods-edit'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['xuat-kho']?></h4>
			<ol class="breadcrumb">
			    <li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
			    <li class="breadcrumb-item active" aria-current="page"><?=$lang['thiet-bi']?></li>
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
					    	<select name="type" class="form-control select2 change-update" style="width: 100%;" data-url="/device/purchase_export-update/<?=$action?>/typees/">
							      	<option value="4" <?=4==$_SESSION['purchase'][$action]['type']?'selected':''?>><?=$lang['xuat-kho']?></option>
						    </select>
						</div>
						
						<div class="mb-3 col-md-4">
							<label class="col-form-label"><?=$lang['ngay']?> <span class="text-danger">*</span></label>
					    	<input type="date" name="date" class="form-control blur-update" data-load="false" data-url="/device/purchase_export-update/<?=$action?>/datee/" value="<?=$data['date']?>">
						</div>
					</div>
				</div>
				<div class="card-body">
				    <div class="">
				    	<div class="row">
							<div class="mb-3 col-lg-12">
								<label class="col-form-label"><?=$lang['san-pham']?> <span class="text-danger">*</span></label>	
								<select name="ingredient" class="form-control select2 change-update" style="width: 100%;" multiple="" data-url="/device/purchase_export-update/<?=$action?>/productsss/add/">
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
											$getPro = $database->get("device","*",["id"=>$SelectProduct['products']]); 
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
												<input type="number" name="amount" class="blur-update border-0 w-100  h-100 p-3 bg-transparent" data-url="/device/purchase_export-update/<?=$action?>/productsss/amount/<?=$key?>/" value="<?=$SelectProduct['amount']?>" data-load="true">
										</td>
										<td class="p-1">
											<?=$database->get("units","name",["id"=>$getPro['units']])?>
										</td>
										<td class="p-1">
											<?=$database->get("supplier","name",["id"=>$getPro['supplier']])?>
										</td>
										<td class="p-0">
											<input type="text" name="price" class="blur-update border-0 w-100  h-100 p-3 bg-transparent number" data-url="/device/purchase_export-update/<?=$action?>/productsss/price/<?=$key?>/" value="<?=$SelectProduct['price']?>" data-load="true">
										</td>
										<td class="text-end fw-bold">
											<?=number_format($total_price)?>
										</td>
										<td class="text-center"><a class="click-update  text-danger" data-load="" data-url="/device/purchase_export-update/<?=$action?>/productsss/deleted/<?=$key?>/"><i class="fa fa-trash"></i></a></td>
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
											<input type="text" name="discount" class="blur-update border-0 w-100  h-100 p-1 bg-transparent text-end" data-url="/device/purchase_export-update/<?=$action?>/discountts/" value="<?=$data['discount']?>" data-load="true">
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
									<textarea name="content" class="form-control blur-update" style="height: 100px;" data-load="false" data-url="/device/purchase_export-update/<?=$action?>/contentts/"><?=$data['content']?></textarea>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer text-end bg-light border-0">
					<a class="click-update btn btn-danger" data-load="" data-url="/device/purchase_export-update/<?=$action?>/cancel/"><?=$lang['huy']?></a>
					<button class="click-update btn btn-success" data-load="/device/export_goods/" data-url="/device/purchase_export-update/<?=$action?>/completed/"><?=$lang['hoan-tat']?></button>
				</div>
			</div>
		</div>
	</div>
<?php } ?>
