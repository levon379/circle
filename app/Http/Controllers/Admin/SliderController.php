<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use App\Admin\Slider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Admin\Category;
use App\helpers\FileUploadHelper;



class SliderController extends Controller
{

    const FOLDER = "admin.slider";
    const TITLE = "Slider";
    const ROUTE = "/admin/slider";

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Slider::orderBy('ordering','asc')->get();
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
        $category = Category::all();
        return view(self::FOLDER . '.create', compact('title', 'route', 'action','category'));
    }

    /**
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function updateOrdering(Request $request)
    {
        $success = true;
        $errorMessage = '';
        try {
            $data = $request->all();
            foreach ($data as $slider) {
                $sliderModel = Slider::find($slider['id']);
                $sliderModel->update(['ordering'=>(int)$slider['ordering']]);
            }
        } catch (\Throwable $e) {
            $success = false;
            $errorMessage = $e->getMessage();
        }
        return response()->json(['success'=>$success, 'errorMessage'=>$errorMessage]);
    }
    public function store(Request $request)
    { //dd($request->path);
        $request->validate([
            'title' => 'required|max:191',
            'description' => 'string',
            //'link' => 'string|max:191',
            //'link_web' => 'string|max:191',
            //"category_id" => "numeric",
            'path' => 'required|image'
        ]);
        if ($request->has('pdf_path') !='') {
            $pdf = Storage::disk('public')->putFile('slider', new File($request->pdf_path));
            //$pdf = FileUploadHelper::upload($request->pdf_path, ['*'], "/slider");
        }else{
            $pdf = '';
        }
        $path = Storage::disk('public')->putFile('slider', new File($request->path));

        DB::beginTransaction();

        $slider = new Slider;
        $slider->title = $request->title;
        $slider->description = $request->description;
        $slider->link = $request->link;
        $slider->link_web = $request->link_web;
        $slider->pdf_path = $pdf;
        //$slider->category_id = $request->category_id;
        $slider->path = $path;
        $slider->save();

        DB::commit();

        return redirect(self::ROUTE);
    }

    /**
     * Display the specified resource.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Slider::find($id);
        $title = self::TITLE;
        $route = self::ROUTE;
        $action = "Show";
        return view(self::FOLDER . '.show', compact('title', 'route', 'data', 'action'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Slider::find($id);
        $title = self::TITLE;
        $route = self::ROUTE;
        $action = "Edit";
        $category = Category::all();
        return view(self::FOLDER . '.edit', compact('title', 'route', 'action', 'data','category'));
    }

    /**
     * Update the specified resource in storage.
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:191',
            'description' => 'string',
            //'link' => 'string|max:191',
            //'link_web' => 'string|max:191',
            //"category_id" => "numeric",
            'path' => 'required'
        ]);
        DB::beginTransaction();

        $slider = Slider::find($id);
        $slider->title = $request->title;
        $slider->description = $request->description;
        $slider->link = $request->link;
        $slider->link_web = $request->link_web;
        //$slider->category_id = $request->category_id;

        if ($request->has('pdf_path') !='') {
            Storage::disk('public')->delete("$slider->pdf_path");
            $pdf = Storage::disk('public')->putFile('slider', new File($request->pdf_path));
            $slider->pdf_path = $pdf;
        }

        if ($request->imagePath) {
            Storage::disk('public')->delete($slider->path);
            $path = Storage::disk('public')->putFile('slider', new File($request->imagePath));
            $slider->path = $path;
        }

        $slider->save();

        DB::commit();

        return redirect(self::ROUTE);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $slider = Slider::find($id);
        Storage::disk('public')->delete("$slider->pdf_path");
        Storage::disk('public')->delete("$slider->path");
        Slider::destroy($slider->id);

        return redirect(self::ROUTE);
    }
}
