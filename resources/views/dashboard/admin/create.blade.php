@extends('dashboard.layout.master')

@section('page-dashboard')

<livewire:create-user-view />

@endsection
//create admin

@extends('dashboard.layout.master')

@section('page-dashboard')

<livewire:edit-user-view :user="$user" />

@endsection
//edit admin
