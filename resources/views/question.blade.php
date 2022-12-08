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
    <div class="my-5 d-flex flex-column ">
        <div class="align-self-center w-50 rounded-pill text-center text-white bg-success bg-gradient shadow-lg p-4 ">
            <h1>2022 World Cup Quiz</h1>
            <p>This year <abbr titile="Federation Internationale de Football Association">FIFA</abbr> is organising the
                22nd World Cup tournament. How up to date are you about the competition? Answer a few questions to find
                out!</p>
        </div>
        <div id="carouselExampleControls" class="carousel carousel-dark slide">
            <div class="carousel-inner">
                <form class="bg-white mt-4 rounded p-4" method="POST" action="/quiz">
                    @csrf
                    @foreach ($questions as $question)
                        <div class="carousel-item text-center @if ($loop->first) active @endif">
                            <h2>Question {{ $loop->iteration }}</h2>
                            <p>{{ $question['main'] }}</p>
                            @foreach ($question['answers'] as $answer)
                                <div class="form-check ">
                                    <input class="form-check-input" type="radio" name="{{ $loop->parent->iteration }}"
                                        id="exampleRadios1" value="{{ $answer }}"
                                        @if (!$loop->parent->last) data-bs-target="#carouselExampleControls" data-bs-slide="next" @endif>

                                    <label class="form-check-label" for="exampleRadios1">
                                        {{ $answer }}
                                    </label>
                                </div>
                            @endforeach
                            @if (!$loop->first)
                                <button class="btn btn-outline-dark"
                                    @if (!$loop->last) type="button"  data-bs-target="#carouselExampleControls" data-bs-slide="prev"> Previous @else type="submit" >
                                    Submit @endif</button>
                            @endif
                        </div>
                    @endforeach
                </form>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
        </script>
        <script>
            var myCarousel = document.querySelector('#carouselExampleControls')
            var carousel = new bootstrap.Carousel(myCarousel, {
                interval: 5000,
                wrap: false
            })
        </script>
</body>

</html>
