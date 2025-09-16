<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\ServiceProvider;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $serviceProviderSandbox = new ServiceProvider();
        $serviceProviderSandbox->base_url   = 'https://scripts.sandbox.bka.sh/versions/1.2.0-beta/checkout/';
        $serviceProviderSandbox->app_key    = '5tunt4masn6pv2hnvte1sb5n3j';
        $serviceProviderSandbox->app_secret = '1vggbqd4hqk9g96o9rrrp2jftvek578v7d2bnerim12a87dbrrka';
        $serviceProviderSandbox->username   = 'sandboxTestUser';
        $serviceProviderSandbox->password   = 'hWD@8vtzw0';
        $serviceProviderSandbox->type   = 'sandbox';
        $serviceProviderSandbox->save();


        $serviceProviderSandbox = new ServiceProvider();
        $serviceProviderSandbox->base_url   = 'https://checkout.pay.bka.sh/v1.2.0-beta/checkout/';
        $serviceProviderSandbox->app_key    = '2l6u3m4i01ed69foin29vp42m';
        $serviceProviderSandbox->app_secret = '1d2qur3hm323h26h6a0m5pqucka8qkaae5drfimo4vejabo032qi';
        $serviceProviderSandbox->username   = 'BDGAMERS';
        $serviceProviderSandbox->password   = 'B@1PtexcaQMvb';
        $serviceProviderSandbox->type   = 'old-production';
        $serviceProviderSandbox->save();

        $serviceProviderSandbox = new ServiceProvider();
        $serviceProviderSandbox->base_url   = 'https://checkout.pay.bka.sh/v1.2.0-beta/checkout/';
        $serviceProviderSandbox->app_key    = '2l6u3m4i01ed69foin29vp42m';
        $serviceProviderSandbox->app_secret = '1d2qur3hm323h26h6a0m5pqucka8qkaae5drfimo4vejabo032qi';
        $serviceProviderSandbox->username   = 'BDGAMERS';
        $serviceProviderSandbox->password   = 'B@1PtexcaQMvb';
        $serviceProviderSandbox->type   = 'web';
        $serviceProviderSandbox->save();

        $serviceProviderSandbox = new ServiceProvider();
        $serviceProviderSandbox->base_url   = 'https://checkout.pay.bka.sh/v1.2.0-beta/checkout/';
        $serviceProviderSandbox->app_key    = '2l6u3m4i01ed69foin29vp42m';
        $serviceProviderSandbox->app_secret = '1d2qur3hm323h26h6a0m5pqucka8qkaae5drfimo4vejabo032qi';
        $serviceProviderSandbox->username   = 'BDGAMERS';
        $serviceProviderSandbox->password   = 'B@1PtexcaQMvb';
        $serviceProviderSandbox->type   = 'app';
        $serviceProviderSandbox->save();




        Service::create([
            'name'         => 'Pac Rush',
            'keyword'      => 'APP-S',
            'mode'         => 'sandbox',
            'validity'     => '1 days',
            'amount'       => 10,
            'api_url'      => '#',
            'redirect_url' => '#',
            'description'  => '#',
        ]);

        Service::create([
            'name'         => 'Pac Rush',
            'keyword'      => 'APP-P',
            'mode'         => 'production',
            'validity'     => '1 days',
            'amount'       => 10,
            'api_url'      => '#',
            'redirect_url' => '#',
            'description'  => '#',
        ]);
    }
}
