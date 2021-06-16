<?php

/**
 * Description of UrlShortnerController
 *
 * @author Pranay
 */

declare (strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use \Illuminate\Support\Facades\Config;
use Carbon\Carbon;
use Exception;
use Redirect;

class UrlshortnerController extends Controller {


	public function __construct(){
		$this->UrlDb = new \App\Http\Models\urlshortner();
	}

	public function shortenUrl(Request $request){
		
		$response=array();
		$setValidator = Validator::make($request->post(), [
	        'url' => 'required|url'
	    ]);

        if ($setValidator->fails()) {
            
            $errorMessages = $setValidator->errors()->toArray();            
            $error = $errorMessages['url'][0];

            throw new Exception($error);
        }

        $url = $request->post()['url'];

        if($this->UrlDb->checkUrlExists($url,'long_url')){
        	throw new \App\Exceptions\ApiExceptions('Url already shortened.');
        }

        $chars = Config::get('constants.charset');

        $charset = str_shuffle($chars);
		$code = substr($charset, 0, rand(7,12));
		$code.=Carbon::now()->timestamp;

        while($this->UrlDb->checkUrlExists($code,'short_code')>0) {
        	$code = substr($charset, 0, rand(7,12));
			$code.=Carbon::now()->timestamp;
        }

        if(!$this->UrlDb->insertShortUrl($url,$code)) {
        	throw new Exception('Something went wrong. Please Try again Later.');
        }

        $response['data'] = Config::get('constants.domain_url').'/actualurl/'.$code;
        return $response;
	}

	public function getActualUrl($shortUrl){

		$result  = $this->UrlDb->getActualUrl($shortUrl);

		if(!empty($result)){
			return Redirect::away($result->long_url);
		}

		abort(404);	
	}
}

?>