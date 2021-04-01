<?php

namespace App\Http\Controllers\Admin;

use App\Admin\WorkWithUs;
use App\Admin\WorkWithUsFiles;
use App\helpers\FileUploadHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class WorkWithUsController extends Controller
{

    const FOLDER = "admin.work-with-us";
    const TITLE = "Work With Us";
    const ROUTE = "/admin/work-with-us";

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = WorkWithUs::with('image')->get();
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
        return view(self::FOLDER . '.create', compact('title', 'route'));
    }

    /**
     * @param Request $request
     */


    /**
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
//        $extension = $data->image->getClientOriginalExtension();;
//        dd($extension);
//
//        $info = pathinfo(storage_path()."$data->image");
//        $ext = $info['extension'];
        $request->validate([
            "email" => "required",
            "message" => "required",
            "images" => "array|max:5",
        ]);

        if ($request->has('images')) {
            $image = FileUploadHelper::upload($request->images, ['*'], "/work-with-us");
        }
        DB::beginTransaction();

        $quote = new WorkWithUs;
        $quote->email = $request->email;
        $quote->message = $request->message;
        $quote->save();
        $arr = array();
        if (!empty($request->images)) {
            foreach ($request->images as $key => $val) {
                if ($val != null) {
                    $image = Storage::disk('public')->putFile('work-with-us', new File($val));
                    $arr[$key]['image'] = $image;
                    $arr[$key]['ext'] = $val->getClientOriginalExtension();
                    $arr[$key]['origin_name'] = $val->getClientOriginalName();
                }
            }
        }

        $quote->image()->createMany($arr);
        DB::commit();

        return redirect(self::ROUTE);
    }

    /**
     * Display the specified resource.
     * @param \App\Admin\RequestQuote $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = WorkWithUs::find($id);
        $title = self::TITLE;
        $route = self::ROUTE;
        return view(self::FOLDER . '.show', compact('title', 'route', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param \App\Admin\RequestQuote $product
     * @return \Illuminate\Http\Response
     */
    public function edit(WorkWithUs $product, $id)
    {
        $data = WorkWithUs::find($id);
        $title = self::TITLE;
        $route = self::ROUTE;
        return view(self::FOLDER . '.edit', compact('title', 'route',  'data'));
    }

    /**
     * Update the specified resource in storage.
     * @param \Illuminate\Http\Request $request
     * @param \App\Admin\RequestQuote       $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WorkWithUs $quote, $id)
    {
        //dd($request);
        $request->validate([
            "email" => "required",
            "message" => "required",
            "images" => "array",
        ]);


        DB::beginTransaction();

        $quote = WorkWithUs::find($id);
        $quote->email = $request->email;
        $quote->message = $request->message;

        $quote->save();

        if ($request->has('images')) {
            $image = FileUploadHelper::upload($request->images, ['*'], "/work-with-us");
            $quote->image()->createMany($image);
        }

        DB::commit();

        return redirect(self::ROUTE);
    }

    /**
     * Remove the specified resource from storage.
     * @param \App\Admin\RequestQuote $product
     * @return \Illuminate\Http\Response
     */
    public function destroyRequest(WorkWithUs $quote)
    {
        if (!empty($quote->image)) {
            foreach ($quote->image as $key) {
                Storage::disk('public')->delete("$key->image");
            }
        }
        WorkWithUs::destroy($quote->id);
        return redirect(self::ROUTE);
    }
    public function destroyQuote($id)
    {
        $quote = WorkWithUs::find($id);
        WorkWithUs::destroy($quote->id);
        return  redirect(self::ROUTE);
    }

    /**
     * @param $product_id
     * @param $image_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroyImage($quote_id, $image_id)
    {
        $quote_image = WorkWithUsFiles::find($image_id);
        Storage::disk('public')->delete("$quote_image->image");
        WorkWithUsFiles::destroy($quote_image->id);
        return redirect(self::ROUTE . '/' . $quote_id . '/edit');
    }


}
