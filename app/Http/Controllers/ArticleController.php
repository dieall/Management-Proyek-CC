<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::ordered()->paginate(10);
        return view('informasi.articles.index', compact('articles'));
    }

    public function create()
    {
        return view('informasi.articles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link_url' => 'nullable|url|max:255',
            'order' => 'nullable|integer|min:0',
        ]);

        $data = $request->except(['image', 'is_active']);
        $data['is_active'] = $request->has('is_active') ? true : false;
        $data['order'] = $request->order ?? Article::max('order') + 1;

        // Handle upload gambar jika ada
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('articles', 'public');
            // Simpan URL yang bisa diakses publik
            $data['image_url'] = Storage::url($path);
        }

        Article::create($data);

        return redirect()->route('articles.index')->with('success', 'Artikel/Pengumuman berhasil ditambahkan!');
    }

    public function show(Article $article)
    {
        return view('informasi.articles.show', compact('article'));
    }

    public function edit(Article $article)
    {
        return view('informasi.articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link_url' => 'nullable|url|max:255',
            'order' => 'nullable|integer|min:0',
        ]);

        $data = $request->except(['image', 'is_active']);
        $data['is_active'] = $request->has('is_active') ? true : false;

        // Jika upload gambar baru, simpan dan update image_url
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('articles', 'public');
            $data['image_url'] = Storage::url($path);
        }

        $article->update($data);

        return redirect()->route('articles.index')->with('success', 'Artikel/Pengumuman berhasil diperbarui!');
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('articles.index')->with('success', 'Artikel/Pengumuman berhasil dihapus!');
    }
}
