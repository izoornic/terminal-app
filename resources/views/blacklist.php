<?php
use Illuminate\Support\Facades\Storage;
//use App\Http\Helpers;


/* $get_val = request()->query('tid');
dd(Helpers::datumKalendarNow()); */

$url = Storage::url('blacklist.txt');
$contents = Storage::disk('public')->get('blacklist.txt');
//dd ($contents);

header('Content-Disposition: attachment; filename="blacklist.txt"');
header('Content-Type: text/plain'); // Don't use application/force-download - it's not a real MIME type, and the Content-Disposition header is sufficient
header('Content-Length: ' . strlen($contents));
header('Connection: close');

echo $contents;
