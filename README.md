# Custom Log Entry

Allows users to add a custom entry to a project's log, optionally linked to a record, via a page or via the REDCap API, for project audit purposes.

## Purpose

A git commit documents what was changed whereas its commit message explains why.

This module is intended to complement automated project logging, and allow project owners or superusers to document various actions and the reasons behind those actions. The regular log might show that an administrator removed four users from a project, or that they moved the project from production back to development, but it will omit the reasoning behind those decisions. This module allows administrators, or users, to add comments to the project's audit trail, for their own protection.

## Setup

Install the module from REDCap module repository and enable in the Control Center. This module should be enabled for all projects rather than per-project.

## Usage

### Project page

The Custom Log Entry sidebar page allows users with appropriate permissions (see [Permissions](#permissions) below) to enter a note to be logged against their username. They may optionally select a record from the project to associate the log entry with. Doing so will mean that an entry will be filterable from the Logging page.

Upon submitting the custom entry, the user is shown a success message. They may then navigate to the Logging page to view the entry.

### API

This module adds an API endpoint so that log entries can be programmatically added.

To use the API endpoint, the user must have the External Modules API privilege, and they must also have the Logging user right, or else the module should be configured to allow other users without this privilege to submit log entries (see [Permissions](#permissions) below).

The API call is structured as follows:

```sh
curl -F "token=APITOKEN" \
     -F "content=externalModule" \
     -F "prefix=custom_log_entry" \
     -F "action=add" \
     -F "comment=<Logging Note>" \
     -F "record=<Record ID (optional)>" \
     https://domain.tld/redcap/api/
```

If the `comment` parameter is missing or the `record` parameter contains a value that does not resolve to a record in the project, the API will return a `400` error. Otherwise, the API will return a `200` success message.


### Permissions

The module by default only allows super users, and users with Logging privilege to add custom log entries. However, if desired, the module allows this limitation to be overridden at either the system level or on a per-project basis in the configuration options.

**Note**: Super users cannot use the API method unless they have been explicitly granted access to the project and have a token.

## Changelog

Version | Description
------- | --------------------
v1.0.0  | Initial release.
v1.1.0  | Record select now supports custom record labels, and becomes a search box if number of records is 5000 or more.
v1.2.0  | Adds an API method for adding entries to the log. Adds configurable override for permissions to use module.
