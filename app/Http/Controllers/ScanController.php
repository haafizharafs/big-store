<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ScanController extends Controller
{
    public function index()
    {
        return view('pages.gudang.scan');
    }
}
