# Invoices Databdase

## Description
Invoices organizer

## Setup using docker-compose.yml
```yml
services:
  app:
    image: ghcr.io/itsraelx/invoicesdatabase:latest
    restart: unless-stopped
    ports:
      - "127.0.0.1:5000:8000"
    volumes:
      - app_data:/var/www/html
    depends_on:
      - db

  db:
    image: mysql:latest
    restart: unless-stopped
    environment:
      MYSQL_ROOT_PASSWORD: secret
      MYSQL_DATABASE: invoice_manager
    volumes:
      - db_data:/var/lib/mysql

  phpmyadmin:
    image: phpmyadmin/phpmyadmin
    restart: unless-stopped
    environment:
      PMA_HOST: db
      PMA_USER: root
      PMA_PASSWORD: secret
    ports:
      - "127.0.0.1:5080:80"
    depends_on:
      - db

volumes:
  db_data:
  app_data:
```
