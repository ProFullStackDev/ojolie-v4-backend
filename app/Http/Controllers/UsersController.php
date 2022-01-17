<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Libs\Helper;
use App\Reference;
use App\Member;
use App\SubscriptionType;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $data['users_active_options'] = Reference::usersActiveOptions();
        $data['members_type_options'] = Reference::membersTypeOptions();
        $data['members_subscription_type_options'] = SubscriptionType::options();
        $data['users'] = User::where('email','!=','admin@gmail.com')->orderBy('id', 'desc')->get();
        return view('users.index', $data);
    }

    public function datasource(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'email',
            3 => 'active'
        );

        $totalData = User::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $users = User::where(function ($query) use ($request) {
            if ($request->user_id)
                $query->where('id', $request->user_id);
            if ($request->name)
                $query->where('first_name', 'LIKE', '%' . $request->name . '%')->orWhere('last_name', 'LIKE', '%' . $request->name . '%');
            if ($request->email)
                $query->where('email', $request->email);
            if ($request->active)
                $query->where('active', $request->active);
        })->whereHas('member', function ($query) use ($request) {
            if ($request->type)
                $query->where('type', $request->type);
        })->offset($start)->limit($limit)->orderBy($order, $dir)->get();

        $totalFiltered = User::where(function ($query) use ($request) {
            if ($request->user_id)
                $query->where('id', $request->user_id);
            if ($request->name)
                $query->where('first_name', 'LIKE', '%' . $request->name . '%')->orWhere('last_name', 'LIKE', '%' . $request->name . '%');
            if ($request->email)
                $query->where('email', $request->email);
            if ($request->active)
                $query->where('active', $request->active);
        })->whereHas('member', function ($query) use ($request) {
            if ($request->type)
                $query->where('type', $request->type);
        })->count();

        if ($request->user_id) {
        } elseif ($request->name) {
        }

        //======================

        $data = array();
        if (!empty($users)) {
            foreach ($users as $user) {
                $show =  route('users.show', $user->id);
                $edit =  route('users.edit', $user->id);
                $delete = route('users.destroy', $user->id);

                $nestedData['id'] = $user->id;
                $nestedData['name'] = $user->getFullName();
                $nestedData['email'] = $user->email;
                $nestedData['active'] = optional($user->activereference)->name;

                $nestedData['options'] = "<div class='btn-group'>";
                //$nestedData['options'] .= "<a href='{$show}' title='Show' class='btn btn-default btn-xs'><i class='fa fa-info-circle'></i></a>";
                $nestedData['options'] .= "<a href='{$edit}' title='Edit' class='btn btn-default btn-xs'><i class='fa fa-edit'></i></a>";
                //$nestedData['options'] .= "<a href='{$delete}' title='Delete' class='btn btn-danger btn-xs delete'><i class='fa fa-trash'></i></a>";
                $nestedData['options'] .= "</div>";

                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        return json_encode($json_data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $data['timezones'] = Helper::timezoneOptions();
        $data['users_active_options'] = Reference::usersActiveOptions();
        $data['members_type_options'] = Reference::membersTypeOptions();

        return view('users.create', $data);
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
            'first_name' => 'required|max:30',
            'last_name' => 'required|max:30',
            'email' => 'required|email|max:100|unique:users',
            'password' => 'required|min:6',
            'active' => 'required',
            'timezone' => '',
            'type' => 'required',
            'notify_pickup' => '',
            'notify_sent' => '',
            'notify_reply' => '',
            'newsletter_subscribed' => '',
        ];

        $request->validate($rules);

        $user = new User;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->active = $request->active;
        $user->save();

        $member = new Member;
        $member->user_id = $user->id;
        $member->type = $request->type;
        $member->timezone = $request->timezone;
        $member->notify_pickup = $request->notify_pickup ? 1 : 0;
        $member->notify_sent = $request->notify_sent ? 1 : 0;
        $member->notify_reply = $request->notify_reply ? 1 : 0;
        $member->newsletter_subscribed = $request->newsletter_subscribed ? 1 : 0;
        $member->save();

        return redirect()->route('users.index')->with('success', 'User created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $member = $user->member;

        $data['user'] = $user;
        $data['member'] = $member;

        $data['timezones'] = Helper::timezoneOptions();
        $data['users_active_options'] = Reference::usersActiveOptions();
        $data['members_type_options'] = Reference::membersTypeOptions();
        return view('users.edit', $data);
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
        $rules = [
            'first_name' => 'required|max:30',
            'last_name' => 'required|max:30',
            'email' => 'required|email|max:100|unique:users,email,' . $id,
            'password' => 'nullable|min:6',
            'active' => 'required',
            'timezone' => '',
            'type' => 'required',
            'notify_pickup' => '',
            'notify_sent' => '',
            'notify_reply' => '',
            'newsletter_subscribed' => '',
        ];

        $request->validate($rules);

        $user = User::find($id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;

        if ($request->password)
            $user->password = bcrypt($request->password);

        $user->active = $request->active;
        $user->save();

        $member = $user->member;
        $member->user_id = $user->id;
        $member->type = $request->type;
        $member->timezone = $request->timezone;
        $member->notify_pickup = $request->notify_pickup ? 1 : 0;
        $member->notify_sent = $request->notify_sent ? 1 : 0;
        $member->notify_reply = $request->notify_reply ? 1 : 0;
        $member->newsletter_subscribed = $request->newsletter_subscribed ? 1 : 0;
        $member->save();

        return redirect()->route('users.index')->with('success', 'User updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
