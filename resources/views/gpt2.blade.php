<!DOCTYPE html>
<html>

<head>
    <title>GPT-2 Integration</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>

<body>
    <div id="chat-container">
        <div id="chat-output"></div>
        <div id="user-input">
            <input type="text" id="input-text" placeholder="أدخل نصًا">
            <button id="submit-button">إرسال</button>
        </div>
    </div>

    <script>
        try {
            document.addEventListener('DOMContentLoaded', function() {
                const chatOutput = document.getElementById('chat-output');
                const inputText = document.getElementById('input-text');
                const submitButton = document.getElementById('submit-button');

                submitButton.addEventListener('click', function() {
                    const userInput = inputText.value;

                    // إرسال النص إلى الخادم باستخدام Ajax
                    $.ajax({
                        url: '/gpt2/generate', // تعديل المسار وفقًا لهيكل مشروعك
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}', // قد تحتاج إلى تضمين توكن CSRF
                            input_text: userInput
                        },
                        success: function(response) {
                            const generatedText = response.generated_text;
                            chatOutput.innerHTML +=
                                `<div><strong>البوت:</strong> ${generatedText}</div>`;
                            inputText.value = ''; // مسح مربع الإدخال
                        },
                        error: function(error) {
                            // معالجة الأخطاء هنا إذا لزم الأمر
                        }
                    });
                });
            });
        } catch (error) {
            console.error("An error occurred:", error);
        }
    </script>
</body>

</html>
