<?php

namespace App\Http\Controllers;


use App\Models\Invoice;
use App\Notifications\InvoiceCreatedNotification;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    public function viewInvoice()
    {
        $invoices = Invoice::orderBy('id', 'desc')->get();

        return view('invoice-list', compact('invoices'));
    }

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|integer',
            'amount' => 'required|numeric',
            'tax_percentage' => 'required|in:0,5,12,18,28',
            'name' => 'required|string',
            'invoice_date' => 'required|date',
            'file' => 'required|mimes:jpg,png,pdf|max:3072',
            'email' => 'required|email'
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed.',
                'error' => $validator->errors()
            ], 422);
        }

        try {
            $quantity = $request->input('quantity');
            $amount = $request->input('amount');
            $total_amount = $quantity * $amount;
            $tax_percentage = $request->input('tax_percentage');
            $tax_amount = ($total_amount * $tax_percentage) / 100;
            $net_amount = $total_amount + $tax_amount;
            $customer_name = $request->input('name');
            $invoice_date = $request->input('invoice_date');
            $customer_email = $request->input('email');
            

            $originalFileName = $request->file('file')->getClientOriginalName();
            $originalFileNameWithoutExtension = pathinfo($originalFileName, PATHINFO_FILENAME);
            $filename = str_replace(' ', '-', $originalFileNameWithoutExtension) . '--' . time() . '.' . $request->file('file')->getClientOriginalExtension();
            $filePath = 'uploads/' . $filename;
            $request->file('file')->storeAs('public/' . $filePath);

            $invoiceDetails = [
                'quantity' => $quantity,
                'amount' => $amount,
                'total_amount' => $total_amount,
                'tax_percentage' => $tax_percentage,
                'tax_amount' => $tax_amount,
                'net_amount' => $net_amount,
                'name' => $customer_name,
                'invoice_date' => $invoice_date,
                'file' => $filePath,
                'email' => $customer_email
            ];

            $invoice = Invoice::create($invoiceDetails);

            if($invoice)
            {
                $adminMail = $invoiceDetails['email'];

                Notification::route('mail', $adminMail)
                            ->notify(new InvoiceCreatedNotification($invoiceDetails));

                return response()->json([
                    'status' => true,
                    'message' => 'Invoice created successfully.'
                ], 200);
            }
            else
            {
                return response()->json([
                    'status' => true,
                    'message' => 'Error creating invoice.',
                ]);
            }
        }
        catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Internal Server Error.',
                'error' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function edit(Request $request, $id)
    {
        $invoice = Invoice::find($id);

        if(!$invoice)
        {
            return response()->json([
                'status' => false,
                'message' => 'Invoice not found.'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'quantity' => 'nullable|integer',
            'amount' => 'nullable|numeric',
            'tax_percentage' => 'nullable|in:0,5,12,18,28',
            'name' => 'nullable|string',
            'invoice_date' => 'nullable|date',
            'file' => 'nullable|mimes:jpg,png,pdf|max:3072',
            'email' => 'nullable|email'
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed.',
                'error' => $validator->errors()
            ], 422);
        }

        $updatedData = [];

        $updatedData['quantity'] = Invoice::find($id)->quantity;
        $updatedData['amount'] = Invoice::find($id)->amount;
        $updatedData['total_amount'] = Invoice::find($id)->total_amount;
        $updatedData['tax_percentage'] = Invoice::find($id)->tax_percentage;
        $updatedData['tax_amount'] = Invoice::find($id)->tax_amount;
        $updatedData['net_amount'] = Invoice::find($id)->net_amount;

        if($request->filled('quantity'))
        {
            $updatedData['quantity'] = $request->input('quantity');

            $totalAmount = $updatedData['quantity'] * $updatedData['amount'];

            $updatedData['total_amount'] = $totalAmount;
            $updatedData['tax_amount'] = ($updatedData['total_amount'] * $updatedData['tax_percentage']) / 100;
            $updatedData['net_amount'] = $updatedData['total_amount'] + $updatedData['tax_amount'];
        }

        if($request->filled('amount'))
        {
            $updatedData['amount'] = $request->input('amount');

            $totalAmount = $updatedData['quantity'] * $updatedData['amount'];

            $updatedData['total_amount'] = $totalAmount;
            $updatedData['tax_amount'] = ($updatedData['total_amount'] * $updatedData['tax_percentage']) / 100;
            $updatedData['net_amount'] = $updatedData['total_amount'] + $updatedData['tax_amount'];
        }

        if($request->filled('tax_percentage'))
        {
            $updatedData['tax_percentage'] = $request->input('tax_percentage');

            $totalAmount = $updatedData['quantity'] * $updatedData['amount'];

            $updatedData['total_amount'] = $totalAmount;
            $updatedData['tax_amount'] = ($updatedData['total_amount'] * $updatedData['tax_percentage']) / 100;
            $updatedData['net_amount'] = $updatedData['total_amount'] + $updatedData['tax_amount'];
        }

        if($request->filled('name'))
        {
            $updatedData['name'] = $request->input('name');
        }

        if($request->filled('invoice_date'))
        {
            $updatedData['invoice_date'] = $request->input('invoice_date');
        }

        if($request->hasFile('file'))
        {
            $originalFileName = $request->file('file')->getClientOriginalName();
            $originalFileNameWithoutExtension = pathinfo($originalFileName, PATHINFO_FILENAME);
            $filename = str_replace(' ', '-', $originalFileNameWithoutExtension) . '--' . time() . '.' . $request->file('file')->getClientOriginalExtension();
            $filePath = 'uploads/' . $filename;
            $request->file('file')->storeAs('public/' . $filePath);
            $updatedData['file'] = $filePath;
        }
        
        if($request->filled('email'))
        {
            $updatedData['email'] = $request->input('email');
        }

        if(empty($updatedData))
        {
            return response()->json([
                'status' => true,
                'message' => 'Nothing to update.'
            ], 200);
        }

        try {
            $invoice->update($updatedData);

            return response()->json([
                'status' => true,
                'message' => 'Updated Successfully.'
            ], 200);
        }
        catch (\Exception $e) {
            return response()->json([
                'status'=> false,
                'message' => 'Could not update.',
                'error' => 'Error: ' . $e->getMessage()
            ], 500);
        }
        
    }

    public function delete($id)
    {
        try {
            $invoice = Invoice::findOrFail($id);
            
            $invoice->delete();

            return response()->json([
                'status' => true,
                'message' => 'Invoice deleted successfully.'
            ], 200);
        }
        catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Invoide not found.',
                'error' => 'Error: ' . $e->getMessage()
            ], 404);
        }
        catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Internal Server Error.',
                'error' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
