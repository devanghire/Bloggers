# 🚀 APIs for Blog management system

    A modern Laravel 12-based web application built with PHP, MySQL


---

## 🛠️ Features

    # Blog

        * User can create | update | delete | view blogs
        * User can like | remove like the blogs
        * User get list of blog with filter to 
            get the most liked Blogs and also
            get the latest added BLOGs
            
            

## Tech Stack & Core Features

- Laravel 12 (Latest)
- Authentication (API ( used Sanctum for auth))
- Eloquent ORM

## 📦 Requirements

- PHP >= 8.2
- Composer
- MySQL
- Laravel CLI (`laravel`)

---

## 🚀 Installation

```bash
# 1. Clone the repository
    git clone https://github.com/devanghire/Hire-Cloud.git

    cd your-laravel12-project

# 2. Install dependencies
    composer install

# 3. Copy .env and generate app key
    cp .env.example .env
    php artisan key:generate

# 4. Set your DB credentials in .env
    DB_DATABASE=your_db
    DB_USERNAME=your_user
    DB_PASSWORD=your_password

# 5. Run migrations
php artisan migrate:fresh --seed


# 7. Serve the application
php artisan serve

#Note
   * You run migration with seeder. get email & password from seeder
   * API postman collection added in app/PostmanCollecton folder
   * Copy .env.example to your .env
