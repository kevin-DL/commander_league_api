<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    public function current(Request $request)
    {
        $params = $request->query();
        $user = $params['user'];
        return response()->json([
            'id' => $user['id'],
            'display_name' => $user['display_name'],
            'picture' => $user['picture'],
        ]);
    }
}
