<?php

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Eloquent  {


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'products';
	protected $fillable = array(
		'id', 
		'name', 
		'description', 
		'price_bgn', 
		'category', 
		'visible',
	     'qty',
		 'image'
	);

	public function category() {
		return $this->hasOne('Category');
	}
	
	public function cartProduct() {
		return $this->belongsTo('Cart_product');
	}	
}
