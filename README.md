# Rateany

Discover, rate, and analyze businesses and professionals with AI‑powered summaries.

<p>
<strong>Stack:</strong> Laravel 11 · PHP 8.2 · Livewire 3 · Sanctum · Tailwind CSS · Vite · Bootstrap 5 · Google Gemini API · Google reCAPTCHA · AWS S3 (Flysystem)  
<strong>License:</strong> MIT
</p>

</div>

## Table of Contents

1. Overview
2. Core Features
3. Architecture & Design
4. Tech Stack & Dependencies
5. Domain Model & Data Schema
6. Smart Scoring & Ratings Logic
7. AI Review Generation Flow
8. Services Layer Summary
9. Livewire Components
10. Routing Overview (Web + API)
11. API Endpoints Reference
12. Directory Structure
13. Environment Configuration
14. Installation & Setup
15. Data Seeding
16. Running in Development
17. Testing
18. Security Measures
19. Performance & Scalability Notes
20. Deployment Guide
21. Contributing
22. Roadmap / Future Ideas
23. License

---

## 1. Overview

Rateany is a review and discovery platform for both businesses and individual professionals. Users can browse categories & professions, view profiles, leave ratings, and consume concise AI‑generated sentiment summaries. An internal smart score blends average rating and review volume to surface top entities. AI summaries are generated via Google Gemini and stored for fast reuse. reCAPTCHA protects public review submission.

## 2. Core Features

-   Public directory of businesses (by category & location) and professionals (by profession & location)
-   User & business profile pages with slug/username based routing
-   Review submission (with rating + comments) and dynamic average rating recalculation
-   Smart score ranking (weighted rating + review count)
-   AI‑powered business summaries (internal reviews and optional external web prompt)
-   Livewire interactive UI components (SPA‑like navigation, pagination, filtering)
-   Contact form with persistence (`UserQuery`)
-   Authentication via Laravel Sanctum + traditional session (login/register throttled)
-   Image/logo support (ready for S3 via Flysystem AWS adapter)
-   reCAPTCHA validation for anonymous review protection

## 3. Architecture & Design

Layered approach:

-   Presentation: Blade + Livewire components (dynamic filtering, pagination, AI generation trigger)
-   HTTP Controllers: REST endpoints & traditional form flows (`UserController`, `BusinessController`, `ReviewController`, `UserQueryController`, `AuthController`)
-   Services: Encapsulate business logic (e.g. `ReviewService` for rating math, `BusinessService` for filtering & ranking, `AIReviewsService` for prompt assembly)
-   Models / Eloquent ORM: Entities & relationships
-   External Integrations: Gemini API (AI content), Google reCAPTCHA, AWS S3 (via `league/flysystem-aws-s3-v3`), optional email services
-   Queue / Async: Jobs table present (ready for deferred AI or image processing)

Design Principles:

-   Separation of concerns (controllers stay lean, services own logic)
-   Declarative relationships & query scopes (`scopeFilter`, `scopeWithSmartScore`)
-   Idempotent AI summary storage via `updateOrCreate`
-   Slug & username uniqueness handled at creation time (collision avoidance logic)

## 4. Tech Stack & Dependencies

Backend (composer.json):

-   Laravel Framework ^11.9
-   PHP ^8.2
-   Livewire ^3.5 (reactive components & SPA‑like navigation)
-   Laravel Sanctum (API authentication / SPA token)
-   Laravel UI (auth scaffolding supplement)
-   Flysystem AWS S3 v3 (cloud storage readiness)
-   Tinker (interactive REPL)

Dev / Tooling:

-   Laravel Sail (optional Docker dev environment)
-   Pint (code style)
-   PHPUnit ^11
-   Collision, Mockery, Faker

Frontend (package.json):

-   Vite (ESBuild/Rollup dev & prod bundling)
-   Tailwind CSS 3
-   Bootstrap 5 (utility + component hybrid usage)
-   Axios (HTTP client)
-   Sass, PostCSS, Autoprefixer

External Services:

-   Google Gemini (Generative AI summaries via REST)
-   Google reCAPTCHA (spam protection)
-   AWS S3 (media storage, optional)

## 5. Domain Model & Data Schema (Key Tables)

### Users (`users`)

Fields: `id`, `name`, `email`, `password`, `profession_id`, `username`, `profile_pic`, `bio`, `location`, contact info, rating aggregates (`average_rating`, `reviews_count`, star buckets), timestamps.
Relationships: `profession` (belongsTo), `businesses` (hasMany), `writtenReviews` (hasMany Reviews as reviewer), `reviews` (hasMany Reviews about user).

### Professions (`professions`)

Fields: `id`, `name`, `slug`, `count` (number of professionals), timestamps.
Relationships: `users` (hasMany).

### Categories (`categories`)

Fields: `id`, `name`, `slug`, timestamps.
Relationships: `businesses` (hasMany).

### Businesses (`businesses`)

Fields: `id`, `userId` (owner), `categoryId`, `name`, `description`, `location`, `slug`, rating aggregates, logo & contact info, timestamps.
Relationships: `owner` (User), `category` (Category), `reviews` (hasMany), `aiSummary` (hasOne `AISummary`).
Scopes: `filter($filters)`, `withSmartScore()`.

### Reviews (`reviews`)

Fields: `id`, `user_id` (subject user), `business_id`, `reviewer_id`, `rating`, `comments`, `type`, timestamps.
Relationships: `user`, `business`, `reviewer`.

### AI Summaries (`ai_summaries`)

Fields: `id`, `business_id`, `ai_summary`, timestamps.
Relationship: `business`.

### User Queries (`user_queries`)

Fields: `id`, `name`, `email`, `message`, timestamps.

## 6. Smart Scoring & Ratings Logic

Both `Business` and `User` models implement a composite smart score for ranking:

Formula:

```
smart_score = (average_rating * 0.7) + (reviews_count * 0.3)
```

Where:

-   `average_rating` is recalculated on each new review.
-   `reviews_count` increments when a review is added.
-   Star bucket columns (`1_star_count` ... `5_star_count`) accumulate distribution (used for recalculating average).

`ReviewService::updatingCounting()` handles updating star buckets + recomputing average efficiently.

## 7. AI Review Generation Flow

1. User triggers AI review (Livewire component / route `generate-ai-review`).
2. `AIReviewsService::generateBusinessAIReview(businessId)` builds rich prompt: business metadata + latest 12 reviews.
3. `GeminiService::generateContent(prompt)` sends HTTP POST to Gemini model endpoint.
4. Response text extracted from `candidates[0].content.parts[0].text`.
5. `AIReviewsService::saveAIReview()` persists / upserts summary in `ai_summaries`.
6. Displayed on business page for future visits (avoids repeated cost/time).

External review flow (`generateExternalBusinessAIReview`) optionally instructs model to perform web‑style sentiment synthesis (future enhancement may offload to queued job).

## 8. Services Layer Summary

-   `BusinessService`: Filtering, ranking, pagination, top businesses.
-   `UserService`: Filtering, ranking professionals, creation tracking profession counts.
-   `ReviewService`: Star bucket maintenance, average rating recomputation, review creation.
-   `AIReviewsService`: Prompt construction, summary persistence (internal/external variants).
-   `GeminiService`: Low-level HTTP integration with Gemini API (model + temperature customization).
-   `CaptchaService`: Validates Google reCAPTCHA (GDPR‑friendly IP anonymization).

## 9. Livewire Components (Representative)

`Home`, `BusinessCard`, `TopRatedBusiness`, `ReviewStars`, `Navbar`, `GenerateAIReview`  
Nested Groups: `Businesses/*` (list, page, categories, rate-now), `Professionals/*` (list, profile page), `Auth/*` (Login, Register), `Profile/*` (Profile management).  
Navigation & filtering leverage Livewire's SPA mode (`wire:navigate`) enhancing UX without full page reloads.

## 10. Routing Overview

### Web (`routes/web.php`)

-   Auth prefix: login/register (throttled @ `5 req/min`), logout, authenticate
-   Users: profile edit/update/image, write-review form, professional detail
-   Businesses: CRUD (create/edit/update/delete), review form, manage, public listing & single page via slug
-   Reviews: POST create
-   Contact: show form + store + admin listing
-   Categories / Professions: listing + slug pages
-   AI: generate AI review page
-   Professionals: listing + profile

### Middleware Highlights

-   `auth` for protected profile & management areas
-   Throttling on auth routes

### API (`routes/api.php`)

-   Authenticated `/user` (Sanctum)
-   Users: index/show/create/delete
-   Businesses: index/show/create/update/delete
    (Extendable for reviews & AI endpoints in future.)

## 11. API Endpoints Reference (Selected)

Base path: `/api`

Users:

-   GET `/users` → List (paginated/filter extensible)
-   GET `/users/{id}` → Retrieve
-   POST `/users` → Create (expects form fields defined in `User::$fillable`)
-   DELETE `/users/{id}` → Delete

Businesses:

-   GET `/businesses` → List (supports filters via query string when integrated)
-   GET `/businesses/{id}` → Retrieve
-   POST `/businesses` → Create (`name`, `categoryId`, `location`, etc.)
-   PUT `/businesses/{id}` → Update
-   DELETE `/businesses/{id}` → Delete

Auth/Profile:

-   GET `/user` (Requires `auth:sanctum` token)

Sample Success (JSON):

```json
{
	"id": 42,
	"name": "Acme Coffee",
	"average_rating": 4.6,
	"reviews_count": 128,
	"smart_score": 4.6 * 0.7 + 128 * 0.3,
	"category": {"id": 3, "name": "Cafe", "slug": "cafe"}
}
```

## 12. Directory Structure (Key Paths)

```
app/
	Models/          # Eloquent entities & relationships
	Services/        # Business logic, integrations
	Http/Controllers # Route controllers
	Livewire/        # Interactive components
config/            # Framework & service configuration
database/
	migrations/      # Schema evolution scripts
	seeders/         # Initial & sample data population
resources/
	views/           # Blade templates (incl. Livewire views)
	css/js           # Frontend assets (Tailwind, Vite entrypoints)
routes/            # web.php & api.php route maps
public/            # Public entrypoint (index.php), assets
tests/             # PHPUnit test suites (Feature, Unit)
```

## 13. Environment Configuration

Duplicate and rename `.env.example` to `.env`, then set:

```
APP_NAME=Rateany
APP_ENV=local
APP_KEY=base64:...
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=rateany
DB_USERNAME=your_user
DB_PASSWORD=your_pass

RECAPTCHA_SITE_KEY=your_site_key
RECAPTCHA_SECRET_KEY=your_secret_key
GEMINI_API_KEY=your_gemini_key
AWS_ACCESS_KEY_ID=...
AWS_SECRET_ACCESS_KEY=...
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=...
FILESYSTEM_DISK=s3   # or local
```

Never commit real keys—use environment secrets in deployment.

## 14. Installation & Setup

Prerequisites: PHP 8.2+, Composer, Node 18+, MySQL/PostgreSQL, optionally Docker (Sail).

```bash
# Clone
git clone <repo-url>
cd Rateany

# Backend deps
composer install

# Frontend deps
npm install

# Environment
cp .env.example .env
php artisan key:generate

# Migrate schema
php artisan migrate

# (Optional) Seed sample data
php artisan db:seed

# Start dev (multi-process convenience script)
composer run dev
```

If using Sail (Docker): `./vendor/bin/sail up -d` then run migrations/seeds inside container (`./vendor/bin/sail artisan migrate`).

## 15. Data Seeding

Default seeding uses defined factories (`UserFactory`, `BusinessFactory`, `ReviewFactory`). Run global seeder:

```bash
php artisan db:seed
```

Or target a specific seeder (e.g. `BusinessSeeder`).

## 16. Running in Development

Multi-process convenience script (`composer dev`) launches:

-   Laravel server
-   Queue listener (`queue:listen`) – ready for future async tasks
-   Log tailing (`pail`) – real-time application logs
-   Vite dev server – HMR for assets

Alternatively manual:

```bash
php artisan serve
php artisan queue:listen
npm run dev
```

## 17. Testing

Run full suite:

```bash
phpunit
```

Or via Artisan:

```bash
php artisan test
```

Add tests under `tests/Feature` (HTTP endpoints, Livewire interactions) & `tests/Unit` (services logic). Suggested critical tests:

-   Review creation recalculates average rating & star buckets
-   Smart score ordering returns expected top entities
-   AI summary generation persists `ai_summaries` row
-   Captcha failure blocks review submission (mock service)

## 18. Security Measures

-   Throttled auth routes (`throttle:5,1`) mitigate brute force
-   Sanctum for token-based API protection
-   reCAPTCHA validation for anonymous review submissions
-   Mass assignment controlled via `$fillable`
-   Password hashing (Laravel native casts)
-   Slug/username uniqueness generation avoids enumeration collisions
-   CSRF protection (Laravel middleware)
-   Sensitive keys only in `.env`

## 19. Performance & Scalability Notes

-   Smart score computed in SQL (`selectRaw`)—efficient ordering
-   Pagination for large listings (`paginate()` on users/businesses)
-   Potential indexes: `businesses.slug`, `users.username`, foreign keys `userId`, `categoryId`, `profession_id`
-   Caching opportunities: top businesses/professionals list, AI summaries after creation
-   Queue workers prepared for offloading external AI review/web scraping tasks

## 20. Deployment Guide (High-Level)

1. Build assets: `npm run build`
2. Set production `.env` (keys, DB, S3)
3. Run migrations: `php artisan migrate --force`
4. (Optional) Seed essential lookup data (professions/categories)
5. Configure queue worker (Supervisor / Horizon) for future async jobs
6. Set up cron for scheduled tasks if added later (`artisan schedule:run`)
7. Enforce HTTPS & secure headers (reverse proxy / server config)

## 21. Contributing

1. Fork & branch from `main`
2. Follow PSR-12 style (Laravel Pint can auto-fix: `./vendor/bin/pint`)
3. Add/adjust tests for new functionality
4. Submit PR with clear description & screenshots (if UI changes)

## 22. Roadmap / Future Ideas

-   Role-based access control (admin moderation / report abuse)
-   Public API documentation (OpenAPI spec generation)
-   Review editing & flagging workflows
-   Full-text / fuzzy search (Laravel Scout + Meilisearch/Algolia)
-   Caching layer (Redis) for top lists & AI summaries
-   Background external review aggregation (scheduled jobs)
-   WebSockets for live rating updates
-   Image optimization pipeline (queued resize)

## 23. License

Released under the MIT License. See `LICENSE` (add if missing).

---

### Quick Start Cheat Sheet

```bash
composer install
npm install
cp .env.example .env && php artisan key:generate
php artisan migrate --seed
composer run dev
```

### Smart Score Formula

```
smart_score = (average_rating * 0.7) + (reviews_count * 0.3)
```

### AI Summary Trigger (Concept)

```php
$service = new \App\Services\AIReviewsService();
$text = $service->generateBusinessAIReview($businessId);
$service->saveAIReview($businessId, $text);
```

---

For questions or support, open an issue or start a discussion.

Happy rating! ⭐
