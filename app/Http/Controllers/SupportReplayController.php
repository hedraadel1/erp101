<?php

namespace App\Http\Controllers;

use App\BusinessLocation;
use App\Contact;
use App\SupportReplay;
use App\SupportTicket;
use App\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


use App\Utils\Util;

class SupportReplayController extends Controller
{
    
      public function store(Request $request){

        $inputs = $request->except('file');
        $inputs['business_id'] = request()->session()->get('user.business_id');
        $inputs['user_id'] = auth()->user()->id;
        if ($request->file) {
          $inputs['file'] = uploadFile($request->file , 'uploads/supported/files/comments/');
        }
        // dd($inputs);
        SupportReplay::create($inputs);
        $output = ['success' => 1,
          'msg' => __('comment.added_success')
        ];
        return back()->with('status', $output);
      }


   


      public function destroy(SupportReplay $comment){

        if($comment->file){
          $path = $comment->file? public_path($comment->file) : null;
          if(file_exists($path)){
              unlink($path);
          }
      }
      $comment->delete();
          $output = ['success' => 1,
          'msg' => __('comment.deletet_success')
        ];
        return back()->with('status', $output);
      }
}
