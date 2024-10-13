<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalPosts = Post::count();
        $totalComments = Comment::count();
        $totalUsers = User::count();

        return Inertia::render('Dashboard', [
            'totalPosts' => $totalPosts,
            'totalComments' => $totalComments,
            'totalUsers' => $totalUsers,
        ]);
    }
}
