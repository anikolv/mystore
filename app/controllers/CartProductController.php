<?php

class CartProductController extends BaseController {
	
	public function myCart() {
		
		return View::make('mycart');
		
	}
	
	public function getMyCart() {
		
		if( null !== Session::get('cart') || null !== Session::get('product_amount')) {
			
				$cartId = Session::get('cart');
			
//				$cart_products = DB::connection('mysql')->select('select p.*
//											         			  from carts_products cp
//												     			  left join products p on cp.product_id = p.id
//												     			  where cp.cart_id = ?',
//													 			  array($cartId[0]));

            $order = $this->performGetRequest(Config::get('settings.find_cart_by_id') . $cartId[0]);
            $products = array();
            for($i = 0, $size = count($order->products->product); $i < $size; ++$i) {
                $item = $order->products->product[$i];
                $product = new StdClass();
                $product->id = (int)$item->id;
                $product->product_cost = (int)$order->products->cost;
                $product->name = (string)$item->name;
                $product->product_qty = (int)$order->products->qantity;
                $product->image = (string)$item->image;
                $product->price_bgn = (string)$item->price;

                $products[] = $product;
            }

            if ( !empty($products) ) {
					
					$total = Session::get('amount')[0];
					$bgn_total = Session::get('amount')[0];
					if( Session::get('currency') != null && Session::get('currency') != 'BGN') {
						$total = number_format((float)$this->convertCurrency('BGN', Session::get('currency'), $total), 2, '.', '');
					foreach($products as $cart_product) {
						$cart_product->price = number_format((float)$this->convertCurrency('BGN', Session::get('currency'), $cart_product->price), 2, '.', '');;
						}
					}
					
					$this->status ['result'] = 0;
					$this->status ['total'] = $total;
					$this->status ['bgn_total'] = $bgn_total;
					$this->status ['products'] = $products;
					$this->status ['currency'] = (Session::get('currency') == null ? 'BGN' : Session::get('currency'));
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
		
//
//		$products = DB::connection('mysql')->select('select p.name
//											         from Products p
//												     left join carts_products cp on cp.product_id = p.id
//												     where cp.cart_id = ?',
//													 array($cartId));

        $order = $this->performGetRequest(Config::get('settings.find_cart_by_id') . $cartId[0]);

        $products = array();
        for($i = 0, $size = count($order->products->product); $i < $size; ++$i) {
            $pro = $order->products->product[$i];
            $products[] = $pro;
        }

        $this->status ['products'] = $products;
		
		return json_encode($this->status);
		
	}
	
	public function addToCart($productId) {
		
//		$product = Product::where('id', '=', $productId)->first();
        $product = $this->performGetRequest(Config::get('settings.get_product_by_id') . $productId);
		//Session::flush();

		
		if( null !== Session::get('cart') ) {
			
			
			$cartId = Session::get('cart');

//			$products = DB::connection('mysql')->select('select * from carts_products cp
//												        where cp.cart_id = ?',
//													   array($cartId[0]));

            $order = $this->performGetRequest(Config::get('settings.find_cart_by_id') . $cartId[0]);

            $counter = 0;
            for($i = 0, $size = count($order->products->product); $i < $size; ++$i) {
                $pro = $order->products->product[$i];

                Log::info("counter: " . $counter);
				if($pro->id == $productId) $counter++;
			}
			
			
			if( $counter < $product->quantity ) {
				$products_count = Session::get('products_amount')[0];
				$amount = Session::get('amount')[0];
				
//				$cartProduct = CartProduct::create(['cart_id' => $cartId[0],
//						'product_id' => $productId,
//						'product_cost' => $product->price_bgn,
//						'product_qty' => 1
//				]);

                $add_product_endpoint = str_replace(array("%orderId%", "%productId%"), array($cartId[0], $productId), Config::get('settings.add_product_to_cart'));
                $this->performGetRequest($add_product_endpoint);
				
//				if( isset($cartProduct) ){
					$products_count++;
					$amount += $product->price;
//				}
				Session::push('cart', $cartId);
				Session::forget('products_amount');
				Session::push('products_amount', $products_count);
				
				Session::forget('amount');
				Session::push('amount', $amount);
			} 
			
		} else {
			
			$products_count = 0;
			$amount = 0;
//			$cart = Cart::create(['status' => 'НОВА',
//								   'cost' => $product->price_bgn
//								]);
            $cart_id = $this->performGetRequest(Config::get('settings.create_order'));
            $add_product_endpoint = str_replace(array("%orderId%", "%productId%"), array($cart_id, $productId), Config::get('settings.add_product_to_cart'));
            $this->performGetRequest($add_product_endpoint);

//			$cartProduct = CartProduct::create(['cart_id' => $cart->id,
//												'product_id' => $productId,
//												'product_cost' => $product->price_bgn,
//												'product_qty' => 1
//												]);
			
//			if( isset($cartProduct) ) {
				$products_count++;
				$amount = $product->price;
//			}
			Session::push('cart', $cart_id);
			Session::forget('products_amount');
			Session::push('products_amount', $products_count);
			
			Session::forget('amount');
			Session::push('amount', $amount);
		}		
	}
	
	public function removeFromCart($productId) {
		

		$cartId = Session::get('cart');
		$products_count = Session::get('products_amount')[0];
		$amount = Session::get('amount')[0];
//		$product = Product::find($productId);
        $product = $this->performGetRequest(Config::get('settings.get_product_by_id') . $productId);

//		DB::connection('mysql')->delete('delete from carts_products where cart_id = ? and product_id = ? limit 1', array($cartId[0], $productId));

        $remove_product_from_cart_endpoint = str_replace(array("%orderId%", "%productId%"), array($cartId[0], $productId), Config::get('settings.remove_product_from_cart'));
        $this->performGetRequest($remove_product_from_cart_endpoint);

        $products_count = $products_count - 1;
		Session::forget('products_amount');
		Session::push('products_amount', $products_count);
		
		$amount = $amount - $product->price_bgn;
		Session::forget('amount');
		Session::push('amount', $amount);
		
	}
}
