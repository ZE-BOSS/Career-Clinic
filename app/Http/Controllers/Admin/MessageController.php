<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin_cc;
use App\Models\user_cc;
use App\Models\message;
use App\Models\message_attachment;

class MessageController extends Controller
{
    public function index()
    {
        $admin_ccs = admin_cc::all()->toArray();
        $user_ccs = user_cc::all()->toArray();
        $messages = message::all()->toArray();
        $message_attachments = message_attachment::all()->toArray();
        return array_reverse($admin_ccs)
            ->with('user_ccs', $user_ccs)
            ->with('messages', $messages)
            ->with('message_attachments', $message_attachments);
    }

    public function create(Request $request)
    {
 
        $message = new message([
            'from' => 1,//refine
            'from_category' => 'admin',
            'to' => $request->input('to'),
            'to_category' => $request->input('to_category'),
            'subject' => $request->input('subject'),
            'message' => $request->input('message'),
            'message_category' => $request->input('message_category'),
            'status' => $request->input('status')
        ]);

        $message->save();

        if($request->input('set_file') == 1){

            $message_attachment = new message_attachment([
                'message_id' => $message->id,
                'name' => $request->input('name'),
                'file_type' => $request->file('file')->getCLientOriginalExtension()
            ]);

            $file_ext = $request->file('file')->getCLientOriginalExtension();
            $message_attachment->file =  str_replace('_', '_', rand(11111, 99999)). '_' . date('h_i_s') . '_' . time() . '.' . $file_ext;
            $request->file('file')->move(
                storage_path().'/app/public/file/message/', $message_attachment->file 
            );
        }

        $message_attachment->save();

        //$admin_cc= admin_cc::create($request);

        return response()->json('Message Sent!');
    }

    public function show($id)
    {
        $message = message::find($id);
        $admin_ccs = admin_cc::all()->toArray();
        $user_ccs = user_cc::all()->toArray();
        $message_attachments = message_attachment::all()->toArray();
        return response()->json($admin_ccs)
            ->with('user_ccs', $user_ccs)
            ->with('message', $message)
            ->with('message_attachments', $message_attachments);
    }

    public function reply($id, Request $request)
    {
        $message = new message([
            'from' => 1,//refine
            'from_category' => 'admin',
            'to' => $request->input('to'),
            'to_category' => $request->input('to_category'),
            'subject' => $request->input('subject'),
            'message' => $request->input('message'),
            'message_type' => $id,
            'message_category' => $request->input('message_category'),
            'status' => $request->input('status')
        ]);

        $message->save();

        if($request->input('set_file') == 1){

            $message_attachment = new message_attachment([
                'message_id' => $message->id,
                'name' => $request->input('name'),
                'file_type' => $request->file('file')->getCLientOriginalExtension()
            ]);

            $file_ext = $request->file('file')->getCLientOriginalExtension();
            $message_attachment->file =  str_replace('_', '_', rand(11111, 99999)). '_' . date('h_i_s') . '_' . time() . '.' . $file_ext;
            $request->file('file')->move(
                storage_path().'/app/public/file/message/', $message_attachment->file 
            );
        }

        $message_attachment->save();

        //$admin_cc= admin_cc::create($request);

        return response()->json('Reply Sent!');
    }

    public function destroy($id)
    {
        $message = message::find($id);

        $message->delete();

        return response()->json('Message Deleted!');
    }
}
