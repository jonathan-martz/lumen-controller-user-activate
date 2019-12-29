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
        $validation = $this->validate($this->request, [
            'token' => 'required|string|size:512'
        ]);

        $tokens = DB::table('user_activate_token')->where('token', '=', $this->request->input('token'));

        if ($tokens->count() === 1) {
            $token = $tokens->get()->first();
            $this->addMessage('success', 'Token exists.');

            if (!empty($token->userid)) {
                $count = DB::table('users')->where('id', '=', $token->userid)->count();
                $active = DB::table('users')->where('id', '=', $token->userid)->where('active', '=', '0')->count();
                if ($count === 1) {
                    if ($active === 1) {
                        $update = DB::table('users')->where('id', '=', $token->userid)->update([
                            'active' => '1',
                            'email_verified_at' => DB::raw('CURRENT_TIMESTAMP')
                        ]);

                        if ($update) {
                            $this->addMessage('success', 'User activated now.');

                            DB::table('user_activate_token')
                                ->where('token', '=', $this->request->input('token'))
                                ->delete();
                        } else {
                            $this->addMessage('error', 'Cant update user.');
                        }
                    } else {
                        $this->addMessage('error', 'User already activated.');
                    }

                } else {
                    $this->addMessage('error', 'User doesnt exists.');
                }
            } else {
                $this->addMessage('error', 'User id empty.');
            }
        } else {
            $this->addMessage('error', 'Token doesnt exists.');
        }

        return $this->getResponse();
    }
}
