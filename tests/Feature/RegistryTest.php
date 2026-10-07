<?php

namespace IlBronza\Clients\Tests\Feature;

use IlBronza\Clients\Models\Client;
use IlBronza\Clients\Models\Destinatable;
use IlBronza\Clients\Models\DestinationReferent;
use IlBronza\Clients\Models\Destinationtype;
use IlBronza\Clients\Models\Referenttype;
use IlBronza\Clients\Tests\TestCase;

class RegistryTest extends TestCase
{
    public function test_client_without_destinations_returns_null() : void
    {
        $this->assertNull($this->createClient()->getDestination());
    }

    public function test_a_single_destination_becomes_default_and_can_be_legal() : void
    {
        $client = $this->createClient();
        $destination = $client->createDestination();

        $this->assertTrue($client->getDestination()->is($destination));
        $this->assertTrue($client->getLegalDestination()->is($destination));
        $this->assertTrue(Destinationtype::getLegal()->destinations()->first()->is($destination));
    }

    public function test_changing_default_preserves_other_clients_and_other_types() : void
    {
        $client = $this->createClient();
        $first = $client->createDestination();
        $second = $client->createDestination();
        $other = $this->createClient('Other')->createDestination();
        $first->setAsDefault();
        $first->setAsLegal();
        $other->setAsDefault();
        $second->setAsDefault();

        $this->assertFalse($first->isDefault());
        $this->assertTrue($second->isDefault());
        $this->assertTrue($other->isDefault());
        $this->assertTrue($client->fresh()->getLegalDestination()->is($first));
    }

    public function test_referents_can_be_attached_and_resolved_in_both_directions() : void
    {
        $client = $this->createClient();
        $referent = $client->createReferent(['email' => 'contact@example.com']);
        $destination = $client->createDestination();
        $destination->referents()->attach($referent);

        $pivot = DestinationReferent::query()->firstOrFail();
        $this->assertTrue($pivot->destination->is($destination));
        $this->assertTrue($pivot->referent->is($referent));
        $this->assertTrue($referent->destinations()->first()->is($destination));
    }

    public function test_destinatable_uses_the_configured_table() : void
    {
        $this->assertSame('clients__destinatable', (new Destinatable)->getTable());
    }

    public function test_multiple_destinations_without_a_default_are_not_chosen_arbitrarily() : void
    {
        $client = $this->createClient();
        $client->createDestination();
        $client->createDestination();
        $this->assertNull($client->getDestination());
    }

    public function test_referent_address_creation_is_persisted_and_reused() : void
    {
        $referent = $this->createClient()->createReferent(['email' => 'contact@example.com']);
        $address = $referent->provideAddressModelForExtraFields();
        $this->assertTrue($address->exists);
        $this->assertTrue($referent->fresh()->provideAddressModelForExtraFields()->is($address));
        $this->assertDatabaseCount('clients__destination_referent', 1);
        $this->assertDatabaseCount('addresses', 1);
    }

    public function test_referents_are_filtered_by_type_and_client() : void
    {
        $client = $this->createClient();
        $type = Referenttype::create(['name' => 'Billing']);
        $matching = $client->createReferent(['email' => 'billing@example.com']);
        $matching->addTypes([$type->getKey()]);
        $client->createReferent(['email' => 'other@example.com']);
        $this->createClient('Other')->createReferent(['email' => 'other-billing@example.com'])->addTypes([$type->getKey()]);
        $this->assertSame([$matching->getKey()], $client->getReferentsByTypes(['Billing'])->modelKeys());
    }

    public function test_default_destination_id_scope_returns_the_matching_id() : void
    {
        $client = $this->createClient();
        $destination = $client->createDestination();
        $destination->setAsDefault();
        $this->assertSame($destination->getKey(), Client::withDefaultDestinationId()->findOrFail($client->getKey())->live_default_destination_id);
    }

    public function test_vat_keeps_empty_values_null_and_preserves_international_identifiers() : void
    {
        $client = new Client;
        foreach ([null, '', '   '] as $value) {
            $client->vat = $value;
            $this->assertNull($client->vat);
        }
        $client->vat = '1234';
        $this->assertSame('00000001234', $client->vat);
        $client->vat = ' de123456789 ';
        $this->assertSame('DE123456789', $client->vat);
    }
}
