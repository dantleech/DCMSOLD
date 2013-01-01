Part I - dantleech.com
======================

* Routing system - full path doesn't work. (???)

Tasks
-----

 * Blog to not use endpoints for posts, to manage all as routes /blog/post/{slug} => _controller
 * Make homepage button. Add button to make endpoint a home page. Show this endpoint first in the list of homepages
   like with Templates.
 * Validation (part I ?)
 * dantleech.com migration script
 


Issues
------

 * Separate module for menu system? (not integrated with endpoints)
   * Probably, now that endpoint position represents route heirarchy

Part II
=======

 * Translations | I18N 
   * I18N Text Input Field  [ This is input|   [fr|de|en]  ]
 * Backoffice themeable
   * Icon set and CSS
 * Multisite
   * Backoffice interface design
   * Site hostname selector and alternative selection mechanisim (for testing without hostname)
 * Site factory
   * Ability to create sites from templates / manifests
   * Manifest subscription
     * Ability to push updates to subscribed sites and/or to pull updates
   * Prototype sites
     * Sites which act as Document / configuration repositories for manifests.
   * Implies a later signup process
 * Document References / symlinks
   * Allow a content / endpoint to be a reference to an existing (e.g. platform) document
   * Provide ability to manage this link, e.g. [use|create] concrete instance or symlink.
 * Theme system 


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
   * Menu - ability to identify menu node from descendent Endpoints.
     * CIP: Highlight most relevant menu item when displaying an endpoint / content des
   * Theme
   * Widget
   * ???
