#!/bin/bash

log_message() {
    echo "[$(date +'%Y-%m-%d %H:%M:%S')] $1"
}

check_db_connection() {
    php -r "
    \$host='$DB_HOST';
    \$port=$DB_PORT;
    \$dbname='$DB_DATABASE';
    \$user='$DB_USERNAME';
    \$pass='$DB_PASSWORD';
    try {
        \$dbh = new PDO(\"mysql:host=\$host;port=\$port;dbname=\$dbname\", \$user, \$pass);
        echo 'Connected successfully';
    } catch (PDOException \$e) {
        echo 'Connection failed: ' . \$e->getMessage();
        exit(1);
    }"
}

max_attempts=5
counter=0

log_message "Attempting to connect to the database..."

until check_db_connection; do
    error_message=$(check_db_connection)
    log_message "Attempt $((counter + 1)) failed. Error: $error_message"
    sleep 1
    counter=$((counter + 1))
    if [ $counter -eq $max_attempts ]; then
        log_message "Failed to connect to database after $max_attempts attempts."
        log_message "Last error: $error_message"
        log_message "Database connection details:"
        log_message "DB_HOST: $DB_HOST"
        log_message "DB_PORT: $DB_PORT"
        log_message "DB_DATABASE: $DB_DATABASE"
        log_message "DB_USERNAME: $DB_USERNAME"

        # Test network connectivity
        if ping -c 1 $DB_HOST &> /dev/null; then
            log_message "Network connectivity to $DB_HOST is OK."
        else
            log_message "Cannot reach $DB_HOST. Possible network issue."
        fi

        exit 1
    fi
done

# Rest of your script...


log_message "Successfully connected to the database."

# Run migrations
log_message "Running migrations..."
php artisan migrate --force

# Clear and cache config
log_message "Clearing and caching config..."
php artisan config:clear
php artisan config:cache

# Cache routes
log_message "Caching routes..."
php artisan route:cache

# Compile assets if using Laravel Mix
# log_message "Compiling assets..."
# npm run production

# Start supervisor
log_message "Starting supervisor..."
exec "$@"
