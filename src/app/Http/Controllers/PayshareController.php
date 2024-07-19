<?php namespace Davidle90\Payshare\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Davidle90\Payshare\app\Models\Group;

class PayshareController extends Controller
{
    public function index()
    {
        $groups = Group::get();

        return view('payshare::pages.public.index', [
            'groups' => $groups
        ]);
    }
}