<?php

namespace App\Http\Controllers;

use App\Business;
use App\BusinessLocation;
use App\Contact;
use App\SupportReplay;
use App\SupportTicket;
use App\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


use App\Utils\Util;

class SupportAdminController extends Controller
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
      $business = Business::latest()->pluck('name','id')->toArray();
      $status = SupportTicket::STATUS ; 

      return view('support.support_admin.index')->with(compact('users', 'business', 'status'));
    }


    public  function data()
    {
      $business_id = request()->session()->get('user.business_id');
      
        $query = SupportTicket::latest();
      
      
        //  filter by location_id
       if(request('business_id')){
            $business_id = request('business_id');
            $query->where('business_id',  $business_id);
      }
      //filter by sr_status
       if(request('sr_status')){
            $query->where('status', request('sr_status'));
      }
      //filter by date
       if(request('start_date') && request('end_date')){
            $query->whereBetween('date', [request('start_date') , request('end_date')] );
      }
    
        $tickets = $query->latest();
        return Datatables::of($tickets)
            ->addColumn(
                'action',
                function (SupportTicket $ticket) {
                  $html = '<span style="display:flex;flex-direction: row-reverse;">';
                  if (auth()->user()->can('ticket_view')) {
                    $html .= '<a class="btn btn-primary" style="margin:0px 5px;" href="'.route("support_admin.show.ticket", $ticket->id).'">عرض</a> ' ;
                  }
                  if (auth()->user()->can('delete_ticket')) {
                  $html .= '<a class="btn btn-danger" style="margin:0px 5px;" href="'.route("support_admin.destroy.ticket", $ticket->id).'">حذف</a></span> ' ;
                  }
                  return $html ;
                }
            )
            ->removeColumn('id')
            ->editColumn('business_id' , function($row){
              return $row->business->name;
            })
            ->rawColumns(['action'])
            ->toJson();
    }
  
    public function show(SupportTicket $ticket)
    {
      $resource = $ticket;
      $comments = SupportReplay::where('ticket_id',$ticket->id)->get();
      
      $status = SupportTicket::STATUS ; 
      return view('support.support_admin.show',compact('resource','comments' ,'status'));
    }


    public function destroy(SupportTicket $ticket){

      if($ticket->file){
        $path = $ticket->file? public_path($ticket->file) : null;
        if(file_exists($path)){
            unlink($path);
        }
    }
    $ticket->delete();
        $output = ['success' => 1,
        'msg' => __('ticket.deletet_success')
      ];
      return back()->with('status', $output);
    }


    public function updateStatus(Request $request){
      SupportTicket::where('id', $request->id)->first()->update([
        'status'=> $request->status
      ]);  
      return response()->json([
        "res"=>['status'=>true , 'href'=> route('support_admin.show.ticket',$request->id )],
     ]);
    }
}
