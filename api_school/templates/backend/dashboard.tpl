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

<div class="d-flex flex-column flex-column-fluid page-content">
  <div class="app-container container-fluid mt-2">

    <div class="row">
      <div class="col-xl-6 mb-xl-10">       
        <div class="card card-flush h-xl-100">   
          <div class="card-header rounded bgi-no-repeat bgi-size-cover bgi-position-y-top bgi-position-x-center align-items-start h-250px" data-bs-theme="light">
            <h4 class="card-title align-items-start flex-column  pt-15 text-center">
              <span class="fw-bold fs-2x mb-3 text-center">HỌC SINH XIN NGHỈ CHƯA DUYỆT</span>
            </h4>   
          </div>
          <div class="card-body mt-n20 text-center">
            <div class="mt-n20 position-relative text-center">
              <div class="row g-3 g-lg-6">
                <div class="col-12 text-center">
                  <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-2">
                    <div class="m-0">
                      <h3 class="card-title align-items-start flex-column  pt-15 text-center ">
                      <span class="fw-bold fs-2x mb-3 text-center" style="color: red;"><?=$furloughss?></span>
                    </h3>
                    </div>
                  </div>    
                </div>
              </div>
            </div> 
          </div>        
        </div>

      </div>
      <div class="col-xl-6 mb-xl-10">       
        <div class="card card-flush h-xl-100">   
          <div class="card-header rounded bgi-no-repeat bgi-size-cover bgi-position-y-top bgi-position-x-center align-items-start h-250px" data-bs-theme="light">
            <h3 class="card-title align-items-start flex-column  pt-15 text-center">
              <span class="fw-bold fs-2x mb-3 text-center"><?=date('d-m-Y')?></span>
            </h3>   
          </div>
          <div class="card-body mt-n20">
            <div class="mt-n20 position-relative">
              <div class="row g-3 g-lg-6">
                <div class="col-6 text-center">
                  <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-2">
                    <div class="m-0">
                      <span class="text-gray-700 fw-bolder d-block fs-7 lh-1 ls-n1 mb-1 text-center"><?=$count-$student_furlough?></span>
                      <span class="text-gray-500 fw-semibold fs-6 text-center">HỌC SINH ĐI HỌC </span>

                    </div>
                  </div>    
                </div>

                <div class="col-6 text-center"> 
                  <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-2">
                    <a href="/profiles/furlough/">
                    <div class="m-0">
                      <span class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1 text-center"><?=$student_furlough?></span>
                      <span class="text-gray-500 fw-semibold fs-6 text-center">HỌC SINH NGHỈ CÓ PHÉP</span>
                    </div>
                  </a>
                  </div>    
                </div>


              </div>
            </div> 
          </div>        
        </div>

      </div>
      <div class="col-xl-6 mb-xl-10 pt-3">       
        <div class="card card-flush h-xl-100">   
          <div class="card-header rounded bgi-no-repeat bgi-size-cover bgi-position-y-top bgi-position-x-center align-items-start h-250px" data-bs-theme="light">
            <h4 class="card-title align-items-start flex-column  pt-15 text-center">
              <span class="fw-bold fs-2x mb-3 text-center">HỌC SINH ĐĂNG KÍ DỊCH VỤ CHƯA DUYỆT</span>
            </h4>   
          </div>
          <div class="card-body mt-n20 text-center">
            <div class="mt-n20 position-relative text-center">
              <div class="row g-3 g-lg-6">
                <div class="col-12 text-center">
                  <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-2">
                    <div class="m-0">
                      <h3 class="card-title align-items-start flex-column  pt-15 text-center">
                      <span class="fw-bold fs-2x mb-3 text-center " style="color: red;"><?=$student_register_car?></span>
                    </h3>
                    </div>
                  </div>    
                </div>
              </div>
            </div> 
          </div>        
        </div>

      </div>
      <div class="col-xl-6 mb-xl-10 pt-3">       
        <div class="card card-flush h-xl-100">   
          <div class="card-header rounded bgi-no-repeat bgi-size-cover bgi-position-y-top bgi-position-x-center align-items-start h-250px" data-bs-theme="light">
            <h3 class="card-title align-items-start flex-column  pt-15 text-center">
              <span class="fw-bold fs-2x mb-3 text-center">THÁNG <?=date('m')?></span>
            </h3>   
          </div>
          <div class="card-body mt-n20">
            <div class="mt-n20 position-relative">
              <div class="row g-3 g-lg-6">
                <div class="col-6 text-center">
                  <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-2">
                    <div class="m-0">
                      <span class="text-gray-700 fw-bolder d-block fs-7 lh-1 ls-n1 mb-1 text-center"><?=$student_number?></span>
                      <span class="text-gray-500 fw-semibold fs-6 text-center">HỌC SINH NHẬP HỌC</span>

                    </div>
                  </div>    
                </div>

                <div class="col-6 text-center"> 
                  <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-2">
                    <a href="/tuitions/tuition/">
                    <div class="m-0">
                      <span class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1 text-center"><?=$tuition_number?></span>
                      <span class="text-gray-500 fw-semibold fs-6 text-center">HÓA ĐƠN HỌC PHÍ</span>
                    </div>
                  </a>
                  </div>    
                </div>
                <div class="col-6 text-center"> 
                  <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-2">
                     <a href="/tuitions/tuition_debt/">
                    <div class="m-0">
                      <span class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1 text-center"><?=$count_tu_stu?></span>
                      <span class="text-gray-500 fw-semibold fs-6 text-center">HỌC SINH CHƯA ĐÓNG HỌC PHÍ</span>
                    </div>
                  </a>
                  </div>    
                </div>
              <div class="col-6 text-center"> 
                  <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-2">
                    <a href="/tuitions/expenditure/">
                    <div class="m-0">
                      <span class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1 text-center"><?=$purchase_number?></span>
                      <span class="text-gray-500 fw-semibold fs-6 text-center">HÓA ĐƠN CHI</span>
                    </div>
                  </a>
                  </div>    
                </div>

              </div>
              

              </div>
            </div> 
          </div>        
        </div>

      </div>
      <div class="card card-custom mt-3">
            <div class="card-body pb-0">
              <div class="d-lg-flex justify-content-between align-items-start mb-4">
                <div class="fs-3 fw-bold text-dark">HỌC SINH BỊ DỊ ỨNG</div>
                
              </div>
              <table class="table table-striped table-hover ">
                <thead>
                  <tr>

                   
                    <th class="fs-6" scope="col"><?=$lang['di-ung']?></th>
                    <th  class="fs-6" scope="col">Số lượng học sinh</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($allergy as $data) {
                    $count_s=0;
                            $date=date("Y-m-d");
                            $course=$database->select("course","*",[
                            "school"        =>$_SESSION['school'],
                            "status"        =>'A',
                            "deleted"       => 0,
                              ]);
                          foreach($course as $value){
                            $date_timestamp = strtotime($date);
                            $start_timestamp = strtotime($value['startdate']);
                            $end_timestamp = strtotime($value['enddate']);
                            
                            if ($date_timestamp >= $start_timestamp && $date_timestamp <= $end_timestamp) {
                              $class = $database->select("class_diagram", "*",[
                                "AND" => [
                                  'status'        => "A", 
                                  "deleted"       => 0,
                                  'course'        => $value['id'],
                                  "school"=>$_SESSION['school'],
                                ]
                              ]);
                            }
                          }
                          foreach($class as $value){
                            $count_s += $database->count("arrange_class",[
                              'AND' => [
                                "class_diagram" => $value['id'],
                                "students"    =>$database->select("students","id",['status' => "A", "school"=>$_SESSION['school'],"allergy"=>$data['id']]),
                                "status"    =>"A",
                                "deleted"       => 0,
                              ]]);
                          }
                    if($count_s!=0 && strtolower($data['name'])!="không"){
                    ?>
                    <tr>
                      <td class="fs-6"><?=$data['name']?></td>
                      <td class="fs-6"><?=$count_s?></td>
                    </tr>
                  <?php }?>
                <?php }?>
                </tbody>
              </table>
            </div>
          </div>
    </div>

  </div>
</div>

</div>

 <!-- <div class="col-xl-8 mb-5 mb-xl-10">
                <div class="row g-5 g-xl-10">
                  <div class="col-xl-6 mb-xl-10">     
                    <div id="kt_sliders_widget_1_slider" class="card card-flush carousel carousel-custom carousel-stretch slide h-xl-100" data-bs-ride="carousel" data-bs-interval="5000">
                      <div class="card-header pt-5">
                        <h4 class="card-title d-flex align-items-start flex-column">            
                          <span class="card-label fw-bold text-gray-800">Cần phải hoàn thành</span>
                          <span class="text-gray-400 mt-1 fw-bold fs-7">bạn có 0 cần hoàn thành</span>
                        </h4>
                        <div class="card-toolbar">            
                          <ol class="p-0 m-0 carousel-indicators carousel-indicators-bullet carousel-indicators-active-primary">
                            <li data-bs-target="#kt_sliders_widget_1_slider" data-bs-slide-to="0" class="ms-1"></li>
                            <li data-bs-target="#kt_sliders_widget_1_slider" data-bs-slide-to="1" class="ms-1 active" aria-current="true"></li>
                            <li data-bs-target="#kt_sliders_widget_1_slider" data-bs-slide-to="2" class="ms-1"></li>
                          </ol>
                        </div>
                      </div>
                      <div class="card-body py-6">  
                        <div class="carousel-inner mt-n5">
                        </div>       
                      </div>   
                    </div>
                  </div>
                  <div class="col-xl-6 mb-xl-10">     
                    <div id="kt_sliders_widget_2_slider" class="card card-flush carousel carousel-custom carousel-stretch slide h-xl-100" data-bs-ride="carousel" data-bs-interval="5000">
                      <div class="card-header pt-5">
                        <h4 class="card-title d-flex align-items-start flex-column">            
                          <span class="card-label fw-bold text-gray-800">Cần phải đánh giá</span>
                          <span class="text-gray-400 mt-1 fw-bold fs-7">bạn có 0 cần đánh giá</span>
                        </h4>
                        <div class="card-toolbar">            
                          <ol class="p-0 m-0 carousel-indicators carousel-indicators-bullet carousel-indicators-active-primary">
                            <li data-bs-target="#kt_sliders_widget_2_slider" data-bs-slide-to="0" class="ms-1"></li>
                            <li data-bs-target="#kt_sliders_widget_2_slider" data-bs-slide-to="1" class="ms-1 active" aria-current="true"></li>
                            <li data-bs-target="#kt_sliders_widget_2_slider" data-bs-slide-to="2" class="ms-1"></li>
                          </ol>
                        </div>
                      </div>
                      <div class="card-body py-6">  
                        <div class="carousel-inner mt-n5">
                        </div>       
                      </div>   
                    </div>
                  </div>
                </div>
                <div class="card border-transparent " data-bs-theme="light" style="background-color: #1C325E;">
                  <div class="card-body d-flex ps-xl-15">      
                    <div class="m-0">    
                      <div class="position-relative fs-2x z-index-2 fw-bold text-white mb-7">
                        <span class="me-2">
                         Bạn vừa chấm công lúc
                         <span class="position-relative d-inline-block text-danger">
                         </span>                     
                       </span>
                       <br>
                       Và đi ra lúc 
                       <span class="position-relative d-inline-block text-danger">
                       </span>                 
                     </div>
                   </div>
                   <img src="/templates/ver3/assets/media/svg/img/7.svg" class="position-absolute me-3 bottom-0 end-0 h-200px" alt=""> 
                 </div>
               </div>
             </div> -->

