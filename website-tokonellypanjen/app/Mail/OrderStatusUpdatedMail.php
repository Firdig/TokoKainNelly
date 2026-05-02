<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdatedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly Order $order,
        public readonly string $oldStatus,
        public readonly string $newStatus
    ) {}

    public function envelope(): Envelope
    {
        $statusLabels = [
            'in_preparation'    => 'Sedang Diproses',
            'ready_for_pickup'  => 'Siap Diambil',
            'shipped'           => 'Sedang Dikirim',
            'completed'         => 'Selesai',
            'cancelled'         => 'Dibatalkan',
        ];

        $label = $statusLabels[$this->newStatus] ?? ucfirst($this->newStatus);

        return new Envelope(
            subject: "Pesanan #{$this->order->invoice_number} - {$label}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.order-status-updated',
            with: [
                'order'     => $this->order,
                'oldStatus' => $this->oldStatus,
                'newStatus' => $this->newStatus,
                'isBops'    => $this->order->transaction_type === 'bops',
            ],
        );
    }
}
