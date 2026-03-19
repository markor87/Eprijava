# Project Setup Guide

## Stack
- Laravel 12, Filament 5, MySQL, PHP 8.2

---

## Login
- URL: `http://localhost/app/login`
- Email: `admin@example.com`
- Password: `password`

---

## Database

MySQL. Database name: `eprijava`.

### MySQL key length fix
Older MySQL servers have a 1000-byte max key length. With `utf8mb4` (4 bytes/char), composite unique indexes (e.g. Spatie's `name + guard_name`) exceed this limit at the default 255-char string length.

Fix applied in `app/Providers/AppServiceProvider.php`:
```php
Builder::defaultStringLength(100);
```
100 chars × 4 bytes × 2 columns = 800 bytes — safely under the limit. No practical impact; permission/role names are always well under 100 chars.

---

## What Was Done

### 1. Roles & Permissions (Spatie + Filament Shield)
- `spatie/laravel-permission ^6.0` — v6 required for PHP 8.2 (v7 needs PHP 8.4)
- `bezhansalleh/filament-shield ^4.0` — v4 supports Filament 5
- Spatie tables migrated: `roles`, `permissions`, `model_has_roles`, `model_has_permissions`, `role_has_permissions`
- `HasRoles` trait added to `User` model
- `FilamentShieldPlugin` registered in `AdminPanelProvider`
- `super_admin` role seeded and assigned to `admin@example.com`

### 2. Single panel at `/app`
One Filament panel for all users. Sidebar items are visible based on each user's role and permissions. Panel was renamed from the default `/admin` to `/app`.

### 3. UserResource
`app/Filament/Resources/Users/UserResource.php`
- Form: name, email, password (hashed; optional on edit), roles multi-select
- Table: name, email, roles as badges
- Grouped under **Filament Shield** in the sidebar

### 4. Candidates table & model
Migration: `database/migrations/2026_03_18_192414_create_candidates_table.php`

| Field | Type | Notes |
|---|---|---|
| user_id | foreignId | FK → users, cascade delete |
| first_name | string | |
| last_name | string | |
| national_id | string(13) | unique, JMBG |
| citizenship | string | |
| place_of_birth | string | |
| address_street | string | Residence |
| address_postal_code | string | |
| address_city | string | |
| delivery_street | string\|null | null = same as residence |
| delivery_postal_code | string\|null | |
| delivery_city | string\|null | |
| phone | string | |
| email | string | |
| alternative_delivery | text\|null | Free text |
| timestamps | | created_at, updated_at |

Model: `app/Models/Candidate.php` — all fields fillable, `belongsTo(User)`.
User model has `hasOne(Candidate)`.

### 5. CandidateResource
`app/Filament/Resources/Candidates/CandidateResource.php`
- Full CRUD: table list, create, edit, delete
- Grouped under **Мој профил** → **Лични подаци** in the sidebar
- `mutateFormDataBeforeCreate` in `CreateCandidate.php` automatically sets `user_id` to the logged-in user
- Form sections (Serbian labels): Лични подаци, Адреса пребивалишта, Адреса за доставу, Контакт, Остало
- Table columns: Презиме, Име, ЈМБГ, Е-пошта, Телефон, Место — with search and sort
- Edit and Delete actions per row; bulk delete
- `$modelLabel` and `$pluralModelLabel` both set to `'Лични подаци'` — UI shows "Лични подаци" everywhere, URL stays `/app/candidates`
- Create button label overridden to **"Додај личне податке"** in `ListCandidates.php` via `CreateAction::make()->label('Додај личне податке')`

#### Filament 5 notes (fixes applied)
- `form()` method signature: `Schema $schema` (not `Form $form`) — import `Filament\Schemas\Schema`
- `Section` comes from `Filament\Schemas\Components\Section` (not `Filament\Forms\Components\Section`)
- In `content()` override, use `Form::make([EmbeddedSchema::make('form')])` with `->livewireSubmitHandler('save')`
- `$navigationGroup` type must be `string|UnitEnum|null` (not `?string`)
- `visible()` closures: do NOT type-hint `Get` — use `fn($get)` not `fn(Get $get)`. `Filament\Forms\Get` does not exist in Filament 5; the correct class is `Filament\Schemas\Components\Utilities\Get` but the type hint still causes a runtime TypeError. Drop the type hint entirely.

#### Structure
```
app/Filament/Resources/Candidates/
├── CandidateResource.php
├── Pages/
│   ├── ListCandidates.php
│   ├── CreateCandidate.php   ← sets user_id automatically
│   └── EditCandidate.php
├── Schemas/
│   └── CandidateForm.php
└── Tables/
    └── CandidatesTable.php
```

### 6. Education — two separate tables & models

The single `educations` table was replaced with two dedicated tables. Migration history:
- `2026_03_19_072219_create_educations_table.php` — kept as-is (creates old `educations` table, matches DB state before split)
- `2026_03_19_120000_replace_educations_with_split_tables.php` — drops `educations`, creates `high_school_educations` and `higher_educations`

#### `high_school_educations`

| Field | Type | Notes |
|---|---|---|
| user_id | foreignId | FK → users, cascade delete |
| institution_name | string\|null | |
| institution_location | string\|null | |
| duration | string\|null | e.g. "4 године" |
| direction | string\|null | e.g. "Природно-математички" |
| occupation | string\|null | Not filled by gymnasium graduates |
| graduation_year | smallint unsigned\|null | |
| timestamps | | |

Model: `app/Models/HighSchoolEducation.php` — `$table = 'high_school_educations'` (explicit), all fields fillable, `belongsTo(User)`.

#### `higher_educations`

| Field | Type | Notes |
|---|---|---|
| user_id | foreignId | FK → users, cascade delete |
| study_type | string\|null | `basic_4yr` \| `3yr` \| `academic` \| `vocational` \| `vocational_academic` |
| institution_name | string\|null | |
| institution_location | string\|null | |
| volume_espb_or_years | string\|null | e.g. "240 ЕСПБ" |
| program_name | string\|null | |
| title_obtained | string\|null | |
| graduation_date | string\|null | Free text, e.g. "15.06.2020." |
| timestamps | | |

Model: `app/Models/HigherEducation.php` — `$table = 'higher_educations'` (explicit), all fields fillable, `belongsTo(User)`.

User model has `highSchoolEducations(): HasMany` and `higherEducations(): HasMany`.

**Note:** Always set `$table` explicitly on these models — Laravel's pluralizer maps `HighSchoolEducation` → `high_school_education` (singular) and `HigherEducation` → `higher_education` (singular).

### 7. HighSchoolEducationResource & HigherEducationResource

Two fully independent CRUD resources, both grouped under **Мој профил** in the sidebar.

| Resource | Nav label | Nav sort | Slug |
|---|---|---|---|
| `HighSchoolEducationResource` | Средња школа | 2 | `high-school-educations` |
| `HigherEducationResource` | Високо образовање | 3 | `higher-educations` |

- `$slug` set explicitly on both — Filament would otherwise generate singular slugs
- `mutateFormDataBeforeCreate` in each `Create*` page sets `user_id = auth()->id()`
- Create button labels: **"Додај школу"** / **"Додај факултет / установу"**

#### Structure
```
app/Filament/Resources/HighSchoolEducations/
├── HighSchoolEducationResource.php
├── Pages/
│   ├── ListHighSchoolEducations.php
│   ├── CreateHighSchoolEducation.php   ← sets user_id automatically
│   └── EditHighSchoolEducation.php
├── Schemas/
│   └── HighSchoolEducationForm.php
└── Tables/
    └── HighSchoolEducationsTable.php

app/Filament/Resources/HigherEducations/
├── HigherEducationResource.php
├── Pages/
│   ├── ListHigherEducations.php
│   ├── CreateHigherEducation.php       ← sets user_id automatically
│   └── EditHigherEducation.php
├── Schemas/
│   └── HigherEducationForm.php
└── Tables/
    └── HigherEducationsTable.php
```

#### Filament 5 note
Custom `Page` classes: `$view` must be **non-static** (`protected string $view`, not `protected static string $view`). The parent `Filament\Pages\Page` declares it as non-static; redeclaring as static causes a fatal error.

### 8. WorkExperienceResource

Migration history:
- `2026_03_19_150000_create_work_experiences_table.php` — creates table (originally with Serbian column names)
- `2026_03_19_160000_rename_work_experiences_columns.php` — renames all columns to English

#### `work_experiences`

| Field | Type | Notes |
|---|---|---|
| user_id | foreignId | FK → users, cascade delete |
| period_from | date | |
| period_to | date\|null | null = current job |
| employer_name | string | |
| job_title | string | |
| job_description | text\|null | |
| employment_basis | string\|null | `fixed_term` \| `permanent` \| `other` |
| required_education | json\|null | multiple-choice checkboxes: `high_school` \| `3yr_180espb` \| `4yr_240espb` |
| timestamps | | |

Model: `app/Models/WorkExperience.php` — `$table = 'work_experiences'` (explicit), all fields fillable, JSON cast on `required_education`, date casts on `period_from`/`period_to`, `belongsTo(User)`.
User model has `workExperiences(): HasMany`.

- Nav group **Мој профил**, label **Радно искуство**, sort=4, slug=`work-experiences`
- `mutateFormDataBeforeCreate` sets `user_id = auth()->id()`
- Create button label: **"Додај радно искуство"**
- `period_to` uses `->helperText()` (renders below the field) instead of `->hint()` — avoids breaking the 2-column layout with long text
- Table sorted by `period_from` descending; `period_to` placeholder shows **"тренутно"** when null

#### Structure
```
app/Filament/Resources/WorkExperiences/
├── WorkExperienceResource.php
├── Pages/
│   ├── ListWorkExperiences.php      ← "Додај радно искуство"
│   ├── CreateWorkExperience.php     ← sets user_id automatically
│   └── EditWorkExperience.php
├── Schemas/
│   └── WorkExperienceForm.php
└── Tables/
    └── WorkExperiencesTable.php
```

### 9. TrainingResource (Стручни и други испити)

Migration: `database/migrations/2026_03_19_170000_create_trainings_table.php`

#### `trainings`

| Field | Type | Notes |
|---|---|---|
| user_id | foreignId | FK → users, cascade delete |
| has_certificate | boolean | Да = true, Не = false |
| exam_type | string | Stored in Serbian: `Државни стручни испит` \| `Испит за инспектора` \| `Правосудни испит` |
| issuing_authority | string\|null | Назив органа / правног лица које је издало доказ |
| exam_date | date\|null | |
| timestamps | | |

Model: `app/Models/Training.php` — `$table = 'trainings'` (explicit), all fields fillable, boolean cast on `has_certificate`, date cast on `exam_date`, `belongsTo(User)`.
User model has `trainings(): HasMany`.

- Nav group **Мој профил**, label **Стручни и други испити**, sort=5, slug=`trainings`
- `mutateFormDataBeforeCreate` sets `user_id = auth()->id()`
- Create button label: **"Додај испит"**
- `exam_type` stored as Serbian text directly — no key/label mapping needed anywhere
- `has_certificate` displayed in table as Да / Не via `formatStateUsing`

#### Structure
```
app/Filament/Resources/Trainings/
├── TrainingResource.php
├── Pages/
│   ├── ListTrainings.php        ← "Додај испит"
│   ├── CreateTraining.php       ← sets user_id automatically
│   └── EditTraining.php
├── Schemas/
│   └── TrainingForm.php
└── Tables/
    └── TrainingsTable.php
```

### 10. ForeignLanguageSkillResource (Страни језици)

Migration: `database/migrations/2026_03_19_180000_create_foreign_language_skills_table.php`

#### `foreign_language_skills`

| Field | Type | Notes |
|---|---|---|
| user_id | foreignId | FK → users, cascade delete |
| language | string | Language name |
| level | string | CEFR: А1 \| А2 \| Б1 \| Б2 \| Ц1 \| Ц2 (stored as Cyrillic) |
| has_certificate | boolean | Да = true, Не = false |
| year_of_examination | smallint unsigned\|null | Year only |
| exemption_requested | boolean | Прилаже оверену фотокопију ради ослобађања тестирања |
| certificate_attachment | string\|null | File path (disk: public) |
| timestamps | | |

Model: `app/Models/ForeignLanguageSkill.php` — `$table = 'foreign_language_skills'` (explicit), all fields fillable, boolean casts on `has_certificate` and `exemption_requested`, `belongsTo(User)`.
User model has `foreignLanguageSkills(): HasMany`.

- Nav group **Мој профил**, label **Страни језици**, sort=6, slug=`foreign-language-skills`
- `mutateFormDataBeforeCreate` sets `user_id = auth()->id()`
- Create button label: **"Додај страни језик"**
- CEFR levels stored as Cyrillic text (А1–Ц2) directly — same key/label pattern as `exam_type` in trainings
- `has_certificate` and `exemption_requested` displayed in table as Да / Не via `formatStateUsing`

#### File upload behavior
- `certificate_attachment` stored on `public` disk under `certificate-attachments/{user_id}/` — each user gets a dedicated subfolder
- Requires `php artisan storage:link` to serve files over HTTP
- **On delete:** `booted()` in the model fires `Storage::disk('public')->delete()` — file removed with the record
- **On edit (file removed or replaced):** `updating` hook checks `isDirty('certificate_attachment')` and deletes the old file from disk before saving

#### Structure
```
app/Filament/Resources/ForeignLanguageSkills/
├── ForeignLanguageSkillResource.php
├── Pages/
│   ├── ListForeignLanguageSkills.php   ← "Додај страни језик"
│   ├── CreateForeignLanguageSkill.php  ← sets user_id automatically
│   └── EditForeignLanguageSkill.php
├── Schemas/
│   └── ForeignLanguageSkillForm.php
└── Tables/
    └── ForeignLanguageSkillsTable.php
```

### 11. UserResource — access control fix
`canAccess()` added to `UserResource` so only users with `super_admin` role or explicit `*_user` permissions can see **Filament Shield → Users**. Without this, all authenticated users saw the page regardless of role.

---

## Day-to-Day

### After adding a new Filament resource or page
```bash
php artisan shield:generate --all --panel=app --option=permissions
```
Then assign the new permissions to roles via **Filament Shield → Roles**.

### Create/manage roles
Panel → **Filament Shield** → **Roles** → assign permissions per role.

### Assign roles to users
Panel → **Filament Shield** → **Users** → edit user → select roles.

### Make a user super admin
```bash
php artisan shield:super-admin --user={id} --panel=app
```
`super_admin` bypasses all permission checks.
