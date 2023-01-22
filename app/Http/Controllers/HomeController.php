<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $infos=UserInfo::all();
        return view('home',compact('infos'));
    }

    public function store(Request $request)
    {
        //
        $validator = FacadesValidator::make($request->all(), [
            'website' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails())
        {
            return redirect()->route('home')->withErrors($validator);
        }

        $is_strong = false;
        $password = $request->password;
        if( $password)
        {
            $is_strong = true;
        }

        UserInfo::create([
            'user_id' => auth()->user()->id,
            'website'=>$request->get('website'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'is_strong' => $is_strong
        ]);

               return redirect()->route('home')->with('success', 'Inserted');

    }

    public function edit($id)
    {
        //
        $info=UserInfo::where('id',$id)->first();
        if(auth()->user()->id == $info->user_id )
        {
            return view('edit',compact('info'));

        }
    }

    public function destroy($id)
    {
        UserInfo::where('id',$id)->delete();
        return redirect()->route('home')->with('success', 'Deleted information');
    }

    public function view($id)
    {
        $data = UserInfo::where('id',$id)->first();
        $reviel = $data->password;
        return redirect()->route('home', compact($reviel));
    }
}
