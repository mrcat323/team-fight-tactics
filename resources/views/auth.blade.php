<p>Привет!</p>
<p>Вы получили это письмо, потому что зарегистрировались на нашем сайте.</p>
<p>Для подтверждения вашего email, перейдите по следующей ссылке:</p>
<a href="{{ route('user.verify', $data['verification_code']) }}">{{ route('user.verify', $data['verification_code']) }}</a>
