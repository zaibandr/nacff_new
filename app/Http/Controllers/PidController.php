<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 11.03.2016
 * Time: 13:12
 */

namespace App\Http\Controllers;

use App\Http\Controllers\DBController;
use Illuminate\Support\Facades\View;


class PidController extends DBController
{
    public function index($id)
    {
        return View::make('patient')->with([
            'patient' => $this->getPatientInfo($id),
            'id' => $id
        ]);
    }
}