<?php if($router['1']=='files'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['du-lieu']?></h4>
			<ol class="breadcrumb">
			    <li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
			    <li class="breadcrumb-item active" aria-current="page"><?=$lang['du-lieu']?></li>
			</ol>
		</div>
	</nav>
	<?php if($jatbi->permission('files.add','button')==true){?>
	<div class="fixed-action-btn">
	    <a class="btn btn-large btn-primary rounded-circle">
	      <i class="fas fa-bars" aria-hidden="true"></i>
	    </a>
	    <ul>
	      <?php if($jatbi->permission('files.delete','button')==true){?>
	      <li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/datas/files-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
	      <?php }?>
	      <?php if($jatbi->permission('files.edit','button')==true){?>
	      <li><a class="modal-url btn rounded-circle btn-info" data-url="/datas/files-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
	      <?php }?>
	    </ul>
	</div>
	<?php } ?>
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
		    	<div class="d-flex justify-content-start align-items-center">
		    		<div class="btn btn-light p-3 rounded-3 mb-3 me-2"><strong class="me-2"><?=$lang['dung-luong']?>:</strong> <?=$jatbi->formatBytes($database->sum("datas","size",["user"=>$account['id'],"deleted"=>0]))?></div>
		    		<div class="btn btn-light p-3 rounded-3 mb-3 me-2"><strong class="me-2"><?=$lang['dung-luong-gioi-han']?>:</strong> Unlimted</div>
		    		<div class="btn btn-light p-3 rounded-3 mb-3 me-2">
		    			<div class="form-check d-flex justify-content-between align-items-center">
						  <input class="form-check-input selectall" type="checkbox" value="" id="all">
						  <label class="form-check-label ms-2 mb-0" for="all">
						  	<?=$lang['chon-tat-ca']?>
						  </label>
						</div>
		    		</div>
		    	</div>
		    	<div class="row">
					<?php foreach($datas as $data) { ?>
						<div class="col-xl-2 col-md-4 col-6">
							<div class="card border rounded-3 p-1 card-custom card-hover mb-3 position-relative">
								<div class="position-absolute">
									<div class="form-check">
										<input class="form-check-input checker" type="checkbox" id="<?=$data['task']?>" name="BOX[<?=$data['id']?>]" value="<?=$data['id']?>">
										<label class="form-check-label" for="<?=$data['id']?>"></label>
									</div>
								</div>
								<a class="modal-url" data-url="/datas/files-views/<?=$data['id']?>/">
									<div style="background-image: url(<?=$jatbi->files_mine($data['id'])['icon']?>);" class="datas-files p-5 w-100"></div>
									<div class="mt-2 p-3">
										<span class="fw-bold mb-2 fs-6 text-dark"><?=$data['name']?></span>
										<small class="d-block fst-italic text-muted"><?=date($setting['site_datetime'],strtotime($data['date']))?></small>
									</div>
								</a>
							</div>
						</div>
					<?php } ?>
				</div>
				<nav class="d-flex justify-content-between align-items-center paginations" aria-label="Page navigation">
				    <?=$page?>
				</nav>
			</div>
		</div>
	</div>
<?php } ?>
<?php if($router['1']=='files-add'){?>
	<div class="modal fade modal-load" tabindex="-1" data-bs-backdrop="static">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title"><?=$lang['them-du-lieu']?></h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
	      <div class="modal-body">
        	<div class="mb-3">
        		<label><?=$lang['ten']?> <small class="text-danger">*</small></label>
        		<input type="text" name="name" class="form-control" value="">
		    </div>
		    <div class="mb-3">
        		<label><?=$lang['du-lieu']?> <small class="text-danger">*</small></label>
        		<input type="file" name="files" class="form-control" value="">
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
<?php if($router['1']=='files-delete'){?>
	<div class="modal fade modal-load" tabindex="-1" data-bs-backdrop="static">
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
<?php if($router['1']=='files-views'){?>
	<div class="modal fade modal-load" tabindex="-1">
		<div class="modal-dialog" style="<?=$file['modal']?>">
	    <div class="modal-content">
	      <div class="modal-body">
	      	<?=$file['views']?>
	      </div>
	      <div class="modal-footer">
	      	<a href="<?=$file['url']?>" class="btn btn-primary" download><?=$lang['tai-ve']?></a>
	        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?=$lang['huy']?></button>
	      </div>
	    </div>
	  </div>
	</div>
<?php } ?>
<?php if($router['1']=='trash'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['thung-rac']?></h4>
			<ol class="breadcrumb">
			    <li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
			    <li class="breadcrumb-item active" aria-current="page"><?=$lang['thung-rac']?></li>
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
		    	<div class="d-flex justify-content-start align-items-center">
		    		<div class="btn btn-light p-3 rounded-3 mb-3 me-2"><strong class="me-2"><?=$lang['dung-luong']?>:</strong> <?=$jatbi->formatBytes($database->sum("datas","size",["user"=>$account['id'],"deleted"=>1]))?></div>
		    		<div class="btn btn-light p-3 rounded-3 mb-3 me-2">
		    			<div class="form-check d-flex justify-content-between align-items-center">
						  <input class="form-check-input selectall" type="checkbox" value="" id="all">
						  <label class="form-check-label ms-2 mb-0" for="all">
						  	<?=$lang['chon-tat-ca']?>
						  </label>
						</div>
		    		</div>
		    		<a class="modal-url btn btn-light text-danger p-3 rounded-3 mb-3 me-2" data-array="true" data-url="/datas/trash-delete/"><i class="fas fa-trash" aria-hidden="true"></i> <?=$lang['xoa']?></a>
		    	</div>
		    	<div class="row">
					<?php foreach($datas as $data) { ?>
						<div class="col-xl-2 col-md-4 col-6">
							<div class="card border rounded-3 p-1 card-custom card-hover mb-3 position-relative">
								<div class="position-absolute">
									<div class="form-check">
										<input class="form-check-input checker" type="checkbox" id="<?=$data['task']?>" name="BOX[<?=$data['id']?>]" value="<?=$data['id']?>">
										<label class="form-check-label" for="<?=$data['id']?>"></label>
									</div>
								</div>
								<div style="background-image: url(<?=$jatbi->files_mine($data['id'])['icon']?>);" class="datas-files p-5 w-100"></div>
								<div class="mt-2 p-3">
									<span class="fw-bold mb-2 fs-6 text-dark"><?=$data['name']?></span>
									<small class="d-block fst-italic text-muted"><?=date($setting['site_datetime'],strtotime($data['date']))?></small>
								</div>
							</div>
						</div>
					<?php } ?>
				</div>
				<nav class="d-flex justify-content-between align-items-center paginations" aria-label="Page navigation">
				    <?=$page?>
				</nav>
			</div>
		</div>
	</div>
<?php } ?>
<?php if($router['1']=='trash-delete'){?>
	<div class="modal fade modal-load" tabindex="-1" data-bs-backdrop="static">
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