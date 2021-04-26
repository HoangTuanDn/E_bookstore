<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;
use Laravel\Scout\Searchable;

class Blog extends Model
{
    use HasTranslations;
    use HasFactory;
    use SoftDeletes;
    use Searchable;

    protected $guarded = ['id'];
    protected $attributes = [
        'view' => 0
    ];
    public $translatable = ['name', 'title', 'content', 'slug'];

    protected $table = 'blogs';

    public function filterBlog($data)
    {
        $query = Blog::select('id', 'name','featured_img', 'title', 'content', 'slug', 'view', 'user_id', 'category_id', 'created_at');

        if (!empty($data['name'])) {
            $query->where('name->vn', 'like', "%{$data['name']}%");
        }
        if (!empty($data['category'])) {
            $query->where('category_id', $data['category']);
        }

        if (!empty($data['archives']['month']) && !empty($data['archives']['year'])) {
            $query->whereMonth('created_at', $data['archives']['month']);
            $query->whereYear('created_at', $data['archives']['year']);
        }

        $sortData = [
            'name'       => 'name',
            'view'       => 'view',
            'created_at' => 'created_at'
        ];

        if (isset($data['sort']) && array_key_exists($data['sort'], $sortData)) {
            $sort = $sortData[$data['sort']];
        } else {
            $sort = $sortData['created_at'];
        }

        if (isset($data['order']) && (utf8_strtolower($data['order']) == 'desc')) {
            $order = "desc";
        } else {
            $order = "asc";
        }

        $query->orderBy($sort, $order);

        if (isset($data['limit'])) {
            if ($data['limit'] < 1) {
                $data['limit'] = config('custom.blog_limit');
            }
        } else {
            $data['limit'] = config('custom.blog_limit');
        }

        if (!isset($data['page'])) {
            $data['page'] = 1;
        }

        return $query->paginate($data['limit'], ['*'], 'page', $data['page']);
    }

    public function author()
    {
        return $this
            ->belongsTo(User::class,'user_id',);
    }

    public function comments()
    {
        return $this
            ->hasMany(Comment::class,'blog_id',);
    }

    public function category()
    {
        return $this
            ->belongsTo(BlogCategory::class,'category_id',);
    }

}
