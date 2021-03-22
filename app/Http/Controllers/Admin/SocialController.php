<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Social;
use App\Http\Controllers\Controller;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SocialController extends Controller
{

    const FOLDER = "admin.social";
    const TITLE = "Social Links";
    const ROUTE = "/admin/social";

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Social::orderBy('id','asc')->get();
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
            "link" => "required",
           // "logo" => "required|image|mimes:jpeg,png,jpg|max:2048",
        ]);

        //$logo = Storage::disk('public')->putFile('social/', new File($request->logo));

        $social = new Social;
        $social->name = $request->name;
        $social->link = $request->link;
       // $social->logo = $logo;
        $social->save();

        return redirect(self::ROUTE);
    }

    /**
     * Display the specified resource.
     * @param \App\Admin\Social $social
     * @return \Illuminate\Http\Response
     */
    public function show(Social $social)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @param \App\Admin\Social $social
     * @return \Illuminate\Http\Response
     */
    public function edit(Social $social)
    {
        $data = $social;
        $title = self::TITLE;
        $route = self::ROUTE;
        $action = "Edit";
        return view(self::FOLDER . '.edit', compact('title', 'route', 'action', "data"));
    }

    /**
     * Update the specified resource in storage.
     * @param \Illuminate\Http\Request $request
     * @param \App\Admin\Social        $social
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Social $social)
    {
        $request->validate([
            "name" => "required",
            "link" => "required",
            //"logo" => "mimes:jpeg,png,jpg|max:2048",
        ]);


//        if ($request->logo){
//            Storage::disk('public')->delete($social->logo);
//            $logo = Storage::disk('public')->putFile('social/', new File($request->logo));
//            $social->logo = $logo;
//        }

        $social->name = $request->name;
        $social->link = $request->link;
        $social->save();

        return redirect(self::ROUTE);
    }

    /**
     * Remove the specified resource from storage.
     * @param \App\Admin\Social $social
     * @return \Illuminate\Http\Response
     */
    public function destroy(Social $social)
    {
       // Storage::disk('public')->delete("$social->logo");
        Social::destroy($social->id);
        return redirect(self::ROUTE);
    }
}
