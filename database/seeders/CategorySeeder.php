<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Makanan Berat',
                'slug' => 'makanan-berat',
                'description' => 'Berbagai macam makanan berat khas Indonesia',
                'image_source' => 'cat_rice.png',
            ],
            [
                'name' => 'Makanan Ringan',
                'slug' => 'makanan-ringan',
                'description' => 'Camilan dan makanan ringan tradisional',
                'image_source' => 'cat_snack.png',
            ],
            [
                'name' => 'Minuman',
                'slug' => 'minuman',
                'description' => 'Minuman tradisional dan modern khas daerah',
                'image_source' => 'cat_drink.png',
            ],
            [
                'name' => 'Makanan Laut',
                'slug' => 'makanan-laut',
                'description' => 'Kuliner seafood dan olahan hasil laut',
                'image_source' => 'cat_seafood.png',
            ],
            [
                'name' => 'Makanan Pedas',
                'slug' => 'makanan-pedas',
                'description' => 'Kuliner dengan cita rasa pedas',
                'image_source' => 'hero_1.png',
            ],
            [
                'name' => 'Dessert',
                'slug' => 'dessert',
                'description' => 'Kue dan makanan penutup tradisional',
                'image_source' => 'hero_2.png',
            ],
            [
                'name' => 'Sate & Bakar',
                'slug' => 'sate-bakar',
                'description' => 'Berbagai jenis sate dan makanan bakar',
                'image_source' => 'cat_chicken.png',
            ],
            [
                'name' => 'Mie & Bakso',
                'slug' => 'mie-bakso',
                'description' => 'Mie, bakso, dan sejenisnya',
                'image_source' => 'cat_noodle.png',
            ],
        ];

        foreach ($categories as $category) {
            $imageSource = $category['image_source'];
            unset($category['image_source']); // Remove from array to avoid column not found error

            // Handle image copy
            $sourcePath = public_path('images/' . $imageSource);
            $destinationPath = 'categories/' . $imageSource;

            if (file_exists($sourcePath)) {
                // Ensure directory exists
                if (!\Storage::disk('public')->exists('categories')) {
                    \Storage::disk('public')->makeDirectory('categories');
                }
                
                // Copy file to storage
                \Storage::disk('public')->put($destinationPath, file_get_contents($sourcePath));
                
                $category['image'] = $destinationPath;
            }

            Category::create($category);
        }
        
    }
}
