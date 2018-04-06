<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Article' => 'App\Policies\ArticlePolicy',
        'App\Models\ArticleCategory' => 'App\Policies\ArticleCategoryPolicy',
        'App\Models\Feedback' => 'App\Policies\FeedbackPolicy',
        'App\Models\User' => 'App\Policies\UserPolicy',
        'App\Models\Slider' => 'App\Policies\SlidePolicy',
        'App\Models\Setting' => 'App\Policies\SettingPolicy',
        'App\Models\ParsingList' => 'App\Policies\ParsingPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
