<?php

namespace App\Http\Controllers\Admin;

use App\Admin\RequestQuote;
use App\Admin\RequestQuoteImage;
use App\helpers\FileUploadHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RequestQuoteController extends Controller
{

    const FOLDER = "admin.request-quote";
    const TITLE = "Request Quote";
    const ROUTE = "/admin/request-quote";

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = RequestQuote::with('image')->get();
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
        $request->validate([
            "email" => "required",
            "quote" => "required",
            /*"product_desc" => "required",
            "uses_desc" => "required",*/
            "images" => "array|max:5",
        ]);

        if ($request->has('images')) {
            $image = FileUploadHelper::upload($request->images, ['*'], "/request-quote");
        }
        DB::beginTransaction();

        $quote = new RequestQuote;
        $quote->email = $request->email;
        $quote->quote = $request->quote;
        $quote->save();
        if ($request->has('images')) {
            $quote->image()->createMany($image);
        }
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
        $data = RequestQuote::find($id);
        $title = self::TITLE;
        $route = self::ROUTE;
        return view(self::FOLDER . '.show', compact('title', 'route', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param \App\Admin\RequestQuote $product
     * @return \Illuminate\Http\Response
     */
    public function edit(RequestQuote $product, $id)
    {
        $data = RequestQuote::find($id);
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
    public function update(Request $request, RequestQuote $quote, $id)
    {
        //dd($request);
        $request->validate([
            "email" => "required",
            "quote" => "required",
            "images" => "array",
        ]);


        DB::beginTransaction();

        $quote = RequestQuote::find($id);
        $quote->email = $request->email;
        $quote->quote = $request->quote;

        $quote->save();

        if ($request->has('images')) {
            $image = FileUploadHelper::upload($request->images, ['*'], "/request-quote");
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
    public function destroyRequest(RequestQuote $quote)
    {
        if (!empty($quote->image)) {
            foreach ($quote->image as $key) {
                Storage::disk('public')->delete("$key->image");
            }
        }
        RequestQuote::destroy($quote->id);
        return redirect(self::ROUTE);
    }
    public function destroyQuote($id)
    {
        $quote = RequestQuote::find($id);
        RequestQuote::destroy($quote->id);
        return  redirect(self::ROUTE);
    }

    /**
     * @param $product_id
     * @param $image_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroyImage($quote_id, $image_id)
    {
        $quote_image = RequestQuoteImage::find($image_id);
        Storage::disk('public')->delete("$quote_image->image");
        RequestQuoteImage::destroy($quote_image->id);
        return redirect(self::ROUTE . '/' . $quote_id . '/edit');
    }


}
