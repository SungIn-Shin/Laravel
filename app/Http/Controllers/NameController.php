<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NameController extends Controller
{
    public function showName($name)
    {
        return view('yourname', ['name' => $name]);
    }
}
