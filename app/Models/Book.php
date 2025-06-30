<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'books';
    protected $primaryKey = 'book_id';
    public $timestamps = false;

    protected $fillable = [
        'book_name',
        'book_author',
        'book_publisher',
        'book_price',
        'book_genre',
        'book_cover_link',
        'book_pages',
        'book_isbn_10',
        'book_isbn_13',
        'book_publication_date',
    ];

    public static function genres(): array
    {
        return static::query()
            ->select('book_genre')
            ->distinct()
            ->whereNotNull('book_genre')
            ->pluck('book_genre')
            ->toArray();
    }

    public static function authors(): array
    {
        return static::query()
            ->select('book_author')
            ->distinct()
            ->whereNotNull('book_author')
            ->pluck('book_author')
            ->toArray();
    }

    public static function publishers(): array
    {
        return static::query()
            ->select('book_publisher')
            ->distinct()
            ->whereNotNull('book_publisher')
            ->pluck('book_publisher')
            ->toArray();
    }
}
