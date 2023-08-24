<?php

namespace App\Http\Controllers;

use App\Account;
use App\AccountSetting;
use App\AccountType;
use App\BusinessLocation;
use Illuminate\Http\Request;
use DB;
class AccountSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->can('account.access')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = session()->get('user.business_id');
        $chart_of_accounts = Account::where('business_id', session('business.id'))->where('is_closed', 0)->get();
        $business_locations = BusinessLocation::forDropdown( request()->session()->get('user.business_id'), true);
        $map_seetings = AccountSetting::where('business_id', session('business.id'))->latest()->get();


        return view('account.map_settings.create')
                ->with(compact('map_seetings','chart_of_accounts','business_locations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('account.access')) {
            abort(403, 'Unauthorized action.');
        }
        try {
          $validated = $request->validate([
            'account_id' => ['required'],
            'name' => ['required'],
            'location_id' => ['nullable'],
            'is_sell' => ['nullable'],
            'is_purchase' => ['nullable'],
            'is_salaries' => ['nullable'],
            'is_expenses' => ['nullable'],
            'is_sell_paid' => ['nullable'],
            'is_purchase_paid' => ['nullable'],
            'is_expenses_paid' => ['nullable'],
            'is_salaries_paid' => ['nullable'],
            'is_expenses_return' => ['nullable'],
            'is_expenses_return_paid' => ['nullable'],
            'type' => ['nullable'],
            'is_customer_payments' => ['nullable'],
            'is_supplier_payments' => ['nullable'],
            'is_customer_payments_debit' => ['nullable'],
          'is_supplier_payments_debit' => ['nullable'],
        ]);
        $validated['business_id'] = session('business.id');
       
            AccountSetting::create($validated);
            $output = ['success' => true,
                            'msg' => __("lang_v1.added_success")
                        ];
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            $output = ['success' => false,
                            'msg' => __("messages.something_went_wrong")
                        ];
        }

        return redirect()->back()->with('status', $output);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AccountType  $accountType
     * @return \Illuminate\Http\Response
     */
    public function show(AccountType $accountType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AccountType  $accountType
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!auth()->user()->can('account.access')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = session()->get('user.business_id');
        $map_setting = AccountSetting::findOrfail($id);
        $map_seetings = AccountSetting::where('business_id', session('business.id'))->latest()->get();
        $chart_of_accounts = Account::where('business_id', session('business.id'))->where('is_closed', 0)->get();

        $business_locations = BusinessLocation::forDropdown( request()->session()->get('user.business_id'), true);
        return view('account.map_settings.edit')
                ->with(compact('map_setting', 'map_seetings','chart_of_accounts','business_locations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AccountType  $accountType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!auth()->user()->can('account.access')) {
            abort(403, 'Unauthorized action.');
        }
        try {
          $validated = $request->validate([
            'account_id' => ['required'],
            'name' => ['required'],
            'location_id' => ['nullable'],
            'is_sell' => ['nullable'],
            'is_purchase' => ['nullable'],
            'is_salaries' => ['nullable'],
            'is_expenses' => ['nullable'],
            'is_sell_paid' => ['nullable'],
            'is_purchase_paid' => ['nullable'],
            'is_expenses_paid' => ['nullable'],
            'is_salaries_paid' => ['nullable'],
            'is_expenses_return' => ['nullable'],
            'is_expenses_return_paid' => ['nullable'],
            'type' => ['nullable'],
            'is_customer_payments' => ['nullable'],
            'is_supplier_payments' => ['nullable'],
            'is_customer_payments_debit' => ['nullable'],
          'is_supplier_payments_debit' => ['nullable'],
          ]);
          $validated['business_id'] = session('business.id');
          // dd($validated);

          DB::beginTransaction();
          AccountSetting::findOrFail($id)->delete();
          AccountSetting::create($validated);
          DB::commit();
                      
            $output = ['success' => true,
                            'msg' => __("lang_v1.updated_success")
                        ];
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            // dd($e);
            $output = ['success' => false,
                            'msg' => __("messages.something_went_wrong")
                        ];
        }

        return redirect()->back()->with('status', $output);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AccountType  $accountType
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!auth()->user()->can('account.access')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = session()->get('user.business_id');
        AccountSetting::where('business_id', $business_id)
                                     ->where('id', $id)
                                     ->delete();
        $output = ['success' => true,
                            'msg' => __("lang_v1.deleted_success")
                        ];

        return redirect()->back()->with('status', $output);
    }
}
