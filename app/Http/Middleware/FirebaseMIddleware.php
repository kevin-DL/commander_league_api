<?php


namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Log;
use Kreait\Laravel\Firebase\Facades\FirebaseAuth;

class FirebaseMiddleware
{
    protected $auth0;

    public function __construct()
    {
    }

    /**
     * Run the request filter.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->bearerToken();
        if (!$token) {
            return response()->json('No token provided', 403);
        }

        $user = $this->validateToken($token);

        if ($user === null) {
            return response()->json('User not found', 403);
        }
        $request->request->add(['user' => $user]);

        return $next($request);
    }

    public function validateToken($token)
    {
        try {
            $decoded = FirebaseAuth::verifyIdToken($token);
            $uid = $decoded->getClaim('sub');
            $user = User::where('provider_id', $uid)->get();
            $user = $user[0] ?? null;

            if (!$user) {
                /** @var \Kreait\Firebase\Auth\UserRecord $data */
                $data = FirebaseAuth::getUser($uid);
                $user = new User();
                $user->provider_id = $data->uid;
                $user->email = $data->email;
                $user->name = $data->displayName ?? 'No Name User';
                $user->image = $data->photoUrl ?? '';
                $user->save();
            }

            return $user;
        } catch (\Exception $e) {
            return null;
        };
    }
}
