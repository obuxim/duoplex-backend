<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TMDBController extends Controller
{
    protected $api_key;

    public function __construct()
    {
        $this->api_key = config('app.tmdb_api_key');
    }

    public function getMovie(Request $request, $movie_id)
    {
        $url = "https://api.themoviedb.org/3/movie/$movie_id?api_key=$this->api_key&language=en";
        $response = file_get_contents($url);
        return response($response);
    }

    public function getIMDBRating($movie_id){
        $url = "https://www.imdb.com/title/$movie_id/ratings";
        $response = file_get_contents($url);
        $result = Str::match('/<span class="ipl-rating-star__rating">(.*)<\/span>/', $response);
        return $result;
    }

    public function getLogo($movie_id){
        $api_key = config('app.tmdb_api_key');
        $url = "https://api.themoviedb.org/3/movie/$movie_id/images?api_key=$this->api_key&language=en";
        $response = file_get_contents($url);
        $jsonArray = json_decode($response, true);
        $logos = $jsonArray['logos'];
        return(substr($logos[0]['file_path'], 1));
    }

    public function getTrailer($movie_id){
        $api_key = config('app.tmdb_api_key');
        $url = "https://api.themoviedb.org/3/movie/$movie_id/videos?api_key=$this->api_key&language=en";
        $response = file_get_contents($url);
        $jsonArray = json_decode($response, true);
        $results = [];
        foreach ($jsonArray['results'] as $key => $value) {
            if($value['type'] == 'Trailer' && $value['official'] == true && $value['site'] == 'YouTube'){
                array_push($results, $value);
            }
        }
        return($results[0]['key']);
    }
}
