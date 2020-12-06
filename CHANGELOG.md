# Changelog

This package uses [Romantic Versioning](http://blog.legacyteam.info/2015/12/romver-romantic-versioning/).

ADD MONOSPACE FONT: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;

REFIEW PREFLIGHT DIFF; CONSIDER ADDING STYLE BLOCK.

## 1.2.0

Moved existing "default" theme to "default-old", created entirely new "default" theme with Bootstrap 4. It looks very similar, but uses different class names in the DOM. Introduces CSS variables as well, which you can edit from the Theme config under the "style" block.

NOTES: Tell users how to add those styles in config.

## Added

- The Draft page now shows the provisional URL based on the current date and title
  of the draft.

- A "Featured Posts" config is now available; it uses the same format as the
  blogroll config.

- Tags can now be deleted via the tag admin page.

- Posts now support the <!-- more --> tag, so that in the index, Read More shows up.

## Changed

- Can now open the local site storage folder from any admin screen.

- ... did these really happen, or is it an artifact of renaming to default-old?
    - Extracted blogroll code to its own blogroll.shtml.php template

    - Extracted menu code to its own menu.shtml.php template

    - Extracted layout footer to its own footer.html.php template

    - Extracted layout head links, meta, scripts, styles, and title code to their own templates

- The Argo.shtml() method now looks at the current script element, not a particular DOM element id.

- Sidebar widgets in the theme config are no longer prefixed with "widgets/" there; the prefix is added automatically.

- Custom theme work is now done not in `custom/` but in `{$name}-custom/`; this allows you to switch between themes, and maintain the custom theme work in each one.

- Posts now "know" what index they are in, so that saving a post rebuilds only that index, not all indexes.

- The custom theme "pender" templates are now located by directory name, not by the specific name in the theme config. This means the order of penders now depends on the file name.

- All content items now support $prev and $next.

- The page names "category" and "categories" are now reserved.

- Pages can now have tags.


## Fixed

- Images and links in draft/post/page/tag previews now point to the local presentation server, not the admin server.


## Other

Updated docs and tests.


## 1.1.0

### Added

Admin screens now use AdminLTE 3 for their UI.

A .htaccess file is created at site initialization.

### Changed

Content items can now specify their markup format.

### Fixed

Drafts now show images properly.


## 1.0.0

Initial release.

