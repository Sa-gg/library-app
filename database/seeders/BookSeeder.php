<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Seed the books table with sample library titles.
     */
    public function run(): void
    {
        $books = [
            [
                'title'       => 'To Kill a Mockingbird',
                'author'      => 'Harper Lee',
                'isbn'        => '978-0-06-112008-4',
                'description' => 'A classic of modern American literature about racial injustice in the Deep South, seen through the eyes of young Scout Finch.',
                'quantity'    => 3,
                'available'   => 3,
            ],
            [
                'title'       => '1984',
                'author'      => 'George Orwell',
                'isbn'        => '978-0-45-152493-5',
                'description' => 'A dystopian novel set in a totalitarian society ruled by Big Brother, exploring themes of surveillance, propaganda, and individual freedom.',
                'quantity'    => 2,
                'available'   => 2,
            ],
            [
                'title'       => 'Pride and Prejudice',
                'author'      => 'Jane Austen',
                'isbn'        => '978-0-14-143951-8',
                'description' => 'A witty romantic novel about the turbulent relationship between Elizabeth Bennet and Mr. Darcy in Regency-era England.',
                'quantity'    => 2,
                'available'   => 2,
            ],
            [
                'title'       => 'The Great Gatsby',
                'author'      => 'F. Scott Fitzgerald',
                'isbn'        => '978-0-74-327356-5',
                'description' => 'A portrait of the Jazz Age in all its decadence, following the mysterious millionaire Jay Gatsby and his obsession with Daisy Buchanan.',
                'quantity'    => 3,
                'available'   => 3,
            ],
            [
                'title'       => 'One Hundred Years of Solitude',
                'author'      => 'Gabriel García Márquez',
                'isbn'        => '978-0-06-088328-7',
                'description' => 'A landmark of magical realism tracing the multi-generational story of the Buendía family in the mythical town of Macondo.',
                'quantity'    => 1,
                'available'   => 1,
            ],
            [
                'title'       => 'The Catcher in the Rye',
                'author'      => 'J.D. Salinger',
                'isbn'        => '978-0-31-676948-0',
                'description' => 'The story of teenage Holden Caulfield\'s experiences in New York City after being expelled from prep school.',
                'quantity'    => 2,
                'available'   => 2,
            ],
            [
                'title'       => 'Brave New World',
                'author'      => 'Aldous Huxley',
                'isbn'        => '978-0-06-085052-4',
                'description' => 'A futuristic dystopia where humans are genetically engineered and socially conditioned in a seemingly perfect but deeply troubling world.',
                'quantity'    => 2,
                'available'   => 2,
            ],
            [
                'title'       => 'The Hobbit',
                'author'      => 'J.R.R. Tolkien',
                'isbn'        => '978-0-54-792822-7',
                'description' => 'The adventure of Bilbo Baggins, a hobbit who embarks on an unexpected journey with a group of dwarves to reclaim their homeland from the dragon Smaug.',
                'quantity'    => 4,
                'available'   => 4,
            ],
            [
                'title'       => 'Don Quixote',
                'author'      => 'Miguel de Cervantes',
                'isbn'        => '978-0-06-093434-7',
                'description' => 'The tale of a man so enchanted by reading romances of chivalry that he sets out to revive knighthood, accompanied by his faithful squire Sancho Panza.',
                'quantity'    => 1,
                'available'   => 1,
            ],
            [
                'title'       => 'Sapiens: A Brief History of Humankind',
                'author'      => 'Yuval Noah Harari',
                'isbn'        => '978-0-06-231609-7',
                'description' => 'A sweeping narrative of human history from the Stone Age to the present, exploring how Homo sapiens came to dominate the planet.',
                'quantity'    => 3,
                'available'   => 3,
            ],
            [
                'title'       => 'Noli Me Tángere',
                'author'      => 'José Rizal',
                'isbn'        => '978-971-08-1048-1',
                'description' => 'A foundational novel of Philippine literature exposing the corruption of Spanish colonial rule and the Catholic friars in the Philippines.',
                'quantity'    => 3,
                'available'   => 3,
            ],
            [
                'title'       => 'Norwegian Wood',
                'author'      => 'Haruki Murakami',
                'isbn'        => '978-0-37-575402-7',
                'description' => 'A nostalgic coming-of-age story set in 1960s Tokyo, exploring themes of love, loss, and the bittersweet passage of youth.',
                'quantity'    => 2,
                'available'   => 2,
            ],
            [
                'title'       => 'The Alchemist',
                'author'      => 'Paulo Coelho',
                'isbn'        => '978-0-06-112241-5',
                'description' => 'A philosophical fable about a young Andalusian shepherd who dreams of finding treasure in Egypt and discovers the importance of following one\'s destiny.',
                'quantity'    => 2,
                'available'   => 2,
            ],
            [
                'title'       => 'Dune',
                'author'      => 'Frank Herbert',
                'isbn'        => '978-0-44-117271-9',
                'description' => 'An epic science fiction saga set on the desert planet Arrakis, following young Paul Atreides as he navigates politics, religion, and ecology.',
                'quantity'    => 2,
                'available'   => 2,
            ],
            [
                'title'       => 'The Art of War',
                'author'      => 'Sun Tzu',
                'isbn'        => '978-1-59-030227-8',
                'description' => 'An ancient Chinese military treatise offering timeless strategies on conflict, leadership, and tactics that remain influential today.',
                'quantity'    => 1,
                'available'   => 1,
            ],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }
}
