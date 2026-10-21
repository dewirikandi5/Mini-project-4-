<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\StockMovement;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Password di-hash (bukan teks biasa). Ganti setelah demo.
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        $categories = Category::factory(5)->create();
        $suppliers = Supplier::factory(4)->create();

        Product::factory(30)->create([
            'category_id' => fn () => $categories->random()->id,
        ])->each(function (Product $product) use ($suppliers, $user) {
            $product->suppliers()->attach($suppliers->random(rand(1, 2))->pluck('id'));

            // Stok awal = barang masuk, sehingga histori selalu cocok dengan stok.
            $in = rand(20, 100);
            StockMovement::create([
                'product_id' => $product->id, 'user_id' => $user->id,
                'type' => 'in', 'quantity' => $in, 'note' => 'Stok awal (seeder)',
            ]);
            $stock = $in;

            if (rand(0, 1)) {
                $out = rand(1, $stock); // tidak pernah melebihi stok
                StockMovement::create([
                    'product_id' => $product->id, 'user_id' => $user->id,
                    'type' => 'out', 'quantity' => $out, 'note' => 'Penjualan contoh (seeder)',
                ]);
                $stock -= $out;
            }

            $product->update(['stock' => $stock]);
        });
    }
}
