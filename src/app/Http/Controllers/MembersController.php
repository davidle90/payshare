<?php namespace Davidle90\Payshare\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MembersController extends Controller
{
    public function index()
    {
    }

    public function view($id)
    {
        
    }
    
    public function create()
    {
        return view('payshare::pages.public.members.edit', [
        ]);
    }

    public function edit($id)
    {
        
    }

    public function store(Request $request)
    {
        
    }

    public function delete($id)
    {
        
    }
}