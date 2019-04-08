#!/usr/bin/env bash

# Run this script to make a dump of the MySQL database.
#
# $> ./dump-database.sh container_name
#
# This is helpful if the container needs to be restarted, and if for some
# reason you want to reload the database on restart. Run this script first to
# make a current copy of the database, then uncomment the line in the
# docker-compose.yml file to allow the .sql file to be loaded when the
# container is run. Remember to change the filename in the docker-compose.yml
# file to match the .sql file you would like to load.

if [ -f .env ]; then

  # Get environment variables
  set -a
  . .env
  set +a

  # Get the current Year Month Day and seconds since Epoch to use as file name
  DATE=`date '+%Y-%m-%d-%s'`
  docker exec $1 sh -c 'exec mysqldump -uroot -p"$MYSQL_ROOT_PASSWORD" $MYSQL_DATABASE' > initial_sql/${DATE}.sql

else

  echo "No .env file found."

fi

