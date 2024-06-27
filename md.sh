#!/bin/bash
# Update Composer
composer update

vendor/bin/phpmd src text cleancode,codesize,controversial,design,naming,unusedcode