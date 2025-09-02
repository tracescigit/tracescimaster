<table>
    <thead>
        <tr>
            <th>Product</th>
            <th>Code Data</th>
            <th>QR Link</th>
            <th>Coupon Code</th>
        </tr>
    </thead>
    <tbody>
        @foreach($coupon_codes as $coupon_code)
        <tr>
            <td>{{ $coupon_code->getCode->getProduct->name??'-' }}</td>
            <td>{{ $coupon_code->getCode->code_data }}</td>
            <td>{{ $coupon_code->getCode->url }}</td>
            <td>{{ $coupon_code->coupon_code }}</td>
        </tr>
        @endforeach
    </tbody>
</table>