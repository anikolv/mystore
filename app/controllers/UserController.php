<?php

class UserController extends BaseController {

	public function register() {
		
		return View::make('register');
		
	}
	
	public function login() {
	
		return View::make('login');
	
	}
	
	public function registerUser() {	
		
		$name = Input::get('name');
		$address = Input::get('address');
		$email = Input::get('email');
		$password = Input::get('password');
		$repeatPassword = Input::get('repeatPassword');
		
		if ($password != $repeatPassword ) {
			$this->status["result"] = 1;
			$this->status["message"] = 'Passwords missmatch';
			return json_encode($this->status);
		}
		
		$user = new User;
		$user->email = $email;
		$user->name = $name;
		$user->address = $address;
		$user->password = Hash::make($password);
		$user->active = 1;
		$user->role = 1;
		
		$user->save();
		
		$this->status["result"] = 0;
		$this->status["message"] = 'Registration successfull';
		
		return json_encode($this->status);
		
	}
	
	public function loginUser() {
		
		$email = Input::get('email');
		$password = Input::get('password');
		$remember = Input::get('remember');
		
		$user = User::where('email', '=', $email)
		->where('active', '=', '1')
		->first();
		
		if( $user && Hash::check($password, $user->password) ) {
			Auth::login($user, $remember);
			
			$this->status["result"] = 0;
			$this->status["role"] = $user->role;
			$this->status["message"] = "Success	.";
			return json_encode($this->status);
			
		} else {
			$this->status["result"] = 1;
			$this->status["message"] = "Wrong username or password.";
			return json_encode($this->status);
		}
	}
	
	public function logout() {
		
		if (Auth::check()) {
			Auth::logout();
		}
		
		return Redirect::to('/');
		
	}
	
	public function getUsers() {
		
		$page = (int)Request::query('page');
		$rows_per_page = (int)Request::query('size');
		$column_name = 'USER_ID';
		$order = 'asc';
		
		
		if (Request::query('col[0]') != null) {
			$column_name = 'USER_ID' ;
			$order = (Request::query('col[0]') == '0' ? 'asc' : 'desc');
		} else if (Request::query('col[1]') != null) {
			$column_name = 'USER_CREATION';
			$order = (Request::query('col[1]') == '0' ? 'asc' : 'desc');
		} else if (Request::query('col[2]') != null) {
			$column_name = 'USER_NAME';
			$order = (Request::query('col[2]') == '0' ? 'asc' : 'desc');
		} else if (Request::query('col[3]') != null) {
			$column_name = 'USER_ADDRESS';
			$order = (Request::query('col[3]') == '0' ? 'asc' : 'desc');
		} else if (Request::query('col[4]') != null) {
			$column_name = 'USER_EMAIL';
			$order = (Request::query('col[4]') == '0' ? 'asc' : 'desc');
		} else if (Request::query('col[5]') != null) {
			$column_name = 'ROLE_NAME';
			$order = (Request::query('col[5]') == '0' ? 'asc' : 'desc');
		}
		
		$sorting = $column_name . " " . $order;
		
		$users = DB::connection('mysql')->select('select u.id as USER_ID, u.created_at as USER_CREATION,
														 u.name as USER_NAME, u.address as USER_ADDRESS, u.email as USER_EMAIL,
														 r.name as ROLE_NAME
												  from users u
												  left join roles r on u.role = r.id
												  where u.active = 1
												  order by ' . $sorting);

		$count = count ( $users );
		
		
		$page_items = array ();
		$t = 0;
		foreach ( $users as $user ) {
			if (($t >= ($page * $rows_per_page) && $t < ($page * $rows_per_page + $rows_per_page))) {
				$page_items [] = $user;
			}
			$t ++;
		}
		
		$this->status ['result'] = 0;
		$this->status ['users'] = $page_items;
		$this->status ['count'] = $count;
		return json_encode($this->status);
		
	}
	
	public function addUser() {
				
		$user = new User;
		$user->email = Input::get('email');
		$user->name = Input::get('name');
		$user->address = Input::get('address');
		$user->password = Hash::make(Input::get('password'));
		$user->active = 1;
		$user->role = Input::get('role');
		
		$user->save();
		
	}
	
	public function removeUser() {
	
		$user = User::find(Input::get('id'));
		$user->delete();
			
	
	}
	
	public function getDetails() {
		
		$this->loginFlag = true;
		
		if (Auth::user() != null) {
			$this->status['result'] = 0;
			$this->status['name'] = Auth::user()->name;
			$this->status['address'] = Auth::user()->address;
			$this->status['email'] = Auth::user()->email;
			$this->status['amount'] = Session::get('amount')[0] * 0.5;
			
			return json_encode($this->status);
		} else {
			$this->status['result'] = 1;
			return json_encode($this->status);
		}
		
	}
	
}
