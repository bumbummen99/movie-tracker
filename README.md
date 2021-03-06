# Movie Tracker
![CI Code Checks](https://github.com/bumbummen99/movie-tracker/workflows/CI/badge.svg?branch=master)
[![codecov](https://codecov.io/gh/bumbummen99/movie-tracker/branch/master/graph/badge.svg)](https://codecov.io/gh/bumbummen99/movie-tracker)
[![StyleCI](https://styleci.io/repos/464262987/shield?branch=master)](https://styleci.io/repos/464262987)

## Requirements
- Linux / maxOS / WSL2
- Docker

**For advanced users:**
- Any HTTP-Server
- PHP >=8.0
- MariaDB / MySQL server
- Redis server

## Installation

Before you can use Movie Tracker you will have to install the dependencies using the following command:
```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```

If this is your first time using this installation you will have to create an .env file, simply copy the example:
```
cp .env.example .env
```

Since we are using Sail for our local environment, define the bash alias if it is not already defined on your machine or substitute `sail` with `vendor/bin/sail` in the following commands:
```
alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'
```

Once the dependencies are installed you can run the application using Laravel Sail:
```
sail up -d
```

Next you will have to generate an application key that will be used for encryption:
```
sail artisan key:generate
```

Once you have generated the key you can proceed to run the migrations in order to initialize the dabase:
```
sail artisan migrate
```

Before you can access the frontend you will first have to install dependencies using NPM and build the CSS/JS using the follwing command
```
sail npm i && \
sail npm run dev
```

That's it! Now you can navigate to http://localhost and use the application.
