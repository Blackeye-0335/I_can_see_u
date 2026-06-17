# API Documentation

## Overview
The REST API provides programmatic access to I Can See U statistics and data.

## Base URL
```
http://127.0.0.1:8000/api.php
```

## Endpoints

### 1. Get Statistics
**Endpoint:** `GET /api.php?action=stats`

Returns overall statistics of captured credentials.

**Example:**
```bash
curl http://127.0.0.1:8000/api.php?action=stats
```

**Response:**
```json
{
  "success": true,
  "data": {
    "total_captures": 62,
    "platforms": {
      "GITHUB": 15,
      "GOOGLE": 20,
      "MICROSOFT": 27
    },
    "devices": {
      "Desktop": 50,
      "Mobile": 12
    },
    "ips": {
      "192.168.1.1": 5
    },
    "latest": {
      "timestamp": "2026-06-18 10:30:00",
      "platform": "GITHUB",
      "ip": "192.168.1.1",
      "device": "Desktop"
    }
  },
  "timestamp": "2026-06-18 12:00:00"
}
```

### 2. Get Captured Entries
**Endpoint:** `GET /api.php?action=entries&limit=50`

Returns recent captured credential entries.

**Parameters:**
- `limit` (optional): Number of entries to return (default: 50)

**Example:**
```bash
curl http://127.0.0.1:8000/api.php?action=entries&limit=10
```

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "timestamp": "2026-06-17 19:32:22",
      "platform": "GITHUB",
      "ip": "127.0.0.1",
      "device": "Desktop",
      "credential": "user@example.com",
      "password": "password123",
      "userAgent": "Mozilla/5.0..."
    }
  ],
  "count": 10
}
```

### 3. Health Check
**Endpoint:** `GET /api.php?action=health`

Checks if the API is online and returns version info.

**Example:**
```bash
curl http://127.0.0.1:8000/api.php?action=health
```

**Response:**
```json
{
  "success": true,
  "status": "online",
  "version": "2.0.0",
  "time": "2026-06-18 12:00:00"
}
```

## CORS Support
The API supports CORS for cross-origin requests. Headers are automatically included:
```
Access-Control-Allow-Origin: *
Access-Control-Allow-Methods: GET, POST, OPTIONS
```

## Error Handling
Invalid requests return appropriate HTTP status codes:

```json
{
  "success": false,
  "error": "Invalid action. Available actions: stats, entries, health"
}
```

## Usage Examples

### JavaScript
```javascript
// Get stats
fetch('http://127.0.0.1:8000/api.php?action=stats')
  .then(response => response.json())
  .then(data => console.log(data));

// Get recent entries
fetch('http://127.0.0.1:8000/api.php?action=entries&limit=20')
  .then(response => response.json())
  .then(data => console.log(data));
```

### Python
```python
import requests

# Get stats
response = requests.get('http://127.0.0.1:8000/api.php?action=stats')
data = response.json()
print(data)
```

## Rate Limiting
Currently no rate limiting is implemented. Use responsibly in production.

## Authentication
The API does not require authentication. For production use, add authentication tokens.

---

**Last Updated:** June 2025  
**Version:** 1.0.0
