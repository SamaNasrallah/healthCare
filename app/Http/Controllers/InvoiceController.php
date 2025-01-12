<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with('patient')->paginate(10);
        return view('admin.invoices.index', compact('invoices'));
    }


    public function toggleStatus($id)
    {
        $invoice = Invoice::findOrFail($id);

        if ($invoice->status === 'unpaid') {
            $invoice->status = 'paid';
            $invoice->save();

            $admin = User::where('role', 'admin')->first();
            Notification::send($admin, new PaymentNotification($invoice));

            $patient = $invoice->patient;
            Notification::send($patient, new PatientPaymentNotification($invoice));

            return response()->json(['message' => 'Invoice marked as Paid successfully!']);
        }

        return response()->json(['message' => 'Invoice already paid.']);
    }



    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('admin.invoices.index')->with('success', 'Invoice deleted successfully!');
    }


    public function create()
    {
        $patients = Patient::all();
        return view('admin.invoices.create', compact('patients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'amount' => 'required|numeric|min:0',
            'issued_at' => 'required|date',
        ]);

        $invoice = Invoice::create([
            'patient_id' => $request->patient_id,
            'amount' => $request->amount,
            'status' => 'unpaid',
            'issued_at' => $request->issued_at,
        ]);

        return redirect()->route('admin.invoices.create')->with('success', 'Invoice added successfully!');
    }


    public function showNotifications()
    {
        $notifications = Auth::user()->unreadNotifications;
        return view('admin.notifications.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->find($id);

        $notification->markAsRead();

        return redirect()->route('notifications.index');
    }

}
