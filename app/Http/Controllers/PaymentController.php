<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HouseType;
use App\Models\House;
use App\Models\Payment;
use App\Models\AdhocConfig;
use App\Models\Tenant;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use PDF;
use NumberFormatter;
//use Mail;
use Illuminate\Support\Facades\Mail;
use App\Mail\MyDemoMail;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payment = Payment::orderBy('id', 'asc')->get();
        $ulinFormat = AdhocConfig::where('name','ULIN')->first()->getULINFormat();
        $tenant = Tenant::where('status','=',0)->selectRaw("CONCAT (firstname, ' ' ,lastname) as columns, id")->orderBy('firstname','ASC')->pluck('columns', 'id')->toArray();
        //Load the view and pass the house
        return view('payment.index')->with('payment',$payment)
                    ->with('ulinFormat', $ulinFormat)
                    ->with('tenant', $tenant);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('payment.index');
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
            'amount' => 'required'

        ], [
            'amount.required' => 'Amount required'
        ]);
            
            //store
            $payment = new Payment;
            $expected = $request->get('expected');
            $amount = $request->get('amount');
            $payment->tenant_id = $request->get('tenant_id');
            $payment->amount = $request->get('amount');
            $payment->rent = $expected;
            $payment->date_from = $request->get('date_from');
            $payment->date_to = $request->get('date_to');
            $payment->balance = $expected - $amount;
            $payment->created_by = Auth::user()->id;
            $payment->save();
            
            $data["amount"] = $request->get('amount');
            $data["email"] = ['sndidde@gmail.com','sndidde@yahoo.co.uk'];
            $data["title"] = "New payment made";
            Mail::send('payment.newpay', $data, function($message)use($data) {

            $message->to($data["email"])

                    ->subject($data["title"]);

        });
            return redirect('payment')
                ->with('message', trans('messages.success-creating-payment'))->with('activepayment', $payment->id);

            // }catch(QueryException $e){
            //     Log::error($e);
            //     echo $e->getMessage();
            // }
        }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('payment.show')
        ->with('payment',Payment::find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $payment = Payment::find($id);
        $tenant = Tenant::orderBy('name','ASC')->pluck('name', 'id')->toArray();

        return view('payment.edit')
        ->with('payment', $payment)
        ->with('tenant', $tenant);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = array('name' => 'required');
        $validator = Validator::make($request->all(), $rules);

        // process the login
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        } else {
            // Update
            $payment = Payment::find($id);
            $payment->name = $request->get('name');
            $payment->description = $request->get('description');
            $payment->updated_by = Auth::user()->id;
            $payment->save();
            return redirect('housetype')
                ->with('message', trans('messages.success-updating-payment')) ->with('activepayment', $payment->id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function summary()
    {
        $query = "select t.id, t.firstname, t.middlename, t.lastname, s.name as site, h.house_no, h.price, sum(p.balance) as balance, max(p.date_to) as latestdate from payment p
            JOIN tenant t on(p.tenant_id = t.id)
            LEFT JOIN house h on(t.house_id = h.id)
            LEFT JOIN site s on(h.site_id = s.id)
            GROUP BY p.tenant_id";
            $data = DB::select($query);

        return view('payment.summary')->with('data',$data);
                    
    }

    public function viewTenantDetails($id){

        $query = "select p.id, t.id as tenantId, t.firstname, t.lastname, t.middlename, s.name as site, h.house_no, h.price, p.amount, p.balance, p.date_to, p.date_from from payment p
            JOIN tenant t on(p.tenant_id = t.id)
            LEFT JOIN house h on(t.house_id = h.id)
            LEFT JOIN site s on(h.site_id = s.id)
            where p.tenant_id = $id
            GROUP BY p.id
            ORDER BY p.id DESC";
            $detail = DB::select($query);
        
        return view('payment.detail')->with('detail', $detail);

    }

    public function updateAmountPaid(Request $request, $id)
    {
        // $rules = array('amount' => 'required');
        // $validator = Validator::make($request->all(), $rules);

        $balance = $request->get('amount');

        $visit = Payment::find($id);
        $ex = $visit->amount;
        $exb = $visit->balance;
        $new_amount = $ex + $balance;
        $new_balance = $exb - $balance;
        
        $visit->amount = $new_amount;
        $visit->balance = $new_balance;
        $visit->updated_at = now();
        $visit->updated_by = Auth::user()->id;
        $visit->save();

            $data["balance"] = $request->get('amount');
            $data["email"] = ['sndidde@gmail.com','sndidde@yahoo.co.uk'];
            $data["title"] = "New payment made";
            Mail::send('payment.newupdate', $data, function($message)use($data) {

            $message->to($data["email"])

                    ->subject($data["title"]);

        });
            return redirect()->route('payment.index')
            ->with('message', 'Amount Successfully updated!');

    }

    public function printPaymentReceipt($id, $visitId)
    {
        // pass the date variable
        $visitDate = Payment::find($visitId);
        
        //  Query to get tests of a particular patient
        $payment = Payment::where('id', '=', $visitId)->get();
        $tenant = Tenant::find($id);

        // Amount Paid
        $amountPaid = Payment::find($visitId)->amount;
        // $balanceleft = Payment::find($visitId)->balance;
        $sql = "SELECT SUM(balance) as balance from payment where tenant_id = $tenant->id";
        $value = DB::select($sql);
        $balanceleft = $value[0]->balance;

        $digit = new NumberFormatter("en", NumberFormatter::SPELLOUT); 
        $string = $digit->format($amountPaid);
        $word = ucfirst($string);

        $content = view('payment.tenant_receipt')
            ->with('tenant', $tenant)
            ->with('payment', $payment)
            ->with('amountPaid', $amountPaid)
            ->with('visitDate', $visitDate)
            ->with('word', $word)
            ->with('balanceleft', $balanceleft);
        ob_end_clean();

        $pdf = PDF::loadHtml($content);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('receipt.pdf');

    }

    public function sendPaymentReceipt($id, $visitId)
    {
        // pass the date variable
        $visitDate = Payment::find($visitId);
        
        //  Query to get tests of a particular patient
        $payment = Payment::where('id', '=', $visitId)->get();
        $tenant = Tenant::find($id);

        // Amount Paid
        $amountPaid = Payment::find($visitId)->amount;
        $balanceleft = Payment::find($visitId)->balance;

        $digit = new NumberFormatter("en", NumberFormatter::SPELLOUT); 
        $string = $digit->format($amountPaid);
        $word = ucfirst($string);

        $content = view('payment.tenant_receipt')
            ->with('tenant', $tenant)
            ->with('payment', $payment)
            ->with('amountPaid', $amountPaid)
            ->with('visitDate', $visitDate)
            ->with('word', $word)
            ->with('balanceleft', $balanceleft);
        ob_end_clean();

        $pdf = PDF::loadHtml($content);
        $pdf->setPaper('A4', 'portrait');

        $data["body"] = $tenant['email'];
        $data["email"] = $tenant['email'];
        $data["title"] = "Nana Properties receipt";

                Mail::send('payment.mailtest', $data, function($message)use($data, $pdf) {

            $message->to($data["email"])

                    ->subject($data["title"])

                    ->attachData($pdf->output(), "receipt.pdf");

        });
        dd("Mail Sent Successfully");
        return view('payment.summary');

    }


}
