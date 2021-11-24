# Texterify WordPress Plugin

[![Build Status](https://travis-ci.org/texterify/texterify-wordpress.svg?branch=master)](https://travis-ci.org/texterify/texterify-wordpress) [![License](https://img.shields.io/github/license/texterify/texterify-wordpress.svg)](https://img.shields.io/github/license/texterify/texterify-wordpress.svg) [![Open Issues](https://img.shields.io/github/issues-raw/texterify/texterify-wordpress.svg)](https://img.shields.io/github/issues-raw/texterify/texterify-wordpress.svg)

**Official VSC extension to interact with Texterify.**

This extension allows you to add keys and download your translations without leaving your editor.

For more information about Texterify visit https://github.com/texterify/texterify.

## Releasing a new version

- Create a new tag in the format `vX.Y.Z`
- Push the tag
- Create a new folder in the WordPress SVN repository under `tags` with the name `X.Y.Z`
- Go to the newly created folder and run `git clone --single-branch --branch vX.Y.Z git@github.com:texterify/texterify-wordpress.git . && rm -rf .git`
- Change the version in the `README.txt` to `X.Y.Z`
- Commit and push the changes via SVN

## Contributing

Want to help build Texterify VSC Extension?

We are happy about every help.
