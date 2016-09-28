#!/bin/bash

# script used to create the ZIP archive to be downloaded in prestashop

mkdir paygent
cp *.php paygent/
cp *.gif paygent/
zip paygent.zip paygent
rm -rf paygent
