# Installation
Run `composer install` from the *root* directory to install the roots/bedrock boilerplate and all dependencies. These dependencies are managed in the composer.json file. For more info see the Bedrock documentation.

https://roots.io/bedrock/docs/installing-bedrock/

# Local Environment
A local LAMP server is required for local development (MAMP etc). Create a virtual host and point the document root to path/to/site/web/.
Create a MYSQL database and configure it's options in the `.env` file in the root directory. Each environment will have it's own `.env` file which is *not* tracked in the git repo.

# Development
To start the development process, change directory to `/web/app/themes/{theme_name}` and run `npm install`
Once the dependencies are installed, run `gulp`.

# Deployment
When deploying `composer install` need to be ran as the `vendor` folder is not tracked in git.