<?php 
	if (!defined('JATBI')) die("Hacking attempt");
	use MatthiasMullie\Minify;
	if($router['1']==$_SESSION['assets-token'].'.css'){
		$Minifycss = [
			$setting['site_backend']."/assets/css/animate.min.css",
			$setting['site_backend']."/assets/plugins/fontawesome/css/all.min.css",
			$setting['site_backend']."/assets/css/bootstrap.min.css",
			$setting['site_backend']."/assets/plugins/ratings/SimpleStarRating.css",
			$setting['site_backend']."/assets/plugins/select2/css/select2.min.css",
			$setting['site_backend']."/assets/plugins/daterangepicker/daterangepicker.css",
			$setting['site_backend']."assets/plugins/bootstrap-fileinput/css/fileinput.min.css",
			$setting['site_backend']."assets/plugins/org-chart/css/jquery.orgchart.css",
			$setting['site_backend']."assets/plugins/fullcalendar/main.min.css",
			$setting['site_backend']."assets/plugins/emojionearea/emojionearea.min.css",
			$setting['site_backend']."assets/plugins/vis-timeline/vis.min.css",
			// $setting['site_backend']."assets/plugins/datatable/datatables.css",
			$setting['site_backend']."/assets/css/style.css",
		];
		header('Content-Type: text/css');
		$minifier = new Minify\CSS($Minifycss);
		echo $minifier->minify();
	}
	elseif($router['1']==$_SESSION['assets-token'].'.js'){
		$Minifyjs = [
			$setting['site_backend']."assets/js/jquery-3.6.0.min.js",
			$setting['site_backend']."assets/js/moment.min.js",
			$setting['site_backend']."assets/js/bootstrap.bundle.min.js",
			$setting['site_backend']."assets/plugins/pjax/pjax.min.js",
			$setting['site_backend']."assets/plugins/sweetalert2/sweetalert2.all.min.js",
			$setting['site_backend']."assets/plugins/topbar/topbar.min.js",
			$setting['site_backend']."assets/plugins/select2/js/select2.full.min.js",
			$setting['site_backend']."assets/plugins/daterangepicker/daterangepicker.js",
			$setting['site_backend']."assets/plugins/cleave/cleave.min.js",
			$setting['site_backend']."assets/plugins/ratings/SimpleStarRating.js",
			$setting['site_backend']."assets/plugins/apexcharts/apexcharts.min.js",
			$setting['site_backend']."assets/plugins/bootstrap-fileinput/js/fileinput.min.js",
			$setting['site_backend']."assets/plugins/org-chart/js/jquery.orgchart.js",
			$setting['site_backend']."assets/plugins/fullcalendar/main.min.js",
			$setting['site_backend']."assets/plugins/fullcalendar/locales/vi.js",
			$setting['site_backend']."assets/plugins/emojionearea/emojionearea.min.js",
			$setting['site_backend']."assets/plugins/vis-timeline/vis.min.js",
			// $setting['site_backend']."assets/plugins/datatable/datatables.min.js",
			$setting['site_backend']."assets/js/main.js",
			$setting['site_backend']."assets/js/chat.js",
			// $setting['site_backend']."assets/js/message.js",
			$setting['site_backend']."assets/js/notification.js",
		];
		header('Content-Type: text/javascript');
		$minifier = new Minify\JS($Minifyjs);
		echo $minifier->minify();
	}
	else {
		header("location: /");
	}
?>