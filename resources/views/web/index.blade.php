@extends('layouts.app')
@section('content')
<style>
h2 {
    margin-top: 40px;
}

.special-text {
    text-align: center;
    background-color: yellowgreen;
}
</style>

<h2>商品列表</h2>
<img src="https://s1.imgs.cc/img/aaaabvuoP.jpg?_w=750" alt="">
<table>
    <thead>
        <tr>
            <td>標題</td>
            <td>內容</td>
            <td>價格</td>
            <td></td>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
            <tr>
                @if($product->id == 1)
                    <td class="special-text">{{ $product->title }}</td>
                @else
                    <td>{{ $product->title }}</td>
                @endif

                <td>{{ $product->content }}</td>
                <td style="{{ $product->price < 30000 ? 'color:red; font-size:22px' : '' }}">{{ $product->price }}</td>
                <td>
                    <input class="check_product" type="button" value="確認商品數量" data-id="{{ $product->id }}">
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<script>
    $('.check_product').on('click', function() {
        $.ajax({
            method: 'POST',
            url: '/products/check-product',
            data: {
                id: $(this).data('id')
            }
        })
        .done(function(response) {
            if(response) {
                alert('商品數量充足');
            }
            else {
                alert('商品數量不夠');
            }
        });
    });
</script>
@endsection
