# Activity tracking demo

A small PHP 8.1 / MySQL MVC application. Users can register, sign in, visit Page A and Page B, buy a cow once, download a demo executable and view reports. Admins can also view activity statistics and the paginated user list.

## Run locally

You need Docker with the Docker Compose plugin. Make sure ports **9000** (website) and **3310** (MySQL from your computer) are available. Run all commands below from the project root. On GitHub, each fenced code block has a copy button.

### 1. Create the environment file

```bash
cp -n .env.example .env
```

`-n` preserves an existing `.env` file. Open `.env` in your editor and fill in all four values. For a local demo, you can use:

```dotenv
DB_DATABASE=test_db
DB_USERNAME=db_user
DB_PASSWORD=local_user_password
DB_ROOT_PASSWORD=local_root_password
```

`DB_USERNAME` **must not be `root`**: the MySQL container creates it as a regular database user. Docker Compose passes these settings to the containers. Keep `.env` private; it is excluded from Git.

### 2. Build and start the containers

```bash
docker compose up -d --build
```

The `app` container serves the site, and the `db` container runs MySQL. On the first start, MySQL may need a few seconds to initialize. Compose waits for the database healthcheck before starting `app`. Check that `db` is healthy and `app` is running:

```bash
docker compose ps
```

If `db` has stopped, inspect its startup messages before continuing:

```bash
docker compose logs db
```

### 3. Install PHP dependencies

```bash
docker compose exec app composer install
```

This generates `vendor/autoload.php`, which the application and CLI scripts need. The `vendor/` directory is not stored in Git.

### 4. Create the database tables

```bash
docker compose exec app php bin/migrate.php
```

The script applies the SQL files from `database/migrations/` in order. Once `app` has started, the database should be ready. On later runs, already-applied migrations print `Skipping`.

### 5. Insert demo users and events

```bash
docker compose exec app php bin/seed.php
```

This runs the user seeder before the event seeder, so the event foreign keys have users to reference. Re-running it skips existing demo records.

### 6. Open the application

Visit <http://localhost:9000> and sign in with:

```text
Email:    admin1@seed.test
Password: DemoPassword123!
```

For a regular user, use `user01@seed.test` with the same password. The seeders create three admins, 50 regular users and 140 demo events. These credentials are **for local development only**.

To stop the containers without deleting the database volume:

```bash
docker compose down
```

MySQL keeps its data in a Docker volume. Changing the `.env` credentials later does not automatically update accounts already created in that volume; do not delete the volume just to troubleshoot a connection issue.

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
