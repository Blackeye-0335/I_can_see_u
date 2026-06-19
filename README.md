# I Can See U - Security Awareness Platform

**Version 2.0.0** - Enhanced educational phishing demonstration with comprehensive admin features

## ⚠️ DISCLAIMER

**EDUCATIONAL PURPOSE ONLY** - This project is designed for cybersecurity education and awareness training. Users are entirely responsible for how they use this tool. Unauthorized access to computer systems is illegal. Use only on systems you own or have explicit permission to test.

## Overview

"I Can See U" is an advanced security awareness platform that demonstrates modern phishing techniques and authentication vulnerabilities. It features realistic fake login pages for major platforms and provides real-time credential capture monitoring with detailed analytics.

## 🆕 What's New in v2.0

### ✨ New Features
- **Admin Dashboard** - Real-time monitoring of captured credentials
- **5 Fake Login Platforms** - GitHub, Google, Microsoft, LinkedIn, Twitter/X
- **Enhanced Analytics** - Statistics by platform, device type, and IP address
- **CSV Export** - Download captured data for analysis
- **Improved Logging** - Device detection, User-Agent capture, advanced filtering
- **Security Hardening** - Input sanitization, CSRF protection, session security
- **Responsive Design** - Mobile-friendly interfaces across all pages

### 🎯 Key Improvements
- **Code Organization** - Centralized configuration and utility functions
- **Reusable Utilities** - DRY principle applied to logging and validation
- **Better Error Handling** - Improved robustness and error messages
- **Modern UI** - Enhanced visual design for all pages
- **Scalability** - Better structure for adding new features

## Requirements

- **PHP 7.4+** or **PHP 8.x**
- **ngrok** (optional, for exposing locally to the internet)
- Modern web browser for testing

## Installation & Setup

### 1. Clone or Download the Repository
```bash
cd /path/to/I_can_see_u
```

### 2. Start PHP Built-in Server
```bash
php -S 127.0.0.1:8000
```

### 3. Access the Platform
Open your browser and navigate to:
```
http://127.0.0.1:8000/home.php
```

## 🌐 Available Pages

| Page | URL | Description |
|------|-----|-------------|
| **Home** | `/home.php` | Main landing page with all options |
| **GitHub** | `/fake_github_login.php` | GitHub login clone |
| **Google** | `/fake_google_login.php` | Google sign-in clone |
| **Microsoft** | `/fake_microsoft_login.php` | Microsoft login clone |
| **LinkedIn** | `/fake_linkedin_login.php` | LinkedIn login clone |
| **Twitter/X** | `/fake_twitter_login.php` | Twitter/X login clone |
| **Admin Dashboard** | `/admin.php` | View and analyze captured credentials |
| **Terminal** | `/index.php?guest` | Interactive hacker terminal (legacy) |

## 🔐 Admin Dashboard

### Accessing the Admin Panel
1. Navigate to `http://127.0.0.1:8000/admin.php`
2. Default password: `admin123` ⚠️ **Change this immediately!**

### Admin Features
- **Real-time Statistics**
  - Total captures count
  - Breakdown by platform
  - Device type analysis
  - Top source IPs

- **Credential Monitoring**
  - View all captured credentials
  - Timestamp tracking
  - Device information
  - User-Agent analysis
  - IP geolocation support

- **Data Management**
  - **Export to CSV** - Download data for external analysis
  - **Clear Logs** - Reset all captured data
  - Secure logout

### Changing Admin Password

Edit `config.php` and update:
```php
define('ADMIN_PASSWORD', 'your_new_password');
```

## 📊 Captured Data Fields

Each capture includes:
- **Timestamp** - When credentials were submitted
- **Platform** - Which login page was used
- **Email/Username** - Captured credential
- **Password** - Captured password
- **IP Address** - Source IP (with CloudFlare support)
- **Device Type** - Mobile or Desktop detection
- **User-Agent** - Browser and OS information

## 📁 File Structure

```
I_can_see_u/
├── home.php                          # Main landing page
├── admin.php                         # Admin dashboard
├── config.php                        # Configuration & settings
├── utils.php                         # Utility functions
├── fake_github_login.php             # GitHub clone
├── fake_google_login.php             # Google clone
├── fake_microsoft_login.php          # Microsoft clone
├── fake_linkedin_login.php           # LinkedIn clone (NEW)
├── fake_twitter_login.php            # Twitter/X clone (NEW)
├── index.php                         # Legacy terminal (kept for compatibility)
├── login.php                         # Legacy form handler
├── capture.html                      # Legacy capture page
├── captured.log                      # Captured credentials log (gitignored)
├── error.log                         # Error log (gitignored)
├── .gitignore                        # Git ignore rules
└── README.md                         # This file
```

## 🚀 Deploy with ngrok

To access your platform from anywhere:

```bash
# In a separate terminal, after PHP server is running
./ngrok http 8000
```

This creates a public URL like:
```
https://xxxx.ngrok-free.dev/home.php
```

## 🔒 Security Considerations

### For Developers/Educators
1. **Change the Admin Password** - Never use the default `admin123`
2. **Secure Your Server** - Use HTTPS in production
3. **Restrict Access** - Use VPN or IP whitelisting
4. **Regular Backups** - Keep copies of captured data
5. **Data Handling** - Follow privacy laws and institutional guidelines

### Best Practices
- Only run this on secure, private networks during testing
- Clear captured logs regularly
- Never commit `captured.log` to version control
- Use strong authentication for admin panel
- Monitor access logs

## 📊 Configuration

### Edit `config.php` to Customize:

```php
// Change platform list
define('PLATFORMS', [...]);

// Adjust session security
ini_set('session.cookie_httponly', 1);

// Set max log entries
define('MAX_LOG_ENTRIES', 1000);
```

## 🛠️ Development Features

### Utility Functions (utils.php)
- `logCredentials()` - Centralized credential logging
- `sanitizeInput()` - Input sanitization
- `getStatistics()` - Analytics generation
- `parseLogLine()` - Log entry parsing
- `exportToCSV()` - Data export

### Helper Functions (config.php)
- `getClientIP()` - IP detection with CloudFlare support
- `getUserAgent()` - Browser detection
- `getDeviceType()` - Mobile/Desktop detection

## 📈 Use Cases

1. **Security Awareness Training** - Train employees to recognize phishing
2. **Penetration Testing** - Demo for authorized security assessments
3. **Educational Research** - Study phishing attack patterns
4. **Red Team Exercises** - Controlled testing scenarios
5. **Security Audits** - Evaluate organizational security posture

## 🐛 Troubleshooting

### Admin dashboard shows "Repository not found"
- Verify `admin.php` file exists
- Check file permissions
- Ensure `config.php` and `utils.php` are in the same directory

### Credentials not logging
- Check `captured.log` file permissions (should be writable)
- Verify PHP error logs: `php -S` output
- Ensure `config.php` is loaded correctly

### Login forms not working
- Clear browser cache
- Check browser console for JavaScript errors
- Verify form submission method (should be POST)

## 📝 Logs

### Captured Credentials Log Format
```
[2024-01-15 14:30:45] | GITHUB | IP: 192.168.1.1 | Device: Desktop | Email/User: user@example.com | Password: xxxxxxxx | UA: Mozilla/5.0...
```

### Error Log
Accessible at: `error.log` (auto-created by PHP)

## 📜 License & Attribution

This project was created for **educational purposes only**.

**Disclaimer**: The creator and contributors are not responsible for any misuse of this code or tools. Users are entirely responsible for their actions. This tool should only be used:
- In legal, authorized security assessments
- For educational training purposes
- On systems you own or have explicit permission to test
- In compliance with all applicable laws and regulations



**Made with 🔒 for Security Awareness Education**

*Last Updated: January 2025*
*Version: 2.0.0*
