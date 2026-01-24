<div class="max-w-xl mx-auto mt-6 bg-white p-6 rounded-2xl shadow">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Create a Post</h2>

    <form method="POST" action="/posts/create">
        <textarea
            name="title"
            rows="4"
            placeholder="title"
            class="w-full p-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none" required></textarea>

        <textarea
            name="type"
            rows="4"
            placeholder="type"
            class="w-full p-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none" required></textarea>

        <textarea
            name="content"
            rows="4"
            placeholder="Write something to interact with the community..."
            class="w-full p-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none" required></textarea>


        <div class="flex justify-end mt-4">
            <button
                type="submit"
                class="bg-blue-600 text-white px-6 py-2 rounded-xl hover:bg-blue-700 transition">
                Publish
            </button>
        </div>
    </form>
</div>
