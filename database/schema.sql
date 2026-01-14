-- ============================================
-- Devycore V2 Database Schema
-- MySQL 8.0+ Required
-- ============================================

-- Drop existing tables (for clean install)
DROP TABLE IF EXISTS social_networks;
DROP TABLE IF EXISTS contact_info;
DROP TABLE IF EXISTS rate_limits;
DROP TABLE IF EXISTS discount_submissions;
DROP TABLE IF EXISTS contact_submissions;
DROP TABLE IF EXISTS projects;
DROP TABLE IF EXISTS auth_tokens;
DROP TABLE IF EXISTS users;

-- ============================================
-- 1. Users Table
-- ============================================
CREATE TABLE users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) UNIQUE NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('super', 'admin') DEFAULT 'admin',
  is_active BOOLEAN DEFAULT TRUE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_username (username),
  INDEX idx_role (role),
  INDEX idx_active (is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 2. Auth Tokens Table
-- ============================================
CREATE TABLE auth_tokens (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL,
  token CHAR(64) UNIQUE NOT NULL,
  expires_at DATETIME NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  INDEX idx_token (token),
  INDEX idx_expires (expires_at),
  INDEX idx_user_id (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 3. Projects Table
-- ============================================
CREATE TABLE projects (
  id BIGINT UNSIGNED PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  url VARCHAR(2048) NOT NULL,
  description TEXT,
  image_path VARCHAR(1024),
  technologies JSON,
  featured BOOLEAN DEFAULT FALSE,
  display_order INT DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_created (created_at DESC),
  INDEX idx_featured (featured),
  INDEX idx_order (display_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 4. Contact Submissions Table
-- ============================================
CREATE TABLE contact_submissions (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  phone VARCHAR(60),
  company VARCHAR(255),
  message TEXT NOT NULL,
  project_type VARCHAR(100),
  company_type VARCHAR(100),
  prize VARCHAR(20),
  ip_address VARCHAR(45),
  user_agent TEXT,
  submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  email_sent BOOLEAN DEFAULT FALSE,
  INDEX idx_email (email),
  INDEX idx_submitted (submitted_at DESC),
  INDEX idx_ip (ip_address),
  INDEX idx_email_sent (email_sent)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 5. Discount Submissions Table
-- ============================================
CREATE TABLE discount_submissions (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  prize VARCHAR(20) NOT NULL,
  percentage TINYINT UNSIGNED,
  source VARCHAR(255),
  project_type VARCHAR(100),
  company VARCHAR(255),
  notes TEXT,
  ip_address VARCHAR(45),
  submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  email_sent BOOLEAN DEFAULT FALSE,
  INDEX idx_email (email),
  INDEX idx_prize (prize),
  INDEX idx_submitted (submitted_at DESC),
  INDEX idx_ip (ip_address),
  INDEX idx_email_sent (email_sent)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 6. Rate Limits Table
-- ============================================
CREATE TABLE rate_limits (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  endpoint VARCHAR(100) NOT NULL,
  ip_address VARCHAR(45) NOT NULL,
  request_count SMALLINT UNSIGNED DEFAULT 1,
  window_start DATETIME NOT NULL,
  last_request TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY unique_endpoint_ip_window (endpoint, ip_address, window_start),
  INDEX idx_ip (ip_address),
  INDEX idx_endpoint (endpoint),
  INDEX idx_window_start (window_start)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 7. Contact Info Table
-- ============================================
CREATE TABLE contact_info (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  info_key VARCHAR(50) UNIQUE NOT NULL,
  info_value TEXT NOT NULL,
  is_active BOOLEAN DEFAULT TRUE,
  display_order INT DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_key (info_key),
  INDEX idx_active (is_active),
  INDEX idx_order (display_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 8. Social Networks Table
-- ============================================
CREATE TABLE social_networks (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  platform VARCHAR(50) NOT NULL,
  url VARCHAR(500) NOT NULL,
  icon_name VARCHAR(100),
  display_order INT DEFAULT 0,
  is_active BOOLEAN DEFAULT TRUE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_platform (platform),
  INDEX idx_active (is_active),
  INDEX idx_order (display_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Initial Data (Optional)
-- ============================================

-- Create default admin user
-- Password: admin123 (CHANGE THIS IMMEDIATELY!)
-- Hash generated with: password_hash('admin123', PASSWORD_BCRYPT, ['cost' => 12])
INSERT INTO users (username, password_hash, role, is_active) VALUES
('admin', '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMesJVa8HnhX4XGS4lqVq0D5zm', 'super', TRUE);

-- Sample project (optional)
INSERT INTO projects (id, title, url, description, image_path, technologies, featured, display_order) VALUES
(UNIX_TIMESTAMP() * 1000, 'Devycore Portfolio', 'https://devycore.com', 'High-performance portfolio website with brutalist design', NULL, '["PHP", "MySQL", "GSAP", "Three.js"]', TRUE, 1);

-- Default contact info
INSERT INTO contact_info (info_key, info_value, display_order) VALUES
('email', 'info@devycore.com', 1),
('phone', '+383 49 123 456', 2),
('address', 'Prishtina, Kosovo', 3),
('business_hours', 'Mon-Fri: 9:00 AM - 6:00 PM', 4);

-- Default social networks
INSERT INTO social_networks (platform, url, icon_name, display_order) VALUES
('LinkedIn', 'https://linkedin.com/company/devycore', 'work', 1),
('GitHub', 'https://github.com/devycore', 'code', 2),
('Twitter', 'https://twitter.com/devycore', 'tag', 3),
('Instagram', 'https://instagram.com/devycore', 'camera_alt', 4),
('Facebook', 'https://facebook.com/devycore', 'groups', 5);

-- ============================================
-- Cleanup: Remove expired tokens (run periodically)
-- ============================================
DELIMITER //
CREATE EVENT IF NOT EXISTS cleanup_expired_tokens
ON SCHEDULE EVERY 1 HOUR
DO
BEGIN
  DELETE FROM auth_tokens WHERE expires_at < NOW();
  DELETE FROM rate_limits WHERE window_start < DATE_SUB(NOW(), INTERVAL 1 DAY);
END //
DELIMITER ;

-- Enable event scheduler
SET GLOBAL event_scheduler = ON;

-- ============================================
-- Verification Queries
-- ============================================
-- SELECT * FROM users;
-- SELECT * FROM auth_tokens;
-- SELECT * FROM projects ORDER BY display_order;
-- SELECT COUNT(*) FROM contact_submissions WHERE submitted_at > DATE_SUB(NOW(), INTERVAL 24 HOUR);
-- SELECT COUNT(*) FROM discount_submissions WHERE submitted_at > DATE_SUB(NOW(), INTERVAL 24 HOUR);
