> # Graylog example
>
> Observer with Graylog integration example.

## How to start

```bash
$ docker compose up -d
$ docker compose ps graylog
$ open http://127.0.0.1:8080/system/inputs
# enable GELF UDP
$ php app/index.php
```

## Useful resources

- [Docker - Installing Graylog](https://docs.graylog.org/docs/docker).
