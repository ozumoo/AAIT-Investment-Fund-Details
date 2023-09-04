<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\CompanySubmissionEmail as CompanySubmissionEmailMailable;

class SendCompanySubmissionEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $company_symbol;
    protected $startDate;
    protected $endDate;

    public function __construct($email, $company_symbol, $startDate, $endDate)
    {
        $this->email = $email;
        $this->company_symbol = $company_symbol;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function handle()
    {

        Mail::to($this->email)
            ->send(
                new CompanySubmissionEmailMailable(
                    $this->company_symbol, $this->startDate, $this->endDate
                )
            );

        if (Mail::failures()) {
            echo 'failure';
        }
    }
}
