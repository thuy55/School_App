<?php if($router['1']=='report-timecodes'){?>
	<nav class="d-flex justify-content-between align-items-center" aria-label="breadcrumb">
		<div class="">
			<h4><?=$lang['bao-cao-ma-gio']?></h4>
			<ol class="breadcrumb">
			    <li class="breadcrumb-item"><a href="/"><?=$lang['trang-chu']?></a></li>
			    <li class="breadcrumb-item active" aria-current="page"><?=$lang['bao-cao-ma-gio']?></li>
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
		    	<!-- <pre><?=print_r($datas)?></pre> -->
				<div class="table-responsive">
					<table class="table table-bordered table-hover align-middle">
					  <thead>
					    <tr>
					    	<th rowspan="3" class="align-middle" width="50">STT</th>
					        <th rowspan="3" class="align-middle"><?=$lang['khach-hang']?></th>
				            <th rowspan="3" class="align-middle"><?=$lang['du-an']?></th>
				            <th rowspan="3" class="align-middle"><?=$lang['san-pham']?></th>
				            <th rowspan="3" class="align-middle"><?=$lang['thoi-luong']?></th>
				            <?php foreach ($jatbi->getDatesFromRange($date_from,$date_to) as $key => $value) {
				            	$month = date("m",strtotime($value));
				            	if($month==$month){
				            		$colspan[$month]['colspan'] += 1;
				            		$colspan[$month]['month'] = $month;
				            	}
				            ?>
							<?php } ?>
							<?php foreach ($colspan as $key => $value) {?>
								<td class="text-center align-middle text-nowrap" colspan="<?=$value['colspan']?>"><?=$lang['thang']?> <?=$value['month']?></td>
							<?php } ?>
				            <th rowspan="3" class="align-middle"><?=$lang['tong-cong']?></th>
				            <th rowspan="3" class="align-middle"><?=$lang['thoi-luong']?></th>
					    </tr>
					    <tr>
							<?php foreach ($jatbi->getDatesFromRange($date_from,$date_to) as $key => $value) {?>
								<td class="text-center"><?=$jatbi->week(date("N",strtotime($value)))?></td>
							<?php } ?>
						</tr>
					    <tr>
							<?php foreach ($jatbi->getDatesFromRange($date_from,$date_to) as $key => $value) {?>
								<td class="text-center"><?=date("d",strtotime($value))?></td>
							<?php } ?>
						</tr>
					  </thead>
					  <tbody>
					    <?php $stt = 1; foreach ($datas as $data) { 
					    ?>
					    	<tr>
					    		<td colspan="100"  class="bg-primary bg-opacity-25 fw-bold text-danger"><?=$data['name']?></td>
					    	</tr>
					    	<?php foreach ($data['targets'] as $key => $target) { 
					    	?>
								<tr>
									<td class="text-nowrap text-center"><?=$stt++?></td>
									<td class="text-nowrap"><?=$target['customers']?></td>
									<td class="text-nowrap"><?=$target['projects']?></td>
									<td class="text-nowrap"><?=$target['name']?></td>
									<td class="text-nowrap text-center fw-bold text-primary"><?=$target['count']?></td>
									<?php foreach ($jatbi->getDatesFromRange($date_from,$date_to) as $key => $value) { $total[$data['id']][$value] += $target['timecode'][$value]['sum'];
									?>
										<td class="text-nowrap text-center modal-url timecode-plan <?=$target['timecode'][$value]['status']?>" data-url="/projects/projects-timecodes/<?=$target['id']?>/<?=$value?>/">
											<?=$target['timecode'][$value]['sum']?>
										</td>
									<?php } ?>
									<td class="text-nowrap text-center fw-bold"><?=$target['total_count']?></td>
									<td class="text-nowrap text-center fw-bold"><?=$target['total_sum']?></td>
						        </tr>
						    <?php } ?>
					        <tr class="bg-info bg-opacity-10">
					        	<td colspan="5" class="text-end">Thời lượng PSC đạt cam kết</td>
								<?php foreach ($jatbi->getDatesFromRange($date_from,$date_to) as $key => $value) { $total_min[$data['id']] += $data['time_min'];?>
									<td class="text-center fw-bold"><?=$data['time_min']>0?$data['time_min']:''?></td>
								<?php } ?>
								<td class="text-nowrap"></td>
								<td class="text-nowrap text-center fw-bold"><?=$total_min[$data['id']]>0?number_format($total_min[$data['id']]):''?></td>
					        </tr>
					        <tr>
					        	<td colspan="5" class="text-end">Lịch PSC book thực tế</td>
								<?php foreach ($jatbi->getDatesFromRange($date_from,$date_to) as $key => $value) { 
									$gettotal = $total[$data['id']][$value];
									if($gettotal<$data['time_min']){
										$total_bg = 'text-danger';
									}
									elseif($gettotal>=$data['time_min'] && $gettotal<=$data['time_max']){
										$total_bg = 'text-primary bg-opacity-50';
									}
									elseif($gettotal>=$data['time_min'] && $gettotal>$data['time_max']){
										$total_bg = 'bg-danger text-dark bg-opacity-10';
									}
								?>
									<td class="text-center <?=$total_bg?>"><?=$gettotal>0?$gettotal:''?></td>
								<?php } ?>
								<td class="text-nowrap"></td>
								<td class="text-nowrap"></td>
					        </tr>
					        <tr class="bg-info bg-opacity-10">
					        	<td colspan="5" class="text-end">Thời lượng tối đa PSC được book</td>
								<?php foreach ($jatbi->getDatesFromRange($date_from,$date_to) as $key => $value) { $total_max[$data['id']] += $data['time_max'];?>
									<td class="text-center fw-bold"><?=$data['time_max']>0?$data['time_max']:''?></td>
								<?php } ?>
								<td class="text-nowrap"></td>
								<td class="text-nowrap text-center fw-bold"><?=$total_max[$data['id']]>0?number_format($total_max[$data['id']]):''?></td>
					        </tr>
					        <tr>
					        	<td colspan="5" class="text-end">Thời lượng còn lại có thể book</td>
								<?php foreach ($jatbi->getDatesFromRange($date_from,$date_to) as $key => $value) { $total_max = $data['time_max']-$total[$data['id']][$value];?>
									<td class="text-center <?=$total_max<0?'text-danger':''?>">
										<?=$total_max?>
									</td>
								<?php } ?>
								<td class="text-nowrap"></td>
								<td class="text-nowrap"></td>
					        </tr>
				    	<?php } ?>
					  </tbody>
					</table>
				</div>
				<nav class="d-flex justify-content-between align-items-center paginations mt-4" aria-label="Page navigation">
				    <?=$page?>
				</nav>
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