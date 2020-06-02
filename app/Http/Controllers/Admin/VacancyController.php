<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Vacancy;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VacancyController extends Controller
{

    const FOLDER = "admin.vacancy";
    const TITLE = "Vacancies";
    const ROUTE = "/admin/vacancies";

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Vacancy::all();
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
        $title = self::TITLE;
        $route = self::ROUTE;
        $action = "Create";
        return view(self::FOLDER . '.create', compact('title', 'route', 'action'));
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
            "description" => "required",
            "location" => "required",
            "start" => "required",
            "end" => "required",
            "status" => "required",
        ]);

        $vacancy = new Vacancy;
        $vacancy->title = $request->title;
        $vacancy->description = $request->description;
        $vacancy->location = $request->location;
        $vacancy->start = $request->start;
        $vacancy->end = $request->end;
        $vacancy->status = $request->status;
        $vacancy->save();

        return redirect(self::ROUTE);
    }

    /**
     * Display the specified resource.
     * @param \App\Admin\Vacancy $vacancy
     * @return \Illuminate\Http\Response
     */
    public function show(Vacancy $vacancy)
    {
        $data = $vacancy;
        $title = self::TITLE;
        $route = self::ROUTE;
        $action = "Show";
        return view(self::FOLDER . '.show', compact('title', 'route', 'action', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param \App\Admin\Vacancy $vacancy
     * @return \Illuminate\Http\Response
     */
    public function edit(Vacancy $vacancy)
    {
        $data = $vacancy;
        $title = self::TITLE;
        $route = self::ROUTE;
        $action = "Edit";
        return view(self::FOLDER . '.edit', compact('title', 'route', 'action', 'data'));
    }

    /**
     * Update the specified resource in storage.
     * @param \Illuminate\Http\Request $request
     * @param \App\Admin\Vacancy       $vacancy
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vacancy $vacancy)
    {
        $request->validate([
            "title" => "required",
            "description" => "required",
            "location" => "required",
            "start" => "required",
            "end" => "required",
            "status" => "required",
        ]);

        $vacancy->title = $request->title;
        $vacancy->description = $request->description;
        $vacancy->location = $request->location;
        $vacancy->start = $request->start;
        $vacancy->end = $request->end;
        $vacancy->status = $request->status;
        $vacancy->save();

        return redirect(self::ROUTE);
    }

    /**
     * Remove the specified resource from storage.
     * @param \App\Admin\Vacancy $vacancy
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vacancy $vacancy)
    {
        Vacancy::destroy($vacancy->id);
        return redirect(self::ROUTE);
    }
}
