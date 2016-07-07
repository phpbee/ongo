#!/bin/bash


set -ex

r=alexk7898
p=ongo

b=${GIT_BRANCH:=`git rev-parse --abbrev-ref HEAD`}
c=${GIT_TAG_NAME:=${GIT_COMMIT:=`git describe --tags`}}

IFS='/' read -a arr <<< "$b"
if [[ ${arr[1]} ]]; then
    b=${arr[1]}
fi

if [ -z ${GIT_BRANCH} ]; then
  if [[ -n $(git status -s) ]]; then
    echo >&2 "You have uncommited changes in repo, will break the build"
    git status -s
#    exit 4
  fi
fi

tag_api="$r/$p:api-$b"
tag_www="$r/$p:www-$b"

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

cd api
  docker build -f Dockerfile -t $tag_api .
cd ..

docker push $tag_www
docker push $tag_api

ssh zaza@ongophotos.com 'docker-compose  -f ongo.yml pull && docker-compose  -f ongo.yml up -d'

#if [ "$b" == "master" ]; then
#    docker tag $tag_www $tag_www_version
#    tag_www_version="$r/$p:www-$c"
#    docker tag $tag_api $tag_api_version
#    tag_api_version="$r/$p:www-$c"
#    docker push $tag_www_version $tag_api_version
#fi
