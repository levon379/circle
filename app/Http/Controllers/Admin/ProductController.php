<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Category;
use App\Admin\Product;
use App\Admin\ProductList;
use App\Admin\ProductListItems;
use App\Admin\ProductTabs;
use App\Admin\ProductFeatur;
use App\Admin\ProductImage;
use App\Admin\ProductSpecification;
use App\Admin\ProductTabsMap;
use App\Admin\Specification;
use App\Admin\SpecificationType;
use App\helpers\FileUploadHelper;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    const FOLDER = "admin.products";
    const TITLE = "Products";
    const ROUTE = "/admin/products";

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Product::with('image')->get();
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
        $category = Category::all();
        $product_tabs = ProductTabs::all();
        $specification = Specification::all();
        $title = self::TITLE;
        $route = self::ROUTE;
        return view(self::FOLDER . '.create', compact('title', 'route', 'category', 'product_tabs', 'specification'));
    }

    /**
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            "title" => "required",
            /*"product_desc" => "required",
            "uses_desc" => "required",*/
            "category_id" => "required|numeric",
            "show" => "required|numeric",
            "images" => "required|array|max:5",
            "thumbnail" => "image|max:5000",
        ]);

        $logo = Storage::disk('public')->putFile('product/', new File($request->thumbnail));
        $image = FileUploadHelper::upload($request->images, ['*'], "/product");

        DB::beginTransaction();

        $product = new Product;
        $product->title = $request->title;
        $product->product_desc = $request->product_desc;
        //$product->uses_desc = $request->uses_desc;
        $product->category_id = $request->category_id;
        $product->logo = $logo;
        $product->show = $request->show;
        if($product->save()) {
            if ($request->has('tabs')&& is_array($request->tabs)) {
                foreach ($request->tabs as $key => $value) {
                    $product_tabs_map = new ProductTabsMap;
                    $product_tabs_map->products_id = $product->id;
                    $product_tabs_map->tabs_id = $value;
                    $product_tabs_map->save();
                }
            }

            for($i = 0; $i < 30; ++$i) {
                if (!$request->has("product-list-$i")) {
                    continue;
                }

                $product_list = new ProductList();
                $product_list->product_id = $product->id;
                $product_list->name = $request->{"product-list-$i"};
                $product_list->save();

                if (!$request->has("product-list-item-$i")) {
                    continue;
                }
                foreach($request->toArray()["product-list-item-$i"] as $itemName) {
                    $item = new ProductListItems();
                    $item->product_list_id = $product_list->id;
                    $item->name = $itemName;
                    $item->save();
                }

            }
        }

        $product->image()->createMany($image);

        DB::commit();

        return redirect(self::ROUTE);
    }

    /**
     * Display the specified resource.
     * @param \App\Admin\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $data = $product;
        $title = self::TITLE;
        $route = self::ROUTE;
        return view(self::FOLDER . '.show', compact('title', 'route', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param \App\Admin\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product,$id)
    {
        //$data = $product;
        $data = Product::find($id);
        $category = Category::all();
        $tabs = ProductTabs::all();
        $product_tabs_map =  ProductTabsMap::where('products_id',$id)->get();
        $choosenTabsId = [];
        foreach ($product_tabs_map as $tab){
            $choosenTabsId[] = $tab->tabs_id;
        }

        $specification = Specification::all();
        $title = self::TITLE;
        $route = self::ROUTE;
        return view(self::FOLDER . '.edit', compact('title', 'route', 'tabs','choosenTabsId', 'category', 'specification', 'data'));
    }

    /**
     * Update the specified resource in storage.
     * @param \Illuminate\Http\Request $request
     * @param \App\Admin\Product       $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product,$id)
    {
        //dd($request);
        $request->validate([
            "title" => "required",
            /*"product_desc" => "required",
            "uses_desc" => "required",*/
            "category_id" => "required|numeric",
            "show" => "required|numeric",
            "images" => "array|max:5",
            "thumbnail" => "image|max:5000",
        ]);


        DB::beginTransaction();

        $product = Product::find($id);
        $product->title = $request->title;
        $product->product_desc = $request->product_desc;
        //$product->uses_desc = $request->uses_desc;
        $product->category_id = $request->category_id;
        $product->show = $request->show;

        if ($request->thumbnail) {
            Storage::disk('public')->delete("$request->thumbnail");
            $logo = Storage::disk('public')->putFile('product/', new File($request->thumbnail));
            $product->logo = $logo;
        }

        $product->save();

        // product tabs
        $product_tabs_map = new ProductTabsMap;
        $product_tabs_map::where('products_id', $id)->delete();
        if ($request->has('tabs')&& is_array($request->tabs)) {
            foreach ($request->tabs as $key => $value) {
                $product_tabs_map = new ProductTabsMap;
                $product_tabs_map->products_id = $product->id;
                $product_tabs_map->tabs_id = $value;
                $product_tabs_map->save();
            }
        }
        //product list
        $product_list = new ProductList();
        $product_list::where('product_id', $product->id)->delete();
        for($i = 0; $i < 20; ++$i) {
            if (!$request->has("product-list-$i")) {
                continue;
            }

            $product_list = new ProductList();
            $product_list->product_id = $product->id;
            $product_list->name = $request->{"product-list-$i"};
            $product_list->save();

            if (!$request->has("product-list-item-$i")) {
                continue;
            }
            foreach($request->toArray()["product-list-item-$i"] as $itemName) {
                $item = new ProductListItems();
                $item->product_list_id = $product_list->id;
                $item->name = $itemName;
                $item->save();
            }

        }
        //////////////
        if ($request->image) {
            $image = FileUploadHelper::upload($request->images, ['*'], "/product");
            $product->image()->createMany($image);
        }

        DB::commit();

        return redirect(self::ROUTE);
    }

    /**
     * Remove the specified resource from storage.
     * @param \App\Admin\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if (!empty($product->image)) {
            foreach ($product->image as $key) {
                Storage::disk('public')->delete("$key->image");
            }
        }
        Storage::disk('public')->delete("$product->logo");
        Product::destroy($product->id);
        return redirect(self::ROUTE);
    }
    public function destroyProduct($id)
    {
        $Product = Product::find($id);
        Product::destroy($Product->id);
        return  redirect(self::ROUTE);
    }

    /**
     * @param $product_id
     * @param $image_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroyImage($product_id, $image_id)
    {
        $product_image = ProductImage::find($image_id);
        Storage::disk('public')->delete("$product_image->image");
        ProductImage::destroy($product_image->id);
        return redirect(self::ROUTE . '/' . $product_id . '/edit');
    }


//    PRODUCT SPECIFICATION PART

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function specification($id)
    {
        $data = ProductSpecification::with('type')->where('product_id', $id)->get();
        $specification = Specification::all();
        $type = SpecificationType::all();
        $title = 'Product Specification';
        $route = self::ROUTE;
        return view(self::FOLDER . '.specification', compact('data', 'id', 'specification', 'type', 'title', 'route'));
    }

    /**
     * @param Request $request
     * @param         $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function specificationStore(Request $request, $id)
    {
        $arr = array();
        $count = 0;

        foreach ($request->data as $key => $val) {
            foreach ($val as $b => $v) {
                if ($v != NULL) {
                    $arr[$count][$b]['product_id'] = $id;
                    $arr[$count][$b]['specification_id'] = $request->specification_id;
                    $arr[$count][$b]['type_id'] = $key;
                    $arr[$count][$b]['name'] = $v;
                    $arr[$count][$b]['created_at'] = Carbon::now();
                    $arr[$count][$b]['updated_at'] = Carbon::now();
                }
            }
            $count++;
        }

        foreach ($arr as $key => $val) {
            $specification = new ProductSpecification;
            $specification->insert($val);
        }

        return redirect(self::ROUTE . "/$id/specification");
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxDelete(Request $request)
    {
        ProductSpecification::destroy($request->id);
        return response()->json(['success' => "Your row has been deleted."], 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxEdit(Request $request)
    {
        $row = ProductSpecification::find($request->id);
        $row->name = $request->input;
        $row->save();

        return response()->json(["success" => "Your row has been changed.", 'name' => $row->name, 'id' => $row->id], 200);
    }

    public function ajaxGet(Request $request)
    {
        $row = ProductSpecification::find($request->id);
        return response()->json(['name' => $row->name, 'id' => $row->id], 200);
    }

//    FEATURED PRODUCT PART

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function featured($id)
    {
        $data = array();
        foreach (ProductFeatur::where('product_id', $id)->get() as $key) {
            $data[] = intval($key->featured_id);
        }
        $data = json_encode($data);
        $products = Product::all();
        $title = 'Featured Product';
        $route = self::ROUTE;
        return view(self::FOLDER . '.featured', compact('data', 'id', 'products', 'title', 'route'));
    }

    /**
     * @param Request $request
     * @param         $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function featuredStore(Request $request, $id)
    {
        $request->validate([
            'featured' => 'required|array|max:5',
        ]);

        $arr = array();
        foreach ($request->featured as $key => $val) {
            $arr[$key]['product_id'] = $id;
            $arr[$key]['featured_id'] = $val;
            $arr[$key]['created_at'] = Carbon::now();
            $arr[$key]['updated_at'] = Carbon::now();
        }

        ProductFeatur::where('product_id', $id)->delete();
        $featured = new ProductFeatur;
        $featured->insert($arr);
        return redirect(self::ROUTE);
    }
}
