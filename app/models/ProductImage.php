<?php

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImage extends Eloquent  {


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'images';
	protected $fillable = array(
		'product_id', 
		'image'
	);

}
