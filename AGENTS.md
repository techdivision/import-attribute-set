# AGENTS.md - import-attribute-set

## Zweck & Verantwortung

Das `import-attribute-set` Modul bietet **Attribute Set & Group Import-Funktionalität**. Es ist ein **Tier 5 Modul** und erweitert `import-attribute`.

**Hauptverantwortung:**
- Attribute Set Import
- Attribute Group Import
- Repository Pattern für Attribute Sets
- Service Layer für Attribute Set-Verarbeitung
- Observer Pattern für Attribute Set-Hooks

## Architektur & Design Patterns

### Kern-Klassen
- **AttributeSetRepository**: Persistierung von Attribute Sets
- **AttributeGroupRepository**: Persistierung von Attribute Groups
- **AttributeSetProcessor**: Service Layer
- **AttributeSetObserver**: Observer für Hooks

### Verwendete Patterns
- **Observer Pattern**: Für Attribute Set-Hooks
- **Repository Pattern**: Für Daten-Persistierung
- **Service Layer**: Für Business Logic

## Abhängigkeiten

### Externe Pakete
- **Keine**

### TechDivision Dependencies
- **import-attribute** ^23.1 - Attribute Importer

### Abhängig von diesem Modul (1 Reverse Dependency)
- **import-cli-simple** - Master CLI

## Wichtige Entry Points

### Repository Klassen
```php
// Attribute Set Repository
AttributeSetRepository::create($row): void
AttributeSetRepository::findByName($name): array

// Attribute Group Repository
AttributeGroupRepository::create($row): void
```

## Events & Extension Points

**Keine Events** - Tier 5 Importer-Modul

## Hints für KI-Agenten

### Wichtig zu verstehen
1. **Tier 5 Modul**: Erweitert Attribute Importer
2. **Spezialisiert**: Nur für Attribute Sets & Groups
3. **Observer Pattern**: Für Hooks
4. **Repository Pattern**: Für Persistierung

## Bekannte Einschränkungen

- **Attribute-Set-Only**: Keine anderen Features
- **Abhängig von Attributes**: Erfordert Attribute zu existieren

## Zusammenfassung

`import-attribute-set` ist ein **Tier 5 Modul**, das Attribute Set & Group Import-Funktionalität bietet. Es erweitert den Attribute Importer mit spezialisierter Funktionalität.

**Für Agenten:** Verstehe dieses Modul als **Attribute Set Importer** mit Observer und Repository Pattern.
