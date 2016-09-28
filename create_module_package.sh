#!/bin/bash

# script used to create the ZIP archive to be downloaded in prestashop
rm -f paygent.zip
mkdir paygent
cp *.php paygent/
cp *.gif paygent/
cp -R controllers paygent/
zip -r paygent.zip paygent/*
rm -rf paygent
