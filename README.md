Yii 2 Vue skeleton
------------------
 
[Yii 2 basic](https://github.com/yiisoft/yii2-app-basic) skeleton application with an integrated [Vue](https://cli.vuejs.org/) frontend framework.

Requirements
============
These are the **minimum** requirements to build and run this project.

* PHP 5.4.0.
* [Node](https://nodejs.org) v8.16.0
* [NPM](https://www.npmjs.com) 6.4.1
* [Composer](https://getcomposer.org/)
* [@vue/cli](https://cli.vuejs.org/) v3.9.1 (also works with v4.0.0+)

> Alternatively you can use [Yarn](https://yarnpkg.com) instead of Node and NPM.

Installation
============

1. Clone this project

    ```bash
    $ git clone https://github.com/radfuse/yii2-vue-skeleton.git my-project
    ```

2. Install vendor packages via composer

    ```bash
    $ cd my-project    
    $ composer install
    ```
    
    > Alternatively you can use `php composer.phar install` if you only have the phar file.


3. Install node modules via npm

    ```bash
    $ cd vue    
    $ npm install
    ```    

Configuration
============

### Database    
    
Edit the `config/db.php` file with actual parameters, for example:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=my_db',
    'username' => 'my-user',
    'password' => 'my-pass',
    'charset' => 'utf8',
];
```

### API URL    
Edit the `vue/.env` file with actual parameters, for example:

```
VUE_APP_API_URL=https://yii2-vue-skeleton.my-page.com/api/
```

### Parameters

Edit the `config/params.php` file for more configuration. You can change the parameters for:

* Access token expiration interval (in seconds)
** with the `access-token-expire` parameter, where 0 means that it won't expire
* Refresh token expiration interval (in seconds)
** with the `refresh-token-expire` parameter, where 0 means that it won't expire
* The port of the Vue application (if runned with Vue CLI)
** with the `vue-port` parameter


Usage
============

### Running with Vue CLI

From the root directory you can start the Vue CLI service to run and live-update your Vue frontend.

```bash
$ cd vue
$ npm run serve
```

Then the CLI must build and serve your app, so you can visit http://localhost:8080 (by default) to see the application running.

### Building with Vue CLI

If you want to deploy your frontend and not serving it via the Vue CLI service, you can run the build command, so the webpack can pack it into your `frontend` folder.

```bash
$ cd vue
$ npm run build
```

After that, the built version of your Vue app must be in the `frontend` folder, and by the `.htaccess` file the application's base URL will redirect the request to that subfolder, therefore serving it as the webapp itself.
