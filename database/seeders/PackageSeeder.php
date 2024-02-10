<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packages = [
            [
                'package' => 'PAKET 1',
                'price' => '10000',
            ],
        ];

        foreach ($packages as $package) {
            Package::create($package);
        }
    }
}
