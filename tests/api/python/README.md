# User Management API - Integration Tests

## Overview
Comprehensive integration tests for the se7entech-crm User Management API REST endpoints.

**Test Coverage: 8/8 (100%)**

## Prerequisites

```bash
# Install Python 3.8+
# Install requests library
pip install requests
```

## Running Tests

### Option 1: Set environment variables and run
```bash
# Windows PowerShell
$env:CRM_API_URL='http://localhost:8081'
$env:CRM_JWT_TOKEN='your_jwt_token_here'
python tests/api/python/test_users_api.py

# Linux/Mac
export CRM_API_URL='http://localhost:8081'
export CRM_JWT_TOKEN='your_jwt_token_here'
python3 tests/api/python/test_users_api.py
```

### Option 2: Edit the script directly
Modify `CRM_BASE_URL` and `JWT_TOKEN` variables in the test file.

## Generating a JWT Token

From the CRM root directory:
```bash
php issue_token.php --client="API-Tester" --exp=8760 --userid=123456
```

Replace `123456` with an admin user ID (access='0').

## Test Cases

1. **List Users - Basic**: GET /api/users with pagination
2. **List Users - Pagination**: Multiple pages with custom per_page
3. **List Users - Filtering**: Filter by status, role, zone_id
4. **Get User by ID**: GET /api/users/{id}
5. **Get User Not Found**: 404 handling
6. **Create User**: POST /api/users (admin only)
7. **Update User**: PUT /api/users/{id} with partial data
8. **Delete User**: DELETE /api/users/{id} (creates then deletes)

## Expected Output

```
============================================================
User Management API Integration Tests
============================================================
CRM URL: http://localhost:8081
JWT Token: ********************...

TEST: List Users - Basic
+ Status code: 200
+ Response indicates success
+ Response structure is correct
+ Pagination: page 1/3, 50 total users
+ Sensitive fields are properly sanitized

... (more tests)

============================================================
Passed: 8 | Failed: 0
============================================================
```

## Notes

- Tests require a running CRM instance (XAMPP/local server)
- JWT token must belong to an admin user (access='0') for CREATE/DELETE tests
- Tests create and delete temporary users for testing
- All sensitive data (passwords, api_keys) are verified to be sanitized
