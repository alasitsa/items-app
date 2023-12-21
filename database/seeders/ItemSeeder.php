<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    private array $items = [
        ['name' => 'google', 'url' => 'google.com'],
        ['name' => 'youtube', 'url' => 'youtube.com'],
        ['name' => 'gmail', 'url' => 'gmail.com'],
        ['name' => 'habr', 'url' => 'habr.com'],
        ['name' => 'laravel', 'url' => 'laravel.com'],
        ['name' => 'google2', 'url' => 'google.com'],
        ['name' => 'youtube2', 'url' => 'youtube.com'],
        ['name' => 'gmail2', 'url' => 'gmail.com'],
        ['name' => 'habr2', 'url' => 'habr.com'],
        ['name' => 'laravel2', 'url' => 'laravel.com'],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->items as $item) {
            $itemModel = new Item();
            $itemModel->name = $item['name'];
            $itemModel->url = $item['url'];
            $itemModel->save();
        }
    }
}
