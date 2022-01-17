<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ecard;
use App\EcardCategory;
use App\EcardToCategory;
use App\EcardTemplate;
use App\Http\Requests\EcardTemplateRequest;
use Illuminate\Support\Facades\Storage;

class EcardsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['ecard_categories'] = EcardCategory::options();
        return view('ecards.index', $data);
    }

    public function datasource(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'thumbnail',
            2 => 'caption',
            3 => 'caption',
            4 => 'active',
            5 => 'private',
        );

        $totalData = Ecard::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $ecards = Ecard::where(function ($query) use ($request) {
            if ($request->filename) $query->where('filename', 'LIKE', '%' . $request->filename . '%');
            if ($request->ecard_category_id) {
                $query->whereHas('ecardcategories', function ($query) use ($request) {
                    $query->where('ecard_categories.id', $request->ecard_category_id);
                });
            }
        })->offset($start)->limit($limit)->orderBy($order, $dir)->get();

        $totalFiltered = Ecard::where(function ($query) use ($request) {
            if ($request->filename) $query->where('filename', 'LIKE', '%' . $request->filename . '%');
            if ($request->ecard_category_id) {
                $query->whereHas('ecardcategories', function ($query) use ($request) {
                    $query->where('ecard_categories.id', $request->ecard_category_id);
                });
            }
        })->count();
        //======================

        $data = array();
        if (!empty($ecards)) {
            foreach ($ecards as $ecard) {
                //$show =  route('ecards.show',$ecard->id);
                $edit =  route('ecards.edit', $ecard->id);
                //$delete = route('ecards.destroy',$ecard->id);

                $right = '<i class="fa fa-check text-success"><i/>';
                $wrong = '<i class="fa fa-remove text-danger"><i/>';

                $nestedData['id'] = $ecard->id;

                $nestedData['thumbnail'] = '<img src="' . asset('storage/img/ecards/' . $ecard->filename . '.jpg') . '" width="70"/>';

                $nestedData['filename'] = $ecard->filename;
                $nestedData['caption'] = $ecard->caption;
                $nestedData['active'] = $ecard->active ? $right : $wrong;
                $nestedData['private'] = $ecard->private ? $right : $wrong;
                $nestedData['options'] = "<div class='btn-group'>";
                $nestedData['options'] .= "<a href='{$edit}' title='Edit' class='btn btn-default btn-xs'><i class='fa fa-edit'></i></a>";
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
        $data['ecard_categories'] = EcardCategory::with('children')->whereNull('parent_id')->get();
        return view('ecards.create', $data);
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
            'caption' => 'required',
            'filename' => 'required|unique:ecards',
            'detail' => 'required',
            'greetings' => '',
            'active' => '',
            'private' => '',
            'img_suffix' => '',
            'video' => 'required|numeric',
            'image_small' => 'required|mimes:jpg|max:2000',
            'image_large' => 'required|mimes:jpg|max:4000',
            'ecard_categories' => 'required|array',
        ];

        if ($request->ecard_categories) {
            foreach ($request->ecard_categories as $ecard_category_id) {
                $rules['groups.' . $ecard_category_id] = 'required';
            }
        }

        $request->validate($rules);

        if ($request->hasFile('image_small')) {
            $image_small = $request->file('image_small');
            $ext = $image_small->extension();
            $filename = $request->filename . '.' . $ext;
            $path = 'storage/img/ecards';
            //$photo = Image::make($photo)->resize(300, 300);
            //\Storage::disk('public')->put( $path, $image_small);
            $request->file('image_small')->move($path, $filename);
        }

        if ($request->hasFile('image_large')) {
            $image_large = $request->file('image_large');
            $ext = $image_large->extension();
            if ($request->img_suffix != null) {
                $photo = $request->filename . 'P_' . $request->img_suffix . '.' . $ext;
            } elseif ($request->img_suffix == null) {
                $photo = $request->filename . 'P.' . $ext;
            }
            $path = 'storage/img/ecards';
            //$photo = Image::make($photo)->resize(300, 300);
            //\Storage::disk('public')->put( $path, $image_large);
            $request->file('image_large')->move($path, $photo);
        }

        $ecard_template_id = EcardTemplate::where('default', 1)->first();

        $ecard = new Ecard;
        $ecard->active = $request->active ? 1 : 0;
        $ecard->private = $request->private ? 1 : 0;
        $ecard->filename = $request->filename;
        $ecard->img_suffix = $request->img_suffix;
        $ecard->caption = $request->caption;
        $ecard->detail = $request->detail;
        $ecard->video = $request->video;
        $ecard->template_id = $ecard_template_id->id;
        $ecard->save();

        //prepare categories
        $ecard_categories = array();
        $groups = $request->groups;
        foreach ($request->ecard_categories as $ecard_category_id) {
            $ecard_categories[$ecard_category_id] = ['type' => $groups[$ecard_category_id]];
        }

        //prepare titles
        $greetings = array();
        foreach ($request->greetings as $greeting) {
            if ($greeting)
                $greetings[] = ['title' => $greeting];
        }

        $ecard->ecardcategories()->sync($ecard_categories);
        $ecard->ecardtitles()->createMany($greetings);

        return redirect()->route('ecards.index')->with('success', 'Ecard created!');
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
        $ecard = Ecard::find($id);

        $formdata = $ecard->toArray();
        $formdata['filename'] = explode('.', $ecard['filename'])[0];
        $formdata['photo'] = explode('.', $ecard['thumbnail'])[0];

        $greetings = array();
        foreach ($ecard->ecardtitles as $greeting) {
            $greetings[] = $greeting->title;
        }

        //print_r($formdata); exit();

        $data['greetings'] = $greetings;
        $data['ecard'] = $ecard;
        $data['formdata'] = $formdata;
        $data['ecard_categories'] = EcardCategory::with('children')->whereNull('parent_id')->get();

        if($ecard->template_id == null){
            $default_check = EcardTemplate::where('default', '=', 1)->first();
            $data['ecard_templates']  = EcardTemplate::where('id', '!=', $default_check->id)->get();
            $data['ecard_template_id']  = $default_check;
        }elseif($ecard->template_id != null){
            $data['ecard_templates']  = EcardTemplate::where('id', '!=', $ecard->template_id)->get();
            $data['ecard_template_id']  = EcardTemplate::findOrFail($ecard->template_id);
        }

        return view('ecards.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_template(Request $request, $id)
    {
        $ecard = Ecard::find($id);

        $ecard->template_id = $request->template_id;

        $ecard->save();

        return back()->with('success', 'Ecard Template Updated!');
    }

    public function copy_template(EcardTemplateRequest $request)
    {

        $id = $request->ecard_id;

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

        $ecard = Ecard::find($id);

        $ecard->template_id = $ecard_template->id;

        $ecard->save();

        return back()->with('success', 'Ecard Template Updated!');
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'caption' => 'required',
            'detail' => 'required',
            'greetings' => '',
            'active' => '',
            'private' => '',
            'img_suffix' => '',
            'image_small' => 'mimes:jpg|max:2000',
            'image_large' => 'mimes:jpg|max:4000',
            'video' => 'required',
            'ecard_categories' => 'required|array',
            'template_id' => 'required',
        ];

        $ecard = Ecard::find($id);

        if ($request->ecard_categories) {
            foreach ($request->ecard_categories as $ecard_category_id) {
                $rules['groups.' . $ecard_category_id] = 'required';
            }
        }

        $request->validate($rules);

        if ($request->hasFile('image_small') && $request->hasFile('image_large')) {

            $oldFile1 = 'storage/img/ecards/' . $ecard->filename . '.jpg';
            $newFile1 = 'storage/img/ecards/' . $request->filename . '_OLD.jpg';
            rename($oldFile1, $newFile1);
            if ($request->img_suffix != null && $ecard->img_suffix != null) {
                $oldFile = 'storage/img/ecards/' . $ecard->filename . 'P_' . $ecard->img_suffix . '.jpg';
                $newFile = 'storage/img/ecards/' . $request->filename . 'P_OLD_' . $request->img_suffix . '.jpg';
                rename($oldFile, $newFile);
            } elseif ($request->img_suffix != null && $ecard->img_suffix == null) {
                $oldFile = 'storage/img/ecards/' . $ecard->filename . 'P.jpg';
                $newFile = 'storage/img/ecards/' . $request->filename . 'P_OLD_' . $request->img_suffix . '.jpg';
                rename($oldFile, $newFile);
            } elseif ($request->img_suffix == null && $ecard->img_suffix != null) {
                $oldFile = 'storage/img/ecards/' . $ecard->filename . 'P_' . $ecard->img_suffix . '.jpg';
                $newFile = 'storage/img/ecards/' . $request->filename . 'P_OLD.jpg';
                rename($oldFile, $newFile);
            } elseif ($request->img_suffix == null && $ecard->img_suffix == null) {
                $oldFile = 'storage/img/ecards/' . $ecard->filename . 'P.jpg';
                $newFile = 'storage/img/ecards/' . $request->filename . 'P_OLD.jpg';
                rename($oldFile, $newFile);
            }

            $image_small = $request->file('image_small');
            $ext1 = $image_small->extension();
            $filename = $request->filename . '.' . $ext1;
            $path1 = 'storage/img/ecards';
            $request->file('image_small')->move($path1, $filename);

            $image_large = $request->file('image_large');
            $ext = $image_large->extension();

            if ($request->img_suffix != null) {
                $photo = $request->filename . 'P_' . $request->img_suffix . '.' . $ext;
            } elseif ($request->img_suffix == null) {
                $photo = $request->filename . 'P.' . $ext;
            }

            $path = 'storage/img/ecards';
            $request->file('image_large')->move($path, $photo);
        } else {
            if ($request->filename == $ecard->filename && $request->img_suffix == $ecard->img_suffix) {
                $rules['filename'] = 'required';
            } elseif ($request->filename == $ecard->filename && $request->img_suffix != $ecard->img_suffix) {

                $rules['filename'] = 'required';
                if ($request->img_suffix != null && $ecard->img_suffix != null) {
                    $oldFile = 'storage/img/ecards/' . $ecard->filename . 'P_' . $ecard->img_suffix . '.jpg';
                    $newFile = 'storage/img/ecards/' . $request->filename . 'P_' . $request->img_suffix . '.jpg';
                    rename($oldFile, $newFile);
                } elseif ($request->img_suffix != null && $ecard->img_suffix == null) {
                    $oldFile = 'storage/img/ecards/' . $ecard->filename . 'P.jpg';
                    $newFile = 'storage/img/ecards/' . $request->filename . 'P_' . $request->img_suffix . '.jpg';
                    rename($oldFile, $newFile);
                } elseif ($request->img_suffix == null && $ecard->img_suffix != null) {
                    $oldFile = 'storage/img/ecards/' . $ecard->filename . 'P_' . $ecard->img_suffix . '.jpg';
                    $newFile = 'storage/img/ecards/' . $request->filename . 'P.jpg';
                    rename($oldFile, $newFile);
                } elseif ($request->img_suffix == null && $ecard->img_suffix == null) {
                    $oldFile = 'storage/img/ecards/' . $ecard->filename . 'P.jpg';
                    $newFile = 'storage/img/ecards/' . $request->filename . 'P.jpg';
                    rename($oldFile, $newFile);
                }
            } elseif ($request->filename != $ecard->filename && $request->img_suffix == $ecard->img_suffix) {
                $rules['filename'] = 'required|unique:ecards';
                $oldFile1 = 'storage/img/ecards/' . $ecard->filename . '.jpg';
                $newFile1 = 'storage/img/ecards/' . $request->filename . '.jpg';
                rename($oldFile1, $newFile1);
                if ($request->img_suffix != null && $ecard->img_suffix != null) {
                    $oldFile = 'storage/img/ecards/' . $ecard->filename . 'P_' . $ecard->img_suffix . '.jpg';
                    $newFile = 'storage/img/ecards/' . $request->filename . 'P_' . $request->img_suffix . '.jpg';
                    rename($oldFile, $newFile);
                } elseif ($request->img_suffix != null && $ecard->img_suffix == null) {
                    $oldFile = 'storage/img/ecards/' . $ecard->filename . 'P.jpg';
                    $newFile = 'storage/img/ecards/' . $request->filename . 'P_' . $request->img_suffix . '.jpg';
                    rename($oldFile, $newFile);
                } elseif ($request->img_suffix == null && $ecard->img_suffix != null) {
                    $oldFile = 'storage/img/ecards/' . $ecard->filename . 'P_' . $ecard->img_suffix . '.jpg';
                    $newFile = 'storage/img/ecards/' . $request->filename . 'P.jpg';
                    rename($oldFile, $newFile);
                } elseif ($request->img_suffix == null && $ecard->img_suffix == null) {
                    $oldFile = 'storage/img/ecards/' . $ecard->filename . 'P.jpg';
                    $newFile = 'storage/img/ecards/' . $request->filename . 'P.jpg';
                    rename($oldFile, $newFile);
                }
            } elseif ($request->filename != $ecard->filename && $request->img_suffix != $ecard->img_suffix) {

                $rules['filename'] = 'required|unique:ecards';
                $oldFile1 = 'storage/img/ecards/' . $ecard->filename . '.jpg';
                $newFile1 = 'storage/img/ecards/' . $request->filename . '.jpg';
                rename($oldFile1, $newFile1);
                if ($request->img_suffix != null && $ecard->img_suffix != null) {
                    $oldFile = 'storage/img/ecards/' . $ecard->filename . 'P_' . $ecard->img_suffix . '.jpg';
                    $newFile = 'storage/img/ecards/' . $request->filename . 'P_' . $request->img_suffix . '.jpg';
                    rename($oldFile, $newFile);
                } elseif ($request->img_suffix != null && $ecard->img_suffix == null) {
                    $oldFile = 'storage/img/ecards/' . $ecard->filename . 'P.jpg';
                    $newFile = 'storage/img/ecards/' . $request->filename . 'P_' . $request->img_suffix . '.jpg';
                    rename($oldFile, $newFile);
                } elseif ($request->img_suffix == null && $ecard->img_suffix != null) {
                    $oldFile = 'storage/img/ecards/' . $ecard->filename . 'P_' . $ecard->img_suffix . '.jpg';
                    $newFile = 'storage/img/ecards/' . $request->filename . 'P.jpg';
                    rename($oldFile, $newFile);
                } elseif ($request->img_suffix == null && $ecard->img_suffix == null) {
                    $oldFile = 'storage/img/ecards/' . $ecard->filename . 'P.jpg';
                    $newFile = 'storage/img/ecards/' . $request->filename . 'P.jpg';
                    rename($oldFile, $newFile);
                }
            }
        }

        $ecard->active = $request->active ? 1 : 0;
        $ecard->private = $request->private ? 1 : 0;

        $ecard->filename = $request->filename;

        $ecard->img_suffix = $request->img_suffix;
        $ecard->caption = $request->caption;
        $ecard->detail = $request->detail;
        $ecard->video = $request->video;
        $ecard->template_id = $ecard->template_id;
        $ecard->save();

        //prepare categories
        $ecard_categories = array();
        $groups = $request->groups;
        foreach ($request->ecard_categories as $ecard_category_id) {
            $ecard_categories[$ecard_category_id] = ['type' => $groups[$ecard_category_id]];
        }

        //prepare titles
        $greetings = array();
        foreach ($request->greetings as $greeting) {
            if ($greeting)
                $greetings[] = ['title' => $greeting];
        }

        $ecard->ecardcategories()->sync($ecard_categories);

        $ecard->ecardtitles()->delete();
        $ecard->ecardtitles()->createMany($greetings);

        return back()->with('success', 'Ecard updated!');
    }

    public function autoupdate(Request $request, $id)
    {
        $rules = [
            'caption' => 'required',
            'filename' => 'required',
            'detail' => 'required',
            'greetings' => '',
            'active' => '',
            'private' => '',
            'popular_card' => '',
            'recommended_card' => '',
            'img_suffix' => 'required',
            'video' => 'required',
            'image_small' => 'image|max:2000',
            'image_large' => 'image|max:4000',
            'ecard_categories' => 'array',
        ];

        if ($request->ecard_categories) {
            foreach ($request->ecard_categories as $ecard_category_id) {
                $rules['groups.' . $ecard_category_id] = 'required';
            }
        }

        $request->validate($rules);

        if ($request->hasFile('image_small')) {
            $image_small = $request->file('image_small');
            $ext = $image_small->extension();
            $filename = $request->filename . '.' . $ext;
            $path = 'storage/img/ecards';
            //$photo = Image::make($photo)->resize(300, 300);
            //\Storage::disk('public')->put( $path, $image_small);
            $request->file('image_small')->move($path, $filename);
        }

        if ($request->hasFile('image_large')) {
            $image_large = $request->file('image_large');
            $ext = $image_large->extension();
            if ($request->img_suffix != null) {
                $photo = $request->filename . 'P_' . $request->img_suffix . '.' . $ext;
            } elseif ($request->img_suffix == null) {
                $photo = $request->filename . 'P.' . $ext;
            }
            $path = 'storage/img/ecards';
            //$photo = Image::make($photo)->resize(300, 300);
            //\Storage::disk('public')->put( $path, $image_large);
            $request->file('image_large')->move($path, $photo);
        }

        $ecard = Ecard::find($id);

        $ecard->active = $request->active ? 1 : 0;
        $ecard->private = $request->private ? 1 : 0;
        $ecard->popular_card = $request->popular_card ? 1 : 0;
        $ecard->recommended_card = $request->recommended_card ? 1 : 0;

        if (isset($filename)) $ecard->filename = $filename;
        if (isset($photo)) $ecard->thumbnail = $photo;

        $ecard->caption = $request->caption;
        $ecard->detail = $request->detail;
        $ecard->video = $request->video;
        $ecard->save();

        //prepare categories
        $ecard_categories = array();
        $groups = $request->groups;
        foreach ($request->ecard_categories as $ecard_category_id) {
            $ecard_categories[$ecard_category_id] = ['type' => $groups[$ecard_category_id]];
        }

        //prepare titles
        $greetings = array();
        foreach ($request->greetings as $greeting) {
            if ($greeting)
                $greetings[] = ['title' => $greeting];
        }

        $ecard->ecardcategories()->sync($ecard_categories);

        $ecard->ecardtitles()->delete();
        $ecard->ecardtitles()->createMany($greetings);
        return $ecard;
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

    public function popular_status_update($id, $popular_status)
    {
        //
    }

    public function sort(Request $request)
    {

        if ($request->ecard_category_id) {
            $data['group_one_ecards'] = EcardToCategory::where('ecard_category_id', $request->ecard_category_id)
                ->where('type', 1)
                ->orderByRaw('-sort DESC')
                ->get();

            $data['group_two_ecards'] = EcardToCategory::where('ecard_category_id', $request->ecard_category_id)
                ->where('type', 2)
                ->orderByRaw('-sort DESC')
                ->get();

            $dataEcards = EcardToCategory::where('ecard_category_id', $request->ecard_category_id)
                ->get();

            $ids = [];

            foreach ($dataEcards as $dataEcard) {
                $ids[] = $dataEcard->ecard_id;
            }

            $data['ungroup_ecards'] = Ecard::whereNotIn('id', $ids)->get();
        }
        $data['ecard_category'] = $request->ecard_category_id;
        $data['ecard_categories'] = EcardCategory::options();
        return view('ecards.sort', $data);
    }

    public function sort_store(Request $request)
    {
        if ($request->group1) {
            $group1 = [];
            parse_str($request->group1, $group1);
            $group1 = $group1['etc'];

            $count = 1;
            foreach ($group1 as $ecard_to_category_id) {
                $ecard_to_category = EcardToCategory::find($ecard_to_category_id);
                $ecard_to_category->type = 1;
                $ecard_to_category->sort = $count;
                $ecard_to_category->save();
                $count++;
            }
        }

        if ($request->group2) {
            $group2 = [];
            parse_str($request->group2, $group2);
            $group2 = $group2['etc'];

            $count = 1;
            foreach ($group2 as $ecard_to_category_id) {
                $ecard_to_category = EcardToCategory::find($ecard_to_category_id);
                $ecard_to_category->type = 2;
                $ecard_to_category->sort = $count;
                $ecard_to_category->save();
                $count++;
            }
        }

        return true;
    }

    public function sort_store_multiple(Request $request)
    {

        $ecard_ids = $request->ecard_ids;
        $ecard_category_id = $request->ecard_category_id;
        $ecard_categories = array();
        $groups = $request->groups;

        foreach ($ecard_ids as $ecard_id) {

            $ecard = Ecard::find($ecard_id);

            $ecard_categories[$ecard_category_id] = ['ecard_id' => $ecard_id, 'type' => $groups[$ecard_category_id]];

            $ecard->ecardcategories()->sync($ecard_categories);
        }

        return back();
    }

    public function sort_delete($id)
    {

        EcardToCategory::whereId($id)->delete();

        return back();
    }

    public function sort_delete_multiple(Request $request)
    {

        $rules = [
            'ids' => 'required|array'
        ];

        $request->validate($rules);

        foreach ($request->ids as $id) {
            EcardToCategory::destroy($id);
        }

        $data['ecard_categories'] = EcardCategory::options();

        return back();
    }
}
