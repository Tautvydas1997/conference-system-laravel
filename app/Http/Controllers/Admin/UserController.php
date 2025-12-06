<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $users = $this->userService->all();
        
        return view('admin.users.index', [
            'users' => $users,
        ]);
    }

    public function edit($id)
    {
        $user = $this->userService->find($id);
        
        if (!$user) {
            return redirect()->route('admin.users.index')->with('error', 'Naudotojas nerastas');
        }
        
        return view('admin.users.edit', [
            'user' => $user,
        ]);
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $user = $this->userService->update($id, $request->validated());
        
        if (!$user) {
            return redirect()->route('admin.users.index')->with('error', 'Naudotojas nerastas');
        }
        
        return redirect()->route('admin.users.index')->with('success', __('users.updated_success'));
    }
}

