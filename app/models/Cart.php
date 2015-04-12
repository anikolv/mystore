<?php

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Eloquent  {


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'carts';
	protected $fillable = array(
		'id', 
		'cost', 
		'status', 
		'created_at', 
		'paid_at'
	);

	public function cartProduct() {
		return $this->belongsTo('Cart_product');
	}	
}
