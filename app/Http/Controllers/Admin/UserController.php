<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\user_cc;
use App\Models\socials;
use App\Models\post_category;
use Hash;

class UserController extends Controller
{
    public function index()
    {
        $user_ccs = user_cc::all()->toArray();
        $socials = socials::all()->toArray();
        $post_categories = post_category::all()->toArray();
        return response()->json([
            'socials' => $socials, 
            'user_ccs' => $user_ccs, 
            'post_categories' => $post_categories, 
        ]);  
    }

    public function store(Request $request)
    {
        $user_cc = new user_cc([
            'first_name' => $request->input('first_name'),
            'middle_name' => $request->input('middle_name'),
            'last_name' => $request->input('last_name'),
            'user_name' => $request->input('user_name'),
            'dob' => $request->input('dob'),
            'city' => $request->input('city'),
            'state' => $request->input('state'),
            'country' => $request->input('country'),
            'address' => $request->input('address'),
            'user_type' => 'user',
            'account_type' => $request->input('account_type'),
            'work_status' => $request->input('work_status'),
            'phone_1' => $request->input('phone_1'),
            'phone_2' => $request->input('phone_2'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'remember_token' => rand(111111111, 999999999)
        ]);

        if($request->hasFile('photo') && $request->hasFile('background')){
            $photo = $request->file('photo');
            $photo_ext = $photo->getCLientOriginalExtension();
            $user_cc->photo =  str_replace('_', '_', rand(11111, 99999)). '_' . date('h_i_s') . '_' . time() . '.' . $photo_ext;
            $photo->move(storage_path().'/app/public/user/image/', $user_cc->photo);
            
            $background = $request->file('background');
            $background_ext = $background->getCLientOriginalExtension();
            $user_cc->background =  str_replace('_', '_', rand(11111, 99999)). '_' . date('h_i_s') . '_' . time() . '.' . $background_ext;
            $background->move(storage_path().'/app/public/user/image/', $user_cc->background);
        }

        $user_cc->save();

        $nums = $request->input('no_icon');
        $icons = $request->input('icon');
        $names = $request->input('name');
        $links = $request->input('link');
        $i_names = $request->input('icon_name');

        if($nums != ''){
            if(count($nums) > 0){
                for ($i=0; $i < count($nums); $i++) { 
                    $socials = new socials([
                        'user_id' => $user_cc->id,
                        'user_category' => 'user',
                        'icon_name' => $i_names[$i],
                        'icon' => $icons[$i],
                        'name' => $names[$i],
                        'link' => $links[$i]
                    ]);

                    $socials->save();
                }
            }
        }
        //$user_cc= user_cc::create($request);

        return response()->json('User Created!');
    }

    public function show($id)
    {
        $user_cc = user_cc::find($id);
        $social = socials::where('user_id', $id)->where('user_category', 'user');
        return response()->json($user_cc)
            ->with('social', $social);
    }

    public function update($id, Request $request)
    {
        $user_cc = user_cc::find($id);
        $social = socials::where('user_id', $id)->where('user_category', 'user');
        $user_cc->update([
            'first_name' => $request->input('first_name'),
            'middle_name' => $request->input('middle_name'),
            'last_name' => $request->input('last_name'),
            'user_name' => $request->input('user_name'),
            'dob' => $request->input('dob'),
            'city' => $request->input('city'),
            'state' => $request->input('state'),
            'country' => $request->input('country'),
            'address' => $request->input('address'),
            'user_type' => $request->input('user_type'),
            'account_type' => $request->input('account_type'),
            'work_status' => $request->input('work_status'),
            'phone_1' => $request->input('phone_1'),
            'phone_2' => $request->input('phone_2'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'remember_token' => rand(111111111, 999999999)
        ]);

        $social->update([
            'icon_name' => $request->input('icon_name'),
            'icon' => $request->input('icon'),
            'name' => $request->input('name'),
            'link' => $request->input('link')
        ]);

        //$user_cc->update($request->all());

        return response()->json('User updated!');
    }

    public function destroy($id)
    {
        $user_cc = user_cc::find($id);
        $social = socials::where('user_id', $id)->where('user_category', 'user');
        $authorisation_cc = authorisation_cc::where('user_id', $id);
        $user_cc->delete();
        $social->delete();
        $authorisation_cc->delete();

        return response()->json('User deleted!');
    }

    public function __construct()     
    { 
        //$this->middleware('guest:user', ['except' => ['logout'], ['/']]);
    }

    function login(Request $request)
    {
     //return true;
        // $this->validate($request, [
        //   'username'   => 'required',
        //   'password'  => 'required'
        // ]);

        // if(Auth::guard('user')->attempt(['username' => $request->username, 'password' => $request->password], $request->remember)){
        //     return redirect()->intended(route('dashboard'));
        // }

        // return redirect()->back()
        //     ->withInput($request->only('username', 'remember'))
        //     ->with('error', 'Wrong Login Details!');
    }

    function logout()
    {
        // Auth::guard('user')->logout();
        // return redirect()->route('login');
    }

    public function resetPasswordVerify(Request $request)
    {
        $email = $request->input('email');
        $user_cc = user_cc::where('email', $email);
        //$user_cc
    }

    public function resetPassword(Request $request)
    {
        $email = $request->input('email');
        $user_cc = user_cc::where('email', $email);
        $user_cc->update([
            'password' => $request->input('password')
        ]);
    }
}
