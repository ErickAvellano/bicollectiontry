<div id="purchaseContent" class="mt-3">
    @if ($purchases->isEmpty())
        <p>No {{ ucfirst($status) }} purchases found.</p>
    @else
        <div class="list-group">
            @foreach ($purchases as $purchase)
                <div class="list-group-item order-card d-flex flex-column p-4 mb-4 border rounded shadow-sm" data-order-id="{{ $purchase->order_id }}">
                    <!-- Product Image and Details -->
                    <div class="d-flex align-items-start">
                        <!-- Product Image -->
                        <div class="me-4">
                            @php
                                $orderItem = $purchase->orderItems->first();
                                $product = $orderItem ? $orderItem->product : null;
                                $image = $product ? $product->images->first() : null;
                                $imagePath = $image ? $image->product_img_path1 : 'https://via.placeholder.com/60';
                            @endphp
                            <img src="{{ asset('storage/' . $imagePath) }}" alt="Product Image" class="img-fluid border" loading="lazy"
                                style="width: 120px; height: 120px; object-fit: cover;">
                        </div>

                        <!-- Purchase Details -->
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p><strong>Order ID:</strong> {{ $purchase->order_id }}</p>
                                    <p><strong>Product Name:</strong> {{ $orderItem->product->product_name ?? 'N/A' }}</p>
                                    <p><strong>Mode of Payment:</strong> {{ $purchase->payment->payment_method ?? 'N/A' }}</p>
                                    <p><strong>Shipping Address:</strong> {{ $purchase->shipping_address ?? 'N/A' }}</p>
                                </div>
                                <div class="text-end">
                                    <p><strong>Status:</strong>
                                        <span class="badge
                                            @if($purchase->order_status === 'cancelled') bg-danger
                                            @elseif($purchase->order_status === 'declined') bg-warning
                                            @elseif($purchase->order_status === 'to-ship') bg-info
                                            @elseif($purchase->order_status === 'to-received') bg-primary
                                            @elseif($purchase->order_status === 'completed') bg-success
                                            @elseif($purchase->order_status === 'pending') bg-secondary
                                            @else bg-dark
                                            @endif">
                                            {{ ucfirst($purchase->order_status) }}
                                        </span>
                                    </p>
                                    <p><strong>Qty:</strong> {{ $purchase->orderItems->sum('quantity') }}</p>
                                    <p><strong>Total:</strong> ₱{{ number_format($purchase->total_amount, 2) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-end mt-3">
                        @if ($purchase->payment && $purchase->payment->payment_status === 'To-pay')
                            <a href="{{ route('payment.show', ['order_id' => $purchase->order_id]) }}" class="btn btn-primary me-2">Pay Now</a>
                            <button type="button" class="btn btn-danger me-2" onclick="openCancelConfirmationModal({{ $purchase->order_id }})">
                                Cancel Order
                            </button>
                        @elseif ($purchase->order_status === 'to-ship')
                            <a href="{{ route('order.track', ['order' => $purchase->order_id]) }}" class="btn btn-secondary me-2">Track Order</a>
                            @elseif ($purchase->order_status === 'to-received' || $purchase->order_status === 'ready')
                            <a href="#" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#confirmReceivedModal" data-order-id="{{ $purchase->order_id }}" data-product-id="{{ $orderItem->product->product_id }}">
                                Item Received
                            </a>
                        @elseif ($purchase->order_status === 'to-rate')
                            <a href="#" id="rateProductButton" class="btn btn-outline-custom me-2" data-order-id="{{ $purchase->order_id }}" data-product-id="{{ $orderItem->product->product_id }}" onclick="openReviewModal(event)">Rate Product</a>
                        @elseif ($purchase->order_status === 'cancel')
                            <span class="btn btn-danger me-2 disabled">Order Cancelled</span>
                        @elseif ($purchase->order_status === 'pending')
                            <a class="btn btn-view me-2">View</a>
                            <a class="btn btn-danger me-2" data-order-id="{{ $purchase->order_id }}" data-payment-id="{{ $purchase->payment->payment_id }}" data-payment-method="{{ $purchase->payment->payment_method ?? '' }}" onclick="openCancelModal(event)">Request Cancel</a>
                        @else

                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
