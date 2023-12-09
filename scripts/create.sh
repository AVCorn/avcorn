#!/bin/bash

SCRIPT_DIRECTORY="$(dirname $(realpath "$0"))"
bash "$SCRIPT_DIRECTORY/create/$1.sh"