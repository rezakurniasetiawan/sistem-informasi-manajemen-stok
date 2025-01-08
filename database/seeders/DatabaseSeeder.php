<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\MdUnit;
use App\Models\MdCategory;
use App\Models\MdSupplier;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Seeder for User
        $users = [
            [
                'name' => 'admin',
                'username' => 'admin',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ],
        ];

        foreach ($users as $data) {
            User::factory()->create([
                'name' => $data['name'],
                'username' => $data['username'],
                'password' => $data['password'],
                'role' => $data['role'],
            ]);
        }

        // Seeder for MdUnits
        $units = [
            [
                'name_mdunit' => 'Pcs'
            ],
            [
                'name_mdunit' => 'Box'
            ],
            [
                'name_mdunit' => 'Pack'
            ],
            [
                'name_mdunit' => 'Kg'
            ],
            [
                'name_mdunit' => 'Meter'
            ],
        ];

        foreach ($units as $data) {
            MdUnit::create([
                'name_mdunit' => $data['name_mdunit'],
            ]);
        }

        // Seeder for mdCategories
        $categories = [
            [
                'name_mdcategory' => 'Elektronik'
            ],
            [
                'name_mdcategory' => 'Pakaian'
            ],
            [
                'name_mdcategory' => 'Makanan'
            ],
            [
                'name_mdcategory' => 'Minuman'
            ],
            [
                'name_mdcategory' => 'Buku'
            ],
        ];

        foreach ($categories as $data) {
            MdCategory::create([
                'name_mdcategory' => $data['name_mdcategory'],
            ]);
        }

        // Seeder for MdSuppliers
        $suppliers = [
            [
                'created_mdsupplier' => '2025-01-08',
                'id_user' => 1,
                'code_mdsupplier' => 'SUP-00001',
                'name_mdsupplier' => 'Supplier 1',
                'address_mdsupplier' => 'Jl. Supplier 1',
                'email_mdsupplier' => 'supplier1@gmail.com',
                'phone_mdsupplier' => '081234567890',
            ],
            [
                'created_mdsupplier' => '2025-01-08',
                'id_user' => 1,
                'code_mdsupplier' => 'SUP-00002',
                'name_mdsupplier' => 'Supplier 2',
                'address_mdsupplier' => 'Jl. Supplier 2',
                'email_mdsupplier' => 'supplier2@gmail.com',
                'phone_mdsupplier' => '081234567891',
            ],
            [
                'created_mdsupplier' => '2025-01-08',
                'id_user' => 1,
                'code_mdsupplier' => 'SUP-00003',
                'name_mdsupplier' => 'Supplier 3',
                'address_mdsupplier' => 'Jl. Supplier 3',
                'email_mdsupplier' => 'supplier3@gmail.com',
                'phone_mdsupplier' => '081234567892',
            ],
            [
                'created_mdsupplier' => '2025-01-08',
                'id_user' => 1,
                'code_mdsupplier' => 'SUP-00004',
                'name_mdsupplier' => 'Supplier 4',
                'address_mdsupplier' => 'Jl. Supplier 4',
                'email_mdsupplier' => 'supplier4@gmail.com',
                'phone_mdsupplier' => '081234567893',
            ],
        ];

        foreach ($suppliers as $data) {
            MdSupplier::create([
                'created_mdsupplier' => $data['created_mdsupplier'],
                'id_user' => $data['id_user'],
                'code_mdsupplier' => $data['code_mdsupplier'],
                'name_mdsupplier' => $data['name_mdsupplier'],
                'address_mdsupplier' => $data['address_mdsupplier'],
                'email_mdsupplier' => $data['email_mdsupplier'],
                'phone_mdsupplier' => $data['phone_mdsupplier'],
            ]);
        }
    }
}
