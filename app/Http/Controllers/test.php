<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 11.01.2016
 * Time: 11:43
 */

namespace App\Http\Controllers;

class Test extends Controller
{
    public function index(){
        echo file_get_contents('http://em100.edaptivedocs.com/GetDoc.aspx?doc=CLSI%20M100%20S26:2016&scope=user');
    }
}
