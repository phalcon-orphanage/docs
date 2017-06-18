#!/bin/bash

# Pull from github
git pull

# Clear cache
./phalcon -clear-cache

# Clear the repo folder
rm -fR ./storage/repo/

# Re-clone the cphalcon project in the folder
mkdir ./storage/repo/
cd ./storage/repo/
git clone https://github.com/phalcon/cphalcon --depth=1 .
cd ../../
