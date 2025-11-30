<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        // User::factory()->create([
        //     'name' => 'Admin',
        //     'email' => env('ADMIN_EMAIL'),
        //     'role' => 1,
        //     'password' => Hash::make(env('ADMIN_PASSWORD'))
        // ]);

        DB::table('abouts')->insert(
            [
                'story_one' => 'Paragraph text one',
                'story_two' => 'Paragraph text two',
                'mission_one' => 'Paragraph text one',
                'mission_two' => 'Paragraph text two',
                'story_image' => 'imageurl',
                'mission_image' => 'imageurl',
            ]
        );

        DB::table('generals')->insert([
            [
                'maintenance' => false,
                'policy' => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words.',
                'site_description' => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words.',
                'site_title' => 'online title',
                'top_text' => 'online tech hub',
                'og_image' => 'image_url',
                'favicon' => 'image_url',
                'logo' => 'image_url',
            ]
        ]);

        DB::table('ads')->insert([
            ['name' => 'big_one', 'main_text' => 'Women', 'sub_text' => 'Spring 2025', 'image_url' => 'image_url', 'link' => 'url_link', 'text_color' => 'red'],
            ['name' => 'big_two', 'main_text' => 'Men', 'sub_text' => 'Spring 2025', 'image_url' => 'image_url', 'link' => 'url_link', 'text_color' => 'red'],
            ['name' => 'small_one', 'main_text' => 'Accessories', 'sub_text' => 'New Trend', 'image_url' => 'image_url', 'link' => 'url_link', 'text_color' => 'red']
        ]);

        DB::table('heroes')->insert([
            ['heading' => 'Device Collections', 'main_text' => 'NEW INNOVATION', 'link' => 'products_link', 'text_color' => 'seagreen', 'image_url' => 'img url'],
            ['heading' => 'New-Tech Innovation', 'main_text' => 'Lorem & Ipsum', 'link' => 'products_link', 'text_color' => 'seagreen', 'image_url' => 'img url'],
            ['heading' => 'Apple devices', 'main_text' => 'New arrivals', 'link' => 'products_link', 'text_color' => 'green', 'image_url' => 'img url'],
        ]);

        DB::table('contacts')->insert([
            [
                'address' => 'National Petroleum Corporation',
                'phone_number' => '+1234567890',
                'email' => 'ecom@mail.com',
                'facebook_link' => 'facebook.com',
                'instagram_link' => 'instagram.com',
                'tiktok_link' => 'tiktok.com',
                'whatsapp_link' => 'whatsapp.com'
            ]
        ]);
    }
}
