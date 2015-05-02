<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function index() {
		
		if(Auth::check() && Auth::user()->role == 2) {
			return Redirect::to('adminOrders');
		} else {
			return View::make('index');
		}
		
	}
	
	public function chooseDetails() {
	
		return View::make('choose_details');
	
	}
	
	public function contact() {
	
		return View::make('contact');
	
	}
	
	public function sendMessage() {
	
		$data = array(
				'content' => Input::get('message'),
				'name' => Input::get('name')
		);
		

		$mail = Mail::send('email', $data, function($message) {
			$message->to(Config::get('settings.admin_mail'), 'a.nikolov8')->subject('Запитване');
		});
		
		if(count(Mail::failures()) > 0) {
			$this->status["result"] = 1;
			$this->status["message"] = "Получи се грешка. Опитай по-късно.";
			return json_encode($this->status);
		}
		
		$this->status["result"] = 0;
		$this->status["message"] = "Съобщението е изпратено успешно!";
		return json_encode($this->status);
	
	}

}
