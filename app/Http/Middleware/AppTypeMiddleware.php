<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Config;

class AppTypeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next, $appName)
    {
        if(is_null($appName)) {
            return response()->json(['error' => 'This Request is not Permitted.'], 400);
        }

        if(!(($request->is('api/*') && $appName === 'Vgnweb') ||
           ($request->is('api/*') && $appName === 'Vgnmobile'))) {
            return response()->json(['error' => 'This Request is not Permitted.'], 400);
        }

        if (!$request->hasHeader('app')) {
            return response()->json(['error' => 'Headers are missing'], 400);
        } else {
            $btoaApp = $request->header('app');
            $decodeApp = base64_decode(urldecode($btoaApp));
            $app = ($decodeApp) ? @explode('|', $decodeApp)[1] : null;
            if($app) {
                $appType = $this->getAppTypeByAppName($app);
                if($app && ($app === 'Vgnweb' || $app === 'Vgnmobile')) {
                    $request->merge(['appType' => $appType, 'appName' => $app]);
                    return $next($request);
                }
            }
            return response()->json(['error' => 'This Request is not Permitted.'], 400);
        }
    }

    public function getAppTypeByAppName($appName) {
        $appType = null;
        if($appName) {
            $appTypes = Config::get('VgnConfig.appTypes');
            if($appTypes && count($appTypes) > 0) {
                foreach($appTypes as $key => $appTypeNames) {
                    if($appTypeNames && count($appTypeNames) > 0) {
                        foreach($appTypeNames as $name) {
                            if($appName && $name && $name === $appName){
                                $appType = $key;
                                break;
                            }
                        }
                    }
                }
            }
        }
        return $appType;
    }
}
