<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .tic {
            display: grid;
            grid-template-columns: repeat(3, min-content);
            grid-template-rows: repeat(3, min-content);
            gap: .1em;
            justify-content: center;
        }
        .tic > * {
            border: 1px solid black;
            font-size: 5em;
            line-height: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            justify-content: center;
            width: 1em;
            height: 1em;
            color: inherit;
            text-decoration: none;

        }
    </style>
</head>
<body>
    <div class="jeu tic">
        @foreach ($plateau as $i=>$case)
            @if($case === '-')
                <a href="{{route('tic.jouer', [$joueur, implode('', $plateau), $i])}}">?</a>
            @else
                <div>{{$case}}</div>
            @endif
        @endforeach
    </div>
    <div><a href="{{route('tic.commencer','X')}}">Recommencer avec les X</a></div>
    <div><a href="{{route('tic.commencer','O')}}">Recommencer avec les O</a></div>
</body>
</html>