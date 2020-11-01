<?php


namespace App\Http\Middleware;

use App\Profile;
use App\User;
use Closure;
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
            $profile = Profile::where('uid', $uid)->get();
            $profile = $profile[0] ?? null;

            if (!$profile) {
                /** @var \Kreait\Firebase\Auth\UserRecord $data */
                $data = FirebaseAuth::getUser($uid);
                $profile = new Profile();
                $profile->uid = $data->uid;
                $profile->display_name = $data->displayName ?? 'No Name User';
                $profile->picture = $data->photoUrl ?? '';
                $profile->save();
            }

            return $profile;
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return null;
        }
    }
}
