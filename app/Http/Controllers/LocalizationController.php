<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocalizationController extends Controller
{
    public function index(Request $request)
    {
        return __('minicrm', [], $request->lang);
    }
}
