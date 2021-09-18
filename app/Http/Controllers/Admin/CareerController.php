<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin_cc;
use App\Models\user_cc;
use App\Models\career_talk_cc;
use App\Models\career_reply_cc;
use App\Models\career_association_cc;
use App\Models\career_share_cc;
use App\Models\career_reply_association_cc;
use App\Models\career_reply_comment_cc;
use App\Models\career_user_feedback_cc;

class CareerController extends Controller
{
    public function index()
    {
        $admin_ccs = admin_cc::all()->toArray();
        $user_ccs = user_cc::all()->toArray();
        $career_talk_ccs = career_talk_cc::all()->toArray();
        $career_reply_ccs = career_reply_cc::all()->toArray();
        $career_association_ccs = career_association_cc::all()->toArray();
        $career_share_ccs = career_share_cc::all()->toArray();
        $career_reply_association_ccs = career_reply_association_cc::all()->toArray();
        $career_reply_comment_ccs = career_reply_comment_cc::all()->toArray();
        $career_user_feedback_ccs = career_user_feedback_cc::all()->toArray();
        return response()->json(['admin_ccs' => $admin_ccs, 
                                    'user_ccs' => $user_ccs, 
                                    'career_talk_ccs' => $career_talk_ccs, 
                                    'career_reply_ccs' => $career_reply_ccs, 
                                    'career_association_ccs' => $career_association_ccs, 
                                    'career_share_ccs' => $career_share_ccs, 
                                    'career_reply_association_ccs' => $career_reply_association_ccs, 
                                    'career_reply_comment_ccs' => $career_reply_comment_ccs, 
                                    'career_user_feedback_ccs' => $career_user_feedback_ccs
                                ]);     
    }

    public function createTalk(Request $request)
    {
        $request->validate([
            'image' => 'required|mimes:jpg,jpeg,png|max:2048',
            'video' => 'required|mimes:mp4,webm|max:2048',
            'gif' => 'required|mimes:gif|max:2048'
         ]);
 
        $career_talk_cc = new career_talk_cc([
            'user_id' => 1,//refine
            'user_category' => 'admin',
            'title' => $request->input('title'),
            'details' => $request->input('details')
        ]);

        $image_ext = $request->file('image')->getCLientOriginalExtension();
        $career_talk_cc->image =  str_replace('_', '_', rand(11111, 99999)). '_' . date('h_i_s') . '_' . time() . '.' . $image_ext;
        $request->file('image')->move(
            storage_path().'/app/public/image/career_talk/', $career_talk_cc->image 
        );

        $video_ext = $request->file('video')->getCLientOriginalExtension();
        $career_talk_cc->video =  str_replace('_', '_', rand(11111, 99999)). '_' . date('h_i_s') . '_' . time() . '.' . $video_ext;
        $request->file('video')->move(
            storage_path().'/app/public/video/career_talk/', $career_talk_cc->video 
        );

        $gif_ext = $request->file('gif')->getCLientOriginalExtension();
        $career_talk_cc->gif =  str_replace('_', '_', rand(11111, 99999)). '_' . date('h_i_s') . '_' . time() . '.' . $gif_ext;
        $request->file('gif')->move(
            storage_path().'/app/public/gif/career_talk/', $career_talk_cc->gif 
        );

        $career_talk_cc->save();

        //$admin_cc= admin_cc::create($request);

        return response()->json('Career Talk Created!');
    }

    public function createAssociation($id, Request $request)
    {
        $career_association_cc = new career_association_cc([
            'user_id' => 1,//refine
            'user_category' => 'admin',
            'career_id' => $id
        ]);

        $career_association_cc->save();

        return response()->json(1);
    }

    public function createReply($id, Request $request)
    {
        $career_reply_cc = new career_reply_cc([
            'user_id' => 1,//refine
            'user_category' => 'admin',
            'career_id' => $id,
            'reply' => $request->input('reply'),
            'link' => $request->input('link')
        ]);

        $career_reply_cc->save();

        return response()->json(1);
    }

    public function createShare($id, Request $request)
    {
        $career_reply_cc = new career_reply_cc([
            'user_id' => 1,//refine
            'user_category' => 'admin',
            'career_id' => $id,
            'platform' => $request->input('platform'),
            'shared_to' => $request->input('shared_to')
        ]);

        $career_reply_cc->save();

        return response()->json(1);
    }

    public function createReplyAssociation($id, Request $request)
    {
        $career_reply_association_cc = new career_reply_association_cc([
            'user_id' => 1,//refine
            'user_category' => 'admin',
            'reply_id' => $id
        ]);

        $career_reply_association_cc->save();

        return response()->json(1);
    }

    public function createReplyComment($id, Request $request)
    {
        $career_reply_comment_cc = new career_reply_comment_cc([
            'user_id' => 1,//refine
            'user_category' => 'admin',
            'reply_id' => $id,
            'reply' => $request->input('reply'),
            'link' => $request->input('link')
        ]);

        $career_reply_comment_cc->save();

        return response()->json(1);
    }

    public function createUserFeedback($id, Request $request)
    {
        $career_user_feedback_cc = new career_user_feedback_cc([
            'user_id' => 1,//refine
            'user_category' => 'admin',
            'career_id' => $request->input('career_id'),
            'reply_id' => $id,
            'feedback' => $request->input('feedback')
        ]);

        $career_user_feedback_cc->save();

        return response()->json(1);
    }

    public function show($id)
    {
        $career_talk_cc = career_talk_cc::find($id);
        $admin_ccs = admin_cc::all()->toArray();
        $user_ccs = user_cc::all()->toArray();
        $career_reply_ccs = career_reply_cc::where('career_id', $id);
        $career_association_ccs = career_association_cc::where('career_id', $id);
        $career_share_ccs = career_share_cc::where('career_id', $id);
        $career_reply_association_ccs = career_reply_association_cc::all()->toArray();
        $career_reply_comment_ccs = career_reply_comment_cc::all()->toArray();
        $career_user_feedback_ccs = career_user_feedback_cc::where('career_id', $id);
        return response()->json(['admin_ccs' => $admin_ccs, 
                                    'user_ccs' => $user_ccs, 
                                    'career_talk_cc' => $career_talk_cc, 
                                    'career_reply_ccs' => $career_reply_ccs, 
                                    'career_association_ccs' => $career_association_ccs, 
                                    'career_share_ccs' => $career_share_ccs, 
                                    'career_reply_association_ccs' => $career_reply_association_ccs, 
                                    'career_reply_comment_ccs' => $career_reply_comment_ccs, 
                                    'career_user_feedback_ccs' => $career_user_feedback_ccs
                                ]);  
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'image' => 'required|mimes:jpg,jpeg,png|max:2048',
            'video' => 'required|mimes:mp4,webm|max:2048',
            'gif' => 'required|mimes:gif|max:2048'
         ]);
        
        $career_talk_cc = career_talk_cc::find($id);
 
        $career_talk_cc->update([
            'title' => $request->input('title'),
            'details' => $request->input('details')
        ]);

        $image_ext = $request->file('image')->getCLientOriginalExtension();
        $career_talk_cc->image =  str_replace('_', '_', rand(11111, 99999)). '_' . date('h_i_s') . '_' . time() . '.' . $image_ext;
        $request->file('image')->move(
            storage_path().'/app/public/image/career_talk/', $career_talk_cc->image 
        );

        $video_ext = $request->file('video')->getCLientOriginalExtension();
        $career_talk_cc->video =  str_replace('_', '_', rand(11111, 99999)). '_' . date('h_i_s') . '_' . time() . '.' . $video_ext;
        $request->file('video')->move(
            storage_path().'/app/public/video/career_talk/', $career_talk_cc->video 
        );

        $gif_ext = $request->file('gif')->getCLientOriginalExtension();
        $career_talk_cc->gif =  str_replace('_', '_', rand(11111, 99999)). '_' . date('h_i_s') . '_' . time() . '.' . $gif_ext;
        $request->file('gif')->move(
            storage_path().'/app/public/gif/career_talk/', $career_talk_cc->gif 
        );

        $career_talk_cc->save();

        //$admin_cc= admin_cc::create($request);

        return response()->json('Career Talk Updated!');
    }

    public function destroy($id)
    {
        $career_talk_cc = career_talk_cc::find($id);

        $career_talk_cc->delete();

        return response()->json('Career Talk Deleted!');
    }
}
