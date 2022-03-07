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
- Pull in the latest image 
  - `sudo docker-compose build --pull`
- then restart.
  - `docker-compose up -d`

### Upgrade MySQL
- Specify the version of MySQL to use in the docker-compose.yml file.
  - `image: mysql:5.7`
- Then restart Docker Compose
  - `docker-compose up -d`
- Log in to the WordPress admin page and run any updates if prompted.

### Update theme or plugin
To get the updates to the theme and plugin, just pull them down from the GitHub
repo. No need to restart Docker Compose.

- While in the folder for the theme or plugin (ex. /var/www/prosody.lib.virginia.edu/prosody_plugin):
  - `git pull`
- Log in to the WordPress admin page and run any updates if prompted.


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

## Requirements
You'll need to create accounts and install these software programs before getting started.

- GitHub account
- Docker Desktop (requires creating an account)
  - [Install Docker Desktop](https://www.docker.com/products/docker-desktop)
- A text editor (ex. VS Code)
  - [VS Code](https://code.visualstudio.com/)

## Setting Up the Environment
Create the local development environment. You'll be creating a local copy of the website. Docker acts as the web and MySQL server. VS Code is the software used to edit the files. GitHub is where the code is stored.

### Copy the Code
Open VS Code. Open the Terminal in VS Code by going to the Terminal menu and New Terminal (or Command-J in Mac, and Ctrl+` in Windows)
- Clone this repository. In the terminal type this out (or copy and paste) then press return or enter key.
  - `git clone https://github.com/scholarslab/prosody.git prosody`
- Change into the 'prosody' folder.
  - `cd prosody`
- Clone the plugins and theme repos into your working directory
  - `git clone https://github.com/scholarslab/prosody_plugin.git`
  - `git clone https://github.com/scholarslab/prosody_theme.git`
  - `git clone https://github.com/Seravo/wp-custom-bulk-actions.git`
- Create a new `.env` file with the following variables
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
- Note the 'Dockerfile'. This is needed so that the xsl module is enabled in the WordPress image. This creates a separate docker image that is used instead of the one supplied by WordPress

### Get the live data
The following steps require access to the live server. If you don't have access to the server, you'll need to get the `uploads` folder and a copy of the database from a Scholars' Lab developer. 

#### Uploads folder
The `uploads` folder goes in the same directory (on the same level) as the prosody_theme and prosody_plugin folders.

- Copy the uploads directory from the old prosody site. This assumes you have access to the server where the live website lives. If you do not, ask one of the Scholars' Lab developers for help.
  - `scp -r prosody.lib.virginia.edu:/path/to/wp/wp-content/uploads/* uploads/`

#### Database
The database file (database_from_production.sql) goes in the same folder as the docker-compose-dev.yml file (on the same level).

- Make a dump of the current prosody database (see above step [MySQL dump](#mysql-dump)).
  - Make sure to rename the sql file you get from the live server to "database_from_production.sql".
- You only need to do this step the very first time you start Docker. Uncomment the line in the docker-compose-dev.yml file that looks like this:
  - `./database_from_production.sql:/docker-entrypoint-initdb.d/prosody_production.sql`
  - That section of the file should look like this:
    ```
    prosody_db:
      image: "mysql:5.7"
      container_name: "prosody_db"
      depends_on:
        - "traefik"
      volumes:
        - "./prosody_db_data:/var/lib/mysql"
        # Only use this line for the initial start up (the very first time docker-compose is run
        - ./database_from_production.sql:/docker-entrypoint-initdb.d/prosody_production.sql
      environment:
        MYSQL_ROOT_PASSWORD: ${MYSQL_ROOT_PASSWORD}
        MYSQL_DATABASE: ${MYSQL_DATABASE}
        MYSQL_USER: ${MYSQL_USER}
        MYSQL_PASSWORD: ${MYSQL_PASSWORD}
      labels:
        - "traefik.enable=false"
    ```

### Start up Docker
- Create the Docker network
  - `docker network create thenetwork `

- Start the container with docker-compose
  - `docker compose -f docker-compose-dev.yml up`

- After Docker Compose is running the container and there are no errors, then comment the line with 'database_from_production.sql' in the docker-compose-dev.yml file.
  - `#./database_from_production.sql:/docker-entrypoint-initdb.d/prosody_production.sql`

### Trick your computer
This next step will trick your computer into thinking that the website URL http://prosody.lib.virginia.edu lives on your computer instead of the real web server. You will need to make this change only while you are testing on your computer. 

After you are done testing on your computer, you will need to undo this change so that your computer can see the real website.

- Change your '/etc/hosts' file to direct http://prosody.lib.virginia.edu to your local machine

<details>
  <summary>For Mac and Linux</summary>

  - Add this line to the '/etc/hosts' file, you will need to be root or use sudo
    - `127.0.0.1 prosody.lib.virginia.edu`
    - In the terminal in VS Code type in the following command (this requires you to have your computer set up to open VS Code with the command `code`. Steps for [Mac](https://code.visualstudio.com/docs/setup/mac#_launching-from-the-command-line).)
      - `sudo code /etc/hosts` 
        - You will need to type in the password you use for the user account for your computer. For security reasons, you don't see the characters (or a *) when you are typing your password.
    - Add the line above to the bottom of the file. Save the file. You can leave the file open as a reminder to comment the line when you are done testing.
</details>

<details>
<summary>For Windows Computers</summary>

  - (from https://gist.github.com/zenorocha/18b10a14b2deb214dc4ce43a2d2e2992)
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
</details>

  - Save the file. You can leave the file open as a reminder to comment the line when you are done testing.
    - Your file will look something like this:

      ```
        ##
        # Host Database
        #
        # localhost is used to configure the loopback interface
        # when the system is booting.  Do not change this entry.
        ##
        127.0.0.1	localhost

        # Added by Docker Desktop
        # To allow the same kube context to work on the host and the container:
        127.0.0.1 kubernetes.docker.internal
        # End of section
        #

        127.0.0.1 prosody.lib.virginia.edu
      ```

### View the testing site
With the Docker running, and the change to the /etc/hosts file, the website is viewable at http://prosody.lib.virginia.edu
  - It might be best to use two different browsers, one for accessing your new local testing site, and one for the live site. The testing site needs to use the non-encrypted 'http' protocol, while the live site uses the encrypted 'https' protocol. Because of browser caching, using the same browser for testing and the live site could cause issues.
  - If you get an error when trying to load the website in your browser, double check that you are using 'http' and not 'https' in the URL.
- REMEMBER: When done testing, comment the line from '/etc/hosts' file so that you can see the live site. With this line uncommented, you can only see the testing site on your computer.


## Saving Changes to GitHub
After making changes to the theme or plugin, you will push those changes to the GitHub repository.

VS Code has Git compatibility baked into it. On the left-most sidebar (the Activity Bar), look for the Git icon. Select that to see the files that have changes. Click the + to add them to 'staging'. After adding all files, type a message in the message box. Then click the check mark above to commit the changes. Then click the three vertical dots menu and select 'Push' to push the changes to the GitHub repo.


## Workflow

1. Before you start changing files, make sure you have the latest version from GitHub. 'Pull' from GitHub
2. Make changes to your files.
3. Test in the local development environment. (change /etc/hosts file)
4. Save changes. 
5. Stage files. 
6. Commit changes. 
7. Push changes to GitHub.
8. Stop local development (change /etc/hosts file)
9. Check live site


# Docker clean up
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
