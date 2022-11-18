# Simple Space
Workspace with php, nginx, adminer, postgresql

## 1. Install project
*Note: for the work, you must have git installed*

Clone the repository

`git clone https://github.com/acferten/first_week`

## 2. Project settings
*Note: settings are in .env file*

Rename .example-env to .env in the "docker" folder and change the values of variables to yours

| Argument | Description |
| -----|------|
| USER_LOGIN | User login. Used as a database access login |
| DB_NAME | Database name for the created user |
| USER_DB_PASSWORD | Database administrator password (administrator login - root) |
| WEB_PORT | Web-server port |
| SERVER_NAME | Server hostname  |

## 2. Run project as production build
*Note: for the project to work, you must have docker and docker-compose installed*
*Note: Run inside the project directory*

`cd docker`

`docker-compose -f docker-compose.prod.yml up -d`

## 3. Run project as development build
*Note: Run inside the project directory*

`cd docker`

`docker-compose up --build`