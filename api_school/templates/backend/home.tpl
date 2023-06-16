
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <meta name="description" content="<?=$setting['site_name'];?>">
  <meta name="author" content="mansys">
  <meta name="mobile-web-app-capable" content="yes" />
  <meta name="apple-touch-fullscreen" content="yes" />
  <meta name="apple-mobile-web-app-title" content="ECLO" />
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="apple-mobile-web-app-status-bar-style" content="default" />
  <meta name="theme-color" content="#009ef7"/>
  <link rel="icon" type="image/png" href="/<?=$setting['site_backend'];?>img/icons/152x152.png"/>
  <link rel="apple-touch-icon" sizes="152x152" href="/<?=$setting['site_backend'];?>img/icons/152x152.png">
  <link rel="apple-touch-icon" sizes="167x167" href="/<?=$setting['site_backend'];?>img/icons/167x167.png">
  <link rel="apple-touch-icon" sizes="180x180" href="/<?=$setting['site_backend'];?>img/icons/180x180.png">
  <link rel="apple-touch-icon" sizes="192x192" href="/<?=$setting['site_backend'];?>img/icons/192x192.png">
  <link rel="apple-touch-icon" sizes="512x512" href="/<?=$setting['site_backend'];?>img/icons/512x512.png">
  <link rel="apple-touch-startup-image" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3)" href="/<?=$setting['site_backend'];?>img/icons/1242x2688.png">
  <!-- iPhone Xr (828px x 1792px) --> 
  <link rel="apple-touch-startup-image" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2)" href="/<?=$setting['site_backend'];?>img/icons/828x1792.png">
  <!-- iPhone X, Xs (1125px x 2436px) --> 
  <link rel="apple-touch-startup-image" media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3)" href="/<?=$setting['site_backend'];?>img/icons/1125x2436.png">
  <!-- iPhone 8 Plus, 7 Plus, 6s Plus, 6 Plus (1242px x 2208px) --> 
  <link rel="apple-touch-startup-image" media="(device-width: 414px) and (device-height: 736px) and (-webkit-device-pixel-ratio: 3)" href="/<?=$setting['site_backend'];?>img/icons/1242x2208.png">
  <!-- iPhone 8, 7, 6s, 6 (750px x 1334px) --> 
  <link rel="apple-touch-startup-image" media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2)" href="/<?=$setting['site_backend'];?>img/icons/750x1334.png">
  <!-- iPad Pro 12.9" (2048px x 2732px) --> 
  <link rel="apple-touch-startup-image" media="(device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2)" href="/<?=$setting['site_backend'];?>img/icons/2048x2732.png">
  <!-- iPad Pro 11” (1668px x 2388px) --> 
  <link rel="apple-touch-startup-image" media="(device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2)" href="/<?=$setting['site_backend'];?>img/icons/1668x2388.png">
  <!-- iPad Pro 10.5" (1668px x 2224px) --> 
  <link rel="apple-touch-startup-image" media="(device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2)" href="/<?=$setting['site_backend'];?>img/icons/1668x2224.png">
  <!-- iPad Mini, Air (1536px x 2048px) --> 
  <link rel="apple-touch-startup-image" media="(device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2)" href="/<?=$setting['site_backend'];?>img/icons/1536x2048.png">
  <link rel='manifest' href='/manifest.json'>
  <link href="/assets/<?=$_SESSION['assets-token']?>.css" rel="stylesheet">
  <script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js"></script>
  <script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-messaging.js"></script>
  <script src="/<?=$setting['site_backend'];?>assets/js/service.js"></script>
  <script src="/<?=$setting['site_backend'];?>assets/js/main.js"></script>
  <script src="https://jsmpeg.com/jsmpeg.min.js"></script>
    <!-- <link href="<?=$setting['site_backend']?>assets/css/animate.min.css">
 <link href="<?=$setting['site_backend']?>assets/css/animate.min.css">
 <link href="<?=$setting['site_backend']?>assets/plugins/fontawesome/css/all.min.css">
 <link href="<?=$setting['site_backend']?>assets/css/bootstrap.min.css">
 <link href="<?=$setting['site_backend']?>assets/plugins/ratings/SimpleStarRating.css">
 <link href="<?=$setting['site_backend']?>assets/plugins/select2/css/select2.min.css">
 <link href="<?=$setting['site_backend']?>assets/plugins/daterangepicker/daterangepicker.css">
 <link href="<?=$setting['site_backend']?>assets/plugins/bootstrap-fileinput/css/fileinput.min.css">
 <link href="<?=$setting['site_backend']?>assets/plugins/org-chart/css/jquery.orgchart.css">
 <link href="<?=$setting['site_backend']?>assets/plugins/fullcalendar/main.min.css">
 <link href="<?=$setting['site_backend']?>assets/plugins/emojionearea/emojionearea.min.css">
 <link href="<?=$setting['site_backend']?>assets/plugins/vis-timeline/vis.min.css">
 <link href="<?=$setting['site_backend']?>assets/css/style.css">

  <script src="/assets/<?=$_SESSION['assets-token']?>.js"></script>
  <script src="<?=$setting['site_backend']?>assets/js/jquery-3.6.0.min.js"></script>
  <script src="<?=$setting['site_backend']?>assets/js/moment.min.js"></script>
  <script src="<?=$setting['site_backend']?>assets/js/bootstrap.bundle.min.js"></script>
  <script src="<?=$setting['site_backend']?>assets/plugins/pjax/pjax.min.js"></script>
  <script src="<?=$setting['site_backend']?>assets/plugins/sweetalert2/sweetalert2.all.min.js"></script>
  <script src="<?=$setting['site_backend']?>assets/plugins/topbar/topbar.min.js"></script>
  <script src="<?=$setting['site_backend']?>assets/plugins/select2/js/select2.full.min.js"></script>
  <script src="<?=$setting['site_backend']?>assets/plugins/daterangepicker/daterangepicker.js"></script>
  <script src="<?=$setting['site_backend']?>assets/plugins/cleave/cleave.min.js"></script>
  <script src="<?=$setting['site_backend']?>assets/plugins/ratings/SimpleStarRating.js"></script>
  <script src="<?=$setting['site_backend']?>assets/plugins/apexcharts/apexcharts.min.js"></script>
  <script src="<?=$setting['site_backend']?>assets/plugins/bootstrap-fileinput/js/fileinput.min.js"></script>
  <script src="<?=$setting['site_backend']?>assets/plugins/org-chart/js/jquery.orgchart.js"></script>
  <script src="<?=$setting['site_backend']?>assets/plugins/fullcalendar/main.min.js"></script>
  <script src="<?=$setting['site_backend']?>assets/plugins/fullcalendar/locales/vi.js"></script>
  <script src="<?=$setting['site_backend']?>assets/plugins/emojionearea/emojionearea.min.js"></script>
  <script src="<?=$setting['site_backend']?>assets/plugins/vis-timeline/vis.min.js"></script>
  <script src="<?=$setting['site_backend']?>assets/js/main.js"></script>
  <script src="<?=$setting['site_backend']?>assets/js/chat.js"></script>
  <script src="<?=$setting['site_backend']?>assets/js/notification.js"></script> -->
  <script src="/assets/<?=$_SESSION['assets-token']?>.js"></script>
  <script src="/<?=$setting['site_backend'];?>assets/plugins/tinymce/tinymce.min.js"></script>
  <title><?=$setting['site_name'];?></title>
</head>

<body class="page <?=$account['mode']?> <?=$account['skin']?>" data-active="<?=$account['active']?>">
  <header >
    <div class="header-top">
      <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
          <div class="d-flex justify-content-start align-items-center">
            <a href="/">
              <img src="/<?=$setting['site_backend'];?>assets/img/eclo.svg" class="logo">
            </a>
            <button class="btn btn-sm link-dark ms-5 d-none d-md-block" id="menu-toggle">
              <!--begin::Svg Icon | path: assets/media/icons/duotune/text/txt001.svg-->
              <span class="svg-icon me-3"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M13 11H3C2.4 11 2 10.6 2 10V9C2 8.4 2.4 8 3 8H13C13.6 8 14 8.4 14 9V10C14 10.6 13.6 11 13 11ZM22 5V4C22 3.4 21.6 3 21 3H3C2.4 3 2 3.4 2 4V5C2 5.6 2.4 6 3 6H21C21.6 6 22 5.6 22 5Z" fill="black"/>
                <path opacity="0.3" d="M21 16H3C2.4 16 2 15.6 2 15V14C2 13.4 2.4 13 3 13H21C21.6 13 22 13.4 22 14V15C22 15.6 21.6 16 21 16ZM14 20V19C14 18.4 13.6 18 13 18H3C2.4 18 2 18.4 2 19V20C2 20.6 2.4 21 3 21H13C13.6 21 14 20.6 14 20Z" fill="black"/>
              </svg></span>
              <!--end::Svg Icon-->
            </button>
            <button class="btn btn-sm link-dark ms-5 d-md-none d-block" id="menu-toggle-mobile">
              <span class="svg-icon svg-icon svg-icon-xl">
                <i class="fas fa-bars animate__animated animate__swing fs-6"></i>
              </span>
            </button>
            <button class="btn btn-sm link-dark ms-3" id="menu-toggle-skin">
              <span class="svg-icon svg-icon svg-icon-xl">
                <i class="fas <?=$account['skin']=='eclo-dark'?'fa-sun':'fa-moon'?> animate__animated animate__swing fs-6"></i>
              </span>
            </button>
          </div>
          
          <div class="d-flex justify-content-start align-items-center">
            <div class="notification me-3">
              <a href="#" class="d-flex justify-content-end align-items-center notification-count link-dark" data-bs-toggle="dropdown" aria-expanded="false">
                <!--begin::Svg Icon | path: assets/media/icons/duotune/ecommerce/ecm004.svg-->
                <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                  <path opacity="0.3" d="M18 10V20C18 20.6 18.4 21 19 21C19.6 21 20 20.6 20 20V10H18Z" fill="#0d6efd"/>
                  <path opacity="0.3" d="M11 10V17H6V10H4V20C4 20.6 4.4 21 5 21H12C12.6 21 13 20.6 13 20V10H11Z" fill="#0d6efd"/>
                  <path opacity="0.3" d="M10 10C10 11.1 9.1 12 8 12C6.9 12 6 11.1 6 10H10Z" fill="#0d6efd"/>
                  <path opacity="0.3" d="M18 10C18 11.1 17.1 12 16 12C14.9 12 14 11.1 14 10H18Z" fill="#0d6efd"/>
                  <path opacity="0.3" d="M14 4H10V10H14V4Z" fill="#0d6efd"/>
                  <path opacity="0.3" d="M17 4H20L22 10H18L17 4Z" fill="#0d6efd"/>
                  <path opacity="0.3" d="M7 4H4L2 10H6L7 4Z" fill="#0d6efd"/>
                  <path d="M6 10C6 11.1 5.1 12 4 12C2.9 12 2 11.1 2 10H6ZM10 10C10 11.1 10.9 12 12 12C13.1 12 14 11.1 14 10H10ZM18 10C18 11.1 18.9 12 20 12C21.1 12 22 11.1 22 10H18ZM19 2H5C4.4 2 4 2.4 4 3V4H20V3C20 2.4 19.6 2 19 2ZM12 17C12 16.4 11.6 16 11 16H6C5.4 16 5 16.4 5 17C5 17.6 5.4 18 6 18H11C11.6 18 12 17.6 12 17Z" fill="#0d6efd"/>
                </svg></span>
                <!--end::Svg Icon-->
              </a>
              <div class="dropdown-menu p-0 dropdown-menu-end animate__animated animate__fadeIn animate__faster" data-popper-placement="bottom-end">
                  <!-- <a class="dropdown-item pjax-load p-2 border-bottom <?=$_SESSION['school']=='0'?'bg-light text-primary':''?>" href="/change-school/0/">
                      <?=$lang['tat-ca']?>
                    </a> -->
                    <?php foreach ($schools as $school) { ?>
                    <a class="dropdown-item pjax-load p-2 border-bottom <?=$_SESSION['school']==$school['id']?'bg-light text-primary':''?>" href="/change-school/<?=$school['id']?>/">
                      <?=$school['name']?>
                      
                      <div class="small fst-italic" style="font-size: 10px;">
                        <?=$school['name']?> - <?=$school['id_school']?>
                      </div>

                    </a>
                    <?php } ?>
                  </div>
                </div>

            <!-- <div class="input-group me-3">             
              <span class="input-group-text bg-white"><?=$lang['truong-hoc']?> </span>
              <select  class="form-control select2 change-update" style="width: 100%;" data-url="profiles/home-update/<?=$action?>/school_option/">
                <option value="" disabled selected><?=$lang['chon-truong-hoc']?></option> 
                <?php foreach ($schools as $school) { ?>
                  <option value="<?=$school['id']?>"  <?=($_SESSION['pairing'][$action]['school_option']==1?'selected':'')?>></option>
                <?php } ?>
              </select>  

            </div> -->
            

            <!-- <div class="notification me-3">
              <a href="#" class="d-flex justify-content-end align-items-center notification-count link-dark" data-bs-toggle="dropdown" aria-expanded="false">
               
                <span class="svg-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                  <path opacity="0.3" d="M20 3H4C2.89543 3 2 3.89543 2 5V16C2 17.1046 2.89543 18 4 18H4.5C5.05228 18 5.5 18.4477 5.5 19V21.5052C5.5 22.1441 6.21212 22.5253 6.74376 22.1708L11.4885 19.0077C12.4741 18.3506 13.6321 18 14.8167 18H20C21.1046 18 22 17.1046 22 16V5C22 3.89543 21.1046 3 20 3Z" fill="black"/>
                  <rect x="6" y="12" width="7" height="2" rx="1" fill="black"/>
                  <rect x="6" y="7" width="12" height="2" rx="1" fill="black"/>
                </svg></span>
                
                <?php if($notifi_chat>0){?>
                <span class="bg-danger text-white notification-count-number"><?=$notifi_chat<=99?$notifi_chat:'99+'?></span>
                  <?php } ?>
                </a>
                <div class="dropdown-menu p-0 notification-list dropdown-menu-end animate__animated animate__fadeIn animate__faster" aria-labelledby="notification-list" data-popper-placement="bottom-end">
                  <div class="d-flex notification-header justify-content-center align-items-center bg-danger p-4">
                    <h5 class="text-white mb-0"><?=$lang['tin-nhan']?></h5>
                    <?php if($notifi_chat>0){?>
                    <span class="p-1 bg-danger rounded text-white ms-3"><?=$notifi_chat<=99?$notifi_chat:'99+'?></span>
                      <?php } ?>
                    </div>
                    <ol class="list-group">
                      <?php if(count($notifications_chats)>0){?>
                      <?php foreach ($notifications_chats as $key => $notification) {?>
                      <li class="p-2 border-bottom position-relative small d-flex justify-content-between align-items-start">
                        <a href="/admin/notification-views/<?=$notification['active']?>/" class="pjax-load pjax-notification ms-2 me-auto" data-active="<?=$notification['active']?>">
                          <p class="mb-0 link-dark">
                            <?php if($notification['views']==0) {?>
                            <span class="badge rounded-circle bg-danger p-1 me-2"> </span>
                            <?php } ?>
                            <?php if($notification['views']>0) {?>
                            <span class="badge rounded-circle bg-success p-1 me-2"> </span>
                            <?php } ?>
                            <span><?=$notification['content']?></span>
                          </p>
                          <small class="text-muted"><?=date($setting['site_time'].' '.$setting['site_date'],strtotime($notification['date']))?></small>
                        </a>
                      </li>
                      <?php } ?>
                      <?php } else { ?>
                      <small class="text-muted text-center p-3"><?=$lang['chua-co-thong-bao-nao']?></small>
                      <?php } ?>
                    </ol>
                    <div class="d-flex notification-footer justify-content-center align-items-center bg-white p-3">
                      <a href="/admin/notification/?type=chat" class="btn btn-sm btn-light pjax-load"><?=$lang['xem-them']?></a>
                    </div>
                  </div>
                </div> -->
                <!-- <div class="notification me-3">
                  <a href="#" class="d-flex justify-content-end align-items-center notification-count link-dark" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path opacity="0.3" d="M20 15H4C2.9 15 2 14.1 2 13V7C2 6.4 2.4 6 3 6H21C21.6 6 22 6.4 22 7V13C22 14.1 21.1 15 20 15ZM13 12H11C10.5 12 10 12.4 10 13V16C10 16.5 10.4 17 11 17H13C13.6 17 14 16.6 14 16V13C14 12.4 13.6 12 13 12Z" fill="currentColor"/>
                      <path d="M14 6V5H10V6H8V5C8 3.9 8.9 3 10 3H14C15.1 3 16 3.9 16 5V6H14ZM20 15H14V16C14 16.6 13.5 17 13 17H11C10.5 17 10 16.6 10 16V15H4C3.6 15 3.3 14.9 3 14.7V18C3 19.1 3.9 20 5 20H19C20.1 20 21 19.1 21 18V14.7C20.7 14.9 20.4 15 20 15Z" fill="currentColor"/>
                    </svg>
                  </span>
                  <?php if($notifi_task>0){?>
                  <span class="bg-danger text-white notification-count-number"><?=$notifi_task<=99?$notifi_task:'99+'?></span>
                    <?php } ?>
                  </a>
                  <div class="dropdown-menu p-0 notification-list dropdown-menu-end animate__animated animate__fadeIn animate__faster" aria-labelledby="notification-list" data-popper-placement="bottom-end">
                    <div class="d-flex notification-header justify-content-center align-items-center bg-danger p-4">
                      <h5 class="text-white mb-0"><?=$lang['cong-viec']?></h5>
                      <?php if($notifi_task>0){?>
                      <span class="p-1 bg-danger rounded text-white ms-3"><?=$notifi_task<=99?$notifi_task:'99+'?></span>
                        <?php } ?>
                      </div>
                      <ol class="list-group">
                        <?php if(count($notifications_tasks)>0){?>
                        <?php foreach ($notifications_tasks as $key => $notification) {?>
                        <li class="p-2 border-bottom position-relative small d-flex justify-content-between align-items-start">
                          <a href="/admin/notification-views/<?=$notification['active']?>/" class="pjax-load pjax-notification ms-2 me-auto" data-active="<?=$notification['active']?>">
                            <p class="mb-0 link-dark">
                              <?php if($notification['views']==0) {?>
                              <span class="badge rounded-circle bg-danger p-1 me-2"> </span>
                              <?php } ?>
                              <?php if($notification['views']>0) {?>
                              <span class="badge rounded-circle bg-success p-1 me-2"> </span>
                              <?php } ?>
                              <span><?=$notification['content']?></span>
                            </p>
                            <small class="text-muted"><?=date($setting['site_time'].' '.$setting['site_date'],strtotime($notification['date']))?></small>
                          </a>
                        </li>
                        <?php } ?>
                        <?php } else { ?>
                        <small class="text-muted text-center p-3"><?=$lang['chua-co-thong-bao-nao']?></small>
                        <?php } ?>
                      </ol>
                      <div class="d-flex notification-footer justify-content-center align-items-center bg-white p-3">
                        <a href="/admin/notification/?type=task" class="btn btn-sm btn-light pjax-load"><?=$lang['xem-them']?></a>
                      </div>
                    </div>
                  </div> -->
                  <!-- <div class="notification me-3">
                    <a href="#" class="d-flex justify-content-end align-items-center notification-count link-dark" data-bs-toggle="dropdown" aria-expanded="false">
                      <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path opacity="0.3" d="M12.5 22C11.9 22 11.5 21.6 11.5 21V3C11.5 2.4 11.9 2 12.5 2C13.1 2 13.5 2.4 13.5 3V21C13.5 21.6 13.1 22 12.5 22Z" fill="currentColor"/>
                        <path d="M17.8 14.7C17.8 15.5 17.6 16.3 17.2 16.9C16.8 17.6 16.2 18.1 15.3 18.4C14.5 18.8 13.5 19 12.4 19C11.1 19 10 18.7 9.10001 18.2C8.50001 17.8 8.00001 17.4 7.60001 16.7C7.20001 16.1 7 15.5 7 14.9C7 14.6 7.09999 14.3 7.29999 14C7.49999 13.8 7.80001 13.6 8.20001 13.6C8.50001 13.6 8.69999 13.7 8.89999 13.9C9.09999 14.1 9.29999 14.4 9.39999 14.7C9.59999 15.1 9.8 15.5 10 15.8C10.2 16.1 10.5 16.3 10.8 16.5C11.2 16.7 11.6 16.8 12.2 16.8C13 16.8 13.7 16.6 14.2 16.2C14.7 15.8 15 15.3 15 14.8C15 14.4 14.9 14 14.6 13.7C14.3 13.4 14 13.2 13.5 13.1C13.1 13 12.5 12.8 11.8 12.6C10.8 12.4 9.99999 12.1 9.39999 11.8C8.69999 11.5 8.19999 11.1 7.79999 10.6C7.39999 10.1 7.20001 9.39998 7.20001 8.59998C7.20001 7.89998 7.39999 7.19998 7.79999 6.59998C8.19999 5.99998 8.80001 5.60005 9.60001 5.30005C10.4 5.00005 11.3 4.80005 12.3 4.80005C13.1 4.80005 13.8 4.89998 14.5 5.09998C15.1 5.29998 15.6 5.60002 16 5.90002C16.4 6.20002 16.7 6.6 16.9 7C17.1 7.4 17.2 7.69998 17.2 8.09998C17.2 8.39998 17.1 8.7 16.9 9C16.7 9.3 16.4 9.40002 16 9.40002C15.7 9.40002 15.4 9.29995 15.3 9.19995C15.2 9.09995 15 8.80002 14.8 8.40002C14.6 7.90002 14.3 7.49995 13.9 7.19995C13.5 6.89995 13 6.80005 12.2 6.80005C11.5 6.80005 10.9 7.00005 10.5 7.30005C10.1 7.60005 9.79999 8.00002 9.79999 8.40002C9.79999 8.70002 9.9 8.89998 10 9.09998C10.1 9.29998 10.4 9.49998 10.6 9.59998C10.8 9.69998 11.1 9.90002 11.4 9.90002C11.7 10 12.1 10.1 12.7 10.3C13.5 10.5 14.2 10.7 14.8 10.9C15.4 11.1 15.9 11.4 16.4 11.7C16.8 12 17.2 12.4 17.4 12.9C17.6 13.4 17.8 14 17.8 14.7Z" fill="currentColor"/>
                      </svg>
                    </span>
                    <?php if($notifi_proposal>0){?>
                    <span class="bg-danger text-white notification-count-number"><?=$notifi_proposal<=99?$notifi_proposal:'99+'?></span>
                      <?php } ?>
                    </a>
                    <div class="dropdown-menu p-0 notification-list dropdown-menu-end animate__animated animate__fadeIn animate__faster" aria-labelledby="notification-list" data-popper-placement="bottom-end">
                      <div class="d-flex notification-header justify-content-center align-items-center bg-danger p-4">
                        <h5 class="text-white mb-0"><?=$lang['de-xuat']?></h5>
                        <?php if($notifi_proposal>0){?>
                        <span class="p-1 bg-danger rounded text-white ms-3"><?=$notifi_proposal<=99?$notifi_proposal:'99+'?></span>
                          <?php } ?>
                        </div>
                        <ol class="list-group">
                          <?php if(count($notifications_proposals)>0){?>
                          <?php foreach ($notifications_proposals as $key => $notification) {?>
                          <li class="p-2 border-bottom position-relative small d-flex justify-content-between align-items-start">
                            <a href="/admin/notification-views/<?=$notification['active']?>/" class="pjax-load pjax-notification ms-2 me-auto" data-active="<?=$notification['active']?>">
                              <p class="mb-0 link-dark">
                                <?php if($notification['views']==0) {?>
                                <span class="badge rounded-circle bg-danger p-1 me-2"> </span>
                                <?php } ?>
                                <?php if($notification['views']>0) {?>
                                <span class="badge rounded-circle bg-success p-1 me-2"> </span>
                                <?php } ?>
                                <span><?=$notification['content']?></span>
                              </p>
                              <small class="text-muted"><?=date($setting['site_time'].' '.$setting['site_date'],strtotime($notification['date']))?></small>
                            </a>
                          </li>
                          <?php } ?>
                          <?php } else { ?>
                          <small class="text-muted text-center p-3"><?=$lang['chua-co-thong-bao-nao']?></small>
                          <?php } ?>
                        </ol>
                        <div class="d-flex notification-footer justify-content-center align-items-center bg-white p-3">
                          <a href="/admin/notification/?type=proposal" class="btn btn-sm btn-light pjax-load"><?=$lang['xem-them']?></a>
                        </div>
                      </div>
                    </div> -->
                    <?php if($database->get('permission','name',['id'=>$account['permission']])!='Tài xế' && $database->get('permission','name',['id'=>$account['permission']])!='Đầu bếp'){?>
                    <div class="notification me-3">
                      <a href="#" class="d-flex justify-content-end align-items-center notification-count link-dark" data-bs-toggle="dropdown" aria-expanded="false">
                        <!--begin::Svg Icon | path: assets/media/icons/duotune/general/gen022.svg-->
                        <span class="svg-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                          <path d="M11.2929 2.70711C11.6834 2.31658 12.3166 2.31658 12.7071 2.70711L15.2929 5.29289C15.6834 5.68342 15.6834 6.31658 15.2929 6.70711L12.7071 9.29289C12.3166 9.68342 11.6834 9.68342 11.2929 9.29289L8.70711 6.70711C8.31658 6.31658 8.31658 5.68342 8.70711 5.29289L11.2929 2.70711Z" fill="black"/>
                          <path d="M11.2929 14.7071C11.6834 14.3166 12.3166 14.3166 12.7071 14.7071L15.2929 17.2929C15.6834 17.6834 15.6834 18.3166 15.2929 18.7071L12.7071 21.2929C12.3166 21.6834 11.6834 21.6834 11.2929 21.2929L8.70711 18.7071C8.31658 18.3166 8.31658 17.6834 8.70711 17.2929L11.2929 14.7071Z" fill="black"/>
                          <path opacity="0.3" d="M5.29289 8.70711C5.68342 8.31658 6.31658 8.31658 6.70711 8.70711L9.29289 11.2929C9.68342 11.6834 9.68342 12.3166 9.29289 12.7071L6.70711 15.2929C6.31658 15.6834 5.68342 15.6834 5.29289 15.2929L2.70711 12.7071C2.31658 12.3166 2.31658 11.6834 2.70711 11.2929L5.29289 8.70711Z" fill="black"/>
                          <path opacity="0.3" d="M17.2929 8.70711C17.6834 8.31658 18.3166 8.31658 18.7071 8.70711L21.2929 11.2929C21.6834 11.6834 21.6834 12.3166 21.2929 12.7071L18.7071 15.2929C18.3166 15.6834 17.6834 15.6834 17.2929 15.2929L14.7071 12.7071C14.3166 12.3166 14.3166 11.6834 14.7071 11.2929L17.2929 8.70711Z" fill="black"/>
                        </svg></span>
                        <!--end::Svg Icon-->
                        <?php if($count_notifi>0){?>
                        <span class="bg-danger text-white notification-count-number"><?=$count_notifi<=99?$count_notifi:'99+'?></span>
                          <?php } ?>
                        </a>
                        
                        <div class="dropdown-menu p-0 notification-list dropdown-menu-end animate__animated animate__fadeIn animate__faster" aria-labelledby="notification-list" data-popper-placement="bottom-end">
                          <div class="d-flex notification-header justify-content-center align-items-center bg-danger p-4">
                            <h5 class="text-white mb-0"><?=$lang['thong-bao']?></h5>
                            <?php if($count_notifi>0){?>
                            <span class="p-1 bg-danger rounded text-white ms-3"><?=$count_notifi<=99?$count_notifi:'99+'?></span>
                              <?php } ?>
                            </div>
                            <ol class="list-group">
                              <?php if(count($notifications)>0){?>
                              <?php foreach ($notifications as $key => $notification) {?>
                              <li class="p-2 border-bottom position-relative small d-flex justify-content-between align-items-start">
                                <a href="/admin/notification-views/<?=$notification['active']?>/" class="pjax-load pjax-notification ms-2 me-auto" data-active="<?=$notification['active']?>">
                                  <p class="mb-0 link-dark">
                                    <?php if($notification['views']==0) {?>
                                    <span class="badge rounded-circle bg-danger p-1 me-2"> </span>
                                    <?php } ?>
                                    <?php if($notification['views']>0) {?>
                                    <span class="badge rounded-circle bg-success p-1 me-2"> </span>
                                    <?php } ?>
                                    <span><?=$notification['content']?></span>
                                  </p>
                                  <small class="text-muted"><?=date($setting['site_time'].' '.$setting['site_date'],strtotime($notification['date']))?></small>
                                </a>
                              </li>
                              <?php } ?>
                              <?php } else { ?>
                              <small class="text-muted text-center p-3"><?=$lang['chua-co-thong-bao-nao']?></small>
                              <?php } ?>
                            </ol>
                            <div class="d-flex notification-footer justify-content-center align-items-center bg-white p-3">
                              <a href="/admin/notification/" class="btn btn-sm btn-light pjax-load"><?=$lang['xem-them']?></a>
                            </div>
                          </div>
                        </div>
                      <?php } ?>
                        <div class="accounts">
                          <a href="#" class="d-flex justify-content-end align-items-center" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="/images/accounts/thumb/<?=$account['avatar'];?>" alt="<?=$account['name'];?>" class="rounded-circle" style="width:40px">
                            <div class="d-none d-md-block ps-2 text-dark">
                              <small class="d-block fw-light"><?=$account['email']?></small>
                              <span class="d-block fw-bold"><?=$account['name']?></span>
                            </div>
                          </a>
                          <div class="dropdown-menu p-0 animate__animated animate__fadeIn animate__faster" aria-labelledby="login-accounts" data-popper-placement="bottom-end">
                            <div class="d-flex justify-content-start align-items-center pt-3 pb-3 pe-4 ps-4 accounts-info">
                              <img src="/images/accounts/thumb/<?=$account['avatar'];?>" alt="<?=$account['name'];?>" class="rounded-circle" style="width:50px">
                              <div class="d-block p-3">
                                <span class="d-block fw-bold"><?=$account['name']?></span>
                                <small class="d-block fw-light"><?=$account['email']?></small>
                                <!-- <small class="d-block fw-light"><?=$database->get("school", "name",["id"=>$database->get("account_school","school",["accounts"=>$account['id']])])?></small> -->
                              </div>
                            </div>
                            <ul class="dropdown-inner">
                              <!-- <li>
                                <a class="dropdown-item pjax-load" href="/users/my-accounts/">
                                  <span class="svg-icon me-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M6.28548 15.0861C7.34369 13.1814 9.35142 12 11.5304 12H12.4696C14.6486 12 16.6563 13.1814 17.7145 15.0861L19.3493 18.0287C20.0899 19.3618 19.1259 21 17.601 21H6.39903C4.87406 21 3.91012 19.3618 4.65071 18.0287L6.28548 15.0861Z" fill="black"/>
                                    <rect opacity="0.3" x="8" y="3" width="8" height="8" rx="4" fill="black"/>
                                  </svg></span>
                                  <?=$lang['tai-khoan']?>
                                </a>
                              </li> -->
                              <li>
                                <a class="dropdown-item modal-url" data-url=/users/accounts-change/>
                                <span class="svg-icon me-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                  <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd" d="M2 4.63158C2 3.1782 3.1782 2 4.63158 2H13.47C14.0155 2 14.278 2.66919 13.8778 3.04006L12.4556 4.35821C11.9009 4.87228 11.1726 5.15789 10.4163 5.15789H7.1579C6.05333 5.15789 5.15789 6.05333 5.15789 7.1579V16.8421C5.15789 17.9467 6.05333 18.8421 7.1579 18.8421H16.8421C17.9467 18.8421 18.8421 17.9467 18.8421 16.8421V13.7518C18.8421 12.927 19.1817 12.1387 19.7809 11.572L20.9878 10.4308C21.3703 10.0691 22 10.3403 22 10.8668V19.3684C22 20.8218 20.8218 22 19.3684 22H4.63158C3.1782 22 2 20.8218 2 19.3684V4.63158Z" fill="black"/>
                                  <path d="M10.9256 11.1882C10.5351 10.7977 10.5351 10.1645 10.9256 9.77397L18.0669 2.6327C18.8479 1.85165 20.1143 1.85165 20.8953 2.6327L21.3665 3.10391C22.1476 3.88496 22.1476 5.15129 21.3665 5.93234L14.2252 13.0736C13.8347 13.4641 13.2016 13.4641 12.811 13.0736L10.9256 11.1882Z" fill="black"/>
                                  <path d="M8.82343 12.0064L8.08852 14.3348C7.8655 15.0414 8.46151 15.7366 9.19388 15.6242L11.8974 15.2092C12.4642 15.1222 12.6916 14.4278 12.2861 14.0223L9.98595 11.7221C9.61452 11.3507 8.98154 11.5055 8.82343 12.0064Z" fill="black"/>
                                </svg></span>
                                <?=$lang['sua-tai-khoan']?>
                              </a>
                            </li>
                            <!-- <li>
                              <a class="dropdown-item pjax-load" href="/nhat-ky/">
                                <span class="svg-icon me-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                  <path opacity="0.3" d="M14 2H6C4.89543 2 4 2.89543 4 4V20C4 21.1046 4.89543 22 6 22H18C19.1046 22 20 21.1046 20 20V8L14 2Z" fill="black"/>
                                  <path d="M20 8L14 2V6C14 7.10457 14.8954 8 16 8H20Z" fill="black"/>
                                  <rect x="13.6993" y="13.6656" width="4.42828" height="1.73089" rx="0.865447" transform="rotate(45 13.6993 13.6656)" fill="black"/>
                                  <path d="M15 12C15 14.2 13.2 16 11 16C8.8 16 7 14.2 7 12C7 9.8 8.8 8 11 8C13.2 8 15 9.8 15 12ZM11 9.6C9.68 9.6 8.6 10.68 8.6 12C8.6 13.32 9.68 14.4 11 14.4C12.32 14.4 13.4 13.32 13.4 12C13.4 10.68 12.32 9.6 11 9.6Z" fill="black"/>
                                </svg></span>
                                <?=$lang['nhat-ky']?>
                              </a>
                            </li> -->
                            <li><hr class="dropdown-divider m-0"></li>
                            <li>
                              <a class="dropdown-item" href="/logout/">
                                <span class="svg-icon me-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                  <rect opacity="0.3" width="12" height="2" rx="1" transform="matrix(-1 0 0 1 15.5 11)" fill="black"/>
                                  <path d="M13.6313 11.6927L11.8756 10.2297C11.4054 9.83785 11.3732 9.12683 11.806 8.69401C12.1957 8.3043 12.8216 8.28591 13.2336 8.65206L16.1592 11.2526C16.6067 11.6504 16.6067 12.3496 16.1592 12.7474L13.2336 15.3479C12.8216 15.7141 12.1957 15.6957 11.806 15.306C11.3732 14.8732 11.4054 14.1621 11.8756 13.7703L13.6313 12.3073C13.8232 12.1474 13.8232 11.8526 13.6313 11.6927Z" fill="black"/>
                                  <path d="M8 5V6C8 6.55228 8.44772 7 9 7C9.55228 7 10 6.55228 10 6C10 5.44772 10.4477 5 11 5H18C18.5523 5 19 5.44772 19 6V18C19 18.5523 18.5523 19 18 19H11C10.4477 19 10 18.5523 10 18C10 17.4477 9.55228 17 9 17C8.44772 17 8 17.4477 8 18V19C8 20.1046 8.89543 21 10 21H19C20.1046 21 21 20.1046 21 19V5C21 3.89543 20.1046 3 19 3H10C8.89543 3 8 3.89543 8 5Z" fill="#C4C4C4"/>
                                </svg></span>
                                <?=$lang['dang-xuat']?>
                              </a>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="nav-menu">
                <div class="nav-menu-items">
                  <ul class="accordion" id="nav-menu-items">
                    <?php foreach ($main_names as $key => $main_name) { ?>
                    <li class="menu-section">
                      <h4 class="menu-text"><?=$main_name['name']?></h4>
                      <i class="fas fa-ellipsis-h"></i>
                    </li>
                    <?php foreach ($main_name['items'] as $key_menu => $main_menu) {?>
                    <li class="nav-menu-item">
                      <a href="<?=$main_menu['url']?>" class="pjax-load nav-menu-link <?=$router['0']==$key_menu?'active':''?>" <?php if(count($main_menu['sub'])>0){ ?>data-bs-toggle="collapse" data-bs-target="#<?=$key_menu?>" aria-expanded="true" aria-controls="<?=$key_menu?>" <?php } ?>>
                        <?=$main_menu['icon']?>
                        <span><?=$main_menu['menu']?></span>
                        <?php if(count($main_menu['sub'])>0){?>
                        <i class="fas fa-chevron-right nav-menu-arrow"></i>
                        <?php }?>
                      </a>
                      <?php if(count($main_menu['sub'])>0){?>
                      <div id="<?=$key_menu?>" class="accordion-collapse collapse <?=$router['0']==$key_menu?'show':''?>" data-bs-parent="#nav-menu-items">
                        <ul class="nav-menu-items-sub">
                          <?php foreach ($main_menu['sub'] as $key_sub => $sub) { ?>
                          <li class="menu-item">
                            <?php if($sub['req']==''){?>
                            <a href="/<?=$key_menu?>/<?=$sub['router']?>/" class="pjax-load nav-menu-sub-link <?=$router['1']==$key_sub?'active':''?>">
                              <?php } ?>
                              <?php if($sub['req']=='modal-url'){?>
                              <a href="#" data-url="/<?=$key_menu?>/<?=$sub['router']?>/" class="modal-url nav-menu-sub-link <?=$router['1']==$key_sub?'active':''?>">
                                <?php } ?>
                                <?=$sub['icon']?>
                                <span><?=$sub['name']?></span>
                              </a>
                            </li>
                            <?php } ?>
                          </ul>
                        </div>
                        <?php }?>
                      </li>
                      <?php } ?>
                      <?php } ?>
                      
                    </ul>
                  </div>
                </div>
              </header>

              <article class="eclo-content js-Pjax">
                <div class="js-Pjax-child">
                  <div class="container-fluid pt-3 pb-5 pe-lg-5 ps-lg-5 position-relative">
                    <?php include($templates);?>
                  </div>
                </div>
              </article>

            </body>

            </html>
