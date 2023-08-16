<?php
declare(strict_types=1);

namespace Argo\Infra\Build;

use Otto\Sapi\Http\Template\Template as OttoTemplate;

class Template extends OttoTemplate
{
    public function __construct(
        Catalog $catalog,
        Helpers $helpers
    ) {
        parent::__construct($catalog, $helpers);
    }
}
