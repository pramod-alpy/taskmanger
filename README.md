
Task Manager App

This web application built with Laravel.While logging in to the system, user can Add/Edit Task under the given projects. Default Seeders will automatically add Projects like School Management & Inventory Management.



📦 Installation


1️⃣ Clone the Repository
```
git clone https://github.com/pramod-alpy/tak-manager.git
cd task-manager
```
2️⃣ Install PHP Dependencies
```
composer install
```
3️⃣ Install JS Dependencies
```
npm install
```
4️⃣ Copy .env File
```
cp .env.example .env
```
5️⃣ Generate App Key
```
php artisan key:generate
```
6️⃣ Configure Database in .env
```
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=task_manager
DB_USERNAME=root
DB_PASSWORD=
```
8️⃣ Run Migrations

```
php artisan migrate
```
9️⃣ Run Seeders
```
php artisan db:seed
```
🔟 Start Development Servers

Backend
```
php artisan serve

```
Frontend
```
npm run dev

```

⚙️ Tech Stack

* Backend: Laravel, MySQL

* Frontend: Blade Templetes

* Other: Composer, npm



