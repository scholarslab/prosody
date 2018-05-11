# Prosody: For Better for Verse

This repo holds instructions and files for setting up the the production and
development environments for the Prosody project.

# Production
## Initial (first-time only) setup
- Create the Apache config file
  - The config should have some form of proxy pass set up. A typical Apache config would look something like this:
    ```
    <VirtualHost *:80>
      ServerName prosody.lib.virginia.edu

      ProxyPass / http://localhost:8228/
      ProxyPassReverse / http://localhost/
      ProxyPreserveHost On
    </VirtualHost> 
    ```
  - Note the port number used on the ProxyPass line. this must be the same as used in the left side of the colon on the PORTS line in the .env file (see below)
- Clone the repository into the appropriate place, ex `/var/www/prosody.lib.virginia.edu`
  - `git clone https://github.com/scholarslab/prosody.git prosody.lib.virginia.edu`
- Change into the 'Prosody' folder.
  - `cd prosody.lib.virginia.edu`
- Clone the plugins and theme repos into your working directory
  - `git clone https://github.com/scholarslab/prosody_plugin.git`
  - `git clone https://github.com/scholarslab/prosody_theme.git`
  - `git clone https://github.com/Seravo/wp-custom-bulk-actions.git`
- Create a '.env' file with the following variables
  ```
  MYSQL_ROOT_PASSWORD=some_great_password
  MYSQL_USER=wordpress_user
  MYSQL_PASSWORD=wordpress_password
  MYSQL_DATABASE=wordpress
  WORDPRESS_DB_HOST=db:3306
  WORDPRESS_TABLE_PREFIX=prosody_wp_
  PORTS=8888:80
  ```
  - NOTE the following about each line:
    - `MYSQL_DATABASE`, `WORDPRESS_DB_HOST`, `WORDPRESS_TABLE_PREFIX` must be as written. 
    - `PORTS` depends on production or development. Production requires a different port than 80 for the first value (left side of colon).
    - The first three lines can be whatever.
- Copy the uploads directory from the old prosody site
  - `scp -r old.prosody.site:/path/to/wp/wp-content/uploads uploads`
- Make a dump of the old prosody database. Make a folder called 'initial_sql', and put the file in there.
  - Make sure to name it "prosody_production.sql".
- Note the 'Dockerfile'. This is needed so that the xsl module is enabled in the WordPress image. This creates a separate docker image that is used instead of the one supplied by WordPress
- Uncomment the 'initial_sql' line in the docker-compose.yml file.
  - `./initial_sql/prosody_production.sql:/docker-entrypoint-initdb.d/prosody_production.sql`
- Make sure the permissions on all files and folders are correct.
  - files should be 644
    - `find . -type f -exec chmod 664 '{}' \;`
  - folders should be 755 (with the s bit set)
    - `find . -type d -exec chmod ug=rwx,g+s,o=rx '{}' \;`
- Start the container with docker-compose, with -d flag to start docker-compose as a background process
  - `docker-compose up -d`
  - To test the set up and check for any errors, run the above command without the "-d" flag. 
    - After everything looks good, you can stop the docker process with 
      - `Ctrl-c` 
    - then stop all docker containers with the following command before restarting
      - `docker-compose down --volumes`
- Comment out the line with 'initial_sql' in the docker-compose.yml file so it is not loaded on subsequent restarts (potentially overwriting changes made to the website).
  - `#./initial_sql/prosody_production.sql:/docker-entrypoint-initdb.d/prosody_production.sql`


## Upgrade Prosody on production
It will be necessary to restart Docker when upgrading the WordPress version, or the MySQL version.

- While in the project folder (/var/www/prosody.lib.virginia.edu), shutdown docker
  - `docker-compose down`
- Make sure to comment out the line with 'initial_sql', if not done already.
  - `#./initial_sql/prosody_production.sql:/docker-entrypoint-initdb.d/prosody_production.sql`

### Upgrade WordPress
- The docker-compose file already has specified to use the latest version of WordPress, so just restart.
  - `docker-compose up -d`

### Upgrade MySQL
- Specify the version of MySQL to use in the docker-compose.yml file.
  - `image: mysql:5.7`
- Then restart Docker Compose
  - `docker-compose up -d`

### Update theme or plugin
To get the updates to the theme and plugin, just pull them down from the GitHub
repo. No need to restart Docker Compose.

- While in the folder for the theme or plugin (ex. /var/www/prosody.lib.virginia.edu/prosody_plugin):
  - `git pull`


## MySQL dump
It may be necessary, or desireable to create a dump of the production (or
development) database. This can be used to seed your development set up, or to
revert the production instance to a known good version. A BASH script in the
'scripts' folder makes this super easy. Just run this from the command line, in
the main project directory (the same level as the 'scripts' folder).
- Double check that the script is executable
- This script will only work if the container is actively running.
- Then run
  - `./scripts/dump-docker-db.sh`

This script will create a new .sql file in the 'initial_sql' folder with the
current date-stamp as the file name. This folder is automatically created when
docker-compose is run. This file can then be used in the docker-compose.yml
file as the initial sql file to seed the database (replace the existing name of
the file on the line that has 'initial_sql', with the version you just
created).



# Development with Docker
Developing the Prosody plugin or theme is easy with Docker. Make a clone of
this repository and the plugins and theme repositories (as shown below), then
just edit the files in the theme or plugin directory. When done making changes,
push them to the GitHub repository.

- Clone this repository
  - `git clone https://github.com/scholarslab/prosody.git prosody`
- Change into the 'prosody' folder.
  - `cd prosody`
- Clone the plugins and theme repos into your working directory
  - `git clone https://github.com/scholarslab/prosody_plugin.git`
  - `git clone https://github.com/scholarslab/prosody_theme.git`
  - `git clone https://github.com/Seravo/wp-custom-bulk-actions.git`
- Create a '.env' file with the following variables
  ```
  MYSQL_ROOT_PASSWORD=some_great_password
  MYSQL_USER=wordpress_user
  MYSQL_PASSWORD=wordpress_password
  MYSQL_DATABASE=wordpress
  WORDPRESS_DB_HOST=db:3306
  WORDPRESS_TABLE_PREFIX=prosody_wp_
  PORTS=80:80
  ```
  - NOTE the following about each line:
    - `MYSQL_DATABASE`, `WORDPRESS_DB_HOST`, `WORDPRESS_TABLE_PREFIX` must be as written. 
    - `PORTS` depends on production or development. Development should have 80 for the first value (left side of colon).
    - The first three lines can be whatever.
- Copy the uploads directory from the old prosody site
  - `scp -r prosody.lib.virginia.edu:/path/to/wp/wp-content/uploads uploads`
- Make a dump of the current prosody database (see above step MySQL dump). 
- Make a folder called 'initial_sql', and put the file in there.
  - Make sure to name it "prosody_production.sql", or change the name in the docker-compose.yml file (noted below).
- Note the 'Dockerfile'. This is needed so that the xsl module is enabled in the WordPress image. This creates a separate docker image that is used instead of the one supplied by WordPress
- Uncomment the 'initial_sql' line in the docker-compose.yml file.
  - `./initial_sql/prosody_production.sql:/docker-entrypoint-initdb.d/prosody_production.sql`
- Start the container with docker-compose
  - `docker-compose up`
- After Docker Compose is running the container and there are no errors, then comment out the line with 'initial_sql' in the docker-compose.yml file.
  - `#./initial_sql/prosody_production.sql:/docker-entrypoint-initdb.d/prosody_production.sql`
- Change your '/etc/hosts' file to direct http://prosody.lib.virginia.edu to your local machine
  - For Mac and Linux
    - Add this line to the '/etc/hosts' file, you will need to be root or use sudo
      - `127.0.0.1 prosody.lib.virginia.edu`
  - For Windows machines (from https://gist.github.com/zenorocha/18b10a14b2deb214dc4ce43a2d2e2992)
    - For Windows 10 and 8
      - Press the Windows key.
      - Type Notepad in the search field.
      - In the search results, right-click Notepad and select Run as administrator.
      - From Notepad, open the following file: c:\Windows\System32\Drivers\etc\hosts
      - Make the necessary changes to the file. Add the line 
        - `127.0.0.1 prosody.lib.virginia.edu`
      - Click File > Save to save your changes.
    - For Windows 7 and Vista
      - Click Start > All Programs > Accessories.
      - Right-click Notepad and select Run as administrator.
      - Click Continue on the Windows needs your permission UAC window.
      - When Notepad opens, click File > Open.
      - In the File name field, type C:\Windows\System32\Drivers\etc\hosts.
      - Click Open.
      - Make the necessary changes to the file. Add the line 
        - `127.0.0.1 prosody.lib.virginia.edu`
      - Click File > Save to save your changes.
    - For Windows NT, Windows 2000, and Windows XP
      - Click Start > All Programs > Accessories > Notepad.
      - Click File > Open.
      - In the File name field, type C:\Windows\System32\Drivers\etc\hosts.
      - Click Open.
      - Make the necessary changes to the file. Add the line 
        - `127.0.0.1 prosody.lib.virginia.edu`
      - Click File > Save to save your changes.
- With the ports set at '80:80' and the change to the /etc/hosts file, the website is viewable at http://prosody.lib.virginia.edu
- When done testing, remove the line from '/etc/hosts' file.


## Docker clean up
It may be necessary to remove the images created by running docker-compose. Docker Compose will create the following images:
- prosody_wp
- wordpress (latest version)
- mysql (version 5.7)

- To fully remove these images, first shut down the containers and remove the local volume:
  - `docker-compose down --volumes`
- Get the list of images with:
  - `docker images`
    ```
    [Results will look like this]
      REPOSITORY          TAG                 IMAGE ID            CREATED             SIZE
      prosody_wp          0.1                 5e42a88dda96        1 hour ago          522MB
      wordpress           latest              652d1ff3db63        1 hour ago          407MB
      mysql               5.7                 0d16d0a97dd1        1 hour ago          372MB

    ```
- Then remove the images (where `<ID>` is the unique IMAGE ID for the prosody_wp, wordpress and mysql images, these should be the most recent three created):
  - `docker rmi <ID> <ID> <ID>`
