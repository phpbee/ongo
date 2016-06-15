#!/bin/sh
set -e

l=$1
b=`basename "${l}"`
d=`dirname "${l}"`
td=$d/thumb
if [ ! -d "$td" ]; then
        mkdir -v "$td"
fi
convert "$l" -resize '480000@' -verbose "$l"
convert "$l" -resize '117600@' -verbose "$td/$b"