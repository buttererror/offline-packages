<?php

namespace App\Console\Commands;

use App\Country;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class SeedCountries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:countries';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seeds Countries Table';

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
        $countries = json_decode(Storage::get('countries.json'), true);
        foreach ($countries as $key => $country) {
            $countries[$key]['created_at'] = now();
            $countries[$key]['updated_at'] = now();
        }
        Country::query()->insert($countries);
    }
}
