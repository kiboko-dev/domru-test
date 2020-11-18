<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Валютный калькулятор</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('css/bootstrap-reboot.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/bootstrap-grid.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
        <!-- Styles -->

        <style>
            body {
                font-family: 'Nunito';
            }
        </style>
    </head>
    <body class="antialiased">
    <div class="container">
        <div class="card" style="margin-top: 20vh; box-shadow: 0 0 10px rgba(0,0,0,0.5)">
            <div class="card-header">
                <h1>Валютный калькулятор</h1>
            </div>
            <div class="card-body">


                    <div class="row">
                        <div class="col-md-8" style="padding-top: 10px;">
                            <form action="{{route('convert')}}" method="post" class="form">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="amount">Обменять</label><br>
                                        <input type="text" name="amount" id="amount" class="form-control" @if (!empty($amount)) value="{{$amount}}" @endif required>
                                        @if ($errors->has('amount'))
                                            <span class="invalid-feedback" role="alert" style="display: block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 30px;text-align: center;">
                                    <div class="col-md-5 text-left">
                                        <label for="fromCode">из</label>
                                        <select name="fromCode" id="fromCode" class="form-control">
                                            @foreach($curList as $key => $value)
                                                <option value="{{$key}}">{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-outline-primary" style="border-radius: 40px;height: 50px;width: 50px;">
                                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-repeat" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/>
                                                <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="col-md-5 text-left">
                                        <label for="toCode">в</label>
                                        <select name="toCode" id="toCode" class="form-control">
                                            @foreach($curList as $key => $value)
                                                <option value="{{$key}}">{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>

                            </form>
                        </div>
                        <div class="col-md-4">
                            @if (!empty($resultAmount))
                                @include('result')
                            @endif
                        </div>
                    </div>


            </div>
        </div>
    </div>

    </body>
</html>
