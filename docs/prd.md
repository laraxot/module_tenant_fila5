# PRD: Tenant Module

## 📋 Executive Summary
The Tenant module implements multi-tenancy for the PTVX ecosystem, allowing multiple Public Administrations to share the same codebase while maintaining absolute data isolation. It handles tenant detection (domain/subdomain), database scoping, and tenant-specific configuration (theme, language, features).

## 👥 Target Personas
- **PA Administrators**: Need full control over their administration's data and users.
- **Super Administrators**: Need to manage the health and configuration of the entire multi-tenant cluster.
- **AI Agents**: Need global `tenant_id` scoping to prevent data leaks.

## 🎯 Functional Requirements (P0/P1)
- **P0: Data Isolation**: Automatic, non-bypassable scoping for all `XotBaseModel` queries.
- **P0: Tenant Resolution**: Dynamic identification based on URL, Header, or Session.
- **P1: Feature Flags**: Per-tenant activation of specific modules (e.g., Mensa, Europa).
- **P1: Tenant Dashboards**: Isolated admin panels with custom branding.

## 🛠️ Technical Specs
- **Implementation**: Uses `tenant_id` columns on shared tables with global scopes.
- **Isolation**: Separate storage directories and cache namespaces per tenant.
- **Extensibility**: Custom `TenantManager` for administration-specific logic.

## 🔌 Service Interface (The Contract)
- **Querying**: All models MUST use the `HasTenant` trait.
- **Scoping**: Super-admin bypass must be explicit and audited.

## 🛡️ Non-Functional Requirements
- **Security**: Zero tolerance for cross-tenant data leaks (GDPR requirement).
- **Compliance**: Supports Italian PA data residency and portability rules.

## ✅ Release Criteria
- Automated regression tests for data isolation.
- Verification of per-tenant theme and language overrides.
