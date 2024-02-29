<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class CheckMenuPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $role = auth()->user()->roles()->where('job_historys.is_active', true)->first();
        $currentUrl = $request->getPathInfo();
        $currentMenu = DB::table('permissions as p')
                                ->join('menus as m', 'm.id', '=', 'p.menus_id')
                                ->select('m.name', 'm.route', 'm.url', 'm.icon', 'm.key_name')
                                ->where('m.url', $currentUrl)
                                ->where('p.roles_id', $role->id)
                                ->where('m.is_active', true)
                                ->where('p.can_view', true)
                                ->first();

        if (!$currentMenu) {
            dd('Tidak Diizinikan!');
            return redirect()->route('halaman_tidak_diizinkan');
        }

        return $next($request);
    }
}
