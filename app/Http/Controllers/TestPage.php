<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestPage extends Controller
{
    public function getTest(){
        return 'It works';
    }
}
