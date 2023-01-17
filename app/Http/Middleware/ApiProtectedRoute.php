<?php

    namespace App\Http\Middleware;

    use Closure;
    use Illuminate\Http\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Tymon\JWTAuth\Exceptions\TokenExpiredException;
    use Tymon\JWTAuth\Exceptions\TokenInvalidException;
    use Tymon\JWTAuth\Facades\JWTAuth;
    use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

    class ApiProtectedRoute extends BaseMiddleware
    {
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle(Request $request, Closure $next)
        {
            try {
                $user = JWTAuth::parseToken()->authenticate();
            } catch (\Exception $e) {
                if ($e instanceof TokenInvalidException){
                    return response()->json(['status' => 'Token is Invalid'], Response::HTTP_UNAUTHORIZED);
                }

                if ($e instanceof TokenExpiredException){
                    return response()->json(['status' => 'Token is Expired'], Response::HTTP_UNAUTHORIZED);
                }

                return response()->json(['status' => 'Authorization Token not found'], Response::HTTP_UNAUTHORIZED);
            }
            return $next($request);
        }
    }
