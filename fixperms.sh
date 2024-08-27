#!/bin/bash

# Directory where the .php files are located
TARGET_DIR=~/public_html

# Set ACL permissions for the directory
echo "Setting ACL permissions..."
nfs4_setfacl -R -a A::www-mids@academy.usna.edu:RWX "$TARGET_DIR"

# Apply chmod 777 to all .php files
echo "Setting chmod 777 for all .php files..."
find "$TARGET_DIR" -type f -name "*.php" -exec chmod 777 {} +

echo "Script execution completed."