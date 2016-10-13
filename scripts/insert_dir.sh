#!/bin/bash

find "$1" -type d  -maxdepth 1 -exec "$1"/insert.sh "{}" \;
