[![Build Status](https://travis-ci.org/harrygr/Creuset.svg?branch=master)](https://travis-ci.org/harrygr/Creuset) 
[![StyleCI](https://styleci.io/repos/29702560/shield)](https://styleci.io/repos/29702560)

# Creuset

Creuset is a powerful ecommerce platform built in Laravel. It is intended to use modern design patterns and have a structure that allows it to be flexible to the extent it could be easily extended or adapted.

## Features

- Testing using PHPUnit, including Laravel's built-in integration testing
- Extensible taxonomies; currently used for _categories_ and _tags_ but can be expanded to others.
- Repository design pattern with decorators for caching, logging etc.
- Uses elixir for asset compilation, browserify.
- Full-featured admin panel with Vue.js components, using [AdminLTE theme][1].

## Usage

1. Clone the repo to your working directory
2. Run `composer install` to install dependencies
3. Set your environment variables, including database config. (see `.env.example` for examples)
4. Serve it up and enjoy

## Contributing

Development is by Git Flow. To add a feature contribute create a branch from the dev branch called `feature/<feature-name>` and pull request back to the dev branch. Small bugfixes and tweaks can be merged straight to master.

All the tests should pass before trying to merge. This is checked using Travis. 

PSR-2 code style should be used throughout. This is auto-checked with StyleCI

### Front End

Creuset uses npm modules with browserify for front-end scripts. Vue components are used and compiled with vueify. You should install the node dependencies with `npm install` before making changes.

Styles are compiled from SASS. Some bower dependencies are used (install them with `bower install`).

The whole lot can then be recompiled by running `gulp`.


[1]: https://almsaeedstudio.com/

