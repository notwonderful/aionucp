<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function __invoke(): View
    {
        return view('pages.admin.index');
    }
}
