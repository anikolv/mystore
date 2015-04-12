<?php

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartProduct extends Eloquent  {


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'carts_products';
	protected $fillable = array(
		'id', 
		'product_cost', 
		'product_qty', 
		'product_id', 
		'cart_id'
	);

	public function product() {
		return $this->hasOne('Product');
	}
	
	public function category() {
		return $this->hasOne('Cart');
	}
}
