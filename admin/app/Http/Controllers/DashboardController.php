<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Traits\UploadFile;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtenção dos totais de posts, comentários e usuários
        $totalPosts = Post::count();
        $totalComments = Comment::count();
        $totalUsers = User::count();

        // Retorna para o frontend usando Inertia com os dados
        return Inertia::render('Dashboard', [
            'totalPosts' => $totalPosts,
            'totalComments' => $totalComments,
            'totalUsers' => $totalUsers,
        ]);
    }
}
