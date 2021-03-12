<?php

namespace App\Http\Controllers\Admin;

use App\Admin\ContactUs;
use App\Admin\Career;
use App\Http\Controllers\Controller;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContactUsController extends Controller
{

    const FOLDER = "admin.contact";
    const TITLE = "Contact Us";
    const ROUTE = "/admin/contact-us";

    const CAREER_FOLDER = "admin.career";
    const CAREER_TITLE = "Career";
    const CAREER_ROUTE = "/admin/career";

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ContactUs::all();
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
            "telephone_number" => "required|regex:/^([0-9\s\-\+\(\)]*)$/",
            "fax_number" => "required",
            "po_box" => "numeric",
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
            "telephone_number" => "required|regex:/^([0-9\s\-\+\(\)]*)$/",
            "fax_number" => "required",
            "po_box" => "numeric",
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
    public function destroy($id)
    {
        ContactUs::destroy($id);
        return  redirect(self::ROUTE);
    }
    /******************** Career START ****************/
    public function career()
    {
        $data = Career::all();
        $title = self::CAREER_TITLE;
        $route = self::CAREER_ROUTE;
        return view(self::CAREER_FOLDER . '.career', compact('title', 'route', 'data'));
    }

    public function careerEdit($id)
    {
        $data = Career::find($id);
        $title = self::CAREER_TITLE;
        $route = self::CAREER_ROUTE;
        $action = "Edit";
        return view(self::CAREER_FOLDER . '.edit', compact('title', 'route', 'action', 'data'));
    }

    public function careerStore(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:191',
            'description' => 'required|string',
            'path' => 'image'
        ]);

        $career = Career::find($id);
        $career->title = $request->title;
        $career->description = $request->description;

        if ($request->path) {
            Storage::disk('public')->delete($career->path);
            $path = Storage::disk('public')->putFile('career', new File($request->path));
            $career->path = $path;
        }

        $career->save();

        return redirect(self::CAREER_ROUTE);
    }
    /******************** CAREER END ****************/
}
