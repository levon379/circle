<?php

namespace App\Http\Controllers\Admin;

use App\Admin\HomePage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class HomePageController extends Controller
{

    const FOLDER = "admin.home-page";
    const TITLE = "Home";
    const ROUTE = "/admin/home-page";

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = HomePage::all();
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
            'title' => 'required|max:191',
            'description' => 'string',
            'link' => 'string|max:191',
           // 'path' => 'required'
        ]);

        $path = Storage::disk('public')->putFile('home-page', new File($request->path));

        DB::beginTransaction();

        $home = new HomePage;
        $home->title = $request->title;
        $home->link = $request->link;
        $home->description = $request->description;
        $home->path = $path;
        $home->save();

        DB::commit();

        return redirect(self::ROUTE);
    }

    /**
     * Display the specified resource.
     * @param \App\Admin\HomePage $WhyTahweel
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     * @param \App\Admin\HomePage $WhyTahweel
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = HomePage::find($id);
        $title = self::TITLE;
        $route = self::ROUTE;
        $action = "Edit";
        return view(self::FOLDER . '.edit', compact('title', 'route', 'action', 'data'));
    }

    /**
     * Update the specified resource in storage.
     * @param \Illuminate\Http\Request $request
     * @param \App\Admin\HomePage     $WhyTahweel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'max:191',
            'description' => 'string',
            'link' => 'string|max:191',
            'path' => 'mimetypes:video/x-ms-asf,video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/avi'
        ]);

        DB::beginTransaction();

        $home = HomePage::find($id);
        $home->title = $request->title;
        $home->link = $request->link;
        $home->description = $request->description;
        $home->link = $request->link;

        if ($request->path) {
            Storage::disk('public')->delete($home->path);
            $path = Storage::disk('public')->putFile('home-page', new File($request->path));
            $home->path = $path;
        }

        $home->save();

        DB::commit();

        return redirect(self::ROUTE);
    }

    /**
     * Remove the specified resource from storage.
     * @param \App\Admin\HomePage $WhyTahweel
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        HomePage::destroy($id);
        return  redirect(self::ROUTE);
    }
}
