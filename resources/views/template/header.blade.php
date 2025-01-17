<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title') &#183 {{ env('APP_NAME') }} </title>

  <!-- Icons -->
  <link rel="shortcut icon" href="{{ asset('storage/app/system/icon.png').'?'.rand() }}" type="image/x-icon">

  <!-- Template CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.0.45/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="{{ asset('public/modules/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/modules/fontawesome/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/modules/summernote/summernote-bs4.css') }}">
  <link rel="stylesheet" href="{{ asset('public/modules/codemirror/lib/codemirror.css') }}">
  <link rel="stylesheet" href="{{ asset('public/modules/codemirror/theme/duotone-dark.css') }}">
  <link rel="stylesheet" href="{{ asset('public/modules/jquery-selectric/selectric.css') }}">
  <link rel="stylesheet" href="{{ asset('public/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('public/css/components.css') }}">
  <link rel="stylesheet" href="{{ asset('public/css/datatables.css') }}">
  <link rel="stylesheet" href="{{ asset('public/modules/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/css/jquery.toast.css') }}">
</head>

<body>
