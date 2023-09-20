<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class WebsiteConfigurations
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $smtp = get_settings('smtp_settings', true);
        config(
            [
                //System configuration
                'app.name' => get_settings('website_title'),
                'app.timezone' => get_settings('timezone'),

                //SMTP configuration
                'mail.mailers.smtp.transport' => $smtp['protocol'],
                'mail.mailers.smtp.host' => $smtp['host'],
                'mail.mailers.smtp.port' => $smtp['port'],
                'mail.mailers.smtp.encryption' => $smtp['security'],
                'mail.mailers.smtp.username' => $smtp['username'],
                'mail.mailers.smtp.password' => $smtp['password'],
                'mail.mailers.smtp.timeout' => null,
                'mail.mailers.smtp.local_domain' => $_SERVER['SERVER_NAME'],
                'mail.from.name' => get_settings('website_title'),
                'mail.from.address' => $smtp['from_email'],
            ]
        );

        return $next($request);
    }
}
