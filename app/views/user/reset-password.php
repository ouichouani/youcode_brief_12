<section class="bg-gradient-to-br from-blue-50 to-indigo-50 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-md mx-auto">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-indigo-700 mb-2">
                    <i class="fas fa-robot mr-2"></i>AI Revenue Generator
                </h1>
                <p class="text-gray-600">Set your new password</p>
            </div>

            <div class="bg-white rounded-2xl shadow-xl p-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Set New Password</h2>

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

                <form action="<?= APP_ROOT ?>/reset-password" method="POST" class="space-y-6">
                    <input type="hidden" name="token" value="<?php echo htmlspecialchars($token ?? ''); ?>">
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2" for="password">
                            <i class="fas fa-lock mr-2"></i>New Password
                        </label>
                        <input type="password" id="password" name="password" required 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" 
                               placeholder="••••••••">
                        <div class="mt-2 text-xs text-gray-500">
                            Must contain: 8+ characters, uppercase, lowercase, number
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2" for="confirm_password">
                            <i class="fas fa-lock mr-2"></i>Confirm New Password
                        </label>
                        <input type="password" id="confirm_password" name="confirm_password" required 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" 
                               placeholder="••••••••">
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-3 px-4 rounded-lg transition duration-300">
                        <i class="fas fa-save mr-2"></i>Reset Password
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <a href="<?= APP_ROOT ?>/login" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-medium">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to Login
                    </a>
                </div>
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