<!DOCTYPE html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="assets/images/favicon.svg" type="image/x-icon" />
    <title>Dashboard | </title>

    @include('includes.admin.style')
</head>

<body>

    @include('includes.admin.sidebar')

    <div class="overlay"></div>

    <main class="main-wrapper">

        @include('includes.admin.navbar')

        <section class="section">

            @yield('content')

        </section>

        @include('includes.admin.footer')

    </main>

    @include('includes.admin.script')
</body>

</html>