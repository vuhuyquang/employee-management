<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailNotify extends Mailable
{
    use Queueable, SerializesModels;
    public $nhanvien;
    public $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nhanvien, $password)
    {
        $this->nhanvien = $nhanvien;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('quantrivien.nhanvien.resetpassword')->subject('Đặt lại mật khẩu')->with(['nhanvien' => $this->nhanvien, 'password' => $this->password]);
    }
}
