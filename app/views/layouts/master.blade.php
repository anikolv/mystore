<!doctype html>
<html lang="en">
<head>

	<meta charset="UTF-8">
	<title>WebTeck</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  	<meta name="description" content="">
  	<meta name="author" content="">
  	
	<link href="../assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="../assets/css/sticky-footer.css" rel="stylesheet">
	<link href="../assets/css/style.css" rel="stylesheet">
	<link href="../assets/css/simple-sidebar.css" rel="stylesheet">
	<link href="../assets/css/jquery.bxslider.css" rel="stylesheet">
	<link href="../assets/css/font-awesome.css" rel="stylesheet">
	<link href="../assets/css/font-awesome.min.css" rel="stylesheet">
	
	   <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
  		<!--[if lt IE 9]>
    		<script src="../assets/js/html5shiv.js"></script>
    		<script src="../assets/js/respond.min.js"></script>
    		<script src="../assets/js/excanvas.js"></script>
  		<![endif]-->
  	
  	 <link rel="icon" href="../assets/images/favicon.png">
  	 <link rel="shortcut icon" href="../assets/images/favicon.png">
	
</head>
<body>

	<!--header start-->
	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="row">
		  	{{ $login_info }}
		</div>
	</nav>
	<!--header end-->
	
	<div class="">
		<div class="row">
			<div class="col-md-3 column">
			  @section('user-sidebar')
			  	<div id="wrapper">
        			<div id="sidebar-wrapper">
            			<ul class="sidebar-nav">
                			<li class="sidebar-brand">
                    			<a href="#">Потребителски панел</a>
                			</li>
                			<li class="myli">
                    			<a href="/" id="phones"></img>Телефони</a>
                			</li>
               				 <li class="myli">
                    			<a href="/store/tablets" id="tablets">Таблети</a>
               				 </li>
               				 <li class="myli">
                    			<a href="/store/notebooks" id="notebooks">Лаптопи</a>
                			</li>
                			<li class="myli">
                    			<a href="/store/tvs" id="tvs">Телевизори</a>
                			</li>
                			<li class="myli">
                   				 <a href="/store/mycart" id="mycart">Количка {{ '( ' }} {{ Session::get('products_amount')[0]; }} {{ ' )' }}</a>
                			</li>
                			<li class="myli">
                    			<a href="#">Потребителски акаунт</a>
                			</li>
                			<li class="myli">
                    			<a href="/contact">Контакти</a>
                			</li>
                				<div class="slider8">	
  									<div class="slide"><img src="http://ausdroid.net/wp-content/uploads/2015/01/Aldi-Medion-4.5-22-smartphone-banner.jpg"></div>
  									<div class="slide"><img src="http://thumbs.dreamstime.com/x/deals-smartphone-shows-online-offers-bargains-promotions-showing-38118776.jpg"></div>
  									<div class="slide"><img src="http://ausdroid.net/wp-content/uploads/2015/01/Aldi-Medion-4.5-22-smartphone-banner.jpg"></div>
  									<div class="slide"><img src="http://thumbs.dreamstime.com/x/deals-smartphone-shows-online-offers-bargains-promotions-showing-38118776.jpg"></div>
  									<div class="slide"><img src="http://ausdroid.net/wp-content/uploads/2015/01/Aldi-Medion-4.5-22-smartphone-banner.jpg"></div>
 								    <div class="slide"><img src="http://thumbs.dreamstime.com/x/deals-smartphone-shows-online-offers-bargains-promotions-showing-38118776.jpg"></div>
  									<div class="slide"><img src="http://ausdroid.net/wp-content/uploads/2015/01/Aldi-Medion-4.5-22-smartphone-banner.jpg"></div>
  									<div class="slide"><img src="http://thumbs.dreamstime.com/x/deals-smartphone-shows-online-offers-bargains-promotions-showing-38118776.jpg"></div>
  									<div class="slide"><img src="http://ausdroid.net/wp-content/uploads/2015/01/Aldi-Medion-4.5-22-smartphone-banner.jpg"></div>
  									<div class="slide"><img src="http://thumbs.dreamstime.com/x/deals-smartphone-shows-online-offers-bargains-promotions-showing-38118776.jpg"></div>
								</div>
            			</ul>
        			</div>
         		</div>
			  @show
			  @section('admin-sidebar')
			  <div id="wrapper">
        			<div id="sidebar-wrapper">
            			<ul class="sidebar-nav">
                			<li class="sidebar-brand">
                    			<a href="#">Админ панел</a>
                			</li>
                			<li class="myli">
                    			<a href="adminUsers" id="users">Потребители</a>
                			</li>
               				 <li class="myli">
                    			<a href="adminProducts" id="products">Продукти</a>
               				 </li>
               				 <li class="myli">
                    			<a href="adminOrders" id="orders">Поръчки</a>
                			</li>
            			</ul>
        			</div>
         		</div>
			  @show
			</div>
			<div class="col-md-9 column">
				 @yield('content')
			</div>
		</div>
	</div>
	    
	<footer class="footer">
 		<div class="col-md-6" style="text-align: left;margin-top: 15px;">
 			<span class="ftlabel">&copy; 2015</span>
 		</div>
 		<div class="col-md-6" style="text-align: right;">
 			<img src="../assets/images/banks.png" style="height: 50px;">
 		</div>
	</footer>
	
	<script type="text/javascript" src="../assets/js/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../assets/js/jquery.bxslider.js"></script>
	<script type="text/javascript" src="../assets/js/jquery.bxslider.min.js"></script>
	<script type="text/javascript" src="../assets/js/knockout-3.2.0.js"></script>
	<script type="text/javascript" src="../assets/js/knockout.mapping-latest.js"></script>
	<script type="text/javascript" src="../assets/js/knockout.validation.min.js"></script>
	<script type="text/javascript" src="../assets/js/jquery.tablesorter.js"></script>
	<script type="text/javascript" src="../assets/js/jquery.tablesorter.pager.js"></script>
	<script type="text/javascript" src="../assets/js/jquery.tablesorter.widgets.js"></script>
	<script type="text/javascript" src="../assets/js/jquery-migrate-1.2.1.min.js"></script>
	<script type="text/javascript" src="../assets/js/jquery.tablesorter.extras-0.1.22.min.js"></script>

	@section('scripts')
 	@show
 	
</body>
</html>
