<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $admins = User::where('role', 'admin')->count();
        $professors = User::where('role', 'professor')->count();
        $students = User::where('role', 'student')->count();

        return view('admin.dashboard', compact('totalUsers', 'admins', 'professors', 'students'));
    }

    public function createProfessor()
    {
        return view('admin.create-professor');
    }

    public function storeProfessor(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role' => 'professor',
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Professeur créé avec succès !');
    }

    public function createStudent()
    {
        return view('admin.create-student');
    }

    public function storeStudent(Request $request)
    {
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'filiere_id' => 'required|exists:filieres,id',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        \Illuminate\Support\Facades\DB::transaction(function () use ($validatedData) {
            $user = User::create([
                'name' => $validatedData['prenom'] . ' ' . $validatedData['nom'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'role' => 'student',
            ]);

            \App\Models\Etudiant::create([
                'nom' => $validatedData['nom'],
                'prenom' => $validatedData['prenom'],
                'email' => $validatedData['email'],
                'filiere_id' => $validatedData['filiere_id'],
                'user_id' => $user->id,
            ]);
        });

        return redirect()->route('admin.dashboard')
            ->with('success', 'Compte étudiant et profil académique créés avec succès !');
    }

    public function usersList()
    {
        $users = User::orderBy('role')->orderBy('name')->get();
        return view('admin.users-list', compact('users'));
    }
}
