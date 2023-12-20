# Generic Loading Bar

A generic PHP loader/progress bar utility package to help with applications that need to display a loading bar during a long running process.

Install with composer:
```bash
composer require stilliard/generic-loading-bar
```

## Basic usage

```php
use GLB\LoadingBar;
$loading = new LoadingBar;
$loading->step(); // each call is 1/100 (or whatever steps is set to)
$loading->set(40); // set a specific loaded %
$loading->complete(); // sets to 100 to mark as complete
$loading->reset(); // sets to 0 to start over
```

or with options:
```php
$loading = new LoadingBar([
    'codename' => 'my_loading_bar',
    'min' => 0,
    'max' => 100,
    'steps' => 150, // default: 100
    'dataHandler' => DBDataHandler::class, // default ProcessDataHandler
    'displayHandler' => HTMLDisplayHandler::class, // default EchoDisplayHandler
]);
```
```php
$loading->step(); // each call is then 1/150 (or whatever steps is set to)
```

### Display the loading bar

```php
echo $loading->display(); // displays the html loading bar with auto refresh
```
or
```php
echo $loading; // same as above
```

### Ranged loading calculations

Ranged calculations are the original reason for this package.
Want to split your loading into 4 parts, each with 25% but then have maybe thousands of records to process inside? This handles this for you.

```php
$totalProducts = count($products);
foreach ($products as $i => $product) {
    // fill in the range between 25% to 50% as the % of the total products handled so far. [index, total] (we auto +1 to the index)
    $loading->calc([25, 50], [$i, $totalProducts]);
}
```

### Data Handlers

- **Process** `ProcessDataHandler` runs just in process and doesn't save anywhere
- **Redis** `RedisDataHandler` uses redis to store the current loading % 
- **PDO** `PDODataHandler` uses a database with a PDO instance, lets you pass a DB PDO instance/object in via the construct options to then query an assumed `loading_bars` table with `name` and `value` columns.
- **DB** `DBDataHandler` like above PDO one but instead of passing a `pdo` instance, it assumes you have a `DB` global class

Build your own by extending the abstract `BaseDataHandler` class, see how the above ones work as an example in the `src/DataHandler` folders.

### Display Handlers

- **Echo** `EchoDisplayHandler` simply echos/outputs the current % at the point of `->display()` called
- **Console** `ConsoleDisplayHandler` a CLI/Console ascii loading/progress bar e.g. `[===>    ] 50%`
- **HTML** `HTMLDisplayHandler` shows a `<progress>` element at point of display, could then be auto refreshed from there through ajax

Build your own by extending the abstract `BaseDisplayHandler` class, see how the above ones work as an example in the `src/DisplayHandler` folders.

### License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/license/mit/).
