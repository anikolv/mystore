<?php

class CartProductController extends BaseController {
	
	public function myCart() {
		
		return View::make('mycart');
		
	}
	
	public function getMyCart() {
		
		if( null !== Session::get('cart') || null !== Session::get('product_amount')) {
			
				$cartId = Session::get('cart');
			
				$cart_products = DB::connection('mysql')->select('select p.*
											         			  from carts_products cp
												     			  left join products p on cp.product_id = p.id
												     			  where cp.cart_id = ?',
													 			  array($cartId[0]));
				
				if ( !empty($cart_products) ) {
					
					$this->status ['result'] = 0;
					$this->status ['total'] = Session::get('amount')[0];
					$this->status ['products'] = $cart_products;
					return json_encode($this->status);
					
				} else {
					$this->status ['result'] = 1;
					return json_encode($this->status);
				}
			
		} else {
			$this->status ['result'] = 1;
			return json_encode($this->status);
		}
		
	}

	public function getCartProducts() {
		
		$cartId = Input::get('id');
		
		
		$products = DB::connection('mysql')->select('select p.name
											         from Products p
												     left join carts_products cp on cp.product_id = p.id
												     where cp.cart_id = ?',
													 array($cartId));
		
		$this->status ['products'] = $products;
		
		return json_encode($this->status);
		
	}
	
	public function addToCart($productId) {
		
		$product = Product::where('id', '=', $productId)->first();
		//Session::flush();
		
		$amount = 10;
		$from_Currency = 'BGN';
		$to_Currency = 'EUR';
		$get = file_get_contents("https://www.google.com/finance/converter?a=$amount&from=$from_Currency&to=$to_Currency");
		$get = explode("<span class=bld>",$get);
		$get = explode("</span>",$get[1]);
		$converted_amount = preg_replace("/[^0-9\.]/", null, $get[0]);
		
// 		if( null !== Session::get('cart') ) {
			
			
// 			$cartId = Session::get('cart');
// 			$products_count = Session::get('products_amount')[0];
// 			$amount = Session::get('amount')[0];

// 				$cartProduct = CartProduct::create(['cart_id' => $cartId[0],
// 									 				'product_id' => $productId,
// 							          				'product_cost' => $product->price_bgn,
// 													'product_qty' => 1
// 													]);
				
// 				if( isset($cartProduct) ){
// 					$products_count++;
// 					$amount += $product->price_bgn;
// 				}
// 				Session::push('cart', $cartId);
// 				Session::forget('products_amount');
// 				Session::push('products_amount', $products_count);
				
// 				Session::forget('amount');
// 				Session::push('amount', $amount);
// 		} else {
			
// 			$products_count = 0;
// 			$amount = 0;
// 			$cart = Cart::create(['status' => 'НОВА',
// 								   'cost' => $product->price_bgn
// 								]);

// 			$cartProduct = CartProduct::create(['cart_id' => $cart->id,
// 												'product_id' => $productId,
// 												'product_cost' => $product->price_bgn,
// 												'product_qty' => 1
// 												]);
			
// 			if( isset($cartProduct) ) {
// 				$products_count++;
// 				$amount = $product->price_bgn;
// 			}
// 			Session::push('cart', $cart->id);
// 			Session::forget('products_amount');
// 			Session::push('products_amount', $products_count);
			
// 			Session::forget('amount');
// 			Session::push('amount', $amount);
// 		}		
	}
	
	public function removeFromCart($productId) {
		

		$cartId = Session::get('cart');
		$products_count = Session::get('products_amount')[0];
		$amount = Session::get('amount')[0];
		$product = Product::find($productId);
		
		DB::connection('mysql')->delete('delete from carts_products where cart_id = ? and product_id = ? limit 1', array($cartId[0], $productId));
		
		$products_count = $products_count - 1;
		Session::forget('products_amount');
		Session::push('products_amount', $products_count);
		
		$amount = $amount - $product->price_bgn;
		Session::forget('amount');
		Session::push('amount', $amount);
		
	}
}
