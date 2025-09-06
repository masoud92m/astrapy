<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gateway;

class GatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Gateway::updateOrCreate(
            ['driver' => 'zarinpal'], // شرط یکتا (تکراری ساخته نشه)
            [
                'name' => 'زرین پال',
                'driver' => 'zarinpal',
                'merchant_id' => 'XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX', // تستی یا واقعی
                'callback_url' => url('/payment/callback/zarinpal'),
                'sandbox' => '1', // فعال‌سازی سندباکس
                'active' => true,
            ]
        );
    }
}
