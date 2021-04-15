<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Vacancy;
use App\Admin\Career;
use App\helpers\FileUploadHelper;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CareerController extends Controller
{

    const FOLDER = "admin.career";
    const TITLE = "Career";
    const ROUTE = "/admin/career";

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Career::orderBy('ordering','asc')->get();;
        $vacancy = Vacancy::all();
        $title = self::TITLE;
        $route = self::ROUTE;
        return view(self::FOLDER . '.index', compact('title','route', 'vacancy', 'data'));
    }
    public function create()
    {
        $vacancy = Vacancy::all();
        $title = self::TITLE;
        $route = self::ROUTE;
        return view(self::FOLDER . '.create', compact('title', 'route','vacancy'));
    }

    public function updateOrdering(Request $request)
    {
        $success = true;
        $errorMessage = '';
        try {
            $data = $request->all();
            foreach ($data as $slider) {
                $sliderModel = Career::find($slider['id']);
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

        $logo = Storage::disk('public')->putFile('career', new File($request->thumbnail));

        DB::beginTransaction();
        $shop = new Career;
        $shop->vacancy_id = $request->vacancy_id;
        $shop->logo = $logo;
        $shop->save();

        DB::commit();

        return redirect(self::ROUTE);
    }

    public function edit(Career $product,$id)
    {
        $data = Career::find($id);
        $vacancy = Vacancy::all();
        $title = self::TITLE;
        $route = self::ROUTE;
        return view(self::FOLDER . '.edit', compact('title', 'route', 'data','vacancy'));
    }

    public function update(Request $request, Career $product,$id)
    {
        DB::beginTransaction();

        $shop = Career::find($id);
        $shop->vacancy_id = $request->vacancy_id;

        if ($request->thumbnail) {
            Storage::disk('public')->delete("$request->thumbnail");
            $logo = Storage::disk('public')->putFile('career', new File($request->thumbnail));
            $shop->logo = $logo;
        }

        $shop->save();

        DB::commit();

        return redirect(self::ROUTE);
    }
    public function destroyShop($id)
    {
        $shop = Career::find($id);
        Storage::disk('public')->delete("$shop->thumbnail");
        Career::destroy($shop->id);
        return  redirect(self::ROUTE);
    }

}
