cc-gallery-helper
======================
travis@magnifiedonline.com

* This app will be programmed in PHP 4.4.9 *

Simpla app to help CC users search and post galleries to their personality page.

These files are meant to create:
- Searchable front end for users to find galleries and retrieve embed code.
- Simple admin to allow gallery data entry

For installation:
- Create a database on your MYSQL Server
- Run -- cc_galleries.sql -- in your MYSQL client to create tables
- Create at least 1 user in the -- cc_galleries_users_admin -- table
- Set up database connection credentials in lib/config.inc.php file
- Adjust your -- BASE_URL and ROOT_PATH -- in the config path.

Default configuration is for local MYSQL server.
