<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin_cc;
use App\Models\user_cc;
use App\Models\event;

class EventController extends Controller
{
    public function index()
    {
        $admin_ccs = admin_cc::all()->toArray();
        $user_ccs = user_cc::all()->toArray();
        $events = event::all()->toArray();
        return response()->json(['admin_ccs' => $admin_ccs, 
                                    'user_ccs' => $user_ccs, 
                                    'events' => $events, 
                                ]); 
    }

    public function create(Request $request)
    {
 
        $event = new event([
            'user_id' => 1,//refine
            'user_category' => 'admin',
            'title' => $request->input('title'),
            'details' => $request->input('details'),
            'file_type' => $request->input('file_type'),
            'start_date' => $request->input('start_date'),
            'start_time' => $request->input('start_time'),
            'start_time_zone' => $request->input('start_time_zone'),
            'end_date' => $request->input('end_date'),
            'end_time' => $request->input('end_time'),
            'end_time_zone' => $request->input('end_time_zone'),
            'venue' => $request->input('venue'),
            'city' => $request->input('city'),
            'state' => $request->input('state'),
            'country' => $request->input('country')
        ]);

        if($request->input('file_type') == 'image'){
            $image_ext = $request->file('image')->getCLientOriginalExtension();
            $event->image =  str_replace('_', '_', rand(11111, 99999)). '_' . date('h_i_s') . '_' . time() . '.' . $image_ext;
            $request->file('image')->move(
                storage_path().'/app/public/image/event/', $event->image 
            );
        }elseif($request->input('file_type') == 'video'){
            $logger = `Psr\Logger\LoggerInterface`;
            $sec = 10;
            $video = $request->file('video');
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
            $event->image = $thumbnail;
            $frame->save(storage_path().'/app/public/image/event/'.$thumbnail);

            //create gif file
            $new_file = str_replace('_', '_', rand(11111, 99999)). '_' . date('h_i_s') . '_' . time() . '.'.'gif';
            $event->gif = $new_file;
            $open = $ffmpeg->open($video);
            $open
                ->gif(FFMpeg\Coordinate\TimeCode::fromSeconds(2), new FFMpeg\Coordinate\Dimension(640, 480), 9)
                ->save(storage_path().'/app/public/gif/event/'.$new_file);

            //create video file
            $event_ext = $request->file('video')->getCLientOriginalExtension();

            $event->video =  str_replace('_', '_', rand(11111, 99999)). '_' . date('h_i_s') . '_' . time() . '.' . $event_ext;

            $request->file('video')->move(
                storage_path().'/app/public/video/event/', $event->video 
            );
        }else{

        }

        $event->save();

        //$admin_cc= admin_cc::create($request);

        return response()->json('Event Created!');
    }

    public function show($id)
    {
        $event = event::find($id);
        $admin_ccs = admin_cc::all()->toArray();
        $user_ccs = user_cc::all()->toArray();
        return response()->json(['admin_ccs' => $admin_ccs, 
                                    'user_ccs' => $user_ccs, 
                                    'event' => $event, 
                                ]); 
    }

    public function update($id, Request $request)
    {
        
        $event = event::find($id);
 
        $event->update([
            'user_id' => 1,//refine
            'user_category' => 'admin',
            'title' => $request->input('title'),
            'details' => $request->input('details'),
            'file_type' => $request->input('file_type'),
            'start_date' => $request->input('start_date'),
            'start_time' => $request->input('start_time'),
            'start_time_zone' => $request->input('start_time_zone'),
            'end_date' => $request->input('end_date'),
            'end_time' => $request->input('end_time'),
            'end_time_zone' => $request->input('end_time_zone'),
            'venue' => $request->input('venue'),
            'city' => $request->input('city'),
            'state' => $request->input('state'),
            'country' => $request->input('country')
        ]);

        if($request->input('file_type') == 'image'){
            $image_ext = $request->file('image')->getCLientOriginalExtension();
            $event->image =  str_replace('_', '_', rand(11111, 99999)). '_' . date('h_i_s') . '_' . time() . '.' . $image_ext;
            $request->file('image')->move(
                storage_path().'/app/public/image/event/', $event->image 
            );
        }elseif($request->input('file_type') == 'video'){
            $logger = `Psr\Logger\LoggerInterface`;
            $sec = 10;
            $video = $request->file('video');
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
            $event->image = $thumbnail;
            $frame->save(storage_path().'/app/public/image/event/'.$thumbnail);

            //create gif file
            $new_file = str_replace('_', '_', rand(11111, 99999)). '_' . date('h_i_s') . '_' . time() . '.'.'gif';
            $event->gif = $new_file;
            $open = $ffmpeg->open($video);
            $open
                ->gif(FFMpeg\Coordinate\TimeCode::fromSeconds(2), new FFMpeg\Coordinate\Dimension(640, 480), 9)
                ->save(storage_path().'/app/public/gif/event/'.$new_file);

            //create video file
            $event_ext = $request->file('video')->getCLientOriginalExtension();

            $event->video =  str_replace('_', '_', rand(11111, 99999)). '_' . date('h_i_s') . '_' . time() . '.' . $event_ext;

            $request->file('video')->move(
                storage_path().'/app/public/video/event/', $event->video 
            );
        }else{

        }

        $event->save();

        //$admin_cc= admin_cc::create($request);

        return response()->json('Event Updated!');
    }

    public function destroy($id)
    {
        $event = event::find($id);

        $event->delete();

        return response()->json('Event Deleted!');
    }
}
