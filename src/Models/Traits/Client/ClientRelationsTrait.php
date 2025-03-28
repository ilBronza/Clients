<?php

namespace IlBronza\Clients\Models\Traits\Client;

use IlBronza\Products\Models\Order;
use IlBronza\Products\Models\Product\Product;
use IlBronza\Products\Models\Quotations\Project;
use IlBronza\Products\Models\Quotations\Quotation;
use IlBronza\Warehouse\Models\Pallettype\Pallettype;

trait ClientRelationsTrait
{
	public function projects()
	{
		return $this->hasMany(Project::getProjectClassName());
	}

	public function receivedQuotations()
	{
		return $this->hasMany(Quotation::getProjectClassName());
	}

    public function pallettype()
	{
		return $this->belongsTo(Pallettype::getProjectClassName());
	}

	public function getPallettype() : ? Pallettype
	{
		return $this->pallettype;
	}

	public function makingOrders()
	{
		return $this->orders()->active()->notShipped();
	}

	public function activeOrders()
	{
		return $this->orders()->active();
	}

	public function orders()
	{
		return $this->hasMany(Order::gpc());
	}

	public function quotations()
	{
		return $this->hasMany(Quotation::gpc());
	}

	public function getOrders() : ? Order
	{
		return $this->orders;
	}

	public function products()
	{
		return $this->hasMany(Product::getProjectClassName());
	}

	public function getProducts()
	{
		return $this->getOrFindCachedRelatedElements('products', 360000);
	}
}