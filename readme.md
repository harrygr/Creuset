# Creuset

Creuset is a powerful cms and blogging platform built in Laravel. It is intended to use modern design patterns and have a structure that allows it to be flexible to the extent it could be easily extended or adapted; such as, for example, be turned into an ecommerce solution.

## Features

- Testing using PHPUnit, including Laravel's built-in integration testing
- Extensible taxonomies; currently used for _categories_ and _tags_ but can be expanded to others.
- Repository design pattern with decorators for caching, logging etc.
- Uses elixir for asset compilation, browserify.
- Full-featured admin panel with Vue.js components

## Usage

1. Clone the repo to your working directory
2. Run `composer install` to install dependencies
3. Set your environment variables, including database config. (see `.env.example` for examples)
4. Serve it up and enjoy

## Contributing

This project was started partly as a learning exercise, but the aim is to make something usable nonetheless. If you want to contribute feel free to submit a pull request or offer suggestions/improvements by submitting an issue.

PSR-2 code style should be used throughout.

### Front End

Creuset uses npm modules with browserify for front-end scripts. You should install the node dependencies with `npm install` before making changes.

Styles are compiled from LESS. Some bower dependencies are used (install them with `bower install`).

The whole lot can then be recompiled by running `gulp`.


