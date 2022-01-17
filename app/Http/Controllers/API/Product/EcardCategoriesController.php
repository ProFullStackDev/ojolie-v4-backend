<?php

namespace App\Http\Controllers\API\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\EcardCategory;
use App\Http\Resources\EcardCategoryResource;
use App\Http\Resources\HolidaysCategoryResource;
use App\Http\Resources\CategoryDetailResource;

class EcardCategoriesController extends Controller
{
    public function index()
    {
        return EcardCategoryResource::collection(EcardCategory::with('children')->whereNull('parent_id')->where('slug', '!=', 'popular-ecards-main')->get());
    }

    public function holidays_menu()
    {
        return HolidaysCategoryResource::collection(EcardCategory::where('parent_id', '=', '1')->paginate(5));
    }

    public function other_categories_menu()
    {
        return EcardCategoryResource::collection(EcardCategory::with('children')->whereNull('parent_id')->where('name', '!=', 'HOLIDAYS')->get());
    }

    public function show($id)
    {
        return new EcardCategoryResource(EcardCategory::find($id));
    }

    public function show_slug($slug)
    {
        return EcardCategoryResource::collection(EcardCategory::with('children')->where('slug', '=', $slug)->get());
    }

    public function get_slug($slug)
    {
        return new CategoryDetailResource(EcardCategory::where('slug', '=', $slug)->first());
    }
}
