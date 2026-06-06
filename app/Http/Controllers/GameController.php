<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class GameController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Game::query();

        if ($request->filled('category') && $request->category !== 'all') {
            $query->byCategory($request->category);
        }

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        if ($request->boolean('featured')) {
            $query->featured();
        }

        $games = $query
            ->orderByDesc('is_featured')
            ->orderByDesc('plays')
            ->paginate($request->get('per_page', 12));

        return response()->json($games);
    }

    public function show(Game $game): JsonResponse
    {
        return response()->json($game);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'category'    => 'required|string|max:100',
            'embed_url'   => 'required|url',
            'thumbnail'   => 'nullable|url',
            'is_featured' => 'boolean',
            'tags'        => 'nullable|array',
            'tags.*'      => 'string|max:50',
        ]);

        $game = Game::create($validated);

        return response()->json($game, 201);
    }

    public function update(Request $request, Game $game): JsonResponse
    {
        $validated = $request->validate([
            'title'       => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'category'    => 'sometimes|string|max:100',
            'embed_url'   => 'sometimes|url',
            'thumbnail'   => 'nullable|url',
            'is_featured' => 'boolean',
            'tags'        => 'nullable|array',
            'tags.*'      => 'string|max:50',
        ]);

        $game->update($validated);

        return response()->json($game);
    }

    public function destroy(Game $game): JsonResponse
    {
        $game->delete();

        return response()->json(['message' => 'Game deleted successfully']);
    }

    public function play(Game $game): JsonResponse
    {
        $game->incrementPlays();

        return response()->json([
            'message' => 'Play recorded',
            'plays'   => $game->plays,
        ]);
    }

    public function categories(): JsonResponse
    {
        $categories = Game::query()
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return response()->json($categories);
    }

    public function featured(): JsonResponse
    {
        $games = Game::featured()
            ->orderByDesc('plays')
            ->limit(6)
            ->get();

        return response()->json($games);
    }

    public function serveRom(Game $game): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $path = storage_path('app/roms/' . basename($game->rom_url));

        abort_unless(file_exists($path), 404);

        return response()->file($path, [
            'Content-Type' => 'application/zip',
        ]);
    }
}
