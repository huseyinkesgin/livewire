<?php

namespace App\Traits;

trait AutoCode
{
    public static function getModelTranslation(string $modelName): ?array
    {
        return config("model-translations.models.{$modelName}");
    }

    public static function getPrefix(string $modelName): string
    {
        $translation = self::getModelTranslation($modelName);

        if (!$translation) {
            return strtoupper($modelName);
        }

        return $translation['code_prefix'] ?? strtoupper($translation['turkish_name']);
    }

    public static function getNextAvailableNumber(): int
    {
        $prefix = self::getPrefix(class_basename(self::class));

        // Tüm kodları al ve numaralarını çıkar
        $numbers = self::query()
            ->where('Code', 'like', $prefix . '-%')
            ->get()
            ->map(function ($model) {
                preg_match('/-(\d+)$/', $model->Code, $matches);
                return (int) $matches[1];
            })
            ->sort()
            ->values()
            ->toArray();

        if (empty($numbers)) {
            return 1;
        }

        // Dizideki boşlukları bul
        $expectedNext = 1;
        foreach ($numbers as $number) {
            if ($number > $expectedNext) {
                return $expectedNext;
            }
            $expectedNext = $number + 1;
        }

        return $expectedNext;
    }

    public static function generateCode(): string
    {
        $prefix = self::getPrefix(class_basename(self::class));
        $nextNumber = self::getNextAvailableNumber();

        return $prefix . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }

    public static function bootAutoCode()
    {
        static::creating(function ($model) {
            if (empty($model->Code)) {
                $model->Code = self::generateCode();
            }
        });
    }
}