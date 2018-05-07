Prosody production Docker

# Production
## Initial (first-time only) setup
- 


# Development with Docker
- Create a folder for the project
- Clone the docker-compose.yml file
  - `git clone `
- Clone the plugins and theme repos into your working directory
  - `git clone https://github.com/scholarslab/prosody_plugin.git`
  - `git clone https://github.com/scholarslab/prosody_theme.git`
  - `git clone https://github.com/Seravo/wp-custom-bulk-actions.git`
- Create a '.env' file with the following variables
  ```
  MYSQL_ROOT_PASSWORD=
  MYSQL_DATABASE=
  MYSQL_USER=
  MYSQL_PASSWORD=
  WORDPRESS_DB_HOST=
  WORDPRESS_DB_USER=
  WORDPRESS_DB_PASSWORD=
  WORDPRESS_TABLE_PREFIX=
  PORTS=
  ```

- Start the docker with docker-compose
  - `docker-compose up`

- The website is viewable at http://localhost
