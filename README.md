# Selae scraper
Scraper for SELAE (Spanish state lottery & betting operator)

Currently scraped pages:
* LaQuiniela

# Installation
```
composer require subzeta/selae-scraper
```

# Use
```
<?php

use subzeta\SelaeScraper\Page\LaQuiniela\Scrapper;

var_dump(
    (new Scrapper())->scrape()
);
```
