<?php namespace Davidle90\Payshare\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PayshareController extends Controller
{
    public function index()
    {
        return view('payshare::pages.public.index', [
        ]);
    }
}