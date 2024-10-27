<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    const VIEW = 'admin.categories.';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Category::latest('id')->paginate(5);
        return view(self::VIEW.__FUNCTION__, compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(self::VIEW.__FUNCTION__);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => [
                'required',
                'max:255',
                Rule::unique('categories')
            ],
        ]);

        try {
            Category::query()->create($data);
            return redirect()->route('categories.index')->with('msg', 'Created successfully.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('msg', false);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view(self::VIEW.__FUNCTION__, compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => [
                'required',
                'max:255',
                Rule::unique('categories')->ignore($category->id)
            ],
        ]);

        try {
            $category->update($data);
            return redirect()->route('categories.index')->with('msg', 'Updated successfully.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('msg', false);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            $category->delete();
            return redirect()->route('categories.index')->with('msg', 'Deleted successfully.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('msg', false);
        }
    }
}
