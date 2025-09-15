<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\ServiceProvider;
use App\Models\ServiceProviderSandbox;
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
        $serviceProviderSandbox = new ServiceProviderSandbox();
        $serviceProviderSandbox->base_url   = 'https://scripts.sandbox.bka.sh/versions/1.2.0-beta/checkout/';
        $serviceProviderSandbox->app_key    = '5tunt4masn6pv2hnvte1sb5n3j';
        $serviceProviderSandbox->app_secret = '1vggbqd4hqk9g96o9rrrp2jftvek578v7d2bnerim12a87dbrrka';
        $serviceProviderSandbox->username   = 'sandboxTestUser';
        $serviceProviderSandbox->password   = 'hWD@8vtzw0';
        $serviceProviderSandbox->save();

        for ($i=0; $i < 50 ; $i++) {
            Service::create([
            'name'         => 'Dummy Service',
            'keyword'      => 'NEW' . $i,
            'type'         => 'subscription',
            'mode'         => 'production',
            'validity'     => '7 days',
            'amount'       => 49.50,
            'api_url'      => 'https://dummy.com/api',
            'redirect_url' => 'https://dummy.com/redirect',
            'description'  => 'Just a test service entry',
        ]);
        }
    }
}
