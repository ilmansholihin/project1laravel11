@extends('layouts.admin.main')
@section('title', 'Admin Product')
@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Produk</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                </div>
                <div class="breadcrumb-item">Produk</div>
            </div>
        </div>

        <a href="{{ route('product.create') }}" class="btn btn-icon icon-left btn-primary">
            <i class="fas fa-plus"></i> Produk
        </a>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-md">
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Harga Produk</th>
                        <th>Nama Distributor</th>
                        <th>Stok</th>
                        <th>Action</th>
                    </tr>
                    @php
                        $no = 0
                    @endphp
                    @forelse ($product as $item)
                        <tr>
                            <td>{{ $no += 1 }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->price }} Points</td>
                            <td>{{ $item->nama_distributor }}</td>
                            <td>{{ $item->stock }}</td>
                            <td>
                                <a href="{{ route('product.detail',$item->id) }}" class="badge badge-info">Detail</a>
                                <a href="{{ route('product.edit', $item->id) }}" class="badge badge-warning">Edit</a>
                                 {{-- <form action="{{ route('product.delete', $item->id) }}" method="POST" style="display: inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <a><button type="submit" class="badge badge-danger border-0">Hapus</button></a>
                                    
                                </form> --}}
                                <a href="{{ route('product.delete', $item->id) }}" class="badge badge-danger">Hapus</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Data Produk Kosong</td>
                        </tr>
                    @endforelse
                </table>
            </div>
        </div>
    </section>
</div>
@endsection
