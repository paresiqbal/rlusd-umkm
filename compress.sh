#!/bin/bash

npm install

npm run build

php ./move_manifest.php

# Set the backup timestamp

# Define the list of folders and files to compress
BACKUP_ITEMS=(
    "app"
    "config"
    "database"
    "resources"
    "views"
    "routes"
    "package-lock.json"
    "package.json"
    "vendor"
)

# Create the backup filename
BACKUP_FILENAME="project_deploy.zip"

# Compress the specified folders and files
zip -r "$BACKUP_FILENAME" "${BACKUP_ITEMS[@]}"

echo "Backup created: $BACKUP_FILENAME"

#==============================================================================
# Compress build folder
BUILD_COMPRESS_FILENAME="build_deploy.zip"
zip -r "$BUILD_COMPRESS_FILENAME" "public/build"

echo "Build folder compressed: $BUILD_COMPRESS_FILENAME"

# Compress public assets folder
ASSETS_COMPRESS_FILENAME="public_assets_deploy.zip"
zip -r "$ASSETS_COMPRESS_FILENAME" "public/assets"

echo "Public assets compressed: $ASSETS_COMPRESS_FILENAME"
