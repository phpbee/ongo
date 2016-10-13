#!/bin/bash

SAVEIFS=$IFS
IFS=$(echo -en "\n\b")


#echo "INSERT INTO gallery (place_id, photograph_id, description) values ($3, $4,'$(pwd) $0 $@');";

echo "REPLACE INTO photo (gallery_id, src, thumb,ico) VALUES "
FILES=$2/*.jpg
for l in $FILES
do
  b=$(dirname "$l");
  f=$(basename "$l");
  pfx="$1/$b"
  echo "($3,'$pfx/$f','$pfx/thumb/$f','$pfx/ico/$f'),";
done
echo "($3,'','','');"
echo "delete from photo where gallery_id=$3 and src='';"

IFS=$SAVEIFS

