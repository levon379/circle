<?php

namespace App\Http\Controllers\Admin;

use App\Admin\RequestQuoteMain;
use App\Http\Controllers\Controller;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RequestQuoteMainController extends Controller
{


    const QUOTE_FOLDER = "admin.quote-main";
    const QUOTE_TITLE = "Quote Main";
    const QUOTE_ROUTE = "/admin/quote-main";

    /******************** Quote Main Start  ****************/
    public function quoteMain()
    {
        $data = RequestQuoteMain::all();
        $title = self::QUOTE_TITLE;
        $route = self::QUOTE_ROUTE;
        return view(self::QUOTE_FOLDER . '.index', compact('title', 'route', 'data'));
    }

    public function quoteMainEdit($id)
    {
        $data = RequestQuoteMain::find($id);
        $title = self::QUOTE_TITLE;
        $route = self::QUOTE_ROUTE;
        $action = "Edit";
        return view(self::QUOTE_FOLDER . '.edit', compact('title', 'route', 'action', 'data'));
    }

    public function quoteMainStore(Request $request, $id)
    {
        $request->validate([
//            'title' => 'required|max:191',
            'path' => 'image'
        ]);

        $quote = RequestQuoteMain::find($id);
//        $quote->title = $request->title;

        if ($request->path) {
            Storage::disk('public')->delete($quote->path);
            $path = Storage::disk('public')->putFile('quote-main', new File($request->path));
            $quote->path = $path;
        }

        $quote->save();

        return redirect(self::QUOTE_ROUTE);
    }
    /******************** Quote Main End ****************/
}
