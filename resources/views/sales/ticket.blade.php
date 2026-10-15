<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Ticket #{{ str_pad($sale->id, 6, '0', STR_PAD_LEFT) }}
    </title>

    @vite(['resources/css/app.css'])

    <style>
        @page {
            size: 80mm auto;
            margin: 0;
        }

        body {
            margin: 0;
            padding: 0;
            background: white;
        }

        .ticket {
            width: 72mm;
            margin: 0 auto;
            padding: 4mm 0;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            line-height: 1.35;
            color: #000;
        }

        .ticket-header {
            text-align: center;
        }

        .ticket-title {
            font-size: 18px;
            font-weight: bold;
        }

        .ticket-subtitle {
            margin-top: 2px;
            font-size: 11px;
        }

        .ticket-divider {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }

        .ticket-row {
            display: flex;
            justify-content: space-between;
            gap: 8px;
        }

        .ticket-products {
            width: 100%;
            border-collapse: collapse;
        }

        .ticket-products th {
            font-size: 10px;
            font-weight: bold;
            padding-bottom: 5px;
        }

        .ticket-products td {
            padding: 3px 0;
            vertical-align: top;
        }

        .product-name {
            width: 48%;
            word-break: break-word;
        }

        .product-quantity {
            width: 12%;
            text-align: center;
        }

        .product-price {
            width: 20%;
            text-align: right;
        }

        .product-subtotal {
            width: 20%;
            text-align: right;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            font-weight: bold;
            margin-top: 5px;
        }

        .grand-total {
            font-size: 18px;
            font-weight: bold;
        }

        .ticket-footer {
            margin-top: 14px;
            text-align: center;
            font-size: 11px;
        }

        @media print {
            body {
                width: 80mm;
            }

            .ticket {
                width: 72mm;
            }
        }
    </style>
</head>

<body>

    <div class="ticket">

        {{-- Encabezado --}}
        <div class="ticket-header">

            <div class="ticket-title">
                PUNTO DE VENTA
            </div>

            <div class="ticket-subtitle">
                Ticket de venta
            </div>

            <div class="ticket-divider"></div>

            <div>
                Venta #{{ str_pad($sale->id, 6, '0', STR_PAD_LEFT) }}
            </div>

            <div>
                {{ $sale->created_at->timezone('America/Mexico_City')->format('d/m/Y H:i') }}
            </div>

        </div>


        {{-- Información --}}
        <div class="ticket-divider"></div>

        <div class="ticket-row">
            <span>Vendedor:</span>

            <span>
                {{ $sale->user?->name ?? 'Sin usuario' }}
            </span>
        </div>


        {{-- Productos --}}
        <div class="ticket-divider"></div>

        <table class="ticket-products">

            <thead>
                <tr>
                    <th class="product-name">
                        Producto
                    </th>

                    <th class="product-quantity">
                        Cant.
                    </th>

                    <th class="product-price">
                        Precio
                    </th>

                    <th class="product-subtotal">
                        Total
                    </th>
                </tr>
            </thead>

            <tbody>

                @foreach ($sale->items as $item)
                    <tr>

                        <td class="product-name">
                            {{ $item->product?->name ?? 'Producto eliminado' }}
                        </td>

                        <td class="product-quantity">
                            {{ $item->quantity }}
                        </td>

                        <td class="product-price">
                            ${{ number_format($item->price, 2) }}
                        </td>

                        <td class="product-subtotal">
                            ${{ number_format($item->subtotal, 2) }}
                        </td>

                    </tr>
                @endforeach

            </tbody>

        </table>


        {{-- Totales --}}
        <div class="ticket-divider"></div>

        <div class="ticket-row">
            <span>Subtotal</span>

            <span>
                ${{ number_format($sale->total, 2) }}
            </span>
        </div>

        <div class="total-row grand-total">
            <span>TOTAL</span>

            <span>
                ${{ number_format($sale->total, 2) }}
            </span>
        </div>


        {{-- Pago --}}
        <div class="ticket-divider"></div>

        @php
            $paymentMethod = $sale->payment_method->label();
        @endphp

        <div class="ticket-row">
            <span>Método:</span>

            <span>
                {{ $paymentMethod }}
            </span>
        </div>

        <div class="ticket-row">
            <span>Recibido:</span>

            <span>
                ${{ number_format($sale->paid_amount, 2) }}
            </span>
        </div>

        <div class="ticket-row">
            <span>Cambio:</span>

            <span>
                ${{ number_format($sale->change, 2) }}
            </span>
        </div>


        {{-- Estado --}}
        @if ($sale->status === 'cancelled')
            <div class="ticket-divider"></div>

            <div style="text-align: center; font-weight: bold;">
                VENTA CANCELADA
            </div>
        @endif


        {{-- Pie --}}
        <div class="ticket-divider"></div>

        <div class="ticket-footer">

            <div>
                Gracias por su compra
            </div>

            <div style="margin-top: 3px;">
                Conserve este ticket como comprobante.
            </div>

        </div>

    </div>


    <script>
        window.addEventListener('load', function() {
            window.print();
        });
    </script>

</body>

</html>
