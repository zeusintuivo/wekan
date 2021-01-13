#!/usr/bin/env bash
#!/bin/bash
#

# cd ..
# exit 0
# firefox -p time &

CWD=$(pwd)
# echo REBUILD
# echo REMOVES DATABASE --CAREFUL 
# rm -rf .meteor/local
# rm -rf .build

meteor update --all-packages
rm -rf node_modules
npm install
export METEOR_ALLOW_SUPERUSER=true
meteor npm install --production --silent
meteor build .build --directory
meteor build .build --server-only --architecture os.linux.x86_64
cp .build/*.tar.gz ./app/bundle.tar.gz
cp .build/*.tar.gz ./meteor/bundle.tar.gz
cp .build/*.tar.gz .meteor/bundle.tar.gz
rm -rf .build/bundle/programs/web.browser.legacy
cd .build/bundle/programs/server
echo ".build/bundle/programs/server"
rm -rf node_modules
npm install
# echo cd ../../../../
cd "${CWD}"

echo RUN 
WITH_API=true RICHER_CARD_COMMENT_EDITOR=false ROOT_URL=http://localhost:4000 meteor run --exclude-archs web.browser.legacy,web.cordova --port 4000
# WITH_API=true RICHER_CARD_COMMENT_EDITOR=false ROOT_URL=https://titra.local meteor run --exclude-archs web.browser.legacy,web.cordova --port 3005
