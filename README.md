Yii 2 Vue skeleton
------------------
 
[Yii 2 basic](https://github.com/yiisoft/yii2-app-basic) skeleton application with an integrated [Vue](https://cli.vuejs.org/) frontend framework.

# Installation
------------

1. **Clone this project**

    ```
    $ git clone https://github.com/radfuse/yii2-vue-skeleton.git my-project
    ```

2. **Install vendor packages via composer**

    `$ cd my-project`

    `$ composer install`


3. **Install node modules via npm**

    `$ cd vue`
    
    `$ npm install`
    

# Configuration
------------

Edit the file `config/db.php` with actual parameters, for example:

```
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=my_db',
    'username' => 'my-user',
    'password' => 'my-pass',
    'charset' => 'utf8',
];
```

Edit the file `vue/.env` with actual parameters, for example:

```
VUE_APP_API_URL=https://yii2-vue-skeleton.my-page.com/api/
```