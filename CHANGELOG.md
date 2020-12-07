# Changelog

This package uses [Romantic Versioning](http://blog.legacyteam.info/2015/12/romver-romantic-versioning/).

## 1.2.0

### UPGRADING

This release has an entirely new "default" theme; the previous one is now called "default-old".

The new "default" theme looks very similar to "default-old", but uses Bootstrap 4 along with different class names in the DOM. It introduces CSS variables as well, which you can edit from the Theme config under the "style" block.

If you want to keep using the previous theme, change your Theme config name to "default-old".

Alternatively, if you want to keep the new "default" theme, you can add this new block to the Theme config to edit the style variables:

    "style": {
        "serif_fonts": "Georgia, 'Times New Roman', Times, serif",
        "sans_serif_fonts": "-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, 'Noto Sans', sans-serif",
        "monospace_fonts": "SFMono-Regular, Menlo, Monaco, Consolas, 'Liberation Mono', 'Courier New', monospace",
        "link_color": "#438287",
        "link_color_hover": "#205d5f",
        "header_font_color": "white",
        "header_background_color": "#f7f7f7",
        "header_background_image": "url('/theme/default/beach-sky.jpg')",
        "footer_font_color": "black",
        "footer_background_color": "#f7f7f7"
    }

Further, in the Theme config for sidebar, widgets no longer need the "widget/" prefix; change your entries from (e.g.) "widgets/search" to just "search".

Finally, custom theme work in your `_theme` directory should now be prefixed with theme name being customize. For example, you should use `default-custom` (instead of just `custom`). This allows you to switch between themes without having to re-edit your custom work each time you switch.

### Added

- The Draft page now shows the provisional URL based on the current date and title of the draft.

- A "Featured Posts" config is now available; it uses the same format as the blogroll config.

- Tags can now be deleted via the tag admin page.

- Posts now support the `<!-- more -->` tag, so that in the post indexes, a "Read More" link shows up.

### Changed

- You can now open the local site storage folder from any admin screen; the link is at the top right of each screen.

- The Argo.shtml() method now looks at the current script element, not a particular DOM element id.

- Sidebar widgets in the theme config are no longer prefixed with "widgets/" there; the prefix is added automatically.

- Custom theme work is now done not in `custom/` but in `{$name}-custom/`; this allows you to switch between themes, and maintain the custom theme work in each one.

- Posts now "know" what index they are in, so that saving a post rebuilds only that index, not all indexes. This is a performance improvement.

- The custom theme "pender" templates are now located by directory name, not by the specific name in the theme config. This means the order of penders now depends on the file name.

- All content items now support $prev and $next.

- All content items now support tags (except tags themselves).

- The page names "category" and "categories" are now reserved.

### Fixed

- Images and links in content item editing previews now point to the preview server, not the admin server, so that they display properly in preview.

- Pages without tags now show up properly for editing.

### Other

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

