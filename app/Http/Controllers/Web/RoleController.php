<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Traits\SearchesRoles;

class RoleController extends WebController
{
    use SearchesRoles;

    /**
     * Show roles
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $queryString = $request->all();

        $roles = $this->paginateRoles($queryString);

        return view('roles.index', [
            'roles' => $roles->appends($queryString),
        ]);
    }
}
