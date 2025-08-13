<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    /**
     * Mass-assignable attributes for the Category model.
     * These are the fields you can fill using create() or update().
     */
    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'is_visible',
        'description',
    ];

    /**
     * Get the parent category for this category.
     *
     * Relationship type: Belongs To
     * - Each category may have ONE parent category.
     * - Uses the 'parent_id' column to find the related category.
     * Example: "Phones" belongs to "Electronics".
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, foreignKey: 'parent_id');
    }

    /**
     * Get all child categories for this category.
     *
     * Relationship type: Has Many
     * - A category can have MANY child categories.
     * - Looks for other categories where 'parent_id' equals this category's ID.
     * Example: "Electronics" has many children — "Phones", "Laptops".
     */
    public function child(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Get all products associated with this category.
     *
     * Relationship type: Belongs To Many
     * - A category can contain MANY products.
     * - A product can belong to MANY categories.
     * - Requires a pivot table (default: category_product).
     * Example: "Phones" category has products like "iPhone", "Samsung Galaxy".
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}

/**
 * Other possible relationships you might add in the future:
 *
 * 1. siblings() — Categories that share the same parent.
 *    return $this->parent->child()->where('id', '!=', $this->id);
 *
 * 2. visibleChildren() — Filtered children that are visible only.
 *    return $this->child()->where('is_visible', true);
 *
 * 3. topLevelCategories() — Categories without a parent.
 *    return self::whereNull('parent_id');
 */
