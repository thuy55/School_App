<!doctype html>
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
    <meta name="theme-color" content="#cc1728"/>
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
    <link rel="stylesheet" href="/<?=$setting['site_backend'];?>assets/css/animate.min.css"/>
    <link href="/<?=$setting['site_backend'];?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/<?=$setting['site_backend'];?>assets/css/style.css" rel="stylesheet">
    <title><?=$setting['site_name'];?></title>
  </head>
  <body class="login animate__animated animate__backInDown">
    <div class="container">
      <div class="row justify-content-md-center">
        <div class="col-md-12 text-center text-md-start">
          <a href="https://eclo.vn"><img src="/<?=$setting['site_backend'];?>assets/img/eclo.svg" class="logo"></a>
        </div>
        <div class="col-md-5">
          <div class="card mb-5">
            <div class="card-body p-5">
              <div class="col-md-12">
                <h3 class="font-weight-bolder text-dark"><?=$lang['dang-nhap']?></h3>
                  <p><?=$lang['chao-dang-nhap']?></p>
              </div>
              <form method="POST" class="needs-validation login-form">
                <div class="col-md-12 mb-4">
                  <label for="account" class="form-label"><?=$lang['tai-khoan']?></label>
                  <input type="text" class="form-control p-3" id="account" name="account" value="" required>
                  <div class="invalid-feedback">
                    Vui lòng nhập tại khoản
                  </div>
                </div>
                <div class="col-md-12 mb-4">
                  <label for="password" class="form-label"><?=$lang['mat-khau']?></label>
                  <input type="password" class="form-control p-3" id="password" name="password" value="" required>
                  <div class="invalid-feedback">
                    Vui lòng nhập mật khẩu
                  </div>
                </div>
                <div class="col-12 mt-4">
                  <button class="btn btn-primary p-3 login-submit w-100" type="submit"><?=$lang['dang-nhap']?></button>
                  <input type="hidden" name="token" value="<?=$_SESSION['csrf']['key']?>" autocapitalize="off" autocomplete="off" autocorrect="off"/>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-md-7">
          <img src="/<?=$setting['site_backend'];?>assets/img/accomplishment.svg" class="w-100">
        </div>
        <div class="col-md-12 text-center mt-4">
            &copy; <?=$lang['ban-quyen-eclo']?>
        </div>
      </div>
    </div>
  </body>
    <script src="/<?=$setting['site_backend'];?>assets/js/jquery-3.6.0.min.js"></script>
    <script src="/<?=$setting['site_backend'];?>assets/js/bootstrap.bundle.min.js"></script>
    <script src="/<?=$setting['site_backend'];?>assets/plugins/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="/<?=$setting['site_backend'];?>assets/js/login.js"></script>
</html>