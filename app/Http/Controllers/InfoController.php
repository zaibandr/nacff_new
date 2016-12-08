<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 04.03.2016
 * Time: 12:34
 */

namespace App\Http\Controllers;

use App\Http\Controllers\DBController;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use sngrl\SphinxSearch\SphinxSearch;
use App\Letter;

class InfoController extends DBController
{
    public function index()
    {
        $error = ''; $count = 0; $key = '';
        $re = '/<style type="text\/css">[a-zA-Z0-9:;.\s\(\)\-\,{}]*<\/style>/';
        $request = NULL;
        if(Input::has('search')) {
            $sphinx = new SphinxSearch();
            $string = "'*" . trim(Input::get('search')) . "*'";
            $result = $sphinx->search($string)->get();
            $b = [];
            if (isset($result['matches'])) {
                $count = count($result['matches']);
                foreach ($result['matches'] as $k => $v) {
                    $key[]= $k;
                }
                //$key = substr($key,0,-1);
                $request = Letter::search($key)->active()->paginate(3);
            } else {
                $error = "Результат поиска пуст";
            }
        } else {
            $request = Letter::active()->paginate(3);
        }
        return View::make('info')->with([
            'error' => $error,
            'res' => $request,
            're' => $re
        ]);
    }
}