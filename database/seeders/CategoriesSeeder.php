<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::query()->insert([
            ['title'=>'Uncategorized','keywords'=>json_encode([]),'created_at'=>now(),'updated_at'=>now()],
            ['title'=>'Sports' , 'keywords'=>json_encode(['football', 'basketball', 'tennis', 'soccer']),'created_at'=>now(),'updated_at'=>now()],
            ['title'=>'Politics' , 'keywords'=>json_encode(['football', 'basketball', 'tennis', 'soccer']),'created_at'=>now(),'updated_at'=>now()],
            ['title'=>'Technology' , 'keywords'=>json_encode(['AI', 'machine learning', 'software', 'tech']),'created_at'=>now(),'updated_at'=>now()],
            ['title'=>'Health' , 'keywords'=>json_encode(['covid', 'health', 'medicine', 'vaccine']),'created_at'=>now(),'updated_at'=>now()],
        ]);
    }
}
