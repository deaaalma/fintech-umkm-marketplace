<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderAdditionalFee;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Show the invoice in the browser.
     */
    public function show(Order $order)
    {
        // Ensure the customer owns this order
        if ($order->customer_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this invoice.');
        }

        $data = $this->prepareInvoiceData($order);

        $umkmName = $order->umkm ? preg_replace('/[^A-Za-z0-9]+/', '-', $order->umkm->name) : 'UMKM';
        $trxId = $order->invoice_number ?? 'TRX-' . str_pad($order->id, 8, '0', STR_PAD_LEFT);
        $filename = 'Invoice-' . $umkmName . '-' . $trxId . '.pdf';

        $pdf = Pdf::loadView('customer.invoice.pdf', $data);
        return $pdf->stream($filename);
    }

    /**
     * Download the invoice as a PDF file.
     */
    public function download(Order $order)
    {
        if ($order->customer_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this invoice.');
        }

        $data = $this->prepareInvoiceData($order);

        $umkmName = $order->umkm ? preg_replace('/[^A-Za-z0-9]+/', '-', $order->umkm->name) : 'UMKM';
        $trxId = $order->invoice_number ?? 'TRX-' . str_pad($order->id, 8, '0', STR_PAD_LEFT);
        $filename = 'Invoice-' . $umkmName . '-' . $trxId . '.pdf';

        $pdf = Pdf::loadView('customer.invoice.pdf', $data);
        return $pdf->download($filename);
    }

    /**
     * Prepare data required for the invoice view.
     */
    private function prepareInvoiceData(Order $order)
    {
        $order->load(['customer', 'umkm.detail', 'umkm.category', 'product', 'payments']);

        $additionalFees = OrderAdditionalFee::where('order_id', $order->id)
            ->where('status', 'accepted')
            ->get();

        $successPayment = $order->payments->where('status', 'success')->first();
        
        $transactionId = $successPayment 
            ? (str_contains($successPayment->payment_gateway_ref, '/') ? 'TRX-' . str_pad($order->id, 8, '0', STR_PAD_LEFT) : ($successPayment->payment_gateway_ref ?? ('TRX-' . str_pad($order->id, 8, '0', STR_PAD_LEFT)))) 
            : ($order->invoice_number ?? ('TRX-' . str_pad($order->id, 8, '0', STR_PAD_LEFT)));

        return [
            'order' => $order,
            'additionalFees' => $additionalFees,
            'successPayment' => $successPayment,
            'transactionId' => $transactionId,
            'additionalTotal' => $additionalFees->sum('amount'),
            'subtotal' => $order->agreed_price ?? 0,
            'platformFee' => $order->platform_fee ?? 0,
            'grandTotal' => ($order->agreed_price ?? 0) + $additionalFees->sum('amount'),
        ];
    }
}
