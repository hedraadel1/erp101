<?php

namespace Modules\Connector\Http\Controllers\Api\Essentail;

use App\Business;
use App\Media;
use App\ReferenceCount;
use App\Utils\ModuleUtil;
use App\Utils\Util;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\View;
use Modules\Connector\Http\Controllers\Api\ApiController;
use Modules\Connector\Http\Requests\StoreTaskToDo;
use Modules\Connector\Http\Requests\UploadDocument;
use Modules\Connector\Transformers\ToDoResource;
use Modules\Essentials\Entities\EssentialsTodoComment;
use Modules\Essentials\Entities\ToDo;
use Spatie\Activitylog\Models\Activity;

use DB;
class ToDoController extends ApiController
{


   /**
     * All Utils instance.
     *
     */
    protected $commonUtil;
    protected $moduleUtil;

    /**
     * Constructor
     *
     * @param CommonUtil
     * @return void
     */
    public function __construct(Util $commonUtil, ModuleUtil $moduleUtil)
    {
        $this->commonUtil = $commonUtil;
        $this->moduleUtil = $moduleUtil;

        $this->priority_colors = [
            'low' => 'bg-green',
            'medium' => 'bg-yellow',
            'high' => 'bg-orange',
            'urgent' => 'bg-red'
        ];

        $this->status_colors = [
            'new' => 'bg-yellow',
            'in_progress' => 'bg-light-blue',
            'on_hold' => 'bg-red',
            'completed' => 'bg-green'
        ];
    }


  public function index()
    {
        $user = auth()->user();
        $business_id = $user->business_id; 
        // dd($user);       
        $todos = ToDo::where('business_id', $business_id)
                        ->with(['project','users', 'assigned_by'])
                        ->latest()->get();
        return ToDoResource::collection($todos);
    }



    /**
     * Show the specified resource.
     * @return Response
     */
    public function show($id)
    {
      $user = auth()->user();
      $business_id = $user->business_id; 

        // if (!(auth()->user()->can('superadmin') || $this->moduleUtil->hasThePermissionInSubscription($business_id, 'essentials_module'))) {
        //     abort(403, 'Unauthorized action.');
        // }

        $is_admin = $this->moduleUtil->is_admin(auth()->user(), $business_id);

        $query = ToDo::where('business_id', $business_id)
                    ->with([
                        'assigned_by',
                        'comments',
                        'comments.added_by',
                        'media',
                        'users',
                        'media.uploaded_by_user'
                    ]);

        //If not admin show only assigned task
        if (!$is_admin) {
            $query->where(function ($query) {
                $query->where('created_by', auth()->user()->id)
                    ->orWhereHas('users', function ($q) {
                        $q->where('user_id', auth()->user()->id);
                    });
            });
        }
        
        // dd($query->where('id',$id)->first());
        $todo = $query->where('id',$id)->first();
        if ($todo) {
          return  response()->json(['status'=> 200,'data'=>new ToDoResource($todo)]);
        } else {
          return  response()->json(['status'=> 200,'data'=>'not found']);
        }
        
    }

     /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(StoreTaskToDo $request)
    {
      try{
      $user = auth()->user();
      $business_id = $user->business_id; 
      $created_by = $user->id;
      $input = $request->validated();
          $input['date'] = $this->uf_date($input['date'], true , $business_id);
          $input['end_date'] = !empty($input['end_date']) ? $this->uf_date($input['end_date'], true, $business_id) : null;
          $input['business_id'] = $business_id;
          $input['created_by'] = $created_by;
          $input['status'] = !empty($input['status']) ? $input['status'] : 'new';
        if (isset($input['users'])) {
          unset($input['users']);
        }
          $users = $request->input('users');
          //Can add only own tasks if permission not given
          if (!auth()->user()->can('essentials.assign_todos') || empty($users)) {
              $users = [$created_by];
          }

          $ref_count = $this->setAndGetReferenceCount('essentials_todos' , $business_id);
          //Generate reference number
          $business = Business::where('id' , $business_id)->first();
          $settings =$business->essentials_settings;
          $settings = !empty($settings) ? json_decode($settings, true) : [];
          $prefix = !empty($settings['essentials_todos_prefix']) ? $settings['essentials_todos_prefix'] : '';
          $input['task_id'] = $this->generateReferenceNumber('essentials_todos', $ref_count, $business_id, $prefix);
          // dd($input);

          $to_dos = ToDo::create($input);

          $to_dos->users()->sync($users);

          //Exclude created user from notification
          $users = $to_dos->users->filter(function ($item) use ($created_by) {
              return $item->id != $created_by;
          });

          $this->commonUtil->activityLog($to_dos, 'added');
          foreach ($users as $key => $value) {
            $curl = curl_init();

            $message = " لقد تم اسناد تاسك جديدة لك بعنوان  :" .$to_dos->task .    ' من خلال ' . $to_dos->assigned_by->getUserFullNameAttribute() .'يجب تنفيذها قبل '  . $to_dos->end_date;
            curl_setopt_array($curl, array(
              CURLOPT_URL => 'http://wha22.gyral.link/public/api/create-message',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS => array(
              'appkey' => 'a2f79db5-85a2-46bb-9a5e-4b3b89833de6',
              'authkey' => '8y7ua568PHD4J765AxYBNrGyfc23ZqBtFctUNicOohR4E8wVqz',
              'to' =>'+'.$value->contact_number,,
              'message' => action('\Modules\Essentials\Http\Controllers\ToDoController@show', $to_dos->id) . '   '.             $message ,
              'sandbox' => 'false'
              ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            // dd( $response);
            // Notification::route('mail',[$value->email =>$value->getUserFullNameAttribute()])->notify( new AddNewTaskNotification($to_dos));
          }
          return  response()->json(['status'=> 200,'data'=>'done']);
        } catch (\Exception $exception) {
          return  response()->json(['status'=>$exception->getCode(),'data'=>$exception->getMessage()]);
      }

           
    }
  
   /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(StoreTaskToDo $request, $id)
    {
      $user = auth()->user();
      $business_id = $user->business_id; 
        // if (!(auth()->user()->can('superadmin') || $this->moduleUtil->hasThePermissionInSubscription($business_id, 'essentials_module'))) {
        //     abort(403, 'Unauthorized action.');
        // }

            try {
                if (!$request->has('only_status')) {
                    $input = $request->validated();

                    $input['date'] = $this->uf_date($input['date'], true,$business_id);
                    $input['end_date'] = !empty($input['end_date']) ? $this->uf_date($input['end_date'], true,$business_id) : null;

                    $input['status'] = !empty($input['status']) ? $input['status'] : 'new';
                } else {
                    $input = [ 'status' => !empty($request->input('status')) ? $request->input('status') : null];
                }

                $query = ToDo::where('business_id', $business_id);

                //Non admin can update only assigned tasks
                $is_admin = $this->moduleUtil->is_admin(auth()->user(), $business_id);
                if (!$is_admin) {
                    $query->where(function ($query) {
                        $query->where('created_by', auth()->user()->id)
                            ->orWhereHas('users', function ($q) {
                                $q->where('user_id', auth()->user()->id);
                            });
                    });
                }

                if (isset($input['users'])) {
                  unset($input['users']);
                }
                $todo = $query->findOrFail($id);

                $todo_before = $todo->replicate();

                $todo->update($input);

                if (auth()->user()->can('essentials.assign_todos') && !$request->has('only_status')) {
                    $users = $request->input('users');
                    $todo->users()->sync($users);
                }
               

                $this->commonUtil->activityLog($todo, 'edited', $todo_before);

                return  response()->json(['status'=> 200,'data'=>'done']);
              } catch (\Exception $exception) {
                return  response()->json(['status'=>$exception->getCode(),'data'=>$exception->getMessage()]);
            }

        
    }

    public function update_Status(Request $request  , $id){
      $user = auth()->user();
      $business_id = $user->business_id; 
      $query = ToDo::where('business_id', $business_id);
      $todo = $query->findOrFail($id);
      $input = [ 'status' => !empty($request->input('status')) ? $request->input('status') : null];
      $todo_before = $todo->replicate();
      $todo->update($input);
      // dd($todo->users);
      $this->commonUtil->activityLog($todo, 'edited', $todo_before);

      $activity = Activity::forSubject($todo)
      ->with(['causer', 'subject'])
      ->latest()
      ->first();
    //  dd($activity);
        foreach ($todo->users as  $value) {
          // dd($activity->causer->getUserFullNameAttribute());
          $curl = curl_init();
          $message = " لقد قام  :" .  optional($activity->causer)->user_full_name  .    'بتغير حالة تاسك ' . $todo->task .    ' الي حالة ' . $todo->status ;

          curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://wha22.gyral.link/public/api/create-message',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
            'appkey' => 'a2f79db5-85a2-46bb-9a5e-4b3b89833de6',
            'authkey' => '8y7ua568PHD4J765AxYBNrGyfc23ZqBtFctUNicOohR4E8wVqz',
            'to' =>'+'.$value->contact_number,,
            'message' => action('\Modules\Essentials\Http\Controllers\ToDoController@show', $todo->id) .  '        ' . $message ,
            'sandbox' => 'false'
            ),
          ));

          $response = curl_exec($curl);

          curl_close($curl);                
        }
  
        return  response()->json(['status'=> 200,'data'=>'done']);
    }
    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
      $user = auth()->user();
      $business_id = $user->business_id;
        // if (!(auth()->user()->can('superadmin') || $this->moduleUtil->hasThePermissionInSubscription($business_id, 'essentials_module'))) {
        //     abort(403, 'Unauthorized action.');
        // }

            try {
                $is_admin = $this->moduleUtil->is_admin(auth()->user(), $business_id);

                $query = ToDo::where('business_id', $business_id);
               
                  //Can destroy only own created tasks if not admin
                  if (!$is_admin) {
                    $query->where('created_by', auth()->user()->id);
                  }
                  $todo = $query->where('id', $id)->first();
                if ($todo) {
                  $todo->delete();
                  return  response()->json(['status'=> 200,'data'=>'done']);
                }else{
                  return  response()->json(['status'=> 202,'data'=>'not found']);
                }
            } catch (\Exception $exception) {
              return  response()->json(['status'=>$exception->getCode(),'data'=>$exception->getMessage()]);
          }
      
    }


   /**
     * Add comment to the task
     * @param  Request $request
     * @return Response
     */
    public function addComment(Request $request)
    {
      $user = auth()->user();
      $business_id = $user->business_id;
        if (!(auth()->user()->can('superadmin') || $this->moduleUtil->hasThePermissionInSubscription($business_id, 'essentials_module'))) {
            abort(403, 'Unauthorized action.');
        }
            try {
                $input = $request->only(['task_id', 'comment']);
                $query = ToDo::where('business_id', $business_id)
                            ->with('users');
                $auth_id = $user->id;

                //Non admin can add comment to only assigned tasks
                $is_admin = $this->moduleUtil->is_admin(auth()->user(), $business_id);
                if (!$is_admin) {
                    $query->where(function ($query) {
                        $query->where('created_by', auth()->user()->id)
                            ->orWhereHas('users', function ($q) {
                                $q->where('user_id', auth()->user()->id);
                            });
                    });
                }

                $todo = $query->findOrFail($input['task_id']);

                $input['comment_by'] = $auth_id;

                $comment = EssentialsTodoComment::create($input);

                $comment_html = View::make('essentials::todo.comment')
                                ->with(compact('comment'))
                                ->render();
                $output = [
                          'success' => true,
                          'comment_html' => $comment_html,
                          'msg' => __('lang_v1.success')
                        ];

                //Remove auth user from users collection
                $users = $todo->users->filter(function ($user) use ($auth_id) {
                    return $user->id != $auth_id;
                });
                foreach ($users as $key => $value) {
                  $curl = curl_init();
                  $message = " لقد قام  :" .$comment->added_by->getUserFullNameAttribute() .    'بالرد علي التاسك ' . $comment->task->name ;

                  curl_setopt_array($curl, array(
                    CURLOPT_URL => 'http://wha22.gyral.link/public/api/create-message',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => array(
                    'appkey' => 'a2f79db5-85a2-46bb-9a5e-4b3b89833de6',
                    'authkey' => '8y7ua568PHD4J765AxYBNrGyfc23ZqBtFctUNicOohR4E8wVqz',
                    'to' =>'+'.$value->contact_number,,
                    'message' => action('\Modules\Essentials\Http\Controllers\ToDoController@show', $comment->task->id) .  '        ' . $message ,
                    'sandbox' => 'false'
                    ),
                  ));
      
                  $response = curl_exec($curl);
      
                  curl_close($curl);                
                }
                return  response()->json(['status'=> 200,'data'=>'done']);
              } catch (\Exception $exception) {
                return  response()->json(['status'=>$exception->getCode(),'data'=>$exception->getMessage()]);
            }

    }

    /**
     * Delete comment of a task
     * @param  int $id
     * @return Response
     */
    public function deleteComment($id)
    {
        // $business_id = request()->session()->get('user.business_id');
        // if (!(auth()->user()->can('superadmin') || $this->moduleUtil->hasThePermissionInSubscription($business_id, 'essentials_module'))) {
        //     abort(403, 'Unauthorized action.');
        // }

        try {
            $comment = EssentialsTodoComment::where('comment_by', auth()->user()->id)
                                    ->where('id', $id)
                                    ->first();
            if ($comment) {
              $comment->delete();
              return  response()->json(['status'=> 200,'data'=>'done']);
            }else{
              return  response()->json(['status'=> 202,'data'=>'not found']);
            }
        } catch (\Exception $exception) {
          return  response()->json(['status'=>$exception->getCode(),'data'=>$exception->getMessage()]);
      }
    }


 /**
     * Upload documents for a task
     * @param  Request $request
     * @return Response
     */
    public function uploadDocument(UploadDocument $request)
    {
      $user = auth()->user();
      $business_id = $user->business_id;
        if (!(auth()->user()->can('superadmin') || $this->moduleUtil->hasThePermissionInSubscription($business_id, 'essentials_module'))) {
            abort(403, 'Unauthorized action.');
        }

        try {
          $input = $request->validated();
          // dd($input);
            $task_id = $input['task_id'];
            $query = ToDo::with('users')->where('business_id', $business_id);
            $auth_id = $user->id;

            //Non admin can add comment to only assigned tasks
            $is_admin = $this->moduleUtil->is_admin($user, $business_id);
            if (!$is_admin) {
                $query->where(function ($query) {
                    $query->where('created_by', $user->id)
                        ->orWhereHas('users', function ($q) {
                            $q->where('user_id', $user->id);
                        });
                });
            }

            $todo = $query->findOrFail($task_id);

            Media::uploadMedia($todo->business_id, $todo, $request, 'documents');

            //Remove auth user from users collection
            $users = $todo->users->filter(function ($user) use ($auth_id) {
                return $user->id != $auth_id;
            });

            // $data = [
            //     'task_id' => $todo->task_id,
            //     'uploaded_by' => $auth_id,
            //     'id' => $todo->id,
            //     'uploaded_by_user_name' => $user->user_full_name
            // ];

            // \Notification::send($users, new NewTaskDocumentNotification($data));

            return  response()->json(['status'=> 200,'data'=>'done']);
          } catch (\Exception $exception) {
            return  response()->json(['status'=>$exception->getCode(),'data'=>$exception->getMessage()]);
        }
    }

 /**
     * Delete comment of a task
     * @param  int $id
     * @return Response
     */
    public function deleteDocument($id)
    {
       
        // if (!(auth()->user()->can('superadmin') || $this->moduleUtil->hasThePermissionInSubscription($business_id, 'essentials_module'))) {
        //     abort(403, 'Unauthorized action.');
        // }

        try {
            $media = Media::findOrFail($id);
            if ($media->model_type == 'Modules\Essentials\Entities\ToDo') {
              $todo = ToDo::findOrFail($media->model_id);
              

                //Can delete document only if task is assigned by or assigned to the user
                // dd($media->display_path);
                if (in_array(auth()->user()->id, [$todo->user_id, $todo->created_by])) {
                  if ($media->display_path) {
                    unlink($media->display_path);
                  }
                    $media->delete();
                }
            }
            return  response()->json(['status'=> 200,'data'=>'done']);
          } catch (\Exception $exception) {
            return  response()->json(['status'=>$exception->getCode(),'data'=>$exception->getMessage()]);
        }
    }



    private function generateReferenceNumber($type, $ref_count, $business_id = null, $default_prefix = null)
    {
        $prefix = '';

        // if (session()->has('business') && !empty(request()->session()->get('business.ref_no_prefixes')[$type])) {
        //     $prefix = request()->session()->get('business.ref_no_prefixes')[$type];
        // }
        if (!empty($business_id)) {
            $business = Business::find($business_id);
            $prefixes = $business->ref_no_prefixes;
            $prefix = !empty($prefixes[$type]) ? $prefixes[$type] : '';
        }

        if (!empty($default_prefix)) {
            $prefix = $default_prefix;
        }

        $ref_digits =  str_pad($ref_count, 4, 0, STR_PAD_LEFT);

        if (!in_array($type, ['contacts', 'business_location', 'username'])) {
            $ref_year = \Carbon::now()->year;
            $ref_number = $prefix . $ref_year . '/' . $ref_digits;
        } else {
            $ref_number = $prefix . $ref_digits;
        }

        return $ref_number;
    }

    
    private function setAndGetReferenceCount($type, $business_id = null)
    {
        $ref = ReferenceCount::where('ref_type', $type)
            ->where('business_id', $business_id)
            ->first();
        if (!empty($ref)) {
            $ref->ref_count += 1;
            $ref->save();
            return $ref->ref_count;
        } else {
            $new_ref = ReferenceCount::create([
                'ref_type' => $type,
                'business_id' => $business_id,
                'ref_count' => 1
            ]);
            return $new_ref->ref_count;
        }
    }

    private function uf_date($date, $time = false , $business_id)
    {
      $business = Business::where('id',$business_id)->first();
        $date_format = $business->date_format;
        $mysql_format = 'Y-m-d';
        if ($time) {
            if ($business->time_format == 12) {
                $date_format = $date_format . ' h:i A';
            } else {
                $date_format = $date_format . ' H:i';
            }
            $mysql_format = 'Y-m-d H:i:s';
        }

        return !empty($date_format) ? Carbon::createFromFormat($date_format, $date)->format($mysql_format) : null;
    }
  
}