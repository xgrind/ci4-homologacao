# AGENTS.md — CI4 Homologação

## Stack
CodeIgniter 4.7 + AdminLTE 4 (Bootstrap 5) + Tabulator. PHP ^8.5, MySQL.

## Key commands
- `composer test` — all PHPUnit tests
- `vendor/bin/php-cs-fixer fix` — apply code style (codeigniter/coding-standard)
- `php spark` — CI4 CLI (make:migration, make:model, make:controller, etc.)
- `php spark db:seed PostSeeder` — import from `arqaparecida.arq_noticia` into `posts`

## Routes (`app/Config/Routes.php`)
- `$routes->presenter('posts', ...)` / `$routes->presenter('decretos', ...)` — each auto-generates 8 methods: index, show, new, create, edit, update, remove, delete
- Custom routes (`post.truncate`, `decreto.truncate`) **must** be defined **before** the presenter route to avoid matching as presenter params
- `post.import` route is **commented out** in Routes.php (line 10)
- `PostController::index()` returns JSON when `X-Requested-With: xmlhttprequest`, else renders view (same pattern in `DecretoController::index()`)

## Database
- Three groups in `app/Config/Database.php`: `default` (MySQLi, app), `arqaparecida` (MySQLi, legacy), `tests` (SQLite3 `:memory:`)
- `ENVIRONMENT === 'testing'` auto-switches `$defaultGroup` to `tests` (set in `Database::__construct()`)
- Tests group uses `DBPrefix = 'db_'` and `foreignKeys = true`
- `.env` (gitignored) has dev creds, `CI_ENVIRONMENT = development`
- One seed: `app/Database/Seeds/PostSeeder.php` — reads from `arqaparecida.arq_noticia`, truncates `posts`, inserts with `$model->protect(false)`
- One migration: `app/Database/Migrations/2026-07-15-201513_DecretoMigration.php` — creates `decretos` table; has a known typo: `update_at` instead of `updated_at`
- `composer.json` excludes `**/Database/Migrations/**` from classmap

## App structure (custom code only)
| Path | Notes |
|---|---|
| `app/Controllers/PostController.php` | ResourcePresenter; table `posts`; only `index`, `show`, `edit`, `truncate` implemented; stubs for `new`, `create`, `update`, `remove`, `delete` |
| `app/Controllers/DecretoController.php` | ResourcePresenter; table `decretos`; full CRUD implemented plus `truncate` and empty `import()` stub |
| `app/Models/PostModel.php` | Table `posts`, soft deletes, timestamps, `returnType=PostEntity`, `findOrNotFound()` throws `PageNotFoundException` |
| `app/Models/DecretoModel.php` | Table `decretos`, soft deletes, timestamps, `returnType=DecretoEntity`, `findOrNotFound()` throws `PageNotFoundException` |
| `app/Models/Prod/NoticiaModel.php` | `$DBGroup = 'arqaparecida'`, table `arq_noticia`, legacy source for import |
| `app/Entities/PostEntity.php` | `toArray()` sets default `foto`, truncates `conteudo` (10 words), appends HTML `actions`; uses `#[Override]` attribute (PHP 8.5+) |
| `app/Entities/DecretoEntity.php` | Datamap: `documento→document`, `data→date`, `titulo→title`; `getDate()` returns placeholder `'d'` |
| `app/Entities/Prod/NoticiaEntity.php` | Datamap maps `not_*` → canonical field names |
| `app/Views/default.php` | AdminLTE 4 layout; Tabulator, Bootstrap 5, Bootstrap Icons, OverlayScrollbars from CDN |
| `public/css/`, `public/js/` | AdminLTE 4 assets vendored directly (not via npm) |

## Testing
- Tests extend `CodeIgniter\Test\CIUnitTestCase`
- DB tests use `DatabaseTestTrait` with SQLite `:memory:` (group `tests`, prefix `db_`)
- Config: `phpunit.dist.xml` — copy to `phpunit.xml` to customize (gitignored)
- Bootstrap: `vendor/codeigniter4/framework/system/Test/bootstrap.php`
