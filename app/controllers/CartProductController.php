<?php

class CartProductController extends BaseController {

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
		
		if( null !== Session::get('cart') ) {
			
			
			$cartId = Session::get('cart');
			$products_count = Session::get('products_amount');

				$cartProduct = CartProduct::create(['cart_id' => $cartId[0],
									 				'product_id' => $productId,
							          				'product_cost' => $product->price_bgn,
													'product_qty' => 1
													]);
				
				if( isset($cartProduct) ) $products_count++;
				Session::push('cart', $cartId);
				Session::push('products_amount', $products_count);
				
				
		} else {
			
			$products_count = 0;
			$cart = Cart::create(['status' => 'NEW',
								   'cost' => $product->price_bgn
								]);
			$cartProduct = CartProduct::create(['cart_id' => $cart->id,
												'product_id' => $productId,
												'product_cost' => $product->price_bgn,
												'product_qty' => 1
												]);
			
			if( isset($cartProduct) ) $products_count++;
			Session::push('cart', $cart->id);
			Session::push('products_amount', $products_count);
			
		}		
	}
}
