<?php

namespace App\Traits;

trait DynamicTitleTrait
{
    protected function getPageTitle($currentRoute = null, $step = null)
    {
        $titles = [
            // User Routes
            'user' => [
                'dashboard' => 'Manuscript Submission',
                'submit' => 'Start Submission',
                'documents' => 'My Submissions',
                'profile' => 'My Profile',
                'step1' => 'Abstract Submission',
                'step2' => 'Abstract Submission',
                'preview' => 'Abstract Submission',
                'step1_research' => 'Proposal Submission',
                'step2_research' => 'Proposal Submission',
                'preview_research' => 'Proposal Submission',
                'drafts' => 'Drafts'
            ],
            
            // Admin Routes
            'admin' => [
                'dashboard' => 'Registrar-PRI Admin',
                'documents' => 'Manage Submissions',
                'users' => 'Manage Users',
                'drafts' => 'All Drafts',
                'profile' => 'Admin Profile',
                'reports' => 'Completed Submissions',
                'research-assessments' => 'Research Assessment',
                'research-assessments.show' => 'Assessment Details',
            ],
            
            // Reviewer Routes
            'reviewer' => [
                'dashboard' => 'Reviewer Dashboard',
                'documents' => 'Documents for Review',
                'reviewed' => 'Completed Documents',
                'profile' => 'Reviewer Profile',
            ]
        ];

        if ($step && isset($titles[$step])) {
            return $titles[$step];
        }

        // Get the current route name
        $route = $currentRoute ?? optional(request()->route())->getName();
        
        // Split the route name to get the role and action
        $parts = explode('.', $route);
        
        if (count($parts) >= 2) {
            $role = $parts[0];    // 'user', 'admin', or 'reviewer'
            $action = $parts[1];   // 'dashboard', 'profile', etc.
            
            // Return the title if it exists for the role and action
            if (isset($titles[$role][$action])) {
                return $titles[$role][$action];
            }
        }

        // Default fallback title
        return 'Manuscript System';
    }

    // Helper method to get current user role
    protected function getCurrentUserRole()
    {
        if (auth()->check()) {
            $user = auth()->user();
            if ($user->hasRole('admin')) return 'admin';
            if ($user->hasRole('reviewer')) return 'reviewer';
            return 'user';
        }
        return null;
    }
}