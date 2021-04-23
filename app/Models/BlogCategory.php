<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class BlogCategory extends Model
{
    use HasTranslations;
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];
    public $translatable = ['name', 'slug'];

    protected $table = 'blog_categories';

    public function blogs()
    {
        return $this
            ->hasMany(Blog::class,'category_id');
    }

    public function filterBlogCategory($data)
    {
        $query = BlogCategory::select('id', 'name', 'created_at');

        if (!empty($data['name'])) {
            $query->where('name->vn', 'like', "%{$data['name']}%");
        }


        $sortData = [
            'name'       => 'name',
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
                $data['limit'] = config('custom.limit');
            }
        } else {
            $data['limit'] = config('custom.limit');
        }

        if (!isset($data['page'])) {
            $data['page'] = 1;
        }

        return $query->paginate($data['limit'], ['*'], 'page', $data['page']);
    }

}
