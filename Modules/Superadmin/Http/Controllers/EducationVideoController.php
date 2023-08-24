<?php

namespace Modules\Superadmin\Http\Controllers;

use App\EducationCategory;
use App\EducationVideo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DB;
use Yajra\DataTables\Facades\DataTables;

class EducationVideoController extends BaseController
{
  public function index()
  {
    if (request()->ajax()) {
    $videos = EducationVideo::latest()->get();
      return DataTables::of($videos)
              ->addColumn(
                'action',
                function($row){
                  return '
                      <a role="button" data-href="'.action('\Modules\Superadmin\Http\Controllers\EducationVideoController@edit', $row->id).'" class="btn btn-xs btn-primary btn-modal" data-container=".education_category_modal"><i class="glyphicon glyphicon-edit"></i>'. __("messages.edit").'</a>
                      &nbsp;
                      <button data-href="'.action('\Modules\Superadmin\Http\Controllers\EducationVideoController@destroy', $row->id).'" class="btn btn-xs btn-danger delete_education_video_button"><i class="glyphicon glyphicon-trash"></i> '.__("messages.delete").'</button>';
                }
              )
              ->editColumn('id', function ($row) {
                
                return $row->id.' #' ;
              })
              ->editColumn('category_id', function ($row) {
                return optional($row->category)->name;
              })
              // ->removeColumn('id')
              ->rawColumns(['action'])
              ->make(true);
    }
    return view('superadmin::education_learn.education_categories.index');
  }


   public function create()
  {
    $video = new EducationVideo();
    $categories = EducationCategory::latest()->pluck('name','id')->toArray();
    return view('superadmin::education_learn.education_videos.form',compact('video','categories'));
  }
  

  public function show()
  {

  }
  public function store(Request $request)
  {
    $inputs = $request->except('video');
    try {
      if (!empty($request->video) ) {
      $inputs['video'] = uploadFile($request->video,'uploads/education-learn/');
      }
      // dd($inputs);
      EducationVideo::create($inputs);
      $output = ['success' => true,
                  'msg' => __("lang_v1.success")
              ];
    }catch (\Exception $e) {
      \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
      dd($e);
      $output = ['success' => false,
                  'msg' => __("messages.something_went_wrong")
              ];
    }
    return $output;
  }

  public function edit($id)
  {
    $video =  EducationVideo::findOrFail($id);
    $categories = EducationCategory::latest()->pluck('name','id')->toArray();
    return view('superadmin::education_learn.education_videos.form',compact('video','categories'));
  }

  public function update(Request $request, $id)
  {
    $inputs = $request->except('video');
    try {
      $video =  EducationVideo::findOrFail($id);
      if (!empty($request->video) ) {
        if ($video->video) {
          $path = $video->video? public_path($video->video) : null;
            if(file_exists($path)){
                unlink($path);
            }
        }
        $inputs['video'] = uploadFile($request->video,'uploads/education-learn/');
      }
      // dd($inputs);
     $video->update($inputs);
      $output = ['success' => true,
                  'msg' => __("lang_v1.success")
              ];
    }catch (\Exception $e) {
      \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
      dd($e);
      $output = ['success' => false,
                  'msg' => __("messages.something_went_wrong")
              ];
    }
    return $output;
  }


  public function destroy($id)
  {
    if (request()->ajax()) {
      try {

          $video = EducationVideo::findOrFail($id);
            $path = $video->video? public_path($video->video) : null;
            if(file_exists($path)){
                unlink($path);
            }
            $video->delete();
          $output = ['success' => true,
                      'msg' => __("lang_v1.success")
                      ];
      } catch (\Exception $e) {
          \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
      
          $output = ['success' => false,
                      'msg' => __("messages.something_went_wrong")
                  ];
      }

      return $output;
  }
  }

}
