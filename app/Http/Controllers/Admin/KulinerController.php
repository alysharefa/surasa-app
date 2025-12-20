<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Kuliner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
class KulinerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $categoryId = $request->input('category');
        $search = $request->input('search');

        $kuliners = Kuliner::with('category')
            ->when($categoryId, function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        $categories = Category::orderBy('name')->get();

        return view('admin.kuliners.index', compact('kuliners', 'categories', 'categoryId', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.kuliners.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:kuliners,name',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'location' => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'price_min' => 'nullable|numeric|min:0',
            'price_max' => 'nullable|numeric|min:0|gte:price_min',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'contact' => 'nullable|string|max:255',
            'open_hours' => 'nullable|string|max:255',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('kuliners', 'public');
        }

        $gallery = [];
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $gallery[] = $image->store('kuliners/gallery', 'public');
            }
        }

        Kuliner::create([
            'name' => $request->name,
            'slug' => $this->generateUniqueSlug($request->name),
            'description' => $request->description,
            'category_id' => $request->category_id,
            'location' => $request->location,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'price_min' => $request->price_min,
            'price_max' => $request->price_max,
            'image' => $imagePath,
            'gallery' => $gallery ?: null,
            'contact' => $request->contact,
            'open_hours' => $request->open_hours,
            'is_featured' => $request->boolean('is_featured'),
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()
            ->route('admin.kuliners.index')
            ->with('success', 'Kuliner berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kuliner $kuliner): View
    {
        $kuliner->load([
            'category',
            'comments' => function ($query) {
                $query->with('user')->latest();
            },
            'ratings' => function ($query) {
                $query->with('user');
            },
        ]);

        return view('admin.kuliners.show', compact('kuliner'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kuliner $kuliner): View
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.kuliners.edit', compact('kuliner', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kuliner $kuliner): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'location' => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'price_min' => 'nullable|numeric|min:0',
            'price_max' => 'nullable|numeric|min:0|gte:price_min',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'contact' => 'nullable|string|max:255',
            'open_hours' => 'nullable|string|max:255',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'location' => $request->location,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'price_min' => $request->price_min,
            'price_max' => $request->price_max,
            'contact' => $request->contact,
            'open_hours' => $request->open_hours,
            'is_featured' => $request->boolean('is_featured'),
            'is_active' => $request->boolean('is_active', true),
        ];

        if ($request->hasFile('image')) {
            // Delete old image
            if ($kuliner->image) {
                Storage::disk('public')->delete($kuliner->image);
            }
            $data['image'] = $request->file('image')->store('kuliners', 'public');
        }

        if ($request->hasFile('gallery')) {
            // Delete old gallery
            if ($kuliner->gallery) {
                foreach ($kuliner->gallery as $image) {
                    Storage::disk('public')->delete($image);
                }
            }

            $gallery = [];
            foreach ($request->file('gallery') as $image) {
                $gallery[] = $image->store('kuliners/gallery', 'public');
            }
            $data['gallery'] = $gallery;
        }

        $kuliner->update($data);

        return redirect()
            ->route('admin.kuliners.index')
            ->with('success', 'Kuliner berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kuliner $kuliner): RedirectResponse
    {
        // Delete images
        if ($kuliner->image) {
            Storage::disk('public')->delete($kuliner->image);
        }

        if ($kuliner->gallery) {
            foreach ($kuliner->gallery as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $kuliner->delete();

        return redirect()
            ->route('admin.kuliners.index')
            ->with('success', 'Kuliner berhasil dihapus');
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured(Kuliner $kuliner): RedirectResponse
    {
        $kuliner->update([
            'is_featured' => !$kuliner->is_featured,
        ]);

        return back()->with('success', 'Status featured berhasil diubah');
    }

    /**
     * Toggle active status
     */
    public function toggleActive(Kuliner $kuliner): RedirectResponse
    {
        $kuliner->update([
            'is_active' => !$kuliner->is_active,
        ]);

        return back()->with('success', 'Status aktif berhasil diubah');
    }

    /**
     * Generate a unique slug for a kuliner
     */
    private function generateUniqueSlug(string $name, ?int $excludeId = null): string
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        while (true) {
            $query = Kuliner::where('slug', $slug);
            
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }

            if (!$query->exists()) {
                break;
            }

            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
