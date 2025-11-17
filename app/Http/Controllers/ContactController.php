<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function send(Request $request)
    {
        // Handle contact form submission
        // For now, just redirect back with success
        return back()->with('success', 'Thank you for your message!');
    }
}