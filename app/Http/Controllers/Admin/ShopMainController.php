<?php

namespace App\Http\Controllers\Admin;

use App\Admin\ShopMain;
use App\Http\Controllers\Controller;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ShopMainController extends Controller
{


    const FOLDER = "admin.shop-main";
    const TITLE = "Shop Main";
    const ROUTE = "/admin/shop-main";

    /******************** TEAM Main Start  ****************/
    public function main()
    {
        $data = ShopMain::all();
        $title = self::TITLE;
        $route = self::ROUTE;
        return view(self::FOLDER . '.index', compact('title', 'route', 'data'));
    }

    public function edit($id)
    {
        $data = ShopMain::find($id);
        $title = self::TITLE;
        $route = self::ROUTE;
        $action = "Edit";
        return view(self::FOLDER . '.edit', compact('title', 'route', 'action', 'data'));
    }

    public function store(Request $request, $id)
    {
        $request->validate([
//            'title' => 'required|max:191',
            'path' => 'image'
        ]);

        $team = ShopMain::find($id);
//        $contact->title = $request->title;

        if ($request->path) {
            Storage::disk('public')->delete($team->path);
            $path = Storage::disk('public')->putFile('shop-main', new File($request->path));
            $team->path = $path;
        }

        $team->save();

        return redirect(self::ROUTE);
    }
    /******************** TEAM Main End ****************/
}
