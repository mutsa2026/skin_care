# Vercel Deployment Guide

## Setup Steps

### 1. Add Environment Variables to Vercel
In your Vercel project settings (Project → Settings → Environment Variables), add:

- `DB_PASSWORD`: Your Railway MySQL password
- `APP_KEY`: `base64:anhcOk+j2oz/nw76NGwza85k6Dky8PscB1dhsyBYbRk=` (from `.env`)
- `APP_URL`: Your Vercel domain (e.g., `https://skincare-recipes.vercel.app`)
- `CORS_ALLOWED_ORIGINS`: Same as APP_URL

### 2. Connect Your Repository
1. Go to [vercel.com](https://vercel.com)
2. Click "Add New" → "Project"
3. Import your GitHub repository (mutsa2026/skin_care)
4. Framework: **Other** (since Laravel needs custom config)
5. Root Directory: Leave blank (default)
6. Build Command: `npm run build` (already set in vercel.json)
7. Output Directory: `public` (optional, Vercel handles this)

### 3. Deploy
Click "Deploy" — Vercel will:
- Install dependencies (composer & npm)
- Run `npm run build` (Vite builds assets)
- Deploy Laravel API via `api/index.php`

### 4. After Deployment
- Your app runs at `https://your-project.vercel.app`
- All requests route through `api/index.php` → Laravel
- Static assets served from `/public`
- Database connects to Railway MySQL via `DB_HOST=interchange.proxy.rlwy.net`

## Files Modified/Created

- **`.env.production`** - Production environment variables with Railway credentials placeholders
- **`vercel.json`** - Updated with buildCommand and improved routing
- **`api/index.php`** - Already configured (no changes needed)

## Important Notes

- Vercel serverless functions have 10-60 second timeouts; long operations may fail
- File uploads use `/tmp` (ephemeral storage); use S3 or similar for persistence
- Database migrations: Run locally or via SSH to your server before deploying
- Sessions use the database driver (configured in `.env.production`)

## Troubleshooting

If deployment fails:
1. Check Vercel build logs for errors
2. Verify `DB_PASSWORD` environment variable is set correctly
3. Ensure `APP_KEY` is valid (base64 format)
4. Test Railway connection locally: `php artisan tinker` → `DB::connection()->getPdo()`
