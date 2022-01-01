<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function testFunction1(Request $request)
    {
        return 'testFunction1 called';
    }
}
