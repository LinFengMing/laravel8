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

<div class="row">
    <div class="col-4">
        <h2>商品列表</h2>
    </div>
    <div class="col-8">
        <img src="https://s.yimg.com/ny/api/res/1.2/8LV4q6rQWwueodC3k5qymQ--/YXBwaWQ9aGlnaGxhbmRlcjt3PTk2MDtoPTU0MC4zMDc2OTIzMDc2OTIzO2NmPXdlYnA-/https://s.yimg.com/uu/api/res/1.2/S2xvI02GB5KYehk92vJrbQ--~B/aD00Mzk7dz03ODA7YXBwaWQ9eXRhY2h5b24-/https://media.zenfs.com/ko/setn.com.tw/4bcb3715f69dce4fdc17d758c942ab9a" alt="">
    </div>
</div>

<table class="table">
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
                <td style="{{ $product->price < 30000 ? 'color:red; font-size:22px' : '' }}"><i class="fab fa-apple" style="font-size: 24px; color:orange;"></i>{{ $product->price }}</td>
                <td>
                    <input class="check_product btn btn-success" type="button" value="確認商品數量" data-id="{{ $product->id }}">
                    <input class="check_shared_url btn btn-warning" type="button" value="分享商品" data-id="{{ $product->id }}">
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

    $('.check_shared_url').on('click', function() {
        var id = $(this).data('id');

        $.ajax({
            method: 'GET',
            url: `/products/shared-url/${id}`,
        })
        .done(function(response) {
            if(response) {
                alert('請分享此縮網址' + response.url);
            }
            else {
                alert('縮網址失敗');
            }
        });
    });
</script>
@endsection
