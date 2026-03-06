# HouseAidPro

A PHP/MySQL maintenance-reporting web app.

## Project Structure

- `api/` - backend endpoints (`auth`, `issues`, uploads, notifications)
- `includes/` - shared PHP code (config, DB, auth, helpers)
- `pages/` - page templates/views
- `js/` - frontend scripts
- `css/` - stylesheets
- `database/` - SQL schema/seed data
- `uploads/` - runtime uploaded media (ignored in Git, except `README.md`)
- `logs/` - runtime logs (ignored in Git, except `README.md`)

## Version Control

This project is now initialized as a Git repository.

- Default branch: `main`
- Runtime artifacts are ignored via `.gitignore`
- Line endings are normalized via `.gitattributes`

## Quick Start

1. Create/import DB using `database/schema.sql`.
2. Confirm DB settings in `includes/config.php`.
3. Serve project at `http://localhost/maintenance` (Laragon/WAMP/Apache).

## Recommended Workflow

- Create feature branches: `git checkout -b feature/<name>`
- Commit small, focused changes
- Keep secrets/environment-specific settings out of committed files
