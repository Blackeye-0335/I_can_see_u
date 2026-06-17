# Quick Start Guide

Get up and running with I Can See U in 5 minutes!

## 🚀 Installation

### Prerequisites
- PHP 7.4+
- Terminal/Command Prompt
- Web Browser

### Step 1: Navigate to Project
```bash
cd /home/blackeye/passwordcapture
```

### Step 2: Start PHP Server
```bash
php -S 127.0.0.1:8000
```

You'll see:
```
[server] Listening on http://127.0.0.1:8000
```

### Step 3: Open in Browser
Visit: `http://127.0.0.1:8000/home.php`

## 🎯 Using the Platform

### Home Page
- **URL:** `http://127.0.0.1:8000/home.php`
- Select any platform to test
- Each platform has a realistic login form

### Admin Dashboard
- **URL:** `http://127.0.0.1:8000/admin.php`
- **Password:** `blackeye0335`
- View all captured credentials
- Download CSV reports
- See statistics

## 📱 Try a Login

1. Go to home page
2. Click "Access GitHub Login"
3. Enter any email and password
4. Form submits automatically
5. Check admin dashboard to see captured data!

## 📊 Available Logins

| Platform | URL | Field 1 | Field 2 |
|----------|-----|---------|---------|
| GitHub | `/fake_github_login.php` | Username | Password |
| Google | `/fake_google_login.php` | Email | Password |
| Microsoft | `/fake_microsoft_login.php` | Email | Password |
| LinkedIn | `/fake_linkedin_login.php` | Email | Password |
| Twitter/X | `/fake_twitter_login.php` | Username | Password |

## 🔧 Admin Features

### Dashboard
- Real-time statistics
- Platform breakdown
- Device type analysis
- Top IPs

### Data Management
- **Export CSV** - Download all data
- **Clear Logs** - Reset database
- **View Details** - Full credential table

### API Access
- **URL:** `http://127.0.0.1:8000/api.php?action=stats`
- Get JSON data programmatically

## 📊 Generate Reports

### HTML Report
- **URL:** `http://127.0.0.1:8000/report.php`
- Printable PDF format
- Statistics and analytics
- Print or export as PDF

## 🌐 Share Publicly (Optional)

### Using ngrok

```bash
# Install ngrok (one time)
# Download from https://ngrok.com

# Start ngrok in new terminal
./ngrok http 8000

# You'll get a public URL like:
# https://xxxx.ngrok-free.dev/home.php
```

Share this URL to allow remote access.

## 🔐 Change Admin Password

Edit `config.php`:
```php
// Find this line
define('ADMIN_PASSWORD', 'blackeye0335');

// Change to your password
define('ADMIN_PASSWORD', 'YourNewPassword123');
```

## 📁 Important Files

```
home.php              - Landing page
admin.php             - Dashboard
api.php               - JSON API
report.php            - Statistics report
config.php            - Configuration
utils.php             - Helper functions
fake_*.php            - Login pages
captured.log          - Credentials (auto-created)
```

## 🐛 Troubleshooting

### Server won't start
```bash
# Port already in use? Try different port
php -S 127.0.0.1:8001
```

### Admin login fails
1. Check password in `config.php`
2. Clear browser cache
3. Try incognito/private window

### Data not saving
1. Check file permissions
2. Ensure `captured.log` is writable
3. Check PHP error logs

## 📚 Learning Paths

### For Students
1. **Day 1:** Explore all fake login pages
2. **Day 2:** Use admin dashboard
3. **Day 3:** Generate reports
4. **Day 4:** Use API endpoint

### For Educators
1. Setup platform
2. Have students attempt logins
3. Review statistics together
4. Discuss security awareness
5. Generate report for documentation

## 🎓 Teaching Ideas

### Lesson 1: Phishing Recognition
- Show students the fake pages
- Discuss realistic elements
- Compare with real sites

### Lesson 2: Data Security
- Demonstrate credential capture
- Show admin dashboard
- Emphasize password importance

### Lesson 3: Analytics
- Generate report
- Show statistics
- Discuss attack patterns

### Lesson 4: Defense
- Discuss 2FA
- Password managers
- Security awareness

## 💡 Tips

- ✅ Use different passwords each test
- ✅ Note timestamps for analysis
- ✅ Export data before clearing logs
- ✅ Take screenshots for reports
- ✅ Document findings

## 🆘 Need Help?

1. **Check documentation:** `README.md`
2. **See API docs:** `API.md`
3. **Review security:** `SECURITY.md`
4. **Check changelog:** `CHANGELOG.md`

---

**Ready to start?** Open `http://127.0.0.1:8000/home.php` now!

**Last Updated:** June 2026
