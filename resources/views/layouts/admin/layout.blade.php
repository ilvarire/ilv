<!DOCTYPE html>
<html x-bind:class="{ 'theme-dark': dark }" x-data="data()" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>
  <link rel="icon" type="image/png" href="{{ asset('storage/' . $site->favicon) }}" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('admin/assets/css/tailwind.output.css') }}" />

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"
    integrity="sha256-yE5LLp5HSQ/z+hJeCqkz9hdjNkk1jaiGG0tDCraumnA=" crossorigin="anonymous">
    </script>

  <script src="{{ asset('admin/assets/js/init-alpine.js') }}"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" defer></script>
  <script src="{{ asset('admin/assets/js/charts-lines.js') }}" defer></script>

  <script src="{{ asset('admin/assets/js/focus-trap.js') }}" defer></script>
  <style>
    [x-cloak] {
      display: none;
    }
  </style>
  @fluxAppearance

</head>

<body data-mode="light" data-sidebar-size="lg" class="group">
  <div class="flex h-screen bg-gray-50 dark:bg-gray-900" x-bind:class="{ 'overflow-hidden': isSideMenuOpen }">
    <!-- Desktop sidebar -->
    @include('livewire.admin.includes.desktop-sidebar')

    <!-- Mobile sidebar -->
    @include('livewire.admin.includes.mobile-sidebar')

    <div class="flex flex-col flex-1 w-full">
      <!-- Header -->
      @livewire('admin.layout.header')

      <main class="h-full overflow-y-auto">
        <div class="container px-6 mx-auto grid">
          {{ $slot }}
        </div>
      </main>
    </div>
  </div>

  <script>
    $('input[name="mobile-number"]').mask('(00) 0000 0000');
    $('input[name="money"]').mask('000,000,000,000,000.00', { reverse: true });
    $('input[name="weight"]').mask('000,000,000,000,000.00', { reverse: true });
    $('input[name="coupon"]').focusout(function () {
      $('input[name="coupon"]').val(this.value.toUpperCase());
    });
  </script>
  @fluxScripts
</body>

</html>