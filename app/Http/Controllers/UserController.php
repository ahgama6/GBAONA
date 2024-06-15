<?php

namespace App\Http\Controllers;

use App\Err\CustomConstants;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'email' => 'required',
            'password' => 'required',
            'role_id' => 'required',
            'name' => 'required',
            'surname' => 'required'
        ]);

        if($validator->fails())
        {

            $fields = $validator->getMessageBag()->keys();

            $message = count($fields) > 1 ? "les champs " . implode(',',input_array_scrawler($fields)) . " sont vides" : "le champ " . implode(',',input_array_scrawler($fields)) . " est vide";

            notify()->warning($message);

            return redirect()->back();

        }

        try {

            if($request->password == $request->confirmation)
            {

                notify()->warning(USER_PASSWORD_CONFORMITY);

                return redirect()->back();

            }

            $user = new User();
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role_id = $request->role_id;
            $user->name = $request->name;
            $user->surname = $request->surname;

            if($user->save())
            {

                notify()->success(USER_CREATED);

                return redirect()->back();

            }
            else{

                notify()->error(USER_OP_ERR);

                return redirect()->back();

            }

        } catch (\Throwable $th) {

            notify()->error($th->getMessage());

            // notify()->error(E_USER);

            return redirect()->back();

        }

    }

    public function add_localization(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'longitude' => 'required',
            'latitude' => 'required',
        ]);

        if($validator->fails())
        {

            $fields = $validator->getMessageBag()->keys();

            $message = count($fields) > 1 ? "les champs " . implode(',',input_array_scrawler($fields)) . " sont vides" : "le champ " . implode(',',input_array_scrawler($fields)) . " est vide";

            notify()->warning($message);

            return redirect()->back();

        }

        try {

            $user = User::find(auth()->user()->id);

            $user->update([
                "longitude"  => $request->longitude,
                'latitude' => $request->latitude
            ]);

            notify()->success("Coordonnées ajoutées avec succès");

            return redirect()->back();

        } catch (\Throwable $th) {

            notify()->error($th->getMessage());

            // notify()->error(E_USER);

            return redirect()->back();

        }

    }

    public function change_password(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'old' => 'required',
            'new' => 'required',
        ]);

        if($validator->fails())
        {

            $fields = $validator->getMessageBag()->keys();

            $message = count($fields) > 1 ? "les champs " . implode(',',input_array_scrawler($fields)) . " sont vides" : "le champ " . implode(',',input_array_scrawler($fields)) . " est vide";

            notify()->warning($message);

            return redirect()->back();

        }

        try {

            if(!Hash::check($request->old, Auth::user()->password))
            {

                notify()->warning("Mot de passe actuel incorrect");

                return redirect()->back();

            }

            $user = User::find(auth()->user()->id);
            $user->password = Hash::make($request->new);

            if($user->save())
            {

                notify()->success("Mot de passe mis à jour avec succès");

                return redirect()->back();

            }
            else{

                notify()->error(USER_OP_ERR);

                return redirect()->back();

            }

        } catch (\Throwable $th) {

            notify()->error($th->getMessage());

            // notify()->error(E_USER);

            return redirect()->back();

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {

        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required',
        ]);

        if($validator->fails())
        {

            $fields = $validator->getMessageBag()->keys();

            $message = count($fields) > 1 ? "les champs " . implode(',',input_array_scrawler($fields)) . " sont vides" : "le champ " . implode(',',input_array_scrawler($fields)) . " est vide";

            return response()->json([
                'status' => CustomConstants::$FunctionalError,
                "text" => $message
            ],200);

        }

        try {

            if($request->has('reset_password'))
            {

                $user->update([
                    'name' => $request->name,
                    'surname' => $request->surname,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role_id' => $request->role_id,
                ]);

            }
            else{

                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'role_id' => $request->role_id
                ]);

            }

            return response()->json([
                "status" => CustomConstants::$Success,
                "text" => USER_UPDATED
            ],200);

        } catch (\Throwable $th) {

            return response()->json([
                "status" => CustomConstants::$TreatmentError,
                "text" => $th->getMessage()
            ],200);

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {

        try {

            $user->delete();

            return response()->json([
                "status" => CustomConstants::$Success,
                "text" => USER_DELETED
            ],200);

        } catch (\Throwable $th) {

            return response()->json([
                "status" => CustomConstants::$TreatmentError,
                "text" => $th->getMessage()
            ],200);

        }

    }
}
