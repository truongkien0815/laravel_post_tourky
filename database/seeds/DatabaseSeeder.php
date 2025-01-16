<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       // Tạo 20 danh mục
       $categories = [];
       for ($i = 1; $i <= 20; $i++) {
           $categories[] = [
               'name' => 'Category ' . $i,
               'created_at' => now(),
               'updated_at' => now(),
           ];
       }
        DB::table('post_category')->insert($categories); // Tạo 20 danh mục

        // Lấy ID các danh mục
        $categoryIds = DB::table('post_category')->pluck('id')->toArray();

        // Tạo 10,000 bài viết
        $posts = [];
        for ($i = 1; $i <= 10000; $i++) {
            $posts[] = [
                'name' => 'Post Title ' . $i,  // Tên bài viết
                'content' => 'Content for post ' . $i,
                'description' =>  $i, // view
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Chèn bài viết vào database
        foreach (array_chunk($posts, 1000) as $chunk) {
            DB::table('post')->insert($chunk); // Chèn bài viết vào bảng posts
        }

        // Lấy ID các bài viết
        $postIds = DB::table('post')->pluck('id')->toArray();

        // Gắn bài viết vào danh mục qua bảng trung gian `post_category_join`
        $pivotData = [];
        foreach ($postIds as $postId) {
            // Gán ngẫu nhiên 1-3 danh mục cho mỗi bài viết
            $randomCategories = array_rand($categoryIds, rand(1, 3));
            if (!is_array($randomCategories)) {
                $randomCategories = [$randomCategories];
            }

            foreach ($randomCategories as $categoryIndex) {
                $pivotData[] = [
                    'post_id' => $postId,
                    'category_id' => $categoryIds[$categoryIndex],
                    
                ];
            }
        }

        // Chèn dữ liệu vào bảng trung gian `post_category_join`
        foreach (array_chunk($pivotData, 1) as $chunk) {
            DB::table('post_category_join')->insert($chunk); // Bảng trung gian post_category_join
        }
    }
}
