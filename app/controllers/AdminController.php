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
		
		$opts = array('http' =>
			array(
				'method'	=> 'GET',
				'header'	=> 'Content-type: application/xml'
			)
		);
	
		$context  = stream_context_create($opts);
		$endpoint = Config::get('settins.currency_api') . 'From=' . $from . '&To=' . $to . '&Amount=' . $amount;
		$result = file_get_contents($endpoint, false, $context);
		$xml_result = simplexml_load_string($result);
		
		return $xml_result->result;
		
		
	}
}
