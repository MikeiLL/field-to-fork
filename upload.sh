#!/usr/bin/env bash

rsync -avP lib *.php *.css poman:public_html/wp/wp-content/plugins/field-to-fork/
