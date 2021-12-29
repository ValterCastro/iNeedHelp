@extends('layouts.navbar')

@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>iNeedHelp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        .content-container{
            min-height: 75vh;
        }
    </style>
</head>
<body>
    <div class="content-container">
        <div class="container">
            <h1 class="display-4 my-2">{{ $tags->name }}</h1>
        </div>
    
        <div class="list-group m-4" style="max-width: 50rem">
            @foreach($tags->question_tags as $question_tag)
                <a href="{{ route('question', ['id' => $question_tag->question->id]) }}"
                       class="list-group-item">
                    <div class="d-flex justify-content-between">
                        <div class="me-2 text-truncate d-block">
                            <h6 class="">{{ $question_tag->question->title }}</h6>
                        </div>
                         <div class="flex-shrink-0 text-muted">
                            <span> {{$question_tag->question->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                 </a>
             @endforeach
        </div>
    </div>

    @include('layouts.footerbar')

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</body>
</html>

@endsection