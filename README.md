### User Profile Service

Install dependencies

```shell
composer install
```

Start Symfony server

```shell
symfony server:start
```

Open the following url

```text
http://<domain>:<port>/v1/profile/<UUIDv7>
```

See expected response

```json
{
    "id": "{from_query}",
    "email": "test@test.com",
    "name": "John Foo",
    "avatar_url": "https://i.pravatar.cc/300",
    "unknown": "alien"
}

```

Upstream user data sources (priority weights, mock responses) are configured in
```text
config/sources.yaml
```

To tests and statically analyze run

```shell
composer check
```