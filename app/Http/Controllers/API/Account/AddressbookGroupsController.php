<?php

namespace App\Http\Controllers\API\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\AddressbookGroup;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\AddressbookGroupResource;

class AddressbookGroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return AddressbookGroupResource::collection(AddressbookGroup::userScope()->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = ['name'=>'required'];

        $request->validate($rules);

        $group = new AddressbookGroup;
        $group->user_id = auth()->user()->id;
        $group->name = $request->name;
        $group->save();

        $message = 'success';

        return response([
            'data' => [
                'code' => '000',
                'response' => new AddressbookGroupResource($group),
                'message' => $message
            ],
        ], Response::HTTP_CREATED);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new AddressbookGroupResource(AddressbookGroup::with('addressbooks')->find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = ['name'=>'required'];

        $request->validate($rules);

        $group = AddressbookGroup::find($id);
        $group->name = $request->name;
        $group->save();

        $message = 'success';

        return response([
            'data' => [
                'code' => '000',
                'response' => new AddressbookGroupResource($group),
                'message' => $message
            ],
        ], Response::HTTP_CREATED);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try
        {
            AddressbookGroup::find($id)->delete();
        }
        catch (\Illuminate\Database\QueryException $e)
        {
            return response()->json($e->errorInfo[2],500);
        }
        return response()->json(null,204);
    }
}
