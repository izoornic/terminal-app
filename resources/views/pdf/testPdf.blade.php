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
                    <td style="text-align: right"><span class="boldd">@money($zaduzenjerow->sum_zaduzeno)</span></td>
                </tr>
                <tr class="rowbotom">
                    <td>Datum dospeća: </td>
                    <td style="text-align: right"><span class="boldd">{{$distributerrow->datum_dospeca}}</span>
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
    <div style="width: 240px; background-color: #e6e6e6; float: right; padding: 10px; font-size: 0.875em;" >
        <span class="boldd">Napomena: </span>Prilikom uplate u polje poziv na broj unesite broj predračuna, {{ App\Http\Helpers::yearNumber($mesecrow->mesec_datum) }}/{{ $zaduzenjerow->id }}
    </div>

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
