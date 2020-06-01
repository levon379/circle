<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //Path To the View Folder
    const FOLDER = "site";
    //Resource Title
    const TITLE = "Admin Dashboard";
    //Resource Route
    const ROUTE = "/";

    public function index()
    {
        return view(self::FOLDER.".index");
    }

    public function terms()
    {
        return view(self::FOLDER.".terms");
    }

    public function privacy()
    {
        return view(self::FOLDER.".privacy");
    }
}
