# Babysitter Booking Application

A simple web application for on-demand babysitter booking services.


### Setup Steps

1. **Clone the repository**

2. **Create Env File**

Before that make a .env file from .env.example by copy or renaming .env.example


3. **Backend Setup**
   ```
   # Install PHP dependencies
   composer install

   # Generate application key
   php artisan key:generate

   # Run migrations
   php artisan migrate

   # Start Laravel server
   php artisan serve

   # Or using herd 
    herd link 
    herd open

   ```

4. **Frontend Setup**
   ```
    # install node modules
       npm install

    # for running the frontend app can use dev server 
     npm run dev 

    # or you can build the assets
     npm run build

   ```

## Features
- Reservation form for babysitter booking
- Summary page to review booking details
- Confirmation page with booking reference

## Tech Stack
- Frontend: Vue 3 with TypeScript
- Backend: Laravel
