<x-app-layout>
<h1>Your Cart</h1>

<table>
    <thead>
        <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Total</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
            <tr>
                <td>{{ $product->title }}</td>
                <td>{{ $cartItems->firstWhere('product_id', $product->id)->quantity }}</td>
                <td>${{ $product->new_price }}</td>
                <td>${{ $product->new_price * $cartItems->firstWhere('product_id', $product->id)->quantity }}</td>
                <td>
                    <form action="{{ route('cart.update', $product->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="number" name="quantity" value="{{ $cartItems->firstWhere('product_id', $product->id)->quantity }}">
                        <button type="submit">Update</button>
                    </form>
                    <form action="{{ route('cart.remove', $product->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Remove</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<!-- Scroll to Top End -->
</x-app-layout>
