<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserActivateController extends Controller
{
    /**
     * @return Response
     */
    public function activate()
    {
        $validation = $this->validate($this->request, []);

        return $this->getResponse();
    }
}
