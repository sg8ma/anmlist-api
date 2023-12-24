<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function list(Request $request)
    {
        $users = (new User())->list();
        return response()->json($users);
    }

    public function read(Request $request, $id)
    {
        $user = (new User())->read($id);
        return response()->json($user);
    }

    public function create(Request $request)
    {
        $user = (new User())->create();
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $user = (new User())->list($id);
        return response()->json($user);
    }

    public function delete(Request $request, $id)
    {
        $user = (new User())->list($id);
        return response()->json($user);
    }
}
