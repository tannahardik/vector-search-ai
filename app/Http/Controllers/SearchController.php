<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Helpers\CohereHelper;

class SearchController extends Controller
{
    public function index()
    {
        return view('search');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        if (!$query) {
            return view('search', ['results' => [], 'query' => '']);
        }

        $queryVector = CohereHelper::getEmbeddings([$query]);

        $vector = $queryVector[0];
        // $this->embedText($query);

        $results = Category::all()
            ->map(function ($category) use ($vector) {
                return [
                    'name' => $category->name,
                    'sub_category' => $category->sub_category,
                    'service' => $category->service,
                    'score' => CohereHelper::cosineSimilarity($vector, $category->embedding)
                ];
            })
            ->sortByDesc('score')
            ->take(5)
            ->filter(fn($item) => $item['score'] > 0.35)
            ->values();

        return view('search', [
            'results' => $results,
            'query' => $query
        ]);
    }

    // private function embedText($text)
    // {
    //     $apiKey = config('services.cohere.api_key');;

    //     $response = Http::withHeaders([
    //         'Authorization' => "Bearer {$apiKey}",
    //         'Content-Type' => 'application/json'
    //     ])->post('https://api.cohere.ai/v1/embed', [
    //         'texts' => [$text],
    //         'model' => 'embed-english-v3.0',
    //         'input_type' => 'search_document'
    //     ]);
    //     return $response->json()['embeddings'][0];
    // }


}
