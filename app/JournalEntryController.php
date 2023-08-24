<?php

namespace Modules\Accounting\Http\Controllers;

use Modules\Accounting\Entities\PaymentType;
use Modules\Accounting\Entities\BusinessLocation;
use Modules\Accounting\Entities\Currency;
use Modules\Accounting\Entities\PaymentDetail;
use Modules\Accounting\Services\FlashService;
use App\Utils\Util;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Accounting\Entities\ChartOfAccount;
use Modules\Accounting\Entities\JournalEntry;
use Yajra\DataTables\Facades\DataTables;

class JournalEntryController extends Controller
{
    private $commonUtil;

    public function __construct(Util $commonUtil)
    {
        $this->commonUtil = $commonUtil;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function storejournal(Request $request)
    {
        $request->validate([
            'location_id' => ['required'],
            'currency_id' => ['required'],
            'journal_entry_data' => ['required', 'array'], // {'debit', 'credit', 'amount', 'notes'}
            'date' => ['required', 'date'],
        ]);

        foreach ($request->journal_entry_data as $data) {
            try {
                DB::beginTransaction();

                $payment_detail = new PaymentDetail();
                $payment_detail->created_by_id = Auth::id();
                $payment_detail->payment_type_id = $request->payment_type_id;
                $payment_detail->transaction_type = 'journal_manual_entry';
                $payment_detail->save();

                //debit account
                $transaction_number = get_uniqid();
                $journal_entry = new JournalEntry();
                $journal_entry->created_by_id = Auth::id();
                $journal_entry->payment_detail_id = $payment_detail->id;
                $journal_entry->transaction_number = $transaction_number;
                $journal_entry->location_id = $request->location_id;
                $journal_entry->currency_id = $request->currency_id;
                $journal_entry->chart_of_account_id = $data['debit'];
                $journal_entry->transaction_type = 'manual_entry';
                $journal_entry->date = $request->date;
                $date = explode('-', $request->date);
                $journal_entry->month = $date[1];
                $journal_entry->year = $date[0];
                $journal_entry->debit = $data['amount'];
                $journal_entry->manual_entry = 1;
                $journal_entry->notes = $data['notes'];
                $journal_entry->save();

                //credit account
                $journal_entry = new JournalEntry();
                $journal_entry->created_by_id = Auth::id();
                $journal_entry->transaction_number = $transaction_number;
                $journal_entry->payment_detail_id = $payment_detail->id;
                $journal_entry->location_id = $request->location_id;
                $journal_entry->currency_id = $request->currency_id;
                $journal_entry->chart_of_account_id = $data['credit'];
                $journal_entry->transaction_type = 'manual_entry';
                $journal_entry->date = $request->date;
                $date = explode('-', $request->date);
                $journal_entry->month = $date[1];
                $journal_entry->year = $date[0];
                $journal_entry->credit = $data['amount'];
                $journal_entry->manual_entry = 1;
                $journal_entry->notes = $data['notes'];
                $journal_entry->save();

                activity()
                    ->on($journal_entry)
                    ->withProperties(['id' => $journal_entry->id])
                    ->log('Create Journal Entry');

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                return (new FlashService())->onException($e)->redirectBackWithInput();
            }
        }

        (new FlashService())->onSave();
        return redirect('accounting/journal_entry');
    }

}
