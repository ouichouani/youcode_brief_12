<section class="bg-gradient-to-br from-blue-50 to-indigo-50 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-md mx-auto">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-indigo-700 mb-2">
                    <i class="fas fa-robot mr-2"></i>AI Revenue Generator
                </h1>
                <p class="text-gray-600">Sign in to access your personalized AI-powered financial plan</p>
            </div>

            <div class="bg-white rounded-2xl shadow-xl p-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Welcome Back</h2>

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

                <form action="<?= APP_ROOT ?>/login" method="POST" class="space-y-6">
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2" for="email">
                            <i class="fas fa-envelope mr-2"></i>Email Address
                        </label>
                        <input type="email" id="email" name="email" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                            placeholder="you@example.com">
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label class="block text-gray-700 text-sm font-medium" for="password">
                                <i class="fas fa-lock mr-2"></i>Password
                            </label>
                            <a href="<?= APP_ROOT ?>/forgot-password"
                                class="text-sm text-indigo-600 hover:text-indigo-800">
                                Forgot password?
                            </a>
                        </div>
                        <input type="password" id="password" name="password" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                            placeholder="••••••••">
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" id="remember" name="remember"
                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-700">
                            Remember me for 30 days
                        </label>
                    </div>

                    <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-3 px-4 rounded-lg transition duration-300">
                        <i class="fas fa-sign-in-alt mr-2"></i>Sign In
                    </button>
                </form>
                <div class="my-6 flex items-center">
                    <div class="flex-grow border-t border-gray-300"></div>
                    <span class="mx-4 text-gray-500 text-sm">OR</span>
                    <div class="flex-grow border-t border-gray-300"></div>
                </div>
                <div class="text-center">
                    <p class="text-gray-600">
                        Don't have an account?
                        <a href="<?= APP_ROOT ?>/register" class="text-indigo-600 hover:text-indigo-800 font-medium">
                            <i class="fas fa-user-plus mr-1"></i>Create Account
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>