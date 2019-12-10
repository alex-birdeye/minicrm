<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LocalizationController extends Controller
{
    public function index(Request $request)
    {
        return __('minicrm', [], $request->lang);
    }

    public function setLocale($locale)
    {
        App::setLocale($locale);
        //store the locale in session so that the middleware can register it
        session()->put('locale', $locale);

//        dd($locale, session()->get('locale'), App::getLocale());
    }

    public function getLocale()
    {
        return App::getLocale();
    }
}
