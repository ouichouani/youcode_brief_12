<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - AI Revenue Generator</title>
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
                <p class="text-gray-600">Create your account to unlock your financial potential</p>
            </div>

            <div class="bg-white rounded-2xl shadow-xl p-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Create Account</h2>

                <?php if (isset($_SESSION['errors'])): ?>
                    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <ul class="text-red-600 text-sm">
                            <?php foreach ($_SESSION['errors'] as $error): ?>
                                <li class="flex items-center">
                                    <i class="fas fa-exclamation-circle mr-2"></i>
                                    <?php echo htmlspecialchars($error); ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <?php unset($_SESSION['errors']); ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['success'])): ?>
                    <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                        <p class="text-green-600 text-sm">
                            <i class="fas fa-check-circle mr-2"></i>
                            <?php echo htmlspecialchars($_SESSION['success']); ?>
                        </p>
                        <?php unset($_SESSION['success']); ?>
                    </div>
                <?php endif; ?>

                <form action="register" method="POST" class="space-y-6">
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2" for="fullname">
                            <i class="fas fa-user mr-2"></i>Full Name
                        </label>
                        <input type="text" id="fullname" name="fullname" value="<?php echo htmlspecialchars($_SESSION['old']['fullname'] ?? ''); ?>" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" placeholder="John Doe">
                        <?php unset($_SESSION['old']['fullname']); ?>
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2" for="email">
                            <i class="fas fa-envelope mr-2"></i>Email Address
                        </label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_SESSION['old']['email'] ?? ''); ?>" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" placeholder="you@example.com">
                        <?php unset($_SESSION['old']['email']); ?>
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2" for="password">
                            <i class="fas fa-lock mr-2"></i>Password
                        </label>
                        <input type="password" id="password" name="password" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" placeholder="••••••••">
                        <div class="mt-2 text-xs text-gray-500">
                            Must contain: 8+ characters, uppercase, lowercase, number
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2" for="confirm_password">
                            <i class="fas fa-lock mr-2"></i>Confirm Password
                        </label>
                        <input type="password" id="confirm_password" name="confirm_password" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" placeholder="••••••••">
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-3 px-4 rounded-lg transition duration-300">
                        <i class="fas fa-user-plus mr-2"></i>Create Account
                    </button>
                </form>

                <div class="my-6 flex items-center">
                    <div class="flex-grow border-t border-gray-300"></div>
                    <span class="mx-4 text-gray-500 text-sm">OR</span>
                    <div class="flex-grow border-t border-gray-300"></div>
                </div>

                <div class="text-center">
                    <p class="text-gray-600">
                        Already have an account?
                        <a href="/login" class="text-indigo-600 hover:text-indigo-800 font-medium">
                            <i class="fas fa-sign-in-alt mr-1"></i>Sign In
                        </a>
                    </p>
                </div>
            </div>

            <div class="text-center mt-8 text-gray-500 text-sm">
                <p>© 2026 AI Revenue Generator. Unlock your financial potential with AI.</p>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('password').addEventListener('input', function(e) {
            const password = e.target.value;
            const strength = document.getElementById('password-strength');
            
            if (!strength) {
                const div = document.createElement('div');
                div.id = 'password-strength';
                div.className = 'mt-2 text-xs';
                e.target.parentNode.appendChild(div);
            }
            
            let strengthText = '';
            let strengthClass = '';
            
            if (password.length === 0) {
                strengthText = '';
            } else if (password.length < 8) {
                strengthText = 'Weak';
                strengthClass = 'text-red-500';
            } else if (!/[A-Z]/.test(password) || !/[a-z]/.test(password) || !/[0-9]/.test(password)) {
                strengthText = 'Medium';
                strengthClass = 'text-yellow-500';
            } else {
                strengthText = 'Strong';
                strengthClass = 'text-green-500';
            }
            
            document.getElementById('password-strength').innerHTML = 
                strengthText ? `Strength: <span class="font-medium ${strengthClass}">${strengthText}</span>` : '';
        });
    </script>
</section>
<!-- </html> -->