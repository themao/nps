nps
===

npp-nps.com: Symfony 6.4 LTS + Sonata Admin 4 on PHP 8.2.35 (includes the CVE-2026-109618 / CVE-2026-109619 fix).

Run locally
-----------

    docker compose up -d --build
    docker compose exec php composer install
    docker compose exec php bin/console doctrine:migrations:migrate -n

The site is on http://localhost/ and the admin on http://localhost/admin.
Local overrides (DB, mailer, GA ids) go to `.env.local`, which is not committed; see `.env` for the variables.

Upgrading an existing database
------------------------------

The schema from the Symfony 2.8 version is kept. `migrations/Version20261021000000.php` only adds defaults/nullability
needed by Sonata Media 4 / User 5 (and the `product_translations.noindex` column if missing).
Existing admin passwords (FOSUser salted sha512) keep working and are verified via the `legacy_sha512` hasher.

Production image: `docker build -f docker/php/Dockerfile --target prod .`
