<?php

namespace App\Http\Controllers\Admin;

use App\Admin\MediaImage;
use App\helpers\FileUploadHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use App\Admin\Media;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class NewsletterController extends Controller
{

    const FOLDER = "admin.media.newsletters";
    const TITLE = "Newsletter";
    const ROUTE = "/admin/newsletters";

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Media::where('type', Media::TYPE['newsletter'])->get();
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
            'title' => 'required',
            'description' => 'required',
            'date' => 'required',
            'logo' => 'required|image|max:2048',
            'images' => 'max:5000',
        ]);

        $logo = Storage::disk('public')->putFile('media/', new File($request->logo));
        $image = FileUploadHelper::upload($request->images, ['*'], "media");

        DB::beginTransaction();

        $media = new Media;
        $media->title = $request->title;
        $media->description = $request->description;
        $media->date = $request->date;
        $media->type = Media::TYPE['newsletter'];
        $media->logo = $logo;
        $media->save();

        $media->images()->createMany($image);
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
        $data = Media::find($id);
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
        $data = Media::with('images')->where('id', $id)->first();
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
            'title' => 'required',
            'description' => 'required',
            'date' => 'required',
            'logo' => 'max:2048',
            'images' => 'max:5000',
        ]);

        DB::beginTransaction();

        $media = Media::find($id);
        $media->title = $request->title;
        $media->description = $request->description;
        $media->date = $request->date;
        $media->type = Media::TYPE['newsletter'];

        if ($request->logo){
            Storage::disk('public')->delete($media->logo);
            $logo = Storage::disk('public')->putFile('media/', new File($request->logo));
            $media->logo = $logo;
        }

        $media->save();

        if (!empty($request->images) OR $request->images != NULL){
            $image = FileUploadHelper::upload($request->images, ['*'], "media");
            $media->images()->createMany($image);
        }
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
        $media = Media::with('images')->where('id', $id)->first();

        if (!empty($media->images)) {
            foreach ($media->images as $key) {
                Storage::disk('public')->delete("$key->image");
            }
        }
        Media::destroy($media->id);

        return redirect(self::ROUTE);
    }

    /**
     * @param $media_id
     * @param $image_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroyImage($media_id, $image_id)
    {
        $media_image = MediaImage::find($image_id);
        Storage::disk('public')->delete("$media_image->image");
        MediaImage::destroy($media_image->id);
        return redirect(self::ROUTE.'/'.$media_id.'/edit');
    }
}