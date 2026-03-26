<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use Cloudinary\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all items from the database
        $items = Item::orderBy('name', 'asc')->get();

        // Return the view with the items
        return view('admin.item.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('category_name', 'asc')->get();

        // Return the view to create a new item
        return view('admin.item.create', compact('categories'));
    }

    private function uploadToCloudinary($file): array
    {
        $cloudinary = new Cloudinary(config('cloudinary.cloud_url'));
        $result = $cloudinary->uploadApi()->upload($file->getRealPath(), [
            'folder' => 'img_item_upload',
        ]);

        return [
            'img'           => $result['secure_url'],
            'img_public_id' => $result['public_id'],
        ];
    }

    private function deleteFromCloudinary(?string $publicId): void
    {
        if ($publicId) {
            $cloudinary = new Cloudinary(config('cloudinary.cloud_url'));
            $cloudinary->uploadApi()->destroy($publicId);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => [
                'required',
                Rule::exists(Category::class, 'id'),
            ],
            'img' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'required|boolean',
        ],
        [
            'name.required' => 'The item name is required.',
            'description.string' => 'The description must be a string.',
            'price.required' => 'The price is required.',
            'category_id.required' => 'The category is required.',
            'img.image' => 'The image must be an image file.',
            'img.max' => 'The image size must not exceed 2MB.',
            'is_active.required' => 'The active status is required.',
            'is_active.boolean' => 'The active status must be true or false.',
        ]);

        if ($request->hasFile('img')) {
            $validatedData = array_merge($validatedData, $this->uploadToCloudinary($request->file('img')));
        }

        $item = Item::create($validatedData);

        return redirect()->route('items.index')->with('success', 'Item created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $item = Item::findOrFail($id);
        $categories = Category::orderBy('category_name', 'asc')->get();

        // Return the view to create a new item
        return view('admin.item.edit', compact('item','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => [
                'required',
                Rule::exists(Category::class, 'id'),
            ],
            'img' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'required|boolean',
        ], [
            'name.required' => 'The item name is required.',
            'description.string' => 'The description must be a string.',
            'price.required' => 'The price is required.',
            'category_id.required' => 'The category is required.',
            'img.image' => 'The image must be an image file.',
            'img.max' => 'The image size must not exceed 2MB.',
            'is_active.required' => 'The active status is required.',
            'is_active.boolean' => 'The active status must be true or false.',
        ]);

        $item = Item::findOrFail($id);

        // Handle image upload ke Cloudinary
       if ($request->hasFile('img')) {
            $this->deleteFromCloudinary($item->img_public_id);
            $validatedData = array_merge($validatedData, $this->uploadToCloudinary($request->file('img')));
        }

        $item->update($validatedData);

        return redirect()->route('items.index')->with('success', 'Item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the item and delete it
        $item = Item::findOrFail($id);
        $item->delete();

        // Redirect to the items index with a success message
        return redirect()->route('items.index')->with('success', 'Item deleted successfully.');
    }

    public function updateStatus($id)
    {
        $item = Item::findOrFail($id);
        $item->is_active = !$item->is_active;
        $item->save();

        return redirect()->route('items.index')->with('success', 'Item status updated successfully.');
    }
}
