# AVCorn

AVCorn is a simple VC CMS for basic content websites, no databases required.
The original intent is for fast deploying, fast developing, and lightweight performance for low traffic website design clients.
Written in PHP, and utilizing the Twig templating engine.

![AVCorn Logo](docs/images/avcorn-logo.png "The nut doesn't fall from from the tree!")

"The nut doesn't fall from from the tree!"

## Install the Application Locally

You will require PHP 7.4 or newer.

* Point your virtual host document root to your new application's `public/` directory.
* Ensure `logs/` is web writable.

To run the application in development, you can run this command:

```bash
cd code
composer start
```

Or you can use `docker-compose` to run the app with `docker`, so you can run this command:
```bash
cd code
docker-compose up -d
```
After that, open `http://localhost:8080` in your browser.

Run this command in the application directory to run the test suite

```bash
composer test
```

That's it!

## Install the Application Remotely

```bash
/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/blaher/avcorn/main/install.sh)"
```

[Check Development Progress](TODO.md)
