# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

Source code for [bastiaan.dev](https://bastiaan.dev), a personal website/blog built on Laravel 13 + Livewire (Volt) + Livewire's `mary` UI package, styled with Tailwind + daisyUI. Blog posts are not stored in a database — they are Markdown files with YAML frontmatter, read via `spatie/sheets`.

## Commands

**Dev server** (serves PHP, queue listener, and Vite together):
```bash
composer run dev
```

**Frontend only:**
```bash
npm run dev      # Vite dev server
npm run build    # production build
npm run format   # prettier --write resources/ (blade + tailwind class sorting)
```

**Tests** (Pest, on top of PHPUnit):
```bash
php artisan test                                  # full suite
php artisan test --filter=test_name                # single test by name
php artisan test tests/Feature/RoutesTest.php       # single file
```
Test env forces `QUEUE_CONNECTION=sync` and `MAIL_MAILER=array` (see [phpunit.xml](phpunit.xml)) — queued jobs and notifications run inline and land in the array mailer during tests, not on a real queue.

**Static analysis / refactoring:**
```bash
vendor/bin/phpstan analyse --memory-limit=512M   # static analysis; see phpstan.neon (level 5 + larastan)
vendor/bin/rector process                        # dry-run: add --dry-run; see rector.php for configured sets
vendor/bin/pint                                  # PHP code style (Laravel Pint)
```
PHPStan needs `larastan/larastan` (already a dev dependency) to understand Eloquent/Livewire magic — without it, things like `Model::create()`/`Model::where()` and `$request->slug` false-positive as undefined. The default CLI memory limit (128M) is too low; always pass `--memory-limit=512M`. `phpstan.neon` ignores two known-safe categories: dynamic frontmatter properties on `spatie/sheets`' `Sheet` (no stubs ship for them) and a PHPDoc covariance nitpick on the stock `User` model's `$fillable`/`$hidden`.

## Architecture

### Content model: blog posts are files, not database rows

Blog posts live in [posts/](posts/) as `.md` files with YAML frontmatter (`title`, `published`, `publish_date`, `updated_date`, `author`, `intro`, `tags`, `min_read`, `header_image`, optional `faq`) followed by HTML/Markdown body content. `faq` is a list of `question`/`answer` pairs, rendered as a collapsible `<details>` section on the post ([resources/views/livewire/show-blogpost.blade.php](resources/views/livewire/show-blogpost.blade.php)) and as `FAQPage` JSON-LD (see SEO section below) — omit it entirely if a post doesn't warrant one. They are indexed by `spatie/sheets`, configured in [config/sheets.php](config/sheets.php) to read the `posts` collection. There is no `Post` Eloquent model — `Sheets::get($slug)` and `Sheets::all()` are the only access points, used in [app/Livewire/ShowBlogpost.php](app/Livewire/ShowBlogpost.php) and [app/Livewire/IndexBlogpost.php](app/Livewire/IndexBlogpost.php). `IndexBlogpost` filters out `published: false` posts; `ShowBlogpost` does not, so an unpublished post stays reachable by direct URL but won't be listed or appear in the sitemap. To add a post, add a new Markdown file to `posts/`; no migration or seeding needed. The database only stores dynamic per-post state (reactions).

### Routing: full-page Livewire components + Volt

[routes/web.php](routes/web.php) mounts full-page Livewire components directly as route handlers (`Route::get('/blog', IndexBlogpost::class)`) rather than going through controllers — there is only one placeholder controller ([app/Http/Controllers/Controller.php](app/Http/Controllers/Controller.php)). The homepage and contact form are registered via `Volt::route('/', 'welcome')` / `Volt::route('/contact', SendMessage::class)` instead of `Route::get(...)`, but they are still ordinary class-based Livewire components ([app/Livewire/Welcome.php](app/Livewire/Welcome.php), [app/Livewire/SendMessage.php](app/Livewire/SendMessage.php)) with a `render()` method — not Volt's functional/closure-based single-file syntax. `Volt::route()` just resolves the component by name and calls `__invoke()` on it ([VoltManager::route()](vendor/livewire/volt/src/VoltManager.php)); it's a naming convention, not a different component model. Blog routes are wrapped in `Spatie\MarkdownResponse\Middleware\ProvideMarkdownResponse`, which lets a blog page be requested as raw Markdown (e.g. for LLM/agent consumption) instead of rendered HTML.

### Blog reactions: async, session-deduped, keyed by slug (not a post ID)

[app/Livewire/BlogpostReact.php](app/Livewire/BlogpostReact.php) lets a visitor react to a post with one of the `BlogReactionType` enum values (`like`/`love`/`wow`/`haha`, [app/Enums/BlogReactionType.php](app/Enums/BlogReactionType.php)). Since posts aren't database rows, `BlogReaction` rows ([app/Models/BlogReaction.php](app/Models/BlogReaction.php)) are keyed by `blog_post_slug` (a plain string) rather than a foreign key. One reaction per slug per session is enforced in the component via `session()->has('reaction.'.$slug)`, not at the database or job level. The actual write is queued through `AddReactionToBlogpost` ([app/Jobs/AddReactionToBlogpost.php](app/Jobs/AddReactionToBlogpost.php)); the Livewire component optimistically increments its local `$reactionCounts` before the job runs.

### Contact form: validated Livewire component → queued job → notification

[app/Livewire/SendMessage.php](app/Livewire/SendMessage.php) validates input using Livewire's `#[Validate]` attributes, builds an unpersisted `ContactMessage` model instance (used as a plain DTO here, not saved to the database), and dispatches `SendContactMessage` ([app/Jobs/SendContactMessage.php](app/Jobs/SendContactMessage.php)), which sends a `ContactFormSubmitted` notification by mail via ad-hoc `Notification::route`. The recipient is `config('mail.to_address')` ([config/mail.php](config/mail.php), backed by the `MAIL_TO_ADDRESS` env var) — never call `env()` directly outside `config/*`, it silently returns `null` once config is cached in production.

### SEO and structured data

Every full-page component sets its own SEO tags + JSON-LD by building a `RalphJSmit\Laravel\SEO\Support\SEOData` object and calling the `seo($seoData)` helper from `render()` — [ShowBlogpost](app/Livewire/ShowBlogpost.php) (`BlogPosting` + `BreadcrumbList`, plus `FAQPage` via `->addFaqPage()` when the post's frontmatter has a `faq` list), [IndexBlogpost](app/Livewire/IndexBlogpost.php) (`CollectionPage` + `BreadcrumbList`), [Welcome](app/Livewire/Welcome.php) (`WebSite` + `Person`), [SendMessage](app/Livewire/SendMessage.php) (`ContactPage` + `BreadcrumbList`). The schema/JSON-LD is built via `RalphJSmit\Laravel\SEO\SchemaCollection` (either the package's fluent `->addArticle()`/`->addBreadcrumbs()`/`->addFaqPage()` builders, or `->add(fn (SEOData $d) => [...])` for raw schema.org arrays like `WebSite`/`Person`/`CollectionPage`/`ContactPage`). The root layout ([resources/views/components/layouts/app.blade.php](resources/views/components/layouts/app.blade.php)) then just renders the bare `{!! seo() !!}` tag. [config/seo.php](config/seo.php) overrides a handful of package defaults (`site_name`, sitemap `<link>` path, description/author fallbacks) — it only lists the overridden keys, everything else falls back to `ralphjsmit/laravel-seo`'s own config via Laravel's `mergeConfigFrom`.

**Gotcha:** `ralphjsmit/laravel-seo` does not bind its `TagManager` as a singleton itself, so every `seo(...)`/`app(TagManager::class)` call would otherwise resolve a *fresh* instance — meaning the layout's bare `seo()` call silently ignores whatever `SEOData` a component just set, falling back to inferred/default title, `og:type=website`, and no JSON-LD at all. [AppServiceProvider::register()](app/Providers/AppServiceProvider.php) binds `TagManager::class` as a singleton to fix this; do not remove that binding.

Open Graph preview images are generated on demand via `spatie/laravel-og-image` (rendered through `spatie/browsershot`/Puppeteer), configured in [config/og-image.php](config/og-image.php) — image responses are content-hashed and cached aggressively (`redirect_cache_max_age`). Every full-page view includes an `<x-og-image>` block (first child of `<main>`) whose rendered content becomes that page's `og:image`.

**Gotcha:** generating that image makes headless Chrome navigate back to the *same* Laravel process (`?ogimage=1`) to screenshot just that block. A single-worker dev server (`php artisan serve`, plain `php -S`) is still busy with the outer request and can never serve that nested one, so hitting `/og-image/*.jpeg` locally reliably fails with a timeout or `ERR_CONNECTION_REFUSED`. This is expected on single-worker setups, not a bug — it works fine behind a real multi-worker server (php-fpm + nginx).

### llms.txt

[public/llms.txt](public/llms.txt) follows the [llmstxt.org](https://llmstxt.org) convention (served as-is at `/llms.txt`, no route needed) so LLM agents get a curated summary of the site plus links to every page and blog post. It is **hand-maintained, not generated** — when adding a new post to `posts/`, add a matching entry under `## Blog posts` in `llms.txt` too.

### Sitemap

[public/sitemap.xml](public/sitemap.xml) is the opposite of `llms.txt` above: **generated, not hand-maintained.** `php artisan sitemap:generate` ([app/Console/Commands/GenerateSitemap.php](app/Console/Commands/GenerateSitemap.php)) rebuilds it from the actual routes plus `Sheets::all()` (only `published: true` posts), using `url()` so every entry matches `config('app.url')`. It's also scheduled daily in [routes/console.php](routes/console.php) (requires the Laravel scheduler cron running on the server). Never hand-edit `public/sitemap.xml` — the next scheduled run overwrites it.

### Views

Blade components follow atomic-ish naming under `resources/views/components/`: `atoms/` for small reusable pieces (button, hamburger), `layouts/` for page chrome (app/header/footer). Livewire component views live in `resources/views/livewire/`, matching each class in `app/Livewire/`. There is no per-view `@section('meta')`/`@yield('meta')` mechanism — the layout never yields a `meta` section, so titles/descriptions must go through `seo($seoData)` in the component's `render()`, not a Blade section. [resources/views/errors/404.blade.php](resources/views/errors/404.blade.php) is a plain Blade view, not a Livewire component — it wraps `<x-layouts.app>` directly, and Laravel auto-resolves it for any 404 response with no route needed.

The layout sets `<html data-theme="bastiaandev">` ([resources/views/components/layouts/app.blade.php](resources/views/components/layouts/app.blade.php)), the custom dark daisyUI theme defined in [tailwind.config.js](tailwind.config.js) (single accent color, warm `stone` neutrals instead of Tailwind's default cool `gray`). **Gotcha:** without that `data-theme` attribute, daisyUI's form/alert components (`input-bordered`, `alert-*`, etc.) silently fall back to daisyUI's built-in light theme while the rest of the page stays dark — do not remove it.
