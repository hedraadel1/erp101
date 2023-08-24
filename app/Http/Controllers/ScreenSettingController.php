<?php

namespace App\Http\Controllers;

use App\UserSettingScreen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScreenSettingController extends Controller
{
    private $setting;
    public function __construct(UserSettingScreen $setting)
    {
        $this->setting = $setting;

    }

    public function setting(Request $request)
    {

        DB::transaction(function () use ($request) {
            $data = $request->except('data');
            $screenSetting = $this->setting->where('user_id', $data['user_id'])->where('screen', $data['screen'])->first();
            $data['data_json'] = json_encode($request->data);
            // dd($data);
            if (!$screenSetting) {
                $this->setting->create($data);
            } else {
                $screenSetting->update($data);
            }
          });
          $output = [
            'success' => 1,
                'msg' => 'تم تعديل بنجاح'
        ];
         return back()->with(['status'=>$output]);

       
    }

    public function getSetting($screen)
    {
      // dd($screen);
        $model = $this->setting->where('user_id', auth()->user()->id)->where('screen', $screen)->first();
        $setting = [];
        if($model){
          $setting = json_decode($model->data_json) ;
        } 
        return response()->json(['setting' => $setting]);

    }
}
