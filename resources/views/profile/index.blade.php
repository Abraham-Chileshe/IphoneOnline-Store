@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="container">
    <livewire:user-profile :tab="$tab ?? null" />
</div>
@endsection
