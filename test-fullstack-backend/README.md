# Backed for test fullstack

### Dependencies:
To run the project you need to have Docker and Docker Compose installed.  
It is also necessary to have the make command already installed.


### Installing and running

First check if the Docker service is already running, with the Docker service running, enter the
project and run the command:
```bash
make d-up
```
with this command we will download and build the Docker image.

<br>
After create a file .env and put that content

<details>
<summary>.env</summary>

```.dotenv
APP_NAME=Lumen
APP_ENV=local
APP_KEY=$2y$10$27QjMWLs8RDfZvt3EeqcHeFyiciXOlSkP1ZNGHQYS.G6udkKYL34u
APP_DEBUG=true
APP_URL=http://localhost
APP_TIMEZONE=UTC

LOG_CHANNEL=stack
LOG_SLACK_WEBHOOK_URL=

DB_CONNECTION=pgsql
DB_HOST=postgres
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=postgres

CACHE_DRIVER=file
QUEUE_CONNECTION=sync

JWT_SECRET=wk2XIl4l2bfduqMLrAN4yfqmBKQnk3rAeD0lyEuCJsdxpK6qXzZLA6EnpOA1OF9m
FILESYSTEM_DRIVER=local

```
</details>

<br/>

After finishing the process, we will set up the database, in another console, running the command:
```bash
make migrate
```

<br/>

After that we have the backend running and the database created, we can add some data by seeding the database:
```bash
make db-seeder
```
<br/>

The API is available at the address:
```
localhost:8080/v1
```

<br/>

### Tests
To run the tests just run the command:
```
make test
```
We can also run a specific test file:
```
make testfile file=FileName
```
where ``FileName`` is the name of the test file we want to run.  
