<p>Привет!</p>
<p>У нас появился новый Продукт</p>
<a href="{{ route('product.show', $data['product']['id']) }}">{{ route('product.show',$data['product']['id']) }}</a>
<h2>{{$data['product']['name']}}</h2>
<h3>{{$data['product']['description']}}</h3>
<h4>{{$data['product']['price']}}</h4>
<p>Для отказа от рассылки на ваш email, перейдите по следующей ссылке:</p>
<a href="{{ route('subscriber.unverify', $data['verification_code']) }}">{{ route('subscriber.unverify', $data['verification_code']) }}</a>
