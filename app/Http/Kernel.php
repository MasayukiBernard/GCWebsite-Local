<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \App\Http\Middleware\TrustProxies::class,
        \Fruitcake\Cors\HandleCors::class,
        \App\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:60,1',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'changePass' => \App\Http\Middleware\EnsureChangePass::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'csa-form-created' => \App\Http\Middleware\CheckStudentHasCSAForm::class,
        'csa-form-none' => \App\Http\Middleware\CheckStudentHasNoCSAForm::class,
        'csa-form-submitted' => \App\Http\Middleware\CheckCSAFormSubmitted::class,
        'csa-form-redirected-summary' => \App\Http\Middleware\RedirectAfterFormSubmission::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'profile-edit-request-none' => \App\Http\Middleware\NoProfileEditRequest::class,
        'profile-finalized' => \App\Http\Middleware\ForceProfileFinalize::class,
        'profile-prevent-update' => \App\Http\Middleware\PreventProfileEdit::class,
        'profile-updated' => \App\Http\Middleware\ForceProfileUpdate::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'staff' => \App\Http\Middleware\CheckIsStaff::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'student' => \App\Http\Middleware\CheckIsStudent::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
    ];
}
