<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\Booking;
use App\Models\Category;
use App\Models\City;
use App\Models\Review;
use App\Models\Service;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ─── Admin User ─────────────────────────────
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@eventswally.com',
            'password' => Hash::make('password'),
            'phone' => '+923001234567',
            'account_type' => 'admin',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // ─── Cities ─────────────────────────────────
        $cities = [
            ['name' => 'Lahore', 'province' => 'Punjab', 'sort_order' => 1],
            ['name' => 'Karachi', 'province' => 'Sindh', 'sort_order' => 2],
            ['name' => 'Islamabad', 'province' => 'Federal', 'sort_order' => 3],
            ['name' => 'Rawalpindi', 'province' => 'Punjab', 'sort_order' => 4],
            ['name' => 'Faisalabad', 'province' => 'Punjab', 'sort_order' => 5],
            ['name' => 'Multan', 'province' => 'Punjab', 'sort_order' => 6],
            ['name' => 'Peshawar', 'province' => 'KPK', 'sort_order' => 7],
            ['name' => 'Quetta', 'province' => 'Balochistan', 'sort_order' => 8],
            ['name' => 'Sialkot', 'province' => 'Punjab', 'sort_order' => 9],
            ['name' => 'Gujranwala', 'province' => 'Punjab', 'sort_order' => 10],
        ];

        $cityModels = [];
        foreach ($cities as $city) {
            $cityModels[$city['name']] = City::create($city);
        }

        // ─── Categories ─────────────────────────────
        $categories = [
            ['name' => 'Wedding Venues', 'icon' => 'location_city', 'color' => 'FFFF6B9D', 'description' => 'Find the perfect venue for your wedding ceremony', 'sort_order' => 1],
            ['name' => 'Photography', 'icon' => 'camera_alt', 'color' => 'FF4F46E5', 'description' => 'Professional wedding photographers & cinematographers', 'sort_order' => 2],
            ['name' => 'Makeup Artists', 'icon' => 'face', 'color' => 'FFEC4899', 'description' => 'Bridal makeup and beauty professionals', 'sort_order' => 3],
            ['name' => 'Catering', 'icon' => 'restaurant', 'color' => 'FFFFC93C', 'description' => 'Wedding catering and menu planning services', 'sort_order' => 4],
            ['name' => 'Decor & Flowers', 'icon' => 'local_florist', 'color' => 'FF10B981', 'description' => 'Event decoration, stage and floral services', 'sort_order' => 5],
            ['name' => 'Mehndi Artists', 'icon' => 'palette', 'color' => 'FFF59E0B', 'description' => 'Professional henna and mehndi design artists', 'sort_order' => 6],
            ['name' => 'Car Rentals', 'icon' => 'directions_car', 'color' => 'FF8B5CF6', 'description' => 'Luxury car hire for wedding events', 'sort_order' => 7],
            ['name' => 'Wedding Planners', 'icon' => 'event_note', 'color' => 'FF3B82F6', 'description' => 'Full-service wedding planning and coordination', 'sort_order' => 8],
            ['name' => 'Invitation Cards', 'icon' => 'mail', 'color' => 'FFEF4444', 'description' => 'Custom wedding invitation designs', 'sort_order' => 9],
            ['name' => 'DJ & Music', 'icon' => 'music_note', 'color' => 'FF6366F1', 'description' => 'DJs, bands, and entertainment', 'sort_order' => 10],
            ['name' => 'Bridal Wear', 'icon' => 'checkroom', 'color' => 'FFD946EF', 'description' => 'Bridal dresses, lehengas, and designer wear', 'sort_order' => 11],
            ['name' => 'Jewelry', 'icon' => 'diamond', 'color' => 'FFF97316', 'description' => 'Wedding jewelry and accessories', 'sort_order' => 12],
        ];

        $categoryModels = [];
        foreach ($categories as $cat) {
            $categoryModels[$cat['name']] = Category::create($cat);
        }

        // ─── Sample Vendors ─────────────────────────
        $vendors = [
            [
                'name' => 'Royal Grand Marquee',
                'city' => 'Lahore',
                'categories' => ['Wedding Venues'],
                'description' => 'Royal Grand Marquee is one of Lahore\'s most prestigious wedding venues, offering a stunning blend of modern elegance and traditional grandeur. With capacity for up to 2000 guests, our banquet hall features crystal chandeliers, imported marble flooring, and a grand stage perfect for baraat and walima events.',
                'short_description' => 'Premium wedding venue in the heart of Lahore',
                'phone' => '+923001234567',
                'whatsapp' => '+923001234567',
                'email' => 'info@royalgrand.pk',
                'address' => 'Main Boulevard, Gulberg III, Lahore',
                'price_min' => 250000,
                'price_max' => 800000,
                'price_unit' => 'event',
                'rating' => 4.7,
                'total_reviews' => 45,
                'total_bookings' => 120,
                'is_verified' => true,
                'is_featured' => true,
                'status' => 'approved',
                'services' => [
                    ['name' => 'Barat Package', 'price' => 350000, 'description' => 'Complete barat setup for 500 guests'],
                    ['name' => 'Walima Package', 'price' => 300000, 'description' => 'Elegant walima arrangement for 500 guests'],
                    ['name' => 'Mehndi Night Package', 'price' => 200000, 'description' => 'Colorful mehndi event setup'],
                ],
            ],
            [
                'name' => 'Capture Memories Studio',
                'city' => 'Lahore',
                'categories' => ['Photography'],
                'description' => 'Capture Memories Studio specializes in wedding photography and cinematography with over 10 years of experience. Our team uses the latest Canon and Sony equipment to deliver stunning photos and cinematic wedding films that you\'ll cherish forever.',
                'short_description' => 'Award-winning wedding photography studio',
                'phone' => '+923011234567',
                'whatsapp' => '+923011234567',
                'email' => 'hello@capturememories.pk',
                'address' => 'DHA Phase 5, Lahore',
                'price_min' => 50000,
                'price_max' => 200000,
                'price_unit' => 'event',
                'rating' => 4.9,
                'total_reviews' => 78,
                'total_bookings' => 200,
                'is_verified' => true,
                'is_featured' => true,
                'status' => 'approved',
                'services' => [
                    ['name' => 'Photography Only', 'price' => 60000, 'description' => '8-hour coverage, 500+ edited photos'],
                    ['name' => 'Photo + Video', 'price' => 120000, 'description' => 'Full coverage with cinematic video'],
                    ['name' => 'Premium Package', 'price' => 200000, 'description' => 'Drone + 2 cameras + album'],
                ],
            ],
            [
                'name' => 'Glamour by Ayesha',
                'city' => 'Karachi',
                'categories' => ['Makeup Artists'],
                'description' => 'Glamour by Ayesha is Karachi\'s premier bridal makeup studio. With celebrity clientele and features in Brides Today magazine, Ayesha specializes in both traditional and contemporary bridal looks using top international brands.',
                'short_description' => 'Celebrity bridal makeup artist in Karachi',
                'phone' => '+923021234567',
                'whatsapp' => '+923021234567',
                'email' => 'glamour@ayesha.pk',
                'address' => 'Clifton Block 5, Karachi',
                'price_min' => 30000,
                'price_max' => 150000,
                'price_unit' => 'event',
                'rating' => 4.8,
                'total_reviews' => 92,
                'total_bookings' => 180,
                'is_verified' => true,
                'is_featured' => true,
                'status' => 'approved',
                'services' => [
                    ['name' => 'Bridal Makeup', 'price' => 50000, 'description' => 'Complete bridal look with hair styling'],
                    ['name' => 'Engagement Makeup', 'price' => 30000, 'description' => 'Elegant engagement day look'],
                    ['name' => 'Full Wedding Package', 'price' => 150000, 'description' => 'Mehndi + Barat + Walima looks'],
                ],
            ],
            [
                'name' => 'Taste of Punjab Catering',
                'city' => 'Lahore',
                'categories' => ['Catering'],
                'description' => 'Taste of Punjab has been serving exquisite Pakistani and continental cuisine at weddings for 15 years. Our experienced team of chefs prepare everything fresh on-site, from traditional mutton karahi to live BBQ stations.',
                'short_description' => 'Premium wedding catering with 15 years experience',
                'phone' => '+923031234567',
                'whatsapp' => '+923031234567',
                'email' => 'info@tasteofpunjab.pk',
                'address' => 'Model Town, Lahore',
                'price_min' => 1200,
                'price_max' => 3500,
                'price_unit' => 'per_person',
                'rating' => 4.6,
                'total_reviews' => 55,
                'total_bookings' => 95,
                'is_verified' => true,
                'is_featured' => false,
                'status' => 'approved',
                'services' => [
                    ['name' => 'Standard Menu', 'price' => 1200, 'price_unit' => 'per_person', 'description' => '10-item buffet menu'],
                    ['name' => 'Premium Menu', 'price' => 2000, 'price_unit' => 'per_person', 'description' => '15-item buffet with live stations'],
                    ['name' => 'Royal Menu', 'price' => 3500, 'price_unit' => 'per_person', 'description' => 'Luxury 20-item menu with imported items'],
                ],
            ],
            [
                'name' => 'Floral Dreams Decor',
                'city' => 'Islamabad',
                'categories' => ['Decor & Flowers'],
                'description' => 'Floral Dreams transforms venues into magical spaces. From imported roses to custom-designed stages, our team brings your vision to life with breathtaking floral arrangements and modern event decor.',
                'short_description' => 'Transform your venue into a fairytale',
                'phone' => '+923041234567',
                'whatsapp' => '+923041234567',
                'email' => 'info@floraldreams.pk',
                'address' => 'F-7 Markaz, Islamabad',
                'price_min' => 100000,
                'price_max' => 500000,
                'price_unit' => 'event',
                'rating' => 4.5,
                'total_reviews' => 33,
                'total_bookings' => 65,
                'is_verified' => true,
                'is_featured' => true,
                'status' => 'approved',
                'services' => [
                    ['name' => 'Basic Decor', 'price' => 100000, 'description' => 'Stage + entrance decoration'],
                    ['name' => 'Premium Decor', 'price' => 250000, 'description' => 'Full venue transformation'],
                    ['name' => 'Royal Decor', 'price' => 500000, 'description' => 'Imported flowers + custom lighting'],
                ],
            ],
            [
                'name' => 'Mehndi Magic by Sana',
                'city' => 'Karachi',
                'categories' => ['Mehndi Artists'],
                'description' => 'Sana has been creating stunning mehndi designs for over 8 years. Specializing in Arabic, Indian, and fusion styles using premium quality organic henna.',
                'short_description' => 'Expert mehndi artist with organic henna',
                'phone' => '+923051234567',
                'whatsapp' => '+923051234567',
                'email' => 'sana@mehndimagic.pk',
                'address' => 'Defence Phase 2, Karachi',
                'price_min' => 5000,
                'price_max' => 25000,
                'price_unit' => 'event',
                'rating' => 4.9,
                'total_reviews' => 110,
                'total_bookings' => 250,
                'is_verified' => true,
                'is_featured' => true,
                'status' => 'approved',
                'services' => [
                    ['name' => 'Bridal Mehndi', 'price' => 15000, 'description' => 'Full hands and feet bridal mehndi'],
                    ['name' => 'Guest Mehndi', 'price' => 500, 'price_unit' => 'per_person', 'description' => 'Simple designs for guests'],
                    ['name' => 'Premium Bridal Package', 'price' => 25000, 'description' => 'Bridal + 10 guest mehndi + trial'],
                ],
            ],
            [
                'name' => 'Royal Rides Pakistan',
                'city' => 'Islamabad',
                'categories' => ['Car Rentals'],
                'description' => 'Royal Rides offers luxury car rentals for weddings. From classic vintage cars to modern Mercedes and BMWs with professional chauffeurs.',
                'short_description' => 'Luxury wedding car rentals',
                'phone' => '+923061234567',
                'whatsapp' => '+923061234567',
                'email' => 'info@royalrides.pk',
                'address' => 'Blue Area, Islamabad',
                'price_min' => 15000,
                'price_max' => 80000,
                'price_unit' => 'event',
                'rating' => 4.4,
                'total_reviews' => 28,
                'total_bookings' => 45,
                'is_verified' => true,
                'is_featured' => false,
                'status' => 'approved',
                'services' => [
                    ['name' => 'Toyota Fortuner', 'price' => 15000, 'description' => 'Decorated SUV with driver'],
                    ['name' => 'Mercedes E-Class', 'price' => 40000, 'description' => 'Luxury sedan with decorations'],
                    ['name' => 'Vintage Car', 'price' => 80000, 'description' => 'Classic vintage car for special entry'],
                ],
            ],
            [
                'name' => 'Pearl Continental Marquee',
                'city' => 'Rawalpindi',
                'categories' => ['Wedding Venues', 'Catering'],
                'description' => 'Experience the luxury of Pearl Continental for your wedding. Our grand ballroom accommodates up to 1500 guests with world-class catering included.',
                'short_description' => 'Five-star hotel wedding venue',
                'phone' => '+923071234567',
                'whatsapp' => '+923071234567',
                'email' => 'events@pc.pk',
                'address' => 'The Mall, Rawalpindi',
                'price_min' => 500000,
                'price_max' => 2000000,
                'price_unit' => 'event',
                'rating' => 4.8,
                'total_reviews' => 62,
                'total_bookings' => 80,
                'is_verified' => true,
                'is_featured' => true,
                'status' => 'approved',
                'services' => [
                    ['name' => 'Silver Package', 'price' => 500000, 'description' => '300 guests with standard menu'],
                    ['name' => 'Gold Package', 'price' => 1000000, 'description' => '500 guests with premium menu'],
                    ['name' => 'Platinum Package', 'price' => 2000000, 'description' => '1000 guests with luxury menu'],
                ],
            ],
        ];

        foreach ($vendors as $vendorData) {
            $cityModel = $cityModels[$vendorData['city']];
            $categoryNames = $vendorData['categories'];
            $servicesData = $vendorData['services'];

            unset($vendorData['city'], $vendorData['categories'], $vendorData['services']);

            $vendor = Vendor::create([
                ...$vendorData,
                'city_id' => $cityModel->id,
                'verified_at' => $vendorData['is_verified'] ? now() : null,
            ]);

            // Attach categories
            foreach ($categoryNames as $catName) {
                $vendor->categories()->attach($categoryModels[$catName]->id);
            }

            // Create services
            foreach ($servicesData as $i => $serviceData) {
                Service::create([
                    'vendor_id' => $vendor->id,
                    'name' => $serviceData['name'],
                    'description' => $serviceData['description'] ?? '',
                    'price' => $serviceData['price'],
                    'price_unit' => $serviceData['price_unit'] ?? 'fixed',
                    'sort_order' => $i,
                ]);
            }
        }

        // ─── Sample Users ───────────────────────────
        $users = [];
        $userNames = ['Ali Khan', 'Fatima Ahmed', 'Hassan Raza', 'Aisha Malik', 'Usman Sheikh'];
        foreach ($userNames as $i => $name) {
            $users[] = User::create([
                'name' => $name,
                'email' => strtolower(str_replace(' ', '.', $name)) . '@gmail.com',
                'password' => Hash::make('password'),
                'phone' => '+92300' . str_pad($i + 1, 7, '0', STR_PAD_LEFT),
                'city_id' => $cityModels[array_keys($cityModels)[$i % count($cityModels)]]->id,
                'account_type' => 'user',
                'email_verified_at' => now(),
            ]);
        }

        // ─── Sample Reviews ─────────────────────────
        $comments = [
            'Amazing service! Everything was perfect for our wedding day.',
            'Very professional team. Highly recommended for anyone planning their big day.',
            'Great value for money. The quality exceeded our expectations.',
            'Loved the attention to detail. Will definitely recommend to family.',
            'Outstanding work! They made our wedding truly memorable.',
        ];

        $allVendors = Vendor::all();
        foreach ($allVendors as $vendor) {
            foreach ($users as $i => $user) {
                if (rand(0, 1)) { // Random reviews
                    Review::create([
                        'user_id' => $user->id,
                        'vendor_id' => $vendor->id,
                        'rating' => rand(4, 5),
                        'comment' => $comments[array_rand($comments)],
                        'status' => 'approved',
                    ]);
                }
            }
        }

        // ─── Banners ────────────────────────────────
        Banner::create([
            'title' => 'Plan Your Dream Wedding',
            'description' => 'Find the best vendors for your perfect day',
            'image' => 'banners/wedding-banner.jpg',
            'position' => 'home_slider',
            'sort_order' => 1,
        ]);

        Banner::create([
            'title' => 'Summer Wedding Sale',
            'description' => 'Up to 30% off on selected vendors',
            'image' => 'banners/summer-sale.jpg',
            'position' => 'home_slider',
            'sort_order' => 2,
        ]);

        $this->command->info('✅ Database seeded successfully!');
        $this->command->info('');
        $this->command->info('Admin Login:');
        $this->command->info('  Email: admin@eventswally.com');
        $this->command->info('  Password: password');
        $this->command->info('');
        $this->command->info("Cities: " . City::count());
        $this->command->info("Categories: " . Category::count());
        $this->command->info("Vendors: " . Vendor::count());
        $this->command->info("Users: " . User::count());
        $this->command->info("Reviews: " . Review::count());
    }
}
