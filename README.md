### 1\. **`curl -s "https://laravel.build/events-api" | bash`**

This command is used to set up a new Laravel project using Docker. Let's break it down:

-   **`curl -s "https://laravel.build/events-api"`:**

    -   **`curl`**: A command-line tool that fetches data from the internet.
    -   **`-s`**: This flag tells `curl` to run silently (without showing extra information).
    -   **`"https://laravel.build/events-api"`**: This URL points to a script that helps you set up a Laravel project with Docker. When you visit this URL in a browser, it will return a script that helps set up a Docker-based Laravel environment.

    So, `curl` gets the script from this URL.

-   **`| bash`**: This part pipes the output of the `curl` command (the script) into the `bash` shell, which then runs the script.

### What happens when you run this command?

This command helps you set up a **Laravel development environment** with **Docker** by fetching a script and running it. It will do the following:

-   It will create a new Laravel project directory (in this case, called `events-api`).
-   It will set up Docker containers for various services like MySQL, Redis, MailPit (for mail testing), Meilisearch (search engine), etc.
-   It creates a Docker-based development environment for your Laravel application, which is isolated and ensures you don't need to install services like MySQL or Redis locally.

**Example:** Imagine you're trying to start a Laravel project, and you don't want to install all the dependencies (like MySQL, Redis, etc.) on your local machine. This command does all that for you by using Docker, which runs those services inside containers, making your local environment clean and easy to work with.

---

### 2\. **`events-api ./vendor/bin/sail up`**

This command is used to start the Laravel development environment with Docker. Let's break it down:

-   **`events-api`**: This refers to the project directory that was created by the first command. It's the folder where the Laravel application is stored.
-   **`./vendor/bin/sail`**: This refers to the Sail tool that's provided by Laravel. Sail is a lightweight command-line interface for interacting with Docker for Laravel projects. It simplifies running Docker containers for development.
-   **`up`**: This is the command given to Sail, asking it to "bring up" (start) all the Docker containers that were defined in the `docker-compose.yml` file. These containers include things like MySQL, Redis, MailPit, etc.

### What happens when you run this command?

When you run `./vendor/bin/sail up`, it starts up all the necessary Docker containers for your Laravel application to run smoothly. These containers might include:

-   **Web server (like Nginx)**: Handles incoming requests to your application.
-   **Database (like MySQL)**: Stores data for your application.
-   **Redis**: Helps with caching and other memory-based operations.
-   **MailPit**: A tool to catch and view emails that are sent from your Laravel application (for testing purposes).
-   **Meilisearch**: Provides search functionality.
-   **Selenium**: If you have automated tests for your application, Selenium runs them in a browser.

Once you run this command, you can open your browser and go to `http://localhost` (or the IP address of your Docker environment), and you should see your Laravel application running.

**Example:** Imagine you have a Laravel project with a MySQL database and an email service. You run `./vendor/bin/sail up`, and Sail starts Docker containers for the MySQL database and MailPit (for email handling). You don't need to worry about setting these services up manually.

---

### **Running Database Migrations**

Once your Docker containers are up and running, you will likely need to **migrate the database**. Laravel uses **migrations** to manage your database schema in a version-controlled manner. Migrations are a way of updating and modifying your database structure over time, allowing you to share the database changes with your team or other developers.

To run the migrations, use the following command:

bash

CopyEdit

`./vendor/bin/sail artisan migrate`

Let's break this down:

-   **`./vendor/bin/sail`**: As mentioned earlier, Sail is the Laravel tool to interact with Docker containers.
-   **`artisan`**: Artisan is Laravel's command-line interface (CLI) that provides many helpful commands for developing applications. `artisan migrate` is used to run the database migrations.
-   **`migrate`**: This is the specific Artisan command that tells Laravel to run the migrations. Migrations could be to create new tables, alter existing ones, or even add some initial data to the database.

When you run `./vendor/bin/sail artisan migrate`, this will:

-   Connect to the MySQL (or other database) container that was started by Docker.
-   Look for any migration files in your Laravel project (these are usually stored in the `database/migrations/` directory).
-   Execute those migration files to update the database schema, for example, creating tables or adding columns.

In this case, since you were experiencing the **sessions table not found** error earlier, running `artisan migrate` would create the necessary `sessions` table in your database if it hasn't been created yet.

### To summarize, here's the process:

1.  **Start Docker containers** with the command `./vendor/bin/sail up`. This starts all necessary services like web server and database in Docker containers.
2.  **Run database migrations** with the command `./vendor/bin/sail artisan migrate`. This applies any database schema changes that are required (like creating missing tables such as `sessions`).
3.  **Access the application** via your browser at `http://localhost`. Your Laravel app should now be running and accessible.v

### ERD: Models and Migrations

sail artisan make:model Roles -m

sail artisan migrate

sail artisan make:migration add_role_id_to_user_table --table=user

sail artisan migrate

sail artisan make:model Event -m

sail artisan migrate

sail artisan make:migration add_created_by_to_events_table --table=events

sail artisan migrate

sail artisan make:model EventParticipation -m

sail artisan migrate

sail artisan make:model Ticket -m

sail artisan migrate

sail artisan make:migration add_ticket_id_to_event_participations_table

sail artisan migrate

sail artisan make:model Transaction -m

sail artisan migrate

sail artisan make:model EventImage -m

sail artisan migrate

sail artisan install:api

Route::apiResource('posts', PostController::Class);

All the routes list will be created for posts

api/posts GET
api/posts POST
API/posts/{post} GET
API/posts/{post} PUT AND PATCH
API/posts/{post} DELETE

sail artisan make:controller Api/AuthController

sail artisan make:request Api/RegisterRequest

sail artisan make:request Api/LoginRequest

sail artisan make:controller Api/EventController --api

sail artisan make:request Api/EventRequest

for executing mysql bash
./vendor/bin/sail exec mysql bash

mysql -u sail -p
