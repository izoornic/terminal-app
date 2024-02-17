<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{$doc_vrsta->naslov}} </title>
    <style>
        *{ font-family: DejaVu Sans !important;}
        table{
            border-collapse: collapse;
            width: 100% !important; 
        }
        .rowbotom{
            border-bottom: 1px solid black;
        }
        .rowbotomtop{
            border-bottom: 1px solid black;
            border-top: 1px solid black;
            margin: 20px 0 20px 0;
        }
        table, th, td {
            /* border-bottom: 1px solid; */
            border-style: none;
        }
        td {
            padding: 5px;
            font-size: 0.875em;
        }
        .boldd{
            font-weight: bold;
        }
        .com_name{
            font-size: 1.5em;
        }
    </style>
</head>
<body>
    <table>
        <tr>
            <td></td>
            <td>
                <table>
                    <tr>
                        <td style="text-align: right">
                            <span class="boldd com_name">{{$distributerrow->distributer_naziv}}</span><br />
                            {{$distributerrow->distributer_adresa}} <br />
                            {{$distributerrow->distributer_zip}} {{ $distributerrow->distributer_mesto }} <br />
                            @if($distributerrow->distributer_tel)
                            Tel: {{$distributerrow->distributer_tel}}  <br />
                            @endif
                            {{$distributerrow->distributer_email}}<br />
                            MB: {{$distributerrow->distributer_mb}} / PIB: {{$distributerrow->distributer_pib}}<br />
                            TR: {{$distributerrow->distributer_tr}}<br />
                            Banka: {{$distributerrow->distributer_banka}}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <div style="text-align: center">
        <h2>{{$doc_vrsta->naslov}} br: {{ $distributerrow->broj_racuna }}</h2>
    </div>
    <div class="rowbotomtop">
        <table>
            <tr>
        <td style="width: 50%">
            <p>Klijent: <br />
            <span class="boldd"> {{ $lokacija_row->l_naziv }}</span><br />
            {{ $lokacija_row->adresa }}<br />
            {{ $lokacija_row->mesto }}<br />
            MB: {{$lokacija_row->mb}} / PIB: {{$lokacija_row->pib}}
            </p>
        </td>
        <td>
            <table>
                <tr class="rowbotom">
                    <td>Vrsta računa:</td>
                    <td style="text-align: right">{{$doc_vrsta->naslov}}</td>
                </tr>
                <tr class="rowbotom">
                    <td>{{$doc_vrsta->placanje}} (RSD): </td>
                    <td style="text-align: right"><span class="boldd">@if($doc_vrsta->tip == 'p')@money($naplata_row->dist_zaduzeno) @else @money($naplata_row->dist_razduzeno)@endif</span></td>
                </tr>
                <tr class="rowbotom">
                    <td>{{$doc_vrsta->datum }}</td>
                    <td style="text-align: right"><span class="boldd">@if($doc_vrsta->tip == 'p'){{$distributerrow->datum_dospeca}} @else {{$distributerrow->datum_placanja}}@endif</span>
                </td>
                </tr>
            </table>
        </td>
        </tr>
    </table>
    </div>
    <table>
        <tr class="rowbotom" style="background-color: #e6e6e6">
            <td class="boldd" style="padding-left: 10px">Artikli</td>
        </tr>
        <tr class="rowbotom">
            <table>
                <tr>
                    <td>
                       Serijski broj:
                    </td>
                    <td>
                        Licenca:
                    </td>
                    <td colspan="2">
                        Trajanje licence:
                    </td>
                    <td>Cena:</td>
                </tr>
            </table>
        </tr>
        <tr class="rowbotom">
            <td>
                <table>
                    <tr>
                        <td class="boldd">
                            {{ $lokacija_row->sn }}
                        </td>
                        <td>
                            {{$naplata_row->naziv_licence}}
                        </td>
                        <td>
                            {{ App\Http\Helpers::datumFormatDan($naplata_row->datum_pocetka_licence) }}
                        </td>
                        <td>
                            {{ App\Http\Helpers::datumFormatDan($naplata_row->datum_kraj_licence) }}
                        </td>
                        <td style="text-align: right">
                            <span class="boldd">@money($naplata_row->dist_zaduzeno)</span> RSD
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <p>&nbsp;</p>
    <div style="width: 400px; float: left">
    <table>
        <tr>
            <td colspan="4" class="boldd"  style="background-color: #e6e6e6; padding-left: 10px">Poreske stope</td>
        </tr>
        <tr class="rowbotom">
            <td>Oznaka</td>
            <td>Ime</td>
            <td>Stopa</td>
            <td>Porez</td>
        </tr>
        <tr class="rowbotom">
            <td>Đ</td>
            <td>PDV</td>
            <td>20%</td>
            <td>Porez</td>
        </tr>
    </table>
    </div>
    @if($doc_vrsta->tip == 'p')
    <div style="width: 240px; background-color: #e6e6e6; float: right; padding: 10px; font-size: 0.875em;" >
        <span class="boldd">Napomena: </span>Prilikom uplate u polje poziv na broj broj predračuna: {{ $distributerrow->poziv_na_broj }}  
    </div>
    @endif

    <script type="text/php">
        if (isset($pdf)) {
            $x = 460;
            $y = 800;
            $text = "Strana {PAGE_NUM} od {PAGE_COUNT}";
            $font = null;
            $size = 10;
            $color = array(0.565, 0.565, 0.565);
            $word_space = 0.0;  //  default
            $char_space = 0.0;  //  default
            $angle = 0.0;   //  default
            $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
        }
    </script>
</body>
</html>
