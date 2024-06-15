<?php

namespace App\Http\Controllers;

use App\Err\CustomConstants;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function Authenticate(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'email' => 'required',
            'password' => 'required'
        ]);

        if($validator->fails())
        {

            $fields = $validator->getMessageBag()->keys();

            $message = count($fields) > 1 ? "les champs " . implode(',',input_array_scrawler($fields)) . " sont vides" : "le champ " . implode(',',input_array_scrawler($fields)) . " est vide";

            notify()->error($message);

            return redirect()->back();

        }

        try {

            $credentials = $request->only(['email','password']);

            if(Auth::attempt($credentials))
            {

                return redirect()->route('dashboard');

            }
            else{

                notify()->error(CRENDENTIALS_UN_MATCH);

                return redirect()->back();

            }

        } catch (\Throwable $th) {

            notify()->error($th->getMessage());

            return redirect()->back();

        }

    }

    public function logout(Request $request)
    {

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerate();

        return redirect()->route('login');

    }

}
