<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function index()
    {
        dd("This is the index method of the Controller class.");
    }
}
