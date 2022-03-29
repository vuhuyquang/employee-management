<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;
use App\Mail\RemindEmail;


class SendMailRemindBirthday implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $hoten;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($hoten)
    {
        $this->hoten = $hoten;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new RemindEmail($this->hoten);
        Mail::to('vuhuyquang2k@gmail.com', 'Thư báo sinh nhật')->send($email);
    }
}
