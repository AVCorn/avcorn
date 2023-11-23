# AVCorn

AVCorn is a simple VC CMS for basic content websites, no databases required.
The original intent is for fast deploying, fast developing, and lightweight performance for low traffic website design clients.
Written in PHP, and utilizing the Twig templating engine.

![AVCorn Logo](docs/images/nutty-readme.png "The nut doesn't fall from from the tree!")

_"The nut doesn't fall from from the tree!"_

## Application Environment

### Install the Application (Locally)

You will require PHP 7.4 or newer.

* Point your virtual host document root to your new application's `public/` directory.
* Ensure `logs/` is web writable.

To run the application in development, you can run this command:

```bash
cd code
composer start
```

Or you can use `docker-compose` to run the app with `docker`, so you can run this command (no need to `cd`):
```bash
docker-compose up -d
```
After that, open `http://localhost:8080` in your browser.

Run this command in the application directory to run the test suite

```bash
composer test
```

That's it!

### Run Production (Docker)

In order to run the environment in a production level environment:
```bash
. ./scripts/start.sh
```

We offer a convient way to shell in to this container:
```bash
. ./scripts/shell.sh
```

If you want to clean up the docker containers made:
```bash
. ./scripts/stop.sh
```

### Install the Application Remotely (AWS)

```bash
/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/blaher/avcorn/main/scripts/install.sh)"
```

## Links
* [Development Progress](docs/TODO.md)
* [Contributing](docs/CONTRIBUTING.md)
