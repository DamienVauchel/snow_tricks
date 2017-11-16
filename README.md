# Snow Tricks

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/40d805a5-a174-476f-9ec6-2447ccdb5623/big.png)](https://insight.sensiolabs.com/projects/40d805a5-a174-476f-9ec6-2447ccdb5623)
Welcome on the Snow Tricks app GitHub. A **Symfony 3.3** project.

## General context

This project is linked to the OpenClassRooms DA PHP/Symfony's studies. It is the 6th project in which it is asked to create a community website called SnowTricks. This is the first Symfony project.

Visitors can't write or edit tricks but can sign up.

When logged, they can write new tricks, comments and edit/delete tricks. Multi Upload is enabled for images on tricks and embed links can be pasted in the description.

If you have admin role, you can add and delete categories too and delete comments to moderate the discusses.

## Prerequisite

* PHP 7
* MySQL
* Apache or IIS depend of your OS

Easier: You can download MAMP, WAMP or XAMPP depend of your OS
* Composer for **Symfony 3.3** and bundles installations

## Add-ons

* Bootstrap
* jQuery
* Font Awesome
* Google Fonts: *Lobster Two* and *Rubik*

## ORM
Doctrine

## Bundles

* Twig
* FOS UserBundle
* CKEditor

## Installation

Download project or clone it in the htdocs or www depend of your OS

* If you are using LAMPP on Linux, check your permissions: Go to /opt/lampp/htdocs/ open a bash and type:

        $  sudo ls -l
    Change permissions for everybody to be able to update informations in every repository's folders.

1. **Symfony 3.3 and bundles installations** Open bash in folder and type:

        composer update
        
    Then, type:
        
        php bin/console assets:install web
        
2. **Database creation** Type:

        php bin/console doctrine:database:create
        
    Then
    
        php bin/console doctrine:schema:update --force
        
3. **Admin creation** Type:

        php bin/console fos:user:create yourusername --super-admin
        
    *For example if you wanna be called "admin"*
    
        php bin/console fos:user:create admin --super-admin
        
4. **Example Datas in database** Type:

        php bin/console st:datas

Now, you can go on the URL:

[http://localhost/snow_tricks/web](http://localhost/snow_tricks/web) (if you put the folder on your apache root)

And enjoy :)

If you have any question, you can contact me

Thanks!