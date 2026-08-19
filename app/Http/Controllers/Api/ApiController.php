<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\Mobile\ApiHelpersTrait;

class ApiController extends Controller
{
    use ApiHelpersTrait;

    protected $apiUser = null;

    const ROLE_CONSUMER     = 'consumer';
    const ROLE_SUPPLY_CHAIN = 'supply_chain';
    const ROLE_BRAND        = 'brand';
    const ROLE_INSPECTOR    = 'inspector';
    const ROLE_AUTHORITY    = 'authority';
    const ROLE_ADMIN        = 'admin';

    protected function resolveToken(Request $request)
    {
        if ($request->filled('token')) {
            return $request->input('token');
        }

        $bearer = $request->bearerToken();

        if (!empty($bearer)) {
            return $bearer;
        }

        if ($request->header('X-Api-Token')) {
            return $request->header('X-Api-Token');
        }

        return null;
    }

    protected function authUser(Request $request)
    {
        if ($this->apiUser !== null) {
            return $this->apiUser;
        }

        $token = $this->resolveToken($request);

        if (empty($token)) {
            return null;
        }

        try {
            $id = decrypt($token);
        } catch (Exception $e) {
            return null;
        }

        $user = User::find($id);

        if (!$user) {
            return null;
        }

        $this->apiUser = $user;

        return $user;
    }

    protected function requireUser(Request $request)
    {
        $user = $this->authUser($request);

        if (!$user) {
            throw new HttpResponseException(
                $this->fail('Session expired. Please login again.', ['token' => ['Invalid or missing token']], 401)
            );
        }

        if ($user->status === '2') {
            throw new HttpResponseException(
                $this->fail('Your account has been blocked. Please contact support.', ['account' => ['Account blocked']], 403)
            );
        }

        return $user;
    }

    protected function requireRole($user, array $roles)
    {
        if (!in_array($this->role($user), $roles, true)) {
            throw new HttpResponseException(
                $this->fail('You are not allowed to access this section.', ['role' => ['Permission denied']], 403)
            );
        }
    }

    protected function role($user)
    {
        switch ((string) $user->type) {
            case '1':
                return self::ROLE_ADMIN;

            case '2':
                if (in_array($user->who_you_are, ['Audit Team', 'Management'], true)) {
                    return self::ROLE_AUTHORITY;
                }
                return self::ROLE_BRAND;

            case '3':
                return self::ROLE_INSPECTOR;

            case '4':
                return self::ROLE_BRAND;

            case '5':
                return self::ROLE_SUPPLY_CHAIN;

            default:
                return self::ROLE_CONSUMER;
        }
    }

    protected function roleLabel($user)
    {
        $labels = [
            self::ROLE_CONSUMER     => 'Consumer',
            self::ROLE_SUPPLY_CHAIN => 'Supply Chain',
            self::ROLE_BRAND        => 'Brand',
            self::ROLE_INSPECTOR    => 'Inspector',
            self::ROLE_AUTHORITY    => 'Authority',
            self::ROLE_ADMIN        => 'Administrator',
        ];

        $role = $this->role($user);

        return isset($labels[$role]) ? $labels[$role] : 'User';
    }

    protected function ownerId($user)
    {
        return $user->parent_id ? $user->parent_id : $user->id;
    }

    protected function ok($message, array $data = [], array $extra = [])
    {
        $payload = [
            'success' => true,
            'message' => $message,
            'data'    => (object) $data,
        ];

        return response(array_merge($payload, $extra), 200);
    }

    protected function okList($message, $key, array $items, array $extra = [])
    {
        $payload = [
            'success' => true,
            'message' => $message,
            'data'    => array_merge([$key => $items, 'count' => count($items)], $extra),
        ];

        return response($payload, 200);
    }

    protected function fail($message, $errors = [], $code = 400)
    {
        return response([
            'success' => false,
            'message' => $message,
            'errors'  => (object) $errors,
        ], $code);
    }

    protected function validateInput(Request $request, array $rules, array $messages = [])
    {
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            throw new HttpResponseException(
                $this->fail($validator->errors()->first(), $validator->errors()->toArray(), 400)
            );
        }

        return $validator->validated();
    }

    protected function paginate($query, Request $request, callable $mapper)
    {
        $limit = (int) $request->input('limit', 20);
        $limit = $limit > 0 ? min($limit, 100) : 20;
        $page  = (int) $request->input('page', 1);
        $page  = $page > 0 ? $page : 1;

        $paginator = $query->paginate($limit, ['*'], 'page', $page);

        $items = [];

        foreach ($paginator->items() as $model) {
            $items[] = call_user_func($mapper, $model);
        }

        $meta = [
            'page'         => $paginator->currentPage(),
            'limit'        => $paginator->perPage(),
            'total'        => $paginator->total(),
            'last_page'    => $paginator->lastPage(),
            'has_more'     => $paginator->currentPage() < $paginator->lastPage(),
        ];

        return [$items, $meta];
    }

    protected function date($value, $format = 'M d, Y h:i a')
    {
        if (empty($value)) {
            return '';
        }

        $timestamp = strtotime($value);

        return $timestamp ? date($format, $timestamp) : '';
    }

    protected function ago($value)
    {
        if (empty($value)) {
            return '';
        }

        try {
            return \Carbon\Carbon::parse($value)->diffForHumans();
        } catch (Exception $e) {
            return '';
        }
    }

    protected function assetUrl($path)
    {
        return !empty($path) ? asset($path) : '';
    }

    protected function json($value, $default = null)
    {
        if (empty($value)) {
            return $default;
        }

        $decoded = json_decode($value, true);

        return json_last_error() === JSON_ERROR_NONE ? $decoded : $default;
    }
}
