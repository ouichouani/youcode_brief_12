<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - AI Revenue Generator</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head> -->
<section class="bg-gradient-to-br from-blue-50 to-indigo-50 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-md mx-auto">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-indigo-700 mb-2">
                    <i class="fas fa-robot mr-2"></i>AI Revenue Generator
                </h1>
                <p class="text-gray-600">Reset your password to continue your financial journey</p>
            </div>
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Reset Password</h2>

                <?php if (isset($flash['error'])): ?>
                    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <p class="text-red-600 text-sm">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            <?php echo htmlspecialchars($flash['error']); ?>
                        </p>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($flash['success'])): ?>
                    <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                        <p class="text-green-600 text-sm">
                            <i class="fas fa-check-circle mr-2"></i>
                            <?php echo htmlspecialchars($flash['success']); ?>
                        </p>
                    </div>
                <?php endif; ?>

                <?php if (!isset($flash['success'])): ?>
                <form action="/forgot-password" method="POST" class="space-y-6">
                    <div class="bg-blue-50 border border-blue-100 rounded-lg p-4">
                        <p class="text-sm text-blue-700">
                            <i class="fas fa-info-circle mr-2"></i>
                            Enter your email address and we'll send you a link to reset your password.
                        </p>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2" for="email">
                            <i class="fas fa-envelope mr-2"></i>Email Address
                        </label>
                        <input type="email" id="email" name="email" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" placeholder="you@example.com">
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-3 px-4 rounded-lg transition duration-300">
                        <i class="fas fa-paper-plane mr-2"></i>Send Reset Link
                    </button>
                </form>
                <?php endif; ?>

                <div class="my-6 flex items-center">
                    <div class="flex-grow border-t border-gray-300"></div>
                    <span class="mx-4 text-gray-500 text-sm">OR</span>
                    <div class="flex-grow border-t border-gray-300"></div>
                </div>

                <div class="text-center">
                    <a href="/login" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-medium">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to Login
                    </a>
                </div>
            </div>
            <div class="text-center mt-8 text-gray-500 text-sm">
                <p>© 2026 AI Revenue Generator. Secure password recovery system.</p>
            </div>
        </div>
    </div>
</section>
<!-- </html> -->