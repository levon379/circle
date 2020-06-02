<?php

namespace App\Http\Controllers\Admin;

use App\Admin\ContactUs;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{

    const FOLDER = "admin.contact";
    const TITLE = "Contact Us";
    const ROUTE = "/admin/contact-us";

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ContactUs::first();
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
            "factory_name" => "required",
            "country" => "required",
            "telephone_number" => "required",
            "fax_number" => "required",
            "po_box" => "required",
        ]);

        $contactUs = new ContactUs;
        $contactUs->factory_name = $request->factory_name;
        $contactUs->country = $request->country;
        $contactUs->telephone_number = $request->telephone_number;
        $contactUs->fax_number = $request->fax_number;
        $contactUs->po_box = $request->po_box;
        $contactUs->save();

        return redirect(self::ROUTE);
    }

    /**
     * Display the specified resource.
     * @param \App\Admin\ContactUs $contactUs
     * @return \Illuminate\Http\Response
     */
    public function show(ContactUs $contactUs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @param \App\Admin\ContactUs $contactUs
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = ContactUs::find($id);
        $title = self::TITLE;
        $route = self::ROUTE;
        $action = "Edit";
        return view(self::FOLDER . '.edit', compact('title', 'route', 'action', 'data'));
    }

    /**
     * Update the specified resource in storage.
     * @param \Illuminate\Http\Request $request
     * @param \App\Admin\ContactUs     $contactUs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            "factory_name" => "required",
            "country" => "required",
            "telephone_number" => "required",
            "fax_number" => "required",
            "po_box" => "required",
        ]);

        $contactUs = ContactUs::find($id);
        $contactUs->factory_name = $request->factory_name;
        $contactUs->country = $request->country;
        $contactUs->telephone_number = $request->telephone_number;
        $contactUs->fax_number = $request->fax_number;
        $contactUs->po_box = $request->po_box;
        $contactUs->save();

        return redirect(self::ROUTE);
    }

    /**
     * Remove the specified resource from storage.
     * @param \App\Admin\ContactUs $contactUs
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContactUs $contactUs)
    {
        //
    }
}
