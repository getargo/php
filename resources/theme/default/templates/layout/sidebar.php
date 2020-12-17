
        <aside class="SidebarLayout__Sidebar">

            <?php foreach ($this->config->theme->sidebar as $widget) {
                echo $this->render($widget);
            } ?>

        </aside>
