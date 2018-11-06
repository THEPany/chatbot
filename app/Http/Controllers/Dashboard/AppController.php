<?php

namespace InitSoftBot\Http\Controllers\Dashboard;

use InitSoftBot\App;
use Illuminate\Http\Request;
use InitSoftBot\Http\Controllers\Controller;
use InitSoftBot\Http\Requests\Dashboard\StoreAppRequest;

class AppController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apps = auth()->user()->apps()->paginate();

        return view('dashboard.app.index')->with([
            'apps' => $apps
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \InitSoftBot\Http\Requests\Dashboard\StoreAppRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAppRequest $request)
    {
        return response()->json(['data' => $request->createApp()], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \InitSoftBot\App  $app
     * @return \Illuminate\Http\Response
     */
    public function show(App $app)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \InitSoftBot\App  $app
     * @return \Illuminate\Http\Response
     */
    public function edit(App $app)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \InitSoftBot\App  $app
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, App $app)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \InitSoftBot\App  $app
     * @return \Illuminate\Http\Response
     */
    public function destroy(App $app)
    {
        //
    }
}
