<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\admin_cc;
use App\Models\user_cc;
use App\Models\socials;
use App\Models\authorisation_cc;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\post_category;
use Hash;

class AdminController extends Controller
{
    public function index()
    {
        $admin_ccs = admin_cc::all()->toArray();
        $user_ccs = user_cc::all()->toArray();
        $socials = socials::all()->toArray();
        $authorisation_ccs = authorisation_cc::all()->toArray();
        $post_categories = post_category::all()->toArray();
        return response()->json(['admin_ccs' => $admin_ccs,
                                    'socials' => $socials, 
                                    'authorisation_ccs' => $authorisation_ccs, 
                                    'post_categories' => $post_categories,
                                ]);     
    }

    public function dashboard()
    {
        $admin_ccs = admin_cc::all()->toArray();
        $user_ccs = user_cc::all()->toArray();
        $socials = socials::all()->toArray();
        $authorisation_ccs = authorisation_cc::all()->toArray();
        return response()->json(['admin_ccs' => $admin_ccs, 
                                    'user_ccs' => $user_ccs, 
                                    'socials' => $socials, 
                                    'authorisation_ccs' => $authorisation_ccs, 
                                ]);        
    }

    public function store(Request $request)
    {
        $admin_cc = new admin_cc([
            'first_name' => $request->input('first_name'),
            'middle_name' => $request->input('middle_name'),
            'last_name' => $request->input('last_name'),
            'user_name' => $request->input('user_name'),
            'dob' => $request->input('dob'),
            'city' => $request->input('city'),
            'state' => $request->input('state'),
            'country' => $request->input('country'),
            'address' => $request->input('address'),
            'user_type' => 'admin',
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
            $admin_cc->photo =  str_replace('_', '_', rand(11111, 99999)). '_' . date('h_i_s') . '_' . time() . '.' . $photo_ext;
            $photo->move(storage_path().'/app/public/admin/image/', $admin_cc->photo);
            
            $background = $request->file('background');
            $background_ext = $background->getCLientOriginalExtension();
            $admin_cc->background =  str_replace('_', '_', rand(11111, 99999)). '_' . date('h_i_s') . '_' . time() . '.' . $background_ext;
            $background->move(storage_path().'/app/public/admin/image/', $admin_cc->background);
        }

        $admin_cc->save();

        $nums = $request->input('no_icon');
        $icons = $request->input('icon');
        $names = $request->input('name');
        $links = $request->input('link');
        $i_names = $request->input('icon_name');

        if(count($nums) > 0){
            for ($i=0; $i < count($nums); $i++) { 
                $socials = new socials([
                    'user_id' => $admin_cc->id,
                    'user_category' => 'admin',
                    'icon_name' => $i_names[$i],
                    'icon' => $icons[$i],
                    'name' => $names[$i],
                    'link' => $links[$i]
                ]);

                $socials->save();
            }
        }

        //$user_cc= user_cc::create($request);

        return response()->json('Admin Created!');
    }

    public function show($id)
    {
        $admin_cc = admin_cc::find($id);
        $social = socials::where('user_id', $id)->where('user_category', 'admin');
        $authorisation_cc = authorisation_cc::where('admin_id', $id);
        return response()->json(['admin_cc' => $admin_cc,
                                    'social' => $social, 
                                    'authorisation_cc' => $authorisation_cc, 
                                ]); 
    }

    public function update($id, Request $request)
    {
        $admin_cc = admin_cc::find($id);
        $social = socials::where('user_id', $id)->where('user_category', 'admin');
        $authorisation_cc = authorisation_cc::where('admin_id', $id);
        $admin_cc->update([
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

        $authorisation_cc->update([
            'allocation' => $request->input('allocation')
        ]);

        //$admin_cc->update($request->all());

        return response()->json('Admin updated!');
    }

    public function destroy($id)
    {
        $admin_cc = admin_cc::find($id);
        $social = socials::where('user_id', $id)->where('user_category', 'admin');
        $authorisation_cc = authorisation_cc::where('admin_id', $id);
        $admin_cc->delete();
        $social->delete();
        $authorisation_cc->delete();

        return response()->json('Admin deleted!');
    }

    function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);
    
        $user = admin_cc::where('email', $request->email)->first();
    
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
    
        return $user->createToken($request->device_name)->plainTextToken;
    }
    
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['msg' => 'Logout Succesful!']);
    }
}
