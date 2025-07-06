<?php

namespace Database\Seeders;

use FontLib\Table\Type\name;
use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $payments = [
            [
                'type' => 'Transfer Bank',
                'name' => 'PT EduFin Indonesia',
                'provider' => 'BCA',
                'account_number' => '888-777-6666',
            ],
            [
                'type' => 'Transfer Bank',
                'name' => 'PT EduFin Indonesia',
                'provider' => 'BRI',
                'account_number' => '001-234-5678',
            ],
            [
                'type' => 'Transfer Bank',
                'name' => 'PT EduFin Indonesia',
                'provider' => 'BNI',
                'account_number' => '123-456-7890',
            ],
            [
                'type' => 'Transfer Bank',
                'name' => 'PT EduFin Indonesia',
                'provider' => 'Mandiri',
                'account_number' => '987-654-3210',
            ],
            [
                'type' => 'Transfer Bank',
                'name' => 'PT EduFin Indonesia',
                'provider' => 'BPD',
                'account_number' => '111-222-3333',
            ],
            [
                'type' => 'Qris',
                'name' => 'PT EduFin Indonesia',
                'provider' => 'Qris',
                'account_number' => '111-222-3333',
            ],
        ];

        PaymentMethod::insert($payments);
    }
}
