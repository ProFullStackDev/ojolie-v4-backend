<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Configuration;
use App\Price;

class SettingsController extends Controller
{
    public function index(Request $request)
    {
        $data = [];
        if($request->type == 'email')
        {
            $data['email_configs'] = Configuration::where('type','email')->get();
        }
        elseif($request->type == 'contact')
        {
            $data['contact_us_configs'] = Configuration::where('type','contact_us')->get();
        }
        elseif($request->type == 'prices')
        {
            $data['prices'] = Price::all();
        }
        else
        {
            return redirect()->route('settings.index',['type'=>'email']);
        }
        return view('settings.index',$data);
    }

    public function store(Request $request)
    {
        if($request->type == 'email')
        {
            $rules = [
                'configurations.driver' => 'required',
                'configurations.host' => 'required',
                'configurations.port' => 'required',
                'configurations.username' => 'required',
                'configurations.password' => 'required',
                'configurations.encryption' => 'required',
                'configurations.from_address' => 'required',
                'configurations.from_name' => 'required',
            ];

            $request->validate($rules);

            foreach($request->configurations as $key => $value)
            {
                $configuration = Configuration::where('key',$key)->first();
                $configuration->value = $value;
                $configuration->save();
            }

            return redirect()->back()->with('success','Email settings updated!');
        }

        if($request->type == 'contact')
        {
            $rules = [
                'configurations.contact_us_email' => 'required'
            ];

            $request->validate($rules);

            foreach($request->configurations as $key => $value)
            {
                $configuration = Configuration::where('key',$key)->first();
                $configuration->value = $value;
                $configuration->save();
            }

            return redirect()->back()->with('success','Contact Us Email settings updated!');
        }

        if($request->type == 'prices')
        {
            $rules = [
                'configurations.*' => 'required|numeric'
            ];

            $request->validate($rules);

            foreach($request->configurations as $key => $value)
            {
                $price = Price::find($key);
                $price->amount = $value;
                $price->save();
            }

            return redirect()->back()->with('success','Contact Us Email settings updated!');
        }
    }
}
