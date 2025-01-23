<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;

use Livewire\Component;

class Navbar extends Component
{

    public function render()
    {
        $user = auth()->user();
        return view('livewire.navbar', compact('user'));
    }
    public function isActive($route)
    {
        return request()->routeIs($route) ? 'text-blue-500' : '';
    }
    public function logout()
    {
        Auth::logout();

        return redirect()->route('login');
    }
}
