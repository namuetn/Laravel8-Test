
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    
    <button type="button" id="btn-check">Click</button>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script>
        $('#btn-check').click(function() {
            $.ajax({
                url: "https://kenh14.vn/",
                type: 'GET',
                dataType: 'json',
                // data: {
                //     'API_TOKEN': 'api_token' // Một chuỗi mã hóa bất kì mà bạn tạo ra
                // },
                // xhrFields: {
                //     withCredentials: true
                // },
            }).done(function(response) {
                console.log(1);
            }).fail(function(err) {
                console.log(2);
            });
        });
    </script>

    
</body>
</html>