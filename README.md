<!--
Hey, thanks for using the awesome-readme-template template.
If you have any enhancements, then fork this project and create a pull request
or just open an issue with the label "enhancement".

Don't forget to give this project a star for additional support ;)
Maybe you can mention me or this repo in the acknowledgements too
-->
<div align="center">

  <h1>2022 World Cup Quiz</h1>
  
  <p>
    A fun trivia to test how well-informed you are about the World Cup events.
  </p>
  
  
<!-- Badges -->
<p>
  <a href="https://github.com/mnborges/wcquiz/graphs/contributors">
    <img src="https://img.shields.io/github/contributors/mnborges/wcquiz" alt="contributors" />
  </a>
  <a href="">
    <img src="https://img.shields.io/github/last-commit/mnborges/wcquiz" alt="last update" />
  </a>
  <a href="https://github.com/mnborges/wcquiz/issues/">
    <img src="https://img.shields.io/github/issues/mnborges/wcquiz" alt="open issues" />
  </a>
</p>
   
<h4>
    <a href="https://github.com/mnborges/wcquiz">Documentation</a>
  <span> · </span>
    <a href="https://github.com/mnborges/wcquiz/issues/">Report Bug</a>
  <span> · </span>
    <a href="https://github.com/mnborges/wcquiz/issues/">Request Feature</a>
  </h4>
</div>

<br />

<!-- Table of Contents -->

# :notebook_with_decorative_cover: Table of Contents

-   [About the Project](#star2-about-the-project)
    -   [Screenshots](#camera-screenshots)
    -   [Tech Stack](#space_invader-tech-stack)
    -   [Environment Variables](#key-environment-variables)
-   [Getting Started](#toolbox-getting-started)
    -   [Prerequisites](#bangbang-prerequisites)
    -   [Run Locally](#running-run-locally)
-   [Contact](#handshake-contact)
-   [Acknowledgements](#gem-acknowledgements)

<!-- About the Project -->

## :star2: About the Project

This project was developed with the goal to study and pratice the usage of the Laravel Framework, thus it has low complexity and a single feature: send questions to the client and grade their submitted answers.

Despite the app's simplicity, it is still a fun trivia to play and interact with.

<!-- Screenshots -->

### :camera: Screenshots

<div align="center"> 
  <img src="screenshots/wcquiz-mnborges.gif" alt="gif of the application interface" />
</div>

<!-- TechStack -->

### :space_invader: Tech Stack

  <ul>
    <li><a href="https://laravel.com/">Laravel</a></li>
    <li><a href="https://www.php.net/">PHP</a></li>
    <li><a href="https://tc39.es/ecma262/">JavaScript</a></li>
    <li><a href="https://getbootstrap.com/">Bootstrap</a></li>
    <li><a href="https://www.mysql.com/">MySQL</a></li>
    <li><a href="https://www.docker.com/">Docker</a></li>
  </ul>

<!-- Env Variables -->

### :key: Environment Variables

To run this project, you will need to define the variables in the [.env.example](.env.example) file to your local environment variables in the .env file.

```bash
  cp .env.example .env
```

<!-- Getting Started -->

## :toolbox: Getting Started

<!-- Prerequisites -->

### :bangbang: Prerequisites

To get started [Docker Desktop](https://www.docker.com/products/docker-desktop) should be installed in your machine. Plus, if you use Windows and want to use Laravel's built-in interface solution, [Sail](https://github.com/laravel/sail), to run the project using [Docker](https://docker.com), windows Subsystem for Linux 2 (WSL2) must be installed and enabled. For more information view [Laravel documention](https://laravel.com/docs/9.x#laravel-and-docker).

<!-- Run Locally -->

### :running: Run Locally

If you wish to use Sail on windows systems, launch Windows Terminal and begin a new terminal session for your WSL2 Linux operating system.

1. Clone the project

```bash
  git clone https://github.com/mnborges/wcquiz.git
```

2. Go to the project directory

```bash
  cd wcquiz
```

3. Install all composer dependacies

```bash
  docker run --rm -u "$(id -u):$(id -g)" -v "$(pwd):/var/www/html" -w /var/www/html laravelsail/php81-composer:latest composer install --ignore-platform-reqs
```

4. Create and start Docker containers

-   Using Sail Interface

```bash
  ./vendor/bin/sail up
```

-   Without Sail

```bash
  docker-compose up
```

5. In a new terminal, generate a new app key to your .env file

-   Using Sail Interface

```bash
./vendor/bin/sail php artisan key:generate

```

-   Without Sail

    Run the following command and copy the container ID of the **sail-8.1/app** image

```bash
  docker ps
```

With the copied ID, run

```bash
docker exec -t -i [container_ID] bash
```

Finally, within the container's shell, execute the following command to generate the app key

```bash
php artisan key:generate
```

6. Migrate and seed the Database

-   With Sail

```bash
  ./vendor/bin/sail php artisan migrate:fresh --seed
```

-   Without Sail

    Within the sail-8.1/app container, execute

```bash
  php artisan migrate:fresh --seed
```

Go to [localhost](https://localhost) in your web browser to check out the application

To stop all containers you can press Control + C in the terminal.

<!-- Contact -->

## :handshake: Contact

Maieza N. Borges - [LinkedIn](https://www.linkedin.com/in/maieza-borges-903895b8/) - maieza.borges@gmail.com

<!-- Acknowledgments -->

## :gem: Acknowledgements

I would like to acknowledge some projects that were valuable to the development of this app:

-   [Awesome README](https://github.com/matiassingers/awesome-readme) for the template of this page.
-   [World Cup JSON](https://github.com/estiens/world_cup_json) for the amazing World Cup API used to seed the DB for the app's questions.
