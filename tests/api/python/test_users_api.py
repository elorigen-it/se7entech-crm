#!/usr/bin/env python3
"""
Integration tests for se7entech-crm User Management API endpoints.

These tests verify all 5 REST API endpoints:
- GET /api/users (list with pagination)
- GET /api/users/{id} (get by ID)
- POST /api/users (create)
- PUT /api/users/{id} (update)
- DELETE /api/users/{id} (delete)
"""

import os
import sys
import requests
import json
from typing import Dict, Any

# Configuration
CRM_BASE_URL = os.getenv('CRM_API_URL', 'http://localhost')
JWT_TOKEN = os.getenv('CRM_JWT_TOKEN', '')

# Test helpers
class Colors:
    GREEN = '\033[92m'
    RED = '\033[91m'
    YELLOW = '\033[93m'
    BLUE = '\033[94m'
    END = '\033[0m'

def log_test(name: str):
    print(f"\n{Colors.BLUE}TEST: {name}{Colors.END}")

def log_success(message: str):
    print(f"{Colors.GREEN}+ {message}{Colors.END}")

def log_error(message: str):
    print(f"{Colors.RED}X {message}{Colors.END}")

def log_warning(message: str):
   print(f"{Colors.YELLOW}! {message}{Colors.END}")

def make_request(method: str, endpoint: str, data: Dict = None, headers: Dict = None) -> requests.Response:
    """Make HTTP request to CRM API"""
    url = f"{CRM_BASE_URL}/modules/users/index.php{endpoint}"
    
    default_headers = {
        'Authorization': f'Bearer {JWT_TOKEN}',
        'Content-Type': 'application/json'
    }
    
    if headers:
        default_headers.update(headers)
    
    try:
        if method == 'GET':
            response = requests.get(url, headers=default_headers, timeout=10)
        elif method == 'POST':
            response = requests.post(url, json=data, headers=default_headers, timeout=10)
        elif method == 'PUT':
            response = requests.put(url, json=data, headers=default_headers, timeout=10)
        elif method == 'DELETE':
            response = requests.delete(url, headers=default_headers, timeout=10)
        else:
            raise ValueError(f"Unsupported method: {method}")
        
        return response
    except requests.exceptions.RequestException as e:
        log_error(f"Request failed: {e}")
        sys.exit(1)

# Test Suite
def test_list_users_basic():
    """Test GET /api/users - Basic listing"""
    log_test("List Users - Basic")
    
    response = make_request('GET', '/api/users')
    
    assert response.status_code == 200, f"Expected 200, got {response.status_code}"
    log_success(f"Status code: {response.status_code}")
    
    data = response.json()
    assert data['success'] is True, "Response should indicate success"
    log_success("Response indicates success")
    
    assert 'data' in data, "Response should contain 'data' key"
    assert 'pagination' in data, "Response should contain 'pagination' key"
    log_success("Response structure is correct")
    
    # Check pagination metadata
    pagination = data['pagination']
    assert 'current_page' in pagination
    assert 'per_page' in pagination
    assert 'total' in pagination
    assert 'total_pages' in pagination
    log_success(f"Pagination: page {pagination['current_page']}/{pagination['total_pages']}, {pagination['total']} total users")
    
    # Check data sanitization
    if len(data['data']) > 0:
        first_user = data['data'][0]
        assert 'password' not in first_user, "Password should be sanitized"
        assert 'smtp_pass' not in first_user, "SMTP password should be sanitized"
        assert 'api_key' not in first_user, "API key should be sanitized"
        log_success("Sensitive fields are properly sanitized")

def test_list_users_pagination():
    """Test GET /api/users - Pagination"""
    log_test("List Users - Pagination")
    
    # Test page 1
    response = make_request('GET', '/api/users?page=1&per_page=5')
    assert response.status_code == 200
    data = response.json()
    assert data['pagination']['current_page'] == 1
    assert data['pagination']['per_page'] == 5
    assert len(data['data']) <= 5
    log_success(f"Page 1: {len(data['data'])} users returned")
    
    # Test page 2 if available
    if data['pagination']['total_pages'] > 1:
        response = make_request('GET', '/api/users?page=2&per_page=5')
        data2 = response.json()
        assert data2['pagination']['current_page'] == 2
        log_success("Page 2 works correctly")

def test_list_users_filters():
    """Test GET /api/users - Filtering"""
    log_test("List Users - Filtering")
    
    # Test filter by status
    response = make_request('GET', '/api/users?status=1&per_page=10')
    assert response.status_code == 200
    data = response.json()
    log_success(f"Filter by status=1: {len(data['data'])} users")

def test_get_user_by_id():
    """Test GET /api/users/{id}"""
    log_test("Get User by ID")
    
    # First get a list to find a valid user ID
    list_response = make_request('GET', '/api/users?per_page=1')
    users = list_response.json()['data']
    
    if len(users) == 0:
        log_warning("No users found to test")
        return
    
    user_id = users[0]['id']
    
    # Get specific user
    response = make_request('GET', f'/api/users/{user_id}')
    assert response.status_code == 200
    log_success(f"Status code: {response.status_code}")
    
    data = response.json()
    assert data['success'] is True
    assert 'data' in data
    log_success("Response structure is correct")
    
    user = data['data']
    assert user['id'] == user_id
    assert 'first_name' in user
    assert 'email' in user
    log_success(f"User data: {user['first_name']} ({user['email']})")
    
    # Check sanitization
    assert 'password' not in user
    assert 'smtp_pass' not in user
    assert 'api_key' not in user
    log_success("Sensitive fields are sanitized")

def test_get_user_not_found():
    """Test GET /api/users/{id} - Non-existent user"""
    log_test("Get User by ID - Not Found")
    
    response = make_request('GET', '/api/users/999999')
    assert response.status_code == 404
    log_success(f"Correctly returns 404 for non-existent user")

def test_create_user():
    """Test POST /api/users - Create user"""
    log_test("Create User (Admin only)")
    
    new_user = {
        "firstname": "API",
        "lastname": "Test User",
        "email": f"test.user.{os.urandom(4).hex()}@example.com",
        "phone": "5551234567",
        "address": "123 Test St",
        "designation": "Tester",
        "role": "6",
        "zone_id": "1",
        "status": "1"
    }
    
    response = make_request('POST', '/api/users', data=new_user)
    
    # Admin check - might be 403 if not admin
    if response.status_code == 403:
        log_warning("User creation requires admin access (403 Forbidden)")
        return
    
    # Debug: Show raw response if not 200/201
    if response.status_code not in [200, 201]:
        log_error(f"Unexpected status code: {response.status_code}")
        log_error(f"Response: {response.text[:500]}")
        assert False, f"Expected 200 or 201, got {response.status_code}"
    
    log_success(f"Status code: {response.status_code}")
    
    # Try to parse JSON, show error if fails
    try:
        data = response.json()
    except Exception as e:
        log_error(f"Failed to parse JSON: {e}")
        log_error(f"Content-Type: {response.headers.get('content-type')}")
        log_error(f"Raw response: {response.text[:500]}")
        raise
    
    assert data['success'] is True
    assert 'data' in data
    assert 'temporary_password' in data
    log_success(f"User created with email: {data['data']['email']}")
    log_success(f"Temporary password: {data['temporary_password']}")
    
    return data['data']['id']

def test_update_user():
    """Test PUT /api/users/{id} - Update user"""
    log_test("Update User")
    
    # Get current user's ID from JWT
    list_response = make_request('GET', '/api/users?per_page=1')
    users = list_response.json()['data']
    
    if len(users) == 0:
        log_warning("No users found to test")
        return
    
    user_id = users[0]['id']
    
    update_data = {
        "firstname": "Updated",
        "lastname": "Name",
        "phone": "5559876543"
    }
    
    response = make_request('PUT', f'/api/users/{user_id}', data=update_data)
    
    # Might be 403 if trying to update another user without admin
    if response.status_code == 403:
        log_warning("Cannot update this user (permission denied)")
        return
    
    # Debug: show status code if not 200
    if response.status_code != 200:
        log_error(f"Unexpected status code: {response.status_code}")
        log_error(f"Response: {response.text[:500]}")
    
    assert response.status_code == 200, f"Expected 200, got {response.status_code}"
    log_success(f"Status code: {response.status_code}")
    
    data = response.json()
    assert data['success'] is True
    log_success(f"User updated successfully")

def test_delete_user():
    """Test DELETE /api/users/{id} - Delete user (Admin only)"""
    log_test("Delete User (Admin only)")
    
    # First, create a user to delete
    new_user = {
        "firstname": "ToDelete",
        "lastname": "TestUser",
        "email": f"delete.test.{os.urandom(4).hex()}@example.com",
        "phone": "5551234567",
        "address": "123 Test St",
        "designation": "Tester",
        "role": "6",
        "zone_id": "1",
        "status": "1"
    }
    
    create_response = make_request('POST', '/api/users', data=new_user)
    
    # If creation fails or user is not admin, skip delete test
    if create_response.status_code == 403:
        log_warning("Cannot test delete - not admin (403)")
        return
    
    if create_response.status_code not in [200, 201]:
        log_warning(f"Cannot test delete - user creation failed ({create_response.status_code})")
        return
    
    # Get the created user ID
    try:
        created_data = create_response.json()
        user_id = created_data['data']['id']
        log_success(f"Created test user with ID: {user_id}")
    except Exception as e:
        log_warning(f"Cannot test delete - failed to get user ID: {e}")
        return
    
    # Now delete the user
    delete_response = make_request('DELETE', f'/api/users/{user_id}')
    
    # Check status code
    if delete_response.status_code not in [200, 204]:
        log_error(f"Unexpected status code: {delete_response.status_code}")
        log_error(f"Response: {delete_response.text[:500]}")
    
    assert delete_response.status_code in [200, 204], f"Expected 200 or 204, got {delete_response.status_code}"
    log_success(f"Status code: {delete_response.status_code}")
    
    # Verify response
    try:
        delete_data = delete_response.json()
        assert delete_data['success'] is True
        log_success("User deleted successfully")
    except Exception as e:
        log_error(f"Failed to parse delete response: {e}")
        raise
    
    # Optional: Verify user no longer exists
    verify_response = make_request('GET', f'/api/users/{user_id}')
    if verify_response.status_code == 404:
        log_success("Verified: User no longer exists (404)")
    else:
        log_warning(f"User still exists after delete (status: {verify_response.status_code})")

def main():
    print(f"\n{'='*60}")
    print(f"{Colors.BLUE}User Management API Integration Tests{Colors.END}")
    print(f"{'='*60}")
    print(f"CRM URL: {CRM_BASE_URL}")
    print(f"JWT Token: {'*' * 20}...{JWT_TOKEN[-10:] if JWT_TOKEN else 'NOT SET'}")
    
    if not JWT_TOKEN:
        log_error("JWT_TOKEN environment variable is not set!")
        print("\nUsage:")
        print("  export CRM_API_URL='https://crm.se7entech.net'")
        print("  export CRM_JWT_TOKEN='your_jwt_token_here'")
        print("  python test_users_api.py")
        sys.exit(1)
    
    tests = [
        test_list_users_basic,
        test_list_users_pagination,
        test_list_users_filters,
        test_get_user_by_id,
        test_get_user_not_found,
        test_create_user,
        test_update_user,
        test_delete_user
    ]
    
    passed = 0
    failed = 0
    
    for test in tests:
        try:
            test()
            passed += 1
        except AssertionError as e:
            log_error(f"Test failed: {e}")
            import traceback
            traceback.print_exc()
            failed += 1
        except Exception as e:
            log_error(f"Test error: {e}")
            import traceback
            traceback.print_exc()
            failed += 1
    
    print(f"\n{'='*60}")
    print(f"{Colors.GREEN}Passed: {passed}{Colors.END} | {Colors.RED}Failed: {failed}{Colors.END}")
    print(f"{'='*60}\n")
    
    return 0 if failed == 0 else 1

if __name__ == '__main__':
    sys.exit(main())
