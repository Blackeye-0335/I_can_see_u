# CHANGELOG

All notable changes to I Can See U project are documented in this file.

## [2.1.0] - 2026-06-18

### Added
- ✨ REST API endpoint (`api.php`) with JSON responses
- 📊 Printable security report generator (`report.php`)
- 📚 Comprehensive API documentation (`API.md`)
- 🎨 Enhanced UI with session info styling
- 📱 Improved mobile responsiveness for smaller screens
- 🔧 Session duration tracking utility function
- 🌐 Platform configuration extension (Facebook, Amazon, Apple)

### Changed
- 🔐 Admin password updated to `blackeye0335`
- 🔧 Fixed admin password whitespace handling
- 🎨 Improved CSS styling on admin dashboard
- 📱 Enhanced responsive design breakpoints

### Security
- ✅ Input sanitization with `htmlspecialchars()`
- ✅ Session security hardening
- ✅ CORS headers for API
- ✅ Error handling improvements

## [2.0.0] - 2026-06-17

### Added
- 🎯 Home page with platform selector (home.php)
- 🔐 Full-featured admin dashboard (admin.php)
- ⚙️ Centralized configuration system (config.php)
- 🛠️ Reusable utility functions (utils.php)
- 💼 LinkedIn login clone (fake_linkedin_login.php)
- 𝕏 Twitter/X login clone (fake_twitter_login.php)
- 📊 Statistics and analytics by platform, device, IP
- 📥 CSV export functionality
- 📱 Device type detection (Mobile/Desktop)
- 👤 User-Agent capture and logging
- 🌐 CloudFlare IP detection support

### Changed
- 🔄 Refactored all login handlers to use utility functions
- 📝 Completely rewritten README with comprehensive documentation
- 🔧 Improved .gitignore with additional patterns
- 🎨 Modern responsive UI design on all pages

### Fixed
- 🔧 Improved error handling and logging
- 🔐 Enhanced session handling
- ✅ Input validation on all forms

## [1.0.0] - 2024-01-01

### Initial Release
- Basic phishing demo with GitHub, Google, Microsoft login pages
- Simple credential logging to `captured.log`
- Terminal interface for guest users
- Basic PHP-based implementation

---

## Upgrade Guide

### From v2.0 to v2.1
1. Download the new files (`api.php`, `report.php`, `API.md`)
2. Update `config.php` with new platform definitions
3. Update `utils.php` with new session tracking function
4. Update `admin.php` with new styling
5. Update `home.php` with responsive improvements
6. Clear browser cache for CSS updates

### From v1.0 to v2.0
Complete rewrite - backup old logs before upgrading.

---

## Future Plans (v3.0)
- [ ] Database backend (MySQL/PostgreSQL)
- [ ] User authentication system
- [ ] Advanced analytics dashboard
- [ ] Webhook notifications
- [ ] More platform clones (Facebook, Instagram, TikTok)
- [ ] Dark/Light theme toggle
- [ ] Multi-language support
- [ ] Rate limiting
- [ ] IP geolocation mapping
- [ ] Real-time alerts

---

**Version:** 2.1.0  
**Last Updated:** June 18, 2026  
**Maintainer:** Blackeye-0335
