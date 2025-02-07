<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class Login extends Component
{
    public $email = '';
    public $password = '';

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:8',
    ];

    public function login()
    {
        // Validate input
        $this->validate();

        // Attempt to log the user in
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            // Redirect to the intended page or dashboard
            return redirect()->route('me');
        }

        // If login fails, throw an error
        throw ValidationException::withMessages([
            'email' => "Could not sign you in. Please try again",
        ]);
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
