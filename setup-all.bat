@echo off
echo ==========================================
echo Devycore V2 - Complete Setup
echo ==========================================
echo.

echo [1/4] Checking PHP and Composer...
where php >nul 2>nul
if %ERRORLEVEL% NEQ 0 (
    echo [ERROR] PHP not found in PATH!
    echo Please add PHP to your system PATH or run from XAMPP shell.
    pause
    exit /b 1
)

echo [OK] PHP found:
php -v | findstr "PHP"

echo.
echo [2/4] Installing Composer dependencies...
composer install --no-dev --optimize-autoloader
if %ERRORLEVEL% NEQ 0 (
    echo [ERROR] Composer install failed!
    pause
    exit /b 1
)
echo [OK] Dependencies installed

echo.
echo [3/4] Setting up database...
echo.
echo Creating database 'devycore_v2'...

mysql -u root -e "CREATE DATABASE IF NOT EXISTS devycore_v2 CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;" 2>nul

if %ERRORLEVEL% EQU 0 (
    echo [OK] Database created
    echo.
    echo Importing schema...
    mysql -u root devycore_v2 < database\schema.sql 2>nul

    if %ERRORLEVEL% EQU 0 (
        echo [OK] Schema imported
    ) else (
        echo [WARNING] Schema import failed - may already exist
    )
) else (
    echo [WARNING] Could not create database
    echo.
    echo Please create database manually:
    echo 1. Open http://localhost/phpmyadmin
    echo 2. Create database: devycore_v2
    echo 3. Import: database/schema.sql
    echo 4. Run: php create-test-data.php
    echo.
    pause
    exit /b 0
)

echo.
echo [4/4] Creating test data...
php create-test-data.php

echo.
echo ==========================================
echo Setup Complete!
echo ==========================================
echo.
echo Your site is ready at:
echo http://localhost/devycore-v2/public/
echo.
echo Login credentials:
echo   Username: admin
echo   Password: admin123
echo.
echo Next steps:
echo 1. Open the site in your browser
echo 2. Test the contact form
echo 3. Try the prize balloon game
echo 4. (Optional) Build admin panel UI
echo.
pause
