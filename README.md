# Zoho CRM Integration (Laravel + Inertia.js)

Простое и надежное решение для интеграции веб-формы с Zoho CRM (создание Account и связанного с ним Deal).

# Предварительные требования

php 8.3
composer

## 🚀 Быстрый старт

1. **Клонируйте репозиторий:**
   ```bash
   git clone <ссылка_на_ваш_репозиторий>
   cd <название_папки>
2. **Установка**
composer install
npm install

3. **Настройте окружение**
Скопируйте .env.example в .env

Сгенерируйте ключ: php artisan key:generate

Укажите ваши данные Zoho API в .env:
ZOHO_CLIENT_ID=...
ZOHO_CLIENT_SECRET=...
ZOHO_REFRESH_TOKEN=...
ZOHO_BASE_URL=[https://www.zohoapis.eu/crm/v3](https://www.zohoapis.eu/crm/v3)
ZOHO_ACCOUNTS_URL=[https://accounts.zoho.eu/oauth/v2/token](https://accounts.zoho.eu/oauth/v2/token)

Запустите проект:
npm run dev
php artisan serve
