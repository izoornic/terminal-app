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

V 0.5.0.3  (.2.2024.)
    - Ispravljen prikaz Terminal History na stranici Terminali za Menadžera licenci. Sada vidi naziv distributera kod koga je terminal.