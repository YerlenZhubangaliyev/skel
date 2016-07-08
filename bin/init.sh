#!/usr/bin/env bash

source "$(dirname ${BASH_SOURCE[0]})/variables.sh"

cd ${DIR_ROOT}

# Removing node_modules directories if exists
rm -fr _skel/static/node_modules
rm -fr static/node_modules

# Update submodules
git submodule foreach git pull origin master

# Create necessary directories
mkdir -p cache/view
mkdir -p data/deploy
mkdir -p data/db/migrations
mkdir -p data/db/seeds
mkdir -p public_html/static
mkdir -p bin
mkdir -p tmp
mkdir -p logs
mkdir -p static
mkdir -p src/App/Applications/Frontend
mkdir -p src/App/Applications/Frontend/Modules
mkdir -p src/App/Applications/Frontend/View
mkdir -p src/App/Applications/Frontend/Config
mkdir -p src/App/Applications/Cli
mkdir -p src/App/Applications/Cli/Modules
mkdir -p src/App/Applications/Cli/Config

# Make symbolic link public for public_html
ln -s public_html public

# Create .gitkeep files
touch cache/view/.gitkeep
touch public_html/static/.gitkeep
touch data/db/migrations/.gitkeep
touch data/db/seeds/.gitkeep
touch tmp/.gitkeep
touch logs/.gitkeep

# Copy necessary files
cp _skel/.gitignore .
cp _skel/composer.json .
cp _skel/static/package.json static/
cp -R _skel/static/application static/
cp _skel/data/index/cli.php bin/index.php
cp _skel/data/index/public.php public_html/index.php
cp _skel/data/index/.htaccess public_html/.htaccess
cp -R _skel/src/App/Applications/Frontend/Config src/App/Applications/Frontend/Config
cp -R _skel/src/App/Applications/Frontend/Modules src/App/Applications/Frontend/Modules
cp -R _skel/src/App/Applications/Frontend/View src/App/Applications/Frontend/View
cp -R _skel/src/App/Applications/Cli/Config src/App/Applications/Cli/Config
cp -R _skel/src/App/Applications/Cli/Modules src/App/Applications/Cli/Modules
cp -R _skel/src/App/Model src/App/
cp -R _skel/data/locale data/
cp -R _skel/bin/variables-*.sh bin/
cp -R _skel/data/deploy/exclude.txt data/deploy/
cp -R _skel/data/deploy/includes.txt data/deploy/

# Run composer install
composer install

# Initialize static build system
cd _skel/static
npm install
cp -R node_modules ../../static/
gulp --app="frontend" --mod="main" --env="${ENV}"
gulp --app="frontend" --mod="admin" --env="${ENV}"
cd ${DIR_ROOT}

# Adding root directory to git
git add . && echo "Now you can make a first commit"
