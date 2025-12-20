<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Recipe;
use App\Models\User;
use App\Models\Kuliner;
use Illuminate\Support\Facades\Storage;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
                // Get or create a user for the recipes
                $user = User::first();
        
                if (!$user) {
                    $user = User::create([
                        'name' => 'Chef SuRasa',
                        'email' => 'chef@surasa.com',
                        'password' => bcrypt('password'),
                    ]);
                }
        
                // Get first kuliner if exists
                $kuliner = Kuliner::first();
                $kulinerId = $kuliner ? $kuliner->id : null;
        
                $recipes = [
                    // Nasi Goreng
                    [
                        'user_id' => $user->id,
                        'kuliner_id' => $kulinerId,
                        'title' => 'Nasi Goreng Spesial Rumahan',
                        'description' => 'Nasi goreng spesial dengan bumbu rahasia keluarga yang gurih dan nikmat. Cocok untuk sarapan atau makan malam.',
                        'ingredients' => [
                            '3 piring nasi putih (sisa semalam lebih baik)',
                            '3 butir telur',
                            '4 siung bawang putih, cincang halus',
                            '5 butir bawang merah, iris tipis',
                            '3 sdm kecap manis',
                            '1 sdm saus tiram',
                            '1 sdt terasi bakar',
                            '2 cabai merah, iris',
                            '100 gram ayam suwir',
                            'Garam dan merica secukupnya',
                            'Minyak goreng',
                        ],
                        'steps' => [
                            'Panaskan minyak, tumis bawang putih dan bawang merah hingga harum.',
                            'Masukkan telur, orak-arik hingga setengah matang.',
                            'Tambahkan ayam suwir, aduk rata.',
                            'Masukkan nasi, aduk hingga tercampur merata.',
                            'Tambahkan kecap manis, saus tiram, dan terasi. Aduk rata.',
                            'Masukkan cabai, garam, dan merica. Koreksi rasa.',
                            'Goreng dengan api besar sambil terus diaduk hingga nasi tidak menggumpal.',
                            'Sajikan panas dengan taburan bawang goreng dan acar.',
                        ],
                        'prep_time' => 10,
                        'cooking_time' => 15,
                        'servings' => 3,
                        'difficulty' => 'mudah',
                        'tips' => 'Gunakan nasi sisa semalam yang sudah dingin agar butiran nasi tidak mudah hancur dan hasilnya lebih pera.',
                        'is_approved' => true,
                        'views' => 1250,
                    ],
        
                    // Rendang
                    [
                        'user_id' => $user->id,
                        'kuliner_id' => $kulinerId,
                        'title' => 'Rendang Daging Sapi Padang Asli',
                        'description' => 'Rendang daging sapi dengan resep turun temurun dari Padang. Bumbu rempah yang kaya dan dimasak hingga kering sempurna.',
                        'ingredients' => [
                            '1 kg daging sapi has dalam, potong dadu',
                            '1 liter santan kental dari 2 butir kelapa',
                            '10 cabai merah keriting',
                            '5 cabai rawit merah',
                            '15 butir bawang merah',
                            '8 siung bawang putih',
                            '5 cm jahe',
                            '5 cm lengkuas',
                            '3 cm kunyit',
                            '3 batang serai, memarkan',
                            '5 lembar daun jeruk',
                            '2 lembar daun kunyit',
                            '1 genggam daun kemangi',
                            'Garam secukupnya',
                        ],
                        'steps' => [
                            'Haluskan cabai, bawang merah, bawang putih, jahe, lengkuas, dan kunyit.',
                            'Tumis bumbu halus bersama serai dan daun jeruk hingga harum dan matang.',
                            'Masukkan daging, aduk hingga daging berubah warna.',
                            'Tuang santan, masak dengan api sedang sambil terus diaduk.',
                            'Setelah santan menyusut dan berminyak, kecilkan api.',
                            'Masak terus dengan api kecil sambil sesekali diaduk hingga daging empuk dan bumbu kering (sekitar 4-5 jam).',
                            'Tambahkan daun kunyit di akhir masakan.',
                            'Koreksi rasa, sajikan dengan nasi putih hangat.',
                        ],
                        'prep_time' => 30,
                        'cooking_time' => 300, // 5 jam
                        'servings' => 8,
                        'difficulty' => 'sulit',
                        'tips' => 'Kunci rendang yang nikmat adalah kesabaran. Masak dengan api kecil dan jangan berhenti mengaduk agar tidak gosong.',
                        'is_approved' => true,
                        'views' => 3420,
                    ],
        
                    // Soto Ayam
                    [
                        'user_id' => $user->id,
                        'kuliner_id' => null,
                        'title' => 'Soto Ayam Lamongan',
                        'description' => 'Soto ayam khas Lamongan dengan kuah kuning yang segar dan gurih. Dilengkapi dengan koya yang khas.',
                        'ingredients' => [
                            '1 ekor ayam kampung',
                            '2 liter air',
                            '5 butir bawang merah',
                            '4 siung bawang putih',
                            '3 cm kunyit bakar',
                            '2 cm jahe',
                            '5 butir kemiri sangrai',
                            '2 batang serai',
                            '3 lembar daun salam',
                            '2 lembar daun jeruk',
                            'Soun secukupnya',
                            'Telur rebus',
                            'Tauge pendek',
                            'Daun bawang dan seledri',
                            'Bawang goreng untuk taburan',
                        ],
                        'steps' => [
                            'Rebus ayam hingga empuk, angkat dan suwir-suwir dagingnya.',
                            'Saring kaldu, sisihkan.',
                            'Haluskan bawang merah, bawang putih, kunyit, jahe, dan kemiri.',
                            'Tumis bumbu halus bersama serai, daun salam, dan daun jeruk hingga harum.',
                            'Masukkan tumisan bumbu ke dalam kaldu, didihkan.',
                            'Koreksi rasa dengan garam dan merica.',
                            'Siapkan mangkuk, tata soun, tauge, ayam suwir, dan telur.',
                            'Siram dengan kuah panas, taburi bawang goreng, daun bawang, dan seledri.',
                        ],
                        'prep_time' => 20,
                        'cooking_time' => 60,
                        'servings' => 6,
                        'difficulty' => 'sedang',
                        'tips' => 'Untuk kuah yang lebih gurih, gunakan ayam kampung dan rebus dengan api kecil agar kaldu keluar maksimal.',
                        'is_approved' => true,
                        'views' => 2156,
                    ],
        
                    // Gado-Gado
                    [
                        'user_id' => $user->id,
                        'kuliner_id' => null,
                        'title' => 'Gado-Gado Jakarta Dengan Bumbu Kacang',
                        'description' => 'Gado-gado legendaris Jakarta dengan bumbu kacang yang creamy dan gurih. Sayuran segar dengan lontong yang mengenyangkan.',
                        'ingredients' => [
                            '200 gram kacang tanah goreng',
                            '3 siung bawang putih',
                            '5 cabai rawit (sesuai selera)',
                            '2 sdm gula merah',
                            '1 sdm asam jawa',
                            '200 ml air matang',
                            'Garam secukupnya',
                            'Kangkung rebus',
                            'Tauge rebus',
                            'Kol rebus',
                            'Kentang rebus, potong dadu',
                            'Tahu goreng',
                            'Tempe goreng',
                            'Telur rebus',
                            'Lontong',
                            'Kerupuk',
                        ],
                        'steps' => [
                            'Haluskan kacang tanah goreng bersama bawang putih dan cabai.',
                            'Tambahkan gula merah dan asam jawa, haluskan lagi.',
                            'Tuang air sedikit demi sedikit sambil diaduk hingga kekentalan pas.',
                            'Koreksi rasa dengan garam.',
                            'Tata sayuran rebus, tahu, tempe, dan telur di piring.',
                            'Potong lontong, susun di atas sayuran.',
                            'Siram dengan bumbu kacang.',
                            'Sajikan dengan kerupuk.',
                        ],
                        'prep_time' => 25,
                        'cooking_time' => 30,
                        'servings' => 4,
                        'difficulty' => 'mudah',
                        'tips' => 'Bumbu kacang lebih nikmat jika kacangnya digoreng dengan kulit, kemudian kupas setelah dingin.',
                        'is_approved' => true,
                        'views' => 1876,
                    ],
        
                    // Bakso
                    [
                        'user_id' => $user->id,
                        'kuliner_id' => $kulinerId,
                        'title' => 'Bakso Daging Sapi Homemade',
                        'description' => 'Bakso daging sapi kenyal dengan kuah kaldu yang gurih. Resep rahasia untuk bakso yang bouncy dan lezat.',
                        'ingredients' => [
                            '500 gram daging sapi giling (has dalam)',
                            '100 gram tepung tapioka',
                            '2 butir putih telur',
                            '4 siung bawang putih, haluskan',
                            '1 sdt garam',
                            '1/2 sdt merica bubuk',
                            '1 sdt baking powder',
                            '100 ml air es',
                            'Tulang sapi untuk kaldu',
                            'Daun bawang dan seledri',
                            'Mie kuning',
                            'Tahu dan siomay (optional)',
                        ],
                        'steps' => [
                            'Giling daging dengan es batu hingga halus dan lengket.',
                            'Tambahkan bawang putih, garam, merica, dan baking powder. Giling lagi.',
                            'Masukkan tepung tapioka dan putih telur, aduk hingga kalis.',
                            'Diamkan adonan di kulkas selama 30 menit.',
                            'Didihkan air, bentuk adonan menjadi bulatan dengan bantuan sendok.',
                            'Masukkan bulatan ke air mendidih, masak hingga mengapung.',
                            'Angkat bakso, sisihkan.',
                            'Untuk kuah, rebus tulang sapi dengan bumbu hingga kaldu keluar.',
                            'Sajikan bakso dengan kuah kaldu, mie, dan taburan daun bawang.',
                        ],
                        'prep_time' => 45,
                        'cooking_time' => 60,
                        'servings' => 6,
                        'difficulty' => 'sedang',
                        'tips' => 'Kunci bakso kenyal adalah es batu saat menggiling daging. Daging harus tetap dingin selama proses penggilingan.',
                        'is_approved' => true,
                        'views' => 2890,
                    ],
        
                    // Ayam Goreng
                    [
                        'user_id' => $user->id,
                        'kuliner_id' => null,
                        'title' => 'Ayam Goreng Kalasan',
                        'description' => 'Ayam goreng khas Kalasan yang dimarinasi dengan bumbu rempah dan air kelapa. Gurih, manis, dan sangat empuk.',
                        'ingredients' => [
                            '1 ekor ayam, potong 8 bagian',
                            '500 ml air kelapa muda',
                            '8 butir bawang merah',
                            '5 siung bawang putih',
                            '3 cm lengkuas',
                            '2 cm jahe',
                            '3 lembar daun salam',
                            '2 batang serai, memarkan',
                            '3 sdm gula merah',
                            '2 sdt ketumbar bubuk',
                            'Garam secukupnya',
                            'Minyak untuk menggoreng',
                        ],
                        'steps' => [
                            'Haluskan bawang merah, bawang putih, lengkuas, jahe, dan ketumbar.',
                            'Lumuri ayam dengan bumbu halus, garam, dan gula merah.',
                            'Masukkan ke panci bersama air kelapa, daun salam, dan serai.',
                            'Masak dengan api kecil hingga air menyusut dan ayam empuk.',
                            'Angkat ayam, tiriskan.',
                            'Panaskan minyak dalam wajan.',
                            'Goreng ayam hingga kecokelatan dan crispy.',
                            'Sajikan dengan sambal dan lalapan.',
                        ],
                        'prep_time' => 20,
                        'cooking_time' => 45,
                        'servings' => 4,
                        'difficulty' => 'sedang',
                        'tips' => 'Air kelapa muda membuat ayam lebih empuk dan memberikan rasa manis alami yang khas.',
                        'is_approved' => true,
                        'views' => 1654,
                    ],
        
                    // Mie Goreng
                    [
                        'user_id' => $user->id,
                        'kuliner_id' => null,
                        'title' => 'Mie Goreng Jawa',
                        'description' => 'Mie goreng ala warung Jawa yang sederhana tapi penuh cita rasa. Bumbu manis gurih yang bikin ketagihan.',
                        'ingredients' => [
                            '200 gram mie kuning',
                            '2 butir telur',
                            '100 gram ayam fillet, potong dadu',
                            '5 butir bawang merah, iris',
                            '3 siung bawang putih, cincang',
                            '2 cabai merah, iris',
                            '3 sdm kecap manis',
                            '1 sdm saus tiram',
                            'Kol iris',
                            'Daun bawang',
                            'Garam dan merica',
                            'Minyak goreng',
                        ],
                        'steps' => [
                            'Rebus mie hingga al dente, tiriskan dan beri sedikit minyak.',
                            'Tumis bawang merah dan bawang putih hingga harum.',
                            'Masukkan ayam, masak hingga berubah warna.',
                            'Sisihkan tumisan ke pinggir, masukkan telur dan orak-arik.',
                            'Campur semua bahan, tambahkan cabai.',
                            'Masukkan mie, kecap manis, dan saus tiram.',
                            'Aduk rata dengan api besar.',
                            'Tambahkan kol dan daun bawang, aduk sebentar.',
                            'Koreksi rasa, sajikan panas.',
                        ],
                        'prep_time' => 10,
                        'cooking_time' => 15,
                        'servings' => 2,
                        'difficulty' => 'mudah',
                        'tips' => 'Goreng mie dengan api besar dan jangan terlalu lama agar mie tidak lembek.',
                        'is_approved' => true,
                        'views' => 1432,
                    ],
        
                    // Pecel
                    [
                        'user_id' => $user->id,
                        'kuliner_id' => null,
                        'title' => 'Pecel Madiun Sambal Kacang',
                        'description' => 'Pecel khas Madiun dengan sambal kacang yang pedas dan gurih. Sayuran segar dengan rempeyek yang renyah.',
                        'ingredients' => [
                            '200 gram kacang tanah goreng',
                            '5 cabai rawit',
                            '3 cabai merah keriting',
                            '2 siung bawang putih',
                            '1 cm kencur',
                            '2 lembar daun jeruk',
                            '2 sdm air asam jawa',
                            'Garam dan gula merah secukupnya',
                            'Bayam rebus',
                            'Kangkung rebus',
                            'Tauge rebus',
                            'Kacang panjang rebus',
                            'Mentimun',
                            'Rempeyek',
                        ],
                        'steps' => [
                            'Goreng kacang tanah hingga matang, tiriskan.',
                            'Haluskan kacang bersama cabai, bawang putih, dan kencur.',
                            'Tambahkan daun jeruk, garam, gula merah, dan air asam.',
                            'Ulek hingga halus dan bumbu tercampur rata.',
                            'Encerkan dengan sedikit air hangat sesuai kekentalan yang diinginkan.',
                            'Tata sayuran rebus di piring.',
                            'Siram dengan sambal kacang.',
                            'Sajikan dengan rempeyek dan mentimun.',
                        ],
                        'prep_time' => 15,
                        'cooking_time' => 20,
                        'servings' => 4,
                        'difficulty' => 'mudah',
                        'tips' => 'Kencur adalah kunci rasa khas pecel Madiun. Jangan skip bahan ini!',
                        'is_approved' => true,
                        'views' => 987,
                    ],
                ];
        
                foreach ($recipes as $recipe) {
                    // Assign image based on existing assets mapping
                    $imageSource = null;
                    if (str_contains(strtolower($recipe['title']), 'nasi goreng')) $imageSource = 'cat_rice.png';
                    elseif (str_contains(strtolower($recipe['title']), 'rendang')) $imageSource = 'hero_2.png';
                    elseif (str_contains(strtolower($recipe['title']), 'soto')) $imageSource = 'cat_chicken.png';
                    elseif (str_contains(strtolower($recipe['title']), 'gado-gado')) $imageSource = 'hero_4.png';
                    elseif (str_contains(strtolower($recipe['title']), 'bakso')) $imageSource = 'food_bakso.png';
                    elseif (str_contains(strtolower($recipe['title']), 'ayam goreng')) $imageSource = 'cat_chicken.png';
                    elseif (str_contains(strtolower($recipe['title']), 'mie')) $imageSource = 'cat_noodle.png';
                    elseif (str_contains(strtolower($recipe['title']), 'pecel')) $imageSource = 'cat_snack.png';
                    else $imageSource = 'hero_3.png'; // Fallback
        
                     // Handle image copy
                    if ($imageSource) {
                         $sourcePath = public_path('images/' . $imageSource);
                         // Store in recipes folder
                         $destinationPath = 'recipes/' . $imageSource;
             
                         if (file_exists($sourcePath)) {
                             // Ensure directory exists
                         if (!Storage::disk('public')->exists('recipes')) {
                             Storage::disk('public')->makeDirectory('recipes');
                         }
                         
                         // Copy file to storage
                         Storage::disk('public')->put($destinationPath, file_get_contents($sourcePath));
                             
                             $recipe['image'] = $destinationPath;
                         }
                    }
        
                    Recipe::create($recipe);
                }
        //
    }
}
