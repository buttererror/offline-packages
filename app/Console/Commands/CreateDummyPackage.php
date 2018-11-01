<?php

namespace App\Console\Commands;

use App\Package;
use Illuminate\Console\Command;

class CreateDummyPackage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dummy:package';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $package = new Package();
        $package->client_id = 1;
        $package->user_id = 1;
        $package->user_id = 1;
        $package->start_date = now();
        $package->adults = 1;
        $package->children_count = 0;
        $package->children = null;
        $package->number_of_destinations = 1;
        $package->save();
    }
}
