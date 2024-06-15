<?php

namespace App\Http\Controllers;

use App\Err\CustomConstants;
use App\Models\Command;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(auth()->user()->id);

        $commands = null;

        if(auth()->user()->role_id == 2)
        {
            $commands = $user->r_commands;
        }
        else{
            $commands = $user->commands;
        }

        return view('dashboard.command.manage',compact('commands'));
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
            'driver' => 'required',
        ]);

        if($validator->fails())
        {

            $fields = $validator->getMessageBag()->keys();

            $message = count($fields) > 1 ? "les champs " . implode(',',input_array_scrawler($fields)) . " sont vides" : "le champ " . implode(',',input_array_scrawler($fields)) . " est vide";

            notify()->error($message);

            return redirect()->route('dashboard');

        }

        try {

            if(auth()->user()->role_id == 1)
            {

                notify()->error('Vous ne pouvez pas commander, vous êtes un chauffeur');

                return redirect()->back();

            }

            $check = Command::where('user_id',auth()->user()->id)->where('driver',$request->driver)->whereDate('created_at',now()->format("Y-m-d"))->get();

            if(count($check) > 0)
            {

                notify()->error('Vous ne pouvez plus commander auprès du même chauffeur');

                return redirect()->back();

            }

            $command = new Command;

            $command->user_id = auth()->user()->id;
            $command->driver = $request->driver;

            $command->save();

            notify()->success('Commande passée avec succès');

            return redirect()->route('command.index');

        } catch (\Throwable $th) {

            notify()->error($th->getMessage());

            return redirect()->route('command.index');

        }

    }

    public function render_with_position()
    {

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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Command $command)
    {

        try {

            $command->delete();

            notify()->success('Commande annulée');

            return redirect()->back();

        } catch (\Throwable $th) {

            notify()->error($th->getMessage());

            return redirect()->route('command.index');

        }

    }
}
