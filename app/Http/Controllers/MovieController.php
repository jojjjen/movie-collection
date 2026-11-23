<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $movies = Movie::when($search, function ($query, $search) {
            $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('director', 'like', '%' . $search . '%')
                ->orWhere('genre', 'like', '%' . $search . '%');
        })->latest()->paginate(10)->withQueryString();
        return view('movies.index', compact('movies', 'search'));
    }


    public function create()
    {
        return view('movies.form', ['movie' => new Movie(), 'mode' => 'create']);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'genre' => 'required|string|max:100',
            'release_year' => 'required|integer|min:1888|max:' . (date('Y') + 5),
            'director' => 'required|string|max:255',
            'status' => 'required|in:Watched,Unwatched',
        ]);
        Movie::create($validated);
        return redirect()->route('movies.index')->with('success', 'Movie added successfully.');
    }


    public function edit(Movie $movie)
    {
        return view('movies.form', compact('movie') + ['mode' => 'edit']);
    }


    public function update(Request $request, Movie $movie)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'genre' => 'required|string|max:100',
            'release_year' => 'required|integer|min:1888|max:' . (date('Y') + 5),
            'director' => 'required|string|max:255',
            'status' => 'required|in:Watched,Unwatched',
        ]);
        $movie->update($validated);
        return redirect()->route('movies.index')->with('success', 'Movie updated successfully.');
    }


    public function destroy(Movie $movie)
    {
        $movie->delete();
        return redirect()->route('movies.index')->with('success', 'Movie deleted successfully.');
    }
}
