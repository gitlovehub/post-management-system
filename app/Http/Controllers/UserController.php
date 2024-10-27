<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    const VIEW = 'admin.users.';

    public function index() {
        $data = User::latest('id')->paginate(5);
        return view(self::VIEW.__FUNCTION__, compact('data'));
    }

    public function edit(User $user) {
        return view(self::VIEW.__FUNCTION__, compact('user'));
    }

    public function update(Request $request, User $user) {
        $data = $request->validate([
            'type' => [
                'required',
                'string',
                Rule::in(['admin', 'member'])
            ],
            'is_active' => [
                'nullable',
                Rule::in([0, 1])
            ]
        ]);

        try {
            $data['is_active'] ??= 0;
            
            $user->update($data);
            return redirect()->route('users.index')->with('msg', 'Updated successfully.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('msg', false);
        }
    }
}
