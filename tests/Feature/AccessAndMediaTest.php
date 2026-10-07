<?php

namespace IlBronza\Clients\Tests\Feature;

use IlBronza\Clients\Models\Client;
use IlBronza\Clients\Tests\TestCase;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AccessAndMediaTest extends TestCase
{
    public function test_guests_and_users_without_a_package_role_cannot_write() : void
    {
        $this->postJson(route('clientsmanagerclients.store'), ['name' => 'Hidden'])->assertUnauthorized();
        $this->signIn('visitor');
        $this->postJson(route('clientsmanagerclients.store'), ['name' => 'Hidden'])->assertForbidden();
        $this->assertDatabaseCount('clients__clients', 0);
    }

    public function test_route_specific_roles_and_explicit_denial_are_honoured() : void
    {
        $this->signIn('clientsManager');
        $client = $this->createClient();
        $url = route('clientsmanagerclients.update', $client);
        config(['clients.routeRoles' => ['clientsmanagerclients.update' => ['administrator']]]);
        $this->putJson($url, ['name' => 'Forbidden'])->assertForbidden();

        config(['clients.routeRoles' => ['clientsmanagerclients.update' => []]]);
        $this->putJson($url, ['name' => 'Forbidden'])->assertForbidden();
        config(['clients.routeRoles' => ['clientsmanagerclients' => ['update' => ['clientsManager']]]]);
        $this->putJson($url, ['name' => 'Allowed'])->assertRedirect();
        $this->assertSame('Allowed', $client->fresh()->name);
    }

    public function test_area_manager_without_an_application_scope_sees_no_clients() : void
    {
        $this->createClient();
        $this->signIn('areaManager');
        $this->assertCount(0, Client::all());
    }

    public function test_missing_models_return_not_found() : void
    {
        $this->signIn();
        $missing = '00000000-0000-0000-0000-000000000000';
        foreach (['clients.show', 'clients.edit', 'clients.logoFetcher', 'referents.edit', 'destinationtypes.edit', 'referenttypes.edit'] as $route) {
            $this->getJson(route('clientsmanager' . $route, $missing))->assertNotFound();
        }
    }

    public function test_media_can_only_be_deleted_from_its_owner_using_delete() : void
    {
        Storage::fake('public');
        $this->signIn();
        $client = $this->createClient();
        $destination = $client->createDestination();
        $other = $client->createDestination();
        $media = $destination->addMedia(UploadedFile::fake()->image('image.png'))->toMediaCollection('images', 'public');
        $url = route('clientsmanagerdestinations.deleteMedia', [$destination, $media]);

        $this->getJson($url)->assertStatus(405);
        $this->deleteJson(route('clientsmanagerdestinations.deleteMedia', [$other, $media]))->assertForbidden();
        $this->assertNotSoftDeleted('media', ['id' => $media->id]);
        $this->deleteJson($url)->assertOk()->assertJson(['success' => true]);
        $this->assertSoftDeleted('media', ['id' => $media->id]);
    }

    public function test_media_delete_requires_csrf_in_a_browser_session() : void
    {
        $this->app->bind(ValidateCsrfToken::class, RequireCsrfToken::class);
        $this->signIn();
        $destination = $this->createClient()->createDestination();
        Storage::fake('public');
        $media = $destination->addMedia(UploadedFile::fake()->image('image.png'))->toMediaCollection('images', 'public');
        $url = route('clientsmanagerdestinations.deleteMedia', [$destination, $media]);

        $this->deleteJson($url)->assertStatus(419);
        $this->assertNotSoftDeleted('media', ['id' => $media->id]);
        $this->withSession(['_token' => 'test-token'])->deleteJson($url, ['_token' => 'test-token'])->assertOk();
    }
}

class RequireCsrfToken extends ValidateCsrfToken
{
    protected function runningUnitTests()
    {
        return false;
    }
}
