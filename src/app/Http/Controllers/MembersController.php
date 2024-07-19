<?php namespace Davidle90\Payshare\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Davidle90\Payshare\app\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class MembersController extends Controller
{   
    public function create($group_id)
    {
        return view('payshare::pages.public.members.edit', [
            'group_id' => $group_id
        ]);
    }

    public function edit($group_id, $member_id)
    {
        $member = Member::find($member_id);
        return view('payshare::pages.public.members.edit', [
            'group_id' => $group_id,
            'member' => $member
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $input = [
            'id' => $request->input('id'),
            'group_id' => $request->input('group_id'),
            'name' => $request->input('name')
        ];

        DB::beginTransaction();

        try {
            
            $member = Member::firstOrNew(['id' => $input['id']]);
            $member->name = $input['name'];
            $member->group_id = $input['group_id'];
            $member->save();

            DB::commit();

            $response = [
                'status' => 1,
                'message' => 'Member has been saved.',
                'redirect' => route('payshare.groups.view', ['id' => $member->group_id])
            ];

        } catch(Exception $e) {

            DB::rollBack();

            $response = [
                'status' => 0,
                'message' => 'Something went wrong while saving member.'
            ];
        }

        return response()->json($response);
    }

    public function delete($id)
    {
        
    }
}