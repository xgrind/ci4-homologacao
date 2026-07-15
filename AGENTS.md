# AGENTS.md — CI4 Homologação

## Stack
CodeIgniter 4.7 + AdminLTE 4 (Bootstrap 5) + Tabulator. PHP ^8.5, MySQL.

## Key commands
- `composer test` — all PHPUnit tests
- `vendor/bin/php-cs-fixer fix` — apply code style (codeigniter/coding-standard)
- `php spark` — CI4 CLI (make:migration, make:model, make:controller, etc.)
- `php spark db:seed PostSeeder` — import from `arqaparecida.arq_noticia` into `posts`

## Routes (`app/Config/Routes.php`)
- `$routes->presenter('posts', ...)` — auto-generates 8 methods: index, show, new, create, edit, update, remove, delete
- Custom routes (`post.import`, `post.truncate`) **must** be defined **before** the presenter route to avoid matching as presenter params
- `post.import` route exists but `import()` method is **missing** from PostController
- `PostController::index()` returns JSON when `X-Requested-With: xmlhttprequest`, else renders `post/index` view

## Database
- Three groups in `app/Config/Database.php`: `default` (MySQLi, app), `arqaparecida` (MySQLi, legacy), `tests` (SQLite3 `:memory:`)
- `ENVIRONMENT === 'testing'` auto-switches `$defaultGroup` to `tests` (set in `Database::__construct()`)
- Tests group uses `DBPrefix = 'db_'` and `foreignKeys = true` — important for test schema setup
- `.env` (gitignored) has dev creds, `CI_ENVIRONMENT = development`
- One seed: `app/Database/Seeds/PostSeeder.php` — reads from `arqaparecida.arq_noticia`, truncates `posts`, inserts with `$model->protect(false)` to bypass field protection
- No migrations yet (`app/Database/Migrations/` empty)
- `composer.json` excludes `**/Database/Migrations/**` from classmap

## App structure (custom code only)
| Path | Notes |
|---|---|
| `app/Controllers/PostController.php` | ResourcePresenter; auto-loads `form` helper via `$helpers` |
| `app/Models/PostModel.php` | Table `posts`, soft deletes, timestamps, `returnType=PostEntity`, `findOrNotFound()` throws `PageNotFoundException` |
| `app/Models/Prod/NoticiaModel.php` | `$DBGroup = 'arqaparecida'`, table `arq_noticia`, legacy source for import |
| `app/Entities/PostEntity.php` | `toArray()` sets default `foto`, truncates `conteudo` (10 words), appends HTML `actions` — used for JSON API response |
| `app/Entities/Prod/NoticiaEntity.php` | Datamap maps `not_*` → canonical field names |
| `app/Views/default.php` | AdminLTE 4 layout; Tabulator, EditorJS, Bootstrap 5, Bootstrap Icons, OverlayScrollbars from CDN |
| `app/Views/post/index.php` | Tabulator table, AJAX data from `PostController::index()` |
| `public/css/`, `public/js/` | AdminLTE 4 assets vendored directly (not via npm) |

## Testing
- Tests extend `CodeIgniter\Test\CIUnitTestCase`
- DB tests use `DatabaseTestTrait` with SQLite `:memory:` (group `tests`, prefix `db_`)
- Config: `phpunit.dist.xml` — copy to `phpunit.xml` to customize (gitignored)
- Bootstrap: `vendor/codeigniter4/framework/system/Test/bootstrap.php`
