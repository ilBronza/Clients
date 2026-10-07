<?php

namespace IlBronza\Clients\Tests\Feature;

use IlBronza\Clients\Models\Client;
use IlBronza\Clients\Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ClientFormsTest extends TestCase
{
    public function test_store_and_update_persist_the_standard_fields() : void
    {
        $this->signIn();
        $this->postJson(route('clientsmanagerclients.store'), [
            'name' => 'Acme', 'vat' => '1234', 'fiscal_code' => 'abc123',
            'sdi' => 'abc1234', 'first_color' => '#112233', 'is_client' => true,
        ])->assertRedirect();

        $client = Client::firstOrFail();
        $this->assertSame('00000001234', $client->vat);
        $this->assertSame('ABC123', $client->fiscal_code);
        $this->assertSame('ABC1234', $client->sdi);
        $this->putJson(route('clientsmanagerclients.update', $client), [
            'name' => 'Acme updated', 'vat' => '1234', 'fiscal_code' => 'abc123', 'sdi' => 'def5678',
            'street' => 'Via Roma', 'city' => 'Milano',
        ])->assertRedirect();
        $this->assertSame('Acme updated', $client->fresh()->name);
        $this->assertSame('DEF5678', $client->fresh()->sdi);
        $this->assertSame('Via Roma', $client->fresh()->address->street);
    }

    public function test_invalid_name_sdi_and_colors_do_not_create_a_client() : void
    {
        $this->signIn();
        $this->postJson(route('clientsmanagerclients.store'), [
            'sdi' => 'BAD', 'first_color' => 'blue',
        ])->assertUnprocessable()->assertJsonValidationErrors(['name', 'sdi', 'first_color']);
        $this->assertDatabaseCount('clients__clients', 0);
    }

    public function test_duplicates_are_rejected_on_create_and_update_but_can_be_enabled() : void
    {
        $this->signIn();
        $client = $this->createClient();
        $client->vat = '1234';
        $client->fiscal_code = 'ABC';
        $client->save();
        $payload = ['name' => 'Duplicate', 'vat' => '1234', 'fiscal_code' => 'abc'];

        $this->postJson(route('clientsmanagerclients.store'), $payload)
            ->assertUnprocessable()->assertJsonValidationErrors(['vat', 'fiscal_code']);
        $other = $this->createClient('Other');
        $this->putJson(route('clientsmanagerclients.update', $other), $payload)
            ->assertUnprocessable()->assertJsonValidationErrors(['vat', 'fiscal_code']);
        $this->assertSame('Other', $other->fresh()->name);

        config(['clients.validation.rejectDuplicateFiscalIdentifiers' => false]);
        $this->postJson(route('clientsmanagerclients.store'), $payload)->assertRedirect();
        $this->assertDatabaseCount('clients__clients', 3);
    }

    public function test_invalid_referent_email_is_rejected() : void
    {
        $this->signIn();
        $referent = $this->createClient()->createReferent(['email' => 'valid@example.com']);
        $this->putJson(route('clientsmanagerreferents.update', $referent), ['email' => 'invalid'])
            ->assertUnprocessable()->assertJsonValidationErrors(['email']);
        $this->assertSame('valid@example.com', $referent->fresh()->email);
    }

    public function test_logo_upload_rejects_invalid_files_without_deleting_the_existing_logo() : void
    {
        Storage::fake('public');
        config(['media-library.disk_name' => 'public']);
        $this->signIn();
        $client = $this->createClient();
        $url = route('clientsmanagerclients.logoUpdate', $client);
        $this->putJson($url, [
            'ib-fileupload' => true, 'fieldname' => 'logo', 'file' => UploadedFile::fake()->image('logo.png'),
        ])->assertOk()->assertJson(['success' => true]);
        $media = $client->fresh()->getFirstMedia('logo');
        $this->assertNotNull($media);
        Storage::disk('public')->assertExists($media->getPathRelativeToRoot());

        foreach ([UploadedFile::fake()->create('document.pdf', 10, 'application/pdf'), UploadedFile::fake()->image('large.png')->size(5121)] as $file) {
            $this->putJson($url, ['ib-fileupload' => true, 'fieldname' => 'logo', 'file' => $file])
                ->assertUnprocessable()->assertJsonValidationErrors(['file']);
            $this->assertSame($media->id, $client->fresh()->getFirstMedia('logo')->id);
        }
        $this->putJson($url, [
            'ib-fileupload' => true, 'fieldname' => 'other', 'file' => UploadedFile::fake()->image('logo.png'),
        ])->assertUnprocessable()->assertJsonValidationErrors(['fieldname']);
    }
}
