<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Traits\SearchesUsers;

class UserController extends WebController
{
    use SearchesUsers;

    /**
     * Show users
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $queryString = $request->all();

        $users = $this->paginateUsers($queryString);

        return view('users.index', [
            'users' => $users->appends($queryString),
        ]);
    }
}
