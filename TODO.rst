Part I - dantleech.com
======================


Tasks
-----

 * [DONE] regression with integer passed to CacascadeMode
 * [NO] Blog to not use endpoints for posts, to manage all as routes /blog/post/{slug} => _controller
 * [DONE] Make homepage button. Add button to make endpoint a home page. Show this endpoint first in the list of homepages

 * [DONE] Menu create !
   * [DONE] Refactored duplicated menu logic into macro and jquery plugin
   * [DONE] Menu reference in block ( e.g. specify which menu )
 * [DONE] Default (CoreBunde\Document\Endpoint) controller.
 * [DONE] Routing system - full path doesn't work. e.g. /about/me does not get found.
   like with Templates.
 * [DONE (added confirmations)] Confirmation on delete -- abstract delete button? Abstract actions?
 * [DONE] dantleech.com migration script

 * [DONE - twig was not going via ::getChildren() with node.children, has to change to node.getChildren]  Method "showInMenu" for object "DCMS\Bundle\CoreBundle\Document\Folder" does not exist in /home/daniel/www/DCMS/src/DCMS/Bundle/AdminBundle/Resources/views/Endpoint/_treeNode.html.twig at line 1

 * HowTo manage assets

 * Multivalue tags not being evaluated (matches only first value)
 * Support for blog comments (and import from dantleech2 [or not])
 * Validation (part I ?)
 * HTACCESS

 * Abstract "Create OK template"

 * System for managing site preferences (not just free form "put whatever you want")

Issues
------

 * [DONEish] Separate module for menu system? (not integrated with endpoints)
   * Probably, now that endpoint position represents route heirarchy

Part II + 
=========

 * Translations | I18N 
   * I18N Text Input Field  [ This is input|   [fr|de|en]  ] (flag dropdown / expansion)
   * I18Nize backoffice text
 * Backoffice themeable
   * Icon set and CSS
 * Multisite
   * Backoffice interface design
   * Site hostname selector and alternative selection mechanisim (for testing without hostname)
 * Site factory
   * Ability to create sites from templates / manifests (think Puppet)
   * Manifest subscription
     * Ability to push updates to subscribed sites and/or to pull updates
   * Prototype sites
     * Sites which act as Document / configuration repositories for manifests.
   * Implies a later signup process
 * Document References / symlinks
   * Allow a content / endpoint to be a reference to an existing (e.g. platform) document
   * Provide ability to manage this link, e.g. [use|create] concrete instance or symlink.
 * Widget Endpoint
   * Endpoint which allows placement of widgets within a layout
   * Will probably be the primary use case of the Endpoints
   * Endpoint editor in backoffice used to place widgets and choose layout
   * Widgets then editable within a site context (WYSIWYG)
     * Potentially retaining backoffice "context" (i.e. navigation)
 * Widget system / framework
   * Provide framework for plugging in widgets
   * Widet definitions should provide:
     * Javascript and CSS dependecies for:
       * The frontend
       * The widget editor
     * A Form object and optionally a form template.
     * A controller to render the frontend content.
     * Potentially using the existing Sonata block system
 * Theme system 
 * Media manager
   * Media browser jquery plugin
   * Media form types
   * Use Sonata media stuff
 * User system

CMF Ambitions
=============

* Universal widget framework
   * Share widgets between different CMF constructions
   * With online repositories, implies an official widget repository
 * Universal theme framework
   * With online repositories, implies an official theme repository
   * Widget dependency resolution
 * Endpoint framework/concept in CMF?

 * Abstract interface and services for universal components
   * i.e. do not rely on the presence of e.g. DCMSThemeBundle
     * so, CoreBundle to provide Theme service interface.
   * Menu - ability to identify menu node from descendent Endpoints.
     * CIP: Highlight most relevant menu item when displaying an endpoint / content des
   * Theme
   * Widget
   * ???

Vendor considerations
=====================

 * Ability to delegate management of a group of sites to a user / user group
   * Should support distributed server CMS installations, e.g. LDAP
