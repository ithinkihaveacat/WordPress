#!/usr/bin/env bash

pushd ../wp-content/themes/twentynineteen
npm install && npm run build:style
popd

rm -rf pkg
mkdir -p pkg/beebo

( echo "@charset 'UTF-8'" ; echo "/*" ; echo "Theme Name: Beebo" ; echo "Template: twentynineteen" ; echo "*/" ; cat ../wp-content/themes/twentynineteen/style.css | grep -v "^@charset" ) > pkg/beebo/style.css
cp src/functions.php pkg/beebo

rm -rf beebo.zip

pushd pkg
zip -r ../beebo beebo
popd
