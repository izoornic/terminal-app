<?php
namespace App\Ivan;

use Illuminate\Support\Facades\DB;

class TerminalHistory
{

    public static function terminalHistoryData($terminalLokacijaId)
    {
        return DB::select(
            "SELECT * FROM (
                SELECT 'tlh' as 'tabela', terminal_lokacija_histories.korisnikIme as 'user_ime', terminal_lokacija_histories.created_at, terminal_lokacija_histories.updated_at, terminal_status_tips.ts_naziv as 'status_naziv', lokacijas.l_naziv as 'lokacija', lokacijas.mesto as 'mesto', 'na' as 'dodeljen'
                FROM terminal_lokacija_histories
                LEFT JOIN terminal_status_tips ON terminal_lokacija_histories.terminal_statusId = terminal_status_tips.id
                LEFT JOIN lokacijas ON terminal_lokacija_histories.lokacijaId = lokacijas.id
                WHERE terminal_lokacija_histories.terminal_lokacijaId = ?
            ) a
            UNION ALL
            SELECT * FROM (
                SELECT 'tiketHist' as 'tabela', tiket_opis_kvara_tips.tok_naziv as 'user_ime', tiket_histories.created_at, tiket_histories.updated_at, tiket_prioritet_tips.tp_naziv as 'status_naziv', tiket_histories.tiketId as 'lokacija', tiket_status_tips.tks_naziv as 'mesto', users.name as 'dodeljen'
                FROM tiket_histories
                LEFT JOIN tiket_opis_kvara_tips ON tiket_histories.opis_kvaraId = tiket_opis_kvara_tips.id
                LEFT JOIN tiket_prioritet_tips ON tiket_histories.tiket_prioritetId = tiket_prioritet_tips.id
                LEFT JOIN tiket_status_tips ON tiket_histories.tiket_statusId = tiket_status_tips.id
                LEFT JOIN users ON tiket_histories.korisnik_dodeljenId = users.id
                WHERE tiket_histories.tremina_lokacijalId = ?
            ) b
            UNION ALL
            SELECT * FROM (
                SELECT 'tiket' as 'tabela', tiket_opis_kvara_tips.tok_naziv as 'user_ime', tikets.created_at, tikets.updated_at, tiket_prioritet_tips.tp_naziv as 'status_naziv', tikets.id as 'lokacija', tiket_status_tips.tks_naziv as 'mesto', users.name as 'dodeljen'
                FROM tikets
                LEFT JOIN tiket_opis_kvara_tips ON tikets.opis_kvaraId = tiket_opis_kvara_tips.id
                LEFT JOIN tiket_prioritet_tips ON tikets.tiket_prioritetId = tiket_prioritet_tips.id
                LEFT JOIN tiket_status_tips ON tikets.tiket_statusId = tiket_status_tips.id
                LEFT JOIN users ON tikets.korisnik_dodeljenId = users.id
                WHERE tikets.tremina_lokacijalId = ?
            ) c
            ORDER BY updated_at DESC", [$terminalLokacijaId, $terminalLokacijaId, $terminalLokacijaId]
        );
    }

}