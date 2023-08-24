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

class SupportController extends Controller
{
    

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $business_id = $request->session()->get('user.business_id');
      $users = User::allUsersDropdown($business_id, false);
      $business_locations = BusinessLocation::forDropdown($business_id, true);

      return view('support.support_customer.index')->with(compact('users', 'business_locations'));
    }


    public  function data()
    {
      $business_id = request()->session()->get('user.business_id');
      
        $query = SupportTicket::where('business_id' , $business_id)->latest();
      
        $tickets = $query->latest();
        return Datatables::of($tickets)
            ->addColumn(
                'action',
                function (SupportTicket $ticket) {
                    $html = '<span style="display:flex;flex-direction: row-reverse;">';
                    if (auth()->user()->can('delete_ticket')) {
                      $html .= '<a class="btn btn-danger" style="margin:0px 5px;" href="'.route("support_admin.destroy.ticket", $ticket->id).'">حذف</a> ' ;
                    }
                    if (auth()->user()->can('edit_ticket')) {
                    $html .= '<span style="display:flex;flex-direction: row-reverse;"><a class="btn btn-info" href="'.route("support_customer.edit.ticket", $ticket->id).'">تعديل</a>' ;
                    }
                    if (auth()->user()->can('ticket_view')) {
                    $html .= '<a class="btn btn-primary" style="margin:0px 5px;" href="'.route("support_customer.show.ticket", $ticket->id).'">عرض</a> </span>' ;
                    }
                    return $html ;
                }
            )
           
            ->rawColumns(['action'])
            ->toJson();
    }
    /**
     * Create a resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
      {
        $business_id = request()->session()->get('user.business_id');
        $resource = New SupportTicket();
        
        $priority = SupportTicket::$PRIORITY ; 
        return view('support.support_customer.form',compact('resource' , 'priority'));
      }


    public function edit(SupportTicket $ticket)
    {
      $business_id = request()->session()->get('user.business_id');
      $resource = $ticket;
      
      $priority = SupportTicket::$PRIORITY ; 
      return view('support.support_customer.form',compact('resource' , 'priority'));
    }

    public function show(SupportTicket $ticket)
    {
      $business_id = request()->session()->get('user.business_id');
      $resource = $ticket;
      $comments = SupportReplay::where('ticket_id',$ticket->id)->get();
      
      // $status = SupportTicket::STATUS ; 
      return view('support.support_customer.show',compact('resource','comments'));
    }


      public function store(Request $request){

        $inputs = $request->except('file');
        $inputs['business_id'] = request()->session()->get('user.business_id');
        $inputs['user_id'] = auth()->user()->id;
        $inputs['date'] = date('Y-m-d');
        if ($request->file) {
          $inputs['file'] = uploadFile($request->file , 'uploads/supported/files/');
        }
        // dd($inputs);
        SupportTicket::create($inputs);
        $output = ['success' => 1,
          'msg' => __('product.added_success')
        ];
        return redirect(route('support_customer.index'))->with('status', $output);
      }


      public function update(Request $request , SupportTicket $ticket){

        $inputs = $request->except('file');
        if ($request->file) {
          $inputs['file'] = uploadFile($request->file , 'uploads/supported/files/');
        }
        // dd($inputs);
        $ticket->update($inputs);
        $output = ['success' => 1,
          'msg' => __('product.updated_success')
        ];
        return redirect(route('support_customer.index'))->with('status', $output);
      }
}