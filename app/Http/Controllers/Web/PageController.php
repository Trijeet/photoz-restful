<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        return view('pages.about');
    }
    public function unauth()
    {
        return view('pages.unauth');
    }
    public function error()
    {
        return view('pages.error');
    }
    public function success()
    {
        return view('pages.success');
    }
}
