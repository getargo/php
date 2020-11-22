
    <!--
        Having a background image is optional. If the background image is not
        used, remove the class `SiteHeader--HasBackgroundImage`
    -->
    <header class="SiteHeader SiteHeader--HasBackgroundImage">

        <?= $this->renderAll($this->config->theme->layout_header_prepend ?? []) ?>

        <!-- Exclude all markup starting here if no background image -->
        <div class="SiteHeader__BackgroundImage">
            <picture>
                <img
                    src="<?= $this->config->theme->layout_header_img_src ?>"
                    alt="<?= $this->config->theme->layout_header_img_alt ?>"
                    class="SiteHeader__BackgroundImageTag"
                >
            </picture>
        </div>
        <!-- /Exclude markup -->

        <div class="SiteHeader__HeadingArea">
            <div class="SiteHeader__HeadingAreaInner">
                <h1 class="SiteHeader__Heading"><?= $this->config->general->title ?></h1>
                <h2 class="SiteHeader__SubHeading"><?= $this->config->general->tagline ?></h2>
            </div>
        </div>

        <?= $this->renderAll($this->config->theme->layout_header_append ?? []) ?>

        <div class="SiteHeader__NavWrapper">
            <nav id="menu-widget" class="SiteNav">
                <script async>Argo.shtml('/menu.shtml', 'menu-widget')</script>
            </nav>
        </div>
    </header>
