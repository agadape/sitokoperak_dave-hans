@extends('guest.layouts.main')
@section('title', 'Detail Pesanan #' . $order->order_number)

@section('content')
    <div class="container py-5 mt-5">

        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Pesanan #{{ $order->order_number }}</h4>
                    </div>

                    <div class="card-body">

                        <!-- INFO PESANAN -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <p><strong>Tanggal:</strong> {{ $order->created_at->format('d F Y H:i') }}</p>
                                <p>
                                    <strong>Status:</strong>
                                    <span class="badge {{ $order->status_badge }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </p>
                            </div>

                            <div class="col-md-6 text-md-end">
                                <p><strong>Total Pembayaran:</strong></p>
                                <h3 class="text-danger">
                                    Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                </h3>
                            </div>
                        </div>

                        <hr>

                        <!-- PRODUK -->
                        <h5>Produk yang Dibeli</h5>

                        <div class="table-responsive mb-4">
                            <table class="table">
                                <tbody>
                                    @foreach($order->items as $item)
                                        <tr>
                                            <td width="60">
                                                @if($item->produk->fotoProduk->first())
                                                    <img src="{{ asset('storage/' . $item->produk->fotoProduk->first()->file_foto_produk) }}"
                                                        width="50" height="50" class="rounded" style="object-fit:cover;">
                                                @else
                                                    <img src="{{ asset('assets/images/produk-default.jpg') }}" width="50"
                                                        height="50" class="rounded">
                                                @endif
                                            </td>

                                            <td>
                                                {{ $item->produk->nama_produk }}
                                                <div class="small text-muted">
                                                    Harga: Rp {{ number_format($item->price_at_purchase, 0, ',', '.') }}
                                                    × {{ $item->quantity }}
                                                </div>
                                            </td>

                                            <td class="text-end">
                                                <strong>
                                                    Rp
                                                    {{ number_format($item->price_at_purchase * $item->quantity, 0, ',', '.') }}
                                                </strong>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <hr>

                        <!-- ALAMAT -->
                        <h5>Alamat Pengiriman</h5>
                        <p>
                            {{ $order->customer_name }}<br>
                            {{ $order->customer_phone }}<br>
                            {{ $order->customer_address }}
                        </p>

                        <!-- CATATAN -->
                        @if($order->notes)
                            <h5>Catatan</h5>
                            <p class="alert alert-info">{{ $order->notes }}</p>
                        @endif

                        <div class="mt-4">
                            <a href="{{ route('customer.dashboard') }}" class="btn btn-secondary">
                                Kembali ke Dashboard
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection
