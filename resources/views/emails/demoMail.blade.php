<!DOCTYPE html>
<html>
<head>
 <title>zetasystem servis</title>
 <style>
     a {
        text-decoration: none;
        color: rgb(2 132 199);
        }
    .komentwarp{
        margin-top: 10px;
    }

    .komentator {
        font-weight: bold;
        margin: 4px;
        margin-left: 5px;
    }

    .koment {
        border-style: solid;
        border-width: 1px;
        padding: 4px;
        margin-left: 15px;
    }
</style>
</head>
<body>
 
 <a href="{{ $data['tiketlink'] }}"><h2>{{ $data['hedaing'] }}</h2></a>
 @if($komentari != null)
 @if($komentari->count())
    @foreach($komentari as $komentar)
            <div class="komentwarp">
                <span class="komentator">{{ $komentar->name }}</span> <span class="text-sm ml-4">{{ App\Http\Helpers::datumFormat($komentar->created_at) }}</span>
                <div class="koment">{{ $komentar->komentar }}</div>
            </div>
    @endforeach
    <h2>Podaci o tiketu:</h2>
@endif
@endif
 <p></p>
 <p>{{ $data['row1'] }}</p>
 <p>{{ $data['row2'] }}</p>
 <p>{{ $data['row3'] }}</p>
 <p>{{ $data['row4'] }}</p>
 <p>{{ $data['row5'] }}</p>
 <p>{{ $data['row6'] }}</p>
 <p>{{ $data['row7'] }}</p>
 <p>{{ $data['row8'] }}</p>
 <p>{{ $data['row9'] }}</p>
 <p>{{ $data['row10'] }}</p>
 <p>{{ $data['row11'] }}</p>
 
</body>
</html> 