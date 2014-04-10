cc-gallery-helper
======================
traviswachendorf@clearchannel.com

* This app will be programmed in PHP 4.4.9 *

* Live version: http://www.knixcountry.com/common/getphotos/ *

Simpla app to help CC users search and post galleries to their personality page.

These files are meant to create:
- Searchable front end for users to find galleries and retrieve embed code.
- Simple admin to allow gallery data entry

Server Requirements:
- MySQL Database

Installation Instructions
- 1. Create a database on your MYSQL Server
- 2. Run -cc_galleries.sql- in your MYSQL client to create tables
- 3. Create at least 1 user in the -- cc_galleries_users_admin -- table
- 4. Set up database connection credentials and filepath constants in -lib/config.inc.php- file and comment out local settings
- 5. Default configuration is for local MYSQL server. You must make a few changes to move from local settings to cc server
	- Files affected: -index.php, admin.php, add-gallery.php, edit-details.php-
	- Comment out -inc/header-local.php- and -inc/footer-local.php-
	- Comment back in (remove /* and */) the code for cc header and cc footer including the javascript in the footer.
- 6. You should be good to go.

