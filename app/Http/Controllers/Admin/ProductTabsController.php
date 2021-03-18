<?php

namespace App\Http\Controllers\Admin;

use App\Admin\ProductTabs;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\helpers\FileUploadHelper;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

class ProductTabsController extends Controller
{

    const FOLDER = "admin.producttabs";
    const TITLE = "Product Tabs";
    const ROUTE = "/admin/product-tabs";

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ProductTabs::orderBy('ordering','asc')->get();
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
            "name" => "required",
            "description" => "required"
        ]);



        $ProductTabs = new ProductTabs;
        $ProductTabs->name = $request->name;
        $ProductTabs->description = $request->description;
        if(!$ProductTabs->save()) {
            echo "<pre>";print_r($ProductTabs->getErrors());die;
        }

        return redirect(self::ROUTE);
    }

    /**
     * Display the specified resource.
     * @param \App\Admin\ProductTabs $ProductTabs
     * @return \Illuminate\Http\Response
     */
    public function updateOrdering(Request $request)
    {
        $success = true;
        $errorMessage = '';
        try {
            $data = $request->all();
            foreach ($data as $tab) {
                $tabModel = ProductTabs::find($tab['id']);
                $tabModel->update(['ordering'=>(int)$tab['ordering']]);
            }
        } catch (\Throwable $e) {
            $success = false;
            $errorMessage = $e->getMessage();
        }
        return response()->json(['success'=>$success, 'errorMessage'=>$errorMessage]);
    }
    public function show($id)
    {
        $data = ProductTabs::find($id);
        $title = self::TITLE;
        $route = self::ROUTE;
        return view(self::FOLDER . '.show', compact('title', 'route', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param \App\Admin\ProductTabs $ProductTabs
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = ProductTabs::find($id);
        $title = self::TITLE;
        $route = self::ROUTE;
        $action = "Edit";
        return view(self::FOLDER . '.edit', compact('title', 'route', 'action', 'data'));
    }

    /**
     * Update the specified resource in storage.
     * @param \Illuminate\Http\Request $request
     * @param \App\Admin\ProductTabs     $ProductTabs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            "name" => "required"
        ]);

        $ProductTabs = ProductTabs::find($id);

        $ProductTabs->name = $request->name;
        $ProductTabs->description = $request->description;

        $ProductTabs->save();

        return redirect(self::ROUTE);
    }

    /**
     * Remove the specified resource from storage.
     * @param \App\Admin\ProductTabs $ProductTabs
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ProductTabs = ProductTabs::find($id);
         ProductTabs::destroy($ProductTabs->id);
        return  redirect(self::ROUTE);
    }
}
