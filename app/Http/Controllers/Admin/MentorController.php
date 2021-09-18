<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin_cc;
use App\Models\user_cc;
use App\Models\mentorship;
use App\Models\mentoship_user;
use App\Models\mentoship_content;
use App\Models\event_cc;
use App\Models\job_cc;
use App\Models\community;
use App\Models\career_talk_cc;
use App\Models\webiner;
use App\Models\webiner_user;
use App\Models\webiner_comment;

class MentorController extends Controller
{
    public function index()
    {
        $admin_ccs = admin_cc::all()->toArray();
        $user_ccs = user_cc::all()->toArray();
        $event_ccs = event_cc::all()->toArray();
        $job_ccs = job_cc::all()->toArray();
        $communities = community::all()->toArray();
        $career_talk_ccs = career_talk_cc::all()->toArray();
        $webiners = webiner::all()->toArray();
        $webiner_users = webiner_user::all()->toArray();
        $webiner_comments = webiner_comment::all()->toArray();
        $mentorships = mentorship::all()->toArray();
        $mentoship_users = mentoship_user::all()->toArray();
        $mentoship_contents = mentoship_content::all()->toArray();
        return array_reverse($admin_ccs)
            ->with('user_ccs', $user_ccs)
            ->with('mentorships', $mentorships)
            ->with('mentoship_users', $mentoship_users)
            ->with('mentoship_contents', $mentoship_contents)
            ->with('event_ccs', $event_ccs)
            ->with('job_ccs', $job_ccs)
            ->with('communities', $communities)
            ->with('career_talk_ccs', $career_talk_ccs)
            ->with('webiners', $webiners)
            ->with('webiner_users', $webiner_users)
            ->with('webiner_comments', $webiner_comments);
    }

    public function createMentorship(Request $request)
    {
 
        $mentorship = new mentorship([
            'user_id' => 1,//refine
            'user_category' => 'admin',
            'title' => $request->input('title'),
            'details' => $request->input('details'),
            'course' => $request->input('course'),
            'event' => $request->input('event'),
            'webiner' => $request->input('webiner'),
            'community' => $request->input('community'),
            'career-talk' => $request->input('career-talk'),
            'job' => $request->input('job')
        ]);

        $image_ext = $request->file('image')->getCLientOriginalExtension();
        $mentorship->image =  str_replace('_', '_', rand(11111, 99999)). '_' . date('h_i_s') . '_' . time() . '.' . $image_ext;
        $request->file('image')->move(
            storage_path().'/app/public/image/mentorship/', $mentorship->image 
        );

        $mentorship->save();

        //$admin_cc= admin_cc::create($request);

        return response()->json('Mentorship Program Created!');
    }

    public function createContent($id, Request $request)
    {
        $mentoship_content = new mentoship_content([
            'user_id' => 1,//refine
            'user_category' => 'admin',
            'mentorship_id' => $id,
            'content_id' => $request->input('content_id'),
            'content_category' => $request->input('content_category'),
            'status' => $request->input('status')
        ]);

        $mentoship_content->save();

        return response()->json(1);
    }

    public function createUser($id, Request $request)
    {
        $mentoship_user = new mentoship_user([
            'user_id' => 1,//refine
            'user_category' => 'admin',
            'mentorship_id' => $id
        ]);

        $mentoship_user->save();

        return response()->json(1);
    }

    public function createWebiner(Request $request)
    {
 
        $webiner = new webiner([
            'user_id' => 1,//refine
            'user_category' => 'admin',
            'code' => $request->input('code'),
            'title' => $request->input('title'),
            'details' => $request->input('details'),
            'webiner_status' => $request->input('webiner_status'),
            'from' => $request->input('from'),
            'to' => $request->input('to')
        ]);

        $logger = `Psr\Logger\LoggerInterface`;
        $sec = 10;
        $webiner = $request->file('video');
        $thumbnail = str_replace('_', '_', rand(11111, 99999)). '_' . date('h_i_s') . '_' . time() . '.'.'png';

        $ffmpeg = FFMpeg\FFMpeg::create(array(
            'ffmpeg.binaries'  => 'C:/FFmpeg/bin/ffmpeg.exe',
            'ffprobe.binaries' => 'C:/FFmpeg/bin/ffprobe.exe',
            'timeout'          => 3600, // The timeout for the underlying process
            'ffmpeg.threads'   => 12,   // The number of threads that FFMpeg should use
        ), $logger);

        //create image file
        $vid = $ffmpeg->open($video);
        $frame = $vid->frame(FFMpeg\Coordinate\TimeCode::fromSeconds($sec));
        $webiner->image = $thumbnail;
        $frame->save(storage_path().'/app/public/image/webiner/'.$thumbnail);

        //create gif file
        $new_file = str_replace('_', '_', rand(11111, 99999)). '_' . date('h_i_s') . '_' . time() . '.'.'gif';
        $webiner->gif = $new_file;
        $open = $ffmpeg->open($video);
        $open
            ->gif(FFMpeg\Coordinate\TimeCode::fromSeconds(2), new FFMpeg\Coordinate\Dimension(640, 480), 9)
            ->save(storage_path().'/app/public/gif/webiner/'.$new_file);

        //create video file
        $webiner_ext = $request->file('video')->getCLientOriginalExtension();

        $webiner->video =  str_replace('_', '_', rand(11111, 99999)). '_' . date('h_i_s') . '_' . time() . '.' . $webiner_ext;

        $request->file('video')->move(
            storage_path().'/app/public/video/webiner/', $v->video 
        );

        $webiner->save();

        //$admin_cc= admin_cc::create($request);

        return response()->json('Webiner Created!');
    }

    public function createWebinerUser($id, Request $request)
    {
        $webiner_user = new webiner_user([
            'user_id' => 1,//refine
            'user_category' => 'admin',
            'webiner_id' => $id,
            'code' => $request->input('code'),
            'from' => $request->input('from'),
            'to' => $request->input('to')
        ]);

        $webiner_user->save();

        return response()->json(1);
    }

    public function createWebinerComment($id, Request $request)
    {
        $webiner_comment = new webiner_comment([
            'user_id' => 1,//refine
            'user_category' => 'admin',
            'webiner_id' => $id,
            'code' => $request->input('code'),
            'comment' => $request->input('comment')
        ]);

        $webiner_comment->save();

        return response()->json(1);
    }

    public function show($id)
    {
        $mentorship = mentorship::find($id);
        $admin_ccs = admin_cc::all()->toArray();
        $user_ccs = user_cc::all()->toArray();
        $event_ccs = event_cc::all()->toArray();
        $job_ccs = job_cc::all()->toArray();
        $communities = community::all()->toArray();
        $career_talk_ccs = career_talk_cc::all()->toArray();
        $webiners = webiner::all()->toArray();
        $webiner_users = webiner_user::all()->toArray();
        $webiner_comments = webiner_comment::all()->toArray();
        $mentoship_user = mentoship_user::where('mentorship_id', $id);
        $mentoship_contents = mentoship_content::where('mentorship_id', $id);
        return response()->json($admin_ccs)
            ->with('user_ccs', $user_ccs)
            ->with('mentorship', $mentorship)
            ->with('mentoship_user', $mentoship_user)
            ->with('mentoship_contents', $mentoship_contents)
            ->with('event_ccs', $event_ccs)
            ->with('job_ccs', $job_ccs)
            ->with('communities', $communities)
            ->with('career_talk_ccs', $career_talk_ccs)
            ->with('webiners', $webiners)
            ->with('webiners', $webiners)
            ->with('webiner_users', $webiner_users)
            ->with('webiner_comments', $webiner_comments);
    }

    public function updateMentorship($id, Request $request)
    {
        
        $mentorship = mentorship::find($id);
 
        $mentorship->update([
            'title' => $request->input('title'),
            'details' => $request->input('details'),
            'course' => $request->input('course'),
            'event' => $request->input('event'),
            'webiner' => $request->input('webiner'),
            'community' => $request->input('community'),
            'career-talk' => $request->input('career-talk'),
            'job' => $request->input('job')
        ]);

        $image_ext = $request->file('image')->getCLientOriginalExtension();
        $mentorship->image =  str_replace('_', '_', rand(11111, 99999)). '_' . date('h_i_s') . '_' . time() . '.' . $image_ext;
        $request->file('image')->move(
            storage_path().'/app/public/image/mentorship/', $mentorship->image 
        );

        $mentorship->save();

        //$admin_cc= admin_cc::create($request);

        return response()->json('Mentorship Program Updated!');
    }

    public function updateContent($id, Request $request)
    {
        
        $mentoship_content = mentoship_content::find($id);
 
        $mentoship_content->update([
            'content_id' => $request->input('content_id'),
            'content_category' => $request->input('content_category'),
            'status' => $request->input('status')
        ]);

        $mentoship_content->save();

        //$admin_cc= admin_cc::create($request);

        return response()->json(1);
    }

    public function destroyMentorship($id)
    {
        $mentorship = mentorship::find($id);

        $mentorship->delete();

        return response()->json('Mentorship Program Deleted!');
    }

    public function destroyUser($id)
    {
        $mentorship_user = mentorship_user::find($id);

        $mentorship_user->delete();

        return response()->json(1);
    }
}
