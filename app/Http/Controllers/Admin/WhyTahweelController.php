<?php

namespace App\Http\Controllers\Admin;

use App\Admin\WhyTahweel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class WhyTahweelController extends Controller
{

    const FOLDER = "admin.why-tahweel";
    const TITLE = "Why Tahweel";
    const ROUTE = "/admin/why-tahweel";

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = WhyTahweel::orderBy('ordering','asc')->get();
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
    public function updateOrdering(Request $request)
    {
        $success = true;
        $errorMessage = '';
        try {
            $data = $request->all();
            foreach ($data as $whyTahweel) {
                $whyTahweelModel = WhyTahweel::find($whyTahweel['id']);
                $whyTahweelModel->update(['ordering'=>(int)$whyTahweel['ordering']]);
            }
        } catch (\Throwable $e) {
            $success = false;
            $errorMessage = $e->getMessage();
        }
        return response()->json(['success'=>$success, 'errorMessage'=>$errorMessage]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:191',
            'description' => 'string',
            'link' => 'string|max:191',
            'path' => 'required'
        ]);

        $path = Storage::disk('public')->putFile('why-tahweel', new File($request->path));

        DB::beginTransaction();

        $about = new WhyTahweel;
        $about->title = $request->title;
        $about->link = $request->link;
        $about->description = $request->description;
        $about->path = $path;
        $about->save();

        DB::commit();

        return redirect(self::ROUTE);
    }

    /**
     * Display the specified resource.
     * @param \App\Admin\WhyTahweel $WhyTahweel
     * @return \Illuminate\Http\Response
     */
    public function show(WhyTahweel $WhyTahweel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @param \App\Admin\WhyTahweel $WhyTahweel
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = WhyTahweel::find($id);
        $title = self::TITLE;
        $route = self::ROUTE;
        $action = "Edit";
        return view(self::FOLDER . '.edit', compact('title', 'route', 'action', 'data'));
    }

    /**
     * Update the specified resource in storage.
     * @param \Illuminate\Http\Request $request
     * @param \App\Admin\WhyTahweel     $WhyTahweel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:191',
            'description' => 'string',
            'link' => 'string|max:191',
            'path' => 'required|image'
        ]);

        DB::beginTransaction();

        $slider = WhyTahweel::find($id);
        $slider->title = $request->title;
        $slider->link = $request->link;
        $slider->description = $request->description;
        $slider->link = $request->link;

        if ($request->path) {
            Storage::disk('public')->delete($slider->path);
            $path = Storage::disk('public')->putFile('why-tahweel', new File($request->path));
            $slider->path = $path;
        }

        $slider->save();

        DB::commit();

        return redirect(self::ROUTE);
    }

    /**
     * Remove the specified resource from storage.
     * @param \App\Admin\WhyTahweel $WhyTahweel
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        WhyTahweel::destroy($id);
        return  redirect(self::ROUTE);
    }
}
