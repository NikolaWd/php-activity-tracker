# Activity tracking demo

A small PHP 8.1 / MySQL MVC application. Users can register, sign in, visit Page A and Page B, buy a cow once, download a demo executable and view reports. Admins can also view activity statistics and the paginated user list.

## Run locally

1. Copy `.env.example` to `.env` and set the database name, a **non-root** `DB_USERNAME`, `DB_PASSWORD`, and `DB_ROOT_PASSWORD`.
2. Start the containers: `docker compose up -d --build`
3. Create tables: `docker compose exec app php bin/migrate.php`
4. Add demo data: `docker compose exec app php bin/seed.php`
5. Open <http://localhost:9000>.

The seeder adds three admins (`admin1@seed.test` through `admin3@seed.test`), 50 users (`user01@seed.test` through `user50@seed.test`), and 140 demo events. All demo accounts use the password `DemoPassword123!`. These are **development-only credentials**.

## Pages and access

| URL | Access | Purpose |
| --- | --- | --- |
| `/login`, `/register` | Guest | Sign in or create an account |
| `/page-a` | Signed-in user | One-time “Buy a cow” button, then `thankYou` |
| `/page-b` | Signed-in user | Download a harmless example `.exe` |
| `/statistics` | Admin | Events filtered by date range, user and action |
| `/reports` | Signed-in user | Daily four-series chart and totals table |
| `/users` | Admin | Paginated user list |

The download is a tiny **MS-DOS** executable that immediately exits. It demonstrates downloading an actual `.exe` file; it is not intended to run on modern 64-bit Windows.

Page visits, successful login/logout/registration and successful button clicks are stored in `events`. The `cow_purchases` table keeps Page A's one-time state; the button click and purchase are committed together. Daily reports are calculated from the events table, not a separate reports table.

## Production scaling roadmap

The application currently uses PHP sessions and writes events directly to MySQL during HTTP requests. The following are **proposals, not features implemented in this demo**:

1. **Redis:** Use a shared Redis-backed session store when running multiple app instances. Cache frequently requested report aggregates with an expiration time and invalidate them when the underlying data changes. Redis can also back login rate limits.
2. **Queues for events:** Publish non-critical activity events to a durable queue and process them with separate workers so page responses do not wait for every event insert. Add retries, idempotency keys and monitoring for failed jobs. Keep the cow purchase and its click event atomic, or use a transactional outbox before moving that event to a queue. Queued events may appear in statistics after a short delay.
3. **Dedicated request classes:** Extract parsing and validation from controllers into classes such as `RegisterRequest`, `LoginRequest` and `StatisticsFilterRequest`. Controllers can then receive validated values and focus on invoking actions and returning responses.
4. **Reporting at scale:** Add appropriate indexes for real query patterns, paginate large activity tables, and consider daily aggregate tables or scheduled jobs when grouping the full event history becomes slow. Define retention and archival rules for old events.

Before a real deployment, also use HTTPS, remove demo credentials and seed data, store secrets outside version control, add login rate limiting, and set up database backups, error monitoring and a reliable worker restart policy.
