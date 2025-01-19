@extends('layouts.default')

@section('content')
    @include('components.success-toast')
    @include('components.failed-toast')
    <div class="max-w-sm">
        <livewire:form-barang-pinjam :detail='null' />
    </div>
    <livewire:table-barang-pinjam />
@endsection
