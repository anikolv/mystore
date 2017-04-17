<?php

return array (
		
	'currency_api' => 'http://globalcurrencies.xignite.com/xGlobalCurrencies.xml/ConvertRealTimeValue?',
	'localhost' => 'http://78.83.56.4/',
	'admin_mail' => 'a.nikolov8@gmail.com',

    'get_products_by_category_endpoint' => 'http://localhost:8080/products/findByCategory/',
    'convert_currency_endpoint' => 'http://localhost:8080/currency',
    'get_orders_endpoint' => 'http://localhost:8080/orders/findAll',
    'get_users_endpoint' => 'http://localhost:8080/users/findAll',
    'delete_user_endpoint' =>'http://localhost:8080/users/deleteById/',
    'add_user_endpoint' => 'http://localhost:8080/users/add',
    'delete_product_endpoint' => 'http://localhost:8080/admin/product/deleteById/',
    'add_product_endpoint' => 'http://localhost:8080/products/add',
    'get_all_products_endpoint' => 'http://localhost:8080/products/getAll',
    'create_order' => 'http://localhost:8080/orders/create',
    'remove_product_from_cart' => 'http://localhost:8080/orders/%orderId%/removeProduct/%productId%',
    'add_product_to_cart' => 'http://localhost:8080/orders/%orderId%/addProduct/%productId%',
    'find_cart_by_id' => 'http://localhost:8080/orders/findById/',
    'get_product_by_id' => 'http://localhost:8080/products/findById/'
);
