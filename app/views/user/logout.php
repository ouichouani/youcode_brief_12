<body class="bg-gradient-to-br from-blue-50 to-indigo-50 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full mx-4">
        <div class="bg-white rounded-2xl shadow-xl p-8 text-center">
            <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-sign-out-alt text-indigo-600 text-2xl"></i>
            </div>

            <h2 class="text-2xl font-bold text-gray-800 mb-4">Logging Out</h2>

            <p class="text-gray-600 mb-8">
                You are being securely logged out of your AI Revenue Generator account.
            </p>

            <div class="flex justify-center mb-8">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600"></div>
            </div>

            <div class="bg-blue-50 border border-blue-100 rounded-lg p-4">
                <p class="text-sm text-blue-700">
                    <i class="fas fa-info-circle mr-2"></i>
                    For security, please close your browser if you're on a shared device.
                </p>
            </div>

            <div class="mt-8">
                <a href="/login" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-medium">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Login
                </a>
            </div>
        </div>
    </div>

    <script>
        setTimeout(function() {
            window.location.href = '/login';
        }, 2000);
    </script>
</body>