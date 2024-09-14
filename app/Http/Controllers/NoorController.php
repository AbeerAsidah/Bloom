<?php

namespace App\Http\Controllers;

use App\Models\Noor;
use Illuminate\Http\Request;

class NoorController extends Controller
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Noor $noor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Noor $noor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Noor $noor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Noor $noor)
    {
        //
    }

    // public function createClient()
    // {
    //     $client = new Client();
    //     $client->user_id = null; 
    //     $client->name = 'New Client Name'; 
    //     $client->redirect = 'http://your-callback-url.com'; 
    //     $client->personal_access_client = false;
    //     $client->password_client = false;
    //     $client->confidential = true;
    //     $client->save();

    //     return response()->json([
    //         'client_id' => $client->id,
    //         'client_secret' => $client->plainSecret,
    //     ]);
    // }

}
