<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Traits\UploadFile;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PostController extends Controller
{
    use UploadFile;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::paginate(10);

        return Inertia::render('Post/Index', [
            'posts' => $posts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Post/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        $validatedData = $request->validated();  // Valida os dados

        $post = new Post();  // Cria uma nova instância de Post

        // Lida com o upload da imagem e popula $validatedData com o nome do arquivo
        $this->handleImageUpload($request, $post, $validatedData);

        // Cria o post com os dados validados (incluindo a imagem, se enviada)
        $post->create($validatedData);

        // Redireciona para a lista de posts após a criação
        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return Inertia::render('Post/Update', [
            'post' => $post,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, Post $post)
    {
        $validatedData = $request->validated();

        $this->handleImageUpload($request, $post, $validatedData);
        $post->update($validatedData);

        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }

    /**
     * The function `handleImageUpload` processes image uploads for a post, handling
     * deletion of existing images and updating the validated data accordingly.
     * 
     * @param Request request  is an instance of the Request class, which
     * contains the data and information about the current HTTP request. It is
     * typically used to retrieve input data, files, cookies, and more from the
     * request. In this context, it is being used to handle image uploads for a post.
     * @param Post post The `handleImageUpload` function takes three parameters:
     * ``, ``, and ``.
     * @param validatedData The `validatedData` parameter in the `handleImageUpload`
     * function is a reference to an array that contains data validated from a request.
     * This function handles the image upload logic for a post, and it checks if there
     * is a file named 'image' in the request. If there is, it
     */
    private function handleImageUpload(Request $request, Post $post, &$validatedData): void
    {
        if ($request->hasFile('image')) {
            if ($post->image) {
                $this->uploadDeleteImage($post->image);
            }

            $imageName = $this->uploadImage($request->image, 'images');
            $validatedData['image'] = $imageName;
        } else {
            unset($validatedData['image']);
        }
    }
}
