# Custom Log Entry

Allows users to add a custom entry to a project's log, optionally linked to a record.

## Purpose

A git commit documents what was changed whereas its commit message explains why.

This module is intended to complement automated project logging, and allow project owners or superusers to document various actions and the reasons behind those actions. The regular log might show that an administrator removed four users from a project, or that they moved the project from production back to development, but it will omit the reasoning behind those decisions. This module allows administrators, or users, to add comments to the project's audit trail, for their own protection.

## Setup

Install the module from REDCap module repository and enable over Control Center. This module should be enabled for all projects rather than per-project.

## Usage

The Custom Log Entry page allows users – either project users with the Logging user right, or superusers – to enter a note to be logged against their username. They may optionally select a record from the project to associate the log entry with. Doing so will mean that an entry will be filterable from the Logging page.

Upon submitting the custom entry, the user is redirected to the Logging page.

## Changelog

Version | Description
------- | --------------------
v1.0.0  | Initial release.
