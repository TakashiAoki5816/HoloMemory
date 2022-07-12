<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class MainController extends Controller
{
    /**
     * トップページを表示
     *
     * @return View
     */
    public function main(): View
    {
        return view('app');
    }
}
