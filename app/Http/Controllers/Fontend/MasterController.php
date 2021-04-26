<?php

namespace App\Http\Controllers\Fontend;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use function PHPUnit\Framework\isEmpty;

class MasterController extends Controller
{
    public function index(View $view){
        $menus = Menu::all();
        $categories = Category::get(['name', 'slug']);
        $collectionParentMenus = $menus->where('parent_id', 0);
        $parentMenus = [];
        $categoryMatchSlug = [];
        $menuGroups = [];
        $data = session('cart');
        $totalItemCart =  empty($data) ? 0 : count($data);
        $childrenMenuTranslate = [
            'Danh nhân' => 'Biography',
            'Kinh doanh' => 'Business',
            'Sách dạy nấu ăn' => 'Cookbooks',
            'Sức khỏe & Thể hình' => 'Health & Fitness',
            'Lịch sử' => 'History',
            'Huyền bí' => 'Mystery',
            'Ma thuật' => 'Magic',
            'Tình cảm' => 'Romance',
            'Viễn tưởng' => 'Fiction',
            'Hài hước' => 'Humor',
            'Harry Potter' => 'Harry Potter',
            'Khoa học' => 'Science',
            'Cảm hứng' => 'Inspiration',
            'Phiêu lưu' => 'Adventure',
            'Bí ẩn' => 'Mystery'
        ];

        $parentMenuTranslate = [
            'Thể loại' => __('categories'),
            'Yêu thích' => __('favourite'),
            'Bộ sưu tập' => __('collections')
        ];


        foreach ($categories as $category){
            $categoryMatchSlug [$category->name] = $category->slug;
        }

        foreach ($menus as $menu){
            if ($menu->parent_id == 0){
                $menuGroups[$menu->id] = [];
            }
            if (isset($menuGroups[$menu->parent_id]) && array_key_exists($menu->name, $categoryMatchSlug)){
                $menuGroups[$menu->parent_id] [] = [
                    'name' => app()->getLocale() === 'en' ? $childrenMenuTranslate[$menu->name] : $menu->name,
                    'href' => route('home.shop',['language'=> app()->getLocale(),'category' => $categoryMatchSlug[$menu->name]])
                ];
            }
        }

        foreach ($collectionParentMenus as $collectionParentMenu){
            if (isset($menuGroups[$collectionParentMenu->id])){
                if (app()->getLocale() === 'en'){
                    $parentMenus[$parentMenuTranslate[$collectionParentMenu->name]] = $menuGroups[$collectionParentMenu->id];
                } else {
                    $parentMenus[$collectionParentMenu->name] = $menuGroups[$collectionParentMenu->id];
                }
            }
        }

        $view->with(['parentMenus' => $parentMenus, 'totalItemCart' => $totalItemCart]);

    }

    public function blogSidebar(View $view)
    {
        /*recent blog comment category archives*/
        $recentBlogs = Blog::latest()->limit(config('custom.limit'))->get(['id','slug', 'featured_img', 'name', 'created_at']);
        $comments = Comment::where('parent_id', 0)->latest()->limit(5)->get(['id', 'blog_id', 'comment', 'customer_id']);
        $categories = BlogCategory::get(['id', 'name', 'slug']);
        $archives = Blog::get(['created_at']);

        $view->with([
            'recentBlogs' => $recentBlogs,
            'comments' => $comments,
            'categories' => $categories,
            'archives' => $archives
        ]);
    }
}
