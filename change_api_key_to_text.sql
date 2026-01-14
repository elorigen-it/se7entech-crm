-- Migration: Change api_key field to TEXT for JWT Token storage
-- Date: 2026-01-14
-- Description: The api_key field needs to be TEXT instead of VARCHAR
--              to support full JWT tokens (which can be 500+ characters)

-- IMPORTANT: Run this on your production database before deploying the new code

ALTER TABLE `invoice_user` 
MODIFY COLUMN `api_key` TEXT NULL DEFAULT NULL 
COMMENT 'JWT Token for API authentication (changed from VARCHAR to TEXT for full JWT storage)';

-- Verify the change
-- SHOW COLUMNS FROM `invoice_user` WHERE Field = 'api_key';
