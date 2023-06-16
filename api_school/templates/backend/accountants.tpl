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
	      <li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/accountants/expenditure-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
	      <?php }?>
	      <?php if($jatbi->permission('expenditure.add','button')==true){?>
	      <li><a class="modal-url btn rounded-circle btn-info" data-url="/accountants/expenditure-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
					        <?php if($jatbi->permission('expenditure.delete','button')==true){?>
					      	<th rowspan="2" width="1%" class="text-center align-middle">
								<div class="form-check">
								  <input class="form-check-input selectall" type="checkbox" value="" id="all">
								  <label class="form-check-label" for="all">
								  </label>
								</div>
					      	</th>
					      	<?php }?>
					        <th colspan="3" class="align-middle text-center"><?=$lang['chung-tu']?></th>
					        <th rowspan="2" class="align-middle text-center"><?=$lang['dien-giai']?></th>
					        <th rowspan="2" class="align-middle text-center"><?=$lang['doi-tuong']?></th>
					        <th colspan="2" class="align-middle text-center"><?=$lang['tai-khoan']?></th>
					        <th colspan="3" class="align-middle text-center"><?=$lang['so-tien']?></th>
					        <?php if($jatbi->permission('expenditure.edit','button')==true){?>
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
					  		<td class="text-end text-success fw-bold"><?=number_format($total_first_thu)?></td>
				            <td class="text-end text-danger fw-bold"><?=number_format($total_first_chi)?></td>
				            <td class="text-end fw-bold"><?=number_format($total_first_thu+$total_first_chi)?></td>
				            <?php if($jatbi->permission('expenditure.edit','button')==true){?>
				            <td></td>
				        	<?php } ?>
					  	</tr>
					  </thead>
					  <tbody>
					    <?php 
					    	$total_first = $total_first_thu+$total_first_chi;
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
				            <?php if($jatbi->permission('expenditure.delete','button')==true){?>
					            <td class="align-middle">
				            		<div class="form-check">
										<input class="form-check-input checker" type="checkbox" id="<?=$data['id']?>" name="BOX[<?=$data['id']?>]" value="<?=$data['id']?>">
										<label class="form-check-label" for="<?=$data['id']?>"></label>
									</div>
					            </td>
					            <td>
					            	<a href="#!" class="modal-url" data-url="/accountants/expenditure-views/<?=$data['id']?>/"><?=date($setting['site_date'],strtotime($data['date']))?></a>
					            </td>
					            <td class="text-center"><?=$data['type']==1?$data['ballot']:''?></td>
					            <td class="text-center"><?=$data['type']==2?$data['ballot']:''?></td>
					            <td><?=$data['content']?></td>
					            <td>
					            	<?php if($data['projects']!=0){ $Getprojects = $database->get("projects","*",["id"=>$data['projects'],"deleted"=>0]);?>
					            		<p class="mb-0"><a href="#!" class="modal-url" data-url="/projects/projects-views/<?=$Getprojects['id']?>">#<?=$ballot_code['projects']?>-<?=$Getprojects['code']?></a></p>
					            	<?php } ?>
					            	<?php if($data['proposal']!=0){ $Getproposal = $database->get("proposal","*",["id"=>$data['proposal'],"deleted"=>0]);?>
					            		<p class="mb-0"><a href="#!" class="modal-url" data-url="/proposal/proposal-views/<?=$Getproposal['id']?>">#<?=$ballot_code['proposal']?>-<?=$Getproposal['code']?></a></p>
					            	<?php } ?>
					            	<?php if($data['customers']!='' || $data['customers']!=0){$GetCustomers = $database->get("customers","*",["id"=>$data['customers'],"deleted"=>0]);?>
					            		<p class="mb-0"><?=$GetCustomers['name']?></p>
					            	<?php } ?>
					            	<?php if($data['personnels']!='' || $data['personnels']!=0){$GetPersonnel = $database->get("personnels","*",["id"=>$data['personnels'],"deleted"=>0]);?>
					            		<p class="mb-0"><?=$GetPersonnel['name']?></p>
					            	<?php } ?>
					            	<?php if($data['vendor']!='' || $data['vendor']!=0){ $Getvendor = $database->get("vendors","*",["id"=>$data['vendor'],"deleted"=>0]);?>
					            		<p class="mb-0"><?=$Getvendor['name']?></p>
					            	<?php } ?>
					            </td>
					            <td class="text-center fw-bold"><?=$database->get("accountants_code","code",["id"=>$data['debt']])?></td>
					            <td class="text-center fw-bold"><?=$database->get("accountants_code","code",["id"=>$data['has']])?></td>
					            <td class="text-end text-success fw-bold"><?=number_format($thu)?></td>
					            <td class="text-end text-danger fw-bold"><?=number_format($chi)?></td>
					            <td class="text-end fw-bold"><?=number_format($expenditure+$thu+$chi)?></td>
					            <?php if($jatbi->permission('expenditure.edit','button')==true){?>
				            	<td>
				            		<a class="btn btn-sm btn-light modal-url" data-url="/accountants/expenditure-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
				            	</td>
					            <?php }?>
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
					   	<select name="type" class="select2 form-control" style="width:100%">
					   		<option value=""><?=$lang['loai']?></option>
			        		<?php foreach ($expenditure_type as $key => $type) { ?>
			        			<option value="<?=$type['id']?>" <?=$data['type']==$type['id']?'selected':''?>><?=$type['name']?></option>
			        		<?php } ?>
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
				        			<option value="<?=$debt['id']?>" <?=$data['debt']==$debt['id']?'selected':''?>><?=$debt['code']?> - <?=$debt['name']?></option>
				        		<?php } ?>
						    </select>
					    </div>
			        	<div class="col-md-6 mb-3">
			        		<label><?=$lang['tai-khoan-co']?> <small class="text-danger">*</small></label>
						   	<select name="has" class="select2 form-control" style="width:100%">
						   		<option value=""><?=$lang['tai-khoan-co']?></option>
				        		<?php foreach ($accountants as $key => $has) { ?>
				        			<option value="<?=$has['id']?>" <?=$data['has']==$has['id']?'selected':''?>><?=$has['code']?> - <?=$has['name']?></option>
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
		        		<textarea name="content" class="form-control" style="height: 235px;"><?=$data['content']?></textarea>
				    </div>
		        </div>
		        <div class="col-sm-6">
				    <div class="card mb-3">
				    	<div class="card-header"><?=$lang['doi-tuong']?></div>
				    	<div class="card-body">
				    		<div class="mb-3">
				        		<label><?=$lang['khach-hang']?></label>
							   	<select name="customers" class="select2 form-control" style="width:100%">
							   		<option value=""><?=$lang['khach-hang']?></option>
					        		<?php foreach ($customers as $key => $customer) { ?>
					        			<option value="<?=$customer['id']?>" <?=$data['customers']==$customer['id']?'selected':''?>><?=$customer['name']?></option>
					        		<?php } ?>
							    </select>
						    </div>
				    		<div class="mb-3">
				        		<label><?=$lang['du-an']?></label>
							   	<select name="projects" class="select2 form-control" style="width:100%">
							   		<option value=""><?=$lang['du-an']?></option>
					        		<?php foreach ($projects as $key => $project) { ?>
					        			<option value="<?=$project['id']?>" <?=$data['projects']==$project['id']?'selected':''?>>#<?=$ballot_code['projects']?>-<?=$project['code']?></option>
					        		<?php } ?>
							    </select>
						    </div>
				    		<div class="mb-3">
				        		<label><?=$lang['nhan-vien']?></label>
							   	<select name="personnels" class="select2 form-control" style="width:100%">
							   		<option value=""><?=$lang['nhan-vien']?></option>
					        		<?php foreach ($personnels as $key => $personnel) { ?>
					        			<option value="<?=$personnel['id']?>" <?=$data['personnels']==$personnel['id']?'selected':''?>><?=$personnel['name']?></option>
					        		<?php } ?>
							    </select>
						    </div>
				    		<div class="mb-3">
				        		<label><?=$lang['nha-cung-cap']?></label>
							   	<select name="vendor" class="select2 form-control" style="width:100%">
							   		<option value=""><?=$lang['nha-cung-cap']?></option>
					        		<?php foreach ($vendors as $key => $vendor) { ?>
					        			<option value="<?=$vendor['id']?>" <?=$data['vendor']==$vendor['id']?'selected':''?>><?=$vendor['name']?></option>
					        		<?php } ?>
							    </select>
						    </div>
				    		<div class="mb-3">
				        		<label><?=$lang['de-xuat']?></label>
							   	<select name="proposal" class="select2 form-control" style="width:100%">
							   		<option value=""><?=$lang['de-xuat']?></option>
							   		<?php foreach ($proposals as $key => $proposal) { ?>
					        			<option value="<?=$proposal['id']?>" <?=$data['proposal']==$proposal['id']?'selected':''?>>#<?=$ballot_code['proposal']?>-<?=$proposal['code']?></option>
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
<?php if($router['1']=='expenditure-views'){?>
	<div class="modal fade modal-load" tabindex="-1">
	  <div class="modal-dialog modal-lg">
	    <div class="modal-content">
	      <div class="modal-header d-print-none">
	        <h5 class="modal-title"><?=$data['type']==1?$lang['phieu-thu']:$lang['phieu-chi']?></h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <div class="modal-body">
	      	<table class="w-100">
	      		<tr>
	      			<td class="text-start align-top">
	      				<h6 class="fw-bold"><?=$getsetting['name']?></h6>
		      			<p class="mb-0">
		      				<?=$getsetting['address']?>
		      				<?=$database->get("ward","name",["id"=>$getsetting['ward']])?>
		      				<?=$database->get("district","name",["id"=>$getsetting['district']])?>
		      				<?=$database->get("province","name",["id"=>$getsetting['province']])?>
		      			</p>
		      			<p class="mb-0">
		      				<?=$getsetting['phone']?>
		      			</p>
	      			</td>
	      			<td class="text-end align-top">
	      				<strong>Mẫu số 02 - TT</strong>
	      				<p class="fst-italic mb-0">(Ban hành theo TT200/2014/TT-BTC)</p>
	      				<p class="mb-0"><strong>Số:</strong> <span class="me-4"><?=$data['ballot']?></span></p>
	      				<p class="mb-0"><strong>Nợ:</strong> <span class="me-4 fw-bold"><?=$database->get("accountants_code","code",["id"=>$data['debt']])?></span> <strong><?=str_replace('-','',number_format($data['price']))?></strong></p>
	      				<p class="mb-0"><strong>Có:</strong> <span class="me-4 fw-bold"><?=$database->get("accountants_code","code",["id"=>$data['has']])?></span> <strong><?=str_replace('-','',number_format($data['price']))?></strong></p>
	      			</td>
	      		</tr>
	      		<tr>
	      			<td colspan="2" class="text-center">
	      				<h3 class="fw-bold text-uppercase"><?=$data['type']==1?$lang['phieu-thu']:$lang['phieu-chi']?></h3>
	      				<p class="fst-italic">Ngày <?=date("d",strtotime($data['date']))?> Tháng <?=date("m",strtotime($data['date']))?> Năm <?=date("Y",strtotime($data['date']))?></p>
	      			</td>
	      		</tr>
	      	</table>
	      	<table class="w-100">
	      		<tr>
	      			<td width="5%" class="text-nowrap">Họ tên người nhận tiền:</td>
	      			<td class="fw-bold"><?=$GetPersonnel['name']?></td>
	      		</tr>
	      		<tr>
	      			<td width="5%" class="text-nowrap">Địa chỉ:</td>
	      			<td></td>
	      		</tr>
	      		<tr>
	      			<td width="5%" class="text-nowrap">Lý do:</td>
	      			<td class="fw-bold"><?=$data['content']?></td>
	      		</tr>
	      		<tr>
	      			<td width="5%" class="text-nowrap">Số tiền:</td>
	      			<td class="fw-bold"><?=str_replace('-','',number_format($data['price']))?></td>
	      		</tr>
	      		<tr>
	      			<td width="5%" class="text-nowrap">Chứng từ gốc:</td>
	      			<td class="fw-bold"></td>
	      		</tr>
	      	</table>
	      	<table class="w-100 mt-2">
	      		<tr>
	      			<td class="text-end" colspan="5">
	      				<p class="fst-italic">Ngày <?=date("d",strtotime($data['date']))?> Tháng <?=date("m",strtotime($data['date']))?> Năm <?=date("Y",strtotime($data['date']))?></p>
	      			</td>
	      		</tr>
	      		<tr>
	      			<td class="text-center" width="20%">
	      				<strong>Giám đốc</strong>
	      				<p class="fst-italic small">(Ký họ tên, đóng dấu)</p>
	      			</td>
	      			<td class="text-center" width="20%">
	      				<strong>Kế toán trưởng</strong>
	      				<p class="fst-italic small">(Ký họ tên)</p>
	      			</td>
	      			<td class="text-center" width="20%">
	      				<strong>Người nhận tiền</strong>
	      				<p class="fst-italic small">(Ký họ tên)</p>
	      			</td>
	      			<td class="text-center" width="20%">
	      				<strong>Người lập phiếu</strong>
	      				<p class="fst-italic small">(Ký họ tên)</p>
	      			</td>
	      			<td class="text-center" width="20%">
	      				<strong>Thủ quỹ</strong>
	      				<p class="fst-italic small">(Ký họ tên)</p>
	      			</td>
	      		</tr>
	      		<tr>
	      			<td style="height:100px" class="text-center align-bottom" width="20%">
	      				<strong>Trần Minh Tâm</strong>
	      			</td>
	      			<td style="height:100px" class="text-center align-bottom" width="20%">
	      				<strong></strong>
	      			</td>
	      			<td style="height:100px" class="text-center align-bottom" width="20%">
	      				<strong><?=$GetPersonnel['name']?></strong>
	      			</td>
	      			<td style="height:100px" class="text-center align-bottom" width="20%">
	      				<strong>Trần Thị Kim Hoa</strong>
	      			</td>
	      			<td style="height:100px" class="text-center align-bottom" width="20%">
	      				<strong>Trần Thị Kim Hoa</strong>
	      			</td>
	      		</tr>
	      		<tr>
	      			<td class="text-start" colspan="5">
	      				<p class="fst-italic mb-0 pt-3">Đã nhận đủ số tiền (Viết bằng chữ):</p>
	      				<p class="fst-italic">(Liên gửi ra ngoài phải đóng dấu)</p>
	      			</td>
	      		</tr>
	      	</table>
	      </div>
	      <div class="modal-footer d-print-none">
	      	<input type="hidden" name="token" value="<?=$_SESSION['csrf']['token']?>">
	        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?=$lang['huy']?></button>
	        <button class="btn btn-success" onclick="window.print();">IN</button>
	      </div>
	    </div>
	  </div>
	</div>
<?php } ?>
<?php if($router['1']=='accounts-code'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['ma-tai-khoan']?></h4>
			<ol class="breadcrumb">
			    <li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
			    <li class="breadcrumb-item active" aria-current="page"><?=$lang['ma-tai-khoan']?></li>
			</ol>
		</div>
	</nav>
	<?php if($jatbi->permission('accounts-code.add','button')==true || $jatbi->permission('accounts-code.delete','button')==true){?>
	<div class="fixed-action-btn">
	    <a class="btn btn-large btn-primary rounded-circle">
	      <i class="fas fa-bars" aria-hidden="true"></i>
	    </a>
	    <ul>
	      <?php if($jatbi->permission('accounts-code.delete','button')==true){?>
	      <li><a class="modal-url btn rounded-circle btn-danger" data-array="true" data-url="/accountants/accounts-code-delete/"><i class="fas fa-trash" aria-hidden="true"></i></a></li>
	      <?php }?>
	      <?php if($jatbi->permission('accounts-code.add','button')==true){?>
	      <li><a class="modal-url btn rounded-circle btn-info" data-url="/accountants/accounts-code-add/"><i class="fas fa-plus" aria-hidden="true"></i></a></li>
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
					        <?php if($jatbi->permission('accounts-code.delete','button')==true){?>
					      	<th width="1%" class="text-center align-middle">
								<div class="form-check">
								  <input class="form-check-input selectall" type="checkbox" value="" id="all">
								  <label class="form-check-label" for="all">
								  </label>
								</div>
					      	</th>
					      	<?php }?>
					        <th colspan="2" class="text-center"><?=$lang['ma-tai-khoan']?></th>
					        <th class="align-middle"><?=$lang['ten']?></th>
					        <th class="align-middle"><?=$lang['ghi-chu']?></th>
					        <th class="align-middle"><?=$lang['trang-thai']?></th>
					        <?php if($jatbi->permission('accounts-code.edit','button')==true){?>
					        <th width="2%"></th>
					        <?php }?>
					    </tr>
					  </thead>
					  <tbody>
					    <?php foreach ($datas as $data) { $SelectMains = $database->select("accountants_code", "*",["deleted"=> 0,"status"=>'A',"main"=>$data['id']]);?>
							<tr>
				            <?php if($jatbi->permission('accounts-code.delete','button')==true){?>
				            <td class="align-middle">
			            		<div class="form-check">
									<input class="form-check-input checker" type="checkbox" id="<?=$data['id']?>" name="BOX[<?=$data['id']?>]" value="<?=$data['id']?>">
									<label class="form-check-label" for="<?=$data['id']?>"></label>
								</div>
				            </td>
				            <?php }?>
				            <td><?=$data['code']?></td>
				            <td></td>
				            <td><?=$data['name']?></td>
				            <td><?=$data['notes']?></td>
				            <td>	
				            	<div class="form-check form-switch">
								  <input class="form-check-input update-status" type="checkbox" id="status" <?=$data['status']=='A'?'checked':''?> data-status="/accountants/accounts-code-status/<?=$data['id']?>/">
								  <label class="form-check-label" for="status"></label>
								</div>
				            </td>
				            <?php if($jatbi->permission('accounts-code.edit','button')==true){?>
				            	<td>
				            		<a class="btn btn-sm btn-light modal-url" data-url="/accountants/accounts-code-edit/<?=$data['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
				            	</td>
				            <?php }?>
					      </tr>
					       <?php foreach ($SelectMains as $SelectMain) { ?>
								<tr>
					            <?php if($jatbi->permission('accounts-code.delete','button')==true){?>
					            <td class="align-middle">
				            		<div class="form-check">
										<input class="form-check-input checker" type="checkbox" id="<?=$data['id']?>" name="BOX[<?=$SelectMain['id']?>]" value="<?=$data['id']?>">
										<label class="form-check-label" for="<?=$data['id']?>"></label>
									</div>
					            </td>
					            <?php }?>
					            <td></td>
					            <td><?=$SelectMain['code']?></td>
					            <td><?=$SelectMain['name']?></td>
					            <td><?=$SelectMain['notes']?></td>
					            <td>	
					            	<div class="form-check form-switch">
									  <input class="form-check-input update-status" type="checkbox" id="status" <?=$SelectMain['status']=='A'?'checked':''?> data-status="/accountants/accounts-code-status/<?=$SelectMain['id']?>/">
									  <label class="form-check-label" for="status"></label>
									</div>
					            </td>
					            <?php if($jatbi->permission('accounts-code.edit','button')==true){?>
					            	<td>
					            		<a class="btn btn-sm btn-light modal-url" data-url="/accountants/accounts-code-edit/<?=$SelectMain['id']?>/"><i class="fas fa-edit" aria-hidden="true"></i></a>
					            	</td>
					            <?php }?>
						      </tr>
					    	<?php } ?>
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
<?php if($router['1']=='accounts-code-add' || $router['1']=='accounts-code-edit'){?>
	<div class="modal fade modal-load" tabindex="-1">
	  <div class="modal-dialog modal-sm">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title"><?=$router['1']=='accounts-code-add'?$lang['them']:$lang['sua']?> <?=$lang['ma-tai-khoan']?></h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <form method="POST" autocomplete="off" enctype="multipart/form-data" class="ajax-form" autocomplete="off">
	      <div class="modal-body">
	      	<div class="row">
		        <div class="col-sm-12">
		        	<div class="mb-3">
		        		<label><?=$lang['cap-do']?> <small class="text-danger">*</small></label>
					   	<select name="main" class="select2 form-control" style="width:100%">
					   		<option value="0"><?=$lang['cap-do-chinh']?></option>
			        		<?php foreach ($accountants_codes as $key => $accountants_code) { ?>
			        			<option value="<?=$accountants_code['id']?>" <?=$data['main']==$accountants_code['id']?'selected':''?>><?=$accountants_code['code']?> - <?=$accountants_code['name']?></option>
			        		<?php } ?>
					    </select>
				    </div>
		        	<div class="mb-3">
		        		<label><?=$lang['ma-tai-khoan']?> <small class="text-danger">*</small></label>
					    <input placeholder="<?=$lang['ma-tai-khoan']?>" type="text" name="code" value="<?=$data['code']?>" class="form-control">
				    </div>
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
<?php if($router['1']=='accounts-code-delete'){?>
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