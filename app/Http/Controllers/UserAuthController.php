<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserAuthRequest;
use App\Models\User;
use App\Models\UsersSessions;
use App\Traits\HttpResponses;

class UserAuthController extends Controller
{
    use HttpResponses;

    /**
     * Check for signature and make based on user's presence in the table
     * 
     * @param UserAuthRequest $request
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function user_auth(UserAuthRequest $request)
    {
        $request = $request->validated($request->all());
        $signature = $request['sig'];

        if (mb_strtolower(md5($this->prepareRequestData($request)), 'UTF-8') === $signature) {
            $user = User::find($request['id']);
            if ($user) {
                $user->update([
                    'first_name' => $request['first_name'],
                    'last_name' => $request['last_name'],
                    'country' => $request['country'],
                    'city' => $request['city']
                ]);

                UsersSessions::updateOrCreate(['user_id' => $request['id']], ['access_token' => $request['access_token']]);
            } else {
                User::create([
                    'first_name' => $request['first_name'],
                    'last_name' => $request['last_name'],
                    'country' => $request['country'],
                    'city' => $request['city']
                ]);

                UsersSessions::updateOrCreate(['user_id' => $request['id']], ['access_token' => $request['access_token']]);
            }
            
            return $this->success(
                $request['access_token'],
                [
                    'id' => $request['id'],
                    'first_name' => $request['first_name'],
                    'last_name' => $request['last_name'],
                    'city' => $request['city'],
                    'country' => $request['country']
                ]
            );
        } else {
            return $this->error('Ошибка авторизации в приложении', 'signature error');
        }
    }

    /**
     * Prepare request data for the comparison
     * 
     * @param array $request
     * 
     * @return string
     */
    private function prepareRequestData($request)
    {
        ksort($request);
        unset($request['sig']);
        $str = implode('', array_map(function ($a, $b) { return "$a=$b"; }, 
        array_keys($request), array_values($request)));

        return $str.config('constants.secret_key');
    }
}
