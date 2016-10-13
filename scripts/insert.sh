#!/bin/bash

SAVEIFS=$IFS
IFS=$(echo -en "\n\b")

DIRS=$(find "$1" -maxdepth 1 -mindepth 1 -type d)

for d in $DIRS
do
  # set me

  echo "INSERT INTO gallery (place_id, photograph_id, description) values ($2, $3,'$d');";

  echo "INSERT INTO photo (gallery_id, src, thumb) VALUES "
  FILES=$d/*.jpg
  for l in $FILES
  do
    b=$(dirname "$l");
    f=$(basename "$l");
    echo "(LAST_INSERT_ID(),'http://$l','http://$b/thumb/$f'),";
  done
  echo "(LAST_INSERT_ID(),'','');"
  echo "delete from photo where src='';"
done

IFS=$SAVEIFS
