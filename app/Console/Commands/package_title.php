<?php

namespace App\Console\Commands;

use App\Package;
use Illuminate\Console\Command;

class package_title extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'package:title';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create package unique title';

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
        $package_ids=Package::pluck('id');
        foreach ($package_ids as $package_id){
            $rand_numbers = substr(uniqid('', true), -3);
            $randomChars = 'SDFGHJKLPOIUYTREWQZXCVBNM';
            $seed = str_split($randomChars);
            $rand_chars='';
            foreach (array_rand($seed, 3) as $k) {
                $rand_chars .= $seed[$k];
            }
            $uniq = $rand_chars . $rand_numbers;
            Package::where('id',$package_id)->update(['title'=>$uniq]);
        }
    }
}
