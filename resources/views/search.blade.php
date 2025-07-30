<!DOCTYPE html>
<html>

<head>
    <title>AI Category Search</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <h1 class="text-center mb-4">🔍 AI Category Search</h1>

                <form method="POST" action="{{ route('search') }}">
                    @csrf
                    <div class="input-group mb-3">
                        <input
                            type="text"
                            name="query"
                            class="form-control"
                            placeholder="Type category, sub-category or service..."
                            value="{{ old('query', $query ?? '') }}"
                            required>
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </form>

                @if(isset($results))
                @if(count($results))
                <div class="card mt-4">
                    <div class="card-header bg-success text-white">
                        <strong>Results</strong>
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach($results as $result)
                        <li class="list-group-item">
                            <strong>Category:</strong> {{ $result['name'] }}<br>
                            <strong>Sub-Category:</strong> {{ $result['sub_category'] ?? '—' }}<br>
                            <span class="badge bg-primary mt-2">Score: {{ number_format($result['score'], 2) }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @else
                <div class="alert alert-warning mt-4">
                    No results found.
                </div>
                @endif
                @endif

            </div>
        </div>
    </div>
</body>

</html>
