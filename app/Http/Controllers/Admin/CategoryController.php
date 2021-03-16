<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\helpers\FileUploadHelper;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

class CategoryController extends Controller
{

    const FOLDER = "admin.categories";
    const TITLE = "Category";
    const ROUTE = "/admin/categories";

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Category::all();
        $title = self::TITLE;
        $route = self::ROUTE;
        return view(self::FOLDER . '.index', compact('title', 'route', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = self::TITLE;
        $route = self::ROUTE;
        $action = "Create";
        return view(self::FOLDER . '.create', compact('title', 'route', 'action'));
    }

    /**
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required"
        ]);
//dd($request->pdf_path);
        //$pdf = Storage::disk('public')->putFile('categories', new File($request->pdf_path));
        //$pdf = FileUploadHelper::upload($request->pdf_path, ['*'], "/categories");

        $Category = new Category;
        $Category->name = $request->name;
        $Category->description = $request->description;
        //$Category->pdf_path = $pdf;
        //$Category->link = $request->link;
        if(!$Category->save()) {
            echo "<pre>";print_r($Category->getErrors());die;
        }

        return redirect(self::ROUTE);
    }

    /**
     * Display the specified resource.
     * @param \App\Admin\Category $Category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $Category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @param \App\Admin\Category $Category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Category::find($id);
        $title = self::TITLE;
        $route = self::ROUTE;
        $action = "Edit";
        return view(self::FOLDER . '.edit', compact('title', 'route', 'action', 'data'));
    }

    /**
     * Update the specified resource in storage.
     * @param \Illuminate\Http\Request $request
     * @param \App\Admin\Category     $Category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            "name" => "required"
        ]);

        $Category = Category::find($id);

//        if ($request->pdf_path) {
//            Storage::disk('public')->delete("$Category->pdf_path");
//            $pdf = Storage::disk('public')->putFile('categories', new File($request->pdf_path));
//            $Category->pdf_path = $pdf;
//        }


        $Category->name = $request->name;
        $Category->description = $request->description;

//        $Category->link = $request->link;
        $Category->save();

        return redirect(self::ROUTE);
    }

    /**
     * Remove the specified resource from storage.
     * @param \App\Admin\Category $Category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Category = Category::find($id);
//         Storage::disk('public')->delete("$Category->pdf_path");
         Category::destroy($Category->id);
        return  redirect(self::ROUTE);
    }
}
