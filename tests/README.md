# CRM API Tests

This directory contains integration tests for the se7entech-crm API.

## Structure

```
tests/
├── api/
│   └── python/
│       ├── test_users_api.py    # User Management API tests
│       └── README.md             # Python tests documentation
└── README.md                     # This file
```

## Running Tests

### Python Integration Tests

See [api/python/README.md](./api/python/README.md) for detailed instructions.

Quick start:
```bash
# Set environment variables
$env:CRM_API_URL='http://localhost:8081'
$env:CRM_JWT_TOKEN='your_jwt_token'

# Run tests
python tests/api/python/test_users_api.py
```

## Test Categories

- **Integration Tests** (`api/python/`): HTTP-based tests that verify API endpoints
- **Unit Tests** (future): PHP unit tests for models and controllers

## Requirements

- Python 3.8+ with `requests` library for integration tests
- Running CRM instance (local or staging server)
- Valid JWT token with appropriate permissions

## CI/CD Integration

These tests can be integrated into your CI/CD pipeline:

```yaml
# Example GitHub Actions
- name: Run API Tests
  env:
    CRM_API_URL: ${{ secrets.CRM_URL }}
    CRM_JWT_TOKEN: ${{ secrets.TEST_JWT }}
  run: python tests/api/python/test_users_api.py
```
