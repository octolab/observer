> # Graylog example
>
> Observer with Graylog integration example.

## How to start

```bash
$ pushd app
$ docker compose up -d
$ docker compose ps graylog
$ open http://127.0.0.1:8080/system/inputs
# enable GELF UDP for 127.0.0.1:12201

$ popd
$ php example.php
```

## Useful resources

- [Docker - Installing Graylog](https://docs.graylog.org/docs/docker).
