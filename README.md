<h3>poster-cms</h3>
<p>Webentwicklung I (Sommersemester 2025) - FH Münster</p>

---

## Overview

- [Team Members](#team-members)
- [Repository Structure](#repository-structure)
- [Configuration](#configuration)
- [Database Setup](#database-setup)
- [Local Development](#local-development)

---

## Members

- Lars Kemper
- Tom Steinbach

## Repository Structure

The repository is organized into the following top-level directories and files:

```
├── src/
│   ├── api/            # PHP API (data fetching & processing)
│   ├── components/     # Reusable frontend components
│   ├── controllers/    # Request controllers
│   ├── lib/            # Configuration & library code
│   ├── pages/          # Frontend pages
│   ├── shared/         # Shared code (frontend & backend)
│   ├── static/         # Static assets (images, fonts, SQL scripts)
│   │   └── sql/        # Database schema & seed data
│   ├── styles/         # Stylesheets
│   └── index.php       # Application entry point
├── docker-compose.yml  # Docker setup (PostgreSQL & Adminer)
├── package.json        # Node dependencies & scripts
└── README.md           # This document
```

## Configuration

All environment-specific settings are defined in **`src/lib/config.php`**. This file includes:

- Database connection parameters (host, port, username, password, database name)
- Application environment settings

> **Tip:** Use environment variables or a `.env` file (loaded via PHP dotenv) to keep sensitive information out of
> version control.

## Database

This project uses PostgreSQL as its database. Schema definitions and seed data are stored under **`src/static/sql/`**.

1. Ensure Docker is installed.
2. Start the database service:

   ```bash
   docker compose up -d
   ```

3. Connect via Adminer at `http://localhost:8080` (configured in `docker-compose.yml`).
4. Import the SQL schema and seed files from `src/static/sql/`.

## Local Development

Follow these steps to run the project locally using PhpStorm:

1. **Clone the repository**:

   ```bash
   git clone https://github.com/fh-dualies/ss25-www1.git
   cd ss25-www1
   ```

2. **Install dependencies** (optional for development):

   ```bash
   npm install
   ```

3. **Start Docker services**:

   ```bash
   docker compose up -d
   ```

4. **Configure PhpStorm**:

   - Open the project directory.
   - Set up a PHP server configuration pointing to `src/index.php`.
   - Ensure Xdebug is configured for debugging.

5. **Run the application**:

   - In PhpStorm, start the PHP built-in server or your preferred local server.
   - Navigate to `http://localhost:<your-port>/` in your browser.
