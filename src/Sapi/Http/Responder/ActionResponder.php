<?php
declare(strict_types=1);

namespace Argo\Sapi\Http\Responder;

use Otto\Sapi\Http\Responder\ActionResponder as OttoActionResponder;
use PayloadInterop\DomainStatus;

class ActionResponder extends OttoActionResponder
{
	protected function getView() : string
	{
		if ($this->payload === null) {
			return parent::getView();
		}

        $view = match ($this->payload->getStatus()) {
            DomainStatus::ACCEPTED => 'status:Accepted',
            DomainStatus::CREATED => 'status:Created',
            DomainStatus::DELETED => 'status:Deleted',
            DomainStatus::ERROR => 'status:Error',
            DomainStatus::INVALID => 'status:Invalid',
            DomainStatus::NOT_FOUND => 'status:NotFound',
            DomainStatus::UPDATED => 'status:Updated',
            default => null,
        };

        return $view ?? parent::getView();
	}
}
