# AVCorn

AVCorn is a simple VC CMS for basic content websites, no databases required.
The original intent is for fast deploying, fast developing, and lightweight performance for low traffic website design clients.
Written in PHP, and utilizing the Twig templating engine.

![AVCorn Logo](docs/images/readme-banner.png "The nut doesn't fall from from the tree!")

_"The nut doesn't fall from from the tree!"_

## Application Environment

### Install the Application (Locally)

You will require PHP 8.1 or newer.

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
. avcorn.sh start
```

We offer a convient way to shell in to this container:
```bash
. avcorn.sh shell
```

If you want to clean up the docker containers made:
```bash
. avcorn.sh stop
```

### Install the Application Remotely (AWS)

```bash
. avcorn.sh deploy
```

## Links

*   [Development Progress](docs/TODO.md)
*   [Contributing Guidelines](docs/CONTRIBUTING.md)
*   [Reporting a Security Issue](docs/SECURITY.md)
*   [License](docs/LICENSE.md)
*   [GitHub](https://github.com/blaher/avcorn)
