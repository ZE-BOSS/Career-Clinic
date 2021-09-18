<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin_cc;
use App\Models\user_cc;
use App\Models\notification;
use App\Models\notification_attachment;

class NotificationController extends Controller
{
    public function index()
    {
        $admin_ccs = admin_cc::all()->toArray();
        $user_ccs = user_cc::all()->toArray();
        $notifications = notification::all()->toArray();
        $notification_attachments = notification_attachment::all()->toArray();
        return array_reverse($admin_ccs)
            ->with('user_ccs', $user_ccs)
            ->with('notifications', $notifications)
            ->with('notification_attachments', $notification_attachments);
    }

    public function create(Request $request)
    {
 
        $notification = new notification([
            'admin_id' => 1,//refine
            'admin_category' => $request->input('admin_category'),
            'user_id' => $request->input('user_id'),
            'user_category' => $request->input('user_category'),
            'name' => $request->input('name'),
            'title' => $request->input('title'),
            'details' => $request->input('details'),
            'notification_type' => $request->input('notification_type'),
            'status' => $request->input('status')
        ]);

        $notification->save();

        if($request->input('set_file') == 1){

            $notification_attachment = new notification_attachment([
                'notification_id' => $notification->id,
                'name' => $request->input('name'),
                'file_type' => $request->file('file')->getCLientOriginalExtension()
            ]);

            $file_ext = $request->file('file')->getCLientOriginalExtension();
            $notification_attachment->file =  str_replace('_', '_', rand(11111, 99999)). '_' . date('h_i_s') . '_' . time() . '.' . $file_ext;
            $request->file('file')->move(
                storage_path().'/app/public/file/notification/', $notification_attachment->file 
            );
        }

        $notification_attachment->save();

        //$admin_cc= admin_cc::create($request);

        return response()->json('notification Sent!');
    }

    public function show($id)
    {
        $notification = notification::find($id);
        $admin_ccs = admin_cc::all()->toArray();
        $user_ccs = user_cc::all()->toArray();
        $notification_attachments = notification_attachment::all()->toArray();
        return response()->json($admin_ccs)
            ->with('user_ccs', $user_ccs)
            ->with('notification', $notification)
            ->with('notification_attachments', $notification_attachments);
    }

    public function destroy($id)
    {
        $notification = notification::find($id);

        $notification->delete();

        return response()->json('notification Deleted!');
    }
}
