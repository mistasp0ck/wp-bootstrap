WP Bootstrap Theme
===================

Bootstrap v5.1.3 (https://getbootstrap.com/) in WordPress theme form. (based on WP-Bootstrap, which is no longer maintained) 

GETTING STARTED
_______________

To get started, open Terminal or a command prompt and run:

	cd path/to/wp-content/themes
	git clone https://git@bitbucket.org:fredswan/custom-fs-theme.git
	npm install
	grunt

  for live browser update change `proxy: "localhost:8888/install/` to your local url

  Final build command is `grunt build` This will minify all js and css and add additional compatibility to css for media queries.

FEATURES
________

WP Bootstrap uses grunt as a task manager to help aid development. Check out the gruntfile.js file for more detail on the default tasks. wp-bootstrap comes with livereload, sass, babel and more tasks out of the box. 


Page Templates
______________

We’ve packaged four different page templates into this theme.

    - Homepage template
    - Standard page with right sidebar
    - Page with left sidebar
    - Full width page

Lightbox
________

To use lightbox add `data-lity` to link

Carousel
________

There are two carousel shortcodes to choose from:

	- Standard Carousel
	- Posts Carousel

Theme Options Panel
___________________

** add in options ** 

Shortcodes
__________

We’ve built in some shortcodes so you can easily add UI elements found in Bootstrap.

Sidebars
________

There are two different sidebars. One for the homepage and one for the other pages. Add widgets to them.