<?php

namespace App\Http\Controllers\Admin;

use App\Admin\MediaImage;
use App\helpers\FileUploadHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use App\Admin\MailContent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MailSettingsController extends Controller
{

    const FOLDER = "admin.mailsettings";
    const TITLE = "Mail Settings";
    const ROUTE = "/admin/mail-settings";

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = MailContent::all();
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
            'subject' => 'required',
            'message' => 'required'
        ]);

        DB::beginTransaction();

        $media = new MailContent;
        $media->subject = $request->subject;
        $media->message = $request->message;
        $media->type = $request->type;
        $media->save();
        DB::commit();

        return redirect(self::ROUTE);
    }

    /**
     * Display the specified resource.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = MailContent::find($id);
        $title = self::TITLE;
        $route = self::ROUTE;
        $action = "Show";
        return view(self::FOLDER . '.show', compact('title', 'route', 'data', 'action'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = MailContent::find($id);
        $title = self::TITLE;
        $route = self::ROUTE;
        $action = "Edit";
        return view(self::FOLDER . '.edit', compact('title', 'route', 'action', 'data'));
    }

    /**
     * Update the specified resource in storage.
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'subject' => 'required',
            'message' => 'required'
        ]);

        DB::beginTransaction();

        $data = MailContent::find($id);
        $data->subject = $request->subject;
        $data->message = $request->message;
        $data->type = $request->type;
        $data->save();

        DB::commit();

        return redirect(self::ROUTE);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        MailContent::destroy($id);
        return redirect(self::ROUTE);
    }
}
