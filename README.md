### Стъпка 1: Подготовка в GitHub
    1. Влез в профила си в GitHub.
    2. Кликни на New repository.
    3. Repository name: Напиши името (напр. Laravel_Test1).
    4. Public/Private: Избери според нуждите си.
    5. Не слагай отметка на "Add a README file", "Add .gitignore" или "Choose a license", тъй като Laravel проектът ти вече има свои такива файлове.
    6. Кликни Create repository.
    7. Копирай HTTPS линка.

### Стъпка 2: Подготовка за качване на проекта
* `git init`
* `git add .`
* `git commit -m "Initial commit"`
* `git branch -M main`

### Стъпка 3: Свързване и Качване
* `git remote add origin https://github.com/URL.git`
* `git push -u origin main`


///////////////////////////////////////////////////////////////////
### Настройки на нов сървър
# 0) База данни
* Правиш си база данни през adminer или където ти е кеф.

# 1) Composer
* `cd /tmp`
* `php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"`
* `sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer`
* `composer --version`

# 2) Потребител
* `sudo adduser new_user`
* `sudo usermod -aG sudo new_user`

# 3) Права над /var/www
* `sudo chown -R new_user:new_user /var/www`

# 4) SSH за VS Code (АКО СЕ НАЛОЖИ!!!!!!!!!!!!!)
* `sudo vim /etc/ssh/sshd_config`
* `PasswordAuthentication yes`
* `sudo systemctl restart ssh`

# 5) Клониране + composer install
* `cd /var/www`
* `git clone https://github.com/RumenKoserkov/Laravel_Test1.git test1`
* `cd test1`
* `composer install`

# 6) Laravel конфигурация + права
* `cp .env.example .env`
* `php artisan key:generate`
* `vim .env` (Попълни DB данните тук!)
* `sudo chown -R new_user:www-data storage bootstrap/cache`
* `sudo chmod -R 775 storage bootstrap/cache`
* `php artisan migrate`

проба 18.02