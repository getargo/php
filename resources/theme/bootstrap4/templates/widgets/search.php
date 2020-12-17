                <section class="my-4">
                    <form action="https://duckduckgo.com/" method="get">
                        <div class="input-group">
                            <input type="hidden" name="sites" value="<?=
                                $this->escape()->attr(
                                    parse_url($this->config->general->url, PHP_URL_HOST)
                                );
                            ?>">
                            <input type="search" name="q" class="form-control" placeholder="Search &hellip;">
                            <span class="input-group-append">
                                <input type="submit" class="btn btn-secondary" value="Go!"></input>
                            </span>
                        </div>
                    </form>
                 </section>
