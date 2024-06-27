#!/bin/bash
# Update Composer
composer update

# Define the target file name
TARGET_FILE="herd.php-xdebug.ini"

# Function to find the required paths
find_dynamic_paths() {
  local cacert_path
  local dump_loader_path
  local xdebug_so_path

  # Find the cacert.pem file in the user's Library/Application Support directory
  cacert_path=$(find "$HOME/Library/Application Support/Herd/config/php" -name cacert.pem 2>/dev/null | head -n 1)

  # Find the dump-loader.php file in the Applications directory
  dump_loader_path=$(find /Applications/Herd.app/Contents/Resources/valet -name dump-loader.php 2>/dev/null | head -n 1)

  # Find the xdebug .so file in the Applications directory
  xdebug_so_path=$(find /Applications/Herd.app/Contents/Resources/xdebug -name "xdebug-83-x86.so" 2>/dev/null | head -n 1)

  # Verify that all paths were found
  if [[ -z "$cacert_path" || -z "$dump_loader_path" || -z "$xdebug_so_path" ]]; then
    echo "Error: Could not find all required dynamic paths."
    exit 1
  fi

  # Return the paths
  echo "$cacert_path,$dump_loader_path,$xdebug_so_path"
}

# Check if the file exists
if [ ! -f "$TARGET_FILE" ]; then
  echo "File $TARGET_FILE does not exist. Creating it now..."

  # Find the dynamic paths
  dynamic_paths=$(find_dynamic_paths)
  echo "Dynamic paths output: $dynamic_paths" # Added for debugging

  # Split the dynamic_paths into separate variables
  IFS=',' read -r -a array <<< "$dynamic_paths"
  CACERT_PATH=${array[0]}
  DUMP_LOADER_PATH=${array[1]}
  XDEBUG_SO_PATH=${array[2]}

  # Print captured paths for debugging
  echo "Captured paths:"
  echo "CACERT_PATH: $CACERT_PATH"
  echo "DUMP_LOADER_PATH: $DUMP_LOADER_PATH"
  echo "XDEBUG_SO_PATH: $XDEBUG_SO_PATH"

  # Create the content for the new ini file
  cat <<EOL > "$TARGET_FILE"
curl.cainfo="${CACERT_PATH}"
openssl.cafile="${CACERT_PATH}"
pcre.jit=0
output_buffering=4096

upload_max_filesize=2048M
memory_limit=-1
auto_prepend_file="${DUMP_LOADER_PATH}"

zend_extension="${XDEBUG_SO_PATH}"
xdebug.mode=debug,develop,coverage
EOL

  echo "File $TARGET_FILE created successfully."
else
  echo "File $TARGET_FILE already exists."
fi

# Load the .dev.env file
set -a
source .dev.env 2>/dev/null
set +a

# Provide fallback values if variables are not set
XDEBUG_VERSION="${DEV_XDEBUG_VERSION:-83}"
ARCHITECTURE="${DEV_ARCHITECTURE:-x86}"

# Run the specified command
chmod 755 md.sh
./md.sh
php -c "$TARGET_FILE" vendor/bin/pest --coverage
infection --threads=10 --show-mutations --log-verbosity=all --initial-tests-php-options="-d zend_extension=/Applications/Herd.app/Contents/Resources/xdebug/xdebug-${XDEBUG_VERSION}-${ARCHITECTURE}.so"