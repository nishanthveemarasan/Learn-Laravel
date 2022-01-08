<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        if (!$this->app->routesAreCached()) {
            Passport::routes();
        }
        //define a gate to given user permission to edit post
        Gate::define('update-post', function (User $user, Post $post) {
            return $user->id === $post->user_id;
        });
        Gate::define('delete-post', function (User $user, Post $post) {
            return false;
        });
        //return the response
        Gate::define('edit-post', function (User $user, Post $post, $value) {
            return $value ? Response::allow() : Response::deny('you must be an administrator');
        });
        //this will be executed first and if returns true then
        //other gates will be ignored
        Gate::before(function ($user, $ability) {
            if ($user->is_admin && in_array($ability, ['update-post'])) {
                return Response::allow();
            }
            return Response::deny('you must be an administrator');
        });
    }
}
