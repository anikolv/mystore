<?php

class CartController extends BaseController {

	public function orders() {
		
		$page = (int)Request::query('page');
		$rows_per_page = (int)Request::query('size');
		$column_name = 'CART_ID';
		$order = 'asc';
		
		
		if (Request::query('col[0]') != null) {
			$column_name = 'CART_ID' ;
			$order = (Request::query('col[0]') == '0' ? 'asc' : 'desc');
		} else if (Request::query('col[1]') != null) {
			$column_name = 'CART_CREATION';
			$order = (Request::query('col[1]') == '0' ? 'asc' : 'desc');
		} else if (Request::query('col[2]') != null) {
			$column_name = 'CUSTOMER_NAME';
			$order = (Request::query('col[2]') == '0' ? 'asc' : 'desc');
		} else if (Request::query('col[3]') != null) {
			$column_name = 'CUSTOMER_ADDRESS';
			$order = (Request::query('col[3]') == '0' ? 'asc' : 'desc');
		} else if (Request::query('col[4]') != null) {
			$column_name = 'CART_COST';
			$order = (Request::query('col[4]') == '0' ? 'asc' : 'desc');
		} else if (Request::query('col[5]') != null) {
			$column_name = 'CART_STATUS';
			$order = (Request::query('col[5]') == '0' ? 'asc' : 'desc');
		} 
		
		$sorting = $column_name . " " . $order;
		
		$orders = DB::connection('mysql')->select('select c.id as CART_ID, c.created_at as CART_CREATION, cd.name as CUSTOMER_NAME, 
												  cd.address as CUSTOMER_ADDRESS, c.cost as CART_COST, c.status as CART_STATUS
												  from carts c
												  left join cart_details cd on c.id = cd.cartid
												   order by ' . $sorting
												);
		
		$count = count ( $orders );
		
		
		$page_items = array ();
		$t = 0;
		foreach ( $orders as $order ) {
			if (($t >= ($page * $rows_per_page) && $t < ($page * $rows_per_page + $rows_per_page))) {
				$page_items [] = $order;
			}
			$t ++;
		}
		
		$this->status ['result'] = 0;
		$this->status ['orders'] = $page_items;
		$this->status ['count'] = $count;
		return json_encode($this->status);
		
// 		$ordersArr = array();
// 		foreach( $orders as $order ) {
// 			$ordersArr[$order->CART_ID] = $order;
// 		}
		
// 		foreach( $orders as $order ) {
			
// 			$products = DB::connection('mysql')->select('select p.name as PRODUCT_NAME, cp.product_qty as PRODUCT_QTY,
// 														p.price_usd as PRODUCT_PRICE
// 														from products p
// 														left join carts_products cp on cp.product_id = p.id
// 														where cp.cart_id = ?', 
// 														array($order->CART_ID)
// 			);
			
// 			$ordersArr[$order->CART_ID]->products = $products;
			
// 		}
		
// 		$this->orders = $orders;
// 		$this->products = $ordersArr->products;
		
		
	}
	
	public function notify() {
		Log::info("NOTIFY HIT");
	}
}
