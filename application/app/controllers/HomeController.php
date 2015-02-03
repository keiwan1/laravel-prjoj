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


	// ********** Main Home Controller //

	public function home(){
		try{

			$settings = Setting::first();
			if($settings){
				
				$search = Input::get('search');
				if(isset($search)){
					$media = Media::where('active', '=', 1)->where('title', 'LIKE', '%'.$search.'%')->orderBy('created_at', 'desc')->paginate(Config::get('site.num_results_per_page'));
				} else {
					$media = Media::where('active', '=', 1)->orderBy('created_at', 'desc')->paginate(Config::get('site.num_results_per_page'));
				}

				$data = array(
					'media' => $media,
					'search' => $search
					);

				return View::make('home', $data);

			} else {
				throw new Exception('settings not set, first install the script');
			}

		}catch(Exception $e){

			return Redirect::to('install');

		}
	}

}