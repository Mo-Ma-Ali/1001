<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $request->validate(['phone_number' => 'required|exists:users']);
    
        $user = User::where('phone_number', $request->phone_number)->first();
    
        if ($user) {
            $this->broker()->sendResetLink(
                $request->only('phone_number')
            );
        }
    
        return back()->with('status', trans('passwords.sent'));
    }
}
