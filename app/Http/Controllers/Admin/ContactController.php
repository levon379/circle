<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Contact;
use App\helpers\FileUploadHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ContactController extends Controller
{

    const FOLDER = "admin.contact-us";
    const TITLE = "Contact US";
    const ROUTE = "/admin/contact-us";

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Contact::all();
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
//            "message" => "required",
        ]);

        DB::beginTransaction();

        $contact = new Contact;
        $contact->email = $request->email;
        $contact->message = $request->message;
        $contact->save();
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
        $data = Contact::find($id);
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
        $data = Contact::find($id);
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
//            "message" => "required",
        ]);


        DB::beginTransaction();

        $contact = Contact::find($id);
        $contact->email = $request->email;
        $contact->message = $request->message;

        $contact->save();


        DB::commit();

        return redirect(self::ROUTE);
    }

    /**
     * Remove the specified resource from storage.
     * @param \App\Admin\RequestQuote $product
     * @return \Illuminate\Http\Response
     */

    public function destroyContact($id)
    {
        $contact = Contact::find($id);
        Contact::destroy($contact->id);
        return  redirect(self::ROUTE);
    }

    /**
     * @param $product_id
     * @param $image_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */


}
