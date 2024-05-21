# Invoices Databdase

## Setup using docker-compose.yml
```yml
services:
  app:
    build:
      context: .
      dockerfile: Dockerfile
    command: sh -c "composer install && /bin/bash /var/www/html/script.sh"
    ports:
      - "5000:8000"
    volumes:
      - .:/var/www/html
    depends_on:
      - db

  db:
    image: mysql:latest
    restart: always
    environment:
      MYSQL_ROOT_PASSWORD: secret
      MYSQL_DATABASE: invoice_manager
    volumes:
      - db_data:/var/lib/mysql
  phpmyadmin:
    image: phpmyadmin/phpmyadmin
    environment:
      PMA_HOST: db
      PMA_USER: root
      PMA_PASSWORD: secret
    ports:
      - "5080:80"

volumes:
  db_data:
```