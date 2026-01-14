@echo off
echo ==========================================
echo Devycore V2 - Database Setup
echo ==========================================
echo.

REM Check if MySQL is accessible
where mysql >nul 2>nul
if %ERRORLEVEL% NEQ 0 (
    echo [ERROR] MySQL command not found!
    echo.
    echo Please add MySQL to PATH or use phpMyAdmin:
    echo 1. Open http://localhost/phpmyadmin
    echo 2. Create database: devycore_v2
    echo 3. Import: database/schema.sql
    echo.
    pause
    exit /b 1
)

echo [1/3] Creating database...
mysql -u root -e "CREATE DATABASE IF NOT EXISTS devycore_v2 CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;"

if %ERRORLEVEL% EQU 0 (
    echo [OK] Database created: devycore_v2
) else (
    echo [FAILED] Could not create database
    echo Please check if MySQL is running in XAMPP
    pause
    exit /b 1
)

echo.
echo [2/3] Importing schema...
mysql -u root devycore_v2 < database\schema.sql

if %ERRORLEVEL% EQU 0 (
    echo [OK] Schema imported successfully
) else (
    echo [FAILED] Could not import schema
    pause
    exit /b 1
)

echo.
echo [3/3] Verifying setup...
php verify-setup.php

echo.
echo ==========================================
echo Database Setup Complete!
echo ==========================================
echo.
echo Next step: Open http://localhost/devycore-v2/public/
echo.
pause
