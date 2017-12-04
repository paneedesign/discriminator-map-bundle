Pane e Design - Discriminator Map Bundle
========================================

Dynamic DiscriminatorMap extender for Symfony with Doctrine ORM.

Installation
============

Step 1: Download the Bundle
---------------------------

Install via Composer:

```bash
composer require paneedesign/discriminator-map-bundle
```

Or add this to your composer.json and run `composer update`:

```bash
"require": {
    "paneedesign/discriminator-map-bundle": "^1.0"
}
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Step 2: Enable the Bundle
-------------------------

Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...

            new \PaneeDesign\DiscriminatorMapBundle\PedDiscriminatorMapBundle(),
        );

        // ...
    }

    // ...
}
```

Step 3: Configurations
----------------------

Add configuration:

```yml
// app/config/config.yml
//...
ped_discriminator_map:
    user:
        entity: PaneeDesign\UserBundle\Entity\User
        children:
            admin:    AppBundle\Entity\Admin
            owner:    AppBundle\Entity\Owner
            customer: AppBundle\Entity\Customer
            ...
```

where parent class implement this annotations:

```php
/**
 * @ORM\Entity()
 * @ORM\Table(name="user")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="user_grant", type="string", length="10")
 * @ORM\DiscriminatorMap({"user" = "User"})
 */
abstract class User
{
    ...
}
```

and children class these one:

```php
/**
 * Class Admin
 *
 * @package AppBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="user_admin")
 */
class Admin extends User
{
    ...
}
```

```php
/**
 * Class Owner
 *
 * @package AppBundle\Entity
 * @ORM\Entity()
 * @ORM\Table(name="user_owner")
 */
class Owner
{
    ...
}
```

```php
/**
 * Class Customer
 *
 * @package AppBundle\Entity
 * @ORM\Entity()
 * @ORM\Table(name="user_customer")
 */
class Customer
{
    ...
}
```