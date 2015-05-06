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
	
}
