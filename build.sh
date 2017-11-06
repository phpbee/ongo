#!/bin/bash

set -ex

r=alexk7898
p=ongo

if [ -z ${GIT_BRANCH} ]; then
  if [[ -n $(git status -s) ]]; then
    echo >&2 "You have uncommited changes in repo, will break the build"
    git status -s

        while true; do
            read -p "Do you wish to continue?" yn
            case $yn in
                [Yy]* ) break;;
                [Nn]* ) exit;;
                * ) echo "Please answer yes or no.";;
            esac
        done
  fi
fi

b=${GIT_BRANCH:=`git rev-parse --abbrev-ref HEAD`}

IFS='/' read -a arr <<< "$b"
if [[ ${arr[1]} ]]; then
    b=${arr[1]}
fi

if [ "master" != "${b}" ]
then
    b="develop"
fi

tag_api="$r/$p:api-$b"
tag_www="$r/$p:www-$b"

cd api
  php composer.phar install
  docker build -f Dockerfile -t $tag_api .
cd ..

cd www
  if [[ -d dist ]]; then rm -r dist; fi

  npm install

  cp app/scripts/services/config.master.js app/scripts/services/config.js

  ./node_modules/bower/bin/bower install
  ./node_modules/grunt-cli/bin/grunt test  || { echo 'grunt test failed' ; exit 1; }
  ./node_modules/grunt-cli/bin/grunt build || { echo 'grunt build failed' ; exit 2; }

  cp app/scripts/services/config.local.js app/scripts/services/config.js

  docker build -t $tag_www .

cd ..

docker push $tag_www
docker push $tag_api

ssh zaza@ongophotos.com 'docker-compose  -f ongo.yml pull && docker-compose  -f ongo.yml up -d'