<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\NhanVien;

class RemindEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $hoten;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($hoten)
    {
        $this->hoten = $hoten;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail')->with(['data' => $this->hoten]);
    }
}
