
# HTML demo with background process using Redis

Run a web server for index.php with:
```bash
php -S localhost:8888
```

View http://localhost:8888 to check the loading bar shows 0%.
The page will reload waiting for changes.

Then start the background process with:
```bash
php background.php
```

Go back to the loading bar in your browser and watch it slowly fill the progress bar.
