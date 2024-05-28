<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Request;

class AppController
{
    public function app(Request $request): View
    {
        return view('app');
    }
}
