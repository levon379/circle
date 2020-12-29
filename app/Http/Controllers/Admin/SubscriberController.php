<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin\Subscriber;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SubscriberController extends Controller
{

    const FOLDER = "admin.subscriber";
    const TITLE = "Subscribers";
    const ROUTE = "/admin/subscriber";

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Subscriber::all();
        $title = self::TITLE;
        $route = self::ROUTE;
        return view(self::FOLDER . '.index', compact('title', 'route', 'data'));
    }

    /**
     * Display the specified resource.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Subscriber::find($id);
        $title = self::TITLE;
        $route = self::ROUTE;
        $action = "Show";
        return view(self::FOLDER . '.show', compact('title', 'route', 'data', 'action'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subscriber= Subscriber::find($id);
        $subscriber->delete();

        return redirect(self::ROUTE);
    }
}
