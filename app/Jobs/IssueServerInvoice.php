<?php

namespace App\Jobs;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Server;
use App\Notifications\PayInvoiceNotif;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class IssueServerInvoice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The server instance.
     *
     * @var \App\Models\Server
     */
    protected $server;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Server $server)
    {
        $this->server = $server;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $client = Client::find($this->server->client_id);
        $invoice = Invoice::create([
            'client_id' => $client->id,
            'server_id' => $this->server->id,
            'payment_method' => $this->server->payment_method,
            'due_date' => $this->server->due_date,
        ]);

        $client->notify(new PayInvoiceNotif($invoice->id));
    }
}
