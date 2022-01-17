<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EcardCategory;
use Illuminate\Support\Str;

class EcardCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['ecard_categories'] = EcardCategory::options(true);
        return view('ecardcategories.index', $data);
    }

    public function datasource(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'parent_id',
            2 => 'name',
            3 => 'header_description',
            4 => 'date'
        );

        $totalData = EcardCategory::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $ecardcategories = EcardCategory::whereNotNull('parent_id')->where(function ($query) use ($request) {
            if ($request->name)
                $query->where('name', 'LIKE', '%' . $request->name . '%');
            if ($request->ecard_category_id)
                $query->where('parent_id', $request->ecard_category_id);
        })->offset($start)->limit($limit)->orderBy($order, $dir)->get();

        $totalFiltered = EcardCategory::whereNotNull('parent_id')->where(function ($query) use ($request) {
            if ($request->name)
                $query->where('name', 'LIKE', '%' . $request->name . '%');
            if ($request->ecard_category_id)
                $query->where('parent_id', $request->ecard_category_id);
        })->count();
        //======================

        $data = array();
        if (!empty($ecardcategories)) {
            foreach ($ecardcategories as $ecardcategory) {
                //$show =  route('ecardcategories.show',$ecardcategory->id);
                $edit =  route('ecardcategories.edit', $ecardcategory->id);
                $delete = route('ecardcategories.destroy', $ecardcategory->id);

                //HOLIDAYS date column.
                if ($ecardcategory->parent_id == 1) {
                    $date = '<a href="' . route('ecardcategories.setdate', $ecardcategory->id) . '" title="Set Date"><i class="fa fa-pencil"></i></a> ';

                    if (is_null($ecardcategory->date)) {
                        $date .= 'Not set';
                    } else {
                        $date .= $ecardcategory->date;
                    }
                } else {
                    $date = 'N/A';
                }

                $nestedData['id'] = $ecardcategory->id;
                $nestedData['parent_id'] = $ecardcategory->parent->name;
                $nestedData['name'] = $ecardcategory->name;
                $nestedData['header_description'] = $ecardcategory->header_descripion;
                $nestedData['date'] = $date;

                $nestedData['options'] = "<div class='btn-group'>";
                $nestedData['options'] .= "<a href='{$edit}' title='Edit' class='btn btn-default btn-xs'><i class='fa fa-edit'></i></a>";
                $nestedData['options'] .= "<a href='{$delete}' title='Delete' class='btn btn-danger btn-xs delete'><i class='fa fa-trash'></i></a>";
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
        $data['ecard_categories'] = EcardCategory::options(true);
        return view('ecardcategories.create', $data);
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
            'parent_id' => '',
            'name' => 'required',
            'slug' => 'required|unique:ecard_categories',
            'header_image' => 'image',
            'header_color' => 'required',
            'header_descripion' => 'required',
            'page_title' => 'required',
            'page_description' => 'required',
            'meta_keyword' => 'required',
        ];

        $request->validate($rules);

        $ecardcategory = new EcardCategory;
        $ecardcategory->parent_id = $request->parent_id;
        $ecardcategory->name = $request->name;
        $ecardcategory->slug = Str::of($request->slug)->slug('-');
        $ecardcategory->header_color = $request->header_color;
        $ecardcategory->header_descripion = $request->header_descripion;
        $ecardcategory->page_title = $request->page_title;
        $ecardcategory->page_description = $request->page_description;
        $ecardcategory->meta_keyword = $request->meta_keyword;
        $ecardcategory->save();

        if ($request->hasFile('header_image')) {
            $header_image = $request->file('header_image');
            $ext = $header_image->extension();
            $imagename = Str::of($request->name)->slug('_') . '_header' .time(). '.' . $ext;
            $path = 'storage/img/headers';
            $request->file('header_image')->move($path, $imagename);

            $ecardcategory->header_image = $imagename;
            $ecardcategory->save();
        }

        return redirect()->route('ecardcategories.index')->with('success', 'Ecard Category created!');
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
        $data['ecardcategory'] = EcardCategory::find($id);
        $data['ecard_categories'] = EcardCategory::options(true);
        return view('ecardcategories.edit', $data);
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
            'parent_id' => 'required',
            'name' => 'required',
            'slug' => 'required|unique:ecard_categories,slug,' . $id,
            'header_image' => 'image',
            'header_color' => 'required',
            'header_descripion' => 'required',
            'page_title' => 'required',
            'page_description' => 'required',
            'meta_keyword' => 'required',
        ];

        $request->validate($rules);

        $ecardcategory = EcardCategory::find($id);
        $ecardcategory->parent_id = $request->parent_id;
        $ecardcategory->name = $request->name;
        $ecardcategory->slug = Str::of($request->slug)->slug('-');
        $ecardcategory->header_color = $request->header_color;
        $ecardcategory->header_descripion = $request->header_descripion;
        $ecardcategory->page_title = $request->page_title;
        $ecardcategory->page_description = $request->page_description;
        $ecardcategory->meta_keyword = $request->meta_keyword;
        $ecardcategory->save();

        if ($request->hasFile('header_image')) {
            $header_image = $request->file('header_image');
            $ext = $header_image->extension();
            $imagename = Str::of($request->name)->slug('_') . '_header' .time(). '.' . $ext;
            $path = 'storage/img/headers';
            $request->file('header_image')->move($path, $imagename);

            $ecardcategory->header_image = $imagename;
            $ecardcategory->save();
        }

        return redirect()->route('ecardcategories.index')->with('success', 'Ecard Category updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            EcardCategory::find($id)->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->with('error', $e->errorInfo[2]);
        }
        return redirect()->route('ecardcategories.index')->with('success', 'Category deleted.');
    }

    public function setdate($id)
    {
        $ecardcategory = EcardCategory::findOrFail($id);
        return view('ecardcategories.setdate', compact('ecardcategory'));
    }

    public function setdate_add(Request $request, $id)
    {

        $ecardcategory = EcardCategory::find($id);

        $ecardcategory->date = $request->date;
        $ecardcategory->save();

        return redirect()->route('ecardcategories.index')->with('success', 'Date set!');
    }
}
