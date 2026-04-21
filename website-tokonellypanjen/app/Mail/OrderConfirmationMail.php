<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Order Confirmation Mailable.
 *
 * This mailable is dispatched to the Laravel Queue (ShouldQueue)
 * so it doesn't block the checkout response. The queue worker
 * processes it asynchronously.
 *
 * Usage:
 *   Mail::to($customer)->queue(new OrderConfirmationMail($order));
 *
 * Requires a view at: resources/views/emails/order-confirmation.blade.php
 */
class OrderConfirmationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public readonly Order $order
    ) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Konfirmasi Pesanan #{$this->order->invoice_number} - Toko Nelly",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.order-confirmation',
            with: [
                'order'     => $this->order,
                'items'     => $this->order->items()->with('productVariant.product')->get(),
                'isBops'    => $this->order->transaction_type === 'bops',
                'pickupCode' => $this->order->pickup_code,
            ],
        );
    }
}
