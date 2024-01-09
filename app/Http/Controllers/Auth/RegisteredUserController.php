<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Kreait\Firebase\Exception\Auth\EmailExists as FirebaseEmailExists;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        $user->assignRole('user');

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
    // public function store(Request $request): RedirectResponse
    // {
    //     $request->validate([
    //         // Twoje reguły walidacji
    //     ]);

    //     $firebaseAuth = Firebase::auth();
    //     try {
    //         // Rejestrowanie użytkownika w Firebase
    //         $firebaseUser = $firebaseAuth->createUser([
    //             'email' => $request->email,
    //             'emailVerified' => false,
    //             'password' => $request->password,
    //             'displayName' => $request->name,
    //             'disabled' => false,
    //         ]);

    //         // Rejestrowanie użytkownika w lokalnej bazie danych Laravel
    //         $user = User::create([
    //             'name' => $request->name,
    //             'email' => $request->email,
    //             'password' => Hash::make($request->password),
    //             'firebase_uid' => $firebaseUser->uid, // Przechowuj UID użytkownika Firebase
    //         ]);

    //         event(new Registered($user));

    //         // Przypisywanie roli, logowanie, itp.
    //         $user->assignRole('user');
    //         Auth::login($user);

    //         return redirect(RouteServiceProvider::HOME);
    //     } catch (FirebaseEmailExists $e) {
    //         // Obsługa błędów, np. email już istnieje w Firebase
    //         return redirect()->back()->withErrors(['email' => 'Ten adres email jest już używany.']);
    //     } catch (\Exception $e) {
    //         // Inne błędy
    //         return redirect()->back()->withErrors(['error' => 'Błąd rejestracji: '.$e->getMessage()]);
    //     }
    // }
}
