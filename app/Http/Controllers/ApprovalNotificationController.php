<?php

namespace App\Http\Controllers;

use App\Models\StudentAnswer;
use App\Models\UserRecipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ApprovalNotificationController extends Controller
{
    /**
     * Check for pending approved tasks that haven't shown a notification yet.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkPendingApprovals()
    {
        $user = Auth::user();

        // Find the most recent approved task that hasn't shown a notification yet
        $pendingApproval = StudentAnswer::where('user_id', $user->id)
            ->where('is_correct', true)
            ->where('status', 'evaluated')
            ->where('notification_shown', false)
            ->with(['task', 'evaluator'])
            ->latest('evaluated_at')
            ->first();

        if ($pendingApproval) {
            // Mark this notification as shown
            $pendingApproval->notification_shown = true;
            $pendingApproval->save();

            // Get the task and points information
            $task = $pendingApproval->task;
            $pointsAwarded = $task ? $task->points_reward : 0;

            // Return the approval data
            return response()->json([
                'success' => true,
                'approval' => [
                    'title' => 'Task Approved!',
                    'message' => "Your answer for '{$task->name}' has been reviewed and approved by your teacher.",
                    'submissionContent' => $pendingApproval->submitted_text,
                    'feedback' => $pendingApproval->feedback,
                    'pointsAwarded' => $pointsAwarded,
                    'continueUrl' => route('learning'),
                    'continueText' => 'Continue Learning'
                ]
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No pending approvals found.'
        ]);
    }

    /**
     * Check for pending approved recipes that haven't shown a notification yet.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkPendingRecipeApprovals()
    {
        $user = Auth::user();

        Log::info('Checking for pending recipe approvals', ['user_id' => $user->id]);

        // Find the most recent approved recipe that hasn't shown a notification yet
        $pendingApproval = UserRecipe::where('user_id', $user->id)
            ->where('points_awarded', true)
            ->where('notification_shown', false)
            ->with(['approver'])
            ->latest('points_awarded_at')
            ->first();

        Log::info('Pending recipe approval query result', [
            'found' => $pendingApproval ? 'yes' : 'no',
            'recipe_id' => $pendingApproval?->id,
            'recipe_name' => $pendingApproval?->name,
            'points_awarded' => $pendingApproval?->points_awarded,
            'notification_shown' => $pendingApproval?->notification_shown,
        ]);

        if ($pendingApproval) {
            // We no longer mark the notification as shown here
            // This is now handled by the RecipeApprovalModal component

            // Get the points information
            $pointsAwarded = $pendingApproval->potential_points ?? 0;

            $approvalData = [
                'title' => 'Recipe Approved!',
                'message' => "Your recipe '{$pendingApproval->name}' has been reviewed and approved by your teacher.",
                'submissionContent' => $pendingApproval->description,
                'feedback' => $pendingApproval->feedback ?? '',
                'pointsAwarded' => $pointsAwarded,
                'continueUrl' => route('recipe-builder'),
                'continueText' => 'Continue Cooking'
            ];

            Log::info('Sending recipe approval notification', $approvalData);

            // Return the approval data
            return response()->json([
                'success' => true,
                'approval' => $approvalData
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No pending recipe approvals found.'
        ]);
    }
}
