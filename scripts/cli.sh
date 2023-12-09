#!/bin/bash

echo 'AVCorn CLI - "The Nut Does Not Fall Far From The Tree!"';

SCRIPT_DIRECTORY="$(dirname $(realpath "$0"))"
. $SCRIPT_DIRECTORY/$1.sh $2