<?php

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartDetails extends Eloquent  {


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'cart_details';
	protected $fillable = array(
		'cartid', 
		'name', 
		'address'
	);

	public function product() {
		return $this->hasOne('Product');
	}
	
	public function category() {
		return $this->hasOne('Cart');
	}
}
