<?php

namespace Modules\Superadmin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use DB;

use Modules\Superadmin\Entities\SuperadminContent;

class ContentController extends BaseController
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        if (!auth()->user()->can('superadmin')) {
            abort(403, 'Unauthorized action.');
        }

        $content = SuperadminContent::latest()->first();;

        return view('superadmin::content.index')
                ->with(compact('content'));
    }

    /**
     * Sends notification to the required business owners.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('superadmin')) {
            abort(403, 'Unauthorized action.');
        }

        //Disable in demo
        if (config('app.env') == 'demo') {
            $output = ['success' => 0,
                            'msg' => 'Feature disabled in demo!!'
                        ];
            return back()->with('status', $output);
        }
        
        $input = $request->input();
        $content = SuperadminContent::first();
        if($content){
         $content->update([
            'description' => $input['description']
        ]);
        DB::table('content_users')->delete();
        }else{
          SuperadminContent::create([
            'description' => $input['description']
        ]);
        DB::table('content_users')->delete();
        }

        $output = ['success' => 1,
                    'msg' => __('lang_v1.success')
                ];
                
        return back()->with('status', $output);
    }

    public function hide(Request $request){
     DB::table('content_users')->insert([
      'user_id' => auth()->user()->id,
      'content_id' => $request['content_id']
     ]);
     return response()->json('true');
    }

}
