<?php

class AdminController extends BaseController {

	public function adminOrders() {
		
		return View::make('admin_orders');
		
	}
	
	public function adminUsers() {
	
		return View::make('admin_users');
	
	}
	
	public function adminProducts() {
	
		return View::make('admin_products');
	
	}
	
	public function convertCurrency( $from, $to, $amount ) {

		$get = file_get_contents("https://www.google.com/finance/converter?a=$amount&from=$from&to=$to");
		$get = explode("<span class=bld>",$get);
		$get = explode("</span>",$get[1]);
		$converted_amount = preg_replace("/[^0-9\.]/", null, $get[0]);
		
		return $converted_amount;
		
	}
}
