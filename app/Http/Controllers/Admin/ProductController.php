<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Category;
use App\Admin\Product;
use App\Admin\ProductImage;
use App\Admin\ProductSpecification;
use App\Admin\Specification;
use App\helpers\FileUploadHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
        $specification = Specification::all();
        $title = self::TITLE;
        $route = self::ROUTE;
        return view(self::FOLDER . '.create', compact('title', 'route', 'category', 'specification'));
    }

    /**
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "title" => "required",
            "product_desc" => "required",
            "uses_desc" => "required",
            "category_id" => "required|numeric",
            "show" => "required|numeric",
            "images" => "required|array|max:5",
        ]);


        $image = FileUploadHelper::upload($request->images, ['*'], "/product");

        DB::beginTransaction();

        $product = new Product;
        $product->title = $request->title;
        $product->product_desc = $request->product_desc;
        $product->uses_desc = $request->uses_desc;
        $product->category_id = $request->category_id;
        $product->show = $request->show;
        $product->save();

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
    public function edit(Product $product)
    {
        $data = $product;
        $category = Category::all();
        $specification = Specification::all();
        $title = self::TITLE;
        $route = self::ROUTE;
        return view(self::FOLDER . '.edit', compact('title', 'route', 'category', 'specification', 'data'));
    }

    /**
     * Update the specified resource in storage.
     * @param \Illuminate\Http\Request $request
     * @param \App\Admin\Product       $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            "title" => "required",
            "product_desc" => "required",
            "uses_desc" => "required",
            "category_id" => "required|numeric",
            "show" => "required|numeric",
            "images" => "array|max:5",
        ]);


        DB::beginTransaction();

        $product->title = $request->title;
        $product->product_desc = $request->product_desc;
        $product->uses_desc = $request->uses_desc;
        $product->category_id = $request->category_id;
        $product->show = $request->show;
        $product->save();

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
        Product::destroy($product->id);
        return redirect(self::ROUTE);
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

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function specification($id)
    {
        $data = ProductSpecification::where('product_id', $id)->get();
        $specification = Specification::all();
        $title = 'Product Specification';
        $route = self::ROUTE;
        return view(self::FOLDER . '.specification', compact('data', 'id','specification', 'title', 'route'));
    }

    public function specificationStore(Request $request, $id)
    {
        $units = json_encode((array)array_filter($request->units, 'strlen'));
        $value = json_encode((array)array_filter($request->value, 'strlen'));
        $tolerance = json_encode((array)array_filter($request->tolerance, 'strlen'));
        $method = json_encode((array)array_filter($request->method, 'strlen'));

        $specification = new ProductSpecification;
        $specification->units = $units;
        $specification->value = $value;
        $specification->tolerance = $tolerance;
        $specification->method = $method;
        $specification->specification_id = $request->specification_id;
        $specification->product_id = $id;
        $specification->save();

        return redirect(self::ROUTE."/$id/specification");
    }


}
