<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = [
            [
                'book_name' => 'To Kill a Mockingbird',
                'book_author' => 'Harper Lee',
                'book_publisher' => 'J.B. Lippincott & Co.',
                'book_price' => 450.00,
                'book_genre' => 'Fiction',
                'book_cover_link' => 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1553383690i/2657.jpg',
                'book_pages' => 324,
                'book_isbn_10' => '0060935464',
                'book_isbn_13' => '9780060935467',
                'book_publication_date' => '1960-07-11',
            ],
            [
                'book_name' => 'The Alchemist',
                'book_author' => 'Paulo Coelho',
                'book_publisher' => 'HarperCollins',
                'book_price' => 200.00,
                'book_genre' => 'Fiction',
                'book_cover_link' => 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1654371463i/18144590.jpg',
                'book_pages' => 163,
                'book_isbn_10' => '0062315005',
                'book_isbn_13' => '9780062315007',
                'book_publication_date' => '1988-01-01',
            ],
            [
                'book_name' => 'Sherlock Holmes: The Complete Collection',
                'book_author' => 'Arthur Conan Doyle',
                'book_publisher' => 'Penguin Classics',
                'book_price' => 500.00,
                'book_genre' => 'Mystery',
                'book_cover_link' => 'https://pictures.abebooks.com/inventory/31095529984.jpg',
                'book_pages' => 1122,
                'book_isbn_10' => '0141034355',
                'book_isbn_13' => '9780141034355',
                'book_publication_date' => '1887-01-01',
            ],
            [
                'book_name' => 'Harry Potter and the Philosopher\'s Stone',
                'book_author' => 'J. K. Rowling',
                'book_publisher' => 'Bloomsbury Publishing',
                'book_price' => 1000.00,
                'book_genre' => 'Fantasy',
                'book_cover_link' => 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1633472105i/59223802.jpg',
                'book_pages' => 223,
                'book_isbn_10' => '0747532699',
                'book_isbn_13' => '9780747532699',
                'book_publication_date' => '1997-06-26',
            ],
            [
                'book_name' => 'The Theory of Everything',
                'book_author' => 'Stephen Hawking',
                'book_publisher' => 'Bantam Books',
                'book_price' => 350.00,
                'book_genre' => 'Science',
                'book_cover_link' => 'https://www.bottomscience.com/wp-content/uploads/2021/06/the-theory-of-everything.jpg',
                'book_pages' => 176,
                'book_isbn_10' => '0553385663',
                'book_isbn_13' => '9780553385663',
                'book_publication_date' => '2006-01-01',
            ],
            [
                'book_name' => 'Atomic Habits',
                'book_author' => 'James Clear',
                'book_publisher' => 'Avery',
                'book_price' => 250.00,
                'book_genre' => 'Self-Help',
                'book_cover_link' => 'https://m.media-amazon.com/images/I/81YkqyaFVEL._SL1500_.jpg',
                'book_pages' => 320,
                'book_isbn_10' => '0735211299',
                'book_isbn_13' => '9780735211292',
                'book_publication_date' => '2018-10-16',
            ],
            [
                'book_name' => 'The Old Man and the Sea',
                'book_author' => 'Ernest Hemingway',
                'book_publisher' => 'Charles Scribner\'s Sons',
                'book_price' => 200.00,
                'book_genre' => 'Fiction',
                'book_cover_link' => 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1682515263i/141686298.jpg',
                'book_pages' => 127,
                'book_isbn_10' => '0684801221',
                'book_isbn_13' => '9780684801223',
                'book_publication_date' => '1952-09-01',
            ],
            [
                'book_name' => 'Web Coding & Development All-in-One For Dummies',
                'book_author' => 'Paul McFedries',
                'book_publisher' => 'For Dummies',
                'book_price' => 300.00,
                'book_genre' => 'Programming',
                'book_cover_link' => 'https://m.media-amazon.com/images/I/81gcvKAAsjL._AC_UF1000,1000_QL80_.jpg',
                'book_pages' => 800,
                'book_isbn_10' => '1119473926',
                'book_isbn_13' => '9781119473923',
                'book_publication_date' => '2018-05-07',
            ],
            [
                'book_name' => 'The Art of War',
                'book_author' => 'Sun Tzu',
                'book_publisher' => 'Dover Publications',
                'book_price' => 150.00,
                'book_genre' => 'Philosophy',
                'book_cover_link' => 'https://d28hgpri8am2if.cloudfront.net/book_images/onix/cvr9781626860605/the-art-of-war-9781626860605_hr.jpg',
                'book_pages' => 112,
                'book_isbn_10' => '0486425576',
                'book_isbn_13' => '9780486425573',
                'book_publication_date' => '2005-01-01',
            ],
            [
                'book_name' => 'Digital Logic and Computer Design',
                'book_author' => 'M. Morris Mano',
                'book_publisher' => 'Pearson',
                'book_price' => 180.00,
                'book_genre' => 'Textbook',
                'book_cover_link' => 'https://rukminim2.flixcart.com/image/832/832/kjbr8280-0/book/n/r/x/digital-logic-computer-design-original-imafyx6p4nygphfn.jpeg',
                'book_pages' => 550,
                'book_isbn_10' => '0132145103',
                'book_isbn_13' => '9789332542525',
                'book_publication_date' => '1979-01-01',
            ],
            [
                'book_name' => '1984',
                'book_author' => 'George Orwell',
                'book_publisher' => 'Secker & Warburg',
                'book_price' => 300.00,
                'book_genre' => 'Dystopian Fiction',
                'book_cover_link' => 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1532714506i/40961427.jpg',
                'book_pages' => 328,
                'book_isbn_10' => '0452284236',
                'book_isbn_13' => '9780452284234',
                'book_publication_date' => '1949-06-08',
            ],
            [
                'book_name' => 'The Great Gatsby',
                'book_author' => 'F. Scott Fitzgerald',
                'book_publisher' => 'Charles Scribner\'s Sons',
                'book_price' => 275.00,
                'book_genre' => 'Fiction',
                'book_cover_link' => 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1490528560i/4671.jpg',
                'book_pages' => 180,
                'book_isbn_10' => '0743273567',
                'book_isbn_13' => '9780743273565',
                'book_publication_date' => '1925-04-10',
            ],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }
}
