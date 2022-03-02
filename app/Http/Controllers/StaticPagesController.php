<?php

namespace App\Http\Controllers;

class StaticPagesController extends Controller
{
    /**
     * Display the public welcome page.
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        return view('welcome');
    }

    /**
     * Display the collection for logged in users.
     *
     * @return \Illuminate\Http\Response
     */
    public function collection()
    {
        return view('collection');
    }
}
