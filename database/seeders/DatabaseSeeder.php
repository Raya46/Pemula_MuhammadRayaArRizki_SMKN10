<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Product;
use App\Models\Role;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::create([
            'name' => 'siswa'
        ]);
        Role::create([
            'name' => 'kantin'
        ]);
        Role::create([
            'name' => 'bank'
        ]);
        Role::create([
            'name' => 'admin'
        ]);

        User::create([
            'name' => 'raya',
            'password' => '123',
            'roles_id' => 1
        ]);
        User::create([
            'name' => 'faris',
            'password' => '999',
            'roles_id' => 1
        ]);

        User::create([
            'name' => 'rizki',
            'password' => '345',
            'roles_id' => 2
        ]);
        User::create([
            'name' => 'muhammad',
            'password' => '567',
            'roles_id' => 3
        ]);

        User::create([
            'name' => 'admin',
            'password' => '333',
            'roles_id' => 4
        ]);

        Category::create([
            'name' => 'makanan'
        ]);
        Category::create([
            'name' => 'minuman'
        ]);
        Category::create([
            'name' => 'snack'
        ]);
        Product::create([
            'name' => 'ciki jaguar',
            'price' => 10000,
            'stand' => 'mpo nunung',
            'stock' => 50,
            'description' => 'ciki baru',
            'photo' => '/photos/snack.png',
            'categories_id' => 3
        ]);
        Product::create([
            'name' => 'nasi kucing',
            'price' => 5000,
            'stand' => 'bang rijal',
            'stock' => 40,
            'description' => 'nasi kucing enak',
            'photo' => '/photos/makanan.png',
            'categories_id' => 1
        ]);
        Product::create([
            'name' => 'fanta',
            'price' => 3000,
            'stand' => 'indomaret',
            'stock' => 100,
            'description' => 'fanta seger',
            'photo' => '/photos/minuman.png',
            'categories_id' => 2
        ]);
        Transaction::create([
            'status' => 'dikeranjang',
            'order_code' => 'INV_123',
            'price' => 10000,
            'quantity' => 1,
            'products_id' => 1,
            'users_id' => 1,
        ]);
        Wallet::create([
            'status' =>'selesai',
            'credit' => 10000,
            'users_id' => 1
        ]);
    }
}
