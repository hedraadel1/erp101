<?php

namespace App\Http\Controllers;

use App\Agent;
use App\AgentDetails;
use App\BusinessLocation;
use App\EducationCategory;
use App\EducationVideo;
use App\Errand;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class EducationVideoController extends Controller
{

  public function index(Request $request)
  {
    $query = EducationCategory::has('videos')->latest();

    if ($request->category_id) {
      $query->where('id',$request->category_id);
    }
    if ($request->search) {
      $query->where('name','like','%'.$request->search .'%');
      $query->orWhereHas('videos', function ($q) use ($request){
        $q->where('name', 'like', '%' . $request->search . '%');
     });
    }
    $category_videos = $query->paginate(20);
    $categories = EducationCategory::latest()->pluck('name','id')->toArray();
    return view('education_videos.index')->with(compact('category_videos','categories'));
  }


  public function show($id)
  {
    $video = EducationVideo::findOrFail($id);
    
    return view('education_videos.show')->with(compact('video'));
  }

  public function showCategoryVideos($id)
  {
    $category_videos = EducationCategory::findOrFail($id);
    
    return view('education_videos.category_videos')->with(compact('category_videos'));
  }
      
}