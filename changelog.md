# Changelog

All notable changes to `Clients` will be documented in this file.

## Unreleased

### Fixed
- Model loading, destination/referent relationships, nullable destination access,
  address creation and referent filtering by type.
- Missing configuration references and 404 responses for missing registry records.
- Duplicate migration index names, configurable SDI table name and non-destructive
  rollback of seeded destination/referent types.
- Destination media deletion now requires DELETE, CSRF, ownership and model rights.
- Per-route role overrides support flat/nested keys and explicit empty denial.
- Area managers without an application assignment scope receive no clients.

### Added
- Regression tests for registry writes, validation, media, access and migrations.
- SDI form field, email/color/image validation and fiscal identifier normalization.
- Configurable rejection of duplicate active fiscal identifiers in standard forms.
- Runtime/development dependency declarations and integration documentation.

### Upgrade notes
- Update custom media deletion callers to DELETE with a CSRF token.
- Merge new configuration keys into any published clients.php file.
- Fiscal identifier duplicates are rejected by default in standard forms; set
  validation.rejectDuplicateFiscalIdentifiers to false where duplicates are intended.
- Existing migrations are not rerun and existing duplicate data is not changed.

## Version 1.0

### Added
- Everything
