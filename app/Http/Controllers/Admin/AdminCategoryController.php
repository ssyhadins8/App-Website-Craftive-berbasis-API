<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate(['name' => 'required|string', 'icon' => 'nullable|string']);
        return response()->json(Category::create($validated), 201);
    }
}