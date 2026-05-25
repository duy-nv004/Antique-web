<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    /**
     * Get all categories.
     */
    public function getAllCategories(): Collection
    {
        return Category::all();
    }

    /**
     * Get all active categories.
     */
    public function getActiveCategories(): Collection
    {
        return Category::where('is_active', 1)->get();
    }

    /**
     * Get paginated categories.
     */
    public function paginateCategories(int $perPage = 10): LengthAwarePaginator
    {
        return Category::paginate($perPage);
    }

    /**
     * Create a new category.
     */
    public function createCategory(array $data): Category
    {
        return Category::create($data);
    }

    /**
     * Find a category by ID.
     */
    public function findCategoryById(int $id): Category
    {
        return Category::findOrFail($id);
    }

    /**
     * Get all categories except a specific ID.
     */
    public function getCategoriesExcept(int $id): Collection
    {
        return Category::where('id', '!=', $id)->get();
    }

    /**
     * Update an existing category.
     */
    public function updateCategory(Category $category, array $data): bool
    {
        return $category->update($data);
    }

    /**
     * Delete a category.
     */
    public function deleteCategory(Category $category): ?bool
    {
        return $category->delete();
    }
}

