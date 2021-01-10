<?php

namespace App\Console\Commands;

use App\Helpers\ScraperApi;
use App\Models\GooglePlayStoreDeveloper;
use App\Models\GooglePlayStoreDeveloperEmailAddress;
use App\Models\UniqeEmailData;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;

class EmailDetect extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:detect';

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
        event('start');
        parent::__construct();
    }

    public function __destruct()
    {
        event('end');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $scraper = new ScraperApi();

        $token = $scraper->getToken();
        if ($token){
            $req = new \App\Helpers\MultiRequest();

            $req->setRequest("GET", "https://api.scraperapi.com?api_key={$token['token']}&url=https://www.instagram.com/graphql/query/?query_id=17888483320059182&id=111&first=12", 0);
            $req->setRequest("GET", "https://api.scraperapi.com?api_key={$token['token']}&url=https://www.instagram.com/graphql/query/?query_id=17888483320059182&id=111&first=12", 0);
            $data = $req->send();

            $resp = [];
            foreach ($data as $index => $datum) {
                $ip = json_decode($datum['response'], true);
                $resp[] = $index;
            }
            $resp['data'] = $token;
            $this->info(var_export([$resp]), true);
            die;
        }


        $this->info(var_export(['']), true);

        return true;
    }
}
