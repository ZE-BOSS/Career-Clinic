<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin_cc;
use App\Models\user_cc;
use App\Models\question_post_cc;
use App\Models\question_img_cc;
use App\Models\question_association_cc;
use App\Models\question_reply_cc;
use App\Models\question_share_cc;
use App\Models\question_reply_img_cc;
use App\Models\question_reply_association_cc;
use App\Models\question_reply_comment_cc;
use App\Models\question_reply_rating;
use App\Models\question_user_feedback_cc;
use App\Models\question_reply_comment_img_cc;
use App\Models\post_category;
use Illuminate\Validation\ValidationException;

class PostController extends Controller
{
    public function index()
    {
        $admin_ccs = admin_cc::all()->toArray();
        $user_ccs = user_cc::all()->toArray();
        $question_post_ccs = question_post_cc::all()->toArray();
        $question_img_ccs = question_img_cc::all()->toArray();
        $question_association_ccs = question_association_cc::all()->toArray();
        $question_reply_ccs = question_reply_cc::all()->toArray();
        $question_share_ccs = question_share_cc::all()->toArray();
        $question_reply_img_ccs = question_reply_img_cc::all()->toArray();
        $question_reply_association_ccs = question_reply_association_cc::all()->toArray();
        $question_reply_comment_ccs = question_reply_comment_cc::all()->toArray();
        $question_reply_ratings = question_reply_rating::all()->toArray();
        $question_user_feedback_ccs = question_user_feedback_cc::all()->toArray();
        $question_reply_comment_img_ccs = question_reply_comment_img_cc::all()->toArray();
        
        return response()->json(['admin_ccs' => $admin_ccs, 
                                    'user_ccs' => $user_ccs, 
                                    'question_post_ccs' => $question_post_ccs, 
                                    'question_img_ccs' => $question_img_ccs, 
                                    'question_association_ccs' => $question_association_ccs, 
                                    'question_reply_ccs' => $question_reply_ccs, 
                                    'question_share_ccs' => $question_share_ccs, 
                                    'question_reply_img_ccs' => $question_reply_img_ccs, 
                                    'question_reply_association_ccs' => $question_reply_association_ccs, 
                                    'question_reply_comment_ccs' => $question_reply_comment_ccs,
                                    'question_reply_ratings' => $question_reply_ratings, 
                                    'question_user_feedback_ccs' => $question_user_feedback_ccs, 
                                    'question_reply_comment_img_ccs' => $question_reply_comment_img_ccs
                                ]);
    }

    public function create()
    {
        $post_categories = post_category::all()->toArray();
        
        return response()->json(['post_categories' => $post_categories]);
    }

    public function createCategory(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $post_s_categories = post_category::all()->where('name', $request->input('name'));
        if(count($post_s_categories) > 0){
            throw ValidationException::withMessages([
                'name' => ['Error: Category Already Exists!'],
            ]);
        }else{
            $post_category = new post_category([
                'name' => $request->input('name')
            ]);

            $post_category->save();

            return response()->json('Success: Category Created Successfully!');
        }
    }

    public function createPost(Request $request)
    {
 
        $question_post_cc = new question_post_cc([
            'user_id' => $request->input('user_id'),
            'user_category' => $request->input('user_category'),
            'title' => $request->input('title'),
            'details' => $request->input('details'),
            'link' => $request->input('link')
        ]);

        $question_post_cc->save();

        if($request->input('set_file') == true){
            if($request->hasFile('image')){
                $files = $request->file('image');
                foreach ($files as $file) {
                    $question_img_cc = new question_img_cc([
                        'question_id' => $question_post_cc->id,
                        'name' => $file->getCLientOriginalExtension()
                    ]);

                    $image_ext = $file->getCLientOriginalExtension();
                    if ($image_ext == 'jpeg' || $image_ext == 'jpg' || $image_ext == 'png' || $image_ext == 'JPEG' || $image_ext == 'JPG' || $image_ext == 'PNG') {
                        $question_img_cc->image =  str_replace('_', '_', rand(11111, 99999)). '_' . date('h_i_s') . '_' . time() . '.' . $image_ext;
                        $file->move(
                            storage_path().'/app/public/post/image/', $question_img_cc->image 
                        );
                    }elseif ($image_ext == 'pdf' || $image_ext == 'txt' || $image_ext == 'docx' || $image_ext == 'PDF' || $image_ext == 'TXT' || $image_ext == 'DOCX') {
                        $question_img_cc->image =  str_replace('_', '_', rand(11111, 99999)). '_' . date('h_i_s') . '_' . time() . '.' . $image_ext;
                        $file->move(
                            storage_path().'/app/public/post/document/', $question_img_cc->image 
                        );
                    }elseif ($image_ext == 'mp4' || $image_ext == 'mkv' || $image_ext == 'webm' || $image_ext == 'MP4' || $image_ext == 'MKV' || $image_ext == 'WEBM') {
                        $question_img_cc->image =  str_replace('_', '_', rand(11111, 99999)). '_' . date('h_i_s') . '_' . time() . '.' . $image_ext;
                        $file->move(
                            storage_path().'/app/public/post/video/', $question_img_cc->image 
                        );
                    }else{
                        $question_img_cc->image =  str_replace('_', '_', rand(11111, 99999)). '_' . date('h_i_s') . '_' . time() . '.' . $image_ext;
                        $file->move(
                            storage_path().'/app/public/post/others/', $question_img_cc->image 
                        );
                    }

                    $question_img_cc->save();
                }
            }else{
                return response()->json('Unable to Upload File!');
            }
        }

        return response()->json('Question Posted!');
    }

    public function createAssociation(Request $request)
    {
        $question_a_find = question_association_cc::all()->where('user_id', $request->input('user_id'))->where('user_category', $request->input('user_category'))->where('question_id', $request->input('question_id'));
        if(count($question_a_find) > 0){
            foreach($question_a_find as $question_a_f){
                $question_a_f->delete();
            }
            return response()->json('Unassociated Successful');
        }else{
            $question_association_cc = new question_association_cc([
                'user_id' => $request->input('user_id'),
                'user_category' => $request->input('user_category'),
                'question_id' => $request->input('question_id')
            ]);

            $question_association_cc->save();

            return response()->json('Association Successful');
        }
    }

    public function createReply(Request $request)
    {
        $request->validate([
            'reply' => ['required']
        ]);

        $question_reply_cc = new question_reply_cc([
            'user_id' => $request->input('user_id'),
            'user_category' => $request->input('user_category'),
            'question_id' => $request->input('question_id'),
            'reply' => $request->input('reply'),
            'link' => $request->input('link')
        ]);

        $question_reply_cc->save();

        return response()->json('Comment Successful');
    }

    public function createShare(Request $request)
    {
        $question_s_find = question_share_cc::all()->where('user_id', $request->input('user_id'))->where('user_category', $request->input('user_category'))->where('question_id', $request->input('question_id'));
        if(count($question_s_find) > 0){
            return response()->json('Already Shared');
        }else{
            $question_share_cc = new question_share_cc([
                'user_id' => $request->input('user_id'),
                'user_category' => $request->input('user_category'),
                'question_id' => $request->input('question_id'),
                'platform' => $request->input('platform'),
                'shared_to' => $request->input('shared_to')
            ]);
    
            $question_share_cc->save();

            return response()->json('Share Successful');
        }
    }

    public function createReplyAssociation(Request $request)
    {
        $question_reply_association_cc = new question_reply_association_cc([
            'user_id' => 1,//refine
            'user_category' => 'admin',
            'reply_id' => ''
        ]);

        $question_reply_association_cc->save();

        return response()->json(1);
    }

    public function createReplyComment(Request $request)
    {
        $question_reply_comment_cc = new question_reply_comment_cc([
            'user_id' => $request->input('user_id'),
            'user_category' => $request->input('user_category'),
            'reply_id' => $request->input('reply_id'),
            'reply' => $request->input('reply'),
            'link' => $request->input('link')
        ]);

        $question_reply_comment_cc->save();

        return response()->json('Replied to Comment Successful');
    }

    public function createUserFeedback($id, Request $request)
    {
        $question_user_feedback_cc = new question_user_feedback_cc([
            'user_id' => 1,//refine
            'user_category' => 'admin',
            'question_id' => $id,
            'reply_id' => $request->input('reply_id'),
            'feedback' => $request->input('feedback')
        ]);

        $question_user_feedback_cc->save();

        return response()->json(1);
    }

    public function show($id)
    {
        $question_post_cc = question_post_cc::find($id);
        $admin_ccs = admin_cc::all()->toArray();
        $user_ccs = user_cc::all()->toArray();
        $question_img_ccs = question_img_cc::where('question_post_cc_id', $id);
        $question_association_ccs = question_association_cc::where('question_post_cc_id', $id);
        $question_reply_ccs = question_reply_cc::all();
        $question_share_ccs = question_share_cc::all()->toArray();
        $question_reply_img_ccs = question_reply_img_cc::all()->toArray();
        $question_reply_association_ccs = question_reply_association_cc::all()->toArray();
        $question_reply_comment_ccs = question_reply_comment_cc::all()->toArray();
        $question_user_feedback_ccs = question_user_feedback_cc::all()->toArray();
        $question_reply_comment_img_ccs = question_reply_comment_img_cc::all()->toArray();
        return response()->json(['admin_ccs' => $admin_ccs, 
                                    'user_ccs' => $user_ccs, 
                                    'question_post_cc' => $question_post_cc, 
                                    'question_img_ccs' => $question_img_ccs, 
                                    'question_association_ccs' => $question_association_ccs, 
                                    'question_reply_ccs' => $question_reply_ccs, 
                                    'question_share_ccs' => $question_share_ccs, 
                                    'question_reply_img_ccs' => $question_reply_img_ccs, 
                                    'question_reply_association_ccs' => $question_reply_association_ccs, 
                                    'question_reply_comment_ccs' => $question_reply_comment_ccs, 
                                    'question_user_feedback_ccs' => $question_user_feedback_ccs, 
                                    'question_reply_comment_img_ccs' => $question_reply_comment_img_ccs
                                ]);
    }

    public function update($id, Request $request)
    {
        
        $question_post_cc = question_post_cc::find($id);
 
        $question_post_cc->update([
            'title' => $request->input('title'),
            'details' => $request->input('details'),
            'link' => $request->input('link')
        ]);

        $question_post_cc->save();

        //$admin_cc= admin_cc::create($request);

        if($request->input('set_file') == 1){

            $question_img_cc = question_img_cc::where('question_id', $id);
            $question_img_cc->update([
                'name' => $request->input('name')
            ]);

            $image_ext = $request->file('image')->getCLientOriginalExtension();
            $question_img_cc->image =  str_replace('_', '_', rand(11111, 99999)). '_' . date('h_i_s') . '_' . time() . '.' . $image_ext;
            $request->file('image')->move(
                storage_path().'/app/public/image/post/', $question_img_cc->image 
            );

            $question_img_cc->save();
        }

        //$admin_cc= admin_cc::create($request);

        return response()->json('Question Updated!');
    }

    public function destroyPost($id)
    {

        $question_post_cc = question_post_cc::find($id);

        $question_post_cc->delete();

        $question_img_cc = question_img_cc::where('question_id', $id);

        if(!empty($question_img_cc)){
            $question_img_cc->delete();
        }

        return response()->json('Question Deleted!');
    }

    public function destroyAssociation($id)
    {

        $question_association_cc = question_association_cc::find($id);

        $question_association_cc->delete();

        return response()->json(1);
    }

    public function destroyReply($id)
    {
        $question_reply_cc = question_reply_cc::find($id);

        $question_reply_cc->delete();

        $question_reply_img_cc = question_reply_img_cc::where('reply_id', $id);

        if(!empty($question_reply_img_cc)){
            $question_reply_img_cc->delete();
        }

        return response()->json(1);
    }

    public function destroyShare($id)
    {
        $question_share_cc = question_share_cc::find($id);

        $question_share_cc->delete();

        return response()->json(1);
    }

    public function destroyReplyAssociation($id)
    {
        $question_reply_association_cc = question_reply_association_cc ::find($id);

        $question_reply_association_cc->delete();

        return response()->json(1);
    }

    public function destroyReplyComment($id)
    {
        
        $question_reply_comment_cc = question_reply_cc::find($id);

        $question_reply_comment_cc->delete();

        $question_reply_comment_img_cc = question_reply_comment_img_cc::where('comment_reply_id', $id);

        if(!empty($question_reply_comment_img_cc)){
            $question_reply_comment_img_cc->delete();
        }

        return response()->json(1);
    }

    public function destroyUserFeedback($id)
    {
        $question_user_feedback_cc = question_user_feedback_cc ::find($id);

        $question_user_feedback_cc->delete();

        return response()->json(1);
    }
}
