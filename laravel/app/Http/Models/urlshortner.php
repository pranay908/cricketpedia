<?php

declare (strict_types=1);

namespace App\Http\Models;

use Illuminate\Support\Facades\DB;

/**
 * Description of Urlshortner
 *
 * @author pranay
 */
class urlshortner{

	public function __construct(){
        $this->db = DB::connection('mysql');
    }

	public function checkUrlExists($url,$column): int {

		$select = $this->db->table("short_urls")
                    ->where($column, "=", $url);

        return $select->count();
	}

	public function insertShortUrl($longUrl,$shortUrl): bool{

		$data=array();
		$data['long_url'] = $longUrl;
		$data['short_code'] = $shortUrl;

		return $this->db->table('short_urls')
                    ->insert($data);

	}

	public function getActualUrl($url){

		$select = $this->db->table("short_urls")
                    ->where('short_code', "=", $url);

        return $select->first('long_url');
	}
}

?>