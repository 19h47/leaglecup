# Leagle Cup

## Docker

Stops containers and removes containers with named volumes declared in the `volumes` section of the `docker-compose.yml`

```bash
docker-compose down --volumes
```

Builds, (re)creates, starts, and attaches to containers for a service

```bash
docker-compose up -d
```

## Make an url point to localhost

```bash
sudo nano /etc/hosts
```

```
127.0.0.1   leaglecup.test www.leaglecup.test
```

Then type `ctrl + x`, and `y` to save and exit nano. Now, the custom url points to `localhost`.

## Database

Put your SQL dump in the `database` folder

## .env
