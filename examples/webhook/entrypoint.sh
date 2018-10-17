#!/bin/sh

export HOME=/root-dir
cd $HOME
exec su-exec user php "$@"