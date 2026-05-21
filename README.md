# password-capture

## Overview

This repository contains a local phishing demo project with fake login pages for Microsoft, Google, and GitHub styles. It uses simple PHP scripts to capture submitted credentials and store them in `captured.log`.

> Note: `captured.log` is ignored by git via `.gitignore` and should not be committed or shared.

## Requirements

- PHP 7.4+ or PHP 8.x
- `ngrok` (optional, for exposing the local server publicly)

## Install

No special dependencies are required other than PHP.

1. Open a terminal.
2. Change into the project directory:

```bash
cd /home/user/passwordcapture
```

## Run locally with PHP built-in server

Start the local server from the project root:

```bash
php -S 127.0.0.1:8000
```

Then open one of these pages in your browser:

- `http://127.0.0.1:8000/fake_microsoft_login.php`
- `http://127.0.0.1:8000/fake_google_login.php`
- `http://127.0.0.1:8000/fake_github_login.php`

## Use ngrok to expose locally

If you want to access the site from outside your machine, start ngrok after the local PHP server is running:

```bash
./ngrok http 8000
```

Then open the public URL shown by ngrok, for example:

```text
https://xxxxx.ngrok-free.dev/fake_microsoft_login.php
```

## Notes

- Do not commit `captured.log` to git.
- The file is already ignored by `.gitignore`.
- If you need to remove sensitive data from the repo, use history rewrite tools carefully.
warning:
 creator is not responsible for any cused using this code and tools user is self responsible for it.
  made for only educational purpose only.
