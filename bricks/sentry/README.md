> # Sentry example
>
> Observer with Sentry integration example.

## How to start

```bash
$ pushd app
$ ./install.sh
# IMPORTANT: not tested

$ popd
# configure your env:
#  cp .env.example .env
#  sed -i 's|___PUBLIC_DSN___|put your dsn|g' .env
$ set -o allexport; source .env; set +o allexport
$ php example.php
```

## Useful resources

- [Self-Hosted Sentry](https://develop.sentry.dev/self-hosted/).
