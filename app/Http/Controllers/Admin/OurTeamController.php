<?php

namespace App\Http\Controllers\Admin;

use App\Admin\OurTeam;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OurTeamController extends Controller
{

    const FOLDER = "admin.our-team";
    const TITLE = "Our Team";
    const ROUTE = "/admin/our-team";

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = OurTeam::all();
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
            'name' => 'required|max:191',
            'surname' => 'required|max:191',
            'position' => 'required|max:191',
            'description' => 'string',
           // 'path' => 'required'
        ]);

        $path = Storage::disk('public')->putFile('our-team', new File($request->path));

        DB::beginTransaction();

        $team = new OurTeam;
        $team->name = $request->name;
        $team->surname = $request->surname;
        $team->position = $request->position;
        $team->description = $request->description;
        $team->path = $path;
        $team->save();

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
        $data = OurTeam::find($id);
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
            //'path' => 'image'
        ]);

        DB::beginTransaction();

        $team = OurTeam::find($id);
        $team->name = $request->name;
        $team->surname = $request->surname;
        $team->position = $request->position;
        $team->description = $request->description;


        if ($request->path) {
            Storage::disk('public')->delete($team->path);
            $path = Storage::disk('public')->putFile('our-team', new File($request->path));
            $team->path = $path;
        }

        $team->save();

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
        OurTeam::destroy($id);
        return  redirect(self::ROUTE);
    }
}
