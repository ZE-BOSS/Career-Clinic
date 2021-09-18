<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin_cc;
use App\Models\user_cc;
use App\Models\job_cc;
use App\Models\job_application_cc;
use App\Models\job_question_cc;
use App\Models\job_reply_cc;
use App\Models\company_cc;
use App\Models\cover_letter_cc;
use App\Models\resume_cc;

class JobController extends Controller
{
    public function index()
    {
        $admin_ccs = admin_cc::all()->toArray();
        $user_ccs = user_cc::all()->toArray();
        $job_ccs = job_cc::all()->toArray();
        $job_application_ccs = job_application_cc::all()->toArray();
        $job_question_ccs = job_question_cc::all()->toArray();
        $job_reply_ccs = job_reply_cc::all()->toArray();
        $company_ccs = company_cc::all()->toArray();
        $cover_letter_ccs = cover_letter_cc::all()->toArray();
        $resume_ccs = resume_cc::all()->toArray();
        return array_reverse($admin_ccs)
            ->with('user_ccs', $user_ccs)
            ->with('job_ccs', $job_ccs)
            ->with('job_application_ccs', $job_application_ccs)
            ->with('job_question_ccs', $job_question_ccs)
            ->with('job_reply_ccs', $job_reply_ccs)
            ->with('company_ccs', $company_ccs)
            ->with('cover_letter_ccs', $cover_letter_ccs)
            ->with('resume_ccs', $resume_ccs); 
    }

    public function createJob(Request $request)
    {
 
        $job_cc = new job_cc([
            'user_id' => 1,//refine
            'user_category' => 'admin',
            'company_id' => $request->input('company_id'),
            'title' => $request->input('title'),
            'details' => $request->input('details'),
            'closes_in' => $request->input('closes_in'),
            'pay_from' => $request->input('pay_from'),
            'pay_to' => $request->input('pay_to'),
            'mentorship_type' => $request->input('mentorship_type'),
            'mentorship_id' => $request->input('mentorship_id')
        ]);

        $job_cc->save();

        //$admin_cc= admin_cc::create($request);

        return response()->json('Job Created!');
    }

    public function createQuestion($id, Request $request)
    {
        $job_question_cc = new job_question_cc([
            'job_id' => $id,//refine
            'question' => $request->input('question')
        ]);

        $job_question_cc->save();

        return response()->json(1);
    }

    public function createReply($id, Request $request)
    {
        $job_reply_cc = new job_reply_cc([
            'user_id' => 1,//refine
            'user_category' => 'admin',
            'question_id' => $id,
            'reply' => $request->input('reply')
        ]);

        $job_reply_cc->save();

        return response()->json(1);
    }

    public function createApplication($id, Request $request)
    {
        $job_application_cc = new job_application_cc([
            'user_id' => 1,//refine
            'user_category' => 'admin',
            'job_id' => $id,
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'resume_id' => $request->input('resume_id'),
            'cover_letter_id' => $request->input('cover_letter_id')
        ]);

        $job_application_cc->save();

        return response()->json(1);
    }

    public function replyApplication($id, Request $request)
    {
        $job_application_cc = job_application_cc::find($id);
        $job_application_cc->update([
            'application_response' => $request->input('application_response')
        ]);

        $job_application_cc->save();

        return response()->json(1);
    }

    public function show($id)
    {
        $job_cc = job_cc::find($id);
        $admin_ccs = admin_cc::all()->toArray();
        $user_ccs = user_cc::all()->toArray();
        $job_application_ccs = job_application_cc::where('job_id', $id);
        $job_question_ccs = job_question_cc::where('job_id', $id);
        $job_reply_ccs = job_reply_cc::all()->toArray();
        $company_ccs = company_cc::all()->toArray();
        $cover_letter_ccs = cover_letter_cc::all()->toArray();
        $resume_ccs = resume_cc::all()->toArray();
        return response()->json($admin_ccs)
            ->with('user_ccs', $user_ccs)
            ->with('job_cc', $job_cc)
            ->with('job_application_ccs', $job_application_ccs)
            ->with('job_question_ccs', $job_question_ccs)
            ->with('job_reply_ccs', $job_reply_ccs)
            ->with('company_ccs', $company_ccs)
            ->with('cover_letter_ccs', $cover_letter_ccs)
            ->with('resume_ccs', $resume_ccs);
    }

    public function updateJob($id, Request $request)
    {
        $job_cc = job_cc::find($id);
        
        $job_cc->update([
            'company_id' => $request->input('company_id'),
            'title' => $request->input('title'),
            'details' => $request->input('details'),
            'closes_in' => $request->input('closes_in'),
            'pay_from' => $request->input('pay_from'),
            'pay_to' => $request->input('pay_to'),
            'mentorship_type' => $request->input('mentorship_type'),
            'mentorship_id' => $request->input('mentorship_id')
        ]);

        $job_cc->save();

        //$admin_cc= admin_cc::create($request);

        return response()->json('Job Created!');
    }

    public function updateQuestion($id, Request $request)
    {
        $job_question_cc = job_question_cc::find($id);

        $job_question_cc->update([
            'question' => $request->input('question')
        ]);

        $job_question_cc->save();

        return response()->json(1);
    }

    public function updateReply($id, Request $request)
    {
        $job_reply_cc = job_reply_cc::find($id);

        $job_reply_cc->update([
            'reply' => $request->input('reply')
        ]);

        $job_reply_cc->save();

        return response()->json(1);
    }

    public function updateApplication($id, Request $request)
    {
        $job_application_cc = job_application_cc::find($id);

        $job_application_cc->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'resume_id' => $request->input('resume_id'),
            'cover_letter_id' => $request->input('cover_letter_id')
        ]);

        $job_application_cc->save();

        return response()->json(1);
    }

    public function destroy($id)
    {
        $job_cc = job_cc::find($id);

        $job_cc->delete();

        return response()->json('job_cc Deleted!');
    }
}
