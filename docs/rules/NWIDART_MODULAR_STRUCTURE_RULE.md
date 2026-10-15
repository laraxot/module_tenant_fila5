# NWIDART MODULAR STRUCTURE - CRITICAL RULE

**STATUS**: MANDATORY - Violation = Architect Error  
**Last Updated**: 2026-10-15  
**Severity**: CRITICAL

---

## THE RULE

**EVERY MODULE MUST CONTAIN ITS OWN `/tests/` DIRECTORY**

```
✅ CORRECT:
laravel/Modules/Xot/
  ├── tests/
  │   ├── Feature/
  │   ├── Unit/
  │   └── TestCase.php
  ├── app/
  ├── config/
  ├── composer.json
  └── README.md

❌ WRONG:
laravel/tests/Modules/Xot/
  ← This violates Nwidart principle of module independence
```

---

## WHY THIS MATTERS

Nwidart Modules = **Each module is a standalone package**

- Each has `vendor/` (composer.json)
- Each has `config/` 
- Each has `tests/` **INSIDE the module**
- Each is independently deployable
- Each is independently testable

**Centralizing tests breaks this principle.**

---

## ANTI-PATTERN

❌ Never create: `laravel/tests/Modules/<Modulo>/`  
❌ Never assume Laravel structure for modules  
❌ Never centralize module tests  
❌ Never split module structure across directories  

---

## VERIFICATION CHECKLIST

- [ ] `Modules/Xot/tests/` exists
- [ ] `Modules/Xot/composer.json` exists
- [ ] No `laravel/tests/Modules/Xot/` directory
- [ ] Tests run with: `php artisan test --path=Modules/Xot/tests`
- [ ] Coverage measurable: `php artisan test --coverage --path=Modules/Xot/tests`

---

## HISTORY

**2026-10-15**: Critical error in session - suggested centralizing tests in `laravel/tests/Modules/`  
**CORRECTION**: Documented this rule to prevent future violations  
**IMPACT**: This is fundamental to Nwidart architecture

