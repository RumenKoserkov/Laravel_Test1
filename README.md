### 1) Създай user laravel (като root)

### Създава Linux потребител "laravel" 
* `adduser laravel`

### Дава sudo права на потребителя.
* `usermod -aG sudo laravel`
-----------------------------------------------------------------------------
###2) Инсталирай Docker + git (като root)

### Обновява списъка с пакети.
* `apt-get update`

### Инсталира нужните пакети за repo/key + git.
* `apt-get install -y ca-certificates curl gnupg git unzip`

### Създава директория за ключове на външни репота.
* `install -m 0755 -d /etc/apt/keyrings`

### Сваля и записва GPG ключа на Docker repo.
* `curl -fsSL https://download.docker.com/linux/ubuntu/gpg | gpg --dearmor -o /etc/apt/keyrings/docker.gpg`

### Дава права key файлът да се чете от apt.
* `chmod a+r /etc/apt/keyrings/docker.gpg`

### Добавя официалното Docker repo към apt.
* `echo "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.gpg] https://download.docker.com/linux/ubuntu $(. /etc/os-release && echo ${VERSION_CODENAME}) stable" \
| tee /etc/apt/sources.list.d/docker.list > /dev/null`

### Обновява пакети след добавяне на docker repo.
* `apt-get update`

### Инсталира Docker Engine + compose plugin (compose v2).
* `apt-get install -y docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin`

### Docker права за laravel (като root)
### Добавя laravel към docker групата (docker без sudo).
* `usermod -aG docker laravel`

-----------------------------------------------------------------------------
### 3) Влез като laravel

### Превключваш към потребителя laravel.
* `su - laravel`

### Проверка: Docker е наличен.
* `docker --version`

### Проверка: docker compose plugin работи.
* `docker compose version`
-----------------------------------------------------------------------------
4) Clone проекта

### Създава папка за проекти.
* `mkdir -p ~/apps`

### Влизаш в папката.
* `cd ~/apps`

### Клонира репото.
* `git clone http://192.168.1.201/Rumen/laravel_test1.git`

### Влизаш в проекта.
* `cd Laravel_Test1`

-----------------------------------------------------------------------------
### 5) .env (копирай и настрой)

### Създава .env от шаблона.
* `cp .env.example .env`

### Редактираш .env.
* `vim .env`


Минимум задължителни стойности:

### URL за достъп (локално на сървъра).
* `APP_URL=http://localhost:8081`

###DB_HOST=mysql е service name от compose, не localhost.
* `DB_CONNECTION=mysql`
* `DB_HOST=mysql`
* `DB_PORT=3306`
* `DB_DATABASE=laravel`
* `DB_USERNAME=sail`
* `DB_PASSWORD=password`

### Redis контейнера по service name.
* `REDIS_HOST=redis`

### Портове + уникално име на проекта, за да няма конфликти.
* `APP_PORT=8081`
* `FORWARD_DB_PORT=3308`
* `VITE_PORT=5174`
* `COMPOSE_PROJECT_NAME=laravel_test1`

### Задава UID/GID за Sail runtime build-а.
* `WWWUSER=1000`
* `WWWGROUP=1000`

-----------------------------------------------------------------------------
### 6) Composer install (за да имаш vendor/ и sail)

### Инсталира PHP dependencies в vendor/ чрез временен composer контейнер.
### След това вече имаш ./vendor/bin/sail
* `docker run --rm \
  -u "$(id -u):$(id -g)" \
  -v "$(pwd):/app" \
  -w /app \
  composer:2 \
  composer install --no-interaction --prefer-dist`

-----------------------------------------------------------------------------
### 7) Fix на compose.yaml (ако го има този ред)

### Маха реда "image: sail-8.5/app" ако присъства (за да не override-ва build).
* `vim compose.yaml`
-----------------------------------------------------------------------------
### 8) Стартирай контейнерите със Sail

### Стартира и билдва контейнерите през Sail (реално docker compose wrapper).
* `./vendor/bin/sail up -d --build`


### Показва контейнерите на проекта (по-чисто от docker ps).
* `./vendor/bin/sail ps`


-----------------------------------------------------------------------------
### 9) Laravel setup (само веднъж)

### Генерира APP_KEY и го записва в .env (без него дава 500).
* `./vendor/bin/sail artisan key:generate`

### Пуска миграциите в MySQL контейнера.
* `./vendor/bin/sail artisan migrate --force`

### Прави symlink за uploads; || true ако вече съществува да не гърми.
* `./vendor/bin/sail artisan storage:link || true`

--------------------------------------------------------------------------------
### ▶️ Стартиране
* `./vendor/bin/sail up -d`

### 🛑 Спиране
* `./vendor/bin/sail down`
