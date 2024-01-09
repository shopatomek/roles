<?php

namespace App\Http\Controllers;

use Kreait\Firebase\Factory;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Kreait\Laravel\Firebase\Facades\Firebase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Kreait\Firebase\Exception\Auth\EmailExists as FirebaseEmailExists;
use Kreait\Firebase\Exception\Auth\FailedToVerifyToken;
use Kreait\Firebase\ServiceAccount;

class FirebaseAuthController extends Controller
{
    protected $auth;
    protected $database;

    public function __construct()
    {
        // Load Firebase service account JSON file
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'firebase_credentials2.json');

        // Initialize Firebase
        $firebase = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->create();

        // Get the Firebase Realtime Database instance
        $this->database = $firebase->getDatabase();
    }

    public function createCustomToken()
    {
        $uid = 'some-uid';
        try {
            $customToken = $this->auth->createCustomToken($uid);
            return response()->json(['token' => $customToken->toString()]);
        } catch (\Exception $e) {
            Log::error('Error creating custom token: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function verifyIdToken($idTokenString)
    {
        try {
            $verifiedIdToken = $this->auth->verifyIdToken($idTokenString);
            $uid = $verifiedIdToken->claims()->get('sub');
            $user = $this->auth->getUser($uid);
            return response()->json(['user' => $user]);
        } catch (FailedToVerifyToken $e) {
            Log::error('The token is invalid: ' . $e->getMessage());
            return response()->json(['error' => 'Invalid token'], 400);
        }
    }

    public function sendJsonToFirebase(Request $request)
    {
        try {
            // Tworzymy referencję do kolekcji w bazie Firebase
            $collectionReference = Firebase::firestore()->collection('my_collection');

            // Tworzymy nowy dokument w kolekcji
            $newDocument = $collectionReference->newDocument();

            // Tworzymy dane JSON do wysłania
            $jsonData = [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'message' => 'Hello, Firebase!',
            ];

            // Zapisujemy dane JSON do dokumentu
            $newDocument->set($jsonData);

            Log::info('JSON sent to Firebase successfully');

            return response()->json(['message' => 'JSON sent to Firebase successfully']);
        } catch (\Exception $e) {
            Log::error('Error sending JSON to Firebase: ' . $e->getMessage());

            return response()->json(['error' => 'Failed to send JSON to Firebase'], 500);
        }
    }


}






//     public function register(Request $request)
//     {
//         $request->validate([
//             'name' => 'required|string|max:255',
//             'email' => 'required|string|email|max:255|unique:users',
//             'password' => 'required|string|min:6|confirmed',
//         ]);

//         // Rejestracja użytkownika w Firebase
//         $firebaseUser = $this->auth->createUser([
//             'email' => $request->email,
//             'emailVerified' => false,
//             'password' => $request->password,
//             'disabled' => false,
//         ]);


//         // Rejestracja użytkownika w lokalnej bazie danych
//         $user = User::create([
//             'name' => $request->name,
//             'email' => $request->email,
//             'password' => Hash::make($request->password),
//             'firebase_uid' => $firebaseUser->uid,
//         ]);

//         // Przypisanie roli 'user'
//         $user->assignRole('user');

//         return response()->json(['user' => $user], 201);


//     }

//     // Tutaj możesz dodać inne metody, np. login, logout, itp.
// }

