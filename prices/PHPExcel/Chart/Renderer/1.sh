#!/bin/sh
svn status | grep -e '^A'|cut -c 7-
# sed 's/\s{2,}/:/'
#| awk  'BEGIN {FS="  "};{print $2}'