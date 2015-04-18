<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	
	public function __construct() {
		$login_info = '';
		if (Auth::user() != null) {
			$login_info .= '<div class="col-md-3" style="text-align: left; padding-left: 40px; ">
								<a class="" href="/" title="Home"><img src="../assets/images/test2.png" style="height: 50px;"/></a>
							</div>
							<div class="col-md-5" style="margin-top: 7px;">'.
								(Auth::user()->role == 1 ? '
								<div class="input-group">
						            <input type="text" class="form-control" placeholder="Search for products..." id="query" name="query" value="">
							         <div class="input-group-btn">
						            <button type="submit" class="btn btn-blue"><span class="glyphicon glyphicon-search"></span></button>
						            </div>
						        </div>' : '') .
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
								<div class="input-group">
						            <input type="text" class="form-control" placeholder="Търси продукти..." id="query" name="query" value="">
							            <div class="input-group-btn">
						            <button type="submit" class="btn btn-blue"><span class="glyphicon glyphicon-search"></span></button>
						            </div>
						        </div>
							</div>
							<div class="col-md-3" style="text-align: right;padding-right: 40px;">
								<a class="" href="login" title="Login"><img src="../assets/images/login.png" style="height: 40px;"/></a>
									&nbsp;&nbsp;&nbsp;
								<a class="" href="register" title="Register"><img src="../assets/images/registereduser.png" style="height: 50px;;"/></a>
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
