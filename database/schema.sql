-- HouseAidPro Database Schema
-- Run this file in SQL Workbench to create the database and tables

CREATE DATABASE houseaidpro
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE houseaidpro;

-- ============================================================
-- Users table (tenants, homeowners, admins, contractors)
-- ============================================================
CREATE TABLE users (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    role            ENUM('tenant','homeowner','admin','contractor') NOT NULL DEFAULT 'tenant',
    title           VARCHAR(10) DEFAULT NULL,
    first_name      VARCHAR(100) NOT NULL,
    surname         VARCHAR(100) NOT NULL,
    email           VARCHAR(255) NOT NULL UNIQUE,
    phone           VARCHAR(30) DEFAULT NULL,
    alt_phone       VARCHAR(30) DEFAULT NULL,
    password_hash   VARCHAR(255) DEFAULT NULL,  -- NULL = guest user
    is_guest        TINYINT(1) NOT NULL DEFAULT 0,
    remember_token  VARCHAR(255) DEFAULT NULL,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_role (role)
) ENGINE=InnoDB;

-- ============================================================
-- Properties
-- ============================================================
CREATE TABLE properties (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    user_id     INT DEFAULT NULL,
    address_line1 VARCHAR(255) NOT NULL,
    address_line2 VARCHAR(255) DEFAULT NULL,
    town        VARCHAR(100) NOT NULL,
    county      VARCHAR(100) DEFAULT NULL,
    postcode    VARCHAR(15) NOT NULL,
    country     VARCHAR(50) NOT NULL DEFAULT 'United Kingdom',
    created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_postcode (postcode)
) ENGINE=InnoDB;

-- ============================================================
-- Issue categories
-- ============================================================
CREATE TABLE issue_categories (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(100) NOT NULL UNIQUE,
    slug        VARCHAR(100) NOT NULL UNIQUE,
    icon        VARCHAR(50) DEFAULT NULL,
    description TEXT DEFAULT NULL,
    sort_order  INT NOT NULL DEFAULT 0
) ENGINE=InnoDB;

-- Seed default categories
INSERT INTO issue_categories (name, slug, icon, sort_order) VALUES
('Plumbing',       'plumbing',       'plumbing',       1),
('Electrical',     'electrical',     'electrical',     2),
('Appliances',     'appliances',     'appliances',     3),
('Heating',        'heating',        'heating',        4),
('Leaks',          'leaks',          'leaks',          5),
('Fencing & Gates','fencing',        'fencing',        6),
('Doors & Windows','doors-windows',  'doors',          7),
('Roofing',        'roofing',        'roofing',        8),
('Damp & Mould',   'damp-mould',    'damp',           9),
('Pest Control',   'pest-control',   'pest',          10),
('Locks & Security','locks-security','locks',         11),
('Other',          'other',          'other',         12);

-- ============================================================
-- Issues (main reports)
-- ============================================================
CREATE TABLE issues (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    reference_code  VARCHAR(20) NOT NULL UNIQUE,
    user_id         INT DEFAULT NULL,
    property_id     INT DEFAULT NULL,
    category_id     INT NOT NULL,
    area_type       ENUM('private','communal') NOT NULL DEFAULT 'private',
    title           VARCHAR(255) NOT NULL,
    description     TEXT NOT NULL,
    priority        ENUM('low','medium','high','emergency') NOT NULL DEFAULT 'medium',
    status          ENUM('new','acknowledged','scheduled','in_progress','completed','closed') NOT NULL DEFAULT 'new',

    -- Appliance-specific fields
    appliance_make    VARCHAR(100) DEFAULT NULL,
    appliance_model   VARCHAR(100) DEFAULT NULL,
    appliance_serial  VARCHAR(100) DEFAULT NULL,
    flights_of_stairs INT DEFAULT NULL,

    -- Leak-specific fields
    leak_container_size   VARCHAR(50) DEFAULT NULL,
    leak_emptying_freq    VARCHAR(100) DEFAULT NULL,
    leak_is_constant      TINYINT(1) DEFAULT NULL,

    -- Access / notes
    notes                 TEXT DEFAULT NULL,
    parking_restrictions  TINYINT(1) DEFAULT 0,
    has_pets              TINYINT(1) DEFAULT 0,
    has_alarm             TINYINT(1) DEFAULT 0,
    vulnerable_occupier   TINYINT(1) DEFAULT 0,
    access_without_presence TINYINT(1) DEFAULT 0,
    accepted_terms        TINYINT(1) NOT NULL DEFAULT 0,
    remember_details      TINYINT(1) DEFAULT 0,

    preferred_date  DATE DEFAULT NULL,
    preferred_time  VARCHAR(50) DEFAULT NULL,

    submitted_at    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id)     REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (property_id) REFERENCES properties(id) ON DELETE SET NULL,
    FOREIGN KEY (category_id) REFERENCES issue_categories(id),
    INDEX idx_status (status),
    INDEX idx_reference (reference_code),
    INDEX idx_submitted (submitted_at)
) ENGINE=InnoDB;

-- ============================================================
-- Issue media (photos, videos, audio)
-- ============================================================
CREATE TABLE issue_media (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    issue_id    INT NOT NULL,
    file_name   VARCHAR(255) NOT NULL,
    original_name VARCHAR(255) NOT NULL,
    file_path   VARCHAR(500) NOT NULL,
    file_type   VARCHAR(50) NOT NULL,
    file_size   INT NOT NULL,  -- bytes
    uploaded_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (issue_id) REFERENCES issues(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ============================================================
-- Contractors
-- ============================================================
CREATE TABLE contractors (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    user_id         INT NOT NULL UNIQUE,
    company_name    VARCHAR(200) DEFAULT NULL,
    specialisation  VARCHAR(255) DEFAULT NULL,
    phone           VARCHAR(30) DEFAULT NULL,
    is_available    TINYINT(1) NOT NULL DEFAULT 1,
    rating_avg      DECIMAL(3,2) DEFAULT 0.00,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ============================================================
-- Contractor assignments
-- ============================================================
CREATE TABLE contractor_assignments (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    issue_id        INT NOT NULL,
    contractor_id   INT NOT NULL,
    status          ENUM('assigned','accepted','declined','in_progress','completed') NOT NULL DEFAULT 'assigned',
    assigned_at     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    accepted_at     DATETIME DEFAULT NULL,
    completed_at    DATETIME DEFAULT NULL,
    notes           TEXT DEFAULT NULL,
    FOREIGN KEY (issue_id)      REFERENCES issues(id) ON DELETE CASCADE,
    FOREIGN KEY (contractor_id) REFERENCES contractors(id) ON DELETE CASCADE,
    INDEX idx_contractor (contractor_id),
    INDEX idx_issue (issue_id)
) ENGINE=InnoDB;

-- ============================================================
-- Appointments
-- ============================================================
CREATE TABLE appointments (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    issue_id        INT NOT NULL,
    contractor_id   INT DEFAULT NULL,
    scheduled_date  DATE NOT NULL,
    scheduled_time  VARCHAR(50) DEFAULT NULL,
    duration_mins   INT DEFAULT 60,
    status          ENUM('scheduled','confirmed','completed','cancelled') NOT NULL DEFAULT 'scheduled',
    notes           TEXT DEFAULT NULL,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (issue_id)      REFERENCES issues(id) ON DELETE CASCADE,
    FOREIGN KEY (contractor_id) REFERENCES contractors(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ============================================================
-- Comments / messages
-- ============================================================
CREATE TABLE comments (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    issue_id    INT NOT NULL,
    user_id     INT DEFAULT NULL,
    message     TEXT NOT NULL,
    is_internal TINYINT(1) NOT NULL DEFAULT 0,
    created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (issue_id) REFERENCES issues(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id)  REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ============================================================
-- Notifications
-- ============================================================
CREATE TABLE notifications (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    user_id     INT DEFAULT NULL,
    issue_id    INT DEFAULT NULL,
    type        ENUM('email','sms','in_app') NOT NULL DEFAULT 'in_app',
    subject     VARCHAR(255) DEFAULT NULL,
    message     TEXT NOT NULL,
    is_read     TINYINT(1) NOT NULL DEFAULT 0,
    sent_at     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id)  REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (issue_id) REFERENCES issues(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ============================================================
-- Ratings
-- ============================================================
CREATE TABLE ratings (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    issue_id        INT NOT NULL,
    user_id         INT NOT NULL,
    contractor_id   INT NOT NULL,
    score           TINYINT NOT NULL CHECK (score BETWEEN 1 AND 5),
    review          TEXT DEFAULT NULL,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (issue_id)      REFERENCES issues(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id)       REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (contractor_id) REFERENCES contractors(id) ON DELETE CASCADE,
    UNIQUE KEY unique_rating (issue_id, user_id)
) ENGINE=InnoDB;

-- ============================================================
-- Insert a default admin user (password: admin123)
-- ============================================================
INSERT INTO users (role, first_name, surname, email, password_hash) VALUES
('admin', 'Admin', 'User', 'admin@houseaidpro.com',
 '$2y$10$MCkmvl5gyQKdopERtxg4neOk5xutvlCxvA6WtdcCh6MujOJqBTSb.');
