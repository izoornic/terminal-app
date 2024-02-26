V 0.4.3.0 (22.7.2023.)
    - 'Osnovna licenca' ukinuta kao i sva funkcijonalnost vezana za nju. Dodavanje, brisanje licence terminalu. 
    - Brisanje licence na stranici 'Distributer terminal' brise licencu i u apiju

V 0.4.3.1 (28.7.2023.)
    - Zamenjena ikona 'Add to Blacklist' na stranici Terminali (Menager Licenci)
    - Napravljena funkcionalnost za brisanje korisnika (admin). Obrisanom korisniku se dodeljuje "Pozicija" - Obrisan i ostaje vidljiv na lisi korisnika bez mogućnosti editovanja. Vraćanje korisnika samo editom polja "pozicija_tipId" u bazi.

V 0.4.3.2 (11.8.2023.)
    - Dodat podatak o modelu i proizvodjaču na modalu HISTORY na stranicama: "licenca-terminali", "terminal", "tiketview"

V 0.4.3.3 (12.10.2023.)
    - Ispravljen bug kod dodavanja tiketa. Lista "Opis kvara" vis ne zavisi od tipa terminala. 

V 0.5.0 (23.12.2013.)
    - Nova tabela u bazi: distributer_user_indices
    - Dodat novi tip usera "Distributer" i napravljena funkcionalonost za Admina da može da dodaje takve korisnike. Novog korisnika vezuje za lokaciju tipa "Distributer" koja je povezana sa tabelom "licenca_distributer_tips".

V 0.5.1 (17.2.2024.)
    - Nova polja u tabelama "terminal_lokacijas", "terminal_lokacija_histories":  'distributerId'
        Stranice na kojima serviser vidi distributera:
            - Teminal -> "Terminal history" modal
            - Teminal -> "Novi tiket" modal
            - Tiket -> "Novi tiket" modal
            - Tiketview stranica

    - Nova tabela "distributer_lokacija_indices" veza izmedju tabela "licenca_distributer_tips" i "lokacijas"
    - Nova stranica "Distributer-lokacija" preko koje Menagerlicenci vezije distridutere za lokacije

    - Nova polja u tabeli "Lokacijas": 'mb', 'distributerId'
    - Nova polja u tabeli "licenca_distributer_tips": 'distributer_tr', 'distributer_banka', 'distributer_tel'

    - Nove stranice za ulogu "Distributer": Dashboard, Terminali, Lokacije, Licence
    - Promenjen naziv polja u tabeli "licenca_distributer_cenas": 'licenca_cena' u 'licenca_zeta_cena'
    - Dodato novo polje u tabelu "licenca_distributer_cenas": 'licenca_dist_cena'

    - Nova polja u tabeli "licenca_naplatas": 'datum_zaduzenja', 'dist_zaduzeno', 'dist_datum_zaduzenja', 'dist_razduzeno', 'dist_datum_razduzenja'
    
    - Kreiranje novog Usera dodata password rules (min(8)->letters()->numbers()->symbols())

    - Nova tabela "kurs_evras"

V 0.5.0.2  (17.2.2024.)
    - Ispravljen bug na stranici user.php prilikom poziva modala updateShowModal($id)

V 0.5.0.3  (18.2.2024.)
    - Ispravljen prikaz Terminal History na stranici Terminali za Menadžera licenci. Sada vidi naziv distributera kod koga je terminal.

V 0.5.0.5  (18.2.2024.)
    - Dodata funkcionalnost ya testUsera da moze da mu se menja Distributer

V 0.5.0.6 (19.2.2024.)
    - Update CSS i JS
    - Menager licenci ne vidi dugmice za dodavanja, brisanje i parametre licence
    - Menager licenci vidi sve terminale prebacene distributeru.

V 0.5.0.7 (25.2.2024.)
    - Hardkodovanom useru "Zeta test user" - tipa distributer dodat modal za promenu distributera na dashboard stranici
    - Menadger Licenci kada dodaje licencu distributeru unosi i preporucenu cenu za distributera
    - Menadžer Licenci na stranici zaduzenje-distributeri ne vidi dugme "ZADUŽI" ako je već zadužio distributera za taj mesec

V 0.5.0.8 (25.2.2024.)
    - Ispravka par slovnih greski i prikay ikonice "Nenaplativa licenca" na nalogu Distributera

V 0.5.0.9 (26.2.2024.)
    - Ispravljen BUG za dodavanje postojece lokacije distributeru.



  UPDATE terminal_lokacijas SET distributerId = '5' WHERE terminal_lokacijas.terminalId = ( SELECT id FROM terminals WHERE sn LIKE 'A26-12RB-1K12746');  

INFO o TerminalLokacija IDju
  SELECT * FROM terminal_lokacijas tl WHERE tl.terminalId = (SELECT id FROM terminals WHERE sn LIKE '0500422040186607'); 


INSERT INTO licenca_naplatas (id, terminal_lokacijaId, distributerId, licenca_distributer_cenaId, licenca_dist_terminalId, mesecId, broj_dana, zaduzeno, datum_zaduzenja, razduzeno, datum_razduzenja, datum_pocetka_licence, datum_kraj_licence, datum_isteka_prekoracenja, dist_zaduzeno, dist_datum_zaduzenja, dist_razduzeno, dist_datum_razduzenja, created_at, updated_at) 
SELECT NULL, ldt.terminal_lokacijaId, ldt.distributerId, ldt.licenca_distributer_cenaId, ldt.id, NULL, ldt.licenca_broj_dana, NULL, NULL, NULL, NULL, ldt.datum_pocetak, ldt.datum_kraj, DATE_ADD(datum_kraj, INTERVAL dist.dani_prekoracenja_licence DAY) , '0', ldt.datum_pocetak, '0', ldt.datum_pocetak, NOW(), NOW()
FROM licenca_distributer_terminals ldt
LEFT JOIN licenca_distributer_tips dist ON ldt.distributerId = dist.id
