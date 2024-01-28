<?php

namespace App\Jobs;

use App\Mail\CreatedTenantAdminUserMail;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CreateTenantAdminUserJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Tenant $tenant;

    /**
     * Create a new job instance.
     */
    public function __construct(Tenant $tenant)
    {
        $this->tenant = $tenant;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        tenancy()->initialize($this->tenant);

        $userPayload = [
            'name'     => $this->tenant->id,
            'email'    => $this->tenant->email,
            'password' => Str::random(12),
        ];

        User::create($userPayload);

        Mail::to($this->tenant->email)
            ->send(new CreatedTenantAdminUserMail([
                'tenant' => $this->tenant,
                'user'   => $userPayload,
            ]));
    }
}
