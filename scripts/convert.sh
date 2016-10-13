#!/bin/bash

find $1 -mindepth 2 -maxdepth 2 -iname \*.jpg -exec ./convert_800.sh "{}" \;
