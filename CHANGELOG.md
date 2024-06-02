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

V 0.5.1.0 (26.2.2024.)
    - spravljen bug sa paginatorom na stranici dist-terminali
    - preimenovan blade i controler distributer.dist-terminal (bio distributer.distributer-terminal)

V 0.5.1.1 (27.2.2024.)
    - Doato polje email u tabelu lokacije. Vidljivo u modalu edit i info. Vidljivo i na stranici "Tiketview"
    - Dodata pretraga tiketa po opisu kvara
    - Dodat zarez kao delimiter za decimalne brojeve prilikom unosa cene licence za ulogu "Distributer"

V 0.5.1.2 (6.3.2024.)
    - Dodata provera email adrese kada se menja ili dodaje da setuje NULL ako je los format

V 0.5.1.3 (6.4.2024.)
    - Ispravljen bug sa editom lokacije koja ima dodatu email adresu. Stranice "Lokacije" i "Dist-Lokacije"


V 0.5.1.4 (23.4.2024.)
    - Dodata funkcionalnost da Admin i Menager licenci ne mogu da premestaju terminale koji imaju dodatu licencu.
    - Dodata dva nova plja u tabelu "licenca_naplatas": 'aktivna', 'nenaplativ'
    
    - Izbacena tabela 'licenca_distributer_terminals' iz baze

        UPDATE licenca_naplatas ls, ( SELECT id, nenaplativ FROM licenca_distributer_terminals ) ldt
        SET ls.nenaplativ = 1
        WHERE ls.licenca_dist_terminalId = ldt.id
        AND ldt.nenaplativ = 1;

    - Dodata nova polja u tabelu "licenca_parametar_terminals" : 'terminal_lokacijaId', 'distributerId', 'licenca_distributer_cenaId'
    - Refaktor prememestanja terminala u jednu funkciju u modelu TerminalLokacija
    - Dodat update broja terminala za distributera prilikom premestanja terminala

V 0.5.1.5 (2.6.2024.)
    - Dodat novi modal "Pregled licenci" na stranici 'Terminali' za uloge 'admin' i 'menadzer licenci'

V 0.5.2.1 (2.6.2024.)
    - Ispravljen bug u blade fajlovima 'Terminali' za uloge 'admin' i 'menadzer licenci'


    --
    PROBLEMATICNA LICENCA (stock dodta kao duga na terminal)
    -- Ima je u tabeli 'licenca_naplatas' a nema je u tabeli 'licence_za_terminals'
    terminal_lokacijaID = 15335
    distributerId = 1       (Zeta Test)
    licenca_distributer_cenaId = 2 (stock)
    SN = 0310639000225881 
         0310639000225881

         08. 02. '24. 		01. 02. '25. 



    //==== Upit za proveru slicnosti tabela 'licenca_naplatas' i 'licenca_distributer_terminals' ====//
    SELECT ln.licenca_dist_terminalId, ldt.id, ln.* FROM licenca_naplatas ln
    LEFT JOIN licenca_distributer_terminals ldt ON ln.licenca_dist_terminalId = ldt.id
    WHERE ln.aktivna > 0
    ORDER BY ln.licenca_dist_terminalId;

    // licenca koja postoji u tabeli 'licenca_naplatas' a ne postoji u tabeli 'licence_za_terminals'
    SELECT * FROM licenca_naplatas ln WHERE (ln.terminal_lokacijaId, ln.distributerId, ln.licenca_distributer_cenaId) NOT IN (SELECT lzt.terminal_lokacijaId, lzt.distributerId, lzt.licenca_distributer_cenaId FROM licence_za_terminals lzt) AND ln.aktivna = 1 ORDER BY `distributerId` ASC 


    // INFO o TerminalLokacija IDju
    SELECT * FROM terminal_lokacijas tl WHERE tl.terminalId = (SELECT id FROM terminals WHERE sn LIKE '0500422040186607'); 
