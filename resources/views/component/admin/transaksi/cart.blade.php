@extends('layouts.admin-app')

@section('title')
    Keranjang
@endsection

@push('cs')
    <style>
        /* CSS untuk tampilan keranjang belanja */

        .cart {
            background-color: #fff;
            border-radius: 4px;
            padding: 20px;
        }

        .cart-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }

        .cart-item img {
            width: 70px;
            height: 70px;
            margin-right: 10px;
        }

        .cart-item-name {
            flex: 1;
        }

        .cart-item-quantity {
            display: flex;
            align-items: center;
        }

        .cart-item-quantity input {
            width: 50px;
            text-align: center;
            margin: 0 5px;
        }

        .cart-item-price {
            width: 70px;
            text-align: right;
        }

        .cart-total {
            text-align: right;
            font-weight: bold;
            margin-top: 10px;
            margin-right: 50px;
        }

        .cart-button {
            display: block;
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #4caf50;
            color: white;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            border: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .cart-button:hover {
            background-color: #45a049;
        }

        .increment-button {
            width: 30px;
            background-color: green;
            color: white;
        }

        .decrement-button {
            width: 30px;
            background-color: red;
            color: white;
        }
    </style>
@endpush

@section('content')
    @if (session('status'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Sukses!',
                text: "{{ session('status') }}",
            });
        </script>
    @endif
    <section class="table-components">
        <div class="container-fluid">
            <div class="cart mt-5">
                @php
                    $total = 0;
                @endphp
                <form action="{{ route('checkout') }}" method="post">
                    @csrf
                    @forelse ($data as $list)
                        <div class="cart-item">
                            <input type="checkbox" id="vehicle1" name="bahan_baku[]" value="{{ $list->bahanBaku->id }}">
                            <img src="{{ asset('storage/bahan-baku-suplier/' . $list->bahanBaku->gambar) }}"
                                alt="Product 1" />
                            <div class="cart-item-name">
                                {{ $list->bahanBaku->nama }},
                                <div class="suplier" style="font-size: 12px">
                                    Suplier : {{ $list->bahanBaku->users->name }}
                                </div>
                            </div>
                            <div class="cart-item-quantity">
                                <button type="button" class="decrement-button">-</button>
                                <input class="quantity" type="number" value="{{ $list->jumlah }}" min="1"
                                    max="{{ $list->bahanBaku->stok }}" required
                                    name="quantity[{{ $list->bahanBaku->id }}]" />
                                <button type="button" class="increment-button">+</button>
                            </div>
                            <div class="cart-item-price mr-5">Rp.{{ $list->bahanBaku->harga }}</div>
                            <a href="{{ route('delete.cart', $list->id) }}"
                                class="text-danger ml-5 btn btn-warning py-0 px-2">
                                <strong>x</strong>
                            </a>
                        </div>
                        @php
                            $subtotal = $list->bahanBaku->harga * $list->jumlah;
                            $total += $list->bahanBaku->harga * $list->jumlah;
                        @endphp
                        <input type="hidden" name="subtotal[{{ $list->bahanBaku->id }}]" value="{{ $subtotal }}">
                    @empty
                        <div class="message">
                            <h3 class="text-center text-danger">Tidak ada Item</h3>
                        </div>
                    @endforelse
                    <div class="cart-total">Total: Rp. {{ $total }}</div>
                    <button type="submit" class="btn btn-success" id="checkout-button" style="width:100%"
                        disabled>checkout</button>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        // JavaScript untuk mengatur perilaku keranjang belanja
        var decrementButtons = document.querySelectorAll(".decrement-button");
        var incrementButtons = document.querySelectorAll(".increment-button");
        var quantityInputs = document.querySelectorAll(".quantity");
        var cartTotalElement = document.querySelector(".cart-total");
        var cartTotalInput = document.querySelector("#total");

        // Mengatur event listener untuk tombol pengurangan
        decrementButtons.forEach(function(button, index) {
            button.addEventListener("click", function() {
                var quantity = parseInt(quantityInputs[index].value);
                if (quantity > 1) {
                    quantity--;
                    quantityInputs[index].value = quantity;
                    updateCartTotal();
                }
            });
        });

        // Mengatur event listener untuk tombol penambahan
        incrementButtons.forEach(function(button, index) {
            button.addEventListener("click", function() {
                var quantity = parseInt(quantityInputs[index].value);
                quantity++;
                quantityInputs[index].value = quantity;
                updateCartTotal();
            });
        });

        // Mengatur event listener untuk perubahan kuantitas langsung di input
        quantityInputs.forEach(function(input, index) {
            input.addEventListener("change", function() {
                var quantity = parseInt(input.value);
                if (quantity < 1) {
                    input.value = 1;
                }
                updateCartTotal();
            });
        });

        // Mengupdate total harga di keranjang belanja
        function updateCartTotal() {
            var cartItems = document.querySelectorAll(".cart-item");
            var total = 0;

            cartItems.forEach(function(item) {
                var checkbox = item.querySelector('input[type="checkbox"]');
                if (checkbox.checked) {
                    var priceElement = item.querySelector(".cart-item-price");
                    var price = parseFloat(priceElement.textContent.replace("Rp.", ""));
                    var quantity = parseInt(item.querySelector(".quantity").value);
                    total += price * quantity;
                }
            });

            cartTotalElement.textContent = "Total: Rp. " + total;
            cartTotalInput.value = total;
        }

        // Mengatur event listener untuk setiap checkbox
        var checkboxes = document.querySelectorAll('input[type="checkbox"]');
        var checkoutButton = document.getElementById('checkout-button');

        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                // Memeriksa apakah setidaknya satu checkbox dicentang
                var checked = false;
                checkboxes.forEach(function(cb) {
                    if (cb.checked) {
                        checked = true;
                    }
                });

                // Mengubah status tombol checkout
                if (checked) {
                    checkoutButton.removeAttribute('disabled');
                } else {
                    checkoutButton.setAttribute('disabled', 'disabled');
                }

                // Memperbarui total
                updateCartTotal();
            });
        });
    </script>
@endpush
