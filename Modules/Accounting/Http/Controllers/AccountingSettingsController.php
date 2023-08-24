<?php

namespace Modules\Accounting\Http\Controllers;

use Modules\Accounting\Services\FlashService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Accounting\Entities\AccountDetailType;
use Modules\Accounting\Entities\AccountMapSetting;
use Modules\Accounting\Entities\AccountSubtype;
use Modules\Accounting\Entities\AccountType;
use Modules\Accounting\Entities\ChartOfAccount;

class AccountingSettingsController extends Controller
{
    public function detail_types()
    {
        $account_detail_types = AccountDetailType::forBusiness()->with('account_subtype')->get();

        $account_subtypes = AccountSubtype::forBusiness()->active()->get();

        return view('accounting::settings.detail_types.index', compact('account_detail_types', 'account_subtypes'));
    }

    public function store_detail_types(Request $request)
    {
        $validated = $request->validate([
            'account_subtype_id' => ['required'],
            'name' => ['required'],
            'description' => ['nullable'],
        ]);

        $validated['active'] = $request->has('active');
        $validated['business_id'] = session('business.id');
        try {
            //ensure $validated attributes are in fillable array 
            AccountDetailType::create($validated);
        } catch (\Exception $e) {
            return (new FlashService())->onException($e)->redirectBackWithInput();
        }

        (new FlashService())->onSave();
        return back();
    }

    public function edit_detail_types($id)
    {
        $account_detail_type = AccountDetailType::forBusiness()->findOrfail($id);

        $account_subtypes = AccountSubtype::forBusiness()->active()->get();

        return view('accounting::settings.detail_types.edit', compact('account_detail_type', 'account_subtypes'));
    }

    public function update_detail_types(Request $request, $id)
    {
        $validated = $request->validate([
            'account_subtype_id' => ['required'],
            'name' => ['required'],
            'description' => ['nullable'],
        ]);

        $validated['active'] = $request->has('active');

        try {
            AccountDetailType::forBusiness()->findOrFail($id)->update($validated);
        } catch (\Exception $e) {
            return (new FlashService())->onException($e)->redirectBackWithInput();
        }

        (new FlashService())->onSave();

        return redirect('accounting/settings/detail_types');
    }

    public function destroy_detail_type($id)
    {
        try {
            AccountDetailType::destroy($id);
        } catch (\Exception $e) {
            return (new FlashService())->onException($e);
        }

        (new FlashService())->onDelete();

        return redirect()->back();
    }

    public function account_subtypes()
    {
        $account_subtypes = AccountSubtype::forBusiness()->orderBy('account_type')->get();

        $account_types = AccountType::getTypes();

        return view('accounting::settings.account_subtypes.index', compact('account_subtypes', 'account_types'));
    }

    public function store_account_subtypes(Request $request)
    {
        $validated = $request->validate([
            'account_type' => ['required'],
            'name' => ['required'],
            'description' => ['nullable'],
        ]);

        $validated['active'] = $request->has('active');
        $validated['business_id'] = session('business.id');

        try {
            //ensure $validated attributes are in fillable array
            AccountSubtype::create($validated);
        } catch (\Exception $e) {
            return (new FlashService())->onException($e)->redirectBackWithInput();
        }

        (new FlashService())->onSave();
        return back();
    }

    public function edit_account_subtypes($id)
    {
        $account_subtype = AccountSubtype::forBusiness()->findOrfail($id);

        $account_types = AccountType::getTypes();

        return view('accounting::settings.account_subtypes.edit', compact('account_subtype', 'account_types'));
    }

    public function update_account_subtypes(Request $request, $id)
    {
        $validated = $request->validate([
            'account_type' => ['required'],
            'name' => ['required'],
            'description' => ['nullable'],
        ]);

        $validated['active'] = $request->has('active');

        try {
            AccountSubtype::forBusiness()->findOrFail($id)->update($validated);
        } catch (\Exception $e) {
            return (new FlashService())->onException($e)->redirectBackWithInput();
        }

        (new FlashService())->onSave();

        return redirect('accounting/settings/account_subtypes');
    }

    public function destroy_account_subtype($id)
    {
        try {
            AccountSubtype::destroy($id);
        } catch (\Exception $e) {
            return (new FlashService())->onException($e);
        }

        (new FlashService())->onDelete();

        return redirect()->back();
    }

    public function map_settings()
    {
        $chart_of_accounts = ChartOfAccount::where('business_id', session('business.id'))->where('active', 1)->orderBy('gl_code')->get();
        $map_seetings = AccountMapSetting::where('business_id', session('business.id'))->latest()->get();
        return view('accounting::settings.map_settings.index', compact('chart_of_accounts','map_seetings'));
    }

    public function store_map_settings(Request $request)
    {
        $validated = $request->validate([
            'chart_account_id' => ['required'],
            'name' => ['required'],
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
        try {
            //ensure $validated attributes are in fillable array 
            AccountMapSetting::create($validated);
        } catch (\Exception $e) {
          // dd($e);

            return (new FlashService())->onException($e)->redirectBackWithInput();
        }

        (new FlashService())->onSave();
        return back();
    }

    public function edit_map_settings($id)
    {
        $map_setting = AccountMapSetting::findOrfail($id);
        $map_seetings = AccountMapSetting::where('business_id', session('business.id'))->latest()->get();

        $chart_of_accounts = ChartOfAccount::where('business_id', session('business.id'))->where('active', 1)->orderBy('gl_code')->get();

        return view('accounting::settings.map_settings.edit', compact('map_seetings','map_setting', 'chart_of_accounts'));
    }

    public function update_map_settings(Request $request, $id)
    {
        $validated = $request->validate([
          'chart_account_id' => ['required'],
          'name' => ['required'],
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
        try {
            AccountMapSetting::findOrFail($id)->delete();
            AccountMapSetting::create($validated);
        } catch (\Exception $e) {
            return (new FlashService())->onException($e)->redirectBackWithInput();
        }

        (new FlashService())->onSave();

        return redirect('accounting/settings/map_setting');
    }

    public function destroy_map_setting($id)
    {
        try {
            AccountMapSetting::destroy($id);
        } catch (\Exception $e) {
            return (new FlashService())->onException($e);
        }

        (new FlashService())->onDelete();

        return redirect()->back();
    }
}
