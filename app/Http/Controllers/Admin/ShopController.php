<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Category;
use App\Admin\Shop;
use App\helpers\FileUploadHelper;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ShopController extends Controller
{

    const FOLDER = "admin.shop";
    const TITLE = "Shop";
    const ROUTE = "/admin/shop";

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Shop::orderBy('ordering','asc')->get();;
        $category = Category::all();
        $title = self::TITLE;
        $route = self::ROUTE;
        return view(self::FOLDER . '.index', compact('title','route', 'category', 'data'));
    }
    public function create()
    {
        $category = Category::all();
        $title = self::TITLE;
        $route = self::ROUTE;
        return view(self::FOLDER . '.create', compact('title', 'route','category'));
    }

    public function updateOrdering(Request $request)
    {
        $success = true;
        $errorMessage = '';
        try {
            $data = $request->all();
            foreach ($data as $slider) {
                $sliderModel = Shop::find($slider['id']);
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
            "link" => "required",
            "show" => "required|numeric",
            "price" => "required",
            "currency" => "required",
            "category_id" => "required|numeric",
            "thumbnail" => "image|max:5000",
        ]);
        $logo = Storage::disk('public')->putFile('shop', new File($request->thumbnail));

        DB::beginTransaction();
        $shop = new Shop;
        $shop->title = $request->title;
        $shop->description = $request->description;
        $shop->category_id = $request->category_id;
        $shop->link = $request->link;
        $shop->show = $request->show;
        $shop->price = $request->price;
        $shop->currency = $request->currency;
        $shop->logo = $logo;
        $shop->save();

        DB::commit();

        return redirect(self::ROUTE);
    }

    public function edit(Shop $product,$id)
    {
        $data = Shop::find($id);
        $category = Category::all();
        $title = self::TITLE;
        $route = self::ROUTE;
        return view(self::FOLDER . '.edit', compact('title', 'route', 'data','category'));
    }

    public function update(Request $request, Shop $product,$id)
    {
        $request->validate([
            "title" => "required",
            "description" => "required",
            "category_id" => "required",
            "link" => "required",
            "show" => "required|numeric",
            "price" => "required",
            "currency" => "required",
            "thumbnail" => "image|max:5000",
        ]);


        DB::beginTransaction();

        $shop = Shop::find($id);
        $shop->title = $request->title;
        $shop->description = $request->description;
        $shop->link = $request->link;
        $shop->show = $request->show;
        $shop->price = $request->price;
        $shop->currency = $request->currency;
        $shop->category_id = $request->category_id;

        if ($request->thumbnail) {
            Storage::disk('public')->delete("$request->thumbnail");
            $logo = Storage::disk('public')->putFile('shop', new File($request->thumbnail));
            $shop->logo = $logo;
        }

        $shop->save();

        DB::commit();

        return redirect(self::ROUTE);
    }
    public function destroyShop($id)
    {
        $shop = Shop::find($id);
        Storage::disk('public')->delete("$shop->thumbnail");
        Shop::destroy($shop->id);
        return  redirect(self::ROUTE);
    }

}
