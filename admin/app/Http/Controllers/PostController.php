<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Traits\UploadFile;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class PostController extends Controller
{
    use UploadFile;

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('Post/Index', [
            'posts' => Post::orderBy('created_at', 'desc')->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Post/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request): RedirectResponse
    {
        $this->savePostData($request, new Post());

        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post): Response
    {
        return Inertia::render('Post/Show', [
            'post' => $post->load('comments')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post): Response
    {
        return Inertia::render('Post/Update', [
            'post' => $post,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, Post $post): RedirectResponse
    {
        $this->savePostData($request, $post);

        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();
        return redirect()->route('posts.index');
    }

    /**
     * Handles saving or updating a Post model.
     */
    private function savePostData(PostRequest $request, Post $post): Post
    {
        $validatedData = $request->validated();
        $validatedData['slug'] = Str::slug($validatedData['title']);

        $this->handleImageUpload($request, $post, $validatedData);

        if ($post->exists) {
            $post->update($validatedData);
        } else {
            $post->create($validatedData);
        }

        return $post;
    }

    /**
     * Handles image uploads and updates the validated data with the image path.
     */
    private function handleImageUpload(Request $request, Post $post, array &$validatedData): void
    {
        if ($request->hasFile('image')) {
            if ($post->image) {
                $this->uploadDeleteImage($post->image);
            }

            $validatedData['image'] = $this->uploadImage($request->image, 'images');
        } else {
            unset($validatedData['image']);
        }
    }
}
