<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	
	public function __construct() {
		Session::push('products_amount', 0);
		$login_info = '';
		if (Auth::user() != null) {
			$login_info .= '<div class="col-md-3" style="text-align: left; padding-left: 40px; ">
								<a class="" href="/" title="Home"><img src="../assets/images/test2.png" style="height: 50px;"/></a>
							</div>
							<div class="col-md-5" style="margin-top: 7px;">'.
								(Auth::user()->role == 1 ? '
									<form method="post" action="/search" style="display: flex;">
						            	<input type="text" class="form-control" placeholder="Търси продукти..." id="query" name="query" value="">
							         	<div class="input-group-btn">
						            		<button type="submit" class="btn btn-blue"><span class="glyphicon glyphicon-search"></span></button>
						            	</div>
								     </form>
						        ' : '') .
							'</div>
							<div class="col-md-4" style="text-align: right;padding-right: 40px;">
								<span style="color:#497AE4;"> Здравей, ' . Auth::user()->name . ' </span>
								&nbsp;	
								&nbsp;
								<a class="" href="logout" title="Logout"><img src="../assets/images/logout.png" style="height: 40px;margin-top: 6px;"/></a>
							</div>';
		} else {
			$login_info .= '<div class="col-md-3" style="text-align: left; padding-left: 40px; ">
								<a class="" href="/" title="Home"><img src="../assets/images/test2.png" style="height: 50px;"/></a>
							</div>
							<div class="col-md-6" style="margin-top: 7px;">
								<form method="post" action="/search" style="display: flex;">
						            	<input type="text" class="form-control" placeholder="Търси продукти..." id="query" name="query" value="">
							         	<div class="input-group-btn">
						            		<button type="submit" class="btn btn-blue"><span class="glyphicon glyphicon-search"></span></button>
						            	</div>
								</form>
							</div>
							<div class="col-md-3" style="text-align: right;padding-right: 40px;">
								<div class="btn-group">
								  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false" style="margin-right: 40px;">
								    Език <span class="caret"></span>
								  </button>
								  <ul class="dropdown-menu" role="menu">
								    <li><a href="#">Български</a></li>
								    <li><a href="#">English</a></li>
								  </ul>
								</div>
								<a class="" href="/login" title="Login"><img src="../assets/images/login.png" style="height: 40px;"/></a>
									&nbsp;&nbsp;&nbsp;
								<a class="" href="/register" title="Register"><img src="../assets/images/registereduser.png" style="height: 50px;;"/></a>
							</div>';
		}
		View::share('login_info', $login_info);
	}
	
	
	protected function setupLayout() {
		if ( ! is_null($this->layout)) {
			$this->layout = View::make($this->layout);
		}
	}
}
