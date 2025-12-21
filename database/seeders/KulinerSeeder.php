<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Kuliner;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class kulinerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kuliners = [
            // Makanan Berat (category_id: 1)
            [
                'name' => 'Nasi Goreng Kambing',
                'slug' => 'nasi-goreng-kambing',
                'description' => 'Nasi goreng dengan daging kambing yang empuk dan bumbu rempah khas Indonesia. Disajikan dengan acar, kerupuk, dan telur mata sapi.',
                'category_id' => 1,
                'location' => 'Jakarta Pusat',
                'address' => 'Jl. Sabang No. 12, Jakarta Pusat',
                'price_min' => 35000,
                'price_max' => 55000,
                'is_featured' => true,
                'is_active' => true,
                'average_rating' => 4.7,
                'total_reviews' => 156,
            ],
            [
                'name' => 'Gudeg Jogja',
                'slug' => 'gudeg-jogja',
                'description' => 'Gudeg khas Yogyakarta dengan nangka muda yang dimasak dengan santan dan gula merah. Disajikan dengan ayam, telur, dan sambal krecek.',
                'category_id' => 1,
                'location' => 'Yogyakarta',
                'address' => 'Jl. Wijilan No. 5, Yogyakarta',
                'price_min' => 25000,
                'price_max' => 40000,
                'is_featured' => true,
                'is_active' => true,
                'average_rating' => 4.8,
                'total_reviews' => 234,
            ],
            [
                'name' => 'Rendang Padang',
                'slug' => 'rendang-padang',
                'description' => 'Rendang daging sapi khas Padang dengan bumbu rempah yang kaya. Dimasak hingga kering dan berwarna cokelat kehitaman.',
                'category_id' => 1,
                'location' => 'Padang',
                'address' => 'Jl. Pasar Raya Padang',
                'price_min' => 30000,
                'price_max' => 60000,
                'is_featured' => true,
                'is_active' => true,
                'average_rating' => 4.9,
                'total_reviews' => 312,
            ],

            // Makanan Ringan (category_id: 2)
            [
                'name' => 'Pempek Palembang',
                'slug' => 'pempek-palembang',
                'description' => 'Pempek asli Palembang dengan ikan tenggiri segar. Disajikan dengan kuah cuko yang gurih dan pedas manis.',
                'category_id' => 2,
                'location' => 'Palembang',
                'address' => 'Jl. Mayor Ruslan, Palembang',
                'price_min' => 5000,
                'price_max' => 25000,
                'is_featured' => false,
                'is_active' => true,
                'average_rating' => 4.6,
                'total_reviews' => 189,
            ],
            [
                'name' => 'Siomay Bandung',
                'slug' => 'siomay-bandung',
                'description' => 'Siomay ikan tenggiri dengan tahu, kentang, pare, dan telur. Disajikan dengan saus kacang yang creamy.',
                'category_id' => 2,
                'location' => 'Bandung',
                'address' => 'Jl. Braga, Bandung',
                'price_min' => 15000,
                'price_max' => 30000,
                'is_featured' => false,
                'is_active' => true,
                'average_rating' => 4.5,
                'total_reviews' => 145,
            ],

            // Minuman (category_id: 3)
            [
                'name' => 'Es Cendol',
                'slug' => 'es-cendol',
                'description' => 'Minuman segar dengan cendol hijau dari tepung beras, santan gurih, dan gula merah. Cocok untuk cuaca panas.',
                'category_id' => 3,
                'location' => 'Bandung',
                'address' => 'Jl. Braga No. 58, Bandung',
                'price_min' => 8000,
                'price_max' => 15000,
                'is_featured' => false,
                'is_active' => true,
                'average_rating' => 4.4,
                'total_reviews' => 98,
            ],
            [
                'name' => 'Bajigur',
                'slug' => 'bajigur',
                'description' => 'Minuman hangat khas Sunda dari santan, gula aren, dan jahe. Cocok dinikmati saat cuaca dingin.',
                'category_id' => 3,
                'location' => 'Bandung',
                'address' => 'Jl. Cihampelas, Bandung',
                'price_min' => 10000,
                'price_max' => 18000,
                'is_featured' => false,
                'is_active' => true,
                'average_rating' => 4.3,
                'total_reviews' => 76,
            ],

            // Makanan Laut (category_id: 4)
            [
                'name' => 'Kepiting Saus Padang',
                'slug' => 'kepiting-saus-padang',
                'description' => 'Kepiting besar dengan saus padang yang pedas dan gurih. Disajikan dengan nasi putih hangat.',
                'category_id' => 4,
                'location' => 'Jakarta',
                'address' => 'Jl. Pluit, Jakarta Utara',
                'price_min' => 100000,
                'price_max' => 250000,
                'is_featured' => true,
                'is_active' => true,
                'average_rating' => 4.6,
                'total_reviews' => 87,
            ],

            // Sate & Bakar (category_id: 7)
            [
                'name' => 'Sate Ayam Madura',
                'slug' => 'sate-ayam-madura',
                'description' => 'Sate ayam khas Madura dengan bumbu kacang yang kental dan manis. Disajikan dengan lontong dan bawang merah.',
                'category_id' => 7,
                'location' => 'Surabaya',
                'address' => 'Jl. Tunjungan, Surabaya',
                'price_min' => 25000,
                'price_max' => 45000,
                'is_featured' => true,
                'is_active' => true,
                'average_rating' => 4.7,
                'total_reviews' => 203,
            ],

            // Mie & Bakso (category_id: 8)
            [
                'name' => 'Bakso Malang',
                'slug' => 'bakso-malang',
                'description' => 'Bakso khas Malang dengan bakso urat, bakso telur, dan bakso goreng. Kuah kaldu sapi yang gurih.',
                'category_id' => 8,
                'location' => 'Malang',
                'address' => 'Jl. Ijen, Malang',
                'price_min' => 20000,
                'price_max' => 35000,
                'is_featured' => false,
                'is_active' => true,
                'average_rating' => 4.5,
                'total_reviews' => 167,
            ],
        ];

        foreach ($kuliners as $kuliner) {
            // Assign image based on existing assets mapping
            $imageSource = null;
            if (str_contains($kuliner['slug'], 'nasi-goreng')) $imageSource = 'cat_rice.png';
            elseif (str_contains($kuliner['slug'], 'pempek')) $imageSource = 'food_pempek.png';
            elseif (str_contains($kuliner['slug'], 'bakso')) $imageSource = 'food_bakso.png';
            elseif (str_contains($kuliner['slug'], 'sate')) $imageSource = 'cat_chicken.png';
            elseif (str_contains($kuliner['slug'], 'gudeg')) $imageSource = 'hero_1.png'; // Placeholder
            elseif (str_contains($kuliner['slug'], 'rendang')) $imageSource = 'hero_2.png'; // Placeholder
            elseif (str_contains($kuliner['slug'], 'minuman') || str_contains($kuliner['slug'], 'es') || str_contains($kuliner['slug'], 'bajigur')) $imageSource = 'cat_drink.png';
            elseif (str_contains($kuliner['slug'], 'kepiting') || str_contains($kuliner['slug'], 'seafood')) $imageSource = 'cat_seafood.png';
            else $imageSource = 'hero_3.png'; // Default fallback

            // Handle image copy
            if ($imageSource) {
                 $sourcePath = public_path('images/' . $imageSource);
                 // Store in kuliners folder
                 $destinationPath = 'kuliners/' . $imageSource;
     
                 if (file_exists($sourcePath)) {
                     // Ensure directory exists
                     if (!Storage::disk('public')->exists('kuliners')) {
                         Storage::disk('public')->makeDirectory('kuliners');
                     }
                     
                     // Copy file to storage
                     Storage::disk('public')->put($destinationPath, file_get_contents($sourcePath));
                     
                     $kuliner['image'] = $destinationPath;
                 }
            }

            Kuliner::create($kuliner);
        }

        // Generate random ratings for each kuliner to match the seeded data concept
        // We will overwrite the hardcoded values by actual data aggregation
        $users = User::all();
        $kuliners = Kuliner::all();

        if ($users->count() > 0 && $kuliners->count() > 0) {
            foreach ($kuliners as $kuliner) {
                // Create random number of ratings (e.g., between 5 and 20 for demo purposes, 
                // or up to total_reviews if we want to match the seed exactly, but random is safer/easier)
                $reviewCount = rand(5, 20); 
                
                // If we want to respect the seeded 'total_reviews' we could try to match it, 
                // but re-calculating from real data is better for consistency.
                
                for ($i = 0; $i < $reviewCount; $i++) {
                    $user = $users->random();
                    
                    // Avoid duplicate rating from same user
                    if (!$kuliner->ratings()->where('user_id', $user->id)->exists()) {
                        Rating::create([
                            'user_id' => $user->id,
                            'kuliner_id' => $kuliner->id,
                            'rating' => rand(3, 5), // Mostly positive ratings
                        ]);
                    }
                }

                // Force update the aggregate columns to match the new ratings
                $kuliner->updateAverageRating();
            }
        }
    }
}
