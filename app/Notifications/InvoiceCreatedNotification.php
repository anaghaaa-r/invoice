<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvoiceCreatedNotification extends Notification
{
    use Queueable;
    public $invoiceDetails;

    /**
     * Create a new notification instance.
     */
    public function __construct($invoiceDetails)
    {
        $this->invoiceDetails = $invoiceDetails;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $attachmentPath = storage_path('app/public/' . $this->invoiceDetails['file']);
        return (new MailMessage)
                    ->subject('Invoice Created Successfully.')
                    ->line('Invoice Date: ' . $this->invoiceDetails['invoice_date'])
                    ->line('Tax Amount: ' . $this->invoiceDetails['tax_amount'])
                    ->line('Net Amount: ' . $this->invoiceDetails['net_amount'])
                    ->attach($attachmentPath);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
