# Google Play Scraper for PHP

> A lightweight PHP scraper for extracting app details from Google Play Store pages.

---

## Features

- Fetch app title, summary, installs, score, reviews, developer info, and more.
- Easy to use and lightweight.
- No API key required.

---

## Installation

Simply download or clone the repository:

```bash
git clone https://github.com/rezamasoudi/google-play-scraper.git
```

Or manually include the `google-play-scraper.php` file into your project.

---

## Usage

```php
require 'google-play-scraper.php';

$scraper = new GooglePlayScraper('ai.captiono.app');

$scraper->title; // Captiono: AI Subtitles
$scraper->summary; // Automatic Video Subtitles. Powerful Video Editing Tools for Bloggers
$scraper->installs; // 100,000+
$scraper->minInstalls; // 100000
$scraper->realInstalls; // 293028
$scraper->score; // 4.3959184
$scraper->ratings; // 4966
$scraper->reviews; // 530
$scraper->developer; // Captiono
$scraper->developerId; // Captiono
$scraper->developerEmail; // info@captiono.ai
$scraper->developerWebsite; // https://captiono.ai
$scraper->privacyPolicy; // https://doc-hosting.flycricket.io/captiono-privacy-policy/82c980eb-89bf-4a8a-b248-c556cbe1d895/privacy
$scraper->genre; // Video Players & Editors
$scraper->genreId; // VIDEO_PLAYERS
$scraper->icon; // https://play-lh.googleusercontent.com/8Z1JAjs4ZLzrmB0YFwzFaCqdX56GEO8pZjwAHeiag0MlzyFXwqEoMU1GSKwA0QfoQw
$scraper->headerImage; // https://play-lh.googleusercontent.com/01YJr78KEX29Y_C5hruaC_dA37q8reDAmO-S7IXqCMBNL9QKckVXOPUPpCxrAtwMw3s
$scraper->video; // 
$scraper->videoImage; // 
$scraper->contentRating; // Rated for 3+
$scraper->contentRatingDescription; // 
$scraper->adSupported; // 
$scraper->containsAds; // 
$scraper->released; // Aug 28, 2024
$scraper->lastUpdatedOn; // Mar 24, 2025
$scraper->updated; // 1742856241
$scraper->version; // 1.3.1
```

---

## Notes

- This scraper depends on the current structure of Google Play pages. If Google changes their page format, the scraper might need updates.
- Use responsibly and avoid sending too many requests to Google servers.

---

## License

This project is licensed under the MIT License.

---

## Author

Made with ❤️ by [Reza Masoudi](https://github.com/rezamasoudi)

---

### 📢 Pull requests and contributions are welcome!
