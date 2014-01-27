.. contents:: Table of Contents

About LyraAdminBundle
=====================

LyraAdminBundle consists of a set of **Twig** templates, a base controller
for CRUD actions and some 'renderer' services to simplify the creation of a
backend area powered by **jQuery** and **jQuery UI** widgets.

This bundle is being developed to provide a common backend interface to all
bundles that make part of **Lyra CMS**, however it can also be used independently
from the CMS as a standalone standard Symfony2 bundle.

This is a work in progress and documentation is still incomplete, however many
features already work and it should be possible to successfully follow the basic
``Getting started`` tutorial you will find below.

If you test the bundle and find errors please use the GitHub issue tracker
to report them. Suggestions are also welcome.

Note
====

Former symfony users will notice quite a few similarities between this bundle
and the symfony 1.x *Admin Generator*: the backend area is organized in a
similar way and offers the same kind of *views*.

1.  **List view**

    This view displays a set of records in a grid layout with sortable columns and
    pagination. From the list view you can perform different *actions*.

    *   **List actions**: ``new`` is the default list action.

    *   **Object actions**: these actions always affects a single record displayed
        in a grid row. Default object actions are ``show``, ``edit`` and ``delete``.

    *   **Batch actions**: these actions affects multiple records selected with
        the grid *check boxes*. Default batch actions is ``delete``.

2.  **Form view**

    This view displays the form to insert and edit a record. Form fields can be
    ordered and grouped in *panels*. Separate configuration options are available
    for ``new`` and ``edit`` form.

----

That being said, there are important differences between LyraAdminBundle and
the symfony *Admin Generator*.

*   This bundle is not a **code generator**, it utilizes Twig template
    inheritance and class inheritance to provide a base backend interface users
    can extend to fit their needs.

*   In place of storing configuration options in a dedicated file (``generator.yml``),
    the bundle exposes a semantic configuration handled by a `service container
    extension`_ and stores configuration options as Dependency Injection Container
    parameters.

*   The overall layout of the backend area can be customized with one of the
    many jQuery UI *themes*, while the user interface is enhanced by standard 
    jQuery UI *widgets* (buttons, modal dialogs).

.. _service container extension: http://symfony.com/doc/current/book/service_container.html#importing-configuration-via-container-extensions

Installation
============

Demo project
------------

The quickest way to try out LyraAdminBundle is by installing a `demo project`_ 
including two example bundles with a preconfigured backend area.
The demo project is available for both Symfony 2.0.x and Symfony 2.1, see
the README file in git repository for installation instructions.

.. _demo project: https://github.com/mgiagnoni/demo-admin-bundle

LyraAdminBundle can be installed as any other Symfony2 bundle.

Install source code
-------------------

You can retrieve LyraAdminBundle source code from GitHub repository by editing the
standard Symfony2 vendor script or directly utilizing git.

Vendor script (Symfony 2.0.x only)
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Add the following lines to your ``deps`` file::

    [LyraAdminBundle]
        git=http://github.com/mgiagnoni/LyraAdminBundle.git
        target=/bundles/Lyra/AdminBundle
        version=origin/2.0

Run the vendors script::

    php bin/vendors install

Composer (Symfony 2.1)
~~~~~~~~~~~~~~~~~~~~~~

Add the following line to your ``composer.json`` file::

    {
        //...

        "require": {
            //...
            "lyra/admin-bundle" : "dev-master"
        }

        //...
    }

Get Composer, unless it's already present::

    curl -s http://getcomposer.org/installer | php

Install the bundle with::

    php composer.phar update lyra/admin-bundle

Git submodule
~~~~~~~~~~~~~

Alternatively from your project root folder run::

    git submodule add git://github.com/mgiagnoni/LyraAdminBundle.git vendor/bundles/Lyra/AdminBundle

To install the bundle as git submodule your whole project must be under version
control with git or the command ``git submodule add`` will return an error. In
this case, you can simply clone the repository::

    git clone git://github.com/mgiagnoni/LyraAdminBundle.git vendor/bundles/Lyra/AdminBundle

If you directly install the bundle with git do not forget to checkout the right
branch of the repository: ``2.0`` for Symfony 2.0.x, ``master`` for Symfony 2.1

Register namespace
------------------

``Lyra`` namespace must be registered for use by the autoloader. This step must
be omitted if you install the bundle in Symfony 2.1 with Composer::

    // app/autoload.php

    $loader->registerNamespaces(array(
        // other namespaces
        'Lyra'  => __DIR__.'/../vendor/bundles',
    ));

    // ...

Add bundle to application kernel
--------------------------------

::

    // app/AppKernel.php

    public function registerBundles()
    {
        $bundles = array(
            // other bundles
            new Lyra\AdminBundle\LyraAdminBundle(),
        );

    // ...

Importing routes
----------------

The bundle routing file must be imported in your application configuration::

    # app/config/routing.yml

    LyraAdminBundle:
        resource: "@LyraAdminBundle/Resources/config/routing.yml"


Enable translator
-----------------

Translator must be always enabled as all messages in default templates
(i.e. button text used for default actions) are *keywords* while actual
text is in translation catalogues::

    # app/config/config.yml

    framework:
        translator: { fallback: en }

Publish bundle assets
---------------------

::

    app/console assets:install web

Load jQuery and jQuery UI
-------------------------

Javascript files needed by **jQuery** and **jQuery UI** scripts are not included
in the bundle package. The default base layout of the bundle loads these scripts
from **Google CDN**. If this doesn't fit your needs, for example because you
want to test the bundle on your *localhost* without an active Internet connection
or for any other reason, copy this file::

    [LyraAdminBundle folder]/Resources/views/Admin/jquery_js.html.twig

to::

    [Your project folder]/app/Resources/LyraAdminBundle/views/Admin/jquery_js.html.twig

Edit the file as you need. For example if you have stored *jquery.min.js* and
*jquery-ui.min.js* in ``web/js``::

    {# jquery_js.html.twig #}

    <script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery-ui.min.js') }}"></script>

Getting started
===============

To demonstrate the very basic features of **LyraAdminBundle** let's generate a 
simple bundle and create an admin area for it.

Create a demo bundle
--------------------

Our example bundle will be named **MGIClassifiedsBundle**: its purpose is
managing a simple advertising board where users and administrators of the
site can post classified ads.

`MGIClassifiedsBundle source code`_ is available at GitHub.

**SensioGeneratorBundle** (included in Symfony2 *Standard Edition*) is the ideal
tool to quickly generate the basic structure of the bundle. From your project
root folder run the following command::

    app/console generate:bundle --namespace=MGI/ClassifiedsBundle --dir=src --format=yml --no-interaction

Generate a ``Listing`` entity::

    app/console generate:doctrine:entity --entity=MGIClassifiedsBundle:Listing --fields="ad_title:string(255) ad_text:text posted_at:datetime expires_at:datetime published:boolean" --with-repository --no-interaction

Create the table in the database::

    app/console doctrine:schema:update --force

.. _MGIClassifiedsBundle source code: https://github.com/mgiagnoni/MGIClassifiedsBundle

Minimal backend configuration
-----------------------------

Configure LyraAdminBundle to create an admin area where you will perform all
CRUD operations on the ``Listing`` entity::

    # app/config/config.yml

    lyra_admin:
        models:
            listing:
                class: 'MGI\ClassifiedsBundle\Entity\Listing'
                list:
                    title: Listings
                    columns:
                        ad_title: ~ 
                        published: ~
                        posted_at: ~


Do not forget to clear cache before proceeding::

    app/console cache:clear

Access backend area
-------------------

If you go to ``http://.../app_dev.php/admin/listing/list`` you will see an
empty list of *Listings*: you can then add, edit, delete, publish/unpublish
a listing object.

Some configuration options are available to customize the list of records
(``Listings`` in our example).

Basic list configuration
------------------------

The label displayed inside colum headings is guessed from entity mapping
informations, you can change it for each column by explicitly setting the
``label`` option::

    # app/config/config.yml

        # ... #
            list:
                columns:
                    ad_title: ~ 
                    published: ~    
                    posted_at: 
                        label: Date

All list columns are sortable, you can change this default behavior with the
``sortable`` option. The following configuration will make the list not sortable
by the value of the *Published* column::

    # app/config/config.yml

        # ... #
            list:
                columns:
                    ad_title: ~ 
                    published: 
                        sortable: false
                    posted_at: ~ 

It's possible to set a default sort column, for example::

    # app/config/config.yml

        # ... #
            list:
                default_sort:
                    column: posted_at
                    order: desc
                columns:
                    # ... #

Use the ``format`` option to format a column content. For columns displaying
dates you can use all format strings allowed by the PHP function ``date``,for
any other column you can use all format placeholders allowed by PHP functions
``printf``, ``sprintf``::

    # app/config/config.yml

        # ... #
            list:
                columns:
                    ad_title: ~
                    published: ~
                    posted_at:
                        label: Date
                        format: 'j/M/Y'

Use the ``max_page_rows`` option to limit the number of rows that will be
displayed on a list page. Pagination links will appear at the bottom of the
list when needed::

    # app/config/config.yml

        # ... #
            list:
                max_page_rows: 15
                columns:
                    # ... #

Action buttons configuration
----------------------------

The button to create a new record has a generic text *New* and a default icon.
Here is how you can you change the configuration if you prefer a more descriptive
text and a different icon::

    # app/config/config.yml

        # ... #
            actions:
                new:
                    text: 'New listing'
                    icon: circle-plus
            list:
                columns:
                    # ... #

The value of the ``icon`` option must be the class name (without the ``ui-icon-``
part) used in **jQuery UI** theme stylesheet for the icon. You can find all
available icons on the `Theme roller`_  home page.

.. _Theme roller: http://jqueryui.com/themeroller/

You can customize all the other default actions (``show``, ``edit``, ``delete``) in the
same way.

Action show configuration
-------------------------

The ``show`` button (the first of the **object actions** unless you have changed
the default order), displays a record in a dialog window. By default all fields
are displayed, but you can choose which fields will be included in the dialog
and in what order::

    # app/config/config.yml

        # ... #
            show:
                # show dialog title
                title: Listing
                fields:
                    ad_title: ~
                    posted_at: ~
                    published: ~
            list:
                columns:
                    # ... #

Filter configuration
--------------------

List results can be filtered by the value of one or more of the ``Listing``
entity fields. Example::

    # app/config/config.yml

        # ... #
            filter:
                # search dialog title
                title: Search listings
                fields:
                    ad_title: ~
                    posted_at: ~
                    published: ~
            list:
                columns:
                    # ... #

With these options ``Listing`` objects are searchable by title, posting date
(from/to range) and published status.

This feature is not fully implemented yet and it works only for string, date,
datetime and boolean fields.

jQuery UI Datepicker in filter form
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Standard Symfony date/datetime widgets are used by default to select date
ranges. If you prefer the jQuery UI datepicker use this configuration for the
filter form::

     # app/config/config.yml

        # ... #
            filter:
                # ... #
                fields:
                    ad_title: ~
                    posted_at:
                        widget: daterange
                        options:
                            child_widget: date_picker 
                    published: ~

If you need to filter records by date and time use ``datetime_picker`` as value
of the ``child_widget`` option. As the standard jQuery UI datepicker allows
only to select a date not a time, a third party `Timepicker Addon`_ will be
used.

.. _Timepicker Addon: https://github.com/trentrichardson/jQuery-Timepicker-Addon

Creating custom batch actions
-----------------------------

A batch action to delete multiple records is available by default. Here is
how you can add your own custom batch actions, for example to publish/unpublish
multiple listings::

    # app/config/config.yml

    lyra_admin:
        models:
            listing:
                class: 'MGI\ClassifiedsBundle\Entity\Listing'
                controller: 'MGIClassifiedsBundle:Admin'
                actions:
                    publish:
                        # text displayed in drop down list
                        text: Publish
                    unpublish:
                        text: Unpublish
                list:
                    # ... #
                    batch_actions: [publish,unpublish,delete]

With the ``controller`` option you can use your own controller in place of
the default controller provided by the bundle. This is needed now because you
will write custom php code to process your batch actions::

    // MGI/ClassifiedsBundle/Controller/AdminController.php

    namespace MGI\ClassifiedsBundle\Controller;
    use Lyra\AdminBundle\Controller\AdminController as BaseAdminController;

    class AdminController extends BaseAdminController
    {
        protected function executeBatchPublish($ids)
        {
            $this->getModelManager()->setFieldValueByIds('published', true, $ids);
        }

        protected function executeBatchUnpublish($ids)
        {
            $this->getModelManager()->setFieldValueByIds('published', false, $ids);
        }
    }

Your controller class must extend LyraAdminBundle base controller. A method
created to process a batch action must be named ``executeBatch`` + action name.
It will receive as argument an array containing the primary keys of selected
records.

**getModelManager()** is a shortcut method defined in base controller that
returns an instance of the manager service for the ``listing`` model;
**setFieldValueByIds()** is one of the methods provided by the manager service
and allows you to modify a field value of multiple objects selected by primary key.

Creating custom list actions
----------------------------

You can also create buttons to perform administrative tasks. Assuming for example
that you want to provide backend users with a quick way to delete all expired
listings, you can configure a custom **list action**::

    # app/config/config.yml

    lyra_admin:
        models:
            listing:
                # ... #
                actions:
                    expired:
                        # action route is admin/listing/expired
                        route_pattern: expired
                        text: 'Delete expired'
                        icon: trash
                        # action requires a confirmation dialog
                        dialog:
                            title: 'Confirm delete expired'
                            message: 'Do you really want to delete all expired listings?'
                    # ... #
                list:
                    # ... #
                    list_actions: [new,expired]

Because this action will permanently remove records from the database it's a
good idea to configure a confirmation dialog. Note that in ``list_actions``
option you need to also include the default list action ``new`` or it will be
removed.

The code that will be executed when the button is pressed and confirmation given
goes in the controller class you have already created for custom batch actions::

    // MGI/ClassifiedsBundle/Controller/AdminController.php

    namespace MGI\ClassifiedsBundle\Controller;
    use Lyra\AdminBundle\Controller\AdminController as BaseAdminController;

    class AdminController extends BaseAdminController
    {

        public function expiredAction()
        {
            if ('POST' === $this->getRequest()->getMethod()) {
                $this->getModelManager()->getRepository()->createQueryBuilder('a')
                    ->delete()->where('a.expires_at < :d')
                    ->setParameter('d', new \DateTime('now'))
                    ->getQuery()->execute();

                $this->setFlash('mgi_classifieds success', 'Expired ads have been successfully deleted');

                return $this->getRedirectToListResponse();
            }

            // Retrieves all actions configured for the model
            $actions = $this->getActions();

            return $this->container->get('templating')
                ->renderResponse('LyraAdminBundle:Dialog:dialog.html.twig', array(
                    // action to execute when the dialog is confirmed
                    'action' => $actions->get('expired'),
                    // action to execute when the dialog is aborted
                    // index = default action to display the list of listings
                    'cancel' => $actions->get('index')
            ));
        }

        // ...
    }

When a confirmation dialog is configured, the controller displays the dialog
when the request method is GET and performs the action task when the method
is POST (i.e user has given confirmation through the dialog window).

This solution works and it's maybe acceptable for a simple action like this,
but for more complex tasks you should avoid to stuff everything inside a controller
as this will make a lot more difficult to reuse the code.

A far better solution involves the creation of a custom model manager for the
``Listing`` object and will be explained below (see 'Extending model manager services').

Basic form configuration
------------------------

Even if the form to create and edit a ``Listing`` object is fully functional
without any configuration, you will usually need to re-order the fields, group
them in panels or remove some fields from view. A simple example::

    # app/config/config.yml

    lyra_admin:
        models:
            listing:
                class: 'MGI\ClassifiedsBundle\Entity\Listing'
                form:
                    groups:
                        listing:
                            # panel title
                            caption: Listing
                            fields: [ad_title,ad_text]
                            # column break after this panel
                            break_after: true
                        status:
                            caption: Status
                            fields: [published,expires_at]
                list:
                    # ... #

With this configuration form fields are grouped in two panels displayed on two
columns (see the ``break_after`` option). You will notice that the ``posted_at``
field is not present in any panel: this field will not be visible and not
editable through the form. This can be useful for fields you want to automatically
update via a Doctrine *lifecycle callback* and that cannot be changed by users.

If you leave the ``Listing`` entity unchanged you now get an exception while
saving a new listing because the value of ``posted_at`` is no longer set by
the form and cannot be NULL. Let's add a ``prePersist`` event to the entity
to solve this issue::

    // MGI/ClassifiedsBundle/Entity/Listing.php

    namespace MGI\ClassifiedsBundle\Entity;

    use Doctrine\ORM\Mapping as ORM;

    /**
     * MGI\ClassifiedsBundle\Entity\Listing
     *
     * @ORM\Table()
     * @ORM\Entity(repositoryClass="MGI\ClassifiedsBundle\Entity\ListingRepository")
     * Activates lyfecycle callbacks
     * @ORM\HasLifecycleCallbacks()
     */
    class Listing
    {
        // No changes to properties
        // No changes to getters/setters

        /**
         * @ORM\PrePersist
         */
        public function createPostedAtValue()
        {
            $this->posted_at = new \DateTime();
        }
    }

jQuery UI Datepicker in new/edit form
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Beside the standard Symfony date and datetime widgets, you can use the jQuery UI
datepicker to edit date fields or the `Timepicker Addon`_ for datetime fields::

    # app/config/config.yml

    lyra_admin:
        models:
            listing:
                # ... #
                fields:
                    expires_at:
                        widget: date_picker
                        options:
                            format: MMM d, yyy
                form:
                    # ... #

See `Date/Time Format Syntax`_ for possible values of ``format`` option.

The ``datetime_picker`` widget requires separate options for date and time
format::

    # app/config/config.yml

            # ... #
            expires_at:
                widget: datetime_picker
                options:
                    date_format: MMM d, yyy
                    time_format: HH:mm

.. _Date/Time Format Syntax: http://userguide.icu-project.org/formatparse/datetime

Changing admin theme
--------------------

The bundle includes two themes: ``ui-lightness`` (default) and ``smoothness``.
To change theme use this configuration::

    # app/config/config.yml

    lyra_admin:
        theme: smoothness
        models:
            listing:
                # ... #

You can get additional themes from the `Theme roller`_ page on the jQuery UI website.
Once you have downloaded the desired theme, *Redmond* for example, uncompress
the package::

    jquery-ui-#.#.#.custom.zip
        css
            redmond <- only this folder and its contents are needed
                images
                    jquery-ui-#.#.#.custom.css <- rename as jquery-ui.custom.css


The package contains some stuff you will not need for use with the bundle.
Move only the folder with the same name of the theme somewhere inside your
project public folder (usually ``web``), for example ``web/css/ui_themes``, 
renaming the theme css file as indicated above. To use the new theme edit the
bundle configuration in this way::

    # app/config/config.yml

    lyra_admin:
        # path to theme folder *relative* to application public folder
        theme: css/ui_themes/redmond
        models:
            listing:
                # ... #


.. _Theme roller: http://jqueryui.com/themeroller/

Extending model manager services
--------------------------------

All the essential operations needed to manage objects (create, update,
delete, find and more) are performed by a model manager service.
A default model manager is provided by the bundle and can be extended by
user defined model managers.

By definining a model manager for the ``Listing`` object you will be able
to clean up the controller that executes the custom list action to delete
expired listings. First create your service class::

    // MGI/ClassifiedsBundle/Model/ListingManager.php

    namespace MGI\ClassifiedsBundle\Model;

    use Lyra\AdminBundle\Model\ORM\ModelManager as BaseManager;

    class ListingManager extends BaseManager
    {
        public function deleteExpiredListings()
        {
            $this->getRepository()->createQueryBuilder('a')
                ->delete()
                ->where('a.expires_at < :d')
                ->setParameter('d', new \DateTime('now'))
                ->getQuery()->execute();

            return true;
        }
    }

You must extend the base model manager provided by LyraAdminBundle as
default functionalities cannot be lost. Define your service in configuration::

    // app/config/config.yml

    services:
        classifieds_listing_manager:
            class: MGI\ClassifiedsBundle\Model\ListingManager

See the file `Resources/config/services.yml`_ in MGIClassifiedsBundle
repository for an example of how to define this service in a bundle configuration
file loaded by the bundle extension.

Change the configuration of the ``Listing`` model to use your custom manager::

    # app/config/config.yml

    lyra_admin:
        models:
            listing:
                # ... #
                services:
                    # service id of user defined model manager
                    model_manager: classifieds_listing_manager

The controller used by the custom action to delete expired listings can now
be cleaned up::

    // MGI/ClassifiedsBundle/Controller/AdminController.php

    namespace MGI\ClassifiedsBundle\Controller;
    use Lyra\AdminBundle\Controller\AdminController as BaseAdminController;

    class AdminController extends BaseAdminController
    {

        public function expiredAction()
        {
            if ('POST' === $this->getRequest()->getMethod()) {
                if ($this->getModelManager()->deleteExpiredListings()) {
                    $this->setFlash('mgi_classifieds success', 'Expired ads have been successfully deleted');
                }

                return $this->getRedirectToListResponse();
            }
                // No changes from here
        }
    }

.. _Resources/config/services.yml: https://github.com/mgiagnoni/MGIClassifiedsBundle/blob/master/Resources/config/services.yml

Customizing routes
------------------

By default all backend routes have the following pattern::

    [global prefix (default: admin)]/[model prefix (default:model name)]/[action pattern (default: action name + parameters)]

Configuration options are available to customize route patterns. If, for
example, you want that all your backend URLs begin with *backend* in place
of *admin*, use the following configuration::

     # app/config/config.yml

     lyra_admin:
        route_pattern_prefix: backend
        # ... #

To also change the prefix of all the routes of the ``Listing`` model and the
pattern of the index action route::

    # app/config/config.yml

     lyra_admin:
        route_pattern_prefix: backend
        # ... #
        models:
            listing:
                route_pattern_prefix: ads
                # ... #
                actions:
                    index:
                        route_pattern: index/{page}/{column}/{order}

With this configuration the URL to display the list of listings becomes::

    http://.../backend/ads/index

Improving the sample bundle
===========================

It's time to add more features to the sample bundle. Displaying a bunch of
uncategorized listings is not very useful, so let's see how to manage
listing **categories**.

Adding an associated model
--------------------------

Create a ``Category`` entity with the **SensioGeneratorBundle**::

    app/console generate:doctrine:entity --entity=MGIClassifiedsBundle:Category --fields="name:string(255) description:text" --with-repository --no-interaction

Implement a *__toString()* method in the newly created entity::

    // MGI/ClassifiedsBundle/Entity/Category.php

    // ...
    class Category
    {
        // ...
        public function __toString()
        {
            return $this->name;
        }
    }

This step is needed as the value of the ``name`` property will be used to
build the options of the dropdown list used to select the listing category
on the listing form.

Edit the ``Listing`` entity to add a **many-to-one** relation with
``Category``::

    // MGI/ClassifiedsBundle/Entity/Listing.php
    // ...
    class Listing
    {
        // ...

        /**
         * @ORM\ManyToOne(targetEntity="Category")
         */
        private $category;

        public function setCategory(Category $category)
        {
            $this->category = $category;
        }

        public function getCategory()
        {
            return $this->category;
        }
    }

Update the database::

    app/console doctrine:schema:update --force

Create a model ``category`` in LyraAdminBundle configuration::

    # app/config/config.yml

    lyra_admin:
        models:
            listing:
                # ... #
            category:
                class: 'MGI\ClassifiedsBundle\Entity\Category'
                # title displayed in top menu
                title: Categories
                list:
                    title: Listing categories
                    columns:
                        name: ~
                        description: ~

Now you can follow the link ``Categories`` in the top menu to create new
categories.

Selecting an associated model in form
-------------------------------------

To set the associated ``Category`` when you create or edit a ``Listing`` object,
add the ``category`` property to the configuration of the ``Listing`` form::

    # app/config/config.yml

    lyra_admin:
        models:
            listing:
                # ... #
                form:
                    groups:
                        listing:
                            caption: Listing
                            fields: [category,ad_title,ad_text]

The form to create / edit a listing now contains a dropdown list to select
the desired category.

Displaying associated model fields in list columns
--------------------------------------------------

``Category`` fields can be also diplayed in a list column::

    # app/config/config.yml

    lyra_admin:
        models:
            listing:
                # ... #
                list:
                    columns:
                        category.name:
                            label: Category
                            sortable: false
                        # ... #

Note that when a column displays fields of a related model the column name
in configuration has the format [model name].[field name]. If you don't like
it, you can explicitly set the ``field`` option and change the column name as
you like. The following is exactly the same than the configuration above::

                    # ... #
                    columns:
                        category:
                            field: category.name
                            # now label could be omitted as the default
                            # value is the 'humanized' column name
                            label: Category
                            sortable: false

If you are not interested to sort list results by category, you are done, provided
that you set ``sortable`` to *false* everything works.

But if you want to make the category colum sortable you will need to make a
small change to the custom Listing model manager you have previously created::

    // MGI/ClassifiedsBundle/Model/ListingManager.php

    namespace MGI\ClassifiedsBundle\Model;

    use Lyra\AdminBundle\Model\ORM\ModelManager as BaseManager;

    class ListingManager extends BaseManager
    {
        // ...
        public function getBaseListQueryBuilder()
        {
            $qb = parent::getBaseListQueryBuilder();
            $qb->select('a');
            $qb->leftJoin('a.category', 'category');

            return $qb;
        }
    }

The model manager method **getBaseListQueryBuilder()** returns the query builder
of the query used to retrieve list results. With this change you add a join
between the Listing and Category models, needed for the sorting to work.

Then you can set the ``sortable`` option of the category column to *true*
(or remove it from configuration as *true* is the option default value).

Filtering by an associated model
--------------------------------

To give backend users the opportunity to filter list results and display
only listings of a given category, you can update filters configuration::

    lyra_admin:
        models:
            listing:
                # ... #
                filter:
                    fields:
                        category: ~
                        ad_title: ~
                        posted_at: ~
                        published: ~

Adding another associated model (many-to-many)
----------------------------------------------

To furtherly improve our classifieds bundle let's give backend users the
opportunity to select **multiple tags** (in addition to a single category)
for each listing.

Create a ``Tag`` entity::

    app/console generate:doctrine:entity --entity=MGIClassifiedsBundle:Tag --fields="name:string(255) description:text" --with-repository --no-interaction

Implement a *__toString()* method in the ``Tag`` class as explained above
for ``Category`` entity.

Edit the ``Listing`` entity to add a **many-to-many** relation with ``Tag``::

    // MGI/ClassifiedsBundle/Entity/Listing.php
    namespace MGI\ClassifiedsBundle\Entity;

    use Doctrine\ORM\Mapping as ORM;
    use Symfony\Component\Validator\Constraints as Assert;
    use Doctrine\Common\Collections\ArrayCollection;

    // ...
    class Listing
    {
        // ...

        /**
         * @ORM\ManyToMany(targetEntity="Tag")
         * @ORM\JoinTable(name="listing_tags")
         */
        private $tags;

        public function __construct()
        {
            $this->tags = new ArrayCollection();
        }

        public function setTags(ArrayCollection $tags)
        {
            $this->tags = $tags;
        }

        public function getTags()
        {
            return $this->tags;
        }
    }

Update the database::

    app/console doctrine:schema:update --force

Create a model ``tag`` in LyraAdminBundle configuration::

    # app/config/config.yml

    lyra_admin:
        models:
            listing:
                # ... #
            category:
                # ... #
            tag:
                class: 'MGI\ClassifiedsBundle\Entity\Tag'
                title: Tags
                list:
                    title: Listing tags
                    columns:
                        name: ~
                        description: ~

Add a new field in listing form::

    # app/config/config.yml

    lyra_admin:
        models:
            listing:
                # ... #
                form:
                    groups:
                        listing:
                            caption: Listing
                            fields: [category,tags,ad_title,ad_text]

Tags will be selected with a multi-select listbox displayed on the listing
form.

Configuring a dual list box
~~~~~~~~~~~~~~~~~~~~~~~~~~~

In addition to the standard multiple select box a more user friendly jQuery
**dual list box** can be made available to select listing tags::

    # app/config/config.yml

    lyra_admin:
        models:
            listing:
                # ... #
                fields:
                    tags:
                        options:
                            attr: { class: dual-list }

Adding ``dual-list`` as class attribute of the field will dinamically transform
a standard HTML select (with multiple attribute) in a dual list box. This is
managed by a `jQuery plugin`_ provided by the bundle.

.. _jQuery plugin: https://github.com/mgiagnoni/LyraAdminBundle/blob/master/Resources/public/js/lyra_dual_list.js

Configuration summary
=====================

Below you will find an example with all the configuration options you have
seen up to this point::

    # app/config/config.yml

    lyra_admin:
        theme: smoothness # or ui-lightness (default)
        # additional themes installed in web/css/ui_themes
        #theme: css/ui_themes/redmond
        models:
            listing:
                class: 'MGI\ClassifiedsBundle\Entity\Listing'
                controller: 'MGIClassifiedsBundle:Admin'
                # title displayed in top menu
                title: Listings
                actions:
                    publish:
                        # for batch actions it's the text displayed in drop down list
                        text: Publish
                    unpublish:
                        text: Unpublish
                    new:
                        # for list/object actions it's the button text
                        text: 'New listing'
                        # button icon
                        icon: circle-plus
                    expired:
                        route_pattern: expired
                        text: 'Delete expired'
                        icon: trash
                        dialog:
                            title: 'Confirm delete expired'
                            message: 'Do you really want to delete all expired listings?'
                show:
                    # show dialog title
                    title: Listing
                    fields:
                        category: ~
                        ad_title: ~
                        posted_at: ~
                        published: ~
                list:
                    # Activate pagination: max 15 rows will be displayed on a list page
                    max_page_rows: 15
                    # default sort column
                    default_sort:
                        column: posted_at
                        order: desc
                    title: Listings
                    columns:
                        category.name:
                            label: Category
                            sortable: false
                     # or alternatively
                     #  category:
                     #      field: category.name
                     #      sortable: false
                        ad_title: ~
                        published:
                            sortable: false
                        posted_at:
                            label: Date
                            format: 'j/M/Y'
                    batch_actions: [publish,unpublish,delete]
                    list_actions: [new,expired]
                filter:
                    # search dialog title
                    title: Search listings
                    fields:
                        ad_title: ~
                        posted_at:
                            widget: daterange
                            options:
                                child_widget: datetime_picker
                        # or    child_widget: date_picker
                        published: ~
                fields:
                    expires_at:
                        widget: datetime_picker
                    tags:
                        options:
                            # activate jQuery dual list box
                            attr: { class: dual-list }
                form:
                    groups:
                        listing:
                            # panel title
                            caption: Listing
                            fields: [category,tags,ad_title,ad_text]
                            # column break after this panel
                            break_after: true
                        status:
                            caption: Status
                            fields: [published,expires_at]
                services:
                    # service id of user defined model manager
                    model_manager: classifieds_listing_manager
            category:
                class: 'MGI\ClassifiedsBundle\Entity\Category'
                list:
                    title: Categories
                    columns:
                        name: ~
                        description: ~
            tag:
                class: 'MGI\ClassifiedsBundle\Entity\Tag'
                title: Tags
                list:
                    title: Listing tags
                    columns:
                        name: ~
                        description: ~

Contact info
============

Bug reports and feedback should be preferably submitted via the `GitHub issue tracker`_.
If you need to contact me, my email address is in the source code.

Updates about the development of LyraAdminBundle will be posted on Twitter (`@mgiagnoni`_)
and on `Lyra CMS blog`_.

.. _GitHub issue tracker: https://github.com/mgiagnoni/LyraAdminBundle/issues
.. _@mgiagnoni: http://twitter.com/mgiagnoni
.. _Lyra CMS blog: http://www.lyra-cms.com/blog

[to be continued ...]
