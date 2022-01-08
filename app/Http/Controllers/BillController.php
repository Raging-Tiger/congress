<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\BillStatus;
use Illuminate\Http\Request;
use PDF;
use Illuminate\Support\Facades\Storage;

define('WAITING', 4);

class BillController extends Controller
{
    /**
     * Middleware, setting access control for specified function.
     * Participant is generalization for Private and Commercial participant.
     *
     */
    public function __construct() {
       
        $this->middleware('admin')->only(['adminIndex', 'displayPayment', 'edit', 'update']);
        $this->middleware('participant')->only(['index', 'downloadInvoice', 'uploadConfirmation']);
    }  
    
    /**
     * Display a listing of all bills for corresponding user.
     *
     * @return corresponing view.
     */
    public function index()
    {
        /* All bills for the specific participant */
        $bills = Bill::where('user_id', '=', auth()->user()->id)->orderBy('id', 'desc')->paginate(25);
        
        return view('bills/bills', ['bills' => $bills]);
    }
    
    /**
     * Display a listing of all issued bills for admin.
     *
     * @return corresponing view.
     */
    public function adminIndex()
    {
        /* All bills created in the system */
        $bills = Bill::orderBy('created_at', 'desc')->paginate(25);
        
        return view('bills/admin_bills', ['bills' => $bills]);
    }
    
    /**
     * Display a payment confirmation file for admin.
     *
     * @param  $id - bill ID.
     * @return response containing file.
     */
    public function displayPayment($id)
    {
        $bill = Bill::where('id', $id)->first();
        
        /* If no bill exists - abort */
        if($bill == NULL)
        {
            abort(404);
        }
        // dd($request->bill_id);
        
        /* Path to the file of bill confirmation */
        $event_name = $bill->events->name;
        $folder_name = str_replace(' ', '_', strtolower($event_name));
        $storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();

        $small_path = 'public/payments/' . $folder_name.'/'.$id.'.pdf';
        $path = $storagePath.$small_path;
        //dd(Storage::disk('local')->exists('public/payments/' . $folder_name.'/'.$request->bill_id.'.pdf'));
        
        /* If such file exists - return it */
        if (Storage::disk('local')->exists($small_path)) 
        {
            return response()->file($path);

        }
        
        /* If file is not found - abort */
        else
        {
            abort(404);
        }
    }
    
    /**
     * Generates invoice based on the bill data and template.
     *
     * @param  $request from the form.
     * @return download of PDF file.
     */
    public function downloadInvoice(Request $request)
    {
        $bill = Bill::where('id', '=', $request->bill_id)->first();   
        
        $name = 'bill_'.$request->bill_id.'.pdf';
        $data = [
            'bill' => $bill,
            'name' => $name,
            ];
        
        /* Creates invoice based on template*/
        $pdf = PDF::loadView('/document_templates/invoice', $data);  
        
        return $pdf->download($name);
    }
    
    /**
     * Store payment confirmation uploaded by the participant.
     *
     * @param $request from the form.
     * @return action BillController@index
     */
    public function uploadConfirmation(Request $request)
    {
        $rules = array(
            'bill_confirmation' => 'required|mimetypes:application/pdf',
        );        
        $this->validate($request, $rules); 
      
        $file = $request->file('bill_confirmation');

        /*Generates file name based on the invoice number*/
        $file_name = $request->bill_id.'.pdf';
      
        
        $bill = Bill::where('id', $request->bill_id)->first();
        $event_name = $bill->events->name;
        
        /* Changes bill status */
        $bill->bill_status_id = WAITING;
        $bill->is_confirmation_uploaded = true;
        $bill->save();
      
        /* Generates path and saves confirmation */
        $folder_name = str_replace(' ', '_', strtolower($event_name));
        $path = 'public/payments/' . $folder_name;
        $file->storeAs($path, $file_name);
         
     return redirect()->action('App\Http\Controllers\BillController@index');       
    }

    /**
     * Show the form for editing bill status.
     *
     * @param  int  $id - corresponds to the database bill ID entry.
     * @return corresponing view.
     */
    public function edit($id)
    {
        $bill = Bill::where('id', $id)->first();
        
        /* If bill is not found - abort */
        if($bill == NULL)
        {
            abort(404);
        }
        
        /* All possible bill statuses */
        $statuses = BillStatus::all();
        $statuses_list = $statuses->pluck('name', 'id');
        
        return view('bills/edit_bill', ['bill' => $bill, 'statuses' => $statuses_list]);

    }

    /**
     * Updates bill status in the DB.
     *
     * @param $request from the form.
     * @param  int  $id - corresponds to the database bill ID entry.
     * @return action BillController@adminIndex
     */
    public function update(Request $request, $id)
    {
        $bill = Bill::where('id', $id)->first();
        
        $bill->bill_status_id=$request->status;
        $bill->save();
      
      return redirect()->action('App\Http\Controllers\BillController@adminIndex');
    }

    /**
     * Not used
     */
    public function destroy($id)
    {
        //
    }
}
