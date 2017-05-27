<?php

/*
 * This file is part of the Antvel App package.
 *
 * (c) Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Database\Seeder;
use Antvel\Categories\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        foreach ($this->categories() as $category => $subCategories) {

            $createted = factory(Category::class)->create([
                'name' => $category,
            ]);

            foreach ($subCategories as $subCategory) {

                factory(Category::class)->create([
                    'category_id' => $createted->id,
                    'name' => $subCategory,
                ]);
            }
        }
    }

    protected function categories()
    {
        return [
            'Digital & Music' => [
                'Music', 'New Releases', 'Deals', 'Music Library'
            ],

            'Books & Audible' => [
                'Books', 'Children Books', 'Textbooks', 'Magazines', 'Audible Audiobooks & More'
            ],

            'Movies, Music & Games' => [
                'Musical Instruments', 'Video Games', 'Digital Games',
                'Movies & TV', 'Blu-ray', 'CDs & Vinyl', 'Digital Music',
                'Entertainment Collectibles', 'Trade In Movies, Music & Games',
            ],

            'Electronics & Computers' => [
                'TV & Video', 'Home Audio & Theater', 'Camera, Photo & Video',
                'Wearable Technology', 'Laptops & Tablets', 'Desktops & Monitors',
                'Computer Accessories & Peripherals', 'Computer Parts & Components',
                'Car Electronics & GPS', 'Musical Instruments', 'Electronics Accessories',
                'Cell Phones & Accessories', 'Video Games', 'Portable Audio & Accessories',
                'Software', 'Printers & Ink', 'Office & School Supplies', 'Trade In Your Electronics',
            ],

            'Home, Garden & Tools'   => [
                'Kitchen & Bath Fixtures', 'HardwareHome Automation',
                'HomeKitchen & Dining', 'Furniture & Décor', 'Bedding & Bath', 'Appliances',
                'Patio, Lawn & Garden', 'Fine Art', 'Arts, Crafts & Sewing', 'Pet Supplies',
                'Wedding Registry', 'Home Improvement', 'Power & Hand Tools', 'Lamps & Light Fixtures',
            ],

            'Beauty, Health & Grocery' => [
                'Grocery & Gourmet Food', 'Specialty Diets', 'Wine', 'Subscribe & Save',
                'All Beauty', 'Luxury Beauty', 'Men’s Grooming', 'Health, Household & Baby Care',
            ],

            'Toys, Kids & Baby' => [
                'For Girls', 'For Boys', 'For Baby',
                'Toys & Games', 'Baby', 'Video Games for Kids', 'Baby Registry', 'Kids’ Birthdays',
            ],

            'Clothing, Shoes & Jewelry' => [
                'Women', 'Men', 'Girls', 'Boys', 'Baby', 'Luggage'
            ],

            'Sports & Outdoors' => [
                'Golf', 'Leisure Sports & Game Room', 'Sports Collectibles', 'All Sports & Fitness',
                'Camping & Hiking', 'Cycling', 'Outdoor Clothing', 'Scooters, Skateboards & Skates',
                'Water Sports', 'Winter Sports', 'Climbing', 'Accessories', 'All Outdoor Recreation',
                'Athletic Clothing', 'Exercise & Fitness', 'Hunting & Fishing', 'Team Sports', 'Fan Shop',
            ],

            'Automotive & Industrial' => [
                'Automotive Parts & Accessories', 'Automotive Tools & Equipment',
                'Industrial Supplies', 'Lab & Scientific', 'Janitorial', 'Safety',
                'Car/Vehicle Electronics & GPS', 'Tires & Wheels', 'Motorcycle & Powersports',
            ],

            'Home Services' => [
                'Computer & Electronics', 'Lessons & Tutoring',
                'Home Improvement & Repair', 'Lawn & Garden Care', 'Automotive Services',
            ],
        ];
    }
}
