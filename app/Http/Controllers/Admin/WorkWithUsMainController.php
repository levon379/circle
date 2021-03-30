<?php

namespace App\Http\Controllers\Admin;

use App\Admin\WorkWithUsMain;
use App\Http\Controllers\Controller;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WorkWithUsMainController extends Controller
{


    const WORK_FOLDER = "admin.work-with-us-main";
    const WORK_TITLE = "Work With Us Main";
    const WORK_ROUTE = "/admin/work-with-us-main";

    /******************** WORK Main Start  ****************/
    public function withUsMain()
    {
        $data = WorkWithUsMain::all();
        $title = self::WORK_TITLE;
        $route = self::WORK_ROUTE;
        return view(self::WORK_FOLDER . '.index', compact('title', 'route', 'data'));
    }

    public function workWithUsMainEdit($id)
    {
        $data = WorkWithUsMain::find($id);
        $title = self::WORK_TITLE;
        $route = self::WORK_ROUTE;
        $action = "Edit";
        return view(self::WORK_FOLDER . '.edit', compact('title', 'route', 'action', 'data'));
    }

    public function workWithUsMainStore(Request $request, $id)
    {
        $request->validate([
//            'title' => 'required|max:191',
            'path' => 'image'
        ]);

        $team = WorkWithUsMain::find($id);
//        $contact->title = $request->title;

        if ($request->path) {
            Storage::disk('public')->delete($team->path);
            $path = Storage::disk('public')->putFile('work-with-us-main', new File($request->path));
            $team->path = $path;
        }

        $team->save();

        return redirect(self::WORK_ROUTE);
    }
    /******************** TEAM Main End ****************/
}
