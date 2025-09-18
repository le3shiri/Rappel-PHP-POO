<?php
// Composer huwa adat (outil) f-PHP kay-tadbir l-dependencies (l-libraries w l-packages lli l-programme dialk kay7taj) w kay-saweb l-autoload d-l-classes otomatik. Y3ni, b-Composr, ma 3ndksh t-dir require aw include b-yddk l-kul file PHP, w ma 3ndksh t-tlbb l-libraries wa7d b-wa7d. Huwa zay wa7d l-manager lli kay-nadhm l-code dialk w kay-jib lik l-7ajat lli nta 7taj.
// Fuqash nst3mlu Composer?
// Nst3mlu Composer f-had l-7alat:

// Ila bghina nst3mlo libraries jdidin: Mthln, ila bghiti library zay guzzlehttp/guzzle bash t-dir HTTP requests, Composr kay-jibha lik w kay-installiha b-sahla.
// Ila 3ndna projet kbir: Composr kay-nadhm l-code b-autoload PSR-4, y3ni tqdr t-dir l-classes dyalk f-dossier (mthln src/) w Composer kay-chajr l-classes otomatik.
// Ila bghina scripts awtomatikia: Composr kay-sm7 lik t-dir awamr (scripts) zay composer run seed bash tshghl 7ajat zay l-génération d-files aw tests.
// Ila bghina n-nadmo l-projet: Composr kay-khdm b-file composer.json lli kay-7dd smiya, version, w dependencies d-l-projet.

// 3lach nst3mlu Composer?

// Soholat l-tadbir: Ma 3ndksh t-tlbb libraries b-yddk, Composr kay-jibhom w kay-t2akd mn l-versions.
// Autoload: Kay-chajr l-classes dyalk otomatik bla ma t-dir require f-kul blasa.
// Scripts: Kay-sm7 lik t-dir awamr qssarin (mthln composer run start) lli tshghl scripts PHP aw binaires.
// Community w standards: Composr kay-khdm m3a Packagist (repo dial libraries PHP) w kay-st3ml standards zay PSR-4 l-mappage d-l-namespaces.
// Integration m3a frameworks: Zay Laravel, Symfony, w CodeIgniter, l-kthra kay-t7taj Composer bash t-installi w t-nadhm.

// L-hadaf mn Composer
// L-hadaf l-2asasi huwa:

// T-nadhm l-projet: B-composer.json, tqdr t-7dd l-7ajat lli l-projet dyalk kay7taj (libraries, version d-PHP, autoload, scripts).
// T-saweb l-code reusable: B-PSR-4, tqdr t-nadhm l-classes dyalk f-dossiers w Composer kay-chajrhom otomatik.
// T-wfr l-wqt: Ma 3ndksh t-ktb code bzzaf l-require files aw t-tlbb libraries manual, Composr kay-dir hada lik.
// T-t2akd mn l-compatibilité: Kay-jib l-versions s7a7a d-l-libraries w kay-t2akd ma ykunsh 3ndk conflicts.
// T-saweb scripts CLI: Zay f-l-kurs, tqdr t-dir scripts zay start w seed bash t-generi files zay articles.seed.json lli ghadi ytkhdm f-Larave