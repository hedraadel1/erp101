<?php

namespace Modules\ProductCatalogue\Http\Controllers;

use App\Contact;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
  public function viewLogin(){
    $value = ['business_id' =>request()->business_id , 'location_id'=>request()->location_id];
    session(['catalog' => $value]);
    return view('productcatalogue::auth.login');
  }
  public function getRegister(){
    return view('productcatalogue::auth.register');
  }


   /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    
     public function login(Request $request) {

      $request->validate([
          'username' => 'required',
          'password' => 'required'
      ]);

      $credentials = $request->only('username', 'password');
      $user = User::where('username',$request->username)->first();

      if(isset($user)){
          if ($user->status != 'active') {
              Auth::logout();
              return redirect(route('product_catalogue.login'))
              ->with(
                  'status',
                  ['success' => 0, 'msg' => __('lang_v1.user_inactive')]
              );
          } elseif (!$user->allow_login) {
              Auth::logout();
              return redirect(route('product_catalogue.login'))
                  ->with(
                      'status',
                      ['success' => 0, 'msg' => __('lang_v1.login_not_allowed')]
                  );
          } elseif (($user->user_type != 'user_customer')){
              Auth::logout();
              return redirect(route('product_catalogue.login'))
                  ->with(
                      'status',
                      ['success' => 0, 'msg' => __('lang_v1.login_not_allowed ')]
                  );
          }
          elseif (auth()->attempt($credentials)) {
              // Auth::logout();

              return redirect(route('catalogue.view' ,[$user->business_id , $user->location_id]));
          }
          else{
              session()->flash('error', 'Invalid credentials');
              return back();
          }
      }else{
              session()->flash('error', 'Invalid credentials');
              return back();
          }

  }

   /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
          'username' => 'required|unique:users,username',
        ], [
          'username.unique'=> 'أسم المستخدم موجود مسبقا',
      ]);

        try {
            $input = $request->only( 'surname', 'first_name', 'last_name', 'email', 'username', 'password', 'contact_number', 'alt_number', 'family_number', 'crm_department', 'crm_designation');

            $input['status'] = !empty($request->input('is_active')) ? 'active' : 'inactive';

            $input['business_id'] = session('catalog.business_id');
            $input['location_id'] = session('catalog.location_id');
            $input['allow_login'] = 1;
            
            $user = $this->creatContactPerson($input);

            $output = [
                'success' => true,
                'msg' => __('lang_v1.success')
            ];
        } catch (Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

            $output = [
                'success' => false,
                'msg' => __('messages.something_went_wrong')
            ];
        }

        return redirect(route('product_catalogue.login'))->with(['status'=>$output]);
    }




    public function creatContactPerson($input)
    {
        $input['password'] = Hash::make($input['password']);
        $input['user_type'] = 'user_customer';

        if (empty($input['allow_login'])) {
            $input['password'] = null;
            $input['username'] = null;
            $input['allow_login'] = 0;
        }
        $user_defualt = User::where('business_id' , $input['business_id'])->first();
        $contact = Contact::create([
          'business_id' => $input['business_id'],
          'mobile' => $input['contact_number'],
          'type' => 'customer',
          'created_by' => $user_defualt->id
        ]);
        $input['crm_contact_id'] = $contact->id;
        // Create the user
        $user = User::create($input);
    }
}