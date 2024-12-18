<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Category;
use League\Csv\Reader;

class CategorySeeder extends Seeder
{
    public function run()
    {
        // Path to your CSV file
        $csvFilePath = database_path('data/categories.csv');

        // Read the CSV data
        $csv = Reader::createFromPath($csvFilePath, 'r');
        $csv->setDelimiter(';'); // Update based on your CSV delimiter
        $csv->setHeaderOffset(0); // Use the first row as headers

        // Fetch all records as an array
        $records = iterator_to_array($csv->getRecords());

        // Insert categories while ensuring uniqueness
        foreach ($records as $record) {
            // Use firstOrCreate to ensure no duplicates based on 'name'
            Category::firstOrCreate(
                ['name' => $record['name']],
                ['description' => $record['description']]
            );
        }
    }
}
