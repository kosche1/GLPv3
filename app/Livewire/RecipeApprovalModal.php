<?php

namespace App\Livewire;

use App\Models\UserRecipe;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\Log;

class RecipeApprovalModal extends Component
{
    public $showApprovalModal = false;
    public $approvedRecipe = null;
    public $pointsAwarded = 0;
    public $recipeName = '';
    public $feedback = '';
    public $description = '';

    protected $listeners = ['checkForApprovedRecipes' => 'checkForApprovedRecipes'];

    public function mount()
    {
        $this->checkForApprovedRecipes();
    }

    public function checkForApprovedRecipes()
    {
        if (!Auth::check()) {
            return;
        }

        Log::info('Checking for approved recipes');

        // Look for recently approved recipes (in the last 30 minutes)
        $recentlyApproved = UserRecipe::where('user_id', Auth::id())
            ->where('points_awarded', true)
            ->where('points_awarded_at', '>=', now()->subMinutes(30))
            ->where('notification_shown', false)
            ->with(['approver'])
            ->latest('points_awarded_at')
            ->first();

        Log::info('Recipe query result', [
            'found_recipe' => $recentlyApproved ? 'yes' : 'no',
            'recipe_id' => $recentlyApproved?->id,
            'recipe_name' => $recentlyApproved?->name,
            'user_id' => Auth::id(),
        ]);

        if ($recentlyApproved) {
            $this->approvedRecipe = $recentlyApproved;
            $this->pointsAwarded = $recentlyApproved->potential_points ?? 0;
            $this->recipeName = $recentlyApproved->name ?? 'Recipe';
            $this->feedback = $recentlyApproved->feedback ?? '';
            $this->description = $recentlyApproved->description ?? '';
            $this->showApprovalModal = true;

            // Mark this approval as shown
            $recentlyApproved->update(['notification_shown' => true]);

            Log::info('Showing recipe approval modal', [
                'recipe_id' => $recentlyApproved->id,
                'user_id' => Auth::id(),
                'points' => $this->pointsAwarded,
                'recipe_name' => $this->recipeName
            ]);
        }
    }

    public function closeModal()
    {
        $this->showApprovalModal = false;
    }

    public function render()
    {
        return view('livewire.recipe-approval-modal');
    }
}
