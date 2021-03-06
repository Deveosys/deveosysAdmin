# DeveosysAdmin

**DeveosysAdmin** is based on top of EasyAdmin and FOSUserBundle.

It brings boilerplate code for users management and bootstrap 4 integration.

Development in progress...

## Installation

### Packages

Install symfony/templating for FOSUserBundle dependency : 
```
$ composer require symfony/templating
```

Add this to your app/config/config.yml :
```
framework:
	[...]
    templating:
        engines: ['twig']
```

Add DeveosysAdmin Package :
```
$ composer require deveosys/deveosys_admin "dev-master"
```

Activate the bundles in app/AppKernel.php
```
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
        	[...]
            // EasyAdminBundle
            new EasyCorp\Bundle\EasyAdminBundle\EasyAdminBundle(),
            // FOSUserBundle
            new FOS\UserBundle\FOSUserBundle(),
            // DeveosysAdminBundle
            new Deveosys\AdminBundle\DeveosysAdminBundle(),
        ];
    [...]
	}
[...]
}

```

### Routing

Import routing in your app/config/routing.yml :
>It already imports routes from EasyAdminBundle and FOSUserBundle

```
deveosys_admin:
    resource: "@DeveosysAdminBundle/Resources/config/routing.yml"
    prefix:   /
```

### Configuration

Create a deveosysAdmin.yml file in app/config :
>or paste the following directly in app/config/config.yml

```
easy_admin:
    site_name: 'Deveosys <small>Admin</small>'
    formats:
        date:     'd/m/Y'
    design:
        templates:
            layout: 'DeveosysAdminBundle:easy_admin:layout.html.twig'
            menu: 'DeveosysAdminBundle:easy_admin:menu.html.twig'
            edit: 'DeveosysAdminBundle:easy_admin:edit.html.twig'
            new: 'DeveosysAdminBundle:easy_admin:new.html.twig'
            list: 'DeveosysAdminBundle:easy_admin:list.html.twig'
            field_toggle: 'DeveosysAdminBundle:easy_admin:field_toggle.html.twig'
        assets:
            css:
                - 'bundles/deveosysadmin/dist/global.css'
            js:
                - 'bundles/deveosysadmin/dist/app.js'
        menu:
            - { label: 'Dashboard', route: 'admin_dashboard', default: true, icon: 'tachometer' }
            - { entity: 'User', icon: 'users' }
    entities:
        User:
            class: Deveosys\AdminBundle\Entity\User
            label: users
            list:
                title: users
                help: user.management
                sort: 'id'
                translation_domain: 'FOSUserBundle'
                fields:
                    - username
                    - { property: 'email', type: 'email' }
                    - enabled
                    - lastLogin
            form:
                fields:
                    - username
                    - email
                    # if administrators are allowed to edit users' passwords and roles, add this:
                    - { property: 'plainPassword', type: 'text', type_options: { required: false } }
                    - { property: 'roles', type: 'choice', type_options: { multiple: true, choices: { 'User': 'ROLE_USER', 'Admin': 'ROLE_ADMIN' } } }
            new:
                form_options: { validation_groups: ['Profile', 'Registration'] }
            edit:
                form_options: { validation_groups: ['Profile'] }

fos_user:
    db_driver: orm # other valid values are 'mongodb' and 'couchdb'
    firewall_name: main
    user_class: Deveosys\AdminBundle\Entity\User
    from_email:
        address: "%mailer_user%"
        sender_name: "%mailer_user%"

deveosys_admin:
    login: ~
```

And import it in your app/config/config.yml : 
```
imports:
    [...]
    - { resource: deveosysAdmin.yml }
```

Edit you app/config/security.yml file as you want but there is an example :
```
security:
    encoders:
        FOS\UserBundle\Model\UserInterface: bcrypt

    role_hierarchy:
        ROLE_ADMIN:       ROLE_USER
        ROLE_SUPER_ADMIN: ROLE_ADMIN

    providers:
        fos_userbundle:
            id: fos_user.user_provider.username

    firewalls:
        main:
            logout_on_user_change: true
            pattern: ^/
            form_login:
                provider: fos_userbundle
                csrf_token_generator: security.csrf.token_manager

            logout:       true
            anonymous:    true
            # pattern:  ^/(_(profiler|wdt)|css|images|js)/
            # security: false

    access_control:
        - { path: ^/login$, role: IS_AUTHENTICATED_ANONYMOUSLY }
        - { path: ^/register, role: IS_AUTHENTICATED_ANONYMOUSLY }
        - { path: ^/resetting, role: IS_AUTHENTICATED_ANONYMOUSLY }
        - { path: ^/admin/, role: ROLE_ADMIN }
```

Set the mailer_user parameter in app/config/parameter.yml
```
mailer_user: your@mail.com
```

Activate translation in app/config/config.yml :
```
framework:
    ...
    translator: { fallbacks: [ '%locale%' ] }
```

### Assets

Install assets : 
```
php bin/console assets:install
``` 
### Update database

We recommend that you use DoctrineMigrationsBundle : 
```
php bin/console doctrine:migrations:diff
php bin/console doctrine:migrations:migrate
```
Otherwise : 
```
php bin/console doctrine:schema:update --force
```

## FOSUserBundle Login and Registration templates overriding

So far, standard FOSUserBundle templates are used for these pages. DeveosysAdminBundle can provide improved templates integrating bootstrap 4 that you can easily modify at your convenience in app/Resources/FOSUserBundle.

To generate it : 

```
php bin/console deveosys:install:fosuser_templates
``` 

## License

This software is published under the [MIT License](LICENSE.md)

<!-- [1]: https://symfony.com/doc/current/bundles/EasyAdminBundle/book/installation.html
[2]: https://symfony.com/doc/current/bundles/EasyAdminBundle/book/your-first-backend.html
[3]: https://symfony.com/doc/current/bundles/EasyAdminBundle
 -->