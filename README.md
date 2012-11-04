accessible-genesis-child-theme
==============================

README.txt Accessible Child Theme for the Genesis Framework
Rian Rietveld http://www.rrwd.nl

Version 0.2
===========
November 3, 2012

Changes in version 0.2:

Replaced Featured Post Widget for a more accessible one:
- removed title attribute in links
- changed heading h2 into h3 for items (matching the H2 for the widget title)

style.css
-------------
- first definition of the font-size to 1 em for all elements
- changed link display in underline

print-style.css
-------------
Included print-style.css that hides the skip links in the output.

functions.php
-------------
- added blog_info options for direction and language
- removed option for custom background
- removed title attribute from link in the site title
- removed link form the site title on the home page


Version 0.1 First release
=========================
September 15, 2012

Changes made to the default (child) theme

functions.php
-------------

Replaced Twitter Widget for a more accessible one:
- removed target is _blank for links, so they don't open in a new window
- removed title attribute in links
- removed links on hashtags to prevent a overload of links for a tweet
- removed the timestamp/link to prevent a overload of links for a tweet
- removed inline style for font-size
- included function genesis_tweet_linkify, renamed it wp_accessible_tweet_linkify
- included a .pot file and dutch .po/.mo files

Changed DocType to HTML5

Added skip links, and included keyboard navigation for that

Heading and titles:
- removed the H1 from the site title and the H2 from the description
- added an H1 on archive and category pages
- removed all title tags for images and links in posts
- changed the heading for the widgets from a H4 into a H2 for semantics. Included code to make this work for the plugin Genesis Simple Sidebars too
- added the post title to the "Read More" link
- removed rel attribute from the category list to pass HTML5 validation

style.css
-------------
- font-sizes in em, first definition 100% ( 16px )
- adjusted colours to match WCAG 2.0 AA standards
- added style for hidden heading for screen readers
- added style for skip links keyboard users 