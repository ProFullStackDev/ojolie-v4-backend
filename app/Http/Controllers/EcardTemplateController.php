<?php

namespace App\Http\Controllers;

use App\EcardTemplate;

use App\Ecard;

use Illuminate\Http\Request;

use App\Http\Requests\EcardTemplateRequest;

use App\Http\Requests\EcardTemplateDefaultRequest;

class EcardTemplateController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $card_templates = EcardTemplate::all();

        return

            view('ecard-template.index', compact('card_templates'));
    }

    public function create()
    {
        $ecards = Ecard::all();

        return view('ecard-template.create', compact('ecards'));
    }

    public function add(EcardTemplateRequest $request)
    {
        $input = $request->all();

        $ecard_template = EcardTemplate::create($input);

        if ($request->default == 0) {

            $default_template = EcardTemplate::find($ecard_template->id);

            $default_template->default = "no_" . $ecard_template->id;

            $default_template->save();

        } elseif ($request->default == 11) {

            $default_check = EcardTemplate::where('default', '=', 1)->count();

            if($default_check == 1){
                $default_remove = EcardTemplate::where('default', '=', 1)->first();
                $default_remove->default = "no_" . $default_remove->id;
                $default_remove->save();

                $default_template = EcardTemplate::find($ecard_template->id);
                $default_template->default = 1;
                $default_template->save();
            } else {
                $default_template = EcardTemplate::find($ecard_template->id);
                $default_template->default = 1;
                $default_template->save();
            }

        }

        if ($request->ecard_id) {

            $ecard = Ecard::find($request->ecard_id);

            $ecard->template_id = $ecard_template->id;

            $ecard->save();
        }

        return redirect('/ecard-template/create')->with('success', 'your template was created successfully.');
    }

    public function edit($id)
    {
        //
        $card_template = EcardTemplate::findOrFail($id);
        if($card_template->ecard_id == null) {
            $ecards = Ecard::all();
        } else {
            $ecards = Ecard::where('id', '!=', $card_template->ecard_id)->get();
        }

        $ecard_detail = Ecard::find($card_template->ecard_id);
        return view('ecard-template.edit', compact('card_template', 'ecards', 'ecard_detail'));
    }

    public function get_card_info($id)
    {
        //
        $ecard_info = Ecard::find($id);
        return response([
        'video' => $ecard_info->video,
        'status' => 'success']);
    }

    public function get_template_info($id)
    {
        //
        $template_info = EcardTemplate::find($id);
        return response([
        'template_name' => $template_info->template_name,
        'template_title' => $template_info->template_title,
        'template_content' => $template_info->template_content,
        'mb_template_title' => $template_info->mb_template_title,
        'mb_template_content' => $template_info->mb_template_content,
        'status' => 'success']);
    }

    public function update(Request $request)
    {
        //
        $id = $request->id;
        $template = EcardTemplate::find($id);
        $template->template_name = $request->template_name;
        $template->template_title = $request->template_title;
        $template->template_content = $request->template_content;
        $template->mb_template_title = $request->mb_template_title;
        $template->mb_template_content = $request->mb_template_content;

        $template->ecard_id = $request->ecard_id;

        if ($request->default == 0) {

            $template->default = "no_" . $id;

        } elseif ($request->default == 1) {

            $default_check = EcardTemplate::where('default', '=', 1)->count();

            if($default_check == 1){
                $default_remove = EcardTemplate::where('default', '=', 1)->first();
                $default_remove->default = "no_" . $default_remove->id;
                $default_remove->save();
                $template->default = $request->default;
            } else {
                $template->default = $request->default;
            }

        } elseif ($request->default == 11) {

            $template->default = 0;

        }

        $template->save();

        if ($request->default == 11) {

        $template_default =  EcardTemplate::find($id);

        $template_default->default = 1;

        $template_default->save();

        }

        if ($request->ecard_id) {
            $ecard = Ecard::find($request->ecard_id);

            $ecard->template_id = $id;

            $ecard->save();
        }

        return response([
            'template_id' => $template->id,
            'status' => 'success']);
    }

    public function update_assigned(Request $request)
    {
        //
        $id = $request->id;
        $template = EcardTemplate::find($id);
        $template->template_title = $request->template_title;
        $template->template_content = $request->template_content;
        $template->mb_template_title = $request->mb_template_title;
        $template->mb_template_content = $request->mb_template_content;

        $template->save();

        if ($request->ecard_id) {
            $ecard = Ecard::find($request->ecard_id);

            $ecard->template_id = $request->id;

            $ecard->save();
        }

        return back()->with('success', 'your template was updated successfully.');
    }

    public function destroy($id)
    {
        $ecards_count = Ecard::where('template_id', $id)->count();
        $ecards = Ecard::where('template_id', $id)->get();
        if($ecards_count > 0) {

            foreach($ecards as $ecard) {
                $ecard_id[] = "$ecard->id";
            }

            $id_value = implode(" , ", $ecard_id);
            return back()->with('error', 'Delete failed. The following cards are using the template: cards ID - '.$id_value);
        } elseif($ecards_count < 1) {
            EcardTemplate::whereId($id)->delete();
            return back()->with('success', 'your template was successfully deleted.');
        }

    }
}
