<?php

namespace IlBronza\Clients\Models;

use IlBronza\Clients\Models\Type;

class Referenttype extends Type
{
	public ? string $translationFolderPrefix = 'clients';

	static $packageConfigPrefix = 'clients';

	static $modelConfigPrefix = 'referenttype';

}