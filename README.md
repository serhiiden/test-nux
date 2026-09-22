# Test task: реєстрація + унікальний лінк + Imfeelinglucky

Laravel 12, PHP 8.2, MySQL 8. Запуск через Docker Compose.

## Вимоги

- Docker + Docker Compose (більше нічого не потрібно — PHP і MySQL піднімаються в контейнерах).

## Покрокова інструкція запуску

1. Клонувати репозиторій і перейти в нього:

   ```bash
   git clone <repo-url> test-nuxgame
   cd test-nuxgame
   ```

2. Створити файл оточення (значення за замовчуванням уже налаштовані під docker-compose):

   ```bash
   cp .env.example .env
   ```

3. Зібрати образ застосунку:

   ```bash
   docker compose build
   ```

4. Встановити залежності:

   ```bash
   docker compose run --rm --no-deps app composer install
   ```

5. Згенерувати ключ застосунку:

   ```bash
   docker compose run --rm --no-deps app php artisan key:generate
   ```

6. Підняти сервіси (MySQL стартує з healthcheck, застосунок дочекається його готовності):

   ```bash
   docker compose up -d
   ```

7. Виконати міграції:

   ```bash
   docker compose exec app php artisan migrate
   ```

8. Відкрити застосунок у браузері: <http://localhost:8000>

## Тести

```bash
docker compose exec app php artisan test
```

Тести використовують SQLite in-memory, база в MySQL не зачіпається.

## Зупинка

```bash
docker compose down          # зупинити контейнери
docker compose down -v       # + видалити дані MySQL
```

## Запуск без Docker (опційно)

Потрібні локальні PHP 8.2 (з розширенням `pdo_mysql`), Composer і MySQL:

1. `cp .env.example .env` і вказати в `.env` реквізити своєї MySQL (`DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).
2. `composer install`
3. `php artisan key:generate`
4. `php artisan migrate`
5. `php artisan serve` → <http://localhost:8000>
