<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use App\Admin\Slider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Admin\Category;

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
        $data = Slider::all();
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
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:191',
            'description' => 'string',
            'link' => 'string|max:191',
            "category_id" => "numeric",
            'path' => 'required|image'
        ]);

        $path = Storage::disk('public')->putFile('slider', new File($request->path));

        DB::beginTransaction();

        $slider = new Slider;
        $slider->title = $request->title;
        $slider->link = $request->link;
        $slider->description = $request->description;
        $slider->category_id = $request->category_id;
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
            'link' => 'string|max:191',
            "category_id" => "numeric",
            'path' => 'required|image'
        ]);

        DB::beginTransaction();

        $slider = Slider::find($id);
        $slider->title = $request->title;
        $slider->link = $request->link;
        $slider->description = $request->description;
        $slider->category_id = $request->category_id;
        $slider->link = $request->link;

        if ($request->path) {
            Storage::disk('public')->delete($slider->path);
            $path = Storage::disk('public')->putFile('slider', new File($request->path));
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
        Storage::disk('public')->delete("$slider->path");
        Slider::destroy($slider->id);

        return redirect(self::ROUTE);
    }
}
