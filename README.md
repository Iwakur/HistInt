# HistInt

Interactive PHP story game set in the world of Valdremor.

## Install With Laragon

1. Install Laragon.
2. Open Laragon.
3. Start `Apache` and `MySQL`.
4. Copy or clone this project into `C:\laragon\www\`.
5. Prefer this final path:

```text
C:\laragon\www\HistInt
```

If you keep the project in:

```text
C:\laragon\www\Github\HistInt
```

that also works, but the URL becomes `http://localhost/Github/HistInt/`.

## Database

The project uses these settings from `includes/config.php`:

```php
DB_HOST = 127.0.0.1
DB_NAME = valdremor
DB_USER = root
DB_PASS = ""
```

On first run, the app automatically creates:

- the `valdremor` database
- the `users` table

If your local MySQL password is different, update `includes/config.php`.

## Start The Project

If the project is in `C:\laragon\www\HistInt`, open:

```text
http://localhost/HistInt/
```

If the project is in `C:\laragon\www\Github\HistInt`, open:

```text
http://localhost/Github/HistInt/
```

## First Run

1. Open the local URL in your browser.
2. Register an account or start a new game.
3. The project will create its database structure automatically when needed.

## Troubleshooting

- If the site does not load, make sure `Apache` is running.
- If login fails, make sure `MySQL` is running.
- If the database connection fails, verify `includes/config.php`.
- If images do not appear, verify the files exist in `assets/images`.



HistInt/
│
├── README.md
├── index.php
├── login.php
├── logout.php
├── profile.php
├── register.php
├── scene.php
│
├── assets/
│   ├── audio/
│   │   ├── cold.mp3
│   │   ├── destiny.mp3
│   │   ├── fire.mp3
│   │   ├── stealth.mp3
│   │   └── tension.mp3
│   ├── css/
│   │   ├── base/
│   │   │   ├── auth_style.css
│   │   │   ├── index_style.css
│   │   │   └── scene_style.css
│   │   └── moods/
│   │       ├── cold_style.css
│   │       ├── destiny_style.css
│   │       ├── fire_style.css
│   │       ├── stealth_style.css
│   │       └── tension_style.css
│   ├── images/
│   │   ├── fin 1.jpg
│   │   ├── fin 2.jpg
│   │   ├── fin 3.jpg
│   │   ├── fin 4.jpg
│   │   ├── scene_01.jpg
│   │   ├── scene_02a.jpg ... scene_08b.jpg
│   │   └── TODO: missing generated images listed below
│   ├── js/
│   │   └── main.js
│   └── specials/
│       └── favicon.png
│
├── content/
│   ├── scene_01.json
│   ├── scene_02a.json ... scene_08c.json
│   └── scene_09_fin_{combat,crypte,pardon,sacrifice}.json
│
└── includes/
    ├── config.php
    ├── db.php
    ├── footer.php
    ├── functions.php
    └── header.php
# HistInt

-----
reerad the DB file