# Complete Step-by-Step Tutorial

Learn how to run and use every feature of the I Can See U project.

---

## 📋 TABLE OF CONTENTS

1. [Initial Setup](#initial-setup)
2. [Start the Server](#start-the-server)
3. [Access Home Page](#access-home-page)
4. [Test Fake Login Pages](#test-fake-login-pages)
5. [Use Admin Dashboard](#use-admin-dashboard)
6. [Use REST API](#use-rest-api)
7. [Generate Reports](#generate-reports)
8. [Check Logs](#check-logs)
9. [Export Data](#export-data)
10. [Troubleshooting](#troubleshooting)

---

## 🚀 INITIAL SETUP

### Step 1.1: Open Terminal
```bash
# Linux/Mac: Open terminal
# Windows: Open Command Prompt or PowerShell
```

### Step 1.2: Navigate to Project Folder
```bash
cd /home/blackeye/passwordcapture
```

### Step 1.3: Check Files Exist
```bash
ls -la
```

**You should see:**
```
admin.php
api.php
config.php
fake_github_login.php
fake_google_login.php
fake_linkedin_login.php
fake_microsoft_login.php
fake_twitter_login.php
home.php
index.php
utils.php
captured.log (if you've tested before)
README.md
API.md
QUICKSTART.md
SECURITY.md
CHANGELOG.md
```

---

## 🖥️ START THE SERVER

### Step 2.1: Start PHP Development Server
```bash
php -S 127.0.0.1:8000
```

**Expected Output:**
```
[Thu Jun 18 01:34:28 2026] PHP 8.4.22 Development Server (http://127.0.0.1:8000) started
```

### Step 2.2: Verify Server is Running
- **Terminal shows:** Server listening on `http://127.0.0.1:8000`
- **Don't close this terminal** - leave it running
- **To stop:** Press `CTRL + C` in the terminal

### Step 2.3: Open New Terminal Tab (Keep Server Running)
```bash
# Open a new terminal tab/window for other commands
# Keep the PHP server running in original terminal
```

---

## 🏠 ACCESS HOME PAGE

### Step 3.1: Open Web Browser
- Chrome, Firefox, Safari, or Edge

### Step 3.2: Visit Home Page
```
URL: http://127.0.0.1:8000/home.php
```

### Step 3.3: What You'll See
- **Title:** "I Can See U"
- **6 Platform Cards:** GitHub, Google, Microsoft, LinkedIn, Twitter/X, and more
- **Statistics Bar:** Shows total captures, platforms used, unique IPs
- **Admin Button:** Red button in top right

### Step 3.4: Understand the Layout
```
┌─────────────────────────────────────────┐
│  I Can See U      [Admin Panel] Button  │
├─────────────────────────────────────────┤
│                                         │
│  Total Captures: 62   Platforms: 5    │
│  Unique IPs: 10       Devices: 2      │
│                                         │
├─────────────────────────────────────────┤
│                                         │
│  [GitHub]  [Google]  [Microsoft]      │
│  [LinkedIn] [Twitter] [More...]       │
│                                         │
└─────────────────────────────────────────┘
```

---

## 🔐 TEST FAKE LOGIN PAGES

### Step 4.1: Click on GitHub Login
**From Home Page:**
1. Click the **GitHub card**
2. You'll be taken to: `http://127.0.0.1:8000/fake_github_login.php`

### Step 4.2: What You'll See on GitHub Page
- **GitHub logo** (dark theme)
- **Two input fields:**
  - "Username or email address"
  - "Password"
- **Sign in button**

### Step 4.3: Enter Test Credentials
```
Email/Username: test@example.com
Password: MyPassword123
```

### Step 4.4: Click Sign In
- Form submits instantly
- You get redirected to: `http://127.0.0.1:8000/index.php?github_success=1`
- Shows success message

### Step 4.5: Behind the Scenes (What Happens)
1. Your credentials are **captured** immediately
2. Written to `captured.log` file
3. Data includes:
   - Timestamp
   - Platform (GitHub)
   - Your IP address
   - Device type (Desktop/Mobile)
   - Username
   - Password
   - Browser info

### Step 4.6: Test Other Platforms
Repeat Steps 4.1-4.4 for:

**Google Login** (`/fake_google_login.php`):
```
Email: myemail@gmail.com
Password: SecurePass456
```

**Microsoft Login** (`/fake_microsoft_login.php`):
```
Email: user@hotmail.com
Password: WindowsPass789
```

**LinkedIn Login** (`/fake_linkedin_login.php`):
```
Email: john.doe@example.com
Password: LinkedInPass000
```

**Twitter/X Login** (`/fake_twitter_login.php`):
```
Username: @myusername
Password: TwitterPass111
```

---

## 📊 USE ADMIN DASHBOARD

### Step 5.1: Go to Admin Panel
**From Home Page:**
1. Click **[Admin Panel]** button (top right)
2. OR Visit directly: `http://127.0.0.1:8000/admin.php`

### Step 5.2: See Login Screen
```
┌────────────────────────────┐
│    Admin Panel Login       │
├────────────────────────────┤
│                            │
│  [Lock Icon]               │
│                            │
│  Password:  [________]     │
│                            │
│             [Login]        │
│                            │
└────────────────────────────┘
```

### Step 5.3: Enter Admin Password
```
Password: blackeye0335
```

### Step 5.4: Click Login
- You're now authenticated
- Dashboard appears

### Step 5.5: Dashboard Overview
You'll see **4 sections:**

#### Section 1: Statistics Cards (Top)
```
┌──────────────┬──────────────┐
│   CAPTURES   │  PLATFORMS   │
│      62      │      5       │
├──────────────┼──────────────┤
│  UNIQUE IPs  │   DEVICES    │
│      10      │      2       │
└──────────────┴──────────────┘
```

#### Section 2: Platform Breakdown Table
```
Platform     | Attempts | %
─────────────┼──────────┼──────
GitHub       |    15    | 24.2%
Google       |    18    | 29.0%
Microsoft    |    12    | 19.4%
LinkedIn     |    10    | 16.1%
Twitter/X    |     7    | 11.3%
```

#### Section 3: Device Breakdown Table
```
Device   | Attempts | %
─────────┼──────────┼──────
Desktop  |    50    | 80.6%
Mobile   |    12    | 19.4%
```

#### Section 4: Top IPs Table
```
IP Address    | Attempts | Last Seen
──────────────┼──────────┼─────────────────
127.0.0.1     |    15    | 2026-06-17 14:32
192.168.1.100 |    10    | 2026-06-17 13:45
```

### Step 5.6: Credentials Table (Main Content)
Scroll down to see all **captured credentials**:

```
Timestamp          | Platform | IP         | Device  | Email             | Password
───────────────────┼──────────┼────────────┼─────────┼───────────────────┼──────────────
2026-06-17 14:32   | GitHub   | 127.0.0.1  | Desktop | test@example.com  | MyPassword123
2026-06-17 14:15   | Google   | 127.0.0.1  | Desktop | myemail@gmail.com | SecurePass456
2026-06-17 14:05   | Microsoft| 127.0.0.1  | Desktop | user@hotmail.com  | WindowsPass789
...
```

### Step 5.7: Action Buttons (Bottom Right)
**3 action buttons:**

1. **Export CSV** (Green)
   - Downloads all data as CSV file
   - Use for reports/analysis

2. **Clear Logs** (Red)
   - Deletes all captured credentials
   - Use after testing

3. **Logout** (Blue)
   - Exits admin panel
   - Requires password to re-enter

### Step 5.8: Try the Actions

#### Export CSV
```
1. Click [Export CSV]
2. Browser downloads: "credentials.csv"
3. Open in Excel/Sheets to see all data
4. File format:
   timestamp,platform,ip,device,credential,password,user_agent
   2026-06-17 14:32,github,127.0.0.1,Desktop,test@example.com,MyPassword123,...
```

#### Clear Logs
```
1. Click [Clear Logs]
2. Confirm action
3. All credentials deleted
4. Statistics reset to 0
5. Dashboard now empty
```

#### Logout
```
1. Click [Logout]
2. Redirected to home page
3. Admin panel locked again
```

---

## 🌐 USE REST API

### Step 6.1: API Overview
The **REST API** provides JSON data without opening a browser interface.

**Base URL:** `http://127.0.0.1:8000/api.php`

### Step 6.2: Health Check Endpoint

**URL:**
```
http://127.0.0.1:8000/api.php?action=health
```

**What it does:** Checks if API is working

**Open in browser or terminal:**
```bash
curl http://127.0.0.1:8000/api.php?action=health
```

**Response:**
```json
{
  "success": true,
  "status": "online",
  "version": "2.0.0",
  "timestamp": "2026-06-17 19:49:39"
}
```

### Step 6.3: Statistics Endpoint

**URL:**
```
http://127.0.0.1:8000/api.php?action=stats
```

**What it does:** Returns all statistics as JSON

**Open in browser:**
```
http://127.0.0.1:8000/api.php?action=stats
```

**Response:**
```json
{
  "success": true,
  "data": {
    "total_captures": 62,
    "platforms": {
      "GITHUB": 15,
      "GOOGLE": 18,
      "MICROSOFT": 12,
      "LINKEDIN": 10,
      "TWITTER": 7
    },
    "devices": {
      "Desktop": 50,
      "Mobile": 12
    },
    "ips": {
      "127.0.0.1": 15,
      "192.168.1.100": 10
    },
    "latest": {
      "timestamp": "2026-06-17 19:32:22",
      "platform": "GITHUB",
      "ip": "127.0.0.1",
      "device": "Desktop",
      "credential": "test@example.com",
      "password": "MyPassword123",
      "userAgent": "Mozilla/5.0..."
    }
  },
  "timestamp": "2026-06-17 19:49:39"
}
```

### Step 6.4: Entries Endpoint

**URL:**
```
http://127.0.0.1:8000/api.php?action=entries&limit=10
```

**What it does:** Returns last N captured credentials

**Parameters:**
- `limit=10` (optional) - Return last 10 entries (default: 50)

**Examples:**

Last 5 entries:
```
http://127.0.0.1:8000/api.php?action=entries&limit=5
```

Last 20 entries:
```
http://127.0.0.1:8000/api.php?action=entries&limit=20
```

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "timestamp": "2026-06-17 14:32",
      "platform": "GITHUB",
      "ip": "127.0.0.1",
      "device": "Desktop",
      "credential": "test@example.com",
      "password": "MyPassword123",
      "userAgent": "Mozilla/5.0..."
    },
    {
      "timestamp": "2026-06-17 14:15",
      "platform": "GOOGLE",
      "ip": "127.0.0.1",
      "device": "Desktop",
      "credential": "myemail@gmail.com",
      "password": "SecurePass456",
      "userAgent": "Mozilla/5.0..."
    }
  ],
  "count": 2
}
```

### Step 6.5: Use API from Terminal

**With curl:**
```bash
# Health check
curl http://127.0.0.1:8000/api.php?action=health

# Get statistics
curl http://127.0.0.1:8000/api.php?action=stats

# Get last 10 entries
curl http://127.0.0.1:8000/api.php?action=entries&limit=10
```

**With Python:**
```python
import requests
import json

# Get statistics
response = requests.get('http://127.0.0.1:8000/api.php?action=stats')
data = response.json()
print(json.dumps(data, indent=2))
```

**With JavaScript/Node.js:**
```javascript
// Get statistics
fetch('http://127.0.0.1:8000/api.php?action=stats')
  .then(response => response.json())
  .then(data => console.log(data));
```

---

## 📄 GENERATE REPORTS

### Step 7.1: Open Report Page
**URL:**
```
http://127.0.0.1:8000/report.php
```

### Step 7.2: What You'll See
```
┌──────────────────────────────────────┐
│   Security Report - I Can See U      │
├──────────────────────────────────────┤
│                                      │
│  Generated: 2026-06-17 19:49:39     │
│  For Educational Purposes Only       │
│                                      │
├──────────────────────────────────────┤
│                                      │
│  STATISTICS                          │
│  ────────────────────────────────   │
│  Total Captures:     62              │
│  Unique Platforms:   5               │
│  Unique IPs:         10              │
│  Device Types:       2               │
│                                      │
├──────────────────────────────────────┤
│                                      │
│  PLATFORM DISTRIBUTION               │
│  ────────────────────────────────   │
│  GitHub       15 attempts  (24.2%)  │
│  Google       18 attempts  (29.0%)  │
│  Microsoft    12 attempts  (19.4%)  │
│  LinkedIn     10 attempts  (16.1%)  │
│  Twitter/X     7 attempts  (11.3%)  │
│                                      │
├──────────────────────────────────────┤
│                                      │
│  DEVICE DISTRIBUTION                 │
│  ────────────────────────────────   │
│  Desktop      50 attempts  (80.6%)  │
│  Mobile       12 attempts  (19.4%)  │
│                                      │
└──────────────────────────────────────┘
```

### Step 7.3: Print/Save as PDF
**Browser Menu:**
```
1. Press: CTRL + P (or CMD + P on Mac)
2. Choose: "Save as PDF"
3. Click: Save
4. File saved as: "report.pdf"
```

### Step 7.4: Use the Report
- **For documentation:** Keep PDF of statistics
- **For analysis:** See which platforms are attacked most
- **For education:** Show patterns to students
- **For reports:** Include in security assessments

---

## 📋 CHECK LOGS

### Step 8.1: View Raw Log File
**Via Terminal:**
```bash
cat captured.log
```

### Step 8.2: Log File Format
Each line contains:
```
[timestamp | platform | IP | device | credential | password | userAgent]
```

**Example:**
```
[2026-06-17 14:32:22 | GITHUB | 127.0.0.1 | Desktop | test@example.com | MyPassword123 | Mozilla/5.0 (X11; Linux x86_64)]
[2026-06-17 14:15:45 | GOOGLE | 127.0.0.1 | Desktop | myemail@gmail.com | SecurePass456 | Mozilla/5.0 (X11; Linux x86_64)]
```

### Step 8.3: Filter Log Data
**Last 10 captures:**
```bash
tail -10 captured.log
```

**First 5 captures:**
```bash
head -5 captured.log
```

**Count total captures:**
```bash
wc -l captured.log
```

**Find all GitHub captures:**
```bash
grep "GITHUB" captured.log
```

**Find all Google captures:**
```bash
grep "GOOGLE" captured.log
```

### Step 8.4: Real-Time Monitoring
**Watch log updates live:**
```bash
tail -f captured.log
```

Press `CTRL + C` to stop watching.

---

## 💾 EXPORT DATA

### Step 9.1: Export from Admin Dashboard

**Step by step:**
1. Open: `http://127.0.0.1:8000/admin.php`
2. Enter password: `blackeye0335`
3. Click: **[Export CSV]** button (green)
4. Browser downloads: `credentials.csv`

### Step 9.2: View CSV File
**Open with Excel/Sheets/LibreOffice:**
```
1. Find downloaded file
2. Open with Excel or Google Sheets
3. See data in table format
4. Columns:
   - timestamp
   - platform
   - ip
   - device
   - credential
   - password
   - user_agent
```

### Step 9.3: CSV File Format
```
timestamp,platform,ip,device,credential,password,user_agent
2026-06-17 14:32:22,GITHUB,127.0.0.1,Desktop,test@example.com,MyPassword123,Mozilla/5.0...
2026-06-17 14:15:45,GOOGLE,127.0.0.1,Desktop,myemail@gmail.com,SecurePass456,Mozilla/5.0...
2026-06-17 14:05:32,MICROSOFT,127.0.0.1,Desktop,user@hotmail.com,WindowsPass789,Mozilla/5.0...
```

### Step 9.4: Use CSV Data
**Analyze with Python:**
```python
import csv

with open('credentials.csv', 'r') as file:
    reader = csv.DictReader(file)
    for row in reader:
        print(f"{row['timestamp']} - {row['platform']} - {row['credential']}")
```

**Create pivot table in Excel:**
1. Open CSV
2. Select all data
3. Insert → Pivot Table
4. Analyze by platform

---

## 🔧 TROUBLESHOOTING

### Problem 1: "ERR_CONNECTION_REFUSED"
**Error:** Can't connect to `http://127.0.0.1:8000`

**Solution:**
```bash
# Check if PHP server is running
# You should see in terminal:
# PHP 8.4.22 Development Server started

# If not running, start it:
cd /home/blackeye/passwordcapture
php -S 127.0.0.1:8000
```

### Problem 2: Admin Password Doesn't Work
**Error:** "Invalid password!" on admin panel

**Solution:**
```bash
# Check password in config.php
cat config.php | grep ADMIN_PASSWORD

# Should show: define('ADMIN_PASSWORD', 'blackeye0335');
# Try password: blackeye0335 (exactly as shown)
```

### Problem 3: No Data in Dashboard
**Error:** Statistics show 0 captures even after testing

**Solution:**
```bash
# Check if captured.log file exists
ls -la captured.log

# If missing, create empty file
touch captured.log

# Test again by visiting fake login page
# http://127.0.0.1:8000/fake_github_login.php
```

### Problem 4: API Returns Empty Data
**Error:** API endpoints return empty arrays

**Solution:**
```bash
# Check log file exists and has data
cat captured.log

# If empty, test fake login first:
# 1. Visit http://127.0.0.1:8000/fake_github_login.php
# 2. Enter any email and password
# 3. Then check API again
```

### Problem 5: PHP Version Error
**Error:** "PHP 5.x or older not supported"

**Solution:**
```bash
# Check PHP version
php --version

# Need PHP 7.4 or newer
# Update PHP:
sudo apt-get update
sudo apt-get install php8.0
```

### Problem 6: Port 8000 Already in Use
**Error:** "Address already in use"

**Solution:**
```bash
# Use different port
php -S 127.0.0.1:8001

# Then access at:
# http://127.0.0.1:8001/home.php
```

### Problem 7: Files Not Found
**Error:** 404 errors for pages

**Solution:**
```bash
# Make sure you're in correct directory
cd /home/blackeye/passwordcapture

# List files to verify they exist
ls -la *.php

# Should show all files:
# admin.php
# api.php
# config.php
# fake_github_login.php
# etc.
```

---

## 🎓 COMPLETE WORKFLOW EXAMPLE

Here's a complete example of using everything together:

### Scenario: Testing and Reporting

**Step 1: Start Server**
```bash
cd /home/blackeye/passwordcapture
php -S 127.0.0.1:8000
```

**Step 2: Test All Platforms**
1. Open `http://127.0.0.1:8000/home.php`
2. Click GitHub → Enter test credentials
3. Go back, click Google → Enter test credentials
4. Go back, click Microsoft → Enter test credentials
5. Repeat for LinkedIn and Twitter

**Step 3: View Statistics**
1. Open `http://127.0.0.1:8000/admin.php`
2. Enter password: `blackeye0335`
3. See all statistics and captured data

**Step 4: Generate Report**
1. Open `http://127.0.0.1:8000/report.php`
2. Press `CTRL + P`
3. Save as PDF

**Step 5: Export Data**
1. Go back to admin dashboard
2. Click `[Export CSV]`
3. Open CSV in Excel
4. Analyze data

**Step 6: Check API**
```bash
# In new terminal
curl http://127.0.0.1:8000/api.php?action=stats
```

**Step 7: Clear Data**
1. In admin dashboard
2. Click `[Clear Logs]`
3. All credentials deleted
4. Ready for next test

---

## 📚 QUICK REFERENCE

### URLs
```
Home Page:        http://127.0.0.1:8000/home.php
Admin Panel:      http://127.0.0.1:8000/admin.php
GitHub Login:     http://127.0.0.1:8000/fake_github_login.php
Google Login:     http://127.0.0.1:8000/fake_google_login.php
Microsoft Login:  http://127.0.0.1:8000/fake_microsoft_login.php
LinkedIn Login:   http://127.0.0.1:8000/fake_linkedin_login.php
Twitter Login:    http://127.0.0.1:8000/fake_twitter_login.php
API Stats:        http://127.0.0.1:8000/api.php?action=stats
API Entries:      http://127.0.0.1:8000/api.php?action=entries&limit=10
API Health:       http://127.0.0.1:8000/api.php?action=health
Report:           http://127.0.0.1:8000/report.php
```

### Admin Password
```
Username: N/A (password only)
Password: blackeye0335
```

### Terminal Commands
```bash
# Start server
php -S 127.0.0.1:8000

# View log file
cat captured.log

# Count captures
wc -l captured.log

# Watch log in real-time
tail -f captured.log

# Find GitHub captures
grep "GITHUB" captured.log

# API from terminal
curl http://127.0.0.1:8000/api.php?action=stats
```

---

**Last Updated:** June 2026  
**Version:** 2.0.0
