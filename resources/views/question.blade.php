<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>2022 World Cup Quiz</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="app.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div
                class="col-12 col-lg-10 m-auto mt-4 rounded-pill text-center text-white bg-success bg-gradient shadow-lg p-4 ">
                <h1>2022 World Cup Quiz</h1>
                <p>This year <abbr titile="Federation Internationale de Football Association">FIFA</abbr> is organising
                    the
                    22nd World Cup tournament. How up to date are you about the competition? Answer a few questions to
                    find
                    out!</p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div id="carousel" class="col-12 col-lg-8 carousel carousel-dark slide ">
                <div class="clearfix carousel-inner ">
                    <form class="bg-white mt-4 rounded p-4 " method="POST" action="/quiz">
                        @csrf
                        @foreach ($questions as $question)
                            <div class="carousel-item @if ($loop->first) active @endif">
                                <div class="">
                                    <h2>Question {{ $loop->iteration }}</h2>
                                    <p>{{ $question['sentence'] }}</p>
                                    @foreach (json_decode($question['alternatives'], true) as $answer)
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio"
                                                name="{{ $loop->parent->iteration }}" id="{{ $question['id'] }}"
                                                value="{{ $answer }}" oninput="carousel.next()">

                                            <label class="form-check-label" for="{{ $question['id'] }}">
                                                {{ $answer }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="">
                                    @if (!$loop->first)
                                        <button class="carousel-control-prev" type="button" data-bs-target="#carousel"
                                            data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </button>
                                    @endif
                                </div>
                                @if ($loop->last)
                                    <button class="btn btn-outline-dark" type="submit"> Submit
                                    </button>
                                @endif


                            </div>
                        @endforeach
                    </form>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
        </script>
        <script>
            var myCarousel = document.querySelector('#carousel')
            var carousel = new bootstrap.Carousel(myCarousel, {
                wrap: false,
                touch: false,
            })
        </script>
</body>

</html>
