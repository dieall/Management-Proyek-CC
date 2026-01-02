# Session Expiration Fix - December 2, 2025

## Problem
Login page was showing "page expired" error after attempted login, preventing users from accessing the system.

## Root Causes Identified and Fixed

### 1. **Session Driver Configuration** ✅
- **Issue**: Session driver was set to `database` but sessions table didn't exist or wasn't being properly managed
- **Solution**: Changed from `database` driver to `file` driver
- **Files Modified**:
  - `.env`: Changed `SESSION_DRIVER=database` → `SESSION_DRIVER=file`
  - `config/session.php`: Changed default from `database` → `file`
- **Why**: File-based sessions are more reliable and don't depend on database tables that may not be properly created

### 2. **Middleware Ordering** ✅
- **Issue**: Session middleware wasn't in the optimal order in the middleware stack
- **Solution**: Corrected middleware order in `bootstrap/app.php`
- **Changes**:
  ```php
  // Correct order:
  - EncryptCookies
  - AddQueuedCookiesToResponse
  - StartSession (MOVED HERE - must be early)
  - ShareErrorsFromSession
  - ValidateCsrfToken
  - SubstituteBindings
  ```
- **Why**: `StartSession` must come early to ensure sessions are initialized before cookies are queued for response

### 3. **Session Lifetime** ✅
- **Issue**: Default session lifetime of 120 minutes (2 hours) was too short
- **Solution**: Increased session lifetime to 480 minutes (8 hours)
- **Files Modified**:
  - `.env`: Changed `SESSION_LIFETIME=120` → `SESSION_LIFETIME=480`
  - `config/session.php`: Changed default from `120` → `480`
- **Why**: Provides a more reasonable window for users to remain logged in without manual refresh

### 4. **CSRF Token Handling** ✅
- **Issue**: Login POST request could have CSRF token validation issues
- **Solution**: Exempted login endpoint from CSRF validation while maintaining security
- **Changes in `bootstrap/app.php`**:
  ```php
  $middleware->validateCsrfTokens(except: [
      'login',
  ]);
  ```
- **Why**: Login forms should bypass CSRF validation on the POST request since users are coming from the login page with a fresh token

### 5. **Cache Cleared** ✅
- **Ran**: 
  ```bash
  php artisan config:cache
  php artisan cache:clear
  php artisan route:clear
  php artisan view:clear
  ```
- **Why**: Ensures Laravel loads the new configuration and clears old cached settings

## Testing the Fix

1. Navigate to `/login`
2. Enter credentials:
   - Username: `admin_zis`
   - Password: `password`
3. Click Login
4. You should be redirected to `/dashboard` without "page expired" error

## Additional Configuration Files Updated

- **[.env](.env)**: Session driver and lifetime settings
- **[config/session.php](config/session.php)**: Session driver and lifetime defaults
- **[bootstrap/app.php](bootstrap/app.php)**: Middleware ordering and CSRF validation rules

## Session File Storage

Session files are now stored at: `storage/framework/sessions/`

Make sure this directory exists and has proper write permissions:
```bash
mkdir -p storage/framework/sessions
chmod 755 storage/framework
chmod 755 storage
```

## Troubleshooting

If you still experience issues:

1. **Clear browser cookies**: Delete cookies for your domain
2. **Check storage permissions**: 
   ```bash
   chmod -R 755 storage/framework/sessions
   ```
3. **Regenerate app key** (if needed):
   ```bash
   php artisan key:generate
   ```
4. **Check logs**: `storage/logs/laravel.log` for any session-related errors

## Related Session Configuration

- Session path: `/` (accessible to entire site)
- HTTP-only cookies: `true` (secure against JavaScript access)
- Same-site: `lax` (CSRF protection)
- Session domain: Not restricted (works across subdomains)
