<?php

namespace App\Providers;

use App\Text;
use App\Setting;
use Illuminate\Support\ServiceProvider;

class ViewAttachServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view) {
            $texts = Text::all();
            $text_list = [];
            foreach ($texts as $text) {
                $text_list[$text->code] = $text->text_content;
            }
            $texts = $text_list;

            $settings = Setting::all();
            $settings_list = [];
            foreach ($settings as $settings) {
                $settings_list[$settings->code] = $settings->text_content;
            }
            $settings = $settings_list;

            $view->with(compact('texts', 'settings'));
        });

        view()->composer('partials.sidebar', function ($view) {
            $view->with('elements', \App\Http\Controllers\AdminController::sidebar());
        });

        view()->composer('admin.edit.pages', function($view) {
            $view->with('hierarchy', \App\Http\Controllers\PagesController::hierarchy());
        });

        view()->composer('admin.edit.pages', function($view) {
            $view->with('views', \App\Http\Controllers\ViewsController::views());
        });

        view()->composer('partials.treepage', function($view) {
            $view->with('views', \App\Http\Controllers\ViewsController::views());
        });

        view()->composer('admin.list.pages', function($view) {
            $view->with('tree', \App\Page::tree());
        });

        view()->composer('pages.partials.menu', function($view) {
            $view->with('menu', \App\Page::menu()->get());
        });

        view()->composer('pages.homePage', function($view) {
            $news = \App\NewsItem::hot()->get();
            $service_categories = \App\ServiceCategory::pageList()->get();
            foreach ($service_categories as $scat) {
                $images = \App\ServiceCategoryImage::attachmentTo($scat)->get();
                $scat->images = $images;
            }
            $view->with(compact('news', 'service_categories'));
        });

        view()->composer('pages.faq', function($view) {
            $view->with('answers', \App\Faq::answered()->get());
        });

        view()->composer('pages.newsList', function($view) {
            $view->with('news', \App\NewsItem::pageList()->get());
        });

        view()->composer('pages.services', function($view) {
            $view->with('services', \App\Service::pageList()->get());
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
