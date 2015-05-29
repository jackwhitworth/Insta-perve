<?php namespace App\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Vinkla\Instagram\Facades\Instagram;

class WelcomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest');
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$instagram = new \MetzWeb\Instagram\Instagram(array(
			'apiKey'      => 'a07741f8d6ee40048d9f2505d58118e1',
			'apiSecret'   => 'b45edac40831451fbd5fe525ad865c49',
			'apiCallback' => 'http://localhost:8000/'
		));

		if (!Session::has('access_token')){
			$code = $_GET['code'];

			$data = $instagram->getOAuthToken($code);

			if (isset($data->access_token)) {
				$instagram->setAccessToken($data);
				Session::put('access_token',$data->access_token);
			} else {
				echo "<a href='{$instagram->getLoginUrl()}'>Login with Instagram</a>";
			}
		}

		$searchmedia = $instagram->searchMedia(52.9521724, -1.143788719, 2000, strtotime("-1 week"));


		return view('perve', ['media' => $searchmedia]);
	}
}
