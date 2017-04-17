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
		
//		$sorting = $column_name . " " . $order;
//
//		$orders = DB::connection('mysql')->select('select c.id as CART_ID, c.created_at as CART_CREATION, cd.name as CUSTOMER_NAME,
//												  cd.address as CUSTOMER_ADDRESS, c.cost as CART_COST, c.status as CART_STATUS
//												  from carts c
//												  left join cart_details cd on c.id = cd.cartid
//												   order by ' . $sorting
//												);

//
//		$count = count ( $orders );
//
//
//		$page_items = array ();
//		$t = 0;
//		foreach ( $orders as $order ) {
//			if (($t >= ($page * $rows_per_page) && $t < ($page * $rows_per_page + $rows_per_page))) {
//				$page_items [] = $order;
//			}
//			$t ++;
//		}


        $endpoint = Config::get('settings.get_orders_endpoint');
        $xml_result = $this->performGetRequest($endpoint);

        $count = count($xml_result->order);

		$page_items = array ();
		$t = 0;
		for ( $i = 0, $size = count($xml_result->order); $i < $size; ++$i ) {
            if (($t >= ($page * $rows_per_page) && $t < ($page * $rows_per_page + $rows_per_page))) {
                $item = $xml_result->order[$i];
                $order = new StdClass();
                $order->CART_ID = (int)$item->id;
                $order->CART_CREATION = (string)$item->createdAt;
                $order->CUSTOMER_NAME = isset($item->details->name) ? (string)$item->details->name : '';
                $order->CUSTOMER_ADDRESS = isset($item->details->address) ? (string)$item->details->address : '';
                $order->CART_COST = (string)$item->cost;
                $order->CART_STATUS = (string)$item->status;
                $page_items [] = $order;
            }
            $t++;
        }

		
		$this->status ['result'] = 0;
		$this->status ['orders'] = $page_items;
		$this->status ['count'] = $count;
		return json_encode($this->status);
	}
	
	public function notify() {
		
		if( Input::get('payment_status') == 'Pending' || Input::get('payment_status') == 'Completed' ) {
			
			$cartId = Input::get('item_number');

			$cart = Cart::find($cartId);
			$cart->status = 'ПЛАТЕНА';
			$cart->save();
			
			$products = DB::connection('mysql')->select('select product_id from carts_products where cart_id = ?', array($cartId));
			foreach( $products as $product ) {
				$pr = Product::find($product->product_id);
				$pr->qty = $pr->qty - 1;
				$pr->save(); 
			}
			Session::flush();
		}
		
	}
}
