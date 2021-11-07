                <section class="my-4">
                    {{= form ([
                        'action' => 'https://duckduckgo.com/',
                        'method' => 'get',
                    ]) }}
                        <div class="input-group">
                            {{= hiddenField ([
                                'name' => 'sites',
                                'value' => parse_url($this->config->general->url, PHP_URL_HOST),
                            ]) }}
                            {{= searchField ([
                                'name' => 'q',
                                'class' => 'form-control',
                                'placeholder' => 'Search ...',
                            ]) }}
                            <span class="input-group-append">
                                {{= submitButton ([
                                    'class' => 'btn btn-secondary',
                                    'value' => 'Go!',
                                ]) }}
                            </span>
                        </div>
                    </form>
                 </section>
