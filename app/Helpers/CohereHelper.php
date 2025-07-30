<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class CohereHelper
{
    public static function getEmbeddings(array $texts): array
    {
        $apiKey = config('services.cohere.api_key');

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$apiKey}",
            'Content-Type'  => 'application/json',
        ])->post('https://api.cohere.ai/v1/embed', [
            'model'       => 'embed-english-v3.0',
            'input_type'  => 'search_document', // must match allowed values
            'texts'       => $texts,
        ]);

        if ($response->failed()) {

            return array_fill(0, count($texts), null);
        }

        return $response->json('embeddings') ?? [];
    }

    public static function cosineSimilarity(array $a, array $b): float
    {
        $dotProduct = array_sum(array_map(fn($x, $y) => $x * $y, $a, $b));
        $magnitudeA = sqrt(array_sum(array_map(fn($x) => $x * $x, $a)));
        $magnitudeB = sqrt(array_sum(array_map(fn($x) => $x * $x, $b)));

        return $magnitudeA * $magnitudeB !== 0 ? $dotProduct / ($magnitudeA * $magnitudeB) : 0;
    }
}
