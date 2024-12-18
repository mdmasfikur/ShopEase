<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use League\Csv\Reader;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    protected static $csvData = null;

    public function definition()
    {
        // Ensure CSV data is loaded only once
        if (self::$csvData === null) {
            $this->loadCSVData(database_path('data/products.csv'),',');
        }

        // Pick a random record from the CSV data
        $record = self::$csvData[array_rand(self::$csvData)];

        return [
            'name' => $record['name'],
            'description' => $record['description'],
            'price' => $this->faker->randomFloat(2, 10, 500),
            'is_hot' => $this->faker->boolean(20), // 20% chance of being hot
            'is_featured' => $this->faker->boolean(5), // 20% chance of being hot
            'views' => $this->faker->numberBetween(0, 1000),
            'sales' => $this->faker->numberBetween(0, 1000),
            'category_id' => Category::inRandomOrder()->value('id') ?? Category::factory(), // Link to a category
        ];
    }
    private function loadCSVData(string $csvFilePath, string $delimiter = ';')
    {
        $csv = Reader::createFromPath($csvFilePath, 'r');
        $csv->setDelimiter($delimiter);
        $csv->setHeaderOffset(0);

        // Store all records in the static property
        self::$csvData = iterator_to_array($csv->getRecords());
    }
}
