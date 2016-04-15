<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 12.02.2016
 * Time: 13:20
 */

namespace App\Http\Controllers;
use App\Http\Controllers\DBController;

class DeleteController extends DBController
{
    public function index($id)
    {
        $res = $this->queryDB("update folders set apprsts='R' where folderno='$id'");
        return redirect()->route('main');
    }
}