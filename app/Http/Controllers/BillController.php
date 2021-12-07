<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\BillStatus;
use Illuminate\Http\Request;
use PDF;
use Illuminate\Support\Facades\Storage;

class BillController extends Controller
{
    public function __construct() {
       
        $this->middleware('admin')->only(['adminIndex', 'displayPayment', 'edit', 'update']);
    
        $this->middleware('participant')->only(['index', 'downloadInvoice', 'uploadConfirmation']);
    }  
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $bills = Bill::where('user_id', '=', auth()->user()->id)->orderBy('id', 'desc')->paginate(25);
        
        return view('bills/bills', ['bills' => $bills]);
    }
    public function adminIndex()
    {
        
        $bills = Bill::orderBy('created_at', 'desc')->paginate(25);
        
        return view('bills/admin_bills', ['bills' => $bills]);
    }
    
    public function displayPayment($id)
    {
        
        $bill = Bill::where('id', $id)->first();
        if($bill == NULL)
        {
            abort(404);
        }
       // dd($request->bill_id);
        $event_name = $bill->events->name;
        $folder_name = str_replace(' ', '_', strtolower($event_name));
        $storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();

        $small_path = 'public/payments/' . $folder_name.'/'.$id.'.pdf';
        $path = $storagePath.$small_path;
        //dd(Storage::disk('local')->exists('public/payments/' . $folder_name.'/'.$request->bill_id.'.pdf'));
        if (Storage::disk('local')->exists($small_path)) 
        {
            return response()->file($path);

        }
        else
        {
            abort(404);
        }
    }
    
    
    public function downloadInvoice(Request $request)
    {
        $bill = Bill::where('id', '=', $request->bill_id)->first();   
        
        $name = 'bill_'.$request->bill_id.'.pdf';
        $data = [
            'bill' => $bill,
            'name' => $name,
            ];
        
        $pdf = PDF::loadView('/document_templates/invoice', $data);  
        
        return $pdf->download($name);
        //return view('invoices/invoice', ['bill' => $bill]);
    }
    
    public function uploadConfirmation(Request $request)
    {
        $rules = array(
            'bill_confirmation' => 'required|mimetypes:application/pdf',
        );        
        $this->validate($request, $rules); 
      
        $file = $request->file('bill_confirmation');

        $file_name = $request->bill_id.'.pdf';
      
        $bill = Bill::where('id', $request->bill_id)->first();
        $event_name = $bill->events->name;
        $bill->bill_status_id = 4;
        $bill->is_confirmation_uploaded = true;
        $bill->save();
      
     
        $folder_name = str_replace(' ', '_', strtolower($event_name));
        $path = 'public/payments/' . $folder_name;
        $file->storeAs($path, $file_name);
         
     return redirect()->action('App\Http\Controllers\BillController@index');       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bill = Bill::where('id', $id)->first();
        
        if($bill == NULL)
        {
            abort(404);
        }
        
        $statuses = BillStatus::all();
        $statuses_list = $statuses->pluck('name', 'id');
        
        return view('bills/edit_bill', ['bill' => $bill, 'statuses' => $statuses_list]);

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
        $bill = Bill::where('id', $id)->first();
        
        $bill->bill_status_id=$request->status;
        $bill->save();
      
      return redirect()->action('App\Http\Controllers\BillController@adminIndex');
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
}
