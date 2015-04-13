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
}
