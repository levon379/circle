<?php

namespace App\Http\Controllers\Admin;

use App\Admin\ContactMain;
use App\Http\Controllers\Controller;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContactMainController extends Controller
{


    const CONTACT_FOLDER = "admin.contact-main";
    const CONTACT_TITLE = "Contact Main";
    const CONTACT_ROUTE = "/admin/contact-main";

    /******************** Contact Main Start  ****************/
    public function contactMain()
    {
        $data = ContactMain::all();
        $title = self::CONTACT_TITLE;
        $route = self::CONTACT_ROUTE;
        return view(self::CONTACT_FOLDER . '.index', compact('title', 'route', 'data'));
    }

    public function contactMainEdit($id)
    {
        $data = ContactMain::find($id);
        $title = self::CONTACT_TITLE;
        $route = self::CONTACT_ROUTE;
        $action = "Edit";
        return view(self::CONTACT_FOLDER . '.edit', compact('title', 'route', 'action', 'data'));
    }

    public function contactMainStore(Request $request, $id)
    {
        $request->validate([
//            'title' => 'required|max:191',
            'path' => 'image'
        ]);

        $contact = ContactMain::find($id);
//        $contact->title = $request->title;

        if ($request->path) {
            Storage::disk('public')->delete($contact->path);
            $path = Storage::disk('public')->putFile('contact-main', new File($request->path));
            $contact->path = $path;
        }

        $contact->save();

        return redirect(self::CONTACT_ROUTE);
    }
    /******************** Contact Main End ****************/
}
