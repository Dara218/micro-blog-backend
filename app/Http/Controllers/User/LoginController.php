<?php

namespace App\Http\Controllers\User;

use App\Enums\UserGuard;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserLoginRequest;
use App\Services\Common\LogService;
use App\Services\User\Authentication\LoginService;
use Illuminate\Http\Response;

class LoginController extends Controller
{
    /**
     * LoginService instance.
     *
     * @var \App\Services\User\Authentication\LoginService $loginService
     */
    protected LoginService $loginService;

    /**
     * Setup the controller.
     *
     * @param \App\Services\User\Authentication\LoginService $loginService
     */
    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    /**
     * Authenticate the user.
     *
     * @param \App\Http\Requests\User\UserLoginRequest $request
     *
     * @return Response
     *
     * @throws \Exception
     */
    public function authenticate(UserLoginRequest $request)
    {
        try {
            $validated = $request->validated();

            $isSuccess = $this->loginService->handleLoginProcess($validated);

            if (!$isSuccess) {
                return response([
                    'success' => false,
                    'data' => null,
                ])->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            // Regenerate session for security
            $request->session()->regenerate();

            return response([
                'success' => true,
                'data' => auth()->guard(UserGuard::USER->value)->user(),
            ]);
        } catch (\Exception $error) {
            LogService::error('Error processing user login.', [
                'error' => $error->getMessage(),
                'trace' => $error->getTraceAsString(),
            ]);

            return response([
                'success' => false,
                'data' => null,
            ])->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
