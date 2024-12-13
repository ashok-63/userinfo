<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TemplateController extends Controller
{
    public function getTemplates()
    {
        $templates = DB::connection('mysql6')->table('templates')->get();
        return view('msg_template_view', compact('templates'));
    }
    public function addTemplate(Request $req)
    {
        // dd($req->all());
        $title = $req->title;
        $text_msg = $req->text_msg;
        $date = date('y-m-d');
        $template_id = $req->template_id;
        $subject = '';
        $createdBy = auth()->user()->User_Name;
        $addTemplate = DB::connection('mysql6')->table('templates')->insert([
            'template_id' => $template_id,
            'title' => $title,
            'subject' => $subject,
            'text_msg' => $text_msg,
            'createdBy' => $createdBy,
            'createdAt' => $date,
        ]);
        if ($addTemplate == true) {
            return response()->json(['msg' => 'Template Added Successfully..!', 'class' => 'success']);
        } else {
            return response()->json(['msg' => 'Something went wrong. Failed to add new template..!', 'class' => 'error']);
        }
    }
    public function updateTemplate(Request $req)
    {
        // dd($req->all());
        $text_msg = $req->text_msg;
        $id = $req->id;
        $date = date('y-m-d');
        $updatedBy = auth()->user()->User_Name;
        $updateTemplate = DB::connection('mysql6')->table('templates')->where('id', $id)->update([
            'text_msg' => $text_msg,
            'updatedBy' => $updatedBy,
            'updatedAt' => $date,
        ]);
        if ($updateTemplate == true) {
            return response()->json(['msg' => 'Template Updated Successfully..!', 'class' => 'success']);
        } else {
            return response()->json(['msg' => 'Something went wrong. Failed to update template..!', 'class' => 'error']);
        }
    }
}
