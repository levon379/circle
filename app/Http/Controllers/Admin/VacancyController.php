<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Vacancy;
use App\helpers\FileUploadHelper;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class VacancyController extends Controller
{

    const FOLDER = "admin.vacancy";
    const TITLE = "Vacancy";
    const ROUTE = "/admin/vacancy";

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Vacancy::orderBy('ordering','asc')->get();;
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

    public function updateOrdering(Request $request)
    {
        $success = true;
        $errorMessage = '';
        try {
            $data = $request->all();
            foreach ($data as $slider) {
                $sliderModel = Vacancy::find($slider['id']);
                $sliderModel->update(['ordering'=>(int)$slider['ordering']]);
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
            "title" => "required",
            "description" => "required",
            "show" => "required|numeric",
            "thumbnail" => "image|max:5000",
        ]);
        $logo = Storage::disk('public')->putFile('vacancy', new File($request->thumbnail));

        DB::beginTransaction();
        $shop = new Vacancy;
        $shop->title = $request->title;
        $shop->description = $request->description;
        $shop->show = $request->show;
        $shop->logo = $logo;
        $shop->save();

        DB::commit();

        return redirect(self::ROUTE);
    }

    public function edit(Vacancy $product,$id)
    {
        $data = Vacancy::find($id);
        $title = self::TITLE;
        $route = self::ROUTE;
        return view(self::FOLDER . '.edit', compact('title', 'route', 'data'));
    }

    public function update(Request $request, Vacancy $product,$id)
    {
        $request->validate([
            "title" => "required",
            "description" => "required",
            "show" => "required|numeric",
            "thumbnail" => "image|max:5000",
        ]);


        DB::beginTransaction();

        $shop = Vacancy::find($id);
        $shop->title = $request->title;
        $shop->description = $request->description;
        $shop->show = $request->show;

        if ($request->thumbnail) {
            Storage::disk('public')->delete("$request->thumbnail");
            $logo = Storage::disk('public')->putFile('vacancy', new File($request->thumbnail));
            $shop->logo = $logo;
        }

        $shop->save();

        DB::commit();

        return redirect(self::ROUTE);
    }
    public function destroyShop($id)
    {
        $shop = Vacancy::find($id);
        Storage::disk('public')->delete("$shop->thumbnail");
        Vacancy::destroy($shop->id);
        return  redirect(self::ROUTE);
    }

}
