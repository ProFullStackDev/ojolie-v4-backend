<?php

namespace App\Http\Controllers;

use App\NewsletterSubscription;

use App\Http\Requests\NewsletterSubscriptionRequest;

use Illuminate\Http\Request;

class NewsletterSubscriptionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $mailing_lists = NewsletterSubscription::all();

        return

            view('newsletter-subscription.index', compact('mailing_lists'));
    }



    public function create()
    {
        return view('newsletter-subscription.create');

    }

    public function add(NewsletterSubscriptionRequest $request)
    {
        NewsletterSubscription::create($request->all());

        return redirect('/newsletter-subscription/create')->with('success', 'Your email was sent successfully.');
    }

    public function edit($id)
    {
        //
        $mailing_list = NewsletterSubscription::findOrFail($id);
        return view('newsletter-subscription.edit', compact('mailing_list'));
    }

    // public function update(Request $request, $id)
    // {
    //     //
    //     $subscriber_status = NewsletterSubscription::find($id);

    //     $subscriber_status->blacklist = $request->blacklist ? 1 : 0;

    //     $subscriber_status->save();

    //     return back()->with('success', 'Subscriber status was updated successfully.');
    // }

    public function destroy($id)
    {
        NewsletterSubscription::whereId($id)->delete();

        return redirect('/newsletter-subscription');

    }
}
