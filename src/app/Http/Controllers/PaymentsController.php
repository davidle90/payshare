<?php namespace Davidle90\Payshare\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    public function create($group_id)
    {
        return view('payshare::pages.public.payments.edit', [
        ]);
    }

    public function edit($group_id, $payment_id)
    {
        return view('payshare::pages.public.payments.edit', [
        ]);
    }

    public function store(Request $request)
    {
        
    }

    public function delete($id)
    {
        
    }
}