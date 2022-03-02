<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>メッセージ</title>
</head>
<body>
    <div>
        <h3>{{ $partner }}さんとのチャット</h3>
        @if(! empty($messages))
         @if(! empty($messages->chat_text))
           @foreach ($messages as $message)
              <p>{{ $message->chat_personal }}</p>
              <p>{{ $message->chat_text }}</p>
           @endforeach
         @endif
         <message-component></message-component>
              <form action="{{ route('message.register') }}" method="post">
                @csrf
                <input type="text" v-model="newMessage" @blur="addMessage" name="chat_text" size="300">
                <input type="hidden" name="chat_personal" value= "{{ $personal }}">
                <input type="submit" value="送信">
              </form>

        @else
        <p>チャット相手がいません</p>
        @endif
        <a href="{{ route('home') }}">ホームへ</a>
    </div>
</body>
<script src="/js/app.js"></script>
</html>
