<?php

namespace App\Providers;

use App\Common\Constant;
use App\Models\Admin\Category\Category;
use App\Models\Admin\News\News;
use App\Policies\CategoryPolicy;
use App\Policies\NewsPolicy;
use Illuminate\Support\Facades\Gate;
use App\Models\Admin\Role\Role;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        News::class     => NewsPolicy::class,
        Category::class => CategoryPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define(Constant::GATE_ROLE_IS_ADMIN, function (User $user) {
            $role = new Role();
            return $role->getByUserId($user->id)->name === Constant::ROLE_ADMIN;
        });

        Gate::define(Constant::GATE_ROLE_IS_USER, function (User $user) {
            $role = new Role();
            return $role->getByUserId($user->id)->name === Constant::ROLE_USER;
        });

        Gate::define(Constant::GATE_UPDATE_NEWS, [NewsPolicy::class, 'edit']);
        Gate::define(Constant::GATE_DELETE_NEWS, [NewsPolicy::class, 'delete']);
        Gate::define(Constant::GATE_UPDATE_CATEGORY, [CategoryPolicy::class, 'edit']);
        Gate::define(Constant::GATE_DELETE_CATEGORY, [CategoryPolicy::class, 'delete']);
    }
}
