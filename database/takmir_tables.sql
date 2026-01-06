-- Migration untuk Tabel Takmir/Pengurus Masjid
-- Jalankan file ini di MySQL database 'minpri'

-- Table: positions
CREATE TABLE IF NOT EXISTS positions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT NULL,
    parent_id BIGINT UNSIGNED NULL,
    `order` INT DEFAULT 0,
    status ENUM('active', 'inactive') DEFAULT 'active',
    level ENUM('leadership', 'member', 'staff') DEFAULT 'member',
    deleted_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (parent_id) REFERENCES positions(id) ON DELETE SET NULL,
    INDEX idx_parent_status (parent_id, status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: committees
CREATE TABLE IF NOT EXISTS committees (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NULL,
    phone_number VARCHAR(20) NULL,
    gender ENUM('male', 'female') NOT NULL,
    address TEXT NULL,
    birth_date DATE NULL,
    join_date DATE NULL,
    active_status ENUM('active', 'inactive', 'resigned') DEFAULT 'active',
    position_id BIGINT UNSIGNED NULL,
    user_id BIGINT UNSIGNED UNIQUE NULL,
    photo_path VARCHAR(500) NULL,
    cv_path VARCHAR(500) NULL,
    deleted_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (position_id) REFERENCES positions(id) ON DELETE SET NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_position (position_id),
    INDEX idx_active_status (active_status),
    INDEX idx_user (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: position_histories
CREATE TABLE IF NOT EXISTS position_histories (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    committee_id BIGINT UNSIGNED NOT NULL,
    position_id BIGINT UNSIGNED NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NULL,
    is_active BOOLEAN DEFAULT TRUE,
    appointment_type ENUM('election', 'appointment', 'volunteer') DEFAULT 'appointment',
    remarks TEXT NULL,
    deleted_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (committee_id) REFERENCES committees(id) ON DELETE CASCADE,
    FOREIGN KEY (position_id) REFERENCES positions(id) ON DELETE CASCADE,
    INDEX idx_is_active (is_active),
    INDEX idx_committee (committee_id),
    INDEX idx_position (position_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: job_responsibilities
CREATE TABLE IF NOT EXISTS job_responsibilities (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    position_id BIGINT UNSIGNED NOT NULL,
    task_name VARCHAR(255) NOT NULL,
    task_description TEXT NULL,
    priority ENUM('low', 'medium', 'high', 'critical') DEFAULT 'medium',
    estimated_hours INT NULL,
    frequency ENUM('daily', 'weekly', 'monthly', 'quarterly', 'yearly', 'on_demand') DEFAULT 'on_demand',
    is_core_responsibility BOOLEAN DEFAULT FALSE,
    deleted_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (position_id) REFERENCES positions(id) ON DELETE CASCADE,
    INDEX idx_position (position_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: duty_schedules
CREATE TABLE IF NOT EXISTS duty_schedules (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    committee_id BIGINT UNSIGNED NOT NULL,
    duty_date DATE NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    location VARCHAR(255) NOT NULL,
    duty_type ENUM('piket', 'kebersihan', 'keamanan', 'acara', 'lainnya') DEFAULT 'piket',
    status ENUM('scheduled', 'ongoing', 'completed', 'cancelled') DEFAULT 'scheduled',
    remarks TEXT NULL,
    is_recurring BOOLEAN DEFAULT FALSE,
    recurring_type ENUM('daily', 'weekly', 'monthly', 'yearly') NULL,
    recurring_end_date DATE NULL,
    deleted_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (committee_id) REFERENCES committees(id) ON DELETE CASCADE,
    INDEX idx_duty_date (duty_date),
    INDEX idx_committee (committee_id),
    INDEX idx_duty_type (duty_type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: task_assignments
CREATE TABLE IF NOT EXISTS task_assignments (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    committee_id BIGINT UNSIGNED NOT NULL,
    job_responsibility_id BIGINT UNSIGNED NOT NULL,
    assigned_date DATE NULL,
    due_date DATE NOT NULL,
    status ENUM('pending', 'in_progress', 'completed', 'cancelled', 'overdue') DEFAULT 'pending',
    progress_percentage INT DEFAULT 0,
    notes TEXT NULL,
    completed_date DATE NULL,
    approved_by BIGINT UNSIGNED NULL,
    approved_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (committee_id) REFERENCES committees(id) ON DELETE CASCADE,
    FOREIGN KEY (job_responsibility_id) REFERENCES job_responsibilities(id) ON DELETE CASCADE,
    FOREIGN KEY (approved_by) REFERENCES committees(id) ON DELETE SET NULL,
    INDEX idx_status (status),
    INDEX idx_due_date (due_date),
    INDEX idx_committee (committee_id),
    INDEX idx_job (job_responsibility_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: organizational_structures
CREATE TABLE IF NOT EXISTS organizational_structures (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    position_id BIGINT UNSIGNED NULL,
    parent_id BIGINT UNSIGNED NULL,
    lft INT NOT NULL,
    rgt INT NOT NULL,
    depth INT DEFAULT 0,
    `order` INT DEFAULT 0,
    is_division BOOLEAN DEFAULT FALSE,
    division_name VARCHAR(255) NULL,
    division_description TEXT NULL,
    deleted_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (position_id) REFERENCES positions(id) ON DELETE CASCADE,
    FOREIGN KEY (parent_id) REFERENCES organizational_structures(id) ON DELETE CASCADE,
    UNIQUE KEY unique_position (position_id),
    INDEX idx_parent (parent_id),
    INDEX idx_lft_rgt (lft, rgt)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: votings
CREATE TABLE IF NOT EXISTS votings (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    committee_id BIGINT UNSIGNED NOT NULL,
    position_id BIGINT UNSIGNED NOT NULL,
    start_date DATETIME NOT NULL,
    end_date DATETIME NOT NULL,
    status ENUM('open', 'closed', 'approved', 'rejected') DEFAULT 'open',
    description TEXT NULL,
    deleted_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (committee_id) REFERENCES committees(id) ON DELETE CASCADE,
    FOREIGN KEY (position_id) REFERENCES positions(id) ON DELETE CASCADE,
    INDEX idx_status (status),
    INDEX idx_committee (committee_id),
    INDEX idx_dates (start_date, end_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: votes
CREATE TABLE IF NOT EXISTS votes (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    voting_id BIGINT UNSIGNED NOT NULL,
    committee_id BIGINT UNSIGNED NOT NULL,
    vote ENUM('yes', 'no') NOT NULL,
    comment TEXT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (voting_id) REFERENCES votings(id) ON DELETE CASCADE,
    FOREIGN KEY (committee_id) REFERENCES committees(id) ON DELETE CASCADE,
    UNIQUE KEY unique_vote (voting_id, committee_id),
    INDEX idx_voting (voting_id),
    INDEX idx_committee (committee_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;







