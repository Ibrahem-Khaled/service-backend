<x-guest-layout>
    <div class="min-h-screen flex flex-col justify-center items-center">
        <div class="w-full sm:max-w-md px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <div>
                <h2 class="text-center text-2xl font-bold">Register</h2>
            </div>

            <form method="POST" action="{{ route('register') }}" class="mt-4">
                @csrf

                <!-- Username -->
                <div>
                    <label for="username" class="block font-medium text-sm text-gray-700">Username</label>
                    <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus
                        class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                </div>

                <!-- Phone Number -->
                <div class="mt-4">
                    <label for="phone" class="block font-medium text-sm text-gray-700">Phone Number</label>
                    <input id="phone" type="text" name="phone" value="{{ old('phone') }}" required
                        class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <label for="password" class="block font-medium text-sm text-gray-700">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                        class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <label for="password_confirmation" class="block font-medium text-sm text-gray-700">Confirm
                        Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        autocomplete="new-password"
                        class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                </div>

                <div class="mt-4">
                    <button type="submit"
                        class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:bg-indigo-700">
                        Register
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
