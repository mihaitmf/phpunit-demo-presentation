#!/usr/bin/env bash

PROJECT_DIR=${1}
SHELL_SCRIPTS_DIR="${PROJECT_DIR}/${2}"

echo "Install commonly used packages"
apt update >/dev/null
apt install -y software-properties-common build-essential htop vim curl net-tools unzip >/dev/null

echo "Running install-php.sh"
${SHELL_SCRIPTS_DIR}/install-php.sh
test $? -ne 0 && exit 1 # If last command returned error (non zero exit code), exit this script with error also

echo "Running install-composer.sh"
${SHELL_SCRIPTS_DIR}/install-composer.sh
test $? -ne 0 && exit 1 # If last command returned error (non zero exit code), exit this script with error also

# set working directory after vagrant ssh
echo "cd $PROJECT_DIR" >> /home/vagrant/.bashrc

exit 0
