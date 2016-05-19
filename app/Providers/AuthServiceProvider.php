<?php

namespace App\Providers;

use App\Permission;
use App\User;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     * @var array
     */
    protected $policies = ['App\Model' => 'App\Policies\ModelPolicy',];

    /**
     * Register any application authentication / authorization services.
     * @param  \Illuminate\Contracts\Auth\Access\Gate $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
//        $this->registerPolicies($gate);
//        foreach ($this->getPermission() as $permission) {
//            $gate->define($permission->name, function(User $user) use ($permission){
//                return $user->hasRole($permission->roles);
//            });
//        }
    }

//    protected function getPermission()
//    {
//        return Permission::with('roles')->get();//把Permission拿到
//    }
}
