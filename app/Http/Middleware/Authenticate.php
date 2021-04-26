<?php

namespace App\Http\Middleware;

use App\Models\Token;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param \Illuminate\Contracts\Auth\Factory $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        //Get token header bearer
        $token = $request->bearerToken();

        if (!$token) {
            $unauthorized = true;
        } else {
            // this way just to check case sensitive db check
            $Tokens = Token::where('token', $token)->where('status', '1')->get();
            $unauthorized = true;
            foreach ($Tokens as $tk) {
                if ($tk->token == $token) {
                    $unauthorized = false;
                    break;
                }
            }
        }

        if ($unauthorized) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        return $next($request);
    }
}
