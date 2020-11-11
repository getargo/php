                    <form
                        action="https://duckduckgo.com/"
                        method="get"
                        onsubmit="
                            document.getElementById('search-q').value
                                = 'site:<?= $this->escape()->js(parse_url($this->config->general->url, PHP_URL_HOST)) ?> '
                                +  document.getElementById('search-input').value;
                        "
                    >
                        <div class="input-group">
                            <input type="hidden" id="search-q" name="q" value="" />
                            <input id="search-input" type="search" class="form-control" placeholder="Search &hellip;">
                            <span class="input-group-append">
                                <input type="submit" class="btn btn-secondary" value="Go!"></input>
                            </span>
                        </div>
                    </form>
