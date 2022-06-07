<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\LogAcesso as ModelsLogAcesso;

class LogAcessoMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
      *  @return mixed
     */
    public function handle($request, Closure $next)
    {
        // dd($request);
        $ip = $request->server->get('REMOTE_ADDR');
        $rota = $request->getRequestUri();
        //request - manipular
        ModelsLogAcesso::create(['log'=> "IP $ip requisitou a rota $rota"]);
        return Response('Chegamos em middleware e finalizamos no próprio middleware');
    }
}
