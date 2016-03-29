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

class InfoController extends DBController
{
    public function index()
    {
        $error = '';
        if(Input::has('search')) {
            $sphinx = new SphinxSearch();
            $string = "'*" . trim(Input::get('search')) . "*'";
            $result = $sphinx->search($string)->get();
            $error = "Результат поиска пуст";
            $b = [];
            if (isset($result['matches'])) {
                foreach ($result['matches'] as $k => $v) {
                    $res = $this->queryDB("select logdate, username, caption, body from letters where flag=1 and id=$k");
                    $row = $this->getResult($res);
                    if (count($row) > 0) {
                        $b[] = $row[0];
                        $b[count($b) - 1]['BODY'] = strip_tags($row[0]['BODY'], '<p><li><ul><b><i>');
                        $error = '';
                    }
                }
            }
        } else {
            $res = $this->queryDB("select logdate, username, caption, body from letters where flag=1 order by logdate");
            while($row=ibase_fetch_assoc($res)) {
                $row['BODY'] = strip_tags($row['BODY'], '<ul><b><i>');
                $b[] = $row;
            }
        }
        return View::make('info')->with([
            'error' => $error,
            'res' => $b
        ]);
    }
}