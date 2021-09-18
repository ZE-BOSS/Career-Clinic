<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin_cc;
use App\Models\user_cc;
use App\Models\course;
use App\Models\course_file;
use App\Models\course_payment;
use App\Models\payment_card;

class CourseController extends Controller
{
    public function index()
    {
        $admin_ccs = admin_cc::all()->toArray();
        $user_ccs = user_cc::all()->toArray();
        $courses = course::all()->toArray();
        $course_files = course_file::all()->toArray();
        $course_payments = course_payment::all()->toArray();
        $payment_cards = payment_card::all()->toArray();
        $my_payment_cards = payment_card::where('user_id', 1)->where('user_category', 'admin');
        return array_reverse($admin_ccs)
            ->with('user_ccs', $user_ccs)
            ->with('courses', $courses)
            ->with('course_files', $course_files)
            ->with('course_payments', $course_payments)
            ->with('payment_cards', $payment_cards)
            ->with('my_payment_cards', $my_payment_cards);
    }

    public function createCourse(Request $request)
    {
 
        $course = new course([
            'user_id' => 1,//refine
            'user_category' => 'admin',
            'name' => $request->input('name'),
            'title' => $request->input('title'),
            'details' => $request->input('details'),
            'course_length' => $request->input('course_length')
        ]);

        $image_ext = $request->file('image')->getCLientOriginalExtension();
        $course->image =  str_replace('_', '_', rand(11111, 99999)). '_' . date('h_i_s') . '_' . time() . '.' . $image_ext;
        $request->file('image')->move(
            storage_path().'/app/public/image/course/', $course->image 
        );

        $course->save();

        //$admin_cc= admin_cc::create($request);

        return response()->json('Course Created!');
    }

    public function createCourseFile($id, Request $request)
    {
        $course_file = new course_chat([
            'course_id' => $id,//refine
            'file_type' => $request->input('file_type'),
            'title' => $request->input('title'),
            'details' => $request->input('details'),
            'file' => $request->input('file')
        ]);

        $image_ext = $request->file('file')->getCLientOriginalExtension();
        $course_file->file =  str_replace('_', '_', rand(11111, 99999)). '_' . date('h_i_s') . '_' . time() . '.' . $image_ext;
        $request->file('file')->move(
            storage_path().'/app/public/image/course_file/', $course_file->file 
        );
        $course_file->file_type = $request->file('file')->getCLientOriginalExtension();

        $course_file->save();

        return response()->json(1);
    }

    public function createCoursePayment($id, Request $request)
    {
 
        $course_payment = new course_payment([
            'user_id' => 1,//refine
            'user_category' => 'admin',
            'course_id' => $request->input('course_id'),
            'course_title' => $request->input('course_title'),
            'card_id' => $request->input('card_id'),
            'payment_status' => $request->input('payment_status'),
            'course_status' => $request->input('course_status')
        ]);

        $course_payment->save();

        //$admin_cc= admin_cc::create($request);

        return response()->json('Course Created!');
    }

    public function updateCourseFile($id, Request $request)
    {
        $course_file = course_file::find($id);

        $course_file->update([
            'file_type' => $request->input('file_type'),
            'title' => $request->input('title'),
            'details' => $request->input('details'),
            'file' => $request->input('file')
        ]);

        $image_ext = $request->file('file')->getCLientOriginalExtension();
        $course_file->file =  str_replace('_', '_', rand(11111, 99999)). '_' . date('h_i_s') . '_' . time() . '.' . $image_ext;
        $request->file('file')->move(
            storage_path().'/app/public/image/course_file/', $course_file->file 
        );
        $course_file->file_type = $request->file('file')->getCLientOriginalExtension();

        $course_file->save();

        return response()->json(1);
    }

    public function show($id)
    {
        $course = course::find($id);
        $admin_ccs = admin_cc::all()->toArray();
        $user_ccs = user_cc::all()->toArray();
        $course_files = course_file::where('course_id', $id);
        $course_payments = course_payment::where('course_id', $id);
        $payment_cards = payment_card::all()->toArray();
        $my_payment_cards = payment_card::where('user_id', 1)->where('user_category', 'admin');
        return response()->json($admin_ccs)
            ->with('user_ccs', $user_ccs)
            ->with('course', $course)
            ->with('course_files', $course_files)
            ->with('course_payments', $course_payments)
            ->with('payment_cards', $payment_cards)
            ->with('my_payment_cards', $my_payment_cards);
    }

    public function update($id, Request $request)
    {
        
        $course = course::find($id);
 
        $course->update([
            'name' => $request->input('name'),
            'title' => $request->input('title'),
            'details' => $request->input('details'),
            'course_length' => $request->input('course_length')
        ]);

        $image_ext = $request->file('image')->getCLientOriginalExtension();
        $course->image =  str_replace('_', '_', rand(11111, 99999)). '_' . date('h_i_s') . '_' . time() . '.' . $image_ext;
        $request->file('image')->move(
            storage_path().'/app/public/image/course/', $course->image 
        );

        $course->save();

        //$admin_cc= admin_cc::create($request);

        return response()->json('course Updated!');
    }
    
    public function destroyCourseFile($id)
    {
        $course_file = course_file::find($id);

        $course_file->delete();

        return response()->json('Course File Deleted!');
    }

    public function destroy($id)
    {
        $course = course::find($id);

        $course->delete();

        return response()->json('Course Deleted!');
    }
}
