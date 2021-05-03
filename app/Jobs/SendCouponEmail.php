<?php

namespace App\Jobs;

use App\Mail\ConfirmMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\Middleware\WithoutOverlapping;


class SendCouponEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /*
     *
     */
    protected array $details;

    /**
     * Create a new job instance.
     * @param array $details
     * @return void
     */
    public function __construct( array $details)
    {
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new ConfirmMail($this->details['data'], $this->details['subject'], $this->details['viewName']);
        Mail::to($this->details['emails'])->send($email);
    }

}
