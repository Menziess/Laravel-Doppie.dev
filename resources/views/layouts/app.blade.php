<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Laravel</title>

	<!-- Fonts -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

	<!-- Styles -->
	<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/css/bootstrap.min.css" integrity="sha384-y3tfxAZXuh4HwSYylfB+J125MxIs6mR5FOHamPBG064zB+AFeWH94NdvaCBm8qnd" crossorigin="anonymous">
	{{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

	<style>
		body {
			font-family: 'Lato';
		}

		.fa-btn {
			margin-right: 6px;
		}
	</style>
</head>


<body id="app-layout">

	<!-- NAVIGATION -->
	@include('layouts.nav')

	<!-- HEADER -->
	@if(Auth::user())
	@include('layouts.header')
	@endif

	<!-- BODY -->
	@include('layouts.body')

	<!-- JavaScripts -->
	<script src="https://cdn.jsdelivr.net/tether/1.3.1/tether.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/js/bootstrap.min.js" integrity="sha384-vZ2WRJMwsjRMW/8U7i6PWi6AlO1L79snBrmgiDpgIWJ82z8eA5lenwvxbMV1PAh7" crossorigin="anonymous"></script>
	{{-- <script src="{{ elixir('js/app.js') }}"></script> --}}

</body>

</html>
