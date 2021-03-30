<?php

namespace App\Http\Controllers\Admin;

use App\Admin\OurServices;
use App\Admin\OurServicesList;
use App\Admin\OurServicesListItem;
use App\helpers\FileUploadHelper;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OurServicesController extends Controller
{

    const FOLDER = "admin.our-services";
    const TITLE = "Our Services";
    const ROUTE = "/admin/our-services";

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = OurServices::all();
        $title = self::TITLE;
        $route = self::ROUTE;
        return view(self::FOLDER . '.index', compact('title', 'route', 'data'));
    }


    public function store(Request $request)
    {

        $request->validate([
            "title" => "required",
            "text1" => "required",
            "text2" => "required",
            "thumbnail" => "image|max:5000",
        ]);

        $logo = Storage::disk('public')->putFile('our-services/', new File($request->thumbnail));

        DB::beginTransaction();

        $service = new OurServices;
        $service->title = $request->title;
        $service->text1 = $request->text1;
        $service->text2 = $request->text2;
        $service->logo = $logo;
        if($service->save()) {
            $this->saveServiceList($request, $service);
        }

        DB::commit();

        return redirect(self::ROUTE);
    }

    public function edit(OurServices $product,$id)
    {
        $data = OurServices::find($id);
        $data->load(['our_services_list' => function ($q) {
            $q->orderBy('id', 'asc');
        }]);

        $title = self::TITLE;
        $route = self::ROUTE;
        return view(self::FOLDER . '.edit', compact('title', 'route', 'data'));
    }

    public function update(Request $request, OurServices $product,$id)
    {
        //dd($request);
        $request->validate([
            "title" => "required",
            "text1" => "required",
            "text2" => "required",
            "thumbnail" => "image|max:5000",
        ]);


        DB::beginTransaction();

        $service = OurServices::find($id);
        $service->title = $request->title;
        $service->text1 = $request->text1;
        $service->text2 = $request->text2;

        if ($request->thumbnail) {
            Storage::disk('public')->delete("$request->thumbnail");
            $logo = Storage::disk('public')->putFile('our-services/', new File($request->thumbnail));
            $service->logo = $logo;
        }

        $service->save();

        //product list
        $service_list = new OurServicesList();
        $service_list::where('our_services_id', $service->id)->delete();
        $this->saveServiceList($request, $service);
        //////////////

        DB::commit();

        return redirect(self::ROUTE);
    }

    protected function saveServiceList(Request $request, OurServices $product) {
        if (!$request->has("our-services-list-order")) {
            return;
        }
        $order = $request->{"our-services-list-order"};
        $orderArray = explode(',', $order);
        if (!is_array($orderArray)) {
            $orderArray = [];
        }
        for ($j = 0; $j < count($orderArray); ++$j) {
            $i = $orderArray[$j];
            if (!$request->has("our-services-list-$i")) {
                continue;
            }

            $our_services_list = new OurServicesList();
            $our_services_list->our_services_id = $product->id;
            $our_services_list->name = $request->{"our-services-list-$i"};
//            $our_services_list->description = $request->{"product-desc-$i"};
            $our_services_list->save();

            if (!$request->has("our-services-list-item-$i")) {
                continue;
            }
            foreach($request->toArray()["our-services-list-item-$i"] as $itemName) {
                $item = new OurServicesListItem();
                $item->our_services_list_id = $our_services_list->id;
                $item->name = $itemName;
                $item->save();
            }

        }
    }
}
