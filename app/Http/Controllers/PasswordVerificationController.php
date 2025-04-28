<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class PasswordVerificationController extends Controller
{
    /**
     * Verify the user's password for session unlock
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify(Request $request)
    {
        Log::info('Password verification request received', [
            'request_data' => $request->all(),
            'user_id' => Auth::id(),
            'is_authenticated' => Auth::check()
        ]);

        $request->validate([
            'password' => 'required|string',
        ]);

        $user = Auth::user();

        if (!$user) {
            Log::warning('Password verification failed: User not authenticated');
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated.',
            ], 401);
        }

        // Check if the provided password matches the user's password
        if (Hash::check($request->password, $user->password)) {
            Log::info('Password verified successfully for user', ['user_id' => $user->id]);
            return response()->json([
                'success' => true,
                'message' => 'Password verified successfully.',
            ]);
        }

        Log::warning('Password verification failed: Incorrect password', ['user_id' => $user->id]);
        return response()->json([
            'success' => false,
            'message' => 'Incorrect password. Please try again.',
        ], 422);
    }
}
