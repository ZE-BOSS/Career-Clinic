<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin_cc;
use App\Models\user_cc;
use App\Models\community;
use App\Models\community_member;
use App\Models\community_chat;
use App\Models\community_chat_image;

class CommunityController extends Controller
{
    public function index()
    {
        $admin_ccs = admin_cc::all()->toArray();
        $user_ccs = user_cc::all()->toArray();
        $communities = community::all()->toArray();
        $community_members = community_member::all()->toArray();
        $community_chats = community_chat::all()->toArray();
        $community_chat_images = community_chat_image::all()->toArray();
        return array_reverse($admin_ccs)
            ->with('user_ccs', $user_ccs)
            ->with('communities', $communities)
            ->with('community_members', $community_members)
            ->with('community_chats', $community_chats)
            ->with('community_chat_images', $community_chat_images); 
    }

    public function createCommunity(Request $request)
    {
 
        $community = new community([
            'user_id' => 1,//refine
            'user_category' => 'admin',
            'name' => $request->input('name'),
            'details' => $request->input('details')
        ]);

        $image_ext = $request->file('image')->getCLientOriginalExtension();
        $community->image =  str_replace('_', '_', rand(11111, 99999)). '_' . date('h_i_s') . '_' . time() . '.' . $image_ext;
        $request->file('image')->move(
            storage_path().'/app/public/image/community/', $community->image 
        );

        $community->save();

        //$admin_cc= admin_cc::create($request);

        return response()->json('Community Created!');
    }

    public function createChat($id, Request $request)
    {
        $community_chat = new community_chat([
            'user_id' => 1,//refine
            'user_category' => 'admin',
            'community_id' => $id,
            'chat' => $request->input('chat'),
            'reply_chat' => $request->input('reply_chat')
        ]);

        $community_chat->save();

        if($request->input('add_file') == 1){
            $community_chat_image = new community_chat_image([
                'user_id' => 1,//refine
                'user_category' => 'admin',
                'chat_id' => $community_chat->id,
                'name' => $request->input('name')
            ]);

            $image_ext = $request->file('file')->getCLientOriginalExtension();
            $community_chat_image->file =  str_replace('_', '_', rand(11111, 99999)). '_' . date('h_i_s') . '_' . time() . '.' . $image_ext;
            $request->file('file')->move(
                storage_path().'/app/public/image/chat/', $community_chat_image->file 
            );
            $community_chat_image->file_type = $request->file('file')->getCLientOriginalExtension();

            $community_chat_image->save();
        }

        return response()->json(1);
    }

    public function createMember($id, Request $request)
    {
        $community_member = new community_member([
            'user_id' => 1,//refine
            'user_category' => 'admin',
            'community_id' => $id
        ]);

        $community_member->save();

        return response()->json(1);
    }

    public function show($id)
    {
        $community = community::find($id);
        $admin_ccs = admin_cc::all()->toArray();
        $user_ccs = user_cc::all()->toArray();
        $community_members = community_member::where('community_id', $id);
        $community_chats = community_chat::where('community_id', $id);
        $community_chat_images = community_chat_image::all();
        return response()->json($admin_ccs)
            ->with('user_ccs', $user_ccs)
            ->with('community', $community)
            ->with('community_members', $community_members)
            ->with('community_chats', $community_chats)
            ->with('community_chat_images', $community_chat_images);
    }

    public function update($id, Request $request)
    {
        
        $community = community::find($id);
 
        $community->update([
            'title' => $request->input('title'),
            'details' => $request->input('details')
        ]);

        $image_ext = $request->file('image')->getCLientOriginalExtension();
        $community->image =  str_replace('_', '_', rand(11111, 99999)). '_' . date('h_i_s') . '_' . time() . '.' . $image_ext;
        $request->file('image')->move(
            storage_path().'/app/public/image/community/', $community->image 
        );

        $community->save();

        //$admin_cc= admin_cc::create($request);

        return response()->json('Community Updated!');
    }

    public function destroy($id)
    {
        $community = community::find($id);

        $community->delete();

        return response()->json('Community Deleted!');
    }

    public function destroyMember($id)
    {
        $community_member = community_member::find($id);

        $community_member->delete();

        return response()->json(1);
    }

    public function destroyChat($id)
    {
        $community_chat = community_chat::find($id);

        $community_chat->delete();

        return response()->json(1);
    }
}
