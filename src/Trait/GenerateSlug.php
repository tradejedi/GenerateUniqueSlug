<?php

namespace TradeJedi\Traits;

use Illuminate\Support\Str;

trait GeneratesSlug
{
    /**
     * Генерация уникального slug.
     *
     * @param string $value Значение для генерации slug
     * @param string $column Название столбца slug в модели
     * @param int|null $id Исключение записи по ID (например, для обновления)
     * @return string Уникальный slug
     */
    public static function generateUniqueSlug(string $value, string $column = 'slug', ?int $id = null): string
    {
        $slug = Str::slug($value);
        $originalSlug = $slug;

        $exists = static::where($column, $slug)
            ->when($id, fn($query) => $query->where('id', '!=', $id))
            ->exists();

        $counter = 1;

        while ($exists) {
            $slug = "{$originalSlug}-{$counter}";

            $exists = static::where($column, $slug)
                ->when($id, fn($query) => $query->where('id', '!=', $id))
                ->exists();

            $counter++;
        }

        return $slug;
    }
}
