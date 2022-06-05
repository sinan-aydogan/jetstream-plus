<?php

namespace Laravel\Jetstream\Http\Middleware;

class JetstreamPlusLocalizationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  callable  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, $next)
    {
        // Determinate the language of the session
        if ($request->session()->has('locale')) {
            // Apply the lang of the session to global
            \Illuminate\Support\Facades\App::setLocale($request->session()->get('locale'));
            \Carbon\Carbon::setLocale($request->session()->get('locale') . '_' . strtoupper($request->session()->get('locale')) . '.UTF-8');
        }
        return $next($request);
    }
}
