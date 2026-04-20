<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

 

class ExpenseAddedMail extends Mailable
{
    public $expense;
    public $group;
    public $user;

    public function __construct($expense, $group, $user)
    {
        $this->expense = $expense;
        $this->group = $group;
        $this->user = $user;
    }


    public function build()
    {
        return $this->subject('New Expense Added')
                    ->view('emails.expense_added');
    }
}