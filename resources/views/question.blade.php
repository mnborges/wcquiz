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
    <style>
        body {
            background: url(khalifa-stadium.jpg);
            background-size: auto;
        }
    </style>
</head>

<body>
    <div class="container">
        @if ($questions)
            <div class="row">
                <div
                    class="col-12 col-lg-10 m-auto mt-4 rounded-pill text-center text-white bg-success bg-gradient shadow-lg p-4 ">
                    <h1>2022 World Cup Quiz</h1>
                    <p>This year <abbr titile="Federation Internationale de Football Association">FIFA</abbr> is
                        organising
                        the
                        22nd World Cup tournament. How up to date are you about the competition? Answer a few
                        questions
                        to
                        find
                        out!</p>
                </div>
            </div>
            <div class=" mt-4 justify-content-center">
                <div class="progress">
                    <div class=" d-block progress-bar bg-success" role="progressbar"
                        style="width: {{ 100 / count($questions) }}%" aria-valuenow="{{ 100 / count($questions) }}"
                        aria-valuemin="0" aria-valuemax="100" data-qcount={{ count($questions) }}></div>
                </div>
            </div>
            <div class="row justify-content-center  mt-4 ">
                <div id="carousel"
                    class="col-12 col-lg-8 bg-light carousel rounded carousel-dark slide shadow-lg bg-gradient">
                    <div class="clearfix carousel-inner ">
                        <form class="bg-white  rounded" method="POST" action="/">
                            @csrf
                            @foreach ($questions as $question)
                                @php
                                    // include flags
                                    $pattern = '/%(\w{3})%/';
                                    $replace = "<img src='/flags/\${1}.jpg' height=14 width=auto' alt='\${1} flag' >";
                                    $sentence = preg_replace($pattern, $replace, $question['sentence']);
                                @endphp
                                <!---- Question ---->
                                <div class="carousel-item @if ($loop->first) active @endif">
                                    <div class="d-flex align-items-baseline">
                                        <div class="order-1 p-4 ">
                                            <h2 class="text-center">Question {{ $loop->iteration }}</h2>
                                            <p><?php echo $sentence; ?> </p>
                                            <div class="d-flex flex-column flex-lg-row justify-content-evenly">
                                                <!---- Alternatives ---->
                                                @foreach (json_decode($question['alternatives'], true) as $answer)
                                                    @php
                                                        $alternative = preg_replace($pattern, $replace, $answer);
                                                    @endphp
                                                    <div class="form-check ">
                                                        <input class="form-check-input" type="radio"
                                                            name="{{ $question['id'] }}" value="{{ $answer }}"
                                                            oninput="carousel.next()" required>

                                                        <label class="form-check-label" for="{{ $question['id'] }}">
                                                            <?php echo $alternative; ?>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                            @if ($loop->last)
                                                <button class="mt-4 d-block w-100 btn btn-outline-dark" type="submit">
                                                    Check out your score!
                                                </button>
                                            @endif
                                        </div>
                                        <div class="order-0  mx-1 my-auto">
                                            <button @class(['bg-transparent', 'border-0', 'd-none' => $loop->first]) type="button"
                                                data-bs-target="#carousel" data-bs-slide="prev" data-bs-toggle="tooltip"
                                                data-bs-placement="bottom" title="Return to previous question">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            @endforeach
                        </form>
                    </div>
                </div>
            </div>
        @else
            @php
                $p = round(($correct->count() * 100) / $answers->count(), 2);
            @endphp
            <div class="row justify-content-center">
                <div class="col-12 col-lg-10 bg-success rounded-pill shadow-lg p-4 mt-4 text-white text-center">
                    <h1>Your results</h1>
                </div>
            </div>
            <div class="row mt-4 justify-content-center">
                <div class="d-flex flex-column col-12 col-lg-10 bg-white rounded shadow-lg p-4">

                    <h2 class="text-center">{{ $correct->count() }}/{{ $answers->count() }}
                    </h2>
                    <p class="text-center">You've answered {{ $p }}% of the questions right.</p>
                    @if ($p > 75)
                        <p class="alert alert-success">Wow! You nailed it. </p>
                    @else
                        @if ($p > 50)
                            <p class="alert alert-info">Good job! </p>
                        @else
                            <p class="alert alert-danger">Better luck next time.</p>
                        @endif
                    @endif
                    <a href="/" class="btn btn-outline-secondary align-self-end"">Try
                        again</a>
                </div>
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script>
        var myCarousel = document.querySelector('#carousel')
        var carousel = new bootstrap.Carousel(myCarousel, {
            interval: false,
            wrap: false,
            touch: false,
        })
        var inputs = Array.from(document.querySelectorAll(".carousel-item"));
        var progress = document.querySelector(".progress-bar");
        myCarousel.addEventListener("slid.bs.carousel", (e) => {
            let active = inputs.findIndex((elem) =>
                elem.classList.contains("active")) + 1;
            const percent = 100 / progress.dataset.qcount * active;
            progress.style.width = `${percent}%`;
            progress.ariaValueNow = percent;
        })
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>

</body>

</html>
