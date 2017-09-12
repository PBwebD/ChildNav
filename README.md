WordPress Plugin: Insert Child Nav
==================================
A WordPress plugin to display child (and parent) pages with a shortcode or widget.

Attributes
----------
Set default values, set widget values, and override default values with shortcode attributes.

| Attribute     | Notes
| ------------- | --------------------------
| depth         | -1 (list of all), 0 (nested list of all), 1+ (# of levels)
| include       | comma-separated list of page IDs, ONLY includes pages listed
| exclude       | comma-separated list of page IDs
| sort          | menu order, post date, post title, post name, post parent
| list_title    | text to display above the page list
| show_parent   | choose yes to show the main parent page link above the list
| current_class | none, bold, italic, underline

Notes
-----
* List won't display on the main blog page or any of the post pages.

Possible TODOs
--------------
* ADD pages to top or bottom of list - useful for a home page or sitemap.