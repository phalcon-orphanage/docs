#!/bin/bash

# Pull from github
git pull

# Clear cache
./phalcon -clear-cache
./phalcon -fetch-contributors