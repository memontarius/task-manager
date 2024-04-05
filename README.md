
# Task Tracker

## Установка

### Предварительные требования

* PHP ^8.1
* Make
* Composer
* Node.js & NPM

### Запуск с разворачиванием в Docker-контейнере

1. Установить зависимости

    ```sh
    make i
    ```

2. Подготовить конфигурационный файл

    ```sh
    make prepare-env
    ```

3. Указать в *.env* пароли для БД

    ```dotenv
    DB_PASSWORD=your_password
    ...
    REDIS_PASSWORD=your_password
    ```
   
4. Запустить контейнеры

    ```sh
    make up
    ```

5. Предварительная установка (разрешения для директорий и миграция)

    ```sh
    make setup
    ```

6. Заполнить базу данными
    ```sh
    make c-seed
    ```
   
