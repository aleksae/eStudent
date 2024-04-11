<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-beta17
* @link https://tabler.io
* Copyright 2018-2023 The Tabler Authors
* Copyright 2018-2023 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Пријава - еСтудент</title>
    <!-- CSS files -->
    <link href="./dist/css/tabler.min.css?1674944402" rel="stylesheet"/>
    <link href="./dist/css/tabler-flags.min.css?1674944402" rel="stylesheet"/>
    <link href="./dist/css/tabler-payments.min.css?1674944402" rel="stylesheet"/>
    <link href="./dist/css/tabler-vendors.min.css?1674944402" rel="stylesheet"/>
    <link href="./dist/css/demo.min.css?1674944402" rel="stylesheet"/>
    <style>
      @import url('https://rsms.me/inter/inter.css');
      :root {
      	--tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
      }
      body {
      	font-feature-settings: "cv03", "cv04", "cv11";
      }
    </style>
  </head>
  <body  class=" d-flex flex-column">
    <script src="./dist/js/demo-theme.min.js?1674944402"></script>
    <div class="page page-center">
      <div class="container container-tight py-4">
        <div class="text-center mb-4">
          <a href="." class="navbar-brand "><img src="./static/etf_login.png" height="70" alt="" ></a>
        </div>
        <div class="card card-md">
          <div class="card-body">
            <h2 class="h2 text-center mb-4">Пријава</h2>
            <form method="POST" class="needs-validation" action="{{ route('login') }}" autocomplete="off" novalidate>
              @csrf

              <div class="mb-3">
                <label class="form-label">Корисничко име</label>
                <input type="text" class="form-control   @error('username') is-invalid @enderror" placeholder="пиггббббс" autocomplete="off" name="username" id="username" required onChange="checkFormat()">
                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>
                                          @if($message=="These credentials do not match our records.") Погрешни подаци! @else Поље је обавезно! @endif</strong>
                                    </span>
                 @enderror
              </div>
              <div class="mb-2">
                <label class="form-label">
                  Лозинка
                  <span class="form-label-description">
                    <a href="./forgot-password.html">Заборављена лозинка</a>
                  </span>
                </label>
                <div class="input-group input-group-flat">
                  <input type="password" class="form-control" id="password" placeholder="Лозинка" name="password" autocomplete="off" required>
                  <span class="input-group-text">
                    <a href="#" class="link-secondary" id="change" title="Прикажи лозинку" data-bs-toggle="tooltip" onClick="change()"><!-- Download SVG icon from http://tabler-icons.io/i/eye -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" /></svg>
                    </a>
                  </span>
                </div>
                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
              </div>
              <div class="mb-2">
                <label class="form-check">
                  <input type="checkbox" class="form-check-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}/>
                  <span class="form-check-label">Запамти ме</span>
                </label>
              </div>
              <div class="form-footer">

                <button type="submit" class="btn btn-primary w-100">Пријава</button>
              </div>
            </form>
          </div>
          
          
        </div>
        <div class="text-center text-muted mt-3">
          Немате налог? <a href="./sign-up.html" tabindex="-1">Обратите се рачунском центру.</a>
        </div>
      </div>
    </div>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script>
      function checkFormat(){
        let username = document.getElementById("username").value;
        let element = document.getElementById("username");
        if(!username) return;
        if (/[a-zA-Z][a-zA-Z][0-9][0-9][0-9][0-9][0-9][0-9](d|m|p)/.test(username))
  {
    element.classList.remove("is-invalid");
    element.classList.add("is-valid");
  }else{
    element.classList.remove("is-valid");
    element.classList.add("is-invalid");
    
  }
      }
      (function () {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  var forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.prototype.slice.call(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }

        form.classList.add('was-validated')
      }, false)
    })
    
    checkFormat();
  
})();
        function change(){
            let type = document.getElementById('password').type;
            if(type=='password') document.getElementById('password').type = 'text';
            else document.getElementById('password').type = 'password'
        }
    </script>
    <script src="./dist/js/tabler.min.js?1674944402" defer></script>
    <script src="./dist/js/demo.min.js?1674944402" defer></script>
  </body>
</html>