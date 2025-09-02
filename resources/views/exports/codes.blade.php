<table>
    <thead>
        <tr>
            <th>Product</th>
            <th>Code Data</th>
            <th>Web Link</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($codes as $code)
        <tr>
            <td>{{ $code->getProduct->name??'-' }}</td>
            <td>{{ $code->code_data }}</td>
            <td>{{ $code->url }}</td>
            <td>{{ $code->status=='1'?'Active':'Inactive' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>