<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class MainController extends Controller
{
    /**
     * viewを表示
     *
     * @return View
     */
    public function main(): View
    {
        return view('app');
    }
}
