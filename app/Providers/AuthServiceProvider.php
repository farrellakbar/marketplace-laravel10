<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
        Gate::define('can_create', function ($user,  Request $request, $condition = null) {
            $currentUrl = $request->getPathInfo();
            if($condition == '/sub-menu')
            {
                $currentUrl = '/menu';
            }
            $currentMenu = DB::table('permissions as p')
                            ->join('menus as m', 'm.id', '=', 'p.menus_id')
                            ->select('p.can_create')
                            ->where('m.url', $currentUrl)
                            ->where('p.roles_id', active_role()->id)
                            ->where('m.is_active', true)
                            ->where('p.can_create', true)
                            ->orderBy('m.ordinal_number')
                            ->first();
                if($currentMenu){
                return true;
            }
            else{
                return false;
            }
        });
        Gate::define('can_edit', function ($user,  Request $request, $condition = null) {
            $currentUrl = $request->getPathInfo();
            if($condition == '/sub-menu')
            {
                $currentUrl = '/menu';
            }else if($condition == '/permission-edit'){
                $currentUrl = '/permission';
            }
            $currentMenu = DB::table('permissions as p')
                            ->join('menus as m', 'm.id', '=', 'p.menus_id')
                            ->select('p.can_edit')
                            ->where('m.url', $currentUrl)
                            ->where('p.roles_id', active_role()->id)
                            ->where('m.is_active', true)
                            ->where('p.can_edit', true)
                            ->orderBy('m.ordinal_number')
                            ->first();
            if($currentMenu){
                return true;
            }
            else{
                return false;
            }
        });
        Gate::define('can_delete', function ($user,  Request $request, $condition = null) {
            $currentUrl = $request->getPathInfo();
            if($condition == '/sub-menu')
            {
                $currentUrl = '/menu';
            }
            $currentMenu = DB::table('permissions as p')
                            ->join('menus as m', 'm.id', '=', 'p.menus_id')
                            ->select('p.can_delete')
                            ->where('m.url', $currentUrl)
                            ->where('p.roles_id', active_role()->id)
                            ->where('m.is_active', true)
                            ->where('p.can_delete', true)
                            ->orderBy('m.ordinal_number')
                            ->first();
            if($currentMenu){
                return true;
            }
            else{
                return false;
            }
        });
    }
}
