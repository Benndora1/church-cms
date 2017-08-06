<?php

namespace App\Http\Controllers;

use App\Models\Billing\Transactions;
use App\Settings;
use App\User;
use Illuminate\Support\Facades\Response;

class ReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * @return mixed
     */
    function downloadGiftsToDate(){
        $table =Transactions::get();
        $filename= "transactions_to_date";
        // the csv file with the first row
        $output = implode(",", array(
            'Date','TXN ID','Member','Customer ID','Item','Description', 'Amount'
        ));
        $output .= "\n";

        foreach ($table as $row) {
            // iterate over each
            $output .= implode(",", array(
                date('d M Y',strtotime($row->created_at)),
                $row->txn_id,
                $row->name,
                $row->customer_id,
                $row->item,
                $row->desc,
                env('CURRENCY_SYMBOL').$row->amount
            ));
            $output .= "\n";
        }
        $headers = array(
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="'.$filename.'.csv"',
        );
        return Response::make(rtrim($output, "\n"), 200, $headers);
    }
}
