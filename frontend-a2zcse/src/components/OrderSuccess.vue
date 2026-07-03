<template>
    <div class="bg-gray-50 flex items-center justify-center min-h-screen">
        <div class="bg-white p-10 rounded-2xl shadow-lg text-center max-w-md">

            <div class="text-5xl mb-4">🎉</div>

            <h1 class="text-2xl font-bold text-gray-800 mb-2">
            Thank You!
            </h1>

            <p class="text-gray-600 mb-6">
            Your order has been successfully placed.<br/>
            We will contact you soon for confirmation.
            </p>

            <router-link :to="'/'"
            class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-xl hover:bg-indigo-700">
            Back to Home
            </router-link>

        </div>
    </div>
</template>