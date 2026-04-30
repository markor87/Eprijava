Ready for review
Select text to add comments on the plan
Plan: Database Schema za "Образац пријаве на конкурс 2026"
Context
Образац је званична пријава за конкурс у државном органу Републике Србије. Потребно је дизајнирати базу која ће омогућити електронско попуњавање обрасца. Форма има две стране: орган попуњава (конкурс, тражена документа, испити) и кандидат попуњава (лични подаци, образовање, искуство, одговори по конкурсу).
________________________________________
Анализа секција обрасца
Секције које попуњава ОРГАН (по конкурсу):
•	Радно место, звање, назив органа
•	Врсте испита које се захтевају
•	Страни језици које захтева конкурс
•	Докази I врсте (орган прибавља)
•	Докази II врсте (кандидат доставља)
•	Националне мањине (ако је применљиво)
Секције које попуњава КАНДИДАТ:
•	Лични подаци (фиксни – исти за сваки конкурс)
•	Образовање: средња школа + факултет (1:N)
•	Радно искуство (1:N, понавља се)
•	Додатне обуке и знања (1:N)
•	Одговори специфични за конкурс (испити, језици, документа, итд.)
________________________________________
Препоручена структура табела (14 табела)
1. users — Laravel auth (постоји)
2. candidates — профил кандидата
id, user_id, prezime, ime, maticni_broj, drzavljanstvo,
mesto_rodjenja,
// адреса пребивалишта
adresa_ulica, adresa_postanski_broj, adresa_mesto,
// адреса за доставу (nullable ако иста)
dostava_ulica, dostava_postanski_broj, dostava_mesto,
telefon, email_adresa, drugi_nacin_dostave
3. educations — образовање кандидата (1:N)
id, user_id,
vrsta (enum: srednja_skola | visoko),
naziv_ustanove, sediste,
// за средњу школу
trajanje_i_smer, zanimanje, godina_zavrsetka,
// за високо образовање
vrsta_studija (enum/string), naziv_programa,
obim_espb_ili_godine, zvanje_steceno, datum_zavrsetka,
redosled (int — за сортирање по нивоу)
4. work_experiences — радно искуство (1:N)
id, user_id,
period_od (date), period_do (date, nullable),
naziv_poslodavca, opis_posla, naziv_radnog_mesta,
osnov_angazovanja (enum: odredjeno | neodredjeno | drugi),
zahtevano_obrazovanje (json или string — може бити вишеструки избор)
5. trainings — додатне обуке и знања (1:N)
id, user_id,
naziv_obuke, institucija_i_mesto,
nivo_znanja (за страни језик, nullable),
godina_pohadjanja
6. competitions — конкурси (попуњава орган)
id, radno_mesto, sifra_radnog_mesta,
zvanje_polozaj, naziv_organa,
napomena, active (boolean),
created_at, updated_at
7. competition_exams — тражени испити по конкурсу
id, competition_id, vrsta_ispita, redosled
8. competition_languages — тражени страни језици по конкурсу
id, competition_id, jezik, redosled
9. competition_documents — тражени докази по конкурсу
id, competition_id,
naziv_dokumenta,
tip (enum: sluzbena_evidencija | licno_dostavlja),
redosled
10. competition_national_minorities — националне мањине по конкурсу
id, competition_id, naziv_manjine, redosled
11. applications — пријава (1 по кандидату по конкурсу)
id, candidate_id, competition_id,
sifra_prijave (unique, генерише се),
status (enum: draft | submitted | rejected | accepted),
 
// Опште функционалне компетенције
oslobadja_opste_kompetencije (boolean),
 
// Рад на рачунару (JSON — само 3 поља: Word/Internet/Excel)
computer_skills (json: {word: {sertifikat, godina}, ...}),
prilaže_racunar_sertifikat (boolean),
 
// Понашајне компетенције
prethodna_provera_kompetencija (boolean),
organ_gde_testiran (nullable string),
uspesno_prosao_proveru (enum: da | ne | ne_secam_se | null),
 
// Посебни услови
posebni_uslovi (boolean),
opis_posebnih_uslova (nullable),
 
// Додатне изјаве
prestao_radni_odnos_teza_povreda (boolean),
nacin_pribavljanja_podataka (enum: licno | organ),
zainteresovan_za_druge_poslove (boolean),
 
// Евалуација — необавезно
kako_saznao (json),
 
ime_prezime_podnosioca, submitted_at,
created_at, updated_at
12. application_exam_responses — одговори на тражене испите
id, application_id, competition_exam_id,
ima_polozeno (boolean),
naziv_organa_dokaza (nullable),
datum_polaganja (nullable date)
13. application_language_responses — одговори на тражене језике
id, application_id, competition_language_id,
ima_sertifikat (boolean),
nivo (enum: A1|A2|B1|B2|C1|C2, nullable),
godina_polaganja (nullable),
prilaže_sertifikat_oslobadjanje (boolean)
14. application_document_responses — одговори на документа
id, application_id, competition_document_id,
// За tip=sluzbena_evidencija: saglasan_organ_pribavi | licno_pribavio
// За tip=licno_dostavlja: da | ne
izjava (enum/string)
15. application_national_minority_responses
id, application_id, competition_national_minority_id,
pripada (boolean)
________________________________________
Шта НЕ треба засебна табела
Секција	Зашто не треба табелу
Computer skills (Word/Excel/Internet)	JSON колона у applications — само 3 фиксна поља
"Kako ste saznali"	JSON или text — само за евалуацију, не за пословну логику
Адреса за доставу	Nullable колоне у candidates
Понашајне компетенције	3 колоне у applications
Посебни услови	2 колоне у applications
________________________________________
Дијаграм релација (кратко)
users ─── candidates ─┬─ educations
                      ├─ work_experiences
                      ├─ trainings
                      └─ applications ──── competition
                              │
                    ┌─────────┼──────────────┐
         exam_responses  language_responses  document_responses
                                             national_minority_responses
________________________________________
Migrations редослед
1.	users (Laravel default)
2.	candidates
3.	educations
4.	work_experiences
5.	trainings
6.	competitions
7.	competition_exams
8.	competition_languages
9.	competition_documents
10.	competition_national_minorities
11.	applications
12.	application_exam_responses
13.	application_language_responses
14.	application_document_responses
15.	application_national_minority_responses
________________________________________
Верификација
•	Форма се може потпуно репродуковати из ових табела
•	Орган може да направи конкурс, дода тражене испите/језике/документа
•	Кандидат се региструје, попуни профил, поднесе пријаву
•	Генерише се шифра пријаве
•	Све обавезне секције (*) имају одговарајућа поља са NOT NULL / validation
