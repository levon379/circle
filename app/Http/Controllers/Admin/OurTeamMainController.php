<?php

namespace App\Http\Controllers\Admin;

use App\Admin\OurTeamMain;
use App\Http\Controllers\Controller;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OurTeamMainController extends Controller
{


    const TEAM_FOLDER = "admin.team-main";
    const TEAM_TITLE = "Our Team Main";
    const TEAM_ROUTE = "/admin/our-team-main";

    /******************** TEAM Main Start  ****************/
    public function teamMain()
    {
        $data = OurTeamMain::all();
        $title = self::TEAM_TITLE;
        $route = self::TEAM_ROUTE;
        return view(self::TEAM_FOLDER . '.index', compact('title', 'route', 'data'));
    }

    public function teamMainEdit($id)
    {
        $data = OurTeamMain::find($id);
        $title = self::TEAM_TITLE;
        $route = self::TEAM_ROUTE;
        $action = "Edit";
        return view(self::TEAM_FOLDER . '.edit', compact('title', 'route', 'action', 'data'));
    }

    public function teamMainStore(Request $request, $id)
    {
        $request->validate([
//            'title' => 'required|max:191',
            'path' => 'image'
        ]);

        $team = OurTeamMain::find($id);
//        $contact->title = $request->title;

        if ($request->path) {
            Storage::disk('public')->delete($team->path);
            $path = Storage::disk('public')->putFile('team-main', new File($request->path));
            $team->path = $path;
        }

        $team->save();

        return redirect(self::TEAM_ROUTE);
    }
    /******************** TEAM Main End ****************/
}
