<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserQuery;

class UserQueryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        UserQuery::create($request->all());

        return redirect()->back()->with('success', 'Your message has been sent!');
    }

    public function index()
    {
        $queries = UserQuery::latest()->get();

        return view('contacts.index', compact('queries'));
    }

    public function show()
    {
        return view('contacts.contact');
    }
}
