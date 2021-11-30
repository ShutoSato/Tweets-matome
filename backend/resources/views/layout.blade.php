<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Tweets matome</title>
  @yield('styles')
  <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
  <div class="footerFixed">
    <header>
      <nav class="my-navbar">
        <a class="my-navbar-brand" href="/">Tweets matome</a>
        <div class="my-navbar-control">
          
        </div>
      </nav>
    </header>
    <main>
      @yield('content')
    </main>
    <footer>
      <p>Copyright © 2021 SS.</p>
    </footer>
  </div>
</body>
</html>