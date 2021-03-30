<?php

namespace App\Http\Controllers\Admin;

use App\Admin\OurWorks;
use App\helpers\FileUploadHelper;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OurWorksController extends Controller
{

    const FOLDER = "admin.our-works";
    const TITLE = "Our Works";
    const ROUTE = "/admin/our-works";

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = OurWorks::all();
        $title = self::TITLE;
        $route = self::ROUTE;
        return view(self::FOLDER . '.index', compact('title','route', 'data'));
    }
    public function create()
    {
        $title = self::TITLE;
        $route = self::ROUTE;
        return view(self::FOLDER . '.create', compact('title', 'route'));
    }


    public function store(Request $request)
    {

        $request->validate([
            "title" => "required",
            "description" => "required",
            "category" => "required",
            "thumbnail" => "image|max:5000",
        ]);
        $logo = Storage::disk('public')->putFile('our-works/', new File($request->thumbnail));

        DB::beginTransaction();

        $service = new OurWorks;
        $service->title = $request->title;
        $service->description = $request->description;
        $service->category = $request->category;
        $service->logo = $logo;
        $service->save();

        DB::commit();

        return redirect(self::ROUTE);
    }

    public function edit(OurWorks $product,$id)
    {
        $data = OurWorks::find($id);

        $title = self::TITLE;
        $route = self::ROUTE;
        return view(self::FOLDER . '.edit', compact('title', 'route', 'data'));
    }

    public function update(Request $request, OurWorks $product,$id)
    {
        $request->validate([
            "title" => "required",
            "description" => "required",
            "category" => "required",
            "thumbnail" => "image|max:5000",
        ]);


        DB::beginTransaction();

        $service = OurWorks::find($id);
        $service->title = $request->title;
        $service->description = $request->description;
        $service->category = $request->category;

        if ($request->thumbnail) {
            Storage::disk('public')->delete("$request->thumbnail");
            $logo = Storage::disk('public')->putFile('our-works/', new File($request->thumbnail));
            $service->logo = $logo;
        }

        $service->save();

        DB::commit();

        return redirect(self::ROUTE);
    }
    public function destroyWork($id)
    {
        $work = OurWorks::find($id);
        Storage::disk('public')->delete("$work->thumbnail");
        OurWorks::destroy($work->id);
        return  redirect(self::ROUTE);
    }

}
