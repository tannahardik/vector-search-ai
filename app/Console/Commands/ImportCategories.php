<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Http;
use App\Models\Category;
use App\Helpers\CohereHelper;

class ImportCategories extends Command
{
    protected $signature = 'import:categories';
    protected $description = 'Import categories with embeddings and keywords';

    public function handle()
    {
        $path = storage_path('app/Lynx_Keyword_Enhanced_Services.xlsx');
        $rows = Excel::toArray([], $path)[0];

        // Skip header and filter empty
        $filtered = collect($rows)->filter(function ($row, $index) {
            return $index !== 0 && !empty($row[0]) && !empty($row[2]);
        });



        $filtered->chunk(90)->each(function ($chunk) {
            // Combine category + subcategory into single text for embedding
            $queries = $chunk->map(function ($row) {
                return trim("{$row[0]} {$row[1]}");
            })->values()->all();

            $embeddings = CohereHelper::getEmbeddings($queries);

            foreach ($chunk->values() as $i => $row) {
                Category::create([
                    'name'         => $row[0],
                    'sub_category' => $row[1],
                    'service'      => $row[2],
                    'keywords'     => $row[3] ?? '',
                    'embedding'    => $embeddings[$i] ?? null,
                ]);

                $this->info("✅ Imported: " . $queries[$i]);
            }
        });

        $this->info("🎉 All data imported successfully.");
    }
}
