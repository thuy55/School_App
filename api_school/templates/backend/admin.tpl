<?php if($router['1']=='logs'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['nhat-ky']?></h4>
			<ol class="breadcrumb">
			    <li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
			    <li class="breadcrumb-item active" aria-current="page"><?=$lang['nhat-ky']?></li>
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
					<table class="table table-striped table-hover align-middle">
					  <thead>
					    <tr>
					    	<th width="50"></th>
					        <th><?=$lang['tai-khoan']?></th>
				            <th><?=$lang['dieu-hanh']?></th>
				            <th><?=$lang['hanh-dong']?></th>
				            <th><?=$lang['duong-dan']?></th>
				            <th><?=$lang['ip']?></th>
				            <th><?=$lang['ngay']?></th>
				            <th width="1%"></th>
					    </tr>
					  </thead>
					  <tbody>
					    <?php foreach ($datas as $data) { $user = $database->get("accounts", "*",["id"=>$data['user']]);?>
							<tr>
								<td><img src="/<?=$upload['images']['avatar']['url'].$user['avatar']?>" class="border border-light rounded-circle shadow-sm w-100"></td>
					            <td><?=$user['name']?></td>
					            <td><?=$data['dispatch']?></td>
					            <td><?=$data['action']?></td>
					            <td><?=$data['url']?></td>
					            <td><?=$data['ip']?></td>
					            <td><?=date($setting['site_datetime'],strtotime($data['date']))?></td>
					            <td>
					            	<a class="btn btn-sm btn-light modal-url" data-url="/admin/logs-views/<?=$data['id']?>/"><i class="fas fa-eye" aria-hidden="true"></i></a>
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
<?php if($router['1']=='logs-views'){?>
	<div class="modal fade modal-load" tabindex="-1">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-body text-break">
	      	<pre><?=print_r($data['logs'])?></pre>
	      </div>
	    </div>
	  </div>
	</div>
<?php } ?>
<?php if($router['1']=='notification'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['thong-bao']?></h4>
			<ol class="breadcrumb">
			    <li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
			    <li class="breadcrumb-item active" aria-current="page"><?=$lang['thong-bao']?></li>
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
				            <th><?=$lang['ngay']?></th>
					        <th><?=$lang['tieu-de']?></th>
				            <th><?=$lang['noi-dung']?></th>
				            <th><?=$lang['duong-dan']?></th>
				            <th><?=$lang['luot-xem']?></th>
				            <th width="1%"></th>
					    </tr>
					  </thead>
					  <tbody>
					    <?php foreach ($datas as $data) {
	                        if($data['template']=='modal-url'){
	                          $echonoti = 'href="#" data-url="/admin/notification-views/'.$data['active'].'/" class="modal-url ms-2 me-auto pjax-notification"';
	                        }
	                        else {
	                          $echonoti = 'href="/admin/notification-views/'.$data['active'].'/" class="pjax-notification ms-2 me-auto pjax-load"';
	                        }
					    ?>
							<tr>
					            <td><?=date($setting['site_datetime'],strtotime($data['date']))?></td>
					            <td><?=$data['title']?></td>
					            <td><?=$data['content']?></td>
					            <td><?=$data['url']?></td>
					            <td>
					            	<?php if($data['views']==0) {?>
		                              <span class="badge  bg-danger p-2 me-2"><?=$data['views']?></span>
		                            <?php } ?>
		                            <?php if($data['views']>0) {?>
		                              <span class="badge  bg-success p-2 me-2"><?=$data['views']?></span>
		                            <?php } ?>
					            </td>
					            <td>
					            	<a <?=$echonoti?> data-active="<?=$data['active']?>"><i class="fas fa-eye" aria-hidden="true"></i></a>
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
					        <th><?=$lang['nhan-vien']?></th>
				            <th><?=$lang['ngay']?></th>
				            <th></th>
				            <th></th>
				            <th width="1%"></th>
					    </tr>
					  </thead>
					  <tbody>
					    <?php foreach ($datas as $data) { $personnels = $database->get("personnels", "*",["id"=>$data['personnels']]);?>
							<tr>
								<td><img src="<?=$data['images']?>" class="border border-light shadow-sm w-100"></td>
					            <td><?=$personnels['name']?></td>
					            <td><?=date($setting['site_datetime'],strtotime($data['date_face']))?></td>
					            <td><?=unserialize($data['content'])['deviceName']?></td>
					            <td><?=unserialize($data['content'])['personType']==0?$lang['nhan-vien']:'<span class="text-danger">'.$lang['nguoi-la'].'</span>'?></td>
					            <td>
					            	<a class="btn btn-sm btn-light modal-url" data-url="/admin/faceid-views/<?=$data['id']?>/"><i class="fas fa-eye" aria-hidden="true"></i></a>
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
<?php if($router['1']=='flood'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['danh-sach-chan']?></h4>
			<ol class="breadcrumb">
			    <li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
			    <li class="breadcrumb-item active" aria-current="page"><?=$lang['danh-sach-chan']?></li>
			</ol>
		</div>
	</nav>
	<div class="card card-custom">
		<div class="card-body">
			<form method="GET" class="pjax-content mb-4 search-form">
				<div class="form-group col-4">
				    <input placeholder="<?=$lang['tim-kiem']?>" type="text" name="name" value="<?=$xss->xss($_GET['name'])?>" class="form-control">
			    </div>
				<div class="form-group d-flex justify-content-start align-items-center">
					<?php if($jatbi->permission('flood.delete','button')==true){?>
						<a class="modal-url p-2 btn btn-danger me-2" data-array="true" data-url="/admin/flood-delete/1/"><i class="fas fa-trash" aria-hidden="true"></i> <?=$lang['xoa']?></a>
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
					    	<?php if($jatbi->permission('flood.delete','button')==true){?>
					      	<th width="1%" class="text-center">
								<div class="form-check">
								  <input class="form-check-input selectall" type="checkbox" value="" id="all">
								  <label class="form-check-label" for="all">
								  </label>
								</div>
					      	</th>
					      	<?php }?>
				            <th><?=$lang['ngay']?></th>
				            <th><?=$lang['ip']?></th>
				            <th><?=$lang['trinh-duyet']?></th>
				            <th width="1%"></th>
					    </tr>
					  </thead>
					  <tbody>
					    <?php foreach ($datas as $data) { ?>
							<tr>
								<?php if($jatbi->permission('flood.delete','button')==true){?>
					            <td class="align-middle">
				            		<div class="form-check">
										<input class="form-check-input checker" type="checkbox" id="<?=$data['id']?>" name="BOX[<?=$data['id']?>]" value="<?=$data['id']?>">
										<label class="form-check-label" for="<?=$data['id']?>"></label>
									</div>
					            </td>
					            <?php }?>
					            <td><?=date($setting['site_datetime'],strtotime($data['date']))?></td>
					            <td><?=$data['ip']?></td>
					            <td><?=$data['browsers']?></td>
					            <td>
					            	<a class="btn btn-sm btn-light modal-url" data-url="/admin/flood-views/<?=$data['id']?>/"><i class="fas fa-eye" aria-hidden="true"></i></a>
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
<?php if($router['1']=='flood-views'){?>
	<div class="modal fade modal-load" tabindex="-1">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-body text-break">
	      	<pre><?=print_r($data['logs'])?></pre>
	      </div>
	    </div>
	  </div>
	</div>
<?php } ?>
<?php if($router['1']=='flood-delete'){?>
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
<?php if($router['1']=='blockip'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['chan-truy-cap']?></h4>
			<ol class="breadcrumb">
			    <li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
			    <li class="breadcrumb-item active" aria-current="page"><?=$lang['chan-truy-cap']?></li>
			</ol>
		</div>
	</nav>
	<?php if($jatbi->permission('blockip.add','button')==true || $jatbi->permission('blockip.delete','button')==true){?>
	<div class="fixed-action-btn">
	    <a class="btn btn-large btn-primary rounded-circle">
	      <i class="fas fa-bars" aria-hidden="true"></i>
	    </a>
	    <ul>
	      <?php if($jatbi->permission('blockip.delete','button')==true){?>
	      <li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/admin/blockip-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
	      <?php }?>
	      <?php if($jatbi->permission('blockip.add','button')==true){?>
	      <li><a class="modal-url btn rounded-circle btn-info" data-url="/admin/blockip-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
					        <?php if($jatbi->permission('blockip.delete','button')==true){?>
					      	<th width="1%" class="text-center">
								<div class="form-check">
								  <input class="form-check-input selectall" type="checkbox" value="" id="all">
								  <label class="form-check-label" for="all">
								  </label>
								</div>
					      	</th>
					      	<?php }?>
					        <th><?=$lang['ip']?></th>
					        <th><?=$lang['noi-dung']?></th>
					        <th><?=$lang['trang-thai']?></th>
					        <th><?=$lang['ngay']?></th>
					        <?php if($jatbi->permission('blockip.edit','button')==true){?>
					        <th width="2%"></th>
					        <?php }?>
					    </tr>
					  </thead>
					  <tbody>
					    <?php foreach ($datas as $data) { ?>
							<tr>
				            <?php if($jatbi->permission('blockip.delete','button')==true){?>
				            <td class="align-middle">
			            		<div class="form-check">
									<input class="form-check-input checker" type="checkbox" id="<?=$data['id']?>" name="BOX[<?=$data['id']?>]" value="<?=$data['id']?>">
									<label class="form-check-label" for="<?=$data['id']?>"></label>
								</div>
				            </td>
				            <?php }?>
				            <td><?=$data['ip']?></td>
				            <td><?=$data['content']?></td>
				            <td>	
				            	<div class="form-check form-switch">
								  <input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/admin/blockip-status/<?=$data['id']?>/">
								  <label class="form-check-label" for="status"></label>
								</div>
				            </td>
				            <td><?=date($setting['site_datetime'],strtotime($data['date']))?></td>
				            <?php if($jatbi->permission('blockip.edit','button')==true){?>
				            	<td>
				            		<a class="btn btn-sm btn-light modal-url" data-url="/admin/blockip-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
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
<?php if($router['1']=='blockip-add' || $router['1']=='blockip-edit'){?>
	<div class="modal fade modal-load" tabindex="-1">
	  <div class="modal-dialog modal-sm">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title"><?=$router['1']=='blockip-add'?$lang['them']:$lang['sua']?> <?=$lang['chan-truy-cap']?></h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
	      <div class="modal-body">
	      	<div class="row">
		        <div class="col-sm-12">
		        	<div class="mb-3">
		        		<label><?=$lang['ip']?> <small class="text-danger">*</small></label>
					    <input placeholder="<?=$lang['ip']?>" type="text" name="ip" value="<?=$data['ip']?>" class="form-control">
				    </div>
				    <div class="mb-3">
		        		<label><?=$lang['noi-dung']?></label>
		        		<textarea name="content" class="form-control" style="height: 150px;"><?=$data['content']?></textarea>
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
<?php if($router['1']=='blockip-delete'){?>
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
<?php if($router['1']=='config'){?>
	<div class="modal fade modal-load" tabindex="-1">
	  <div class="modal-dialog modal-lg">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title"><?=$lang['cau-hinh']?></h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
	      <div class="modal-body">
	      	<div class="row">
		        <div class="col-sm-6">
		        	<div class="mb-3">
		        		<label><?=$lang['ten']?></label>
					    <input placeholder="<?=$lang['ten']?>" type="text" name="name" value="<?=$school['name']?>" class="form-control">
				    </div>
		        	<div class="mb-3">
		        		<label><?=$lang['dien-thoai']?></label>
					    <input placeholder="<?=$lang['dien-thoai']?>" type="text" name="phone" value="<?=$school['phone_number']?>" class="form-control">
				    </div>
		        	<div class="mb-3">
		        		<label><?=$lang['dia-chi']?></label>
					    <input placeholder="<?=$lang['dia-chi']?>" type="text" name="address" value="<?=$school['address']?>" class="form-control">
				    </div>
				    <div class="select-areas">
			        	
		        		<div class="mb-3 ">
				        	<label><?=$lang['gio-lam-viec']?></label>
			        		<div class="input-group">
							   	<input placeholder="<?=$lang['gio-lam-viec']?>" type="time" name="timework_from" value="<?=$data['timework_from']?>" class="form-control">
							   	<span class="input-group-text"><?=$lang['den-gio']?></span>
							   	<input placeholder="<?=$lang['gio-lam-viec']?>" type="time" name="timework_to" value="<?=$data['timework_to']?>" class="form-control">
						    </div>
						</div>
						<div class="mb-3">
							<label><?=$lang['ngay-lam-viec']?></label>
							<select name="week[]" class="select2 form-control" style="width:100%" multiple>
								<?php if($datas>1){
									foreach ($datas as $dat) {
									?>
										<?php if($dat['week']==1){?>
											<option value="<?=$dat['week']?>"  selected ><?=$lang['thu-hai']?></option>
										<?php }elseif($dat['week']==2){?>
											<option value="<?=$dat['week']?>"  selected ><?=$lang['thu-ba']?></option>
										<?php }elseif($dat['week']==3){?>
											<option value="<?=$dat['week']?>"  selected ><?=$lang['thu-tu']?></option>
										<?php }elseif($dat['week']==4){?>
											<option value="<?=$dat['week']?>"  selected ><?=$lang['thu-nam']?></option>
										<?php }elseif($dat['week']==5){?>
											<option value="<?=$dat['week']?>"  selected ><?=$lang['thu-sau']?></option>
										<?php }elseif($dat['week']==6){?>
											<option value="<?=$dat['week']?>"  selected ><?=$lang['thu-bay']?></option>
										<?php }elseif($dat['week']==7){?>
											<option value="<?=$dat['week']?>"  selected ><?=$lang['chu-nhat']?></option>
										<?php } ?>

									<?php }?>
								<?php } else{?>
									<option value="" disabled selected >Chọn</option>
								<?php } ?>
								<option value="1" ><?=$lang['thu-hai']?></option>
								<option value="2" ><?=$lang['thu-ba']?></option>	
								<option value="3" ><?=$lang['thu-tu']?></option>
								<option value="4" ><?=$lang['thu-nam']?></option>	
								<option value="5" ><?=$lang['thu-sau']?></option>
								<option value="6" ><?=$lang['thu-bay']?></option>	
								<option value="7" ><?=$lang['chu-nhat']?></option>	
							</select>
						</div>
						<div class="mb-3">
							<label><?=$lang['ngay-nghi']?></label>
							<select name="weekk[]" class="select2 form-control" style="width:100%" multiple>
								<?php if($datass>1){
									foreach ($datass as $dat) {
									?>
										<?php if($dat['week']==1){?>
											<option value="<?=$dat['week']?>"  selected ><?=$lang['thu-hai']?></option>
										<?php }elseif($dat['week']==2){?>
											<option value="<?=$dat['week']?>"  selected ><?=$lang['thu-ba']?></option>
										<?php }elseif($dat['week']==3){?>
											<option value="<?=$dat['week']?>"  selected ><?=$lang['thu-tu']?></option>
										<?php }elseif($dat['week']==4){?>
											<option value="<?=$dat['week']?>"  selected ><?=$lang['thu-nam']?></option>
										<?php }elseif($dat['week']==5){?>
											<option value="<?=$dat['week']?>"  selected ><?=$lang['thu-sau']?></option>
										<?php }elseif($dat['week']==6){?>
											<option value="<?=$dat['week']?>"  selected ><?=$lang['thu-bay']?></option>
										<?php }elseif($dat['week']==7){?>
											<option value="<?=$dat['week']?>"  selected ><?=$lang['chu-nhat']?></option>
										<?php } ?>

									<?php }?>
								<?php } else{?>
									<option value="" disabled selected >Chọn</option>
								<?php } ?>
								<option value="1" ><?=$lang['thu-hai']?></option>
								<option value="2" ><?=$lang['thu-ba']?></option>	
								<option value="3" ><?=$lang['thu-tu']?></option>
								<option value="4" ><?=$lang['thu-nam']?></option>	
								<option value="5" ><?=$lang['thu-sau']?></option>
								<option value="6" ><?=$lang['thu-bay']?></option>	
								<option value="7" ><?=$lang['chu-nhat']?></option>	
							</select>
						</div>
					</div>
		        </div>
		        <div class="col-sm-6">
		        	<div class="mb-3">
		        		<label><?=$lang['so-trang']?></label>
					    <input placeholder="<?=$lang['so-trang']?>" type="text" name="page" value="<?=$data['page']?>" class="form-control">
				    </div>
		        	<div class="mb-3">
		        		<label><?=$lang['ky-tu-tai-khoan']?></label>
					    <input placeholder="<?=$lang['ky-tu-tai-khoan']?>" type="text" name="characters" value="<?=$data['characters']?>" class="form-control">
				    </div>
		        	<div class="mb-3">
		        		<label><?=$lang['dinh-dang-ngay']?></label>
					   	<input placeholder="<?=$lang['dinh-dang-ngay']?>" type="text" name="date" value="<?=$data['date']?>" class="form-control">
				    </div>
		        	<div class="mb-3">
		        		<label><?=$lang['dinh-dang-gio']?></label>
					   	<input placeholder="<?=$lang['dinh-dang-gio']?>" type="text" name="time" value="<?=$data['time']?>" class="form-control">
				    </div>
				    <div class="mb-3">
		        		<label><?=$lang['noi-dung']?></label>
		        		<textarea name="content" class="form-control" style="height: 184px;"><?=$data['content']?></textarea>
				    </div>
		        </div>
		        <div class="col-sm-12">
		        	<div class="mb-3 preview-images">
		        		<label><?=$lang['logo-cong-ty']?></label>
					    <input placeholder="Logo" type="file" name="logo" value="<?=$data['name']?>" class="form-control getImg">
		        		<img src="/<?=$upload['images']['logo']['url'].$data['logo']?>" id="preview-data" class="w-100 p-3 rounded mt-3 border border-light" style="<?=$data['logo']==''?'display: none':''?>">
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
<?php if($router['1']=='projects-task'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['cong-viec-du-an']?></h4>
			<ol class="breadcrumb">
			    <li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
			    <li class="breadcrumb-item active" aria-current="page"><?=$lang['cong-viec-du-an']?></li>
			</ol>
		</div>
	</nav>
	<?php if($jatbi->permission('projects-task.add','button')==true || $jatbi->permission('projects-task.delete','button')==true){?>
	<div class="fixed-action-btn">
	    <a class="btn btn-large btn-primary rounded-circle">
	      <i class="fas fa-bars" aria-hidden="true"></i>
	    </a>
	    <ul>
	      <?php if($jatbi->permission('projects-task.delete','button')==true){?>
	      <li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/admin/projects-task-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
	      <?php }?>
	      <?php if($jatbi->permission('projects-task.add','button')==true){?>
	      <li><a class="modal-url btn rounded-circle btn-info" data-url="/admin/projects-task-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
					        <?php if($jatbi->permission('projects-task.delete','button')==true){?>
					      	<th width="1%" class="text-center">
								<div class="form-check">
								  <input class="form-check-input selectall" type="checkbox" value="" id="all">
								  <label class="form-check-label" for="all">
								  </label>
								</div>
					      	</th>
					      	<?php }?>
					        <th><?=$lang['ten']?></th>
					        <th><?=$lang['noi-dung']?></th>
					        <th><?=$lang['loai']?></th>
					        <th><?=$lang['nhan-vien']?></th>
					        <th><?=$lang['bo-phan']?></th>
					        <th><?=$lang['thoi-gian']?></th>
					        <th><?=$lang['trang-thai']?></th>
					        <?php if($jatbi->permission('projects-task.edit','button')==true){?>
					        <th width="2%"></th>
					        <?php }?>
					    </tr>
					  </thead>
					  <tbody>
					    <?php foreach ($datas as $data) { ?>
							<tr>
				            <?php if($jatbi->permission('projects-task.delete','button')==true){?>
				            <td class="align-middle">
			            		<div class="form-check">
									<input class="form-check-input checker" type="checkbox" id="<?=$data['id']?>" name="BOX[<?=$data['id']?>]" value="<?=$data['id']?>">
									<label class="form-check-label" for="<?=$data['id']?>"></label>
								</div>
				            </td>
				            <?php }?>
				            <td><?=$data['name']?></td>
				            <td><?=$data['content']?></td>
				            <td>
				            	<?=($data['type']=='1'?'Giao đến cho nhân viên khởi tạo':'')?>
				            	<?=($data['type']=='2'?'Giao đến cho nhân viên chỉ định':'')?>
				            	<?=($data['type']=='3'?'Giao đến cho 1 bộ phận':'')?>
				            </td>
				            <td>
				            	<?php foreach (unserialize($data['accounts']) as $key => $value) {?>
				            		<p class="mb-0 small"><?=$database->get("accounts","name",["id"=>$value])?></p>
				            	<?php } ?>
				            </td>
				            <td>
				            	<?php foreach (unserialize($data['offices']) as $key => $value_offices) {?>
				            		<p class="mb-0 small"><?=$database->get("offices","name",["id"=>$value_offices])?></p>
				            	<?php } ?>
				            </td>
				            <td><?=$data['time']?> <?=$lang['ngay']?></td>
				            <td>	
				            	<div class="form-check form-switch">
								  <input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/admin/projects-task-status/<?=$data['id']?>/">
								  <label class="form-check-label" for="status"></label>
								</div>
				            </td>
				            <?php if($jatbi->permission('projects-task.edit','button')==true){?>
				            	<td>
				            		<a class="btn btn-sm btn-light modal-url" data-url="/admin/projects-task-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
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
<?php if($router['1']=='projects-task-add' || $router['1']=='projects-task-edit'){?>
	<div class="modal fade modal-load" tabindex="-1">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title"><?=$router['1']=='projects-task-add'?$lang['them']:$lang['sua']?> <?=$lang['cong-viec-du-an']?></h5>
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
		        		<label><?=$lang['noi-dung']?></label>
		        		<textarea name="content" class="form-control" style="height: 150px;"><?=$data['content']?></textarea>
				    </div>
		        	<div class="mb-3">
		        		<label><?=$lang['muc-do-uu-tien']?> <small class="text-danger">*</small></label>
					    <input placeholder="<?=$lang['muc-do-uu-tien']?>" type="text" name="position" value="<?=$data['position']?>" class="form-control">
				    </div>
				    <div class="mb-3">
		        		<label><?=$lang['loai']?> <small class="text-danger">*</small></label>
				    	<select name="type" class="select2 form-control type" style="width:100%">
					      <option value="1" <?=($data['type']=='1'?'selected':'')?>>Giao đến cho nhân viên khởi tạo</option>
					      <option value="2" <?=($data['type']=='2'?'selected':'')?>>Giao đến cho nhân viên chỉ định</option>
					      <!-- <option value="3" <?=($data['type']=='3'?'selected':'')?>>Giao đến cho 1 bộ phận</option> -->
					    </select>
				    </div>
				    <div class="mb-3 accounts" <?=$data['type']==2?'style="display:block"':'style="display:none"'?>>
		        		<label><?=$lang['nhan-vien']?> <small class="text-danger">*</small></label>
				    	<select name="accounts[]" class="select2 form-control" style="width:100%" multiple>
				    		<?php foreach ($accounts as $key => $account) {?>
				    		<option value="<?=$account['id']?>" <?=($vaccounts[$account['id']]==$account['id']?'selected':'')?>><?=$account['name']?></option>
				    		<?php } ?>
					    </select>
				    </div>
				    <div class="mb-3">
		        		<label><?=$lang['nguoi-theo-doi']?></label>
				    	<select name="views[]" class="select2 form-control" style="width:100%" multiple>
				    		<?php foreach ($accounts as $key => $account) {?>
				    		<option value="<?=$account['id']?>" <?=($vviews[$account['id']]==$account['id']?'selected':'')?>><?=$account['name']?></option>
				    		<?php } ?>
					    </select>
				    </div>
				   <!--  <div class="mb-3 offices" <?=$data['type']==3?'style="display:block"':'style="display:none"'?>>
		        		<label><?=$lang['bo-phan']?> <small class="text-danger">*</small></label>
				    	<select name="offices[]" class="select2 form-control" style="width:100%" multiple>
				    		<?php foreach ($offices as $key => $office) {?>
				    		<option value="<?=$office['id']?>" <?=($voffices[$office['id']]==$office['id']?'selected':'')?>><?=$office['name']?></option>
				    		<?php } ?>
					    </select>
				    </div> -->
				    <div class="mb-3">
		        		<label><?=$lang['dieu-kien-trang-thai']?> <small class="text-danger">*</small></label>
				    	<select name="process" class="select2 form-control" style="width:100%">
				    		<option value=""><?=$lang['dieu-kien-trang-thai']?></option>
				    		<?php foreach ($projects_status as $key => $projects_statu) {?>
				    		<option value="<?=$projects_statu['id']?>" <?=($data['process']==$projects_statu['id']?'selected':'')?>><?=$projects_statu['name']?></option>
				    		<?php } ?>
					    </select>
				    </div>
		        	<div class="mb-3">
		        		<label><?=$lang['thoi-gian-hoan-thanh-cong-viec']?> <small class="text-danger">*</small></label>
		        		<div class="input-group">
					    	<input placeholder="<?=$lang['thoi-gian-hoan-thanh-cong-viec']?>" type="text" name="time" value="<?=$data['time']?>" class="form-control">
					    	<span class="input-group-text"><?=$lang['ngay']?></span>
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
		$(".type").on("change",function() {
			if($(this).val()==1){
				$(".accounts").hide();
				$(".offices").hide();
			}
			if($(this).val()==2){
				$(".accounts").show();
				$(".offices").hide();
			}
			if($(this).val()==3){
				$(".accounts").hide();
				$(".offices").show();
			}
		})
	</script>
<?php } ?>
<?php if($router['1']=='projects-task-delete'){?>
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