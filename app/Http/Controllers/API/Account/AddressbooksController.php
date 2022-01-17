<?php

namespace App\Http\Controllers\API\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Addressbook;
use App\Http\Resources\AddressbookResource;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class AddressbooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $addressbooks = Addressbook::userScope()->where(function ($query) use ($request) {
            if ($request->search) {
                $query->where(function ($query) use ($request) {
                    $query->where('fname', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('lname', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('email', 'LIKE', '%' . $request->search . '%');
                });
            }

            if ($request->addressbook_group_id) {
                $query->whereHas('addressbookgroups', function ($query) use ($request) {
                    $query->where('addressbook_groups.id', $request->addressbook_group_id);
                });
            }
        })->paginate(10);

        return AddressbookResource::collection($addressbooks);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'fname' => 'required',
            'email' =>  [
                'required',
                'email',
                Rule::unique('addressbooks')->where('user_id', auth()->user()->id)
            ]
        ];

        $request->validate($rules);

        $addressbook = new Addressbook;
        $addressbook->user_id = auth()->user()->id;
        $addressbook->fname = $request->fname;
        $addressbook->email = $request->email;
        $addressbook->save();

        if ($request->addressbook_group_ids && is_array($request->addressbook_group_ids))
            $addressbook->addressbookgroups()->sync($request->addressbook_group_ids);

        $message = 'success';

        return response([
            'data' => [
                'code' => '000',
                'response' => new AddressbookResource($addressbook),
                'message' => $message
            ],
        ], Response::HTTP_CREATED);
    }

    public function contact_store(Request $request)
    {
        $rules = [
            'contact_data' => 'required',
        ];

        $request->validate($rules);

        $address = $request->contact_data;

        foreach ($address as $value) {
            $content = explode(",", $value);
            $contact_name = $content[0];
            $contact_email = $content[1];

            $checkEmail = Addressbook::where('user_id', auth()->user()->id)->where('email', $contact_email)->first();
            if($checkEmail){
                return response([
                    'data' => [
                        'code' => '422',
                        'message' => "$checkEmail->email is already in your addressbook."
                    ],
                ], 422);
            }else{
                $addressbook = new Addressbook;
                $addressbook->user_id = auth()->user()->id;
                $addressbook->fname = $contact_name;
                $addressbook->email = $contact_email;
                $addressbook->save();

                $message = 'success';
            }
        }

        return response([
            'data' => [
                'code' => '000',
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
        return new AddressbookResource(Addressbook::find($id));
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
        $addressbook = Addressbook::find($id);
        $rules = [
            'fname' => 'required',
            'email' =>  [
                'required',
                'email',
                Rule::unique('addressbooks')->where('user_id', auth()->user()->id)->ignore($addressbook)
            ]
        ];

        $request->validate($rules);

        $addressbook->fname = $request->fname;
        $addressbook->email = $request->email;
        $addressbook->save();

        $message = 'success';

        return response([
            'data' => [
                'code' => '000',
                'response' => new AddressbookResource($addressbook),
                'message' => $message
            ],
        ], Response::HTTP_CREATED);
    }

    /**
     * Update the specified resources in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  str  $type
     * @return \Illuminate\Http\Response
     */

    public function group(Request $request, $type)
    {
        $rules = [
            'addressbook_id' => 'required|numeric',
            'addressbook_group_id' => 'required|numeric'
        ];

        $request->validate($rules);

        $addressbook = Addressbook::find($request->addressbook_id);

        if ($type == 'attach') {
            $addressbook->addressbookgroups()->attach($request->addressbook_group_id);
        } else {
            $addressbook->addressbookgroups()->detach($request->addressbook_group_id);
        }

        $message = 'success';

        return response([
            'data' => [
                'code' => '000',
                'response' => new AddressbookResource($addressbook),
                'message' => $message
            ],
        ], Response::HTTP_CREATED);
    }

    public function group_multiple(Request $request, $type)
    {
        $rules = [
            'addressbook_id' => 'required|array',
            'addressbook_group_id' => 'required|numeric'
        ];

        $request->validate($rules);

        $addressbook_ids = $request->addressbook_id;

        foreach ($addressbook_ids as $addressbook_id) {

            $addressbook = Addressbook::find($addressbook_id);

            if ($type == 'attach') {
                $addressbook->addressbookgroups()->attach($request->addressbook_group_id);
            } else {
                $addressbook->addressbookgroups()->detach($request->addressbook_group_id);
            }
        }

        $message = 'success';

        return response([
            'data' => [
                'code' => '000',
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
        Addressbook::whereId($id)->delete();
        return response()->json(['code' => 204, 'message' => "Address Deleted successfully."]);
    }

    public function destroy_multiple(Request $request)
    {
        foreach ($request->ids as $id) {
            Addressbook::destroy($id);
        }

        return response()->json(['code' => 204, 'message' => "Address Deleted successfully."]);
    }
}
