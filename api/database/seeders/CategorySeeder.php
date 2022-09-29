<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use File;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    
    public function run()
    {

        $json = File::get("database/data/categories.json");

        $categories = json_decode($json);
        foreach ($categories as $category) {
            $categoryCreated = Category::create([
                'name' => $category->name,
                // 'slug' => isset($category->slug) ? $category->slug : Str::slug($category->name)
            ]);

            foreach($category->brands as $brand){

                $brandCreated = $categoryCreated->brands()->create([
                    'name' => $brand->name,
                    // 'slug' => Str::slug($brand->name),
                ]);
                
                if($category->hasModels){
                    foreach($brand->models as $item){
                        $brandCreated->models()->create([
                            'name' => $item->name,
                            // 'slug' => Str::slug($item->name),
                        ]);
                    }
                }

            }

            
        }
    }
}
