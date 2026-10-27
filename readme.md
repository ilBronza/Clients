# Clients

Anagrafica clienti e fornitori per applicazioni Laravel dell'ecosistema IlBronza.
Gestisce dati fiscali, indirizzi, destinazioni, referenti e relative tipologie,
colori aziendali e logo.

## Requisiti e integrazioni

- PHP 8.2 o successivo della serie 8; Laravel con minimo dichiarato in Composer.
- Le dipendenze Laravel e le relative integrazioni indicano soltanto versioni
  minime, senza tetti sulle major. Le versioni concrete vengono scelte
  dall’applicazione ospite e fissate nel suo `composer.lock`.
- La suite locale usa Laravel 11, PHP 8.4 e SQLite. La compatibilità del
  codice con altre versioni va verificata eseguendo i test.
- Un'applicazione Laravel ospite con `App\Http\Controllers\Controller` e
  `App\Models\User`, richiesti da CRUD e AccountManager.
- AccountManager e Spatie Permission per autenticazione e ruoli; CRUD, Form,
  FormField, Datatables, Buttons, Menu, UikitTemplate e Ukn per l'interfaccia.
- Addresses, Category, Contacts, Notes e Payments per le relazioni anagrafiche.
  Products è necessario anche al salvataggio del cliente: il trait fornitore
  crea il relativo record Supplier. Operators è richiesto dalle migrazioni.
- FileCabinet è usato dal riquadro bancario del form standard. Warehouse e
  Timeline sono usati dalle integrazioni dei modelli Products.
- Spatie Media Library e il modello media configurato da CRUD, con le relative
  migrazioni. Il modello `IlBronza\CRUD\Models\Media` richiede anche `deleted_at`.

Le versioni dei package IlBronza vanno fissate nel lock dell'applicazione ospite:
il package dichiara i nomi delle dipendenze senza inventare intervalli di
compatibilità per release non verificate. Le dipendenze e le migrazioni dei
package collegati devono essere installate/configurate secondo i rispettivi
requisiti.

## Installazione

Nell'applicazione ospite, con i repository IlBronza già configurati:

```sh
composer require ilbronza/clients
php artisan vendor:publish --tag=clients.config
php artisan migrate
```

Il provider viene individuato tramite Composer e carica automaticamente route,
migrazioni, viste e traduzioni. **Non copiare né registrare una seconda volta
route e migrazioni di Clients.** Prima della prima migrazione devono essere
configurati i nomi delle tabelle Addresses e Operators; le loro tabelle devono
esistere quando il database verifica le chiavi esterne.

Per pubblicare le traduzioni:

```sh
php artisan vendor:publish --tag=clients.translations
```

Configurare un disco Media Library scrivibile. Per un disco locale pubblico,
pubblicare il collegamento allo storage secondo la configurazione dell'app:

```sh
php artisan storage:link
```

Non è necessario pubblicare le viste per usare il package. Gli override Blade
possono essere collocati in `resources/views/vendor/clients/`.

## Route e accesso

Il percorso HTTP standard è `/clients-management`. `clients.routePrefix`
controlla il prefisso dei **nomi** delle route; il valore storico è
`clientsmanager`, senza punto finale. Esempi:

```php
route('clientsmanagerclients.index');
route('clientsmanagerclients.edit', ['client' => $client->getKey()]);
route('clientsmanagerdestinations.index');
route('clientsmanagerreferents.index');
```

Le route usano `web`, `auth` e `clients.roles`. I ruoli predefiniti sono
`administrator`, `clientsManager` e `areaManager`. L'applicazione deve creare e
assegnare questi ruoli; avere un ruolo diverso, incluso `superadmin`, non
aggira automaticamente il middleware del package.

In `config/clients.php` è possibile restringere le singole route:

```php
'defaultRoles' => ['administrator', 'clientsManager'],
'routeRoles' => [
    'clientsmanagerclients.destroy' => ['administrator'],
    'clientsmanagerdestinations.deleteMedia' => ['administrator'],
    'clientsmanagerclients.update' => [], // nega l'accesso a tutti
],
```

Sono accettate anche mappe annidate. Una lista vuota esplicita nega l'accesso;
una route senza override usa `defaultRoles`. I controlli sui singoli modelli
restano quelli di CRUD (`userCanUpdate`, `userCanDelete`, ecc.).

Gli utenti `areaManager` vengono filtrati mediante lo scope
`scopeForAreaManagers` del modello Client configurato dall'applicazione. Se
quello scope non esiste, la query non restituisce clienti. Implementare nello
scope i criteri di assegnazione reali dell'applicazione; non rimuovere il filtro
per compensare una configurazione mancante.

La cancellazione di un media di destinazione accetta esclusivamente `DELETE`:

```php
route('clientsmanagerdestinations.deleteMedia', [
    'destination' => $destination->getKey(),
    'media' => $media->getKey(),
]);
```

Da un form usare `@csrf` e `@method('DELETE')`; da JavaScript inviare il token
CSRF previsto da Laravel. Il media deve appartenere alla destinazione e
l'utente deve poterla modificare mediante il permesso di cancellazione.
Le chiamate GET alla vecchia URL non cancellano file.

## Dati e validazione

- Il nome cliente e i nomi delle tipologie sono obbligatori.
- L'email del referente deve avere formato email valido.
- SDI è disponibile nei form cliente di creazione, modifica e dettaglio:
  è facoltativo e accetta sette caratteri alfanumerici, salvati in maiuscolo.
- I colori devono essere valori esadecimali compatibili con la colonna di
  otto caratteri. Il logo accetta JPEG, PNG, GIF e WebP fino a 5 MiB.
- La validazione del logo si applica anche alle richieste AJAX di upload:
  `ib-fileupload=1`, `fieldname=logo`, file nel campo `file`. Un upload non
  valido non rimuove il logo precedente. Il normale invio del form non
  scrive una colonna `logo` nella tabella clienti.
- Una partita IVA vuota resta `null`. Gli identificativi numerici mantengono
  il padding storico a undici cifre; quelli alfanumerici internazionali
  vengono conservati e convertiti in maiuscolo. Il codice fiscale viene
  ripulito dagli spazi esterni e convertito in maiuscolo.

I form standard impediscono di riutilizzare partita IVA o codice fiscale di
un'altra anagrafica attiva. Il controllo include anche clienti nascosti dagli
scope dell'utente; esclude il record in modifica e le anagrafiche cancellate
logicamente. Non effettua accorpamenti o bonifiche dei dati esistenti.

Per consentire duplicati legittimi, o durante una bonifica, impostare:

```php
'validation' => [
    'rejectDuplicateFiscalIdentifiers' => false,
],
```

È un controllo applicativo dei form, non un vincolo univoco nel database:
importazioni, scritture Eloquent dirette e richieste concorrenti richiedono
una politica coerente nell'applicazione. Le regole non verificano la validità
fiscale presso registri esterni.

## Destinazioni e referenti

```php
$destination = $client->createDestination();
$destination->setAsDefault();
$destination->setAsLegal();

$referent = $client->createReferent(['email' => 'ufficio@example.com']);
$destination->referents()->syncWithoutDetaching([$referent->getKey()]);
```

`getDestination()` e `getDefaultDestination()` possono restituire `null`.
Una destinazione unica viene scelta automaticamente come predefinita; con
zero destinazioni o più destinazioni senza default non viene effettuata una
scelta arbitraria. `getLegalDestination()` può usare quella predefinita come
sede legale. Il tipo legale viene creato se manca.

Assegnare una destinazione come predefinita o legale rimuove quel tipo dalle
altre destinazioni dello stesso cliente. Gli altri tipi e gli altri clienti
restano invariati. Dopo modifiche alle relazioni su istanze diverse, usare
`refresh()` o `fresh()` per ricaricare eventuali relazioni già memorizzate.

La tabella `destinationReferent` è una pivot con `destination_id`,
`referent_id` e `priority`, senza timestamp né soft delete. Le sue relazioni
`destination()` e `referent()` sono `belongsTo`.

## Estensione e configurazione

Le classi sono risolte tramite `clients.models.*`. Per cambiare singole chiavi
senza perdere il resto della configurazione, nel `register()` del provider
applicativo, dopo la registrazione di Clients:

```php
$this->app['config']->set('clients.models.client.class', \App\Models\Client::class);
$this->app['config']->set('clients.models.client.controllers.index', \App\Http\Controllers\ClientIndexController::class);
$this->app['config']->set('clients.models.client.parametersFiles.edit', \App\Http\Parameters\ClientEditParameters::class);
```

I modelli personalizzati devono estendere quelli del package e mantenere le
relazioni richieste. Per client e fornitori filtrati sono disponibili anche
`models.client.asClient` e `models.client.asSupplier`. Se si personalizzano i
form, estendere i parameter file standard permette di conservare le regole
di validazione introdotte dal package.

Le azioni delle destinazioni usano `models.destination.controllers.*`.
Il riferimento legacy `models.destination.controller` punta al controller
di elenco; non rappresenta un controller resource completo.

`destinations.enabled` e `referents.enabled` controllano le sezioni delle
relazioni nel dettaglio cliente, non disabilitano le rispettive route:
per limitare l'accesso utilizzare i ruoli.

Cambiare `models.*.table` prima dell'installazione permette di personalizzare
i nomi delle tabelle. Cambiare solo la configurazione su un database già
popolato non rinomina le tabelle: serve una migrazione dell'applicazione.
Quando si aggiorna una configurazione pubblicata, confrontarla con i nuovi
default e conservare tutte le chiavi necessarie: il merge Laravel non è
ricorsivo per gli array di modelli.

Le migrazioni iniziali popolano i tipi predefiniti. Il rollback della sola
migrazione di popolamento conserva i dati, perché potrebbero essere
preesistenti o referenziati. Il rollback completo elimina le tabelle attraverso
le migrazioni che le hanno create. Le correzioni ai file di migrazione storici
non rieseguono operazioni sui database già migrati.

I controller/helper legacy `Clienthash` sono presenti ma il loro flusso di
accesso e invio non è completo.

## Test

Con le dipendenze di sviluppo installate:

```sh
composer test
composer test:lint
```

Nel workspace IlBronza si può usare il vendor condiviso senza installazioni:

```sh
php ../.ibtest/vendor/phpunit/phpunit/phpunit -c phpunit.xml
```

Il bootstrap preferisce `vendor/` locale; se manca usa `.ibtest/vendor` e i
checkout dei package fratelli. La suite crea un'applicazione Testbench sotto
`tests/.runtime/` (ignorata da Git), usa SQLite in memoria e non modifica
l'applicazione ospite o il vendor condiviso. Non usa `RefreshDatabase`.

Sono coperti salvataggio e modifica via HTTP, validazioni, upload logo,
ruoli e CSRF, appartenenza dei media, destinazioni e referenti, risoluzione
della configurazione, migrazioni e rollback anche con nomi tabella diversi.
I test non coprono l'intera interfaccia Blade né tutte le integrazioni Products.
Alcuni scope aggregati legacy (`withTypesString`) usano ancora sintassi MySQL:
la suite SQLite non implica la portabilità completa di tutti gli elenchi.
