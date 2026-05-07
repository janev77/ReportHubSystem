<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Http\Requests\StoreNotificationsRequest;
use App\Http\Requests\UpdateNotificationsRequest;

class AnnouncementsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNotificationsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Announcement $notifications)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Announcement $notifications)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNotificationsRequest $request, Announcement $notifications)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Announcement $notifications)
    {
        //
    }
}
