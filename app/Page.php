<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    const ROOT_PAGE_NAME = '--корневая страница--';

    protected $fillable = [
        'id',
        'is_active',
        'is_in_menu',
        'name',
        'header',
        'meta_tags',
        'meta_description',
        'url',
        'parent',
        'view',
        'real_level',
        'is_root',
        'page_content',
        'pos'
    ];

    public function scopeAdminList($query)
    {
        return $query->where('is_root', '!=', 1)->orderBy('pos');
    }

    public function scopeMenu($query)
    {
        return $query->where('is_active', 1)->where('is_in_menu', 1)->orderBy('pos');
    }

    public static function images()
    {
        return [
            'Картинка страницы' => 'PageImage',
            'Изображение слайдера' => 'PageSliderImage',
        ];
    }

    public static function files()
    {
        return [
            'Файлы' => 'PageFile'
        ];
    }

    public function pageImages()
    {
        return $this->hasMany('App\PageImage');
    }


    /**
     * The service function to build the tree-like list of the pages.
     *
     * @param $root
     * @return mixed
     */
    public static function buildTree($root)
    {
        if (!$root) return false;
        $children = Page::where('parent', $root->id)->orderBy('pos')->get();
        if (sizeof($children)) {
            foreach ($children as $child) {
                Page::buildTree($child);
            }
        }

        $root->children = $children;
        return $root;
    }

    /**
     * Service function to flatten the tree-like site pages list.
     *
     * @param $page
     * @param $output
     * @return array
     */
    public static function flatten($page, $output)
    {
        if (!$page) return [Page::firstOrCreate(['is_root' => 1, 'real_level' => -1, 'name' => Page::ROOT_PAGE_NAME, 'url' => ''])];
        $page->name = str_repeat('&nbsp;&nbsp;', $page->real_level > 0 ? $page->real_level : 0) . ($page->real_level > 0 ? '└' : '') . str_repeat('─', $page->real_level > 0 ? $page->real_level : 0) . ' ' . $page->name;
        $output[] = $page;
        if (sizeof($page->children)) {
            foreach ($page->children as $child) {
                $output = Page::flatten($child, $output);
            }
        }
        return $output;
    }

    /**
     * Returns the tree-like list of the pages. Checks if the true root page is created.
     *
     * @return array
     */
    public static function tree()
    {
        $tree = Page::buildTree(Page::where('real_level', 0)->first());
        return [$tree];
    }

    /**
     * Returns the flatten list of the site pages to show in the select boxes for example.
     *
     * @return mixed
     */
    public static function flatTree()
    {
        $tree = Page::buildTree(Page::where('real_level', 0)->first());
        return Page::flatten($tree, []);
    }

}
