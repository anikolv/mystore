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
			
			$cart = Session::get('cart');
			$cartProducts =  DB::connection('mysql')->select('select * from carts_products where cart_id = ?',
													 		  array($cart->id));
			
			foreach ( $cartProducts as $cartProduct ) {
				
				if ( $cartProduct->product_id = $productId ) {
				
					$cartProduct->product_qty = $cartProduct->product_qty + 1;
					$cartProduct->save();
				
					$cart->cost = $cart->cost + $cartProduct->product_cost;
					$cart->save();
					Session::push('cart', $cart);
				
				} else {
				
							CartProduct::create(['cart_id' => $cart->id,
												 'product_id' => $productId,
							                     'product_cost' => $product->price_bgn
												]);
				
				}
				
			}
				
		} else {
			
			$cart = Cart::create(['status' => 'NEW',
								   'cost' => $product->price_bgn
								]);
			$cartProduct = CartProduct::create(['cart_id' => $cart->id,
												'product_id' => $productId,
												'product_cost' => $product->price_bgn,
												'product_qty' => 1
			]);
			
			Session::push('cart', $cart);
			
		}		
	}
}
