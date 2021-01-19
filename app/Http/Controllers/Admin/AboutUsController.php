<?php

namespace App\Http\Controllers\Admin;

use App\Admin\AboutUs;
use App\Admin\Overview;
use App\Admin\Integrated;
use App\Admin\MissionVision;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AboutUsController extends Controller
{

    const ABOUT_FOLDER = "admin.about";

    const OVERVIEW_FOLDER = "admin.about.overview";
    const INTEGRATED_FOLDER = "admin.about.integrated";
    const MISION_VISION_FOLDER = "admin.about.mission-vision";

    const TITLE = "About Us";

    const TITLE_OVERVIEW = "Overview";
    const TITLE_INTEGRATED = "Integrated";
    const TITLE_MISSION_VISION = "Mission & Vision";

    const ROUTE = "/admin/about-us";

    const OVERVIEW_ROUTE = "/admin/overview";
    const INTEGRATED_ROUTE = "/admin/integrated";
    const MISSION_VISION_ROUTE = "/admin/mission-vision";

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = AboutUs::all();
        $title = self::TITLE;
        $route = self::ROUTE;
        return view(self::ABOUT_FOLDER . '.index', compact('title', 'route', 'data'));
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function overview()
    {
        $data = Overview::all();
        $title = self::TITLE_OVERVIEW;
        $route = self::OVERVIEW_ROUTE;
        return view(self::OVERVIEW_FOLDER . '.overview', compact('title', 'route', 'data'));
    }

    public function overviewEdit($id)
    {
        $data = Overview::find($id);
        $title = self::TITLE_OVERVIEW;
        $route = self::OVERVIEW_ROUTE;
        $action = "Edit";
        return view(self::OVERVIEW_FOLDER . '.edit', compact('title', 'route', 'action', 'data'));
    }

    public function overviewStore(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:191',
            'text1' => 'required|string',
            'text2' => 'required|string',
            'text3' => 'required|string',
            'path' => 'image'
        ]);

        $overview = Overview::find($id);
        $overview->title = $request->title;
        $overview->text1 = $request->text1;
        $overview->text2 = $request->text2;
        $overview->text3 = $request->text3;

        if ($request->path) {
            Storage::disk('public')->delete($overview->path);
            $path = Storage::disk('public')->putFile('overview', new File($request->path));
            $overview->path = $path;
        }

        $overview->save();

        return redirect(self::OVERVIEW_ROUTE);
    }


    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function integrated()
    {
        $data = Integrated::all();
        $title = self::TITLE_INTEGRATED;
        $route = self::INTEGRATED_ROUTE;
        return view(self::INTEGRATED_FOLDER . '.integrated', compact('title', 'route', 'data'));
    }

    public function integratedEdit($id)
    {
        $data = Integrated::find($id);
        $title = self::TITLE_INTEGRATED;
        $route = self::INTEGRATED_ROUTE;
        $action = "Edit";
        return view(self::INTEGRATED_FOLDER . '.edit', compact('title', 'route', 'action', 'data'));
    }

    public function integratedStore(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:191',
            'description1' => 'required|string',
            'description2' => 'required|string'
        ]);

        $integrated = Integrated::find($id);
        $integrated->title = $request->title;
        $integrated->description1 = $request->description1;
        $integrated->description2 = $request->description2;

        $integrated->save();

        return redirect(self::INTEGRATED_ROUTE);
    }


    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function missionVision()
    {
        $data = MissionVision::all();
        $title = self::TITLE_MISSION_VISION;
        $route = self::MISSION_VISION_ROUTE;
        return view(self::MISION_VISION_FOLDER . '.mission-vision', compact('title', 'route', 'data'));
    }

    public function missionVisionEdit($id)
    {
        $data = MissionVision::find($id);
        $title = self::TITLE_MISSION_VISION;
        $route = self::MISSION_VISION_ROUTE;
        $action = "Edit";
        return view(self::MISION_VISION_FOLDER . '.edit', compact('title', 'route', 'action', 'data'));
    }

    public function missionVisionStore(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:191',
            'mission_text' => 'required|string',
            'vision_text' => 'required|string'
        ]);

        $integrated = MissionVision::find($id);
        $integrated->title = $request->title;
        $integrated->mission_text = $request->mission_text;
        $integrated->vision_text = $request->vision_text;

        $integrated->save();

        return redirect(self::MISSION_VISION_ROUTE);
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
        return view(self::ABOUT_FOLDER . '.create', compact('title', 'route', 'action'));
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
            'path' => 'required|image'
        ]);

        $path = Storage::disk('public')->putFile('about', new File($request->path));

        DB::beginTransaction();

        $about = new AboutUs;
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
     * @param \App\Admin\AboutUs $AboutUs
     * @return \Illuminate\Http\Response
     */
    public function show(AboutUs $AboutUs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @param \App\Admin\AboutUs $AboutUs
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = AboutUs::find($id);
        $title = self::TITLE;
        $route = self::ROUTE;
        $action = "Edit";
        return view(self::ABOUT_FOLDER . '.edit', compact('title', 'route', 'action', 'data'));
    }

    /**
     * Update the specified resource in storage.
     * @param \Illuminate\Http\Request $request
     * @param \App\Admin\AboutUs     $AboutUs
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

        $slider = AboutUs::find($id);
        $slider->title = $request->title;
        $slider->link = $request->link;
        $slider->description = $request->description;
        $slider->link = $request->link;

        if ($request->path) {
            Storage::disk('public')->delete($slider->path);
            $path = Storage::disk('public')->putFile('about', new File($request->path));
            $slider->path = $path;
        }

        $slider->save();

        DB::commit();

        return redirect(self::ROUTE);
    }

    /**
     * Remove the specified resource from storage.
     * @param \App\Admin\AboutUs $AboutUs
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        AboutUs::destroy($id);
        return  redirect(self::ROUTE);
    }
}
