<?php

namespace IlBronza\Clients\Models;

use IlBronza\Buttons\Button;
use IlBronza\Category\Traits\InteractsWithCategoryTrait;
use IlBronza\Clients\Models\Scopes\ClientAreaManagerScope;
use IlBronza\Clients\Models\Traits\Client\ClientRelationsTrait;
use IlBronza\Clients\Models\Traits\InteractsWithDestinationTrait;
use IlBronza\Contacts\Models\Traits\InteractsWithContact;
use IlBronza\CRUD\Models\BaseModel;
use IlBronza\CRUD\Models\Casts\ExtraField;
use IlBronza\CRUD\Traits\CRUDSluggableTrait;
use IlBronza\CRUD\Traits\IlBronzaPackages\CRUDLogoTrait;
use IlBronza\CRUD\Traits\Model\CRUDUseUuidTrait;
use IlBronza\CRUD\Traits\Model\PackagedModelsTrait;
use IlBronza\Notes\Traits\InteractsWithNotesTrait;
use IlBronza\Payments\Models\Traits\InteractsWithPaymenttypes;
use IlBronza\Products\Models\Interfaces\SupplierInterface;
use IlBronza\Products\Models\Traits\Sellable\InteractsWithSupplierTrait;
use IlBronza\Ukn\Facades\Ukn;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

#[ScopedBy([ClientAreaManagerScope::class])]
class Client extends BaseModel implements SupplierInterface, HasMedia
{
	static $packageConfigPrefix = 'clients';
	static $modelConfigPrefix = 'client';
	public ?string $translationFolderPrefix = 'clients';
	protected $keyType = 'string';

	protected $casts = [
//		'company_site_slug' => ExtraField::class,

		'street' => ExtraField::class . ':address',
		'number' => ExtraField::class . ':address',
		'zip' => ExtraField::class . ':address',
		'town' => ExtraField::class . ':address',
		'city' => ExtraField::class . ':address',
		'province' => ExtraField::class . ':address',
		'region' => ExtraField::class . ':address',
		'state' => ExtraField::class . ':address',
	];

	use InteractsWithContact;
	use InteractsWithDestinationTrait;
	use InteractsWithPaymenttypes;
	use PackagedModelsTrait;
	use InteractsWithNotesTrait;
	use InteractsWithSupplierTrait;

	//	use ClientsPackageBaseModelTrait;
	use CRUDUseUuidTrait;
	use CRUDSluggableTrait;
	use CRUDLogoTrait;
	use InteractsWithCategoryTrait;

	use InteractsWithMedia;

	use ClientRelationsTrait;

	public function getCategoryModel() : string
	{
		return config('category.models.category.class');
	}

	public function getCategoriesCollection() : ?string
	{
		return null;
	}

	public function getRouteBaseNamePrefix() : ?string
	{
		return config('clients.routePrefix');
	}

	public function getDestination() : Destination
	{
		return $this->getDefaultDestination();
	}

	public function destinations()
	{
		return $this->hasMany(Destination::getProjectClassName());
	}

	public function getDefaultDestination() : ?Destination
	{
		if ($this->defaultDestination)
			return $this->defaultDestination;

		if ($this->destinations()->count() != 1)
			return null;

		if (! $destination = $this->destinations()->first())
			return $this->createDefaultDestination();

		return $this->assignRandomDestinationAsDefault();
	}

	public function getDestinations(array $relations = [])
	{
		if ($this->relationLoaded('destinations'))
			return $this->destinations;

		// Log::error('cachare questo e verificare in caso di modifica cliente se decachato');

		return $this->destinations()->with($relations)->get();
	}

	public function getLegalDestination() : ?Destination
	{
		if ($this->legalDestination)
			return $this->legalDestination;

		if (! $destination = $this->getDefaultDestination())
			return null;

		$destination->setAsLegal();

		return $destination;
	}

	public function getReferents()
	{
		return $this->referents;
	}

	public function hashes()
	{
		return $this->hasMany(Clienthash::getProjectClassName());
	}

	public function getCreateHashButton() : Button
	{
		return Button::create([
			'href' => route(config('clients.routePrefix') . 'clients.clienthashes.create', ['client' => $this]),
			'text' => 'clients::clienthashes.create',
			'icon' => 'user'
		]);
	}

	public function getCreateDestinationButton() : Button
	{
		return Button::create([
			'href' => $this->getCreateDestinationUrl(),
			'text' => 'clients::destinations.create',
			'icon' => 'location'
		]);
	}

	public function getCreateDestinationUrl()
	{
		return route(config('clients.routePrefix') . 'clients.destinations.create', ['client' => $this]);
	}

	public function getCreateReferentUrl()
	{
		return route(config('clients.routePrefix') . 'clients.referents.create', ['client' => $this]);
	}

	public function getCreateReferentButton() : Button
	{
		return Button::create([
			'href' => route(config('clients.routePrefix') . 'clients.referents.create', ['client' => $this]),
			'text' => 'clients::referents.create',
			'icon' => 'user'
		]);
	}

	public function addEmailsToReferentTypes(array $emails, array $types)
	{
		$referents = $this->referents()->with('types')->get();

		foreach ($emails as $email)

			if ($referent = $referents->firstWhere('email', $email))
				$referent->addTypes($types);

			else
				$this->createReferentByEmailTypes($email, $types);
	}

	public function referents()
	{
		return $this->hasMany(Referent::getProjectClassName());
	}

	public function createReferentByEmailTypes(string $email, array $types = [])
	{
		$referent = $this->createReferent([
			'email' => $email
		]);

		$referent->addTypes($types);
	}

	public function createReferent(array $parameters = []) : Referent
	{
		$referent = Referent::getProjectClassName()::make();

		$referent->client_id = $this->getKey();
		$referent->first_name = $this->getName();

		foreach ($parameters as $parameter => $value)
			$referent->$parameter = $value;

		$referent->save();

		return $referent;
	}

	public function getReferentsByTypes(array $types)
	{
		$types = Referenttype::whereIn('name', $types)->get();

		$referentsByTypesIds = ReferenttypeReferent::whereIn('type_slug', $types->pluck('slug'))->select('referent_id')->get();

		return $this->referents()->whereIn('id', $referentsByTypesIds)->get();
	}

	public function getVatAttribute($value)
	{
		if (is_null($value))
			return null;

		return str_pad($value, 11, '0', STR_PAD_LEFT);
	}

	public function setVatAttribute($value)
	{
		$this->attributes['vat'] = str_pad($value, 11, '0', STR_PAD_LEFT);
	}

	private function assignRandomDestinationAsDefault() : Destination
	{
		$destination = $this->destinations->first();
		$destination->setAsDefault();

		Ukn::w(trans('clients::destinations.setAsDefaultBySystem', ['name' => $destination->getName()]));

		return $destination;
	}

	public function scopeAsClient($query)
	{
		return $query->where('is_client', true);
	}

	public function scopeAsSupplier($query)
	{
		return $query->where('is_supplier', true);
	}
}