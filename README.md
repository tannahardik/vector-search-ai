# 📚 AI Vector Search Engine

A Laravel-based AI-powered vector search system for intelligent and relevant text matching using embeddings and cosine similarity.

## 🚀 Features

- Import categories/subcategories/services via Excel
- Generate vector embeddings using cohere
- Perform semantic search using cosine similarity  
- Store and manage embeddings in JSON/DB for fast retrieval  
- Simple and extendable Laravel controller
- CLI commands for importing categories
## 🛠️ Tech Stack

- **Backend**: Laravel 11  
- **Embeddings**: cohere 
- **Search**: Cosine Similarity  
- **Frontend**: Blade 
- **Storage**: MySQL 8.4.3 
- **CLI**: Custom Artisan Commands

## 📁 Project Structure

```
/app
  /Console/Commands/ImportCategories.php
  /Http/Controllers/SearchController.php
  /Helpers/CohereHelper.php
/resources/views/search.blade.php
/routes/web.php
/database/migrations/2025_07_29_090841_create_categories_table.php
```

## ⚙️ Setup Instructions

```bash
git clone https://github.com/tannahardik/vector-search-ai.git
cd vector-search-ai
composer install
cp .env.example .env
php artisan key:generate
update database configs and cohere key in .env
php artisan migrate

```

## 💾 Import Category Data

```bash
put Lynx_Keyword_Enhanced_Services.xlsx file in storage/app folder
php artisan import:categories
```

## 🔍 Run Search

Start the server:
```bash
php artisan serve
```

Search via UI:
```
http://127.0.0.1:8000/
```

## 🧠 How It Works

1. Input query is embedded into a vector using `cohere`
2. All stored categories/services are compared using cosine similarity
3. Top N matching results are returned to the user

Note : cohere key has limit of 1000 calls per month

## 📦 Dependencies

- `cohere` – for embeddings  
- `cosine-similarity` – for computing similarity  
- Laravel Excel (for imports)

## 📜 License

MIT License
