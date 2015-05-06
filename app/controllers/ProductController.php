<?php
class ProductController extends BaseController {
	public function getProducts() {
		
		$page = (int)Request::query('page');
		$rows_per_page = (int)Request::query('size');
		$column_name = 'PRO_ID';
		$order = 'asc';
		
		
		if (Request::query('col[0]') != null) {
			$column_name = 'PRO_ID' ;
			$order = (Request::query('col[0]') == '0' ? 'asc' : 'desc');
		} else if (Request::query('col[1]') != null) {
			$column_name = 'PRO_NAME';
			$order = (Request::query('col[1]') == '0' ? 'asc' : 'desc');
		} else if (Request::query('col[2]') != null) {
			$column_name = 'PRO_CATEGORY';
			$order = (Request::query('col[2]') == '0' ? 'asc' : 'desc');
		} else if (Request::query('col[3]') != null) {
			$column_name = 'PRO_PRICE';
			$order = (Request::query('col[3]') == '0' ? 'asc' : 'desc');
		} else if (Request::query('col[4]') != null) {
			$column_name = 'PRO_QTY';
			$order = (Request::query('col[4]') == '0' ? 'asc' : 'desc');
		} 
		
		$sorting = $column_name . " " . $order;
				
		$products = DB::connection('mysql')->select('select p.id as PRO_ID, p.name as PRO_NAME,
														  c.name as PRO_CATEGORY, p.price_bgn as PRO_PRICE, p.qty as PRO_QTY
												  from products p
												  left join categories c on p.category = c.id
												   order by ' . $sorting
												);
		
		$count = count ( $products );
				
		$page_items = array ();
		$t = 0;
		foreach ( $products as $product ) {
			if (($t >= ($page * $rows_per_page) && $t < ($page * $rows_per_page + $rows_per_page))) {
				$page_items [] = $product;
			}
			$t ++;
		}
		
		$this->status ['result'] = 0;
		$this->status ['products'] = $page_items;
		$this->status ['count'] = $count;
		return json_encode($this->status);
		
	}
	
	public function addProduct() {
		
    	$product = Product::create(['name'       => Input::get('name'),
    								'qty'       => Input::get('qty'),
                           			'description'       => Input::get('description'),
                           			'category' => Input::get('category'),
                           			'price_bgn'      => Input::get('price'),
    								'image' =>   Input::get('image')]);	
	}
	
	public function removeProduct() {
 		$product = Product::find(Input::get('id'));
 		$product->delete();
 		
	}
	
	public function tablets() {
	
		return View::make('tablets');
	
	}
	
	public function notebooks() {
	
		return View::make('notebooks');
	
	}
	
	public function tvs() {
	
		return View::make('tvs');
	
	}
	
	
	public function getPhones() {
		
		$phones = DB::connection('mysql')->select('select * from Products where category = 1 and qty > 0');
		
		if( Session::get('currency') != null && Session::get('currency') != 'BGN') {
			foreach($phones as $phone) {
				$phone->price_bgn = number_format((float)$this->convertCurrency('BGN', Session::get('currency'), $phone->price_bgn), 2, '.', '');;
			}
		}
		
		$this->status ['result'] = 0;
		$this->status ['phones'] = $phones;
		$this->status ['currency'] = (Session::get('currency') == null ? 'BGN' : Session::get('currency'));
		return json_encode($this->status);
		
	}
	
	public function getTablets() {
	
		$tablets = DB::connection('mysql')->select('select * from Products where category = 2 and qty > 0');
		
		if( Session::get('currency') != null && Session::get('currency') != 'BGN') {
			foreach($tablets as $tablet) {
				$tablet->price_bgn = number_format((float)$this->convertCurrency('BGN', Session::get('currency'), $tablet->price_bgn), 2, '.', '');;
			}
		}
			
		$this->status ['result'] = 0;
		$this->status ['tablets'] = $tablets;
		$this->status ['currency'] = (Session::get('currency') == null ? 'BGN' : Session::get('currency'));
		return json_encode($this->status);
	
	}
	
	public function getNotebooks() {
	
		$notebooks = DB::connection('mysql')->select('select * from Products where category = 3 and qty > 0');
		
		if( Session::get('currency') != null && Session::get('currency') != 'BGN') {
			foreach($notebooks as $notebook) {
				$notebook->price_bgn = number_format((float)$this->convertCurrency('BGN', Session::get('currency'), $notebook->price_bgn), 2, '.', '');;
			}
		}
			
		$this->status ['result'] = 0;
		$this->status ['notebooks'] = $notebooks;
		$this->status ['currency'] = (Session::get('currency') == null ? 'BGN' : Session::get('currency'));
		return json_encode($this->status);
	
	}
	
	public function getTvs() {
	
		$tvs = DB::connection('mysql')->select('select * from Products where category = 4 and qty > 0');
		
		if( Session::get('currency') != null && Session::get('currency') != 'BGN') {
			foreach($tvs as $tv) {
				$tv->price_bgn = number_format((float)$this->convertCurrency('BGN', Session::get('currency'), $tv->price_bgn), 2, '.', '');;
			}
		}
			
		$this->status ['result'] = 0;
		$this->status ['tvs'] = $tvs;
		$this->status ['currency'] = (Session::get('currency') == null ? 'BGN' : Session::get('currency'));
		return json_encode($this->status);
	
	}
	
	public function search() {
		
		$filter = Input::get('query');
		$products = DB::connection('mysql')->select('select * from Products where name like "%' . $filter . '%"');
		if($filter == '') {
			$products = null;
		}
		$key = 'search';
		
		if (Cache::has($key)) {
			Cache::forget($key);
			Cache::put($key, $products, 10);
		} else {
			Cache::put($key, $products, 10);
		}
		
		return View::make('search_results');
		
	}
	
	public function getSearchResults() {
		$key = 'search';
		
		if (Cache::has($key)) {
			$products = Cache::get($key);
			if (count($products) == 0 || $products == null) {
				$this->status ['result'] = 1;
				return json_encode($this->status);
			} else {
				$this->status ['result'] = 0;
				$this->status ['products'] = $products;
				return json_encode($this->status);
			}
		} else {
			$this->status ['result'] = 1;
			return json_encode($this->status);
		}
		
	}
}