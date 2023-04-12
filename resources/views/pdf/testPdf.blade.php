<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Predračun </title>
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
        .flex-container {
            display: flex;
            flex-wrap: nowrap;
            background-color: DodgerBlue;
        }
        .flex-container > div {
            background-color: #f1f1f1;
            width: 50%;
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
    </style>
</head>
<body>
    <table>
        <tr>
            <td><img src="img/ZetaSystemUspravno-01.jpg" style="width: 180px; height: 180px"></td>
            <td>
                <table>
                    <tr>
                        <td style="text-align: right">
                            <span class="boldd">ZETA SYSTEM DOO BEOGRAD</span><br />
                            Golsordijeva 1 <br />
                            11050 Beograd (Vračar) <br />
                            Tel:  <br />
                            office@zeta.rs<br />
                            MB: 06967361 / PIB: 102054577<br />
                            TR: 160-0000000353657-91
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <div style="text-align: center">
        <h2>Predračun br: {{ App\Http\Helpers::yearNumber($mesecrow->mesec_datum) }} / {{ $zaduzenjerow->id }}</h2>
    </div>
    <div class="rowbotomtop">
        <table>
            <tr>
        <td style="width: 50%">
            <p>Klijent: <br />
            <span class="boldd"> {{$distributerrow->distributer_naziv}}</span><br />
            {{$distributerrow->distributer_adresa }}<br />
            {{$distributerrow->distributer_zip}} {{$distributerrow->distributer_mesto}}<br />
            MB: {{$distributerrow->distributer_mb}} / PIB: {{$distributerrow->distributer_pib}}
            </p>
        </td>
        <td>
            <table>
                <tr class="rowbotom">
                    <td>Vrsta računa:</td>
                    <td style="text-align: right">Predračun</td>
                </tr>
                <tr class="rowbotom">
                    <td>Za uplatu (RSD): </td>
                    <td style="text-align: right"><span class="boldd">@money($zaduzenjerow->sum_zaduzeno)</span> RSD</td>
                </tr>
                <tr class="rowbotom">
                    <td>Datum dospeća: </td>
                    <td style="text-align: right"><span class="boldd">???</span>
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
                    <td class="boldd">
                       Serijski broj:<br />Lokacija:
                    </td>
                    <td class="boldd">
                        Licenca:
                    </td>
                    <td colspan="2" class="boldd">
                        Trajanje licence:
                    </td>
                    <td class="boldd">Cena:</td>
                </tr>
            </table>
        </tr>
        @php
            $olditem = new stdClass();
            $olditem->id = '';
        @endphp                         
        @if ($data->count())
            @foreach ($data as $item)
                @if($olditem->id == $item->id)
                    @php
                        $item->isDuplicate = true;
                    @endphp
                @else
                    @php
                        $item->isDuplicate = false;
                    @endphp
                @endif
                <tr class="rowbotom">
                    <td>
                        <table>
                            <tr>
                                <td>
                                    {{ $item->sn }}
                                </td>
                                <td>
                                    {{ $item->licenca_naziv }}
                                </td>
                                <td>
                                    {{ App\Http\Helpers::datumFormatDan($item->datum_pocetka_licence) }}
                                </td>
                                <td>
                                    {{ App\Http\Helpers::datumFormatDan($item->datum_kraj_licence) }}
                                </td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    @if($item->isDuplicate)
                                        
                                    @else
                                        {{ $item->l_naziv }} {{ $item->adresa }}, {{ $item->mesto }}
                                    @endif
                                </td>
                                <td style="text-align: right">
                                    <span class="boldd">@money($item->zaduzeno)</span> RSD
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                @php
                    $olditem = $item;
                @endphp
            @endforeach
        @else 
            <tr>
                <td>No Results Found</td>
            </tr>
        @endif
    </table>
    
</body>
</html>
