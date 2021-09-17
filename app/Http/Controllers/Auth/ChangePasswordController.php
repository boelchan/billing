<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ChangePasswordController extends Controller
{
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
        return view('auth.passwords.change-password');
    } 
   
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function change(Request $request)
    {
        $validator = Validator::make(
            $request->all(), 
            [
                'current_password' => ['required', new MatchOldPassword],
                'new_password' => ['required'],
                'new_confirm_password' => ['same:new_password']
            ],
        );

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->getMessageBag()->toArray(),
            ], 400);
        }
   
        $user = User::findorFail(Auth::id());
        $user->password = Hash::make($request->new_password);
        $user->save();

        Auth::logout();
   
        return response()->json([
            'success'  => true,
            'message'  => 'Password berhasil diperbarui',
            'redirect' => route('login')
        ]);
    }
}
